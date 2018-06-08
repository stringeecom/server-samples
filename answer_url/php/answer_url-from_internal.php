<?php

/*
	Stringee Server gets SCCO by sending HTTP GET to this URL when users make a call from Client App

/answer_url-from_internal-test.php
	?from=02473065979
	&to=0916983188
	&fromInternal=true
	&userId=user1
	&projectId=3
	&custom=custom_data_from_client
*/

$from = @$_GET['from'];
$to = @$_GET['to'];
$fromInternal = @$_GET['fromInternal'];
$userId = @$_GET['userId'];//request from this user ID
$projectId = @$_GET['projectId'];
$custom = @$_GET['custom'];

//url decode
$from = urldecode($from);
$to = urldecode($to);
$custom = urldecode($custom);

//test routing
$toInt = (int) $to;
if($toInt < 60000){
	//call to client app
	$toType = 'internal';
}else{
	//call-out to a phone number
	$toType = 'external';
}

$scco = '[{
			"action": "connect",

			"from": {
				"type": "internal",
				"number": "' . $from . '",
				"alias": "' . $from . '"
			},

			"to": {
				"type": "' . $toType . '",
				"number": "' . $to . '",
				"alias": "' . $to . '"
			},

			"customData": "test-custom-data"
		}]';

header('Content-Type: application/json');

echo $scco;



