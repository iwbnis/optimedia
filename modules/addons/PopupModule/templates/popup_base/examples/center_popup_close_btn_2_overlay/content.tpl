<div class="popup-container">
    {foreach from=$popups item=popup}
        <div class="popup not-shown" data-popup-id="{$popup.settings.id}" data-popup-delay ="{$popup.settings.delay}" data-popup-style="{$popup.settings.style}">
            <span class="popup-attributes" style="display:none">{$popup.settings|@json_encode}</span>
            <div class="popup-window">
                {if $popup.settings.type eq 'image'}
                    <img class="popup-image-message message" src="modules/addons/PopupModule/templates/clientarea/assets/popup/{$popup.message}" alt="" />
                {else}
                    <div class="popup-message message">
                        {$popup.message|unescape:'html'}
                    </div>
                {/if}

                {if $popup.settings.allow_not_show_again eq '1'}
                    <div class="notshow-container">
                        <label class="notShownAgain-container">{$MGLANG->absoluteT('addonCA', 'popup', 'noShowAgain')}
                            <input class="not-show-again" type="checkbox">
                            <span class="notShownAgain-checkmark"></span>
                        </label>
                    </div>
                {/if}
                <div class="popup-close">
                    <button class="mg-popup-close btn btn-danger pull-right">Close</button>
                </div>
            </div>
        </div>
    {/foreach}
</div>