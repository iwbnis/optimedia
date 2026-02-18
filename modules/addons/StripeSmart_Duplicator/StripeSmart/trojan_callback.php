<?php
require_once __DIR__ . '/../../../init.php';
use Illuminate\Database\Capsule\Manager as Capsule;

App::load_function('gateway');
App::load_function('invoice');

$gatewayModuleName = basename(__FILE__, '.php');
$gatewayParams = getGatewayVariables($gatewayModuleName);

if (!$gatewayParams['type']) {
    die("Module Not Activated");
}

$received = file_get_contents('php://input');
$params = json_decode( $received , true);

$type = $params['type'];
$paramsObject = $params['data']['object'];

// Retrieve data returned in redirect
$status = ($paramsObject['payment_status']) ? $paramsObject['payment_status'] : $paramsObject['status'] ;
$subId = $paramsObject['subscription'];
$invoiceId = $paramsObject['client_reference_id'];
$amount = ($paramsObject['amount_total']) ? $paramsObject['amount_total']/100 : $paramsObject['amount_paid']/100;
$currencyCode = $paramsObject['currency'];
	
if($paramsObject['invoice'])
{
	$transactionId = $paramsObject['invoice'];
}
elseif($paramsObject['payment_intent'])
{
	$transactionId = $paramsObject['payment_intent'];
}
else
{
	$transactionId = $paramsObject['id'];
}


if (($type == 'checkout.session.completed' && $status == 'paid') || ($type == 'charge.succeeded' && $status == 'succeeded')) {
	
	if($invoiceId)
	{
		
		$paymentCurrencyID = Capsule::table('tblcurrencies')
			  ->where("code", "=", $currencyCode)
			  ->value('id');

		$userid = Capsule::table('tblinvoices')
				  ->where("id", "=", $invoiceId)
				  ->value('userid');

		$userCurrency = Capsule::table('tblclients')
				  ->where("id", "=", $userid)
				  ->value('currency');

		$paymentAmount = convertCurrency($amount, $paymentCurrencyID, $userCurrency);
		
		
		$invoiceId = checkCbInvoiceID($invoiceId, $gatewayParams['paymentmethod']);

		logTransaction($gatewayParams['paymentmethod'], $params, "Success");

		$commandInv = 'GetInvoice';
		$postDataInv = array(
			'invoiceid' => $invoiceId,
		);

		$resultsInv = localAPI($commandInv, $postDataInv);

		$invoiceWHMCSStatus = $resultsInv['status'];


		if ($invoiceWHMCSStatus == 'Unpaid') {	

			addInvoicePayment($invoiceId, $transactionId, $paymentAmount, $fees, $gatewayModuleName);
		}

	}
	
	if($subId)
	{
		StripeSmart<number>_checkUpdateSubscription($subId , $paramsObject);
	}
}

if($type == 'invoice.paid' && $status == 'paid')
{
	$subscExist = Capsule::table('gateway_stripeSmart<number>_Subscriptions')
        ->where("subscriptionid", "=", $subId)
        ->get();
	
	
	foreach($subscExist as $sub)
	{
			$pid = $sub->productid;
			$nextrenewal = $sub->nextrenewal;
			$invoiceId = Capsule::table('tblinvoiceitems')
				->where("relid", "=", $pid)
				->orderBy('id' , 'DESC')
				->value('invoiceid');
			
			
		$invoiceId = checkCbInvoiceID($invoiceId, $gatewayParams['paymentmethod']);

		logTransaction($gatewayParams['paymentmethod'], $params, "Subscription Renewal");

		$commandInv = 'GetInvoice';
		$postDataInv = array(
			'invoiceid' => $invoiceId,
		);

		$resultsInv = localAPI($commandInv, $postDataInv);

		$invoiceWHMCSStatus = $resultsInv['status'];
		$paymentAmount = $resultsInv['total'];



		if ($invoiceWHMCSStatus == 'Unpaid') {	

			addInvoicePayment($invoiceId, $transactionId, $paymentAmount, $fees, $gatewayModuleName);
		}
			
	}

	if($subId)
	{
		StripeSmart<number>_checkUpdateSubscription($subId , $params);
	}
	
}






