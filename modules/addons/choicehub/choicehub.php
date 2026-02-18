<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

function choicehub_config()
{
    return [
        "name" => "Choice Hub",
        "description" => "Choice Hub control panel",
        "version" => "1.0",
        "author" => "Your Name",
        "language" => "english",
        "fields" => [
            "vod_limit" => [
                "FriendlyName" => "VoD Limit",
                "Type" => "text",
                "Size" => "25",
                "Default" => "10", // Default VoD limit
                "Description" => "Enter the VoD limit (numerical form).",
            ],
        ],
    ];
}

function choicehub_output($vars)
{
    $modulelink = 'addonmodules.php?module=choicehub_dashboard';

    // Check if the current URL matches the intended dashboard URL
    if (basename($_SERVER['PHP_SELF']) == 'addonmodules.php' && isset($_GET['module']) && $_GET['module'] == 'choicehub_dashboard') {
        $vodLimit = getVodLimit();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newVodLimit = (int)$_POST['vod_limit'];
            saveVodLimit($newVodLimit);
            $vodLimit = $newVodLimit; // Update the displayed value after saving
        }

        return <<<HTML
        <h2>Choice Hub Control Panel</h2>
        <form method="post" action="{$modulelink}">
            <label for="vod_limit">VoD Limit:</label>
            <input type="number" id="vod_limit" name="vod_limit" value="{$vodLimit}">
            <br>
            <input type="submit" class="btn btn-primary" value="Save">
        </form>
HTML;
    } else {
        // Redirect to the dashboard URL
        header("Location: {$modulelink}");
        exit;
    }
}

function getVodLimit()
{
    $setting = Capsule::table('mod_choicehub_settings')->first();
    return $setting ? $setting->vod_limit : 10; // Default VoD limit
}

function saveVodLimit($vodLimit)
{
    Capsule::table('mod_choicehub_settings')->updateOrInsert(
        ['id' => 1],
        ['vod_limit' => $vodLimit]
    );
}

function choicehub_activate()
{
    // Create the database table during module activation
    try {
        Capsule::schema()->create(
            'mod_choicehub_settings',
            function ($table) {
                $table->increments('id');
                $table->integer('vod_limit')->default(10); // Default VoD limit
            }
        );

        return [
            'status' => 'success',
            'description' => 'Module activated successfully.',
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'description' => 'Error creating mod_choicehub_settings table: ' . $e->getMessage(),
        ];
    }
}
