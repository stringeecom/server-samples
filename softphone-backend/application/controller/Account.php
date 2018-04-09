<?php
header('Access-Control-Allow-Origin: *');
class AccountController extends Controller {

	public function _init() {
		$this->layout->name = "Index";
	}

	public function loginAction() {
		global $cache;
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

		// CHECK CÓ ĐẦY ĐỦ PARAMS KHÔNG
		$phone = trim($data['phone']);

		if (!$phone) {
			$res = [
				'status' => 301,
				'message' => 'Thiếu tham số'
			];
			_echoJsonAndReturn($res);
		}

		$checkIsPhone = Class_Validate::isPhoneNumber($phone);
		if (!$checkIsPhone) {
			$res = [
				'status' => 302,
				'message' => 'Số điện thoại lỗi'
			];
			_echoJsonAndReturn($res);
		}

		// CHECK TÀI KHOẢN CÓ TỒN TẠI KHÔNG
		$modelAccount = new Model_Account();
		$checkAccount = $modelAccount->findOne([
			'phone' => $phone
		]);
		if ($checkAccount && $checkAccount['is_active']) {
			//Tạo code, cached và gửi SMS code
			Class_SendSMS::sendCodeAndCached($phone);
		} else {
			$modelAccount->delete(['phone' => $phone]);
		}

		// TẠO TÀI KHOẢN
		$dataInsertNewAccount = [
			'phone' => $phone,
			'is_active' => $config['account_active_no'],
			'created' => time()
		];
		$checkInsertAccount = $modelAccount->insert($dataInsertNewAccount);
		if (!$checkInsertAccount) {
			$res = [
				'status' => 304,
				'message' => 'Lỗi không ghi được dữ liệu DB Account'
			];
			_echoJsonAndReturn($res);
		}

		Class_SendSMS::sendCodeAndCached($phone);
	}

	public function confirmAction() {
		global $config;
		global $cache;

		$this->setNoRender();
		$data = Class_ApiJson::getPostJson();
		if (!$data) {
			$res = [
				'status' => 300,
				'message' => 'Bad request'
			];
			_echoJsonAndReturn($res);
		}

		// CHECK CÓ ĐẦY ĐỦ PARAMS KHÔNG
		$phone = $data['phone'];
		$code = $data['code'];
		if (!$phone || !$code) {
			$res = [
				'status' => 301,
				'message' => 'Thiếu tham số'
			];
			_echoJsonAndReturn($res);
		}

		$checkIsPhone = Class_Validate::isPhoneNumber($phone);
		if (!$checkIsPhone) {
			$res = [
				'status' => 302,
				'message' => 'Số điện thoại lỗi'
			];
			_echoJsonAndReturn($res);
		}

		// CHECK TÀI KHOẢN CÓ TỒN TẠI KHÔNG
		$modelAccount = new Model_Account();
		$checkAccount = $modelAccount->findOne(['phone' => $phone]);
		if (!$checkAccount) {
			$res = [
				'status' => 302,
				'message' => 'Số điện thoại chưa đăng kí',
				'data' => [
					'code' => $code
				]
			];
			_echoJsonAndReturn($res);
		}

		// CHECK TOKEN CÓ ĐÚNG KHÔNG
		$cacheKey = 'verify_' . $phone;
		$cacheValue = $cache->load($cacheKey);
		if (!$cacheValue) {
			$res = [
				'status' => 302,
				'message' => 'Mã code hết hạn hoặc không tồn tại'
			];
			_echoJsonAndReturn($res);
		}

		if ($cacheValue != $code) {
			$res = [
				'status' => 303,
				'message' => 'Sai mã code'
			];
			_echoJsonAndReturn($res);
		}

		$resGetAccessToken = Class_ApiJson::getAccessTokenByUser($phone);
		if ($checkAccount && $checkAccount['is_active']) {
			$res = [
				'status' => 200,
				'message' => 'Xác thực thành công',
				'data' => [
					'phone' => $phone,
					'token' => $checkAccount['token'],
					'access_token' => $resGetAccessToken['access_token'],
					'expire_time' => $resGetAccessToken['expire_time'],
					'callOutNumber' => $config['callOutNumber']
				]
			];
			_echoJsonAndReturn($res);
		}
		
		
		// ACTIVE TÀI KHOẢN NẾU CHƯA ACTIVE
		$token = autoString(6);
		while ($modelAccount->findOne(['token' => $token])) {
			$token = autoString(6);
		}
		$checkUpdateAccount = $modelAccount->update(
			['phone' => $phone], [
			'token' => $token,
			'is_active' => $config['account_active_yes']
			]
		);

		if (!$checkUpdateAccount) {
			$res = [
				'status' => 304,
				'message' => 'Cập nhật dữ liệu DB Account thất bại'
			];
			_echoJsonAndReturn($res);
		}

		$cache->remove($cacheKey);

		$res = [
			'status' => 200,
			'message' => 'Xác thực thành công',
			'data' => [
				'phone' => $phone,
				'token' => $token,
				'access_token' => $resGetAccessToken['access_token'],
				'expire_time' => $resGetAccessToken['expire_time'],
				'callOutNumber' => $config['callOutNumber']
			]
		];
		_echoJsonAndReturn($res);
	}

