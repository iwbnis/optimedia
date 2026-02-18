{include file="$template/includes/flashmessage.tpl"}

<p>{lang key="userManagement.usersFound" count=$users->count()}</p>

<table class="table table-striped table-bordered">
    <tr>
        <th>{lang key="userManagement.emailAddress"} / {lang key="userManagement.lastLogin"}</th>
        <th width="300">{lang key="userManagement.actions"}</th>
    </tr>
    {foreach $users as $user}
        <tr>
            <td>
                {$user->email}
                {if $user->pivot->owner}
                    <span class="label label-info">{lang key="clientOwner"}</span>
                {/if}
                {if $user->hasTwoFactorAuthEnabled()}
                    <i class="fas fa-shield text-success" data-toggle="tooltip" data-placement="auto right" title="{lang key='twoFactor.enabled'}"></i>
                {else}
                    <i class="fas fa-shield text-grey" data-toggle="tooltip" data-placement="auto right" title="{lang key='twoFactor.disabled'}"></i>
                {/if}
                <br>
                <small>
                    {lang key="userManagement.lastLogin"}:
                    {if $user->pivot->hasLastLogin()}
                        {$user->pivot->getLastLogin()->diffForHumans()}
                    {else}
                        {$LANG.never}
                    {/if}
                </small>
            </td>
            <td>
                <a href="{routePath('account-users-permissions', $user->id)}" class="btn outline-btn btn-sm btn-manage-permissions"{if $user->pivot->owner} disabled="disabled"{/if}>
                    {lang key="userManagement.managePermissions"}
                </a>
                <a href="#" class="btn danger-btn btn-sm btn-remove-user" data-id="{$user->id}"{if $user->pivot->owner} disabled="disabled"{/if}>
                    {lang key="userManagement.removeAccess"}
                </a>
            </td>
        </tr>
    {/foreach}
    {if $invites->count() > 0}
        <tr>
            <td colspan="3">
                <strong>{lang key="userManagement.pendingInvites"}</strong>
            </td>
        </tr>
        {foreach $invites as $invite}
            <tr>
                <td>
                    {$invite->email}
                    <br>
                    <small>
                        {lang key="userManagement.inviteSent"}:
                        {$invite->created_at->diffForHumans()}
                    </small>
                </td>
                <td>
                    <form method="post" action="{routePath('account-users-invite-resend')}">
                        <input type="hidden" name="inviteid" value="{$invite->id}">
                        <button type="submit" class="btn outline-btn btn-sm">
                            {lang key="userManagement.resendInvite"}
                        </button>
                        <button type="button" class="btn outline-btn btn-sm btn-cancel-invite" data-id="{$invite->id}">
                            {lang key="userManagement.cancelInvite"}
                        </button>
                    </form>
                </td>
            </tr>
        {/foreach}
    {/if}
</table>

<p>* {lang key="userManagement.accountOwnerPermissionsInfo"}</p>

<div class="sub-heading">
    <h3>{lang key="userManagement.inviteNewUser"}</h3>
</div>
<p>{lang key="userManagement.inviteNewUserDescription"}</p>

<form method="post" action="{routePath('account-users-invite')}">
    <div class="form-group">
        <input type="email" name="inviteemail" placeholder="name@example.com" class="form-control" value="{$formdata.inviteemail}">
    </div>
    <div class="form-group">
        <label class="radio-inline">
            <input type="radio" name="permissions" value="all" checked="checked">
            {lang key="userManagement.allPermissions"}
        </label>
        <label class="radio-inline">
            <input type="radio" name="permissions" value="choose">
            {lang key="userManagement.choosePermissions"}
        </label>
    </div>
    <div class="well hidden" id="invitePermissions">
        {foreach $permissions as $permission}
            <label class="checkbox-inline">
                <input type="checkbox" name="perms[{$permission.key}]" value="1">
                {$permission.title}
                -
                {$permission.description}
            </label>
            <br>
        {/foreach}
    </div>
    <button type="submit" class="btn primary-solid-btn">
        {lang key="userManagement.sendInvite"}
    </button>
</form>

<form method="post" action="{routePath('user-accounts')}">
    <input type="hidden" name="id" value="" id="inputSwitchAcctId">
</form>

<form method="post" action="{routePath('account-users-remove')}">
    <input type="hidden" name="userid" id="inputRemoveUserId">
    <div class="modal fade" id="modalRemoveUser">
        <div class="modal-dialog">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title text-white">
                        {lang key="userManagement.removeAccess"}
                    </h5>
                </div>
                <div class="modal-body">
                    <p>{lang key="userManagement.removeAccessSure"}</p>
                    <p>{lang key="userManagement.removeAccessInfo"}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn outline-btn btn-sm" data-dismiss="modal">
                        {lang key="cancel"}
                    </button>
                    <button type="submit" class="btn primary-solid-btn btn-sm" id="btnRemoveUserConfirm">
                        {lang key="confirm"}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" action="{routePath('account-users-invite-cancel')}">
    <input type="hidden" name="inviteid" id="inputCancelInviteId">
    <div class="modal fade" id="modalCancelInvite">
        <div class="modal-dialog">
            <div class="modal-content panel-primary">
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title text-white">
                        {lang key="userManagement.cancelInvite"}
                    </h5>
                </div>
                <div class="modal-body">
                    <p>{lang key="userManagement.cancelInviteSure"}</p>
                    <p>{lang key="userManagement.cancelInviteInfo"}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn outline-btn btn-sm" data-dismiss="modal">
                        {lang key="cancel"}
                    </button>
                    <button type="submit" class="btn primary-solid-btn btn-sm" id="btnCancelInviteConfirm">
                        {lang key="confirm"}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    jQuery(document).ready(function() {
        jQuery('input:radio[name=permissions]').change(function () {
            if (this.value === 'choose') {
                jQuery('#invitePermissions').hide().removeClass('hidden').slideDown();
            } else {
                jQuery('#invitePermissions').slideUp();
            }
        });
        jQuery('.btn-manage-permissions').click(function(e) {
            if (jQuery(this).attr('disabled')) {
                e.preventDefault();
            }
        });
        jQuery('.btn-remove-user').click(function(e) {
            e.preventDefault();
            if (jQuery(this).attr('disabled')) {
                return;
            }
            jQuery('#inputRemoveUserId').val(jQuery(this).data('id'));
            jQuery('#modalRemoveUser').modal('show');
        });
        jQuery('.btn-cancel-invite').click(function(e) {
            e.preventDefault();
            jQuery('#inputCancelInviteId').val(jQuery(this).data('id'));
            jQuery('#modalCancelInvite').modal('show');
        });
    });
</script>
