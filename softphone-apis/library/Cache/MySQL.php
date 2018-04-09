<?php

/**
 * @package		Borua
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       May 13, 2011
 * @version     $Id: Cache_MySQL 1 May 13, 2011 12:19:27 PM Anhxtanh3087 $
 */
class Cache_MySQL /*extends Cache*/ {

	public static $dhCache;
	private $db;

	public static function getInstance() {
		if (self::$dhCache == null) {
			self::$dhCache = new Cache_MySQL();
		}
		return self::$dhCache;
	}

	public function __construct() {
		global $db;
		$this->db = $db;
	}

	public function save($data, $cacheId, $expire = 0) {
		$this->db->where('cacheId', $cacheId);
		$this->db->delete('cache');

		$d['data'] = serialize($data);
		$d['cacheId'] = $cacheId;
		$d['modified'] = time();
		if ($expire) {
			$d['expire'] = $d['modified'] + $expire;
		} else {
			$d['expire'] = 0;
		}

		$this->db->insert('cache', $d);

		return true;
	}

	public function load($cacheId) {
		$this->db->where('cacheId', $cacheId);
		$this->db->where('(expire = ?  or expire > ?)', array(0, time()));

		$row = $this->db->getOne('cache');

		if ($row) {
			return unserialize($row['data']);
		}

		return false;
	}

	public function remove($cacheId) {
		$this->db->where('cacheId', $cacheId);
		$this->db->delete('cache');
	}

}
