{if $action eq "faq"}

{* List FAQ Groups *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkgroup" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb">
                        <input type="checkbox" id="bulkcheckbox">
                    </th>
                    <th width="55%" class="text-left">{WHMCMS::__("faqTableGroupTitle")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("faqTableQuestions")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("faqTableViews")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("faqTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $groups as $group}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$group.groupid}"></td>
                    <td class="text-left">{$group.title|stripslashes}</td>
                    <td class="text-center"><a href="{$modurl}&action=listfaq&groupid={$group.groupid}">{$group.questions|number_format}</a></td>
                    <td class="text-center">{$group.hits|number_format}</td>
                    <td class="text-center">
                        <a href="{$modurl}&action=listfaq&groupid={$group.groupid}" class="btn btn-sm btn-info" title="{WHMCMS::__("faqTableListQuestions")}"><i class="fa fa-folder-open"></i></a>
                        <a href="{$group.viewurl}" target="_blank" class="btn btn-sm btn-default" title="{WHMCMS::__("faqTableBrowseURL")}"><i class="fa fa-eye"></i></a>
                        <a href="#updateGroup_{$group.groupid}" data-toggle="modal" class="btn btn-sm btn-warning" title="{WHMCMS::__("faqTableUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deleteGroup_{$group.groupid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("faqTableDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
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
                    <option value="">{WHMCMS::__("faqTableActions")}</option>
                    <option value="delete">{WHMCMS::__("faqTableActionDelete")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("faqTableActionsApply")}</button>
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


{* Delete Group Confirm Box *}
{foreach $groups as $group}
<div id="deleteGroup_{$group.groupid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteGroupTitle_{$group.groupid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletegroup&groupid={$group.groupid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteGroupTitle_{$group.groupid}">{WHMCMS::__("faqDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("faqDeleteDescription")} "<b>{$group.title|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("faqDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("faqDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{* Adding Group Modal *}
<div id="addGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addGroupTitle">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doaddgroup" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addGroupTitle">{WHMCMS::__("faqCreatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#addfaqgroup_overview" aria-controls="addfaqgroup_overview" role="tab" data-toggle="tab">{WHMCMS::__("faqCreateOverview")}</a></li>
                        <li role="presentation"><a href="#addfaqgroup_translations" aria-controls="addfaqgroup_translations" role="tab" data-toggle="tab">{WHMCMS::__("faqCreateTranslations")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="addfaqgroup_overview">
                            {$faqGroupMain}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="addfaqgroup_translations">
                            <div class="panel-group" id="accordion_addfaqgroup_translations" role="tablist" aria-multiselectable="true">
								{foreach $translations as $translation}
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="addGroupTitle_{$translation.language}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion_addfaqgroup_translations" href="#translate_{$translation.language}" aria-expanded="true" aria-controls="">
											{$translation.language|ucfirst}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="translate_{$translation.language}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="addGroupTitle_{$translation.language}">
                                        <div class="panel-body">
                                    	{$translation.form}
                                        </div>
                                    </div>
                                </div>
								{/foreach}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("faqCreateCancel")}</button>
                    <button type="submit" class="btn btn-primary">{WHMCMS::__("faqCreateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>


{* Update Group Modal *}
{foreach $groups as $group}
<div id="updateGroup_{$group.groupid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doupdategroup&groupid={$group.groupid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("faqUpdatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#editfaqgroup_overview_{$group.groupid}" aria-controls="editfaqgroup_overview_{$group.groupid}" role="tab" data-toggle="tab">{WHMCMS::__("faqCreateOverview")}</a></li>
                        <li role="presentation"><a href="#editfaqgroup_translations_{$group.groupid}" aria-controls="editfaqgroup_translations_{$group.groupid}" role="tab" data-toggle="tab">{WHMCMS::__("faqCreateTranslations")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="editfaqgroup_overview_{$group.groupid}">
                    		{$group.groupMain}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="editfaqgroup_translations_{$group.groupid}">
                            <div class="panel-group" id="accordion_editfaqgroup_translations_{$group.groupid}" role="tablist" aria-multiselectable="true">
								{foreach $group.translations as $translation}
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion_editfaqgroup_translations_{$group.groupid}" href="#translate_{$translation.formid}" aria-expanded="true">
												{$translation.language|ucfirst}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="translate_{$translation.formid}" class="panel-collapse collapse" role="tabpanel">
                                        <div class="panel-body">
                                    	{$translation.form}
                                        </div>
                                    </div>
                                </div>
								{/foreach}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("faqUpdateCancel")}</button>
                    <button type="submit" class="btn btn-primary">{WHMCMS::__("faqUpdateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{****************************
* FAQ Items
*****************************}
{elseif $action eq "listfaq"}

<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkfaq&groupid={$groupid}" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="55%" class="text-left">{WHMCMS::__("faqItemTableQuestion")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("faqItemTableModified")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("faqItemTablePublished")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("faqItemTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $items as $item}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$item.faqid}"></td>
                    <td class="text-left">{$item.question|stripslashes}</td>
                    <td class="text-center">{$item.datemodify|stripslashes}</td>
                    <td class="text-center">
                        {if $item.enable eq 1}
                            <a href="{$modurl}&action=disablefaq&faqid={$item.faqid}&groupid={$item.groupid}" class="btn btn-sm btn-default faq-actions-togglestatus" data-status="published" data-faqid="{$item.faqid}" title="{WHMCMS::__("faqItemTablePublishButton")}"><i class="fa fa-fw fa-check color-blue"></i></a>
                        {else}
                            <a href="{$modurl}&action=enablefaq&faqid={$item.faqid}&groupid={$item.groupid}" class="btn btn-sm btn-default faq-actions-togglestatus" data-status="unpublished" data-faqid="{$item.faqid}" title="{WHMCMS::__("faqItemTableUnPublishButton")}"><i class="fa fa-fw fa-times color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">
                        <a href="{$modurl}&action=updatefaq&faqid={$item.faqid}" class="btn btn-sm btn-warning" title="{WHMCMS::__("faqItemTableUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deleteFaq_{$item.faqid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("faqItemTableDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="5">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* FAQ Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("faqItemTableActions")}</option>
                    <option value="publish">{WHMCMS::__("faqItemTableActionPublish")}</option>
                    <option value="unpublish">{WHMCMS::__("faqItemTableActionUnPublish")}</option>
                    <option value="delete">{WHMCMS::__("faqItemTableActionDelete")}</option>
                </select>
            </div>
            <div class="col-lg-2">
            <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("faqItemTableActionApply")}</button>
        </div>
        
        <div class="clear"></div>
        
        </form>
    </div>
</div>


{* Pagination *}
<nav>
    {$pagination.HTML}
</nav>

{* Delete FAQ Confirm Box *}
{foreach $items as $item}
<div id="deleteFaq_{$item.faqid}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteFaqTitle_{$item.faqid}">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletefaq&faqid={$item.faqid}&groupid={$item.groupid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteFaqTitle_{$item.faqid}">{WHMCMS::__("faqItemDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("faqItemDeleteDescription")} "<b>{$item.question|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("faqItemDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("faqItemDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{elseif $action eq "addfaq"}


{* Adding FAQ HTML Form *}
<form action="{$modurl}&action=doaddfaq" method="post" class="validform formPage" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$faqMain}
        </div>
    </div>
    <div class="col-lg-4">
		<div class="well">
			{$faqOptions}
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6 col-lg-offset-6">
                <button type="submit" class="btn btn-info btn-block btn-large">{WHMCMS::__("faqItemCreateSubmit")}</button>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br>

<div class="row">
    <div class="col-lg-12">
        {$faqMainEditor}
    </div>
</div>

{* Question Translations *}
<br>
<h4>{WHMCMS::__("faqItemCreateTranslations")}</h4>

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

{elseif $action eq "updatefaq"}

{* Update Question HTML Form *}
<form action="{$modurl}&action=doupdatefaq&faqid={$faqid}" method="post" class="validform formPage" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$faqMain}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="well">
			{$faqOptions}
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="savechanges" class="btn btn-block btn-info">{WHMCMS::__("faqItemUpdateSubmit")}</button>
            </div>
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="saveandreturn" class="btn btn-block btn-primary">{WHMCMS::__("faqUpdateSubmitAndReturn")}</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br>


<div class="row">
    <div class="col-lg-12">
        {$faqMainEditor}
    </div>
</div>


{* Question Translations *}
<br>
<h4>{WHMCMS::__("faqItemUpdateTranslations")}</h4>

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
