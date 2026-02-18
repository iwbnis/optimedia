<?php
define('CLIENTAREA', true);
define('FORCESSL', true);

# Define Frontend File Version For Compatibility Check
define("FRONTENDFILEVERSION", "3.3.1");


include('./configuration.php');

# Print Frontend File Version
if (isset($_REQUEST['getfrontendfileversion'])){

    if (md5($cc_encryption_hash) !== trim($_REQUEST['getfrontendfileversion'])){

        die("Invalid Request");

    }

    header("Content-Type: application/json; charset=utf-8;");

    echo json_encode(["frontendfileversion" => FRONTENDFILEVERSION]);

    exit;

}

# Init WHMCS
require_once('./init.php');

# Display Errors
if (isset($_REQUEST['whmcms_debug'])){
    error_reporting(E_ALL);
}

# Include WHMCMS Files
require_once(ROOTDIR . '/modules/addons/whmcms/vendor/autoload.php');

# Load Required Classes
use WHMCS\ClientArea as ClientArea;

use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Database\Capsule;

# Get Client Template
$template = WHMCMS::getClientTemplate();

# Get Client Language
$language = WHMCMS::getClientLanguage();

/****************************
 * Get Params
 *****************************/
$request = WHMCMS::getClientAreaRoutePath();
$action = $request['action'];
$params = WHMCMS::fromInput($request['params'], 'array');

# Unsupported Action
if (WHMCMS::fromInput($action, 'null') === null){

    $action = "errorpages.errorpages";

    $params['code'] = 404;

}

# Init WHMCS Client Area
$clientArea = new ClientArea();

if (isset($smarty)){
    $smarty->registerClass("WHMCMS", "\WHMCMS\Base");
}

# Init Smarty
$views = new Smarty();
$views->setCompileDir($templates_compiledir);
$views->setTemplateDir(ROOTDIR . "/");
$views->compile_id = "efccb7ef69c80261e2fba91ae5d82688";
$views->registerClass("WHMCMS", "\WHMCMS\Base");

# First Breadcrumbs
WHMCMS::addToBreadCrumbs(WHMCMS::getSystemURL(), Lang::trans('globalsystemname'));


