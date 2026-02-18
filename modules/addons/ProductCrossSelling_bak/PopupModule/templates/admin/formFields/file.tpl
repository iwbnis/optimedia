{if $enableLabel}
    <label {if $id} for="{$id}" {elseif $addIDs}for="{$addIDs}_{$name}"{/if} class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T($textLabel)}</label>
{/if}
<div class="col-sm-{$colWidth}">
    <input name="{$nameAttr}" type="file" value="{$value}" class="pull-left" {if $id} id="{$id}" {elseif $addIDs}id="{$addIDs}_{$name}"{/if}
           {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach} {if $required}required{/if}>
    {if $enableAjaxUpload}
        <button class="btn btn-xs btn-success btn-inverse uploadAjaxFile pull-left" style="marcin-top: 2px">
            <i class="fa fa-circle-o-notch fa-spin hide"></i> 
            {$MGLANG->T('Upload File')}
        </button>
    {/if}
    <div class="help-block with-errors">{$error}</div>
    {if $enableDescription}
        <span class="help-block">{$MGLANG->T('description')}</span>
    {/if}
</div>