<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.1.0.0
* @ Author			:	DeZender
* @ Release on		:	15.05.2020
* @ Official site	:	http://DeZender.Net
*
*/

define('CLIENTAREA', true);
define('FORCESSL', true);
define('FRONTENDFILEVERSION', '3.2.0');
include './configuration.php';

if (isset($_REQUEST['getfrontendfileversion'])) {
	if (md5($cc_encryption_hash) !== trim($_REQUEST['getfrontendfileversion'])) {
		exit('Invalid Request');
	}

	header('Content-Type: application/json; charset=utf-8;');
	echo json_encode(['frontendfileversion' => FRONTENDFILEVERSION]);
	exit();
}

require_once './init.php';

if (isset($_REQUEST['whmcms_debug'])) {
	error_reporting(32767);
}

require_once ROOTDIR . '/modules/addons/whmcms/vendor/autoload.php';
$template = WHMCMS\Base::getClientTemplate();
$language = WHMCMS\Base::getClientLanguage();
$request = WHMCMS\Base::getClientAreaRoutePath();
$action = $request['action'];
$params = WHMCMS\Base::fromInput($request['params'], 'array');

if (WHMCMS\Base::fromInput($action, 'null') === NULL) {
	$action = 'errorpages.errorpages';
	$params['code'] = 404;
}

$clientArea = new WHMCS\ClientArea();

if (isset($smarty)) {
	$smarty->registerClass('WHMCMS', '\\WHMCMS\\Base');
}

$views = new Smarty();
$views->setCompileDir($templates_compiledir);
$views->setTemplateDir(ROOTDIR . '/');
$views->compile_id = 'efccb7ef69c80261e2fba91ae5d82688';
$views->registerClass('WHMCMS', '\\WHMCMS\\Base');
WHMCMS\Base::addToBreadCrumbs(WHMCMS\Base::getSystemURL(), Lang::trans('globalsystemname'));

if ($action === 'pages.homepage') {
	$getPage = WHMCMS\Database\Capsule::table('mod_whmcms_pages')->where('pageid', '=', WHMCMS\Base::getConfig('homepage'))->where('topid', '=', 0)->select('alias')->first();
	$getPage = (array) $getPage;
	$params['alias'] = $getPage['alias'];
}

