<link rel="stylesheet" type="text/css" href="modules/servers/XUIResellerPanel/templates/newstyle.css?v=vvvvvvvvv" />

{if $pendingcancellation}
{include file="$template/includes/alert.tpl" type="error" msg=$LANG.cancellationrequestedexplanation textcenter=true
idname="alertPendingCancellation"}
{/if}
{if $alertmessage}
{include file="$template/includes/alert.tpl" type="info" msg=$alertmessage textcenter=true
idname="alertModuleCustomButtoninfo"}
{/if}
<div class="show tab-panel fade in active" id="tabOverview">
    <div class="product-details clearfix">
        <div class="row">
            <div class="col-md-6 panel_design">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fab fa-product-hunt"></i>&nbsp;Product Details
                    </h3>
                </div>
                <div class="panel panel-default panel-accent-blue panelfont">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="font-size:15px;padding: 7px;">
                            <i class="fas fa-tv"></i>&nbsp;{$lang.iptv_service_details}
                        </h3>
                    </div>
                    <div class="list-group">
                        <div class="list-group-item">
                            Package Name : <strong class="text-domain"> {$groupname} - {$product}</strong>
                        </div>
                        <div class="list-group-item">
                            <i class="fas fa-shield text-grey" data-toggle="tooltip" data-placement="auto right"
                                title="" data-original-title="Your IPTV service Username to login via APP"></i> <span
                                class="label label-info">{$lang.username} :</span> <strong
                                class="text-domain">{$iptv_username} </strong>
                        </div>
                        <div class="list-group-item">
                            <i class="fas fa-shield text-grey" data-toggle="tooltip" data-placement="auto right"
                                title="" data-original-title="Your IPTV service Password to login via APP"></i>
                            <span class="label label-info">{$lang.password} :</span>
                            {if $iptv_password neq ''}
                            <form method="POST" id="overviewForm" action="clientarea.php?action=productdetails&id={$serviceid}"
                                style="display: contents;">
                                <strong class="text-domain">
                                    <span style="display:none;" id="show">
                                        {$iptv_password}
                                    </span>
                                    <span style="display:none;" id="update_pass">
                                        <input type="text" id="pass_word" name="pass_word" value="{$iptv_password}">
                                    </span>
                                    <span id="hide">
                                        ********
                                    </span>
                                </strong>
                                &nbsp;&nbsp;
                                <span id="showbtnspan" onclick="jQuery('#show').css('display', 'inline');
                                            jQuery('#hide').css('display', 'none');
                                            jQuery(this).css('display', 'none');
                                            jQuery('#hidebtnspan').css('display', 'inline')"
                                    class="label status status-active"
                                    style="display: inline;cursor: pointer;color: white;">
                                    Show
                                </span>
                                <span id="hidebtnspan" onclick="jQuery('#hide').css('display', 'inline');
                                            jQuery('#show').css('display', 'none');
                                            jQuery(this).css('display', 'none');
                                            jQuery('#showbtnspan').css('display', 'inline')"
                                    class="label status status-active"
                                    style="display: none;cursor: pointer;color: white;">
                                    Hide
                                </span>
                                <span id="updatepass" class="label status status-active"
                                    style="display: inline;cursor: pointer;" onclick="
                                            jQuery('#update_pass').css('display', 'inline-block');
                                            jQuery('#updatepass').css('display', 'none');
                                            jQuery('#hide').css('display', 'none');
                                            jQuery('#save_pass').css('display', 'inline-block');
                                            jQuery('#show').css('display', 'none');">
                                    Update
                                </span>
                                <input type="hidden" name="customAction" value="update_pass">
                                <input type="hidden" name="serviceid" value="{$serviceid}">
                                <button id="save_pass" type="button" class="label status status-active"
                                    style="display: none;cursor: pointer;color: white;padding: 0;width: 12%;">
                                    Save
                                </button>
                                <input type="hidden" id="clientSelectedBouquets1" name="clientSelectedBouquets" value="">
                            </form>
                            {else}
                            -
                            {/if}
                        </div>
                        <div class="list-group-item">
                            <span> Expiry Date:</span> <strong class="text-domain">{$exp_date|date_format:"%A, %B %e,
                                %Y"} </strong>
                        </div>
                        <div class="list-group-item">
                            <span> Edit Bouquets:</span>
                            <strong class="text-domain">
                                <button type="button" onclick="selectbouquetsFirst()" style="padding: 8px 0px 8px 0px;width: 30%;font-size: 14px;" class="btn btn-primary">Select Buquets</button>
                            </strong>
                        </div>
                        <form method="post" action="clientarea.php?action=productdetails&id={$serviceid}">
                            {if $customfields}
                            {foreach from=$customfields item=field}
                            {if $lang.custom_field_mag == {$field.name}}
                            {if $field.value neq ''}
                            <div class="list-group-item">
                                MAG Portal! : <strong class="text-domain"><a target="_blank"
                                        href='{$mag_portal}'>{$mag_portal} </a></strong>
                            </div>

                            <div class="list-group-item">
                                {$field.name} : <strong id="mag_span" class="text-domain">{if $field.value neq
                                    ''}{$field.value}{else}None{/if}</strong>

                                <input style="display:none;width: 40%;" type="text" name="magupdate" id="magupdateInput"
                                    value="{if $field.value neq ''}{$field.value}{/if}">
                                <span id="updatemagaddress" class="label status status-active"
                                    style="display: inline;cursor: pointer;" onclick="
                                                        jQuery('#mag_span').css('display', 'none');
                                                        jQuery('#updatemagaddress').css('display', 'none');
                                                        jQuery('#magupdateInput').css('display', 'inline-block');
                                                        jQuery('#updatemag').css('display', 'inline-block');">
                                    Update
                                </span>
                                <button id="updatemag" type="submit" class="label status status-active"
                                    style="display: none;cursor: pointer;color: white;padding: 0;width: 12%;">
                                    Save
                                </button>
                            </div>
                            {/if}
                            <input type="hidden" name="customAction" value="update_magaddress">
                            <input type="hidden" name="magFieldId" value="{$field.id}">
                            <input type="hidden" name="serviceid" value="{$serviceid}">
                            {/if}
                            {/foreach}
                            {/if}
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default panel-accent-green panelfont" style="margin-top:40px">
                    <div class="list-group">
                        <div class="list-group-item">
                            Product : <strong class="text-domain">{$product} - {$groupname}</strong>
                        </div>
                        <div class="list-group-item">
                            {$LANG.clientareastatus} : <span class="label status status-{$rawstatus}"
                                style="display: inline;">{$status}</span>
                        </div>
                        <div class="list-group-item">
                            {$LANG.clientareahostingregdate} : <strong class="text-domain"> {$regdate}</strong>
                        </div>

                        <div class="list-group-item">
                            {$LANG.recurringamount} : <strong class="text-domain">{$recurringamount}</strong>
                        </div>
                        <div class="list-group-item">
                            {$LANG.orderbillingcycle} : <strong class="text-domain"> {$billingcycle}</strong>
                        </div>
                        <div class="list-group-item">
                            {$LANG.orderpaymentmethod} : <strong class="text-domain">{$paymentmethod}</strong>
                        </div>
                        <div class="list-group-item">
                            {$LANG.firstpaymentamount} : <strong class="text-domain">{$firstpaymentamount}</strong>
                        </div>
                        {if $configurableoptions}
                        {foreach from=$configurableoptions item=configoption}
                        <div class="list-group-item">
                            {$configoption.optionname}
                            <strong class="text-domain">
                                {if $configoption.optiontype eq 3}{if
                                $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif
                                $configoption.optiontype eq 4}{$configoption.selectedqty} x
                                {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}
                            </strong>
                        </div>
                        {/foreach}
                    </div>
                    {/if}
                    {if $lastupdate}
                    <div class="list-group-item">
                        {$LANG.clientareadiskusage} : <strong class="text-domain">{$diskusage}MB / {$disklimit}MB
                            ({$diskpercent})</strong>
                    </div>
                    <div class="list-group-item">
                        {$LANG.clientareabwusage} : <strong class="text-domain">{$bwusage}MB / {$bwlimit}MB
                            ({$bwpercent})</strong>
                    </div>
                    {/if}
                    {if $suspendreason}
                    <div class="list-group-item">
                        {$LANG.suspendreason} : <strong class="text-domain">{$suspendreason}</strong>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div> 
<div style="width: 100%;" class="container">
    <div class="row new_custom_field2221">
        <div class="col-sm-6">
            <form id="login" method="post" target="_blank" action="{$watchstrmurl}">
                <input name="username" value="{$iptv_username}" type="hidden">
                <input type="hidden" name="password" value="{$iptv_password}">
                <input class="btn btn-default btn-block lovey_webtv" style="float:left;margin-right: 50px;" value='Watch Stream!' type="submit" onclick="setNonSecureAction()">
            </form>
        </div>
        <script>
        function setNonSecureAction() {
            var form = document.getElementById("login");
            var actionUrl = form.getAttribute("action");
            
            if (actionUrl.startsWith("https://")) {
                actionUrl = "http://" + actionUrl.substring(8);
            } else if (!actionUrl.startsWith("http://")) {
                actionUrl = "http://" + actionUrl;
            }
            
            form.setAttribute("action", actionUrl);
        }
        </script>
        <div class="col-sm-6">
            <button type="button" class="btn btn-info downloadapp" data-toggle="modal" data-target="#applicationpopup">
                Download Application &nbsp;&nbsp;<i class="fa fa-download download_icn_set" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

<br>
{foreach $hookOutput as $output}
<div>
        {$output|unescape:'html'}
</div>
{/foreach}

<script src="{$BASE_PATH_JS}/bootstrap-tabdrop.js"></script>
<script type="text/javascript">
    jQuery('.nav-tabs-overflow').tabdrop();
    $(document).ready(function(){
        $("#save_pass").click(function(){ 
            $("#clientSelectedBouquets1").val($("#clientSelectedBouquets").val());
            $("#overviewForm").submit(); 
        });
    });
</script>

<div class="list-group-item item_new">
    <div width="100%">
        <div style="width: 17%; float: left; margin-top: 8px; font-size: 14px;"><b>M3U & EPG List:</b></div>
        <div>
            <label style="margin-right: 12px; margin-top: 6px;"> 
                <input type="radio" style="margin-right: 6px;" name="m3u_output" checked="checked" value="m3u_plus" onclick="updateOutput()">M3U Plus
            </label>
            <label style="margin-right: 12px; margin-top: 6px;"> 
                <input type="radio" style="margin-right: 6px;" name="m3u_output" value="m3u" onclick="updateOutput()">M3U
            </label>
            <label style="margin-right: 12px; margin-top: 6px;"> 
                <input type="radio" style="margin-right: 6px;" name="m3u_output" value="m3u_basic" onclick="updateOutput()">M3U Basic
            </label>
            <label style="margin-right: 12px; margin-top: 6px;"> 
                <input type="radio" style="margin-right: 6px;" name="m3u_output" value="epg_url" onclick="updateOutput()">EPG URL
            </label>
        </div>
    </div>
    <div width="100%" style="clear: both; margin-top: 12px;">
        <div style="width: 14%; float: left; margin-top: 8px; font-size: 14px;"><b>URL:</b></div>
        <div>
            <input style="width: 55%; float: left; margin-right: 15px;" class="form-control" type="text" id="m3ulinks" value="{$m3uurl}/playlist/{$iptv_username}/{$iptv_password}/">
		<button id="m3u_download" class="btn btn-default btn-primary" onclick="openInNewTab()">
			<i class="fa fa-download" aria-hidden="true"></i> Download
		</button>
           <button id="copyButton" onclick="copyToClipboard()" class="btn btn-default btn-secondary" style="margin-left: 10px;">
			<i class="fa fa-copy" aria-hidden="true"></i> Click to Copy
		</button>
        </div>
    </div>
</div>

<script>
function updateOutput() {
    var selectedValue = document.querySelector('input[name="m3u_output"]:checked').value;
    var m3uBaseURL = "{$m3uurl}/playlist/{$iptv_username}/{$iptv_password}/";
    var m3uLink;

    if (selectedValue === "m3u_plus") {
        m3uLink = m3uBaseURL + "m3u_plus";
    } else if (selectedValue === "m3u") {
        m3uLink = m3uBaseURL + "m3u";
    } else if (selectedValue === "m3u_basic") {
        m3uLink = "{$m3uurl}/get.php?username={$iptv_username}&password={$iptv_password}&type=m3u_plus&output=mpegts"; // Completely different value for M3U Basic
    } else if (selectedValue === "epg_url") {
        m3uLink = "{$m3uurl}/xmltv.php?username={$iptv_username}&password={$iptv_password}"; // Completely different value for EPG URL
    }

    document.getElementById("m3ulinks").value = m3uLink;
}

function openInNewTab() {
    var downloadLink = document.getElementById("m3ulinks").value;
    window.open(downloadLink, '_blank', 'noopener,noreferrer');
}


</script>

 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script src="https://clipboardjs.com/dist/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script> 
    <script>
                                    $(document).ready(function () {
                                        var myRadio = $('input[name=stream_output]');
                                        var mode = myRadio.filter(':checked').val();
                                        $('.dropdown-menu.mydropdown a').each(function () {
                                            $(this).attr('href', $(this).data('url') + mode);
                                        });
                                        myRadio.on('change', function () {
                                            var mode = myRadio.filter(':checked').val();
                                            //here change the urls
                                            $('.dropdown-menu.mydropdown a').each(function () {
                                                $(this).attr('href', $(this).data('url') + mode);
                                            });
                                        });
                                        var mym3ulink = $('input[name=m3u_output]');
                                        var mode = mym3ulink.filter(':checked').val();
                                        $('#m3u_output').attr('href', $('#m3u_output').data('url') + mode);
                                        $('#m3ulinks').attr('value', $('#m3u_output').data('url') + mode);
                                        mym3ulink.on('change', function () {
                                            var mode = mym3ulink.filter(':checked').val();
                                            $('#m3ulinks').attr('value', $('#m3u_output').data('url') + mode);
                                            $('#m3u_output').attr('href', $('#m3u_output').data('url') + mode);
                                        });


                                    });
                                    $(".btnclipboard").click(function () {

                                        var id = this.id;
                                        var clipboard = new ClipboardJS("#" + id);
                                        clipboard.on('success', function (e) {
                                            $('.btnclipboard').html('Click to Copy');
                                            $('#' + id).html('Copied text to clipboard!');
                                        });
                                        clipboard.on('error', function (e) {
                                            console.log(e);
                                        });
                                    });


    </script> 

    <div class="modal fade" id="applicationpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style=" float: left;font-size:22px " id="exampleModalLongTitle">Choose Your Platform</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {if $appdata|@count gt 0}   
                        <div class="container-fluid"> 
                            <div class="row">
                            {* <pre> *}
                            {* {$appdata|@print_r} *}
                                {* {foreach item=application from=$appdata} *}

                                 {foreach item=applidata from=$appdata}


                                    {if {$applidata.apptype} == 'android'}
                                        <div class="col-md-4 ml-auto"  style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 230px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-android fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">Android APP</h3>
                                            <span  style="margin-bottom: 13px;">({$applidata.name})</span>  
                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" target="__blank" class="btn btn-success" style="font-size: 12px; ">DOWNLOAD NOW</a></center></div>

                                    {/if}
                                    {if {$applidata.apptype} == 'ios'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 230px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-apple fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">IOS APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}
                                    {if {$applidata.apptype} == 'linux'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 230px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-linux fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">Linux APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}
                                    {if {$applidata.apptype} == 'windows'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 230px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-windows fa-5x"></i></center>
                                            <h3 class="text-center" style="margin-top: 15px;font-size: 22px;">Windows APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}

                                    {if {$applidata.apptype} == 'macos'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 230px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-desktop fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">MacOS APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}

                                    {/foreach} 
                                {* {/foreach}  *}
                            </div> 
                        </div> 
                    {/if} 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div> 
    {if $checkupgrade eq 1}
        <div class="row new_custom_field">
            {* {if $is_trial eq 1}
                <p>Your Free Trial will be expire soon {if $exp_date neq ""} on {$exp_date|date_format:"%A, %B %e, %Y"}{/if}. Please upgrade to Paid Subscription below:</p>
            {/if}*}
            <div class="col-sm-6">
                <a href="upgrade.php?type=package&id={$service_id}">
                    <button type="submit" class="btn btn-default btn-block new_here111"> 
                        Upgrade Subscription                                
                    </button>   
                </a>
            </div>
            <div class="col-sm-6">
                <a href="index.php?rp=/knowledgebase">
                    <button type="submit" class="btn btn-default btn-block new_here11122"> Setup Guide                                
                    </button>    
                </a>                         
            </div>
        </div>
    {else}
        <div class="row new_custom_field new_custom_field1">
            {*{if $is_trial eq 1}
            <p>Your Free Trial will be expire soon {if $exp_date neq ""} on {$exp_date|date_format:"%A, %B %e, %Y"}{/if}. Please upgrade to Paid Subscription below:</p>
            {/if}*}
            <div class="col-sm-12">
                <a href="index.php?rp=/knowledgebase">
                    <button type="submit" class="btn btn-default btn-block new_here2 new_custm" style="width: 45% !important;text-align: center;position: relative;left: 0;right: 0;margin: 0 auto;"> 
                        Setup Guide                                
                    </button> 
                </a>                                    
            </div>
        </div>
    {/if}
</div>