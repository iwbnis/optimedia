<div class="form-horizontal tab-content">
    {foreach from=$hidden item=field}
        {$field->html}
    {/foreach}
    {foreach from=$fields item=field}
            {if $field->opentag}
                <div class="form-group {$field->id}" id="">
            {/if}
              {$field->html}
            {if $field->closetag}
                </div>
            {/if}
    {/foreach}
</div>
