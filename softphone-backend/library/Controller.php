<?php

/**
 * @package		Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Feb 14, 2011
 * @version     $Id: Controller.php 1 Feb 14, 2011 2:43:36 PM Anhxtanh3087 $
 */
class Controller {

	/**
	 *
	 * @var array array('frontend_layout_path','backend_layout_path')
	 */
	public static $layoutPath;

	/**
	 * Object khai bao layout: name, content, title
	 */
	public $layout;

	/**
	 * View object to render template
	 * @var View Object
	 */
	public $view;

	/**
	 * @var boolean TRUE thì không render template file, không layout
	 */
	private $_noViewRender = FALSE;

	/**
	 * @var boolean TRUE thì không render template file, không layout
	 */
	private $_notSendToBrowser = FALSE;

	/**
	 * @var boolean TRUE thì không render template file, vẫn dùng layout
	 */
	private $_noRenderTemplateFile = FALSE;

	/**
	 * @var String
	 */
	private $_templateFile;
	private $_ajaxRequest = null;

	/**
	 * Du lieu dc day ve client
	 * @var type 
	 */
	protected $_output;

	/**
	 * Hàm tạo, được Dispatcher gọi
	 */
	function __construct() {
		$this->_preInit();

		$this->layout = new stdClass;
		$this->layout->content = '';

		//view
		$this->view = new View();

		$this->_init();
	}

	protected function _preInit() {	
		
	}

	/**
	 * Ham do nguoi dung dinh nghia, se chay truoc khi chay Action, chay cuoi ham __construct
	 */
	protected function _init() {
		
	}

	/**
	 * Chuyen den Controller/Action de xu ly tiep noi dung.
	 * @param <type> $controller Controller name
	 * @param <type> $action Action name
	 * @param array $params Params are tranfered
	 */
	protected function _forward($controller, $action, array $params = null) {
		Dispatcher::$params = $params;
		Dispatcher::$controller = $controller;
		Dispatcher::$action = $action;

		//Re-run
		Dispatcher::run($this);
		Dispatcher::$runFinishMethod = FALSE;
	}

	/**
	 * Ham chay, sau khi chay Action
	 * Nguoi dung ko the rewrite ham nay
	 * Fetch template, layout
	 */
	public final function finish() {
		$this->getOutput();
	}

	/**
	 * Lay du lieu (String) se duoc gui ve client
	 */
	public function getOutput() {
		if (!isset($this->_output)) {
			if (!$this->_noViewRender) {
				ob_start();

				if (!empty($this->layout->name)) {
					//Xử lý Layout
					$layoutPath = self::$layoutPath[Dispatcher::$isBackend] . $this->layout->name . '/';
					include $layoutPath . 'Layout.php';
					Layout::beforeRenderView($this->layout, $layoutPath, $this->view, $this);
				}
				
				//Render template file
				if (!$this->_noRenderTemplateFile) {
					if (!$this->_templateFile) {
						$this->_templateFile = Dispatcher::$controller . '/' . Dispatcher::$action;
					}
					$this->layout->content .= $this->view->render($this->_templateFile . '.html.php');
				}

				if (!empty($this->layout->name)) {
					//Xử lý Layout
					Layout::afterRenderView($this->layout, $layoutPath, $this->view, $this);
					include $layoutPath . 'index.html.php';
				} else {
					echo $this->layout->content;
				}

				$this->_output = ob_get_contents();
				ob_end_clean();
				if (!$this->_notSendToBrowser) {
					echo $this->_output;
				}
			}
		}
		return $this->_output;
	}

	/**
	 * Ham nguoi dung goi de lay Params
	 */
	public function _getParam($paramName) {
		if (isset(Dispatcher::$params [$paramName])) {
			return Dispatcher::$params [$paramName];
		} else {
			return '';
		}
	}

	protected function _redirect($url) {
		header('Location: ' . $url);
		exit();
	}

	/**
	 * Thiết lập không render template file, không dùng layout nếu $noRender = true và ngược lại
	 */
	public function setNoRender($noRender = true) {
		$this->_noViewRender = $noRender;
	}

	/**
	 * Thiết lập không render template file, tuy nhiên vẫn dùng layout
	 */
	public function setNoRenderTemplateFile($noRenderTemplateFile = TRUE) {
		$this->_noRenderTemplateFile = $noRenderTemplateFile;
	}

	public function setNotSendToBrowser($notSend = TRUE) {
		$this->_notSendToBrowser = $notSend;
	}

	/**
	 * @param String $file Có dạng: User/login (khong bao gom phan .html.php)
	 */
	public function setTemplateFile($file) {
		$this->_templateFile = $file;
	}

	/**
	 * Ném ra lỗi và thoát chương trình
	 * @param String $message Nội dung lỗi
	 */
	protected function _throwException($message, $boxy = false) {
		$this->_forward('Error', 'index', array('message' => $message, 'boxy' => $boxy));
		exit();
	}

	/**
	 * TRUE: request is AJAX REQUEST
	 * @return boolean
	 */
	protected function _isAjaxRequest() {
		if (!isset($this->_ajaxRequest)) {
			if ($_GET['__a'] == 1 || $_POST['__a'] == 1) {
				$this->_ajaxRequest = TRUE;
			} else {
				$this->_ajaxRequest = FALSE;
			}
		}

		return $this->_ajaxRequest;
	}

}
