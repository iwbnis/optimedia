<?php

namespace WHMCMS;

use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Database\Capsule;

# Manage Client Area Menu
class Menus {
    
    private static $clientId = 0;
    
    private static $client = null;
    
    private static $clientStats = null;
    
    private static $conditions = null;
    
    public static $menus = [];
    
    # Generate WHMCMS Menus HTML
    public static function generateMenuItems($menuId){
        
        # Menu Already Generated
        if (isset(self::$menus[ $menuId ])){
            return self::$menus[ $menuId ];
        }
        
        self::$clientId = intval($_SESSION['uid']);
        
        # Get Client
        if (self::$clientId !== 0 && is_null(self::$client)){
            
            self::$client = \Menu::context("client");
            
            self::$clientStats = self::getClientStats();
            
        }
        
        # Init Menu Conditions
        if (is_null(self::$conditions)){
            
            self::$conditions = self::initItemConditions();
            
        }
        
        $menuItems = [];
        
        # Select Menu
        $getMenu = Capsule::table("mod_whmcms_menucategories")
        ->where("categoryid", "=", intval($menuId));
        
        if ($getMenu->count() === 0){
            return [];
        }
        
        $getMenu = (array) $getMenu->first();
        
        # Get First Level Items
        $getLevel1 = Capsule::table("mod_whmcms_menu")
        ->where("categoryid", "=", $menuId)
        ->where("topid", "=", 0)
        ->where("parentid", "=", 0)
        ->where("enable", "=", 1)
        ->whereIn("private", (self::$clientId === 0 ? [0,2] : [0,1]))
        ->orderBy("reorder", "asc");
        
        $childrensLevel1 = [];
        
        foreach ($getLevel1->get() as $level1) {
            
            $level1 = (array) $level1;
            
            # Get Translation
            if ($level1['language'] !== $language) {
                $getTranslation = Capsule::table("mod_whmcms_menu")
                ->where("topid", "=", $level1['menuid'])
                ->where("language", "=", $language);
                
                if ($getTranslation->count() > 0){
                    $getTranslation = (array) $getTranslation->first();
                    
                    $level1['title'] = $getTranslation['title'];
                }
            }
            
            # Get Second Level Items
            $getLevel2 = Capsule::table("mod_whmcms_menu")
            ->where("topid", "=", 0)
            ->where("parentid", "=", $level1['menuid'])
            ->where("enable", "=", 1)
            ->whereIn("private", (self::$clientId === 0 ? [0,2] : [0,1]))
            ->orderBy("reorder", "asc");
            
            $childrensLevel2 = [];
            
            foreach ($getLevel2->get() as $level2) {
                
                $level2 = (array) $level2;
                
                # Get Translation
                if ($level2['language'] !== $language) {
                    $getTranslation = Capsule::table("mod_whmcms_menu")
                    ->where("topid", "=", $level2['menuid'])
                    ->where("language", "=", $language);
                    
                    if ($getTranslation->count() > 0){
                        $getTranslation = (array) $getTranslation->first();
                        
                        $level2['title'] = $getTranslation['title'];
                    }
                }
                
                # Get Third Level Menu Items
                $getLevel3 = Capsule::table("mod_whmcms_menu")
                ->where("topid", "=", 0)
                ->where("parentid", "=", $level2['menuid'])
                ->where("enable", "=", 1)
                ->whereIn("private", (self::$clientId === 0 ? [0,2] : [0,1]))
                ->orderBy("reorder", "asc");
                
                $childrensLevel3 = [];
                
                foreach ($getLevel3->get() as $level3) {
                    
                    $level3 = (array) $level3;
                    
                    # Get Translation
                    if ($level3['language'] !== $language) {
                        $getTranslation = Capsule::table("mod_whmcms_menu")
                        ->where("topid", "=", $level3['menuid'])
                        ->where("language", "=", $language);
                        
                        if ($getTranslation->count() > 0){
                            $getTranslation = (array) $getTranslation->first();
                            
                            $level3['title'] = $getTranslation['title'];
                        }
                    }
                    
                    # Get Fourth Level Menu Items
                    $getLevel4 = Capsule::table("mod_whmcms_menu")
                    ->where("topid", "=", 0)
                    ->where("parentid", "=", $level3['menuid'])
                    ->where("enable", "=", 1)
                    ->whereIn("private", (self::$clientId === 0 ? [0,2] : [0,1]))
                    ->orderBy("reorder", "asc");
                    
                    $childrensLevel4 = [];
                    
                    foreach ($getLevel4->get() as $level4) {
                        
                        $level4 = (array) $level4;
                        
                        # Get Translation
                        if ($level4['language'] !== $language) {
                            $getTranslation = Capsule::table("mod_whmcms_menu")
                            ->where("topid", "=", $level4['menuid'])
                            ->where("language", "=", $language);
                            
                            if ($getTranslation->count() > 0){
                                $getTranslation = (array) $getTranslation->first();
                                
                                $level4['title'] = $getTranslation['title'];
                            }
                        }
                        
                        $level4['title'] = self::getItemTitle($level4['title']);
                        $level4['url'] = self::getItemURL($level4);
                        $level4['visibility'] = self::isItemVisible($level4['private']);
                        $level4['current'] = self::isItemCurrent($level4['url']);
                        $level4['condition'] = self::checkItemCondition($level4['menucondition']);
                        $level4['badge'] = self::getItemBadge($level4['menubadge']);
                        $level4['css_classes'] = self::getItemClasses($level4['css_class'], $level4['css_hassubclass'], 0, $level4['current'], $getMenu);
                        $level4['css_submenuclass'] = $level4['css_submenuclass'];
                        
                        $childrensLevel4[] = $level4;
                        
                    }
                    
                    $level3['title'] = self::getItemTitle($level3['title']);
                    $level3['url'] = self::getItemURL($level3);
                    $level3['visibility'] = self::isItemVisible($level3['private']);
                    $level3['current'] = self::isItemCurrent($level3['url']);
                    $level3['condition'] = self::checkItemCondition($level3['menucondition']);
                    $level3['badge'] = self::getItemBadge($level3['menubadge']);
                    $level3['css_classes'] = self::getItemClasses($level3['css_class'], $level3['css_hassubclass'], $level3['level4'], $level3['current'], $getMenu);
                    $level3['css_submenuclass'] = $level3['css_submenuclass'];
                    $level3['childrens'] = $childrensLevel4;
                    
                    $childrensLevel3[] = $level3;
                    
                }
                
                $level2['title'] = self::getItemTitle($level2['title']);
                $level2['url'] = self::getItemURL($level2);
                $level2['visibility'] = self::isItemVisible($level2['private']);
                $level2['current'] = self::isItemCurrent($level2['url']);
                $level2['condition'] = self::checkItemCondition($level2['menucondition']);
                $level2['badge'] = self::getItemBadge($level2['menubadge']);
                $level2['css_classes'] = self::getItemClasses($level2['css_class'], $level2['css_hassubclass'], $level2['level3'], $level2['current'], $getMenu);
                $level2['css_submenuclass'] = $level2['css_submenuclass'];
                $level2['childrens'] = $childrensLevel3;
                
                $childrensLevel2[] = $level2;
                
            }
            
            $level1['title'] = self::getItemTitle($level1['title']);
            $level1['url'] = self::getItemURL($level1);
            $level1['visibility'] = self::isItemVisible($level1['private']);
            $level1['current'] = self::isItemCurrent($level1['url']);
            $level1['condition'] = self::checkItemCondition($level1['menucondition']);
            $level1['badge'] = self::getItemBadge($level1['menubadge']);
            $level1['css_classes'] = self::getItemClasses($level1['css_class'], $level1['css_hassubclass'], $level1['level2'], $level1['current'], $getMenu);
            $level1['css_submenuclass'] = $level1['css_submenuclass'];
            $level1['childrens'] = $childrensLevel2;
            
            $childrensLevel1[] = $level1;
            
        }
        
        self::$menus[ $menuId ] = $childrensLevel1;
        
        return self::$menus[ $menuId ];
        
    }

