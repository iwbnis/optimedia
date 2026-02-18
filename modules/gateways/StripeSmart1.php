<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;


function StripeSmart1_MetaData()
{
    return [
        'DisplayName' => 'Stripe Smart 1',
        'APIVersion' => '1.1', // Use API Version 1.1
    ];
}

function StripeSmart1_config()
{
    return [
        'FriendlyName' => [
            'Type' => 'System',
            'Value' => 'Stripe Smart 1 Gateway',
        ],
        'SmartURL' => [
            'FriendlyName' => 'Smart URL',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter your Smart URL here',
        ],
		'DisableSub' => [
            'FriendlyName' => 'Disable Subscription',
            'Type' => 'yesno',
            'Description' => 'Disable Subscription Model Entierly (Previous Subscriptions will still go on)',
        ],
        'DisableOne' => [
            'FriendlyName' => 'Disable Onetime',
            'Type' => 'yesno',
            'Description' => 'Disable Onetime Model Entierly (Only Applies to Products and Addons)',
        ],		
        'Key' => [
            'FriendlyName' => 'Smart Key',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter your Smart Key here',
        ],
		'TextInfo' => [
            'FriendlyName' => 'Text Information',
            'Type' => 'textarea',
            'Rows' => '3',
            'Cols' => '60',
            'Description' => 'Enter the Text Information here which will be displayed above card form iframe',
        ]
	];
}


function StripeSmart1_tables()
{
  if (!Capsule::schema()->hasTable('gateway_stripeSmart1_Customers')) {

    try {

            Capsule::schema()
                ->create(
                    'gateway_stripeSmart1_Customers',
                    function ($table) {
                        $table->increments('id');
                        $table->integer('clientid');
                        $table->text('customer_id');
                    }
                );

    } catch (\Exception $e) {
      logTransaction(basename(__FILE__), "Internal Error", $e->getMessage());
    }


  }	
  if (!Capsule::schema()->hasTable('gateway_stripeSmart1_Subscriptions')) {

    try {

            Capsule::schema()
                ->create(
                    'gateway_stripeSmart1_Subscriptions',
                    function ($table) {
                              $table->increments('id');
                              $table->text('subscriptionid');
                              $table->integer('productid');
                              $table->text('type');
                              $table->text('nextrenewal');
                              $table->text('data');
                    }
                );

    } catch (\Exception $e) {
      logTransaction(basename(__FILE__), "Internal Error", $e->getMessage());
    }


  }	
}

function StripeSmart1_nolocalcc() {}
StripeSmart1_tables();
StripeSmart1_check_type();

function StripeSmart1_check_type(){

  $type = Capsule::table('tblpaymentgateways')
          ->where("gateway", "=", "StripeSmart1")
          ->where("setting", "=", "type")
          ->value('value');

          if($type != "CC")
          {
            try{
      Capsule::table('tblpaymentgateways')
        ->where("gateway", "StripeSmart1")
        ->where("setting", "type")
              ->update(
                  [
                      'value' => 'CC',
                  ]
              );

      }
       catch (\Exception $e) {

        // echo 'Unable to update transaction data';

        }

          }

}

