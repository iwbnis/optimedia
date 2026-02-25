{include file="orderforms/{$carttpl}/common.tpl"}
<link rel="stylesheet" href="/templates/hostx-child/templates/orderforms/hostx_cart/css/configureproduct-custom.css?v=1708800006">
<input type="hidden" id="whmcsLoggedIn" value="{if $loggedin}1{else}0{/if}">
<div class="cp-enhanced">
<script>
var _localLang = {
    'addToCart': '{$LANG.orderForm.addToCart|escape}',
    'addedToCartRemove': '{$LANG.orderForm.addedToCartRemove|escape}'
}
</script>
<div id="order-standard_cart" class="hostx-cart-body-section">
    {include file="orderforms/{$carttpl}/product-group-list.tpl"}
    <div class="row configure-product-page">
        <div class="cart-body">
            <form id="frmConfigureProduct">
                <input type="hidden" name="configure" value="true" />
                <input type="hidden" name="i" value="{$i}" />
                    <div class="row">
                        <div class="secondary-cart-body">

                            {* --- Step Indicator --- *}
                            <div class="cp-step-indicator">
                                <div class="cp-step active">
                                    <div class="cp-step-circle">1</div>
                                    <span class="cp-step-label">Configure</span>
                                </div>
                                <div class="cp-step-line"></div>
                                <div class="cp-step">
                                    <div class="cp-step-circle">2</div>
                                    <span class="cp-step-label">Review</span>
                                </div>
                                <div class="cp-step-line"></div>
                                <div class="cp-step">
                                    <div class="cp-step-circle">3</div>
                                    <span class="cp-step-label">Checkout</span>
                                </div>
                            </div>

                            {* --- Heading Area --- *}
                            <div class="cp-heading-area">
                                <h1 class="cp-title">Build Your <span class="cp-gradient-text">OptiMedia</span> Package</h1>
                                <p class="cp-subtitle">Customize your IPTV service below</p>
                            </div>

                            <div class="alert alert-danger w-hidden" role="alert" id="containerProductValidationErrors">
                                <p>{$LANG.orderForm.correctErrors}:</p>
                                <ul id="containerProductValidationErrorsList"></ul>
                            </div>

                            {* --- Billing cycle (hidden by CSS, used for WHMCS internal tracking) --- *}
                            {if $pricing.type eq "recurring"}
                                <div class="field-container billing-cycle-styled">
                                    <div class="sub-heading">
                                        <span class="primary-bg-color">{$LANG.cartchoosecycle}</span>
                                    </div>
                                    <div class="select-billing-cycle">
                                        <ul class="selectBillingCycleHostxCart">
                                            {if $pricing.monthly}
                                                <li {if $billingcycle eq 'monthly'} class="active"{/if}>
                                                    <input type="radio" name="billingcycle" class="no-icheck w-hidden" value="monthly" {if $billingcycle eq "monthly"} checked{/if} actionCall ="{if $configurableoptions}{$i}{else}callHostxCartSummary{/if}" />
                                                    <strong>{$LANG.orderpaymenttermmonthly}</strong>
                                                    <span>{$pricing.minprice.price->format('{literal}{PREFIX}{/literal}')}{$pricing.rawpricing.monthly}{$pricing.minprice.price->format('{literal}{SUFFIX}{/literal}')}</span>
                                                </li>
                                            {/if}
                                            {if $pricing.quarterly}
                                                <li {if $billingcycle eq 'quarterly'} class="active"{/if}>
                                                    <input type="radio" name="billingcycle" class="no-icheck w-hidden"  value="quarterly" {if $billingcycle eq "quarterly"} checked{/if} actionCall ="{if $configurableoptions}{$i}{else}callHostxCartSummary{/if}" />
                                                    <strong>{$LANG.orderpaymenttermquarterly}</strong>
                                                    <span>{$pricing.minprice.price->format('{literal}{PREFIX}{/literal}')}{$pricing.rawpricing.quarterly}{$pricing.minprice.price->format('{literal}{SUFFIX}{/literal}')}</span>
                                                </li>
                                            {/if}
                                            {if $pricing.semiannually}
                                                <li {if $billingcycle eq 'semiannually'} class="active"{/if}>
                                                    <input type="radio" name="billingcycle" class="no-icheck w-hidden"  value="semiannually" {if $billingcycle eq "semiannually"} checked{/if} actionCall ="{if $configurableoptions}{$i}{else}callHostxCartSummary{/if}" />
                                                    <strong>{$LANG.orderpaymenttermsemiannually}</strong>
                                                    <span>{$pricing.minprice.price->format('{literal}{PREFIX}{/literal}')}{$pricing.rawpricing.semiannually}{$pricing.minprice.price->format('{literal}{SUFFIX}{/literal}')}</span>
                                                </li>
                                            {/if}
                                            {if $pricing.annually}
                                                <li {if $billingcycle eq 'annually'} class="active"{/if}>
                                                    <input type="radio" name="billingcycle" class="no-icheck w-hidden" value="annually" {if $billingcycle eq "annually"} checked{/if} actionCall ="{if $configurableoptions}{$i}{else}callHostxCartSummary{/if}" />
                                                    <strong>{$LANG.orderpaymenttermannually}</strong>
                                                    <span>{$pricing.minprice.price->format('{literal}{PREFIX}{/literal}')}{$pricing.rawpricing.annually}{$pricing.minprice.price->format('{literal}{SUFFIX}{/literal}')}</span>
                                                </li>
                                            {/if}
                                            {if $pricing.biennially}
                                                <li {if $billingcycle eq 'biennially'} class="active"{/if}>
                                                    <input type="radio" name="billingcycle" class="no-icheck w-hidden"  value="biennially" {if $billingcycle eq "biennially"} checked{/if} actionCall ="{if $configurableoptions}{$i}{else}callHostxCartSummary{/if}" />
                                                    <strong>{$LANG.orderpaymenttermbiennially}</strong>
                                                    <span>{$pricing.minprice.price->format('{literal}{PREFIX}{/literal}')}{$pricing.rawpricing.biennially}{$pricing.minprice.price->format('{literal}{SUFFIX}{/literal}')}</span>
                                                </li>
                                            {/if}
                                            {if $pricing.triennially}
                                                <li {if $billingcycle eq 'triennially'} class="active"{/if}>
                                                    <input type="radio" name="billingcycle" class="no-icheck w-hidden" value="triennially" {if $billingcycle eq "triennially"} checked{/if} actionCall ="{if $configurableoptions}{$i}{else}callHostxCartSummary{/if}" />
                                                    <strong>{$LANG.orderpaymenttermtriennially}</strong>
                                                    <span>{$pricing.minprice.price->format('{literal}{PREFIX}{/literal}')}{$pricing.rawpricing.triennially}{$pricing.minprice.price->format('{literal}{SUFFIX}{/literal}')}</span>
                                                </li>
                                            {/if}
                                        </ul>
                                    </div>
                                </div>
                            {/if}

                            {* --- Configurable Options (hidden by CSS) --- *}
                            {if $configurableoptions}
                                <div class="product-configurable-options" id="productConfigurableOptions" style="display:none;">
                                    <div class="sub-heading">
                                        <span class="primary-bg-color">{$LANG.orderconfigpackage}</span>
                                    </div>
                                    <div class="row">
                                        {foreach $configurableoptions as $num => $configoption}
                                        {if $configoption.optiontype eq 1}
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputConfigOption{$configoption.id}">{$configoption.optionname}</label>
                                                    <select name="configoption[{$configoption.id}]" id="inputConfigOption{$configoption.id}" class="form-control">
                                                        {foreach key=num2 item=options from=$configoption.options}
                                                            <option value="{$options.id}"{if $configoption.selectedvalue eq $options.id} selected="selected"{/if}>
                                                                {$options.name}
                                                            </option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                        {elseif $configoption.optiontype eq 2}
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputConfigOption{$configoption.id}">{$configoption.optionname}</label>
                                                    {foreach key=num2 item=options from=$configoption.options}
                                                        <br />
                                                        <label>
                                                            <input type="radio" name="configoption[{$configoption.id}]" value="{$options.id}"{if $configoption.selectedvalue eq $options.id} checked="checked"{/if} />
                                                            {if $options.name}
                                                                {$options.name}
                                                            {else}
                                                                {$LANG.enable}
                                                            {/if}
                                                        </label>
                                                    {/foreach}
                                                </div>
                                            </div>
                                        {elseif $configoption.optiontype eq 3}
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputConfigOption{$configoption.id}">{$configoption.optionname}</label>
                                                    <br />
                                                    <label>
                                                        <input type="checkbox" name="configoption[{$configoption.id}]" id="inputConfigOption{$configoption.id}" value="1"{if $configoption.selectedqty} checked{/if} />
                                                        {if $configoption.options.0.name}
                                                            {$configoption.options.0.name}
                                                        {else}
                                                            {$LANG.enable}
                                                        {/if}
                                                    </label>
                                                </div>
                                            </div>
                                        {elseif $configoption.optiontype eq 4}
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputConfigOption{$configoption.id}">{$configoption.optionname}</label>
                                                    <input type="number" name="configoption[{$configoption.id}]" value="{if $configoption.selectedqty}{$configoption.selectedqty}{else}{$configoption.qtyminimum}{/if}" id="inputConfigOption{$configoption.id}" min="{$configoption.qtyminimum}" class="form-control form-control-qty" />
                                                </div>
                                            </div>
                                        {/if}
                                        {if $num % 2 != 0}
                                    </div>
                                    <div class="row">
                                        {/if}
                                        {/foreach}
                                    </div>
                                </div>
                            {/if}

                            {* --- Custom fields (hidden, kept for WHMCS form submission) --- *}
                            {if $customfields}
                                <div class="custom-field-configure-product" style="display:none;">
                                    <div class="field-container">
                                        {foreach $customfields as $customfield}
                                            <div class="form-group">
                                                <label for="customfield{$customfield.id}">{$customfield.name}</label>
                                                {$customfield.input}
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            {/if}

                            {* ============================================================ *}
                            {* === SERVICE TYPE SELECTION (visual cards)                 === *}
                            {* ============================================================ *}
                            <input type="hidden" id="selectserviceType" name="selectserviceType" value="Select Service">

                            <div class="cp-service-cards">
                                <div class="service-type-card" data-value="Create new service" onclick="selectServiceCard('Create new service', this)">
                                    <div class="stc-icon-wrap purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    </div>
                                    <h4>New Service</h4>
                                    <p>Set up a new IPTV subscription</p>
                                </div>
                                <div class="service-type-card" data-value="Renew Existing Service" onclick="selectServiceCard('Renew Existing Service', this)">
                                    <div class="stc-icon-wrap teal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                    </div>
                                    <h4>Renew Service</h4>
                                    <p>Extend your existing subscription</p>
                                </div>
                                <div class="service-type-card" data-value="Reseller" onclick="selectServiceCard('Reseller', this)">
                                    <div class="stc-icon-wrap pink">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    </div>
                                    <h4>Reseller</h4>
                                    <p>Start selling IPTV as a reseller</p>
                                </div>
                            </div>

                            {* --- Login popup modal --- *}
                            <div class="modal fade" id="loginPopupModal" tabindex="-1" aria-labelledby="loginPopupModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered login-popup-dialog">
                                <div class="modal-content login-popup-content">
                                  <button type="button" class="login-popup-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                  <div class="login-popup-body">
                                    <div class="login-popup-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#083C72" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        <circle cx="12" cy="16" r="1"></circle>
                                      </svg>
                                    </div>
                                    <h4 class="login-popup-title">Login Required</h4>
                                    <p class="login-popup-subtitle">Please sign in to your account to renew an existing service.</p>
                                    <div class="login-popup-actions">
                                      <a href="{$WEB_ROOT}/login" class="login-popup-btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;vertical-align:-3px;">
                                          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                          <polyline points="10 17 15 12 10 7"></polyline>
                                          <line x1="15" y1="12" x2="3" y2="12"></line>
                                        </svg>
                                        Sign In
                                      </a>
                                      <button type="button" class="login-popup-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            {* --- Channel List Preview (always accessible) --- *}
                            <div class="cp-channel-preview">
                                <button type="button" class="btn btn-block cp-btn-gradient"
                                        data-toggle="modal" data-target="#channelListModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:-2px;"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                    View Channel List
                                </button>
                                <p class="cp-channel-hint">Browse 14,000+ channels before you configure your package</p>
                            </div>

                            {* --- Account Selector (Renew flow, outside configOptions) --- *}
                            <div id="userServicesDiv" style="display:none;">
                                <div class="cp-form-group">
                                    <div class="cp-group-header teal">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </div>
                                        <h3>Select Your Account</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group user-log">
                                                    <label for="userServices">Account</label>
                                                    <select id="userServices" class="form-control select-inline custom-select">
                                                        <option value="">Select account</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {* ============================================================ *}
                            {* === MAIN CONFIG OPTIONS (grouped sections)               === *}
                            {* ============================================================ *}
                            <div class="product-configurable-options-custom" id="productConfigOptionsCustom" style="display:none;">

                                {* Provider auto-selected (single provider: Edge) *}
                                <input type="hidden" id="inputProvider" value="">
                                <input type="hidden" id="selectedChannels" name="selected_channels" value="">

                                {* --- Group 1: Package Details --- *}
                                <div class="cp-form-group" id="cpGroup1">
                                    <div class="cp-group-header purple">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                        </div>
                                        <h3>Package Details</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div class="row">
                                            <div class="col-sm-6" id="fieldDevice">
                                                <div class="form-group">
                                                    <label for="inputConfigOption15Device">Your Device
                                                        <span class="cp-info-icon" data-tooltip="Select the device you'll use to watch. This ensures the best compatible app and setup instructions.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <select name="configoptionDevice" id="inputConfigOption15Device" class="form-control select-inline custom-select">
                                                        <option value="">-- Select --</option>
                                                        <option value="Firestick">Firestick</option>
                                                        <option value="MAG">MAG</option>
                                                        <option value="Android">Android</option>
                                                        <option value="Apple">Apple</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 cp-field-locked" id="fieldPackageType">
                                                <div class="form-group">
                                                    <label for="inputPackageType">Package Type
                                                        <span class="cp-info-icon" data-tooltip="Select the channel package region. Choice includes all countries worldwide.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <select id="inputPackageType" class="form-control select-inline custom-select">
                                                        <option value="">-- Select --</option>
                                                        <option value="CHOICE" title="14,000+ channels from every country worldwide. Our most popular all-in-one package.">Choice (All Countries)</option>
                                                        <option value="AMERICAS TV" title="10,000+ channels focused on USA, Canada & Latin America with premium sports.">Americas</option>
                                                        <option value="CANADA PREMIUM TV" title="8,000+ Canadian channels including local & regional sports and French content.">Canada Premium</option>
                                                        <option value="USA PREMIUM TV" title="US-focused package with all major networks, sports, news and entertainment.">USA Premium</option>
                                                        <option value="ENGLISH COUNTRIES TV" title="Channels from USA, Canada, UK, Australia & other English-speaking countries.">English Countries</option>
                                                        <option value="USA-CAN-UK" title="Combined package covering USA, Canada and UK channels.">USA-CAN-UK</option>
                                                    </select>
                                                    <small id="packageTypeInfo" class="cp-option-info"></small>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 cp-field-locked" id="fieldAdult">
                                                <div class="form-group">
                                                    <label for="inputAdult">Include Adult Content
                                                        <span class="cp-info-icon" data-tooltip="Choose whether to include 18+ adult channels in your package.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <select id="inputAdult" class="form-control select-inline custom-select">
                                                        <option value="">-- Select --</option>
                                                        <option value="ADULT">Yes</option>
                                                        <option value="NO ADULT">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 cp-field-locked" id="fieldDuration">
                                                <div class="form-group">
                                                    <label for="inputDuration">Duration
                                                        <span class="cp-info-icon" data-tooltip="How long your subscription will last. Longer plans offer better value.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <select id="inputDuration" class="form-control select-inline custom-select">
                                                        <option value="">-- Select --</option>
                                                        <option value="1 Month">1 Month</option>
                                                        <option value="3 Months">3 Months</option>
                                                        <option value="6 Months">6 Months</option>
                                                        <option value="12 Months">12 Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 cp-field-locked" id="fieldConnections">
                                                <div class="form-group">
                                                    <label for="inputConnections">Number of Connections
                                                        <span class="cp-info-icon" data-tooltip="How many devices can stream simultaneously. Each connection allows one device to watch at a time.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <select id="inputConnections" class="form-control select-inline custom-select">
                                                        <option value="">-- Select --</option>
                                                        <option value="1 Connection">1</option>
                                                        <option value="2 Connections">2</option>
                                                        <option value="3 Connections">3</option>
                                                        <option value="4 Connections">4</option>
                                                        <option value="5 Connections">5</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 cp-field-locked" id="fieldPackage">
                                                <div class="form-group">
                                                    <label for="selectedProductId">IPTV Package / Product
                                                        <span class="cp-info-icon" data-tooltip="Your package is auto-matched based on your selections above. You can also manually choose a different package.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <select id="selectedProductId" name="selectedProductId" class="form-control select-inline custom-select">
                                                        <option value="">Select Package / Product</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {* --- MAG Address (shown when device=MAG and package selected) --- *}
                                            <div class="col-sm-6" id="magAddress" style="display:none;">
                                                <div class="form-group">
                                                    <label for="magIp">MAG Address
                                                        <span class="cp-info-icon" data-tooltip="Enter your MAG device MAC address. Format: 00:1A:79:XX:XX:XX. Found in your MAG device settings.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                                        </span>
                                                    </label>
                                                    <input type="text" id="magIp" name="magIp" class="form-control" placeholder="00:1A:79:XX:XX:XX" maxlength="17">
                                                    <div id="magError" style="color:red; display:none; font-size:12px; margin-top:4px;">Invalid MAG Address</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {* --- Group 2: Channels & Customization --- *}
                                <div class="cp-form-group cp-locked" id="cpGroup2">
                                    <div class="cp-group-header teal">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                        </div>
                                        <h3>Channels & Customization</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group mb-sm-0">
                                                    <button type="button" onclick="openBouquetModal()"
                                                            class="btn btn-primary btn-block cp-btn-gradient">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:-2px;"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                                        Customize Channels
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="selectedChannelsDisplay" class="mt-3"></div>
                                    </div>
                                </div>

                                {* --- Group 3: Payment & Add-ons --- *}
                                <div class="cp-form-group cp-locked" id="cpGroup3">
                                    <div class="cp-group-header purple">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                        </div>
                                        <h3>Payment & Add-ons</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div class="row">
                                            <input type="hidden" name="billing_cycle" id="billing_cycle" value="monthly">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="vpnToggle">Add VPN (Optional)</label><br>
                                                    <label class="cp-toggle-switch">
                                                        <input type="checkbox" id="vpnToggle" name="addVpn" value="1">
                                                        <span class="cp-toggle-slider">
                                                            <span class="cp-toggle-knob"></span>
                                                        </span>
                                                    </label>
                                                    <small class="form-text text-muted">Toggle to include VPN add-on</small>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="androidProducts">Add Android IPTV Box</label>
                                                    <select id="androidProducts" class="form-control">
                                                        <option value="">None</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {* --- Group 4: Account Details --- *}
                                <div class="cp-form-group cp-locked" id="cpGroup4">
                                    <div class="cp-group-header teal">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </div>
                                        <h3>Account Details</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div id="loginDetails">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group user-log position-relative">
                                                        <label for="username">Username *</label>
                                                        <input type="text" placeholder="username" id="username" name="username" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group user-log position-relative">
                                                        <label for="password">Password *</label>
                                                        <input type="password" id="password" name="password" class="form-control pe-5">
                                                        <span class="toggle-password" onclick="togglePassword()"
                                                              style="position:absolute; right:18px; top:48px; cursor:pointer;">
                                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                                 fill="none" stroke="currentColor" stroke-width="2"
                                                                 stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="generate-btn" id="generatePassword">Generate Password</button>
                                        </div>

                                    </div>
                                </div>

                            </div>{* end productConfigOptionsCustom *}

                            {* ============================================================ *}
                            {* === RESELLER CONFIG OPTIONS (shown when service = Reseller) === *}
                            {* ============================================================ *}
                            <div class="product-configurable-options-custom" id="resellerConfigOptions" style="display:none;">

                                {* --- Reseller Group 1: Package --- *}
                                <div class="cp-form-group">
                                    <div class="cp-group-header purple">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                        </div>
                                        <h3>Reseller Package</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="resellerPackage">Reseller Package</label>
                                                    <select id="resellerPackage" class="form-control select-inline custom-select">
                                                        <option value="">Select Reseller Package</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6" id="resellerBillingCycleWrap" style="display:none;">
                                                <div class="form-group">
                                                    <label for="resellerBillingCycle">Payment Terms</label>
                                                    <select id="resellerBillingCycle" class="form-control select-inline custom-select">
                                                        <option value="monthly" selected>Monthly</option>
                                                        <option value="quarterly">Quarterly</option>
                                                        <option value="semiannually">Semi-Annually</option>
                                                        <option value="annually">Annually</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {* --- Reseller Group 2: Account Details --- *}
                                <div class="cp-form-group">
                                    <div class="cp-group-header teal">
                                        <div class="cp-group-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </div>
                                        <h3>Account Details</h3>
                                    </div>
                                    <div class="cp-group-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group user-log position-relative">
                                                    <label for="resellerUsername">Username *</label>
                                                    <input type="text" placeholder="username" id="resellerUsername" name="resellerUsername" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group user-log position-relative">
                                                    <label for="resellerPassword">Password *</label>
                                                    <input type="password" id="resellerPassword" name="resellerPassword" class="form-control pe-5">
                                                    <span class="toggle-password" onclick="toggleResellerPassword()"
                                                          style="position:absolute; right:18px; top:48px; cursor:pointer;">
                                                        <svg id="resellerEyeIcon" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                             fill="none" stroke="currentColor" stroke-width="2"
                                                             stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="generate-btn" id="resellerGeneratePassword">Generate Password</button>
                                    </div>
                                </div>

                            </div>{* end resellerConfigOptions *}

                            {* --- Account Action Modal (Renew) --- *}
                            <div class="modal fade" id="accountActionModal" tabindex="-1" aria-labelledby="accountActionModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <p>Please select one of the options to continue:</p>
                                    <div class="iptv-fx-card">
                                        <a href="{$WEB_ROOT}/clientarea.php?action=invoices" target="_blank" class="btn btn-primary" id="payInvoiceBtn">Pay invoice</a>
                                        <a href="#" target="_blank" class="btn btn-secondary" id="upgradeBtn">Upgrade/Downgrade</a>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            {* --- Channel List Modal (iframe) --- *}
                            <div class="modal fade" id="channelListModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered cp-modal-channel-list" role="document">
                                    <div class="modal-content cp-modal-content">
                                        <div class="cp-modal-header">
                                            <div class="cp-modal-header-inner">
                                                <div class="cp-modal-icon teal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                                </div>
                                                <h4 class="cp-modal-title">Channel List</h4>
                                            </div>
                                            <button type="button" class="cp-modal-close" data-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="cp-modal-body-iframe">
                                            <iframe src="channel-list.html" scrolling="auto" frameborder="0"></iframe>
                                        </div>
                                        <div class="cp-modal-footer">
                                            <button type="button" class="cp-modal-btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {* --- Bouquet / Channel Customization Modal --- *}
                            <div class="modal fade" id="channelModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered cp-modal-bouquet" role="document">
                                    <div class="modal-content cp-modal-content">
                                        <div class="cp-modal-header">
                                            <div class="cp-modal-header-inner">
                                                <div class="cp-modal-icon purple">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                                </div>
                                                <h4 class="cp-modal-title">Customize Your Channels</h4>
                                            </div>
                                            <button type="button" class="cp-modal-close" onclick="$('#channelModal').modal('hide');" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="cp-bouquet-tabs">
                                            <ul class="nav nav-tabs" id="bouquetCatTabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#" id="showDefaultBtn">All</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="cp-modal-body-bouquet">
                                            <form id="channelForm">
                                                <div class="tab-content"></div>
                                                <div id="bouquetsList" class="checkbox-grid" style="display: grid !important;"></div>
                                            </form>
                                        </div>
                                        <div class="cp-modal-footer">
                                            <button type="button" class="cp-modal-btn-toggle" id="btnToggleAllBouquets" onclick="toggleAllBouquets()"><svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="20 6 9 17 4 12"></polyline></svg><span id="toggleLabel">Select All</span></button>
                                            <button type="button" class="cp-modal-btn-primary" onclick="$('#channelModal').modal('hide');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Save Selection
                                            </button>
                                            <button type="button" class="cp-modal-btn-secondary" onclick="$('#channelModal').modal('hide');">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {* --- Password Generate Modal --- *}
                            <div id="passwordModal" class="pw-modal">
                                <div class="pw-modal-content">
                                    <h5>Generated Password</h5>
                                    <p id="generatedPassword"></p>
                                    <div class="pw-modal-actions">
                                        <button type="button" id="changePasswordBtn" class="pw-btn pw-btn-secondary">Re-Generate Password</button>
                                        <button type="button" id="usePasswordBtn" class="pw-btn pw-btn-primary">Use Password</button>
                                        <button type="button" id="closeModalBtn" class="pw-btn pw-btn-danger">Close</button>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning info-text-sm">
                                <i class="fas fa-question-circle"></i>
                                {$LANG.orderForm.haveQuestionsContact} <a href="{$WEB_ROOT}/contact.php" target="_blank" class="alert-link">{$LANG.orderForm.haveQuestionsClickHere}</a>
                            </div>

                        </div>
                        <div class="secondary-cart-sidebar" id="scrollingPanelContainer">
                            <div id="orderSummary" style="margin-top: 0px;">
                                <div class="order-summary">
                                    <div class="loader" id="orderSummaryLoader" style="display: none;">
                                        <i class="fas fa-fw fa-sync fa-spin"></i>
                                    </div>
                                    <h2 class="font-size-30">Order Summary</h2>
                                    <div class="summary-container">
                                        <span class="product-name">{$productinfo.name}</span>
                                        <div class="summary-totals">
                                            <div class="clearfix">
                                                <span class="pull-left float-left">Setup Fees:</span>
                                                <span class="pull-right float-right">$0.00 USD</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="pull-left float-left changedes">Monthly:</span>
                                                <span class="pull-right float-right">$0.00 USD</span>
                                            </div>
                                        </div>
                                        <div class="total-due-today">
                                            <span class="amt">$0.00 USD</span>
                                            <span>Total Due Today</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="btnCompleteProductConfig" class="btn btn-primary btn-lg">
                                        Continue
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

            </form>
        </div>
    </div>
