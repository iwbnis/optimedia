<div class="row">
    <div class="{if $noBreadcrumbButton eq true}col-lg-12{else}col-lg-10{/if}">
        <ol class="breadcrumb">
            {foreach $breadcrumbs as $link => $title name=breadcrumbs}
            {if $smarty.foreach.breadcrumbs.last}
            <li class="active">{$title}</li>
            {else}
            <li><a href="{$link}">{$title}</a></li>
            {/if}
            {/foreach}
        </ol>
    </div>
    {if $noBreadcrumbButton neq true}
    <div class="col-lg-2">
        {if $action eq "listpages"}
        <a href="{$modurl}&action=addpage" class="btn btn-block btn-info">{WHMCMS::__("pagesCreatePageButton")}</a>
        {elseif $action eq "faq"}
        <a href="#addGroup" data-toggle="modal" class="btn btn-block btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("faqCreateGroupButton")}</a>
        {elseif $action eq "listfaq"}
        <a href="{$modurl}&action=addfaq&groupid={$groupid}" class="btn btn-block btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("faqItemCreateButton")}</a>
        {elseif $action eq "portfolio"}
        <a href="#addCategory" data-toggle="modal" class="btn btn-block btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("portfolioCreateButton")}</a>
        {elseif $action eq "listprojects"}
        <a href="{$modurl}&action=addproject" class="btn btn-block btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("projectsCreateButton")}</a>
        {elseif $action eq "listphotos"}
        <a href="#addPhoto" data-toggle="modal" class="btn btn-block btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("photosCreateButton")}</a>
		{elseif $action eq "menu"}
        <a href="#addCategory" data-toggle="modal" class="btn btn-block btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("menuCategoryCreateButton")}</a>
		{elseif $action eq "listmenu"}
        <div class="btn-group btn-block">
            <a href="{$modurl}&action=addmenu&categoryid={$categoryid}" class="btn btn-info"><i class="fa fa-plus-square"></i> {WHMCMS::__("menuItemCreateButton")}</a>
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="{$modurl}&action=addmenudivider&categoryid={$categoryid}">{WHMCMS::__("menuDividerCreateButton")}</a></li>
            </ul>
        </div>
		{else}
        <a href="{$goBackURL}" class="btn btn-block btn-default">{WHMCMS::__("breadcrumbsGoBack")}</a>
        {/if}
    </div>
    {/if}
</div>
<br>