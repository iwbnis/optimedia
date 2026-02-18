{if $inactive}

    {include file="$template/includes/alert.tpl" type="danger" msg=$LANG.affiliatesdisabled textcenter=true}

{else}

    <div class="row mb-40">

        <div class="col-sm-4">
            <div class="affiliate-stat client-dashboard-single">
                <i class="fas fa-users"></i>
                <div class="icon-title-wrap">
                    <h2>{$visitors}</h2>
                <h5>{$LANG.affiliatesclicks}</h5>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="affiliate-stat client-dashboard-single">
                <i class="fas fa-shopping-cart"></i>
                <div class="icon-title-wrap">
                    <h2>{$signups}</h2>
                    <h5>{$LANG.affiliatessignups}</h5>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="affiliate-stat client-dashboard-single">
                <i class="far fa-chart-bar"></i>
                <div class="icon-title-wrap">
                    <h2>{$conversionrate}%</h2>
                    <h5>{$LANG.affiliatesconversionrate}</h5>
                </div>
            </div>
        </div>

    </div>



    <div class="row mb-40">
        <div class="col-md-6">
            <table class="table referral-commission-table">
                <tr>
                    <td class="text-left">{$LANG.affiliatescommissionspending}:</td>
                    <td><strong>{$pendingcommissions}</strong></td>
                </tr>
                <tr>
                    <td class="text-left">{$LANG.affiliatescommissionsavailable}:</td>
                    <td><strong>{$balance}</strong></td>
                </tr>
                <tr>
                    <td class="text-left">{$LANG.affiliateswithdrawn}:</td>
                    <td><strong>{$withdrawn}</strong></td>
                </tr>
            </table>

        </div>
        <div class="col-md-6">
             <div class="affiliate-referral-link">
                <h5>{$LANG.affiliatesreferallink}</h5>
                <span>{$referrallink}</span>
            </div>
        </div>
        <div class="widthdrol-request mb-20">
            <div class="col-md-12">
                <div class="message message-no-data">
                    {if $withdrawrequestsent}
                    <p class="message-text text-center">
                        {$LANG.affiliateswithdrawalrequestsuccessful}
                    </p>
                    {else}
                    <p class="message-text text-center">
                        {if !$withdrawlevel}
                            {lang key="affiliateWithdrawalSummary" amountForWithdrawal=$affiliatePayoutMinimum}
                        {/if}
                    </p>
                    <div class="message-action mt-20">
                        <a href="{$smarty.server.PHP_SELF}?action=withdrawrequest" class="btn primary-solid-btn"{if !$withdrawlevel} disabled="true"{/if}>
                            <i class="fas fa-university"></i> {$LANG.affiliatesrequestwithdrawal}
                        </a>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>

    <span class="referals-headding">{include file="$template/includes/subheader.tpl" title=$LANG.affiliatesreferals}</span>

    {include file="$template/includes/tablelist.tpl" tableName="AffiliatesList"}
    <script type="text/javascript">
        jQuery(document).ready( function ()
        {
            var table = jQuery('#tableAffiliatesList').removeClass('hidden').DataTable();
            {if $orderby == 'regdate'}
                table.order(0, '{$sort}');
            {elseif $orderby == 'product'}
                table.order(1, '{$sort}');
            {elseif $orderby == 'amount'}
                table.order(2, '{$sort}');
            {elseif $orderby == 'status'}
                table.order(4, '{$sort}');
            {/if}
            table.draw();
            jQuery('#tableLoading').addClass('hidden');
        });
    </script>
    {if $referrals}
        <div class="table-container clearfix">
            <table id="tableAffiliatesList" class="table table-list hidden">
                <thead>
                    <tr>
                        <th>{$LANG.affiliatessignupdate}</th>
                        <th>{$LANG.orderproduct}</th>
                        <th>{$LANG.affiliatesamount}</th>
                        <th>{$LANG.affiliatescommission}</th>
                        <th>{$LANG.affiliatesstatus}</th>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$referrals item=referral}
                    <tr class="text-center">
                        <td><span class="hidden">{$referral.datets}</span>{$referral.date}</td>
                        <td>{$referral.service}</td>
                        <td data-order="{$referral.amountnum}">{$referral.amountdesc}</td>
                        <td data-order="{$referral.commissionnum}">{$referral.commission}</td>
                        <td><span class='label status status-{$referral.rawstatus|strtolower}'>{$referral.status}</span></td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
            <div class="text-center" id="tableLoading">
                <p><i class="fas fa-spinner fa-spin"></i> {$LANG.loading}</p>
            </div>
        </div>
    {else}
        {include file="$template/includes/no-data.tpl" msg="No data found!"}
    {/if}
    {if $affiliatelinkscode}
        {include file="$template/includes/subheader.tpl" title=$LANG.affiliateslinktous}
        <div class="margin-bottom text-center">
            {$affiliatelinkscode}
        </div>
    {/if}

{/if}
