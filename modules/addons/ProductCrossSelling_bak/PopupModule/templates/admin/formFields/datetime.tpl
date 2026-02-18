{if $enableLabel}
    <label for="{$formName}_{$name}" class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T($textLabel)}</label>
{/if}
<div class="col-sm-{$colWidth}">
    <div class='input-group date'>
        <span class="input-group-addon" onclick="jQuery(this).parent().children().last().focus()" style="cursor: initial;">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
        <input name="{$nameAttr}" data-datetimepicker="" type="text" value="{$value}"  class="form-control" {if $addIDs}id="{$addIDs}_{$name}"{/if} placeholder="{if $enablePlaceholder}{$MGLANG->T('placeholder')}{/if}" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>
    </div>
    {if $enableDescription}
        <span class="help-block">{$MGLANG->T('description')}</span>
    {/if}
    <span class="help-block error-block"{if !$error}style="display:none;"{/if}>{$error}</span>
</div>