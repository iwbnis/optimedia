<div class="col-sm-9">
    <h3 {if $addIDs}id="{$addIDs}_{$name}"{/if} {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach} >{$MGLANG->T('label')}</h3>
</div>