	// KIỂM TRA DANH BẠ GỬI LÊN VÀ TRẢ VỀ MẢNG DANH BẠ ĐÃ TỒN TẠI
	public function checkphonebookexistedAction() {
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

		// CHECK CÓ ĐẦY ĐỦ PARAMS KHÔNG
		$token = $data['token'];
		$phonebook = $data['phonebook'];
		if (!$token || !$phonebook) {
			$res = [
				'status' => 301,
				'message' => 'Thiếu tham số'
			];
			_echoJsonAndReturn($res);
		}

		// CHECK THONG TIN SO DIEN THOAI
		$modelAccount = new Model_Account();
		$checkPhone = $modelAccount->findOne(['token' => $token]);
		if (!$checkPhone) {
			$res = [
				'status' => 302,
				'message' => 'Token sai hoặc hết hạn'
			];
			_echoJsonAndReturn($res);
		}

		// CHECK DANH BẠ TRUYỀN VÀO CÓ PHẢI MẢNG KHÔNG
		if (!is_array($phonebook)) {
			$res = [
				'status' => 302,
				'message' => 'Sai kiểu dữ liệu'
			];
			_echoJsonAndReturn($res);
		}

		// TRẢ VỀ MẢNG PHONE NUMBER ĐÃ TỒN TẠI
		$arrPhoneExisted = [];
		$modelPhonebook = new Model_Phonebook();
		
		// VERSION CU
		if($phonebook[0]){
			foreach ($phonebook as $p){
				$checkAccountExist = $modelAccount->findOne(['phone' => $p, 'is_active' => $config['account_active_yes']]);
				if ($checkAccountExist) {
					array_push($arrPhoneExisted, (string)$p);
				}
			}
		}else{
			foreach ($phonebook as $p => $n) {
				$checkAccountExist = $modelAccount->findOne(['phone' => $p, 'is_active' => $config['account_active_yes']]);
				if ($checkAccountExist) {
					array_push($arrPhoneExisted, (string)$p);
				}

				$checkPhonebookExist = $modelPhonebook->findOne(['phone' => $p, 'phone_owner_id' => $checkPhone['id']]);
				if(!$checkPhonebookExist){
					$modelPhonebook->insert(['phone' => $p, 'name' => $n, 'phone_owner' => $checkPhone['phone'], 'phone_owner_id' => $checkPhone['id']]);
				}
			}
		}
		

		$countPhoneExisted = count($arrPhoneExisted);
		$res = [
			'status' => 200,
			'message' => 'Kiểm tra danh bạ thành công',
			'data' => [
				'countPhoneExisted' => $countPhoneExisted,
				'phonesExisted' => $arrPhoneExisted
			]
		];
		_echoJsonAndReturn($res);
	}

	public function getaccesstokenAction() {
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

		$resGetAccessToken = Class_ApiJson::getAccessTokenByUser($checkAccount['phone']);
		$res = [
			'status' => 200,
			'message' => 'Lấy access token thành công',
			'data' => [
				'phone' => $checkAccount['phone'],
				'token' => $checkAccount['token'],
				'access_token' => $resGetAccessToken['access_token'],
				'expire_time' => $resGetAccessToken['expire_time'],
				'callOutNumber' => $config['callOutNumber']
			]
		];
		_echoJsonAndReturn($res);
	}

}
