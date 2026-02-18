<?php

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$clientid = $_POST['client_id'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClientsDetails',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $clientid,
            'clientid' => '72359',
            'pid' => array(250),
          //  'domain' => array('domain1.com', 'dómáin2.com'),
          //  'idnlanguage' => array('', 'fre'),
         //   'billingcycle' => array('monthly','semiannually'),
         //   'addons' => array('1,3,9', ''),
          //  'customfields' => array(base64_encode(serialize(array("1" => "Google"))), base64_encode(serialize(array("1" => "Google")))),
         //   'configoptions' => array(base64_encode(serialize(array("1" => 999))), base64_encode(serialize(array("1" => 999)))),
           // 'domaintype' => array('register', 'register'),
          //  'regperiod' => array(1, 2),
         //   'dnsmanagement' => array(0 => false, 1 => true),
         //   'nameserver1' => 'ns1.demo.com',
         //   'nameserver2' => 'ns2.demo.com',
            'paymentmethod' => 'credit card',
         //   'servicerenewals' => array(3,10),
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

