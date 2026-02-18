<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

add_hook('ClientAreaPage', 1, function($vars) {
    // Fetch columns from the tblpaymentgateways table
    $columns = Capsule::schema()->getColumnListing('tblpaymentgateways');

    // Check if the 'gateway' column exists in the table
    if (in_array('gateway', $columns)) {
        // Fetch the values of the 'gateway' column
        $gatewayValues = Capsule::table('tblpaymentgateways')->pluck('gateway');

        // Check if 'StripeSmart', 'AirWallexRouterHosted', and 'Interac' are present in the 'gateway' column values
        $isStripeSmart = in_array('StripeSmart', $gatewayValues);
        $isAirWallexRouterHosted = in_array('AirWallexRouterHosted', $gatewayValues);
        $isInterac = in_array('Interac', $gatewayValues);

        // Assign Smarty tags to indicate the presence of 'StripeSmart', 'AirWallexRouterHosted', and 'Interac'
        return [
            'isStripeSmart' => $isStripeSmart,
            'isAirWallexRouterHosted' => $isAirWallexRouterHosted,
            'isInterac' => $isInterac,
        ];
    }

    return [];
});
