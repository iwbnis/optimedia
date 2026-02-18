<?php
header('Content-Type: application/json; charset=utf-8');

require '/var/www/html/init.php';
use WHMCS\Database\Capsule;

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
    'address2' => $_POST['address2'],
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

if (isset($jsonData['clientid']) && $jsonData['result'] == 'success')
{
    $updateClientVerified = Capsule::table('tblclients')
                 ->where('id', $jsonData['clientid'])
                 ->update(
                   [
                      'email_verified' => 2,
                   ]
                   );

$randomNum = substr(str_shuffle("0123456789"), 0, 4);

   Capsule::table('tblverification')
		->insert([
		        'user_id'      => $jsonData['clientid'],
			'email'	       => $_POST['email'],
		        'otp'          => $randomNum,
		        'verified'   => 0,
    ]);


$postfields1 = array(
    'identifier' => $api_Identifier,
    'secret' => $api_Secret,
    'action' => 'SendEmail',
    'clientid' =>  $jsonData['clientid'],
    'messagename' => 'Otp Email',
    'id' => $jsonData['clientid'],
    'customtype' => 'general',
    'customsubject' => 'Your verification OTP code',
    'custommessage' => '<p>Thank you for choosing us,</p><p>Your activation code is: <b> '.$randomNum.' </b></p><br /><br /><p>{$signature}</p> <p>You are receiving this email because you recently created an account. If you did not do this, please contact us.</p>',
    'responsetype' => 'json',
);

$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch1, CURLOPT_POST, 1);
curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($postfields1));
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

$response1 = curl_exec($ch1);


curl_close($ch);


$jsonResponse = json_encode($jsonData);
echo $jsonResponse;
}
else
{
die($response);
}
?>
