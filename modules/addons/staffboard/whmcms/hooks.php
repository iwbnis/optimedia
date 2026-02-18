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

if (defined('WHMCS') === false) {
	exit('Direct Access to this file is forbidden!');
}
require_once ROOTDIR . '/modules/addons/whmcms/vendor/autoload.php';
add_hook('ClientAreaHeadOutput', 1000, function($vars) {
	if (count(WHMCMS\Base::fromInput($vars['whmcms'], 'array')) === 0) {
		return '';
	}

	$WHMCMS = $vars['whmcms'];
	$HTML = [];
	$HTML[] = '<link type="text/css" rel="stylesheet" href="' . WHMCMS\Base::getSystemURL() . 'modules/addons/whmcms/clientarea/css/styles.css">';
	$HTML[] = '<script type="text/javascript" src="' . WHMCMS\Base::getSystemURL() . 'modules/addons/whmcms/clientarea/js/holder.js"></script>';
	$HTML[] = '<meta property="og:title" content="' . $WHMCMS['title'] . '">';
	$HTML[] = '<meta property="og:site_name" content="' . WHMCMS\Base::getSystemConfig('CompanyName') . '">';
	$HTML[] = '<meta property="og:url" content="' . $WHMCMS['url'] . '">';

	if (in_array($WHMCMS['action'], ['pages.homepage', 'pages.page'])) {
		if (WHMCMS\Base::fromInput($WHMCMS['data']['meta']['description']) !== '') {
			$HTML[] = '<meta name="description" content="' . $WHMCMS['data']['meta']['description'] . '">';
			$HTML[] = '<meta property="og:description" content="' . $WHMCMS['data']['meta']['description'] . '">';
		}

		if (WHMCMS\Base::fromInput($WHMCMS['data']['meta']['keywords']) !== '') {
			$HTML[] = '<meta name="keywords" content="' . $WHMCMS['data']['meta']['keywords'] . '">';
		}
	}

	if ($WHMCMS['action'] === 'portfolio.project') {
		if (WHMCMS\Base::fromInput($WHMCMS['data']['details']) !== '') {
			$metaDescription = WHMCMS\Base::cutText(strip_tags($WHMCMS['data']['details']), 150, ' ', '...');
			$HTML[] = '<meta name="description" content="' . $metaDescription . '">';
			$HTML[] = '<meta property="og:description" content="' . $metaDescription . '">';
		}

		if (0 < WHMCMS\Base::fromInput($WHMCMS['data']['tags'], 'array')) {
			$tags = [];

			foreach (WHMCMS\Base::fromInput($WHMCMS['data']['tags'], 'array') as $tag) {
				$tags[] = $tag['name'];
			}

			$HTML[] = '<meta name="keywords" content="' . join(',', $tags) . '">';
		}

		if (WHMCMS\Base::fromInput($WHMCMS['data']['logo']) !== '') {
			$HTML[] = '<meta property="og:image" content="' . WHMCMS\Base::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $WHMCMS['data']['logo'] . '&w=-1">';
			$HTML[] = '<link rel="image_src" href="' . WHMCMS\Base::getSystemURL() . 'modules/addons/whmcms/resize.php?src=' . $WHMCMS['data']['logo'] . '&w=-1">';
		}
	}

	if (WHMCMS\Base::fromConfig('metaimage') !== '') {
		$HTML[] = '<meta property="og:image" content="' . WHMCMS\Base::fromConfig('metaimage') . '">';
		$HTML[] = '<link rel="image_src" href="' . WHMCMS\Base::fromConfig('metaimage') . '">';
	}

	if (WHMCMS\Base::fromConfig('metaimage398') !== '') {
		$HTML[] = '<meta property="og:image" content="' . WHMCMS\Base::fromConfig('metaimage398') . '">';
		$HTML[] = '<link rel="image_src" href="' . WHMCMS\Base::fromConfig('metaimage398') . '">';
	}

	if (WHMCMS\Base::fromConfig('customize_css') !== '') {
		$HTML[] = '<style type="text/css">';
		$HTML[] = html_entity_decode(WHMCMS\Base::fromConfig('customize_css'), ENT_QUOTES);
		$HTML[] = '</style>';
	}

	if (WHMCMS\Base::fromConfig('customize_js') !== '') {
		$HTML[] = '<script type="text/javascript">';
		$HTML[] = html_entity_decode(WHMCMS\Base::fromConfig('customize_js'), ENT_QUOTES);
		$HTML[] = '</script>';
	}
	if ((in_array($WHMCMS['action'], ['pages.homepage', 'pages.page']) === true) && (WHMCMS\Base::fromInput($WHMCMS['data']['headoutput']) !== '')) {
		$HTML[] = $WHMCMS['data']['headoutput'];
	}

	return join("\n", $HTML);
});
add_hook('ClientAreaFooterOutput', 1000, function($vars) {
	if (count(WHMCMS\Base::fromInput($vars['whmcms'], 'array')) === 0) {
		return '';
	}

	$HTML = [];
	$HTML[] = '<script type="text/javascript" src="' . WHMCMS\Base::getSystemURL() . 'modules/addons/whmcms/clientarea/js/isotope/jquery.isotope.min.js"></script>';
	return join("\n", $HTML);
});
add_hook('ClientAreaPage', 1, function($vars) {
	global $smarty;
	$smarty->registerClass('WHMCMS', '\\WHMCMS\\Base');
	$smarty->registerClass('WHMCMSMenus', '\\WHMCMS\\Menus');
});
add_hook('ClientAreaPrimaryNavbar', 1000000000, function(WHMCS\View\Menu\Item $primaryNavbar) {
	$primaryId = WHMCMS\Base::fromConfig('PrimaryNavbarCategoryid', 'int');
	$isMenuExist = WHMCMS\Database\Capsule::table('mod_whmcms_menucategories')->where('categoryid', '=', $primaryId)->count();
	if (($primaryId === 0) || ($isMenuExist === 0)) {
		return true;
	}

	if (is_null($primaryNavbar->getChildren()) !== true) {
		foreach ($primaryNavbar->getChildren() as $menuItem) {
			$primaryNavbar->removeChild($menuItem->getName());
		}
	}

	$menuItems = WHMCMS\Menus::generateMenuItems($primaryId);
	$levelOneObject = NULL;
	$levelOneCounter = 0;

	foreach ($menuItems as $level1) {
		$levelOneObject = $primaryNavbar->addChild($level1['menuid']);
		$levelOneObject->setLabel($level1['title']);
		$levelOneObject->setURI($level1['url']);
		$levelOneObject->setOrder($levelOneCounter);
		$levelOneObject->setClass($level1['css_classes']);
		$levelOneObject->setCurrent($level1['current']);

		if (WHMCMS\Base::fromInput($level1['badge']) !== '') {
			$levelOneObject->setBadge($level1['badge']);
		}

		if (WHMCMS\Base::fromInput($level1['css_iconclass']) !== '') {
			$levelOneObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level1['css_iconclass'])));
		}

		if (0 < WHMCMS\Base::fromInput($level1['childrens'], 'array')) {
			$levelTwoObject = NULL;
			$levelTwoCounter = 0;

			foreach ($level1['childrens'] as $level2) {
				$levelTwoObject = $levelOneObject->addChild($level2['menuid']);

				if (in_array(strtolower($level2['title']), ['-----', '------', 'divider'])) {
					$levelTwoObject->setClass('nav-divider');
					$levelTwoObject->setLabel('');
					$levelTwoObject->setURI('#');
					$levelTwoObject->setBadge('');
					$levelTwoObject->setIcon('');
				}
				else {
					$levelTwoObject->setClass($level2['css_classes']);
					$levelTwoObject->setCurrent($level2['current']);

					if (WHMCMS\Base::fromInput($level2['badge']) !== '') {
						$levelTwoObject->setBadge($level2['badge']);
					}

					if (WHMCMS\Base::fromInput($level2['css_iconclass']) !== '') {
						$levelTwoObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level2['css_iconclass'])));
					}

					$levelTwoObject->setLabel($level2['title']);
					$levelTwoObject->setURI($level2['url']);
					$levelTwoObject->setAttribute('target', $level2['target']);
				}

				$levelTwoObject->setOrder($levelTwoCounter);
				$levelTwoCounter++;
			}

			if (0 < WHMCMS\Base::fromInput($level2['childrens'], 'array')) {
				$levelThreeObject = NULL;
				$levelThreeCounter = 0;

				foreach ($level2['childrens'] as $level3) {
					$levelThreeObject = $levelThreeObject->addChild($level3['menuid']);
					$levelThreeObject->setCurrent($level3['current']);

					if (in_array(strtolower($level3['title']), ['-----', '------', 'divider'])) {
						$levelThreeObject->setClass('nav-divider');
						$levelThreeObject->setLabel('');
						$levelThreeObject->setURI('#');
						$levelThreeObject->setBadge('');
						$levelThreeObject->setIcon('');
					}
					else {
						$levelThreeObject->setClass($level3['css_classes']);
						$levelThreeObject->setCurrent($level3['current']);

						if (WHMCMS\Base::fromInput($level3['badge']) !== '') {
							$levelThreeObject->setBadge($level3['badge']);
						}

						if (WHMCMS\Base::fromInput($level3['css_iconclass']) !== '') {
							$levelThreeObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level3['css_iconclass'])));
						}

						$levelThreeObject->setLabel($level3['title']);
						$levelThreeObject->setURI($level3['url']);
						$levelThreeObject->setAttribute('target', $level3['target']);
					}

					$levelThreeObject->setOrder($levelThreeCounter);
					$levelThreeCounter++;
				}

				if (0 < WHMCMS\Base::fromInput($level3['childrens'], 'array')) {
					$levelFourObject = NULL;
					$levelFourCounter = 0;

					foreach ($level3['childrens'] as $level4) {
						$levelFourObject = $levelFourObject->addChild($level4['menuid']);

						if (in_array(strtolower($level4['title']), ['-----', '------', 'divider'])) {
							$levelFourObject->setClass('nav-divider');
							$levelFourObject->setLabel('');
							$levelFourObject->setURI('#');
							$levelFourObject->setBadge('');
							$levelFourObject->setIcon('');
						}
						else {
							$levelFourObject->setClass($level4['css_classes']);
							$levelFourObject->setCurrent($level4['current']);

							if (WHMCMS\Base::fromInput($level4['badge']) !== '') {
								$levelFourObject->setBadge($level4['badge']);
							}

							if (WHMCMS\Base::fromInput($level4['css_iconclass']) !== '') {
								$levelFourObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level4['css_iconclass'])));
							}

							$levelFourObject->setLabel($level4['title']);
							$levelFourObject->setURI($level4['url']);
							$levelFourObject->setAttribute('target', $level4['target']);
						}

						$levelFourObject->setOrder($levelFourCounter);
						$levelFourCounter++;
					}
				}
			}
		}

		$levelOneCounter++;
	}
});
add_hook('ClientAreaSecondaryNavbar', 1000000000, function(WHMCS\View\Menu\Item $secondaryNavbar) {
	$secondaryId = WHMCMS\Base::fromConfig('SecondaryNavbarCategoryid', 'int');
	$isMenuExist = WHMCMS\Database\Capsule::table('mod_whmcms_menucategories')->where('categoryid', '=', $secondaryId)->count();
	if (($secondaryId === 0) || ($isMenuExist === 0)) {
		return true;
	}

	if (is_null($secondaryNavbar->getChildren()) !== true) {
		foreach ($secondaryNavbar->getChildren() as $menuItem) {
			$secondaryNavbar->removeChild($menuItem->getName());
		}
	}

	$menuItems = WHMCMS\Menus::generateMenuItems($secondaryId);
	$levelOneObject = NULL;
	$levelOneCounter = 0;

	foreach ($menuItems as $level1) {
		$levelOneObject = $secondaryNavbar->addChild($level1['menuid']);
		$levelOneObject->setLabel($level1['title']);
		$levelOneObject->setURI($level1['url']);
		$levelOneObject->setOrder($levelOneCounter);
		$levelOneObject->setClass($level1['css_classes']);
		$levelOneObject->setCurrent($level1['current']);

		if (WHMCMS\Base::fromInput($level1['badge']) !== '') {
			$levelOneObject->setBadge($level1['badge']);
		}

		if (WHMCMS\Base::fromInput($level1['css_iconclass']) !== '') {
			$levelOneObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level1['css_iconclass'])));
		}

		if (0 < WHMCMS\Base::fromInput($level1['childrens'], 'array')) {
			$levelTwoObject = NULL;
			$levelTwoCounter = 0;

			foreach ($level1['childrens'] as $level2) {
				$levelTwoObject = $levelOneObject->addChild($level2['menuid']);

				if (in_array(strtolower($level2['title']), ['-----', '------', 'divider'])) {
					$levelTwoObject->setClass('nav-divider');
					$levelTwoObject->setLabel('');
					$levelTwoObject->setURI('#');
					$levelTwoObject->setBadge('');
					$levelTwoObject->setIcon('');
				}
				else {
					$levelTwoObject->setClass($level2['css_classes']);
					$levelTwoObject->setCurrent($level2['current']);

					if (WHMCMS\Base::fromInput($level2['badge']) !== '') {
						$levelTwoObject->setBadge($level2['badge']);
					}

					if (WHMCMS\Base::fromInput($level2['css_iconclass']) !== '') {
						$levelTwoObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level2['css_iconclass'])));
					}

					$levelTwoObject->setLabel($level2['title']);
					$levelTwoObject->setURI($level2['url']);
					$levelTwoObject->setAttribute('target', $level2['target']);
				}

				$levelTwoObject->setOrder($levelTwoCounter);
				$levelTwoCounter++;
			}

			if (0 < WHMCMS\Base::fromInput($level2['childrens'], 'array')) {
				$levelThreeObject = NULL;
				$levelThreeCounter = 0;

				foreach ($level2['childrens'] as $level3) {
					$levelThreeObject = $levelThreeObject->addChild($level3['menuid']);

					if (in_array(strtolower($level3['title']), ['-----', '------', 'divider'])) {
						$levelThreeObject->setClass('nav-divider');
						$levelThreeObject->setLabel('');
						$levelThreeObject->setURI('#');
						$levelThreeObject->setBadge('');
						$levelThreeObject->setIcon('');
					}
					else {
						$levelThreeObject->setClass($level3['css_classes']);
						$levelThreeObject->setCurrent($level3['current']);

						if (WHMCMS\Base::fromInput($level3['badge']) !== '') {
							$levelThreeObject->setBadge($level3['badge']);
						}

						if (WHMCMS\Base::fromInput($level3['css_iconclass']) !== '') {
							$levelThreeObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level3['css_iconclass'])));
						}

						$levelThreeObject->setLabel($level3['title']);
						$levelThreeObject->setURI($level3['url']);
						$levelThreeObject->setAttribute('target', $level3['target']);
					}

					$levelThreeObject->setOrder($levelThreeCounter);
					$levelThreeCounter++;
				}

				if (0 < WHMCMS\Base::fromInput($level3['childrens'], 'array')) {
					$levelFourObject = NULL;
					$levelFourCounter = 0;

					foreach ($level3['childrens'] as $level4) {
						$levelFourObject = $levelFourObject->addChild($level4['menuid']);

						if (in_array(strtolower($level4['title']), ['-----', '------', 'divider'])) {
							$levelFourObject->setClass('nav-divider');
							$levelFourObject->setLabel('');
							$levelFourObject->setURI('#');
							$levelFourObject->setBadge('');
							$levelFourObject->setIcon('');
						}
						else {
							$levelFourObject->setClass($level4['css_classes']);
							$levelFourObject->setCurrent($level4['current']);

							if (WHMCMS\Base::fromInput($level4['badge']) !== '') {
								$levelFourObject->setBadge($level4['badge']);
							}

							if (WHMCMS\Base::fromInput($level4['css_iconclass']) !== '') {
								$levelFourObject->setIcon(str_replace(['fa ', 'glyphicon '], '', trim($level4['css_iconclass'])));
							}

							$levelFourObject->setLabel($level4['title']);
							$levelFourObject->setURI($level4['url']);
							$levelFourObject->setAttribute('target', $level4['target']);
						}

						$levelFourObject->setOrder($levelFourCounter);
						$levelFourCounter++;
					}
				}
			}
		}

		$levelOneCounter++;
	}
});
add_hook('ClientAreaPage', 1, function($vars) {
	if ((WHMCMS\Base::getConfig('homepage') === 'default') || (WHMCMS\Base::getConfig('homepage') === NULL) || ($vars['filename'] !== 'index')) {
		return [];
	}

	$requestURI = $_SERVER['REQUEST_URI'];
	$redirect = true;
	if (strpos($requestURI, 'knowledgebase') || strpos($requestURI, 'announcements') || strpos($requestURI, 'download')) {
		$redirect = false;
	}

	if (0 < count($_REQUEST)) {
		$redirect = false;
		$redirectQuery = [];

		foreach ($_REQUEST as $key => $value) {
			if (in_array($key, ['systpl', 'carttpl', 'language'])) {
				unset($_REQUEST[$key]);
			}
		}

		if (count($_REQUEST) === 0) {
			$redirect = true;
		}
	}

	if ($redirect === true) {
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . WHMCMS\Base::getSystemConfig('SystemURL'), true, 301);
		exit();
	}
});
add_hook('AdminAreaHeadOutput', 1, function($vars) {
	if ($vars['pagetitle'] !== 'WHMCMS') {
		return '';
	}

	global $CONFIG;
	$files = [];

	if (version_compare('7.8', $CONFIG['Version'], '<') === true) {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/jqueryui/jquery-ui.min.js"></script>';
		$files[] = '<link type="text/css" rel="stylesheet" href="../modules/addons/whmcms/assets/js/jqueryui/jquery-ui.min.css">';
	}

	$files[] = '<script type="text/javascript">var rootSystemURL = "' . WHMCMS\Base::getSystemURL() . '";</script>';
	$files[] = '<script type="text/javascript">var whmcmsURL = "' . WHMCMS\Base::getModURL() . '";</script>';
	$files[] = '<link type="text/css" rel="stylesheet" href="../modules/addons/whmcms/assets/js/validation/css/validationEngine.jquery.css">';
	$files[] = '<link type="text/css" rel="stylesheet" href="../modules/addons/whmcms/assets/css/style.css">';

	if (0 < count(WHMCMS\Base::fromInput(WHMCMS\Base::__('javascript'), 'array'))) {
		$javascriptTranslations = [];
		$javascriptTranslations[] = '<script type="text/javascript">';
		$javascriptTranslations[] = 'var WHMCMS = new Object();';

		foreach (WHMCMS\Base::__('javascript') as $key => $value) {
			$javascriptTranslations[] = 'WHMCMS[\'' . $key . '\'] = \'' . $value . '\';';
		}

		$javascriptTranslations[] = '</script>';
		$files[] = join("\n", $javascriptTranslations);
	}

	return join('', $files);
});
add_hook('AdminAreaFooterOutput', 1, function($vars) {
	if ($vars['pagetitle'] !== 'WHMCMS') {
		return '';
	}

	$files = [];

	if (WHMCMS\Base::getConfig('editor') === 'ckeditor') {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/ckeditor/ckeditor.js"></script>';
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/ckeditor/config.js"></script>';
	}

	if (WHMCMS\Base::getConfig('editor') === 'tinymce') {
		if (is_file(ROOTDIR . '/assets/js/tiny_mce/jquery.tinymce.js') === true) {
			$files[] = '<script type="text/javascript" src="../assets/js/tiny_mce/jquery.tinymce.js"></script>';
			$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/tinymce/config.jquery.js"></script>';
		}
		else {
			$files[] = '<script type="text/javascript" src="../assets/js/tinymce/tinymce.min.js"></script>';
			$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/tinymce/config.js"></script>';
		}
	}
	if ((WHMCMS\Base::getConfig('editor') === 'htmleditor') || (WHMCMS\Base::fromGet('action') === 'customize')) {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/jseditor/ace.js"></script>';
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/editor/jseditor/editor_config.js"></script>';
	}

	$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/validation/languages/jquery.validationEngine-en.js"></script>';
	$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/validation/jquery.validationEngine.js"></script>';
	$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/admin.js"></script>';

	if (in_array(WHMCMS\Base::fromRequest('action'), ['listpages', 'addpage', 'updatepage'])) {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/pages.js"></script>';
	}

	if (in_array(WHMCMS\Base::fromRequest('action'), ['faq', 'listfaq', 'addfaq', 'updatefaq'])) {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/faq.js"></script>';
	}

	if (in_array(WHMCMS\Base::fromRequest('action'), ['errorpages', 'logerrors', 'updateerrorpage'])) {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/errorpages.js"></script>';
	}

	if (in_array(WHMCMS\Base::fromRequest('action'), ['portfolio', 'listprojects', 'listphotos', 'addproject', 'updateproject'])) {
		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/portfolio.js"></script>';
	}

	if (in_array(WHMCMS\Base::fromRequest('action'), ['menu', 'listmenu', 'addmenu', 'updatemenu'])) {
		if (WHMCMS\Base::fromRequest('action') === 'listmenu') {
			$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/sortable/sortable.js"></script>';
		}

		$files[] = '<script type="text/javascript" src="../modules/addons/whmcms/assets/js/includes/menus.js"></script>';
	}

	return join('', $files);
});
add_hook('ClientAreaPage', 1, function($vars) {
	if (count(WHMCMS\Base::fromInput($vars['whmcms'], 'array')) === 0) {
		return [];
	}

	if (isset($vars['whmcms']['action'])) {
		$linkBackURL = WHMCMS\Base::generateFriendlyURL($vars['whmcms']['data'], $vars['whmcms']['action']);
		return ['currentpagelinkback' => $linkBackURL . ((WHMCMS\Base::getConfig('FriendlyURLsMode') !== 'basic') || ($vars['whmcms']['action'] === 'pages.homepage') ? '?' : '&')];
	}
});
add_hook('ClientAreaFooterOutput', 1, function($vars) {
	if (count(WHMCMS\Base::fromInput($vars['whmcms'], 'array')) === 0) {
		return '';
	}

	$files = [];
	if ($vars['whmcms']['data']['social']['facebookButton'] || $vars['whmcms']['data']['social']['facebookComments']) {
		$files[] = '<script type="text/javascript">(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&autoLogAppEvents=1";fjs.parentNode.insertBefore(js,fjs);}(document,"script","facebook-jssdk"));</script><div id="fb-root"></div>';
	}

	if ($vars['whmcms']['data']['social']['twitterButton']) {
		$files[] = '<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	}

	if ($vars['whmcms']['data']['social']['googlePlusButton']) {
		$files[] = '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>';
	}

	return join("\n", $files);
});

?>