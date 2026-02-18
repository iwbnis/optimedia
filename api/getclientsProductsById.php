<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$clientid = $_POST['client_id'];
$orderid = $_POST['order_id']; // Get the order_id from the POST data
$upgradableId = [ 250, 261, 249, 265, 260, 251, 262, 252, 266, 253, 254, 263, 255, 267, 256, 257,
  264, 258, 268, 259, 38, 73, 37, 164, 53, 40, 74, 41, 206, 42, 43, 75, 44, 247,
  45, 46, 76, 47, 248, 48, 128, 278, 129, 289, 130, 179, 280, 180, 281, 181,
  182, 282, 183, 283, 291, 284, 285, 286, 287, 184, 118, 269, 119, 270, 120,
  121, 271, 122, 272, 123, 292, 273, 126, 125, 127, 274, 275, 276, 277, 288,
  227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241,
  242, 243, 244, 245, 246, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216,
  217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 293, 294, 300, 301, 302,
  303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317,
  295, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332,
  333, 334, 335, 336, 337, 296, 338, 339, 340, 341, 342, 343, 344, 345, 346,
  347, 348, 349, 350, 351, 352, 353, 354, 355, 356, 297, 357, 358, 359, 360,
  361, 362, 363, 364, 365, 366, 367, 368, 369, 370, 371, 372, 373, 374, 375,
  199, 394, 432, 435, 436, 437, 438, 439, 440, 441, 442, 443, 444, 445, 446,
  447, 448, 454, 451, 455, 395, 392, 396, 397, 398, 399, 400, 401, 402, 403,
  404, 405, 406, 407, 408, 409, 410, 411, 412, 413 ];


use WHMCS\Database\Capsule;

require '../init.php';

$categories = Capsule::table('tblproductgroups')
    ->select('id', 'name', 'order', 'hidden', 'headline', 'tagline')
    ->orderBy('order', 'asc')
    ->get()
    ->keyBy('id');


$ch = curl_init();
$ch1 = curl_init();
$ch2 = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch1, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch2, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch1, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClientsProducts',
            'clientid' => $clientid,
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

curl_setopt($ch2, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetInvoices',
            'userid' => $clientid,
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
$responseResult = array (
		"result" => $jsonData['result'],
    		"clientid" => $jsonData['clientid'],
    		"serviceid" => $jsonData['serviceid'],
    		"pid" => $jsonData['pid'],
    		"domain" => $jsonData['domain'],
		"products" => array ( "product" => [] ),
		);

foreach ($jsonData['products']['product'] as $x) {
  if ($x['orderid'] == $orderid)
{
	array_push($responseResult['products']['product'], $x);
}
}
foreach ($responseResult['products']['product'] as $y => $item) {
	$responseResult['products']['product'][$y]['serviceid'] = $responseResult['products']['product'][$y]['id'];
	curl_setopt($ch1, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetProducts',
            'pid' =>  $responseResult['products']['product'][$y]['pid'],
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
$response1 = curl_exec($ch1);
$jsonData1 = json_decode($response1, true);
$responseResult['products']['product'][$y]['gid'] = $jsonData1['products']['product'][0]['gid'];
$responseResult['products']['product'][$y]['description'] = trim(preg_replace('/\s+/', ' ', strip_tags($jsonData1['products']['product'][0]['description'])));
//$responseResult['products']['product'][$y]['productprice'] = $jsonData1['products']['product'][0]['recurringamount'];
//$responseResult['products']['product'][$y]['productprice1'] = $jsonData1['products']['product'][0]['recurringamount'].' '.
        if (in_array($responseResult['products']['product'][$y]['pid'], $upgradableId, true)) {
        $responseResult['products']['product'][$y]['upgradable'] = 1;
        }
$currentcies = Capsule::table('tblinvoiceitems') -> leftJoin('tblhosting', 'tblinvoiceitems.relid', '=', 'tblhosting.id') -> leftJoin('tblinvoices', 'tblinvoices.id', '=', 'tblinvoiceitems.invoiceid') -> where('tblinvoiceitems.relid', $responseResult['products']['product'][$y]['id']) ->orderBy('tblinvoiceitems.invoiceid', 'DESC') ->first();
foreach ($categories as $a =>  $items1) {
	if ($items1 -> id == $responseResult['products']['product'][$y]['gid'])
{
	$responseResult['products']['product'][$y]['category_name'] = $items1->name;
        $responseResult['products']['product'][$y]['category_tagline'] = $items1->tagline;
        $responseResult['products']['product'][$y]['category_headline'] = $items1->headline;
}
foreach ($jsonData2['invoices']['invoice'] as $b => $items2) {
	if ($items2['id'] == $currentcies->invoiceid)
{
	$responseResult['products']['product'][$y]['currencycode'] = $items2['currencycode'];
	$responseResult['products']['product'][$y]['productprice1'] = $currentcies->amount.' '. $items2['currencycode'].' '.$responseResult['products']['product'][$y]['billingcycle'];
	$responseResult['products']['product'][$y]['productprice'] = $currentcies->amount;
}
}
}
}
// Encode the JSON data with pretty-print option
$jsonResponse = json_encode($responseResult, JSON_PRETTY_PRINT);
header("Content-Type: application/json");
echo $jsonResponse;
?>
