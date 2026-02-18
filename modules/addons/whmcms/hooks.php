<?php

if (defined("WHMCS") === false){
    die("Direct Access to this file is forbidden!");
}

# Include WHMCMS Files
require_once(ROOTDIR . '/modules/addons/whmcms/vendor/autoload.php');

use WHMCS\View\Menu\Item as MenuItem;

use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Database\Capsule;
use \WHMCMS\Menus as WHMCMSMenus;

# Init WHMCMS <head> Codes
add_hook("ClientAreaHeadOutput", 1000, function ($vars) {

    # Only Run Inside WHMCMS
    if (count(WHMCMS::fromInput($vars['whmcms'], "array")) === 0){
        return "";
    }

    $WHMCMS = $vars['whmcms'];

    $HTML = [];

    # CSS Files
    $HTML[] = '<link type="text/css" rel="stylesheet" href="' . WHMCMS::getSystemURL() . 'modules/addons/whmcms/clientarea/css/styles.css">';

    $HTML[] = '<script type="text/javascript" src="' . WHMCMS::getSystemURL() . 'modules/addons/whmcms/clientarea/js/holder.js"></script>';

    $HTML[] = '<meta property="og:title" content="' . $WHMCMS['title'] . '">';
    $HTML[] = '<meta property="og:site_name" content="' . WHMCMS::getSystemConfig("CompanyName") . '">';
    $HTML[] = '<meta property="og:url" content="' . $WHMCMS['url'] . '">';

    # Pages
    if (in_array($WHMCMS['action'], ["pages.homepage", "pages.page"])){
        # Page Description
        if (WHMCMS::fromInput($WHMCMS['data']['meta']['description']) !== ""){
            $HTML[] = '<meta name="description" content="' . $WHMCMS['data']['meta']['description'] . '">';
            $HTML[] = '<meta property="og:description" content="' . $WHMCMS['data']['meta']['description'] . '">';
        }
        # Page Keywords
        if (WHMCMS::fromInput($WHMCMS['data']['meta']['keywords']) !== ""){
            $HTML[] = '<meta name="keywords" content="' . $WHMCMS['data']['meta']['keywords'] . '">';
        }
    }

    # Portfolio Project
    if ($WHMCMS['action'] === "portfolio.project"){
        # Project Details/Case Study
        if (WHMCMS::fromInput($WHMCMS['data']['details']) !== ""){
            $metaDescription = WHMCMS::cutText(strip_tags($WHMCMS['data']['details']), 150, " ", "...");
            $HTML[] = '<meta name="description" content="' . $metaDescription . '">';
            $HTML[] = '<meta property="og:description" content="' . $metaDescription . '">';
        }

        # Project Tags
        if (WHMCMS::fromInput($WHMCMS['data']['tags'], 'array') > 0){
            $tags = [];
            foreach(WHMCMS::fromInput($WHMCMS['data']['tags'], 'array') as $tag){
                $tags[] = $tag['name'];
            }
            $HTML[] = '<meta name="keywords" content="' . join(",", $tags) . '">';
        }

        # Project Logo
        if (WHMCMS::fromInput($WHMCMS['data']['logo']) !== ""){
            $HTML[] = '<meta property="og:image" content="' . WHMCMS::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $WHMCMS['data']['logo'] . '&w=-1">';
            $HTML[] = '<link rel="image_src" href="' . WHMCMS::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $WHMCMS['data']['logo'] . '&w=-1">';
        }
    }

    # Settings -> SEO -> Images
    if (WHMCMS::fromConfig("metaimage") !== ""){
        $HTML[] = '<meta property="og:image" content="' . WHMCMS::fromConfig("metaimage") . '">';
        $HTML[] = '<link rel="image_src" href="' . WHMCMS::fromConfig("metaimage") . '">';
    }
    if (WHMCMS::fromConfig("metaimage398") !== ""){
        $HTML[] = '<meta property="og:image" content="' . WHMCMS::fromConfig("metaimage398") . '">';
        $HTML[] = '<link rel="image_src" href="' . WHMCMS::fromConfig("metaimage398") . '">';
    }

    # Customize -> CSS
    if (WHMCMS::fromConfig("customize_css") !== ""){
        $HTML[] = '<style type="text/css">';
        $HTML[] = html_entity_decode(WHMCMS::fromConfig("customize_css"), ENT_QUOTES);
        $HTML[] = '</style>';
    }

    # Customize -> Javascript
    if (WHMCMS::fromConfig("customize_js") !== ""){
        $HTML[] = '<script type="text/javascript">';
        $HTML[] = html_entity_decode(WHMCMS::fromConfig("customize_js"), ENT_QUOTES);
        $HTML[] = '</script>';
    }

    # Pages -> Header Content
    if (in_array($WHMCMS['action'], ["pages.homepage", "pages.page"]) === true && WHMCMS::fromInput($WHMCMS['data']['headoutput']) !== ""){
        $HTML[] = $WHMCMS['data']['headoutput'];
    }

    return join("\n", $HTML);

});

