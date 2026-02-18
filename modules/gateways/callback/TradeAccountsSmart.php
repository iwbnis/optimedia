<?php

require_once __DIR__ . '/../../../init.php';
App::load_function('gateway');
App::load_function('invoice');
use WHMCS\Database\Capsule;

$gatewayModuleName = basename(__FILE__, '.php');

$gatewayParams = getGatewayVariables($gatewayModuleName);

if (!$gatewayParams['type']) {
    die("Module Not Activated");
}

$received = file_get_contents('php://input');
$data = json_decode( $received , true);

$secret_key = "9f2b7c4a1d8e6f0a3b5c7d2e1f4a6b8c";

if (!isset($data['key']) || $data['key'] !== $secret_key) {
    logTransaction($gatewayModuleName, $data, "Invalid Secret Key for Refund");
    header('HTTP/1.0 403 Forbidden');
    exit('Access denied.');
}

unset($data['key']);


$status = $data["refund_status"];
$invoiceId = $data["order_id"];
$transactionId = $data["transaction_id"];


$record = Capsule::table('gateway_TradeAccountsSmart')
    ->where('invoiceid', $invoiceId)
    ->where('refund_status', "PENDING")
    ->first();

$paymentAmount = $record->amount;


$clientId = Capsule::table('tblinvoices')
        ->where('id', $invoiceId)
        ->value('userid');

$currencyId = Capsule::table('tblclients')
    ->where('id', $clientId)
    ->value('currency');

$currency = Capsule::table('tblcurrencies')
    ->where('id', $currencyId)
    ->first();

$currencyCode = $currency->code;

$refundTransactionId = $transactionId . '-REFUND';

$invoiceId = checkCbInvoiceID($invoiceId, $gatewayParams['name']);

checkCbTransID($refundTransactionId);


if ($status == "ACCEPTED") {

    $command  = 'AddTransaction';
    $postData = [
        'paymentmethod' => $gatewayModuleName,
        'userid'        => $clientId,
        'transid'       => $refundTransactionId,
        'date'          => date("Y-m-d"),
        'description'   => 'Initiated by Admin',
        'amountin'      => $paymentAmount * -1,
        'invoiceid'     => $invoiceId
    ];

    $results = localAPI($command, $postData);

    if($results['result'] == 'success')
    {
        $command = 'UpdateInvoice';
        $postData = array(
            'invoiceid' => $invoiceId,
            'status' => 'Refunded',
        );

        $results = localAPI($command, $postData);
        
    }
    
    try {
    $updated = Capsule::table('gateway_TradeAccountsSmart')
        ->where('id', $record->id)
        ->update([
            'refund_status' => $status,
        ]);

  
} catch (\Exception $e) {
    logActivity( "Error updating refund record in gateway_TradeAccountsSmart table but refund was successful: " . $e->getMessage() , 0);
}

    logTransaction($gatewayModuleName, $data, "Refund Successful");

    echo "Refund processed successfully";

} 
