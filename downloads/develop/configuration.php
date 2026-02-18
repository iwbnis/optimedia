<?php
$license = 'choice';
$db_host = 'localhost';
$db_port = '';
$db_username = 'choiceip_tetteh739';
$db_password = 'L@m@t3tt3h35556';
$db_name = 'choiceip_choice20200401';
$cc_encryption_hash = 'pQS5QT4tqiFeslqtXdA5enLPxkPYDvRBgbKsuzfhncgCg0BpNEHQcfZfF2UMqG31';
$templates_compiledir = '/home/choiceiptv35556/templates_c/';
$crons_dir = '/home/choiceiptv35556/crons/';
$whmcspath = '/home/choiceiptv35556/public_html/';
$customadminpath = 'l0m0t3tt3hc35556739';
$mysql_charset = 'utf8';

if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && 
$_SERVER['HTTP_CF_CONNECTING_IP'] != '') {
$_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
} else {
$_SERVER["REMOTE_ADDR"] = $_SERVER['REMOTE_ADDR'];
}
