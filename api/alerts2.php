<?php

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

// Function to send an HTTP request to the WHMCS API
function whmcsApiRequest($action, $postData = array())
{
    global $whmcsUrl, $api_Identifier, $api_Secret;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array_merge($postData, array(
        'action' => $action,
        'identifier' => $api_Identifier,
        'secret' => $api_Secret,
    ))));

    $response = curl_exec($ch);
    if (curl_error($ch)) {
        die('Unable to connect to the WHMCS API: ' . curl_error($ch));
    }
    curl_close($ch);

    $responseData = json_decode($response, true);
    if ($responseData['result'] != 'success') {
        die('WHMCS API Error: ' . $responseData['message']);
    }

    return $responseData;
}

// Get client details
$clientID = 123; // Replace with the actual client ID
$clientDetails = whmcsApiRequest('getclientdetails', array(
    'clientid' => $clientID,
));

// Invoice Created
if ($clientDetails['result'] == 'success') {
    $invoiceCreatedMessage = "Hello " . $clientDetails['fullname'] . ",\n\n";
    $invoiceCreatedMessage .= "A new invoice has been created for you.";
    // Send the $invoiceCreatedMessage to the client's email address
    // or use any other desired method of notification
}

// Invoice Overdue
if ($clientDetails['result'] == 'success') {
    $invoiceOverdueMessage = "Hello " . $clientDetails['fullname'] . ",\n\n";
    $invoiceOverdueMessage .= "Your invoice with ID " . $invoiceID . " is now overdue.";
    // Send the $invoiceOverdueMessage to the client's email address
    // or use any other desired method of notification
}

// Payment Confirmation
if ($clientDetails['result'] == 'success') {
    $paymentConfirmationMessage = "Hello " . $clientDetails['fullname'] . ",\n\n";
    $paymentConfirmationMessage .= "Your payment for the invoice with ID " . $invoiceID . " has been received.";
    // Send the $paymentConfirmationMessage to the client's email address
    // or use any other desired method of notification
}

// Service Activation
if ($clientDetails['result'] == 'success') {
    // Retrieve service details using WHMCS API's 'GetClientsProducts' action
    // and find the relevant service information based on the clientID
    // Once you have the service details, you can compose the activation message
    // and send it to the client's email address or use any other desired method of notification
}

// Service Suspension
if ($clientDetails['result'] == 'success') {
    // Retrieve service details using WHMCS API's 'GetClientsProducts' action
    // and find the relevant service information based on the clientID
    // Once you have the service details, you can compose the suspension message
    // and send it to the client's email address or use any other desired method of notification
}

// Service Termination
if ($clientDetails['result'] == 'success') {
    // Retrieve service details using WHMCS API's 'GetClientsProducts' action
    // and find the relevant service information based on the clientID
    // Once you have the service details, you can compose the termination message
    // and send it to the client's email address or use any other desired method of notification
}

// Domain Renewal Reminder
if ($clientDetails['result'] == 'success') {
    // Retrieve domain details using WHMCS API's 'GetClientsDomains' action
    // and find the relevant domain information based on the clientID
    // Once you have the domain details, you can compose the renewal reminder message
    // and send it to the client's email address or use any other desired method of notification
}

// Domain Transfer Confirmation
if ($clientDetails['result'] == 'success') {
    // Retrieve domain details using WHMCS API's 'GetClientsDomains' action
    // and find the relevant domain information based on the clientID
    // Once you have the domain details, you can compose the transfer confirmation message
    // and send it to the client's email address or use any other desired method of notification
}

// Support Ticket Updates
if ($clientDetails['result'] == 'success') {
    // Retrieve ticket details using WHMCS API's 'GetTickets' action
    // and find the relevant ticket information based on the clientID
    // Once you have the ticket details, you can compose the updates message
    // and send it to the client's email address or use any other desired method of notification
}

// Account Information Change
if ($clientDetails['result'] == 'success') {
    $accountChangeMessage = "Hello " . $clientDetails['fullname'] . ",\n\n";
    $accountChangeMessage .= "There have been changes made to your account information.";
    // Send the $accountChangeMessage to the client's email address
    // or use any other desired method of notification
}
