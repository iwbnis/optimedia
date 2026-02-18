<link rel="stylesheet" type="text/css" href="modules/servers/WSResellerPanel/templates/newstyle.css" />{if $response}    {if $response == "success"}        {include file="$template/includes/alert.tpl" type="success" msg={$message} textcenter=true idname="alertModuleCustomButtonSuccess"}    {else}        {include file="$template/includes/alert.tpl" type="error" msg={$message}  textcenter=true idname="alertModuleCustomButtonFailed"}    {/if}{/if}{if $pendingcancellation}    {include file="$template/includes/alert.tpl" type="error" msg=$LANG.cancellationrequestedexplanation textcenter=true idname="alertPendingCancellation"}{/if} {if $alertmessage}    {include file="$template/includes/alert.tpl" type="info" msg=$alertmessage textcenter=true idname="alertModuleCustomButtoninfo"}{/if} 
<div class="tab-content margin-bottom">
    <div class="tab-pane fade in active" id="tabOverview">
        <div class="product-details clearfix">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-status product-status-{$rawstatus|strtolower}">
                        <div class="product-icon text-center">
                            <span class="fa-stack fa-lg">                            
                                <i class="fa fa-circle fa-stack-2x">
                                </i>                            
                                <i class="fa fa-television fa-stack-1x fa-inverse">
                                </i>                        
                            </span>                        
                            <h3>{$product}
                            </h3>
                            <h4>{$groupname}
                            </h4>
                        </div>
                        <div class="product-status-text">                        {$status}                    
                        </div>
                    </div>
                    {$unsuspend}             
                </div>
                <div class="col-lg-6">
                    <div  class="panel panel-default panel-accent-green">
                        <div class="panel-heading">
                            <h3 class="panel-title">                            
                                <i class="fa fa-info">
                                </i>&nbsp;Product Details                        
                            </h3>
                        </div>
                        <div class="list-group">
                            <div class="list-group-item" >                            Product : 
                                <strong class="text-domain">{$product} - {$groupname}
                                </strong>                        
                            </div>
                            <div class="list-group-item" >                            {$LANG.clientareastatus} : 
                                <span class="label status status-{$rawstatus}" style="display: inline;">{$status}
                                </span>                        
                            </div>
                            <div class="list-group-item" >                            {$LANG.clientareahostingregdate} : 
                                <strong class="text-domain"> {$regdate}
                                </strong>                        
                            </div>
                            <div style="color:red" class="list-group-item" > {$LANG.clientareahostingnextduedate}: 
                                <strong style="color:red" class="text-domain">{$nextduedate}
                                </strong>                
                            </div>
                            <div class="list-group-item" >                    {$LANG.recurringamount} : 
                                <strong class="text-domain">{$recurringamount}
                                </strong>                
                            </div>
                            <div class="list-group-item" >                    {$LANG.orderbillingcycle} : 
                                <strong class="text-domain"> {$billingcycle}
                                </strong>                
                            </div>
                            <div class="list-group-item" >                    {$LANG.orderpaymentmethod} : 
                                <strong class="text-domain">{$paymentmethod}
                                </strong>                
                            </div>
                            <div class="list-group-item" >                    {$LANG.firstpaymentamount} : 
                                <strong class="text-domain">{$firstpaymentamount}
                                </strong>                
                            </div> 
                            {foreach from=$extracustomfields key=customfieldname item=customfieldvalue}

                                <div class="list-group-item" >
                                    {$customfieldname}

                                    <strong class="text-domain">
                                        {$customfieldvalue}
                                    </strong>                
                                </div>
                            {/foreach}
                            {if $configurableoptions}  
                                {foreach from=$configurableoptions item=configoption}                        
                                    <div class="list-group-item" >                            
                                        {$configoption.optionname}                             
                                        <strong class="text-domain">    
                                            {if $configoption.optiontype eq 3}
                                                {if $configoption.selectedqty}
                                                    {$LANG.yes}
                                                {else}
                                                    {$LANG.no}
                                                {/if}
                                            {elseif $configoption.optiontype eq 4}
                                                {$configoption.selectedqty} x {$configoption.selectedoption}
                                            {else}
                                                {$configoption.selectedoption}
                                            {/if}            
                                        </strong>
                                    </div>
                                {/foreach}
                            {/if}
                            {if $lastupdate}
                                <div class="list-group-item" >        {$LANG.clientareadiskusage} : 
                                    <strong class="text-domain">{$diskusage}MB / {$disklimit}MB ({$diskpercent})
                                    </strong>    
                                </div>
                                <div class="list-group-item" >        {$LANG.clientareabwusage} : 
                                    <strong class="text-domain">{$bwusage}MB / {$bwlimit}MB ({$bwpercent})
                                    </strong>    
                                </div>
                            {/if} {if $suspendreason}    
                                <div class="list-group-item" >        {$LANG.suspendreason} : 
                                    <strong class="text-domain">{$suspendreason}
                                    </strong>    
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {foreach $hookOutput as $output}    
            <div>        {$output}    
            </div>
        {/foreach}  
        <script src="{$BASE_PATH_JS}/bootstrap-tabdrop.js"></script>
        <script type="text/javascript">    jQuery('.nav-tabs-overflow').tabdrop();</script> 
    </div>
    <div class="tab-pane fade out" id="tabDownloads">
        <h3>{$LANG.downloadstitle}</h3>
        {include file="$template/includes/alert.tpl" type="info" msg="{lang key="clientAreaProductDownloadsAvailable"}" textcenter=true}
        <div class="row">
            {foreach from=$downloads item=download}
                <div class="col-xs-10 col-xs-offset-1">
                    <h4>{$download.title}</h4>
                    <p>
                        {$download.description}
                    </p>
                    <p>
                        <a href="{$download.link}" class="btn btn-default"><i class="fa fa-download"></i> {$LANG.downloadname}</a>
                    </p>
                </div>
            {/foreach}
        </div>
    </div>
    <div class="tab-pane fade out" id="tabAddons">
        <h3>{$LANG.clientareahostingaddons}</h3>
        {if $addonsavailable}
            {include file="$template/includes/alert.tpl" type="info" msg="{lang key="clientAreaProductAddonsAvailable"}" textcenter=true}
        {/if}
        <div class="row">
            {foreach from=$addons item=addon}
                <div class="col-xs-10 col-xs-offset-1">
                    <h4>{$addon.name}</h4>
                    <p>
                        {$addon.pricing}
                    </p>
                    <p>
                        {$LANG.registered}: {$addon.regdate}
                    </p>
                    <p>
                        {$LANG.clientareahostingnextduedate}: {$addon.nextduedate}
                    </p>
                    <p>
                        <span class="label status-{$addon.rawstatus|strtolower}">{$addon.status}</span>
                    </p>
                </div>
            {/foreach}
        </div>
    </div>
    <div class="tab-pane fade out" id="tabChangepw">
        <h3>{$LANG.serverchangepassword}</h3>
        {if $modulechangepwresult}
            {if $modulechangepwresult == "success"}
                {include file="$template/includes/alert.tpl" type="success" msg=$modulechangepasswordmessage textcenter=true}
            {elseif $modulechangepwresult == "error"}
                {include file="$template/includes/alert.tpl" type="error" msg=$modulechangepasswordmessage|strip_tags textcenter=true}
            {/if}
        {/if}
        <form class="form-horizontal using-password-strength" method="post" action="{$smarty.server.PHP_SELF}?action=productdetails#tabChangepw" role="form">
            <input type="hidden" name="id" value="{$id}" />
            <input type="hidden" name="modulechangepassword" value="true" />
            <div id="newPassword1" class="form-group has-feedback">
                <label for="inputNewPassword1" class="col-sm-5 control-label">{$LANG.newpassword}</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputNewPassword1" name="newpw" autocomplete="off" />
                    <span class="form-control-feedback glyphicon"></span>
                    {include file="$template/includes/pwstrength.tpl"}
                </div>
            </div>
            <div id="newPassword2" class="form-group has-feedback">
                <label for="inputNewPassword2" class="col-sm-5 control-label">{$LANG.confirmnewpassword}</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputNewPassword2" name="confirmpw" autocomplete="off" />
                    <span class="form-control-feedback glyphicon"></span>
                    <div id="inputNewPassword2Msg">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-6">
                    <input class="btn btn-primary" type="submit" value="{$LANG.clientareasavechanges}" />
                    <input class="btn" type="reset" value="{$LANG.cancel}" />
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="row new_custom1"> 
            {if $status eq 'Active'}      
            <div class="col-sm-6">
                <form method="post" action="clientarea.php?action=productdetails&id={$serviceid}">                
                    <input type="hidden" name="id" value="{$serviceid}" />                
                    <input type="hidden" name="customAction" value="manage" />                
                    <button type="submit" class="btn btn-default btn-block btn_new_here">                     
                        Reseller Panel Details                
                    </button>            
                </form>
            </div>
        {/if}        
        <div class="col-sm-6">
            {if $showcancelbutton || $packagesupgrade}                
                <div class="row">
                    <div class="col-xs-{if $showcancelbutton}6{else}12{/if}">{$upgradeButton}
                    </div>
                    {if $showcancelbutton}                        
                        <div class="col-xs-{if $upgradeButton neq ''}6{else}12{/if}">                            
                            <a href="clientarea.php?action=cancel&amp;id={$id}" class="btn btn-block btn-danger btn_new1_here {if $pendingcancellation}disabled{/if}">{if $pendingcancellation}{$LANG.cancellationrequested}{else}{$LANG.clientareacancelrequestbutton}{/if}
                            </a>                        
                        </div>
                    {/if}                
                </div>
            {/if}        
        </div>
    </div>



    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <form method="post" action="clientarea.php?action=productdetails&id={$serviceid}"> 
        <div class="container"> 
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content"> 
                        <div class="modal-header">
                            <h4 class="modal-title" style="float: left;">ReCaptcha Confirm</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div> 
                        <div class="modal-body">
                            <div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="{$sitekey}" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>

                        </div> 
                        <div class="modal-footer">                
                            <input type="hidden" name="id" value="{$serviceid}" />   
                            {if $refreshandrenew eq '1'}  
                                <input type="hidden" name="customAction" value="renewservice" />            
                                {else}
                                <input type="hidden" name="customAction" value="refreshservice" />      
                            {/if}    
                            <button type="submit" class="btn btn-default btn-block btn_new_refresh1">                     
                                Continue                
                            </button>   
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>   
                    </div>
                </div>
            </div> 
        </div>
    </form>
    {if $checkupgrade eq 1}
        <div class="row new_custom_field">
            {if $is_trial eq 1}
                <p>Your Free Trial will be expire soon {if $exp_date neq ""} on {$exp_date|date_format:"%A, %B %e, %Y"}{/if}. Please upgrade to Paid Subscription below:</p>
            {/if}
            <div class="col-sm-4">
                <a href="upgrade.php?type=package&id={$service_id}">
                    <button type="submit" class="btn btn-default btn-block new_here1"> 
                        Upgrade Subscription                                
                    </button>   
                </a>
            </div>
            <div class="col-sm-4">
                <a href="index.php?rp=/knowledgebase">
                    <button type="submit" class="btn btn-default btn-block new_here2"> Setup Guide                                
                    </button>    
                </a>                         
            </div>
        </div>
        {if $checkcaptcha eq 'on'}
            {if $rawstatus neq 'active'}
                {if $showrefreshbtn eq 'yes'}
                    <div class="col-sm-4" style="padding-left: 0px; padding-right: 0px;">
                        <button type="button"class="btn btn-default btn-block btn_new_refresh" data-toggle="modal" data-target="#myModal" style="margin-left: 0px;">
                            Refresh Service  
                        </button>  
                    </div>
                {/if}
        {/if}{/if}
    {else}

        <div class="row new_custom_field new_custom_field1" style="margin-top: 90px;">
            {if $is_trial eq 1}
                <p>Your Free Trial will be expire soon {if $exp_date neq ""} on {$exp_date|date_format:"%A, %B %e, %Y"}{/if}. Please upgrade to Paid Subscription below:</p>
            {/if} 
            {if $checkcaptcha eq 'on'}
                {if $rawstatus neq 'active'}
                    {if $showrefreshbtn eq 'yes'}
                    <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                        <button type="button"class="btn btn-default btn-block btn_new_refresh" data-toggle="modal" data-target="#myModal" style="margin-left: 0px;">
                            Refresh Service  
                        </button>  
                    </div>
                    {/if}
            {/if}{/if}
            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                <a href="index.php?rp=/knowledgebase">
                    <button type="submit" class="btn btn-default btn-block new_here2"  style="margin-left: 0px;"> 
                        Setup Guide                                
                    </button> 
                </a>                                    
            </div>
        </div>
    {/if}  <!-- 
    -->
</div> 