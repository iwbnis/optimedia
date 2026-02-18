<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

// Define input variables from another API
$orderid = $_POST['order_id'];
$paymentmethod = $_POST['paymentmethod_id'];
$newproductbillingcycle = $_POST['newproductbillingcycle_id'];
$newproductid = $_POST['newproduct_id'];
//$configoptions = $_POST['configoptions_id'];
$clientid = $_POST['client_id'];
$productid = $_POST['product_id'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'UpgradeProduct',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'responsetype' => 'json',
            'orderid' => $orderid, 
            'productid' => $productid, 
            'paymentmethod' => $paymentmethod, 
            'newproductbillingcycle' => $newproductbillingcycle, 
            'type' => 'product',
            'newproductid' => $newproductid, 
            //'configoptions' => json_encode($configoptions), 
            'clientid' => $clientid,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Output the JSON response in a pretty format
if ($response) {
    $decodedResponse = json_decode($response, true);
    if ($decodedResponse !== null) {
        $jsonResponse = json_encode($decodedResponse, JSON_PRETTY_PRINT);
        header("Content-Type: application/json");
        echo $jsonResponse;
    } else {
        echo "Invalid JSON response from WHMCS API.";
    }
} else {
    echo "No response from WHMCS API.";
}
?>
