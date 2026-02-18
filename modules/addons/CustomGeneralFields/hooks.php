<?php

use WHMCS\Database\Capsule;
use WHMCS\Module\Addon\CustomGeneralFields\Admin\AdminDispatcher;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
# Load Files in Admin Area
function CustomGeneralFieldsHook_loadAdminAreaFiles($vars) {
    $HTML = '';

    # Only Applied In Our Module
    if ($vars['filename'] == "addonmodules" && $_GET['module'] == "CustomGeneralFields") {
        # Sortable Plugin
        $HTML .= '<script type="text/javascript" src="../modules/addons/CustomGeneralFields/assets/plugins/sortable/sortable.js"></script>';
        # Our Styles / Scripts
        $HTML .= '<link type="text/css" rel="stylesheet" href="../modules/addons/CustomGeneralFields/assets/css/styles.css">';
        $HTML .= '<script type="text/javascript" src="../modules/addons/CustomGeneralFields/assets/js/scripts.js"></script>';
    }

    return $HTML;
}

add_hook("AdminAreaHeadOutput", 1, "CustomGeneralFieldsHook_loadAdminAreaFiles");

function passVariable($vars){
    
    $dispatcher = new AdminDispatcher();

    # Get Varialbe
    $getVarialbes = Capsule::table("mod_customgeneralfields")
            ->orderBy("id", "desc")
            ->get();
    $variables = $dispatcher->fromMYSQL($getVarialbes);
    foreach ($variables as $variable) {

        $vars[$variable['key']] = $variable['value'];
    }
    return $vars;
}

add_hook('ClientAreaPage', 1, 'passVariable');
add_hook('EmailTplMergeFields', 1, 'passVariable');

add_hook('EmailPreSend', 1, 'passVariable');
