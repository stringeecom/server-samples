<?php

include_once './StringeeApi/StringeeCurlClient.php';

$keySid = 'SKIOmNlmpWRV4E23OlHuRbFxL6LJ4vrI6N';
$keySecret = 'M29vRmlhZ2JFWHEweldFN2lHek1jWU9QOGlaS1F6QTM=';

$curlClient = new StringeeCurlClient($keySid, $keySecret);

$url = 'https://api.stringee.com/v1/sms';



/*============================================*/
$smses[] = array(
	'from' => 'Stringee', 
	'to' => '84909982668',
	'text' => 'Dau',	
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

