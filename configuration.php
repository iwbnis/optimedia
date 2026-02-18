<?php
$db_tls_verify_cert = '';
$db_tls_key = '';
$db_tls_cipher = '';
$db_tls_cert = '';
$db_tls_ca_path = '';
$db_tls_ca = '';
$license = 'choice';
$db_host = 'localhost';
$db_port = '';
$db_username = 'choiceip_tetteh739';
$db_password = 'L@m@t3tt3h35556';
$db_name = 'choiceip_choice20200401';
$cc_encryption_hash = 'pQS5QT4tqiFeslqtXdA5enLPxkPYDvRBgbKsuzfhncgCg0BpNEHQcfZfF2UMqG31';
$templates_compiledir = '/var/www/templates_c/';
$crons_dir = '/var/www/crons/';
$whmcspath = '/var/www/public_html/';
$customadminpath = 'jimmywilliamzito739';
$mysql_charset = 'utf8';
if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && 
$_SERVER['HTTP_CF_CONNECTING_IP'] != '') {
$_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
} else {
$_SERVER["REMOTE_ADDR"] = $_SERVER['REMOTE_ADDR'];
}
