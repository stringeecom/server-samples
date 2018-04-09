<?php

/**
 * @package     Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Oct 1, 2010
 * @version     $Id: Router.php 1 Oct 1, 2010 10:12:46 PM Anhxtanh3087 $
 */
class Router {

	//Mảng các route
	public static $routes = array();
	private $_controller;
	private $_action;
	private $_params;
	//Thành phần hậu tố của URI, sẽ được loại bỏ trước khi xử lý định tuyến
	private $_suffix = '';
	//Route mặc định: {controller}/{action}/{params}
	private $_defaultRoute = array('uri' => '([^/]+)?/?([^/]+)?/?(.*)', 'route' => array(), 'params' => array(1 => '{controller}', 2 => '{action}', 3 => '{params}'));

	/**
	 * @param $route Có dạng array ('controller' => 'controller_name', 'action' => 'action_name' )
	 * @param $uri Dạng của URI: (dùng biểu thức chính quy)
	 * 			   (\d+): chữ số
	 * 			   (.+): ký tự bất kỳ trừ xuống dòng
	 * @param $params Mảng (vị trí=>tên tham số,vị trí=>tên tham số,...)
	 */
	public function addRoute($uri, array $route, array $params) {
		array_push(self::$routes, array('uri' => $uri, 'route' => $route, 'params' => $params));
	}

	/**
	 * @return Tên Controller
	 */
	public function getController() {
		return ucfirst($this->_controller);
	}

	/**
	 * @return Tên Action
	 */
	public function getAction() {
		return $this->_action;
	}

	/**
	 * @return Mảng các Param (cặp tên=>giá-trị)
	 */
	public function getParams() {
		return $this->_params;
	}

	public function setSuffix($suffix) {
		$this->_suffix = $suffix;
	}

	public function getSuffix() {
		return $this->_suffix;
	}

	/**
	 *
	 * @param $uri URI String
	 * @return bool Phân tích $uri, đưa ra tên Controller,Action,Params
	 * Ưu tiên dạng Biểu thức chính quy trước, sau cùng là default route
	 * Ưu tiên route nào được add trước
	 */
	public function parseUri($uri, $isBackend = FALSE) {
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

		//Bỏ phần hậu tố của URI
		if ($uri) {
			if ($this->_suffix) {
				if (substr($uri, strlen($uri) - strlen($this->_suffix)) == $this->_suffix) {
					$uri = substr($uri, 0, strlen($uri) - strlen($this->_suffix));
				} else {
					$this->_controller = 'error';
					$this->_action = 'index';
					$this->_params ['error'] = 'Phần hậu tố URI không chính xác!';
					return false;
				}
			}
		}

		//Nếu là backend: chỉ dùng Default router
		if ($isBackend) {
			self::$routes = array();
		}

		//Add default router: có độ ưu tiên thấp nhất
		array_push(self::$routes, $this->_defaultRoute);

		//Xem $uri trùng khớp với route nào trong mảng self::$routes (dạng biểu thức chính quy)
		foreach (self::$routes as $route) {
			//Nếu khớp
			if (preg_match('@^' . $route ['uri'] . '$@i', $uri, $matches)) {
				////Neu $route ['route'] ['controller'] da duoc dinh nghia
				if (isset($route ['route'] ['controller'])) {
					$this->_controller = $route ['route'] ['controller'];
				}
				if (isset($route ['route'] ['action'])) {
					$this->_action = $route ['route'] ['action'];
				}

				//Phan tich PARAMS
				foreach ($route ['params'] as $k => $v) {
					$this->_params [$v] = $matches [$k];
				}

				//Neu $route ['route'] ['controller'] khong duoc dinh nghia
				if (!$this->_controller) {
					if (isset($this->_params ['{controller}'])) {
						$this->_controller = $this->_params ['{controller}'];
						unset($this->_params ['{controller}']);

						if (!$this->_controller) {
							$this->_controller = 'index';
						}
					} else {
						continue;
					}
				}

				//Neu $route ['route'] ['action'] khong duoc dinh nghia
				if (!$this->_action) {
					if (isset($this->_params ['{action}'])) {
						$this->_action = $this->_params ['{action}'];
						unset($this->_params ['{action}']);

						if (!$this->_action) {
							$this->_action = 'index';
						}
					} else {
						continue;
					}
				}

				//Neu $this->_params ['{params}'] duoc dinh nghia
				if (isset($this->_params ['{params}'])) {
					$paramsSegment = $this->_params ['{params}'];
					$paramsSegmentArr = explode('/', $paramsSegment);
					$c = count($paramsSegmentArr);
					if ($c > 1) {
						for ($i = 0; $i < $c; $i = $i + 2) {
							if (isset($paramsSegmentArr [$i + 1])) {
								$this->_params [$paramsSegmentArr [$i]] = $paramsSegmentArr [$i + 1];
							}
						}
					}
				}

				return true;
			}
		}
	}

}
