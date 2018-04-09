<?php
/**
 * @package		Borua
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Feb 10, 2011
 * @version     $Id: NodeUtil.php 1 Feb 10, 2011 10:13:14 AM Anhxtanh3087 $
 */
class Class_SmsSender {

	public function __construct() {
		
	}

	/**
	 * 
	 * @param type $toPhoneNumber
	 * @param type $message
	 * @param type $provider 1=eSMS; 2=twilio; 3=vpmedia
	 */
	public function send($fromNumber, $toNumber, $message) {
		$resCode = $this->_sendViaVHT($fromNumber, $toNumber, $message);

		error_log('send SMS:'
				. ' fromNumber=[' . $fromNumber . '],'
				. ' toNumber=[' . $toNumber . '],'
				. ' message=[' . $message . '],'
				. ' res code=[' . $resCode . '],'
		);

		return $resCode;
	}
	
	/**
	 * 
	 * @param type $fromNumber
	 * @param type $toNumber
	 * @param type $message
	 * @return type 
	 * -1000: ket qua tra ve rong (NULL); 
	 * -2000: co loi xay ra; 
	 * >=0 cac ma loi khac cua VHT: 
	 * 0=thanh cong; 
	 * 3=so dien thoai cua thue bao khong con hoat dong; 
	 * 4=tu choi boi sdt; 
	 * 8=loi mang; 
	 * 304=tin nhan bi trung lap; 
	 * 509=noi dung bi sai template
	 */
	private function _sendViaVHT($fromNumber, $toNumber, $message) {
		global $config;
		$client = new SoapClient("http://sms2.vht.com.vn/SendMTAuth/SendMT2.asmx?WSDL", array('trace' => 1));

		try {
			$account_name = $config['sms_vht_api_key'];
			$account_password = $config['sms_vht_api_secret'];

			//SendSMS
			$params = [
				'account_name' => $account_name,
				'account_password' => $account_password,
				'User_ID' => $toNumber,
				'Content' => $message,
				'Service_ID' => $fromNumber,
				'Command_Code' => 'GO', //Mã của dịch vụ, Ví dụ : GO, SC …
				'Request_ID' => '0', // Trongtrường hợp bản tin phát sinh từ đốitác (không có MO) thì request_id đượcđặt = 0
				'Message_Type' => '0', //0: SMS phát sinh từ dịch vụ, không tính tiền; 1: Có trừ tiền của khách hàng
				'Total_Message' => '1', //Tổng cộng MT phản hồi cho MO này
				'Message_Index' => '1', //Số thứ tự của MT cho một MO (bắt đầutừ 1)
				'IsMore' => '0', //0: MT cuối cùng; 1 là còn MT tiếp theo
				'Content_Type' => '0', //0:Text; 1: ringtone; 2: logo; 4: picture message
			];
			$result = $client->SendSMS($params);

			if ($result) {
				return $result->SendSMSResult;
			}

			return -1000;
		} catch (SoapFault $fault) {
			error_log('error: ' . $fault->getMessage());
			return -2000;
		}
	}

	private function _sendViaVHT_alphasms($fromNumber, $toNumber, $sms_template_code, $param1) {
		global $config;
		$ch = curl_init();

		$sms = array(
			'brandname' => $fromNumber,
			'text' => array(
				'sms_template_code' => $sms_template_code,
				'param1' => $param1
			),
			'to' => $toNumber
		);

		$data = array(
			'submission' => array(
				'api_key' => $config['sms_vht_api_key'],
				'api_secret' => $config['sms_vht_api_secret'],
				'sms' => array(
					0 => $sms
				)
			)
		);

		$data_string = json_encode($data);

		error_log('request data_string: ' . $data_string);

		$ch = curl_init('https://sms.vht.com.vn/ccsms/json');

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string)
		));

		$result = curl_exec($ch);

		error_log('response data_string: ' . $result);

		/*
		  {
		  "submission": {
		  "sms": [{
		  "id": "5a34ece1-f0b4-4e04-9ad5-6c2dac1010bd",
		  "status": 0,
		  "error_message": ""
		  }]
		  }
		  }
		 */

		curl_close($ch);

		if (!$result) {
			return -1000; //HTTP res NULL
		}

		$resJson = json_decode($result);
		if (!$resJson) {
			return -1001; //decode JSON loi; co the do $sms_template_code sai
		}

		$resSmses = $resJson->submission->sms;
		if (!$resSmses || count($resSmses) == 0) {
			return -1002; //JSON res khong dung dinh dang
		}

		$resSms = $resSmses[0];

		if (!isset($resSms->status)) {
			return -1003; //khong co truong status trong response
		}

		return $resSms->status;
	}

	

	public function saveLogToDb($phoneNumber, $message, $result, $errorMessage, $proviverSmsId, $proviver) {
		$table = new Db_TableAbstract('sms_out');

		$row = array();
		$row['phoneNumber'] = $phoneNumber;
		$row['content'] = $message;
		$row['result'] = (int) $result;
		$row['errorMessage'] = $errorMessage;
		$row['proviverSmsId'] = $proviverSmsId;
		$row['proviver'] = $proviver;

		$row['created'] = date('Y-m-d H:i:s');

		$table->insert($row);
	}

}
