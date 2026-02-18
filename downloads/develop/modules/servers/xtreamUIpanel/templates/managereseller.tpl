<link rel="stylesheet" type="text/css" href="modules/servers/WSResellerPanel/templates/newstyle.css" />
<p>Here you can see details related to reseller service.</p>

<div class="row">
    <div class="col-lg-9 panel_design">
        <div class="panel panel-default panel-accent-blue">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-info"></i>&nbsp;My Reseller Panel Details
                </h3>
            </div>
            <div class="list-group">
                <div class="list-group-item">
                    Product :  <strong class="text-domain">  {$groupname} - {$product}</strong>
                </div>  
                <div class="list-group-item">
                    Username :  <strong class="text-domain">{$iptv_username} </strong>
                </div>  
                <div class="list-group-item">
                    <span>Password :</span> {if $iptv_password neq ''}<strong class="text-domain"><span style="display:none;" id="show">{$iptv_password}</span> <span id="hide">********</span>

                        <input type="text" id="show1" name="newPassword" value="{$iptv_password}" style="display:none;">
                    </strong> &nbsp;&nbsp;<span onclick="jQuery('#show').css('display', 'inline');
                            jQuery('#hide').css('display', 'none')" class="label status status-active" style="display: inline;cursor: pointer;">Show</span>

                    {else}-{/if}
                        </div> 
                        <div class="list-group-item">
                            Panel URL :  <a href="{$resellerPanelURL}"><strong class="text-domain">{$resellerPanelURL}</strong></a>
                        </div>
                        <!--<div class="list-group-item">
                            Credits :  <strong style="font-size: 16px;" class="text-domain"><font color="orange"><u>{$reseller_credits} Credits</u></font><input type="button" onclick="window.location.href='cart.php'" value="Add Credits" style="padding: 6px 12px;width: 220px;margin-left: 50px"class="btn btn-success"></strong>
                        </div>-->
                    </div>
                </div>  
            </div>
        </div>


        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-4"></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form method="post" action="clientarea.php?action=productdetails&id={$serviceid}">
                    <input type="hidden" name="id" value="{$serviceid}" />
                    <input type="hidden" name="customAction" value="overview" />
                    <button type="submit" class="btn btn-default btn-block overview_btn_new">
                        <i class="fa fa-arrow-circle-left"></i>
                        Back to Overview
                    </button>
                </form>
            </div>
        </div> 