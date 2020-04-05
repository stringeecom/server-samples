<?php

/*
	Stringee Server gets SCCO by sending HTTP GET to this URL when someone calls your Number
		
/answer_url-from_external-test.php
	?from=0909982888
	&to=02473082686
	&uuid=2297a8fa-acad-11e7-a9ba-b596eac7cf7a
	&fromInternal=false

*/

$userId = @$_GET['userId'];

$from = @$_GET['from'];
$to = @$_GET['to'];
$fromInternal = @$_GET['fromInternal'];
$uuid = @$_GET['uuid'];


if($userId){
        $callTo = $userId;
}else{
        $callTo = 'USER_ID';
}

$scco = '[{
			"action": "connect",

			"from": {
				"type": "external",
				"number": "' . $from . '",
				"alias": "' . $from . '"
			},

			"to": {
				"type": "internal",
				"number": "' . $callTo . '",
				"alias": "' . $to . '"
			},

			"customData": "test-custom-data"
		}]';

header('Content-Type: application/json');
echo $scco;


/* 
	$signing_secret_key = 'YOUR_SIGNING_SECRET_KEY';
	$requestUri = $_SERVER['REQUEST_URI'];
	$signature = @$_SERVER['HTTP_X_STRINGEE_SIGNATURE'];

	function computeSignature($data, $signing_secret_key) {
		$hmac = hash_hmac("sha1", $data, $signing_secret_key, true);
		return base64_encode($hmac);
	}

	$requestUri = str_replace (' ', '%20', $requestUri);
	$computedSignature = computeSignature($requestUri, $signing_secret_key);
	if($computedSignature == $signature){
		error_log('Confirmed to have come from Stringee');
	} else {
		error_log('SIGNATURE NOT VALID. It might have been spoofed');
	}
*/

