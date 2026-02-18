{if $action eq "listpages"}

{* List Pages *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkpage" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="40%" class="text-left">{WHMCMS::__("pagesTableTitle")}</th>
                    <th width="5%" class="text-center">{WHMCMS::__("pagesTableViews")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("pagesTableModified")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("pagesTablePublished")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("pagesTablePrivate")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("pagesTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $pages as $page}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$page.pageid}"></td>
                    <td class="text-left">
					   <div><a href="{$modurl}&action=updatepage&pageid={$page.pageid}">{$page.title|stripslashes}</a></div>
                       {if $page.parent.id > 0}<div><small>&#8627; <a href="{$modurl}&action=updatepage&pageid={$page.parent.id}">{$page.parent.title}</a></small></div>{/if}
                    </td>
                    <td class="text-center">{$page.hits|number_format}</td>
                    <td class="text-center">{$page.datemodify|stripslashes}</td>
                    <td class="text-center">
                        {if $page.enable eq 1}
                            <a href="{$modurl}&action=disablepage&pageid={$page.pageid}" class="btn btn-sm btn-default pages-actions-togglestatus" data-status="published" data-pageid="{$page.pageid}" title="{WHMCMS::__("pagesTablePublishButton")}"><i class="fa fa-fw fa-check color-blue"></i></a>
                        {else}
                            <a href="{$modurl}&action=enablepage&pageid={$page.pageid}" class="btn btn-sm btn-default pages-actions-togglestatus" data-status="unpublished" data-pageid="{$page.pageid}" title="{WHMCMS::__("pagesTableUnPublishButton")}"><i class="fa fa-fw fa-times color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">
                        {if $page.private eq 1}
                            <a href="{$modurl}&action=privatepage&status=0&pageid={$page.pageid}" class="btn btn-sm btn-default pages-actions-toggleaccess" data-status="private" data-pageid="{$page.pageid}" title="{WHMCMS::__("pagesTablePrivateButton")}"><i class="fa fa-fw fa-check color-blue"></i></a>
                        {else}
                            <a href="{$modurl}&action=privatepage&status=1&pageid={$page.pageid}" class="btn btn-sm btn-default pages-actions-toggleaccess" data-status="public" data-pageid="{$page.pageid}" title="{WHMCMS::__("pagesTablePublicButton")}"><i class="fa fa-fw fa-times color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">
                        <a href="{$page.viewurl}" target="_blank" class="btn btn-sm btn-default" title="{WHMCMS::__("pagesTablePreviewButton")}"><i class="fa fa-eye"></i></a>
                        <a href="{$modurl}&action=updatepage&pageid={$page.pageid}" class="btn btn-sm btn-warning" title="{WHMCMS::__("pagesTableUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deletePage_{$page.pageid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("pagesTableDeleteButton")}"><i class="fa fa-trash-o fa-trash"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="7">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* Page Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("pagesActions")}</option>
                    <option value="public">{WHMCMS::__("pagesActionPublic")}</option>
                    <option value="private">{WHMCMS::__("pagesActionPrivate")}</option>
                    <option value="publish">{WHMCMS::__("pagesActionPublish")}</option>
                    <option value="unpublish">{WHMCMS::__("pagesActionUnPublish")}</option>
                    <option value="hits">{WHMCMS::__("pagesActionResetViews")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("pagesActionApply")}</button>
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

{* Delete Page Confirm Box *}
{foreach $pages as $page}
<div id="deletePage_{$page.pageid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deletePageTitle_{$page.pageid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletepage&pageid={$page.pageid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deletePageTitle_{$page.pageid}">{WHMCMS::__("pagesDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("pagesDeleteDescription")} "<b>{$page.title|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("pagesDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("pagesDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}

{elseif $action eq "addpage"}

{* Adding Page HTML Form *}
<form action="{$modurl}&action=doaddpage" method="post" class="validform formPage">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$pageMain}
        </div>
    </div>
    <div class="col-lg-4">
        <ul class="nav nav-pills" id="tabOptions">
            <li class="active"><a href="#pageOptions">{WHMCMS::__("pagesCreateOptions")}</a></li>
            <li><a href="#pageAdvanced">{WHMCMS::__("pagesCreateAdvanced")}</a></li>
        </ul>
        <div class="clearline"></div>
        <div class="well">
            <div class="tab-content">
                <div class="tab-pane active" id="pageOptions">{$pageOptions}</div>
                <div class="tab-pane" id="pageAdvanced">{$pageAdvanced}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6 col-lg-offset-6">
                <button type="submit" class="btn btn-block btn-info btn-large">{WHMCMS::__("pagesCreateSubmit")}</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br><br>

{* Main Page Editor *}
<div>
    {$pageEditor}
</div>

<div class="clear"></div>

{* Page Translations *}
<br>
<h4>{WHMCMS::__("pagesCreateTranslation")}</h4>

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

</form>

{elseif $action eq "updatepage"}

{* Update Page HTML Form *}
<form action="{$modurl}&action=doupdatepage&pageid={$pageid}" method="post" class="validform">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$pageMain}
        </div>
    </div>
    <div class="col-lg-4">
        <ul class="nav nav-pills" id="tabOptions">
            <li class="active"><a href="#pageOptions">{WHMCMS::__("pagesUpdateOptions")}</a></li>
            <li><a href="#pageAdvanced">{WHMCMS::__("pagesUpdateAdvanced")}</a></li>
        </ul>
        <div class="clearline"></div>
        <div class="well">
            <div class="tab-content">
                <div class="tab-pane active" id="pageOptions">{$pageOptions}</div>
                <div class="tab-pane" id="pageAdvanced">{$pageAdvanced}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="savechanges" class="btn btn-block btn-info">{WHMCMS::__("pagesUpdateSubmit")}</button>
            </div>
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="saveandreturn" class="btn btn-block btn-primary">{WHMCMS::__("pagesUpdateSubmitAndReturn")}</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br><br>

{* Main Page Editor *}
<div>
    {$pageEditor}
</div>
<div class="clear"></div>

{* Page Translations *}
<br>
<h4>{WHMCMS::__("pagesUpdateTranslation")}</h4>
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

</form>

{/if}
