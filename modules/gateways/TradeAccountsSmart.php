<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;


function TradeAccountsSmart_MetaData()
{
    return array(
        'DisplayName' => 'Trade Accounts Payment Gateway',
        'APIVersion' => '1.1', // Use API Version 1.1
    );
}

function TradeAccountsSmart_config()
{
    
    if (!Capsule::schema()->hasTable('gateway_TradeAccountsSmart')) {

    try {

            Capsule::schema()
                ->create(
                    'gateway_TradeAccountsSmart',
                    function ($table) {
                        $table->increments('id');
                        $table->text('invoiceid');
                        $table->text('refund_status');
                        $table->text('amount');
                        $table->text('request_date');
                        $table->text('transid');
                        $table->text('status');
                    }
                );

        logActivity("Successfully Created the table for Trade Smart Accounts: Gateway Refund Feature" , 0);
        
    } catch (\Exception $e) {
        
        logActivity("Unable to Create the table for Trade Smart Accounts: Gateway Refund Feature due to Error: ".$e->getMessage() , 0);
    }


  }
    
    
    
    return array(

        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Trade Accounts Payment Gateway',
        ),
        'Domain' => array(
            'FriendlyName' => 'Router Domain',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter your Router Domain here',
        ),
    );
}

function TradeAccountsSmart_capture($params)
{
    global $CONFIG;
    $SystemURL = $CONFIG['SystemURL'];

    // Gateway Configuration Parameters
    $Domain = $params['Domain'];
    $key = $params['Key'];


    // Invoice Parameters
    $invoiceId = $params['invoiceid'];
    $description = $params["description"];
    $amount = $params['amount'];
    $currencyCode = $params['currency'];

    // Credit Card Parameters
    $cardType = $params['cardtype'];
    $cardNumber = $params['cardnum'];
    $cardExpiry = $params['cardexp'];
    $cardStart = $params['cardstart'];
    $cardIssueNumber = $params['cardissuenum'];
    $cardCvv = $params['cccvv'];
    

    // Client Parameters
    $clientid = $params['clientdetails']['id'];
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
    $params['ip'] = TradeAccountsSmart_get_client_ip();
    $userAgent = $_SERVER['HTTP_USER_AGENT'];  
    $params['userAgent'] = $userAgent;

    
    $url = "$Domain/TradeAccounts_PayNow/paynow.php";

    $payment = TradeAccountsSmart_CurlCallPOST($url , $params);
    
    if ($payment['status'] == 1 && !empty($payment['transaction_id'])) {
        $returnData = [
            // 'success' if successful, otherwise 'declined', 'error' for failure
            'status' => 'success',
            // Data to be recorded in the gateway log - can be a string or array
            'rawdata' => $payment,
            // Unique Transaction ID for the capture transaction
            'transid' => $payment['transaction_id'],
            // Optional fee amount for the fee value refunded
            'fee' => 0,
        ];
    } 
    else 
    {

      $errorText = $payment['message'];

      if(empty($errorText))
      {
        $errorText = 'Credit card declined. Please contact issuer.';

      }

        $returnData = [
            // 'success' if successful, otherwise 'declined', 'error' for failure
            'status' => 'declined',
            // When not successful, a specific decline reason can be logged in the Transaction History
            'declinereason' => $errorText,
            // Data to be recorded in the gateway log - can be a string or array
            'rawdata' => $payment,
        ];
    }

    return $returnData;
}


function TradeAccountsSmart_refund($params , $confirm = false , $data = '')
{
    global $CONFIG;
    $SystemURL = $CONFIG['SystemURL'];

    // Gateway Configuration Parameters
    $Domain = $params['Domain'];
    $key = $params['Key'];

    // Transaction Parameters
    $transactionIdToRefund = $params['transid'];
    $refundAmount = $params['amount'];
    $currencyCode = $params['currency'];
    $invoiceId = $params['invoiceid'];

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
    $params['ip'] = TradeAccountsSmart_get_client_ip();
    $userAgent = $_SERVER['HTTP_USER_AGENT'];  
    $params['userAgent'] = $userAgent;
    $params['return_url'] = $systemUrl . '/modules/gateways/callback/' . $moduleName . '.php';

    $url = "$Domain/TradeAccounts_PayNow/refund.php";

    $payment = TradeAccountsSmart_CurlCallPOST($url , $params);
    
    
    if($payment['data']['status'] == "REFUNDED")
    {
        
        try {

                Capsule::table('gateway_TradeAccountsSmart')->insert([
                    'invoiceid' => $payment['data']['order_id'],
                    'refund_status' => $payment['data']['refund_status'],
                    'amount' => $refundAmount,
                    'request_date' => $payment['data']['refund_date'],
                    'transid' => $payment['data']['transaction_id'],
                    'status' => $payment['data']['status']
                ]);
                
                logActivity("Recorded Refund Request Data for InvoiceID $invoiceId with data: ".json_encode($payment) , 0);

            } catch (\Exception $e) {
            
                logActivity("Error Refund Request Data for InvoiceID $invoiceId with data:".json_encode($payment)."  Error: " . $e->getMessage() , 0);
    
            }
        
        
        $_SESSION['success'] = "Your refund request has been submitted successfully, Your invoice will be updated as soon as refund is processed.";
        header("Location: invoices.php?action=edit&id=$invoiceId");
        die();
    }
    else
    {
        $_SESSION['error'] = "Your refund request was unsuccessful, Check the activity log fo more information.";
        header("Location: invoices.php?action=edit&id=$invoiceId");
        die();    
    }
    
    
    if($confirm && $data)
    {
         return array(
        // 'success' if successful, otherwise 'declined', 'error' for failure
        'status' => 'success',
        // Data to be recorded in the gateway log - can be a string or array
        'rawdata' => $data,
        // Unique Transaction ID for the refund transaction
        'transid' => $data['transaction_id'],
        'fee' => 0,
    );
    }

  
}


function TradeAccountsSmart_CurlCallPOST($url , $params)
{
  $header = array("Content-type: application/json");   
  $content = json_encode($params);
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
  $json_response = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $response = json_decode($json_response, true);
  logTransaction(basename($url), $response, 'CURL RESPONSE');
  return $response;

}

function TradeAccountsSmart_get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        if(strpos($ipaddress, ",") !== false){
            $ip = explode(',' , $ipaddress);
            $ipaddress = $ip[0];
        }
        return $ipaddress;
    } 
