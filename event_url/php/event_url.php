<?php



$postData = file_get_contents('php://input');

error_log('Event data from Stringee: ' . $postData);

http_response_code(200);

/*
	$signing_secret_key = 'YOUR_SIGNING_SECRET_KEY';

	$signature = @$_SERVER['HTTP_X_STRINGEE_SIGNATURE'];

	function computeSignature($data, $signing_secret_key) {
		$hmac = hash_hmac("sha1", $data, $signing_secret_key, true);
		return base64_encode($hmac);
	}

	$computedSignature = computeSignature($postData, $signing_secret_key);
	if ($computedSignature == $signature) {
		error_log('Confirmed to have come from Stringee');
	} else {
		error_log('NOT VALID. It might have been spoofed');
	}
*/