function StripeSmart1_remoteinput($params)
{
    $SmartURL = $params['SmartURL'];
    $testMode = $params['testMode'];
	$DisableSub = $params['DisableSub'];
    $DisableOne = $params['DisableOne'];
	$disableSubUser = $_GET['disableSub'];
	$TextInfo = $params['TextInfo'];
	$Key = $params['Key'];

    // Invoice Parameters
    $invoiceId = $params['invoiceid'];
    $description = $params['description'];
    $amount = $params['amount'];
    $currencyCode = $params['currency'];

    // Client Parameters
    $clientId = $params['clientdetails']['id'];
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

    // System Parameters
    $companyName = $params['companyname'];
    $systemUrl = $params['systemurl'];
    $returnUrl = $params['returnurl'];
    $langPayNow = $params['langpaynow'];
    $moduleDisplayName = $params['name'];
    $moduleName = $params['paymentmethod'];
    $whmcsVersion = $params['whmcsVersion'];
	



	$customer_id = StripeSmart1_getCustomer($params);
	
	    
    $invoiceitems = Capsule::table('tblinvoiceitems')
        ->where("invoiceid", "=", $params['invoiceid'])
        ->get();
	
	$userid = Capsule::table('tblinvoices')
		->where("id", "=", $params['invoiceid'])
		->value('userid');

	$currency = Capsule::table('tblclients')
		->where("id", "=", $userid)
		->value('currency');

	$currencyCode = Capsule::table('tblcurrencies')
		->where("id", "=", $currency)
		->value('code');
		
	$mode = 'payment';
	$items = array();
	$i = 0;
	foreach($invoiceitems as $item)
	{
		
		switch($item->type)
		{
			case 'AddFunds':
				
				$name = "Add Funds";
				$desc = "Add Funds to your account";
				$billingCycle = false;
			break;
			case 'Addon':
				
				$service = Capsule::table('tblhostingaddons')
					->where("id", "=", $item->relid)
					->first();
				
				$product = Capsule::table('tbladdons')
					->where("id", "=", $service->addonid)
					->first();
				
				$name = "Invoice # $invoiceId";
				$desc = "";

				$billingCycle = ($service->billingcycle != 'One Time' && $service->billingcycle != 'Free Account' ) ? $service->billingcycle : false ;				

				
				
				
			break;
			case 'Domain':
			case 'DomainRegister':
			case 'DomainTransfer':
				
				$service = Capsule::table('tbldomains')
					->where("id", "=", $item->relid)
					->first();
				
				$name = "Invoice # $invoiceId";
				$desc = "";

				$billingCycle = false;
				
			break;
			case 'Hosting':
				
				$service = Capsule::table('tblhosting')
					->where("id", "=", $item->relid)
					->first();
				
				$product = Capsule::table('tblproducts')
					->where("id", "=", $service->packageid)
					->first();
				
				$name = "Invoice # $invoiceId";
				$desc = "";

				$billingCycle = ($service->billingcycle != 'One Time' && $service->billingcycle != 'Free Account' ) ? $service->billingcycle : false ;

				
			break;
			case 'Invoice':
				$name = "Invoice # ".$params['invoiceid'];
				$billingCycle = false;
				$desc = "Custom $name";

			break;
			case 'Item':
				
				$service = Capsule::table('tblbillableitems')
					->where("id", "=", $item->relid)
					->first();
								
				$name = "Invoice # $invoiceId";
				$billingCycle = false;				
				$desc = "";

			break;
			case 'LateFee':
				$name = "Late Fee";
				$billingCycle = false;
				$desc = "Late Fee Charges";

			break;
			case 'Setup':
				$name = "Setup Charges";
				$billingCycle = false;
				$desc = "Product Setup Charges";

			break;
			case 'Upgrade':
				$name = "Upgrade Charges";
				$billingCycle = false;
				$desc = "Product Upgrade Charges";

			break;
			default:
				$billingCycle = false;
				$name = "Invoice # $invoiceId";
				$desc = "";
		}
		
		if($DisableSub == 'on' || $disableSubUser == 'yes')
		{
			$billingCycle = false;
		}
		
		if($billingCycle)
		{
				switch($billingCycle){
					case 'Days':
						$interval = 'day';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 1 ;
					break;

					case 'Weeks':
						
						$interval = 'week';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 1 ;
						
					break;
						
					case 'Months':
					case 'Monthly':

						$interval = 'month';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 1 ;
						
					break;
					
					case 'Quarterly':

						$interval = 'month';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 3 ;
						

					break;
					
					case 'Semi-Annually':

						$interval = 'month';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 6 ;

					break;
					
					case 'Years':
					case 'Annually':
						
						$interval = 'year';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 1 ;
						
					break;
					
					case 'Biennially':

						$interval = 'year';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 2 ;
						
					break;
					
					case 'Triennially':

						$interval = 'year';
						$frequency = ($billingCycleFrequency) ? $billingCycleFrequency : 3 ;
						
					break;
					
						
				}
			
		}
		
		$name = "Invoice # $invoiceId";
		
		
		$items[$i]['quantity'] = 1;
		$items[$i]['price_data'] = array(
			'currency' => $currencyCode,
			'unit_amount_decimal' => $item->amount * 100,
			'product_data' => array(
							'name' => $name
							)
		);
		
		
		if($billingCycle)
		{
			$items[$i]['price_data']['recurring'] = array(
				'interval' => $interval,
				'interval_count' => $frequency,
			);	
			
			$mode = 'subscription';
		}
		
		
		$i++;
		
	}
	
	if($mode == 'subscription')
	{
		if($DisableOne != 'on')
		{
			$oneTimeBtn = '<center><a href="?disableSub=yes" class="btn btn-success">Pay One-time instead</a> <br>';		
		}
	}
	else
	{
		if($DisableSub != 'on')
		{
			$SubBtn = '<a href="?disableSub=no" class="btn btn-success"><i class="fa fa-repeat"></i> Subscribe instead</a></center><br>';						
		}
		
	}
			
	
	$amountSend = $amount * 100;
	
	if($TextInfo)
	{
		$showText = '<center><span class="alert alert-primary" role="alert">'.$TextInfo.'</span></center><br>';
	}
	

    $formFields = [
        'customerId' => $customer_id,
        'invoiceId' => $invoiceId,
        'amount' => $amountSend,
        'currency' => $currencyCode,
        'name' => 'Invoice # '.$invoiceId,
		'items' => json_encode($items),
		'mode' => $mode
    ];

	
    $formOutput = '';
    foreach ($formFields as $key => $value) {
        $formOutput .= "<input type='hidden' name='$key' value='$value'>" . PHP_EOL;
    }

    // This is a working example which posts to the file: demo/remote-iframe-demo.php
    return '<form method="post" action="' . $SmartURL . '/pay.php">
    ' . $formOutput . '
    <noscript>
        <input type="submit" value="Click here to continue &raquo;">
    </noscript>
</form>
'.$oneTimeBtn.' '.$SubBtn.'
<br>
'.$showText.'
<script>
	$(document).ready(function(){
		
		 setTimeout(function(){
		 
		 		$(".auth3d-area").height("1100px");
				$(".auth3d-area").css("padding-top","20px");
				$(".auth3d-area").css("border","none");

		 
		 }, 5000);
	
	});

</script>';
}