    public static function getItemURL($item){
        
        $urlType = WHMCMS::fromInput($item['url_type']);
        $urlTarget = WHMCMS::fromInput($item['url']);
        
        # Get Page
        if ($urlType === "page"){
            
            $getPage = Capsule::table("mod_whmcms_pages")
            ->where("pageid", "=", WHMCMS::fromInput($urlTarget, 'int'))
            ->first();
            $getPage = (array) $getPage;
            
            return WHMCMS::generateFriendlyURL($getPage, "pages.page");
            
        }
        
        # Get FAQ Group
        if ($urlType === "faq"){
            
            $getGroup = Capsule::table("mod_whmcms_faqgroups")
            ->where("groupid", "=", WHMCMS::fromInput($urlTarget, 'int'))
            ->first();
            $getGroup = (array) $getGroup;
            
            return WHMCMS::generateFriendlyURL($getGroup, "faq.group");
            
        }
        
        # Client Area URLs
        if ($urlType === "internal" || $urlType === "clientarea"){
            
            if ($urlTarget === "portfolio.php"){
                return WHMCMS::generateFriendlyURL([], "portfolio.index");
            }
            
            return WHMCMS::getSystemURL() . $urlTarget;
            
        }
        
        # Support Department
        if ($urlType === "support"){
            
            return WHMCMS::getSystemURL() . 'submitticket.php?step=2&deptid=' . WHMCMS::fromInput($urlTarget, 'int');
            
        }
        
        # Download Category
        if (in_array($urlType, ["download", "knowledge"]) === true){
            
            $urlTypes = [
                "download" => "downloads",
                "knowledge" => "knowledgebase"
            ];
            
            # Get Download Category
            if ($urlType === "download"){
                $getCategory = Capsule::table("tbldownloadcats")
                ->where("id", "=", WHMCMS::fromInput($urlTarget, 'int'))
                ->first();
                $getCategory = (array) $getCategory;
            }
            # Get Knowledgebase Category
            else {
                $getCategory = Capsule::table("tblknowledgebasecats")
                ->where("id", "=", WHMCMS::fromInput($urlTarget, 'int'))
                ->first();
                $getCategory = (array) $getCategory;
            }
            
            # WHMCS version older than 7.2
            if (WHMCMS::getSystemConfig("RouteUriPathMode") === null){
                
                if (WHMCMS::getSystemConfig("SEOFriendlyUrls") == 'on'){
                    
                    return WHMCMS::getSystemURL() . $urlTypes[ $urlType ] . "/" . $getCategory['id'] . "/" . WHMCMS::generateAlias($getCategory['name']);
                    
                }
                
                return WHMCMS::getSystemURL() . $urlTypes[ $urlType ] . ".php?action=displaycat&catid=" . $getCategory['id'];
                
            }
            
            if (WHMCMS::getSystemConfig("RouteUriPathMode") === "basic"){
                
                return WHMCMS::getSystemURL() . "index.php?rp=/" . $urlTypes[ $urlType ] . "/" . $getCategory['id'] . "/" . WHMCMS::generateAlias($getCategory['name']);
                
            }
            
            if (WHMCMS::getSystemConfig("RouteUriPathMode") === "acceptpathinfo"){
                
                return WHMCMS::getSystemURL() . "index.php/" . $urlTypes[ $urlType ] . "/" . $getCategory['id'] . "/" . WHMCMS::generateAlias($getCategory['name']);
                
            }
            
            return WHMCMS::getSystemURL() . $urlTypes[ $urlType ] . "/" . $getCategory['id'] . "/" . WHMCMS::generateAlias($getCategory['name']);
            
        }
        
        return $urlTarget;
        
    }
    
