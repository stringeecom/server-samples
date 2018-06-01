<?php

$dataString = file_get_contents('php://input');
$data = json_decode($dataString, true);


error_log ('event data from Stringee: ' . $dataString);



