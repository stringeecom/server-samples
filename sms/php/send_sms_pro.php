<?php

include_once './StringeeApi/StringeeCurlClient.php';

$keySid = '';
$keySecret = '';

$curlClient = new StringeeCurlClient($keySid, $keySecret);

$url = 'https://api.stringee.com/v1/sms';

//=======================
$smses[] = array(
	'from' => 'YOUR_BRANDNAME',
	'to' => 'CLIENT_NUMBER',
	'text' => 'CONTENT_SMS',
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

