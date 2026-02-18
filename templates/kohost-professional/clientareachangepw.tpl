{if $successful}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
{/if}

{if $errormessage}
    {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
{/if}

<form class="custom-card-block form-horizontal using-password-strength pass-generation-wrap row" method="post" action="clientarea.php?action=changepw" role="form">
    <input type="hidden" name="submit" value="true" />
    <div class="col-sm-12">
        <div class="form-group">
            <label for="inputExistingPassword" class="control-label">{$LANG.existingpassword}</label>
            <input type="password" class="form-control" name="existingpw" id="inputExistingPassword" autocomplete="off" />
        </div>
     </div>
     <div class="col-sm-6">
        <div id="newPassword1" class="form-group has-feedback">
            <label for="inputNewPassword1" class="control-label">{$LANG.newpassword} <span class="fas fa-info-circle" data-toggle="tooltip" title="" data-html="true" data-container="body" data-original-title="{$LANG.passwordtips}"></span></label>
            <input type="password" class="form-control" name="newpw" id="inputNewPassword1" autocomplete="off" />
            <span class="form-control-feedback glyphicon"></span>
            {include file="$template/includes/kohost-pwstrength.tpl"}
            <div class="password-wrap change-password-wrap">
                <button type="button" class="btn primary-solid-btn generate-password" data-targetfields="inputNewPassword1,inputNewPassword2">
                    {$LANG.generatePassword.btnLabel}
                </button>
                <div class="progress" id="passwordStrengthBar">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">New Password Rating: 0%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div id="newPassword2" class="form-group has-feedback">
            <label for="inputNewPassword2" class="control-label">{$LANG.confirmnewpassword}</label>
            <input type="password" class="form-control" name="confirmpw" id="inputNewPassword2" autocomplete="off" />
            <span class="form-control-feedback glyphicon"></span>
            <div id="inputNewPassword2Msg"></div>
        </div>
        <div class="form-group">
            <input class="btn primary-solid-btn" type="submit" value="{$LANG.clientareasavechanges}" />
            <input class="btn outline-btn" type="reset" value="{$LANG.cancel}" />
        </div>
    </div>
</form>