# WHMCMS ClientArea Footer Files
add_hook("ClientAreaFooterOutput", 1000, function ($vars) {

    # Only Run Inside WHMCMS
    if (count(WHMCMS::fromInput($vars['whmcms'], "array")) === 0){
        return "";
    }

    $HTML = [];

    $HTML[] = '<script type="text/javascript" src="' . WHMCMS::getSystemURL() . 'modules/addons/whmcms/clientarea/js/isotope/jquery.isotope.min.js"></script>';

    return join("\n", $HTML);

});

# Register WHMCMS Classes In Smarty
add_hook('ClientAreaPage', 1, function ($vars) {

    global $smarty;

    $smarty->registerClass("WHMCMS", "\WHMCMS\Base");

    $smarty->registerClass("WHMCMSMenus", "\WHMCMS\Menus");

});

# Integrate Primary Navbar
add_hook("ClientAreaPrimaryNavbar", 1000000000, function (MenuItem $primaryNavbar) {

    # Get Primary Menu ID
    $primaryId = WHMCMS::fromConfig("PrimaryNavbarCategoryid", 'int');

    # Check If Menu Exist
    $isMenuExist = Capsule::table("mod_whmcms_menucategories")
    ->where("categoryid", "=", $primaryId)
    ->count();

    # Menu Doesn't Exist
    if ($primaryId === 0 || $isMenuExist === 0) {
        return true;
    }

    # Delete Exist Primary Menu Items
    if (is_null($primaryNavbar->getChildren()) !== true) {

        foreach ($primaryNavbar->getChildren() as $menuItem) {
            $primaryNavbar->removeChild($menuItem->getName());
        }

    }

    # Get Menu Items
    $menuItems = \WHMCMS\Menus::generateMenuItems($primaryId);

    $levelOneObject = null;
    $levelOneCounter = 0;

    # Level 1
    foreach ($menuItems as $level1) {

        $levelOneObject = $primaryNavbar->addChild($level1['menuid']);
        $levelOneObject->setLabel($level1['title']);
        $levelOneObject->setURI($level1['url']);
        $levelOneObject->setOrder($levelOneCounter);

        $levelOneObject->setClass($level1['css_classes']);
        $levelOneObject->setCurrent($level1['current']);
        if (WHMCMS::fromInput($level1['badge']) !== "") {
            $levelOneObject->setBadge($level1['badge']);
        }
        if (WHMCMS::fromInput($level1['css_iconclass']) !== "") {
            $levelOneObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level1['css_iconclass'])));
        }

        # Level 2
        if (WHMCMS::fromInput($level1['childrens'], 'array') > 0) {

            $levelTwoObject = null;
            $levelTwoCounter = 0;

            foreach ($level1['childrens'] as $level2) {

                $levelTwoObject = $levelOneObject->addChild($level2['menuid']);
                if (in_array(strtolower($level2['title']), ["-----", "------", "divider"])) {
                    $levelTwoObject->setClass("nav-divider");
                    $levelTwoObject->setLabel("");
                    $levelTwoObject->setURI("#");
                    $levelTwoObject->setBadge("");
                    $levelTwoObject->setIcon("");
                }
                else {

                    $levelTwoObject->setClass($level2['css_classes']);
                    $levelTwoObject->setCurrent($level2['current']);
                    if (WHMCMS::fromInput($level2['badge']) !== "") {
                        $levelTwoObject->setBadge($level2['badge']);
                    }
                    if (WHMCMS::fromInput($level2['css_iconclass']) !== "") {
                        $levelTwoObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level2['css_iconclass'])));
                    }
                    $levelTwoObject->setLabel($level2['title']);
                    $levelTwoObject->setURI($level2['url']);
                    $levelTwoObject->setAttribute("target", $level2['target']);
                }
                $levelTwoObject->setOrder($levelTwoCounter);

                $levelTwoCounter ++;
            }

            # Level 3
            if (WHMCMS::fromInput($level2['childrens'], 'array') > 0) {

                $levelThreeObject = null;
                $levelThreeCounter = 0;

                foreach ($level2['childrens'] as $level3) {

                    $levelThreeObject = $levelTwoObject->addChild($level3['menuid']);
                    $levelThreeObject->setCurrent($level3['current']);
                    if (in_array(strtolower($level3['title']), ["-----", "------", "divider"])) {
                        $levelThreeObject->setClass("nav-divider");
                        $levelThreeObject->setLabel("");
                        $levelThreeObject->setURI("#");
                        $levelThreeObject->setBadge("");
                        $levelThreeObject->setIcon("");
                    }
                    else {

                        $levelThreeObject->setClass($level3['css_classes']);
                        $levelThreeObject->setCurrent($level3['current']);
                        if (WHMCMS::fromInput($level3['badge']) !== "") {
                            $levelThreeObject->setBadge($level3['badge']);
                        }
                        if (WHMCMS::fromInput($level3['css_iconclass']) !== "") {
                            $levelThreeObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level3['css_iconclass'])));
                        }
                        $levelThreeObject->setLabel($level3['title']);
                        $levelThreeObject->setURI($level3['url']);
                        $levelThreeObject->setAttribute("target", $level3['target']);
                    }
                    $levelThreeObject->setOrder($levelThreeCounter);

                    $levelThreeCounter ++;
                }

                # Level 4
                if (WHMCMS::fromInput($level3['childrens'], 'array') > 0) {

                    $levelFourObject = null;
                    $levelFourCounter = 0;

                    foreach ($level3['childrens'] as $level4) {

                        $levelFourObject = $levelThreeObject->addChild($level4['menuid']);
                        if (in_array(strtolower($level4['title']), ["-----", "------", "divider"])) {
                            $levelFourObject->setClass("nav-divider");
                            $levelFourObject->setLabel("");
                            $levelFourObject->setURI("#");
                            $levelFourObject->setBadge("");
                            $levelFourObject->setIcon("");
                        }
                        else {

                            $levelFourObject->setClass($level4['css_classes']);
                            $levelFourObject->setCurrent($level4['current']);
                            if (WHMCMS::fromInput($level4['badge']) !== "") {
                                $levelFourObject->setBadge($level4['badge']);
                            }
                            if (WHMCMS::fromInput($level4['css_iconclass']) !== "") {
                                $levelFourObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level4['css_iconclass'])));
                            }
                            $levelFourObject->setLabel($level4['title']);
                            $levelFourObject->setURI($level4['url']);
                            $levelFourObject->setAttribute("target", $level4['target']);
                        }
                        $levelFourObject->setOrder($levelFourCounter);

                        $levelFourCounter ++;
                    }

                }

            }

        }

        $levelOneCounter ++;

    }

});

