<?php
header('Content-Type: application/json; charset=utf-8');

require '/var/www/html/init.php';
use WHMCS\Database\Capsule;

$whmcsUrl = 'http://192.168.61.3/';
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$email = $_POST['email'];
$password = $_POST['password2'];
$postfields = array(
    'action' => 'ValidateLogin',
    'identifier' => $api_Identifier,
    'secret' => $api_Secret,
    'email' => $email,
    'password2' => $password,
    'responsetype' => 'json',
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);


if ($result['result'] === 'success') {

$isVerified = Capsule::table("tblclients")->where("email", "=", $email)->first();	

if ($isVerified->email_verified == 2)
{
   $res->success = true;
    $res->isVerified = false;
    $res->clientid = $isVerified->id;
   die(json_encode($res));
}

    $getuserpostfields = array(
        'action' => 'GetUsers',
        'identifier' => $api_Identifier,
        'secret' => $api_Secret,
        'search' => $email,
        'responsetype' => 'json',
    );

    $ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch1, CURLOPT_POST, 1);
curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($getuserpostfields));
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

$response1 = curl_exec($ch1);
curl_close($ch1);

$result1 = json_decode($response1, true);

$useridarray = $result1['users'][0]['clients'];
$responsearray = array();
$clientid  = 0;
 if (count($useridarray) === 1)
 {
    $clientid = $result1['users'][0]['clients'][0]['id'];

    $clientDetailsPostfields = array(
        'action' => 'GetClientsDetails',
        'identifier' => $api_Identifier,
        'secret' => $api_Secret,
        'clientid' => $clientid,
        'stats' => true,
        'responsetype' => 'json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($clientDetailsPostfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);

    // Decode response
    $jsonData = json_decode($response, true);
    array_push($responsearray, $jsonData);

 }

 elseif (count($useridarray) > 1)
 {
    foreach ($useridarray as $value) {
        $clientid = $value['id'];
        $clientDetailsPostfields = array(
            'action' => 'GetClientsDetails',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $clientid,
            'stats' => true,
            'responsetype' => 'json',
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($clientDetailsPostfields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        // Decode response
        $jsonData = json_decode($response, true);
        array_push($responsearray, $jsonData);
      }
 }
    // echo "Login credentials are valid." . PHP_EOL;

    // Use the obtained client ID for the next API call

    $prettyJson = json_encode($responsearray, JSON_PRETTY_PRINT);
    
    echo $prettyJson;

} else {
    $errorMessage = $result['message'];
	echo "API Response: " . $response . PHP_EOL;
    echo "Invalid login credentials. Error: $errorMessage" . PHP_EOL;
}
?>