    private static function getItemTitle($title, $username = 'Guest'){
        
        $vars = [
            '[username]' => self::$client->firstname,
            '{$clientfirstname}' => self::$client->firstname,
            '{$clientlastname}' => self::$client->lastname,
            '{$clientemail}' => self::$client->email
        ];
        
        foreach ($vars as $var => $value){
            
            $title = str_replace($var, $value, $title);
            
        }
        
        return $title;
        
    }
    
    private static function isItemVisible($visibility = 0){
        
        $visibility = intval($visibility);
        
        if ($visibility === 1 && self::$clientId === 0) {
            return false;
        }
        
        if ($visibility === 2 && self::$clientId !== 0) {
            return false;
        }
        
        return true;
        
    }
    
    private static function isItemCurrent($itemURL, $requestURL = ""){
        
        $itemURL = self::breakURL($itemURL);
        
        $requestURL = self::breakURL($requestURL);
        
        if ($itemURL['path'] !== $requestURL['path']){
            return false;
        }
        
        foreach ($requestURL['query'] as $var => $value){
            if (isset($itemURL['query'][ $var ]) === false){
                return false;
            }
            if ($itemURL['query'][ $var ] !== $value){
                return false;
            }
        }
        
        return true;
        
    }
    
    private static function breakURL($url){
        
        $url = urldecode($url);
        
        $url = strtolower($url);
        
        $url = str_replace("&amp;", "&", $url);
        
        $parsed = parse_url($url);
        
        $excludedQueryParams = ["language", "systpl", "carttpl"];
        
        $query = explode("&", $parsed['query']);
        $query = array_filter($query);
        
        $queryParams = [];
        
        foreach ($query as $item){
            $item = explode("=", $item);
            
            if (in_array($item[0], $excludedQueryParams)){
                continue;
            }
            
            $queryParams[] = [
                "name" => $item[0],
                "value" => $item[1]
            ];
        }
        
        return [
            "path" => $parsed['path'],
            "query" => $queryParams
        ];
        
    }
    