# Integrate Secondary Navbar
add_hook("ClientAreaSecondaryNavbar", 1000000000, function (MenuItem $secondaryNavbar) {

    # Get Primary Menu ID
    $secondaryId = WHMCMS::fromConfig("SecondaryNavbarCategoryid", 'int');

    # Check If Menu Exist
    $isMenuExist = Capsule::table("mod_whmcms_menucategories")
    ->where("categoryid", "=", $secondaryId)
    ->count();

    # Menu Doesn't Exist
    if ($secondaryId === 0 || $isMenuExist === 0) {
        return true;
    }

    # Delete Exist Secondary Menu Items
    if (is_null($secondaryNavbar->getChildren()) !== true) {

        foreach ($secondaryNavbar->getChildren() as $menuItem) {
            $secondaryNavbar->removeChild($menuItem->getName());
        }

    }

    # Get Menu Items
    $menuItems = \WHMCMS\Menus::generateMenuItems($secondaryId);

    $levelOneObject = null;
    $levelOneCounter = 0;

    # Level 1
    foreach ($menuItems as $level1) {

        $levelOneObject = $secondaryNavbar->addChild($level1['menuid']);
        $levelOneObject->setLabel($level1['title']);
        $levelOneObject->setURI($level1['url']);
        $levelOneObject->setOrder($levelOneCounter);
        $levelOneObject->setClass($level1['css_classes']);
        $levelOneObject->setCurrent($level1['current']);
        if (WHMCMS::fromInput($level1['badge']) !== "") {
            $levelOneObject->setBadge($level1['badge']);
        }
        if (WHMCMS::fromInput($level1['css_iconclass']) !== "") {
            $levelOneObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level1['css_iconclass'])));
        }

        # Level 2
        if (WHMCMS::fromInput($level1['childrens'], 'array') > 0) {

            $levelTwoObject = null;
            $levelTwoCounter = 0;

            foreach ($level1['childrens'] as $level2) {

                $levelTwoObject = $levelOneObject->addChild($level2['menuid']);
                if (in_array(strtolower($level2['title']), ["-----", "------", "divider"])) {
                    $levelTwoObject->setClass("nav-divider");
                    $levelTwoObject->setLabel("");
                    $levelTwoObject->setURI("#");
                    $levelTwoObject->setBadge("");
                    $levelTwoObject->setIcon("");
                }
                else {

                    $levelTwoObject->setClass($level2['css_classes']);
                    $levelTwoObject->setCurrent($level2['current']);
                    if (WHMCMS::fromInput($level2['badge']) !== "") {
                        $levelTwoObject->setBadge($level2['badge']);
                    }
                    if (WHMCMS::fromInput($level2['css_iconclass']) !== "") {
                        $levelTwoObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level2['css_iconclass'])));
                    }
                    $levelTwoObject->setLabel($level2['title']);
                    $levelTwoObject->setURI($level2['url']);
                    $levelTwoObject->setAttribute("target", $level2['target']);
                }
                $levelTwoObject->setOrder($levelTwoCounter);

                $levelTwoCounter ++;
            }

            # Level 3
            if (WHMCMS::fromInput($level2['childrens'], 'array') > 0) {

                $levelThreeObject = null;
                $levelThreeCounter = 0;

                foreach ($level2['childrens'] as $level3) {

                    $levelThreeObject = $levelThreeObject->addChild($level3['menuid']);
                    if (in_array(strtolower($level3['title']), ["-----", "------", "divider"])) {
                        $levelThreeObject->setClass("nav-divider");
                        $levelThreeObject->setLabel("");
                        $levelThreeObject->setURI("#");
                        $levelThreeObject->setBadge("");
                        $levelThreeObject->setIcon("");
                    }
                    else {

                        $levelThreeObject->setClass($level3['css_classes']);
                        $levelThreeObject->setCurrent($level3['current']);
                        if (WHMCMS::fromInput($level3['badge']) !== "") {
                            $levelThreeObject->setBadge($level3['badge']);
                        }
                        if (WHMCMS::fromInput($level3['css_iconclass']) !== "") {
                            $levelThreeObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level3['css_iconclass'])));
                        }
                        $levelThreeObject->setLabel($level3['title']);
                        $levelThreeObject->setURI($level3['url']);
                        $levelThreeObject->setAttribute("target", $level3['target']);
                    }
                    $levelThreeObject->setOrder($levelThreeCounter);

                    $levelThreeCounter ++;
                }

                # Level 4
                if (WHMCMS::fromInput($level3['childrens'], 'array') > 0) {

                    $levelFourObject = null;
                    $levelFourCounter = 0;

                    foreach ($level3['childrens'] as $level4) {

                        $levelFourObject = $levelFourObject->addChild($level4['menuid']);
                        if (in_array(strtolower($level4['title']), ["-----", "------", "divider"])) {
                            $levelFourObject->setClass("nav-divider");
                            $levelFourObject->setLabel("");
                            $levelFourObject->setURI("#");
                            $levelFourObject->setBadge("");
                            $levelFourObject->setIcon("");
                        }
                        else {

                            $levelFourObject->setClass($level4['css_classes']);
                            $levelFourObject->setCurrent($level4['current']);
                            if (WHMCMS::fromInput($level4['badge']) !== "") {
                                $levelFourObject->setBadge($level4['badge']);
                            }
                            if (WHMCMS::fromInput($level4['css_iconclass']) !== "") {
                                $levelFourObject->setIcon(str_replace(["fa ", "glyphicon "], "", trim($level4['css_iconclass'])));
                            }
                            $levelFourObject->setLabel($level4['title']);
                            $levelFourObject->setURI($level4['url']);
                            $levelFourObject->setAttribute("target", $level4['target']);
                        }
                        $levelFourObject->setOrder($levelFourCounter);

                        $levelFourCounter ++;
                    }

                }

            }

        }

        $levelOneCounter ++;

    }

});


