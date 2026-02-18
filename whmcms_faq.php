<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use WHMCS\Database\Capsule;

define("CLIENTAREA", true);
require __DIR__ . '/init.php';

// Define the table names
$faqTableName = 'mod_whmcms_faq';
$faqGroupsTableName = 'mod_whmcms_faqgroups';

// Retrieve data from the mod_whmcms_faq table
$faqData = Capsule::table($faqTableName)->get();

// Retrieve data from the mod_whmcms_faqgroups table
$faqGroupsData = Capsule::table($faqGroupsTableName)->get();

// Create an associative array to store group titles
$groupTitles = [];

// Populate the $groupTitles array with group titles from mod_whmcms_faqgroups
foreach ($faqGroupsData as $group) {
    $groupTitles[$group->groupid] = $group->title;
}

// Get the current domain name from the HTTP_HOST server variable
$currentDomain = $_SERVER['HTTP_X_REAL_HOST'] ?? $_SERVER['HTTP_HOST'];
// Initialize an array to store the results
$results = [];

// Loop through the retrieved data from mod_whmcms_faq and format it
foreach ($faqData as $faq) {
    // Check if the groupid exists in the $groupTitles array
    if (array_key_exists($faq->groupid, $groupTitles)) {
        // Check if the current domain matches the group_title
        if (strpos($currentDomain, $groupTitles[$faq->groupid]) !== false) {
            $result = [
                'faqid' => $faq->faqid,
                'topid' => $faq->topid,
                'groupid' => $faq->groupid,
                'question' => $faq->question,
                // Decode HTML entities in the answer field
                'answer' => htmlspecialchars_decode($faq->answer),
                'enable' => $faq->enable,
                'group_title' => $groupTitles[$faq->groupid],
            ];

            // Add the formatted result to the results array
            $results[] = $result;
        }
    }
}

// Output the filtered results in JSON format
header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
