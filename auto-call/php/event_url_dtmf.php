<?php

$postDataFromStringee = file_get_contents('php://input');
//{"time":"1530870073736","dtmf":"0","call_id":"call-vn-1-Y8JUX5TVSZ-1530721745779","customField":"","timeout":false}
error_log('postDataFromStringee: ' . $postDataFromStringee);

$sccos = ' [{
	"action": "connect",

	"from": {
		"type": "external",
		"number": "YOUR_STRINGEE_NUMBER",
		"alias": "YOUR_STRINGEE_NUMBER"
	},

	"to": {
		"type": "external",
		"number": "CALL_TO_NUMBER_2",
		"alias": "YOUR_STRINGEE_NUMBER",
	},

	"customData": "test-custom-data"
}]';

echo $sccos;