# Prevent access to /index.php if WHMCMS set as homepage
add_hook("ClientAreaPage", 1, function ($vars) {

    if (WHMCMS::getConfig("homepage") === "default" || WHMCMS::getConfig("homepage") === null || $vars['filename'] !== "index") {
        return [];
    }

    $requestURI = $_SERVER['REQUEST_URI'];

    $redirect = true;

    # Displaying Routable Content, Disable Redirect
    if (strpos($requestURI, "knowledgebase") || strpos($requestURI, "announcements") || strpos($requestURI, "download")) {
        $redirect = false;
    }

    # Has Query Parameters, Disable the redirect
    if (count($_REQUEST) > 0) {

        $redirect = false;

        $redirectQuery = [];

        # Remove System Parameters
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, [
                "systpl",
                "carttpl",
                "language"
            ])) {
                unset($_REQUEST[$key]);
            }
        }

        # No Query String anymore?, Enable Redirect
        if (count($_REQUEST) === 0) {
            $redirect = true;
        }

    }

    # 301 Redirect Used as 302 wasn't recommended for SEO
    if ($redirect === true) {

        header("HTTP/1.1 301 Moved Permanently");

        header("Location: " . WHMCMS::getSystemConfig("SystemURL"), true, 301);

        exit();

    }

});

