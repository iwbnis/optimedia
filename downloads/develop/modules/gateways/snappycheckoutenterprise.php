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

function snappycheckoutenterprise_MetaData()
{
	return ['DisplayName' => 'Snappy Checkout Gateway enterprise', 'APIVersion' => '1.1', 'DisableLocalCreditCardInput' => true, 'TokenisedStorage' => false];
}

function snappycheckoutenterprise_config()
{
	global $CONFIG;
	$URL = $CONFIG['SystemURL'];
	return [
		'FriendlyName' => ['Type' => 'System', 'Value' => 'SnappyCheckout Gateway enterprise'],
		'APIKEY'       => ['FriendlyName' => 'API Key', 'Type' => 'text', 'Size' => '25', 'Default' => '', 'Description' => 'Enter your API Key here'],
		'PPWP'         => ['FriendlyName' => 'Product ID', 'Type' => 'text', 'Size' => '25', 'Default' => '', 'Description' => 'Enter your Pay What you Want (PWYW) Product ID here. <br>- Its Title will be visible on checout so make sure to Enter your site name as Product Title<br>- Place below given Redirect and Webhook URL under this product configuration on SnappyCheckout.'],
		'callbackURL'  => ['FriendlyName' => 'Redirect Customer URL', 'Type' => 'text', 'Size' => '125', 'Default' => $URL . '/modules/gateways/callback/snappycheckout.php?pay=[paymentid]&email=[email]', 'Description' => 'Enter this URL in "What would you like to do after your customer pays?"'],
		'webhookURL'   => ['FriendlyName' => 'Webhook URL', 'Type' => 'text', 'Size' => '125', 'Default' => $URL . '/modules/gateways/callback/snappycheckout.php', 'Description' => 'Enable Send webhook event and add this URL' . "\n" . '            <script>' . "\n" . '            $( document ).ready(function() {' . "\n" . '              $("input[name=\\"field[webhookURL]\\"]").prop(\'readonly\' , true);' . "\n" . '              $("input[name=\\"field[webhookURL]\\"]").css(\'max-width\' , \'800px\');' . "\n" . '              $("input[name=\\"field[callbackURL]\\"]").prop(\'readonly\' , true);' . "\n" . '              $("input[name=\\"field[callbackURL]\\"]").css(\'max-width\' , \'800px\');' . "\n" . '            });' . "\n" . '            </script>'],
		'TestCode'     => ['FriendlyName' => 'TestCode', 'Type' => 'text', 'Size' => '25', 'Default' => '', 'Description' => 'Enter your Test Code here'],
		'testMode'     => ['FriendlyName' => 'Test Mode', 'Type' => 'yesno', 'Description' => 'Tick to enable test mode<br>- Test mode only works if you configure  your Test Code above<br>- In test mode you will have to manually enter the amount to pay after redirection to checkout page<br>- If you are converting the currency then you should look in the URL for amount parameter on checkout page to enter converted amount.']
	];
}

