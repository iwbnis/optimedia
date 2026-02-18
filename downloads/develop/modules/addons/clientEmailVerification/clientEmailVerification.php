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
use WHMCS\Module\Addon\clientEmailVerification\Admin\AdminDispatcher;
use WHMCS\Module\Addon\clientEmailVerification\Client\ClientDispatcher;

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
//ALTER TABLE `tblcustomfields` ADD `readonly` TEXT NOT NULL AFTER `sortorder`;

function clientEmailVerification_config() {
    return [
        // Display name for your module
        'name' => 'Client Email Verification Module',
        // Description displayed within the admin interface
        'description' => 'This module provides a platform to pass read only in custom field'
        . ' which be shown on profile page',
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

function clientEmailVerification_activate() {
    // Create custom tables and schema required by your module
    try {
		
		Capsule::schema()
                ->create(
                        'mod_verifiedemail', function ($table) {                    
                    $table->increments('id');
                    $table->text('email');   
                    $table->text('verification_code');   
                    $table->tinyInteger('is_verified');
                    $table->timestamps();
                }
            );
			
		Capsule::schema()
                ->create(
                        'mod_configemail_verification', function ($table) {                    
                    $table->increments('id');
                    $table->text('setting');   
                    $table->text('value');   
                    $table->timestamps();
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
            'description' => 'Unable to add readonly: ' . $e->getMessage(),
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
function clientEmailVerification_deactivate() {
    // Undo any database and schema modifications made by your module here
    try {
        
		
            Capsule::Schema()->dropIfExists('mod_verifiedemail');
        
        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'Module uninstalled',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            "status" => "error",
            "description" => "Unable to drop  readonly field: {$e->getMessage()}",
        ];
    }
}

function clientEmailVerification_upgrade($vars) {
    $currentlyInstalledVersion = $vars['version'];
}

function clientEmailVerification_output($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. clientEmailVerifications.php?module=clientEmailVerification
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    global $CONFIG;
    global $templates_compiledir;

    define("MODURL", $vars['modulelink']);
    define("MODVERION", $vars['version']);
	
	# Init Smarty
    $smarty = new Smarty;
    $smarty->setCompileDir($templates_compiledir);
    $smarty->setTemplateDir(ROOTDIR . "/modules/addons/clientEmailVerification/templates/");
    $smarty->compile_id = md5(MODURL);

    $dispatcher = new AdminDispatcher();
	
    # Default Template
    $templateFile = "index.tpl";

    # Assign Default Heading
    $smarty->assign("modPageTitle", "Menu Groups");

    $smarty->assign("modurl", MODURL);
 
    $action = trim($_GET['action']);
	if ($action == "save") {
		unset($_POST['token']);

        try {
			foreach($_POST as $k=>$v){
				$getVarialbes = Capsule::table("mod_configemail_verification")
                ->where("setting", $k)
                ->first();
				if($getVarialbes){
					Capsule::table("mod_configemail_verification")
						->where("setting", $k)
						->update(
							array(
								"value" => trim($v)
							)
						);
				} else {
					Capsule::table("mod_configemail_verification")->insertGetId(
							array(
								"setting" => trim($k),
								"value" => trim($v)
							)
					);
				}
			}
            
            # Redirect
            $dispatcher->redirect(MODURL . '&success=1');
            exit;
        } catch (\Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
	
	$smarty->assign("action", $action);
	
	$getVarialbes = Capsule::table("mod_configemail_verification")
                ->orderBy("id", "desc")
                ->get();
				
	$finalVarialbes = array();
	foreach($getVarialbes as $Varialbes){
		
		$finalVarialbes[$Varialbes->setting] = $Varialbes->value;
		
	}
	$smarty->assign("variables", $finalVarialbes);

	 # Finally Display Output
    $smarty->display("header.tpl");
    $smarty->display($templateFile); 
    $smarty->display("footer.tpl");
    //$response = $dispatcher->dispatch($action, $vars);
    // echo $response;

}

function clientEmailVerification_sidebar($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];



    $sidebar = '';
    return $sidebar;
}

function clientEmailVerification_clientarea($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. index.php?m=clientEmailVerification
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables


    /**
     * Dispatch and handle request here. What follows is a demonstration of one
     * possible way of handling this using a very basic dispatcher implementation.
     */
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    
    return "";
}
