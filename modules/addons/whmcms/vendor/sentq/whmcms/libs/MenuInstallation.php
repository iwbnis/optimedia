<?php

namespace WHMCMS;

use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Database\Capsule;

class MenuInstallation {
    
    /* CategoryId */
    private $menuId = 0;
    
    /* Hold WHMCS Translation Arrays */
    private $translations = null;
    
    public function __construct($menuId = 0){
        
        if (intval($menuId) > 0){
            $this->setMenuId($menuId);
        }
        
        $this->loadTranslations();
        
        return $this;
        
    }
    
    public function setMenuId($menuId){
        
        if (intval($menuId) > 0){
            $this->menuId = $menuId;
        }
        
        return $this;
        
    }
    
    public function getMenuId(){
        return $this->menuId;
    }
    
    
    /* Load WHMCS Translations */
    private function loadTranslations(){
        
        if (!is_null($this->translations)){
            return;
        }
        
        # Get System Languages List
        $systemLanguages = WHMCMS::getSystemLanguages(true);
        
        # Get System Languages Loaded
        foreach ($systemLanguages as $language){
            
            unset($_LANG);
            
            if (is_file(ROOTDIR . "/lang/" . $language . ".php") === false){
                continue;
            }
            
            include(ROOTDIR . "/lang/" . $language . ".php");
            
            $this->translations[ $language ] = $_LANG;
            
            if (is_file(ROOTDIR . "/lang/overrides/" . $language . ".php") === false){
                continue;
            }
            
            unset($_LANG);
            
            include(ROOTDIR . "/lang/overrides/" . $language . ".php");
            
            $this->translations[ $language ] = array_replace_recursive($this->translations[ $language ], $_LANG);
            
        }
        
    }
    