</div>
</div>

{* ============================================================ *}
{* === JAVASCRIPT: Load data & full customcart logic         === *}
{* ============================================================ *}

{literal}
<style>
li.nav-item .nav-link { color: #363636; }
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #083c72 !important;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // ========== GLOBAL STATE ==========
    window.selectedProductData = {
        pid: null,
        setupFee: 0,
        recurringPrice: 0,
        totalPrice: 0,
        duration: "monthly",
        androidPrice: 0,
        vpnPrice: 0
    };

    var allProducts = [];
    var vpnProducts = [];
    var androidProducts = [];
    var resellerProducts = [];
    var xuiData = [];
    var xui_catss = [];
    var userServices = [];
    var loggedIn = document.getElementById('whmcsLoggedIn') && document.getElementById('whmcsLoggedIn').value === '1';

    // ========== DOM REFS ==========
    var selectserviceType = document.getElementById("selectserviceType");
    var panel = document.getElementById("scrollingPanelContainer");
    var cartBody = document.querySelector("#order-standard_cart .secondary-cart-body");
    var configOptionsCustom = document.getElementById("productConfigOptionsCustom");
    var userServicesDiv = document.getElementById("userServicesDiv");
    var loginDetails = document.getElementById("loginDetails");
    var providerSelect = document.getElementById("inputProvider");
    var adultSelect = document.getElementById("inputAdult");
    var durationSelect = document.getElementById("inputDuration");
    var connectionsSelect = document.getElementById("inputConnections");
    var deviceSelect = document.getElementById("inputConfigOption15Device");
    var packageTypeSelect = document.getElementById("inputPackageType");
    var selectedProductId = document.getElementById("selectedProductId");
    var billingCycleSelect = document.getElementById("billing_cycle");
    var vpnToggle = document.getElementById("vpnToggle");
    var androidSelect = document.getElementById("androidProducts");
    var magAddressDiv = document.getElementById("magAddress");
    var resellerConfigOptions = document.getElementById("resellerConfigOptions");
    var resellerPackageSelect = document.getElementById("resellerPackage");
    var resellerBillingCycleSelect = document.getElementById("resellerBillingCycle");
    var totalDueEl = document.querySelector('#orderSummary .total-due-today .amt');
    var summaryTotalsEl = document.querySelector('.summary-totals');

    // ========== LOAD DATA VIA AJAX ==========
    fetch("customcart.php?a=getdata")
        .then(function(res) { return res.json(); })
        .then(function(data) {
            allProducts = data.allProducts || [];
            vpnProducts = data.vpnProducts || [];
            androidProducts = data.androidProducts || [];
            resellerProducts = data.resellerProducts || [];
            xuiData = data.xuiData || [];
            xui_catss = data.xui_catss || [];
            userServices = data.userServices || [];
            loggedIn = data.loggedIn || false;

            populateProviders();
            populateProductDropdown(allProducts);
            populateAndroidProducts();
            populateResellerPackages();
            populateBouquetCatTabs();
            if (loggedIn) {
                populateUserServices();
            }
        })
        .catch(function(err) {
            console.error("Failed to load customcart data:", err);
        });

    // ========== POPULATE DROPDOWNS ==========
    function populateProviders() {
        // Auto-select first provider (single provider setup)
        if (xuiData.length > 0) {
            providerSelect.value = xuiData[0].identifier;
        }
    }

    function populateProductDropdown(products) {
        selectedProductId.innerHTML = '<option value="">Select Package / Product</option>';
        products.forEach(function(prod) {
            var opt = document.createElement("option");
            opt.value = prod.id;
            opt.textContent = prod.name;
            selectedProductId.appendChild(opt);
        });
    }

    function populateAndroidProducts() {
        androidSelect.innerHTML = '<option value="">None</option>';
        androidProducts.forEach(function(prod) {
            var opt = document.createElement("option");
            opt.value = prod.id;
            opt.textContent = prod.name;
            androidSelect.appendChild(opt);
        });
    }

    function populateUserServices() {
        var sel = document.getElementById("userServices");
        sel.innerHTML = '<option value="">Select account</option>';
        userServices.forEach(function(svc) {
            var opt = document.createElement("option");
            opt.value = svc.id;
            opt.textContent = svc.username;
            sel.appendChild(opt);
        });
    }

    function populateResellerPackages() {
        resellerPackageSelect.innerHTML = '<option value="">Select Reseller Package</option>';
        resellerProducts.forEach(function(prod) {
            var opt = document.createElement("option");
            opt.value = prod.id;
            opt.textContent = prod.name;
            resellerPackageSelect.appendChild(opt);
        });
    }

    function populateBouquetCatTabs() {
        var tabContainer = document.getElementById("bouquetCatTabs");
        xui_catss.forEach(function(cat) {
            var li = document.createElement("li");
            li.className = "nav-item";
            li.innerHTML = '<a class="nav-link" data-toggle="tab" href="#" data-id="' + cat.id + '">' + cat.cat_name + '</a>' +
                           '<input type="hidden" id="catInput' + cat.id + '" value="">';
            tabContainer.appendChild(li);
        });
    }

    // ========== SERVICE TYPE TOGGLE ==========
    function toggleServiceType() {
        var val = selectserviceType.value;

        // Reset all panels
        if (resellerConfigOptions) resellerConfigOptions.style.display = "none";
        if (configOptionsCustom) configOptionsCustom.style.display = "none";

        if (val === "Select Service") {
            // Initial state: only service cards + channel list visible
            if (panel) panel.style.display = "none";
            if (cartBody) cartBody.style.setProperty("width", "100%", "important");
        } else if (val === "Create new service") {
            if (configOptionsCustom) configOptionsCustom.style.display = "block";
            if (panel) panel.style.display = "block";
            if (cartBody) cartBody.style.setProperty("width", "60%", "");
            if (userServicesDiv) userServicesDiv.style.display = "none";
            if (loginDetails) loginDetails.style.display = "block";
        } else if (val === "Renew Existing Service") {
            if (!loggedIn) {
                if (typeof $ !== 'undefined') {
                    $('#loginPopupModal').modal('show');
                }
                if (panel) panel.style.display = "none";
                if (cartBody) cartBody.style.setProperty("width", "100%", "important");
                return;
            }
            // Only show account selector, hide config options
            if (configOptionsCustom) configOptionsCustom.style.display = "none";
            if (panel) panel.style.display = "none";
            if (cartBody) cartBody.style.setProperty("width", "100%", "important");
            if (userServicesDiv) userServicesDiv.style.display = "block";
            if (loginDetails) loginDetails.style.display = "none";
        } else if (val === "Reseller") {
            if (panel) panel.style.display = "block";
            if (cartBody) cartBody.style.setProperty("width", "60%", "");
            if (resellerConfigOptions) resellerConfigOptions.style.display = "block";
            resetOrderSummary();
        }
    }

    toggleServiceType();

    // Expose toggleServiceType globally for card onclick handlers
    window.toggleServiceType = toggleServiceType;

    // Service card click handler
    window.selectServiceCard = function(val, el) {
        document.getElementById('selectserviceType').value = val;
        document.querySelectorAll('.service-type-card').forEach(function(c) { c.classList.remove('active'); });
        el.classList.add('active');
        toggleServiceType();
    };

    // ========== PROGRESSIVE FIELD-BY-FIELD UNLOCK ==========
    function unlockField(id) {
        var el = document.getElementById(id);
        if (el && el.classList.contains('cp-field-locked')) {
            el.classList.remove('cp-field-locked');
        }
    }
    function unlockGroup(id) {
        var el = document.getElementById(id);
        if (el && el.classList.contains('cp-locked')) {
            el.classList.remove('cp-locked');
        }
    }

    // Device → Package Type
    deviceSelect.addEventListener("change", function() {
        if (this.value) unlockField('fieldPackageType');
    });
    // Package Type → Adult + show info
    packageTypeSelect.addEventListener("change", function() {
        if (this.value) unlockField('fieldAdult');
        var infoEl = document.getElementById('packageTypeInfo');
        if (infoEl) {
            var sel = this.options[this.selectedIndex];
            infoEl.textContent = sel && sel.title ? sel.title : '';
        }
    });
    // Adult → Duration
    adultSelect.addEventListener("change", function() {
        if (this.value) unlockField('fieldDuration');
    });
    // Duration → Connections
    durationSelect.addEventListener("change", function() {
        if (this.value) unlockField('fieldConnections');
    });
    // Connections → Package
    connectionsSelect.addEventListener("change", function() {
        if (this.value) unlockField('fieldPackage');
    });

    // Package selected → unlock Groups 2, 3, 4
    function unlockAfterPackage() {
        if (selectedProductId && selectedProductId.value) {
            // Show MAG Address if device is MAG
            if (deviceSelect.value === "MAG") {
                if (magAddressDiv) magAddressDiv.style.display = "block";
                if (loginDetails) loginDetails.style.display = "none";
            }
            unlockGroup('cpGroup2');
            unlockGroup('cpGroup3');
            unlockGroup('cpGroup4');
        }
    }

    // ========== DEVICE TOGGLE (MAG vs Login) ==========
    function toggleDeviceFields() {
        if (deviceSelect.value === "MAG") {
            // Only show MAG Address if package is already selected
            if (selectedProductId && selectedProductId.value) {
                if (magAddressDiv) magAddressDiv.style.display = "block";
            }
            if (loginDetails) loginDetails.style.display = "none";
        } else {
            if (selectserviceType.value !== "Renew Existing Service") {
                if (loginDetails) loginDetails.style.display = "block";
            }
            if (magAddressDiv) magAddressDiv.style.display = "none";
        }
    }
    deviceSelect.addEventListener("change", toggleDeviceFields);

    // ========== PRODUCT MATCHING ==========
    function matchProduct() {
        var a = adultSelect ? adultSelect.value.trim() : "";
        var d = durationSelect ? durationSelect.value.trim() : "";
        var c = connectionsSelect ? connectionsSelect.value.trim() : "";
        var dev = deviceSelect ? deviceSelect.value.trim() : "";
        var pt = packageTypeSelect ? packageTypeSelect.value.trim() : "";

        if (c && !c.startsWith("1 ")) {
            c = c.replace("Connection", "Connections");
        }

        var productsToSearch = allProducts;

        // Filter by device
        if (dev) {
            var filtered = productsToSearch.filter(function(prod) {
                return prod.name.toLowerCase().indexOf(dev.toLowerCase()) !== -1;
            });
            if (filtered.length > 0) productsToSearch = filtered;
        }

        // Filter by package type
        if (pt) {
            var ptFiltered = productsToSearch.filter(function(prod) {
                return prod.name.toUpperCase().indexOf(pt.toUpperCase()) !== -1;
            });
            if (ptFiltered.length > 0) productsToSearch = ptFiltered;
        }

        // Filter by adult
        if (a) {
            var adultFiltered = productsToSearch.filter(function(prod) {
                return prod.name.toUpperCase().indexOf("(" + a + ")") !== -1;
            });
            if (adultFiltered.length > 0) productsToSearch = adultFiltered;
        }

        // Filter by duration — extract number, match "N Month" or "N Months"
        if (d) {
            var dNum = d.match(/(\d+)/);
            if (dNum) {
                var durationFiltered = productsToSearch.filter(function(prod) {
                    var re = new RegExp(":\\s*" + dNum[1] + "\\s+months?\\s*\\(", "i");
                    return re.test(prod.name);
                });
                if (durationFiltered.length > 0) productsToSearch = durationFiltered;
            }
        }

        // Filter by connections — extract number, match "(N Connection" or "(N Connections"
        if (c) {
            var cNum = c.match(/(\d+)/);
            if (cNum) {
                var connFiltered = productsToSearch.filter(function(prod) {
                    var re = new RegExp("\\(" + cNum[1] + "\\s+connections?\\)", "i");
                    return re.test(prod.name);
                });
                if (connFiltered.length > 0) productsToSearch = connFiltered;
            }
        }

        populateProductDropdown(productsToSearch);

        // Auto-select if only 1 result
        if (productsToSearch.length === 1) {
            selectedProductId.value = productsToSearch[0].id;
            fetchProductPrice(productsToSearch[0].id);
            unlockAfterPackage();
            return;
        }

        var key = (pt || "CHOICE") + " (" + a + "): " + d + " (" + c + ")";

        var found = null;
        for (var i = 0; i < productsToSearch.length; i++) {
            if (productsToSearch[i].name.trim().toLowerCase() === key.trim().toLowerCase()) {
                found = productsToSearch[i];
                break;
            }
        }

        if (found) {
            selectedProductId.value = found.id;
            fetchProductPrice(found.id, key);
            unlockAfterPackage();
        } else {
            selectedProductId.value = "";
        }
    }

    [adultSelect, durationSelect, connectionsSelect, deviceSelect, packageTypeSelect].forEach(function(el) {
        if (el) el.addEventListener("change", matchProduct);
    });

    selectedProductId.addEventListener("change", function() {
        if (this.value) {
            fetchProductPrice(this.value);
            unlockAfterPackage();
        }
    });

    // ========== FETCH PRODUCT PRICE ==========
    function fetchProductPrice(pid, keyName) {
        if (!pid) return;
        document.getElementById("orderSummaryLoader").style.display = "block";

        fetch("getProductPrice010.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ pid: pid })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            document.getElementById("orderSummaryLoader").style.display = "none";

            if (data.result === "success") {
                var pricing = data.product.pricing.USD || data.product.pricing;
                var durationValue = durationSelect ? durationSelect.value.trim().toLowerCase() : "monthly";
                var price = 0;
                var setupFee = parseFloat(pricing.setup || 0);

                switch (durationValue) {
                    case "1 month":
                    case "monthly":
                        price = parseFloat(pricing.monthly || 0); break;
                    case "3 months":
                    case "quarterly":
                        price = parseFloat(pricing.quarterly || 0); break;
                    case "6 months":
                    case "semiannually":
                        price = parseFloat(pricing.semiannually || 0); break;
                    case "12 months":
                    case "annually":
                        price = parseFloat(pricing.annually || 0); break;
                    default:
                        price = parseFloat(pricing.monthly || 0);
                }

                var total = setupFee + price;

                window.selectedProductData.pid = pid;
                window.selectedProductData.setupFee = setupFee;
                window.selectedProductData.recurringPrice = price;
                window.selectedProductData.totalPrice = total;
                window.selectedProductData.duration = durationValue;

                // Update summary
                var nameEl = document.querySelector(".product-name");
                if (nameEl) {
                    nameEl.textContent = keyName || findProductName(pid) || "Selected Product";
                }

                var setupEl = document.querySelector(".summary-totals .clearfix:nth-child(1) .pull-right");
                if (setupEl) setupEl.textContent = "$" + setupFee.toFixed(2) + " USD";

                var recurEl = document.querySelector(".summary-totals .clearfix:nth-child(2) .pull-right");
                if (recurEl) recurEl.textContent = "$" + price.toFixed(2) + " USD";

                updateGrandTotal();

                // Sync billing label
                updateBillingLabel(durationValue);
            }
        })
        .catch(function(err) {
            document.getElementById("orderSummaryLoader").style.display = "none";
            console.error("AJAX Error:", err);
        });
    }

    function findProductName(pid) {
        for (var i = 0; i < allProducts.length; i++) {
            if (allProducts[i].id == pid) return allProducts[i].name;
        }
        return null;
    }

    // ========== BILLING LABEL SYNC ==========
    var billingTextMap = {
        "monthly": "Monthly:",
        "1 month": "Monthly:",
        "quarterly": "Quarterly:",
        "3 months": "Quarterly:",
        "semiannually": "Semi-Annually:",
        "6 months": "Semi-Annually:",
        "annually": "Annually:",
        "12 months": "Annually:"
    };

    var durationToCycle = {
        "1 Month": "monthly",
        "3 Months": "quarterly",
        "6 Months": "semiannually",
        "12 Months": "annually"
    };

    function updateBillingLabel(cycle) {
        var billingLabel = document.querySelector(".summary-totals .pull-left.float-left.changedes");
        if (billingLabel && billingTextMap[cycle]) {
            billingLabel.textContent = billingTextMap[cycle];
        }
    }

    // Sync duration dropdown -> billing cycle hidden select
    durationSelect.addEventListener("change", function() {
        var mapped = durationToCycle[this.value];
        if (mapped && billingCycleSelect) {
            billingCycleSelect.value = mapped;
        }
    });

    // Sync product dropdown -> duration & billing
    selectedProductId.addEventListener("change", function() {
        var selectedText = this.options[this.selectedIndex] ? this.options[this.selectedIndex].text : "";
        for (var key in durationToCycle) {
            if (selectedText.indexOf(key) !== -1) {
                durationSelect.value = key;
                billingCycleSelect.value = durationToCycle[key];
                updateBillingLabel(durationToCycle[key]);
                break;
            }
        }
    });

    // ========== GRAND TOTAL ==========
    function updateGrandTotal() {
        var main = parseFloat(window.selectedProductData.totalPrice || 0);
        var android = parseFloat(window.selectedProductData.androidPrice || 0);
        var vpn = parseFloat(window.selectedProductData.vpnPrice || 0);
        var grandTotal = main + android + vpn;
        if (totalDueEl) totalDueEl.textContent = "$" + grandTotal.toFixed(2) + " USD";
    }

    // ========== VPN TOGGLE ==========
    vpnToggle.addEventListener("change", function() {
        if (this.checked) {
            if (vpnProducts.length > 0) {
                var vpnPid = vpnProducts[0].id;
                fetch("getProductPrice010.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ pid: vpnPid })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.result === "success") {
                        var vpnPrice = parseFloat(data.product.pricing.monthly || 0);
                        window.selectedProductData.vpnPrice = vpnPrice;

                        var existingRow = document.querySelector("#vpnProductPrice");
                        if (existingRow) existingRow.remove();

                        var newDiv = document.createElement("div");
                        newDiv.classList.add("clearfix");
                        newDiv.id = "vpnProductPrice";
                        newDiv.innerHTML = '<span class="pull-left float-left">' + data.product.name + ':</span>' +
                                           '<span class="pull-right float-right">$' + vpnPrice.toFixed(2) + ' USD</span>';
                        summaryTotalsEl.appendChild(newDiv);
                        updateGrandTotal();
                    }
                });
            }
        } else {
            window.selectedProductData.vpnPrice = 0;
            var vpnRow = document.querySelector("#vpnProductPrice");
            if (vpnRow) vpnRow.remove();
            updateGrandTotal();
        }
    });

    // ========== ANDROID PRODUCT ==========
    androidSelect.addEventListener("change", function() {
        var pid = this.value;
        var existingRow = document.querySelector("#androidProductPrice");
        if (existingRow) existingRow.remove();

        if (!pid || pid === "0") {
            window.selectedProductData.androidPrice = 0;
            updateGrandTotal();
            return;
        }

        fetch("getProductPrice010.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ pid: pid })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.result === "success") {
                var price = parseFloat(data.product.pricing.monthly || 0);
                window.selectedProductData.androidPrice = price;

                var newDiv = document.createElement("div");
                newDiv.classList.add("clearfix");
                newDiv.id = "androidProductPrice";
                newDiv.innerHTML = '<span class="pull-left float-left">' + data.product.name + ':</span>' +
                                   '<span class="pull-right float-right">$' + price.toFixed(2) + ' USD</span>';
                summaryTotalsEl.appendChild(newDiv);
                updateGrandTotal();
            }
        });
    });

    // ========== USER SERVICES (Renew) ==========
    document.getElementById("userServices").addEventListener("change", function() {
        var selectedAccountId = this.value;
        if (selectedAccountId !== "") {
            var upgradeBtn = document.getElementById("upgradeBtn");
            if (upgradeBtn) {
                upgradeBtn.href = "/clientarea.php?action=productdetails&id=" + selectedAccountId;
            }
            var payInvoiceBtn = document.getElementById("payInvoiceBtn");
            if (payInvoiceBtn) {
                payInvoiceBtn.href = "/clientarea.php?action=productdetails&id=" + selectedAccountId + "#tabInvoices";
            }
            if (typeof $ !== 'undefined') {
                $('#accountActionModal').modal('show');
            }
        }
    });

    // ========== CONTINUE BUTTON → REDIRECT ==========
    document.getElementById("btnCompleteProductConfig").addEventListener("click", function(e) {
        e.preventDefault();

        var serviceType = selectserviceType.value;

        // ---- RESELLER FLOW ----
        if (serviceType === "Reseller") {
            var resellerPid = resellerPackageSelect.value;
            if (!resellerPid) {
                alert("Please select a Reseller Package before continuing.");
                return;
            }

            var rUser = document.getElementById("resellerUsername").value;
            var rPass = document.getElementById("resellerPassword").value;
            if (!rUser || !rPass) {
                alert("Please enter username and password.");
                return;
            }

            var rCycle = encodeURIComponent(resellerBillingCycleSelect.value);
            var url = "customcart.php?a=add&pid=" + resellerPid + "&skipconfig=1&billingcycle=" + rCycle +
                      "&cf_username=" + encodeURIComponent(rUser) +
                      "&cf_password=" + encodeURIComponent(rPass) +
                      "&cf_selectservicetype=" + serviceType;
            window.location.href = url;
            return;
        }

        // ---- IPTV FLOW (Create new / Renew) ----
        var vpnVal = "";
        if (vpnToggle.checked && vpnProducts.length > 0) {
            vpnVal = "&vpn=" + vpnProducts[0].id;
        }

        var androidVal = "";
        if (androidSelect.value) {
            androidVal = "&android=" + androidSelect.value;
        }

        var userSvcVal = document.getElementById("userServices").value;

        var pid = selectedProductId.value;
        if (!pid) {
            alert("Please select a valid product before continuing.");
            return;
        }

        var selectedBouquets = document.getElementById("selectedChannels").value;
        var billingCycle = encodeURIComponent(billingCycleSelect.value);

        if (deviceSelect.value === "MAG") {
            var magAddr = document.getElementById("magIp").value;
            var url = "customcart.php?a=add&pid=" + pid + "&skipconfig=1&billingcycle=" + billingCycle +
                      "&cf_magaddress=" + encodeURIComponent(magAddr) +
                      "&cf_selectbouquets=" + selectedBouquets +
                      "&cf_selectservicetype=" + serviceType +
                      "&cf_selectaccount=" + userSvcVal + vpnVal + androidVal;
            window.location.href = url;
        } else {
            var uname = document.getElementById("username").value;
            var pass = document.getElementById("password").value;

            if ((!uname || !pass) && serviceType !== "Renew Existing Service") {
                alert("Please enter username and password.");
                return;
            }

            var url = "customcart.php?a=add&pid=" + pid + "&skipconfig=1&billingcycle=" + billingCycle +
                      "&cf_username=" + encodeURIComponent(uname) +
                      "&cf_password=" + encodeURIComponent(pass) +
                      "&cf_selectbouquets=" + selectedBouquets +
                      "&cf_selectservicetype=" + serviceType +
                      "&cf_selectaccount=" + userSvcVal + vpnVal + androidVal;
            window.location.href = url;
        }
    });

    // ========== TOGGLE PASSWORD VISIBILITY ==========
    window.togglePassword = function() {
        var pw = document.getElementById("password");
        var icon = document.getElementById("eyeIcon");
        if (pw.type === "password") {
            pw.type = "text";
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20C5 20 1 12 1 12a18.05 18.05 0 0 1 4.58-5.94M9.9 4.24A9.77 9.77 0 0 1 12 4c7 0 11 8 11 8a18.37 18.37 0 0 1-2.63 3.69M15 12a3 3 0 1 1-3-3"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            pw.type = "password";
            icon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    };

    // ========== PASSWORD GENERATOR ==========
    function generateRandomPassword(length) {
        length = length || 12;
        var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+";
        var pw = "";
        for (var i = 0; i < length; i++) {
            pw += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return pw;
    }

    var pwModal = document.getElementById("passwordModal");
    var genPwEl = document.getElementById("generatedPassword");
    var currentPassword = "";

    document.getElementById("generatePassword").addEventListener("click", function() {
        currentPassword = generateRandomPassword(12);
        genPwEl.textContent = currentPassword;
        pwModal.style.display = "block";
        // Ensure "Use Password" fills the IPTV password field
        document.getElementById("usePasswordBtn").onclick = function(e) {
            e.preventDefault();
            document.getElementById("password").value = currentPassword;
            pwModal.style.display = "none";
        };
    });

    document.getElementById("changePasswordBtn").addEventListener("click", function() {
        currentPassword = generateRandomPassword(12);
        genPwEl.textContent = currentPassword;
    });

    document.getElementById("usePasswordBtn").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("password").value = currentPassword;
        pwModal.style.display = "none";
    });

    document.getElementById("closeModalBtn").addEventListener("click", function() {
        pwModal.style.display = "none";
    });

    window.addEventListener("click", function(event) {
        if (event.target === pwModal) {
            pwModal.style.display = "none";
        }
    });

    // ========== MAG ADDRESS VALIDATION ==========
    var magInput = document.getElementById("magIp");
    var magError = document.getElementById("magError");
    magInput.addEventListener("input", function() {
        var value = this.value.toUpperCase();
        value = value.replace(/[^0-9A-F:]/g, "");
        var parts = value.split(":").map(function(part) { return part.substring(0, 2); });
        if (parts.length > 6) parts.length = 6;
        value = parts.join(":");
        this.value = value;

        if (value.length === 17) {
            var isValid = /^([0-9A-F]{2}:){5}([0-9A-F]{2})$/.test(value);
            magError.style.display = isValid ? "none" : "inline";
        } else {
            magError.style.display = "none";
        }
    });

    // ========== BOUQUET / CHANNEL MODAL LOGIC ==========
    // Tab click handlers
    document.addEventListener("click", function(e) {
        if (e.target && e.target.matches(".nav-link")) {
            e.preventDefault();
            document.querySelectorAll(".nav-link").forEach(function(l) { l.classList.remove("active"); });
            e.target.classList.add("active");

            if (e.target.id === "showDefaultBtn") {
                document.querySelectorAll(".allCatchanl").forEach(function(el) { el.style.display = ""; });
                return;
            }

            var categoryId = e.target.getAttribute("data-id");
            if (!categoryId) return;
            var catInput = document.getElementById("catInput" + categoryId);
            if (!catInput) return;
            var catVal = catInput.value;

            document.querySelectorAll(".allCatchanl").forEach(function(el) { el.style.display = "none"; });
            catVal.split(",").filter(function(item) { return item.trim() !== ""; }).forEach(function(val) {
                document.querySelectorAll(".catchanl" + val).forEach(function(el) { el.style.display = ""; });
            });
        }
    });

    // Hidden input sync for selected bouquets
    var hiddenChannels = document.getElementById("selectedChannels");

    function updateFromCheckboxes() {
        var nodes = document.querySelectorAll('#bouquetsList input[name="selectedbouquets"]');
        var selected = [];
        nodes.forEach(function(ch) {
            if (ch.checked) selected.push(ch.value);
        });
        hiddenChannels.value = selected.join(",");
    }

    document.addEventListener("change", function(e) {
        if (e.target && e.target.matches && e.target.matches('#bouquetsList input[name="selectedbouquets"]')) {
            updateFromCheckboxes();
        }
    });

    // ========== RESELLER PACKAGE PRICE ==========
    resellerPackageSelect.addEventListener("change", function() {
        var pid = this.value;
        if (!pid) {
            resetOrderSummary();
            return;
        }
        fetchResellerPrice(pid);
    });

    resellerBillingCycleSelect.addEventListener("change", function() {
        var pid = resellerPackageSelect.value;
        if (pid) fetchResellerPrice(pid);
    });

    function fetchResellerPrice(pid) {
        if (!pid) return;
        document.getElementById("orderSummaryLoader").style.display = "block";

        fetch("getProductPrice010.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ pid: pid })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            document.getElementById("orderSummaryLoader").style.display = "none";

            if (data.result === "success") {
                var pricing = data.product.pricing.USD || data.product.pricing;
                var cycle = resellerBillingCycleSelect.value;
                var price = 0;
                var setupFee = parseFloat(pricing.setup || 0);

                switch (cycle) {
                    case "monthly": price = parseFloat(pricing.monthly || 0); break;
                    case "quarterly": price = parseFloat(pricing.quarterly || 0); break;
                    case "semiannually": price = parseFloat(pricing.semiannually || 0); break;
                    case "annually": price = parseFloat(pricing.annually || 0); break;
                    default: price = parseFloat(pricing.monthly || 0);
                }

                var total = setupFee + price;

                window.selectedProductData.pid = pid;
                window.selectedProductData.setupFee = setupFee;
                window.selectedProductData.recurringPrice = price;
                window.selectedProductData.totalPrice = total;
                window.selectedProductData.duration = cycle;
                window.selectedProductData.androidPrice = 0;
                window.selectedProductData.vpnPrice = 0;

                var nameEl = document.querySelector(".product-name");
                if (nameEl) nameEl.textContent = data.product.name || "Reseller Package";

                var setupEl = document.querySelector(".summary-totals .clearfix:nth-child(1) .pull-right");
                if (setupEl) setupEl.textContent = "$" + setupFee.toFixed(2) + " USD";

                var recurEl = document.querySelector(".summary-totals .clearfix:nth-child(2) .pull-right");
                if (recurEl) recurEl.textContent = "$" + price.toFixed(2) + " USD";

                updateBillingLabel(cycle);
                updateGrandTotal();
            }
        })
        .catch(function(err) {
            document.getElementById("orderSummaryLoader").style.display = "none";
            console.error("Reseller price error:", err);
        });
    }

    // ========== RESET ORDER SUMMARY ==========
    function resetOrderSummary() {
        window.selectedProductData.pid = null;
        window.selectedProductData.setupFee = 0;
        window.selectedProductData.recurringPrice = 0;
        window.selectedProductData.totalPrice = 0;
        window.selectedProductData.androidPrice = 0;
        window.selectedProductData.vpnPrice = 0;

        var nameEl = document.querySelector(".product-name");
        if (nameEl) nameEl.textContent = "";

        var setupEl = document.querySelector(".summary-totals .clearfix:nth-child(1) .pull-right");
        if (setupEl) setupEl.textContent = "$0.00 USD";

        var recurEl = document.querySelector(".summary-totals .clearfix:nth-child(2) .pull-right");
        if (recurEl) recurEl.textContent = "$0.00 USD";

        if (totalDueEl) totalDueEl.textContent = "$0.00 USD";

        // Remove VPN/Android add-on rows
        var vpnRow = document.querySelector("#vpnProductPrice");
        if (vpnRow) vpnRow.remove();
        var androidRow = document.querySelector("#androidProductPrice");
        if (androidRow) androidRow.remove();
    }

    // ========== RESELLER PASSWORD TOGGLE ==========
    window.toggleResellerPassword = function() {
        var pw = document.getElementById("resellerPassword");
        var icon = document.getElementById("resellerEyeIcon");
        if (pw.type === "password") {
            pw.type = "text";
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20C5 20 1 12 1 12a18.05 18.05 0 0 1 4.58-5.94M9.9 4.24A9.77 9.77 0 0 1 12 4c7 0 11 8 11 8a18.37 18.37 0 0 1-2.63 3.69M15 12a3 3 0 1 1-3-3"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            pw.type = "password";
            icon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    };

    // ========== RESELLER GENERATE PASSWORD ==========
    document.getElementById("resellerGeneratePassword").addEventListener("click", function() {
        currentPassword = generateRandomPassword(12);
        genPwEl.textContent = currentPassword;
        pwModal.style.display = "block";
        // Override "Use Password" to fill reseller password field
        document.getElementById("usePasswordBtn").onclick = function(e) {
            e.preventDefault();
            document.getElementById("resellerPassword").value = currentPassword;
            pwModal.style.display = "none";
        };
    });

    // ========== ORDER SUMMARY SCROLL ==========
    var $summaryPanel = document.getElementById("orderSummary");
    if ($summaryPanel) {
        var currentY = 0;
        var targetY = 0;
        function smoothScroll() {
            targetY = window.scrollY * 0.5;
            currentY += (targetY - currentY) * 0.1;
            $summaryPanel.style.transform = "translateY(" + currentY + "px)";
            requestAnimationFrame(smoothScroll);
        }
        smoothScroll();
    }

}); // end DOMContentLoaded

