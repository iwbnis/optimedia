{**********************************************************************
*
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

<form data-toggle="validator" role="form" id="mg-popup-form">
    <div class="modal modal-style fade bs-example-modal-lg" id="mg-modal-add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">{$MGLANG->T('Add New Style')} <strong></strong></h4>
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
                    {$form}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-inverse" data-modal-action="save" id="pm-modal-addip-button-add">{$MGLANG->T('modal','Add')}</button>
                    <button type="button" class="btn btn-default btn-inverse" data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
                </div>
            </div>
        </div>
    </div>
</form>