if (in_array($action, ['pages.page', 'pages.homepage'])) {
	$alias = WHMCMS\Base::fromInput($params['alias']);
	$getPage = WHMCMS\Database\Capsule::table('mod_whmcms_pages')->where('alias', '=', $alias)->where('topid', '=', 0);

	if (WHMCMS\Base::isAdmin() === false) {
		$getPage->where('enable', '=', 1);
	}

	if ($getPage->count() === 0) {
		header('HTTP/1.0 404 Not Found');
		$action = 'errorpages.errorpages';
		$params['code'] = 404;
	}
	else {
		$getPage = (array) $getPage->first();
		$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_pages')->where('topid', '=', $getPage['pageid'])->where('language', '=', $language);

		if (0 < $getTranslation->count()) {
			$getTranslation = (array) $getTranslation->first();
			$getPage['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $getPage['title']);
			$getPage['subtitle'] = (WHMCMS\Base::fromInput($getTranslation['subtitle']) !== '' ? $getTranslation['subtitle'] : $getPage['subtitle']);
			$getPage['content'] = (WHMCMS\Base::fromInput($getTranslation['content']) !== '' ? $getTranslation['content'] : $getPage['content']);
		}

		$clientArea->setPageTitle($getPage['title']);
		$clientArea->initPage();
		if ((intval($getPage['private']) === 1) && (WHMCMS\Base::isAdmin() === false)) {
			$clientArea->requireLogin();
		}

		foreach (WHMCMS\Base::getPageParentsTree($getPage['pageid']) as $parent) {
			WHMCMS\Base::addToBreadCrumbs($parent['url'], $parent['title']);
		}

		WHMCMS\Database\Capsule::table('mod_whmcms_pages')->where('pageid', $getPage['pageid'])->update(['hits' => intval($getPage['hits']) + 1]);
		$ActionParams = [
			'action' => $action,
			'params' => $params,
			'url'    => WHMCMS\Base::generateFriendlyURL($getPage, $action),
			'title'  => $getPage['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName'),
			'data'   => [
				'pageid'          => $getPage['pageid'],
				'title'           => $getPage['title'],
				'subtitle'        => $getPage['subtitle'],
				'alias'           => $getPage['alias'],
				'content'         => html_entity_decode($getPage['content'], ENT_QUOTES),
				'clientsonly'     => intval($getPage['private']) === 1 ? true : false,
				'published'       => intval($getPage['enable']) === 1 ? true : false,
				'hidetitle'       => $getPage['hidetitle'] === 'on' ? true : false,
				'hidebreadcrumbs' => $getPage['breadcrumbs'] === 'on' ? true : false,
				'meta'            => ['keywords' => $getPage['metakeywords'], 'description' => $getPage['metadescription']],
				'robots'          => ['index' => $getPage['metaindex'] === 'on' ? true : false, 'follow' => $getPage['metafollow'] === 'on' ? true : false, 'archive' => $getPage['metaarchive'] === 'on' ? true : false, 'odp' => $getPage['metaodp'] === 'on' ? true : false, 'snippet' => $getPage['metasnippet'] === 'on' ? true : false],
				'views'           => $getPage['hits'],
				'social'          => ['url' => WHMCMS\Base::generateFriendlyURL($getPage, $action), 'title' => $getPage['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName'), 'facebookButton' => $getPage['fblike'] === 'on' ? true : false, 'facebookComments' => $getPage['fbcomment'] === 'on' ? true : false, 'twitterButton' => $getPage['twitter'] === 'on' ? true : false, 'googlePlusButton' => $getPage['googleplus'] === 'on' ? true : false],
				'headoutput'      => html_entity_decode($getPage['headercontent'], ENT_QUOTES),
				'created'         => $getPage['datecreate'],
				'modified'        => $getPage['datemodify']
			]
		];

		foreach (run_hook('WHMCMS_ClientAreaPage', $ActionParams) as $index => $return) {
			if (0 < count(WHMCMS\Base::fromInput($return['data'], 'array'))) {
				$ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS\Base::fromInput($return['data'], 'array'));
				unset($return['data']);
				continue;
			}
		}

		$parsePageContent = $views->createData();

		foreach (run_hook('WHMCMS_ClientAreaPage_MergeFields', $ActionParams) as $index => $return) {
			if (0 < count(WHMCMS\Base::fromInput($return, 'array'))) {
				foreach ($return as $key => $value) {
					$parsePageContent->assign($key, $value);
				}
			}

			unset($return);
			continue;
		}

		$pageContent = $views->fetch('string:' . $ActionParams['data']['content'], $parsePageContent);
		$ActionParams['data']['content'] = $pageContent;
		$clientArea->assign('whmcms', $ActionParams);

		foreach ($ActionParams['data'] as $key => $value) {
			$views->assign($key, $value);
		}

		if (is_file(ROOTDIR . '/templates/' . $template . '/whmcms/pages.tpl') === true) {
			$templateFile = file_get_contents(ROOTDIR . '/templates/' . $template . '/whmcms/pages.tpl');
		}
		else {
			$templateFile = file_get_contents(ROOTDIR . '/modules/addons/whmcms/clientarea/views/pages.tpl');
		}

		$output = $views->fetch('string:' . $templateFile);
		$clientArea->assign('displayTitle', $ActionParams['data']['title']);
		$clientArea->assign('tagline', $ActionParams['data']['subtitle']);
		$clientArea->assign('output', $output);

		if ($ActionParams['data']['hidebreadcrumbs'] === false) {
			foreach (WHMCMS\Base::getBreadCrumbs() as $link => $title) {
				if ($link === WHMCMS\Base::generateFriendlyURL($getPage, $action)) {
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

if ($action === 'faq.group') {
	$alias = WHMCMS\Base::fromInput($params['alias']);
	$getGroup = WHMCMS\Database\Capsule::table('mod_whmcms_faqgroups')->where('alias', '=', $alias)->where('topid', '=', 0);

	if ($getGroup->count() === 0) {
		header('HTTP/1.0 404 Not Found');
		$action = 'errorpages.errorpages';
		$params['code'] = 404;
	}
	else {
		$getGroup = (array) $getGroup->first();
		$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_faqgroups')->where('topid', '=', $getGroup['groupid'])->where('language', '=', $language);

		if (0 < $getTranslation->count()) {
			$getTranslation = (array) $getTranslation->first();
			$getGroup['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $getGroup['title']);
		}

		$clientArea->setPageTitle($getGroup['title']);
		$clientArea->initPage();
		WHMCMS\Database\Capsule::table('mod_whmcms_faqgroups')->where('groupid', $getGroup['groupid'])->update(['hits' => intval($getGroup['hits']) + 1]);
		$ActionParams = [
			'action' => $action,
			'params' => $params,
			'url'    => WHMCMS\Base::generateFriendlyURL($getGroup, $action),
			'title'  => $getGroup['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName'),
			'data'   => [
				'groupid' => $getGroup['groupid'],
				'title'   => $getGroup['title'],
				'alias'   => $getGroup['alias'],
				'views'   => $getGroup['hits'],
				'social'  => ['url' => WHMCMS\Base::generateFriendlyURL($getGroup, $action), 'title' => $getGroup['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName')],
				'items'   => []
			]
		];
		$getItems = WHMCMS\Database\Capsule::table('mod_whmcms_faq')->where('groupid', '=', $getGroup['groupid'])->where('topid', '=', 0)->where('enable', '=', 1)->orderBy('faqid', 'desc')->get();

		foreach ($getItems as $item) {
			$item = (array) $item;
			$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_faq')->where('topid', '=', $item['faqid'])->where('language', '=', $language);

			if (0 < $getTranslation->count()) {
				$item['question'] = (WHMCMS\Base::fromInput($getTranslation['question']) !== '' ? $getTranslation['question'] : $item['question']);
				$item['answer'] = (WHMCMS\Base::fromInput($getTranslation['answer']) !== '' ? $getTranslation['answer'] : $item['answer']);
			}

			$ActionParams['data']['items'][$item['faqid']] = ['itemid' => $item['faqid'], 'question' => $item['question'], 'answer' => html_entity_decode($item['answer'], ENT_QUOTES), 'published' => intval($item['enable']) === 1 ? true : false, 'created' => $item['datecreate'], 'modified' => $item['datemodify']];
		}

		foreach (run_hook('WHMCMS_ClientAreaPage', $ActionParams) as $index => $return) {
			if (0 < count(WHMCMS\Base::fromInput($return['data'], 'array'))) {
				$ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS\Base::fromInput($return['data'], 'array'));
			}
		}

		foreach ($ActionParams['data']['items'] as $faqIndex => $faqItem) {
			$parseFAQAnswer = $views->createData();

			foreach (run_hook('WHMCMS_ClientAreaPage_MergeFields', ['action' => 'faq.item', 'data' => $faqItem]) as $index => $return) {
				if (0 < count(WHMCMS\Base::fromInput($return, 'array'))) {
					foreach ($return as $key => $value) {
						$parseFAQAnswer->assign($key, $value);
					}
				}

				unset($return);
				continue;
			}

			$faqAnswer = $views->fetch('string:' . $faqItem['answer'], $parseFAQAnswer);
			$ActionParams['data']['items'][$faqIndex]['answer'] = $faqAnswer;
		}

		$clientArea->assign('whmcms', $ActionParams);

		foreach ($ActionParams['data'] as $key => $value) {
			$views->assign($key, $value);
		}

		if (is_file(ROOTDIR . '/templates/' . $template . '/whmcms/faq.tpl') === true) {
			$templateFile = file_get_contents(ROOTDIR . '/templates/' . $template . '/whmcms/faq.tpl');
		}
		else {
			$templateFile = file_get_contents(ROOTDIR . '/modules/addons/whmcms/clientarea/views/faq.tpl');
		}

		$output = $views->fetch('string:' . $templateFile);
		$clientArea->assign('displayTitle', $ActionParams['data']['title']);
		$clientArea->assign('output', $output);
		WHMCMS\Base::addToBreadCrumbs(WHMCMS\Base::generateFriendlyURL($getGroup, $action), $ActionParams['data']['title']);

		foreach (WHMCMS\Base::getBreadCrumbs() as $link => $title) {
			$clientArea->addToBreadCrumb($link, $title);
		}

		$clientArea->setTemplate('whmcms/output');
		$clientArea->output();
	}
}

if (in_array($action, ['portfolio.index', 'portfolio.tag', 'portfolio.category', 'portfolio.project'])) {
	if (WHMCMS\Base::getConfig('portfolioitemsinrow') == '2') {
		$projectLogoWidth = 545;
		$projectLogoHeight = 300;
		$projectGridColumns = 6;
	}
	else if (WHMCMS\Base::getConfig('portfolioitemsinrow') == '3') {
		$projectLogoWidth = 350;
		$projectLogoHeight = 255;
		$projectGridColumns = 4;
	}
	else if (WHMCMS\Base::getConfig('portfolioitemsinrow') == '4') {
		$projectLogoWidth = 253;
		$projectLogoHeight = 184;
		$projectGridColumns = 3;
	}
	else if (WHMCMS\Base::getConfig('portfolioitemsinrow') == '6') {
		$projectLogoWidth = 155;
		$projectLogoHeight = 112;
		$projectGridColumns = 2;
	}

	$getCategories = WHMCMS\Database\Capsule::table('mod_whmcms_portfoliocategories')->where('topid', '=', 0)->where('enable', '=', 1);
	$categories = [];

	foreach ($getCategories->get() as $category) {
		$category = (array) $category;
		$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_portfoliocategories')->where('topid', '=', $category['categoryid'])->where('language', '=', $language);

		if (0 < $getTranslation->count()) {
			$getTranslation = (array) $getTranslation->first();
			$category['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $category['title']);
		}

		$getProjects = WHMCMS\Database\Capsule::table('mod_whmcms_portfoliorelations')->join('mod_whmcms_portfolio', 'mod_whmcms_portfoliorelations.projectid', '=', 'mod_whmcms_portfolio.projectid')->where('mod_whmcms_portfoliorelations.categoryid', '=', $category['categoryid'])->where('mod_whmcms_portfolio.enable', '=', 1)->select('mod_whmcms_portfoliorelations.projectid');
		$projects = [];

		foreach ($getProjects->get() as $project) {
			$project = (array) $project;
			$projects[$project['projectid']] = $project['projectid'];
		}

		$categories[$category['categoryid']] = ['id' => $category['categoryid'], 'title' => $category['title'], 'alias' => $category['alias'], 'url' => WHMCMS\Base::generateFriendlyURL($category, 'portfolio.category'), 'projects' => $projects];
	}

	$portfolioLayouts = ['default' => 'portfolio_default.tpl', 'onepage' => 'portfolio_onepage.tpl', 'category' => 'portfolio_category.tpl', 'filter' => 'portfolio_filterable.tpl'];
	$selectedPortfolioLayout = $portfolioLayouts[WHMCMS\Base::getConfig('portfoliolayout')];
	$filterButtons = [];
	$selectedFilter = '';

	if (WHMCMS\Base::getConfig('portfoliofilterby') === 'category') {
		foreach ($categories as $category) {
			$filterButtons[] = ['title' => $category['title'], 'filter' => '_cat_' . $category['id'], 'url' => WHMCMS\Base::generateFriendlyURL($category, 'portfolio.category')];
		}
	}
	else {
		foreach (WHMCMS\Base::getPortfolioTags() as $tagName => $tag) {
			$filterButtons[] = ['title' => $tag, 'filter' => '_tag_' . $tagName, 'url' => WHMCMS\Base::generateFriendlyURL(['alias' => $tag], 'portfolio.tag')];
		}
	}

	$portfolioFriendlyURL = WHMCMS\Base::generateFriendlyURL([], 'portfolio.index');
	$pageTitle = WHMCMS\Base::__('portfolioTitle');
	WHMCMS\Base::addToBreadCrumbs($portfolioFriendlyURL, $pageTitle);
	$selectedCategory = ['id' => 0, 'title' => WHMCMS\Base::__('portfolioAllCategory'), 'url' => $portfolioFriendlyURL];

	if ($action === 'portfolio.category') {
		$alias = WHMCMS\Base::fromInput($params['alias']);
		$getCategory = WHMCMS\Database\Capsule::table('mod_whmcms_portfoliocategories')->where('topid', '=', 0)->where('enable', '=', 1)->where('alias', '=', $alias);

		if ($getCategory->count() === 0) {
			header('HTTP/1.0 404 Not Found');
			$action = 'errorpages.errorpages';
			$params['code'] = 404;
		}
		else {
			$getCategory = (array) $getCategory->first();
			$selectedCategory = $categories[$getCategory['categoryid']];
			$portfolioFriendlyURL = WHMCMS\Base::generateFriendlyURL($selectedCategory, 'portfolio.category');
			$pageTitle = $selectedCategory['title'];
			WHMCMS\Base::addToBreadCrumbs($portfolioFriendlyURL, $pageTitle);
		}

		$selectedFilter = '_cat_' . $selectedCategory['id'];

		if (in_array(WHMCMS\Base::getConfig('portfoliolayout'), ['default', 'category']) === false) {
			$selectedPortfolioLayout = $portfolioLayouts['default'];
		}
	}

	$selectedTag = false;

	if ($action === 'portfolio.tag') {
		$tag = WHMCMS\Base::fromInput($params['tag']);
		$selectedTag = ['name' => $tag, 'url' => WHMCMS\Base::generateFriendlyURL(['alias' => $tag], 'portfolio.tag')];
		$portfolioFriendlyURL = WHMCMS\Base::generateFriendlyURL(['alias' => $tag], 'portfolio.tag');
		$pageTitle = $tag;
		WHMCMS\Base::addToBreadCrumbs($portfolioFriendlyURL, $pageTitle);
		$selectedFilter = '_tag_' . WHMCMS\Base::toLower($tag);

		if (in_array(WHMCMS\Base::getConfig('portfoliolayout'), ['default']) === false) {
			$selectedPortfolioLayout = $portfolioLayouts['default'];
		}
	}
}

if (in_array($action, ['portfolio.index', 'portfolio.category', 'portfolio.tag'])) {
	$getProjects = WHMCMS\Database\Capsule::table('mod_whmcms_portfolio')->where('mod_whmcms_portfolio.topid', '=', 0)->where('mod_whmcms_portfolio.enable', '=', 1);

	if (intval($selectedCategory['id']) !== 0) {
		$getProjects->join('mod_whmcms_portfoliorelations', 'mod_whmcms_portfolio.projectid', '=', 'mod_whmcms_portfoliorelations.projectid')->where('mod_whmcms_portfoliorelations.categoryid', '=', $selectedCategory['id']);
	}

	if ($selectedTag !== false) {
		$getProjects->where('mod_whmcms_portfolio.tags', 'like', '%' . $selectedTag['name'] . '%');
	}

	$projects = [];

	foreach ($getProjects->get() as $project) {
		$project = (array) $project;
		$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_portfolio')->where('topid', '=', $project['projectid'])->where('language', '=', $language);

		if (0 < $getTranslation->count()) {
			$getTranslation = (array) $getTranslation->first();
			$project['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $project['title']);
			$project['details'] = (WHMCMS\Base::fromInput($getTranslation['details']) !== '' ? $getTranslation['details'] : $project['details']);
		}

		$getCategories = WHMCMS\Database\Capsule::table('mod_whmcms_portfoliorelations')->join('mod_whmcms_portfoliocategories', 'mod_whmcms_portfoliorelations.categoryid', '=', 'mod_whmcms_portfoliocategories.categoryid')->where('mod_whmcms_portfoliocategories.enable', '=', 1)->where('mod_whmcms_portfoliorelations.projectid', '=', $project['projectid'])->select('mod_whmcms_portfoliocategories.categoryid');
		$projectCategories = [];

		foreach ($getCategories->get() as $category) {
			$category = (array) $category;
			$projectCategories[$category['categoryid']] = $categories[$category['categoryid']];
		}

		$project['categories'] = $projectCategories;
		$projects[] = $project;
	}

	$clientArea->setPageTitle($pageTitle);
	$clientArea->initPage();
	$ActionParams = [
		'action' => $action,
		'params' => $params,
		'url'    => $portfolioFriendlyURL,
		'title'  => $pageTitle . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName'),
		'data'   => [
			'projects'         => [],
			'logowidth'        => $projectLogoWidth,
			'logoheight'       => $projectLogoHeight,
			'gridcolumns'      => $projectGridColumns,
			'categories'       => $categories,
			'selectedcategory' => $selectedCategory,
			'portfolioindex'   => WHMCMS\Base::generateFriendlyURL([], 'portfolio.index'),
			'filterbuttons'    => $filterButtons,
			'selectedfilter'   => $selectedFilter
		]
	];

	foreach ($projects as $project) {
		$projectTags = [];

		foreach (explode(',', $project['tags']) as $tag) {
			$tag = trim($tag);
			$projectTags[] = ['name' => $tag, 'url' => WHMCMS\Base::generateFriendlyURL(['alias' => $tag], 'portfolio.tag')];
		}

		$projectFilterButtons = [];

		if (WHMCMS\Base::getConfig('portfoliofilterby') === 'category') {
			foreach ($project['categories'] as $categoryId => $category) {
				$projectFilterButtons[] = '_cat_' . $categoryId;
			}
		}
		else {
			foreach ($projectTags as $tag) {
				$projectFilterButtons[] = '_tag_' . WHMCMS\Base::toLower($tag['name']);
			}
		}

		$ActionParams['data']['projects'][$project['projectid']] = [
			'projectid'     => $project['projectid'],
			'title'         => $project['title'],
			'alias'         => $project['alias'],
			'client'        => $project['client'],
			'url'           => $project['url'],
			'logo'          => $project['logo'],
			'tags'          => $projectTags,
			'categories'    => $project['categories'],
			'details'       => html_entity_decode($project['details'], ENT_QUOTES),
			'published'     => intval($project['enable']) === 1 ? true : false,
			'views'         => $project['hits'],
			'social'        => ['url' => WHMCMS\Base::generateFriendlyURL($project, 'portfolio.project'), 'title' => $project['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName')],
			'created'       => $project['datecreate'],
			'modified'      => $project['datemodify'],
			'filterclasses' => $projectFilterButtons
		];
	}

	foreach (run_hook('WHMCMS_ClientAreaPage', $ActionParams) as $index => $return) {
		if (0 < count(WHMCMS\Base::fromInput($return['data'], 'array'))) {
			$ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS\Base::fromInput($return['data'], 'array'));
		}
	}

	$clientArea->assign('whmcms', $ActionParams);

	foreach ($ActionParams['data'] as $key => $value) {
		$views->assign($key, $value);
	}

	if (is_file(ROOTDIR . '/templates/' . $template . '/whmcms/' . $selectedPortfolioLayout) === true) {
		$templateFile = file_get_contents(ROOTDIR . '/templates/' . $template . '/whmcms/' . $selectedPortfolioLayout);
	}
	else {
		$templateFile = file_get_contents(ROOTDIR . '/modules/addons/whmcms/clientarea/views/' . $selectedPortfolioLayout);
	}

	$output = $views->fetch('string:' . $templateFile);
	$clientArea->assign('displayTitle', $pageTitle);
	$clientArea->assign('output', $output);

	foreach (WHMCMS\Base::getBreadCrumbs() as $link => $title) {
		$clientArea->addToBreadCrumb($link, $title);
	}

	$clientArea->setTemplate('whmcms/output');
	$clientArea->output();
}

if ($action === 'portfolio.project') {
	$alias = WHMCMS\Base::fromInput($params['alias']);
	$getProject = WHMCMS\Database\Capsule::table('mod_whmcms_portfolio')->where('topid', '=', 0)->where('enable', '=', 1)->where('alias', '=', $alias);

	if ($getProject->count() === 0) {
		header('HTTP/1.0 404 Not Found');
		$action = 'errorpages.errorpages';
		$params['code'] = 404;
	}
	else {
		$getProject = $getProject->first();
		$project = (array) $getProject;
		$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_portfolio')->where('topid', '=', $project['projectid'])->where('language', '=', $language);

		if (0 < $getTranslation->count()) {
			$getTranslation = (array) $getTranslation->first();
			$project['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $project['title']);
			$project['details'] = (WHMCMS\Base::fromInput($getTranslation['details']) !== '' ? $getTranslation['details'] : $project['details']);
		}

		$clientArea->setPageTitle($project['title']);
		$clientArea->initPage();
		$ActionParams = [
			'action' => $action,
			'params' => $params,
			'url'    => WHMCMS\Base::generateFriendlyURL($project, 'portfolio.project'),
			'title'  => $project['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName'),
			'data'   => []
		];
		$projectTags = [];

		foreach (explode(',', $project['tags']) as $tag) {
			$tag = trim($tag);
			$projectTags[] = ['name' => $tag, 'url' => WHMCMS\Base::generateFriendlyURL(['alias' => $tag], 'portfolio.tag')];
		}

		$project['tags'] = $projectTags;
		$getCategories = WHMCMS\Database\Capsule::table('mod_whmcms_portfoliorelations')->join('mod_whmcms_portfoliocategories', 'mod_whmcms_portfoliorelations.categoryid', '=', 'mod_whmcms_portfoliocategories.categoryid')->where('mod_whmcms_portfoliocategories.enable', '=', 1)->select('mod_whmcms_portfoliocategories.categoryid');
		$projectCategories = [];

		foreach ($getCategories->get() as $category) {
			$category = (array) $category;
			$projectCategories[$category['categoryid']] = $categories[$category['categoryid']];
		}

		$project['categories'] = $projectCategories;
		$getPhotos = WHMCMS\Database\Capsule::table('mod_whmcms_photos')->where('topid', '=', 0)->where('enable', '=', 1)->where('parentid', '=', $project['projectid']);
		$projectPhotos = [];

		foreach ($getPhotos->get() as $photo) {
			$photo = (array) $photo;
			$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_photos')->where('topid', '=', $photo['photoid'])->where('language', '=', $language);

			if (0 < $getTranslation->count()) {
				$getTranslation = (array) $getTranslation->first();
				$photo['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $photo['title']);
				$photo['details'] = (WHMCMS\Base::fromInput($getTranslation['details']) !== '' ? $getTranslation['details'] : $photo['details']);
			}

			$projectPhotos[] = ['photoid' => $photo['photoid'], 'title' => $photo['title'], 'details' => html_entity_decode($photo['details'], ENT_QUOTES), 'source' => $photo['source'], 'modified' => $photo['datemodify'], 'published' => intval($photo['enable']) === 1 ? true : false, 'url' => WHMCMS\Base::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $photo['source']];
		}

		$project['photos'] = $projectPhotos;
		$ActionParams['data'] = [
			'projectid'     => $project['projectid'],
			'title'         => $project['title'],
			'alias'         => $project['alias'],
			'client'        => $project['client'],
			'url'           => $project['url'],
			'logo'          => $project['logo'],
			'tags'          => $project['tags'],
			'categories'    => $project['categories'],
			'details'       => html_entity_decode($project['details'], ENT_QUOTES),
			'published'     => intval($project['enable']) === 1 ? true : false,
			'datepublished' => fromMySQLDate($project['datepublished']),
			'views'         => $project['hits'],
			'photos'        => $project['photos'],
			'social'        => ['url' => WHMCMS\Base::generateFriendlyURL($project, 'portfolio.project'), 'title' => $project['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName')],
			'created'       => $project['datecreate'],
			'modified'      => $project['datemodify']
		];
		$ActionParams['data']['portfolioindex'] = WHMCMS\Base::generateFriendlyURL([], 'portfolio.index');

		foreach (run_hook('WHMCMS_ClientAreaPage', $ActionParams) as $index => $return) {
			if (0 < count(WHMCMS\Base::fromInput($return['data'], 'array'))) {
				$ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS\Base::fromInput($return['data'], 'array'));
			}
		}

		$clientArea->assign('whmcms', $ActionParams);

		foreach ($ActionParams['data'] as $key => $value) {
			$views->assign($key, $value);
		}

		if (is_file(ROOTDIR . '/templates/' . $template . '/whmcms/portfolio_project.tpl') === true) {
			$templateFile = file_get_contents(ROOTDIR . '/templates/' . $template . '/whmcms/portfolio_project.tpl');
		}
		else {
			$templateFile = file_get_contents(ROOTDIR . '/modules/addons/whmcms/clientarea/views/portfolio_project.tpl');
		}

		$pageTitle = $ActionParams['data']['title'];
		$output = $views->fetch('string:' . $templateFile);
		$clientArea->assign('displayTitle', $pageTitle);
		$clientArea->assign('output', $output);
		WHMCMS\Base::addToBreadCrumbs(WHMCMS\Base::generateFriendlyURL($project, $action), $ActionParams['data']['title']);

		foreach (WHMCMS\Base::getBreadCrumbs() as $link => $title) {
			$clientArea->addToBreadCrumb($link, $title);
		}

		$clientArea->setTemplate('whmcms/output');
		$clientArea->output();
	}
}

if ($action === 'errorpages.errorpages') {
	$code = WHMCMS\Base::fromInput($params['code'], 'int');
	$getPage = WHMCMS\Database\Capsule::table('mod_whmcms_errorpages')->where('code', '=', $code)->where('topid', '=', 0);

	if ($getPage->count() === 0) {
		header('HTTP/1.0 404 Not Found');
		$code = 404;
	}

	if (200 < $code) {
		$getPage = WHMCMS\Database\Capsule::table('mod_whmcms_errorpages')->where('code', '=', $code)->where('topid', '=', 0);
		$getPage = (array) $getPage->first();
		$getTranslation = WHMCMS\Database\Capsule::table('mod_whmcms_errorpages')->where('topid', '=', $getPage['pageid'])->where('language', '=', $language);

		if (0 < $getTranslation->count()) {
			$getTranslation = (array) $getTranslation->first();
			$getPage['title'] = (WHMCMS\Base::fromInput($getTranslation['title']) !== '' ? $getTranslation['title'] : $getPage['title']);
			$getPage['content'] = (WHMCMS\Base::fromInput($getTranslation['content']) !== '' ? $getTranslation['content'] : $getPage['content']);
		}

		$clientArea->setPageTitle($getPage['title']);
		$clientArea->initPage();

		if (WHMCMS\Base::isAdmin() === false) {
			WHMCMS\Database\Capsule::table('mod_whmcms_errorpages')->where('pageid', $getPage['pageid'])->update(['hits' => intval($getPage['hits']) + 1, 'datelastvisit' => date('Y-m-d H:i:s')]);
		}

		$targetUrl = (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		if ($targetUrl !== WHMCMS\Base::generateFriendlyURL($getPage, $action)) {
			WHMCMS\Database\Capsule::table('mod_whmcms_errorlog')->insert(['code' => $code, 'refurl' => WHMCMS\Base::fromInput($_SERVER['HTTP_REFERER']), 'targeturl' => $targetUrl, 'datecreate' => date('Y-m-d H:i:s'), 'ip' => WHMCMS\Base::fromInput($_SERVER['REMOTE_ADDR']), 'useragent' => WHMCMS\Base::fromInput($_SERVER['HTTP_USER_AGENT'])]);
		}

		$ActionParams = [
			'action' => $action,
			'params' => $params,
			'url'    => WHMCMS\Base::generateFriendlyURL($getPage, $action),
			'title'  => $getPage['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName'),
			'data'   => [
				'pageid'     => $getPage['pageid'],
				'title'      => $getPage['title'],
				'code'       => $getPage['code'],
				'content'    => html_entity_decode($getPage['content'], ENT_QUOTES),
				'views'      => $getPage['hits'],
				'social'     => ['url' => WHMCMS\Base::generateFriendlyURL($getPage, $action), 'title' => $getPage['title'] . ' - ' . WHMCMS\Base::getSystemConfig('CompanyName')],
				'headoutput' => html_entity_decode($getPage['headercontent'], ENT_QUOTES),
				'created'    => $getPage['datecreate'],
				'modified'   => $getPage['datemodify']
			]
		];

		foreach (run_hook('WHMCMS_ClientAreaPage', $ActionParams) as $index => $return) {
			if (0 < count(WHMCMS\Base::fromInput($return['data'], 'array'))) {
				$ActionParams['data'] = array_replace_recursive($ActionParams['data'], WHMCMS\Base::fromInput($return['data'], 'array'));
			}
		}

		$clientArea->assign('whmcms', $ActionParams);

		foreach ($ActionParams['data'] as $key => $value) {
			$views->assign($key, $value);
		}

		if (is_file(ROOTDIR . '/templates/' . $template . '/whmcms/errorpages.tpl') === true) {
			$templateFile = file_get_contents(ROOTDIR . '/templates/' . $template . '/whmcms/errorpages.tpl');
		}
		else {
			$templateFile = file_get_contents(ROOTDIR . '/modules/addons/whmcms/clientarea/views/errorpages.tpl');
		}

		$output = $views->fetch('string:' . $templateFile);
		$clientArea->assign('displayTitle', $ActionParams['data']['title']);
		$clientArea->assign('output', $output);
		WHMCMS\Base::addToBreadCrumbs(WHMCMS\Base::generateFriendlyURL($getPage, $action), $ActionParams['data']['title']);

		foreach (WHMCMS\Base::getBreadCrumbs() as $link => $title) {
			$clientArea->addToBreadCrumb($link, $title);
		}

		$clientArea->setTemplate('whmcms/output');
		$clientArea->output();
	}
}

?>