#######################################
# [Pages]
#######################################
# Homepage
if ($action === "pages.homepage"){

    # Get Page
    $getPage = Capsule::table("mod_whmcms_pages")
    ->where("pageid", "=", WHMCMS::getConfig('homepage'))
    ->where("topid", "=", 0)
    ->select("alias")
    ->first();
    $getPage = (array) $getPage;

    $params['alias'] = $getPage['alias'];

}
# Display Pages and Homepage
if (in_array($action, ["pages.page", "pages.homepage"])){

    $alias = WHMCMS::fromInput($params['alias']);

    # Get Page
    $getPage = Capsule::table("mod_whmcms_pages")
    ->where("alias", "=", $alias)
    ->where("topid", "=", 0);

    # Always Display Pages for Admin
    if (WHMCMS::isAdmin() === false){
        $getPage->where("enable", "=", 1);
    }

    # Page Wasn't Found, Trigger 404 error
    if ($getPage->count() === 0){

        header("HTTP/1.0 404 Not Found");

        $action = "errorpages.errorpages";

        $params['code'] = 404;

    }
    # Display The Requested Page
    else {

        $getPage = (array) $getPage->first();

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_pages")
        ->where("topid", "=", $getPage['pageid'])
        ->where("language", "=", $language);

        if ($getTranslation->count() > 0){

            $getTranslation = (array) $getTranslation->first();

            $getPage['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $getPage['title'];
            $getPage['subtitle'] = (WHMCMS::fromInput($getTranslation['subtitle']) !== "") ? $getTranslation['subtitle'] : $getPage['subtitle'];
            $getPage['content'] = (WHMCMS::fromInput($getTranslation['content']) !== "") ? $getTranslation['content'] : $getPage['content'];

        }

        $clientArea->setPageTitle($getPage['title']);

        $clientArea->initPage();

        # Page Available for logged-in clients
        if (intval($getPage['private']) === 1 && WHMCMS::isAdmin() === false){
            $clientArea->requireLogin();
        }

        # Get Page Parents For BreadCrumbs
        foreach (WHMCMS::getPageParentsTree($getPage['pageid']) as $parent){
            WHMCMS::addToBreadCrumbs($parent['url'], $parent['title']);
        }

        # Update Page Hits
        Capsule::table("mod_whmcms_pages")
        ->where("pageid", $getPage['pageid'])
        ->update(["hits" => (intval($getPage['hits']) + 1)]);

        ###################################################
        $ActionParams = [
            "action" => $action,
            "params" => $params,
            "url" => WHMCMS::generateFriendlyURL($getPage, $action),
            "title" => $getPage['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
            "data" => [
                "pageid" => $getPage['pageid'],
                "title" => $getPage['title'],
                "subtitle" => $getPage['subtitle'],
                "alias" => $getPage['alias'],
                "content" => html_entity_decode($getPage['content'], ENT_QUOTES),
                "clientsonly" => ((intval($getPage['private']) === 1) ? true : false),
                "published" => ((intval($getPage['enable']) === 1) ? true : false),
                "hidetitle" => (($getPage['hidetitle'] === "on") ? true : false),
                "hidebreadcrumbs" => (($getPage['breadcrumbs'] === "on") ? true : false),
                "meta" => [
                    "keywords" => $getPage['metakeywords'],
                    "description" => $getPage['metadescription'],
                ],
                "robots" => [
                    "index" => (($getPage['metaindex'] === "on") ? true : false),
                    "follow" => (($getPage['metafollow'] === "on") ? true : false),
                    "archive" => (($getPage['metaarchive'] === "on") ? true : false),
                    "odp" => (($getPage['metaodp'] === "on") ? true : false),
                    "snippet" => (($getPage['metasnippet'] === "on") ? true : false),
                ],
                "views" => $getPage['hits'],
                "social" => [
                    "url" => WHMCMS::generateFriendlyURL($getPage, $action),
                    "title" => $getPage['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
                    "facebookButton" => (($getPage['fblike'] === "on") ? true : false),
                    "facebookComments" => (($getPage['fbcomment'] === "on") ? true : false),
                    "twitterButton" => (($getPage['twitter'] === "on") ? true : false),
                    "googlePlusButton" => (($getPage['googleplus'] === "on") ? true : false),
                ],
                "headoutput" => html_entity_decode($getPage['headercontent'], ENT_QUOTES),
                "created" => $getPage['datecreate'],
                "modified" => $getPage['datemodify'],
            ]
        ];

        foreach (run_hook("WHMCMS_ClientAreaPage", $ActionParams) as $index => $return){
            if (count(WHMCMS::fromInput($return['data'], 'array')) > 0){
                $ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS::fromInput($return['data'], 'array'));
                unset($return['data']);
                continue;
            }
        }

        #### >>> Get & Parse WHMCMS Pages' Content MergeFields

        $parsePageContent = $views->createData();

        foreach (run_hook("WHMCMS_ClientAreaPage_MergeFields", $ActionParams) as $index => $return){

            if (count(WHMCMS::fromInput($return, 'array')) > 0){

                foreach ($return as $key => $value){

                    $parsePageContent->assign($key, $value);

                }

            }

            unset($return);
            continue;
        }

        $pageContent = $views->fetch("string:" . $ActionParams['data']['content'], $parsePageContent);

        $ActionParams['data']['content'] = $pageContent;

        #### <<<


        $clientArea->assign("whmcms", $ActionParams);
        ###################################################

        # Assign Vars To Our View
        foreach($ActionParams['data'] as $key => $value){
            $views->assign($key, $value);
        }

        # Check if Customized TPL File Exists
        if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/pages.tpl") === true){
            $templateFile = file_get_contents(ROOTDIR . "/templates/" . $template . "/whmcms/pages.tpl");
        }
        # Display Default Template Instead
        else {
            $templateFile = file_get_contents(ROOTDIR . "/modules/addons/whmcms/clientarea/views/pages.tpl");
        }

        $output = $views->fetch("string:" . $templateFile);

        $clientArea->assign("displayTitle", $ActionParams['data']['title']);
        $clientArea->assign("tagline", $ActionParams['data']['subtitle']);
        $clientArea->assign("output", $output);

        if ($ActionParams['data']['hidebreadcrumbs'] === false){
            foreach (WHMCMS::getBreadCrumbs() as $link => $title){
                if ($link === WHMCMS::generateFriendlyURL($getPage, $action)){
                    $clientArea->addToBreadCrumb($link, $ActionParams['data']['title']);
                    continue;
                }
                $clientArea->addToBreadCrumb($link, $title);
            }
        }

        $clientArea->setTemplate('whmcms/output');

        $clientArea->output();

    }

}


#######################################
# [FAQ]
#######################################
if ($action === "faq.group"){

    $alias = WHMCMS::fromInput($params['alias']);

    # Get Group
    $getGroup = Capsule::table("mod_whmcms_faqgroups")
    ->where("alias", "=", $alias)
    ->where("topid", "=", 0);

    # Always Display FAQ Groups for Admin
    //if (WHMCMS::isAdmin() === false){
        //$getGroup->where("enable", "=", 1);
    //}

    # FAQ Group Wasn't Found, Trigger 404 error
    if ($getGroup->count() === 0){

        header("HTTP/1.0 404 Not Found");

        $action = "errorpages.errorpages";

        $params['code'] = 404;

    }
    # Display The Requested FAQ Group
    else {

        $getGroup = (array) $getGroup->first();

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_faqgroups")
        ->where("topid", "=", $getGroup['groupid'])
        ->where("language", "=", $language);

        if ($getTranslation->count() > 0){

            $getTranslation = (array) $getTranslation->first();

            $getGroup['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $getGroup['title'];

        }

        $clientArea->setPageTitle($getGroup['title']);

        $clientArea->initPage();

        # FAQ Group Available for logged-in clients
        //if ($getGroup['private'] === 1 && WHMCMS::isAdmin() === false){
            //$clientArea->requireLogin();
        //}

        # Update FAQ Group Hits
        Capsule::table("mod_whmcms_faqgroups")
        ->where("groupid", $getGroup['groupid'])
        ->update(["hits" => (intval($getGroup['hits']) + 1)]);

        ###################################################
        $ActionParams = [
            "action" => $action,
            "params" => $params,
            "url" => WHMCMS::generateFriendlyURL($getGroup, $action),
            "title" => $getGroup['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
            "data" => [
                "groupid" => $getGroup['groupid'],
                "title" => $getGroup['title'],
                "alias" => $getGroup['alias'],
                "views" => $getGroup['hits'],
                "social" => [
                    "url" => WHMCMS::generateFriendlyURL($getGroup, $action),
                    "title" => $getGroup['title'] . " - " . WHMCMS::getSystemConfig("CompanyName")
                ],
                "items" => []
            ]
        ];

        # Get FAQ Items
        $getItems = Capsule::table("mod_whmcms_faq")
        ->where("groupid", "=", $getGroup['groupid'])
        ->where("topid", "=", 0)
        ->where("enable", "=", 1)
        ->orderBy("faqid", "desc")
        ->get();

        # Get Translation and Assign Item to Group Data
        foreach ($getItems as $item){

            $item = (array) $item;

            # Get Translation
            $getTranslation = Capsule::table("mod_whmcms_faq")
            ->where("topid", "=", $item['faqid'])
            ->where("language", "=", $language);

            if ($getTranslation->count() > 0){
                $item['question'] = (WHMCMS::fromInput($getTranslation['question']) !== "") ? $getTranslation['question'] : $item['question'];
                $item['answer'] = (WHMCMS::fromInput($getTranslation['answer']) !== "") ? $getTranslation['answer'] : $item['answer'];
            }

            $ActionParams['data']['items'][ $item['faqid'] ] = [
                "itemid" => $item['faqid'],
                "question" => $item['question'],
                "answer" => html_entity_decode($item['answer'], ENT_QUOTES),
                "published" => ((intval($item['enable']) === 1) ? true : false),
                "created" => $item['datecreate'],
                "modified" => $item['datemodify']
            ];

        }

        # Run ActionHook To Allow Client Customizing The Final Data
        foreach (run_hook("WHMCMS_ClientAreaPage", $ActionParams) as $index => $return){
            if (count(WHMCMS::fromInput($return['data'], 'array')) > 0){
                $ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS::fromInput($return['data'], 'array'));
            }
        }


        #### >>> Get & Parse WHMCMS Pages' Content MergeFields

        foreach ($ActionParams['data']['items'] as $faqIndex => $faqItem){

            $parseFAQAnswer = $views->createData();

            foreach (run_hook("WHMCMS_ClientAreaPage_MergeFields", ["action" => "faq.item", "data" => $faqItem]) as $index => $return){

                if (count(WHMCMS::fromInput($return, 'array')) > 0){

                    foreach ($return as $key => $value){

                        $parseFAQAnswer->assign($key, $value);

                    }

                }

                unset($return);
                continue;
            }

            $faqAnswer = $views->fetch("string:" . $faqItem['answer'], $parseFAQAnswer);

            $ActionParams['data']['items'][ $faqIndex ]['answer'] = $faqAnswer;

        }
        #### <<<

        $clientArea->assign("whmcms", $ActionParams);
        ###################################################

        # Assign Vars To Our View
        foreach($ActionParams['data'] as $key => $value){
            $views->assign($key, $value);
        }

        # Check if Customized TPL File Exists
        if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/faq.tpl") === true){
            $templateFile = file_get_contents(ROOTDIR . "/templates/" . $template . "/whmcms/faq.tpl");
        }
        # Display Default Template Instead
        else {
            $templateFile = file_get_contents(ROOTDIR . "/modules/addons/whmcms/clientarea/views/faq.tpl");
        }

        $output = $views->fetch("string:" . $templateFile);

        $clientArea->assign("displayTitle", $ActionParams['data']['title']);
        $clientArea->assign("output", $output);


        WHMCMS::addToBreadCrumbs(WHMCMS::generateFriendlyURL($getGroup, $action), $ActionParams['data']['title']);

        foreach (WHMCMS::getBreadCrumbs() as $link => $title){
            $clientArea->addToBreadCrumb($link, $title);
        }

        $clientArea->setTemplate('whmcms/output');

        $clientArea->output();

    }

}


#######################################
# [Portfolio]
#######################################
if (in_array($action, ["portfolio.index", "portfolio.tag", "portfolio.category", "portfolio.project"])){

    # Define Project Listing Width/Height and # of Grid Columns
    if (WHMCMS::getConfig("portfolioitemsinrow") == "2"){
        $projectLogoWidth = 545;
        $projectLogoHeight = 300;
        $projectGridColumns = 6;
    }
    elseif (WHMCMS::getConfig("portfolioitemsinrow") == "3"){
        $projectLogoWidth = 350;
        $projectLogoHeight = 255;
        $projectGridColumns = 4;
    }
    elseif (WHMCMS::getConfig("portfolioitemsinrow") == "4"){
        $projectLogoWidth = 253;
        $projectLogoHeight = 184;
        $projectGridColumns = 3;
    }
    elseif (WHMCMS::getConfig("portfolioitemsinrow") == "6"){
        $projectLogoWidth = 155;
        $projectLogoHeight = 112;
        $projectGridColumns = 2;
    }

    # Get Categories
    $getCategories = Capsule::table("mod_whmcms_portfoliocategories")
    ->where("topid", "=", 0)
    ->where("enable", "=", 1);

    $categories = [];

    foreach ($getCategories->get() as $category){

        $category = (array) $category;

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_portfoliocategories")
        ->where("topid", "=", $category['categoryid'])
        ->where("language", "=", $language);

        if ($getTranslation->count() > 0){

            $getTranslation = (array) $getTranslation->first();

            $category['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $category['title'];

        }

        # Get Category Projects
        $getProjects = Capsule::table("mod_whmcms_portfoliorelations")
        ->join("mod_whmcms_portfolio", "mod_whmcms_portfoliorelations.projectid", "=", "mod_whmcms_portfolio.projectid")
        ->where("mod_whmcms_portfoliorelations.categoryid", "=", $category['categoryid'])
        ->where("mod_whmcms_portfolio.enable", "=", 1)
        ->select("mod_whmcms_portfoliorelations.projectid");

        $projects = [];

        foreach ($getProjects->get() as $project){

            $project = (array) $project;

            $projects[ $project['projectid'] ] = $project['projectid'];

        }

        $categories[ $category['categoryid'] ] = [
            "id" => $category['categoryid'],
            "title" => $category['title'],
            "alias" => $category['alias'],
            "url" => WHMCMS::generateFriendlyURL($category, "portfolio.category"),
            "projects" => $projects
        ];

    }

    # Portfolio Layouts
    $portfolioLayouts = [
        "default" => "portfolio_default.tpl",
        "onepage" => "portfolio_onepage.tpl",
        "category" => "portfolio_category.tpl",
        "filter" => "portfolio_filterable.tpl",
    ];

    $selectedPortfolioLayout = $portfolioLayouts[ WHMCMS::getConfig('portfoliolayout') ];

    ###################

    #######################
    ### Filterable Layout
    $filterButtons = [];
    $selectedFilter = "";

    # Get Filterable Buttons
    if (WHMCMS::getConfig("portfoliofilterby") === "category"){

        foreach ($categories as $category){
            $filterButtons[] = [
                "title" => $category['title'],
                "filter" => "_cat_" . $category['id'],
                "url" => WHMCMS::generateFriendlyURL($category, "portfolio.category")
            ];
        }

    }
    else {

        foreach (WHMCMS::getPortfolioTags() as $tagName => $tag){
            $filterButtons[] = [
                "title" => $tag,
                "filter" => "_tag_" . $tagName,
                "url" => WHMCMS::generateFriendlyURL(["alias" => $tag], "portfolio.tag")
            ];
        }

    }
    #######################


    # Portfolio Index
    $portfolioFriendlyURL = WHMCMS::generateFriendlyURL([], "portfolio.index");
    $pageTitle = WHMCMS::__('portfolioTitle');
    WHMCMS::addToBreadCrumbs($portfolioFriendlyURL, $pageTitle);

    # Default Category
    $selectedCategory = [
        "id" => 0,
        "title" => WHMCMS::__("portfolioAllCategory"),
        "url" => $portfolioFriendlyURL
    ];

    # Find and Display Category
    if ($action === "portfolio.category"){

        $alias = WHMCMS::fromInput($params['alias']);

        # Find Category
        $getCategory = Capsule::table("mod_whmcms_portfoliocategories")
        ->where("topid", "=", 0)
        ->where("enable", "=", 1)
        ->where("alias", "=", $alias);

        # Category Wasn't found, throw 404 error
        if ($getCategory->count() === 0){

            header("HTTP/1.0 404 Not Found");

            $action = "errorpages.errorpages";

            $params['code'] = 404;

        }
        else {

            $getCategory = (array) $getCategory->first();

            $selectedCategory = $categories[ $getCategory['categoryid'] ];

            $portfolioFriendlyURL = WHMCMS::generateFriendlyURL($selectedCategory, "portfolio.category");

            $pageTitle = $selectedCategory['title'];

            WHMCMS::addToBreadCrumbs($portfolioFriendlyURL, $pageTitle);

        }

        # Define Active Filter
        $selectedFilter = "_cat_" . $selectedCategory['id'];

        # Define Compatible Layout
        if (in_array(WHMCMS::getConfig('portfoliolayout'), ["default", "category"]) === false){
            $selectedPortfolioLayout = $portfolioLayouts['default'];
        }

    }

    $selectedTag = false;

    # Find and Display Tag
    if ($action === "portfolio.tag"){

        $tag = WHMCMS::fromInput($params['tag']);

        $selectedTag = [
            "name" => $tag,
            "url" => WHMCMS::generateFriendlyURL(['alias' => $tag], "portfolio.tag")
        ];

        $portfolioFriendlyURL = WHMCMS::generateFriendlyURL(['alias' => $tag], "portfolio.tag");

        $pageTitle = $tag;

        WHMCMS::addToBreadCrumbs($portfolioFriendlyURL, $pageTitle);

        # Define Active Filter
        $selectedFilter = "_tag_" . WHMCMS::toLower($tag);

        # Define Compatible Layout
        if (in_array(WHMCMS::getConfig('portfoliolayout'), ["default"]) === false){
            $selectedPortfolioLayout = $portfolioLayouts['default'];
        }

    }



}
# Portfolio Index, Portfolio Category, Portfolio Tags
if (in_array($action, ["portfolio.index", "portfolio.category", "portfolio.tag"])){

    # Get Projects
    $getProjects = Capsule::table("mod_whmcms_portfolio")
    ->where("mod_whmcms_portfolio.topid", "=", 0)
    ->where("mod_whmcms_portfolio.enable", "=", 1);

    # Filter Projects By Category
    if (intval($selectedCategory['id']) !== 0){
        $getProjects->join("mod_whmcms_portfoliorelations", "mod_whmcms_portfolio.projectid", "=", "mod_whmcms_portfoliorelations.projectid")
        ->where("mod_whmcms_portfoliorelations.categoryid", "=", $selectedCategory['id']);
    }

    # Filter Projects By Tag
    if ($selectedTag !== false){
        $getProjects->where("mod_whmcms_portfolio.tags", "like", "%" . $selectedTag['name'] . "%");
    }

    $projects = [];

    foreach ($getProjects->get() as $project){

        $project = (array) $project;

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_portfolio")
        ->where("topid", "=", $project['projectid'])
        ->where("language", "=", $language);

        if ($getTranslation->count() > 0){

            $getTranslation = (array) $getTranslation->first();

            $project['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $project['title'];
            $project['details'] = (WHMCMS::fromInput($getTranslation['details']) !== "") ? $getTranslation['details'] : $project['details'];

        }

        # Get Project Categories
        $getCategories = Capsule::table("mod_whmcms_portfoliorelations")
        ->join("mod_whmcms_portfoliocategories", "mod_whmcms_portfoliorelations.categoryid", "=", "mod_whmcms_portfoliocategories.categoryid")
        ->where("mod_whmcms_portfoliocategories.enable", "=", 1)
        ->where("mod_whmcms_portfoliorelations.projectid", "=", $project['projectid'])
        ->select("mod_whmcms_portfoliocategories.categoryid");

        $projectCategories = [];

        foreach ($getCategories->get() as $category){
            $category = (array) $category;
            $projectCategories[ $category['categoryid'] ] = $categories[ $category['categoryid'] ];
        }

        $project['categories'] = $projectCategories;

        $projects[] = $project;

    }

    $clientArea->setPageTitle($pageTitle);

    $clientArea->initPage();

    ###################################################
    $ActionParams = [
        "action" => $action,
        "params" => $params,
        "url" => $portfolioFriendlyURL,
        "title" => $pageTitle . " - " . WHMCMS::getSystemConfig("CompanyName"),
        "data" => [
            "projects" => [],
            "logowidth" => $projectLogoWidth,
            "logoheight" => $projectLogoHeight,
            "gridcolumns" => $projectGridColumns,
            "categories" => $categories,
            "selectedcategory" => $selectedCategory,
            "portfolioindex" => WHMCMS::generateFriendlyURL([], "portfolio.index"),
            "filterbuttons" => $filterButtons,
            "selectedfilter" => $selectedFilter
        ]
    ];

    # ~
    foreach ($projects as $project){

        # Get Project Tags
        $projectTags = [];

        foreach (explode(",", $project['tags']) as $tag){
            $tag = trim($tag);

            $projectTags[] = [
                "name" => $tag,
                "url" => WHMCMS::generateFriendlyURL(['alias' => $tag], "portfolio.tag")
            ];

        }

        $projectFilterButtons = [];

        # Get Project Filters
        if (WHMCMS::getConfig("portfoliofilterby") === "category"){

            foreach ($project['categories'] as $categoryId => $category){
                $projectFilterButtons[] = "_cat_" . $categoryId;
            }

        }
        else {

            foreach ($projectTags as $tag){
                $projectFilterButtons[] = "_tag_" . WHMCMS::toLower($tag['name']);
            }

        }

        $ActionParams['data']['projects'][ $project['projectid'] ] = [
            "projectid" => $project['projectid'],
            "title" => $project['title'],
            "alias" => $project['alias'],
            "client" => $project['client'],
            "url" => $project['url'],
            "logo" => $project['logo'],
            "introvideo" => (strlen($project['introvideo']) > 0 ? $project['introvideo'] : false),
            "tags" => $projectTags,
            "categories" => $project['categories'],
            "details" => html_entity_decode($project['details'], ENT_QUOTES),
            "published" => ((intval($project['enable']) === 1) ? true : false),
            "views" => $project['hits'],
            "social" => [
                "url" => WHMCMS::generateFriendlyURL($project, "portfolio.project"),
                "title" => $project['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
            ],
            "created" => $project['datecreate'],
            "modified" => $project['datemodify'],
            "filterclasses" => $projectFilterButtons
        ];
    }

    foreach (run_hook("WHMCMS_ClientAreaPage", $ActionParams) as $index => $return){
        if (count(WHMCMS::fromInput($return['data'], 'array')) > 0){
            $ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS::fromInput($return['data'], 'array'));
        }
    }
    $clientArea->assign("whmcms", $ActionParams);
    ###################################################

    # Assign Vars To Our View
    foreach($ActionParams['data'] as $key => $value){
        $views->assign($key, $value);
    }

    # Check if Customized TPL File Exists
    if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/" . $selectedPortfolioLayout) === true){
        $templateFile = file_get_contents(ROOTDIR . "/templates/" . $template . "/whmcms/" . $selectedPortfolioLayout);
    }
    # Display Default Template Instead
    else {
        $templateFile = file_get_contents(ROOTDIR . "/modules/addons/whmcms/clientarea/views/" . $selectedPortfolioLayout);
    }

    $output = $views->fetch("string:" . $templateFile);

    $clientArea->assign("displayTitle", $pageTitle);
    $clientArea->assign("output", $output);

    # ~
    foreach (WHMCMS::getBreadCrumbs() as $link => $title){
        $clientArea->addToBreadCrumb($link, $title);
    }

    $clientArea->setTemplate('whmcms/output');

    $clientArea->output();

}
# Portfolio Project
if ($action === "portfolio.project"){

    $alias = WHMCMS::fromInput($params['alias']);

    # Get Project
    $getProject = Capsule::table("mod_whmcms_portfolio")
    ->where("topid", "=", 0)
    ->where("enable", "=", 1)
    ->where("alias", "=", $alias);

    # Project Wasn't Found
    if ($getProject->count() === 0){

        header("HTTP/1.0 404 Not Found");

        $action = "errorpages.errorpages";

        $params['code'] = 404;

    }
    else {

        $getProject = $getProject->first();

        $project = (array) $getProject;

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_portfolio")
        ->where("topid", "=", $project['projectid'])
        ->where("language", "=", $language);

        if ($getTranslation->count() > 0){

            $getTranslation = (array) $getTranslation->first();

            $project['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $project['title'];
            $project['details'] = (WHMCMS::fromInput($getTranslation['details']) !== "") ? $getTranslation['details'] : $project['details'];

        }

        $clientArea->setPageTitle($project['title']);

        $clientArea->initPage();

        ###################################################
        $ActionParams = [
            "action" => $action,
            "params" => $params,
            "url" => WHMCMS::generateFriendlyURL($project, "portfolio.project"),
            "title" => $project['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
            "data" => []
        ];

        # Get Project Tags
        $projectTags = [];
        foreach (explode(",", $project['tags']) as $tag){
            $tag = trim($tag);

            $projectTags[] = [
                "name" => $tag,
                "url" => WHMCMS::generateFriendlyURL(['alias' => $tag], "portfolio.tag")
            ];

        }
        $project['tags'] = $projectTags;

        # Get Project Categories
        $getCategories = Capsule::table("mod_whmcms_portfoliorelations")
        ->join("mod_whmcms_portfoliocategories", "mod_whmcms_portfoliorelations.categoryid", "=", "mod_whmcms_portfoliocategories.categoryid")
        ->where("mod_whmcms_portfoliocategories.enable", "=", 1)
        ->select("mod_whmcms_portfoliocategories.categoryid");
        $projectCategories = [];
        foreach ($getCategories->get() as $category){
            $category = (array) $category;
            $projectCategories[ $category['categoryid'] ] = $categories[ $category['categoryid'] ];
        }
        $project['categories'] = $projectCategories;

        # Get Project Photos
        $getPhotos = Capsule::table("mod_whmcms_photos")
        ->where("topid", "=", 0)
        ->where("enable", "=", 1)
        ->where("parentid", "=", $project['projectid']);
        $projectPhotos = [];
        foreach ($getPhotos->get() as $photo){
            $photo = (array) $photo;

            # Get Translation
            $getTranslation = Capsule::table("mod_whmcms_photos")
            ->where("topid", "=", $photo['photoid'])
            ->where("language", "=", $language);

            if ($getTranslation->count() > 0){

                $getTranslation = (array) $getTranslation->first();

                $photo['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $photo['title'];
                $photo['details'] = (WHMCMS::fromInput($getTranslation['details']) !== "") ? $getTranslation['details'] : $photo['details'];

            }

            $projectPhotos[] = [
                "photoid" => $photo['photoid'],
                "title" => $photo['title'],
                "details" => html_entity_decode($photo['details'], ENT_QUOTES),
                "source" => $photo['source'],
                "modified" => $photo['datemodify'],
                "published" => ((intval($photo['enable']) === 1) ? true : false),
                "url" => WHMCMS::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $photo['source']
            ];

        }
        $project['photos'] = $projectPhotos;

        $ActionParams['data'] = [
            "projectid" => $project['projectid'],
            "title" => $project['title'],
            "alias" => $project['alias'],
            "client" => $project['client'],
            "url" => $project['url'],
            "logo" => $project['logo'],
            "introvideo" => (strlen($project['introvideo']) > 0 ? $project['introvideo'] : false),
            "tags" => $project['tags'],
            "categories" => $project['categories'],
            "details" => html_entity_decode($project['details'], ENT_QUOTES),
            "published" => ((intval($project['enable']) === 1) ? true : false),
            "datepublished" => fromMySQLDate($project['datepublished']),
            "views" => $project['hits'],
            "photos" => $project['photos'],
            "social" => [
                "url" => WHMCMS::generateFriendlyURL($project, "portfolio.project"),
                "title" => $project['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
            ],
            "created" => $project['datecreate'],
            "modified" => $project['datemodify']
        ];

        $ActionParams['data']['portfolioindex'] = WHMCMS::generateFriendlyURL([], "portfolio.index");

        foreach (run_hook("WHMCMS_ClientAreaPage", $ActionParams) as $index => $return){
            if (count(WHMCMS::fromInput($return['data'], 'array')) > 0){
                $ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS::fromInput($return['data'], 'array'));
            }
        }
        $clientArea->assign("whmcms", $ActionParams);
        ###################################################

        # Assign Vars To Our View
        foreach($ActionParams['data'] as $key => $value){
            $views->assign($key, $value);
        }

        # Check if Customized TPL File Exists
        if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/portfolio_project.tpl") === true){
            $templateFile = file_get_contents(ROOTDIR . "/templates/" . $template . "/whmcms/portfolio_project.tpl");
        }
        # Display Default Template Instead
        else {
            $templateFile = file_get_contents(ROOTDIR . "/modules/addons/whmcms/clientarea/views/portfolio_project.tpl");
        }

        $pageTitle = $ActionParams['data']['title'];

        $output = $views->fetch("string:" . $templateFile);

        $clientArea->assign("displayTitle", $pageTitle);
        $clientArea->assign("output", $output);

        # ~
        WHMCMS::addToBreadCrumbs(WHMCMS::generateFriendlyURL($project, $action), $ActionParams['data']['title']);
        foreach (WHMCMS::getBreadCrumbs() as $link => $title){
            $clientArea->addToBreadCrumb($link, $title);
        }

        $clientArea->setTemplate('whmcms/output');

        $clientArea->output();

    }

}



#######################################
# [ErrorPages]
#######################################
if ($action === "errorpages.errorpages"){

    $code = WHMCMS::fromInput($params['code'], 'int');

    # Get Page
    $getPage = Capsule::table("mod_whmcms_errorpages")
    ->where("code", "=", $code)
    ->where("topid", "=", 0);

    # Page Wasn't Found, Trigger 404 error
    if ($getPage->count() === 0){

        header("HTTP/1.0 404 Not Found");

        $code = 404;

    }

    # Display The Requested Page
    if ($code > 200) {

        # Get Page
        $getPage = Capsule::table("mod_whmcms_errorpages")
        ->where("code", "=", $code)
        ->where("topid", "=", 0);

        $getPage = (array) $getPage->first();

        # Get Translation
        $getTranslation = Capsule::table("mod_whmcms_errorpages")
        ->where("topid", "=", $getPage['pageid'])
        ->where("language", "=", $language);

        if ($getTranslation->count() > 0){

            $getTranslation = (array) $getTranslation->first();

            $getPage['title'] = (WHMCMS::fromInput($getTranslation['title']) !== "") ? $getTranslation['title'] : $getPage['title'];
            $getPage['content'] = (WHMCMS::fromInput($getTranslation['content']) !== "") ? $getTranslation['content'] : $getPage['content'];

        }

        $clientArea->setPageTitle($getPage['title']);

        $clientArea->initPage();

        # Update Page Hits
        if (WHMCMS::isAdmin() === false){
            Capsule::table("mod_whmcms_errorpages")
            ->where("pageid", $getPage['pageid'])
            ->update(["hits" => (intval($getPage['hits']) + 1), "datelastvisit" => date("Y-m-d H:i:s")]);
        }

        # Get Target URL
        $targetUrl = ((!empty($_SERVER['HTTPS'])) ? "https://" : "http://") . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        # Insert Error Log
        if ($targetUrl !== WHMCMS::generateFriendlyURL($getPage, $action)){
            Capsule::table("mod_whmcms_errorlog")
            ->insert([
                'code' => $code,
                'refurl' => WHMCMS::fromInput($_SERVER['HTTP_REFERER']),
                'targeturl' => $targetUrl,
                'datecreate' => date("Y-m-d H:i:s"),
                'ip' => WHMCMS::fromInput($_SERVER["REMOTE_ADDR"]),
                'useragent' => WHMCMS::fromInput($_SERVER['HTTP_USER_AGENT'])
            ]);
        }

        ###################################################
        $ActionParams = [
            "action" => $action,
            "params" => $params,
            "url" => WHMCMS::generateFriendlyURL($getPage, $action),
            "title" => $getPage['title'] . " - " . WHMCMS::getSystemConfig("CompanyName"),
            "data" => [
                "pageid" => $getPage['pageid'],
                "title" => $getPage['title'],
                "code" => $getPage['code'],
                "content" => html_entity_decode($getPage['content'], ENT_QUOTES),
                "views" => $getPage['hits'],
                "social" => [
                    "url" => WHMCMS::generateFriendlyURL($getPage, $action),
                    "title" => $getPage['title'] . " - " . WHMCMS::getSystemConfig("CompanyName")
                ],
                "headoutput" => html_entity_decode($getPage['headercontent'], ENT_QUOTES),
                "created" => $getPage['datecreate'],
                "modified" => $getPage['datemodify'],
            ]
        ];

        foreach (run_hook("WHMCMS_ClientAreaPage", $ActionParams) as $index => $return){
            if (count(WHMCMS::fromInput($return['data'], 'array')) > 0){
                $ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS::fromInput($return['data'], 'array'));
            }
        }
        $clientArea->assign("whmcms", $ActionParams);
        ###################################################

        # Assign Vars To Our View
        foreach($ActionParams['data'] as $key => $value){
            $views->assign($key, $value);
        }

        # Check if Customized TPL File Exists
        if (is_file(ROOTDIR . "/templates/" . $template . "/whmcms/errorpages.tpl") === true){
            $templateFile = file_get_contents(ROOTDIR . "/templates/" . $template . "/whmcms/errorpages.tpl");
        }
        # Display Default Template Instead
        else {
            $templateFile = file_get_contents(ROOTDIR . "/modules/addons/whmcms/clientarea/views/errorpages.tpl");
        }

        $output = $views->fetch("string:" . $templateFile);

        $clientArea->assign("displayTitle", $ActionParams['data']['title']);
        $clientArea->assign("output", $output);

        WHMCMS::addToBreadCrumbs(WHMCMS::generateFriendlyURL($getPage, $action), $ActionParams['data']['title']);
        foreach (WHMCMS::getBreadCrumbs() as $link => $title){
            $clientArea->addToBreadCrumb($link, $title);
        }

        $clientArea->setTemplate('whmcms/output');

        $clientArea->output();

    }

}

?>
