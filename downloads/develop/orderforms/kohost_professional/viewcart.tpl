{if $checkout}

    {include file="orderforms/$carttpl/checkout.tpl"}

{else}

    <script>
        // Define state tab index value
        var statesTab = 10;
        var stateNotRequired = true;
    </script>
    {include file="orderforms/kohost_professional/common.tpl"}
    <script type="text/javascript" src="{$BASE_PATH_JS}/StatesDropdown.js"></script>

    <div id="order-standard_cart">

        <div class="row">
            <div class="cart-sidebar">

                {include file="orderforms/kohost_professional/sidebar-categories.tpl"}

            </div>
            <div class="cart-body">
                <div class="header-lined">
                    <h2 class="font-size-24">{$LANG.cartreviewcheckout}</h2>
                </div>

                {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

                <div class="row">
                    <div class="col-md-8">

                        {if $promoerrormessage}
                            <div class="alert alert-warning text-center" role="alert">
                                {$promoerrormessage}
                            </div>
                        {elseif $errormessage}
                            <div class="alert alert-danger" role="alert">
                                <p>{$LANG.orderForm.correctErrors}:</p>
                                <ul>
                                    {$errormessage}
                                </ul>
                            </div>
                        {elseif $promotioncode && $rawdiscount eq "0.00"}
                            <div class="alert alert-info text-center" role="alert">
                                {$LANG.promoappliedbutnodiscount}
                            </div>
                        {elseif $promoaddedsuccess}
                            <div class="alert alert-success text-center" role="alert">
                                {$LANG.orderForm.promotionAccepted}
                            </div>
                        {/if}

                        {if $bundlewarnings}
                            <div class="alert alert-warning" role="alert">
                                <strong>{$LANG.bundlereqsnotmet}</strong><br />
                                <ul>
                                    {foreach from=$bundlewarnings item=warning}
                                        <li>{$warning}</li>
                                    {/foreach}
                                </ul>
                            </div>
                        {/if}
                        {if $cartitems > 0}
                            <form method="post" action="{$smarty.server.PHP_SELF}?a=view">

                            <div class="view-cart-items-header">
                                <div class="row">
                                    <div class="{if $showqtyoptions}col-sm-5{else}col-sm-7{/if} col-xs-7 col-7">
                                        {$LANG.orderForm.productOptions}
                                    </div>
                                    {if $showqtyoptions}
                                        <div class="col-sm-2 hidden-xs text-center d-none d-sm-block">
                                            {$LANG.orderForm.qty}
                                        </div>
                                    {/if}
                                    <div class="col-sm-4 col-xs-5 col-5 text-right">
                                        {$LANG.orderForm.priceCycle}
                                    </div>
                                </div>
                            </div>
                            <div class="view-cart-items">

                                    {foreach $products as $num => $product}
                                        <div class="item">
                                            <div class="row">
                                                <div class="{if $showqtyoptions}col-sm-5{else}col-sm-7{/if} col-xs-6">
                                                <span class="item-title">
                                                    {$product.productinfo.groupname} - {$product.productinfo.name}
                                                </span>
                                                    {if $product.domain}
                                                        <span class="item-domain">
                                                        {$product.domain}
                                                    </span>
                                                    {/if}
                                                    {if $product.configoptions}
                                                        <small>
                                                            {foreach key=confnum item=configoption from=$product.configoptions}
                                                                &nbsp;&raquo; {$configoption.name}: {if $configoption.type eq 1 || $configoption.type eq 2}{$configoption.option}{elseif $configoption.type eq 3}{if $configoption.qty}{$configoption.option}{else}{$LANG.no}{/if}{elseif $configoption.type eq 4}{$configoption.qty} x {$configoption.option}{/if}<br />
                                                            {/foreach}
                                                        </small>
                                                    {/if}
                                                </div>
                                                {if $showqtyoptions}
                                                    <div class="col-sm-2 item-qty">
                                                        {if $product.allowqty}
                                                            <input type="number" name="qty[{$num}]" value="{$product.qty}" class="form-control text-center" min="0" />
                                                            <button type="submit" class="btn btn-xs">
                                                                {$LANG.orderForm.update}
                                                            </button>
                                                        {/if}
                                                    </div>
                                                {/if}
                                                <div class="col-sm-3 col-xs-3 item-price">
                                                    <span>{$product.pricing.totalTodayExcludingTaxSetup}/{$product.billingcyclefriendly}</span>

                                                    {if $product.pricing.productonlysetup}
                                                        {$product.pricing.productonlysetup->toPrefixed()} {$LANG.ordersetupfee}
                                                    {/if}
                                                    {if $product.proratadate}<br />({$LANG.orderprorata} {$product.proratadate}){/if}
                                                </div>
                                                <div class="col-sm-2 col-xs-2 actions-prod">
                                                    <div class="cart-actions-item">
                                                        <a href="{$WEB_ROOT}/cart.php?a=confproduct&i={$num}" data-toggle="tooltip" data-original-title="Edit" class="btn btn-link btn-xs edit-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-link btn-xs btn-remove-from-cart" data-toggle="tooltip" data-original-title="Remove" onclick="removeItem('p','{$num}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {foreach $product.addons as $addonnum => $addon}
                                            <div class="item">
                                                <div class="row">
                                                    <div class="{if $showAddonQtyOptions}col-sm-5{else}col-sm-7 col-xs-6{/if}">
                                                    <span class="item-title">
                                                        {$addon.name} - {$LANG.orderaddon}
                                                    </span>
                                                    </div>
                                                    {if $showAddonQtyOptions}
                                                        <div class="col-sm-2 item-qty">
                                                            {if $addon.allowqty === 2}
                                                                <input type="number" name="paddonqty[{$num}][{$addonnum}]" value="{$addon.qty}" class="form-control text-center" min="0" />
                                                                <button type="submit" class="btn btn-xs">
                                                                    {$LANG.orderForm.update}
                                                                </button>
                                                            {/if}
                                                        </div>
                                                    {/if}
                                                    <div class="col-sm-3 col-xs-3 item-price">
                                                        <span>{$addon.totaltoday}/{$addon.billingcyclefriendly}</span>
                                                        {if $addon.setup}{$addon.setup->toPrefixed()} {$LANG.ordersetupfee}{/if}
                                                        {if $addon.isProrated}<br />({$LANG.orderprorata} {$addon.prorataDate}){/if}
                                                    </div>
                                                </div>
                                            </div>
                                        {/foreach}
                                    {/foreach}

                                    {foreach $addons as $num => $addon}
                                        <div class="item">
                                            <div class="row">
                                                <div class="{if $showAddonQtyOptions}col-sm-5{else}col-sm-7 col-xs-6{/if}">
                                                <span class="item-title">
                                                    {$addon.productname} - {$addon.name}
                                                </span>
                                                    {if $addon.domainname}
                                                        <span class="item-domain">
                                                        {$addon.domainname}
                                                    </span>
                                                    {/if}
                                                </div>
                                                {if $showAddonQtyOptions}
                                                    <div class="col-sm-2 item-qty">
                                                        {if $addon.allowqty === 2}
                                                            <input type="number" name="addonqty[{$num}]" value="{$addon.qty}" class="form-control text-center" min="0" />
                                                            <button type="submit" class="btn btn-xs">
                                                                {$LANG.orderForm.update}
                                                            </button>
                                                        {/if}
                                                    </div>
                                                {/if}
                                                <div class="col-sm-3 col-xs-3 item-price">
                                                    <span>{$addon.pricingtext}/{$addon.billingcyclefriendly}</span>
                                                    {if $addon.setup}{$addon.setup->toPrefixed()} {$LANG.ordersetupfee}{/if}
                                                    {if $addon.isProrated}<br />({$LANG.orderprorata} {$addon.prorataDate}){/if}
                                                </div>
                                                <div class="col-sm-2 col-xs-2 actions-prod">
                                                    <div class="cart-actions-item">
                                                        <button type="button" class="btn btn-link btn-xs btn-remove-from-cart" data-toggle="tooltip" data-original-title="Remove" onclick="removeItem('a','{$num}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}

                                    {foreach $domains as $num => $domain}
                                        <div class="item">
                                            <div class="row">
                                                <div class="col-sm-7 col-xs-6">
                                                <span class="item-title">
                                                    {if $domain.type eq "register"}{$LANG.orderdomainregistration}{else}{$LANG.orderdomaintransfer}{/if}
                                                </span>
                                                    {if $domain.domain}
                                                        <span class="item-domain">
                                                        {$domain.domain}
                                                    </span>
                                                    {/if}
                                                    <ul class="addon-item-icon mb-0">
                                                        {if $domain.dnsmanagement}
                                                            <li>{$LANG.domaindnsmanagement}</li>
                                                        {/if}
                                                        {if $domain.emailforwarding}
                                                            <li>{$LANG.domainemailforwarding}</li>
                                                        {/if}
                                                        {if $domain.idprotection}
                                                            <li>{$LANG.domainidprotection}</li>
                                                        {/if}
                                                    </ul>
                                                </div>
                                                <div class="col-sm-3 col-xs-3 item-price">
                                                    {if count($domain.pricing) == 1 || $domain.type == 'transfer'}
                                                        <span name="{$domain.domain}Price">{$domain.price}/{$domain.regperiod} {$domain.yearsLanguage}</span>
                                                        <span class="renewal cycle">
                                                        {if isset($domain.renewprice)}{lang key='domainrenewalprice'} <span class="renewal-price cycle">{$domain.renewprice->toPrefixed()}{$domain.shortRenewalYearsLanguage}{/if}</span>
                                                    </span>
                                                    {else}
                                                        <span name="{$domain.domain}Price">{$domain.price}</span>
                                                        <div class="dropdown renewal-item">
                                                            <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="{$domain.domain}Pricing" name="{$domain.domain}Pricing" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                {$domain.regperiod} {$domain.yearsLanguage}
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="{$domain.domain}Pricing">
                                                                {foreach $domain.pricing as $years => $price}
                                                                    <li>
                                                                        <a href="#" onclick="selectDomainPeriodInCart('{$domain.domain}', '{$price.register}', {$years}, '{if $years == 1}{lang key='orderForm.year'}{else}{lang key='orderForm.years'}{/if}');return false;">
                                                                            {$years} {if $years == 1}{lang key='orderForm.year'}{else}{lang key='orderForm.years'}{/if} @ {$price.register}
                                                                        </a>
                                                                    </li>
                                                                {/foreach}
                                                            </ul>
                                                        </div>
                                                        <span class="renewal cycle">
                                                        {lang key='domainrenewalprice'} <span class="renewal-price cycle">{if isset($domain.renewprice)}{$domain.renewprice->toPrefixed()}{$domain.shortRenewalYearsLanguage}{/if}</span>
                                                    </span>
                                                    {/if}
                                                </div>
                                                <div class="col-sm-2 col-xs-2 actions-prod">
                                                    <div class="cart-actions-item">
                                                        <a href="{$WEB_ROOT}/cart.php?a=confdomains" data-toggle="tooltip" data-original-title="Edit" class="btn btn-link btn-xs edit-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-link btn-xs btn-remove-from-cart" data-toggle="tooltip" data-original-title="Remove" onclick="removeItem('d','{$num}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}

                                    {foreach $renewals as $num => $domain}
                                        <div class="item">
                                            <div class="row">
                                                <div class="col-sm-7 col-xs-6">
                                                <span class="item-title">
                                                    {$LANG.domainrenewal}
                                                </span>
                                                    <span class="item-domain">
                                                    {$domain.domain}
                                                </span>
                                                    <ul class="addon-item-icon mb-0">
                                                        {if $domain.dnsmanagement}
                                                            <li>{$LANG.domaindnsmanagement}</li>
                                                        {/if}
                                                        {if $domain.emailforwarding}
                                                            <li>{$LANG.domainemailforwarding}</li>
                                                        {/if}
                                                        {if $domain.idprotection}
                                                            <li>{$LANG.domainidprotection}</li>
                                                        {/if}
                                                    </ul>
                                                </div>
                                                <div class="col-sm-3 col-xs-3 item-price">
                                                    <span>{$domain.price}/{$domain.regperiod} {$LANG.orderyears}</span>
                                                </div>
                                                <div class="col-sm-2 col-xs-2 actions-prod">
                                                    <div class="cart-actions-item">
                                                        <button type="button" class="btn btn-link btn-xs btn-remove-from-cart" data-toggle="tooltip" data-original-title="Remove" onclick="removeItem('r','{$num}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}

                                    {foreach $upgrades as $num => $upgrade}
                                        <div class="item">
                                            <div class="row">
                                                <div class="{if $showUpgradeQtyOptions}col-sm-5{else}col-sm-7{/if}">
                                                <span class="item-title">
                                                    <strong>
                                                         {if $upgrade->type == 'service'}
                                                             {$upgrade->originalProduct->productGroup->name}<br>{$upgrade->originalProduct->name} => {$upgrade->newProduct->name}
                                                         {elseif $upgrade->type == 'addon'}
                                                             {$upgrade->originalAddon->name} => {$upgrade->newAddon->name}
                                                         {/if}
                                                    </strong>
                                                    {$LANG.upgrade}
                                                </span>
                                                    <span class="item-domain">
                                                    {if $upgrade->type == 'service'}
                                                        {$upgrade->service->domain}
                                                    {/if}
                                                </span>
                                                </div>
                                                {if $showUpgradeQtyOptions}
                                                    <div class="col-sm-2 item-qty">
                                                        {if $upgrade->allowMultipleQuantities}
                                                            <input type="number" name="upgradeqty[{$num}]" value="{$upgrade->qty}" class="form-control text-center" min="{$upgrade->minimumQuantity}" />
                                                            <button type="submit" class="btn btn-xs">
                                                                {$LANG.orderForm.update}
                                                            </button>
                                                        {/if}
                                                    </div>
                                                {/if}
                                                <div class="col-sm-3 col-xs-3 item-price">
                                                    <span>{$upgrade->newRecurringAmount}/{$upgrade->localisedNewCycle}</span>
                                                </div>
                                                <div class="col-sm-2 col-xs-2 actions-prod">
                                                    <div class="cart-actions-item">
                                                        <button type="button" class="btn btn-link btn-xs btn-remove-from-cart" data-toggle="tooltip" data-original-title="Remove" onclick="removeItem('u','{$num}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            {if $upgrade->totalDaysInCycle > 0}
                                                <div class="row row-upgrade-credit">
                                                    <div class="col-sm-7">
                                                    <span class="item-group">
                                                        {$LANG.upgradeCredit}
                                                    </span>
                                                        <div class="upgrade-calc-msg">
                                                            {lang key="upgradeCreditDescription" daysRemaining=$upgrade->daysRemaining totalDays=$upgrade->totalDaysInCycle}
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 item-price">
                                                        <span>-{$upgrade->creditAmount}</span>
                                                    </div>
                                                </div>
                                            {/if}
                                        </div>
                                    {/foreach}

                                    {if $cartitems == 0}
                                        <div class="view-cart-empty">
                                            {$LANG.cartempty}
                                        </div>
                                    {/if}

                                </div>
                                {if $cartitems > 0}
                                    <div class="empty-cart">
                                        <button type="button" class="btn btn-xs" id="btnEmptyCart">
                                            <i class="fas fa-trash"></i>
                                            <span>{$LANG.emptycart}</span>
                                        </button>
                                    </div>
                                {/if}


                            </form>
                        {else}
                            {include file="$template/includes/no-data.tpl" msg="Your Shopping Cart is Empty" btnText="Start Shopping" btnUrl="cart.php" btnClass="primary-solid-btn"}
                        {/if}
                        {foreach $hookOutput as $output}
                            <div>
                                {$output}
                            </div>
                        {/foreach}

                        {foreach $gatewaysoutput as $gatewayoutput}
                            <div class="view-cart-gateway-checkout">
                                {$gatewayoutput}
                            </div>
                        {/foreach}
                        {if $cartitems > 0}
                            <div class="view-cart-tabs">
                                <h5>{$LANG.orderForm.applyPromoCode}</h5>
                                <div role="tabpanel" class="tab-pane active promo" id="applyPromo">
                                    {if $promotioncode}
                                        <div class="view-cart-promotion-code">
                                            {$promotioncode} - {$promotiondescription}
                                        </div>
                                        <div class="text-center">
                                            <a href="{$WEB_ROOT}/cart.php?a=removepromo" class="btn outline-btn btn-sm">
                                                {$LANG.orderForm.removePromotionCode}
                                            </a>
                                        </div>
                                    {else}
                                        <form method="post" action="{$WEB_ROOT}/cart.php?a=view">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group prepend-icon ">
                                                        <input type="text" name="promocode" id="inputPromotionCode" class="field form-control" placeholder="{lang key="orderPromoCodePlaceholder"}" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" name="validatepromo" class="btn outline-btn btn-block" value="{$LANG.orderpromovalidatebutton}">
                                                        {$LANG.orderpromovalidatebutton}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    {/if}
                                </div>
                                {if $taxenabled && !$loggedin}
                                    <h5>{$LANG.orderForm.estimateTaxes}</h5>
                                    <div role="tabpanel" class="tab-pane" id="calcTaxes">
                                        <form method="post" action="{$WEB_ROOT}/cart.php?a=setstateandcountry">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" name="state" id="inputState" value="{$clientsdetails.state}" placeholder="State" class="form-control"{if $loggedin} disabled="disabled"{/if} />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="country" id="inputCountry" class="form-control">
                                                            {foreach $countries as $countrycode => $countrylabel}
                                                                <option value="{$countrycode}"{if (!$country && $countrycode == $defaultcountry) || $countrycode eq $country} selected{/if}>
                                                                    {$countrylabel}
                                                                </option>
                                                            {/foreach}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group text-center">
                                                        <button type="submit" class="btn primary-solid-btn btn-block">
                                                            {$LANG.orderForm.updateTotals}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                {/if}

                            </div>
                        {/if}
                    </div>
                    <div class="col-md-4" id="scrollingPanelContainer">

                        <div class="order-summary" id="orderSummary">
                            <div class="loader" id="orderSummaryLoader" style="display: none;">
                                <i class="fas fa-fw fa-sync fa-spin"></i>
                            </div>
                            <h2>{$LANG.ordersummary}</h2>
                            <div class="summary-container">

                                <ul class="order-summary-list">
                                    <li class="summary-list-item">
                                        <span class="pull-left">{$LANG.ordersubtotal}</span>
                                        <span id="subtotal" class="pull-right">{$subtotal}</span>
                                    </li>
                                </ul>
                                {if $promotioncode || $taxrate || $taxrate2}
                                    <div class="bordered-totals">
                                        {if $promotioncode}
                                            <ul class="order-summary-list">
                                                <li class="summary-list-item">
                                                    <span class="pull-left">{$promotiondescription}</span>
                                                    <span id="discount" class="pull-right">{$discount}</span>
                                                </li>
                                            </ul>
                                        {/if}
                                        {if $taxrate}
                                            <ul class="order-summary-list">
                                                <li class="summary-list-item">
                                                    <span class="pull-left">{$taxname} @ {$taxrate}%</span>
                                                    <span id="taxTotal1" class="pull-right">{$taxtotal}</span>
                                                </li>
                                            </ul>
                                        {/if}
                                        {if $taxrate2}
                                            <ul class="order-summary-list">
                                                <li class="summary-list-item">
                                                    <span class="pull-left">{$taxname2} @ {$taxrate2}%</span>
                                                    <span id="taxTotal2" class="pull-right">{$taxtotal2}</span>
                                                </li>
                                            </ul>
                                        {/if}
                                    </div>
                                {/if}

                                <ul id="recurring" class="order-summary-list">
                                    <li class="summary-list-item faded">
                                        <span class="pull-left">{$LANG.orderForm.totals}</span>
                                    </li>
                                    <span class="summary-list-item" id="recurringMonthly" {if !$totalrecurringmonthly}style="display:none;"{/if}>
                                        <small class="pull-left">{$LANG.orderpaymenttermmonthly}</small>
                                        <span class="cost pull-right">{$totalrecurringmonthly}</span>
                                    </span>
                                    <span class="summary-list-item" id="recurringQuarterly" {if !$totalrecurringquarterly}style="display:none;"{/if}>
                                        <small>{$LANG.orderpaymenttermquarterly}</small>
                                        <span class="cost pull-right">{$totalrecurringquarterly}</span>
                                    </span>
                                    <span class="summary-list-item" id="recurringSemiAnnually" {if !$totalrecurringsemiannually}style="display:none;"{/if}>
                                        <small class="pull-left">{$LANG.orderpaymenttermsemiannually}</small>
                                        <span class="cost pull-right">{$totalrecurringsemiannually}</span>
                                    </span>
                                    <span class="summary-list-item" id="recurringAnnually" {if !$totalrecurringannually}style="display:none;"{/if}>
                                        <small class="pull-left">{$LANG.orderpaymenttermannually}</small>
                                        <span class="cost pull-right">{$totalrecurringannually}</span>
                                    </span>
                                    <span class="summary-list-item" id="recurringBiennially" {if !$totalrecurringbiennially}style="display:none;"{/if}>
                                        <small class="pull-left">{$LANG.orderpaymenttermbiennially}</small>
                                        <span class="cost pull-right">{$totalrecurringbiennially}</span>
                                    </span>
                                    <span class="summary-list-item" id="recurringTriennially" {if !$totalrecurringtriennially}style="display:none;"{/if}>
                                        <small class="pull-left">{$LANG.orderpaymenttermtriennially}</small>
                                        <span class="cost pull-right">{$totalrecurringtriennially}</span>
                                    </span>
                                </ul>


                                <div class="total-due-today total-due-today-padded">
                                    <div class="content">
                                        <span id="totalDueToday" class="amt">{$total}</span>
                                        <span class="total-due-today-text">{$LANG.ordertotalduetoday}</span>
                                    </div>
                                </div>

                                <div class="express-checkout-buttons">
                                    {foreach $expressCheckoutButtons as $checkoutButton}
                                        {$checkoutButton}
                                        <div class="separator">
                                            - {$LANG.or|strtoupper} -
                                        </div>
                                    {/foreach}
                                </div>

                                <div class="order-summary-actions">
                                    <a href="{$WEB_ROOT}/cart.php?a=checkout&e=false" class="btn btn-block btn-checkout{if $cartitems == 0} disabled{/if}" id="checkout">
                                        {$LANG.orderForm.checkout}
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                <a href="{$WEB_ROOT}/cart.php" class="btn btn-link btn-continue-shopping btn-xs" id="continueShopping">
                                    <i class="fas fa-reply"></i> {$LANG.orderForm.continueShopping}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="{$WEB_ROOT}/cart.php">
            <input type="hidden" name="a" value="remove" />
            <input type="hidden" name="r" value="" id="inputRemoveItemType" />
            <input type="hidden" name="i" value="" id="inputRemoveItemRef" />
            <div class="modal fade modal-remove-item" id="modalRemoveItem" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="{$LANG.orderForm.close}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">
                                <i class="fas fa-times fa-3x"></i>
                                <span>{$LANG.orderForm.removeItem}</span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            {$LANG.cartremoveitemconfirm}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn outline-btn" data-dismiss="modal">{$LANG.no}</button>
                            <button type="submit" class="btn primary-solid-btn">{$LANG.yes}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="post" action="{$WEB_ROOT}/cart.php">
            <input type="hidden" name="a" value="empty" />
            <div class="modal fade modal-remove-item" id="modalEmptyCart" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="{$LANG.orderForm.close}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">
                                <i class="fas fa-trash-alt fa-3x"></i>
                                <span>{$LANG.emptycart}</span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            {$LANG.cartemptyconfirm}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn outline-btn" data-dismiss="modal">{$LANG.no}</button>
                            <button type="submit" class="btn primary-solid-btn">{$LANG.yes}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
{/if}
