<?php

include_once 'StringeeApi/StringeeCurlClient.php';

class Class_SendSMS {

	public static function sendCodeAndCached($phone){
		global $config;
		// TẠO MÃ CODE ĐỂ CONFIRM
		$code = self::generateCodeAndCached($phone);
		//SEND SMS BY STRINGEE
		$resSend = Class_SendSMS::sendSmsByStringee($phone, $code. ' is your Softphone verification code ' );

		if ($resSend['statusCode'] != 200 || $resSend['content']['result']['r'] != 0) {
			$res = [
				'status' => 305,
				'message' => 'Gửi code sms thất bại'
			];
			_echoJsonAndReturn($res);
		}

		$res = [
			'status' => 200,
			'message' => 'Đăng kí thành công',
			'data' => [
				'phone' => $phone
			]
		];
		_echoJsonAndReturn($res);
	}
	
	
	public static function sendSmsByStringee($to, $text) {
		global $config;
		$keySid = $config['keySid'];
		$keySecret = $config['keySecret'];


		$curlClient = new StringeeCurlClient($keySid, $keySecret);

		$url = 'https://api.stringee.com/v1/sms';

		//=======================
		$smses[] = array(
			'from' => 'Stringee', //$from
			'text' => $text,
			'to' => $to,
		);

		$data = array(
			'sms' => $smses,
		);
		//=======================

		$postData = json_encode($data);
		$res = $curlClient->post($url, $postData, 15);

		
		$statusCode = $res->getStatusCode(); // statusCode: 200
		$content = $res->getContent(); //{"smsSent":1,"result":[{"price":"830","smsType":2,"r":0,"msg":"Success"}]}

		$dataReturn = [
			'statusCode' => $statusCode,
			'content' => $content
		];

		return $dataReturn;
	}
	
	
	// Tạo mã code và lưu vào cached
	private function generateCodeAndCached($phone){
		global $cache;
		$randCode = rand(10000, 99999);
		$cacheId = 'verify_' . $phone;
		$cache->save($randCode, $cacheId, 900); //cache 15 phut
		return $randCode;
	}
	

}
