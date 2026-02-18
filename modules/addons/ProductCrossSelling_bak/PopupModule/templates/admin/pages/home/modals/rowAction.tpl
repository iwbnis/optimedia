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
<a href="{$systemURL}?debug_popup={$id}" data-modal-target="{$id}" target="_blank"
        class="btn btn-sm btn-info buttonInGroup mg-modal-preview" title="{$MGLANG->T('actionButtons','preview')}"><i class="glyphicon glyphicon-eye-open"></i>
</a>
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-edit-entity" data-modal-target="{$id}"  data-toggle="tooltip" class="btn btn-sm btn-info buttonInGroup"
    title="{$MGLANG->T('actionButtons','edit')}"> <i class="fa fa-pencil"></i>     
</button>
{if $status eq 'active'}
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-inactive-entity" data-modal-target="{$id}" 
        class="btn btn-sm btn-info buttonInGroup" title="{$MGLANG->T('actionButtons','move to inactive')}"><i class="glyphicon glyphicon-ban-circle"></i>
</button>   
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-archive-entity" data-modal-target="{$id}" 
        class="btn btn-sm btn-info buttonInGroup" title="{$MGLANG->T('actionButtons','move to archive')}"><i class="glyphicon glyphicon-folder-open"></i>
</button>    
{/if}
{if $status eq 'inactive'}
<button  data-toggle="tooltip" type="button" data-modal-id="mg-modal-active-entity" data-modal-target="{$id}" 
        class="btn btn-sm btn-info buttonInGroup" title="{$MGLANG->T('actionButtons','move to activate')}"><i class="glyphicon glyphicon-ok"></i>
</button>
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-archive-entity" data-modal-target="{$id}" 
        class="btn btn-sm btn-info buttonInGroup" title="{$MGLANG->T('actionButtons','move to archive')}"><i class="glyphicon glyphicon-folder-open"></i>
</button>    
{/if}
{if $status eq 'archive'}
<button  data-toggle="tooltip" type="button" data-modal-id="mg-modal-active-entity" data-modal-target="{$id}"
        class="btn btn-sm btn-info buttonInGroup" title="{$MGLANG->T('actionButtons','move to activate')}"><i class="glyphicon glyphicon-ok"></i>
</button>
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-inactive-entity" data-modal-target="{$id}" 
        class="btn btn-sm btn-info buttonInGroup" title="{$MGLANG->T('actionButtons','move to inactive')}"><i class="glyphicon glyphicon-ban-circle"></i>
</button>  
{/if}
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-delete-entity" data-modal-target="{$id}" 
        class="btn btn-sm btn-danger buttonInGroup" title="{$MGLANG->T('actionButtons','delete')}"><i class="glyphicon glyphicon-remove"></i>
</button>
