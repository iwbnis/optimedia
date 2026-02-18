<?php
use WHMCS\Database\Capsule;


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

/**
 * Define addon module configuration parameters.
 *
 * Includes a number of required system fields including name, description,
 * author, language and version.
 *
 * Also allows you to define any configuration parameters that should be
 * presented to the user when activating and configuring the module. These
 * values are then made available in all module function calls.
 *
 * Examples of each and their possible configuration parameters are provided in
 * the fields parameter below.
 *
 * @return array
 */
function XUIModule_config()
{
    return [
        // Display name for your module
        'name' => 'XUIModule',
        // Description displayed within the admin interface
        'description' => 'This module for XUIModule',
        // Module author name
        'author' => 'WHMCS',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.0'

    ];
}



function XUIModule_activate()
{
     //let's drop the table if it exists
     Capsule::schema()->dropIfExists('XUIModuleaddon');
     //now we create it again
     Capsule::schema()->create(
     'XUIModuleaddon',
     function ($table) {
        //incremented id
        $table->increments('id');
        $table->text('serviceid')->nullable();
        $table->text('xtreamoneid')->nullable();
     }
     );
}

function XUIModule_output($vars)
{
    
    print_r('Loading......'); die();
    // if ($_GET['actionurl'] == 'cron') {
    //     include(__DIR__.'/cron.php');
    // }else{
    //     //include(__DIR__.'/dashboard.php');
    // }
    

}


function XUIModule_upgrade($vars)
{
    $currentlyInstalledVersion = $vars['version'];    
}
function XUIModule_deactivate()
{
    // Undo any database and schema modifications made by your module here
    try {
       Capsule::schema()->dropIfExists('XUIModuleaddon');
        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => '',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            "status" => "error",
            "description" => "Unable to drop mod_whmcshosting: {$e->getMessage()}",
        ];
    }
}