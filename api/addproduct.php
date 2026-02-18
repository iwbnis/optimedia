<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'AddProduct',
            // See https://developers.whmcs.com/api/authentication
           'identifier' => $api_Identifier,
             'secret' => $api_Secret,
            'type' => 'other',
            'gid' => '1',
            'name' => 'Sample Product',
            'paytype' => 'recurring',
            'pricing' => array(1 => array('monthly' => 1.00, 'msetupfee' => 1.99, 'quarterly' => 2.00, 'qsetupfee' => 1.99, 'semiannually' => 3.00, 'ssetupfee' => 1.99, 'annually' => 4.00, 'asetupfee' => 1.99, 'biennially' => 5.00, 'bsetupfee' => 1.99, 'triennially' => 6.00, 'tsetupfee' => 1.99)),
            'recommendations' => array(array('id' => 1, 'order' => 0), array('id' => 2, 'order' => 1)),
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
// Decode response
$jsonData = json_decode($response, true);
$jsonResponse = json_encode($jsonData);
// Dump array structure for inspection
// var_dump($jsonData);
echo $jsonResponse;

?>