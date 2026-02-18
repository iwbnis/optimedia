<?php
require_once '../../../init.php';
require_once './functions.php';

use WHMCS\Database\Capsule;

if (isset($_POST['action']) && $_POST['action'] == "delete" && !empty($_POST['panelid'])) {
    $panelid = $_POST['panelid'];
    Capsule::table('xui_paneldetails')->where('id', $panelid)->delete();
    echo 'success';
    exit;
}
if (isset($_POST['action']) && $_POST['action'] == "testconnection" && isset($_POST['task'])) {
    $panel_url = $_POST['panel_url'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mag_portal = $_POST['mag_portal'];
    $panel_name = $_POST['panel_name'];
    $m3uurl = $_POST['m3uurl'];
    $watchstrmurl = $_POST['watchstrmurl'];

    $panel_details = array('panel_url' => $panel_url, 'username' => $username, 'password' => $password, 'm3uurl' => $m3uurl, 'mag_portal' => $mag_portal, 'watchstrmurl' => $watchstrmurl, 'panel_name' => $panel_name, 'action' => $_POST['task']);

    testconnection($panel_details);
}
if (isset($_POST['action']) && $_POST['action'] == "getproductinfo") {
    $productid = $_POST['productid'];
    $serverid = $_POST['serverid'];
    $panel_details = array();
    $paneldetails = Capsule::table('xui_paneldetails')->where('id', $serverid)->get();
    foreach ($paneldetails as $val) {
        $panel_details['panel_url'] = $val->panel_link;
        $panel_details['username'] = $val->username;
        $panel_details['password'] = $val->password;
        $panel_details['panel_name'] = $val->identifier;
    }
    $response = getproductsinfo($panel_details, 'getproductinfo', $productid);
    echo $response;
    exit;
}
if (isset($_POST['action']) && $_POST['action'] == "getBouquetCategorized") {
    $productid = $_POST['productid'];
    $packageid = $_POST['packageid'];
    $count = Capsule::table('xui_cat_data')->where('productid', $productid)->where('packageid', $packageid)->count();
    if ($count > 0) {
        $data = Capsule::table('xui_cat_data')->where('productid', $productid)->where('packageid', $packageid)->first();
        $categories_data = $data->categories_data;
        echo $categories_data;
        exit;
    } else {
        echo "error";
        exit;
    }
}
if (isset($_POST['action']) && $_POST['action'] == "saveSelectedBouquets") {
    $selectedbouquets = $_POST['selectedbouquets'];
    $productid = $_POST['productid'];
    //update product config
    $update = Capsule::table('tblproducts')->where('id', $productid)->update(['configoption12' => $selectedbouquets]);
    echo "success";
    exit;
}
if (isset($_POST['action']) && $_POST['action'] == "getBouquetCategories") {
    $response = array();
    $count = Capsule::table('xui_cats')->where('hidden', '0')->orderBy('order')->count();
    if ($count > 0) {
        $xui_cats = Capsule::table('xui_cats')->where('hidden', '0')->orderBy('order')->get();
        $cat_data = Capsule::table('xui_cat_data')->where('productid', $_POST['productid'])->where('packageid', $_POST['packageid'])->get();
        $xui_cat_data =  $cat_data[0]->categories_data;
        $categories = array();
        foreach ($xui_cats as $val) {
            $categories[] = array(
                $val->id => $val->cat_name
            );
        }
        $newArray = array();
        $xui_cat_data = json_decode($xui_cat_data);
        $array = (array) $xui_cat_data;
        $response['status'] = 'success';
        $response['data'] = $categories;
        $response['cat_data'] = isset($xui_cat_data) && !empty($xui_cat_data) ? $xui_cat_data : "";
        echo json_encode($response);
        exit;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No Categories Added.';
        echo json_encode($response);
        exit;
    }
}
if (isset($_POST['action']) && $_POST['action'] == "getBouquetCategoriesOnClientArea") {
    //for client area
    $response = array();
    $count = Capsule::table('xui_cats')->where('hidden', '0')->orderBy('order')->count();
    
    
    if ($count > 0) {
        $savedbouquets = Capsule::table('tblproducts')->where('id', $_POST['productid'])->select('configoption12')->get();
        $xui_cats = Capsule::table('xui_cats')->where('hidden', '0')->orderBy('order')->get();
        $cat_data = Capsule::table('xui_cat_data')->where('productid', $_POST['productid'])->get();
        $categoriesData = json_decode($cat_data[0]->categories_data);
        $categoriesData = (array) $categoriesData;
        $count = 0;
        foreach ($categoriesData as $value) {
            if ($value == "uncategorized") {
                $count++;
            }
        }
        $xui_cat_data =  $cat_data[0]->categories_data;
        $cat_data_clientarea =  $cat_data[0]->cat_data_clientarea;
        $categories = array();
        foreach ($xui_cats as $val) {
            $categories[] = array(
                $val->id => $val->cat_name
            );
        }
        //get custom fields and config options with the product  
        $selected_bouquets_serviceDetails = array();
        if (isset($_POST['serviceid']) && !empty($_POST['serviceid'])) {
            $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', 'Select Bouquets')->where('relid', $_POST['productid'])->select('id')->get();
            $fieldid =  $tblcustomfields[0]->id;
            $tblcustomfieldsvalues = Capsule::table('tblcustomfieldsvalues')->where('relid', $_POST['serviceid'])->where('fieldid', $fieldid)->first();
            $selectedBouquets = $tblcustomfieldsvalues->value;
            $selected_bouquets_serviceDetails = isset($selectedBouquets) && !empty($selectedBouquets) ? trim($selectedBouquets) : $savedbouquets[0]->configoption12;
            $selected_bouquets_serviceDetails = explode(",", $selected_bouquets_serviceDetails);
        }
        $xui_cat_data = json_decode($xui_cat_data);
        $xui_cat_data = (array) $xui_cat_data;
        $cat_data_clientarea = json_decode($cat_data_clientarea);
        $bouquets = (array) $cat_data_clientarea;
        $response['status'] = 'success';
        $response['data'] = $categories;
        $response['savedbouquets'] = $savedbouquets[0]->configoption12;
        $response['clientSavedBouquets'] = $selected_bouquets_serviceDetails;
        $response['uncategorizedLength'] = $count;
        $response['bouquets'] = $bouquets;
        $response['cat_data'] = isset($xui_cat_data) && !empty($xui_cat_data) ? $xui_cat_data : "";
        echo json_encode($response);
        exit;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No Categories Added.';
        echo json_encode($response);
        exit;
    }
}
if (isset($_POST['action']) && $_POST['action'] == "saveBouquetCategories") {
    $savedbouquets = Capsule::table('tblproducts')->where('id', $_POST['productid'])->select('configoption12')->first();
    $savedbouquets = $savedbouquets->configoption12;
    $savedbouquets = explode(",", $savedbouquets);
    $arrayToSave = array();
    foreach ($_POST['uncategorizedArray'] as $bouqueyid => $val) {
        if (isset($val) && !empty($val) && $val != "" && $val != null && $val != "undefined") {
            $arrayToSave[$bouqueyid] = $val;
        }
    }
    foreach ($_POST['bouquetsData'] as $bouqueyid => $catid) {
        if (isset($catid) && !empty($catid) && $catid != "" && $catid != null && $catid != "undefined" && in_array($bouqueyid, $savedbouquets)) {
            $arrayToSave[$bouqueyid] = $catid;
        }
    }
    //save bouquets 
    $datatoSave = $_POST['datatoSave'];
    $arrayToInsert = array();
    foreach ($datatoSave as $bouauet_id => $val) {
        if (isset($val) && !empty($val)) {
            $arrayToInsert[$bouauet_id] = $val;
        }
    }
    $arrayToInsert = json_encode($arrayToInsert);
    $finalarrayTosave = json_encode($arrayToSave);
    Capsule::table('xui_cat_data')->where('productid', $_POST['productid'])->delete();
    $insert = Capsule::table('xui_cat_data')->insert([
        'productid' => $_POST['productid'],
        'packageid' => $_POST['packageid'],
        'cat_data_clientarea' => $arrayToInsert,
        'categories_data' => $finalarrayTosave,
    ]);
    if ($insert) {
        echo "success";
        exit;
    }
    echo "error";
    exit;
}
