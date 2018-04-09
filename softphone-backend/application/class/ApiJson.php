<?php

class Class_ApiJson {

	public function __construct() {
		
	}

	public static function getPostJson() {
		$dataString = file_get_contents('php://input');
		$data = json_decode($dataString, true);
		return $data;
	}
	
	public static function getAccessTokenByUser($phone) {
		global $config;
		include 'FirebaseJWT/JWT.php';
		$JWT = new \Firebase\JWT\JWT;
		
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

		$apiKeySid = $config['keySid'];
		$apiKeySecret = $config['keySecret'];

		$now = time();
		$exp = $now + (3600 * 12);

		$username = $phone;

		$header = array('cty' => "stringee-api;v=1");
		$payload = array(
			"jti" => $apiKeySid . "-" . $now,
			"iss" => $apiKeySid,
			"exp" => $exp,
			"userId" => $username
		);

		$access_token = $JWT->encode($payload, $apiKeySecret, 'HS256', null, $header);
		
		$res = [
			'access_token' => $access_token,
			'expire_time' => $exp
		];
		return $res;
	}

}