// ========== SELECT ALL / DESELECT ALL TOGGLE ==========
function toggleAllBouquets() {
    var checkboxes = $('#bouquetsList input[name="selectedbouquets"]');
    var allChecked = checkboxes.length > 0 && checkboxes.filter(':checked').length === checkboxes.length;
    checkboxes.prop('checked', !allChecked);
    var arr = checkboxes.filter(':checked').map(function(){ return $(this).val(); }).get();
    $('#selectedChannels').val(arr.join(','));
    var btn = $('#btnToggleAllBouquets');
    if (allChecked) {
        $('#toggleLabel').text('Select All');
        $('#toggleIcon').html('<polyline points="20 6 9 17 4 12"></polyline>');
        btn.removeClass('toggled');
    } else {
        $('#toggleLabel').text('Deselect All');
        $('#toggleIcon').html('<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>');
        btn.addClass('toggled');
    }
}

// ========== BOUQUET MODAL GUARD ==========
function openBouquetModal() {
    var pid = $('#selectedProductId').val();
    if (!pid) {
        $('#packageWarning').remove();
        var warning = '<div id="packageWarning" style="background:linear-gradient(135deg,#fff3cd,#fff8e1);border:1px solid #ffc107;color:#856404;padding:12px 16px;border-radius:10px;margin-top:10px;font-size:14px;display:flex;align-items:center;gap:10px;">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e67e22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>' +
            '<span><strong>Please select a package first!</strong> Choose your IPTV Package above before customizing channels.</span>' +
            '</div>';
        $('#selectedProductId').closest('.form-group').append(warning);
        $('html, body').animate({ scrollTop: $('#selectedProductId').offset().top - 100 }, 500);
        $('#selectedProductId').css({'border-color':'#ffc107','box-shadow':'0 0 0 3px rgba(255,193,7,0.25)'});
        setTimeout(function() { $('#selectedProductId').css({'border-color':'','box-shadow':''}); }, 2500);
        setTimeout(function() { $('#packageWarning').fadeOut(300, function(){ $(this).remove(); }); }, 5000);
        return;
    }
    selectbouquetsFirst();
    $('#channelModal').modal('show');
}

