var http = require('http');
var fs = require('fs');

var server = http.createServer(function (request, response) {

	response.writeHead(200, {
		"Context-type": "text/plain"
	});
	
	var apiKeySid = 'SKGXYxF2kj4GG8DX3NFC7VICQAcybSJ9';
	var apiKeySecret = "TVRDVEVsZ0hxbDZnSUFtbDhTR0JMNDhWQWhoSFd4Ynk=";
	var now = Math.floor(Date.now() / 1000);
	var exp = now + 3600;
	
	var userId = 'YOUR_USER_ID';
	
	var header = {cty: "stringee-api;v=1"};
	var payload = {
		jti: apiKeySid + "-" + now,
		iss: apiKeySid,
		exp: exp,
		userId: userId
	};
	
	var jwt = require('jsonwebtoken');
	var token = jwt.sign(payload, apiKeySecret, {algorithm : 'HS256', header: header})
	response.write('TOKEN: ' + token);
	response.end();
});

server.listen(3000, function () {
	console.log('Connected Successfull');
})





