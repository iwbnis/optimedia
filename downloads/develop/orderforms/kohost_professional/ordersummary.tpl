{if $producttotals}
    {* <span class="product-name">{if $producttotals.allowqty && $producttotals.qty > 1}{$producttotals.qty} x {/if}{$producttotals.productinfo.name}</span> *}
    {* <span class="product-group">{$producttotals.productinfo.groupname}</span>  *}

    <ul class="order-summary-list">
        <li class="summary-list-item">
            <span class="pull-left float-left">{$producttotals.productinfo.name}</span>
            <span class="pull-right float-right">{$producttotals.pricing.baseprice}</span>
        </li>
    </ul>

    {foreach $producttotals.configoptions as $configoption}
        {if $configoption}
            <ul class="order-summary-list">
                <li class="summary-list-item">
                    <span class="pull-left float-left">&nbsp;&raquo; {$configoption.name}: {$configoption.optionname}</span>
                    <span class="pull-right float-right">{$configoption.recurring}{if $configoption.setup} + {$configoption.setup} {$LANG.ordersetupfee}{/if}</span>
                </li>
            </ul>
        {/if}
    {/foreach}

    {foreach $producttotals.addons as $addon}
        <ul class="order-summary-list">
            <li class="summary-list-item">
                <span class="pull-left float-left">+ {$addon.name}</span>
                <span class="pull-right float-right">{$addon.recurring}</span>
            </li>
        </ul>
    {/foreach}

    {if $producttotals.pricing.setup || $producttotals.pricing.recurring || $producttotals.pricing.addons}
        <div class="summary-totals">
            {if $producttotals.pricing.setup}
                <ul class="order-summary-list">
                    <li class="summary-list-item">
                        <span class="pull-left float-left">{$LANG.cartsetupfees}:</span>
                        <span class="pull-right float-right">{$producttotals.pricing.setup}</span>
                    </li>
                </ul>
            {/if}
            {foreach from=$producttotals.pricing.recurringexcltax key=cycle item=recurring}
                <ul class="order-summary-list">
                    <li class="summary-list-item">
                        <span class="pull-left float-left">{$cycle}:</span>
                        <span class="pull-right float-right">{$recurring}</span>
                    </li>
                </ul>
            {/foreach}
            {if $producttotals.pricing.tax1}
                <ul class="order-summary-list">
                    <li class="summary-list-item">
                        <span class="pull-left float-left">{$carttotals.taxname} @ {$carttotals.taxrate}%:</span>
                        <span class="pull-right float-right">{$producttotals.pricing.tax1}</span>
                    </li>
                </ul>
            {/if}
            {if $producttotals.pricing.tax2}
                <ul class="order-summary-list">
                    <li class="summary-list-item">
                        <span class="pull-left float-left">{$carttotals.taxname2} @ {$carttotals.taxrate2}%:</span>
                        <span class="pull-right float-right">{$producttotals.pricing.tax2}</span>
                    </li>
                </ul>
            {/if}
        </div>
    {/if}

    <div class="total-due-today">
        <div class="content">
            <span class="amt">{$producttotals.pricing.totaltoday}</span>
            <span class="total-due-today-text">{$LANG.ordertotalduetoday}</span>
        </div>
    </div>
{elseif $renewals}
    {if $carttotals.renewals}
        
        <ul class="order-summary-list">
            <li class="summary-list-item faded">
                <span class="pull-left float-left">{lang key='domainrenewals'}</span>
            </li>
        </ul>
        {foreach $carttotals.renewals as $domainId => $renewal}
            <ul class="order-summary-list" id="cartDomainRenewal{$domainId}">
                <li class="summary-list-item">
                    <span class="pull-left float-left"> {$renewal.domain} - {$renewal.regperiod} {if $renewal.regperiod == 1}{lang key='orderForm.year'}{else}{lang key='orderForm.years'}{/if}</span>
                    <span class="pull-right float-right">
                        {$renewal.priceBeforeTax}
                        <a onclick="removeItem('r','{$domainId}'); return false;" data-toggle="tooltip" data-original-title="Remove" class="remove-icon" href="#" id="linkCartRemoveDomainRenewal{$domainId}">
                            <i class="fas fa-fw fa-trash-alt"></i>
                        </a>
                    </span>
                </li>
            </ul>
            {if $renewal.dnsmanagement}
                <div class="clearfix">
                    <span class="pull-left float-left">+ {lang key='domaindnsmanagement'}</span>
                </div>
            {/if}
            {if $renewal.emailforwarding}
                <div class="clearfix">
                    <span class="pull-left float-left">+ {lang key='domainemailforwarding'}</span>
                </div>
            {/if}
            {if $renewal.idprotection}
                <div class="clearfix">
                    <span class="pull-left float-left">+ {lang key='domainidprotection'}</span>
                </div>
            {/if}
            {if $renewal.hasGracePeriodFee}
                <div class="clearfix">
                    <span class="pull-left float-left">+ {lang key='domainRenewal.graceFee'}</span>
                </div>
            {/if}
            {if $renewal.hasRedemptionGracePeriodFee}
                <div class="clearfix">
                    <span class="pull-left float-left">+ {lang key='domainRenewal.redemptionFee'}</span>
                </div>
            {/if}

        {/foreach}
    {/if}
    <div class="summary-totals">
        <ul class="order-summary-list">
            <li class="summary-list-item">
                <span class="pull-left float-left">{lang key='ordersubtotal'}:</span>
                <span class="pull-right float-right">{$carttotals.subtotal}</span>
            </li>
        </ul>
        {if ($carttotals.taxrate && $carttotals.taxtotal) || ($carttotals.taxrate2 && $carttotals.taxtotal2)}
            {if $carttotals.taxrate}
                <div class="clearfix">
                    <span class="pull-left float-left">{$carttotals.taxname} @ {$carttotals.taxrate}%:</span>
                    <span class="pull-right float-right">{$carttotals.taxtotal}</span>
                </div>
            {/if}
            {if $carttotals.taxrate2}
                <div class="clearfix">
                    <span class="pull-left float-left">{$carttotals.taxname2} @ {$carttotals.taxrate2}%:</span>
                    <span class="pull-right float-right">{$carttotals.taxtotal2}</span>
                </div>
            {/if}
        {/if}
    </div>
    <div class="total-due-today">
        <div class="content">
            <span class="amt">{$carttotals.total}</span>
            <span class="total-due-today-text">{lang key='ordertotalduetoday'}</span>
        </div>
    </div>
{/if}
