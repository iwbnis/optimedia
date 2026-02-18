<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$ticketId = $_POST['ticketid'];
$message = $_POST['message'];
$clientid = $_POST['clientid'];

// Prepare the attachment
$attachmentName = 'sample_text_file.txt';
$attachmentContent = 'This is a sample text file contents';
$attachmentData = base64_encode($attachmentContent);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,

    http_build_query(
        array(
            'action' => 'AddTicketNote', // Use AddTicketNote instead of AddTicketReply
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'ticketid' => $ticketId,
            'message' => $message,
            'clientid' => $clientid,
            'customfields' => base64_encode(serialize(array("1" => "Google"))),
            'markdown' => true,
            'attachments' => base64_encode(json_encode([['name' => $attachmentName, 'data' => $attachmentData]])),
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
$jsonData = json_decode($response, true);
$jsonResponse = json_encode($jsonData);

echo $jsonResponse;
?>
