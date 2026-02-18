<?php
use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Database\Capsule;

/****************************
* Settings Form
*****************************/
function whmcms_generalSettings(){

    # Select Page List
    $pagelist['default'] = WHMCMS::__("settingsDefaultHomepage");
    $getPages = Capsule::table("mod_whmcms_pages")
    ->where("topid", 0)
    ->orderBy("pageid", "asc")
    ->get();

    foreach($getPages as $page){
        $page = (array) $page;

        if ($page['private']=='1'){
            $page['title'] = $page['title'] . ' [Private]';
        }
        $pagelist[$page['pageid']] = $page['title'];
    }

    $form = array(
        array(
            'Fieldname' => 'frontendfile',
            'FriendlyName' => WHMCMS::__("settingsFrontendFile"),
            'Type' => 'text',
            'Value' => WHMCMS::getConfig("frontendfile"),
            'Class' => 'span4',
            'Description' => WHMCMS::__("settingsFrontendFileDescription")
        ),
        array(
            'Fieldname' => 'homepage',
            'FriendlyName' => WHMCMS::__("settingsHomepage"),
            'Type' => 'select',
            'Options' => $pagelist,
            'Value' => WHMCMS::getConfig("homepage"),
            'Class' => 'span4',
            'Description' => WHMCMS::__("settingsHomepageDesc"),
        ),
        array(
            'Fieldname' => 'editor',
            'FriendlyName' => WHMCMS::__("settingsEditor"),
            'Type' => 'select',
            'Options' => array('noeditor' => WHMCMS::__("settingsNoEditor"), 'ckeditor' => WHMCMS::__("settingsCKEditor"), 'htmleditor' => WHMCMS::__("settingsHTMLEditor"), 'tinymce' => WHMCMS::__("settingsTinyEditor")),
            'Value' => WHMCMS::getConfig("editor"),
            'Class' => 'span4',
            'Description' => WHMCMS::__("settingsEditorsDesc"),
        )
    );
    $htmlForm = createForm($form);

    return $htmlForm;

}

/****************************
* Settings Portfolio Form
*****************************/
function whmcms_portfolioSettings(){

    $layoutOptions = '';
    $layoutOptions .= '<label class="radioImg ' . ((WHMCMS::getConfig("portfoliolayout") == 'default') ? 'active' : '') . '" for="default-layout">';
        $layoutOptions .= '<img src="../modules/addons/whmcms/assets/img/default-layout.png" alt="">';
        $layoutOptions .= '<span>'.WHMCMS::__("settingsPortfolioLayoutDefault").'</span>';
        $layoutOptions .= '<input type="radio" name="portfoliolayout" id="default-layout" value="default" ' . ((WHMCMS::getConfig("portfoliolayout") == 'default') ? 'checked' : '') . '>';
    $layoutOptions .= '</label>';
    $layoutOptions .= '<label class="radioImg ' . ((WHMCMS::getConfig("portfoliolayout") == 'category') ? 'active' : '') . '" for="category-layout">';
        $layoutOptions .= '<img src="../modules/addons/whmcms/assets/img/category-layout.png" alt="">';
        $layoutOptions .= '<span>'.WHMCMS::__("settingsPortfolioLayoutCategory").'</span>';
        $layoutOptions .= '<input type="radio" name="portfoliolayout" id="category-layout" value="category" ' . ((WHMCMS::getConfig("portfoliolayout") == 'category') ? 'checked' : '') . '>';
    $layoutOptions .= '</label>';
    $layoutOptions .= '<label class="radioImg ' . ((WHMCMS::getConfig("portfoliolayout") == 'filter') ? 'active' : '') . '" for="filter-layout">';
        $layoutOptions .= '<img src="../modules/addons/whmcms/assets/img/filter-layout.png" alt="">';
        $layoutOptions .= '<span>'.WHMCMS::__("settingsPortfolioLayoutFilterable").'</span>';
        $layoutOptions .= '<input type="radio" name="portfoliolayout" id="filter-layout" value="filter" ' . ((WHMCMS::getConfig("portfoliolayout") == 'filter') ? 'checked' : '') . '>';
    $layoutOptions .= '</label>';
    $layoutOptions .= '<label class="radioImg ' . ((WHMCMS::getConfig("portfoliolayout") == 'onepage') ? 'active' : '') . '" for="onepage-layout">';
        $layoutOptions .= '<img src="../modules/addons/whmcms/assets/img/onepage-layout.png" alt="">';
        $layoutOptions .= '<span>'.WHMCMS::__("settingsPortfolioOnePage").'</span>';
        $layoutOptions .= '<input type="radio" name="portfoliolayout" id="onepage-layout" value="onepage" ' . ((WHMCMS::getConfig("portfoliolayout")=='onepage') ? 'checked' : '') . '>';
    $layoutOptions .= '</label>';
    $layoutOptions .= '<div class="clear"></div>';

    $form = array(
        array(
            'FriendlyName' => WHMCMS::__("settingsPortfolioLayout"),
            'Type' => 'hr',
            'Description' => $layoutOptions
        ),
        array(
            'Fieldname' => 'portfolioitemsinrow',
            'FriendlyName' => WHMCMS::__("settingsPortfolioItemsPerRow"),
            'Type' => 'select',
            'Options' => array('2' => '2', '3' => '3', '4' => '4', '6' => '6'),
            'Value' => WHMCMS::getConfig("portfolioitemsinrow"),
            'Class' => 'span3',
            'Description' => WHMCMS::__("settingsPortfolioItemsPerRowDesc"),
        ),
        array(
            'Fieldname' => 'portfoliosort',
            'FriendlyName' => WHMCMS::__("settingsPortfolioItemsSortBy"),
            'Type' => 'select',
            'Options' => array('ASC' => WHMCMS::__("settingsPortfolioItemsSortASC"), 'DESC' => WHMCMS::__("settingsPortfolioItemsSortDESC")),
            'Value' => WHMCMS::getConfig("portfoliosort"),
            'Class' => 'span3',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'portfoliofilteroption',
            'FriendlyName' => WHMCMS::__("settingsPortfolioFilterBy"),
            'Type' => 'select',
            'Options' => array('tags' => WHMCMS::__("settingsPortfolioFilterTags"), 'category' => WHMCMS::__("settingsPortfolioFilterCategory")),
            'Value' => WHMCMS::getConfig("portfoliofilterby"),
            'Class' => 'span3',
            'Description' => WHMCMS::__("settingsPortfolioFilterByDesc"),
        )
    );
    $htmlForm = createForm($form);

return $htmlForm;
}

