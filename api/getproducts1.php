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
$jsonReponse = array();
$responseObj = new stdClass();
if (isset($jsonData['products']) && isset($jsonData['products']['product'])) {
    foreach ($jsonData['products']['product'] as $product) {
        if (isset($product['name'])) {
            $productName = preg_replace('/\s*\([^)]*\)\s*/', '', $product['name']);

            preg_match('/\b\d+\s+Months?\b/i', $product['name'], $matches);
            $duration = isset($matches[0]) ? $matches[0] : '';
	    $responsePricing = new stdClass();
	    foreach ($product['pricing'] as $priceKey => $priceValue) {
		if ((int)$priceValue['monthly'] > 0 || (int)$priceValue['quarterly'] > 0 || (int)$priceValue['semiannually'] > 0 || (int)$priceValue['annually'] > 0 || (int)$priceValue['biennially'] > 0 || (int)$priceValue['triennially'] > 0 )
		{
			$responsePricing -> $priceKey = new stdClass();
			foreach ($priceValue as $key => $value)
			{
				if ((int)$value > 0)
				{
					 $responsePricing -> $priceKey -> $key = $value;
				}
			}
		}
		}
		if (isset($responsePricing->CAD) || isset($responsePricing->USD)) {
		      $formattedProductData[] = array(
                'pid' => $product['pid'],
               	'gid'=> $product['gid'],
                'type' => $product['type'],
                'duration' => $duration,
                'name' => $product['name'],
                'description' => $product['description'],
                'product_url' => $product['product_url'],
                'paytype' => $product['paytype'],
		'pricing' => $responsePricing,
            );
		}
        }
    }
}

// Convert the formatted product data array to JSON
//$formattedProductDataJson = json_encode($formattedProductData);
$responseObj -> result = $jsonData['result'];
$responseObj ->	totalresults = $jsonData['totalresults'];
$responseObj -> products = $formattedProductData;
$formarttedRespoinseObjJson = json_encode($responseObj);

header('Content-type: application/json');

// Print the formatted product data JSON
//echo $formattedProductDataJson;
echo $formarttedRespoinseObjJson;
// Print the full response
//echo $response;
?>
