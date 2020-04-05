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
$userId = @$_GET['userId']; //request from this user ID
$projectId = @$_GET['projectId'];
$custom = @$_GET['custom']; //custom_data_from_client via makeCall method

//url decode
$from = urldecode($from);
$to = urldecode($to);
$custom = urldecode($custom);

//test routing
$toInt = (int) $to;
if ($toInt < 60000) {
	//call to client app
	$toType = 'internal';
} else {
	//call-out to a phone number
	$toType = 'external';
}

/**
 * timeout: If the call is unanswered, set the number in seconds before Stringee stops ringing.
 */
/**
 * maxConnectTime: Maximum length of the call in seconds (-1 => unlimited)
 */
/**
  peerToPeerCall:
  + true: The media stream of calls will not go through Stringee's server. The calls will be peer-to-peer calls. If the parameter "peerToPeerCall" is "true", the calls can not be recorded, even when you put action "record" before action "connect".
  + false: The media stream of calls will always go through Stringee'server. If you want the calls to be recorded, the parameter "peerToPeerCall" must be "false" and the action "record" must be placed before action "connect" in the SCCO.
  Caution: With call types other than app-to-app, all calls will always go through Stringee's server. At the time, the "peerToPeerCall" value does not make sense.
 */

//connect action
$connectAction = array(
	'action' => 'connect',
	'from' => array(
		'type' => 'internal',
		'number' => $from,
		'alias' => $from,
	),
	'to' => array(
		'type' => 'internal',
		'number' => $to,
		'alias' => $to,
	),
	'customData' => 'custom-data-from-server-' . $custom,
	'timeout' => 45,
	'maxConnectTime' => -1,
	'peerToPeerCall' => false
);

//record action
//If you want the calls to be recorded, the parameter "peerToPeerCall" must be "false" and the action "record" must be placed before action "connect" in the SCCO.
$recordAction = array(
	'action' => 'record',
	'eventUrl' => '',
	'format' => 'mp3',
);

header('Content-Type: application/json');

$sccos = [$connectAction];
echo json_encode($sccos);



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
