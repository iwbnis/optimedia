{include file="$template/includes/tablelist.tpl" tableName="EmailsList" noSortColumns="-1"}
<script type="text/javascript">
    jQuery(document).ready( function ()
    {
        var table = jQuery('#tableEmailsList').removeClass('hidden').DataTable();
        {if $orderby == 'date'}
            table.order(0, '{$sort}');
        {elseif $orderby == 'subject'}
            table.order(1, '{$sort}');
        {/if}
        table.draw();
        jQuery('#tableLoading').addClass('hidden');
    });
</script>
<div class="table-container clearfix">
    <table id="tableEmailsList" class="table table-list hidden view-message-table">
        <thead>
            <tr>
                <th>{$LANG.clientareaemailsdate}</th>
                <th>{$LANG.clientareaemailssubject}</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$emails item=email}
            <tr onclick="popupWindow('viewemail.php?id={$email.id}', 'emailWin', '650', '450')">
                <td><span class="hidden">{$email.normalisedDate}</span>{$email.date}</td>
                <td>{$email.subject}{if $email.attachmentCount > 0} <i class="fal fa-paperclip"></i>{/if}</td>
                <td class="text-right"><input type="button" data-toggle="tooltip" class="view-message" data-container="body" data-original-title="{$LANG.emailviewmessage}"  onclick="popupWindow('viewemail.php?id={$email.id}', 'emailWin', '650', '450', 'scrollbars=1,')" /><i class="fas fa-envelope color-primary"></i></td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    <div class="text-center" id="tableLoading">
        <p><i class="fas fa-spinner fa-spin"></i> {$LANG.loading}</p>
    </div>
</div>
