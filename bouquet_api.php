<?php
/**
 * Bouquet API endpoint for dashboard
 * Handles fetching and saving bouquet categories for IPTV services
 */
require_once __DIR__ . '/init.php';

use WHMCS\Database\Capsule;

header('Content-Type: application/json');

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check authentication
if (empty($_SESSION['uid'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$uid = (int) $_SESSION['uid'];
$action = isset($_POST['action']) ? $_POST['action'] : '';
$serviceid = isset($_POST['serviceid']) ? (int) $_POST['serviceid'] : 0;

if (!$serviceid) {
    echo json_encode(['status' => 'error', 'message' => 'Service ID required']);
    exit;
}

// Verify user owns this service
$service = Capsule::table('tblhosting')->where('id', $serviceid)->where('userid', $uid)->first();
if (!$service) {
    echo json_encode(['status' => 'error', 'message' => 'Service not found']);
    exit;
}

$productid = $service->packageid;

if ($action === 'getBouquets') {
    // Get bouquet categories - same logic as XUIResellerPanel Config.php getBouquetCategoriesOnClientArea
    $response = [];
    $count = Capsule::table('xui_cats')->where('hidden', '0')->orderBy('order')->count();

    if ($count > 0) {
        $savedbouquets = Capsule::table('tblproducts')->where('id', $productid)->select('configoption12')->get();
        $xui_cats = Capsule::table('xui_cats')->where('hidden', '0')->orderBy('order')->get();
        $cat_data = Capsule::table('xui_cat_data')->where('productid', $productid)->get();

        if (empty($cat_data) || !isset($cat_data[0])) {
            echo json_encode(['status' => 'error', 'message' => 'No bouquet data configured for this product']);
            exit;
        }

        $categoriesData = json_decode($cat_data[0]->categories_data);
        $categoriesData = (array) $categoriesData;
        $uncategorizedCount = 0;
        foreach ($categoriesData as $value) {
            if ($value === 'uncategorized') {
                $uncategorizedCount++;
            }
        }

        $xui_cat_data = $cat_data[0]->categories_data;
        $cat_data_clientarea = $cat_data[0]->cat_data_clientarea;

        $categories = [];
        foreach ($xui_cats as $val) {
            $categories[] = [$val->id => $val->cat_name];
        }

        // Get client-specific selected bouquets
        $selected_bouquets_serviceDetails = [];
        $tblcustomfields = Capsule::table('tblcustomfields')
            ->where('fieldname', 'Select Bouquets')
            ->where('relid', $productid)
            ->select('id')
            ->get();

        if (!empty($tblcustomfields)) {
            $fieldid = $tblcustomfields[0]->id;
            $tblcustomfieldsvalues = Capsule::table('tblcustomfieldsvalues')
                ->where('relid', $serviceid)
                ->where('fieldid', $fieldid)
                ->first();
            $selectedBouquets = $tblcustomfieldsvalues ? $tblcustomfieldsvalues->value : '';
            $selected = (!empty($selectedBouquets)) ? trim($selectedBouquets) : $savedbouquets[0]->configoption12;
            $selected_bouquets_serviceDetails = explode(',', $selected);
        }

        $xui_cat_data_decoded = json_decode($xui_cat_data);
        $xui_cat_data_decoded = (array) $xui_cat_data_decoded;
        $cat_data_clientarea_decoded = json_decode($cat_data_clientarea);
        $bouquets = (array) $cat_data_clientarea_decoded;

        $response['status'] = 'success';
        $response['data'] = $categories;
        $response['savedbouquets'] = $savedbouquets[0]->configoption12;
        $response['clientSavedBouquets'] = $selected_bouquets_serviceDetails;
        $response['uncategorizedLength'] = $uncategorizedCount;
        $response['bouquets'] = $bouquets;
        $response['cat_data'] = !empty($xui_cat_data_decoded) ? $xui_cat_data_decoded : '';
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No categories configured']);
    }
    exit;
}

if ($action === 'saveBouquets') {
    $selectedBouquets = isset($_POST['selectedBouquets']) ? $_POST['selectedBouquets'] : '';

    // Get the custom field ID for "Select Bouquets"
    $tblcustomfields = Capsule::table('tblcustomfields')
        ->where('fieldname', 'Select Bouquets')
        ->where('relid', $productid)
        ->select('id')
        ->get();

    if (!empty($tblcustomfields)) {
        $fieldid = $tblcustomfields[0]->id;

        // Check if value exists
        $existing = Capsule::table('tblcustomfieldsvalues')
            ->where('relid', $serviceid)
            ->where('fieldid', $fieldid)
            ->first();

        if ($existing) {
            Capsule::table('tblcustomfieldsvalues')
                ->where('relid', $serviceid)
                ->where('fieldid', $fieldid)
                ->update(['value' => $selectedBouquets]);
        } else {
            Capsule::table('tblcustomfieldsvalues')->insert([
                'fieldid' => $fieldid,
                'relid' => $serviceid,
                'value' => $selectedBouquets,
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Bouquets saved']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bouquet field not found']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
