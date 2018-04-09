<?php

/**
 * @package		Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Feb 14, 2011
 * @version     $Id: Loader.php 1 Feb 14, 2011 2:43:36 PM Anhxtanh3087 $
 */
class Loader {

	/**
	 * e.g., "Example_Class" --> "Example/Class.php"
	 *
	 * @param string $class      - The full class name
	 * @return void
	 */
	public static function loadClass($class) {
		if (class_exists($class, false) || interface_exists($class, false)) {
			return;
		}

		$file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
		include_once $file;

		if (!class_exists($class, false) && !interface_exists($class, false)) {
			die("File $file does not exist or class $class was not found in the file");
		}
	}

	/**
	 *
	 * @param string $class
	 * @return string|false Class name on success; false on failure
	 */
	public static function autoload($class) {
		$a = explode('_', $class);

		if ($a [0] == 'Model') {
			include_once ROOT_PATH . 'application/model/' . $a [1] . '.php';
		} elseif ($a [0] == 'Form') {
			include_once ROOT_PATH . 'application/form/' . $a [1] . '.php';
		} elseif ($a [0] == 'Class') {
			include_once ROOT_PATH . 'application/class/' . $a [1] . '.php';
		} elseif ($a [0] == 'Module') {
			include_once ROOT_PATH . 'application/module/' . $a [1] . '.php';
		}

		try {
			self::loadClass($class);
		} catch (Exception $e) {
			exit("Class $class not found!");
		}
	}

	/**
	 * Register {@link autoload()} with spl_autoload()
	 *
	 * @param string $class (optional)
	 * @param boolean $enabled (optional)
	 * @return void
	 */
	public static function registerAutoload($class = 'Loader', $enabled = true) {
		self::loadClass($class);

		if ($enabled === true) {
			spl_autoload_register(array($class, 'autoload'));
		} else {
			spl_autoload_unregister(array($class, 'autoload'));
		}
	}

}
