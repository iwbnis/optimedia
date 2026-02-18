<?php
session_start();
# Required File Includes
if (file_exists("../../../dbconnect.php")) {
  require_once("../../../dbconnect.php");
} else {
  require_once("../../../init.php");
}

require_once("../../../includes/functions.php");
require_once("../../../includes/gatewayfunctions.php");
require_once("../../../includes/invoicefunctions.php");
require_once('AmazonPaySDK/Client.php');

$gatewaymodule = "AmazonPay"; # Enter your gateway module name here replacing template

try {
  $gatewayVariables = getGatewayVariables($gatewaymodule);
  $varPresent       = 1;
}
catch (\Exception $e) {}

if (is_numeric($varPresent)) {
  $invoiceDetails = explode('::', urldecode(base64_decode($_REQUEST['trd'])));
  $amazonConfig = array(
    'merchant_id' => $gatewayVariables['merchantid'],
    'access_key' => $gatewayVariables['accesskey'],
    'secret_key' => $gatewayVariables['secretkey'],
    'client_id' => $gatewayVariables['clientid'],
    'region' => $gatewayVariables['region']
  );
  
  $amazonClient = new AmazonPay\Client($amazonConfig);
  
  if ($gatewayVariables['sandbox'] === 'on') {
    $amazonClient->setSandbox(true);
    switch ($getGatewayVariables['region']) {
      case 'us':
        $endpointurl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js'></script>";
        break;
      
      case 'uk':
        $endpointurl = "<script type='text/javascript' src='https://static-eu.payments-amazon.com/OffAmazonPayments/uk/sandbox/js/Widgets.js'></script>";
        break;
      
      case 'de':
        $endpointurl = "<script type='text/javascript' src='https://static-eu.payments-amazon.com/OffAmazonPayments/uk/sandbox/js/Widgets.js'></script>";
        break;
      
      case 'jp':
        $endpointurl = "<script type='text/javascript' src='https://origin-na.ssl-images-amazon.com/images/G/09/EP/offAmazonPayments/sandbox/prod/lpa/js/Widgets.js'></script>";
        break;
      
      default:
        $endpointurl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js'></script>";
        break;
    }
  } else {
    switch ($getGatewayVariables['region']) {
      case 'us':
        $endpointurl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/js/Widgets.js'></script>";
        break;
      
      case 'uk':
        $endpointurl = "<script type='text/javascript' src='https://static-eu.payments-amazon.com/OffAmazonPayments/uk/js/Widgets.js'></script>";
        break;
      
      case 'de':
        $endpointurl = "<script type='text/javascript' src='https://static-eu.payments-amazon.com/OffAmazonPayments/uk/js/Widgets.js'></script>";
        break;
      
      case 'jp':
        $endpointurl = "<script type='text/javascript' src='https://origin-na.ssl-images-amazon.com/images/G/09/EP/offAmazonPayments/prod/lpa/js/Widgets.js'></script>";
        break;
      
      default:
        $endpointurl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/js/Widgets.js'></script>";
        break;
    }
  }
	
  $code = '<html><header>
<style type="text/css">
#btn-place-order{display:inline-block;width:159px;background:none repeat scroll 0 0 #d8dde6;border:1px solid;border-color:#b7b7b7 #aaa #a0a0a0;border-image:none;height:35px;overflow:hidden;text-align:center;text-decoration:none!important;vertical-align:middle;color:#05a;cursor:pointer}
#btn-place-order{border-color:#be952c #a68226 #9b7924;background-color:#eeba37}
#btn-place-order{background:#f6d073;background:-moz-linear-gradient(top,#fee6b0,#eeba37);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fee6b0),color-stop(100%,#eeba37));background:-webkit-linear-gradient(top,#fee6b0,#eeba37);background:-o-linear-gradient(top,#fee6b0,#eeba37);background:-ms-linear-gradient(top,#fee6b0,#eeba37);background:linear-gradient(top,#fee6b0,#eeba37);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#fee6b0",endColorstr="#eeba37",GradientType=0);zoom:1;}
#btn-place-order:hover{background:#f5c85b;background:-moz-linear-gradient(top,#fede97,#ecb21f);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#fede97),color-stop(100%,#ecb21f));background:-webkit-linear-gradient(top,#fede97,#ecb21f);background:-o-linear-gradient(top,#fede97,#ecb21f);background:-ms-linear-gradient(top,#fede97,#ecb21f);background:linear-gradient(top,#fede97,#ecb21f);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#fede97",endColorstr="#ecb21f",GradientType=0);zoom:1}
#btn-place-order:active{-webkit-box-shadow:0 1px 3px rgba(0,0,0,0.2) inset;-moz-box-shadow:0 1px 3px rgba(0,0,0,0.2) inset;box-shadow:0 1px 3px rgba(0,0,0,0.2) inset;background-color:#eeba37;background-image:none;filter:none}
#btn-place-order{line-height:33px;background-color:transparent;color:#111;display:block;font-family:Arial,sans-serif;font-size:15px;outline:0 none;text-align:center;white-space:nowrap;cursor:pointer;}
#btn-place-order:link {text-decoration: none;}
</style></header><body>';
  
  $code .= '<!-- <div id="addressBookWidgetDiv" style="width:400px; height:240px;"></div> --!>
<div align="center" style="margin:5%;">
		<img src="https://images-na.ssl-images-amazon.com/images/G/01/amazonservices/payments/website/Secondary-logo-amazonpay-fullcolor_tools._V534864886_.png">
		<br/>
		<p><span id="helloMessage"></span><br/><br/>Pay <b>$' . $invoiceDetails[1] . ' USD</b> to ' . $invoiceDetails[3] . '</p>
		<div id="walletWidgetDiv" align="center" style="width:400px; height:240px;"></div>
		<br>
		<a id="btn-place-order" style="display: none;">Place your order</a>
</div>';
  
  $code .= '<script type=\'text/javascript\'>
    window.onAmazonLoginReady = function () {
        amazon.Login.setClientId(\'' . $gatewayVariables['clientid'] . '\');
				amazon.Login.retrieveProfile(function (response) {
						// Display profile information.
						document.getElementById("helloMessage").innerHTML = "Hello, " + response.profile.Name + ".";
				});
    };
</script>';
  
  $code .= $endpointurl;
  
  $code .= '<script type="text/javascript">
		var orderReferenceId;
	  var enableOrderButton = function(orderReferenceId) {
		    var placeOrderBtn = document.getElementById("btn-place-order");
				placeOrderBtn.style.display = "block";
				placeOrderBtn.href = window.location.href + "&AmazonOrderReferenceId=" + orderReferenceId;
		};
	/* No need
    new OffAmazonPayments.Widgets.AddressBook({
        sellerId: \'' . $gatewayVariables['merchantid'] . '\',
        onOrderReferenceCreate: function (orderReference) {
           orderReferenceId = orderReference.getAmazonOrderReferenceId();
					 enableOrderButton(orderReferenceId);
		       //window.location = window.location.href + "&AmazonOrderReferenceId=" + orderReferenceId;
        },
        onAddressSelect: function () {
            // do stuff here like recalculate tax and/or shipping
        },
        design: {
            designMode: \'responsive\'
        },
        onError: function (error) {
            console.log(error.getErrorCode(),error.getErrorMessage());
            // your error handling code
        }
    }).bind("addressBookWidgetDiv");
  */
    new OffAmazonPayments.Widgets.Wallet({
        sellerId: \'' . $gatewayVariables['merchantid'] . '\',
				onOrderReferenceCreate: function (orderReference) {
           orderReferenceId = orderReference.getAmazonOrderReferenceId();
					 enableOrderButton(orderReferenceId);
        },
        onPaymentSelect: function (orderReference) {
           orderReferenceId = orderReference.getAmazonOrderReferenceId ? orderReference.getAmazonOrderReferenceId() : orderReferenceId;
					 enableOrderButton(orderReferenceId);
        },
        design: {
            designMode: \'responsive\'
        },
        onError: function (error) {
            console.log(error.getErrorCode(),error.getErrorMessage());
            // your error handling code
        }
    }).bind("walletWidgetDiv");
</script>';
  
  $code .= '</body></html>';
  
  if (!isset($_REQUEST['AmazonOrderReferenceId'])) {
    echo $code;
    exit();
  }
  
  
  $requestParameters       = array();
  $gAmazonOrderReferenceId = $_REQUEST['AmazonOrderReferenceId'];
  
  // Create the parameters array to set the order
  $requestParameters['amazon_order_reference_id'] = $gAmazonOrderReferenceId;
  $requestParameters['amount']                    = $invoiceDetails[1];
  $requestParameters['currency_code']             = 'USD';
  $requestParameters['seller_note']               = $invoiceDetails[2];
  $requestParameters['seller_order_id']           = $invoiceDetails[0];
  $requestParameters['store_name']                = $invoiceDetails[3];
  
  // Set the Order details by making the SetOrderReferenceDetails API call
  $response = $amazonClient->SetOrderReferenceDetails($requestParameters);
  
  // If the API call was a success Get the Order Details by making the GetOrderReferenceDetails API call
  if ($amazonClient->success) {
    $requestParameters['address_consent_token'] = null;
    $response                                   = $amazonClient->GetOrderReferenceDetails($requestParameters);
  }
  // Pretty print the Json and then echo it for the Ajax success to take in
  $json = json_decode($response->toJson());
  
  // Confirm the order by making the ConfirmOrderReference API call
  $response = $amazonClient->confirmOrderReference($requestParameters);
  
  $responsearray['confirm'] = json_decode($response->toJson());
  
  
  // If the API call was a success make the Authorize API call
  
  
  if ($amazonClient->success) {
    $requestParameters['authorization_amount']       = $invoiceDetails[1];
    $requestParameters['authorization_reference_id'] = md5($gAmazonOrderReferenceId);
    $requestParameters['seller_authorization_note']  = 'Authorizing payment';
    $requestParameters['capture_now']                = TRUE;
    $requestParameters['transaction_timeout']        = 1440; # 24 hours
		
    $response                   = $amazonClient->authorize($requestParameters);
    $responsearray['authorize'] = json_decode($response->toJson());
  }
  
  // Echo the Json encoded array for the Ajax success 
  $GATEWAY = getGatewayVariables($gatewaymodule);
  
  if (!$GATEWAY["type"])
    die("Module Not Activated"); # Checks gateway module is active before accepting callback
  
  # Get Returned Variables - Adjust for Post Variable Names from your Gateway's Documentation
  
  $responseCapture = json_decode($response->toJson(), true);
  
  $invoiceid = $invoiceDetails[0];
  $transid   = $gAmazonOrderReferenceId;
  $auth_status = $responseCapture['AuthorizeResult']['AuthorizationDetails']['AuthorizationStatus']['State'];
  
  $invoiceid = checkCbInvoiceID($invoiceid, $GATEWAY["name"]); # Checks invoice ID is a valid invoice number or ends processing
  
  checkCbTransID($transid); # Checks transaction number isn't already in the database and ends processing if it does
  
  if ($responseCapture["ResponseStatus"] == 200 && $auth_status == "Pending") {
    # Successful
    # addInvoicePayment($invoiceid, $transid, $amount, $fee, $gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
    logTransaction($GATEWAY["name"], $responseCapture, "Pending"); # Save to Gateway Log: name, data array, status
		echo "<p>Thank you! The transaction process has been initiated, please give us upto 24 hours. Once done, we will notify you.<br/>Sincerely, IPBurger.</p>";
    echo "<p><a href='" . $invoiceDetails[4] . "'>Click here to go back to your invoice.</a></p>";
  } else {
    # Unsuccessful
    logTransaction($GATEWAY["name"], $responseCapture, "Failed"); # Save to Gateway Log: name, data array, status
    echo "<p>There was an error processing your payment. Please try another payment method, or contact support.<br/>Sincerely, IPBurger.</p>";
    echo "<script type='text/javascript'>setTimeout(function() {window.location = '" . $invoiceDetails[4] . ";'}, 5000);</script>";
  }
}
session_destroy();
?>
