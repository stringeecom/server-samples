<?php

/**
 * @package     Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Oct 1, 2010
 * @version     $Id: Uri.php 1 Oct 1, 2010 10:12:46 PM Anhxtanh3087 $
 */
class Uri {

	protected $_uri;
	protected $_requestUri;
	protected $_segments;

	function __construct() {
		$this->_requestUri = $this->_getRequestUri();
		$this->_uri = $this->_getUri();
		$this->_segments = $this->_getSegments();
	}

	/**
	 * 
	 * @return Chuỗi request: bỏ đi index.php, phần path tới index.php, phần query string, bo /
	 */
	private function _getUri() {
		$uriArr = explode('?', $this->_requestUri);
		$uri = $uriArr [0];

		$uri = trim($uri, '/');

		return $uri;
	}

	/**
	 * @return Chuỗi request bao gồm cả phần query string. VD: hihi/dayroai?okichianao=hehe
	 */
	private function _getRequestUri() {
		$scriptName = $_SERVER ['SCRIPT_NAME']; //Ex: /Test/index.php
		$scriptPath = substr($scriptName, 0, strlen($scriptName) - 9); //Ex: /Test/         strlen('index.php')=9

		$requestUri = $_SERVER ['REQUEST_URI']; //Ex: /Test/mot/hai/ba?bon=nam               hoac         /Test/index.php/mot/hai/ba?bon=nam
		$uri = substr($requestUri, strlen($scriptPath)); //Ex:   mot/hai/ba?bon=nam          hoac         index.php/mot/hai/ba?bon=nam
		if (substr($uri, 0, 9) == 'index.php') {
			$uri = substr($uri, 10);
		}

		return urldecode($uri);
	}

	public function getUri() {
		return $this->_uri;
	}

	public function getRequestUri() {
		return $this->_requestUri;
	}

	private function _getSegments() {
		$segments = explode('/', $this->_uri);
		return $segments;
	}

	/**
	 *
	 * @return array Lay cac doan URI, vi du: URI=mot/hai/ba, thi array(0=>'mot',1=>'hai',2=>'ba')
	 */
	public function getSegments() {
		return $this->_segments;
	}

	public function getSegment($segment) {
		$segments = $this->_getSegments();
		return $segments[$segment];
	}

}