function StripeSmart<number>_checkUpdateSubscription($subId , $data){
	
	$invoiceId = $data["client_reference_id"];

	$subscExist = Capsule::table('gateway_stripeSmart<number>_Subscriptions')
        ->where("subscriptionid", "=", $subId)
        ->get();
	
	
	if(count($subscExist) > 0)
	{
		//renew Service
		
		foreach($subscExist as $product)
		{
			
			$type = $product->type;
			$serviceId = $product->productid;
			
			switch($type){
				
				case 'Hosting':
					
					$service = Capsule::table('tblhosting')
						->where("id", "=", $serviceId)
						->first();
					$billingCycle = $service->billingcycle;
					$nextdue = $service->nextduedate;
					
				
				break;
				case 'Addon':
					
					$service = Capsule::table('tblhostingaddons')
						->where("id", "=", $serviceId)
						->first();
					
					$billingCycle = $service->billingcycle;
					$nextdue = $service->nextduedate;
					
				break;
				default:
					continue;
				
				
			}
			
			
			switch($type){
					
				case 'Hosting':

						try {
						  	Capsule::table('gateway_stripeSmart<number>_Subscriptions')
							  ->where('subscriptionid', $subId)
							  ->where('productid', $serviceId)
							  ->where('type', $type)
							  ->update(
								  [
									'nextrenewal' => $nextdue,
									'data' => serialize($data),
								  ]
							  );
							
						logActivity("Updated Subscription ($subId) Details to Stripe Subscription Table for Service with ID: $serviceId with Type: $type and now next due is $nextdue ");
							

					  } catch (\Exception $e) {
							
						logActivity("Unable to Update Subscription ($subId) Details to Stripe Subscription Table for Service with ID: $serviceId with Type: $type but now next due is $nextdue ");

						}
						
			
				
				break;
				case 'Addon':
											
						try {
						  	Capsule::table('gateway_stripeSmart<number>_Subscriptions')
							  ->where('subscriptionid', $subId)
							  ->where('productid', $serviceId)
							  ->where('type', $type)
							  ->update(
								  [
									'nextrenewal' => $nextdue,
									'data' => serialize($data),
								  ]
							  );
							
						logActivity("Updated Subscription ($subId) Details to Stripe Subscription Table for Service with ID: $serviceId with Type: $type and now next due is $nextdue ");
							

					  } catch (\Exception $e) {
							
						logActivity("Unable to Update Subscription ($subId) Details to Stripe Subscription Table for Service with ID: $serviceId with Type: $type but now next due is $nextdue ");

						}
					
					
					
				break;

					
			}
			
			
			
			
			
		}
		
		
		
		 
	}
	else
	{
		//create subscription in stripe subscription table
		
		$products = Capsule::table('tblinvoiceitems')
        ->where("invoiceid", "=", $invoiceId)
        ->get();
		
		foreach($products as $product)
		{
			
			$type = $product->type;
			$serviceId = $product->relid;
			
			switch($type){
				
				case 'Hosting':
					
					$service = Capsule::table('tblhosting')
						->where("id", "=", $serviceId)
						->first();
					$billingCycle = $service->billingcycle;
					$nextdue = $service->nextduedate;
					
				
				break;
				case 'Addon':
					
					$service = Capsule::table('tblhostingaddons')
						->where("id", "=", $serviceId)
						->first();
					
					$billingCycle = $service->billingcycle;
					$nextdue = $service->nextduedate;
					
				break;
				default:
					continue;
				
				
			}
			
			
			
			
			
		if($type == 'Hosting' || $type == 'Addon')
		{
			  try {
					  Capsule::table('gateway_stripeSmart<number>_Subscriptions')->insert(
					  [
						  'subscriptionid' => $subId,
						  'productid' => $serviceId,
						  'type' => $type,
						  'nextrenewal' => $nextdue,
						  'data' => serialize($data)
					  ]
				  );

				 logActivity("Added Subscription ($subId) Details to Stripe Subscription Table for Service with ID: $serviceId with Type: $type and now next due is $nextdue ");

				} catch (\Exception $e) {

				  logActivity("Unable to add Subscription ($subId) Details to Stripe Subscription Table for Service with ID: $serviceId with Type: $type but now next due should be $nextdue Error: ". $e->getMessage());

			  }
			
		}
			
			
			
			
			
		}
		
		
		
	}
	
}
