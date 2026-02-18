<?php
$whmcsUrl = "http://192.168.61.3/";

$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';


$randomNum = 1234;
$postfields1 = array(
    'identifier' => $api_Identifier,
    'secret' => $api_Secret,
    'action' => 'SendEmail',
    'clientid' =>  72204,
    'messagename' => 'Otp Email',
    'id' => 72204,
    'customtype' => 'general',
    'customsubject' => 'Your verification OTP code',
    'custommessage' => '<p>Thank you for choosing us,</p><p>Your activation code is: <b> ' .$randomNum.' </b></p>',
    'responsetype' => 'json',
);
print_r($postfields1);	

$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch1, CURLOPT_POST, 1);
curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($postfields1));
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

$response1 = curl_exec($ch1);

curl_close($ch);

print_r($response1);