function snappycheckoutenterprise_link($params)
{
	$APIKEY = $params['APIKEY'];
	$TestCode = $params['TestCode'];
	$testMode = $params['testMode'];
	$PPWP = $params['PPWP'];
	$invoiceId = $params['invoiceid'];
	$_SESSION['invoiceId'] = $invoiceId;
	$description = $params['description'];
	$amount = $params['amount'];
	$currencyCode = $params['currency'];
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];
	$companyName = $params['companyname'];
	$systemUrl = $params['systemurl'];
	$returnUrl = $params['returnurl'];
	$langPayNow = $params['langpaynow'];
	$moduleDisplayName = $params['name'];
	$moduleName = $params['paymentmethod'];
	$whmcsVersion = $params['whmcsVersion'];
	if (($testMode == 'on') && !empty($TestCode)) {
		$htmlOutput .= '<a id="myPayNowBtn" style="display:none;" class="btn btn-success" href="https://www.snappycheckout.com/pay?' . $PPWP . '&test=' . $TestCode . '&passthrough=' . $invoiceId . '&amount=' . $amount . '">' . $langPayNow . '</a>';
	}
	else {
		$htmlOutput .= '<a id="myPayNowBtn" style="display:none;" class="btn btn-success" href="https://www.snappycheckout.com/pay?' . $PPWP . '&passthrough=' . $invoiceId . '">' . $langPayNow . '</a>';
		$htmlOutput .= '<script src="https://s3.amazonaws.com/snappycheckout/Button.js" passthrough="' . $invoiceId . '"></script>';
	}

	$htmlOutput .= '<script>' . "\n" . '    function _0x5a4f(){var _0x340239=[\'onclick\',\'13622720hpmVER\',\'1214588NRxJbf\',\'#checkout-panel-paymentform-price-container\',\'#checkout-panel-paymentform-receipt-inner-container\',\'3352veMKFZ\',\'11TCzRjO\',\'#checkout-panel-payment\',\'readonly\',\'3315390Pgvwgg\',\'location.reload();\',\'5wtvCJA\',\'val\',\'#SavePriceButton\',\'length\',\'click\',\'show\',\'attr\',\'hide\',\'857azODcp\',\'#checkout-panel-paymentform-price-manual\',\'8721672XdfCpj\',\'#myPayNowBtn\',\'4711iQiIsr\',\'ready\',\'120KvpmFC\',\'4937616KTblYO\',\'#checkout-panel-payment div:first-child div img\',\'3qgsoLw\'];_0x5a4f=function(){return _0x340239;};return _0x5a4f();}function _0x3f2c(_0x4a7de0,_0x2f93c5){var _0x5a4f7a=_0x5a4f();return _0x3f2c=function(_0x3f2c4f,_0x424783){_0x3f2c4f=_0x3f2c4f-0xe2;var _0x2af173=_0x5a4f7a[_0x3f2c4f];return _0x2af173;},_0x3f2c(_0x4a7de0,_0x2f93c5);}var _0x15e33d=_0x3f2c;(function(_0x5ebf2f,_0x4d47b2){var _0x4430e0=_0x3f2c,_0x58144b=_0x5ebf2f();while(!![]){try{var _0x18ec44=-parseInt(_0x4430e0(0xfb))/0x1*(-parseInt(_0x4430e0(0xed))/0x2)+-parseInt(_0x4430e0(0xe7))/0x3*(-parseInt(_0x4430e0(0xea))/0x4)+-parseInt(_0x4430e0(0xf3))/0x5*(-parseInt(_0x4430e0(0xf1))/0x6)+-parseInt(_0x4430e0(0xe2))/0x7*(-parseInt(_0x4430e0(0xe4))/0x8)+parseInt(_0x4430e0(0xe5))/0x9+-parseInt(_0x4430e0(0xe9))/0xa+-parseInt(_0x4430e0(0xee))/0xb*(parseInt(_0x4430e0(0xfd))/0xc);if(_0x18ec44===_0x4d47b2)break;else _0x58144b[\'push\'](_0x58144b[\'shift\']());}catch(_0x289dc2){_0x58144b[\'push\'](_0x58144b[\'shift\']());}}}(_0x5a4f,0xba149),$(document)[_0x15e33d(0xe3)](function(){var _0x16425b=_0x15e33d;$(_0x16425b(0xfe))[\'show\']();}),$(_0x15e33d(0xfe))[_0x15e33d(0xf7)](function(){var _0x5587cb=setInterval(function(){var _0x14a10a=_0x3f2c;$(_0x14a10a(0xef))[_0x14a10a(0xf6)]>0x0&&($(_0x14a10a(0xfc))[\'prop\'](_0x14a10a(0xf0),!![]),$(_0x14a10a(0xeb))[_0x14a10a(0xfa)](),$(_0x14a10a(0xec))[_0x14a10a(0xfa)](),$(_0x14a10a(0xfc))[_0x14a10a(0xf4)](' . $amount . '),$(_0x14a10a(0xf5))[_0x14a10a(0xf6)]>0x0&&($(_0x14a10a(0xf5))[\'click\']()&&$(_0x14a10a(0xe6))[_0x14a10a(0xf9)](_0x14a10a(0xe8),_0x14a10a(0xf2))),clearInterval(_0x5587cb)),$(\'#checkout-panel-paymentform-receipt-inner-container\')[_0x14a10a(0xf8)]();},0x64);}));' . "\n" . '    </script>';
	$LicenseStatus = snappycheckoutenterprise_verify_license();

	if ($LicenseStatus == 'active') {
		return $htmlOutput;
	}
	else {
		return 'API ERROR!';
	}
}

function snappycheckoutenterprise_verify_license()
{
	$LicenseKey = '23112021215324MNH3CUQHASZ67GTY1FHZ';
	$url = 'https://xpertsol.org/WHMCS_snappy/license_verify.php?key=' . $LicenseKey . '&domain=' . $_SERVER['SERVER_NAME'];
	$LicenseStatus = snappycheckoutenterprise_curl_get_contents($url);

	if ($LicenseStatus === false) {
		$LicenseStatus = 'Error connecting to Server';
		exit();
	}

	return $LicenseStatus;
}

function snappycheckoutenterprise_curl_get_contents($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

if (!defined('WHMCS')) {
	exit('This file cannot be accessed directly');
}

?>