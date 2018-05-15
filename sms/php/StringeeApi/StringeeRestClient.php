<?php

include_once 'StringeeCurlClient.php';

class StringeeRestClient {

	protected $_keySid;
	protected $_keySecret;
	protected $_baseUrl = 'https://test3.stringee.com:6883/';
//	protected $_baseUrl = 'https://local.stringee.com:8000/';
	protected $_curlClient;

	public function __construct($keySid, $keySecret) {
		$this->_keySid = $keySid;
		$this->_keySecret = $keySecret;

		$this->_curlClient = new StringeeCurlClient($keySid, $keySecret);
	}

	public function test() {
		if (count($this->_notificationItems) == 0) {
			return;
		}

		$url = $this->_baseUrl . 'notify';
		$postData = json_encode($this->_notificationItems);
		$res = $this->_curlClient->post($url, $postData, 15);

		$this->_notificationItems = array();

		return $res;
	}

}
