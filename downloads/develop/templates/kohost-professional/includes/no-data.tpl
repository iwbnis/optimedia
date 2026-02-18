<div class="row">
    <div class="col-md-12">
        <div class="message message-no-data">
            <div class="message-image">
                <span class="fas fa-exclamation-triangle fa-3x"></span>
            </div>
            <p class="message-text text-center">{$msg}</p>
            {if $btnText}
            <div class="message-action mt-20">
                <a class="btn {if $btnClass}{$btnClass}{else}primary-solid-btn{/if}" href="{$btnUrl}">
                    {if $btnIcon}
                    <i class="{$btnIcon}"></i>
                    {/if}
                    {$btnText}
                </a>
            </div>
            {/if}
        </div>
    </div>
</div>