<?php

include_once './StringeeApi/StringeeCurlClient.php';

$keySid = 'YOUR_API_KEY_SID';
$keySecret = 'YOUR_API_KEY_SECRET';

$curlClient = new StringeeCurlClient($keySid, $keySecret);

$url = 'https://api.stringee.com/v1/sms';



/*============================================*/
$smses[] = array(
	'from' => 'YOUR_BRANDNAME', 
	'to' => 'CLIENT_NUMBER',
	'text' => 'CONTENT_SMS',	
);

/*
 * $sms['text'] is string if you use brandname Stringee or your brandname
	"text" => "CONTENT_SMS"
 * 
 * $sms['text'] is array if you use brandname Notify-GSMS-VSMS:
	"text" => [
				"template" => 5689, 
				"params" => ["param1"]
			]
*/


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

