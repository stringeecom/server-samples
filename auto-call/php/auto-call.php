<?php

include './StringeeApi/StringeeCurlClient.php';

global $config;


$keySid = 'YOUR_KEY_SID';
$keySecret = 'YOUR_KEY_SECRET';

$curlClient = new StringeeCurlClient($keySid, $keySecret);
$url = 'http://api.stringee.com/v1/call2/callout';

$data = '{
    "from": {
        "type": "external",
        "number": "YOUR_STRINGEE_NUMBER",
        "alias": "YOUR_STRINGEE_NUMBER"
    },
    
    "to": [{
        "type": "external",
        "number": "CALL_TO_NUMBER",
        "alias": "CALL_TO_NUMBER"
    }],
   
    "actions": [
        {
            "action": "talk",
            "text": "       Stringee kính chào quý khách, đây là cuộc gọi tự động, vui lòng liên hệ với chúng tôi qua info@stringee.com hoặc nhấn phím bất kỳ để gặp bộ phận kinh doanh của Stringee",
            "voice": "hn_male_xuantin_vdts_48k-hsmm",
            "bargeIn": true,
            "loop": 5
        },
        {
            "action": "input",
            "eventUrl": "https://example.com/event_url_dtmf.php",
            "submitOnHash": "false",
            "timeout": "15"
        },


    ]
}';

$resJson = $curlClient->post($url, $data, 15);
$status = json_decode($resJson->getStatusCode());

$content = $resJson->getContent();

echo '$status: ' . $status . '<br>';
echo '$content: ' . $content . '<br>';



