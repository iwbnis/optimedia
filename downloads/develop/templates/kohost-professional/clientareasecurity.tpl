{if $linkableProviders }
    <div class="sub-heading">
        <h3>{lang key='remoteAuthn.titleLinkedAccounts'}</h3>
    </div>

    <div class="custom-card-block mb-40">
        {include file="$template/includes/linkedaccounts.tpl" linkContext="clientsecurity" }

        {include file="$template/includes/linkedaccounts.tpl" linkContext="linktable" }
    </div>

{/if}

{if $showSsoSetting}

    <div class="sub-heading">
        <h3>{$LANG.sso.title}</h3>
    </div>
    <div class="custom-card-block mb-40">
        {include file="$template/includes/alert.tpl" type="success" msg=$LANG.sso.summary}

        <form id="frmSingleSignOn">
            <input type="hidden" name="token" value="{$token}" />
            <input type="hidden" name="action" value="security" />
            <input type="hidden" name="toggle_sso" value="1" />
            <div class="margin-10">
                <input type="checkbox" name="allow_sso" class="toggle-switch-success" id="inputAllowSso"{if $isSsoEnabled} checked{/if}>
                &nbsp;
                <span id="ssoStatusTextEnabled"{if !$isSsoEnabled} class="hidden"{/if}>
                    {$LANG.sso.enabled}
                </span>
                <span id="ssoStatusTextDisabled"{if $isSsoEnabled} class="hidden"{/if}>
                    {$LANG.sso.disabled}
                </span>
            </div>
        </form>

        <p>{$LANG.sso.disablenotice}</p>

    </div>

{/if}
