<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$invoiceid = $_POST['invoiceid'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetInvoice',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'invoiceid' => $invoiceid,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetCurrencies',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
$response2 = curl_exec($ch2);
curl_close($ch2);

// Decode response
$jsonData = json_decode($response, true);

$jsonData2 = json_decode($response2, true);

if (isset($jsonData['items']['item'][0]['description'])) {
    $jsonData['items']['item'][0]['description'] = str_replace('<br>', '', $jsonData['items']['item'][0]['description']);
}

if (isset($jsonData['userid']))
{
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch1, CURLOPT_POST, 1);
curl_setopt($ch1, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClientsDetails',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $jsonData['userid'],
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
$response1 = curl_exec($ch1);
curl_close($ch1);
}
$jsonData1 = json_decode($response1, true);
foreach ($jsonData2['currencies']['currency'] as $crcy) {
  if ($crcy['id'] == $jsonData1['currency'])
{
	$jsonData['subtotal'] = "{$crcy['prefix']}{$jsonData['subtotal']}";
        $jsonData['credit'] = "{$crcy['prefix']}{$jsonData['credit']}";
        $jsonData['tax2'] = "{$crcy['prefix']}{$jsonData['tax2']}";
        $jsonData['tax'] = "{$crcy['prefix']}{$jsonData['tax']}";
        $jsonData['total'] = "{$crcy['prefix']}{$jsonData['total']}";
        $jsonData['balance'] = "{$crcy['prefix']}{$jsonData['balance']}";
        $jsonData['taxrate'] = "{$crcy['prefix']}{$jsonData['taxrate']}";
        $jsonData['taxrate2'] = "{$crcy['prefix']}{$jsonData['taxrate2']}";
if (isset($jsonData['items']['item'][0]['description'])) {
    $jsonData['items']['item'][0]['amount'] = "{$crcy['prefix']}{$jsonData['items']['item'][0]['amount']}";
}
}
}
$jsonResponse = json_encode($jsonData);
//print_r($jsonData2);
header('Content-Type: application/json');
echo $jsonResponse;
?>
