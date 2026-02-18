{if $enableLabel}
    <label for="{$formName}_{$name}" class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}" {if $addIDs}id="{$addIDs}_{$name}"{/if}>
    {assign var="id" value=1}
    {foreach from=$options item=option key=opValue}
        <div class="col-sm-12" style="padding-left: 0px;">
            <input type="radio" {if $value == $opValue}checked="checked"{/if} name="{$nameAttr}" value="{$opValue}" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>
            <label>{$option}</label>
            {assign var="id" value=$id+1}
        </div>
    {/foreach}
    <span class="help-block error-block"{if !$error}style="display:none;"{/if}>{$error}</span>
    <script type="text/javascript">
        {literal}
        var stopDoubleChange = false;
        $('input[type=radio][name="{/literal}{$nameAttr}{literal}"]').iCheck({
            radioClass: 'iradio_minimal',
            cursor: true,
            increaseArea: '20%'
        });
        $('input[type=radio][name="{/literal}{$nameAttr}{literal}"]').on('ifChanged', function (event) { 
            if (stopDoubleChange) {
                $(event.target).attr("checked", 'checked');
                $(event.target).change(); 
                stopDoubleChange = false;
            } else {
                $(event.target).removeAttr("checked");
                stopDoubleChange = true;
            }
        });
    {/literal}
    </script>
</div>