    private static function getClientStats(){
        
        $stats = [
            "ActiveTickets" => 0,
            "AllDomains" => 0,
            "ActiveDomains" => 0,
            "AllServices" => 0,
            "ActiveServices" => 0,
            "UnpaidInvoices" => 0,
            "DueInvoices" => 0,
            "OverdueInvoices" => 0,
            "CreditBalance" => '',
            "IsAffiliate" => false
        ];
        
        if (self::$clientId === 0){
            return $stats;
        }
        
        # Get Unpaid Invoices
        $getUnpaidInvoices = Capsule::table("tblinvoices")
        ->where("userid", "=", self::$clientId)
        ->where("duedate", ">", date("Y-m-d"))
        ->where("status", "=", "Unpaid")
        ->count();
        
        # Get Due Invoices
        $getDueInvoices = Capsule::table("tblinvoices")
        ->where("userid", "=", self::$clientId)
        ->where("duedate", "=", date("Y-m-d"))
        ->where("status", "=", "Unpaid")
        ->count();
        
        # Get Overdue Invoices
        $getOverdueInvoices = Capsule::table("tblinvoices")
        ->where("userid", "=", self::$clientId)
        ->where("duedate", "<", date("Y-m-d"))
        ->where("status", "=", "Unpaid")
        ->count();
        
        # Get Active Tickets
        $getActiveTickets = Capsule::table("tbltickets")
        ->join("tblticketstatuses", "tblticketstatuses.title", "=", "tbltickets.status")
        ->where("tbltickets.userid", "=", self::$clientId)
        ->where("tblticketstatuses.showactive", "=", 1)
        ->count();
        
        # Get All Domains
        $getAllDomains = Capsule::table("tbldomains")
        ->where("userid", "=", self::$clientId)
        ->count();
        
        # Get Active Domains
        $getActiveDomains = Capsule::table("tbldomains")
        ->where("userid", "=", self::$clientId)
        ->where("status", "=", "Active")
        ->count();
        
        # Get All Services
        $getAllServices = Capsule::table("tblhosting")
        ->where("userid", "=", self::$clientId)
        ->count();
        
        # Get Active Services
        $getActiveServices = Capsule::table("tblhosting")
        ->where("userid", "=", self::$clientId)
        ->where("domainstatus", "=", "Active")
        ->count();
        
        # Get Credit Balance
        $currencyData = getCurrency(self::$clientId);
        $getCreditBalance = formatCurrency(self::$client->credit, $currencyData['id']);
        
        # Get Client Affiliate Status
        $isClientAnAffiliate = (is_null($client->affiliate) ? false : true);
        
        $stats = [
            "ActiveTickets" => $getActiveTickets,
            "AllDomains" => $getAllDomains,
            "ActiveDomains" => $getActiveDomains,
            "AllServices" => $getAllServices,
            "ActiveServices" => $getActiveServices,
            "UnpaidInvoices" => $getUnpaidInvoices,
            "DueInvoices" => $getDueInvoices,
            "OverdueInvoices" => $getOverdueInvoices,
            "CreditBalance" => $getCreditBalance,
            "IsAffiliate" => $isClientAnAffiliate
        ];
    }
    
