<?php
use WHMCS\Database\Capsule;

add_hook('AddInvoicePayment', 1, function($vars) {
    
    // Remove </a> tags from tblhosting's dedicatedip column
    function removeClosingATags() {
        try {
            // Get all hosting entries with dedicatedip containing </a> tags
            $ipsWithClosingATag = Capsule::table('tblhosting')
                ->where('dedicatedip', 'LIKE', '%</a>%')
                ->get();

            foreach ($ipsWithClosingATag as $hostingEntry) {
                $newIP = str_replace('</a>', '', $hostingEntry->dedicatedip);
                Capsule::table('tblhosting')
                    ->where('id', $hostingEntry->id)
                    ->update(['dedicatedip' => $newIP]);
            }

            logActivity('Removed </a> tags from tblhosting\'s dedicatedip column successfully.');

        } catch (\Exception $e) {
            logActivity('Error removing </a> tags from tblhosting\'s dedicatedip: ' . $e->getMessage());
        }
    }

    // Execute the removal function
    removeClosingATags();

});
