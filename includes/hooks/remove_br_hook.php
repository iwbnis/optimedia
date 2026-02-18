<?php
use WHMCS\Database\Capsule;

add_hook('AfterShoppingCartCheckout', 2, function ($vars) {
    // Delay for 5 seconds
    sleep(5);

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

            logActivity('Removed <br> tags successfully.'); // Using logActivity instead of echo

        } catch (\Exception $e) {
            logActivity('Error removing <br> tags: ' . $e->getMessage()); // Logging the error instead of echoing
        }
    }

    // Call the function to remove <br> tags
    removeBrTagsFromInvoiceItems();
});
