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
            'action' => 'TriggerNotificationEvent',
            // See https://developers.whmcs.com/api/authentication
            'identifier' => $api_Identifier,
             'secret' => $api_Secret,
            'title' => $_POST['title'],
            'message' => $_POST['message'],
            'notification_identifier' => $_POST['notification_identifier'],
            // 'url' => $_POST['url'],
            // 'status' => $_POST['status'],
            // 'statusStyle' => $_POST['statusStyle'],
            // 'attributes[0][label]' => $_POST['label'],
            // 'attributes[0][value]' => $_POST['value'],
            // 'attributes[0][url]' => $_POST['attribute_url'],
            // 'attributes[0][style]' => $_POST['attribute_style'],
            // 'attributes[0][icon]' => $_POST['attribute_icon'],
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