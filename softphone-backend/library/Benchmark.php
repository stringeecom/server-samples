<?php

/**
 * @package		Borua Framework
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Feb 14, 2011
 * @version     $Id: Benchmark.php 1 Feb 14, 2011 2:43:36 PM Anhxtanh3087 $
 */
class Benchmark {

	private $start;

	function __construct() {
		$this->start = microtime();
	}

	/**
	 * Đánh dấu thời điểm bắt đầu đo thời gian chạy
	 */
	function start() {
		$this->start = microtime();
	}

	/**
	 * Thời gian thực thi script, kể từ lúc gọi hàm start()
	 * @return String
	 */
	function time() {
		$end = microtime();
		list($sm, $ss) = explode(' ', $this->start);
		list($em, $es) = explode(' ', $end);
		return number_format(($em + $es) - ($sm + $ss), 6) . ' seconds';
	}

}
