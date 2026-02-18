<?php
header('Content-Type: application/json; charset=utf-8');

require '/var/www/html/init.php';
use WHMCS\Database\Capsule;


$clientId = $_POST['clientid'];
$otp = $_POST['otp'];

if (!isset($clientId) || !isset($otp))
{
die('please post all required data');
}

$storedOtp = Capsule::table("tblverification")->where("user_id", "=", $clientId)->first();
if ($storedOtp->otp != $otp)
{
   $res->success = false;
    $res->data = 'OTP missmatched';
   die(json_encode($res));
}
else
{
    $updateClientVerified = Capsule::table('tblclients')
                 ->where('id', $clientId)
                 ->update(
                   [
                      'email_verified' => 1,
                   ]
                   );

   $updateClientVerified1 = Capsule::table('tblverification')
                 ->where('user_id', $clientId)
                 ->update(
                   [
                      'verified' => 1,
                   ]
                   );
   $res->success = success;
    $res->data = 'account activated';
print_r(json_encode($res));
}
?>
