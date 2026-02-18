{**********************************************************************
* PopupModule product developed. (2015-11-16)
* *
*
*  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
*  CONTACT                        ->       contact@modulesgarden.com
*
*
* This software is furnished under a license and may be used and copied
* only  in  accordance  with  the  terms  of such  license and with the
* inclusion of the above copyright notice.  This software  or any other
* copies thereof may not be provided or otherwise made available to any
* other person.  No title to and  ownership of the  software is  hereby
* transferred.
*
*
**********************************************************************}

{**
* @author Marcin Domanski <marcin.do@modulesgarden.com>
*}
    <div class="row">
        <div class="col-lg-12" id="mg-home-content" >
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{$MGLANG->T('Popup List')}</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#active" aria-controls="active" role="tab" data-toggle="tab">
                                    {$MGLANG->T('Active')}
                                    <span id="actived" class="badge badge-info">
                                        {if isset($recordsTotalActive)} {$recordsTotalActive} {else} 0 {/if}
                                    </span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#inactive" aria-controls="inactive" role="tab" data-toggle="tab">
                                    {$MGLANG->T('Inactive')} 
                                    <span id="inactived" class="badge badge-info">
                                        {if isset($recordsTotalInactive)} {$recordsTotalInactive} {else} 0 {/if }
                                    </span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#archive" aria-controls="archive" role="tab" data-toggle="tab">
                                    {$MGLANG->T('Archive')} 
                                    <span id="archived" class="badge badge-info">
                                        {if isset($recordsTotalArchive)} {$recordsTotalArchive} {else} 0 {/if }
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="active">
                                <table class="table table-hover" id="mg-data-activeList" >
                                    <thead>
                                        <tr>
                                            <th style="min-width: 15px; padding-bottom: 4px;"><input id='slesct-mass-action-rekords-active' type="checkbox"></th>
                                            <th style="min-width: 20px;">{$MGLANG->T('ID')}</th>
                                            <th style="width: 30%">{$MGLANG->T('Title')}</th>
                                            <th style="width: 25%">{$MGLANG->T('Page restriction')}</th>
                                            <th>{$MGLANG->T('Delay')}</th>
                                            <th>{$MGLANG->T('Views')}</th>
                                            <th>{$MGLANG->T('Start')}</th>
                                            <th>{$MGLANG->T('End')}</th>
                                            <th style="width: 170px; text-align: center;">{$MGLANG->T('Actions')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody> 
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="inactive">
                                <table class="table table-hover" id="mg-data-inactiveList" >
                                    <thead>
                                        <tr>
                                            <th style="min-width: 15px; padding-bottom: 4px;"><input id='slesct-mass-action-rekords-inactive' type="checkbox"></th>
                                            <th style="min-width: 20px;">{$MGLANG->T('ID')}</th>
                                            <th style="width: 30%">{$MGLANG->T('Title')}</th>
                                            <th style="width: 25%">{$MGLANG->T('Page restriction')}</th>
                                            <th>{$MGLANG->T('Delay')}</th>
                                            <th>{$MGLANG->T('Views')}</th>
                                            <th>{$MGLANG->T('Start')}</th>
                                            <th>{$MGLANG->T('End')}</th>
                                            <th style="width: 170px; text-align: center;">{$MGLANG->T('Actions')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody> 
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="archive">
                                <table class="table table-hover" id="mg-data-archiveList" >
                                    <thead>
                                        <tr>
                                            <th style="min-width: 15px; padding-bottom: 4px;"><input id='slesct-mass-action-rekords-archive' type="checkbox"></th>
                                            <th style="min-width: 20px;">{$MGLANG->T('ID')}</th>
                                            <th style="width: 30%">{$MGLANG->T('Title')}</th>
                                            <th style="width: 25%">{$MGLANG->T('Page restriction')}</th>
                                            <th>{$MGLANG->T('Delay')}</th>
                                            <th>{$MGLANG->T('Views')}</th>
                                            <th>{$MGLANG->T('Start')}</th>
                                            <th>{$MGLANG->T('End')}</th>
                                            <th style="width: 170px; text-align: center;">{$MGLANG->T('Actions')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody> 
                                </table>
                            </div>
                        </div>
                    </div>
                    {*Modal mg-modal-new-entity*}
                    {$createForm}
                    {*Modal mg-modal-edit-entity*}
                    {$editForm}
                    {$archiveModal}
                    {$activeModal}
                    {$inactiveModal}
                    {$deleteModal}
                    {$massActiveModal}
                    {$massInactiveModal}
                    {$massArchiveModal}
                    {$massDeleteModal}
                </div>
            </div>
            <div class="well">
                <button class="btn btn-success btn-inverse" type="button" data-toggle="modal" data-target="#mg-modal-add-new">               
                    {$MGLANG->T('Add New Popup')}
                </button>
                <button id="mass-action-button-active" class="btn btn-primary btn-inverse" type="button" data-toggle="tooltip" data-modal-id="mg-modal-mass-active-entity" data-modal-target="" disabled="" style="display: none;">               
                    {$MGLANG->T('Active Popups')}
                </button>
                <button id="mass-action-button-inactive" class="btn btn-primary btn-inverse" type="button" data-toggle="tooltip" data-modal-id="mg-modal-mass-inactive-entity" data-modal-target="" disabled="">               
                    {$MGLANG->T('Inactive Popups')}
                </button>
                <button id="mass-action-button-archive" class="btn btn-warning btn-inverse" type="button" data-toggle="tooltip" data-modal-id="mg-modal-mass-archive-entity" data-modal-target="" disabled="">               
                    {$MGLANG->T('Archive Popups')}
                </button>
                <button id="mass-action-button-delete" class="btn btn-danger btn-inverse" type="button" data-toggle="tooltip" data-modal-id="mg-modal-mass-delete-entity" data-modal-target="" disabled="">               
                    {$MGLANG->T('Delete Popups')}
                </button>
            </div>
        </div>
    </div>
{literal}
    <script type="text/javascript">
        var mgDataTableActive;
        var mgDataTableInactive;
        var mgDataTableArchive;
        var massActionIds = {
                    'active'  : [],
                    'inactive': [],
                    'archive' : []
                };
        function resetMassActionIds() {
            jQuery('#slesct-mass-action-rekords-active').prop('checked',false);
            jQuery('#slesct-mass-action-rekords-inactive').prop('checked',false);
            jQuery('#slesct-mass-action-rekords-archive').prop('checked',false);
            massActionIds = {
                    'active'  : [],
                    'inactive': [],
                    'archive' : []
                };
        }        
        
        var massActionTabs = {
                    'active'  : true,
                    'inactive': false,
                    'archive' : false
                };
        function resetMassActionTabs() {
            massActionTabs = {
                    'active'  : false,
                    'inactive': false,
                    'archive' : false
                };
        }
        
        
        jQuery(document).ready(function () {
                mgDataTableActive = $('#mg-data-activeList').DataTable({
                    processing: false,
                    searching: true,
                    autoWidth: false,
                    serverSide: false,
                    order: [[1, "desc"]],
                    ajax: function (data, callback, settings) {
                        var filter = {};
                        JSONParser.request('activeList', {
                            filter: filter,
                            limit: data.length,
                            offset: data.start,
                            order: data.order,
                            search: data.search
                        }
                        , function (dataBack) {
                            settings.json = dataBack;
                            pages = Math.ceil( dataBack.recordsTotal / settings._iDisplayLength );
                            if (settings._iDisplayLength * pages <= settings._iDisplayStart ) {
                                settings._iDisplayStart = 0;
                            }
                            callback(dataBack);
                        });
                    },
                    columns: [{orderable: false}, null, null, null, null, null, null, null, {orderable: false}],
                    aoColumnDefs: [{
                            'bSortable': false,
                            'aTargets': ['nosort']
                        }],
                    language: {
                        "zeroRecords": "{/literal}{$MGLANG->T('Nothing to display')}{literal}",
                        "infoEmpty": "",
                        "search": "{/literal}{$MGLANG->T('search')}{literal}",
                        "paginate": {
                            "previous": "{/literal}{$MGLANG->T('previous')}{literal}"
                            , "next": "{/literal}{$MGLANG->T('next')}{literal}"
                        }
                    }
                });
                mgDataTableInactive = $('#mg-data-inactiveList').DataTable({
                    processing: false,
                    searching: true,
                    autoWidth: false,
                    serverSide: false,
                    order: [[1, "desc"]],
                    ajax: function (data, callback, settings) {
                        var filter = {};
                        JSONParser.request('inactiveList', {
                            filter: filter,
                            limit: data.length,
                            offset: data.start,
                            order: data.order,
                            search: data.search
                        }
                        , function (dataBack) {
                            settings.json = dataBack;
                            pages = Math.ceil( dataBack.recordsTotal / settings._iDisplayLength );
                            if (settings._iDisplayLength * pages <= settings._iDisplayStart ) {
                                settings._iDisplayStart = 0;
                            }
                            callback(dataBack);
                        });
                    },
                    columns: [{orderable: false}, null, null, null, null, null, null, null, {orderable: false}],
                    aoColumnDefs: [{
                            'bSortable': false,
                            'aTargets': ['nosort']
                        }],
                    language: {
                        "zeroRecords": "{/literal}{$MGLANG->T('Nothing to display')}{literal}",
                        "infoEmpty": "",
                        "search": "{/literal}{$MGLANG->T('search')}{literal}",
                        "paginate": {
                            "previous": "{/literal}{$MGLANG->T('previous')}{literal}"
                            , "next": "{/literal}{$MGLANG->T('next')}{literal}"
                        }
                    }
                });
                mgDataTableArchive = $('#mg-data-archiveList').DataTable({
                    processing: false,
                    searching: true,
                    autoWidth: false,
                    serverSide: false,
                    order: [[1, "desc"]],
                    ajax: function (data, callback, settings) {
                        var filter = {};
                        JSONParser.request('archiveList', {
                            filter: filter,
                            limit: data.length,
                            offset: data.start,
                            order: data.order,
                            search: data.search
                        }
                        , function (dataBack) {
                            settings.json = dataBack;
                            pages = Math.ceil( dataBack.recordsTotal / settings._iDisplayLength );
                            if (settings._iDisplayLength * pages <= settings._iDisplayStart ) {
                                settings._iDisplayStart = 0;
                            }
                            callback(dataBack);
                        });
                    },
                    columns: [{orderable: false}, null, null, null, null, null, null, null, {orderable: false}],
                    aoColumnDefs: [{
                            'bSortable': false,
                            'aTargets': ['nosort']
                        }],
                    language: {
                        "zeroRecords": "{/literal}{$MGLANG->T('Nothing to display')}{literal}",
                        "infoEmpty": "",
                        "search": "{/literal}{$MGLANG->T('search')}{literal}",
                        "paginate": {
                            "previous": "{/literal}{$MGLANG->T('previous')}{literal}"
                            , "next": "{/literal}{$MGLANG->T('next')}{literal}"
                        }
                    }
                });
                $('.dataTables_length select').on('change', function(){
                    $(this).parents('div.tab-content').find('table').DataTable().ajax.reload();
                });
                $('#mg-home-content').MGModalActions();
                
                $('.modal-tabed').on('show.bs.modal', function (e) {
                    $('#mg-popup-form').trigger('reset');
                    $(this).find('.modal-alerts').alerts('clear');
                    $(this).find('.nav-tabs li').removeClass();
                    $(this).find('li').first().addClass('active');
                    $(this).find('.tab-content div').removeClass('active');
                    $('#general-tab, #general-tab-edit').addClass('active');
                    $('#MGAlerts').alerts('clear');
                });
                $('#mg-modal-delete-entity, #mg-modal-archive-entity, #mg-modal-active-entity, #mg-modal-inactive-entity, #mg-modal-edit-entity, #mg-modal-add-new, #mg-modal-mass-active-entity, #mg-modal-mass-inactive-entity, #mg-modal-mass-archive-entity, #mg-modal-mass-delete-entity').on('hidden.bs.modal', function (e) {
                    mgDataTableActive.ajax.reload(function (json) {
                        $('#actived').text(json.recordsTotal);
                    }, false);
                    mgDataTableInactive.ajax.reload(function (json) {
                        $('#inactived').text(json.recordsTotal);
                    }, false);
                    mgDataTableArchive.ajax.reload(function (json) {
                        $('#archived').text(json.recordsTotal);
                    }, false);
                    resetMassActionIds();
                    disabledAllMassActionButton();
                });
                
                $('#slesct-mass-action-rekords-active, #slesct-mass-action-rekords-inactive, #slesct-mass-action-rekords-archive').on('click', function (e) {
                    var arg = $(this).is( ":checked" )?true:false;
                    var prefix = $(this).attr('id').replace('slesct-mass-action-rekords-','');
                    var elements = $(this).parent().parent().parent().parent().children().last().find('input[type="checkbox"]');
                    if (elements.length > 0) {
                        $.each(elements,function (index, element) {
                            $(element).prop('checked',arg);
                            massActionIds[prefix][$(element).val()] = arg;
                        });
                        changeViewMassActionButton(this,prefix);
                    }
                });
                
                $('#mg-data-activeList tbody, #mg-data-inactiveList tbody, #mg-data-archiveList tbody').on( 'click', 'tr', function (e) {
                    if(e.target.nodeName != 'TD') return;
                    $(this).toggleClass('selected');
                    var input = $(this).find('td').first().find('input').first();
                    var arg = input.is( ":checked" )?false:true;
                    input.prop('checked',arg);
                    var parent = $(this).parent().parent().parent().parent().parent().parent().first().get(0);
                    var prefix = getPrefixMassAction(parent);
                    if (prefix === undefined) {
                        return;
                    }
                    massActionIds[prefix][input.val()] = arg;
                    changeViewMassActionButton(parent,prefix);
                });
                
                
                $('#mg-data-activeList tbody, #mg-data-inactiveList tbody, #mg-data-archiveList tbody').on( 'click','input', function (e) {
                    $(this).parent().parent().toggleClass('selected');
                    var prefix = getPrefixMassAction(this);
                    if (prefix === undefined) {
                        return;
                    }
                    massActionIds[prefix][$(this).val()] = $(this).is( ":checked" )?true:false;
                    
                    changeViewMassActionButton(this,prefix);
                });
                
                
                function undisabledAllMassButton() {
                    $("#mass-action-button-active").removeAttr('disabled');
                    $("#mass-action-button-inactive").removeAttr('disabled');
                    $("#mass-action-button-archive").removeAttr('disabled');
                    $("#mass-action-button-delete").removeAttr('disabled');
                }
                
                function disabledAllMassActionButton() {
                    $("#mass-action-button-active").attr('disabled','disabled');
                    $("#mass-action-button-inactive").attr('disabled','disabled');
                    $("#mass-action-button-archive").attr('disabled','disabled');
                    $("#mass-action-button-delete").attr('disabled','disabled');
                }
                
                function changeViewMassActionButton(el,prefixName) {
                    if (prefixName === undefined) {
                        return;
                    }
                    var showButton = false;
                    $.each( $('.mass-action.'+prefixName), function() {
                        if ($(this).is( ":checked" )) showButton = true;
                    });
                    
                    var value = "";
                    $.each( massActionIds[prefixName], function(i,val) {
                        if (val) value += "," + i;
                    });
                    
                    $("#mass-action-button-active").attr('data-modal-target',value.substr(1));
                    $("#mass-action-button-archive").attr('data-modal-target',value.substr(1));
                    $("#mass-action-button-inactive").attr('data-modal-target',value.substr(1));
                    $("#mass-action-button-delete").attr('data-modal-target',value.substr(1));
                    
                    
                    if (massActionTabs[prefixName]) {
                        if (showButton) {
                            undisabledAllMassButton();
                        } else {
                            disabledAllMassActionButton();
                        }
                        hiddenMassButton();
                        if (prefixName == "active") {
                            $("#mass-action-button-delete").show();
                            $("#mass-action-button-inactive").show().removeClass("btn-warning").addClass( "btn-primary" );
                            $("#mass-action-button-archive").show();
                        } else if (prefixName == "inactive") {
                            $("#mass-action-button-active").show();
                            $("#mass-action-button-archive").show();
                            $("#mass-action-button-delete").show();
                        } else if (prefixName == "archive") {
                            $("#mass-action-button-active").show();
                            $("#mass-action-button-inactive").show().removeClass("btn-primary").addClass( "btn-warning" );
                            $("#mass-action-button-delete").show();
                        }
                    } else {
                        hiddenMassButton();
                    }
                    
                };
                
                $('div.panel-body div ul.nav.nav-tabs').on('click','li',function () {
                    var name = $(this).find('a').first().attr('aria-controls');
                    if (name === undefined) {
                        return;
                    }
                    resetMassActionTabs();
                    massActionTabs[name] = true;
                    changeViewMassActionButton(this,name);
                });
                
                function getPrefixMassAction(el) {
                    var prefix = "";
                    var search = $(el).attr('id');
                    var number = 19
                    if (!search) {
                        search = $(el).attr('class');
                        number = 12;
                    }
                    if (search.search("active") == number || search.search("active") == 0) prefix = 'active';
                    else if (search.search("inactive") == number || search.search("inactive") == 0) prefix = 'inactive';
                    else if (search.search("archive") == number || search.search("archive") == 0) prefix = 'archive';
                    return prefix;
                };
                
                function hiddenMassButton() {
                    $("#mass-action-button-active").hide();
                    $("#mass-action-button-archive").hide();
                    $("#mass-action-button-inactive").hide();
                    $("#mass-action-button-delete").hide();
                    
                }
                
        });
    </script>
{/literal}
