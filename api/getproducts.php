<?php
$whmcsUrl = "http://192.168.61.3/";

$api_identifier = "RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw";
$api_secret = "lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM";

// Set post values
$postfields = array(
    'identifier' => $api_identifier,
    'secret' => $api_secret,
    'action' => 'GetProducts',
    'responsetype' => 'json',
);

// Call the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
$response = curl_exec($ch);
if (curl_error($ch)) {
    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
}
curl_close($ch);

$jsonData = json_decode($response, true);


$formattedProductData = array();

if (isset($jsonData['products']) && isset($jsonData['products']['product'])) {
    foreach ($jsonData['products']['product'] as $product) {
        if (isset($product['name'])) {
            $productName = preg_replace('/\s*\([^)]*\)\s*/', '', $product['name']);

            preg_match('/\b\d+\s+Months?\b/i', $product['name'], $matches);
            $duration = isset($matches[0]) ? $matches[0] : '';

            $formattedProductData[] = array(
                'pid' => $product['pid'],
                'gid'=> $product['gid'],
                'duration' => $duration,
            );
        }
    }
}

// Convert the formatted product data array to JSON
$formattedProductDataJson = json_encode($formattedProductData);

// Print the formatted product data JSON
echo $formattedProductDataJson;

// Print the full response
echo $response;
?>
