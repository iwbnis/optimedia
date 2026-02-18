<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$postfields = array(
    'identifier' => $api_Identifier,
    'secret' => $api_Secret,
    'action' => 'AddClient',
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'companyname'=> $_POST['companyname'],
    'email' => $_POST['email'],
    'address1' => $_POST['address'],
   /* 'address2' => $_POST['address2'],*/
    'city' => $_POST['city'],
    'state' => $_POST['state'],
    'postcode' => $_POST['postcode'],
    'country' => $_POST['country'],
    'phonenumber' => $_POST['phonenumber'],
    'password2' => $_POST['password2'],
    'clientip' => $_SERVER['REMOTE_ADDR'],
    'responsetype' => 'json',
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);

$jsonData = json_decode($response, true);
$jsonResponse = json_encode($jsonData);
echo $jsonResponse;
?>
