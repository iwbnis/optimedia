<?php
# Minimum Version of Client Area File Required To Run Properly With This Module
define("MINIMUMFRONTENDFILEVERSION", '3.2.0');


# Include Functions File
require_once(ROOTDIR . '/modules/addons/whmcms/vendor/autoload.php');

use \WHMCMS\Database\Capsule;
use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Menus as WHMCMSMenus;

# Addon Main Config
function whmcms_config(){
    return [
        'name' => 'WHMCMS',
        'version' => '3.4.0',
        'author' => '<a href="http://www.whmcms.com" taret="_blank">SENTQ</a>',
        'language' => 'english',
        'description' => "Customized Version of WHMCMS.com Module",
        'fields' => []
    ];
}

# Install WHMCMS
function whmcms_activate(){

    $querylist = [];

    # Version 2.0
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_errorlog` (  `logid` int(11) NOT NULL AUTO_INCREMENT,  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,  `refurl` text COLLATE utf8_unicode_ci NOT NULL,  `targeturl` text COLLATE utf8_unicode_ci NOT NULL,  `datecreate` datetime NOT NULL,  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `useragent` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`logid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_errorpages` (  `pageid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `content` longtext COLLATE utf8_unicode_ci NOT NULL,  `datemodify` datetime NOT NULL,  `datelastvisit` datetime NOT NULL,  `hits` int(11) NOT NULL DEFAULT '0',  `language` varchar(25) COLLATE utf8_unicode_ci NOT NULL,  `headercontent` text COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`pageid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_faq` (  `faqid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `groupid` int(11) NOT NULL,  `question` text COLLATE utf8_unicode_ci NOT NULL,  `answer` text COLLATE utf8_unicode_ci NOT NULL,  `enable` tinyint(1) NOT NULL DEFAULT '1',  `hits` int(11) NOT NULL DEFAULT '0',  `datecreate` datetime NOT NULL,  `datemodify` datetime NOT NULL,  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`faqid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_faqgroups` (  `groupid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `alias` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `hits` int(11) NOT NULL DEFAULT '0',  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`groupid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_menu` (  `menuid` int(10) NOT NULL AUTO_INCREMENT,  `categoryid` int(11) NOT NULL,  `topid` int(11) NOT NULL DEFAULT '0',  `parentid` int(11) NOT NULL DEFAULT '0',  `title` text COLLATE utf8_unicode_ci NOT NULL,  `url` text COLLATE utf8_unicode_ci NOT NULL,  `url_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `target` enum('_self','_blank') COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self',  `reorder` int(11) NOT NULL DEFAULT '0',  `enable` int(1) NOT NULL DEFAULT '1',  `private` int(1) NOT NULL DEFAULT '0',  `css_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `css_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `css_hassubclass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `css_submenuclass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `datecreate` datetime NOT NULL,  `datemodify` datetime NOT NULL,  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`menuid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_menucategories` (  `categoryid` int(11) NOT NULL AUTO_INCREMENT,  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `css_class` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `css_id` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`categoryid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_pages` (  `pageid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `parentid` int(11) NOT NULL DEFAULT '0',  `alias` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `subtitle` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `content` longtext COLLATE utf8_unicode_ci NOT NULL,  `private` int(1) NOT NULL DEFAULT '0',  `metadescription` text COLLATE utf8_unicode_ci NOT NULL,  `metakeywords` text COLLATE utf8_unicode_ci NOT NULL,  `datecreate` datetime NOT NULL,  `datemodify` datetime NOT NULL,  `enable` tinyint(1) NOT NULL DEFAULT '1',  `hits` int(11) NOT NULL DEFAULT '0',  `language` varchar(25) COLLATE utf8_unicode_ci NOT NULL,  `metaindex` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `metafollow` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `metaarchive` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `metaodp` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `metasnippet` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `hidetitle` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `breadcrumbs` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `googleplus` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `fblike` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `twitter` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `fbcomment` varchar(2) COLLATE utf8_unicode_ci NOT NULL,  `headercontent` text COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`pageid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_photos` (  `photoid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `parentid` int(11) NOT NULL,  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `details` text COLLATE utf8_unicode_ci NOT NULL,  `source` text COLLATE utf8_unicode_ci NOT NULL,  `datemodify` datetime NOT NULL,  `enable` tinyint(1) NOT NULL DEFAULT '0',  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`photoid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_portfolio` (  `projectid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `client` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `alias` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `url` text COLLATE utf8_unicode_ci NOT NULL,  `details` text COLLATE utf8_unicode_ci NOT NULL,  `logo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `tags` text COLLATE utf8_unicode_ci NOT NULL,  `enable` tinyint(1) NOT NULL DEFAULT '0',  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  `datemodify` datetime NOT NULL,  `datecreate` datetime NOT NULL,  `datepublished` varchar(20) COLLATE utf8_unicode_ci NOT NULL,  `hits` int(11) NOT NULL DEFAULT '0',  PRIMARY KEY (`projectid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_portfoliocategories` (  `categoryid` int(11) NOT NULL AUTO_INCREMENT,  `topid` int(11) NOT NULL DEFAULT '0',  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `alias` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `enable` int(1) NOT NULL DEFAULT '1',  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`categoryid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_portfoliorelations` (  `projectid` int(11) NOT NULL,  `categoryid` int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "CREATE TABLE IF NOT EXISTS `mod_whmcms_settings` (  `varname` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  `value` text COLLATE utf8_unicode_ci NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $querylist[] = "INSERT INTO `mod_whmcms_errorpages` (`pageid`, `topid`, `code`, `title`, `content`, `datemodify`, `datelastvisit`, `hits`, `language`, `headercontent`) VALUES (1, 0, '400', '400 Bad Request', '&lt;p&gt;The request cannot be fulfilled due to bad syntax.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(2, 0, '403', '403 Forbidden', '&lt;p&gt;The server has refused to fulfil your request.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(3, 0, '404', '404 Not Found', '&lt;p&gt;The page you requested was not found on this server.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(4, 0, '405', '405 Method Not Allowed', '&lt;p&gt;The method specified in the request is not allowed for the specified resource.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(5, 0, '408', '408 Request Timeout', '&lt;p&gt;Your browser failed to send a request in the time allowed by the server.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(6, 0, '500', '500 Internal Server Error', '&lt;p&gt;The request was unsuccessful due to an unexpected condition encountered by the server.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(7, 0, '502', '502 Bad Gateway', '&lt;p&gt;The server received an invalid response while trying to carry out the request.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', ''),(8, 0, '504', '504 Gateway Timeout', '&lt;p&gt;The upstream server failed to send a request in the time allowed by the server.&lt;/p&gt;', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'english', '');";
    $querylist[] = "INSERT INTO `mod_whmcms_settings` (`varname`, `value`) VALUES ('photowidth', '800'),('photoheight', '600'),('thumbwidth', '200'),('thumbheight', '200'),('imagequality', '90'),('customize_css', ''),('customize_js', ''),('frontendfile', 'whmcms.php'),('homepage', 'default'),('editor', 'ckeditor'),('seourls', 'disable'),('portfoliolayout', 'filter'),('portfolioitemsinrow', '3'),('portfolioitemsinpage', ''),('error400', 'disable'),('error403', 'disable'),('error404', 'disable'),('error405', 'disable'),('error408', 'disable'),('error500', 'disable'),('error502', 'disable'),('error504', 'disable'),('whmcsdir', ''),('metatags', 'enable'),('metakeywords', 'default, meta, keywords'),('metadescription', 'default meta description'),('metaimage', ''),('portfoliosort', 'DESC'),('portfoliofilterby', 'category');";

    # Version 2.1
    $querylist[] = "INSERT INTO `mod_whmcms_settings` (`varname` ,`value`) VALUES ('metaimage398', '');";

    # Version 2.1.1
    $querylist[] = "ALTER TABLE  `mod_whmcms_menu` ADD  `css_iconclass` VARCHAR( 250 ) NOT NULL AFTER  `css_submenuclass`";
    $querylist[] = "ALTER TABLE  `mod_whmcms_menu` ADD  `menucondition` VARCHAR( 100 ) NOT NULL AFTER  `css_iconclass`";
    $querylist[] = "ALTER TABLE  `mod_whmcms_menu` ADD  `menubadge` VARCHAR( 100 ) NOT NULL AFTER  `menucondition`";
    $querylist[] = "ALTER TABLE  `mod_whmcms_menucategories` ADD  `css_activeclass` VARCHAR( 100 ) NOT NULL";

    foreach($querylist as $key => $queryorder){
        Capsule::statement($queryorder);
    }

    # Version 2.3.0
    WHMCMS::setConfig("vsixtemplate", "yes");

	# Upgrade To Version 2.5.0
    WHMCMS::setConfig("UploadEnableCache", "yes");
    WHMCMS::setConfig("UploadCachePeriod", 24);
    WHMCMS::setConfig("UploadResizeWidth", 400);
    WHMCMS::setConfig("UploadDirectory", "attachments");
    WHMCMS::setConfig("UploadCustomDirectory", "");
    WHMCMS::setConfig("PrimaryNavbarCategoryid", 0);
    WHMCMS::setConfig("SecondaryNavbarCategoryid", 0);

    # Version 2.5.1
    WHMCMS::setConfig("AutoApplyRewriteRules", "yes");

    # Version 3.0.0
    Capsule::statement("ALTER TABLE `mod_whmcms_menucategories` ADD `integration` TINYINT(1) NOT NULL DEFAULT '0' AFTER `css_activeclass`;");
    WHMCMS::setConfig("FriendlyURLsMode", "basic");

    # Version 3.4
    Capsule::statement("ALTER TABLE `mod_whmcms_portfolio` ADD `introvideo` TEXT NULL DEFAULT NULL AFTER `logo`;");
    Capsule::statement("ALTER TABLE `mod_whmcms_portfoliocategories` ADD `meta_description` TEXT NULL DEFAULT NULL AFTER `language`, ADD `meta_keywords` TEXT NULL DEFAULT NULL AFTER `meta_description`, ADD `custom_head` TEXT NULL DEFAULT NULL AFTER `meta_keywords`;");

    return [
        'status' => 'success',
        'description' => 'WHMCMS installed successfully.'
    ];

}

# Upgrade WHMCMS
function whmcms_upgrade($vars) {

    $queries = [];

    $version = $vars['version'];

    # Upgrade WHMCMS From v2.0 to v2.1
    if (version_compare($version, '2.1', "<") === true){
        WHMCMS::setConfig("metaimage398", "");
    }

    # Upgrade WHMCMS From v2.1 to v2.1.1
    if (version_compare($version, '2.1.1', "<") === true){

        $queries = [];
        $queries[] = "ALTER TABLE  `mod_whmcms_menu` ADD  `css_iconclass` VARCHAR( 250 ) NOT NULL AFTER  `css_submenuclass`;";
        $queries[] = "ALTER TABLE  `mod_whmcms_menu` ADD  `menucondition` VARCHAR( 100 ) NOT NULL AFTER  `css_iconclass`;";
        $queries[] = "ALTER TABLE  `mod_whmcms_menu` ADD  `menubadge` VARCHAR( 100 ) NOT NULL AFTER  `menucondition`;";
        $queries[] = "ALTER TABLE  `mod_whmcms_menucategories` ADD  `css_activeclass` VARCHAR( 100 ) NOT NULL;";

        foreach($queries as $key => $queryorder){
            Capsule::statement($queryorder);
        }

    }

	# Upgrade To Version 2.5.0
    if (version_compare($version, '2.5.0', "<") === true){
    	WHMCMS::setConfig("UploadEnableCache", "yes");
        WHMCMS::setConfig("UploadCachePeriod", 24);
        WHMCMS::setConfig("UploadResizeWidth", 400);
        WHMCMS::setConfig("UploadDirectory", "attachments");
        WHMCMS::setConfig("UploadCustomDirectory", "");
        WHMCMS::setConfig("PrimaryNavbarCategoryid", 0);
        WHMCMS::setConfig("SecondaryNavbarCategoryid", 0);
    }

    # Version 2.5.1
    if (version_compare($version, '2.5.1', "<") === true){
        WHMCMS::setConfig("AutoApplyRewriteRules", "yes");
    }

    # Version 3.0.0
    if (version_compare($version, '3.0.0', "<") === true){
        Capsule::statement("ALTER TABLE `mod_whmcms_menucategories` ADD `integration` TINYINT(1) NOT NULL DEFAULT '0' AFTER `css_activeclass`;");
        WHMCMS::setConfig("FriendlyURLsMode", "basic");
    }

    # Version 3.4.0
    if (version_compare($version, '3.4.0', "<") === true) {
        Capsule::statement("ALTER TABLE `mod_whmcms_portfolio` ADD `introvideo` TEXT NULL DEFAULT NULL AFTER `logo`;");
        Capsule::statement("ALTER TABLE `mod_whmcms_portfoliocategories` ADD `meta_description` TEXT NULL DEFAULT NULL AFTER `language`, ADD `meta_keywords` TEXT NULL DEFAULT NULL AFTER `meta_description`, ADD `custom_head` TEXT NULL DEFAULT NULL AFTER `meta_keywords`;");
    }

    return [
        'status' => 'success',
        'description' => 'WHMCMS updated successfully.'
    ];

}

# Uninstall WHMCMS
function whmcms_deactivate() {

    $queries = [];

    $queries[] = "DROP TABLE `mod_whmcms_errorlog`;";
    $queries[] = "DROP TABLE `mod_whmcms_errorpages`;";
    $queries[] = "DROP TABLE `mod_whmcms_faq`;";
    $queries[] = "DROP TABLE `mod_whmcms_faqgroups`;";
    $queries[] = "DROP TABLE `mod_whmcms_menu`;";
    $queries[] = "DROP TABLE `mod_whmcms_menucategories`;";
    $queries[] = "DROP TABLE `mod_whmcms_pages`;";
    $queries[] = "DROP TABLE `mod_whmcms_photos`;";
    $queries[] = "DROP TABLE `mod_whmcms_portfolio`;";
    $queries[] = "DROP TABLE `mod_whmcms_portfoliocategories`;";
    $queries[] = "DROP TABLE `mod_whmcms_portfoliorelations`;";
    $queries[] = "DROP TABLE `mod_whmcms_settings`;";

    foreach($queries as $index => $query){
        Capsule::statement($query);
    }

    return [
        'status' => 'success',
        'description' => 'WHMCMS successfully deactivated.'
    ];

}

/****************************
* Output Functions
*****************************/

# SideBar WHMCMS
function whmcms_sidebar($vars) {

    global $CONFIG;

    $moduleLink = $vars['modulelink'];
    $moduleVersion = $vars['version'];

    $WHMCSVersion = $CONFIG['Version'];

    $sidebar = "";

    if (version_compare($WHMCSVersion, '8.0.0', ">=") === true){
        $updateAvailable = '<a href="' . $moduleLink . '&action=updates" class="label label-danger"><i class="fa fa-fw fa-download"></i> ' . WHMCMS::__("sideBarUpdateNow") . '</a>';
        $updateLatest = '<a href="' . $moduleLink . '&action=updates" class="label label-success">' . WHMCMS::__("sideBarUptoDate") . '</a>';

        $sidebar = '<div class="sidebar-header"><i class="fa fa-home"></i> WHMCMS</div>
        <ul class="menu whmcms_sidemenu_v8">
            <li><a href="' . $moduleLink . '"><i class="fa fa-fw fa-tachometer-alt fa-dashboard"></i> ' . WHMCMS::__("sideBarDashboard") . '</a></li>
            <li><a href="' . $moduleLink . '&action=listpages"><i class="fa fa-fw fa-file-alt fa-file-text"></i> ' . WHMCMS::__("sideBarPages") . '</a></li>
            <li><a href="' . $moduleLink . '&action=menu"><i class="fa fa-fw fa-bars"></i> ' . WHMCMS::__("sideBarMenu") . '</a></li>
            <li><a href="' . $moduleLink . '&action=faq"><i class="fa fa-fw fa-question-circle"></i> ' . WHMCMS::__("sideBarFaq") . '</a></li>
            <li><a href="' . $moduleLink . '&action=errorpages"><i class="fa fa-fw fa-times"></i> ' . WHMCMS::__("sideBarErrorPages") . '</a></li>
            <li><a href="' . $moduleLink . '&action=customize"><i class="fa fa-fw fa-code"></i> ' . WHMCMS::__("sideBarCustomize") . '</a></li>
            <li><a href="' . $moduleLink . '&action=settings"><i class="fa fa-fw fa-cog"></i> ' . WHMCMS::__("sideBarSettings") . '</a></li>
            <li><a href="' . $moduleLink . '&action=support"><i class="fa fa-fw fa-question-circle"></i> ' . WHMCMS::__("sideBarSupport") . '</a></li>
            <li><a href="' . $moduleLink . '&action=updates"><i class="fa fa-fw fa-download"></i> ' . WHMCMS::__("sideBarVersion") . ' ' . $moduleVersion . '</a></li>
        </ul>';

        $sidebar .= '<div class="label-version-v8">' . (version_compare(WHMCMS::getLatestVersion(), $moduleVersion, ">") ? $updateAvailable : $updateLatest) . '</div>';

        $sidebar .= '<div class="sidebar-header"><i class="fa fa-image fa-picture-o"></i> ' . WHMCMS::__("sideBarPortfolio") . '</div>
        <ul class="menu whmcms_sidemenu_v8">
            <li><a href="' . $moduleLink . '&action=listprojects"><i class="fa fa-fw fa-image fa-picture-o"></i> ' . WHMCMS::__("sideBarProjects") . '</a></li>
            <li><a href="' . $moduleLink . '&action=portfolio"><i class="fa fa-fw fa-folder-open"></i> ' . WHMCMS::__("sideBarCategories") . '</a></li>
        </ul>';

        return $sidebar;
    }

    $updateAvailable = '<a href="' . $moduleLink . '&action=updates" class="label label-danger">' . WHMCMS::__("sideBarUpdateNow") . '</a>';
    $updateLatest = '<a href="' . $moduleLink . '&action=updates" class="label label-success">' . WHMCMS::__("sideBarUptoDate") . '</a>';

    $sidebar = '<span class="header"><i class="fa fa-home"></i> WHMCMS</span>
    <ul class="menu whmcms_sidemenu">
        <li><a href="' . $moduleLink . '"><i class="fa fa-fw fa-tachometer-alt fa-dashboard"></i> ' . WHMCMS::__("sideBarDashboard") . '</a></li>
        <li><a href="' . $moduleLink . '&action=listpages"><i class="fa fa-fw fa-file-alt fa-file-text"></i> ' . WHMCMS::__("sideBarPages") . '</a></li>
        <li><a href="' . $moduleLink . '&action=menu"><i class="fa fa-fw fa-bars"></i> ' . WHMCMS::__("sideBarMenu") . '</a></li>
        <li><a href="' . $moduleLink . '&action=faq"><i class="fa fa-fw fa-question-circle"></i> ' . WHMCMS::__("sideBarFaq") . '</a></li>
        <li><a href="' . $moduleLink . '&action=errorpages"><i class="fa fa-fw fa-times"></i> ' . WHMCMS::__("sideBarErrorPages") . '</a></li>
        <li><a href="' . $moduleLink . '&action=customize"><i class="fa fa-fw fa-code"></i> ' . WHMCMS::__("sideBarCustomize") . '</a></li>
        <li><a href="' . $moduleLink . '&action=settings"><i class="fa fa-fw fa-cog"></i> ' . WHMCMS::__("sideBarSettings") . '</a></li>
        <li><a href="' . $moduleLink . '&action=support"><i class="fa fa-fw fa-question-circle"></i> ' . WHMCMS::__("sideBarSupport") . '</a></li>
        <li><a href="' . $moduleLink . '&action=updates"><i class="fa fa-fw fa-download"></i> ' . WHMCMS::__("sideBarVersion") . ' ' . $moduleVersion . '</a></li>
        <li class="label-version">' . (version_compare(WHMCMS::getLatestVersion(), $moduleVersion, ">") ? $updateAvailable : $updateLatest) . '</li>
    </ul>';

    $sidebar .= '<span class="header"><i class="fa fa-image fa-picture-o"></i> ' . WHMCMS::__("sideBarPortfolio") . '</span>
    <ul class="menu whmcms_sidemenu">
        <li><a href="' . $moduleLink . '&action=listprojects"><i class="fa fa-fw fa-image fa-picture-o"></i> ' . WHMCMS::__("sideBarProjects") . '</a></li>
        <li><a href="' . $moduleLink . '&action=portfolio"><i class="fa fa-fw fa-folder-open"></i> ' . WHMCMS::__("sideBarCategories") . '</a></li>
    </ul>';

    return $sidebar;

}


# Addon Index Content
function whmcms_output($vars) {

    global $attachments_dir, $templates_compiledir;

    # Define Module Setting from WHMCS
    define("MODURL", $vars['modulelink']);
    define("MODVERSION", $vars['version']);
    define("TEMPLATE", ROOTDIR . '/modules/addons/whmcms/assets/tpl/');
    define("DB_PREFIX"  , 'mod_whmcms_');

    # init Smarty
    $smarty = new Smarty();
	$smarty->setCompileDir($templates_compiledir);
	$smarty->setTemplateDir(ROOTDIR . "/modules/addons/whmcms/assets/tpl/");
	$smarty->compile_id = "efccb7ef69c80261e2fba91ae5d82688";
	$smarty->registerClass("WHMCMS", "\WHMCMS\Base");

    $smarty->assign('modurl', MODURL);

    #**********************************************
    #**********************************************

    # Define Actions Vars
    $action = WHMCMS::fromRequest('action');
    $pageId = WHMCMS::fromRequest('pageid', 'int');
    $categoryId = WHMCMS::fromRequest('categoryid', 'int');
    $projectId = WHMCMS::fromRequest('projectid', 'int');
    $photoId = WHMCMS::fromRequest('photoid', 'int');
    $groupId = WHMCMS::fromRequest('groupid', 'int');
    $faqId = WHMCMS::fromRequest('faqid', 'int');
    $menuId = WHMCMS::fromRequest('menuid', 'int');
    $code = WHMCMS::fromRequest('code', 'int');
    $pagenum = WHMCMS::fromRequest('page', 'int');
    $tab = WHMCMS::fromRequest('tab');

    $smarty->assign('action', $action);
    $smarty->assign('pageid', $pageId);
    $smarty->assign('categoryid', $categoryId);
    $smarty->assign('projectid', $projectId);
    $smarty->assign('photoid', $photoId);
    $smarty->assign('groupid', $groupId);
    $smarty->assign('faqid', $faqId);
    $smarty->assign('menuid', $menuId);
    $smarty->assign('code', $code);
    $smarty->assign('pagenum', $pagenum);
    $smarty->assign('tab', $tab);
    $smarty->assign('editor', WHMCMS::getConfig("editor"));

    if (WHMCMS::getSystemConfig("SystemSSLURL") !== null){
        $_systemurl = str_replace('https:', '', WHMCMS::getSystemConfig("SystemSSLURL"));
    }
    else {
        $_systemurl = str_replace('http:', '', WHMCMS::getSystemConfig("SystemURL"));
    }
    $smarty->assign('_systemurl', $_systemurl);

    # Handle AJAX Requests
    $ajax = WHMCMS::fromRequest('ajax', 'int');
    $isAjax = false;
    if ($ajax === 1){

        $isAjax = true;

        header("HTTP/1.1 200 OK;");

        header("Content-Type: application/json; charset=utf-8;");

    }

    # BreadCrumbs
    $BC = [];
    $BC[ MODURL ] = WHMCMS::__("breadcrumbsDashboard");


    /****************************
    * Module Actions
    *****************************/
    # ~
    if (1 === 1){

        # Dashboard
        if ($action === ""){

            $integration = ["errors" => [], "warnings" => [], "successful" => []];

            # Get Latest Version Number
            if (WHMCMS::isUpToDate() === "update available"){

                $integration['errors'][] = [
                    "title" => "New Version Available",
                    "description" => "update to the latest version to benefit from latest improvements, fixes and new features."
                ];

            }
            elseif (WHMCMS::isUpToDate() === "unknown"){

                $integration['warnings'][] = [
                    "title" => "v" . MODVERSION,
                    "description" => "unable to determine whether you have the latest version or not, visit <a href='https://www.whmcms.com/' target='_blank'>www.whmcms.com</a> for more information"
                ];

            }
            elseif (WHMCMS::isUpToDate() === "up to date"){

                $integration['successful'][] = [
                    "title" => "Up To Date",
                    "description" => "Your installation is up-to-date, check this page in regular basis to be informed when new version became available."
                ];

            }

            # Turn on SEO URLs
            /*
            if (WHMCMS::getConfig('seourls') === "disable"){

                $integration['warnings'][] = [
                    "title" => "Turn SEO URLs ON",
                    "description" => "This feature will make your URLs looks more professional and search engine friendly, <a href='" . MODURL . "&action=settings'>enable</a> it now."
                ];

            }
            */

            # htaccess file does not exists, or not writable (if Auto Apply SEO Rules ON)
            if (!is_file(ROOTDIR . "/.htaccess") || !is_writable(ROOTDIR . "/.htaccess")){

                $integration['errors'][] = [
                    "title" => ".htaccess file not exists",
                    "description" => "make sure \".htaccess\" file exists and writable in WHMCS main directory in order to use SEO Friendly URLs, <a href='https://www.whmcms.com/knowledgebase/11/SEO-Friendly-URLs.html' target='_blank'>click here</a> for more information."
                ];

            }

            # htaccess code need to be updated (Provide button to Apply automatically + link to manual code)
            $isRewriteRulesUpToDate = WHMCMS::isRewriteRulesUpToDate();
            if ($isRewriteRulesUpToDate['result'] === "nomatch"){

                $integration['errors'][] = [
                    "title" => "Rewrite Rules Outdated",
                    "description" => ".htaccess file has outdated rules, please update it in order for WHMCMS to work as expected <a href='" . MODURL . "&action=applyrewriterules'>click here</a> to apply the updated rules automatically (recommended), or you may copy the <a href='" . MODURL . "&action=customize&tab=htaccess'>required rules</a> and apply it manually, <a href='https://www.whmcms.com/knowledgebase/11/SEO-Friendly-URLs.html' target='_blank'>click here</a> for more information."
                ];

            }

            # Default Templates integration
            if (is_file(ROOTDIR . "/templates/" . WHMCMS::getSystemConfig('Template') . "/whmcms/output.tpl") === false){
                $integration['errors'][] = [
                    "title" => "Default Template Integration Missing",
                    "description" => "The default template (" . WHMCMS::getSystemConfig('Template') . ") missing the required integration for WHMCMS to work as expected, you need to copy this directory \"/templates/six/<b>whmcms</b>/\" from WHMCMS downloaded .zip file, <a href='https://www.whmcms.com/knowledgebase/9/Template-Integration.html' target='_blank'>click here</a> for more information."
                ];
            }

            # Templates integrations
            $missingTemplates = [];
            foreach (WHMCMS::getClientAreaTemplates(true) as $template){

                if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/output.tpl") === false){
                    $missingTemplates[] = $template;
                }

            }
            if (count($missingTemplates) > 0){

                $integration['warnings'][] = [
                    "title" => "Template Integration Missing",
                    "description" => "The following template(s) does not have the required integration for WHMCMS to work as expected if/when you switch to one of them:<br>+ " . join("<br>+ ", $missingTemplates) . "<br><br>You need to copy this directory \"/templates/six/<b>whmcms</b>/\" from WHMCMS downloaded .zip file inside each of the mentioned templates directory, <a href='https://www.whmcms.com/knowledgebase/9/Template-Integration.html' target='_blank'>click here</a> for more information."
                ];

            }

            # Frontend file doesn't exists
            if (is_file(ROOTDIR . "/" . WHMCMS::getConfig('frontendfile')) === false){

                $integration['errors'][] = [
                    "title" => "Client Area File Missing",
                    "description" => "The following file (" . WHMCMS::getConfig('frontendfile') . ") does not exists in WHMCS main directory, copy the original file from latest version of WHMCMS .zip file and upload it to WHMCS main directory, and/or make sure WHMCMS -> <a href='" . MODURL . "&action=settings'>General Settings</a> has the right file name, <a href='https://www.whmcms.com/knowledgebase/13/Client-Area-File.html' target='_blank'>click here</a> for more information."
                ];

            }
            else {

                # Frontend File Version Doesn't match (old)
                $frontendFileVersion = WHMCMS::getFrontendFileVersion();
                $requireFileVersion = MINIMUMFRONTENDFILEVERSION;

                if (version_compare($requireFileVersion, $frontendFileVersion, ">") === true && $frontendFileVersion !== false){

                    $integration['errors'][] = [
                        "title" => "Client Area File Outdated",
                        "description" => "Update (" . WHMCMS::getConfig('frontendfile') . ") file located in WHMCS main directory to the latest version, <a href='https://www.whmcms.com/knowledgebase/13/Client-Area-File.html' target='_blank'>click here</a> for more information."
                    ];

                }

            }

            # Upload Directory doesn't exists or not writable
            if (WHMCMS::getConfig('UploadDirectory') === "custom"){

                if (is_dir(WHMCMS::getConfig('UploadCustomDirectory')) === false || is_writable(WHMCMS::getConfig('UploadCustomDirectory')) === false){

                    $integration['errors'][] = [
                        "title" => "Upload Directory",
                        "description" => "The following directory (" . WHMCMS::getConfig('UploadCustomDirectory') . ") does not exists or not writable, you need to fix this in order for WHMCMS to upload images."
                    ];

                }

            }


            $smarty->assign("integration", $integration);

            # Display Index Template
            $templateFile = "index.tpl";

            $smarty->assign("noBreadcrumbButton", true);

        }

        # Generate Alias
        elseif ($action === "generatealias"){

            $string = WHMCMS::fromPost('string');

            $relType = WHMCMS::fromPost('reltype');

            $relId = WHMCMS::fromPost('relid', 'int');

            $generateAlias = WHMCMS::validateAlias($relType, $relId, "", $string);

            if ($generateAlias === null){
                echo json_encode(["alias" => ""]);
                exit;
            }

            echo json_encode(["alias" => $generateAlias]);

            exit;

        }

        /********************************
        * Page Functions Started
        *********************************/
        # Page List
        elseif ($action === "listpages") {

            # Select Pages
            $getPages = Capsule::table("mod_whmcms_pages")
            ->where("topid", 0);

            # Init Pagination
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'listpages';
            $pagination = pagination($getPages->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Pages
            $getPages->orderBy("pageid", "asc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);
            foreach ($getPages->get() as $page){
                $page = (array) $page;

                $page['datemodify'] = ($page['datemodify']=='0000-00-00 00:00:00')? $page['datecreate']: $page['datemodify'];
                $page['datemodify'] = fromMySQLDate($page['datemodify'], true, false);

                $page['viewurl'] = WHMCMS::generateFriendlyURL($page, "pages.page");

                # Get Parent Page
                $getParentPage = Capsule::table("mod_whmcms_pages")
                ->where("pageid", "=", $page['parentid'])
                ->first();
                $page['parent'] = ["id" => intval($getParentPage->pageid), "title" => $getParentPage->title];

                $pagelist[] = $page;
                unset($page['child']);
            }
            $smarty->assign('pages', $pagelist);
            $smarty->assign('pagination', $pagination);

            $templateFile = "pages.tpl";

            $BC[ MODURL . "&action=listpages" ] = WHMCMS::__("breadcrumbsPages");

        }

        # Add Page Form
        elseif ($action === "addpage"){

            # Page Main Form
            $smarty->assign('pageMain', pageForm('', 'main', '', $smarty));

            # Page Editor Form
            $smarty->assign('pageEditor', pageForm('', 'editor', '', $smarty));

            # Page Options Form
            $smarty->assign('pageOptions', pageForm('', 'options', '', $smarty));

            # Page Advanced Form
            $smarty->assign('pageAdvanced', pageForm('', 'advanced', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => pageForm('', 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "pages.tpl";

            $BC[ MODURL . "&action=listpages" ] = WHMCMS::__("breadcrumbsPages");
            $BC[ MODURL . "&action=addpage" ] = WHMCMS::__("breadcrumbsPagesAdd");

            $smarty->assign("goBackURL", MODURL . "&action=listpages");

        }

        # Add Page Data
        elseif ($action === "doaddpage"){

            $alias = WHMCMS::validateAlias("pages", 0, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Page Data
            $data = [
                'topid' => 0,
                'parentid' => WHMCMS::fromPost('parentid', "int"),
                'alias' => WHMCMS::fromInput($alias),
                'title' => WHMCMS::fromPost('title'),
                'subtitle' => WHMCMS::fromPost('subtitle'),
                'content' => WHMCMS::fromPost('content'),
                'private' => WHMCMS::fromPost('private', "int"),
                'metadescription' => WHMCMS::fromPost('description'),
                'metakeywords' => WHMCMS::fromPost('keywords'),
                'datecreate' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', "int"),
                'language' => WHMCMS::getSystemDefaultLanguage(),
                'hidetitle' => WHMCMS::fromPost('hidetitle'),
                'breadcrumbs' => WHMCMS::fromPost('breadcrumbs'),
                'googleplus' => WHMCMS::fromPost('googleplus'),
                'fblike' => WHMCMS::fromPost('fblike'),
                'fbcomment' => WHMCMS::fromPost('fbcomment'),
                'twitter' => WHMCMS::fromPost('twitter'),
                'headercontent' => WHMCMS::fromPost('headercontent')
            ];

            # Main Page Insert
            $pageId = Capsule::table("mod_whmcms_pages")
            ->insertGetId($data);

            # Page Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    Capsule::table("mod_whmcms_pages")
                    ->insert([
                        'topid' => $pageId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'subtitle' => WHMCMS::fromInput($_POST['translate_subtitle'][ $language ]),
                        'content' => WHMCMS::fromInput($_POST['translate_content'][ $language ])
                    ]);

                }

            }

            WHMCMS::redirect(WHMCMS::__("pageCreatedMessage"), 'success', MODURL . '&action=updatepage&pageid=' . $pageId);

        }

        # Update Page Form
        elseif ($action === "updatepage"){

            $pageId = WHMCMS::fromRequest('pageid', "int");

            # Get Page
            $getPage = Capsule::table("mod_whmcms_pages")
            ->where("pageid", "=", $pageId)
            ->first();

            # Page Main Form
            $smarty->assign('pageMain', pageForm($pageId, 'main', '', $smarty));

            # Page Editor Form
            $smarty->assign('pageEditor', pageForm($pageId, 'editor', '', $smarty));

            # Page Options Form
            $smarty->assign('pageOptions', pageForm($pageId, 'options', '', $smarty));

            # Page Advanced Form
            $smarty->assign('pageAdvanced', pageForm($pageId, 'advanced', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => pageForm($pageId, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "pages.tpl";

            $BC[ MODURL . "&action=listpages" ] = WHMCMS::__("breadcrumbsPages");
            $BC[ MODURL . "&action=addpage" ] = WHMCMS::__("breadcrumbsPagesEdit") . $getPage->title;

            $smarty->assign("goBackURL", MODURL . "&action=listpages");

        }

        # Update Page Data
        elseif ($action === "doupdatepage"){

            $pageId = WHMCMS::fromRequest("pageid", "int");

            $alias = WHMCMS::validateAlias("pages", $pageId, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Page Data
            $data = [
                'topid' => 0,
                'parentid' => WHMCMS::fromPost('parentid', "int"),
                'alias' => WHMCMS::fromInput($alias),
                'title' => WHMCMS::fromPost('title'),
                'subtitle' => WHMCMS::fromPost('subtitle'),
                'content' => WHMCMS::fromPost('content'),
                'private' => WHMCMS::fromPost('private', "int"),
                'metadescription' => WHMCMS::fromPost('description'),
                'metakeywords' => WHMCMS::fromPost('keywords'),
                'datemodify' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', "int"),
                'language' => WHMCMS::getSystemDefaultLanguage(),
                'hidetitle' => WHMCMS::fromPost('hidetitle'),
                'breadcrumbs' => WHMCMS::fromPost('breadcrumbs'),
                'googleplus' => WHMCMS::fromPost('googleplus'),
                'fblike' => WHMCMS::fromPost('fblike'),
                'fbcomment' => WHMCMS::fromPost('fbcomment'),
                'twitter' => WHMCMS::fromPost('twitter'),
                'headercontent' => WHMCMS::fromPost('headercontent')
            ];

            # Main Page Insert
            Capsule::table("mod_whmcms_pages")
            ->where("pageid", "=", $pageId)
            ->update($data);

            # Delete Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', "int") > 0){
                Capsule::table("mod_whmcms_pages")
                ->where("pageid", "=", WHMCMS::fromPost('deletetranslation', "int"))
                ->delete();
            }

            # Page Translation Insert
            foreach (WHMCMS::fromPost('translate_title', "array") as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $pageId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'subtitle' => WHMCMS::fromInput($_POST['translate_subtitle'][ $language ]),
                        'content' => WHMCMS::fromInput($_POST['translate_content'][ $language ])
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_pages")
                    ->where("topid", "=", $pageId)
                    ->where("language", "=", $language);

                    # Insert Translation
                    if ($getTranslation->count() === 0){
                        Capsule::table("mod_whmcms_pages")
                        ->insert($data);
                    }
                    # Update Translation
                    else {
                        $getTranslation->update($data);
                    }

                }

            }

            # Return To Pages
            if (isset($_POST['saveandreturn'])){

                WHMCMS::redirect(WHMCMS::__("pageUpdatedMessage"), 'success', MODURL . '&action=listpages');

            }

            WHMCMS::redirect(WHMCMS::__("pageUpdatedMessage"), 'success', MODURL . '&action=updatepage&pageid=' . $pageId);

        }

        # Delete Page & Child Pages Form
        elseif ($action=="deletepage"){

            $pageId = WHMCMS::fromRequest('pageid', "int");

            # Select Page Title
            $getPageInfo = Capsule::table("mod_whmcms_pages")
            ->where("pageid", "=", $pageId)
            ->where("topid", "=", 0)
            ->first();
            $pagedata = (array) $getPageInfo;

            $smarty->assign('pagedata', $pagedata);

            $templateFile = "pages.tpl";

        }

        # Delete Page & Child Pages Data
        else if ($action=="dodeletepage"){

            $pageId = WHMCMS::fromRequest('pageid', "int");

            # Update Child Pages
            Capsule::table("mod_whmcms_pages")
            ->where("parentid", "=", $pageId)
            ->update(['parentid' => '0']);

            # Delete Page
            Capsule::table("mod_whmcms_pages")
            ->where("pageid", "=", $pageId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_pages")
            ->where("topid", "=", $pageId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("pageDeletedMessage"), 'success', MODURL . '&action=listpages');

        }

        # Disbale/Enable Page
        elseif (in_array($action, ['disablepage', 'enablepage', 'privatepage'])){

            $pageId = WHMCMS::fromRequest('pageid', "int");

            if ($action === 'disablepage'){

                Capsule::table("mod_whmcms_pages")
                ->where("pageid", "=", $pageId)
                ->update(['enable' => 0]);

            }
            elseif ($action === 'enablepage'){

                Capsule::table("mod_whmcms_pages")
                ->where("pageid", "=", $pageId)
                ->update(['enable' => 1]);

            }
            elseif ($action === 'privatepage'){

                Capsule::table("mod_whmcms_pages")
                ->where("pageid", "=", $pageId)
                ->update(['private' => WHMCMS::fromRequest('status', "int")]);

            }

            # Return Ajax Response
            if ($isAjax === true){

                echo json_encode(["result" => "success"]);

                exit;

            }

            WHMCMS::redirect('', '', MODURL.'&action=listpages');

        }

        # Page Bulk Actions
        else if ($action=='bulkpage'){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', "array")) > 0 && $bulkaction != ""){

                foreach (WHMCMS::fromPost('bulkcheckbox', "array") as $index => $pageId){

                    if ($bulkaction == 'public'){

                        Capsule::table("mod_whmcms_pages")
                        ->where("pageid", "=", $pageId)
                        ->update(['private' => 0]);

                    }
                    elseif ($bulkaction=='private'){

                        Capsule::table("mod_whmcms_pages")
                        ->where("pageid", "=", $pageId)
                        ->update(['private' => 1]);

                    }
                    elseif ($bulkaction=='publish'){

                        Capsule::table("mod_whmcms_pages")
                        ->where("pageid", "=", $pageId)
                        ->update(['enable' => 1]);

                    }
                    elseif ($bulkaction=='unpublish'){

                        Capsule::table("mod_whmcms_pages")
                        ->where("pageid", "=", $pageId)
                        ->update(['enable' => 0]);

                    }
                    elseif ($bulkaction=='hits'){

                        Capsule::table("mod_whmcms_pages")
                        ->where("pageid", "=", $pageId)
                        ->update(['hits' => 0]);

                    }

                }
            }

            WHMCMS::redirect('', '', MODURL.'&action=listpages');

        }
        /********************************
        * Page Functions Ended
        *********************************/

        /********************************
        * Portfolio Categories Started
        *********************************/
        # Portfolio Category List
        elseif ($action === "portfolio") {

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            /**********************
            * Adding Category Form
            ***********************/
            # Category Main Form
            $smarty->assign('categoryMain', categoryForm(0, 'main', '', $smarty));
            $smarty->assign('categoryMeta', categoryForm(0, 'meta', '', $smarty));

            # Category Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => categoryForm(0, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            /**********************
            * Category List
            ***********************/

            # Get Categories
            $getCategories = Capsule::table("mod_whmcms_portfoliocategories")
            ->where("topid", "=", 0);

            # Init Pagination
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'portfolio';
            $pagination = pagination($getCategories->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Categories
            $getCategories->orderBy("categoryid", "asc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            foreach ($getCategories->get() as $category){
                $category = (array) $category;

                # Total Projects
                $getProjectsTotal = Capsule::table("mod_whmcms_portfoliorelations")
                ->where("categoryid", "=", $category['categoryid']);
                $category['projects'] = $getProjectsTotal->count();

                # Update Category Form
                $category['categoryMain'] = categoryForm($category['categoryid'], 'main', '', $smarty);
                $category['categoryMeta'] = categoryForm($category['categoryid'], 'meta', '', $smarty);
                $category['viewurl'] = WHMCMS::generateFriendlyURL($category, "portfolio.category");

                # Category Translate Forms
                $translations = [];
                foreach ($languages as $language){
                    $translation = [
                        'formid' => WHMCMS::randomInt(),
                        'language' => $language,
                        'form' => categoryForm($category['categoryid'], 'translate', $language, $smarty)
                    ];
                    $translations[] = $translation;
                }
                $category['translations'] = $translations;

                $categories[] = $category;
            }
            $smarty->assign('categories', $categories);

            $smarty->assign('pagination', $pagination);

            $templateFile = "portfolio.tpl";

            $BC[ MODURL . "&action=portfolio" ] = WHMCMS::__("portfolioPageTitle");

        }

        # Add Portfolio Category Data
        elseif ($action === "doaddcategory"){

            $alias = WHMCMS::validateAlias("portfolio-category", 0, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Category Data
            $data = [
                'topid' => 0,
                'title' => WHMCMS::fromPost('title'),
                'alias' => WHMCMS::fromInput($alias),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'language' => WHMCMS::getSystemDefaultLanguage(),
                'meta_description' => WHMCMS::fromInput($_POST['meta_description']),
                'meta_keywords' => WHMCMS::fromInput($_POST['meta_keywords']),
                'custom_head' => $_POST['custom_head'],
            ];

            # Main Category Insert
            $categoryId = Capsule::table("mod_whmcms_portfoliocategories")
            ->insertGetId($data);

            # Category Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){
                if (WHMCMS::fromInput($title) !== ""){
                    $data = [
                        'topid' => $categoryId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title)
                    ];

                    Capsule::table("mod_whmcms_portfoliocategories")
                    ->insert($data);
                }
            }

            WHMCMS::redirect(WHMCMS::__("portfolioCategoryCreatedMessage"), 'success', MODURL . '&action=portfolio');

        }

        # Update Category Data
        elseif ($action === "doupdatecategory"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            $alias = WHMCMS::validateAlias("portfolio-category", $categoryId, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Category Data
            $data = [
                'topid' => 0,
                'title' => WHMCMS::fromPost('title'),
                'alias' => WHMCMS::fromInput($alias),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'language' => WHMCMS::getSystemDefaultLanguage(),
                'meta_description' => WHMCMS::fromInput($_POST['meta_description']),
                'meta_keywords' => WHMCMS::fromInput($_POST['meta_keywords']),
                'custom_head' => $_POST['custom_head'],
            ];

            # Main Category Insert
            Capsule::table("mod_whmcms_portfoliocategories")
            ->where("categoryid", "=", $categoryId)
            ->update($data);

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') !== 0){

                Capsule::table("mod_whmcms_portfoliocategories")
                ->where("categoryid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();

            }

            # Category Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $categoryId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title)
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_portfoliocategories")
                    ->where("topid", "=", $categoryId)
                    ->where("language", "=", $language);

                    if ($getTranslation->count()=='0'){

                        Capsule::table("mod_whmcms_portfoliocategories")
                        ->insert($data);

                    }
                    else {

                        Capsule::table("mod_whmcms_portfoliocategories")
                        ->where("topid", "=", $categoryId)
                        ->where("language", $language)
                        ->update($data);

                    }
                }
            }

            WHMCMS::redirect(WHMCMS::__("portfolioCategoryUpdatedMessage"), 'success', MODURL . '&action=portfolio');

        }

        # Delete Category
        elseif ($action === "dodeletecategory"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            # Delete Category
            Capsule::table("mod_whmcms_portfoliocategories")
            ->where("categoryid", "=", $categoryId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_portfoliocategories")
            ->where("topid", "=", $categoryId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("portfolioCategoryDeletedMessage"), 'success', MODURL . '&action=portfolio');

        }

        # Disbale/Enable Category
        elseif ($action === "disablecategory" || $action === "enablecategory"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            if ($action === "disablecategory"){

                Capsule::table("mod_whmcms_portfoliocategories")
                ->where("categoryid", "=", $categoryId)
                ->update(['enable' => 0]);

            }
            elseif ($action === "enablecategory"){

                Capsule::table("mod_whmcms_portfoliocategories")
                ->where("categoryid", "=", $categoryId)
                ->update(['enable' => 1]);

            }

            # Return Ajax Response
            if ($isAjax === true){

                echo json_encode(["result" => "success"]);

                exit;

            }

            WHMCMS::redirect('', '', MODURL . '&action=portfolio');

        }

        # Category Bulk Actions
        elseif ($action === "bulkcategory"){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction!=''){

                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $categoryId){

                    if ($bulkaction === "publish"){

                        Capsule::table("mod_whmcms_portfoliocategories")
                        ->where("categoryid", "=", $categoryId)
                        ->update(['enable' => 1]);

                    }
                    elseif ($bulkaction === "unpublish"){

                        Capsule::table("mod_whmcms_portfoliocategories")
                        ->where("categoryid", "=", $categoryId)
                        ->update(['enable' => 0]);

                    }

                }
            }

            WHMCMS::redirect('', '', MODURL.'&action=portfolio');

        }
        /********************************
        * Portfolio Categories Ended
        *********************************/

        /********************************
        * Portfolio Projects Started
        *********************************/
        # Portfolio List
        elseif ($action === "listprojects") {

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            # Get Category
            $getCategory = Capsule::table("mod_whmcms_portfoliocategories")
            ->where("categoryid", "=", $categoryId)
            ->first();
            $getCategory = (array) $getCategory;

            $pageParams = array();

            # Get Projects
            $getProjects = Capsule::table("mod_whmcms_portfolio")
            ->where("topid", "=", 0);

            if ($categoryId != 0){

                $pageParams['categoryid'] = $categoryId;

                $getProjects->join("mod_whmcms_portfoliorelations", "mod_whmcms_portfoliorelations.projectid", "=", "mod_whmcms_portfolio.projectid");
                $getProjects->where("mod_whmcms_portfoliorelations.categoryid", "=", $categoryId);

            }

            # Init Pagination
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'listprojects';
            $pagination = pagination($getProjects->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Projects
            $getProjects->orderBy("mod_whmcms_portfolio.projectid", "asc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            $projects = [];

            foreach ($getProjects->get() as $project){

                $project = (array) $project;

                # Select Total Photos
                $getTotalPhotos = Capsule::table("mod_whmcms_photos")
                ->where("topid", "=", 0)
                ->where("parentid", "=", $project['projectid'])
                ->count();

                $project['photos'] = $getTotalPhotos;

                $project['datemodify'] = ($project['datemodify']=='0000-00-00 00:00:00')? $project['datecreate']: $project['datemodify'];
                $project['datemodify'] = fromMySQLDate($project['datemodify'], true, false);

                $project['viewurl'] = WHMCMS::generateFriendlyURL($project, "portfolio.project");

                $projects[] = $project;

            }
            $smarty->assign('projects', $projects);

            $smarty->assign('pagination', $pagination);

            $templateFile = "portfolio.tpl";

            $BC[ MODURL . "&action=portfolio" ] = WHMCMS::__("portfolioPageTitle");

            if ($categoryId > 0){
                $BC[ MODURL . "&action=listprojects&categoryid=" . $categoryId ] = $getCategory['title'] . " " . WHMCMS::__("projectsPageTitle");
            }
            else {
                $BC[ MODURL . "&action=listprojects" ] = WHMCMS::__("projectsPageTitle");
            }

        }

        # Add Project Form
        elseif ($action === "addproject"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            # Get Category
            $getCategory = Capsule::table("mod_whmcms_portfoliocategories")
            ->where("categoryid", "=", $categoryId)
            ->first();
            $getCategory = (array) $getCategory;

            # Project Main Form
            $smarty->assign('projectMain', projectForm('', 'main', '', $smarty));

            # Project Main Editor
            $smarty->assign('projectMainEditor', projectForm('', 'maineditor', '', $smarty));

            # Project Options Form
            $smarty->assign('projectOptions', projectForm('', 'options', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => projectForm(0, 'translate', $language, $smarty)
                ];

                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "portfolio.tpl";

            $BC[ MODURL . "&action=portfolio" ] = WHMCMS::__("portfolioPageTitle");

            $BC[ MODURL . "&action=listprojects" ] = WHMCMS::__("projectsPageTitle");

            $BC[ MODURL . "&action=addproject" ] = WHMCMS::__("projectsCreatePageTitle");

            $smarty->assign("goBackURL", MODURL . "&action=listprojects&categoryid=" . $categoryId);

        }

        # Add Project Data
        elseif ($action === "doaddproject"){

            $alias = WHMCMS::validateAlias("portfolio-project", 0, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Upload Logo
            $uploadLogo = \WHMCMS\Upload::uploadImage(["file" => $_FILES['projectlogo']]);

            # Project Data
            $data = [
                'topid' => 0,
                'alias' => WHMCMS::fromInput($alias),
                'title' => WHMCMS::fromPost('title'),
                'client' => WHMCMS::fromPost('client'),
                'url' => WHMCMS::fromPost('url'),
                'details' => WHMCMS::fromPost('details'),
                'tags' => WHMCMS::fromPost('tags'),
                'logo' => WHMCMS::fromInput($uploadLogo['filename']),
                'datecreate' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'datepublished' => WHMCMS::fromPost('datepublished'),
                'language' => WHMCMS::getSystemDefaultLanguage(),
            ];

            # Main Page Insert
            $projectId = Capsule::table("mod_whmcms_portfolio")
            ->insertGetId($data);

            # Assign Categories to the Project
            if (count(WHMCMS::fromPost('categoryid', 'array')) > 0){

                foreach (WHMCMS::fromPost('categoryid', 'array') as $index => $categoryId){

                    Capsule::table("mod_whmcms_portfoliorelations")
                    ->insert([
                        'projectid' => $projectId,
                        'categoryid' => $categoryId
                    ]);

                }
            }

            # Project Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $projectId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'details' => WHMCMS::fromInput($_POST['translate_details'][ $language ])
                    ];

                    Capsule::table("mod_whmcms_portfolio")
                    ->insert($data);

                }

            }

            WHMCMS::redirect(WHMCMS::__("projectCreatedMessage"), 'success', MODURL . '&action=updateproject&projectid=' . $projectId);

        }

        # Update Project Form
        elseif ($action === "updateproject"){

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Get Project
            $getProject = Capsule::table("mod_whmcms_portfolio")
            ->where("projectid", "=", $projectId)
            ->first();
            $getProject = (array) $getProject;

            # Project Main Form
            $smarty->assign('projectMain', projectForm($projectId, 'main', '', $smarty));

            # Project Main Editor
            $smarty->assign('projectMainEditor', projectForm($projectId, 'maineditor', '', $smarty));

            # Project Options Form
            $smarty->assign('projectOptions', projectForm($projectId, 'options', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => projectForm($projectId, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "portfolio.tpl";

            $BC[ MODURL . "&action=portfolio" ] = WHMCMS::__("portfolioPageTitle");

            $BC[ MODURL . "&action=listprojects" ] = WHMCMS::__("projectsPageTitle");

            $BC[ MODURL . "&action=updateproject&projectid=" . $projectId ] = WHMCMS::__("projectsUpdatePageTitle") . $getProject['title'];

            $smarty->assign("goBackURL", MODURL . "&action=listprojects");

        }

        # Update Project Data
        elseif ($action === "doupdateproject"){

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            $alias = WHMCMS::validateAlias("portfolio-project", $projectId, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Upload Logo
            $uploadLogo = \WHMCMS\Upload::uploadImage(["file" => $_FILES['projectlogo']]);

            # Project Data
            $data = [
                'topid' => 0,
                'alias' => WHMCMS::fromInput($alias),
                'title' => WHMCMS::fromPost('title'),
                'client' => WHMCMS::fromPost('client'),
                'url' => WHMCMS::fromPost('url'),
                'details' => WHMCMS::fromPost('details'),
                'tags' => WHMCMS::fromPost('tags'),
                'datemodify' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'datepublished' => WHMCMS::fromPost('datepublished'),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            if (WHMCMS::fromInput($uploadLogo['filename']) !== ""){
                $data['logo'] = $uploadLogo['filename'];
            }

            # Main Project Insert
            Capsule::table("mod_whmcms_portfolio")
            ->where("projectid", "=", $projectId)
            ->update($data);

            # Assign Categories to the Project
            Capsule::table("mod_whmcms_portfoliorelations")
            ->where("projectid", "=", $projectId)
            ->delete();

            if (count(WHMCMS::fromPost('categoryid', 'array')) > 0){
                foreach (WHMCMS::fromPost('categoryid', 'array') as $index => $categoryId){
                    $relationData = [
                        'projectid' => $projectId,
                        'categoryid' => $categoryId
                    ];

                    Capsule::table("mod_whmcms_portfoliorelations")
                    ->insert($relationData);
                }
            }

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') > 0){
                Capsule::table("mod_whmcms_portfolio")
                ->where("projectid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();
            }

            # Project Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $projectId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'details' => WHMCMS::fromInput($_POST['translate_details'][ $language ])
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_portfolio")
                    ->where("topid", "=", $projectId)
                    ->where("language", "=", $language);

                    if ($getTranslation->count()=='0'){
                        Capsule::table("mod_whmcms_portfolio")
                        ->insert($data);
                    }
                    else {
                        Capsule::table("mod_whmcms_portfolio")
                        ->where("topid", "=", $projectId)
                        ->where("language", "=", $language)
                        ->update($data);
                    }

                }

            }

            # Upload Intro Video
            $uploadIntroVideo = \WHMCMS\Upload::uploadVideo('projectintrovideo');

            if ($uploadIntroVideo !== false) {
                if ($uploadIntroVideo['result'] == 'error') {
                    WHMCMS::redirect($uploadIntroVideo['message'], 'error', MODURL . '&action=listprojects');
                } else {
                    # Main Project Insert
                    Capsule::table("mod_whmcms_portfolio")
                        ->where("projectid", "=", $projectId)
                        ->update([
                            'introvideo' => $uploadIntroVideo['file'],
                        ]);
                }
            }

            if ($_POST['deleteprojectintrovideo'] != 0) {

                # Get Project
                $project = Capsule::table("mod_whmcms_portfolio")
                    ->where("projectid", "=", $projectId)
                    ->first();

                if (file_exists(ROOTDIR . '/videos/' . $project->introvideo)) {
                    @unlink(ROOTDIR . '/videos/' . $project->introvideo);
                }

                Capsule::table("mod_whmcms_portfolio")
                    ->where("projectid", "=", $projectId)
                    ->update([
                        'introvideo' => null,
                    ]);
            }

            # Return To Projects
            if (isset($_POST['saveandreturn'])){

                WHMCMS::redirect(WHMCMS::__("projectUpdatedMessage"), 'success', MODURL . '&action=updateproject&projectid=' . $projectId);

            }

            WHMCMS::redirect(WHMCMS::__("projectUpdatedMessage"), 'success', MODURL . '&action=updateproject&projectid=' . $projectId);

        }

        # Delete Project & Project Translation Data
        elseif ($action === "dodeleteproject"){

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Delete Project
            Capsule::table("mod_whmcms_portfolio")
            ->where("projectid", "=", $projectId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_portfolio")
            ->where("topid", "=", $projectId)
            ->delete();

            # Delete Project Relations
            Capsule::table("mod_whmcms_portfoliorelations")
            ->where("projectid", "=", $projectId)
            ->delete();

            # Delete Project Photos
            Capsule::table("mod_whmcms_photos")
            ->where("parentid", "=", $projectId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("projectDeletedMessage"), 'success', MODURL . '&action=listprojects');

        }

        # Disbale/Enable Project
        elseif ($action === "disableproject" || $action == "enableproject"){

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            if ($action === "disableproject"){
                Capsule::table("mod_whmcms_portfolio")
                ->where("projectid", "=", $projectId)
                ->update(['enable' => 0]);
            }
            elseif ($action=='enableproject'){
                Capsule::table("mod_whmcms_portfolio")
                ->where("projectid", "=", $projectId)
                ->update(['enable' => 1]);
            }

            # Return Ajax Response
            if ($isAjax === true){

                echo json_encode(["result" => "success"]);

                exit;

            }

            WHMCMS::redirect('', '', MODURL.'&action=listprojects');

        }

        # Project Bulk Actions
        elseif ($action === "bulkproject"){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromRequest('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction !== ""){
                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $projectId){

                    if ($bulkaction === "publish"){
                        Capsule::table("mod_whmcms_portfolio")
                        ->where("projectid", "=", $projectId)
                        ->update(['enable' => 1]);
                    }
                    elseif ($bulkaction === "unpublish"){
                        Capsule::table("mod_whmcms_portfolio")
                        ->where("projectid", "=", $projectId)
                        ->update(['enable' => 0]);
                    }
                    elseif ($bulkaction === "hits"){
                        Capsule::table("mod_whmcms_portfolio")
                        ->where("projectid", "=", $projectId)
                        ->update(['hits' => 0]);
                    }

                }
            }

            WHMCMS::redirect('', '', MODURL.'&action=listprojects');

        }

        # Portfolio List
        elseif ($action === "listphotos") {

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Get Project
            $getProject = Capsule::table("mod_whmcms_portfolio")
            ->where("projectid", "=", $projectId)
            ->first();
            $getProject = (array) $getProject;

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            /**********************
            * Adding Photo Form
            ***********************/
            # Photo Main Form
            $smarty->assign('photoMain', photoForm(0, 'main', '', $smarty));

            # Photo Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => photoForm(0, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            # Get Photos
            $getPhotos = Capsule::table("mod_whmcms_photos");

            # Paging Params
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'listphotos';

            if ($projectId > 0){
                $pageParams['projectid'] = $projectId;
                $getPhotos->where("topid", "=", 0)
                ->where("parentid", "=", $projectId);
            }
            else {
                $getPhotos->where("topid", 0);
            }

            # Select Project Title
            $getProjectTitles = Capsule::table("mod_whmcms_portfolio")
            ->where("topid", "=", 0);

            $projects = [];

            foreach ($getProjectTitles->get() as $project){
                $project = (array) $project;

                $projects[ $project['projectid'] ] = $project['title'];
            }

            # Init Pagination
            $pagination = pagination($getPhotos->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Photos
            $getPhotos->orderBy("photoid", "desc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            $photos = [];

            foreach ($getPhotos->get() as $photo){
                $photo = (array) $photo;

                # Update Photo Form
                $photo['photoMain'] = photoForm($photo['photoid'], 'main', '', $smarty);

                # Photo Translate Forms
                $translations = [];
                foreach ($languages as $language){
                    $translation = [
                        'formid' => WHMCMS::randomInt(),
                        'language' => $language,
                        'form' => photoForm($photo['photoid'], 'translate', $language, $smarty)
                    ];
                    $translations[] = $translation;
                }
                $photo['translations'] = $translations;

                $photo['project'] = $projects[ $photo['parentid'] ];

                $photo['datemodify'] = fromMySQLDate($photo['datemodify'], true, false);

                $photo['viewurl'] = WHMCMS::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $photo['source'];

                $photos[] = $photo;
            }
            $smarty->assign('photos', $photos);

            $smarty->assign('pagination', $pagination);

            $templateFile = "portfolio.tpl";

            $BC[ MODURL . "&action=portfolio" ] = WHMCMS::__("portfolioPageTitle");

            $BC[ MODURL . "&action=listprojects" ] = WHMCMS::__("projectsPageTitle");

            $BC[ MODURL . "&action=updateproject&projectid=" . $projectId ] = $getProject['title'];

            $BC[ MODURL . "&action=listphotos&projectid=" . $projectId ] = WHMCMS::__("photosPageTitle");

        }

        # Add Portfolio Photo Data
        elseif ($action === "doaddphoto"){

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Upload Photo
            $uploadPhoto = \WHMCMS\Upload::uploadImage(["file" => $_FILES['source']]);

            # Photo Data
            $data = [
                'topid' => 0,
                'parentid' => $projectId,
                'title' => WHMCMS::fromPost('title'),
                'details' => WHMCMS::fromPost('details'),
                'source' => WHMCMS::fromInput($uploadPhoto['filename']),
                'datemodify' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            # Main Photo Insert
            $photoId = Capsule::table("mod_whmcms_photos")
            ->insertGetId($data);

            # Photo Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $photoId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'details' => WHMCMS::fromInput($_POST['translate_details'][ $language ])
                    ];

                    Capsule::table("mod_whmcms_photos")
                    ->insert($data);

                }

            }

            WHMCMS::redirect(WHMCMS::__("photoCreatedMessage"), 'success', MODURL . '&action=listphotos&projectid=' . $projectId);

        }

        # Update Photo Data
        elseif ($action=="doupdatephoto"){

            $photoId = WHMCMS::fromRequest('photoid', 'int');
            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Upload Photo
            $uploadPhoto = \WHMCMS\Upload::uploadImage(["file" => $_FILES['source']]);

            # Photo Data
            $data = [
                'topid' => 0,
                'title' => WHMCMS::fromPost('title'),
                'details' => WHMCMS::fromPost('details'),
                'datemodify' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            if (WHMCMS::fromInput($uploadPhoto['filename']) !== ""){
                $data['source'] = $uploadPhoto['filename'];
            }

            # Main Photo Insert
            Capsule::table("mod_whmcms_photos")
            ->where("photoid", "=", $photoId)
            ->update($data);

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') !== 0){
                Capsule::table("mod_whmcms_photos")
                ->where("photoid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();
            }

            # Photo Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $photoId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'details' => WHMCMS::fromInput($_POST['translate_details'][ $language ])
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_photos")
                    ->where("topid", "=", $photoId)
                    ->where("language", "=", $language);

                    if ($getTranslation->count() === 0){
                        Capsule::table("mod_whmcms_photos")
                        ->insert($data);
                    }
                    else {
                        Capsule::table("mod_whmcms_photos")
                        ->where("topid", "=", $photoId)
                        ->where("language", "=", $language)
                        ->update($data);
                    }

                }

            }

            WHMCMS::redirect(WHMCMS::__("photoUpdatedMessage"), 'success', MODURL . '&action=listphotos&projectid=' . $projectId);

        }

        # Delete Photo
        elseif ($action === "dodeletephoto"){

            $photoId = WHMCMS::fromRequest('photoid', 'int');
            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Delete Photo
            Capsule::table("mod_whmcms_photos")
            ->where("photoid", "=", $photoId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_photos")
            ->where("topid", "=", $photoId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("photoDeletedMessage"), 'success', MODURL . '&action=listphotos&projectid=' . $projectId);

        }

        # Disbale/Enable Photo
        elseif ($action === "disablephoto" || $action === "enablephoto"){

            $photoId = WHMCMS::fromRequest('photoid', 'int');
            $projectId = WHMCMS::fromRequest('projectid', 'int');

            if ($action === "disablephoto"){
                Capsule::table("mod_whmcms_photos")
                ->where("photoid", "=", $photoId)
                ->update(['enable' => 0]);
            }
            elseif ($action === "enablephoto"){
                Capsule::table("mod_whmcms_photos")
                ->where("photoid", "=", $photoId)
                ->update(['enable' => 1]);
            }

            # Return Ajax Response
            if ($isAjax === true){

                echo json_encode(["result" => "success"]);

                exit;

            }

            WHMCMS::redirect('', '', MODURL . '&action=listphotos&projectid=' . $projectId);

        }

        # Photo Bulk Actions
        elseif ($action === "bulkphotos"){

            $projectId = WHMCMS::fromRequest('projectid', 'int');

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction !== ""){
                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $photoId){

                    if ($bulkaction === "publish"){
                        Capsule::table("mod_whmcms_photos")
                        ->where("photoid", "=", $photoId)
                        ->update(['enable' => 1]);
                    }
                    elseif ($bulkaction === "unpublish"){
                        Capsule::table("mod_whmcms_photos")
                        ->where("photoid", "=", $photoId)
                        ->update(['enable' => 0]);
                    }

                }
            }

            WHMCMS::redirect('', '', MODURL.'&action=listphotos&projectid=' . $projectId);

        }
        /********************************
        * Portfolio Projects Ended
        *********************************/

        /********************************
        * FAQ Groups Started
        *********************************/
        # FAQ Groups List
        elseif ($action === "faq") {

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            /**********************
            * Adding Group Form
            ***********************/
            # FAQ Group Main Form
            $smarty->assign('faqGroupMain', faqGroupForm(0, 'main', '', $smarty));

            # FAQ Group Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => faqGroupForm(0, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            /**********************
            * Groups List
            ***********************/

            # Get Groups
            $getGroups = Capsule::table("mod_whmcms_faqgroups")
            ->where("topid", "=", 0);

            # Init Pagination
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'faq';
            $pagination = pagination($getGroups->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Groups
            $getGroups->orderBy("groupid", "asc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            foreach ($getGroups->get() as $group){

                $group = (array) $group;

                # Total Questions
                $getTotalQuestions = Capsule::table("mod_whmcms_faq")
                ->where("groupid", "=", $group['groupid'])
                ->count();
                $group['questions'] = $getTotalQuestions;

                # Update Group Form
                $group['groupMain'] = faqGroupForm($group['groupid'], 'main', '', $smarty);

                # Group Translate Forms
                $translations = [];
                foreach ($languages as $language){
                    $translation = [
                        'formid' => WHMCMS::randomInt(),
                        'language' => $language,
                        'form' => faqGroupForm($group['groupid'], 'translate', $language, $smarty)
                    ];
                    $translations[] = $translation;
                }
                $group['translations'] = $translations;

                $group['viewurl'] = WHMCMS::generateFriendlyURL($group, "faq.group");

                $groups[] = $group;
            }
            $smarty->assign('groups', $groups);

            $smarty->assign('pagination', $pagination);

            $templateFile = "faq.tpl";

            $BC[ MODURL . "&action=faq" ] = WHMCMS::__("faqPageTitle");

        }

        # Add FAQ Group Data
        elseif ($action === "doaddgroup"){

            $alias = WHMCMS::validateAlias("faq", 0, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Main Group Insert
            $groupId = Capsule::table("mod_whmcms_faqgroups")
            ->insertGetId([
                'topid' => 0,
                'title' => WHMCMS::fromPost('title'),
                'alias' => WHMCMS::fromInput($alias),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ]);

            # Groups Translation Insert
            foreach (WHMCMS::fromPost('translate_title') as $language => $title){
                if (WHMCMS::fromInput($title) !== ""){
                    Capsule::table("mod_whmcms_faqgroups")
                    ->insert([
                        'topid' => $groupId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title)
                    ]);
                }
            }

            WHMCMS::redirect(WHMCMS::__("faqGroupCreatedMessage"), 'success', MODURL . '&action=faq');

        }

        # Update FAQ Group Data
        elseif ($action === "doupdategroup"){

            $groupId = WHMCMS::fromRequest('groupid', 'int');

            $alias = WHMCMS::validateAlias("faq", $groupId, WHMCMS::fromPost('alias'), WHMCMS::fromPost('title'));

            # Group Data
            $data = [
                'topid' => 0,
                'title' => WHMCMS::fromPost('title'),
                'alias' => WHMCMS::fromInput($alias),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            # Main FAQ Group Update
            Capsule::table("mod_whmcms_faqgroups")
            ->where("groupid", "=", $groupId)
            ->update($data);

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') > 0){
                Capsule::table("mod_whmcms_faqgroups")
                ->where("groupid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();
            }

            # Group Translation Insert
            foreach (WHMCMS::fromPost('translate_title') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = array(
                        'topid' => $groupId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title)
                    );

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_faqgroups")
                    ->where("topid", "=", $groupId)
                    ->where("language", "=", $language);
                    if ($getTranslation->count()=='0'){
                        Capsule::table("mod_whmcms_faqgroups")
                        ->insert($data);
                    }
                    else {
                        Capsule::table("mod_whmcms_faqgroups")
                        ->where("topid", "=", $groupId)
                        ->where("language", "=", $language)
                        ->update($data);
                    }

                }

            }

            WHMCMS::redirect(WHMCMS::__("faqGroupUpdatedMessage"), 'success', MODURL . '&action=faq');

        }

        # Delete FAQ Group
        elseif ($action === "dodeletegroup"){

            $groupId = WHMCMS::fromRequest('groupid', 'int');

            # Delete Group
            Capsule::table("mod_whmcms_faqgroups")
            ->where("groupid", "=", $groupId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_faqgroups")
            ->where("topid", "=", $groupId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("faqGroupDeletedMessage"), 'success', MODURL . '&action=faq');

        }

        # FAQ Group Bulk Actions
        elseif ($action === 'bulkgroup'){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction !== ""){
                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $groupId){

                    if ($bulkaction === 'delete'){
                        Capsule::table("mod_whmcms_faqgroups")
                        ->where("groupid", "=", $groupId)
                        ->delete();
                    }

                }
            }

            WHMCMS::redirect('', '', MODURL . '&action=faq');

        }
        /********************************
        * FAQ Groups Ended
        *********************************/

        /********************************
        * FAQ Items Started
        *********************************/
        # FAQ Items List
        else if ($action=="listfaq") {

            $groupId = WHMCMS::fromGet('groupid', 'int');

            # Get FAQ Group
            $getGroup = Capsule::table("mod_whmcms_faqgroups")
            ->where("groupid", "=", $groupId)
            ->first();
            $getGroup = (array) $getGroup;

            # Get FAQ Items
            $getItems = Capsule::table("mod_whmcms_faq")
            ->where("topid", "=", 0)
            ->where("groupid", "=", $groupId);

            # Init Pagination
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'listfaq';
            $pageParams['groupid'] = $groupId;
            $pagination = pagination($getItems->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select FAQ Items
            $getItems->orderBy("faqid", "asc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            foreach ($getItems->get() as $item){
                $item = (array) $item;

                $item['datemodify'] = ($item['datemodify']=='0000-00-00 00:00:00')? $item['datecreate']: $item['datemodify'];
                $item['datemodify'] = fromMySQLDate($item['datemodify'], true, false);

                $items[] = $item;
            }
            $smarty->assign('items', $items);

            $smarty->assign('pagination', $pagination);

            $templateFile = "faq.tpl";

            $BC[ MODURL . "&action=faq" ] = WHMCMS::__("faqPageTitle");
            $BC[ MODURL . "&action=listfaq&groupid=" . $groupId ] = $getGroup['title'];

        }

        # Add FAQ Item Form
        elseif ($action === "addfaq"){

            $groupId = WHMCMS::fromRequest('groupid', 'int');

            # Get FAQ Group
            $getGroup = Capsule::table("mod_whmcms_faqgroups")
            ->where("groupid", "=", $groupId)
            ->first();
            $getGroup = (array) $getGroup;

            # FAQ Main Form
            $smarty->assign('faqMain', faqItemForm('', 'main', '', $smarty));

            # FAQ Main Editor
            $smarty->assign('faqMainEditor', faqItemForm('', 'maineditor', '', $smarty));

            # FAQ Options Form
            $smarty->assign('faqOptions', faqItemForm('', 'options', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = array(
                    'language' => $language,
                    'form' => faqItemForm(0, 'translate', $language, $smarty)
                );
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "faq.tpl";

            $BC[ MODURL . "&action=faq" ] = WHMCMS::__("faqPageTitle");
            $BC[ MODURL . "&action=listfaq&groupid=" . $groupId ] = $getGroup['title'];
            $BC[ MODURL . "&action=addfaq&groupid=" . $groupId ] = WHMCMS::__("faqItemCreatePageTitle");

            $smarty->assign("goBackURL", MODURL . "&action=listfaq&groupid=" . $groupId);

        }

        # Add FAQ Data
        elseif ($action === "doaddfaq"){

            # FAQ Data
            $data = [
                'topid' => 0,
                'groupid' => WHMCMS::fromPost('groupid', 'int'),
                'question' => WHMCMS::fromPost('question'),
                'answer' => WHMCMS::fromPost('answer'),
                'datecreate' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'language' => WHMCMS::getSystemDefaultLanguage(),
            ];

            # Main Page Insert
            $itemId = Capsule::table("mod_whmcms_faq")
            ->insertGetId($data);

            # FAQ Translation Insert
            foreach (WHMCMS::fromPost('translate_question', 'array') as $language => $question){

                if (WHMCMS::fromInput($question) !== ""){

                    $data = array(
                        'topid' => $itemId,
                        'language' => $language,
                        'question' => WHMCMS::fromInput($question),
                        'answer' => WHMCMS::fromInput($_POST['translate_answer'][ $language ])
                    );
                    Capsule::table("mod_whmcms_faq")
                    ->insert($data);

                }

            }

            WHMCMS::redirect(WHMCMS::__("questionCreatedMessage"), 'success', MODURL . '&action=updatefaq&faqid=' . $itemId);

        }


        # Update FAQ Form
        elseif ($action === "updatefaq"){

            $itemId = WHMCMS::fromRequest('faqid', 'int');

            # Get FAQ
            $getItem = Capsule::table("mod_whmcms_faq")
            ->where("faqid", "=", $itemId)
            ->first();
            $getItem = (array) $getItem;

            # Get FAQ Group
            $getGroup = Capsule::table("mod_whmcms_faqgroups")
            ->where("groupid", "=", $getItem['groupid'])
            ->first();
            $getGroup = (array) $getGroup;

            # FAQ Main Form
            $smarty->assign('faqMain', faqItemForm($itemId, 'main', '', $smarty));

            # FAQ Main Editor
            $smarty->assign('faqMainEditor', faqItemForm($itemId, 'maineditor', '', $smarty));

            # FAQ Options Form
            $smarty->assign('faqOptions', faqItemForm($itemId, 'options', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = array(
                    'language' => $language,
                    'form' => faqItemForm($itemId, 'translate', $language, $smarty)
                );
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "faq.tpl";

            $BC[ MODURL . "&action=faq" ] = WHMCMS::__("faqPageTitle");
            $BC[ MODURL . "&action=listfaq&groupid=" . $groupId ] = $getGroup['title'];
            $BC[ MODURL . "&action=updatefaq&faqid=" . $itemId ] = WHMCMS::__("faqItemUpdatePageTitle") . $getItem['question'];

            $smarty->assign("goBackURL", MODURL . "&action=listfaq&groupid=" . $getGroup['groupid']);

        }

        # Update FAQ Data
        elseif ($action=="doupdatefaq"){

            $itemId = WHMCMS::fromRequest('faqid', 'int');

            # FAQ Data
            $data = [
                'topid' => 0,
                'groupid' => WHMCMS::fromPost('groupid', 'int'),
                'question' => WHMCMS::fromPost('question'),
                'answer' => WHMCMS::fromPost('answer'),
                'datemodify' => date("Y-m-d H:i:s"),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            # Main FAQ Insert
            Capsule::table("mod_whmcms_faq")
            ->where("faqid", "=", $itemId)
            ->update($data);

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') > 0){
                Capsule::table("mod_whmcms_faq")
                ->where("faqid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();
            }

            # FAQ Translation Insert
            foreach (WHMCMS::fromPost('translate_question', 'array') as $language => $question){

                if (WHMCMS::fromInput($question) !== ""){

                    $data = [
                        'topid' => $itemId,
                        'language' => $language,
                        'question' => WHMCMS::fromInput($question),
                        'answer' => WHMCMS::fromInput($_POST['translate_answer'][ $language ])
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_faq")
                    ->where("topid", "=", $itemId)
                    ->where("language", "=", $language);

                    if ($getTranslation->count()=='0'){
                        Capsule::table("mod_whmcms_faq")
                        ->insert($data);
                    }
                    else {
                        Capsule::table("mod_whmcms_faq")
                        ->where("topid", "=", $itemId)
                        ->where("language", "=", $language)
                        ->update($data);
                    }

                }

            }

            # Return To Pages
            if (isset($_POST['saveandreturn'])){

                WHMCMS::redirect(WHMCMS::__("questionUpdatedMessage"), 'success', MODURL . '&action=listfaq&groupid=' . WHMCMS::fromPost('groupid', 'int'));

            }

            WHMCMS::redirect(WHMCMS::__("questionUpdatedMessage"), 'success', MODURL . '&action=updatefaq&faqid=' . $itemId);

        }

        # Delete FAQ & FAQ Translation Data
        elseif ($action === "dodeletefaq"){

            $itemId = WHMCMS::fromRequest('faqid', 'int');
            $groupId = WHMCMS::fromRequest('groupid', 'int');

            # Delete FAQ
            Capsule::table("mod_whmcms_faq")
            ->where("faqid", "=", $itemId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_faq")
            ->where("topid", "=", $itemId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("questionDeletedMessage"), 'success', MODURL . '&action=listfaq&groupid=' . $groupId);

        }

        # Disbale/Enable FAQ
        elseif ($action === "disablefaq" || $action == "enablefaq"){

            $itemId = WHMCMS::fromRequest('faqid', 'int');
            $groupId = WHMCMS::fromRequest('groupid', 'int');

            if ($action === "disablefaq"){

                Capsule::table("mod_whmcms_faq")
                ->where("faqid", "=", $itemId)
                ->update(['enable' => 0]);

            }
            elseif ($action === "enablefaq"){

                Capsule::table("mod_whmcms_faq")
                ->where("faqid", "=", $itemId)
                ->update(['enable' => 1]);

            }

            # Return Ajax Response
            if ($isAjax === true){

                echo json_encode(["result" => "success"]);

                exit;

            }

            WHMCMS::redirect('', '', MODURL . '&action=listfaq&groupid=' . $groupId);

        }

        # FAQ Bulk Actions
        elseif ($action === "bulkfaq"){

            $groupId = WHMCMS::fromRequest('groupid', 'int');

            # Get The Selected Action
            $bulkaction = WHMCMS::fromRequest('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', "array")) > 0 && $bulkaction!=''){

                foreach (WHMCMS::fromPost('bulkcheckbox', "array") as $index => $itemId){

                    if ($bulkaction === "publish"){

                        Capsule::table("mod_whmcms_faq")
                        ->where("faqid", "=", $itemId)
                        ->update(['enable' => 1]);

                    }
                    elseif ($bulkaction === "unpublish"){

                        Capsule::table("mod_whmcms_faq")
                        ->where("faqid", "=", $itemId)
                        ->update(['enable' => 0]);

                    }
                    elseif ($bulkaction === "delete"){

                        Capsule::table("mod_whmcms_faq")
                        ->where("faqid", "=", $itemId)
                        ->delete();

                    }

                }
            }

            WHMCMS::redirect('', '', MODURL . '&action=listfaq&groupid=' . $groupId);

        }
        /********************************
        * FAQ Items Ended
        *********************************/

        /********************************
        * Error Pages Functions Started
        *********************************/
        # Error Pages List
        elseif ($action === "errorpages") {

            # Get Pages
            $getPages = Capsule::table("mod_whmcms_errorpages")
            ->where("topid", "=", 0);

            # Init Pagination
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'errorpages';
            $pagination = pagination($getPages->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Error Pages
            $getPages->orderBy("pageid", "asc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            foreach($getPages->get() as $page){
                $page = (array) $page;

                # Select Log Total
                $getTotalLogs = Capsule::table("mod_whmcms_errorlog")
                ->where("code", "=", $page['code']);
                $page['logs'] = $getTotalLogs->count();

                $page['datelastvisit'] = ($page['datelastvisit']=='0000-00-00 00:00:00')? 'Never' : fromMySQLDate($page['datelastvisit'], true, false);
                $page['datemodify'] = ($page['datemodify']=='0000-00-00 00:00:00')? 'Never': fromMySQLDate($page['datemodify'], true, false);
                $page['viewurl'] = WHMCMS::generateFriendlyURL($page, "errorpages.errorpages");
                $pages[] = $page;
            }
            $smarty->assign('errorpages', $pages);

            $smarty->assign('pagination', $pagination);

            $templateFile = "errorpages.tpl";

            $BC[ MODURL . "&action=errorpages" ] = WHMCMS::__("errorPagesPageTitle");

            $smarty->assign("noBreadcrumbButton", true);

        }

        # Update Error Page Form
        elseif ($action=="updateerrorpage"){

            $pageId = WHMCMS::fromRequest('pageid', 'int');

            # Get Page
            $getPage = Capsule::table("mod_whmcms_errorpages")
            ->where('pageid', '=', $pageId)
            ->first();
            $getPage = (array) $getPage;

            # Page Main Form
            $smarty->assign('pageMain', errorPageForm($pageId, 'main', '', $smarty));
            # Page Main Editor
            $smarty->assign('pageMainEditor', errorPageForm($pageId, 'maineditor', '', $smarty));
            # Page Options Form
            $smarty->assign('pageOptions', errorPageForm($pageId, 'options', '', $smarty));
            # Page Advanced Form
            $smarty->assign('pageAdvanced', errorPageForm($pageId, 'advanced', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => errorPageForm($pageId, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            $templateFile = "errorpages.tpl";

            $BC[ MODURL . "&action=errorpages" ] = WHMCMS::__("errorPagesPageTitle");
            $BC[ MODURL . "&action=updateerrorpage&pageid=" . $pageId ] = WHMCMS::__("errorPageUpdatePageTitle") . $getPage['title'];

            $smarty->assign("goBackURL", MODURL . "&action=errorpages");

        }

        # Update Page Data
        elseif ($action === "doupdateerrorpage"){

            $pageId = WHMCMS::fromRequest('pageid', 'int');

            # Page Data
            $data = [
                'topid' => 0,
                'title' => WHMCMS::fromPost('title'),
                'content' => WHMCMS::fromPost('content'),
                'datemodify' => date("Y-m-d H:i:s"),
                'language' => WHMCMS::getSystemDefaultLanguage(),
                'headercontent' => WHMCMS::fromPost('headercontent')
            ];

            # Main Page Insert
            Capsule::table("mod_whmcms_errorpages")
            ->where("pageid", "=", $pageId)
            ->update($data);

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') > 0){
                Capsule::table("mod_whmcms_errorpages")
                ->where("pageid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();
            }

            # Page Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $pageId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title),
                        'content' => WHMCMS::fromInput($_POST['translate_content'][ $language ])
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_errorpages")
                    ->where("topid", "=", $pageId)
                    ->where("language", "=", $language);

                    if ($getTranslation->count()=='0'){
                        Capsule::table("mod_whmcms_errorpages")
                        ->insert($data);
                    }
                    else {
                        Capsule::table("mod_whmcms_errorpages")
                        ->where("topid", "=", $pageId)
                        ->where("language", "=", $language)
                        ->update($data);
                    }

                }

            }

            # Return To Pages
            if (isset($_POST['saveandreturn'])){

                WHMCMS::redirect(WHMCMS::__("errorPageUpdatedMessage"), 'success', MODURL . '&action=errorpages');

            }

            WHMCMS::redirect(WHMCMS::__("errorPageUpdatedMessage"), 'success', MODURL . '&action=updateerrorpage&pageid=' . $pageId);

        }

        # Error Pages Bulk Actions
        elseif ($action === "bulkerrorpage"){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction!=''){
                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $code){

                    # Clear Log
                    if ($bulkaction === "log"){

                        Capsule::table("mod_whmcms_errorlog")
                        ->where("code", "=", $code)
                        ->delete();

                    }
                    # Reset Hits counter
                    elseif ($bulkaction === "hits"){

                        Capsule::table("mod_whmcms_errorpages")
                        ->where("code", "=", $code)
                        ->update(["hits" => 0]);

                    }

                }
            }

            WHMCMS::redirect('', '', MODURL.'&action=errorpages');

        }

        # Error Log List
        elseif ($action === "logerrors") {

            $code = WHMCMS::fromRequest('code', 'int');

            # Get Page
            $getPage = Capsule::table("mod_whmcms_errorpages")
            ->where("topid", "=", 0)
            ->where("code", "=", $code)
            ->first();
            $getPage = (array) $getPage;

            $getLogs = Capsule::table("mod_whmcms_errorlog")
            ->where("code", "=", $code);

            # Init Pagination
            $pageParams = array();
            $pageParams['module'] = 'whmcms';
            $pageParams['action'] = 'logerrors';
            $pageParams['code'] = $code;
            $pagination = pagination($getLogs->count(), 25, WHMCMS::fromGet('page', 'int'), $pageParams);

            # Select Error Log
            $getLogs->orderBy("logid", "desc")
            ->skip($pagination['LimitFrom'])
            ->take($pagination['LimitTo']);

            $logs = [];

            foreach ($getLogs->get() as $log){
                $log = (array) $log;

                # Check If IP Address Is Banned
                $isIPBanned = Capsule::table("tblbannedips")
                ->where("ip", $log['ip'])
                ->take(1)
                ->count();

                $log['ipbanned'] = $isIPBanned;

                if ($isIPBanned === 0){
                    $log['banipform'] = banErrorIP($log['logid']);
                }

                $log['loginfo'] = errorLogInfo($log['logid']);

                $log['datecreate'] = fromMySQLDate($log['datecreate'], true, false);

                $logs[] = $log;
            }
            $smarty->assign('logs', $logs);

            $smarty->assign('pagination', $pagination);

            $templateFile = "errorpages.tpl";

            $BC[ MODURL . "&action=errorpages" ] = WHMCMS::__("errorPagesPageTitle");
            $BC[ MODURL . "&action=logerrors&code=" . $code ] = $getPage['title'] ." ". WHMCMS::__("errorPagesLogsPageTitle");

            $smarty->assign("noBreadcrumbButton", true);

        }

        # Error Log Bulk Actions
        elseif ($action === "bulkerrorlog"){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction!=''){
                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $logId){

                    # Clear Log
                    if ($bulkaction === "delete"){
                        Capsule::table("mod_whmcms_errorlog")
                        ->where("logid", "=", $logId)
                        ->delete();
                    }

                }
            }

            WHMCMS::redirect('', '', MODURL.'&action=logerrors&code=' . $code);

        }

		# Error Log Delete Record
        elseif ($action === "deletelogitem"){

			$logId = WHMCMS::fromGet('logid', 'int');
			$code = WHMCMS::fromGet('code', 'int');

            # Delete Project
            Capsule::table("mod_whmcms_errorlog")
            ->where("logid", "=", $logId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect('', '', MODURL . '&action=logerrors&code=' . $code);

        }

        # Ban IP
        elseif ($action === "banip"){

            $ipaddress = WHMCMS::fromPost('ipaddress');
            $days = WHMCMS::fromPost('days', 'int');
            $reason = WHMCMS::fromPost('reason');

            # Delete Old Record
            Capsule::table("tblbannedips")
            ->where("ip", "=", $ipaddress)
            ->delete();

            # Add New Record
            Capsule::table("tblbannedips")
            ->insert([
                "ip" => $ipaddress,
                "reason" => $reason,
                "expires" => date("Y-m-d H:i:s", strtotime("now + {$days} days"))
            ]);

            WHMCMS::redirect('', '', MODURL . '&action=logerrors&code=' . $code);

        }

        # UnBan IP
        elseif ($action === "unbanip"){

            $ipaddress = WHMCMS::fromPost('ipaddress');

            Capsule::table("tblbannedips")
            ->where("ip", "=", $ipaddress)
            ->delete();

            WHMCMS::redirect('', '', MODURL . '&action=logerrors&code=' . $code);

        }
        /********************************
        * Error Pages Functions Ended
        *********************************/

        /********************************
        * Menu Manager Started
        *********************************/
        # Menu List
        elseif ($action === "menu"){

            $integrationTypes = [
                '0' => "None",
                1 => "Manually",
                3 => "Primary Navbar",
                4 => "Secondary Navbar"
            ];
            $smarty->assign("integrationtypes", $integrationTypes);

            $smarty->assign('menuCategoryMain', menuCategoryForm('', 'main', $smarty));
            $smarty->assign('menuCategoryOptions', menuCategoryForm('', 'options', $smarty));

            # Select Menu Categories
            $getCategories = Capsule::table("mod_whmcms_menucategories")
            ->orderBy("categoryid", "asc");

            foreach ($getCategories->get() as $category){
                $category = (array) $category;

                # Total Menu Items
                $getTotalMenuItems = Capsule::table("mod_whmcms_menu")
                ->where("categoryid", "=", $category['categoryid'])
                ->where("topid", "=", 0)
                ->count();
                $category['items'] = $getTotalMenuItems;

                $category['categoryMain'] = menuCategoryForm($category['categoryid'], 'main', $smarty);
                $category['categoryOptions'] = menuCategoryForm($category['categoryid'], 'options', $smarty);
                $categories[] = $category;
            }
            $smarty->assign('categories', $categories);

            $templateFile = "menu.tpl";

            $BC[ MODURL . "&action=menu" ] = WHMCMS::__("menuCategoryPageTitle");

        }

        # Add Menu Category Data
        elseif ($action === "doaddmenucategory"){

            $categoryID = Capsule::table("mod_whmcms_menucategories")
            ->insertGetId([
                'title' => WHMCMS::fromPost('title'),
                'css_class' => WHMCMS::fromPost('css_class'),
                'css_activeclass' => WHMCMS::fromPost('css_activeclass'),
                'css_id' => WHMCMS::fromPost('css_id')
            ]);

            # Install WHMCS Primary Navbar
            if (WHMCMS::fromPost('installdefaultmenu') === "primary"){

                $installMenu = new \WHMCMS\MenuInstallation($categoryID);

                $installMenu->primaryNavbar();

            }

            # Install WHMCS Secondary Navbar
            if (WHMCMS::fromPost('installdefaultmenu') === "secondary"){

                $installMenu = new \WHMCMS\MenuInstallation($categoryID);

                $installMenu->secondaryNavbar();

            }

            WHMCMS::redirect(WHMCMS::__("menuCategoryCreatedMessage"), 'success', MODURL . '&action=menu');

        }

        # Update Menu Category Data
        elseif ($action === "doupdatemenucategory"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            Capsule::table("mod_whmcms_menucategories")
            ->where("categoryid", "=", $categoryId)
            ->update([
                'title' => WHMCMS::fromPost('title'),
                'css_class' => WHMCMS::fromPost('css_class'),
                'css_activeclass' => WHMCMS::fromPost('css_activeclass'),
                'css_id' => WHMCMS::fromPost('css_id')
            ]);

            WHMCMS::redirect(WHMCMS::__("menuCategoryUpdatedMessage"), 'success', MODURL . '&action=menu');

        }

        # Delete Menu Category Data
        elseif ($action === "dodeletemenucategory"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            # Delete Menu Category
            Capsule::table("mod_whmcms_menucategories")
            ->where("categoryid", "=", $categoryId)
            ->delete();

            # Delete Menu Items
            Capsule::table("mod_whmcms_menu")
            ->where("categoryid", "=", $categoryId)
            ->delete();

            WHMCMS::redirect(WHMCMS::__("menuCategoryDeletedMessage"), 'success', MODURL . '&action=menu');

        }

        # Bulk Menu Category Action
        elseif ($action === "bulkmenu"){

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction!=''){
                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $categoryId){

                    if ($bulkaction === 'delete'){
                        # Delete Menu Category
                        Capsule::table("mod_whmcms_menucategories")
                        ->where("categoryid", "=", $categoryId)
                        ->delete();

                        # Delete Menu Items
                        Capsule::table("mod_whmcms_menu")
                        ->where("categoryid", "=", $categoryId)
                        ->delete();
                    }
                }
            }

            WHMCMS::redirect(WHMCMS::__("menuCategoriesDeletedMessage"), 'success', MODURL . '&action=menu');

        }

        # Save Menu Integration Type
        elseif ($action === "setmenuintegration"){

            $menuId = WHMCMS::fromRequest('categoryid', 'int');
            $type = WHMCMS::fromRequest('type', 'int');

            $primaryNavbarId = WHMCMS::fromInput(WHMCMS::getConfig("PrimaryNavbarCategoryid"), 'int');
            $secondaryNavbarId = WHMCMS::fromInput(WHMCMS::getConfig("SecondaryNavbarCategoryid"), 'int');

            if ($type === 0 || $type === 1){

                Capsule::table("mod_whmcms_menucategories")
                ->where("categoryid", "=", $menuId)
                ->update(["integration" => $type]);

                if ($primaryNavbarId === $menuId){
                    WHMCMS::setConfig("PrimaryNavbarCategoryid", 0);
                }

                if ($secondaryNavbarId === $menuId){
                    WHMCMS::setConfig("SecondaryNavbarCategoryid", 0);
                }

            }

            if ($type === 3){

                Capsule::table("mod_whmcms_menucategories")
                ->where("integration", "=", 3)
                ->update(["integration" => 0]);

                Capsule::table("mod_whmcms_menucategories")
                ->where("categoryid", "=", $menuId)
                ->update(["integration" => $type]);

                WHMCMS::setConfig("PrimaryNavbarCategoryid", $menuId);

            }

            if ($type === 4){

                Capsule::table("mod_whmcms_menucategories")
                ->where("integration", "=", 4)
                ->update(["integration" => 0]);

                Capsule::table("mod_whmcms_menucategories")
                ->where("categoryid", "=", $menuId)
                ->update(["integration" => $type]);

                WHMCMS::setConfig("SecondaryNavbarCategoryid", $menuId);

            }

            WHMCMS::redirect("", 'success', MODURL . '&action=menu');

        }

        # List Menu Items
        elseif ($action === "listmenu"){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            $getCategory = Capsule::table('mod_whmcms_menucategories')
            ->where("categoryid", "=", $categoryId)
            ->first();
            $getCategory = (array) $getCategory;

            # Redirect Admin If Menu Category Not Specified
            if ($categoryId === 0){
                WHMCMS::redirect('', '', MODURL . '&action=menu');
            }

            # Select Menu Items
            # First Level
            $getLevel1 = Capsule::table("mod_whmcms_menu")
            ->where("categoryid", "=", $categoryId)
            ->where("topid", "=", 0)
            ->where("parentid", "=", 0)
            ->orderBy("reorder", "asc");

            $menulevel1 = [];

            foreach ($getLevel1->get() as $level1){

                $level1 = (array) $level1;

                # 2nd Level
                $getLevel2 = Capsule::table("mod_whmcms_menu")
                ->where("topid", "=", 0)
                ->where("parentid", "=", $level1['menuid'])
                ->orderBy("reorder", "asc");

                $menulevel2 = [];

                foreach ($getLevel2->get() as $level2){

                    $level2 = (array) $level2;

                    # 3rd Level
                    $getLevel3 = Capsule::table("mod_whmcms_menu")
                    ->where("topid", "=", 0)
                    ->where("parentid", "=", $level2['menuid'])
                    ->orderBy("reorder", "asc");


                    $menulevel3 = [];

                    foreach ($getLevel3->get() as $level3){

                        $level3 = (array) $level3;

                        # 4th Level
                        $getLevel4 = Capsule::table("mod_whmcms_menu")
                        ->where("topid", "=", 0)
                        ->where("parentid", "=", $level3['menuid'])
                        ->orderBy("reorder", "asc");

                        $menulevel4 = [];

                        foreach ($getLevel4->get() as $level4){

                            $level4 = (array) $level4;

                            $level4['datemodify'] = ($level4['datemodify']=='0000-00-00 00:00:00')? $level4['datecreate']: $level4['datemodify'];
                            $level4['datemodify'] = fromMySQLDate($level4['datemodify'], true, false);

                            $level4['targeturl'] = WHMCMSMenus::getItemURL($level4);
                            $level4['shorturl'] = str_replace(WHMCMS::getSystemURL(), "../", $level4['targeturl']);

                            if (in_array(strtolower($level4['title']), ["-----", "------", "divider"])){
                                $level4['title'] = "------";
                            }

                            $level4['validurl'] = true;
                            if (strpos($level4['targeturl'], "http") === false && strpos($level4['targeturl'], "https") === false){
                                $level4['validurl'] = false;
                            }

                            $menulevel4[] = $level4;

                        }

                        $level3['children'] = $menulevel4;

                        $level3['datemodify'] = ($level3['datemodify']=='0000-00-00 00:00:00')? $level3['datecreate']: $level3['datemodify'];
                        $level3['datemodify'] = fromMySQLDate($level3['datemodify'], true, false);

                        $level3['targeturl'] = WHMCMSMenus::getItemURL($level3);
                        $level3['shorturl'] = str_replace(WHMCMS::getSystemURL(), "../", $level3['targeturl']);

                        if (in_array(strtolower($level3['title']), ["-----", "------", "divider"])){
                            $level3['title'] = "------";
                        }

                        $level3['validurl'] = true;
                        if (strpos($level3['targeturl'], "http") === false && strpos($level3['targeturl'], "https") === false){
                            $level3['validurl'] = false;
                        }

                        $menulevel3[] = $level3;

                    }

                    $level2['children'] = $menulevel3;

                    $level2['datemodify'] = ($level2['datemodify']=='0000-00-00 00:00:00')? $level2['datecreate']: $level2['datemodify'];
                    $level2['datemodify'] = fromMySQLDate($level2['datemodify'], true, false);

                    $level2['targeturl'] = WHMCMSMenus::getItemURL($level2);
                    $level2['shorturl'] = str_replace(WHMCMS::getSystemURL(), "../", $level2['targeturl']);

                    if (in_array(strtolower($level2['title']), ["-----", "------", "divider"])){
                        $level2['title'] = "------";
                    }

                    $level2['validurl'] = true;
                    if (strpos($level2['targeturl'], "http") === false && strpos($level2['targeturl'], "https") === false){
                        $level2['validurl'] = false;
                    }

                    $menulevel2[] = $level2;

                }

                $level1['children'] = $menulevel2;

                $level1['datemodify'] = ($level1['datemodify']=='0000-00-00 00:00:00')? $level1['datecreate']: $level1['datemodify'];
                $level1['datemodify'] = fromMySQLDate($level1['datemodify'], true, false);

                $level1['targeturl'] = WHMCMSMenus::getItemURL($level1);
                $level1['shorturl'] = str_replace(WHMCMS::getSystemURL(), "../", $level1['targeturl']);

                if (in_array(strtolower($level1['title']), ["-----", "------", "divider"])){
                    $level1['title'] = "------";
                }

                $level1['validurl'] = true;
                if (strpos($level1['targeturl'], "http") === false && strpos($level1['targeturl'], "https") === false){
                    $level1['validurl'] = false;
                }

                $menu[] = $level1;

            }
            $smarty->assign('menu', $menu);

            $templateFile = "menu.tpl";

            $BC[ MODURL . "&action=menu" ] = WHMCMS::__("menuCategoryPageTitle");
            $BC[ MODURL . "&action=listmenu&categoryid=" .  $categoryId ] = $getCategory['title'] . " " . WHMCMS::__("menuItemsPageTitle");

        }

        # Add Menu Item Form
        elseif (in_array($action, ["addmenu", "addmenudivider"])){

            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            $getCategory = Capsule::table('mod_whmcms_menucategories')
            ->where("categoryid", "=", $categoryId)
            ->first();
            $getCategory = (array) $getCategory;

            # Redirect Admin If Menu Category Not Specified
            if ($categoryId === 0){
                WHMCMS::redirect('', '', MODURL . '&action=menu');
            }

            # Main Menu Form
            $smarty->assign('menuMain', menuItemForm('', $categoryId, 'main', '', $smarty));

            # Menu Options Form
            $smarty->assign('menuOptions', menuItemForm('', $categoryId, 'options', '', $smarty));

            # CSS Options Form
            $smarty->assign('menuCss', menuItemForm('', $categoryId, 'css', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => menuItemForm(0, $categoryId, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            # Get Icons
            $smarty->assign("icons", WHMCMS::getResourcesIcons());


            $templateFile = "menu.tpl";

            $BC[ MODURL . "&action=menu" ] = WHMCMS::__("menuCategoryPageTitle");
            $BC[ MODURL . "&action=listmenu&categoryid=" .  $categoryId ] = $getCategory['title'] . " " . WHMCMS::__("menuItemsPageTitle");
            $BC[ MODURL . "&action=addmenu&categoryid=" .  $categoryId ] = WHMCMS::__("menuItemCreatePageTitle");

            $smarty->assign("goBackURL", MODURL . "&action=listmenu&categoryid=" . $categoryId);

        }

        # Add Menu Item Data
        elseif ($action === "doaddmenuitem"){

            $parentId = WHMCMS::fromPost('parentid', 'int');
            $urlType = WHMCMS::fromPost('url_type');
            $menuId = WHMCMS::fromPost('categoryid', 'int');

            # Get Menu Type To Save
            if ($urlType === "page"){
                $url = WHMCMS::fromPost('type_page', 'int');
            }
            elseif ($urlType === "faq"){
                $url = WHMCMS::fromPost('type_faq', 'int');
            }
            elseif ($urlType === "internal"){
                $url = WHMCMS::fromPost('type_internal');
            }
            elseif ($urlType === "clientarea"){
                $url = WHMCMS::fromPost('type_clientarea');
            }
            elseif ($urlType === "external"){
                $url = WHMCMS::fromPost('type_external');
            }
            elseif ($urlType === "download"){
                $url = WHMCMS::fromPost('type_download', 'int');
            }
            elseif ($urlType === "knowledge"){
                $url = WHMCMS::fromPost('type_knowledge', 'int');
            }
            elseif ($urlType === "support"){
                $url = WHMCMS::fromPost('type_support', 'int');
            }

            # Get The New Item Ordering Number
            $getNewOrdering = Capsule::table("mod_whmcms_menu")
            ->where("topid", "=", 0)
            ->where("parentid", "=", $parentId)
            ->where("categoryid", "=", $menuId)
            ->orderBy("reorder", "desc")
            ->take(1);

            $ordering = 1;

            if ($getNewOrdering->count() > 0){
                $lastItemOrdering = (array) $getNewOrdering->first();
                $ordering = $lastItemOrdering['reorder'] + 1;
            }

            $data = [
                'categoryid' => $menuId,
                'topid' => 0,
                'parentid' => WHMCMS::fromPost('parentid', 'int'),
                'title' => WHMCMS::fromPost('title'),
                'url' => $url,
                'url_type' => WHMCMS::fromPost('url_type'),
                'target' => WHMCMS::fromPost('target'),
                'reorder' => $ordering,
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'private' => WHMCMS::fromPost('private', 'int'),
                'css_class' => WHMCMS::fromPost('css_class'),
                'css_id' => WHMCMS::fromPost('css_id'),
                'css_hassubclass' => WHMCMS::fromPost('css_hassubclass'),
                'css_submenuclass' => WHMCMS::fromPost('css_submenuclass'),
                'css_iconclass' => WHMCMS::fromPost('css_iconclass'),
                'menucondition' => WHMCMS::fromPost('menucondition'),
                'menubadge' => WHMCMS::fromPost('menubadge'),
                'datecreate' => date("Y-m-d H:i:s"),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            $itemId = Capsule::table("mod_whmcms_menu")
            ->insertGetId($data);

            # FAQ Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){
                    $data = [
                        'topid' => $itemId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title)
                    ];

                    Capsule::table("mod_whmcms_menu")
                    ->insert($data);
                }

            }

            if (WHMCMS::fromPost("title") === "------"){
                WHMCMS::redirect(WHMCMS::__("menuItemCreatedMessage"), 'success', MODURL . '&action=updatemenudivider&menuid=' . $itemId);
            }

            WHMCMS::redirect(WHMCMS::__("menuItemCreatedMessage"), 'success', MODURL . '&action=updatemenu&menuid=' . $itemId);

        }

        # Update Menu Item Form
        elseif (in_array($action, ["updatemenu", "updatemenudivider"])){

            $itemId = WHMCMS::fromRequest('menuid', 'int');

            # Get Item
            $getItem = Capsule::table("mod_whmcms_menu")
            ->where("menuid", $itemId)
            ->first();
            $getItem = (array) $getItem;

            $smarty->assign("item", $getItem);

            $menuId = $getItem['categoryid'];

            # Get Menu
            $getMenu = Capsule::table("mod_whmcms_menucategories")
            ->where("categoryid", "=", $menuId)
            ->first();
            $getMenu = (array) $getMenu;

            # Main Menu Form
            $smarty->assign('menuMain', menuItemForm($itemId, $menuId, 'main', '', $smarty));

            # Menu Options Form
            $smarty->assign('menuOptions', menuItemForm($itemId, $menuId, 'options', '', $smarty));

            # CSS Options Form
            $smarty->assign('menuCss', menuItemForm($itemId, $menuId, 'css', '', $smarty));

            # Languages
            $languages = WHMCMS::getSystemLanguages(true);

            # Page Translate Forms
            $translations = [];
            foreach ($languages as $language){
                $translation = [
                    'language' => $language,
                    'form' => menuItemForm($itemId, $menuId, 'translate', $language, $smarty)
                ];
                $translations[] = $translation;
            }
            $smarty->assign('translations', $translations);

            # Get Icons
            $smarty->assign("icons", WHMCMS::getResourcesIcons());

            $templateFile = "menu.tpl";

            $BC[ MODURL . "&action=menu" ] = WHMCMS::__("menuCategoryPageTitle");
            $BC[ MODURL . "&action=listmenu&categoryid=" .  $menuId ] = $getMenu['title'] . " " . WHMCMS::__("menuItemsPageTitle");
            $BC[ MODURL . "&action=addmenu&categoryid=" .  $menuId ] = WHMCMS::__("menuItemUpdatePageTitle") . $getItem['title'];

            $smarty->assign("goBackURL", MODURL . "&action=listmenu&categoryid=" . $menuId);

        }

        # Update Menu Item Data
        elseif ($action === "doupdatemenuitem"){

            $itemId = WHMCMS::fromRequest('menuid', 'int');
            $urlType = WHMCMS::fromPost('url_type');
            $parentId = WHMCMS::fromPost('parentid', 'int');
            $categoryId = WHMCMS::fromRequest('categoryid', 'int');

            # Get Item
            $getItem = Capsule::table("mod_whmcms_menu")
            ->where("menuid", "=", $itemId)
            ->first();
            $getItem = (array) $getItem;

            $menuId = $getItem['categoryid'];

            # Get Menu
            $getMenu = Capsule::table("mod_whmcms_menucategories")
            ->where("categoryid", "=", $menuId)
            ->first();
            $getMenu = (array) $getMenu;

            # Update Reordering
            $getNewOrdering = Capsule::table("mod_whmcms_menu")
            ->where("topid", "=", 0)
            ->where("parentid", "=", $parentId)
            ->where("categoryid", "=", $menuId)
            ->orderBy("reorder", "desc")
            ->take(1);

            $ordering = 1;

            if ($getNewOrdering->count() > 0){
                $lastItemOrdering = (array) $getNewOrdering->first();
                $ordering = $lastItemOrdering['reorder'] + 1;
            }

            # Get Menu Type To Save
            if ($urlType === "page"){
                $url = WHMCMS::fromPost('type_page', 'int');
            }
            elseif ($urlType === "faq"){
                $url = WHMCMS::fromPost('type_faq', 'int');
            }
            elseif ($urlType === "internal"){
                $url = WHMCMS::fromPost('type_internal');
            }
            elseif ($urlType === "clientarea"){
                $url = WHMCMS::fromPost('type_clientarea');
            }
            elseif ($urlType === "external"){
                $url = WHMCMS::fromPost('type_external');
            }
            elseif ($urlType === "download"){
                $url = WHMCMS::fromPost('type_download', 'int');
            }
            elseif ($urlType === "knowledge"){
                $url = WHMCMS::fromPost('type_knowledge', 'int');
            }
            elseif ($urlType === "support"){
                $url = WHMCMS::fromPost('type_support', 'int');
            }

            $data = [
                'topid' => 0,
                'parentid' => $parentId,
                'title' => WHMCMS::fromPost('title'),
                'url' => WHMCMS::fromInput($url),
                'url_type' => WHMCMS::fromPost('url_type'),
                'target' => WHMCMS::fromPost('target'),
                'enable' => WHMCMS::fromPost('enable', 'int'),
                'private' => WHMCMS::fromPost('private', 'int'),
                'css_class' => WHMCMS::fromPost('css_class'),
                'css_id' => WHMCMS::fromPost('css_id'),
                'css_hassubclass' => WHMCMS::fromPost('css_hassubclass'),
                'css_submenuclass' => WHMCMS::fromPost('css_submenuclass'),
                'css_iconclass' => WHMCMS::fromPost('css_iconclass'),
                'menucondition' => WHMCMS::fromPost('menucondition'),
                'menubadge' => WHMCMS::fromPost('menubadge'),
                'datemodify' => date("Y-m-d H:i:s"),
                'language' => WHMCMS::getSystemDefaultLanguage()
            ];

            if ($parentId !== WHMCMS::fromInput($getItem['parentid'], "int")){

                $data['reorder'] = $ordering;

                # Update Other Menu items Ordering
                $getNextMenuItems = Capsule::table("mod_whmcms_menu")
                ->where("topid", "=", 0)
                ->where("parentid", "=", $getItem['parentid'])
                ->where("categoryid", "=", $getItem['categoryid'])
                ->where("reorder", ">", $getItem['reorder'])
                ->orderBy("reorder", "asc");
                foreach ($getNextMenuItems->get() as $item){

                    $item = (array) $item;

                    Capsule::table("mod_whmcms_menu")
                    ->where("menuid", "=", $item['menuid'])
                    ->update(["reorder" => (WHMCMS::fromInput($item['reorder'], 'int') - 1)]);

                }

            }

            # Main Menu Item
            Capsule::table("mod_whmcms_menu")
            ->where("menuid", "=", $itemId)
            ->update($data);

            # Delete Not Translation That Not Used
            if (WHMCMS::fromPost('deletetranslation', 'int') > 0){
                Capsule::table("mod_whmcms_menu")
                ->where("menuid", "=", WHMCMS::fromPost('deletetranslation', 'int'))
                ->delete();
            }

            # Menu Translation Insert
            foreach (WHMCMS::fromPost('translate_title', 'array') as $language => $title){

                if (WHMCMS::fromInput($title) !== ""){

                    $data = [
                        'topid' => $itemId,
                        'language' => $language,
                        'title' => WHMCMS::fromInput($title)
                    ];

                    # Check for Exist Record
                    $getTranslation = Capsule::table("mod_whmcms_menu")
                    ->where("topid", "=", $itemId)
                    ->where("language", "=", $language);

                    if ($getTranslation->count()=='0'){
                        Capsule::table("mod_whmcms_menu")
                        ->insert($data);
                    }
                    else {
                        Capsule::table("mod_whmcms_menu")
                        ->where("topid", "=", $itemId)
                        ->where("language", "=", $language)
                        ->update($data);
                    }

                }

            }

            # Return To Pages
            if (isset($_POST['saveandreturn'])){

                WHMCMS::redirect(WHMCMS::__("menuItemUpdatedMessage"), 'success', MODURL . '&action=listmenu&categoryid=' . $categoryId);

            }

            if (WHMCMS::fromPost("title") === "------"){
                WHMCMS::redirect(WHMCMS::__("menuItemUpdatedMessage"), 'success', MODURL . '&action=updatemenudivider&menuid=' . $itemId);
            }

            WHMCMS::redirect(WHMCMS::__("menuItemUpdatedMessage"), 'success', MODURL . '&action=updatemenu&menuid=' . $itemId);

        }

        # Save Manu Items Ordering
        elseif ($action === "menuitemsordering"){

            $orderlevel1 = 1;
            $orderlevel2 = 1;
            $orderlevel3 = 1;
            $orderlevel4 = 1;

            foreach (WHMCMS::fromPost('items', 'array') as $index => $level1){

                # Update Level #1
                Capsule::table("mod_whmcms_menu")
                ->where("menuid", "=", WHMCMS::fromInput($level1['id'], 'int'))
                ->update([
                    "parentid" => 0,
                    "reorder" => WHMCMS::fromInput($orderlevel1, 'int')
                ]);

                # Update Level #2
                if (WHMCMS::fromInput($level1['children'], 'array')){

                    $orderlevel2 = 1;

                    foreach (WHMCMS::fromInput($level1['children'], 'array') as $index => $level2){

                        Capsule::table("mod_whmcms_menu")
                        ->where("menuid", "=", WHMCMS::fromInput($level2['id'], 'int'))
                        ->update([
                            "parentid" => WHMCMS::fromInput($level1['id'], 'int'),
                            "reorder" => WHMCMS::fromInput($orderlevel2, 'int')
                        ]);

                        $orderlevel2++;

                        # Update Level #3
                        if (WHMCMS::fromInput($level2['children'], 'array')){

                            $orderlevel3 = 1;

                            foreach (WHMCMS::fromInput($level2['children'], 'array') as $index => $level3){

                                Capsule::table("mod_whmcms_menu")
                                ->where("menuid", "=", WHMCMS::fromInput($level3['id'], 'int'))
                                ->update([
                                    "parentid" => WHMCMS::fromInput($level2['id'], 'int'),
                                    "reorder" => WHMCMS::fromInput($orderlevel3, 'int')
                                ]);

                                $orderlevel3++;

                                # Update Level #4
                                if (WHMCMS::fromInput($level3['children'], 'array')){

                                    $orderlevel4 = 1;

                                    foreach (WHMCMS::fromInput($level3['children'], 'array') as $index => $level4){

                                        Capsule::table("mod_whmcms_menu")
                                        ->where("menuid", "=", WHMCMS::fromInput($level4['id'], 'int'))
                                        ->update([
                                            "parentid" => WHMCMS::fromInput($level3['id'], 'int'),
                                            "reorder" => WHMCMS::fromInput($orderlevel4, 'int')
                                        ]);

                                        $orderlevel4++;

                                    }

                                }

                            }

                        }

                    }

                }

                $orderlevel1++;
            }

            echo json_encode(["result" => "success"]);

            exit;

        }

        # Delete Menu Item
        elseif ($action === "dodeletemenuitem"){

            $itemId = WHMCMS::fromRequest('menuid', 'int');

            # Get Menu
            $getItem = Capsule::table("mod_whmcms_menu")
            ->where("menuid", "=", $itemId)
            ->first();
            $getItem = (array) $getItem;

            # Delete Sub Menu Levels
            $getLevel2 = Capsule::table("mod_whmcms_menu")
            ->where("parentid", "=", $itemId);

            foreach ($getLevel2->get() as $level2){

                $level2 = (array) $level2;

                # Select Sub Level
                $getLevel3 = Capsule::table("mod_whmcms_menu")
                ->where("parentid", "=", $level2['menuid']);

                foreach ($getLevel3->get() as $level3){

                    $level3 = (array) $level3;

                    # Select Sub Level
                    $getLevel4 = Capsule::table("mod_whmcms_menu")
                    ->where("parentid", "=", $level3['menuid']);

                    foreach ($getLevel4->get() as $level4){

                        $level4 = (array) $level4;

                        # Delete Level4 & Translation
                        Capsule::table("mod_whmcms_menu")
                        ->where("menuid", "=", $level4['menuid'])
                        ->delete();

                        Capsule::table("mod_whmcms_menu")
                        ->where("topid", "=", $level4['menuid'])
                        ->delete();

                    }

                    # Delete Level3 & Translation
                    Capsule::table("mod_whmcms_menu")
                    ->where("menuid", "=", $level3['menuid'])
                    ->delete();

                    Capsule::table("mod_whmcms_menu")
                    ->where("topid", "=", $level3['menuid'])
                    ->delete();

                }

                # Delete Level2 & Translation
                Capsule::table("mod_whmcms_menu")
                ->where("menuid", "=", $level2['menuid'])
                ->delete();

                Capsule::table("mod_whmcms_menu")
                ->where("topid", "=", $level2['menuid'])
                ->delete();

            }

            # Change Other Items Ordering
            $getNextMenuItems = Capsule::table("mod_whmcms_menu")
            ->where("topid", "=", 0)
            ->where("parentid", "=", $getItem['parentid'])
            ->where("categoryid", "=", $getItem['categoryid'])
            ->where("reorder", ">", $getItem['reorder'])
            ->orderBy("reorder", "asc");

            foreach ($getNextMenuItems->get() as $item){

                $item = (array) $item;

                Capsule::table("mod_whmcms_menu")
                ->where("menuid", "=", $item['menuid'])
                ->update(['reorder' => ($item['reorder'] - 1) ]);

            }

            # Delete Menu
            Capsule::table("mod_whmcms_menu")
            ->where("menuid", "=", $itemId)
            ->delete();

            # Delete Translations
            Capsule::table("mod_whmcms_menu")
            ->where("topid", "=", $itemId)
            ->delete();

            # Print Successfull Message and redirect admin to main page
            WHMCMS::redirect(WHMCMS::__("menuItemDeletedMessage"), 'success', MODURL . '&action=listmenu&categoryid=' . $getItem['categoryid']);

        }

        # Disbale/Enable Menu Item
        elseif ($action === "disablemenuitem" || $action === "enablemenuitem"){

            $itemId = WHMCMS::fromRequest('menuid', 'int');

            $menuId = WHMCMS::fromRequest('categoryid', 'int');

            if ($action === "disablemenuitem"){
                Capsule::table("mod_whmcms_menu")
                ->where("menuid", "=", $itemId)
                ->update(["enable" => 0]);
            }
            elseif ($action === "enablemenuitem"){
                Capsule::table("mod_whmcms_menu")
                ->where("menuid", "=", $itemId)
                ->update(["enable" => 1]);
            }

            # Return Ajax Response
            if ($isAjax === true){

                echo json_encode(["result" => "success"]);

                exit;

            }

            WHMCMS::redirect('', '', MODURL . '&action=listmenu&categoryid=' . $menuId);

        }

        # Menu Items Bulk Actions
        elseif ($action == "bulkmenuitems"){

            $menuId = WHMCMS::fromRequest('categoryid', 'int');

            # Get The Selected Action
            $bulkaction = WHMCMS::fromPost('bulkaction');

            # Process Bulk Actions
            if (count(WHMCMS::fromPost('bulkcheckbox', 'array')) > 0 && $bulkaction !== ""){

                foreach (WHMCMS::fromPost('bulkcheckbox', 'array') as $index => $itemId){

                    if ($bulkaction === "publish"){
                        Capsule::table("mod_whmcms_menu")
                        ->where("menuid", "=", $itemId)
                        ->update(["enable" => 1]);
                    }
                    elseif ($bulkaction === "unpublish"){
                        Capsule::table("mod_whmcms_menu")
                        ->where("menuid", "=", $itemId)
                        ->update(["enable" => 0]);
                    }
                    elseif ($bulkaction === "delete"){

                        # Select Menu Data
                        $getItem = Capsule::table("mod_whmcms_menu")
                        ->where("menuid", "=", $itemId)
                        ->first();

                        $getItem = (array) $getItem;

                        # Delete Sub Menu Levels
                        $getLevel2 = Capsule::table("mod_whmcms_menu")
                        ->where("parentid", "=", $itemId);

                        foreach ($getLevel2->get() as $level2){

                            $level2 = (array) $level2;

                            # Select Sub Level
                            $getLevel3 = Capsule::table("mod_whmcms_menu")
                            ->where("parentid", "=", $level2['menuid']);

                            foreach ($getLevel3->get() as $level3){

                                $level3 = (array) $level3;

                                # Select Sub Level
                                $getLevel4 = Capsule::table("mod_whmcms_menu")
                                ->where("parentid", "=", $level3['menuid']);

                                foreach ($getLevel4->get() as $level4){

                                    $level4 = (array) $level4;

                                    # Delete Level4 & Translation
                                    Capsule::table("mod_whmcms_menu")
                                    ->where("menuid", "=", $level4['menuid']);

                                    Capsule::table("mod_whmcms_menu")
                                    ->where("topid", "=", $level4['menuid']);

                                }

                                # Delete Level3 & Translation
                                Capsule::table("mod_whmcms_menu")
                                ->where("menuid", "=", $level3['menuid']);

                                Capsule::table("mod_whmcms_menu")
                                ->where("topid", "=", $level3['menuid']);

                            }

                            # Delete Level2 & Translation
                            Capsule::table("mod_whmcms_menu")
                            ->where("menuid", "=", $level2['menuid']);

                            Capsule::table("mod_whmcms_menu")
                            ->where("topid", "=", $level2['menuid']);

                        }

                        # Change Other Items Ordering
                        $getNextMenuItems = Capsule::table("mod_whmcms_menu")
                        ->where("topid", "=", 0)
                        ->where("parentid", "=", $getItem['parentid'])
                        ->where("categoryid", "=", $getItem['categoryid'])
                        ->where("reorder", ">", $getItem['reorder'])
                        ->orderBy("reorder", "asc");

                        foreach ($getNextMenuItems->get() as $item){

                            $item = (array) $item;

                            Capsule::table("mod_whmcms_menu")
                            ->where("menuid", "=", $item['menuid'])
                            ->update(['reorder' => ($item['reorder'] - 1) ]);

                        }

                        # Delete Menu
                        Capsule::table("mod_whmcms_menu")
                        ->where("menuid", "=", $itemId)
                        ->delete();

                        # Delete Translations
                        Capsule::table("mod_whmcms_menu")
                        ->where("topid", "=", $itemId)
                        ->delete();

                    }

                }

            }

            WHMCMS::redirect('', '', MODURL . '&action=listmenu&categoryid=' . $menuId);

        }

        /********************
        * Customizations Started
        *********************/
        # Update Customization Form
        elseif ($action === "customize"){

            # The Customized HTACCESS CODE
            $htaccessCode = [];
            $htaccessCode[] = "# WHMCMS Code Started";
            $htaccessCode[] = WHMCMS::generateRewriteRules();
            $htaccessCode[] = "# WHMCMS Code Ended";

            $cssForm = createForm([
                [
                    'Fieldname' => 'customize_css',
                    'FriendlyName' => "",
                    'Type' => 'textarea',
                    'Value' => WHMCMS::getConfig("customize_css"),
                    'Rows' => 20,
                    'Cols' => 100,
                    'Class' => 'span10 css_editor',
                    'id' => 'css_editortext',
                    'Description' => '<pre id="css_editor" class="css_editor">' . WHMCMS::getConfig("customize_css") . '</pre>'
                ]
            ]);
            $jsForm = createForm([
                [
                    'Fieldname' => 'customize_js',
                    'FriendlyName' => "",
                    'Type' => 'textarea',
                    'Value' => WHMCMS::getConfig("customize_js"),
                    'Rows' => 20,
                    'Cols' => 100,
                    'Class' => 'span10 js_editor',
                    'id' => 'js_editortext',
                    'Description' => '<pre id="js_editor" class="css_editor">' . WHMCMS::getConfig("customize_js") . '</pre>'
                ]
            ]);
            $htaccessForm = createForm([
                [
                    'Fieldname' => '',
                    'FriendlyName' => "",
                    'Type' => 'textarea',
                    'Value' => join("", $htaccessCode),
                    'Rows' => 20,
                    'Cols' => 100,
                    'Class' => 'span10',
                    'Description' => '',
                    "Attr" => "readonly"
                ]
            ]);

            $smarty->assign('cssForm', $cssForm);
            $smarty->assign('jsForm', $jsForm);
            $smarty->assign('htaccessForm', $htaccessForm);

            $templateFile = "customizations.tpl";

            $BC[ MODURL . "&action=customize" ] = WHMCMS::__("customizePageTitle");

            $smarty->assign("noBreadcrumbButton", true);

        }

        # Update Customizations Data
        elseif ($action === "doupdatecustomize"){

            # Save CSS Changes
            WHMCMS::setConfig("customize_css", WHMCMS::fromPost('customize_css'));

            # Save Javascript Changes
            WHMCMS::setConfig("customize_js", WHMCMS::fromPost('customize_js'));

            WHMCMS::redirect(WHMCMS::__("customizationUpdatedMessage"), 'success', MODURL . '&action=customize');

        }
        /********************
        * Customizations Ended
        *********************/

        /********************
        * Settings Started
        *********************/
        elseif ($action=='settings'){

            $smarty->assign("generalSettings", whmcms_generalSettings());

            $smarty->assign("portfolioSettings", whmcms_portfolioSettings());

            $smarty->assign("errorpagesSettings", whmcms_errorpagesSettings());

            $smarty->assign("metaSettings", whmcms_metaSettings());

            $smarty->assign("_settings", $_settings);

            # Menu Categories
            $getMenuCategories = Capsule::table("mod_whmcms_menucategories")->get();
            $menuCategories = array();
            foreach ($getMenuCategories as $category){

                $category = (array) $category;

                $menuCategories[] = $category;

            }
            $smarty->assign("menuCategories", $menuCategories);

            $templateFile = "settings.tpl";

            $BC[ MODURL . "&action=settings" ] = WHMCMS::__("settingsPageTitle");

            $smarty->assign("noBreadcrumbButton", true);

        }

        # Setting Save Data
        elseif ($action === "updatesettings"){

            # Version 2.0.0 (initial)
            if (WHMCMS::fromPost('frontendfile') === ""){
                WHMCMS::setConfig("frontendfile", "whmcms.php");
            }
            else {
                WHMCMS::setConfig("frontendfile", WHMCMS::fromPost('frontendfile'));
            }

            WHMCMS::setConfig("homepage", WHMCMS::fromPost('homepage'));

            WHMCMS::setConfig("editor", WHMCMS::fromPost('editor'));

            WHMCMS::setConfig("seourls", WHMCMS::fromPost('seourls'));

            WHMCMS::setConfig("portfoliolayout", WHMCMS::fromPost('portfoliolayout'));

            WHMCMS::setConfig("portfolioitemsinrow", WHMCMS::fromPost('portfolioitemsinrow', 'int'));

            WHMCMS::setConfig("portfolioitemsinpage", WHMCMS::fromPost('portfolioitemsinpage', 'int'));

            WHMCMS::setConfig("error400", WHMCMS::fromPost('error400'));

            WHMCMS::setConfig("error403", WHMCMS::fromPost('error403'));

            WHMCMS::setConfig("error404", WHMCMS::fromPost('error404'));

            WHMCMS::setConfig("error405", WHMCMS::fromPost('error405'));

            WHMCMS::setConfig("error408", WHMCMS::fromPost('error408'));

            WHMCMS::setConfig("error500", WHMCMS::fromPost('error500'));

            WHMCMS::setConfig("error502", WHMCMS::fromPost('error502'));

            WHMCMS::setConfig("error504", WHMCMS::fromPost('error504'));

            WHMCMS::setConfig("metaimage", WHMCMS::fromPost('metaimage'));

            WHMCMS::setConfig("portfoliosort", WHMCMS::fromPost('portfoliosort'));

            WHMCMS::setConfig("portfoliofilteroption", WHMCMS::fromPost('portfoliofilteroption'));

            # Version 2.1
            WHMCMS::setConfig("metaimage398", WHMCMS::fromPost('metaimage398'));

			# Version 2.3.0
            WHMCMS::setConfig("vsixtemplate", "yes");

            # Version 2.5.0
            WHMCMS::setConfig("UploadEnableCache", WHMCMS::fromPost('UploadEnableCache'));

            WHMCMS::setConfig("UploadCachePeriod", WHMCMS::fromPost('UploadCachePeriod'));

            WHMCMS::setConfig("UploadResizeWidth", WHMCMS::fromPost('UploadResizeWidth'));

            WHMCMS::setConfig("UploadDirectory", WHMCMS::fromPost('UploadDirectory'));

            WHMCMS::setConfig("UploadCustomDirectory", WHMCMS::fromPost('UploadCustomDirectory'));

            /* Update Primary Navbar */
            WHMCMS::setConfig("PrimaryNavbarCategoryid", WHMCMS::fromPost('PrimaryNavbarCategoryid', 'int'));

            Capsule::table("mod_whmcms_menucategories")
            ->where("integration", "=", 3)
            ->update(["integration" => 0]);

            if (WHMCMS::fromPost('PrimaryNavbarCategoryid', 'int') > 0){
                Capsule::table("mod_whmcms_menucategories")
                ->where("categoryid", "=", WHMCMS::fromPost('PrimaryNavbarCategoryid', 'int'))
                ->update(["integration" => 3]);
            }

            /* Update Secondary Navbar */
            WHMCMS::setConfig("SecondaryNavbarCategoryid", WHMCMS::fromPost('SecondaryNavbarCategoryid', 'int'));

            Capsule::table("mod_whmcms_menucategories")
            ->where("integration", "=", 4)
            ->update(["integration" => 0]);

            if (WHMCMS::fromPost('SecondaryNavbarCategoryid', 'int') > 0){
                Capsule::table("mod_whmcms_menucategories")
                ->where("categoryid", "=", WHMCMS::fromPost('SecondaryNavbarCategoryid', 'int'))
                ->update(["integration" => 4]);
            }

            # Version 2.5.1
            WHMCMS::setConfig("AutoApplyRewriteRules", WHMCMS::fromPost('AutoApplyRewriteRules'));

            ### Auto Apply SEO URLs Rules Is Set To YES
            if (WHMCMS::getConfig("AutoApplyRewriteRules") === "yes"){

                $result = WHMCMS::applyRewriteRules();

                if ($result['result'] === "error"){

                    WHMCMS::redirect($result['message'], 'error', MODURL . '&action=settings');

                }

            }

            # Version 3.0.0
            WHMCMS::setConfig("FriendlyURLsMode", WHMCMS::fromPost('FriendlyURLsMode'));


            WHMCMS::redirect('The New Changes has been saved successfully!', 'success', MODURL . '&action=settings');

        }
        /********************
        * Settings Ended
        *********************/

        /********************************
         * WHMCMS Updates Started
         *********************************/
        /********************************
         * WHMCMS Updates Ended
         *********************************/

        /********************************
         * WHMCMS Support Started
         *********************************/
        elseif ($action === "support" || $action === "updates"){

            $smarty->assign("isuptodate", WHMCMS::isUpToDate());

            $templateFile = "support.tpl";

            $BC[ MODURL . "&action=listpages" ] = WHMCMS::__("supportPageTitle");

            $smarty->assign("noBreadcrumbButton", true);

        }
        /********************************
         * WHMCMS Support Ended
         *********************************/

        elseif ($action === "applyrewriterules"){

            $result = WHMCMS::applyRewriteRules();

            if ($result['result'] === "error"){

                WHMCMS::redirect($result['message'], 'error', MODURL);

            }

            WHMCMS::redirect('Rewrite rules applied successfully.', 'success', MODURL);

        }

    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//  Module Actions
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

    if (isset($_SESSION['whmcms_message'])){
        $smarty->assign("system_message", $_SESSION['whmcms_message']);
        $smarty->assign("system_messagetype", $_SESSION['whmcms_messagetype']);
        unset($_SESSION['whmcms_message']);
        unset($_SESSION['whmcms_messagetype']);
    }

    $smarty->assign("breadcrumbs", $BC);

    $smarty->display("header.tpl");

        if ($templateFile){
        $smarty->display($templateFile);
        }

        $footer = [];
        $footer[] = '<div style="margin-top:20px;margin-bottom:300px;">';
            $footer[] = 'Powered by: <a href="http://www.whmcms.com/" target="_blank" style="color:#EF652A;">WHMCMS | CMS Module for WHMCS.</a>';
        $footer[] = '</div>';
        echo join("", $footer);

    $smarty->display("footer.tpl");

}
