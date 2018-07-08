const apiKeySid = 'YOUR_API_KEY_SID';
const apiKeySecret = 'YOUR_API_KEY_SECRET';
const userId = 'YOUR_USER_ID';

var token = getAccessToken();
console.log(token);


function getAccessToken() {
	var now = Math.floor(Date.now() / 1000);
	var exp = now + 3600;

	var header = {cty: "stringee-api;v=1"};
	var payload = {
		jti: apiKeySid + "-" + now,
		iss: apiKeySid,
		exp: exp,
		userId: userId
	};

	var jwt = require('jsonwebtoken');
	var token = jwt.sign(payload, apiKeySecret, {algorithm: 'HS256', header: header})
	return token;
}
