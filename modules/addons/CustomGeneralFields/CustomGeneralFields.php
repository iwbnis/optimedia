<?php

/**
 * WHMCS General Custom Fields Module
 *
 *
 * For more information, please refer to the online documentation.
 *
 * @contact https://ionwebs.com
 *
 */
use WHMCS\Database\Capsule;
use WHMCS\Module\Addon\CustomGeneralFields\Admin\AdminDispatcher;
use WHMCS\Module\Addon\CustomGeneralFields\Client\ClientDispatcher;

//error_reporting(E_ALL);
//ini_set("display_error", 1);

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function customgeneralfields_config() {
    return [
        // Display name for your module
        'name' => 'General Custom Fields Module',
        // Description displayed within the admin interface
        'description' => 'This module provides a platform to pass variables to template'
        . ' which can be used to show in template',
        // Module author name
        'author' => 'IonWebs (ionwebs.com)',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.0',
        'fields' => [
        // a text field type allows for single line text input
        ]
    ];
}

function customgeneralfields_activate() {
    // Create custom tables and schema required by your module
    try {
        Capsule::schema()
                ->create(
                        'mod_customgeneralfields', function ($table) {
                    /** @var \Illuminate\Database\Schema\Blueprint $table */
                    $table->increments('id');
                    $table->text('key');
                    $table->text('value');
                }
        );

        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'Module installed ',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            'status' => "error",
            'description' => 'Unable to create mod_customgeneralfields: ' . $e->getMessage(),
        ];
    }
}

/**
 * Deactivate.
 *
 * Called upon deactivation of the module.
 * Use this function to undo any database and schema modifications
 * performed by your module.
 *
 * This function is optional.
 *
 * @see https://developers.whmcs.com/advanced/db-interaction/
 *
 * @return array Optional success/failure message
 */
function customgeneralfields_deactivate() {
    // Undo any database and schema modifications made by your module here
    try {
        Capsule::schema()
                ->dropIfExists('mod_customgeneralfields');

        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'Module uninstalled',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            "status" => "error",
            "description" => "Unable to drop mod_customgeneralfields: {$e->getMessage()}",
        ];
    }
}

function customgeneralfields_upgrade($vars) {
    $currentlyInstalledVersion = $vars['version'];
}

function customgeneralfields_output($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. customgeneralfieldss.php?module=customgeneralfields
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    global $CONFIG;
    global $templates_compiledir;

    define("MODURL", $vars['modulelink']);
    define("MODVERION", $vars['version']);

    # Init Smarty
    $smarty = new Smarty;
    $smarty->setCompileDir($templates_compiledir);
    $smarty->setTemplateDir(ROOTDIR . "/modules/addons/CustomGeneralFields/templates/");
    $smarty->compile_id = md5(MODURL);

    $dispatcher = new AdminDispatcher();

    # Default Template
    $templateFile = "groups.tpl";

    # Assign Default Heading
    $smarty->assign("modPageTitle", "Menu Groups");

    $smarty->assign("modurl", MODURL);



    $action = trim($_GET['action']);
    $smarty->assign("action", $action);

    // Dispatch and handle request here. What follows is a demonstration of one
    // possible way of handling this using a very basic dispatcher implementation.

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';



    # List Varialbes
    if ($action == "") {


        # Get Varialbe
        $getVarialbes = Capsule::table("mod_customgeneralfields")
                ->orderBy("id", "desc")
                ->get();

        $variables = $dispatcher->fromMYSQL($getVarialbes);

        $smarty->assign("variables", $variables);
    }
    # Add Group
    else if ($action == "addvariable") {

        try {


            $groupid = Capsule::table("mod_customgeneralfields")->insertGetId(
                    array(
                        "key" => (string) trim($_POST['key']),
                        "value" => (string) trim($_POST['value'])
                    )
            );


            # Redirect
            $dispatcher->redirect(MODURL . '&success=1');
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
    # Update Group
    else if ($action == "updatevariable") {

        try {

            $variableid = intval($_GET['id']);


            Capsule::table("mod_customgeneralfields")
                    ->where("id", $variableid)
                    ->update(
                            array(
                                "key" => (string) trim($_POST['key']),
                                "value" => (string) trim($_POST['value'])
                            )
            );

            # Redirect
            $dispatcher->redirect(MODURL . '&success=1');
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

# Delete Group
    else if ($action == "deletevariable") {

        $variablesid = intval($_GET['id']);

        # Delete Group Record
        Capsule::table('mod_customgeneralfields')
                ->where("id", $variablesid)
                ->delete();


        # Redirect
        $dispatcher->redirect(MODURL . '&success=1');
        exit;
    }

    # Finally Display Output
    $smarty->display("header.tpl");
    $smarty->display($templateFile);
    $smarty->display("footer.tpl");
    //$response = $dispatcher->dispatch($action, $vars);
    // echo $response;
}

function customgeneralfields_sidebar($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];



    $sidebar = '';
    return $sidebar;
}

function customgeneralfields_clientarea($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. index.php?m=customgeneralfields
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables


    /**
     * Dispatch and handle request here. What follows is a demonstration of one
     * possible way of handling this using a very basic dispatcher implementation.
     */
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new ClientDispatcher();
    return $dispatcher->dispatch($action, $vars);
}
