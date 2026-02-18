{if $action eq "portfolio"}

{* List Portfolio Categories *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkcategory" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="50%" class="text-left">{WHMCMS::__("portfolioTableTitle")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("portfolioTableProjects")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("portfolioTablePublished")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("portfolioTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $categories as $category}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$category.categoryid}"></td>
                    <td class="text-left">{$category.title|stripslashes}</td>
                    <td class="text-center"><a href="{$modurl}&action=listprojects&categoryid={$category.categoryid}">{$category.projects|number_format}</a></td>
                    <td class="text-center">
                        {if $category.enable eq 1}
                            <a href="{$modurl}&action=disablecategory&categoryid={$category.categoryid}" class="btn btn-sm btn-default category-actions-togglestatus" data-categoryid="{$category.categoryid}" data-status="published" title="{WHMCMS::__("portfolioTablePublish")}"><i class="fa fa-check color-blue"></i></a>
                        {else}
                            <a href="{$modurl}&action=enablecategory&categoryid={$category.categoryid}" class="btn btn-sm btn-default category-actions-togglestatus" data-categoryid="{$category.categoryid}" data-status="unpublished" title="{WHMCMS::__("portfolioTableUnPublish")}"><i class="fa fa-times color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">
                        <a href="{$modurl}&action=listprojects&categoryid={$category.categoryid}" class="btn btn-sm btn-info" title="{WHMCMS::__("portfolioListProjects")}"><i class="fa fa-folder-open"></i></a>
                        <a href="{$category.viewurl}" target="_blank" class="btn btn-sm btn-default" title="{WHMCMS::__("portfolioPreviewButton")}"><i class="fa fa-eye"></i></a>
                        <a href="#updateCategory_{$category.categoryid}" data-toggle="modal" class="btn btn-sm btn-warning" title="{WHMCMS::__("portfolioUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deleteCategory_{$category.categoryid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("portfolioDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="5">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* Category Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("portfolioActions")}</option>
                    <option value="publish">{WHMCMS::__("portfolioActionPublish")}</option>
                    <option value="unpublish">{WHMCMS::__("portfolioActionUnPublish")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-info btn-block bulkapply">{WHMCMS::__("portfolioActionApply")}</button>
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
<div id="deleteCategory_{$category.categoryid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletecategory&categoryid={$category.categoryid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("portfolioDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("portfolioDeleteDescription")} "<b>{$category.title|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("portfolioDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("portfolioDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{* Adding Category Modal *}
<div id="addCategory" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doaddcategory" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("portfolioCreatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#addcategory_overview" aria-controls="addcategory_overview" role="tab" data-toggle="tab">{WHMCMS::__("portfolioCategoryCreateOverview")}</a></li>
                        <li role="presentation"><a href="#addcategory_translations" aria-controls="addcategory_translations" role="tab" data-toggle="tab">{WHMCMS::__("portfolioCategoryCreateTranslations")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="addcategory_overview">
                            {$categoryMain}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="addcategory_translations">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("portfolioCreateCancel")}</button>
                    <button type="submit" class="btn btn-info">{WHMCMS::__("portfolioCreateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>


{* Update Category Modal *}
{foreach $categories as $category}
<div id="updateCategory_{$category.categoryid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doupdatecategory&categoryid={$category.categoryid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("portfolioUpdatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#editcategory_overview_{$category.categoryid}" aria-controls="addcategory_overview" role="tab" data-toggle="tab">{WHMCMS::__("portfolioCategoryCreateOverview")}</a></li>
                        <li role="presentation"><a href="#editcategory_translations_{$category.categoryid}" aria-controls="addcategory_translations" role="tab" data-toggle="tab">{WHMCMS::__("portfolioCategoryCreateTranslations")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="editcategory_overview_{$category.categoryid}">
                            {$category.categoryMain}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="editcategory_translations_{$category.categoryid}">
                            <div class="panel-group" id="translation" role="tablist" aria-multiselectable="true">
								{foreach $category.translations as $translation}
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="{$translation.language}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#translation" href="#translate_{$translation.formid}" aria-expanded="true" aria-controls="translate_{$translation.language}">
                                    		{$translation.language|ucfirst}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="translate_{$translation.formid}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{$translation.language}">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("portfolioUpdateCancel")}</button>
                    <button type="submit" class="btn btn-info">{WHMCMS::__("portfolioUpdateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{****************************
* Portfolio Projects
*****************************}
{elseif $action eq "listprojects"}

<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkproject" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="30%" class="text-left">{WHMCMS::__("projectsTableTitle")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("projectsTableViews")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("projectsTablePhotos")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("projectsTableModified")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("projectsTablePublished")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("projectsTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $projects as $project}
                <tr>
                    <td><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$project.projectid}"></td>
                    <td class="text-left">{$project.title|stripslashes}</td>
                    <td class="text-center">{$project.hits|number_format}</td>
                    <td class="text-center"><a href="{$modurl}&action=listphotos&projectid={$project.projectid}" title="{WHMCMS::__("projectsPhotosButton")}">{$project.photos|number_format}</a></td>
                    <td class="text-center">{$project.datemodify|stripslashes}</td>
                    <td class="text-center">
                        {if $project.enable eq 1}
                            <a href="{$modurl}&action=disableproject&projectid={$project.projectid}" class="btn btn-sm btn-default project-actions-togglestatus" data-projectid="{$project.projectid}" data-status="published" title="{WHMCMS::__("projectsPublishButton")}"><i class="fa fa-check color-blue"></i></a>
                        {else}
                            <a href="{$modurl}&action=enableproject&projectid={$project.projectid}" class="btn btn-sm btn-default project-actions-togglestatus" data-projectid="{$project.projectid}" data-status="unpublished" title="{WHMCMS::__("projectsUnPublishButton")}"><i class="fa fa-times color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">
                        <a href="{$modurl}&action=listphotos&projectid={$project.projectid}" class="btn btn-sm btn-info" title="{WHMCMS::__("projectsPhotosButton")}"><i class="fa fa-images fa-picture-o"></i></a>
                        <a href="{$project.viewurl}" target="_blank" class="btn btn-sm btn-default" title="{WHMCMS::__("projectsPreviewURL")}"><i class="fa fa-eye"></i></a>
                        <a href="{$modurl}&action=updateproject&projectid={$project.projectid}" class="btn btn-sm btn-warning" title="{WHMCMS::__("projectsUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deleteProject_{$project.projectid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("projectsDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="7">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>

        {* Project Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("projectsActions")}</option>
                    <option value="publish">{WHMCMS::__("projectsActionPublish")}</option>
                    <option value="unpublish">{WHMCMS::__("projectsActionUnPublish")}</option>
                    <option value="hits">{WHMCMS::__("projectsActionResetViews")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("projectsActionApply")}</button>
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


{* Delete Project Confirm Box *}
{foreach $projects as $project}
<div id="deleteProject_{$project.projectid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeleteproject&projectid={$project.projectid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("projectsDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("projectsDeleteDescription")} "<b>{$project.title|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("projectsDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("projectsDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}


{elseif $action === "addproject"}

{* Adding Project HTML Form *}
<form action="{$modurl}&action=doaddproject" method="post" class="validform formPage" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$projectMain}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="well">
            <div class="tab-pane active" id="projectOptions">{$projectOptions}</div>
        </div>
        <div>
            <button type="submit" class="btn btn-info span5 btn-sm">{WHMCMS::__("projectsCreateSubmit")}</button>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br>

<div>
	{$projectMainEditor}
</div>

<div class="clear"></div>

{* Project Translations *}
<br>
<h4>{WHMCMS::__("projectsCreateTranslations")}</h4>
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

{elseif $action eq "updateproject"}

{* Update Project HTML Form *}
<form action="{$modurl}&action=doupdateproject&projectid={$projectid}" method="post" class="validform formPage" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-8">
        <div>
            {$projectMain}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="well">
			{$projectOptions}
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="savechanges" class="btn btn-block btn-info">{WHMCMS::__("projectsUpdateSubmit")}</button>
            </div>
            <div class="col-xs-12 col-lg-6">
                <button type="submit" name="saveandreturn" class="btn btn-block btn-primary">{WHMCMS::__("projectUpdateSubmitAndReturn")}</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<br>

<div>
{$projectMainEditor}
</div>

<div class="clear"></div>

{* Project Translations *}
<br>
<h4>{WHMCMS::__("projectsUpdateTranslations")}</h4>
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


{****************************
* List Project Photos
*****************************}
{elseif $action eq "listphotos"}

{* List Project Photos *}
<div class="row">
    <div class="col-lg-12">
        <form action="{$modurl}&action=bulkphotos&projectid={$projectid}" method="post" class="bulkform validform">
        <table class="table table-hover table-striped table-vertical-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center cb"><input type="checkbox" id="bulkcheckbox"></th>
                    <th width="25%" class="text-left">{WHMCMS::__("photosTableTitle")}</th>
                    <th width="25%" class="text-left">{WHMCMS::__("photosTableProject")}</th>
                    <th width="20%" class="text-center">{WHMCMS::__("photosTableModified")}</th>
                    <th width="10%" class="text-center">{WHMCMS::__("photosTablePublished")}</th>
                    <th width="15%" class="text-center">{WHMCMS::__("photosTableTools")}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $photos as $photo}
                <tr>
                    <td class="text-center"><input type="checkbox" class="bulkcheckbox" name="bulkcheckbox[]" value="{$photo.photoid}"></td>
                    <td class="text-left">{$photo.title|stripslashes}</td>
                    <td class="text-left"><a href="{$modurl}&action=listprojects&projectid={$photo.parentid}">{$photo.project|stripslashes}</a></td>
                    <td class="text-center">{$photo.datemodify}</td>
                    <td class="text-center">
                        {if $photo.enable eq 1}
                            <a href="{$modurl}&action=disablephoto&photoid={$photo.photoid}&projectid={$photo.parentid}" class="btn btn-sm btn-default photo-actions-togglestatus" data-projectid="{$photo.projectid}" data-photoid="{$photo.photoid}" data-status="published" title="{WHMCMS::__("photosTablePublish")}"><i class="fa fa-check color-blue"></i></a>
                        {else}
                            <a href="{$modurl}&action=enablephoto&photoid={$photo.photoid}&projectid={$photo.parentid}" class="btn btn-sm btn-default photo-actions-togglestatus" data-projectid="{$photo.projectid}" data-photoid="{$photo.photoid}" data-status="unpublished" title="{WHMCMS::__("photosTableUnPublish")}"><i class="fa fa-times color-red"></i></a>
                        {/if}
                    </td>
                    <td class="text-center">
                        <a href="{$photo.viewurl}" class="btn btn-sm btn-default" target="_blank" title="{WHMCMS::__("photosPreviewButton")}"><i class="fa fa-eye"></i></a>
                        <a href="#updatePhoto_{$photo.photoid}" data-toggle="modal" class="btn btn-sm btn-warning" title="{WHMCMS::__("photosUpdateButton")}"><i class="fa fa-pencil"></i></a>
                        <a href="#deletePhoto_{$photo.photoid}" data-toggle="modal" class="btn btn-sm btn-danger" title="{WHMCMS::__("photosDeleteButton")}"><i class="fa fa-trash fa-trash-o"></i></a>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="6">{WHMCMS::__("tableNoData")}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        
        {* Photo Bulk Actions *}
        <div class="row">
            <div class="col-lg-2 col-lg-offset-8">
                <select name="bulkaction" class="validate[required] form-control input-sm">
                    <option value="">{WHMCMS::__("photosActions")}</option>
                    <option value="publish">{WHMCMS::__("photosActionPublish")}</option>
                    <option value="unpublish">{WHMCMS::__("photosActionUnPublish")}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-sm btn-info btn-block bulkapply">{WHMCMS::__("photosActionApply")}</button>
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

{* Delete Photo Confirm Box *}
{foreach $photos as $photo}
<div id="deletePhoto_{$photo.photoid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=dodeletephoto&photoid={$photo.photoid}&projectid={$photo.parentid}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("photosDeletePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <p>{WHMCMS::__("photosDeleteDescription")} "<b>{$photo.title|stripslashes}</b>".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("photosDeleteCancel")}</button>
                    <button type="submit" class="btn btn-danger">{WHMCMS::__("photosDeleteSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}

{* Adding Photo Modal *}
<div id="addPhoto" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doaddphoto&projectid={$projectid}" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("photosCreatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#addphoto_overview" aria-controls="addphoto_overview" role="tab" data-toggle="tab">{WHMCMS::__("photoCreateOverview")}</a></li>
                        <li role="presentation"><a href="#addphoto_translations" aria-controls="addphoto_translations" role="tab" data-toggle="tab">{WHMCMS::__("photosCreateTranslations")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="addphoto_overview">
                            {$photoMain}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="addphoto_translations">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("photosCreateCancel")}</button>
                    <button type="submit" class="btn btn-primary">{WHMCMS::__("photosCreateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>

{* Update Photo Modal *}
{foreach $photos as $photo}
<div id="updatePhoto_{$photo.photoid}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{$modurl}&action=doupdatephoto&photoid={$photo.photoid}&projectid={$projectid}" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{WHMCMS::__("photosUpdatePageTitle")}</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#editphoto_overview_{$photo.photoid}" aria-controls="editphoto_overview_{$photo.photoid}" role="tab" data-toggle="tab">{WHMCMS::__("photoCreateOverview")}</a></li>
                        <li role="presentation"><a href="#editphoto_translations_{$photo.photoid}" aria-controls="editphoto_translations_{$photo.photoid}" role="tab" data-toggle="tab">{WHMCMS::__("photosCreateTranslations")}</a></li>
                    </ul>
                    <div class="clearline"></div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="editphoto_overview_{$photo.photoid}">
                    		{$photo.photoMain}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="editphoto_translations_{$photo.photoid}">
                            <div class="panel-group" id="translation" role="tablist" aria-multiselectable="true">
                        		{foreach $photo.translations as $translation}
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="{$translation.language}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#translation" href="#translate_{$translation.formid}" aria-expanded="true" aria-controls="translate_{$translation.language}">
                                    			{$translation.language|ucfirst}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="translate_{$translation.formid}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{$translation.language}">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">{WHMCMS::__("photosUpdateCancel")}</button>
                    <button type="submit" class="btn btn-primary">{WHMCMS::__("photosUpdateSubmit")}</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/foreach}

{/if}
