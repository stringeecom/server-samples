<?php

/**
 * @package     Borua
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Oct 1, 2010
 * @version     $Id: Borua.php 1 Oct 1, 2010 10:12:46 PM Anhxtanh3087 $
 */
header('X-Powered-By: Stringee Framework');

define('ROOT_PATH', realpath(dirname(__FILE__)) . '/../');
$include_path = get_include_path();
set_include_path(ROOT_PATH . 'library' . PATH_SEPARATOR . $include_path);
include ROOT_PATH . 'config.php';
if ($config['siteOffline']) {
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	exit('<br /><br /><h1 style="text-align:center">Website tạm ngừng hoạt động để bảo trì!</h1>');
}
if ($config['enviroment'] == 'development') {
	error_reporting(E_ALL ^ E_NOTICE);
} else {
	error_reporting(0);
}
define('BASE_URL', $config['baseUrl']);
define('STATIC_URL', $config['staticUrl']);
define('EMAIL_BASE_URL', $config['emailBaseUrl']);
define('EMMA_URL', $config['emmaUrl']);
define('EMMA_STATIC_URL', $config['emmaStaticUrl']);
define('STICKER_DIR', $config['stickerDir']);
define('STICKER_URL', $config['stickerUrl']);
define('LANG_PATH', ROOT_PATH . 'application/language/' . $config['language'] . '/');
define('SITE_NAME', $config['siteName']);
define('CURRENT_SERVER', $config['currentServer']);
define('IOS_PUSH_PATH', $config['ios_push']['path']);
define('UPLOAD_PATH', $config['upload']['path']);

include_once LANG_PATH . 'common.php';
date_default_timezone_set($config['timezone']);

include 'Loader.php';
Loader::registerAutoload();

//$bm = new Benchmark();
Dispatcher::factory(array(ROOT_PATH . 'application/controller/', ROOT_PATH . 'administrator/controller/'), 'backend');
include ROOT_PATH . 'application/' . 'router.php';

//M-V-C settings
//$db = Zend_Db::factory($config['db']['adapter'], $config['db']);
include_once 'Db/MysqliDb.php';

//$config['db'] = Array(
//	'host' => '127.0.0.1',
//	'username' => 'root',
//	'password' => '',
//	'db' => 'azstack_sdk',
//	'port' => 3306,
//	'prefix' => 'dh_',
//	'charset' => 'utf8');
//$db = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['db'], $config['db']['port']);
$db = new MysqliDb($config['db']);

$cache = new Cache_MySQL();
/**
 * Cache_Memcached
 */
//$cache = new Cache_Memcached($config['memcachedIp'], $config['memcachedPort']);

include ROOT_PATH . 'application/common.php';
Dispatcher::run();
//echo $bm->time();
