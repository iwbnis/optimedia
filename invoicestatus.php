<?php
header('Content-Type: application/json; charset=utf-8');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header('HTTP/1.1 200 OK');
  exit();
}
$key = 'Vq5frG6JcNEkPgbp9SWDhCvjRnsFYaxX';
$ciphering = "AES-256-CBC";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '5334567891011121';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data))
{
   $invoiceId = $data['invoiceId'];
   $token = $data['token'];
if (empty( $invoiceId ) || empty($token))
{
 $response = [ 'success' => false, 'data' => 'please post all required data' ];
 http_response_code(400);
echo json_encode($response);
}
else
{
$encryptedInvoiceId = openssl_encrypt($invoiceId, $ciphering, $key, $options, $encryption_iv);
if ($token !== $encryptedInvoiceId)
{
die(json_encode([ 'success' => false, 'data' => 'Token mismatched']));
}
else
{
	$headers = array();
	$headers[] = "Accept: application/json";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://apihubs.cc/payment_status?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&invoiceid=".$invoiceId);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	echo $result;
}
}
} else {
 $response = [ 'success' => false, 'data' => 'please post all required data' ];
 http_response_code(400);
echo json_encode($response);
}



?>
