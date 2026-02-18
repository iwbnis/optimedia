{if $registrarcustombuttonresult=="success"}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.moduleactionsuccess textcenter=true}
{elseif $registrarcustombuttonresult}
    {include file="$template/includes/alert.tpl" type="error" msg=$LANG.moduleactionfailed textcenter=true}
{/if}

{if $unpaidInvoice}
    <div class="alert alert-{if $unpaidInvoiceOverdue}danger{else}warning{/if}" id="alert{if $unpaidInvoiceOverdue}Overdue{else}Unpaid{/if}Invoice">
        <div class="pull-right">
            <a href="viewinvoice.php?id={$unpaidInvoice}" class="btn btn-xs btn-default">
                {lang key='payInvoice'}
            </a>
        </div>
        {$unpaidInvoiceMessage}
    </div>
{/if}

<div class="tab-content margin-bottom">
    <div class="tab-pane fade in active" id="tabOverview">

        {if $alerts}
            {foreach $alerts as $alert}
                {include file="$template/includes/alert.tpl" type=$alert.type msg="<strong>{$alert.title}</strong><br>{$alert.description}" textcenter=true}
            {/foreach}
        {/if}

        {if $systemStatus != 'Active'}
            <div class="alert alert-warning" role="alert">
                {$LANG.domainCannotBeManagedUnlessActive}
            </div>
        {/if}
        <div class="sub-heading">
            <h3>{$LANG.overview}</h3>
        </div>
        {if $lockstatus eq "unlocked"}
            {capture name="domainUnlockedMsg"}<strong>{$LANG.domaincurrentlyunlocked}</strong><br />{$LANG.domaincurrentlyunlockedexp}{/capture}
            {include file="$template/includes/alert.tpl" type="error" msg=$smarty.capture.domainUnlockedMsg}
        {/if}


        <div class="row row-eq-height">
            <div class="col-md-6">
                <div class="overview-info-wrap">
                    <ul class="product-info-list">
                        <li>
                            <span class="list-info-title">{$LANG.clientareahostingdomain}</span>
                            <span class="list-info-text"> <a href="http://{$domain}" target="_blank">{$domain}</a></span>
                        </li>
                        <li>
                            <span class="list-info-title">{$LANG.firstpaymentamount}</span>
                            <span class="list-info-text"> {$firstpaymentamount}</span>
                        </li>
                        <li>
                            <span class="list-info-title">{$LANG.clientareahostingregdate}</span>
                            <span class="list-info-text"> {$registrationdate}</span>
                        </li>
                        <li>
                            <span class="list-info-title">{$LANG.recurringamount}</span>
                            <span class="list-info-text"> {$recurringamount} {$LANG.every} {$registrationperiod} {$LANG.orderyears}</span>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-6">
                <div class="overview-info-wrap">
                    <ul class="product-info-list">
                        <li>
                            <span class="list-info-title">{$LANG.clientareahostingnextduedate}</span>
                            <span class="list-info-text">  {$nextduedate}</span>
                        </li>
                        <li>
                            <span class="list-info-title">{$LANG.orderpaymentmethod}</span>
                            <span class="list-info-text"> {$paymentmethod}</span>
                        </li>
                        <li>
                            <span class="list-info-title">{$LANG.clientareastatus}</span>
                            <span class="list-info-text"> {$status}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        {if $sslStatus}
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-info-wrap mt-20 ssl-overview">
                        <ul class="product-info-list">
                            <li class="{if $sslStatus->isInactive()} ssl-inactive{/if}">
                                <span class="list-info-title">{$LANG.sslState.sslStatus}</span>
                                <span class="list-info-text">
                                    <img src="{$sslStatus->getImagePath()}" width="16" data-type="domain" data-domain="{$domain}" data-showlabel="1" class="{$sslStatus->getClass()}"/>
                                    <span id="statusDisplayLabel">
                                        {if !$sslStatus->needsResync()}
                                            {$sslStatus->getStatusDisplayLabel()}
                                        {else}
                                            {$LANG.loading}
                                        {/if}
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    {if $sslStatus->isActive() || $sslStatus->needsResync()}
                        <div class="overview-info-wrap">
                            <ul class="product-info-list">
                                <li>
                                    <span class="list-info-title">{$LANG.sslState.startDate}</span>
                                    <span class="list-info-text" id="ssl-startdate">
                                        {if !$sslStatus->needsResync() || $sslStatus->startDate}
                                            {$sslStatus->startDate->toClientDateFormat()}
                                        {else}
                                            {$LANG.loading}
                                        {/if}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    {/if}
                </div>
            </div>
            {if $sslStatus->isActive() || $sslStatus->needsResync()}
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-info-wrap mt-20 gradient-bg">
                            <ul class="product-info-list">
                                <li>
                                    <span class="list-info-title">{$LANG.sslState.issuerName}</span>
                                    <span class="list-info-text" id="ssl-issuer">
                                        {if !$sslStatus->needsResync() || $sslStatus->issuerName}
                                            {$sslStatus->issuerName}
                                        {else}
                                            {$LANG.loading}
                                        {/if}
                                    </span>
                                </li>
                                <li>
                                    <span class="list-info-title">{$LANG.sslState.expiryDate}</span>
                                    <span class="list-info-text" id="ssl-expirydate">
                                        {if !$sslStatus->needsResync() || $sslStatus->expiryDate}
                                            {$sslStatus->expiryDate->toClientDateFormat()}
                                        {else}
                                            {$LANG.loading}
                                        {/if}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            {/if}
        {/if}

        {if $registrarclientarea}
            <div class="moduleoutput">
                {$registrarclientarea|replace:'modulebutton':'btn'}
            </div>
        {/if}

        {foreach $hookOutput as $output}
            <div class="recommended-addon">
                {$output}
            </div>
        {/foreach}

        <br />

        {if $canDomainBeManaged
        and (
        $managementoptions.nameservers or
        $managementoptions.contacts or
        $managementoptions.locking or
        $renew)}
            {* No reason to show this section if nothing can be done here! *}

            <h5>{$LANG.doToday}</h5>

            <ul class="product-info-list">
                {if $systemStatus == 'Active' && $managementoptions.nameservers}
                    <li>
                        <a class="tabControlLink" data-toggle="tab" href="#tabNameservers">
                            {$LANG.changeDomainNS}
                        </a>
                    </li>
                {/if}
                {if $systemStatus == 'Active' && $managementoptions.contacts}
                    <li>
                        <a href="clientarea.php?action=domaincontacts&domainid={$domainid}">
                            {$LANG.updateWhoisContact}
                        </a>
                    </li>
                {/if}
                {if $systemStatus == 'Active' && $managementoptions.locking}
                    <li>
                        <a class="tabControlLink" data-toggle="tab" href="#tabReglock">
                            {$LANG.changeRegLock}
                        </a>
                    </li>
                {/if}
                {if $renew}
                    <li>
                        <a href="{routePath('domain-renewal', $domain)}">
                            {$LANG.renewYourDomain}
                        </a>
                    </li>
                {/if}
            </ul>

        {/if}

    </div>
    <div class="tab-pane fade" id="tabAutorenew">

        <div class="sub-heading">
            <h3>{$LANG.domainsautorenew}</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message message-no-data">
                    {if $changeAutoRenewStatusSuccessful}
                        {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=false}
                    {/if}
                    <h5>{$LANG.domainautorenewstatus}: <span class="label label-{if $autorenew}success{else}danger{/if}">{if $autorenew}{$LANG.domainsautorenewenabled}{else}{$LANG.domainsautorenewdisabled}{/if}</span></h5>
                    <p class="message-text text-center">{$LANG.domainrenewexp}</p>

                    <div class="message-action mt-20">
                        <form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails#tabAutorenew">
                            <input type="hidden" name="id" value="{$domainid}">
                            <input type="hidden" name="sub" value="autorenew" />
                            {if $autorenew}
                                <input type="hidden" name="autorenew" value="disable">
                                <p class="text-left">
                                    <input type="submit" class="btn delete-btn" value="{$LANG.domainsautorenewdisable}" />
                                </p>
                            {else}
                                <input type="hidden" name="autorenew" value="enable">
                                <p class="text-left">
                                    <input type="submit" class="btn primary-solid-btn" value="{$LANG.domainsautorenewenable}" />
                                </p>
                            {/if}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tabNameservers">
        <div class="sub-heading">
            <h3>{$LANG.domainnameservers}</h3>
        </div>
        {if $nameservererror}
            {include file="$template/includes/alert.tpl" type="error" msg=$nameservererror textcenter=true}
        {/if}
        {if $subaction eq "savens"}
            {if $updatesuccess}
                {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
            {elseif $error}
                {include file="$template/includes/alert.tpl" type="error" msg=$error textcenter=true}
            {/if}
        {/if}

        {include file="$template/includes/alert.tpl" type="info" msg=$LANG.domainnsexp}

        <form class="form-horizontal" role="form" method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails#tabNameservers">
            <input type="hidden" name="id" value="{$domainid}" />
            <input type="hidden" name="sub" value="savens" />
            <div class="radio">
                <label>
                    <input type="radio" name="nschoice" value="default" onclick="disableFields('domnsinputs',true)"{if $defaultns} checked{/if} /> {$LANG.nschoicedefault}
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="nschoice" value="custom" onclick="disableFields('domnsinputs',false)"{if !$defaultns} checked{/if} /> {$LANG.nschoicecustom}
                </label>
            </div>
            <br />
            {for $num=1 to 5}
                <div class="form-group">
                    <label for="inputNs{$num}" class="col-sm-4 control-label">{$LANG.clientareanameserver} {$num}</label>
                    <div class="col-sm-7">
                        <input type="text" name="ns{$num}" class="form-control domnsinputs" id="inputNs{$num}" value="{$nameservers[$num].value}" />
                    </div>
                </div>
            {/for}
            <p class="text-center">
                <input type="submit" class="btn btn-primary" value="{$LANG.changenameservers}" />
            </p>
        </form>

    </div>
    <div class="tab-pane fade" id="tabReglock">

        <div class="sub-heading">
            <h3>{$LANG.domainregistrarlock}</h3>
        </div>


        {if $subaction eq "savereglock"}
            {if $updatesuccess}
                {include file="$template/includes/alert.tpl" type="success" msg=$LANG.changessavedsuccessfully textcenter=true}
            {elseif $error}
                {include file="$template/includes/alert.tpl" type="error" msg=$error textcenter=true}
            {/if}
        {/if}

        {include file="$template/includes/alert.tpl" type="info" msg=$LANG.domainlockingexp}

        <br />

        <h2 class="text-center">{$LANG.domainreglockstatus}: <span class="label label-{if $lockstatus == "locked"}success{else}danger{/if}">{if $lockstatus == "locked"}{$LANG.domainsautorenewenabled}{else}{$LANG.domainsautorenewdisabled}{/if}</span></h2>

        <br />
        <br />

        <form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails#tabReglock">
            <input type="hidden" name="id" value="{$domainid}">
            <input type="hidden" name="sub" value="savereglock" />
            {if $lockstatus=="locked"}
                <p class="text-center">
                    <input type="submit" class="btn btn-lg btn-danger" value="{$LANG.domainreglockdisable}" />
                </p>
            {else}
                <p class="text-center">
                    <input type="submit" class="btn btn-lg btn-success" name="reglock" value="{$LANG.domainreglockenable}" />
                </p>
            {/if}
        </form>

    </div>
    <div class="tab-pane fade" id="tabRelease">
        <div class="sub-heading">
            <h3>{$LANG.domainrelease}</h3>
        </div>


        {include file="$template/includes/alert.tpl" type="info" msg=$LANG.domainreleasedescription}

        <form class="form-horizontal" role="form" method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
            <input type="hidden" name="sub" value="releasedomain">
            <input type="hidden" name="id" value="{$domainid}">

            <div class="form-group">
                <label for="inputReleaseTag" class="col-xs-4 control-label">{$LANG.domainreleasetag}</label>
                <div class="col-xs-6 col-sm-5">
                    <input type="text" class="form-control" id="inputReleaseTag" name="transtag" />
                </div>
            </div>

            <p class="text-center">
                <input type="submit" value="{$LANG.domainrelease}" class="btn btn-primary" />
            </p>
        </form>

    </div>
    <div class="tab-pane fade" id="tabAddons">
        <div class="sub-heading">
            <h3>{$LANG.domainaddons}</h3>
        </div>
        <p> {$LANG.domainaddonsinfo}</p>

        {if $addons.idprotection}
            <div class="single-addon">
                <div class="addon-icon">
                    <i class="fas fa-shield-alt fa-3x"></i>
                </div>
                <div class="addon-info">
                    <strong>{$LANG.domainidprotection}</strong><br />
                    {$LANG.domainaddonsidprotectioninfo}<br />
                    <form action="clientarea.php?action=domainaddons" method="post">
                        <input type="hidden" name="id" value="{$domainid}"/>
                        {if $addonstatus.idprotection}
                            <input type="hidden" name="disable" value="idprotect"/>
                            <input type="submit" value="{$LANG.disable}" class="btn btn-danger"/>
                        {else}
                            <input type="hidden" name="buy" value="idprotect"/>
                            <input type="submit" value="{$LANG.domainaddonsbuynow} {$addonspricing.idprotection}" class="btn btn-success"/>
                        {/if}
                    </form>
                </div>
            </div>
        {/if}
        {if $addons.dnsmanagement}
            <div class="single-addon">
                <div class="addon-icon">
                    <i class="fas fa-cloud fa-3x"></i>
                </div>
                <div class="addon-info">
                    <strong>{$LANG.domainaddonsdnsmanagement}</strong><br />
                    {$LANG.domainaddonsdnsmanagementinfo}<br />
                    <form action="clientarea.php?action=domainaddons" method="post">
                        <input type="hidden" name="id" value="{$domainid}"/>
                        {if $addonstatus.dnsmanagement}
                            <input type="hidden" name="disable" value="dnsmanagement"/>
                            <a class="btn btn-success" href="clientarea.php?action=domaindns&domainid={$domainid}">{$LANG.manage}</a> <input type="submit" value="{$LANG.disable}" class="btn btn-danger"/>
                        {else}
                            <input type="hidden" name="buy" value="dnsmanagement"/>
                            <input type="submit" value="{$LANG.domainaddonsbuynow} {$addonspricing.dnsmanagement}" class="btn btn-success"/>
                        {/if}
                    </form>
                </div>
            </div>
        {/if}
        {if $addons.emailforwarding}
            <div class="single-addon">
                <div class="addon-icon">
                    <i class="fas fa-envelope fa-3x"></i>
                </div>
                <div class="addon-info">
                    <strong>{$LANG.domainemailforwarding}</strong><br />
                    {$LANG.domainaddonsemailforwardinginfo}<br />
                    <form action="clientarea.php?action=domainaddons" method="post">
                        <input type="hidden" name="id" value="{$domainid}"/>
                        {if $addonstatus.emailforwarding}
                            <input type="hidden" name="disable" value="emailfwd"/>
                            <a class="btn btn-success" href="clientarea.php?action=domainemailforwarding&domainid={$domainid}">{$LANG.manage}</a> <input type="submit" value="{$LANG.disable}" class="btn btn-danger"/>
                        {else}
                            <input type="hidden" name="buy" value="emailfwd"/>
                            <input type="submit" value="{$LANG.domainaddonsbuynow} {$addonspricing.emailforwarding}" class="btn btn-success"/>
                        {/if}
                    </form>
                </div>
            </div>
        {/if}
    </div>
</div>