/****************************
* Settings Error Pages Form
*****************************/
function whmcms_errorpagesSettings(){

    $form = array(
        array(
            'Fieldname' => 'error400',
            'FriendlyName' => WHMCMS::__("settingsError400"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error400"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error403',
            'FriendlyName' => WHMCMS::__("settingsError403"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error403"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error404',
            'FriendlyName' => WHMCMS::__("settingsError404"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error404"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error405',
            'FriendlyName' => WHMCMS::__("settingsError405"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error405"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error408',
            'FriendlyName' => WHMCMS::__("settingsError408"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error408"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error500',
            'FriendlyName' => WHMCMS::__("settingsError500"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error500"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error502',
            'FriendlyName' => WHMCMS::__("settingsError502"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error502"),
            'Class' => 'span2',
            'Description' => '',
        ),
        array(
            'Fieldname' => 'error504',
            'FriendlyName' => WHMCMS::__("settingsError504"),
            'Type' => 'select',
            'Options' => array('enable' => WHMCMS::__("settingsErrorEnabled"), 'disable' => WHMCMS::__("settingsErrorDisabled")),
            'Value' => WHMCMS::getConfig("error504"),
            'Class' => 'span2',
            'Description' => '',
        )
    );
    $htmlForm = createForm($form);

    return $htmlForm;

}
/****************************
* Settings Meta Tags Form
*****************************/
function whmcms_metaSettings(){

    $form = array(
        array(
            'Fieldname' => 'metaimage',
            'FriendlyName' => WHMCMS::__("settingsMetaImg128"),
            'Type' => 'text',
            'Value' => WHMCMS::getConfig("metaimage"),
            'Class' => 'span6',
            'Description' => WHMCMS::__("settingsMetaImg128Desc")
        ),
        array(
            'Fieldname' => 'metaimage398',
            'FriendlyName' => WHMCMS::__("settingsMetaImg398"),
            'Type' => 'text',
            'Value' => WHMCMS::getConfig("metaimage398"),
            'Class' => 'span6',
            'Description' => WHMCMS::__("settingsMetaImg398Desc")
        )
    );
    $htmlForm = createForm($form);

    return $htmlForm;

}

/*********************************************************************************
 * Error Pages
 */
/*
 * @param $pageid Used for Update Page
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function errorPageForm($pageid=0, $returnForm='main', $langForm='', $smarty){

    $pageid = intval($pageid);

    if ($pageid!='0'){
        # Select Page Data
        $getPageInfo = Capsule::table("mod_whmcms_errorpages")->where("pageid", $pageid)->get();

        $pagedata = (array) $getPageInfo[0];

        $pagedata['datemodify'] = ($pagedata['datemodify']=='0000-00-00 00:00:00')? 'Never': $pagedata['datemodify'];

        # Select Translate
        $getPageTranslate = Capsule::table("mod_whmcms_errorpages")
        ->where("topid", $pageid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());
        $countTrans = $getPageTranslate->count();
        $pageTrans = $getPageTranslate->get();
        $pageTrans = (array) $pageTrans[0];

        if ($countTrans!='0'){
            $oldpagedata = $pagedata; // Save The Current Page Details for use in other place
            $pagedata['title'] = $pageTrans['title'];
            $pagedata['content'] = $pageTrans['content'];
            $pagedata['deletetranslation'] = $pageTrans['pageid'];
        }
        $smarty->assign('pagedata', $pagedata);
    }

    # Select Log Total
    $getLogInfo = Capsule::table("mod_whmcms_errorlog")
    ->where("code", $pagedata['code']);
    $count_log = $getLogInfo->count();

    # Main Page Form
    $pageForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("errorPagesFormTitle"),
            'Type' => 'text',
            'Value' => $pagedata['title'],
            'Size' => 30,
            'Class' => 'span10 validate[required] text-input generateAlias',
            'Attr' => 'data-alias="#alias"',
            'Description' => ''
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($pagedata['deletetranslation'])
        )
    );
    $pageForm = createForm($pageForm);

    # Page Content Editor
    if (WHMCMS::getConfig("editor") == 'htmleditor'){
        $pageEditor = array(
            array (
                'Fieldname' => 'content',
                'FriendlyName' => "",
                'Type' => 'textarea',
                'Value' => $pagedata['content'],
                'Rows' => 10,
                'Cols' => 100,
                'Class' => 'span10 html_editor',
                'id' => 'html_editortext',
                'Description' => '<pre id="html_editor" class="html_editor">' . $pagedata['content'] . '</pre>'
            )
        );
    }
    else {
        $pageEditor = array(
            array (
                'Fieldname' => 'content',
                'FriendlyName' => '',
                'Type' => 'editor',
                'Rows' => 10,
                'Value' => $pagedata['content'],
                'Class' => 'span10',
                'id' => 'page_content',
                'Description' => ''
            )
        );
    }
    $pageEditor = createForm($pageEditor);

    # Date Created & Modified When Update
    if ($pageid!='' && $pageid!='0'){
        $pageOptions = createForm(array(
            array(
                'FriendlyName' => WHMCMS::__("errorPagesFormModify"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $pagedata['datemodify']
            ),
            array(
                'FriendlyName' => WHMCMS::__("errorPagesFormLastVisit"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $pagedata['datelastvisit']
            ),
            array(
                'FriendlyName' => WHMCMS::__("errorPagesFormViews"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => number_format($pagedata['hits'])
            ),
            array(
                'FriendlyName' => WHMCMS::__("errorPagesFormLogRecords"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => number_format($count_log)
            )
        ));
    }

    # SEO Options Form
    $pageAdvanced = array(
        array (
            'Fieldname' => 'headercontent',
            'FriendlyName' => WHMCMS::__("errorPagesFormCustomCode"),
            'Type' => 'textarea',
            'Value' => $pagedata['headercontent'],
            'Cols' => 50,
            'Rows' => 3,
            'Class' => 'span12',
            'Description' => WHMCMS::__("errorPagesFormCustomCodeDesc")
        )
    );
    $pageAdvanced = createForm($pageAdvanced);

    # Translate Form Data
    $getPageTranslate = Capsule::table("mod_whmcms_errorpages")
    ->where("topid", $pageid)
    ->where("language", $langForm)
    ->get();
    $transdata = (array) $getPageTranslate[0];
    if ($oldpagedata['language']==$langForm){
        $transdata['title'] = $oldpagedata['title'];
        $transdata['subtitle'] = $oldpagedata['subtitle'];
        $transdata['content'] = $oldpagedata['content'];
    }
    # Translate Form HTML
    $pageTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("errorPagesFormTranslateTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span6',
                'Description' => ''
            )
        )
        );
    if (WHMCMS::getConfig("editor") != 'htmleditor'){
        $pageTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_content[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("errorPagesFormTranslateContent"),
                    'Type' => 'editor',
                    'Value' => $transdata['content'],
                    'Class' => 'span12',
                    'Description' => ''
                )
            )
            );
    }
    else {
        $jsEditor = "<script type='text/javascript'>var html_editor_".$langForm." = ace.edit('html_editor_".$langForm."');
        html_editor_".$langForm.".setTheme('ace/theme/xcode');
        html_editor_".$langForm.".getSession().setMode('ace/mode/html');
        var html_textarea_".$langForm." = $('#html_editortext_".$langForm."');
        html_textarea_".$langForm.".hide();
        html_editor_".$langForm.".getSession().on('change', function () {
            html_textarea_".$langForm.".val(html_editor_".$langForm.".getSession().getValue());
        });</script>";
        $pageTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_content[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("errorPagesFormTranslateContent"),
                    'Type' => 'editor',
                    'Value' => $transdata['content'],
                    'Class' => 'span12',
                    'id' => 'html_editortext_' . $langForm,
                    'Description' => '<pre id="html_editor_' . $langForm . '" class="html_editor">' . $transdata['content'] . '</pre>' . $jsEditor
                )
            )
            );
    }

    if ($returnForm=='main'){
        return $pageForm;
    }
    elseif ($returnForm=='maineditor'){
        return $pageEditor;
    }
    elseif ($returnForm=='options'){
        return $pageOptions;
    }
    elseif ($returnForm=='advanced'){
        return $pageAdvanced;
    }
    elseif ($returnForm=='translate'){
        return $pageTranslate;
    }
}

/*
 * Error Log Informations Form
 */
function errorLogInfo($logid){

    $getErrorLog = Capsule::table("mod_whmcms_errorlog")->where("logid", $logid)->get();
    $data = (array) $getErrorLog[0];

    # Log Info Form
    $logForm = array(
        array (
            'Fieldname' => 'targeturl',
            'FriendlyName' => WHMCMS::__("errorLogsFormErrorURL"),
            'Type' => 'textarea',
            'Value' => $data['targeturl'],
            'Rows' => 2,
            'Class' => 'span12 validate[optional] text-input ltr text-left',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'refurl',
            'FriendlyName' => WHMCMS::__("errorLogsFormReferralURL"),
            'Type' => 'textarea',
            'Value' => $data['refurl'],
            'Rows' => 2,
            'Class' => 'span12 validate[optional] text-input ltr text-left',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'useragent',
            'FriendlyName' => WHMCMS::__("errorLogsFormUserAgent"),
            'Type' => 'textarea',
            'Value' => $data['useragent'],
            'Rows' => 2,
            'Class' => 'span12 validate[optional] text-input',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'ip',
            'FriendlyName' => WHMCMS::__("errorLogsFormIPAddress"),
            'Type' => 'text',
            'Value' => $data['ip'],
            'Size' => 30,
            'Class' => 'span6 validate[optional] text-input',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'datecreate',
            'FriendlyName' => WHMCMS::__("errorLogsFormDateTime"),
            'Type' => 'text',
            'Value' => $data['datecreate'],
            'Size' => 30,
            'Class' => 'span6 validate[optional] text-input',
            'Description' => ''
        ),
    );
    $logForm = createForm($logForm);

    return $logForm;

}

/*
 * Ban IP
 */
function banErrorIP($logid){

    $getErrorLog = Capsule::table("mod_whmcms_errorlog")->where("logid", $logid)->get();
    $data = (array) $getErrorLog[0];

    # Ban IP Form
    $banForm = array(
        array (
            'Fieldname' => 'ip',
            'FriendlyName' => WHMCMS::__("errorLogsFormBanIPAddress"),
            'Type' => 'text',
            'Value' => $data['ip'],
            'Size' => 30,
            'Class' => 'span6 validate[required] text-input ltr text-left disabled',
            'id' => 'ip_' . $logid,
            'Attr' => 'disabled="disabled"',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'days',
            'FriendlyName' => WHMCMS::__("errorLogsFormBanIPDays"),
            'Type' => 'text',
            'Value' => '',
            'Size' => 30,
            'Class' => 'span6 validate[optional, custom[integer]] text-input',
            'id' => 'days_' . $logid,
            'Placeholder' => WHMCMS::__("errorLogsFormBanIPDaysDesc"),
            'Description' => ''
        ),
        array (
            'Fieldname' => 'reason',
            'FriendlyName' => WHMCMS::__("errorLogsFormBanIPReason"),
            'Type' => 'text',
            'Value' => '',
            'Size' => 2,
            'Class' => 'span6 validate[optional] text-input ltr text-left',
            'id' => 'reason_' . $logid,
            'Placeholder' => '',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'ipaddress',
            'Type' => 'hidden',
            'Value' => $data['ip']
        )
    );
    $banForm = createForm($banForm);

    return $banForm;

}

/*********************************************************************************
 * FAQ Admin Area
 */
/*
 * @param $groupid Used for Update Category
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function faqGroupForm($groupid = 0, $returnForm = 'main', $langForm = '', $_smarty){

    $groupid = intval($groupid);

    if ($groupid!='0'){

        # Select Category Data
        $getGroupInfo = Capsule::table("mod_whmcms_faqgroups")->where("groupid", "=", $groupid)->get();
        $groupdata = (array) $getGroupInfo[0];

        # Select Translate
        $getGroupTranslate = Capsule::table("mod_whmcms_faqgroups")
        ->where("topid", "=", $groupid)
        ->where("language", "=", WHMCMS::getSystemDefaultLanguage());
        $countTrans = $getGroupTranslate->count();
        $groupTrans = $getGroupTranslate->get();
        $groupTrans = (array) $groupTrans[0];

        if ($countTrans!='0'){
            $oldgroupdata = $groupdata; // Save The Current Category Details for use in other place
            $groupdata['title'] = $groupTrans['title'];
            $groupdata['deletetranslation'] = $groupTrans['groupid'];
        }

        $_smarty->assign('groupdata', $groupdata);
    }
    else {
        $groupdata['enable'] = 1;
    }

    # AJAX Alias Form
    $aliasForm = [];
    $aliasForm[] = '<div id="seo-url_' . $groupid . '" class="seo-url form-group span12">';
    $aliasForm[] = '<div id="seo-url-actions_' . $groupid . '" class="seo-url-actions">';
    $aliasForm[] = '<span id="seo-url-actions-loading_' . $groupid . '" class="seo-url-actions-loading hidden"><i class="fa fa-fw fa-spinner fa-spin"></i></span>';
    $aliasForm[] = '<span id="seo-url-actions-lock_' . $groupid . '" class="seo-url-actions-lock" data-reltype="faq" data-relid="' . $groupid . '" title="Locked, click to edit it"><i class="fa fa-fw fa-lock"></i></span>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '<div class="input-group">';
    $aliasForm[] = '<div id="seo-url-prefix_' . $groupid . '" class="seo-url-prefix input-group-addon">' . WHMCMS::getSystemURL() . '</div>';
    $aliasForm[] = '<input type="text" id="seo-url-input_' . $groupid . '" name="alias" value="' . $groupdata['alias'] . '" class="seo-url-input form-control locked' . (($groupid === 0) ? "" : " manual") . '" data-source="#title" data-reltype="faq" data-relid="' . $groupid . '" data-ajaxsignature="" readonly>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '</div>';

    $aliasForm = join("", $aliasForm);

    # Main Group Form
    $groupForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("faqGroupFormTitle"),
            'Type' => 'text',
            'Value' => $groupdata['title'],
            'Size' => 30,
            'Class' => 'span12 validate[required] text-input generateAlias',
            'Attr' => 'data-alias="#alias_' . $groupid . '" data-reltype="faq" data-relid="' . $groupid . '" required',
            'Description' => ''
        ),
        array (
            'FriendlyName' => WHMCMS::__("faqGroupFormAlias"),
            'Type' => 'hr',
            'Description' => $aliasForm
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($groupdata['deletetranslation'])
        )
    );
    $groupForm = createForm($groupForm);

    # Translate Form Data
    $getGroupTranslate = Capsule::table("mod_whmcms_faqgroups")
    ->where("topid", $groupid)
    ->where("language", $langForm)
    ->get();
    $transdata = (array) $getGroupTranslate[0];
    if ($oldgroupdata['language']==$langForm){
        $transdata['title'] = $oldgroupdata['title'];
    }
    # Translate Form HTML
    $groupTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("faqGroupFormTranslateTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span12',
                'Description' => ''
            )
        )
        );

    if ($returnForm=='main'){
        return $groupForm;
    }
    elseif ($returnForm=='translate'){
        return $groupTranslate;
    }
}

/*
 * @param $faqid Used for Update Project
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function faqItemForm($faqid=0, $returnForm='main', $langForm='', $_smarty){

    $faqid = intval($faqid);

    # Select FAQ Group List
    $getGroups = Capsule::table("mod_whmcms_faqgroups")->where("topid", 0)->get();
    foreach ($getGroups as $groupdata){
        $groupdata = (array) $groupdata;
        $grouplist[$groupdata['groupid']] = $groupdata['title'];
    }

    if ($faqid!='0'){
        # Select FAQ Data
        $getFAQInfo = Capsule::table("mod_whmcms_faq")->where("faqid", $faqid)->get();
        $faqdata = (array) $getFAQInfo[0];
        $faqdata['datemodify'] = ($faqdata['datemodify']=='0000-00-00 00:00:00')? 'Never': $faqdata['datemodify'];

        # Select Translate
        $getFAQTranslate = Capsule::table("mod_whmcms_faq")
        ->where("topid", $faqid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());
        $countTrans = $getFAQTranslate->count();
        $faqTrans = $getFAQTranslate->get();
        $faqTrans = (array) $faqTrans[0];

        if ($countTrans!='0'){
            $oldfaqdata = $faqdata; // Save The Current Page Details for use in other place
            $faqdata['question'] = $faqTrans['question'];
            $faqdata['answer'] = $faqTrans['answer'];
            $faqdata['deletetranslation'] = $faqTrans['faqid'];
        }

        $_smarty->assign('faqdata', $faqdata);
    }
    else {
        $faqdata['enable'] = 1;
        $faqdata['groupid'] = intval($_GET['groupid']);
    }

    # Main FAQ Form
    $faqForm = array(
        array (
            'Fieldname' => 'question',
            'FriendlyName' => WHMCMS::__("faqItemFormQuestion"),
            'Type' => 'text',
            'Value' => $faqdata['question'],
            'Size' => 30,
            'Class' => 'span10 validate[required] text-input',
            'Description' => ''
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($faqdata['deletetranslation'])
        )
    );
    $faqForm = createForm($faqForm);

    # Page Content Editor
    if (WHMCMS::getConfig("editor") == 'htmleditor'){
        $faqEditor = array(
            array (
                'Fieldname' => 'answer',
                'FriendlyName' => "",
                'Type' => 'textarea',
                'Value' => $faqdata['answer'],
                'Rows' => 10,
                'Cols' => 100,
                'Class' => 'span10 html_editor',
                'id' => 'html_editortext',
                'Description' => '<pre id="html_editor" class="html_editor">' . $faqdata['answer'] . '</pre>'
            )
        );
    }
    else {
        $faqEditor = array(
            array (
                'Fieldname' => 'answer',
                'FriendlyName' => '',
                'Type' => 'editor',
                'Rows' => 10,
                'Value' => $faqdata['answer'],
                'Class' => 'span10',
                'id' => 'page_content',
                'Description' => ''
            )
        );
    }
    $faqMainEditor = createForm($faqEditor);

    # Date Created & Modified When Update
    if ($faqid!='' && $faqid!='0'){
        $faqOptions = createForm(array(
            array(
                'FriendlyName' => WHMCMS::__("faqItemFormCreated"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $faqdata['datecreate']
            ),
            array(
                'FriendlyName' => WHMCMS::__("faqItemFormModified"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $faqdata['datemodify']
            )
        ));
    }

    # Publishing & Sharing Options Form
    $faqOptions .= createForm(array(
        array (
            'Fieldname' => 'groupid',
            'FriendlyName' => WHMCMS::__("faqItemFormGroup"),
            'Type' => 'select',
            'Value' => $faqdata['groupid'],
            'Options' => $grouplist,
            'Class' => '',
            'Description' => ""
        ),
        array (
            'Fieldname' => 'enable',
            'FriendlyName' => WHMCMS::__("faqItemFormPublished"),
            'Type' => 'select',
            'Value' => $faqdata['enable'],
            'Options' => array(1 => WHMCMS::__("faqItemFormPublish"), 0 => WHMCMS::__("faqItemFormUnPublish")),
            'Class' => '',
            'Description' => ""
        )
    ));

    # Translate Form Data
    $getFAQTranslate = Capsule::table("mod_whmcms_faq")
    ->where("topid", $faqid)
    ->where("language", $langForm)
    ->get();
    //$transdata = query_select('faq', '*', "`topid`='{$faqid}' AND `language`='{$langForm}'");
    $transdata = (array) $getFAQTranslate[0];
    if ($oldfaqdata['language']==$langForm){
        $transdata['question'] = $oldfaqdata['question'];
        $transdata['answer'] = $oldfaqdata['answer'];
    }
    # Translate Form HTML
    $faqTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_question[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("faqItemFormTranslateQuestion"),
                'Type' => 'text',
                'Value' => $transdata['question'],
                'Size' => 40,
                'Class' => 'span6',
                'Description' => ''
            )
        )
        );
    if (WHMCMS::getConfig("editor") != 'htmleditor'){
        $faqTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_answer[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("faqItemFormTranslateAnswer"),
                    'Type' => 'editor',
                    'Value' => $transdata['answer'],
                    'Class' => 'span12',
                    'Description' => ''
                )
            )
            );
    }
    else {
        $jsEditor = "<script type='text/javascript'>var html_editor_".$langForm." = ace.edit('html_editor_".$langForm."');
        html_editor_".$langForm.".setTheme('ace/theme/xcode');
        html_editor_".$langForm.".getSession().setMode('ace/mode/html');
        var html_textarea_".$langForm." = $('#html_editortext_".$langForm."');
        html_textarea_".$langForm.".hide();
        html_editor_".$langForm.".getSession().on('change', function () {
            html_textarea_".$langForm.".val(html_editor_".$langForm.".getSession().getValue());
        });</script>";
        $faqTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_answer[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("faqItemFormTranslateAnswer"),
                    'Type' => 'editor',
                    'Value' => $transdata['answer'],
                    'Class' => 'span12',
                    'id' => 'html_editortext_' . $langForm,
                    'Description' => '<pre id="html_editor_' . $langForm . '" class="html_editor">' . $transdata['answer'] . '</pre>' . $jsEditor
                )
            )
            );
    }

    if ($returnForm=='main'){
        return $faqForm;
    }
    elseif ($returnForm=='maineditor'){
        return $faqMainEditor;
    }
    elseif ($returnForm=='options'){
        return $faqOptions;
    }
    elseif ($returnForm=='translate'){
        return $faqTranslate;
    }
}
/*
 *
 *********************************************************************************/


 /*********************************************************************************
 * Menus Admin Area
 */
/*
 * @param $groupid Used for Update Category
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function menuCategoryForm($categoryid = 0, $returnForm = 'main', $_smarty){

    $categoryid = intval($categoryid);

    if ($categoryid!='0'){

        # Select Category Data
        $getCategoryInfo = Capsule::table("mod_whmcms_menucategories")->where("categoryid", $categoryid)->get();
        $categorydata = (array) $getCategoryInfo[0];

        $_smarty->assign('categorydata', $categorydata);

    }

    # AJAX Alias Form
    $aliasForm = "<i style='font-size:14px;'>" . WHMCMS::getSystemURL() . "faq/</i> &nbsp;";
    $aliasForm .= '<input type="text" id="alias_' . $groupid . '" name="alias" value="' . $groupdata['alias'] . '"> <img src="images/loading.gif" class="hide" id="aliasLoading" alt="loading..">';

    # Main Category Form
    $categoryForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("menuCategoryFormTitle"),
            'Type' => 'text',
            'Value' => $categorydata['title'],
            'Size' => 30,
            'Class' => 'span5 validate[required] text-input',
            'Placeholder' => WHMCMS::__("menuCategoryFormTitleDesc"),
            'Description' => ''
        ),
    );
    if ($categoryid === 0){

        $categoryForm[] = array (
            'Fieldname' => 'installdefaultmenu',
            'FriendlyName' => WHMCMS::__("menuCategoryFormInstallDefaultLabel"),
            'Type' => 'select',
            'Options' => array("none" => "None", "primary" => "WHMCS Primary Navbar", "secondary" => "WHMCS Secondary Navbar"),
            'Size' => 30,
            'Class' => 'span5',
            'Placeholder' => WHMCMS::__("menuCategoryFormInstallDefaultDesc"),
            'Description' => ''
        );

    }

    $categoryForm = createForm($categoryForm);

    # CSS Options Form
    $optionsForm = array(
        array (
            'Fieldname' => 'css_class',
            'FriendlyName' => WHMCMS::__("menuCategoryFormCssClass"),
            'Type' => 'text',
            'Value' => $categorydata['css_class'],
            'Size' => 30,
            'Class' => 'span5 validate[optional] text-input',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'css_activeclass',
            'FriendlyName' => WHMCMS::__("menuCategoryFormCssActiveClass"),
            'Type' => 'text',
            'Value' => $categorydata['css_activeclass'],
            'Size' => 30,
            'Class' => 'span5 validate[optional] text-input',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'css_id',
            'FriendlyName' => WHMCMS::__("menuCategoryFormCssID"),
            'Type' => 'text',
            'Value' => $categorydata['css_id'],
            'Size' => 30,
            'Class' => 'span5 validate[optional] text-input',
            'Description' => ''
        )
    );
    $optionsForm = createForm($optionsForm);


    if ($returnForm=='main'){
        return $categoryForm;
    }
    elseif ($returnForm=='options'){
        return $optionsForm;
    }
}

/*
 * @param $menuid Used for Update Menu Item
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function menuItemForm($menuid=0, $categoryid, $returnForm='main', $langForm='', $_smarty){

    $categoryid = intval($categoryid);
    $menuid = intval($menuid);

    # Select Menu Parent List
    $menulist['0'] = WHMCMS::__("menuItemNoParent");

    $getLevel1 = Capsule::table("mod_whmcms_menu")
    ->where("categoryid", $categoryid)
    ->where("topid", 0)
    ->where("parentid", 0)
    ->where("menuid", "!=", $menuid)
    ->orderBy("reorder", "asc")
    ->get();
    foreach($getLevel1 as $level1){

        $level1 = (array) $level1;
        $menulist[$level1['menuid']] = $level1['title'];

        # 2nd Level
        $getLevel2 = Capsule::table("mod_whmcms_menu")
        ->where("topid", 0)
        ->where("parentid", $level1['menuid'])
        ->where("menuid", "!=", $menuid)
        ->orderBy("reorder", "asc")
        ->get();
        foreach($getLevel2 as $level2){

            $level2 = (array) $level2;
            $menulist[$level2['menuid']] = ' &nbsp; -- &nbsp; ' . $level2['title'];

            # 3rd Level
            $getLevel3 = Capsule::table("mod_whmcms_menu")
            ->where("topid", 0)
            ->where("parentid", $level2['menuid'])
            ->where("menuid", "!=", $menuid)
            ->orderBy("reorder", "asc")
            ->get();
            foreach($getLevel3 as $level3){

                $level3 = (array) $level3;
                $menulist[$level3['menuid']] = ' &nbsp; &nbsp; &nbsp; -- &nbsp; ' . $level3['title'];

            }
        }
    }

    if ($menuid!='0'){
        # Select Menu Data
        $getMenuInfo = Capsule::table("mod_whmcms_menu")->where("menuid", $menuid)->get();
        $menudata = (array) $getMenuInfo[0];

        $menudata['datecreate'] = fromMySQLDate($menudata['datecreate'], true, false);
        $menudata['datemodify'] = ($menudata['datemodify']=='0000-00-00 00:00:00')? 'Never': fromMySQLDate($menudata['datemodify'], true, false);

        # Select Translate
        $getMenuTranslate = Capsule::table("mod_whmcms_menu")
        ->where("topid", $menuid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());

        $countTrans = $getMenuTranslate->count();
        $menuTrans = $getMenuTranslate->get();
        $menuTrans = (array) $menuTrans[0];

        if ($countTrans!='0'){
            $oldmenudata = $menudata; // Save The Current Page Details for use in other place
            $menudata['title'] = $menuTrans['title'];
            $menudata['deletetranslation'] = $menuTrans['menuid'];
        }
        $_smarty->assign('menudata', $menudata);
    }
    else {
        $menudata['enable'] = 1;
        $menudata['private'] = 0;
    }

    /***********
     * Select Menu Type Data
     ************/
    # Select Pages
    $getPages = Capsule::table("mod_whmcms_pages")->where("topid", 0);
    //$select_pages = query_select('pages', '*', "`topid`='0'");
    $count_pages = $getPages->count();
    if ($menudata['url_type']=='page' || $menudata['url_type']==''){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }

    $pagelist = '<select name="type_page" id="type_page" class="span8 form-control ' . $selected_type . '">';
    if ($count_pages=='0'){
        $pagelist .= '<option value="" disabled>' . WHMCMS::__("menuItemNoPages") . '</option>';
    }
    foreach($getPages->get() as $page){
        $page = (array) $page;
        if ($menudata['url_type']=='page' && $page['pageid']==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $pagelist .= '<option value="' . $page['pageid'] . '" ' . $selected . '>' . $page['title'] . '</option>';
        $selected = '';
    }
    $pagelist .= '</select>';
    $selected = '';

    # Select FAQ Groups
    $getFAQGroups = Capsule::table("mod_whmcms_faqgroups")->where("topid", 0);
    $count_faq = $getFAQGroups->count();
    if ($menudata['url_type']=='faq'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }

    $faqlist = '<select name="type_faq" id="type_faq" class="span8 form-control ' . $selected_type . '">';
    if ($count_faq=='0'){
        $faqlist .= '<option value="" disabled>'.WHMCMS::__("menuItemNoFaq").'</option>';
    }
    foreach($getFAQGroups->get() as $faq){
        $faq = (array) $faq;
        if ($menudata['url_type']=='faq' && $faq['groupid']==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $faqlist .= '<option value="' . $faq['groupid'] . '" ' . $selected . '>' . $faq['title'] . '</option>';
        $selected = '';
    }
    $faqlist .= '</select>';

    # Select Download Categories
    $getDownloadCategories = Capsule::table("tbldownloadcats")->where("parentid", 0);
    $count_download = $getDownloadCategories->count();
    if ($menudata['url_type']=='download'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }

    $downloadlist = '<select name="type_download" id="type_download" class="span8 form-control ' . $selected_type . '">';

    if ($count_download=='0'){
        $downloadlist .= '<option value="" disabled>'.WHMCMS::__("menuItemNoDownload").'</option>';
    }

    foreach ($getDownloadCategories->get() as $download){
        $download = (array) $download;
        if ($menudata['url_type']=='download' && $download['id']==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $downloadlist .= '<option value="' . $download['id'] . '" ' . $selected . '>' . $download['name'] . '</option>';
        $selected = '';
    }
    $downloadlist .= '</select>';

    # Select Knowledgebase Categories
    $getKBCategories = Capsule::table("tblknowledgebasecats")->where("parentid", 0);
    $count_knowledge = $getKBCategories->count();
    if ($menudata['url_type']=='knowledge'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }

    $knowledgelist = '<select name="type_knowledge" id="type_knowledge" class="span8 form-control ' . $selected_type . '">';

    if ($count_knowledge=='0'){
        $knowledgelist .= '<option value="" disabled>'.WHMCMS::__("menuItemNoKnowledge").'</option>';
    }

    foreach($getKBCategories->get() as $knowledge){
        $knowledge = (array) $knowledge;
        if ($menudata['url_type']=='knowledge' && $knowledge['id']==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $knowledgelist .= '<option value="' . $knowledge['id'] . '" ' . $selected . '>' . $knowledge['name'] . '</option>';
        $selected = '';
    }
    $knowledgelist .= '</select>';

    # Select Support Departments
    $getSupportDepartments = Capsule::table("tblticketdepartments");
    $count_support = $getSupportDepartments->count();
    if ($menudata['url_type']=='support'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }

    $supportlist = '<select name="type_support" id="type_support" class="span8 form-control ' . $selected_type . '">';

    if ($count_support=='0'){
        $supportlist .= '<option value="" disabled>'.WHMCMS::__("menuItemNoSupport").'</option>';
    }

    foreach($getSupportDepartments->get() as $support){
        $support = (array) $support;
        if ($menudata['url_type']=='support' && $support['id']==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $supportlist .= '<option value="' . $support['id'] . '" ' . $selected . '>' . $support['name'] . '</option>';
        $selected = '';
    }
    $supportlist .= '</select>';

    # External Link
    if ($menudata['url_type']=='external'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }
    $type_external = '<input type="text" id="type_external" name="type_external" value="' . $menudata['url'] . '" class="form-control span8 validate[optional] text-input ' . $selected_type . '" placeholder="'.WHMCMS::__("menuItemNoExternal").'">';

    # Internal URLs
    $internal = [
        'index.php' => WHMCMS::__("menuLinksHome"),
        'clientarea.php' => WHMCMS::__("menuLinksClientArea"),
        'portfolio.php' => WHMCMS::__("menuLinksPortfolio"),
        'announcements' => WHMCMS::__("menuLinksAnnouncements"),
        'downloads.php' => WHMCMS::__("menuLinksDownloads"),
        'knowledgebase' => WHMCMS::__("menuLinksKnowledge"),
        'domainchecker.php' => WHMCMS::__("menuLinksDomainChecker"),
        'networkissues.php' => WHMCMS::__("menuLinksNetworkIssues"),
        'cart.php' => WHMCMS::__("menuLinksOrderPage"),
        'supporttickets.php' => WHMCMS::__("menuLinksSupportTickets"),
        'submitticket.php' => WHMCMS::__("menuLinksSubmitTicket"),
        'affiliates.php' => WHMCMS::__("menuLinksAffiliates"),
        'contact.php' => WHMCMS::__("menuLinksContactUs"),
        'serverstatus.php' => WHMCMS::__("menuLinksServerStatus"),
        'register.php' => WHMCMS::__("menuLinksRegister"),
        'pwreset.php' => WHMCMS::__("menuLinksForgotPassword"),
        'login.php' => WHMCMS::__("menuLinksLogin"),
    ];

    if ($menudata['url_type']=='internal'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }
    $type_internal .= '<select name="type_internal" id="type_internal" class="span8 form-control ' . $selected_type . '">';
    foreach ($internal as $urls => $titles){
        if ($menudata['url_type']=='internal' && $urls==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $type_internal .= '<option value="' . $urls . '" ' . $selected . '>' . $titles . '</option>';
        $selected = '';
    }
    $type_internal .= '</select>';

    # Clientarea URLs
    $clientarea = [
        'clientarea.php?action=products' => WHMCMS::__("menuLinksMyServices"),
        'cart.php' => WHMCMS::__("menuLinksOrderNewService"),
        'cart.php?gid=addons' => WHMCMS::__("menuLinksAvailableAddons"),
        'clientarea.php?action=domains' => WHMCMS::__("menuLinksMyDomains"),
        'cart.php?gid=renewals' => WHMCMS::__("menuLinksRenewDomains"),
        'cart.php?a=add&domain=register' => WHMCMS::__("menuLinksRegNewDomain"),
        'cart.php?a=add&domain=transfer' => WHMCMS::__("menuLinksTransferDomains"),
        'domainchecker.php' => WHMCMS::__("menuLinksWhois"),
        'clientarea.php?action=invoices' => WHMCMS::__("menuLinksMyInvoices"),
        'clientarea.php?action=creditcard' => WHMCMS::__("menuLinksManageCC"),
        'clientarea.php?action=addfunds' => WHMCMS::__("menuLinksAddFunds"),
        'clientarea.php?action=quotes' => WHMCMS::__("menuLinksMyQuotes"),
        'clientarea.php?action=masspay&all=true' => WHMCMS::__("menuLinksMassPayment"),
        'clientarea.php?action=security' => WHMCMS::__("menuLinksSecuritySettings"),
        'supporttickets.php' => WHMCMS::__("menuLinksMyTickets"),
        'clientarea.php?action=details' => WHMCMS::__("menuLinksEditAccount"),
        'clientarea.php?action=contacts' => WHMCMS::__("menuLinksContacts"),
        'clientarea.php?action=emails' => WHMCMS::__("menuLinksEmails"),
        'clientarea.php?action=changepw' => WHMCMS::__("menuLinksChangePassword"),
        'logout.php' => WHMCMS::__("menuLinksLogout")
    ];

    if ($menudata['url_type']=='clientarea'){
        $selected_type = 'menuTypeShow';
    }
    else {
        $selected_type = 'menuTypeHide';
    }

    $type_clientarea .= '<select name="type_clientarea" id="type_clientarea" class="span8 form-control ' . $selected_type . '">';

    foreach ($clientarea as $urls => $titles){
        if ($menudata['url_type']=='clientarea' && $urls==$menudata['url']){
            $selected = 'selected="selected"';
        }
        $type_clientarea .= '<option value="' . $urls . '" ' . $selected . '>' . $titles . '</option>';
        $selected = '';
    }
    $type_clientarea .= '</select>';

    # Mix All URL Types
    $type_urls = '<div class="type_box"><label>Target URL</label>' . $pagelist . $faqlist . $downloadlist . $knowledgelist . $supportlist . $type_external . $type_internal . $type_clientarea . '</div>';

    # Type Options
    $type_list = [
        'page' => WHMCMS::__("menuFormTypePages"),
        'support' => WHMCMS::__("menuFormTypeSupport"),
        'download' => WHMCMS::__("menuFormTypeDownload"),
        'knowledge' => WHMCMS::__("menuFormTypeKnowledge"),
        'faq' => WHMCMS::__("menuFormTypeFAQ"),
        'clientarea' => WHMCMS::__("menuFormTypeClientArea"),
        'internal' => WHMCMS::__("menuFormTypeInternal"),
        'external' => WHMCMS::__("menuFormTypeExternal")
    ];

    # Menu Item Conditions
    $conditions = array(
        '' => WHMCMS::__("menuItemAlwaysVisible"),
        'numoverdueinvoices' => 'Client have: overdue invoice(s)', // Client Stats
        'numactivetickets' => 'Client have: active ticket(s)', // Client Stats
        'numactivedomains' => 'Client have: active domain(s)', // Client Stats
        'productsnumtotal' => 'Client have: active product(s)', // Client Stats
        'isaffiliate' => 'Client is registered as Affiliate', // Settings
        'updatecc' => 'Option enabled: Manage Credit Cards', // Settings
        'addfunds' => 'Option enabled: Add Funds', // Settings
        'domainreg' => 'Option enabled: Domain Registeration', // Settings
        'domaintrans' => 'Option enabled: Domain Transfer', // Settings
        'masspay' => 'Option enabled: Mass Pay', // Settings
        'affiliates' => 'Option enabled: Affiliates', // Settings
        'enomnewtldsenabled' => 'Module active: Enom New Tld', // Settings
        'dns_manager_is_active' => 'Module active: DNS Manager', // Settings
        'pmaddon' => 'Module active: Project Management', // Project Management WHMCS Addon
    );

    # Menu Item Badge/Label
    $badges = array(
        '' => WHMCMS::__("menuItemBadgeNone"),
        'productsnumtotal' => 'Number of Products/Services', // Client Stats
        'numdomains' => 'Number of Domains', // Client Stats
        'numdueinvoices' => 'Number of Due Invoices', // Client Stats
        'numoverdueinvoices' => 'Number of Overdue Invoices', // Client Stats
        'numactivetickets' => 'Number of Active Tickets', // Client Stats
        'creditbalance' => 'Credit Balance', // Client Stats
        'numunpaidinvoices' => 'Number of Unpaid Invoices', // Client Stats
        'numactivedomains' => 'Number of Active Domains' // Client Stats
    );

    # Menu Item = Divider
    $isDivider = false;
    if (in_array(WHMCMS::fromGet('action'), ["addmenudivider", "updatemenudivider"])){
        $isDivider = true;
    }

    # Main Menu Form
    $menuFormAdd = array(
        array (
            'Fieldname' => 'parentid',
            'FriendlyName' => WHMCMS::__("menuItemFormParent"),
            'Type' => 'select',
            'Value' => intval($menudata['parentid']),
            'Options' => $menulist,
            'Class' => 'span8 validate[optional] text-input',
            'Description' => ''
        )
    );

    $menuForm = array(
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($menudata['deletetranslation'])
        ),
        array(
            'Fieldname' => 'categoryid',
            'Type' => 'hidden',
            'Value' => intval($categoryid)
        ),
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("menuItemFormTitle"),
            'Type' => 'text',
            'Value' => ($isDivider ? "------" : $menudata['title']),
            'Class' => 'span8 validate[required] text-input',
            'Description' => '',
            'Attr' => ($isDivider ? "readonly" : "")
        ),
        array (
            'Fieldname' => 'url_type',
            'FriendlyName' => WHMCMS::__("menuItemFormTargetURL"),
            'Type' => 'select',
            'Value' => ($isDivider ? "external" : $menudata['url_type']),
            'Class' => 'span8 changemenutype',
            'Options' => $type_list,
            'Description' => ($isDivider ? "" : $type_urls),
            'Attr' => ($isDivider ? "readonly" : "")
        )
    );

    if ($menuid=='0'){
        $menuForm = $menuFormAdd + $menuForm;
        $menuForm = createForm($menuForm);
    }
    else {
        $menuForm = $menuFormAdd + $menuForm;
        $menuForm = createForm($menuForm);
    }

    # Date Created & Modified When Update
    if ($menuid!='' && $menuid!='0'){
        $menuOptions = createForm(array(
            array(
                'FriendlyName' => WHMCMS::__("menuItemFormCreated"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $menudata['datecreate']
            ),
            array(
                'FriendlyName' => WHMCMS::__("menuItemFormModified"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $menudata['datemodify']
            )
        ));
    }

    # Publishing & Sharing Options Form
    $menuOptions .= createForm([
        [
            'Fieldname' => 'enable',
            'FriendlyName' => WHMCMS::__("menuItemFormPublished"),
            'Type' => 'select',
            'Value' => $menudata['enable'],
            'Options' => [1 => WHMCMS::__("menuItemFormPublish"), 0 => WHMCMS::__("menuItemFormUnpublish")],
            'Class' => 'span12',
            'Description' => ""
        ],
        [
            'Fieldname' => 'private',
            'FriendlyName' => WHMCMS::__("menuItemFormStatus"),
            'Type' => 'select',
            'Value' => $menudata['private'],
            'Options' => [0 => WHMCMS::__("menuItemFormVisibleAll"), 1 => WHMCMS::__("menuItemFormVisibleAfterLogin"), 2 => WHMCMS::__("menuItemFormHiddenAfterLogin")],
            'Class' => 'span12',
            'Description' => WHMCMS::__("menuItemFormVisibility")
        ],
        [
            'Fieldname' => 'menucondition',
            'FriendlyName' => WHMCMS::__("menuItemFormCondition"),
            'Type' => 'select',
            'Value' => $menudata['menucondition'],
            'Options' => $conditions,
            'Class' => 'span12',
            'Description' => "",
            'Attr' => ''
        ],
        [
            'Fieldname' => 'menubadge',
            'FriendlyName' => WHMCMS::__("menuItemFormBadge"),
            'Type' => 'select',
            'Value' => $menudata['menubadge'],
            'Options' => $badges,
            'Class' => 'span12',
            'Description' => "",
            'Attr' => ($isDivider ? "readonly" : "")
        ],
        [
            'Fieldname' => 'target',
            'FriendlyName' => WHMCMS::__("menuItemFormTarget"),
            'Type' => 'select',
            'Value' => $menudata['target'],
            'Options' => ['_self' => WHMCMS::__("menuItemFormOpenInSameWin"), '_blank' => WHMCMS::__("menuItemFormOpenInNewWin")],
            'Class' => 'span12',
            'Description' => "",
            'Attr' => ($isDivider ? "readonly" : "")
        ]
    ]);

    # Css Settings
    $menuCss .= createForm(array(
        /*array (
         'Fieldname' => 'css_iconclass',
         'FriendlyName' => WHMCMS::__("menuItemFormCssIcon"),
         'Type' => 'text',
         'Value' => $menudata['css_iconclass'],
         'Size' => 20,
         'Class' => 'span12',
         'Description' => "You can specify Icon class name here to be displayed in this item, ex: <code><a href='https://fontawesome.com/v4.7.0/icons/' target='_blank'>fa fa-home</a></code> or <code><a href='https://getbootstrap.com/docs/3.3/components/#glyphicons' target='_blank'>glyphicon glyphicon-search</a></code>",
         'Attr' => ($isDivider ? "readonly" : "")
         ),*/
        array (
            'Fieldname' => 'css_class',
            'FriendlyName' => WHMCMS::__("menuItemFormCssClassName"),
            'Type' => 'text',
            'Value' => $menudata['css_class'],
            'Size' => 20,
            'Class' => 'span12',
            'Description' => "",
            'Attr' => ""
        ),
        array (
            'Fieldname' => 'css_id',
            'FriendlyName' => WHMCMS::__("menuItemFormCssID"),
            'Type' => 'text',
            'Value' => $menudata['css_id'],
            'Size' => 20,
            'Class' => 'span12',
            'Description' => "",
            'Attr' => ($isDivider ? "readonly" : "")
        ),
        array (
            'Fieldname' => 'css_hassubclass',
            'FriendlyName' => WHMCMS::__("menuItemFormParentClassName"),
            'Type' => 'text',
            'Value' => $menudata['css_hassubclass'],
            'Size' => 20,
            'Class' => 'span12',
            'Description' => WHMCMS::__("menuItemFormParentClassNameDesc"),
            'Attr' => ($isDivider ? "readonly" : "")
        ),
        array (
            'Fieldname' => 'css_submenuclass',
            'FriendlyName' => WHMCMS::__("menuItemFormSubMenuClass"),
            'Type' => 'text',
            'Value' => $menudata['css_submenuclass'],
            'Size' => 20,
            'Class' => 'span12',
            'Description' => WHMCMS::__("menuItemFormSubMenuClassDesc"),
            'Attr' => ($isDivider ? "readonly" : "")
        )
    ));

    # Translate Form Data
    $getMenuTranslate = Capsule::table("mod_whmcms_menu")
    ->where("topid", $menuid)
    ->where("language", $langForm)
    ->get();
    //$transdata = query_select('menu', '*', "`topid`='{$menuid}' AND `language`='{$langForm}'");
    $transdata = (array) $getMenuTranslate[0];
    if ($oldmenudata['language']==$langForm){
        $transdata['title'] = $oldtitledata['title'];
    }
    # Translate Form HTML
    $menuTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("menuItemFormTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span8',
                'Description' => ''
            )
        )
        );

    if ($returnForm=='main'){
        return  $menuForm;
    }
    elseif ($returnForm=='options'){
        return $menuOptions;
    }
    elseif ($returnForm=='css'){
        return $menuCss;
    }
    elseif ($returnForm=='translate'){
        return $menuTranslate;
    }

}
/*
 *
 *********************************************************************************/


/*********************************************************************************
 * Pages Admin Area
 */
/*
 * @param $pageid Used for Update Page
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function pageForm($pageid = 0, $returnForm = 'main', $langForm = '', $smarty){

    $pageid = intval($pageid);

    # Select Page Parent List
    $parentlist['0'] = 'No Parent';

    $getPageParent = Capsule::table("mod_whmcms_pages")
    ->where("topid", 0)
    ->where("parentid", 0)
    ->where("pageid", "!=", $pageid)
    ->select("pageid", "title")
    ->get();

    foreach ($getPageParent as $pageParent){

        $pageParent = (array) $pageParent;

        $parentlist[$pageParent['pageid']] = $pageParent['title'];

        $levelMarkBase = "--";

        foreach (whmcms_getPageChildLoop($pageParent['pageid'], $pageid) as $child){

            $levelMark = " ";
            for($i = 1; $i <= $child['level']; $i++){
                $levelMark .= $levelMarkBase;
            }
            $levelMark .= " ";

            if ($child['pageid']!=$pageid){
                $parentlist[$child['pageid']] = $levelMark . $child['title'];
            }

        }

    }

    if ($pageid != 0){
        # Select Page Data
        $getPageInfo = Capsule::table("mod_whmcms_pages")
        ->where("pageid", $pageid)
        ->get();
        $pagedata = (array) $getPageInfo[0];

        $pagedata['datemodify'] = ($pagedata['datemodify']=='0000-00-00 00:00:00')? 'Never': $pagedata['datemodify'];

        # Select Translate
        $getPageTranslate = Capsule::table("mod_whmcms_pages")
        ->where("topid", $pageid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());

        $countTrans = $getPageTranslate->count();
        $pageTrans = $getPageTranslate->get();
        $pageTrans = (array) $pageTrans[0];

        if ($countTrans!='0'){
            $oldpagedata = $pagedata; // Save The Current Page Details for use in other place
            $pagedata['title'] = $pageTrans['title'];
            $pagedata['subtitle'] = $pageTrans['subtitle'];
            $pagedata['content'] = $pageTrans['content'];
            $pagedata['deletetranslation'] = $pageTrans['pageid'];
        }
        $smarty->assign('pagedata', $pagedata);
    }
    else {
        $pagedata['enable'] = 1;
    }

    $aliasForm = [];
    $aliasForm[] = '<div id="seo-url_' . $pageid . '" class="seo-url form-group span10">';
    $aliasForm[] = '<div id="seo-url-actions_' . $pageid . '" class="seo-url-actions">';
    $aliasForm[] = '<span id="seo-url-actions-loading_' . $pageid . '" class="seo-url-actions-loading hidden"><i class="fa fa-fw fa-spinner fa-spin"></i></span>';
    $aliasForm[] = '<span id="seo-url-actions-lock_' . $pageid . '" class="seo-url-actions-lock" data-reltype="pages" data-relid="' . $pageid . '" title="Locked, click to edit it"><i class="fa fa-fw fa-lock"></i></span>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '<div class="input-group">';
    $aliasForm[] = '<div id="seo-url-prefix_' . $pageid . '" class="seo-url-prefix input-group-addon">' . WHMCMS::getSystemURL() . '</div>';
    $aliasForm[] = '<input type="text" name="alias" value="' . $pagedata['alias'] . '" id="seo-url-input_' . $pageid . '" class="seo-url-input form-control locked' . (($pageid === 0) ? "" : " manual") . '" data-source="#title" data-reltype="pages" data-relid="' . $pageid . '" data-ajaxsignature="" readonly>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '</div>';

    $aliasForm = join("", $aliasForm);

    # AJAX Alias Form
    //$aliasForm = "<i style='font-size:14px;'>" . WHMCMS::getSystemURL() . "</i> &nbsp;";
    //$aliasForm .= '<input type="text" id="alias" name="alias" value="' . $pagedata['alias'] . '"> <img src="images/loading.gif" class="hide" id="aliasLoading" alt="loading..">';

    # Main Page Form
    $pageForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("pagesFormTitle"),
            'Type' => 'text',
            'Value' => $pagedata['title'],
            'Size' => 30,
            'Class' => 'span10 validate[required] text-input generateAlias',
            'Attr' => 'data-alias="#alias" data-reltype="pages" data-relid="' . $pageid . '"',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'subtitle',
            'FriendlyName' => WHMCMS::__("pagesFormSubTitle"),
            'Type' => 'text',
            'Value' => $pagedata['subtitle'],
            'Size' => 30,
            'Class' => 'span10',
            'Description' => ''
        ),
        array (
            'FriendlyName' => WHMCMS::__("pagesFormAlias"),
            'Type' => 'hr',
            'Description' => $aliasForm
        ),
        array (
            'Fieldname' => 'parentid',
            'FriendlyName' => WHMCMS::__("pagesFormPageParent"),
            'Type' => 'select',
            'Value' => $pagedata['parentid'],
            'Options' => $parentlist,
            'Class' => 'span10',
            'Description' => ''
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($pagedata['deletetranslation'])
        )
    );
    $pageForm = createForm($pageForm);

    # Page Editor Form
    if (WHMCMS::getConfig("editor") == 'htmleditor'){
        $pageEditor = array(
            array (
                'Fieldname' => 'content',
                'FriendlyName' => "",
                'Type' => 'textarea',
                'Value' => $pagedata['content'],
                'Rows' => 10,
                'Cols' => 100,
                'Class' => 'span10 html_editor',
                'id' => 'html_editortext',
                'Description' => '<pre id="html_editor" class="html_editor">' . $pagedata['content'] . '</pre>'
            )
        );
    }
    else {
        $pageEditor = array(
            array (
                'Fieldname' => 'content',
                'FriendlyName' => '',
                'Type' => 'editor',
                'Rows' => 10,
                'Value' => $pagedata['content'],
                'Class' => 'span10',
                'id' => 'page_content',
                'Description' => ''
            )
        );
    }
    $pageEditor = createForm($pageEditor);

    # Date Created & Modified When Update
    if ($pageid!='' && $pageid!='0'){
        $pageOptions = createForm(array(
            array(
                'FriendlyName' => WHMCMS::__("pagesFormCreated"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $pagedata['datecreate']
            ),
            array(
                'FriendlyName' => WHMCMS::__("pagesFormModified"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $pagedata['datemodify']
            ),
            array(
                'FriendlyName' => WHMCMS::__("pagesFormViews"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => number_format($pagedata['hits'])
            )
        ));
    }

    # Publishing & Sharing Options Form
    $pageOptions .= createForm(array(
        array (
            'Fieldname' => 'private',
            'FriendlyName' => WHMCMS::__("pagesFormAccessibility"),
            'Type' => 'select',
            'Value' => $pagedata['private'],
            'Options' => array('1' => WHMCMS::__("pagesFormPrivate"), '0' => WHMCMS::__("pagesFormPublic")),
            'Class' => '',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'enable',
            'FriendlyName' => WHMCMS::__("pagesFormPublished"),
            'Type' => 'select',
            'Value' => $pagedata['enable'],
            'Options' => array('1' => WHMCMS::__("pagesFormPublish"), '0' => WHMCMS::__("pagesFormUnPublish")),
            'Class' => '',
            'Description' => ""
        ),
        array (
            'Fieldname' => 'hidetitle',
            'FriendlyName' => WHMCMS::__("pagesFormHideTitle"),
            'Type' => 'tickbox',
            'Value' => $pagedata['hidetitle'],
            'Class' => '',
            'Description' => WHMCMS::__("pagesFormHideTitleDesc")
        ),
        array (
            'Fieldname' => 'breadcrumbs',
            'FriendlyName' => WHMCMS::__("pagesFormBreadcrumbs"),
            'Type' => 'tickbox',
            'Value' => $pagedata['breadcrumbs'],
            'Class' => '',
            'Description' => WHMCMS::__("pagesFormBreadcrumbsDesc")
        ),
        array (
            'Fieldname' => 'fblike',
            'FriendlyName' => WHMCMS::__("pagesFormFacebook"),
            'Type' => 'tickbox',
            'Value' => $pagedata['fblike'],
            'Class' => '',
            'Description' => WHMCMS::__("pagesFormFacebookDesc")
        ),
        array (
            'Fieldname' => 'twitter',
            'FriendlyName' => WHMCMS::__("pagesFormTwitter"),
            'Type' => 'tickbox',
            'Value' => $pagedata['twitter'],
            'Class' => '',
            'Description' => WHMCMS::__("pagesFormTwitterDesc")
        ),
        array (
            'Fieldname' => 'googleplus',
            'FriendlyName' => WHMCMS::__("pagesFormGooglePlus"),
            'Type' => 'tickbox',
            'Value' => $pagedata['googleplus'],
            'Class' => '',
            'Description' => WHMCMS::__("pagesFormGooglePlusDesc")
        ),
        array (
            'Fieldname' => 'fbcomment',
            'FriendlyName' => WHMCMS::__("pagesFormFBComments"),
            'Type' => 'tickbox',
            'Value' => $pagedata['fbcomment'],
            'Class' => '',
            'Description' => WHMCMS::__("pagesFormFBCommentsDesc")
        )
    ));

    # SEO Options Form
    $pageAdvanced = array(
        array (
            'Fieldname' => 'description',
            'FriendlyName' => WHMCMS::__("pagesFormMetaDescription"),
            'Type' => 'textarea',
            'Value' => $pagedata['metadescription'],
            'Cols' => 50,
            'Rows' => 3,
            'Class' => 'span12',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'keywords',
            'FriendlyName' => WHMCMS::__("pagesFormMetaKeywords"),
            'Type' => 'textarea',
            'Value' => $pagedata['metakeywords'],
            'Cols' => 50,
            'Rows' => 3,
            'Class' => 'span12',
            'Description' => WHMCMS::__("pagesFormMetaKeywordsDesc")
        ),
        array (
            'Fieldname' => 'headercontent',
            'FriendlyName' => WHMCMS::__("pagesFormCustomHead"),
            'Type' => 'textarea',
            'Value' => $pagedata['headercontent'],
            'Cols' => 50,
            'Rows' => 3,
            'Class' => 'span12',
            'Description' => WHMCMS::__("pagesFormCustomHeadDesc")
        )
    );
    $pageAdvanced = createForm($pageAdvanced);

    # Translate Form Data
    $getPageTranslate = Capsule::table("mod_whmcms_pages")
    ->where("topid", $pageid)
    ->where("language", $langForm)
    ->get();
    //$transdata = query_select('pages', '*', "`topid`='{$pageid}' AND `language`='{$langForm}'");
    $transdata = (array) $getPageTranslate[0];
    if ($oldpagedata['language']==$langForm){
        $transdata['title'] = $oldpagedata['title'];
        $transdata['subtitle'] = $oldpagedata['subtitle'];
        $transdata['content'] = $oldpagedata['content'];
    }
    # Translate Form HTML
    $pageTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("pagesFormTranslateTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span6',
                'Description' => ''
            ),
            array (
                'Fieldname' => 'translate_subtitle[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("pagesFormTranslateSubTitle"),
                'Type' => 'text',
                'Value' => $transdata['subtitle'],
                'Size' => 40,
                'Class' => 'span6',
                'Description' => ''
            )
        )
        );
    if (WHMCMS::getConfig("editor") != 'htmleditor'){
        $pageTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_content[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("pagesFormTranslateContent"),
                    'Type' => 'editor',
                    'Value' => $transdata['content'],
                    'Class' => 'span12',
                    'Description' => ''
                )
            )
            );
    }
    else {
        $jsEditor = "<script type='text/javascript'>var html_editor_".$langForm." = ace.edit('html_editor_".$langForm."');
        html_editor_".$langForm.".setTheme('ace/theme/xcode');
        html_editor_".$langForm.".getSession().setMode('ace/mode/html');
        var html_textarea_".$langForm." = $('#html_editortext_".$langForm."');
        html_textarea_".$langForm.".hide();
        html_editor_".$langForm.".getSession().on('change', function () {
            html_textarea_".$langForm.".val(html_editor_".$langForm.".getSession().getValue());
        });</script>";
        $pageTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_content[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("pagesFormTranslateContent"),
                    'Type' => 'editor',
                    'Value' => $transdata['content'],
                    'Class' => 'span12',
                    'id' => 'html_editortext_' . $langForm,
                    'Description' => '<pre id="html_editor_' . $langForm . '" class="html_editor">' . $transdata['content'] . '</pre>' . $jsEditor
                )
            )
            );
    }

    if ($returnForm=='main'){
        return $pageForm;
    }
    elseif ($returnForm=='editor'){
        return $pageEditor;
    }
    elseif ($returnForm=='options'){
        return $pageOptions;
    }
    elseif ($returnForm=='advanced'){
        return $pageAdvanced;
    }
    elseif ($returnForm=='translate'){
        return $pageTranslate;
    }
}
# Get Page Child URLs
function whmcms_getPageChildLoop($pageID, $ignoredPageID = 0){

    global $level;

    if ($level>=1){
        $level++;
    }
    else {
        $level = 1;
    }

    $pageChild = array();

    # Get Page Child
    $getPageChild = Capsule::table("mod_whmcms_pages")
    ->where("topid", 0)
    ->where("parentid", $pageID)
    ->select("pageid", "title");

    foreach($getPageChild->get() as $child){

        $child = (array) $child;

        $child['level'] = $level;

        if ($child['pageid']!==$ignoredPageID){

            $pageChild[] = $child;

            foreach (whmcms_getPageChildLoop($child['pageid']) as $sub){

                $pageChild[] = $sub;

            }

        }

    }

    if (count($pageChild)>0){

        return $pageChild;

    }
    else {

        return array();

    }

}
# Get Page Parent URLs
function whmcms_getPageParentLoop($parentID = 0){

    $pageParents = array();

    # Has Parent?
    if (intval($parentID)!=0){

        # Get Parent Info
        $getParentInfo = Capsule::table("mod_whmcms_pages")
        ->where("pageid", $parentID)
        ->where("topid", 0)
        ->select("pageid", "parentid", "alias", "title", "language");

        $parentInfo = $getParentInfo->get();

        $parent = (array) $parentInfo[0];

        # Need To Get Translation?
        if ($parent['language'] != WHMCMS::getSystemDefaultLanguage()){

            # Get Parent Translation
            $getParentTranslation = Capsule::table("mod_whmcms_pages")
            ->where("topid", $parent['pageid'])
            ->where("language", WHMCMS::getSystemDefaultLanguage())
            ->select("pageid", "parentid", "alias", "title", "language");

            # Translation Exist
            if ($getParentTranslation->count()>0){

                $parentTranslation = $getParentTranslation->get();
                $parentTranslation = (array) $parentTranslation[0];

                $parent['title'] = $parentTranslation['title'];

            }

        }

        #~
        $pageParents[] = $parent;

        if(intval($parent['parentid'])!==0){

            foreach (whmcms_getPageParentLoop($parent['parentid']) as $parentParent){

                $pageParents[] = $parentParent;

            }

        }

    }

    if (count($pageParents)>0){
        return array_reverse($pageParents);
    }
    else {
        return array();
    }

}

/*
 *
 *********************************************************************************/


/*********************************************************************************
 * Portfolio Admin Area
 */
/*
 * @param $categoryid Used for Update Category
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function categoryForm($categoryid = 0, $returnForm = 'main', $langForm = '', $_smarty){

    $categoryid = intval($categoryid);

    if ($categoryid!='0'){
        # Select Category Data
        $getCategoryInfo = Capsule::table("mod_whmcms_portfoliocategories")
        ->where("categoryid", $categoryid)
        ->get();
        $categorydata = (array) $getCategoryInfo[0];

        # Select Translate
        $getCategoryTranslate = Capsule::table("mod_whmcms_portfoliocategories")
        ->where("topid", $categoryid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());
        $countTrans = $getCategoryTranslate->count();
        $categoryTrans = $getCategoryTranslate->get();
        $categoryTrans = (array) $categoryTrans[0];
        if ($countTrans!='0'){
            $oldcategorydata = $categorydata; // Save The Current Category Details for use in other place
            $categorydata['title'] = $categoryTrans['title'];
            $categorydata['deletetranslation'] = $categoryTrans['categoryid'];
        }
        $_smarty->assign('categorydata', $categorydata);
    }
    else {
        $categorydata['enable'] = 1;
    }


    # AJAX Alias Form
    $aliasForm = [];
    $aliasForm[] = '<div id="seo-url_' . $categoryid . '" class="seo-url form-group span12">';
    $aliasForm[] = '<div id="seo-url-actions_' . $categoryid . '" class="seo-url-actions">';
    $aliasForm[] = '<span id="seo-url-actions-loading_' . $categoryid . '" class="seo-url-actions-loading hidden"><i class="fa fa-fw fa-spinner fa-spin"></i></span>';
    $aliasForm[] = '<span id="seo-url-actions-lock_' . $categoryid . '" class="seo-url-actions-lock" data-reltype="portfolio-category" data-relid="' . $categoryid . '" title="Locked, click to edit it"><i class="fa fa-fw fa-lock"></i></span>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '<div class="input-group">';
    $aliasForm[] = '<div id="seo-url-prefix_' . $categoryid . '" class="seo-url-prefix input-group-addon">' . WHMCMS::getSystemURL() . 'portfolio/</div>';
    $aliasForm[] = '<input type="text" id="seo-url-input_' . $categoryid . '" name="alias" value="' . $categorydata['alias'] . '" class="seo-url-input form-control locked' . (($categoryid === 0) ? "" : " manual") . '" data-source="#title" data-reltype="portfolio-category" data-relid="' . $categoryid . '" data-ajaxsignature="" readonly>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '</div>';

    $aliasForm = join("", $aliasForm);

    # Main Category Form
    $categoryForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("portfolioFormTitle"),
            'Type' => 'text',
            'Value' => $categorydata['title'],
            'Size' => 30,
            'Class' => 'span12 validate[required] text-input generateAlias',
            'Attr' => 'data-alias="#alias_' . $categoryid . '" data-reltype="portfolio-category" data-relid="' . $categoryid . '" required',
            'Description' => ''
        ),
        array (
            'FriendlyName' => WHMCMS::__("portfolioFormAlias"),
            'Type' => 'hr',
            'Description' => $aliasForm
        ),
        array (
            'Fieldname' => 'enable',
            'FriendlyName' => WHMCMS::__("portfolioFormPublished"),
            'Type' => 'select',
            'Value' => $categorydata['enable'],
            'Options' => array(0 => WHMCMS::__("portfolioFormUnPublish"), 1 => WHMCMS::__("portfolioFormPublish")),
            'Class' => 'span12',
            'Description' => ""
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($categorydata['deletetranslation'])
        )
    );
    $categoryForm = createForm($categoryForm);

    # Category Form Meta
    $categoryFormMeta = array(
        array (
            'Fieldname' => 'meta_description',
            'FriendlyName' => WHMCMS::__("portfolioFormMetaDescription"),
            'Type' => 'textarea',
            'Value' => $categorydata['meta_description'],
            'Rows' => 6,
            'Class' => 'span12 text-input',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'meta_keywords',
            'FriendlyName' => WHMCMS::__("portfolioFormMetaKeywords"),
            'Type' => 'textarea',
            'Value' => $categorydata['meta_keywords'],
            'Rows' => 6,
            'Class' => 'span12 text-input',
            'Description' => 'Separate between words by comma ","'
        ),
        array (
            'Fieldname' => 'custom_head',
            'FriendlyName' => WHMCMS::__("portfolioFormMetaCustomHeadContent"),
            'Type' => 'textarea',
            'Value' => html_entity_decode($categorydata['custom_head']),
            'Rows' => 6,
            'Class' => 'span12 text-input',
            'Description' => 'HTML, Javascript and CSS placed between &lt;head&gt; tag'
        ),
    );
    $categoryFormMeta = createForm($categoryFormMeta);

    # Translate Form Data
    $getCategoryTranslate = Capsule::table("mod_whmcms_portfoliocategories")
    ->where("topid", $categoryid)
    ->where("language", $langForm)
    ->get();
    $transdata = (array) $getCategoryTranslate[0];
    if ($oldcategorydata['language']==$langForm){
        $transdata['title'] = $oldcategorydata['title'];
    }
    # Translate Form HTML
    $categoryTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("portfolioFormTranslateTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span12',
                'Description' => ''
            )
        )
        );

    if ($returnForm=='main'){
        return $categoryForm;
    }
    elseif ($returnForm=='meta'){
        return $categoryFormMeta;
    }
    elseif ($returnForm=='translate'){
        return $categoryTranslate;
    }
}

/*
 * @param $projectid Used for Update Project
 * @param $returnForm Used to Return Specific HTML Form
 * @param $langForm Used to Pass the Translate Language to get you a specific Form
 */
function projectForm($projectid=0, $returnForm='main', $langForm='', $_smarty){

    $projectid = intval($projectid);

    $catids = [];

    # Select Project Categories
    $getRelations = Capsule::table("mod_whmcms_portfoliorelations")
    ->where("projectid", $projectid)
    ->get();
    foreach ($getRelations as $relation){
        $relation = (array) $relation;
        $catids[] = $relation['categoryid'];
    }

    # Select Project Categories List
    $getCategories = Capsule::table("mod_whmcms_portfoliocategories")
    ->where("topid", 0)
    ->get();
    foreach($getCategories as $category){
        $categorydata = (array) $category;

        $checkedID = in_array($categorydata['categoryid'], $catids) ? 'checked="checked"' : '';
        $categorylist[$categorydata['categoryid']] = $categorydata['title'];
        $categoriesOptions .= '<label class="categoryLabel"><input type="checkbox" name="categoryid[]" value="' . $categorydata['categoryid'] . '" ' . $checkedID . '> ' . $categorydata['title'] . '</label>';
    }

    if ($projectid!='0'){
        # Select Project Data
        $getProjectInfo = Capsule::table("mod_whmcms_portfolio")
        ->where("projectid", $projectid)
        ->get();
        $projectdata = (array) $getProjectInfo[0];
        $projectdata['datemodify'] = ($projectdata['datemodify']=='0000-00-00 00:00:00')? WHMCMS::__("projectFormNever"): $projectdata['datemodify'];

        # Select Translate
        $getProjectTranslate = Capsule::table("mod_whmcms_portfolio")
        ->where("topid", $projectid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());
        $countTrans = $getProjectTranslate->count();
        $projectTrans = $getProjectTranslate->get();
        $projectTrans = (array) $projectTrans[0];
        if ($countTrans!='0'){
            $oldprojectdata = $projectdata; // Save The Current Page Details for use in other place
            $projectdata['title'] = $projectTrans['title'];
            $projectdata['details'] = $projectTrans['details'];
            $projectdata['deletetranslation'] = $projectTrans['projectid'];
        }
        $_smarty->assign('projectdata', $projectdata);
    }
    else {
        $projectdata['enable'] = 1;
    }

    # AJAX Alias Form
    $aliasForm = [];
    $aliasForm[] = '<div id="seo-url_' . $projectid . '" class="seo-url form-group span10">';
    $aliasForm[] = '<div id="seo-url-actions_' . $projectid . '" class="seo-url-actions">';
    $aliasForm[] = '<span id="seo-url-actions-loading_' . $projectid . '" class="seo-url-actions-loading hidden"><i class="fa fa-fw fa-spinner fa-spin"></i></span>';
    $aliasForm[] = '<span id="seo-url-actions-lock_' . $projectid . '" class="seo-url-actions-lock" data-reltype="portfolio-project" data-relid="' . $projectid . '" title="Locked, click to edit it"><i class="fa fa-fw fa-lock"></i></span>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '<div class="input-group">';
    $aliasForm[] = '<div id="seo-url-prefix_' . $projectid . '" class="seo-url-prefix input-group-addon">' . WHMCMS::getSystemURL() . 'portfolio/</div>';
    $aliasForm[] = '<input type="text" id="seo-url-input_' . $projectid . '" name="alias" value="' . $projectdata['alias'] . '" class="seo-url-input form-control locked' . (($projectid === 0) ? "" : " manual") . '" data-source="#title" data-reltype="portfolio-project" data-relid="' . $projectid . '" data-ajaxsignature="" readonly>';
    $aliasForm[] = '</div>';
    $aliasForm[] = '</div>';

    $aliasForm = join("", $aliasForm);

    # Main Project Form
    $projectForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("projectFormTitle"),
            'Type' => 'text',
            'Value' => $projectdata['title'],
            'Size' => 30,
            'Class' => 'span10 validate[required] text-input generateAlias',
            'Attr' => 'data-alias="#alias" data-reltype="portfolio-project" data-relid="' . $projectid . '"',
            'Description' => ''
        ),
        array (
            'FriendlyName' => WHMCMS::__("projectFormAlias"),
            'Type' => 'hr',
            'Description' => $aliasForm
        ),
        array (
            'Fieldname' => 'url',
            'FriendlyName' => WHMCMS::__("projectFormProjectUrl"),
            'Type' => 'text',
            'Size' => 30,
            'Value' => $projectdata['url'],
            'Class' => 'span10 ltr',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'client',
            'FriendlyName' => WHMCMS::__("projectFormClient"),
            'Type' => 'text',
            'Size' => 30,
            'Value' => $projectdata['client'],
            'Class' => 'span10 ltr',
            'Description' => ''
        ),
        array (
            'Fieldname' => 'projectlogo',
            'FriendlyName' => WHMCMS::__("projectFormLogo"),
            'Type' => 'file',
            'Value' => '',
            'Size' => 30,
            'Class' => 'span10',
            'Description' => ""
        ),
        array (
            'Fieldname' => 'projectintrovideo',
            'FriendlyName' => WHMCMS::__("projectFormIntroVideo"),
            'Type' => 'file',
            'Value' => '',
            'Size' => 30,
            'Class' => 'span10',
            'Description' => "When used it will be displayed in category listing instead of the photo/logo above<br>Allowed file types (mp4) up-to 100Mb"
        ),
        array(
            'Fieldname' => 'deleteprojectintrovideo',
            'Type' => 'hidden',
            'Value' => 0,
        ),
        array (
            'Fieldname' => 'deleteprojectintrovideo',
            'FriendlyName' => '',
            'Type' => 'tickbox',
            'Value' => 1,
            'Size' => 30,
            'Class' => 'span10',
            'Description' => WHMCMS::__("projectFormDeleteIntroVideo")
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($projectdata['deletetranslation'])
        ),
        array(
            'Fieldname' => 'currentlogo',
            'Type' => 'hidden',
            'Value' => $projectdata['logo']
        )
    );
    $projectForm = createForm($projectForm);

    # Portfolio Details Editor Form
    if (WHMCMS::getConfig("editor") == 'htmleditor'){
        $projectEditor = array(
            array (
                'Fieldname' => 'details',
                'FriendlyName' => "",
                'Type' => 'textarea',
                'Value' => $projectdata['details'],
                'Rows' => 10,
                'Cols' => 100,
                'Class' => 'span10 html_editor',
                'id' => 'html_editortext',
                'Description' => '<pre id="html_editor" class="html_editor">' . $projectdata['details'] . '</pre>'
            )
        );
    }
    else {
        $projectEditor = array(
            array (
                'Fieldname' => 'details',
                'FriendlyName' => '',
                'Type' => 'editor',
                'Rows' => 10,
                'Value' => $projectdata['details'],
                'Class' => 'span10',
                'id' => 'project_details',
                'Description' => ''
            )
        );
    }
    $projectMainEditor = createForm($projectEditor);

    # Date Created & Modified When Update
    if ($projectid!='' && $projectid!='0'){
        $projectOptions = createForm(array(
            array(
                'FriendlyName' => WHMCMS::__("projectFormCreated"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $projectdata['datecreate']
            ),
            array(
                'FriendlyName' => WHMCMS::__("projectFormModified"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => $projectdata['datemodify']
            ),
            array(
                'FriendlyName' => WHMCMS::__("projectFormViews"),
                'Type' => 'hr',
                'Class' => 'oneline',
                'Description' => number_format($projectdata['hits'])
            )
        ));
    }

    # Publishing & Sharing Options Form
    $projectOptions .= createForm(array(
        array (
            'Fieldname' => 'datepublished',
            'FriendlyName' => WHMCMS::__("projectFormDatePublished"),
            'Type' => 'text',
            'Value' => $projectdata['datepublished'],
            'Size' => 30,
            'Class' => 'span12 datepicker',
            'Description' => ""
        ),
        array (
            'Fieldname' => 'enable',
            'FriendlyName' => WHMCMS::__("projectFormPublished"),
            'Type' => 'select',
            'Value' => $projectdata['enable'],
            'Options' => array(1 => WHMCMS::__("projectFormPublish"), 0 => WHMCMS::__("projectFormUnPublish")),
            'Class' => 'span12',
            'Description' => ""
        ),
        array (
            'FriendlyName' => WHMCMS::__("projectFormCategories"),
            'Type' => 'hr',
            'Description' => $categoriesOptions
        ),
        array (
            'Fieldname' => 'tags',
            'FriendlyName' => WHMCMS::__("projectFormTags"),
            'Type' => 'textarea',
            'Value' => $projectdata['tags'],
            'Cols' => 50,
            'Rows' => 3,
            'Class' => 'span12',
            'Description' => WHMCMS::__("projectFormTagsDesc")
        )
    ));

    # Translate Form Data
    $getProjectTranslate = Capsule::table("mod_whmcms_portfolio")
    ->where("topid", $projectid)
    ->where("language", $langForm)
    ->get();
    $transdata = (array) $getProjectTranslate[0];
    if ($oldprojectdata['language']==$langForm){
        $transdata['title'] = $oldprojectdata['title'];
        $transdata['details'] = $oldprojectdata['details'];
    }
    # Translate Form HTML
    $projectTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("projectFormTranslateTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span6',
                'Description' => ''
            )
        )
        );
    if (WHMCMS::getConfig("editor") != 'htmleditor'){
        $projectTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_details[' . $langForm . ']',
                    'FriendlyName' => WHMCMS::__("projectFormTranslateDetails"),
                    'Type' => 'editor',
                    'Value' => $transdata['details'],
                    'Class' => 'span12',
                    'Description' => ''
                )
            )
            );
    }
    else {
        $jsEditor = "<script type='text/javascript'>var html_editor_".$langForm." = ace.edit('html_editor_".$langForm."');
        html_editor_".$langForm.".setTheme('ace/theme/xcode');
        html_editor_".$langForm.".getSession().setMode('ace/mode/html');
        var html_textarea_".$langForm." = $('#html_editortext_".$langForm."');
        html_textarea_".$langForm.".hide();
        html_editor_".$langForm.".getSession().on('change', function () {
            html_textarea_".$langForm.".val(html_editor_".$langForm.".getSession().getValue());
        });</script>";
        $projectTranslate .= createForm(
            array(
                array (
                    'Fieldname' => 'translate_details[' . $langForm . ']',
                    'FriendlyName' => 'Details',
                    'Type' => 'editor',
                    'Value' => $transdata['details'],
                    'Class' => 'span12',
                    'id' => 'html_editortext_' . $langForm,
                    'Description' => '<pre id="html_editor_' . $langForm . '" class="html_editor">' . $transdata['details'] . '</pre>' . $jsEditor
                )
            )
            );
    }

    if ($returnForm=='main'){
        return $projectForm;
    }
    elseif ($returnForm=='maineditor'){
        return $projectMainEditor;
    }
    elseif ($returnForm=='options'){
        return $projectOptions;
    }
    elseif ($returnForm=='translate'){
        return $projectTranslate;
    }
}

/*
 * Photos HTML Form
 */
function photoForm($photoid = 0, $returnForm = 'main', $langForm = '', $_smarty){

    $photoid = intval($photoid);

    if ($photoid!='0'){
        # Select Photo Data
        $getPhotoInfo = Capsule::table("mod_whmcms_photos")
        ->where("photoid", $photoid)
        ->get();

        $photodata = (array) $getPhotoInfo[0];

        # Select Translate
        $getPhotoTranslate = Capsule::table("mod_whmcms_photos")
        ->where("topid", $photoid)
        ->where("language", WHMCMS::getSystemDefaultLanguage());
        $countTrans = $getPhotoTranslate->count();
        $photoTrans = $getPhotoTranslate->get();
        $photoTrans = (array) $photoTrans[0];
        if ($countTrans!='0'){
            $oldphotodata = $photodata; // Save The Current Photo Details for use in other place
            $photodata['title'] = $photoTrans['title'];
            $photodata['deletetranslation'] = $photoTrans['photoid'];
        }
        $_smarty->assign('photodata', $photodata);
        $photoRequired = 'optional';
    }
    else {
        $photodata['enable'] = 1;
        $photoRequired = 'required';
    }

    # Main Photo Form
    $photoForm = array(
        array (
            'Fieldname' => 'title',
            'FriendlyName' => WHMCMS::__("photoFormTitle"),
            'Type' => 'text',
            'Value' => $photodata['title'],
            'Size' => 30,
            'Class' => 'span12 validate[required] text-input',
            'id' => 'title_' . $photodata['photoid'],
            'Placeholder' => WHMCMS::__("photoFormTitleDesc"),
            'Description' => ''
        ),
        array (
            'Fieldname' => 'source',
            'FriendlyName' => WHMCMS::__("photoFormPhoto"),
            'Type' => 'file',
            'Value' => '',
            'Size' => 30,
            'Class' => 'span12 validate[' . $photoRequired . '] text-input',
            'id' => 'source_' . $photodata['photoid'],
            'Description' => ''
        ),
        array (
            'Fieldname' => 'details',
            'FriendlyName' => WHMCMS::__("photoFormDescription"),
            'Type' => 'textarea',
            'Value' => $photodata['details'],
            'Rows' => 5,
            'Class' => 'span12 validate[optional] text-input',
            'id' => 'details_' . $photodata['photoid'],
            'Placeholder' => WHMCMS::__("photoFormDescriptionDesc"),
            'Description' => ''
        ),
        array (
            'Fieldname' => 'enable',
            'FriendlyName' => WHMCMS::__("photoFormPublished"),
            'Type' => 'select',
            'Value' => $photodata['enable'],
            'Options' => array(0 => WHMCMS::__("photoFormUnPublish"), 1 => WHMCMS::__("photoFormPublish")),
            'Class' => 'span5',
            'Description' => ""
        ),
        array(
            'Fieldname' => 'current_photo',
            'Type' => 'hidden',
            'Value' => $photodata['source']
        ),
        array(
            'Fieldname' => 'deletetranslation',
            'Type' => 'hidden',
            'Value' => intval($photodata['deletetranslation'])
        )
    );
    $photoForm = createForm($photoForm);

    # Translate Form Data
    $getPhotoTranslate = Capsule::table("mod_whmcms_photos")
    ->where("topid", $photoid)
    ->where("language", $langForm)
    ->get();
    $transdata = (array) $getPhotoTranslate[0];
    if ($oldphotodata['language']==$langForm){
        $transdata['title'] = $oldphotodata['title'];
    }
    # Translate Form HTML
    $photoTranslate = createForm(
        array(
            array (
                'Fieldname' => 'translate_title[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("photoFormTranslateTitle"),
                'Type' => 'text',
                'Value' => $transdata['title'],
                'Size' => 40,
                'Class' => 'span12',
                'Description' => ''
            ),
            array (
                'Fieldname' => 'translate_details[' . $langForm . ']',
                'FriendlyName' => WHMCMS::__("photoFormTranslateDesciption"),
                'Type' => 'textarea',
                'Value' => $transdata['details'],
                'Rows' => 5,
                'Class' => 'span12',
                'Description' => ''
            )
        )
        );

    if ($returnForm=='main'){
        return $photoForm;
    }
    elseif ($returnForm=='translate'){
        return $photoTranslate;
    }
}
/*
 *
 *********************************************************************************/

/*********************************************************************************
 * Pagination
 */
function pagination($total, $per_page = 10, $page = 1, $urlVars = '?'){

    $total = $total;
    $adjacents = "2";

    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $per_page;

    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total/$per_page);
    $lpm1 = $lastpage - 1;

    $querystart = ($page * $per_page) - $per_page; // this return for mysql

    if (is_array($urlVars)){
        $url = '?';
        foreach ($urlVars as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
    }
    elseif ($urlVars==''){
        $url = '?';
    }
    else {
        $url = $urlVars;
    }

    $pagination = "";
    if($lastpage > 1){
        $pagination .= "<ul class='pagination'>";
        //$pagination .= "<li class='details'>Page $page of $lastpage</li>";
        if ($lastpage < 7 + ($adjacents * 2)){

            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page){
                    $pagination.= "<li class='active'><a>$counter</a></li>";
                }
                else {
                    $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)) {
            if($page < 1 + ($adjacents * 2)){
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }
                    else {
                        $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                }
                $pagination.= "<li class='disabled'><span>...</span></li>";
                $pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
            }
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='disabled'><span>...</span></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }
                    else {
                        $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                }
                $pagination.= "<li class='disabled'><span>..</span></li>";
                $pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
            }
            else {
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='disabled'><span>..</span></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }
                    else {
                        $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                }
            }
        }

        if ($page < $counter - 1){
            $pagination.= "<li><a href='{$url}page=$next'>".WHMCMS::__('paginationNext')."</a></li>";
            $pagination.= "<li><a href='{$url}page=$lastpage'>".WHMCMS::__('paginationLast')."</a></li>";
        }
        else{
            $pagination.= "<li class='disabled'><a>".WHMCMS::__('paginationNext')."</a></li>";
            $pagination.= "<li class='disabled'><a>".WHMCMS::__('paginationLast')."</a></li>";
        }
        $pagination.= "</ul>";
    }

    # Get From #
    $itemsFrom = $querystart+1;

    # Get To #
    $itemsTo = $itemsFrom-1+$per_page;

    if ($itemsTo>$total){
        $itemsTo = $total;
    }
    if ($total=='0'){
        $itemsFrom = 0;
    }

    #return $pagination;
    $info = array(
        'LimitFrom' => $querystart,
        'LimitTo' => $per_page,
        'HTML' => $pagination,
        'DisplayedFrom' => $itemsFrom,
        'DisplayedTo' => $itemsTo,
        'Total' => $total
    );

    return $info;

}

