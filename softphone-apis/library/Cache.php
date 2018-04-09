<?php

/**
 * @package		Borua
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       May 13, 2011
 * @version     $Id: Cache 1 May 13, 2011 12:19:27 PM Anhxtanh3087 $
 */
abstract class Cache {
	const CLEANING_MODE_ALL = 1;
	const CLEANING_MODE_OLD = 2;
	const CLEANING_MODE_MATCHING_TAG = 3;
//	const CLEANING_MODE_NOT_MATCHING_TAG = 4;
//	const CLEANING_MODE_MATCHING_ANY_TAG = 5;

	/**
	 * @param string $backend
	 * @return Cache Instance
	 */
	public static function factory($backend) {
//		include ROOT_PATH . 'library/Cache/' . $backend . '.php';
		$backendClass = 'Cache_' . $backend;
		return $backendClass::getInstance();
	}

	/**
	 * Lấy dữ liệu được cache
	 * @param string $cacheId
	 * @param boolean $testCacheValidity true: kiểm tra thời gian hết hạn, false: ko kiểm tra
	 * @return Object Dữ liệu 
	 */
	abstract public function load($cacheId, $testCacheValidity = true);

	/**
	 * Kiểm tra cache có tồn tại hay ko?
	 * @param type $cacheId
	 * @return mixed false: cache ko tồn tại | nếu tồn tại: thời điểm lưu
	 */
	abstract public function test($cacheId);

	/**
	 * @param Object $data
	 */
	abstract public function save($data, $cacheId, $tags = array(), $expire=0);

	abstract public function remove($cacheId);

	abstract public function clean($mode, $tags = array());
}
