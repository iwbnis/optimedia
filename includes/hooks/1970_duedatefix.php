<?php
use WHMCS\Database\Capsule;

add_hook("InvoicePaid", 1, function($vars) {
    try {
        // Define an associative array to map billing cycle names to values
        $billingCycles = [
            'monthly' => 1,
            'quarterly' => 3,
            'semi-annually' => 6,
            'annually' => 12,
            'biannually' => 24,
            'triannually' => 36,
        ];

        // Fetch data from tblhosting with nextduedate in year 1970
        $hostingData = Capsule::table('tblhosting')
            ->select('id', 'userid', 'orderid', 'nextduedate', 'billingcycle', 'domainstatus') // Include domainstatus
            ->whereYear('nextduedate', '=', 1970)
            ->get();

        // Initialize an array to store the results
        $result = [];

        // Get today's date in the same format as nextduedatefix
        $todayDate = date('Y-m-d');

        // Loop through the hosting data
        foreach ($hostingData as $row) {
            // Determine the billing cycle value using the mapping array
            $billingCycleValue = $billingCycles[strtolower($row->billingcycle)];

            // Compare orderid with id in tblorders
            $orderData = Capsule::table('tblorders')
                ->select('invoiceid') // Include invoiceid
                ->where('id', $row->orderid)
                ->first();

            if ($orderData) {
                // Fetch corresponding invoice data from tblinvoices
                $invoiceData = Capsule::table('tblinvoices')
                    ->select('invoicenum', 'datepaid', 'status') // Include status
                    ->where('id', $orderData->invoiceid)
                    ->first();

                // Format the datepaid field to remove the time
                $datepaid = date('Y-m-d', strtotime($invoiceData->datepaid));

                // Calculate nextduedatefix based on the billing cycle value
                $nextduedatefix = date('Y-m-d', strtotime("+" . $billingCycleValue . " months", strtotime($datepaid)));

                // Update the nextduedate field in the database with nextduedatefix
                Capsule::table('tblhosting')
                    ->where('id', $row->id)
                    ->update(['nextduedate' => $nextduedatefix]);

                // Determine the domainstatus based on the comparison of nextduedate and datetoday
                $domainstatus = ($nextduedatefix > $todayDate) ? 'Active' : 'Suspended';

                // If a match is found, add it to the result array
                if ($invoiceData) {
                    $result[] = [
                        'userid' => $row->userid,
                        'orderid' => $row->orderid,
                        'nextduedate' => $nextduedatefix, // Updated nextduedate field
                        'datetoday' => $todayDate, // Include datetoday in the result
                        'nextduedatefix' => $nextduedatefix, // Include nextduedatefix in the result
                        'billingcycle' => $row->billingcycle,
                        'invoiceid' => $orderData->invoiceid,
                        'invoicenum' => $invoiceData->invoicenum,
                        'datepaid' => $datepaid, // Updated datepaid format without time
                        'status' => $invoiceData->status,
                        'domainstatus' => $domainstatus, // Updated domainstatus
                    ];
                }
            }
        }

        // Check if no values matched the criteria
        if (empty($result)) {
            $result = ['message' => 'No matching values found.'];
        }

        // Output the result in JSON format
        header('Content-Type: application/json');
        echo json_encode($result, JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    } finally {
        Capsule::commit();
    }
});