    private static function initItemConditions(){
        
        # Get Activated Addon Modules
        $activatedAddonModules = explode(",", WHMCMS::getSystemConfig("ActiveAddonModules"));
        
        $conditions = [
            "numoverdueinvoices" => ((self::$clientStats['OverdueInvoices'] > 0) ? true : false),
            "numactivetickets" => ((self::$clientStats['ActiveTickets'] > 0) ? true : false),
            "numactivedomains" => ((self::$clientStats['ActiveDomains'] > 0) ? true : false),
            "productsnumtotal" => ((self::$clientStats['AllServices'] > 0) ? true : false),
            "updatecc" => true,
            "addfunds" => ((WHMCMS::getSystemConfig("AddFundsEnabled") === "on") ? true : false),
            "domainreg" => ((WHMCMS::getSystemConfig("AllowRegister") === "on") ? true : false),
            "domaintrans" => ((WHMCMS::getSystemConfig("AllowTransfer") === "on") ? true : false),
            "enomnewtldsenabled" => ((in_array("enomnewtlds", $activatedAddonModules)) ? true : false),
            "dns_manager_is_active" => ((in_array("dns_manager", $activatedAddonModules)) ? true : false),
            "masspay" => ((WHMCMS::getSystemConfig("EnableMassPay") === "on") ? true : false),
            "pmaddon" => ((in_array("project_management", $activatedAddonModules)) ? true : false),
            "affiliates" => ((WHMCMS::getSystemConfig("AffiliateEnabled") === "on") ? true : false),
            "isaffiliate" => self::$clientStats['IsAffiliate']
        ];
        
        return $conditions;
        
    }
    
    private static function checkItemCondition($condition){
        
        if (isset(self::$conditions[ $condition ])){
            return self::$conditions[ $condition ];
        }
        
        return false;
        
    }
    
    private static function getItemBadge($badge){
        
        if (isset(self::$clientStats[ $badge ])){
            return self::$clientStats[ $badge ];
        }
        
        return "";
        
    }
    
    
    //$level1['css_classes']getMenuItemClass($level1['css_class'], $level1['css_hassubclass'], $level1['level2'], $level1['active'], $category);
    private static function getItemClasses($itemClass = "", $itemSubClass = "", $childrens = [], $itemIsCurrent = false, $menu = []){
        
        $classes = [];
        
        # Menu Class
        if ($itemClass !== "") {
            $classes[] = $itemClass;
        }
        
        # Menu Has Childrens
        if (count($childrens) > 0) {
            $classes[] = $itemSubClass;
        }
        
        # Check if one of the childrens are current
        if (is_array($childrens)) {
            foreach ($childrens as $child) {
                if ($child['current'] == true) {
                    $childIsCurrent = true;
                }
            }
        }
        
        # Item or subitem is current
        if ($itemIsCurrent == true || $childIsCurrent == true) {
            $classes[] = $menu['css_activeclass'];
        }
        
        return join(" ", $classes);
        
    }
    
    
    public static function renderMenu($menuId){
        
        # Get Menu
        $getMenu = Capsule::table("mod_whmcms_menucategories")
        ->where("categoryid", "=", $menuId);
        
        if ($getMenu->count() === 0){
            return "";
        }
        
        global $templates_compiledir;
        
        # Init Smarty
        $views = new \Smarty();
        $views->setCompileDir($templates_compiledir);
        $views->setTemplateDir(ROOTDIR . "/");
        $views->compile_id = "efccb7ef69c80261e2fba91ae5d82688";
        $views->registerClass("WHMCMS", "\WHMCMS\Base");
        $views->registerClass("WHMCMSMenus", "\WHMCMS\Menus");
        
        $template = WHMCMS::getClientTemplate();
        
        $getMenu = (array) $getMenu->first();
        
        $views->assign("menu", $getMenu);
        
        $views->assign("items", self::generateMenuItems($menuId));
        
        # Check if Customized TPL File Exists
        if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/navbar.tpl") === true){
            $templateFile = file_get_contents(ROOTDIR . "/templates/" . $template . "/whmcms/navbar.tpl");
        }
        # Display Default Template Instead
        else {
            $templateFile = file_get_contents(ROOTDIR . "/modules/addons/whmcms/clientarea/views/navbar.tpl");
        }
        
        return $views->fetch("string:" . $templateFile);
        
    }
    
}


?>