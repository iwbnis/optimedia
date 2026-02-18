<?php

// Include the WHMCS Init file if it's not already included
if (!defined("WHMCS")) {
    require_once("init.php");
}

use WHMCS\Database\Capsule;

try {
    // Set the criteria columns
    $subjectColumn = 'title';
    $clientColumn = 'userid';

    // Retrieve all support tickets
    $tickets = Capsule::table('tbltickets')
        ->select('tid', $subjectColumn, $clientColumn)
        ->get();

    // Create an array to track seen combinations of subject and user ID
    $seenCombinations = [];

    foreach ($tickets as $ticket) {
        $ticketId = $ticket->tid;
        $subjectValue = $ticket->{$subjectColumn};
        $clientValue = $ticket->{$clientColumn};

        // Create a unique identifier for the ticket based on subject and client
        $identifier = $subjectValue . '-' . $clientValue;

        // Check if this combination has been seen before
        if (in_array($identifier, $seenCombinations)) {
            // Delete the duplicate ticket
            Capsule::table('tbltickets')->where('tid', $ticketId)->delete();
            echo "Duplicate ticket ID {$ticketId} deleted.\n";
        } else {
            // Mark this combination as seen
            $seenCombinations[] = $identifier;
        }
    }

    echo "Duplicate cleanup completed.\n";
} catch (Exception $e) {
    // Handle any exceptions that occur
    echo "An error occurred: " . $e->getMessage() . "\n";
}
