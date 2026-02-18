{include file="$template/includes/flashmessage.tpl"}

<div class="sub-heading">
    <h3>{$LANG.userProfile.profile}</h3>
</div>
<form method="post" action="{routePath('user-profile-save')}">
    <div class="custom-card-block account-eidt mb-40">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="inputFirstName" class="control-label">
                        {$LANG.clientareafirstname}
                    </label>
                    <input
                        type="text"
                        name="firstname"
                        id="inputFirstName"
                        value="{$user->firstName}"
                        class="form-control"
                        {if in_array('firstname', $uneditableFields)}disabled="disabled"{/if}
                    >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="inputLastName" class="control-label">
                        {$LANG.clientarealastname}
                    </label>
                    <input
                        type="text"
                        name="lastname"
                        id="inputLastName"
                        value="{$user->lastName}"
                        class="form-control"
                        {if in_array('lastname', $uneditableFields)}disabled="disabled"{/if}
                    >
                </div>
            </div>
        </div>
        <div class="form-group mb-0">
            <input class="btn primary-solid-btn" type="submit" name="save" value="{$LANG.clientareasavechanges}" />
            <input class="btn outline-btn" type="reset" value="{$LANG.cancel}" />
        </div>
    </div>
</form>

<div class="sub-heading">
    <h3>{$LANG.userProfile.changeEmail}</h3>
</div>
<p>
    {if $user->needsToCompleteEmailVerification()}
        <span class="label label-default">{$LANG.userProfile.notVerified}</span>
    {elseif $user->emailVerified()}
        <span class="label label-success">{$LANG.userProfile.verified}</span>
    {/if}
</p>

<form method="post" action="{routePath('user-profile-email-save')}">
    <div class="custom-card-block account-eidt mb-40">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="inputEmail" class="control-label">
                        {$LANG.clientareaemail}
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="inputEmail"
                        value="{$user->email}"
                        class="form-control"
                        {if in_array('email', $uneditableFields)}disabled="disabled"{/if}
                    >
                </div>
            </div>
        </div>
        <div class="form-group mb-0">
            <input class="btn primary-solid-btn" type="submit" name="save" value="{$LANG.clientareasavechanges}" />
            <input class="btn outline-btn" type="reset" value="{$LANG.cancel}" />
        </div>
    </div>
</form>
