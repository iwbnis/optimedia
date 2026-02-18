{include file="$template/includes/flashmessage.tpl"}

<p>{lang key='userManagement.settings'}</p>

{if $linkableProviders }
    <div class="sub-heading">
        <h3>{lang key='remoteAuthn.titleLinkedAccounts'}</h3>
    </div>

    {include file="$template/includes/linkedaccounts.tpl" linkContext="clientsecurity" }

    <br>

    {include file="$template/includes/linkedaccounts.tpl" linkContext="linktable" }

    <br>
{/if}

{if $securityQuestions->count() > 0}
    <div class="sub-heading">
        <h3>{$LANG.clientareanavsecurityquestions}</h3>
    </div>
    <div class="custom-card-block account-eidt mb-40">
         <form method="post" action="{routePath('user-security-question')}">
            {if $user->hasSecurityQuestion()}
                <div class="form-group">
                    <label for="inputCurrentAns" class="control-label">{$user->getSecurityQuestion()}</label>
                    <input type="password" name="currentsecurityqans" id="inputCurrentAns" class="form-control" autocomplete="off" />
                </div>
            {/if}
    
            <div class="form-group">
                <label for="inputSecurityQid" class="control-label">{$LANG.clientareasecurityquestion}</label>
                <select name="securityqid" id="inputSecurityQid" class="form-control">
                    {foreach $securityQuestions as $question}
                        <option value="{$question->id}">
                            {$question->question}
                        </option>
                    {/foreach}
                </select>
            </div>
    
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputSecurityAns1" class="control-label">{$LANG.clientareasecurityanswer}</label>
                        <input type="password" name="securityqans" id="inputSecurityAns1" class="form-control" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputSecurityAns2" class="control-label">{$LANG.clientareasecurityconfanswer}</label>
                        <input type="password" name="securityqans2" id="inputSecurityAns2" class="form-control" autocomplete="off" />
                    </div>
                </div>
            </div>
    
            <p>
                <input class="btn primary-solid-btn" type="submit" name="submit" value="{$LANG.clientareasavechanges}" />
                <input class="btn outline-btn" type="reset" value="{$LANG.cancel}" />
            </p>
        </form>
    </div>
   
{/if}

{if $twoFactorAuthAvailable}
    <div class="sub-heading">
        <h3>{$LANG.twofactorauth}</h3>
    </div>
    <div class="custom-card-block">
        <p class="twofa-config-link disable{if !$twoFactorAuthEnabled} hidden{/if}">
            {$LANG.twofacurrently} <strong>{$LANG.enabled|strtolower}</strong>
        </p>
        <p class="twofa-config-link enable{if $twoFactorAuthEnabled} hidden{/if}">
            {$LANG.twofacurrently} <strong>{$LANG.disabled|strtolower}</strong>
        </p>
    
        {include file="$template/includes/alert.tpl" type="warning" msg="{lang key="clientAreaSecurityTwoFactorAuthRecommendation"}"}

        <a href="{routePath('account-security-two-factor-disable')}" class="btn danger-btn open-modal twofa-config-link disable{if !$twoFactorAuthEnabled} hidden{/if}" data-modal-title="{$LANG.twofadisable}" data-modal-class="twofa-setup" data-btn-submit-label="{lang key='twofadisable'}" data-btn-submit-color="danger" data-btn-submit-id="btnDisable2FA">
            {$LANG.twofadisableclickhere}
        </a>
        <a href="{routePath('account-security-two-factor-enable')}" class="btn primary-solid-btn open-modal twofa-config-link enable{if $twoFactorAuthEnabled} hidden{/if}" data-modal-title="{$LANG.twofaenable}" data-modal-class="twofa-setup" data-btn-submit-id="btnEnable2FA">
            {$LANG.twofaenableclickhere}
        </a>
    </div>
{/if}
