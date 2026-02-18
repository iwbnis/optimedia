{if $action eq "errorpages"}
{* List Error Pages *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkerrorpage" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="30%" class="text-left">{WHMCMS::__("errorPageTitle")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("errorPageLogRecords")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("errorPageViews")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("errorPageLastVisit")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("errorPageLastModify")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("errorPageTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $errorpages as $page}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$page.code}"></td>
                    <td class="text-left">{$page.title|stripslashes}</td>
                    <td class="text-center"><a href="{$modurl}&action=logerrors&code={$page.code}">{$page.logs|number_format}</a></td>
                    <td class="text-center">{$page.hits|number_format}</td>
                    <td class="text-center">{$page.datelastvisit|stripslashes}</td>
                    <td class="text-center">{$page.datemodify|stripslashes}</td>
                    <td class="text-center">
                        <a href="{$modurl}&action=logerrors&code={$page.code}" class="btn btn-sm btn-info" title="{WHMCMS::__("errorPageBrowseLog")}"><i class="fa fa-folder-open"></i></a>
                        <a href="{$page.viewurl}" target="_blank" class="btn btn-sm btn-default" title="{WHMCMS::__("errorPageBrowseURL")}"><i class="fa fa-eye"></i></a>
                        <a href="{$modurl}&action=updateerrorpage&pageid={$page.pageid}" class="btn btn-sm btn-warning" title="{WHMCMS::__("errorPageUpdateURL")}"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* Page Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("errorPageBulkActions")}</option>
                    <option value="log">{WHMCMS::__("errorPageBulkActionClearLog")}</option>
                    <option value="hits">{WHMCMS::__("errorPageBulkActionResetViews")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("errorPageBulkActionApply")}</button>
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

{elseif $action eq "updateerrorpage"}

{* Update Page HTML Form *}
<form action="{$modurl}&action=doupdateerrorpage&pageid={$pageid}" method="post" class="validform">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$pageMain}
        </div>
    </div>
    <div class="col-lg-4">
        <ul class="nav nav-pills" id="tabOptions">
            <li class="active"><a href="#pageOptions">{WHMCMS::__("errorPageUpdateOptions")}</a></li>
            <li><a href="#pageAdvanced">{WHMCMS::__("errorPageUpdateAdvanced")}</a></li>
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
                <button type="submit" name="savechanges" class="btn btn-block btn-info">{WHMCMS::__("errorPageUpdateButton")}</button>
            </div>
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="saveandreturn" class="btn btn-block btn-primary">{WHMCMS::__("errorPageUpdateSubmitAndReturn")}</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br>

{* Main Page Editor *}
<div>
    {$pageMainEditor}
</div>
<div class="clear"></div>

{* Page Translations *}
<br>
<h4>{WHMCMS::__("errorPageTranslation")}</h4>
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

</form>

{elseif $action eq "logerrors"}

{* List Error Logs *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkerrorlog&code={$code}" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="25%" class="text-left">{WHMCMS::__("errorLogsTargetURL")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("errorLogsIPAddress")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("errorLogsDate")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("errorLogsUserAgent")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("errorLogsTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $logs as $log}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$log.logid}"></td>
                    <td class="text-left">
                        <a href="#logInfo_{$log.logid}" data-toggle="modal" title="{WHMCMS::__("errorLogsClickForInfo")}">{$log.targeturl|stripslashes|truncate:40}</a>
                    </td>
                    <td class="text-center">
                        <a href="http://www.geoiptool.com/en/?IP={$log.ip}" target="_blank">{$log.ip}</a>&nbsp;
                        {if $log.ipbanned eq 0}
                        <a href="#banIP_{$log.logid}" data-toggle="modal" class="btn btn-sm btn-default" title="{WHMCMS::__("errorLogsClickToBan")}"><i class="fa fa-ban color-blue"></i></a>
                        {else}
                        <a href="{$modurl}&action=unbanip&ip={$log.ip}&code={$code}" class="btn" title="{WHMCMS::__("errorLogsClickToUnBan")}"><i class="fa fa-ban color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">{$log.datecreate}</td>
                    <td class="text-center"><input type="text" class="form-control input-sm" value="{$log.useragent|stripslashes}"></td>
                    <td class="text-center">
                        <a href="#logInfo_{$log.logid}" data-toggle="modal" class="btn btn-sm btn-info" title="{WHMCMS::__("errorLogsErrorInfoButton")}"><i class="fa fa-info"></i></a>
                        <a href="{$modurl}&action=deletelogitem&logid={$log.logid}&code={$code}" class="btn btn-sm btn-danger" title="{WHMCMS::__("errorLogsDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="6">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* Log Errors Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8"> 
                <select name="bulkaction" class="validate[required] form-control">
                    <option value="">{WHMCMS::__("errorLogsBulkActions")}</option>
                    <option value="delete">{WHMCMS::__("errorLogsBulkActionDelete")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-info btn-block bulkapply">{WHMCMS::__("errorLogsBulkActionApply")}</button>
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

{* Log Entry Information Box *}
{foreach $logs as $log}
<div id="logInfo_{$log.logid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="logInfoTitle_{$log.logid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletepage&pageid={$log.pageid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="logInfoTitle_{$log.logid}">{WHMCMS::__("errorLogsInfoPageTitle")}</h4>
                </div>
                <div class="modal-body">
                    {$log.loginfo}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("errorLogsInfoPageClose")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}

{* Ban IP Form *}
{foreach $logs as $log}
<div id="banIP_{$log.logid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="banIPTitle_{$log.logid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=banip&logid={$log.logid}&code={$code}" method="post" class="validform">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="banIPTitle_{$log.logid}">{WHMCMS::__("errorLogsBanIPPageTitle")}</h4>
                </div>
                <div class="modal-body">
                    {$log.banipform}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("errorLogsBanIPClose")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("errorLogsBanIPButton")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}

{/if}
