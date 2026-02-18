<div class="modal fade bs-example-modal-lg" id="mg-modal-mass-inactive-entity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">{$MGLANG->T('modal','Inactivate Popups')} <strong data-modal-title=""></strong></h4>
            </div>
            <div class="modal-loader" style="display:none;"></div>

            <div class="modal-body">
                <input type="hidden" name="id" data-target="id" value="">
                <div class="modal-alerts">
                    <div style="display:none;" data-prototype="error">
                        <div class="note note-danger">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                            <strong></strong>
                            <a style="display:none;" class="errorID" href=""></a>
                        </div>
                    </div>
                    <div style="display:none;" data-prototype="success">
                        <div class="note note-success">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                            <strong></strong>
                        </div>
                    </div>
                </div>
                <div style="margin: 30px; text-align: center;">

                    <div>{$MGLANG->T('Are you sure you want to inactivate this entry?')} </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-inverse" data-modal-action="massinactive" id="pm-modal-addip-button-add">{$MGLANG->T('modal','inactivate')}</button>
                <button type="button" class="btn btn-default btn-inverse" data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
            </div>
        </div>
    </div>
</div>