function StripeSmart1_getCustomer($params){

	$SmartURL = $params['SmartURL'];
    $testMode = $params['testMode'];
	$Key = $params['Key'];
	
	$clientid = $params['clientdetails']['id'];
	
	$customer_id = Capsule::table('gateway_stripeSmart1_Customers')
                ->where("clientid", "=", $clientid)
                ->value('customer_id');

    if(empty($customer_id))
    {

	  $params['path'] = 'createcustomer';
      $customer = StripeSmart1_CurlCallPOST($params);
      $customer_id = $customer['id'];

      try {
        Capsule::table('gateway_stripeSmart1_Customers')->insert(
                    [
                        'clientid' => $clientid,
                        'customer_id' => $customer_id,
                    ]
                );
              } catch (\Exception $e) {
                logTransaction(basename(__FILE__), $customer, $e->getMessage());
            }
      }

    $params['customer_id'] = $customer_id;	

	
	return $customer_id;
	
}



function StripeSmart1_CurlCallPOST($params)
{
  $SmartURL = $params['SmartURL'];
  $testMode = $params['testMode'];
  $Key = $params['Key'];
	
  $url = $SmartURL.'/SmartStripe.php';
  $content = json_encode($params);
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
  $json_response = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $response = json_decode($json_response, true);
  logTransaction($params['path'], $response, 'Smart Response');
  return $response;

}



function StripeSmart1_refund($params)
{
	$SmartURL = $params['SmartURL'];
	$testMode = $params['testMode'];
	$Key = $params['Key'];
    
    // Transaction Parameters
    $transactionIdToRefund = $params['transid'];
    $refundAmount = $params['amount'];
    $currencyCode = $params['currency'];
    
    // Client Parameters
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

    // System Parameters
    $companyName = $params['companyname'];
    $systemUrl = $params['systemurl'];
    $langPayNow = $params['langpaynow'];
    $moduleDisplayName = $params['name'];
    $moduleName = $params['paymentmethod'];
    $whmcsVersion = $params['whmcsVersion'];

	

	$params['path'] = 'refund';
	$refund = StripeSmart1_CurlCallPOST($params);

    
    if ($refund['object'] == 'refund' && $refund['status'] == "succeeded") {
        
        return array(
        // 'success' if successful, otherwise 'declined', 'error' for failure
        'status' => 'success',
        // Data to be recorded in the gateway log - can be a string or array
        'rawdata' => $refund,
        // Unique Transaction ID for the refund transaction
        'transid' => $refund['id'],
        // Optional fee amount for the fee value refunded
        'fee' => 0,
        );     
    }
    else
    {
         $returnData = [
            // 'success' if successful, otherwise 'declined', 'error' for failure
            'status' => 'declined',
            // When not successful, a specific decline reason can be logged in the Transaction History
            'declinereason' => 'Refund Failed. Please contact issuer.',
            // Data to be recorded in the gateway log - can be a string or array
            'rawdata' => $refund,
        ];
        logTransaction(basename(__FILE__), $refund, "REFUND-FAILED: ".$LicenseStatus);
    }
    
}