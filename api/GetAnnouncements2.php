<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
    array(
        'action' => 'GetAnnouncements',
        'identifier' => $api_Identifier,
        'secret' => $api_Secret,
        'responsetype' => 'json',
    )
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

// Function to remove HTML tags and decode HTML entities from a string
function clean_html_string($string) {
    $string = strip_tags($string); // Remove HTML tags
    $string = html_entity_decode($string); // Decode HTML entities
    return $string;
}

// Remove HTML tags and decode HTML entities from the "announcement" parameter
if (isset($responseData['announcement'])) {
    $responseData['announcement'] = clean_html_string($responseData['announcement']);
}

// Prepare the response as an associative array
$result = array(
    'response' => $responseData, // Updated response data
);

// Set the content type to JSON and output the result as a formatted JSON string
header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
?>
