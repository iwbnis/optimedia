<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.1.0.1
* @ Author			:	DeZender
* @ Release on		:	29.08.2020
* @ Official site	:	http://DeZender.Net
*
*/

require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
require_once __DIR__ . '/../../../includes/invoicefunctions.php';
$gatewayModuleName = basename(__FILE__, '.php');
$gatewayParams = getGatewayVariables($gatewayModuleName);

if (!$gatewayParams['type']) {
	exit('Module Not Activated');
}

$paymentID = $_GET['pay'];
$email = $_GET['email'];
$invoiceId = $_REQUEST['Passthrough'];

if (empty($invoiceId)) {
	$invoiceId = $_SESSION['invoiceId'];
}
if (!empty($paymentID) && !empty($email)) {
	$body = [];
	$body['Method'] = 'ValidatePayment';
	$body['Key'] = $gatewayParams['APIKEY'];
	$body['Id'] = $paymentID;
	$body['Email'] = $email;
	$url = 'https://www.SnappyCheckout.com/api/v1/';
	$ch = curl_init();
	$content = $body;
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($content));
	$json_response = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$response = json_decode($json_response, true);

	if ($response['result']) {
		$command = 'UpdateInvoice';
		$postData = ['invoiceid' => $invoiceId, 'status' => 'Payment Pending'];
		$results = localAPI($command, $postData);
		callback3DSecureRedirect($invoiceId, $response['result']);
	}
}
else {
	$paymentID = $_POST['PaymentId'];
	$PaymentAmount = $_POST['PaymentPrice'];
	$PaymentHandlingFee = $_POST['PaymentHandlingFee'];
	$paymentCurrency = $_POST['PaymentCurrency'];
	$paymentCurrencyID = Illuminate\Database\Capsule\Manager::table('tblcurrencies')->where('code', '=', $paymentCurrency)->value('id');
	$userid = Illuminate\Database\Capsule\Manager::table('tblinvoices')->where('id', '=', $invoiceId)->value('userid');
	$userCurrency = Illuminate\Database\Capsule\Manager::table('tblclients')->where('id', '=', $userid)->value('currency');
	$paymentAmount = convertCurrency($PaymentAmount, $paymentCurrencyID, $userCurrency);
	$paymentFee = convertCurrency($PaymentHandlingFee, $paymentCurrencyID, $userCurrency);
	$paymentStatus = (!empty($paymentID) ? true : false);
}

$transactionStatus = ($paymentStatus ? 'Success' : 'Failure');
$success = $paymentStatus;
$transactionId = $paymentID;
$invoiceId = checkCbInvoiceID($invoiceId, $gatewayParams['name']);
checkCbTransID($transactionId);
logTransaction($gatewayParams['name'], $_POST, $transactionStatus);

if ($success) {
	addInvoicePayment($invoiceId, $transactionId, $paymentAmount, $paymentFee, $gatewayModuleName);
}

?>