// ========== BOUQUET API FUNCTION (global) ==========
function selectbouquetsFirst() {
    $.ajax({
        type: "POST",
        url: "modules/servers/XUIResellerPanel/Config.php",
        data: {
            action: 'getBouquetCategoriesOnClientArea',
            productid: $('#selectedProductId').val(),
            serviceid: ''
        },
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            var bouquetsList = '';
            if (obj.status == "success") {
                var bouquets = obj.bouquets;
                var catData = obj.cat_data;

                var hiddenVal = $('#selectedChannels').val();
                var selectedArr = hiddenVal ? hiddenVal.split(',') : [];

                $.each(catData, function(key, value) {
                    var catInptData = $('#catInput'+value).val();
                    $('#catInput'+value).val(catInptData+','+key);
                });

                $.each(bouquets, function(key, value) {
                    var isChecked = selectedArr.includes(key.toString()) ? 'checked' : '';
                    bouquetsList += '<label class="allCatchanl catchanl'+key+'"><input type="checkbox" name="selectedbouquets" value="'+ key +'" '+isChecked+'> '+ value +'</label>';
                });

                $('#bouquetsList').html(bouquetsList);

                var arr = $('#bouquetsList input[name="selectedbouquets"]:checked').map(function(){ return $(this).val(); }).get();
                $('#selectedChannels').val(arr.join(','));
            } else {
                alert('No Bouquets found!');
            }
        },
        error: function() {
            alert('No Bouquets found!');
        }
    });
}
</script>
{/literal}

{include file="orderforms/{$carttpl}/recommendations-modal.tpl"}
