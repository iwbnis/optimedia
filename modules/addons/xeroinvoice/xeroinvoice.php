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
function xeroinvoice_config()
{
    return [
        // Display name for your module
        'name' => 'Xero Addon Invoice',
        // Description displayed within the admin interface
        'description' => 'This module for Xero Invoice Details',
        // Module author name
        'author' => 'WHMCS',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.0',
        'fields' => [
           
            'client_id' => [
                'FriendlyName' => 'Client Id',
                'Type' => 'text',
                'Size' => '255',
                'Description' => '',
                'Require' => false,
            ],
            
            'client_secret' => [
                'FriendlyName' => 'Client Secret Id',
                'Type' => 'text',
                'Size' => '255',
                'Default' => '',
                'Description' => '',
                'Require' => false,
            ],
            'refresh_token' => [
                'FriendlyName' => 'Refresh Token',
                'Type' => 'text',
                'Size' => '255',
                'Default' => '',
                'Description' => '',
                'Require' => false,
            ],
            'access_token' => [
                'FriendlyName' => 'Access Token',
                'Type' => 'text',
                'Size' => '255',
                'Default' => '',
                'Description' => '',
                'Require' => false,
            ],
            'xero-tenant-id' => [
                'FriendlyName' => 'Tenent-Id',
                'Type' => 'text',
                'Size' => '255',
                'Default' => '',
                'Description' => '',
                'Require' => false,
            ],
            // 're_directURL' => [
            //     'FriendlyName' => 'Redirect URL',
            //     'Type' => 'text',
            //     'Size' => '255',
            //     'Default' => '',
            //     'Description' => '',
            //     'Require' => false,
            // ],
            // 'scopes' => [
            //     'FriendlyName' => 'Scopes',
            //     'Type' => 'text',
            //     'Size' => '255',
            //     'Default' => '',
            //     'Description' => '',
            //     'Require' => false,
            // ],
            // 'state' => [
            //     'FriendlyName' => 'State',
            //     'Type' => 'text',
            //     'Size' => '255',
            //     'Default' => '',
            //     'Description' => '',
            //     'Require' => false,
            // ],
        ]

    ];
}



function xeroinvoice_activate()
{
     //let's drop the table if it exists
     Capsule::schema()->dropIfExists('xeroinvoiceaddon');
     //now we create it again
     Capsule::schema()->create(
     'xeroinvoiceaddon',
     function ($table) {
     //incremented id
     $table->increments('id');
        $table->string('client_id', 500)->nullable();
        $table->string('client_secret',500)->nullable();
        $table->string('refresh_token', 500)->nullable();                    
        $table->string('access_token', 500)->nullable();                    
        $table->string('xero-tenant-id', 500)->nullable(); 
        $table->string('re_directURL', 500)->nullable(); 
        $table->string('scopes', 500)->nullable(); 
        $table->string('state', 500)->nullable(); 
     }
     );
}

function xeroinvoice_output($vars)
{
    
    print_r('Loading......'); die();
    // if ($_GET['actionurl'] == 'cron') {
    //     include(__DIR__.'/cron.php');
    // }else{
    //     //include(__DIR__.'/dashboard.php');
    // }
    

}


function xeroinvoice_upgrade($vars)
{
    $currentlyInstalledVersion = $vars['version'];    
}
function xeroinvoice_deactivate()
{
    // Undo any database and schema modifications made by your module here
    try {
       Capsule::schema()->dropIfExists('xeroinvoiceaddon');
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