    public function addDivider($parentMenuId, $reorder = 0, $private = 2){
        
        Capsule::table('mod_whmcms_menu')
        ->insert([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => intval($parentMenuId),
            "title" => "-----",
            "url" => "#",
            "url_type" => "external",
            "reorder" => intval($reorder),
            "private" => intval($private),
            "language" => WHMCMS::getSystemDefaultLanguage(),
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
    }
    
    public function addMenuItemTranslations($menuItemId, $parentMenuId = 0, $title, $extraTitle = ""){
    
        # Add Translations
        foreach ($this->translations as $language => $translation){
            
            if (!isset($translation[ $title ])){
                continue;
            }
            
            Capsule::table("mod_whmcms_menu")
            ->insert([
                "categoryid" => $this->getMenuId(),
                "topid" => intval($menuItemId),
                "parentid" => intval($parentMenuId),
                "title" => (string) $translation[ $title ] . (strlen($extraTitle) > 0 ? $extraTitle : ""),
                "language" => $language
            ]);
        
        }
        
    }
    
    public function primaryNavbar(){
        
        # Get Default Language
        $defaultLanguage = WHMCMS::getSystemDefaultLanguage();
        
        # Get Default Language Loaded
        if (is_file(ROOTDIR . "/lang/" . $defaultLanguage . ".php") === true){
            
            unset($_LANG);
            
            include(ROOTDIR . "/lang/" . $defaultLanguage . ".php");
            
            $DefaultTranslation = $_LANG;
            
            unset($_LANG);
            
            if (is_file(ROOTDIR . "/lang/overrides/" . $defaultLanguage . ".php") === true){
                include(ROOTDIR . "/lang/overrides/" . $defaultLanguage . ".php");
                
                $DefaultTranslation = array_replace_recursive($DefaultTranslation, $_LANG);
            }
            
        }
        
        # Get Product Groups
        $getProductGroups = Capsule::table("tblproductgroups")
        ->where("hidden", "=", 0)
        ->orderBy("order", "asc")
        ->get();
        $productGroups = array();
        foreach ($getProductGroups as $group){
            $group = (array) $group;
            $productGroups[ $group['id'] ] = $group['name'];
        }
        
        # Home
        $homeMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['clientareanavhome'],
            "url" => "index.php",
            "url_type" => "internal",
            "reorder" => 1,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($homeMenuId, 0, 'clientareanavhome');
        
        # Store
        $storeMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['navStore'],
            "url" => "cart.php",
            "url_type" => "internal",
            "reorder" => 2,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($storeMenuId, 0, 'navStore');
        
        # Store Sub-Menu Items
        $menuItemBrowseAll = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $storeMenuId,
            "title" => (string) $DefaultTranslation['navBrowseProductsServices'],
            "url" => "cart.php",
            "url_type" => "internal",
            "reorder" => 1,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($menuItemBrowseAll, $storeMenuId, 'navBrowseProductsServices');
        
        $this->addDivider($storeMenuId, 2, 2);
        
        # Add Product Groups As Menu Items
        $storeSubMenuCounter = 3;
        foreach ($productGroups as $groupID => $groupName){
            Capsule::table('mod_whmcms_menu')
            ->insert([
                "categoryid" => $this->getMenuId(),
                "topid" => 0,
                "parentid" => $storeMenuId,
                "title" => (string) $groupName,
                "url" => "cart.php?gid=" . $groupID,
                "url_type" => "external",
                "reorder" => $storeSubMenuCounter,
                "private" => 2,
                "language" => $defaultLanguage,
                "datecreate" => date("Y-m-d H:i:s"),
                "datemodify" => date("Y-m-d H:i:s")
            ]);
            
            $storeSubMenuCounter++;
        }
        
        # Register Domain
        $menuItemRegisterDomain = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $storeMenuId,
            "title" => (string) $DefaultTranslation['navregisterdomain'],
            "url" => "cart.php?a=add&domain=register",
            "url_type" => "internal",
            "reorder" => $storeSubMenuCounter + 1,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($menuItemRegisterDomain, $storeMenuId, 'navregisterdomain');
        
        # Transfer Domain
        $menuItemTransferDomain = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $storeMenuId,
            "title" => (string) $DefaultTranslation['navtransferdomain'],
            "url" => "cart.php?a=add&domain=transfer",
            "url_type" => "internal",
            "reorder" => $storeSubMenuCounter + 2,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($menuItemTransferDomain, $storeMenuId, 'navtransferdomain');
        
        # Announcements
        $announcementMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['announcementstitle'],
            "url" => "announcements",
            "url_type" => "internal",
            "reorder" => 3,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($announcementMenuId, 0, 'announcementstitle');
        
        # Knowledgebase
        $knowledgebaseMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['knowledgebasetitle'],
            "url" => "knowledgebase",
            "url_type" => "internal",
            "reorder" => 4,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($knowledgebaseMenuId, 0, 'knowledgebasetitle');
        
        # Network Status
        $networkMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['networkstatustitle'],
            "url" => "serverstatus.php",
            "url_type" => "internal",
            "reorder" => 5,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($networkMenuId, 0, 'networkstatustitle');
        
        # Contact Us
        $contactMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['contactus'],
            "url" => "contact.php",
            "url_type" => "internal",
            "reorder" => 6,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($contactMenuId, 0, 'contactus');
        
        ## Now Menu of Clients
        # Home
        $homeMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['globalsystemname'],
            "url" => "clientarea.php",
            "url_type" => "internal",
            "reorder" => 6,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($homeMenuId, 0, 'globalsystemname');
        
        # Services
        $servicesMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['navservices'],
            "url" => "#",
            "url_type" => "external",
            "reorder" => 7,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($servicesMenuId, 0, 'navservices');
        
        # My Services
        $myservicesMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $servicesMenuId,
            "title" => (string) $DefaultTranslation['clientareanavservices'],
            "url" => "clientarea.php?action=products",
            "url_type" => "clientarea",
            "reorder" => 1,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($myservicesMenuId, $servicesMenuId, 'clientareanavservices');
        
        # My Projects
        $myprojectsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $servicesMenuId,
            "title" => (string) $DefaultTranslation['clientareaprojects'],
            "url" => "index.php?m=project_management",
            "url_type" => "external",
            "reorder" => 2,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "pmaddon"
        ]);
        
        $this->addMenuItemTranslations($myprojectsMenuId, $servicesMenuId, 'clientareaprojects');
        
        $this->addDivider($servicesMenuId, 3, 0);
        
        # Order New Service
        $cartMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $servicesMenuId,
            "title" => (string) $DefaultTranslation['navservicesorder'],
            "url" => "cart.php",
            "url_type" => "clientarea",
            "reorder" => 4,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($cartMenuId, $servicesMenuId, 'navservicesorder');
        
        # View Available Addons
        $addonsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $servicesMenuId,
            "title" => (string) $DefaultTranslation['clientareaviewaddons'],
            "url" => "cart.php?gid=addons",
            "url_type" => "clientarea",
            "reorder" => 5,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($addonsMenuId, $servicesMenuId, 'clientareaviewaddons');
        
        # Domains
        $domainsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['navdomains'],
            "url" => "#",
            "url_type" => "external",
            "reorder" => 8,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($domainsMenuId, 0, 'navdomains');
        
        # My Domains
        $mydomainsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $domainsMenuId,
            "title" => (string) $DefaultTranslation['clientareanavdomains'],
            "url" => "clientarea.php?action=domains",
            "url_type" => "clientarea",
            "reorder" => 1,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($mydomainsMenuId, $domainsMenuId, 'clientareanavdomains');
        
        $this->addDivider($domainsMenuId, 2, 0);
        
        # Renew Domains
        $renewDomainsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $domainsMenuId,
            "title" => (string) $DefaultTranslation['navrenewdomains'],
            "url" => "cart.php?gid=renewals",
            "url_type" => "clientarea",
            "reorder" => 3,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($renewDomainsMenuId, $domainsMenuId, 'navrenewdomains');
        
        # Register a New Domain
        $registerDomainMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $domainsMenuId,
            "title" => (string) $DefaultTranslation['navregisterdomain'],
            "url" => "cart.php?a=add&domain=register",
            "url_type" => "clientarea",
            "reorder" => 4,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "domainreg"
        ]);
        
        $this->addMenuItemTranslations($registerDomainMenuId, $domainsMenuId, 'navregisterdomain');
        
        # Transfer Domains to Us
        $transferDomainMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $domainsMenuId,
            "title" => (string) $DefaultTranslation['navtransferdomain'],
            "url" => "cart.php?a=add&domain=transfer",
            "url_type" => "clientarea",
            "reorder" => 5,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "domaintrans"
        ]);
        
        $this->addMenuItemTranslations($transferDomainMenuId, $domainsMenuId, 'navtransferdomain');
        
        $this->addDivider($domainsMenuId, 6, 0);
        
        # Domain Search
        $domainSearchMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $domainsMenuId,
            "title" => (string) $DefaultTranslation['navdomainsearch'],
            "url" => "domainchecker.php",
            "url_type" => "clientarea",
            "reorder" => 7,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "domainreg"
        ]);
        
        $this->addMenuItemTranslations($domainSearchMenuId, $domainsMenuId, 'navdomainsearch');
        
        # Billing
        $billingMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['navbilling'],
            "url" => "#",
            "url_type" => "external",
            "reorder" => 9,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($billingMenuId, 0, 'navbilling');
        
        # My Invoices
        $myinvoicesMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $billingMenuId,
            "title" => (string) $DefaultTranslation['invoices'],
            "url" => "clientarea.php?action=invoices",
            "url_type" => "clientarea",
            "reorder" => 1,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($billingMenuId, $billingMenuId, 'invoices');
        
        # My Quotes
        $myquotesMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $billingMenuId,
            "title" => (string) $DefaultTranslation['quotestitle'],
            "url" => "clientarea.php?action=quotes",
            "url_type" => "clientarea",
            "reorder" => 2,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($myquotesMenuId, $billingMenuId, 'quotestitle');
        
        $this->addDivider($billingMenuId, 3, 0);
        
        # Add Funds
        $addfundsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $billingMenuId,
            "title" => (string) $DefaultTranslation['addfunds'],
            "url" => "clientarea.php?action=addfunds",
            "url_type" => "clientarea",
            "reorder" => 4,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "addfunds"
        ]);
        
        $this->addMenuItemTranslations($addfundsMenuId, $billingMenuId, 'addfunds');
        
        # Mass Payment
        $masspaymentMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $billingMenuId,
            "title" => (string) $DefaultTranslation['masspaytitle'],
            "url" => "clientarea.php?action=masspay&all=true",
            "url_type" => "clientarea",
            "reorder" => 5,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "masspay"
        ]);
        
        $this->addMenuItemTranslations($masspaymentMenuId, $billingMenuId, 'masspaytitle');
        
        # Manage Credit Card
        $manageccMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $billingMenuId,
            "title" => (string) $DefaultTranslation['navmanagecc'],
            "url" => "clientarea.php?action=creditcard",
            "url_type" => "clientarea",
            "reorder" => 6,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "updatecc"
        ]);
        
        $this->addMenuItemTranslations($manageccMenuId, $billingMenuId, 'navmanagecc');
        
        # Support
        $supportMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['navsupport'],
            "url" => "#",
            "url_type" => "external",
            "reorder" => 10,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($supportMenuId, 0, 'navsupport');
        
        # Tickets
        $myticketsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $supportMenuId,
            "title" => (string) $DefaultTranslation['navtickets'],
            "url" => "supporttickets.php",
            "url_type" => "clientarea",
            "reorder" => 1,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($myticketsMenuId, $supportMenuId, 'navtickets');
        
        # Announcements
        $announcementMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $supportMenuId,
            "title" => (string) $DefaultTranslation['announcementstitle'],
            "url" => "announcements",
            "url_type" => "internal",
            "reorder" => 2,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($announcementMenuId, $supportMenuId, 'announcementstitle');
        
        # Knowledgebase
        $knowledgebaseMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $supportMenuId,
            "title" => (string) $DefaultTranslation['knowledgebasetitle'],
            "url" => "knowledgebase",
            "url_type" => "internal",
            "reorder" => 3,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($knowledgebaseMenuId, $supportMenuId, 'knowledgebasetitle');
        
        # Downloads
        $downloadsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $supportMenuId,
            "title" => (string) $DefaultTranslation['downloadstitle'],
            "url" => "downloads.php",
            "url_type" => "internal",
            "reorder" => 4,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($downloadsMenuId, $supportMenuId, 'downloadstitle');
        
        # Network Status
        $networkMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $supportMenuId,
            "title" => (string) $DefaultTranslation['networkstatustitle'],
            "url" => "serverstatus.php",
            "url_type" => "internal",
            "reorder" => 5,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($networkMenuId, $supportMenuId, 'networkstatustitle');
        
        # Open Ticket
        $openticketMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['navopenticket'],
            "url" => "submitticket.php",
            "url_type" => "internal",
            "reorder" => 11,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($openticketMenuId, 0, 'navopenticket');
        
        # Affiliates
        $affiliatesMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['affiliatestitle'],
            "url" => "affiliates.php",
            "url_type" => "internal",
            "reorder" => 12,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "affiliates"
        ]);
        
        $this->addMenuItemTranslations($affiliatesMenuId, 0, 'affiliatestitle');
        
    }
    
    public function secondaryNavbar(){
        
        # Get Default Language
        $defaultLanguage = WHMCMS::getSystemDefaultLanguage();
        
        # Get Default Language Loaded
        if (is_file(ROOTDIR . "/lang/" . $defaultLanguage . ".php") === true){
            
            unset($_LANG);
            
            include(ROOTDIR . "/lang/" . $defaultLanguage . ".php");
            
            $DefaultTranslation = $_LANG;
            
            unset($_LANG);
            
            if (is_file(ROOTDIR . "/lang/overrides/" . $defaultLanguage . ".php") === true){
                include(ROOTDIR . "/lang/overrides/" . $defaultLanguage . ".php");
                
                $DefaultTranslation = array_replace_recursive($DefaultTranslation, $_LANG);
            }
            
        }
        
        # Visitors Menu
        $accountMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) $DefaultTranslation['account'],
            "url" => "#",
            "url_type" => "external",
            "reorder" => 1,
            "private" => 2,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($accountMenuId, 0, 'account');
        
        # Login
        $loginMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['login'],
            "url" => "login.php",
            "url_type" => "internal",
            "reorder" => 1,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($loginMenuId, 0, 'login');
        
        # Register
        $registerMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['register'],
            "url" => "register.php",
            "url_type" => "internal",
            "reorder" => 2,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($registerMenuId, 0, 'register');
        
        $this->addDivider($accountMenuId, 3, 0);
        
        # Forgot Password
        $forgotpasswordMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['forgotpw'],
            "url" => "pwreset.php",
            "url_type" => "internal",
            "reorder" => 4,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($forgotpasswordMenuId, 0, 'forgotpw');
        
        ### Clients Menu
        $accountMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => 0,
            "title" => (string) sprintf($DefaultTranslation['helloname'], '{$clientfirstname}'),
            "url" => "#",
            "url_type" => "external",
            "reorder" => 2,
            "private" => 1,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        
        $this->addMenuItemTranslations($accountMenuId, 0, 'hello', ', {$clientfirstname}!');
        
        # Edit Account Details
        $editdetailsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['editaccountdetails'],
            "url" => "clientarea.php?action=details",
            "url_type" => "clientarea",
            "reorder" => 1,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($editdetailsMenuId, 0, 'editaccountdetails');
        
        # Manage Credit Card
        $manageccMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['navmanagecc'],
            "url" => "clientarea.php?action=creditcard",
            "url_type" => "clientarea",
            "reorder" => 2,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s"),
            "menucondition" => "updatecc"
        ]);
        
        $this->addMenuItemTranslations($manageccMenuId, 0, 'navmanagecc');
        
        # Contacts
        $contactsMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['clientareanavcontacts'],
            "url" => "clientarea.php?action=contacts",
            "url_type" => "clientarea",
            "reorder" => 3,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($manageccMenuId, 0, 'clientareanavcontacts');
        
        # Email History
        $emailhistoryMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['navemailssent'],
            "url" => "clientarea.php?action=emails",
            "url_type" => "clientarea",
            "reorder" => 5,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($emailhistoryMenuId, 0, 'navemailssent');
        
        
        # Security
        $securityMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['clientareanavsecurity'],
            "url" => "clientarea.php?action=security",
            "url_type" => "clientarea",
            "reorder" => 6,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($securityMenuId, 0, 'clientareanavsecurity');
        
        # Change Password
        $changepasswordMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['clientareanavchangepw'],
            "url" => "clientarea.php?action=changepw",
            "url_type" => "clientarea",
            "reorder" => 7,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($changepasswordMenuId, 0, 'clientareanavchangepw');
        
        $this->addDivider($accountMenuId, 8, 0);
        
        # Logout
        $logoutMenuId = Capsule::table('mod_whmcms_menu')
        ->insertGetId([
            "categoryid" => $this->getMenuId(),
            "topid" => 0,
            "parentid" => $accountMenuId,
            "title" => (string) $DefaultTranslation['clientareanavlogout'],
            "url" => "logout.php",
            "url_type" => "clientarea",
            "reorder" => 9,
            "private" => 0,
            "language" => $defaultLanguage,
            "datecreate" => date("Y-m-d H:i:s"),
            "datemodify" => date("Y-m-d H:i:s")
        ]);
        
        $this->addMenuItemTranslations($logoutMenuId, 0, 'clientareanavlogout');
        
    }
    
}

?>