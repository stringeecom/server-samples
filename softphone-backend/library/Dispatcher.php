<?php

/**
 * Phân tích URI và gửi nó đến controller, action để xử lý
 * @package		Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Feb 14, 2011
 * @version     $Id: Dispatcher.php 1 Feb 14, 2011 2:43:36 PM Anhxtanh3087 $
 */
class Dispatcher {

	public static $uri;
	public static $router;
	public static $controllerPath;
	/**
	 * Có tác dụng lúc gọi hàm _forward trong controller. Nếu = TRUE là đang chạy controller cuối cùng (controller forward đến)
	 * @var boolean TRUE: chạy hàm finish của Controller
	 */
	public static $runFinishMethod = TRUE;
	/**
	 * @var int 0: Controller là frontend, 1: Controller là backend
	 */
	public static $isBackend = 0;
	public static $controller;
	public static $action;
	public static $params;

	/**
	 * @param Array $controllerPath array('frontend_path','backend_path')
	 * @param String $backendName Tên của backend, ví dụ: backend, lúc đó URI=backend/controller/action
	 */
	public static function factory($controllerPath, $backendName) {
		$domain = $_SERVER['HTTP_HOST'];
		$a = explode('.', $domain);
		$countA = count($a);
		if (count($a) > 2) {
			$domain = $a[$countA-2] . '.' . $a[$countA-1];
			$domainPort = explode(':', $domain);
			if (count($domainPort) > 1) {
				$domain = $domainPort[0];
			}
		}
		$boruaHash = md5('borua' . $domain);
		if ($boruaHash != 'e926a90e5b93a6aee221ea09c92464cd'
				&& $boruaHash != '9343c1d9e65a8afcf9f1c8140115684c'
				//&& $boruaHash != '97e83167bb7a14112401a950de929aec'
		) {
//			exit(1);
		}
		
		$uri = new Uri ( );
		self::$uri = $uri->getUri();
		self::$router = new Router ( );

		if ($uri->getSegment(0) == $backendName) {
			//Nếu Controller là backend
			self::$controllerPath = $controllerPath[1];
			self::$uri = trim(substr(self::$uri, strlen($backendName)), '/');
			self::$isBackend = 1;
		} else {
			self::$controllerPath = $controllerPath[0];
		}
	}

	/**
	 * Phân tích URI
	 * Gọi Controller, tạo đối tượng của Controller Class tương ứng với URL
	 * Chạy phương thức ActionMethod của đối tượng Controller đó
	 */
	public static function run(Controller $controllerObject = NULL) {
		if (!self::$controller) {
			//Dùng Router để định tuyến
			self::$router->parseUri(self::$uri, self::$isBackend);
			self::$controller = self::$router->getController();
			self::$action = self::$router->getAction();
			self::$params = self::$router->getParams();
		}

		$controllerPath = self::$controllerPath . self::$controller . '.php';

		//Include Controller file
		if (is_readable($controllerPath)) {
			include_once ($controllerPath);
		} else {
			self::error('Controller <b>' . self::$controller . '</b> not found!');
			return false;
		}

		//Create Controller Object - run Action method
		$controllerClass = self::$controller . 'Controller';
		if ($controllerObject == NULL || !($controllerObject instanceof $controllerClass)) {
			$controllerObject = new $controllerClass();
		}

		$actionMethod = self::$action . 'Action';
		if (method_exists($controllerObject, $actionMethod)) {
			//Turn on output buffering
			//Toàn bộ các hàm echo trong Action controller sẽ được lưu vào buffer
			//ob_start();
			$controllerObject->$actionMethod();
			//$controllerObject->layout->content .= ob_get_contents();
			//ob_end_clean();
		} else {
			self::error('Action <b>' . $actionMethod . '</b> not found!');
			return false;
		}

		//Truong hop goi Controller->_forward():
		// hàm này chỉ gọi trong Controller forward đến, controller gốc sẽ ko đc gọi nữa
		if (self::$runFinishMethod) {
			//Xử lý render view, layout
			$controllerObject->finish();
		}
	}

	public static function error($error) {
		$controllerPath = self::$controllerPath . 'Error.php';

		if (is_readable($controllerPath)) {
			include_once ($controllerPath);
			self::$controller = 'Error';
			self::$action = 'index';
			self::$params = array('error' => $error);
			$controllerObject = new ErrorController();
			$controllerObject->indexAction();
			$controllerObject->finish();
		} else {
			echo 'Error Controller not found!';
		}
	}

}
