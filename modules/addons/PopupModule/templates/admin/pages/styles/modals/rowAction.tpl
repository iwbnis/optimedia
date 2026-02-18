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
<a href="{$systemURL}?debug_styles={$id}" data-modal-target="{$id}" target="_blank"
        class="btn btn-sm btn-info buttonInGroup mg-modal-preview" title="{$MGLANG->T('actionButtons','preview')}"><i class="glyphicon glyphicon-eye-open"></i>
</a>
<a  href="{$mainURL}" class="btn btn-sm btn-info buttonInGroup"
    title="{$MGLANG->T('actionButtons','edit')}"> <i class="fa fa-pencil"></i>     
</a>
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-delete-entity" data-modal-target="{$id}" data-modal-title="{$title}" 
        class="btn btn-sm btn-danger buttonInGroup" title="{$MGLANG->T('actionButtons','delete')}"><i class="glyphicon glyphicon-remove"></i>
</button>