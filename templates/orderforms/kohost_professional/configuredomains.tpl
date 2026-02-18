{include file="orderforms/kohost_professional/common.tpl"}

<script>
var _localLang = {
    'addToCart': '{$LANG.orderForm.addToCart|escape}',
    'addedToCartRemove': '{$LANG.orderForm.addedToCartRemove|escape}'
}
</script>

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">{$LANG.cartdomainsconfig}</h2>
            </div>

            {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

            <form method="post" action="{$smarty.server.PHP_SELF}?a=confdomains" id="frmConfigureDomains">
                <input type="hidden" name="update" value="true" />

                <p>{$LANG.orderForm.reviewDomainAndAddons}</p>

                {if $errormessage}
                    <div class="alert alert-danger" role="alert">
                        <p>{$LANG.orderForm.correctErrors}:</p>
                        <ul>
                            {$errormessage}
                        </ul>
                    </div>
                {/if}

                {foreach $domains as $num => $domain}

                    <div class="card-block">
                        <div class="sub-heading">
                            <span>{$domain.domain}</span>
                        </div>
    
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{$LANG.orderregperiod}</label>
                                    <br />
                                    {$domain.regperiod} {$LANG.orderyears}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{$LANG.hosting}</label>
                                    <br />
                                    {if $domain.hosting}<span style="color:#009900;">[{$LANG.cartdomainshashosting}]</span>{else}<a href="{$WEB_ROOT}/cart.php" style="color:#cc0000;">[{$LANG.cartdomainsnohosting}]</a>{/if}
                                </div>
                            </div>
                            {if $domain.eppenabled}
                                <div class="col-sm-12">
                                    <div class="form-group prepend-icon">
                                        <input type="text" name="epp[{$num}]" id="inputEppcode{$num}" value="{$domain.eppvalue}" class="field form-control" placeholder="{$LANG.domaineppcode}" />
                                        <label for="inputEppcode{$num}" class="field-icon">
                                            <i class="fas fa-lock"></i>
                                        </label>
                                        <span class="field-help-text">
                                            {$LANG.domaineppcodedesc}
                                        </span>
                                    </div>
                                </div>
                            {/if}
                        </div>
                        {if $domain.dnsmanagement || $domain.emailforwarding || $domain.idprotection}
                            <div class="row addon-products configure-addon">
    
                                {if $domain.dnsmanagement}
                                    <div class="col-sm-{math equation="12 / numAddons" numAddons=$domain.addonsCount}">
                                        <div class="panel panel-addon{if $domain.dnsmanagementselected} panel-addon-selected{/if}">
                                            <div class="panel-body">
                                                <label>
                                                    <input type="checkbox" name="dnsmanagement[{$num}]"{if $domain.dnsmanagementselected} checked{/if} />
                                                </label>
                                                <div class="checkbox-content">
                                                    <h6 class="addon-title">{$LANG.domaindnsmanagement} <i class="fas fa-info-circle" data-toggle="tooltip" title="" data-original-title="{$LANG.domainaddonsdnsmanagementinfo}"></i></h6>
                                                    <p>{$domain.dnsmanagementprice} / {$domain.regperiod} {$LANG.orderyears}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
    
                                {if $domain.idprotection}
                                    <div class="col-sm-{math equation="12 / numAddons" numAddons=$domain.addonsCount}">
                                        <div class="panel panel-addon{if $domain.idprotectionselected} panel-addon-selected{/if}">
                                            <div class="panel-body">
                                                <label>
                                                    <input type="checkbox" name="idprotection[{$num}]"{if $domain.idprotectionselected} checked{/if} />
                                                </label>
                                                <div class="checkbox-content">
                                                    <h6 class="addon-title">{$LANG.domainidprotection} <i class="fas fa-info-circle" data-toggle="tooltip" title="" data-original-title="{$LANG.domainaddonsidprotectioninfo}"></i></h6>
                                                    <p>{$domain.idprotectionprice} / {$domain.regperiod} {$LANG.orderyears}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
    
                                {if $domain.emailforwarding}
                                    <div class="col-sm-{math equation="12 / numAddons" numAddons=$domain.addonsCount}">
                                        <div class="panel panel-addon{if $domain.emailforwardingselected} panel-addon-selected{/if}">
                                            <div class="panel-body">
                                                <label>
                                                    <input type="checkbox" name="emailforwarding[{$num}]"{if $domain.emailforwardingselected} checked{/if} />
                                                </label>
                                                <div class="checkbox-content">
                                                    <h6 class="addon-title">{$LANG.domainemailforwarding} <i class="fas fa-info-circle" data-toggle="tooltip" title="" data-original-title="{$LANG.domainaddonsemailforwardinginfo}"></i></h6>
                                                    <p>{$domain.emailforwardingprice} / {$domain.regperiod} {$LANG.orderyears}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
    
                            </div>
                        {/if}
                        {foreach from=$domain.fields key=domainfieldname item=domainfield}
                            <div class="form-group row">
                                <div class="col-sm-4 text-sm-right">{$domainfieldname}:</div>
                                <div class="col-sm-8">{$domainfield}</div>
                            </div>
                        {/foreach}
                    </div>

                {/foreach}

                {if $atleastonenohosting}
                
            
                <div class="heading-title">
                    <h5>{$LANG.domainnameservers}</h5>
                    <p>{$LANG.cartnameserversdesc}</p>
                </div>
                    
                    <div class="card-block mb-20">
                        
                                            
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="inputNs1">{$LANG.domainnameserver1}</label>
                                    <input type="text" class="form-control" id="inputNs1" name="domainns1" value="{$domainns1}" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="inputNs2">{$LANG.domainnameserver2}</label>
                                    <input type="text" class="form-control" id="inputNs2" name="domainns2" value="{$domainns2}" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="inputNs3">{$LANG.domainnameserver3}</label>
                                    <input type="text" class="form-control" id="inputNs3" name="domainns3" value="{$domainns3}" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="inputNs1">{$LANG.domainnameserver4}</label>
                                    <input type="text" class="form-control" id="inputNs4" name="domainns4" value="{$domainns4}" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="inputNs5">{$LANG.domainnameserver5}</label>
                                    <input type="text" class="form-control" id="inputNs5" name="domainns5" value="{$domainns5}" />
                                </div>
                            </div>
                        </div>
                    </div>

                {/if}

                <div class="text-left pt-4">
                    <button type="submit" class="btn primary-solid-btn">
                        {$LANG.continue}
                        &nbsp;<i class="fas fa-arrow-circle-right"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
