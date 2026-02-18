{if $action eq "menu"}

{* List Menus *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkmenu" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="30%" class="text-left">{WHMCMS::__("menuCategoryTableTitle")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("menuCategoryTableIntegration")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("menuCategoryTableCode")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("menuCategoryTableItems")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("menuCategoryTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $categories as $category}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$category.categoryid}"></td>
                    <td class="text-left">
                        <a href="{$modurl}&action=listmenu&categoryid={$category.categoryid}">{$category.title|stripslashes}</a>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-default btn-block dropdown-toggle" type="button" id="integrationType_{$category.categoryid}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            	{$integrationtypes[$category.integration]}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="integrationType_{$category.categoryid}">
                                {foreach $integrationtypes as $type => $name}
                                <li{if $category.integration eq $type} class="active"{/if}><a href="{$modurl}&action=setmenuintegration&categoryid={$category.categoryid}&type={$type}">{$name}</a></li>
                                {/foreach}
                            </ul>
                        </div>
                    </td>
                    <td class="text-center">
                        {if $category.integration eq 1}
                        <a href="#codeCategory_{$category.categoryid}" data-toggle="modal" class="btn btn-sm btn-default" title="{WHMCMS::__("menuCategoryTableCodeButton")}"><i class="fa fa-code"></i></a>
                        {/if}
                    </td>
                    <td class="text-center"><a href="{$modurl}&action=listmenu&categoryid={$category.categoryid}">{$category.items|number_format}</a></td>
                    <td class="text-center">
                        <a href="{$modurl}&action=listmenu&categoryid={$category.categoryid}" class="btn btn-sm btn-info" title="{WHMCMS::__("menuCategoryTableItemsButton")}"><i class="fa fa-folder-open"></i></a>
                        <a href="#updateCategory_{$category.categoryid}" data-toggle="modal" class="btn btn-sm btn-warning" title="{WHMCMS::__("menuCategoryTableUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deleteCategory_{$category.categoryid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("menuCategoryTableDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="5">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* Group Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("menuCategoryActions")}</option>
                    <option value="delete">{WHMCMS::__("menuCategoryActionDelete")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("menuCategoryActionApply")}</button>
            </div>
        </div>
        
        <div class="clear"></div>
        
        </form>
    </div>
</div>


{* Pagination *}
<nav>
    {$pagination.HTML}
</nav>


{* Delete Category Confirm Box *}
{foreach $categories as $category}
<div id="deleteCategory_{$category.categoryid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryTitle_{$category.categoryid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletemenucategory&categoryid={$category.categoryid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteCategoryTitle_{$category.categoryid}">{WHMCMS::__("menuCategoryDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("menuCategoryDeleteDescription")} "<b>{$category.title|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("menuCategoryDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("menuCategoryDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}

{* Category Integration Code *}
{foreach $categories as $category}
<div id="codeCategory_{$category.categoryid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("menuCategoryCodePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("menuCategoryCodeDescription")}</p>
                    <textarea class="span12 form-control" rows="5" style="font-size:9pt;">{literal}{include file="$template/whmcms/output.tpl" output=WHMCMSMenus::renderMenu({/literal}{$category.categoryid}{literal})}{/literal}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("menuCategoryCodeCancel")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{* Adding Category Modal *}
<div id="addCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addCategoryTitle">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doaddmenucategory" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addCategoryTitle">{WHMCMS::__("menuCategoryCreatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" id="tabOptions">
                        <li class="active"><a href="#categoryMain">{WHMCMS::__("menuCategoryCreateInformation")}</a></li>
                        <li><a href="#categoryOptions">{WHMCMS::__("menuCategoryCreateOptions")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div class="clearline"></div>
                        <div class="tab-pane active" id="categoryMain">{$menuCategoryMain}</div>
                        <div class="tab-pane" id="categoryOptions">{$menuCategoryOptions}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("menuCategoryCreateCancel")}</button>
                    <button type="submit" class="btn btn-info">{WHMCMS::__("menuCategoryCreateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>


{* Update Category Modal *}
{foreach $categories as $category}
<div id="updateCategory_{$category.categoryid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateCategoryTitle_{$category.categoryid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doupdatemenucategory&categoryid={$category.categoryid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="updateCategoryTitle_{$category.categoryid}">{WHMCMS::__("menuCategoryUpdatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" id="tabOptions">
                        <li class="active"><a href="#categoryMain_{$category.categoryid}">{WHMCMS::__("menuCategoryUpdateInformation")}</a></li>
                        <li><a href="#categoryOptions_{$category.categoryid}">{WHMCMS::__("menuCategoryUpdateOptions")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div class="clearline"></div>
                        <div class="tab-pane active" id="categoryMain_{$category.categoryid}">{$category.categoryMain}</div>
                        <div class="tab-pane" id="categoryOptions_{$category.categoryid}">{$category.categoryOptions}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("menuCategoryUpdateCancel")}</button>
                    <button type="submit" class="btn btn-info">{WHMCMS::__("menuCategoryUpdateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{****************************
* Menu Items
*****************************}
{elseif $action eq "listmenu"}

<div class="row">
    <div class="col-lg-12">
    
        {function menuChildrenLoop items=[]}
        
            <ol{if $cssid neq ""} id="{$cssid}"{/if}{if $cssclass neq ""} class="{$cssclass}"{/if}>
            	
				{foreach $items as $item}
                <li id="list_{$item.menuid}">
                    <div class="menu-item">
                        <div class="text-left pull-left">
                            <div class="drag-drop-item">
                                <div>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </div>
                            </div>
                            <span>{$item.title}</span>
                        </div>
                        <div class="row pull-right">
                            <div class="col-lg-8 text-left">
                                <span class="text-mute" title="{$item.targeturl}">
                                	{if $item.title neq "------"}{$item.shorturl|truncate:60}{/if}
                                </span>
                            </div>
                            <div class="col-lg-1 text-center">
                                {if $item.enable eq 1}
                                <a href="{$modurl}&action=disablemenuitem&menuid={$item.menuid}&categoryid={$item.categoryid}" class="btn btn-sm btn-default menuitem-actions-togglestatus" data-status="published" data-menuid="{$item.menuid}" data-categoryid="{$item.categoryid}" title="{WHMCMS::__("menuItemTablePublish")}"><i class="fa fa-fw fa-check color-blue"></i></a>
								{else}
                                <a href="{$modurl}&action=enablemenuitem&menuid={$item.menuid}&categoryid={$item.categoryid}" class="btn btn-sm btn-default menuitem-actions-togglestatus" data-status="unpublished" data-menuid="{$item.menuid}" data-categoryid="{$item.categoryid}" title="{WHMCMS::__("menuItemTableUnPublish")}"><i class="fa fa-fw fa-times color-red"></i></a>
								{/if}
                            </div>
                            <div class="col-lg-3 text-right">
                                {if $item.validurl eq true}<a href="{$item.targeturl}" target="_blank" class="btn btn-sm btn-default" title="{WHMCMS::__("menuItemTableBrowseURL")}"><i class="fa fa-eye"></i></a>{/if}
                                <a href="{$modurl}&action={if $item.title eq "------"}updatemenudivider{else}updatemenu{/if}&menuid={$item.menuid}" class="btn btn-sm btn-warning" title="{WHMCMS::__("menuItemTableUpdateButton")}"><i class="fa fa-pencil"></i></a>
                                <a href="#deleteItem_{$item.menuid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("menuItemTableDeleteButton")}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                
                	{menuChildrenLoop items=$item.children cssid="" cssclass=""}
                
                </li>
				{/foreach}
                
            </ol>
            
    	{/function}
        
        {* Loop Menu *}
        {menuChildrenLoop items=$menu cssid="sortable-menu" cssclass="menu-items-list sortable"}

    </div>
</div>

{* Delete Menu Item Confirm Box *}
{function name=deleteMenuItemsLoop items=[]}
	{foreach $items as $item}
    <div id="deleteItem_{$item.menuid}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{$modurl}&action=dodeletemenuitem&menuid={$item.menuid}&categoryid={$categoryid}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{WHMCMS::__("menuItemDeletePageTitle")}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{WHMCMS::__("menuItemDeleteDescription")} "<b>{$item.title|stripslashes}</b>".</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("menuItemDeleteCancel")}</button>
                        <button type="submit" class="btn btn-danger">{WHMCMS::__("menuItemDeleteSubmit")}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
	{deleteMenuItemsLoop items=$item.children}
    
	{/foreach}
{/function}

{deleteMenuItemsLoop items=$menu}


{elseif $action eq "addmenu" || $action eq "addmenudivider"}

{* Adding Menu HTML Form *}
<form action="{$modurl}&action=doaddmenuitem" method="post" class="validform formPage" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$menuMain}
        </div>
    </div>
    <div class="col-lg-4">
        <ul class="nav nav-pills" id="tabOptions">
            <li class="active"><a href="#menuOptions">{WHMCMS::__("menuItemCreateOptions")}</a></li>
            <li><a href="#menuCss">{WHMCMS::__("menuItemCreateCss")}</a></li>
        </ul>
        <div class="clearline"></div>
        <div class="tab-content well">
            <div class="tab-pane active" id="menuOptions">{$menuOptions}</div>
            <div class="tab-pane" id="menuCss">
                {if $action eq "addmenu"}
                <div class="elementBox span12">
                    <label for="css_iconclass">{WHMCMS::__("menuItemFormCssIcon")}</label>
                    <div class="input-group">
                        <input type="text" name="css_iconclass" id="css_iconclass" value="" class="form-control" placeholder="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#menuIconModal"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                {/if}
				{$menuCss}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6 col-lg-offset-6">
                <button type="submit" class="btn btn-block btn-info">{WHMCMS::__("menuItemCreateSubmit")}</button>
            </div>
        </div>
    </div>
</div>
<br>

<div class="clear"></div>

{if $action eq "addmenu"}

{* Menu Item Translations *}
<br>
<h4>{WHMCMS::__("menuItemCreateTranslation")}</h4>

<hr>

<div class="row">
    <div class="col-lg-12">
        
        <div class="panel-group" id="translation" role="tablist" aria-multiselectable="true">
            {foreach $translations as $translation}
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="{$translation.language}">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#translation" href="#translate_{$translation.language}" aria-expanded="true" aria-controls="translate_{$translation.language}">
                        {$translation.language|ucfirst}
                        </a>
                    </h4>
                </div>
                <div id="translate_{$translation.language}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{$translation.language}">
                    <div class="panel-body">
                    {$translation.form}
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
        
    </div>
</div>


{/if}

<div class="clear"></div>

{include file="./includes/iconsmodal.tpl"}

</form>

{elseif $action eq "updatemenu" || $action eq "updatemenudivider"}

{* Update Menu Item HTML Form *}
<form action="{$modurl}&action=doupdatemenuitem&menuid={$menuid}" method="post" class="validform formPage" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$menuMain}
        </div>
    </div>
    <div class="col-lg-4">
        <ul class="nav nav-pills" id="tabOptions">
            <li class="active"><a href="#menuOptions">{WHMCMS::__("menuItemUpdateOptions")}</a></li>
            <li><a href="#menuCss">{WHMCMS::__("menuItemUpdateCss")}</a></li>
        </ul>
        <div class="clearline"></div>
        <div class="tab-content well">
            <div class="tab-pane active" id="menuOptions">{$menuOptions}</div>
            <div class="tab-pane" id="menuCss">
				{if $action eq "updatemenu"}
                <div class="elementBox span12">
                    <label for="css_iconclass">{WHMCMS::__("menuItemFormCssIcon")}</label>
                    <div class="input-group">
                        <input type="text" name="css_iconclass" id="css_iconclass" value="{$item.css_iconclass}" class="form-control" placeholder="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#menuIconModal"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                {/if}
				{$menuCss}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="savechanges" class="btn btn-block btn-info">{WHMCMS::__("menuItemUpdateSubmit")}</button>
            </div>
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="saveandreturn" class="btn btn-block btn-primary">{WHMCMS::__("menuItemUpdateSubmitAndReturn")}</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<br>

{if $action eq "updatemenu"}

{* Menu Item Translations *}
<br>
<h4>{WHMCMS::__("menuItemUpdateTranslation")}</h4>

<hr>

<div class="row">
    <div class="col-lg-12">
        
        <div class="panel-group" id="translation" role="tablist" aria-multiselectable="true">
            {foreach $translations as $translation}
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="{$translation.language}">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#translation" href="#translate_{$translation.language}" aria-expanded="true" aria-controls="translate_{$translation.language}">
                        {$translation.language|ucfirst}
                        </a>
                    </h4>
                </div>
                <div id="translate_{$translation.language}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{$translation.language}">
                    <div class="panel-body">
                    {$translation.form}
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
        
    </div>
</div>

<div class="clear"></div>



{/if}

</form>

{include file="./includes/iconsmodal.tpl"}

{/if}


