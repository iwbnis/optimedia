<?php
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

// Add a hook to create the admin page
function choicehub_hook_admin_navigation($params)
{
    return [
        'addonmodule' => [
            'name' => 'Choice Hub',
            'parent' => 'addonmodules',
            'uri' => '../modules/addons/choicehub/admin/choicehub_dashboard.php',
            'icon' => 'fas fa-cogs', // You can change the icon to your preference
        ],
    ];
}

// Rest of the code remains the same as previously provided
