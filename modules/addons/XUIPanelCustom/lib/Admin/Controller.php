<?php

namespace WHMCS\Module\Addon\XUIPanelCustom\Admin;

class Controller
{
    public function index($vars)
    {
        require_once __DIR__ . '/tabs.php';
        if (isset($_GET['action']) && $_GET['action'] == "logs") {
            require_once __DIR__ . '/logs.php';
        } elseif (isset($_GET['action']) && $_GET['action'] == "addpanels") {
            require_once __DIR__ . '/panels.php';
        } elseif (isset($_GET['action']) && $_GET['action'] == "addserver") {
            require_once __DIR__ . '/addserver.php';
        } elseif (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])) {
            require_once __DIR__ . '/edit.php';
        } elseif (isset($_GET['action']) && $_GET['action'] == "categories" && !isset($_GET['id'])) {
            require_once __DIR__ . '/categories.php';
        } elseif (isset($_GET['action']) && $_GET['action'] == "categories" && isset($_GET['id'])) {
            require_once __DIR__ . '/categoriesedit.php';
        }
        elseif (isset($_GET['action']) && $_GET['action'] == "applinks") {
            require_once __DIR__ . '/applinks.php';
        } else {
            require_once __DIR__ . '/settings.php';
        }
    }
}
