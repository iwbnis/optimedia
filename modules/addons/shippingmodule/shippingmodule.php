<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function shippingmodule_config()
{
    return [
        // Display name for your module
        'name' => 'Shipping Module',
        // Description displayed within the admin interface
        'description' => 'This module provides an ability to add  Shipping information to the Orders.',
        // Module author name
        // 'author' => '<img src="../modules/addons/shippingmodule/img/logo.png" />',
        'author' => '<a href="https://fayzanzaid.com" target="_new">Fiz (Fayzan Zahid)</a>',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '4.0',
        'fields' => [
            'ShippingType' => [
                'FriendlyName' => 'Shipping Type',
                'Type' => 'radio',
                'Options' => '1. Flat Shipping for All,2. Flat Shipping for All + Zip Code Charges,3. Country Flat Shipping + Zip Code Charges,4. Zip Code Charges',
                'Default' => 'Country Flat Shipping + Zip Code Charges',
                'Description' => 'Choose the Shipping Charges',
            ],
            'FlatShippingAll' => [
                'FriendlyName' => 'Flat Shipping for All',
                'Type' => 'text',
                'Size' => '25',
                'Default' => '0',
                'Description' => '<br />Enter flat shipping charges for All countries if you selected "Flat Shipping for All" above. It will be saved in your Default Currency and converted at the time of checkout in user currency if you are using multiple currencies',
            ],
            'CheckoutType' => [
                'FriendlyName' => 'Checkout Type',
                'Type' => 'radio',
                'Options' => '1. View Cart Page (Multipage Checkout),2. Checkout Page (OnePage Checkout)',
                'Default' => '1. View Cart Page (Multipage Checkout)',
                'Description' => 'Choose where to display the Shipping form (Option 1 is recommended)',
            ],
        ]
    ];
}

function shippingmodule_activate()
{

  require_once('view.php');
  $view = new ViewSM();

if (!Capsule::schema()->hasTable('mod_shippingmodule_rates_types')) {

  //CREATE TABLES
  try {
      Capsule::schema()
          ->create(
              'mod_shippingmodule_rates_types',
              function ($table) {
                  $table->increments('id');
                  $table->text('rate_type');
              }
          );

          Capsule::schema()
              ->create(
                  'mod_shippingmodule_additional_rates',
                  function ($table) {
                      $table->increments('id');
                      $table->integer('country');
                      $table->integer('product_id');
                      $table->integer('rate_type');
                      $table->integer('value');
                  }
              );


      return [
          // Supported values here include: success, error or info
          'status' => 'success',
          'description' => 'Addon activated successfully',
      ];
  } catch (\Exception $e) {
      return [
          // Supported values here include: success, error or info
          'status' => "error",
          'description' => 'An error occured while creating tables: ' . $e->getMessage(),
      ];
  }


}


  if (!Capsule::schema()->hasTable('mod_shippingmodule')) {

      //CREATE TABLES
      try {
          Capsule::schema()
              ->create(
                  'mod_shippingmodule',
                  function ($table) {
                      $table->increments('id');
                      $table->integer('orderid');
                      $table->integer('service_id');
                      $table->text('shipping_addr');
                      $table->integer('zip_code');
                      $table->string('country');
                      $table->string('shipping_company');
                      $table->string('shipping_url');
                      $table->string('shipping_status');
                      $table->string('tracking_number');

                  }
              );


              Capsule::schema()
              ->create(
                  'mod_shippingmodule_license',
                  function ($table) {
                      $table->increments('id');
                      $table->text('license_key');
                      $table->text('license_domain');
                      $table->text('activated_on');
                      $table->text('expiry');
                      $table->string('status');

                  }
              );


              Capsule::schema()
                  ->create(
                      'mod_shippingmodule_country',
                      function ($table) {
                          $table->increments('id');
                          $table->text('country');
                          $table->integer('status');
                      }
                  );

                  Capsule::schema()
                      ->create(
                          'mod_shippingmodule_zip_ranges',
                          function ($table) {
                              $table->increments('id');
                              $table->text('country');
                              $table->integer('product_id');
                              $table->text('zipc_range_start');
                              $table->text('zipc_range_end');
                              $table->float('rate');
                          }
                      );

                  Capsule::schema()
                      ->create(
                          'mod_shippingmodule_rates',
                          function ($table) {
                              $table->increments('id');
                              $table->text('country');
                              $table->float('flat_rate');
                              $table->integer('product_id');
                          }
                      );


                      Capsule::schema()
                          ->create(
                              'mod_shippingmodule_products',
                              function ($table) {
                                  $table->increments('id');
                                  $table->text('product');
                                  $table->text('shipping_enable');
                                  $table->longText('photo');
                              }
                          );

          return [
              // Supported values here include: success, error or info
              'status' => 'success',
              'description' => 'Addon activated successfully',
          ];
      } catch (\Exception $e) {
          return [
              // Supported values here include: success, error or info
              'status' => "error",
              'description' => 'An error occured while creating tables: ' . $e->getMessage(),
          ];
      }

    }

    $view->InsertCountries_WHMCS();
    $view->InsertRate_Types();
}


