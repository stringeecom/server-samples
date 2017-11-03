<?php

include 'FirebaseJWT/JWT.php';

use \Firebase\JWT\JWT;

/*
HEADER:
	{
	  "typ": "JWT",
	  "alg": "HS256",
	  "cty": "stringee-api;v=1"
	}

PAYLOAD:
	{
	  "jti": "SK9387c378e0092f6deb93f28824f74403-1497503680",//JWT ID
	  "iss": "SK9387c378e0092f6deb93f28824f74403",//API Key SID
	  "exp": 1497507280,//Expiration Time
	  "userId": "huydn-123456"
	}
*/

$apiKeySid = 'SK9387c378e0092f6deb93f28824f74403';
$apiKeySecret = "tXS2Ll52Y2rVZt33JGLw8Wuq0xH8tLYd";

$now = time();
$exp = $now + 3600;

$username = @$_GET['u'];

if(!$username){
	$jwt = '';
}else {
	$header = array('cty' => "stringee-api;v=1");
	$payload = array(
	    "jti" => $apiKeySid . "-" . $now,
	    "iss" => $apiKeySid,
	    "exp" => $exp,
	    "userId" => $username
	);

	$jwt = JWT::encode($payload, $apiKeySecret, 'HS256', null, $header);
}



$res = array(
	'access_token' => $jwt
	);

header('Access-Control-Allow-Origin: *');
echo json_encode($res);





