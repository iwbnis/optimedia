<?php

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$clientid = $_POST['client_id'];
$message=$_POST['message'];
$subject=$_POST['subject'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'OpenTicket',
             'identifier' => $api_Identifier,
        	'secret' => $api_Secret,
            'deptid' => '1',
            'subject' => $subject,
            'message' => $message,
            'clientid' => $clientid,
          //  'userid'=>$clientid,
            'markdown' => true,
            'attachments' => base64_encode(json_encode([['name' => 'sample_text_file.txt', 'data' => base64_encode('This is a sample text file contents')]])),
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode response
$jsonData = json_decode($response, true);
  $prettyJson = json_encode($jsonData, JSON_PRETTY_PRINT);
    echo $prettyJson;
// Dump array structure for inspection
// var_dump($jsonData);