# WHMCMS Admin Area Header Files
add_hook("AdminAreaHeadOutput", 1, function ($vars) {

    if ($vars['pagetitle'] !== "WHMCMS"){
        return "";
    }

    global $CONFIG;

    $files = [];

    # Since WHMCS v7.8, jQueryUI liberary was removed leaving a compatible issue with our addon
    if (version_compare("7.8", $CONFIG['Version'], '<') === true){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/jqueryui/jquery-ui.min.js"></script>';
        $files[] = '<link type="text/css" rel="stylesheet" href="../modules/addons/whmcms/assets/js/jqueryui/jquery-ui.min.css">';
    }

    $files[] = '<script type="text/javascript">var rootSystemURL = "'.WHMCMS::getSystemURL().'";</script>';
    $files[] = '<script type="text/javascript">var whmcmsURL = "'.WHMCMS::getModURL().'";</script>';
    $files[] = '<link type="text/css" rel="stylesheet" href="../modules/addons/whmcms/assets/js/validation/css/validationEngine.jquery.css">';
    $files[] = '<link type="text/css" rel="stylesheet" href="../modules/addons/whmcms/assets/css/style.css">';

    if (count(WHMCMS::fromInput(WHMCMS::__("javascript"), 'array')) > 0){

        $javascriptTranslations = [];
        $javascriptTranslations[] = '<script type="text/javascript">';
        $javascriptTranslations[] = "var WHMCMS = new Object();";

        foreach (WHMCMS::__("javascript") as $key => $value){
            $javascriptTranslations[] = "WHMCMS['" . $key . "'] = '" . $value . "';";
        }

        $javascriptTranslations[] = '</script>';

        $files[] = join("\n", $javascriptTranslations);

    }

    return join("", $files);

});