/*******************************************************************************
 * Create Form Elements From Arrays
 ********************************************************************************/
function createForm($elements){
    $form = '';
    foreach ($elements as $key){
        if ($key['Type']!='multi' && $key['Type']!='multitext' && $key['Type']!='multiselect'){
            $form .= '<div class="elementBox">';
        }
        # If Type of input equal "text" a normal text input created
        if ($key['Type']=="text"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><input type="text" size="' . $key['Size'] . '" name="' . $key['Fieldname'] . '" id="' . $key['id'] . '" value="' . $key['Value'] . '" class="' . $key['Class'] . ' form-control" placeholder="' . $key['Placeholder'] . '" ' . $key['Attr'] . '>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">'.$key['Description'].'</span>';
            }
        }
        # If Type of input equal "password" a text input with [Type="password"] will be created
        elseif ($key['Type']=="password"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><input type="password" size="' . $key['Size'] . '" name="' . $key['Fieldname'] . '" id="' . $key['id'] . '" value="' . $key['Value'] . '" class="' . $key['Class'] . ' form-control" placeholder="' . $key['Placeholder'] . '" ' . $key['Attr'] . '>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "file" file text input created
        elseif ($key['Type']=="file"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><input type="file" size="' . $key['Size'] . '" name="' . $key['Fieldname'] . '" id="' . $key['id'] . '" class="' . $key['Class'] . ' form-control" placeholder="' . $key['Placeholder'] . '" ' . $key['Attr'] . '>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "hidden" a hidden input caring value will be created
        elseif ($key['Type']=="hidden"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<input type="hidden" name="' . $key['Fieldname'] . '" id="' . $key['id'] . '" value="' . $key['Value'] . '" ' . $key['Attr'] . '>';
        }
        # If Type of input equal "tickbox" it means a checkbox with the value "on" created
        elseif ($key['Type']=="tickbox"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label class="checkbox" for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label>';
            $form .= '<input type="checkbox" name="' . $key['Fieldname'] . '" class="checkbox" id="' . $key['id'] . '" value="on" ' . ($key['Value']=="on" ? 'checked="checked"' : '') . ' class="' . $key['Class'] . '" ' . $key['Attr'] . '>';
            if ($key['Description']!=''){
                $form .= ' <span>' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "hr" a seperate Row will be created
        elseif ($key['Type']=="hr"){
            $form .= '<label class="' . $key['Class'] . '">' . $key['FriendlyName'] . '</label>';
            if ($key['Description']!=''){
                $form .= '<span class="online">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "textarea" textarea will be created
        elseif ($key['Type']=="textarea"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><textarea name="' . $key['Fieldname'] . '" id="' . $key['id'] . '" cols="' . $key['Cols'] . '" rows="' . $key['Rows'] . '" class="' . $key['Class'] . ' form-control" placeholder="' . $key['Placeholder'] . '" ' . $key['Attr'] . '>' . $key['Value'] . '</textarea>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "editor" on column will be shown and editor will be created
        elseif ($key['Type']=="bigtextarea"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><textarea name="' . $key['Fieldname'] . '" id="' . $key['id'] . '" cols="' . $key['Cols'] . '" rows="' . $key['Rows'] . '" class="' . $key['Class'] . ' form-control" placeholder="' . $key['Placeholder'] . '" ' . $key['Attr'] . '>' . $key['Value'] . '</textarea>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "editor" on column will be shown and editor will be created
        elseif ($key['Type']=="editor"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><textarea class="ckeditor ' . $key['Class'] . ' form-control" id="' . $key['id'] . '" name="' . $key['Fieldname'] . '" id="' . $key['Fieldname'] . '" cols="'.$key['Cols'].'" rows="'.$key['Rows'].'" placeholder="' . $key['Placeholder'] . '" ' . $key['Attr'] . '>' . $key['Value'] . '</textarea>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "select" a dropdown menu will be created and containing the options offered
        elseif ($key['Type']=="select"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><select name="' . $key['Fieldname'] . '" class="' . $key['Class'] . ' form-control" id="' . $key['id'] . '" ' . $key['Attr'] . '>';
            if (!empty($key['Options']) && is_array($key['Options'])){
                foreach ($key['Options'] as $value => $option){
                    $form .= '<option label="' . $option . '" value="' . $value . '" ' . ($key['Value']==$value ? 'selected="selected"' : '') . '>' . $option . '</option>';
                }
            }
            $form .= '</select>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # If Type of input equal "multiselect" a dropdown menu will be created and containing the options offered
        elseif ($key['Type']=="multiselectbox"){
            $key['id'] = ($key['id']=='') ? $key['Fieldname'] : $key['id'];
            $form .= '<label for="' . $key['id'] . '">' . $key['FriendlyName'] . '</label><select name="' . $key['Fieldname'] . '" multiple="multiple" class="' . $key['Class'] . ' form-control" id="' . $key['id'] . '" ' . $key['Attr'] . '>';
            if (!empty($key['Options']) && is_array($key['Options'])){
                foreach ($key['Options'] as $value => $option){
                    $form .= '<option label="' . $option . '" value="' . $value . '" ' . (in_array($value, (array) $key['Value']) ? 'selected="selected"' : '') . '>' . $option . '</option>';
                }
            }
            $form .= '</select>';
            if ($key['Description']!=''){
                $form .= '<span class="help-block">' . $key['Description'] . '</span>';
            }
        }
        # Type "radio" are the same as "select"
        elseif ($key['Type']=="radio"){
            $form .= '<label>' . $key['FriendlyName'] . '</label>';
            if (!empty($key['Options']) && is_array($key['Options'])){
                foreach ($key['Options'] as $value => $option){
                    $form .= '<label class="radio" for="radio_' . $value . '">';
                    $form .= '<input type="radio" name="' . $key['Fieldname'] . '" value="' . $value . '" id="radio_' . $value . '" class="radio" ' . ($key['Value']==$value ? 'checked="checked"' : '') . ' ' . $key['Attr'] . '> ' . $option;
                    $form .= '</label>';
                }
            }
            $form .= '';
        }
        # If Type of input equal "multi" that mean you need to create multi input in the same line by array(); in the "Multi" key
        elseif ($key['Type']=="multi"){
            $form .= '<label>' . $key['FriendlyName'] . '</label><div class="form-multi"> ' . createForm($key['Multi']) . '</div>';
        }
        # Two Forms for Multi Option only
        elseif ($key['Type']=="multitext"){
            $form .= '<input type="text" size="' . $key['Size'] . '" name="' . $key['Fieldname'] . '" value="' . $key['Value'] . '" class="input form-control"> ';
        }
        elseif ($key['Type']=="multiselect"){
            $form .= '<select name="' . $key['Fieldname'] . '" class="' . $key['Class'] . ' form-control">';
            if (!empty($key['Options']) && is_array($key['Options'])){
                foreach ($key['Options'] as $value => $option){
                    $form .= '<option label="' . $option . '" value="' . $value . '" ' . ($key['Value']==$value ? 'selected="selected"' : '') . '>' . $option . '</option>';
                }
            }
            $form .= '</select> ';
        }
        if ($key['Type']!='multi' && $key['Type']!='multitext' && $key['Type']!='multiselect'){
            $form .= '</div>';
        }
    }

    return $form;
}

?>
