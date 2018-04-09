<?php


/**
 * Dau Ngoc Huy
 */
class Cache_Memcached {

	public static $dhCache;

	public static function getInstance() {
		if (self::$dhCache == null) {
			self::$dhCache = new Cache_Memcached();
		}
		return self::$dhCache;
	}

	protected $_memcache = null;

	public function __construct($ip, $port) {
		$this->_memcache = memcache_connect($ip, $port);
	}

	public function load($id, $doNotTestCacheValidity = false) {
		return $this->_memcache->get($id);
	}

	public function test($id) {
		$tmp = $this->_memcache->get($id);
		if (is_array($tmp)) {
			return $tmp[1];
		}
		return false;
	}

	public function save($data, $id, $tags = array(), $specificLifetime = false) {
		if($specificLifetime){
			$result = $this->_memcache->set($id, $data, false, $specificLifetime);
		}else{
			$result = $this->_memcache->set($id, $data, false);
		}

		return $result;
	}

	public function remove($id) {
		return $this->_memcache->delete($id, 0);
	}

	public function clean($mode = 1, $tags = array()) {
		switch ($mode) {
			case 1:
				return $this->_memcache->flush();
				break;
			default:
				break;
		}
	}

	public function getFillingPercentage() {
		$mems = $this->_memcache->getExtendedStats();

		$memSize = null;
		$memUsed = null;
		foreach ($mems as $key => $mem) {
			if ($mem === false) {
				$this->_log('can\'t get stat from ' . $key);
				continue;
			}

			$eachSize = $mem['limit_maxbytes'];
			$eachUsed = $mem['bytes'];
			if ($eachUsed > $eachSize) {
				$eachUsed = $eachSize;
			}

			$memSize += $eachSize;
			$memUsed += $eachUsed;
		}

		if ($memSize === null || $memUsed === null) {
			Zend_Cache::throwException('Can\'t get filling percentage');
		}

		return ((int) (100. * ($memUsed / $memSize)));
	}

}
