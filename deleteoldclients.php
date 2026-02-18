<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/init.php';

use WHMCS\Database\Capsule;

function deleteInactiveClients() {
    $inactiveStatuses = array('Inactive', 'Closed'); // Define the account statuses to consider as inactive

    $clientsToDelete = Capsule::table('tblclients')
        ->whereIn('status', $inactiveStatuses)
        ->get();

    foreach ($clientsToDelete as $client) {
        // Delete the client's emails
        Capsule::table('tblemails')->where('userid', $client->id)->delete();
        
        // Delete the client's orders and invoices
        Capsule::table('tblorders')->where('userid', $client->id)->delete();
        Capsule::table('tblinvoices')->where('userid', $client->id)->delete();

        // Delete the client
        Capsule::table('tblclients')
            ->where('id', $client->id)
            ->delete();
    }

    echo count($clientsToDelete) . " clients deleted.\n";
}

// Call the function to delete inactive clients
deleteInactiveClients();
