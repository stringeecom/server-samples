<?php

include_once './StringeeApi/StringeeCurlClient.php';

$keySid = 'YOUR_API_KEY_SID';
$keySecret = 'YOUR_API_KEY_SECRET';

$curlClient = new StringeeCurlClient($keySid, $keySecret);

$url = 'https://api.stringee.com/v1/sms';



/*============================================*/
/*
	'text' is string if you use brandname Stringee or your brandname
	'text' is array if you use brandname Notify-GSMS-VSMS:
		array(
		  'template' => 5689, //template code
		  'params' => ['123456789'] //list params
		)
*/

$smses[] = array(
	'from' => 'YOUR_BRANDNAME', 
	'to' => 'CLIENT_NUMBER',
	'text' => 'CONTENT_SMS',	
);

$data = array(
	'sms' => $smses,
);
/*============================================*/

$postData = json_encode($data);
$res = $curlClient->post($url, $postData, 15);

$statusCode = $res->getStatusCode();

echo 'statusCode: ' . $statusCode;

echo '<br><br><br>';

$content = $res->getContent();

echo 'content: ' . $content;

