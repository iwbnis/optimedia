<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.0.10.0
* @ Author			:	DeZender
* @ Release on		:	09.04.2020
* @ Official site	:	http://DeZender.Net
*
*/

include_once '../../../../../init.php';

if ($_REQUEST['action'] == 'test_connection') {
	$URL = $_REQUEST['xc_url'] . '/index.php';
	$postdata = ['login' => $_REQUEST['username'], 'pass' => $_REQUEST['password']];
	$cookie_path = dirname(__FILE__) . '/cookie.txt';
	$ch = curl_init($URL);
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$ret1 = curl_exec($ch);

	if (curl_error($ch)) {
		$error_msg = curl_error($ch);
	}

	curl_close($ch);

	if (isset($error_msg)) {
		echo ' ' . "\n" . '        <span style="padding:2px 10px;background-color:#cc0000;color:#fff;"><strong>FAILED:</strong> Failed to connect to Reseller Panel: Connection Failed, Please check the details and try again</span>  ' . "\n" . '        ';
	}
	else {
		$orginalurl = $_REQUEST['xc_url'] . '/userpanel/';
		$cookie_path = dirname(__FILE__) . '/cookie.txt';
		$ch = curl_init($_REQUEST['xc_url']);
		$postdata = ['login' => $_REQUEST['username'], 'pass' => $_REQUEST['password']];
		curl_setopt($ch, CURLOPT_URL, $_REQUEST['xc_url']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret1 = curl_exec($ch);
		$orginalurl = $orginalurl . 'add_user.php';
		curl_setopt($ch, CURLOPT_URL, $orginalurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		$ret2 = curl_exec($ch);

		if (curl_error($ch)) {
			$error_msg = curl_error($ch);
		}

		curl_close($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($ret2);
		$select = $dom->getElementsByTagName('select');

		for ($i = 0; $i < $select->length; $i++) {
			$selectgrab = $select->item($i);

			if ($selectgrab->getAttribute('name') == 'package_id') {
				$packages = 'yes';
			}
		}
		if (isset($packages) && ($packages == 'yes')) {
			echo '            <span style="padding:2px 10px;background-color:#5bb75b;color:#fff;font-weight:bold;">SUCCESSFUL!</span>' . "\n\n" . '            ';
		}
		else {
			echo ' ' . "\n" . '            <span style="padding:2px 10px;background-color:#cc0000;color:#fff;"><strong>FAILED:</strong> Failed to connect to Reseller Panel: Connection Failed, Please check the details and try again</span>' . "\n" . '            ';
		}
	}
}

?>