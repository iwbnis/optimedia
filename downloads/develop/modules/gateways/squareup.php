<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.0.8.9
* @ Author			:	DeZender
* @ Release on		:	10.05.2019
* @ Official site	:	http://DeZender.Net
*
*/

/**
 * Define module related meta data.
 *
 * @return array
 */
function squareup_MetaData()
{
	return ['DisplayName' => 'SquareUp', 'APIVersion' => '1.1', 'DisableLocalCredtCardInput' => true, 'TokenisedStorage' => false];
}

/**
 * Define gateway configuration options.
 *
 * @return array
 */
function squareup_config()
{
	return [
		'FriendlyName'           => ['Type' => 'System', 'Value' => 'SquareUp Payments'],
		'live_access_token'      => ['FriendlyName' => 'Live Access Token', 'Type' => 'text', 'Size' => '250', 'Default' => '', 'Description' => 'Enter Live Access Token'],
		'live_location_id'       => ['FriendlyName' => 'Live Location ID', 'Type' => 'text', 'Size' => '250', 'Default' => '', 'Description' => 'Enter Live Location ID'],
		'sandbox_access_token'   => ['FriendlyName' => 'Sandbox Access Token', 'Type' => 'text', 'Size' => '250', 'Default' => '', 'Description' => 'Enter Sandbox Access Token'],
		'sandbox_location_id'    => ['FriendlyName' => 'Sandbox Location ID', 'Type' => 'text', 'Size' => '250', 'Default' => '', 'Description' => 'Enter Sandbox Location ID'],
		'merchant_support_email' => ['FriendlyName' => 'Merchant Support Email', 'Type' => 'text', 'Size' => '250', 'Default' => '', 'Description' => 'Enter Merchant Support Email'],
		'license_key'            => ['FriendlyName' => 'License Key', 'Type' => 'text', 'Size' => '250', 'Default' => '', 'Description' => 'Enter License Key'],
		'test_mode'              => ['FriendlyName' => 'Test Mode', 'Type' => 'yesno', 'Description' => 'Tick to enable test mode']
	];
}

function squareup_link($params)
{
	$live_access_token = $params['live_access_token'];
	$live_location_id = $params['live_location_id'];
	$sandbox_access_token = $params['sandbox_access_token'];
	$sandbox_location_id = $params['sandbox_location_id'];
	$merchant_support_email = $params['merchant_support_email'];
	$test_mode = ($params['test_mode'] == 'on' ? 1 : 0);
	$return_url = $params['systemurl'] . 'modules/gateways/callback/squareup.php';
	$license_key = $params['license_key'];

	if ($license_key == '') {
		$htmlOutput = '<p style=\'color:red\'>Please provide Gateway License Key.</p>';
		return $htmlOutput;
		exit();
	}

	if ($license_key != '1098bde742fb97937fcaf48fe8f0ffc9') {
		exit('Invalid Module License. Please Contact Administrator For Support.');
	}

	if (strpos(trim($_SERVER['HTTP_HOST']), 'zuluhosting.org') === false) {
		exit('Invalid Module License. Please Contact Administrator For Support.');
	}

	$invoiceId = $params['invoiceid'];
	$description = $params['description'];
	$amount = $params['amount'];
	$currencyCode = $params['currency'];
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$phone = $params['clientdetails']['phonenumber'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$companyName = $params['companyname'];
	$systemUrl = $params['systemurl'];
	$returnUrl = $params['returnurl'];
	$langPayNow = $params['langpaynow'];
	$moduleDisplayName = $params['name'];
	$moduleName = $params['paymentmethod'];
	$whmcsVersion = $params['whmcsVersion'];
	$idempotencyKey = uniqid();
	$orderArray = [
		'idempotency_key'               => $idempotencyKey,
		'order'                         => [
			'reference_id' => (string) $invoiceId . '_' . $idempotencyKey,
			'line_items'   => [
				[
					'name'             => $description,
					'quantity'         => '1',
					'base_price_money' => ['amount' => $amount * 100, 'currency' => $currencyCode]
				]
			]
		],
		'ask_for_shipping_address'      => true,
		'merchant_support_email'        => $merchant_support_email,
		'pre_populate_buyer_email'      => $email,
		'pre_populate_shipping_address' => ['address_line_1' => $address1, 'address_line_2' => $address2, 'locality' => $city, 'administrative_district_level_1' => $state, 'postal_code' => $postcode, 'first_name' => $firstname, 'last_name' => $lastname],
		'redirect_url'                  => $return_url
	];
	$SQ_ENDPOINT_CHECKOUT = 'https://connect.squareup.com/v2/locations/{LOCATIONID}/checkouts';

	if ($test_mode) {
		$ACCESS_TOKEN = $sandbox_access_token;
		$location_id = $sandbox_location_id;
	}
	else {
		$ACCESS_TOKEN = $live_access_token;
		$location_id = $live_location_id;
	}

	$myCheckoutEndpoint = str_replace('{LOCATIONID}', $location_id, $SQ_ENDPOINT_CHECKOUT);
	squareup_logger("\n" . 'Data sending to SquareUp for creating order : ' . print_r($orderArray, true));

	try {
		squareup_logger("\n" . 'Creating SquareUp order for Invoice ID : ' . $invoiceId);
		$checkoutResponse = getCheckoutUrl($ACCESS_TOKEN, $orderArray, $myCheckoutEndpoint);
		squareup_logger("\n" . 'Checkout Response from SquareUp server : ' . print_r($checkoutResponse, true));

		if ($checkoutResponse) {
			$checkoutUrl = $checkoutResponse['checkoutUrl'];
			$checkoutID = $checkoutResponse['checkoutID'];
			insert_query('tblsq_orders', ['sq_user_id' => $_SESSION['uid'], 'sq_invoice_id' => $invoiceId, 'sq_idempotency_key' => $idempotencyKey, 'sq_checkout_id' => $checkoutID, 'sq_invoice_amount' => $amount]);
			$htmlOutput = "\n\t\t\t\t\t\t\t" . '<script>' . "\n\t\t\t\t\t\t\t\t" . 'function paynow(){' . "\n\t\t\t\t\t\t\t\t\t" . 'window.location = "' . $checkoutUrl . '";' . "\n\t\t\t\t\t\t\t\t" . '}' . "\n\t\t\t\t\t\t\t" . '</script>' . "\n\t\t\t\t\t\n\t\t\t\t\t\t\t" . '<button class="btn btn-success" onclick="paynow()">Pay Now</button>';
			return $htmlOutput;
		}
		else {
			squareup_logger('\\nError While Creating Order : no response at all, maybe the server is down');
			$htmlOutput = '<p style=\'color:red\'>Sorry for inconvenience<br/>There was a problem while creating order. Please contact administrator for support.</p>';
			return $htmlOutput;
		}
	}
	catch (Exception $e) {
		squareup_logger('\\nError While Creating Order : ' . $e->getMessage());
		$htmlOutput = '<p style=\'color:red\'>Sorry for the inconvenience<br/>There was a problem while creating order. Please contact administrator for support.</p>';
		return $htmlOutput;
	}

	return '';
}

if (!defined('WHMCS')) {
	exit('This file cannot be accessed directly');
}

require_once __DIR__ . '/squareup/lib/helper_functions.php';

?>