<?php
header('Content-Type: application/json; charset=utf-8');

require '/var/www/html/init.php';
use WHMCS\Database\Capsule;

$whmcsUrl = "http://192.168.61.3/";

$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$clientId = $_POST['clientid'];


if (!isset($clientId))
{
die('please post all required data');
}

$randomNum = substr(str_shuffle("0123456789"), 0, 4);
$getClientId = Capsule::table('tblverification')->where('user_id', $clientId)->first();

if (!isset($getClientId->id))
{
   $res->success = false;
    $res->data = 'clientid not found';
   die(json_encode($res));
}

if ($getClientId->verified == 1)
{
   $res->success = false;
    $res->data = 'This client already activated';
   die(json_encode($res));
}

$updateOtp = Capsule::table('tblverification')->where('id', $getClientId->id)->update(
            [
                'otp' => $randomNum,
            ]
        );

$postfields1 = array(
    'identifier' => $api_Identifier,
    'secret' => $api_Secret,
    'action' => 'SendEmail',
    'clientid' =>  $clientId,
    'messagename' => 'Otp Email',
    'id' => $clientId,
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

    $res->success = true;
    $res->data = 'done';
    print_r(json_encode($res));
?>
