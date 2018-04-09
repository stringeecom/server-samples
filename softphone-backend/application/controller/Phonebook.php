<?php
header('Access-Control-Allow-Origin: *');
class PhonebookController extends Controller {

	public function _init() {
		$this->layout->name = "Index";
	}

	public function indexAction() {
		global $config;
		$this->setNoRender();
		$data = Class_ApiJson::getPostJson();
		if (!$data) {
			$res = [
				'status' => 300,
				'message' => 'Bad request'
			];
			_echoJsonAndReturn($res);
		}

		$token = $data['token'];
		if (!$token) {
			$res = [
				'status' => 301,
				'message' => 'Thiếu tham số'
			];
			_echoJsonAndReturn($res);
		}

		$modelAccount = new Model_Account();
		$checkAccount = $modelAccount->findOne(['token' => $token]);
		if (!$checkAccount) {
			$res = [
				'status' => 302,
				'message' => 'Sai token'
			];
			_echoJsonAndReturn($res);
		}

		if ($checkAccount['is_active'] != $config['account_active_yes']) {
			$res = [
				'status' => 303,
				'message' => 'Số điện thoại chưa xác thực'
			];
			_echoJsonAndReturn($res);
		}
		
		$modelPhonebook = new Model_Phonebook();
		$phonebook = $modelPhonebook->findAll(['phone_owner_id'=> $checkAccount['id']]);
		$res = [
			'status' => 200,
			'message' => 'Lấy danh bạ thành công',
			'data' => [
				'phonebook' => $phonebook
			]
		];
		_echoJsonAndReturn($res);
	}

}