function shippingmodule_deactivate()
{
    //Do something on de-activation
}


function shippingmodule_upgrade($vars)
{
    $currentlyInstalledVersion = $vars['version'];


}


function shippingmodule_output($vars)
{

  require_once('view.php');
  $view = new ViewSM();

    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. shippingmodules.php?module=shippingmodule
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    // Get module configuration parameters
    $configShippingType = $vars['ShippingType'];
    $configFlatShippingAll = $vars['FlatShippingAll'];

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    if(!isset($_GET['view']))
    {
      $view->Dashboard();
    }

    if($_GET['view'] == "manageCountryShipping")
    {
      $view->manageCountryShipping();
      $view->dataTables_includes();
    }

    if($_GET['view'] == "enableCountry")
    {
      $view->enableCountry($_GET['id']);
    }

    if($_GET['view'] == "disableCountry")
    {
      $view->disableCountry($_GET['id']);
    }

    if($_GET['view'] == "massSaveCountryShipping")
    {
      $view->massSaveCountryShipping();
    }

    if($_GET['view'] == "massManageShippingCountries")
    {
      $view->massManageShippingCountries();
    }


    if($_GET['view'] == "manageCountries")
    {
      $view->manageCountries($_GET['pid']);
      $view->dataTables_includes();
    }


    if($_GET['view'] == "addCountry")
    {
      $view->addCountry($_GET['pid']);
    }

    if($_GET['view'] == "saveCountry")
    {
      $view->saveCountry();
    }

    if($_GET['view'] == "editCountry")
    {
      $view->editCountry($_GET['id']);
    }

    if($_GET['view'] == "updateCountry")
    {
      $view->updateCountry($_POST['id']);
    }

    if($_GET['view'] == "deleteCountry")
    {
      $view->deleteCountry($_GET['id']);
    }

    if($_GET['view'] == "manageZipRanges")
    {
      $view->manageZipRanges($_REQUEST['country']);
      $view->dataTables_includes();
    }

    if($_GET['view'] == "addZipRange")
    {
      $view->addZipRange($_GET['country']);
    }

    if($_GET['view'] == "saveZipRange")
    {
      $view->saveZipRange();
    }

    if($_GET['view'] == "deleteZipRange")
    {
      $view->deleteZipRange($_GET['id']);
    }

    if($_GET['view'] == "editZipRange")
    {
      $view->editZipRange($_GET['id']);
    }

    if($_GET['view'] == "updateZipRange")
    {
      $view->updateZipRange($_POST['id']);
    }

    if($_GET['view'] == "manageFlatRates")
    {
      $view->manageFlatRates($_REQUEST['country']);
      $view->dataTables_includes();
    }


    if($_GET['view'] == "massFlatRate")
    {
      $view->massFlatRate($_GET['pid']);
    }

    if($_GET['view'] == "massSaveFlatRate")
    {
      $view->massSaveFlatRate($_GET['pid']);
    }

    if($_GET['view'] == "editFlatRate")
    {
      $view->editFlatRate($_REQUEST['country']);
    }

    if($_GET['view'] == "updateFlatRate")
    {
      $view->updateFlatRate($_REQUEST['country']);
    }

    if($_GET['view'] == "manageOrderTracking")
    {
      $view->manageOrderTracking();
      $view->dataTables_includes();
    }

    if($_GET['view'] == "editOrderTracking")
    {
      $view->editOrderTracking($_GET['id']);
    }

    if($_GET['view'] == "updateOrderTracking")
    {
      $view->updateOrderTracking($_POST['id']);
    }

    if($_GET['view'] == "manageProducts")
    {
      $view->manageProducts();
      $view->dataTables_includes();
    }

    if($_GET['view'] == "updateProducts")
    {
      $view->updateProducts($_GET['pid']);
    }

    if($_GET['view'] == "manageProduct")
    {
      $view->manageProduct($_GET['pid']);

    }

    if($_GET['view'] == "manageProductPhoto")
    {
      $view->manageProductPhoto($_GET['pid']);

    }

    if($_GET['view'] == "UpdateProductPhoto")
    {
      $view->UpdateProductPhoto($_GET['pid']);

    }

    if($_GET['view'] == "manageLicense")
    {
      $view->manageLicense();
      $view->dataTables_includes();

    }

    if($_GET['view'] == "addLicense")
    {
      $view->addLicense();

    }

    if($_GET['view'] == "saveLicense")
    {
      $view->saveLicense();
    }

    if($_GET['view'] == "editLicense")
    {
      $view->editLicense($_GET);
    }

    if($_GET['view'] == "updateLicense")
    {
      $view->updateLicense($_GET);
    }

    if($_GET['view'] == "destroyLicense")
    {
      $view->destroyLicense($_GET);
    }

    if($_GET['view'] == "reGenerateLicense")
    {
      $view->reGenerateLicense($_GET);
    }

    if($_GET['view'] == "runCron")
    {
      $view->runCron($_GET);
    }

     if($_GET['view'] == "deleteImage")
    {
      $view->deleteImage($_GET);
    }

     if($_GET['view'] == "Documentation")
    {
      $view->Documentation();
    }

    if($_GET['view'] == "manageAddQuantity")
    {
      $view->manageAddQuantity();
    }

    if($_GET['view'] == "updateAddQuantityRate")
    {
      $view->updateAddQuantityRate($_GET['country']);
    }

// NEw REVISION
    if($_GET['view'] == "massManageAddQuantityRate")
    {
      $view->massManageAddQuantityRate();
    }

    if($_GET['view'] == "massSaveAddQuantityRate")
    {
      $view->massSaveAddQuantityRate();
    }

    if($_GET['view'] == "AddVideos")
    {
      $view->AddVideos();
    }

    if($_GET['view'] == "UpdateVideoURL")
    {
      $view->UpdateVideoURL();
    }


}


function shippingmodule_sidebar($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];

    $sidebar = '
    <span class="header"><img src="images/icons/addonmodules.png" class="absmiddle" width="16" height="16"> Shipping Module</span>
    <ul class="menu">
            <li><a href="addonmodules.php?module=shippingmodule">Dashboard</a></li>
            <li><a href="addonmodules.php?module=shippingmodule&view=manageLicense">Manage Licenses</a></li>
            <li><a href="addonmodules.php?module=shippingmodule&view=manageOrderTracking">Manage Order Tracking</a></li>
            <li><a href="addonmodules.php?module=shippingmodule&view=manageCountryShipping">Shipping Countries</a></li>
            <li><a href="addonmodules.php?module=shippingmodule&view=manageProducts">Manage Products</a></li>
            <li><a href="addonmodules.php?module=shippingmodule&view=Documentation">Documentation</a></li>

            <li><a href="configaddonmods.php">Settings</a></li>

        </ul>';
    return $sidebar;
}

function shippingmodule_clientarea($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. index.php?m=shippingmodule
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

}
