<?php

include_once './StringeeApi/StringeeCurlClient.php';

$keySid = '';
$keySecret = '';

$curlClient = new StringeeCurlClient($keySid, $keySecret);

$url = 'https://api.stringee.com/v1/sms';

//=======================
$smses[] = array(
	'from' => 'Stringee',
	'text' => 'Xin chao, day la tin nhan gui tu Stringee',
	'to' => '84909982668',
);

$data = array(
	'sms' => $smses,
);
//=======================

$postData = json_encode($data);
$res = $curlClient->post($url, $postData, 15);

$statusCode = $res->getStatusCode();

echo 'statusCode: ' . $statusCode;

echo '<br><br><br>';

$content = $res->getContent();

echo 'content: ' . $content;

