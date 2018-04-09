<?php

function getURL($onlyDomain = false, $show_request_uri = true) {
    if ($onlyDomain) {
        $url = $_SERVER["SERVER_NAME"];
    } else {
        $url = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
        $url .= ( $_SERVER["SERVER_PORT"] !== "80" ) ? ":" . $_SERVER["SERVER_PORT"] : "";
        if ($show_request_uri) {
            $url .= $_SERVER["REQUEST_URI"];
        } else {
            $url .= "/";
        }
    }
    return $url;
}



function removeFile($filename, $filePath) {
    unlink($filePath . $filename);
}

function removeFileFromRemove($host, $username, $password, $port, $remotePath){
    $connection = ssh2_connect($host, $port);
    if ($connection) {
        if (ssh2_auth_password($connection, $username, $password)) {
            $remove = ssh2_sftp_unlink(ssh2_sftp($connection), $remotePath);
            return $remove;
        }
    }
    return false;
}

function sendFileToRemote($host, $username, $password, $port, $localPath, $remotePath) {
    $connection = ssh2_connect($host, $port);
    if ($connection) {
        if (ssh2_auth_password($connection, $username, $password)) {
            $send = ssh2_scp_send($connection, $localPath, $remotePath, 0644);
            return $send;
        }
    }
    return false;
}

function uploadFile($requestname, $savePath, $savename, $allowExtension = array()) {
    if (isset($_FILES[$requestname]) && $_FILES[$requestname]['name'] != "") {
        if ($_FILES[$requestname]['error'] < 1) {
            if (count($allowExtension) > 0) {
                foreach ($allowExtension as $extension) {
                    if ($_FILES[$requestname]['type'] != $extension) {
                        return "";
                    }
                }
            }
            $r = move_uploaded_file($_FILES[$requestname]["tmp_name"], $savePath . $savename);
            if ($r) {
                return $savename;
            }
        }
    }
    return "";
}

function sendEmail($to, $nameTo, $subject, $body) {
    /**
     * PHPMailer
     */
    include_once 'PHPMailer/class.phpmailer.php';
    try {
        global $config;
        $mailer = new PHPMailer();
        $mailer->CharSet = 'UTF-8';
        $mailer->IsSMTP();
        $mailer->SMTPDebug = 0;

        $mailer->SMTPAuth = true; // enable SMTP authentication
        $mailer->SMTPSecure = $config['mailSMTPSecure']; // sets the prefix to the servier
        $mailer->Host = $config['mailHost'];
        $mailer->Port = $config['mailPort'];
        $mailer->Username = $config['mailUsername'];
        $mailer->Password = $config['mailApikey'];

        $mailer->SetFrom($config['mailFrom'], $config['mailName'], 0); //Định danh người gửi
        $mailer->Subject = $subject;
        $mailer->MsgHTML($body);

        $mailer->AddAddress($to, $nameTo); //Gửi tới ai ?
        return $mailer->Send();
    } catch (Exception $ex) {
        return false;
    }
}



/**
 * @package		Borua
 * @copyright   Copyright (c) 2010 Anhxtanh3087
 * @author      Dau Ngoc Huy - Anhxtanh3087 - huydaungoc@gmail.com
 * @since       Feb 14, 2011
 * @version     $Id: common.php 1 Feb 14, 2011 2:43:36 PM Anhxtanh3087 $
 */
function dateTimeExplode($node) {
    $dateTime = strtotime($node ['created']);
    $node ['date'] = date("d/m/Y", $dateTime);
    $node ['time'] = date("H:i", $dateTime);
    return $node;
}





function checkEvent($user) {
    $modelDaemon = new Model_Daemon();
    $modelDaemon->addToQueueIfNotExist($user, 1);
}

function userFilter($username) {
    return preg_replace('/[^a-z0-9\._\-]+/i', '', $username);
}

function hashCookie($password, $username, $expirationDate) {
    return md5($password . $username . $expirationDate . $_SERVER['REMOTE_ADDR'] . 'DauHuy');
}

/**
 * $data mảng dữ liệu gồm các object và chỉ số: ($obj1->index, $obj1->data)
 * $key tên trường chứa chỉ số để sắp xếp ('index')
 * $order ASC - tăng dần, DESC - giảm dần
 * */
function objectSort($data, $key, $order = 'ASC') {
    for ($i = count($data) - 1; $i >= 0; $i--) {
        $swapped = false;
        for ($j = 0; $j < $i; $j++) {
            if ($order == 'ASC') {
                if ($data[$j]->$key > $data[$j + 1]->$key) {
                    $tmp = $data[$j];
                    $data[$j] = $data[$j + 1];
                    $data[$j + 1] = $tmp;
                    $swapped = true;
                }
            } else {
                if ($data[$j]->$key < $data[$j + 1]->$key) {
                    $tmp = $data[$j];
                    $data[$j] = $data[$j + 1];
                    $data[$j + 1] = $tmp;
                    $swapped = true;
                }
            }
        }
        if (!$swapped)
            return $data;
    }

    return $data;
}

function is_valid_url($url) {
    // First check: is the url just a domain name? (allow a slash at the end)
    $_domain_regex = "|^[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,})/?$|";
    if (preg_match($_domain_regex, $url)) {
        return true;
    }

    // Second: Check if it's a url with a scheme and all
    $_regex = '#^([a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))$#';
    if (preg_match($_regex, $url, $matches)) {
        // pull out the domain name, and make sure that the domain is valid.
        $_parts = parse_url($url);
        if (!in_array($_parts['scheme'], array('http', 'https')))
            return false;

        // Check the domain using the regex, stops domains like "-example.com" passing through
        if (!preg_match($_domain_regex, $_parts['host']))
            return false;

        // This domain looks pretty valid. Only way to check it now is to download it!
        return true;
    }

    return false;
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function money($amount){
	return number_format($amount, 0, ',', '.');
}

// $res = array
function _echoJsonAndReturn($res){
	header('Content-Type: application/json');
	echo json_encode($res);
	exit();
}

function autoString($limit) {
	$stringInput = 'ABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789abcdefghijklmnopqrstuvxwyz';
	$countStringInput = strlen($stringInput);

	$autoString = NULL;
	for ($x = 1; $x <= $limit; $x++) {
		$positionCharacter = rand(0, $countStringInput);
		$autoString .= substr($stringInput, $positionCharacter, 1);
	}
	return $autoString;
}




