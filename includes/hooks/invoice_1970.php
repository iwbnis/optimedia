<?php
use WHMCS\Database\Capsule;

add_hook('InvoiceCreated', 1, function($vars) {
    // Define the target year as an integer (1970)
    $targetYear = 1970;

    // Get the newly created invoice ID
    $invoiceId = $vars['invoiceid'];

    // Retrieve the invoice details
    $invoice = Capsule::table('tblinvoices')
        ->where('id', $invoiceId)
        ->first();

    // Check if the invoice is unpaid and has a due date in 1970
    if ($invoice && $invoice->status === 'Unpaid') {
        // Extract the year part of the due date
        $dueDateYear = (int) date('Y', strtotime($invoice->duedate));

        // Check if the year matches the target year (1970)
        if ($dueDateYear === $targetYear) {
            // Delete the invoice
            Capsule::table('tblinvoices')->where('id', $invoiceId)->delete();
            logActivity("Deleted Invoice #" . $invoiceId . " with due date: " . $invoice->duedate);
        }
    }
	$userId = $invoice->userid;
	$ch = curl_init( "https://apihubs.cc/push" );
	$payload = json_encode( array( "clientid" => $userId, "title" => "Your new invoice is ready for review. Please check and process. Thank you!", "message" => "Your new invoice is ready for review. Please check and process. Thank you!") );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'token: NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP'));
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	curl_close($ch);
	
});
?>
