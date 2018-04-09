<?php

/**
 * Database
 */
$config['db'] = Array(
	'host' => '127.0.0.1',
	'username' => 'root',
	'password' => '',
	'db' => 'softphone-api',
	'port' => 3306,
	'charset' => 'utf8',
	'prefix' => 'dh_',
);

$config['baseUrl'] = '';


$config['firebaseServerKey'] = '';

/**
 * System
 */
$config['template'] = 'default';
$config['mobileTemplate'] = 'default';
$config['language'] = 'en';
$config['enviroment'] = 'development'; // development || production
$config['siteName'] = 'Softphone-apis';
$config['timezone'] = 'Asia/Ho_Chi_Minh';
$config['siteOffline'] = false;

// SMS VHT
$config['sms_vht_api_key'] = ''; /
$config['sms_vht_api_secret'] = ''; 
$config['sms_vht_from_number'] = '';

$config['account_active_no'] = 0;
$config['account_active_yes'] = 1;

$config['callOutNumber'] = ["84901701050","84899189228"];

$config['keySid'] = 'YOUR SID KEY'; 
$config['keySecret'] = 'YOUR SECRET KEY'; 