# WHMCMS Admin Area Footer Files
add_hook("AdminAreaFooterOutput", 1, function ($vars) {

    if ($vars['pagetitle'] !== "WHMCMS"){
        return "";
    }

    $files = [];

    # CKEditor
    if (WHMCMS::getConfig('editor') === "ckeditor"){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/ckeditor/ckeditor.js"></script>';
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/ckeditor/config.js"></script>';
    }

    # TinyMCE Editor
    if (WHMCMS::getConfig('editor') === "tinymce"){
        if (is_file(ROOTDIR . "/assets/js/tiny_mce/jquery.tinymce.js") === true){
            $files[] = '<script type="text/javascript" src="../assets/js/tiny_mce/jquery.tinymce.js"></script>';
            $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/tinymce/config.jquery.js"></script>';
        }
        # Since WHMCS v7.6.1
        else {
            $files[] = '<script type="text/javascript" src="../assets/js/tinymce/tinymce.min.js"></script>';
            $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/tinymce/config.js"></script>';
        }
    }

    # HTML Editor
    if (WHMCMS::getConfig('editor') === "htmleditor" || WHMCMS::fromGet('action') === "customize"){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/jseditor/ace.js"></script>';
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/jseditor/editor_config.js"></script>';
    }

    # Validation Engine
    $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/validation/languages/jquery.validationEngine-en.js"></script>';
    $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/validation/jquery.validationEngine.js"></script>';

    # Common Scripts
    $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/admin.js"></script>';

    # Pages
    if (in_array(WHMCMS::fromRequest("action"), ["listpages", "addpage", "updatepage"])){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/pages.js"></script>';
    }

    # FAQ
    if (in_array(WHMCMS::fromRequest("action"), ["faq", "listfaq", "addfaq", "updatefaq"])){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/faq.js"></script>';
    }

    # Error Pages
    if (in_array(WHMCMS::fromRequest("action"), ["errorpages", "logerrors", "updateerrorpage"])){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/errorpages.js"></script>';
    }

    # Portfolio
    if (in_array(WHMCMS::fromRequest("action"), ["portfolio", "listprojects", "listphotos", "addproject", "updateproject"])){
        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/portfolio.js"></script>';
    }

    # Menus
    if (in_array(WHMCMS::fromRequest("action"), ["menu", "listmenu", "addmenu", "updatemenu"])){
        if (WHMCMS::fromRequest("action") === "listmenu"){
            $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/sortable/sortable.js"></script>';
        }

        $files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/menus.js"></script>';
    }

    return join("", $files);

});



/**
 * Generate and Replace Current Link Back
 *
 */
add_hook("ClientAreaPage", 1, function($vars){

    if (count(WHMCMS::fromInput($vars['whmcms'], "array")) === 0){
        return [];
    }

    if (isset($vars['whmcms']['action'])){

        $linkBackURL = WHMCMS::generateFriendlyURL($vars['whmcms']['data'], $vars['whmcms']['action']);

        return ["currentpagelinkback" => $linkBackURL . ((WHMCMS::getConfig("FriendlyURLsMode") !== "basic" || $vars['whmcms']['action'] === "pages.homepage") ? "?" : "&")];

    }

});



/**
 * Load Related Content before </body>
 *
 */
add_hook("ClientAreaFooterOutput", 1, function($vars){

    if (count(WHMCMS::fromInput($vars['whmcms'], "array")) === 0){
        return "";
    }

    $files = [];

    # Pages -> Social
    if ($vars['whmcms']['data']['social']['facebookButton'] || $vars['whmcms']['data']['social']['facebookComments']){
        $files[] = '<script type="text/javascript">(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&autoLogAppEvents=1";fjs.parentNode.insertBefore(js,fjs);}(document,"script","facebook-jssdk"));</script><div id="fb-root"></div>';
    }
    if ($vars['whmcms']['data']['social']['twitterButton']){
        $files[] = '<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    }
    if ($vars['whmcms']['data']['social']['googlePlusButton']){
        $files[] = '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>';
    }

    return join("\n", $files);

});

# V3.4
add_hook('ClientAreaHeadOutput', 1, function ($vars = []) {
    if (isset($vars['whmcms']['action']) &&
        isset($vars['whmcms']['data']['selectedcategory']['id']) &&
        $vars['whmcms']['action'] == 'portfolio.category') {
        $category = Capsule::table('mod_whmcms_portfoliocategories')
            ->where('categoryid', '=', $vars['whmcms']['data']['selectedcategory']['id'])
            ->first();

        $HTML = [];

        # Page Description
        if (strlen($category->meta_description) > 0) {
            $HTML[] = '<meta name="description" content="' . $category->meta_description . '">';
            $HTML[] = '<meta property="og:description" content="' . $category->meta_description . '">';
        }

        # Page Keywords
        if (strlen($category->meta_keywords) > 0) {
            $HTML[] = '<meta name="keywords" content="' . $category->meta_keywords . '">';
        }

        # Page Keywords
        if (strlen($category->custom_head) > 0) {
            $HTML[] = html_entity_decode($category->custom_head);
        }

        return join("", $HTML);
    }
});
