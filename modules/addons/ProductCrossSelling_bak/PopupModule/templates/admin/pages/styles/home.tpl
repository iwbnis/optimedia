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
                    <h3 class="panel-title">{$MGLANG->T('Styles List')}</h3>
                </div>
                <div class="panel-body">
                    <div>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="active">
                                <table class="table table-hover" id="mg-data-activeList" >
                                    <thead>
                                        <tr>
                                            <th style="min-width: 20px;">{$MGLANG->T('ID')}</th>
                                            <th>{$MGLANG->T('Title')}</th>
                                            <th style="width: 150px; text-align: center;">{$MGLANG->T('Actions')}</th>
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
                    {$deleteModal}
                </div>
            </div>
            <div class="well">
                <a class="btn btn-success btn-inverse" href="{$createURL}">               
                    {$MGLANG->T('Add New Style')}
                </a>
            </div>
        </div>
    </div>
{literal}
    <script type="text/javascript">
        var mgDataTableActive;
        jQuery(document).ready(function () {
            
                mgDataTableActive = $('#mg-data-activeList').DataTable({
                    processing: false,
                    searching: true,
                    autoWidth: false,
                    "serverSide": false,
                    "order": [[0, "desc"]],
                    ajax: function (data, callback, settings) {
                        var filter = {};
                        JSONParser.request('getList', {
                            filter: filter,
                            limit: data.length,
                            offset: data.start,
                            order: data.order,
                            search: data.search
                        }
                        , function (dataBack) {
                            pages = Math.ceil( dataBack.recordsTotal / settings._iDisplayLength );
                            if (settings._iDisplayLength * pages <= settings._iDisplayStart ) {
                                settings._iDisplayStart = 0;
                            }
                            callback(dataBack);
                        });
                    },
                    'columns': [null, null, {orderable: false}],
                    'aoColumnDefs': [{
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
                    $(this).find('li').first().addClass('active');
                    $('#MGAlerts').alerts('clear');
                });
                $('#mg-modal-delete-entity, #mg-modal-add-new').on('hidden.bs.modal', function (e) {
                    mgDataTableActive.ajax.reload(function () {
                    }, false);
                });

        });
    </script>
{/literal}
