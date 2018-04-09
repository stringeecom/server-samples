<?php

class AnswerController extends Controller {

	public function fromInternalAction() {
		$this->setNoRender();
		/*
		  URL nay se duoc Stringee Server goi sang Your Server khi user make call tu app (Client SDK)

		  /answer_url-from_internal-test.php
		  ?from=02473065979
		  &to=0916983168
		  &fromInternal=true
		  &userId=huydn
		  &projectId=3
		  &custom=custom_data_from_client
		 */

		$from = @$_GET['from'];
		$to = @$_GET['to'];
		$fromInternal = @$_GET['fromInternal'];
		$userId = @$_GET['userId']; //request den tu user (agent_id) nay
		$projectId = @$_GET['projectId']; //userId thuoc project nay
		$custom = @$_GET['custom'];

		
		/*
		  //test routing
		  $toInt = (int) $to;
		  if($toInt < 60000){
		  //goi noi bo Stringee
		  $toType = 'internal';
		  }else{
		  //goi ra ngoai Stringee
		  $toType = 'external';
		  }
		 */

		$custom = urldecode($custom);
		$arrCustom = json_decode($custom, true);
//var_dump($arrCustom);

		$appToPhone = (bool) $arrCustom['app-to-phone'];

//echo "<br>";
//var_dump($appToPhone);

		if ($appToPhone) {
			$toType = 'external';
		} else {
			$toType = 'internal';
		}
		
		if($toType == 'internal'){
			$modelAccount = new Model_Account();
			$checkAccount = $modelAccount->findOne(['phone' => $to]);
			if(!$checkAccount || $from == $to){
				$to = NULL;
			}
		}


		$sipTrunkId = 0;
		error_log('custom: ' . $custom);
		error_log('toType: ' . $toType);

		$scco = '[{
			"action": "connect",
			"eventUrl": ["https://example.com/events"],

			"from": {
				"type": "internal",
				"number": "' . $from . '",
				"alias": "' . $from . '"
			},

			"to": {
				"type": "' . $toType . '",
				"number": "' . $to . '",
				"alias": "' . $to . '",
				"sipTrunkId": ' . $sipTrunkId . '
			}

		}]';

		header('Content-Type: application/json');

		echo $scco;
	}

}
