<?php
use WHMCS\Database\Capsule;

add_hook('ClientAreaPage', 1, function ($vars) {
    // Check if the client is logged in and on the clientarea.php page
    if ($vars['filename'] == 'clientarea' && $vars['action'] == '') {
        // Get the client ID
        $clientId = (int) $_SESSION['uid'];

        // Query the database to get the client's credit balance
        $client = Capsule::table('tblclients')
            ->where('id', $clientId)
            ->first();

        // Check if the client exists and has a credit balance
        if ($client) {
            $creditBalance = $client->credit;
            // Format the credit balance as currency (you can customize this as needed)
            $formattedCreditBalance = formatCurrency($creditBalance);

            // Assign the credit balance to a Smarty variable
            $vars['credit_balance'] = $formattedCreditBalance;
        }
    }
});
