<div class="row">
    <div class="col-lg-10">{$breadcrumbs}</div>
    <div class="col-lg-2">
        <a href="#AddVariable" data-toggle="modal" class="btn btn-sm btn-block btn-primary"><i class="fa fa-plus"></i> New Variable</a>
    </div>
</div>

<div class="clear-line-20"></div>

<ul class="list-group menu-group-list">
    <li class="list-group-item" style="background-color:#f8f8f8;font-weight: bolder;">
        <div class="row" >
            <div class="col-lg-6 text-left">Key</div>
            <div class="col-lg-2 text-center">
                Value
                
            </div>
            <div class="col-lg-2 text-center">
                How to use?
            </div>
            <div class="col-lg-2 text-center">
                Action
            </div>
        </div>
    </li>
    {foreach item=variable from=$variables}
    <li class="list-group-item">
        <div class="row">
            <div class="col-lg-6 text-left">{$variable.key}</div>
            <div class="col-lg-2 text-center">
                <div class="label label-success">{$variable.value}</div>
                
            </div>
            <div class="col-lg-2 text-center">
                {literal}{${/literal}{$variable.key}{literal}}{/literal}
            </div>
            <div class="col-lg-2 text-center">
                <a href="#UpdateVariable_{$variable.id}" data-toggle="modal" class="btn btn-sm btn-warning" title="Update Variable"><i class="fa fa-pencil"></i></a>
                <a href="#DeleteVariable_{$variable.id}" data-toggle="modal" class="btn btn-sm btn-danger" title="Delete Variable"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </li>
    {foreachelse}
    <li class="list-group-item text-center">No Variables Created Yet</li>
    {/foreach}
</ul>

{* variable Delete Modal *}
{foreach item=variable from=$variables}
<div id="DeleteVariable_{$variable.id}" class="modal fade modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{$modurl}&action=deletevariable&id={$variable.id}" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete "{$variable.key}"</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this variable "<b>{$variable.key}</b>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-danger">Delete Variable</button>
            </div>
            </form>
        </div>
    </div>
</div>
{/foreach}

{* Variable Update Modal *}
{foreach item=variable from=$variables}
<div id="UpdateVariable_{$variable.id}" class="modal fade modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{$modurl}&action=updatevariable&id={$variable.id}" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update "{$variable.key}"</h4>
            </div>
            <div class="modal-body">
                <div class="customgeneralfields-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#variablemain_{$variable.id}" aria-controls="variablemain_{$variable.id}" role="tab" data-toggle="tab">General</a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="alert alert-warning">Do not use space or special character in variable name</div>
                        <div role="tabpanel" class="tab-pane active" id="variablemain_{$variable.id}">
                            
                            <div class="form-group">
                                <label for="name_{$variable.id}">Variable Name</label>
                                <input type="text" name="key" id="key_{$variable.id}" value="{$variable.key}" placeholder="Enter Variable Name..." class="form-control" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="value_{$variable.id}">Variable Name</label>
                                <input type="text" name="value" id="value_{$variable.id}" value="{$variable.value}" placeholder="Enter Variable Name..." class="form-control" required>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-warning">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
{/foreach}

{* Variable Create Modal *}
<div id="AddVariable" class="modal fade modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{$modurl}&action=addvariable" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Variable</h4>
            </div>
            <div class="modal-body">
                <div class="customgeneralfields-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#groupmain" aria-controls="groupmain" role="tab" data-toggle="tab">General</a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="alert alert-warning">Do not use space or special character in variable name</div>
                        <div role="tabpanel" class="tab-pane active" id="groupmain">
                            <div class="form-group">
                                <label for="name">Variable Name</label>
                                <input type="text" name="key" id="key" value="" placeholder="Enter Variable Name..." class="form-control" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="name">Value</label>
                                <input type="text" name="value" id="value" value="" placeholder="Enter Variable Value..." class="form-control" required>
                            </div>
                            
                                                    </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary">Add Variable</button>
            </div>
            </form>
        </div>
    </div>
</div>
