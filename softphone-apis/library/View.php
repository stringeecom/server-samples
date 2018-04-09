<?php

/**
 * @package     Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Oct 1, 2010
 * @version     $Id: View.php 1 Oct 1, 2010 10:12:46 PM Anhxtanh3087 $
 */
class View {

	/**
	 * @var array('frontend_template_path','backend_template_path')
	 */
	public static $path;
	public static $engine;

	public function __construct() {
		
	}

	public function __set($key, $val) {
		$this->$key = $val;
	}

	public function __get($name) {
		return $this->$name;
	}

	/**
	 * @param String $name Tên file muốn render, ví dụ: User/test.html.php
	 * @param String $cacheId
	 * @return String Nội dung
	 */
	public function render($name, $cacheId = null, $cacheLifeTime = null) {
		$data = FALSE;
		global $cache;
		if ($cacheId && $cache) {
			$data = $cache->load(TPL_NAME . '_' . $cacheId);
		}

		if (!$data) {
			ob_start();
			$filePath = self::$path[Dispatcher::$isBackend] . $name;
			if (is_readable($filePath)) {
				include ($filePath);
			} else {
				global $config;
				include (ROOT_PATH . 'template/' . $config['template'] . '/' . $name);
			}
			$data = ob_get_contents();
			ob_end_clean();

			if ($cacheId && $cache) {
				if (!$cacheLifeTime) {
					$cache->save($data, TPL_NAME . '_' . $cacheId);
				} else {
					$cache->save($data, TPL_NAME . '_' . $cacheId, null, $cacheLifeTime);
				}
			}
		}

		return $data;
	}

	/**
	 * @param String $filePath đường dẫn đầy đủ file muốn render
	 * @param String $cacheId
	 * @return String Nội dung
	 */
	public function fetch($filePath, $cacheId = null) {
		ob_start();
		include ($filePath);
		$data = ob_get_contents();
		ob_end_clean();

		return $data;
	}

	public function clearCache($name) {
		return self::$engine->clear_cache($name);
	}

	public function clearAllCache() {
		return self::$engine->clear_all_cache();
	}

	

	

	

	

	


	



}
