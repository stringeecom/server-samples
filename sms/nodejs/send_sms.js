var http = require('http');

const apiKeySid = 'YOUR_API_KEY_SID';
const apiKeySecret = "YOUR_API_KEY_SECRET";

var sms = [
	{
		"from": "YOUR_BRANDNAME",
		"to": "CLIENT_NUMBER",
		"text": "CONTENT_SMS"
	}
]
sendSMS(sms)


//==========================AUTHENTICATION============================//
function getAccessToken() {
	var now = Math.floor(Date.now() / 1000);
	var exp = now + 3600;

	var header = {cty: "stringee-api;v=1"};
	var payload = {
		jti: apiKeySid + "-" + now,
		iss: apiKeySid,
		exp: exp
	};

	var jwt = require('jsonwebtoken');
	var token = jwt.sign(payload, apiKeySecret, {algorithm: 'HS256', header: header})
	return token;
}

//==========================SEND SMS==================================//
function sendSMS(sms) {
	var options = {
		hostname: 'api.stringee.com',
		port: 80,
		path: '/v1/sms',
		method: 'POST',
		headers: {
			'X-STRINGEE-AUTH': getAccessToken(),
			'Content-Type': 'application/json',
			'Accept': 'application/json'
		}
	};

	var postData = JSON.stringify(
			{
				"sms": sms
			}
	);


	var req = http.request(options, function (res) {
		console.log('STATUS:', res.statusCode);
		console.log('HEADERS:', JSON.stringify(res.headers));
		res.setEncoding('utf8');

		res.on('data', function (chunk) {
			console.log('BODY:', chunk);
		});

		res.on('end', function () {
			console.log('No more data in response.');
		});
	});

	req.on('error', function (e) {
		console.log('Problem with request:', e.message);
	});

	req.write(postData);
	req.end();
}



