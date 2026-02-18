{**********************************************************************
* PopupModule product developed. (2015-11-16)
* *
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
<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/style.css" />
<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/defaultStyle.css" />
{if !$isWHMCS6}
    <script type="text/javascript" src="{$assetsURL}/js/jquery.cookie.js"></script>
{/if}
<script type="text/javascript" src="{$assetsURL}/js/script.js"></script>

<div id="popup-container" >
    {foreach from=$popups item=popup}
        <div class="popup not-shown" data-popup-id="{$popup.settings.id}" data-popup-delay ="{$popup.settings.delay}" data-popup-style="{$popup.settings.style}" >
            <span class="popup-attributes" style="display:none">{$popup.settings|@json_encode}</span>
            <div class="popup-window">
                <a class="close" value="{$popup.settings.id}">x</a>
                {if $popup.settings.type eq 'image'}
                    <img class="popup-image-message message" src="modules/addons/PopupModule/templates/clientarea/assets/popup/{$popup.message}" alt="" />
                {else}
                    <div class="popup-message message">
                        {$popup.message|unescape:'html'}
                    </div>
                {/if}
                {if $popup.settings.allow_not_show_again eq '1'}
                    <div class="notshow-container">
                        <input id="not-show-again-{$popup.settings.id}" style="vertical-align: -2px;" class="not-show-again" type="checkbox" /> 
                        <label for="not-show-again-{$popup.settings.id}">{$MGLANG->absoluteT('addonCA', 'popup', 'noShowAgain')}</label>
                    </div>
                {/if}
            </div>
        </div>
    {/foreach}
</div>