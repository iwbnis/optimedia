<?php
require_once('AmazonPay/Client.php');

try {
  $gatewayVariables = getGatewayVariables('amazonpay');
  $varPresent       = 1;
}
catch (\Exception $e) {}

if (is_numeric($varPresent)) {
  
  $amazonConfig = array(
    'merchant_id' => $gatewayVariables['merchantid'],
    'access_key' => $gatewayVariables['accesskey'],
    'secret_key' => $gatewayVariables['secretkey'],
    'client_id' => $gatewayVariables['clientid'],
    'region' => $gatewayVariables['region']
  );
  
  $amazonClient = new AmazonPay\Client($amazonConfig);
  
  if ($gatewayVariables['sandbox'] == 'on') {
    $amazonClient->setSandbox(true);
  }
}

function amazonpay_config()
{
  $configarray = array(
    "FriendlyName" => array(
      "Type" => "System",
      "Value" => "Amazon Pay"
    ),
    "merchantid" => array(
      "FriendlyName" => "Merchant ID",
      "Type" => "text",
      "Size" => "20"
    ),
    "accesskey" => array(
      "FriendlyName" => "Access Key",
      "Type" => "text",
      "Size" => "20"
    ),
    "secretkey" => array(
      "FriendlyName" => "Secret Key",
      "Type" => "text",
      "Size" => "20"
    ),
    "clientid" => array(
      "FriendlyName" => "Client ID",
      "Type" => "text",
      "Size" => "20"
    ),
    "region" => array(
      "FriendlyName" => "Region",
      "Type" => "dropdown",
      "Options" => "us,uk,de,jp"
    ),
    "sandbox" => array(
      "FriendlyName" => "Test Mode",
      "Type" => "yesno",
      "Description" => "Enable sandbox"
    )
  );
  return $configarray;
}

function amazonpay_link($params)
{
  
  # Gateway Specific Variables
  $gatewaymerchantid       = $params['merchantid'];
  $gatewayaccesskey        = $params['accesskey'];
  $gatewaysecretkey        = $params['secretkey'];
  $gatewayclientid         = $params['clientid'];
  $gatewayallowedreturnurl = rtrim($params['systemurl'], '/') . '/modules/gateways/callback/amazonpay.php';
  $gatewaytestmode         = $params['testmode'];
  $gatewayendpointurl      = $params['endpointurl'];
  
  # Invoice Variables
  $invoiceid   = $params['invoiceid'];
  $description = $params["description"];
  $amount      = $params['amount']; # Format: ##.##
  $currency    = $params['currency']; # Currency Code
  
  # Client Variables
  $firstname = $params['clientdetails']['firstname'];
  $lastname  = $params['clientdetails']['lastname'];
  $email     = $params['clientdetails']['email'];
  $address1  = $params['clientdetails']['address1'];
  $address2  = $params['clientdetails']['address2'];
  $city      = $params['clientdetails']['city'];
  $state     = $params['clientdetails']['state'];
  $postcode  = $params['clientdetails']['postcode'];
  $country   = $params['clientdetails']['country'];
  $phone     = $params['clientdetails']['phonenumber'];
  
  # System Variables
  $companyname        = $params['companyname'];
  $currency           = $params['currency'];
  $returnToInvoiceUrl = rtrim($params['systemurl'], '/') . '/viewinvoice.php?id=' . $invoiceid;
  $transdetails       = urlencode(base64_encode($invoiceid . '::' . $amount . '::' . $description . '::' . $companyname . '::' . $returnToInvoiceUrl));
  
  $getGatewayVariables = getGatewayVariables('amazonpay');
  
  if (!$getGatewayVariables["type"])
    die("Module Not Activated");
  
  if ($getGatewayVariables['sandbox'] === 'on') {
    
    switch ($getGatewayVariables['region']) {
      case 'us':
        $endpointurl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js'></script>";
        break;
      
      case 'uk':
        $endpointurl = "<script type='text/javascript' src='https://static-eu.payments-amazon.com/OffAmazonPayments/uk/sandbox/lpa/js/Widgets.js'></script>";
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
  
  $code = '<div id="AmazonLoginButton"></div>';
  $code .= '<script type=\'text/javascript\'>
    window.onAmazonLoginReady = function () {
        amazon.Login.setClientId(\'' . $gatewayclientid . '\');
        amazon.Login.logout(); //we log out so every time user gets to choose explicitly which amazon account to use
    };
</script>';
  
  $code .= $endpointurl;
  $code .= '<script type=\'text/javascript\'>
    var authRequest;
    OffAmazonPayments.Button("AmazonLoginButton", "' . $gatewaymerchantid . '", {
        type: "PwA",
        color: "DarkGray",
        popup: false,
        authorization: function () {
            loginOptions = { scope: "profile postal_code payments:widget payments:shipping_address", popup: true };
            authRequest = amazon.Login.authorize(loginOptions, "' . $gatewayallowedreturnurl . '?trd=' . $transdetails . '");
        },
        onError: function (error) {
            // something bad happened
        }
    });
</script>';
  
  return $code;
}

?>
