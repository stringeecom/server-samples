<?php

/**
 * @package		Borua
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Nov 12, 2011
 * @version     $Id: BoruaApi.php 1 Nov 12, 2011 8:47:35 PM Anhxtanh3087 $
 */
class BoruaApi {

	/**
	 * Tạo chữ ký
	 * @param string $stringEncoded Dữ liệu đã mã hóa
	 * @param string $privateKey Khóa bí mật
	 * @return string Chữ ký 
	 */
	public static function makeSignature($stringEncoded, $privateKey) {
		return hash_hmac('md5', $stringEncoded, $privateKey);
	}

	/**
	 * Mã hóa dữ liệu
	 * @param array | object $data Dữ liệu cần mã hóa
	 * @return string Chuỗi trả về sau khi mã hóa
	 */
	public static function encodeData($data) {
		return urlencode(base64_encode(json_encode($data)));
	}

	/**
	 * Lấy ra dữ liệu từ chuỗi đã được mã hóa
	 * @param string $stringEncoded Chuỗi cần dịch
	 * @param boolean $returnArray true - trả về dạng mảng, false - trả về dạng đối tượng
	 * @return array | object Dữ liệu sau khi dịch
	 */
	public static function decodeString($stringEncoded, $returnArray = true) {
		return json_decode(base64_decode(urldecode($stringEncoded)), $returnArray);
	}

	public static function makeUrl($service, $data, $privateKey, $publicKey, $baseUrl = 'http://borua.net') {
		$dataEncoded = BoruaApi::encodeData($data);
		$signature = BoruaApi::makeSignature($dataEncoded, $privateKey);
		return $baseUrl . '/api?service=' . $service . '&data=' . $dataEncoded . '&public_key=' . $publicKey
				. '&signature=' . $signature;
	}

}
