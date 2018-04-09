<?php

class Class_Validate {

	// @return true = phone
	public static function isPhoneNumber($phone) {
		$phone = trim($phone);

		$err = false;

		if (!is_numeric($phone)) {
			$err = true;
		}

		if ($phone[0] == 0) {
			$err = true;
		}

		if (strlen($phone) < 10 || strlen($phone) > 12) {
			$err = true;
		}

		if ($err) {
			return false;
		}

		return true;
	}

}
