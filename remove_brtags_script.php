<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use WHMCS\Database\Capsule;

// Define the function to remove <br> tags
function removeBrTagsFromInvoiceItems() {
    try {
        // Get all invoice items with descriptions containing <br> tags
        $itemsWithBr = Capsule::table('tblinvoiceitems')
            ->where('description', 'LIKE', '%<br>%')
            ->get();

        foreach ($itemsWithBr as $item) {
            $newDescription = str_replace('<br>', '', $item->description);
            Capsule::table('tblinvoiceitems')
                ->where('id', $item->id)
                ->update(['description' => $newDescription]);
        }

        echo 'Removed <br> tags successfully.';
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Include WHMCS configuration and initialize database connection
require __DIR__ . '/init.php';

// Call the function to remove <br> tags
removeBrTagsFromInvoiceItems();
?>
