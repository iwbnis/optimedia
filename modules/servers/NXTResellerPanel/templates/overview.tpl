<link rel="stylesheet" type="text/css" href="modules/servers/NXTResellerPanel/templates/newstyle.css?v=ddvdddddd" />
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
                            Package Name :  <strong class="text-domain">  {$groupname} - {$product}</strong>
                        </div>  
                        <div class="list-group-item">  
                            <i class="fas fa-shield text-grey" data-toggle="tooltip" data-placement="auto right" title="" data-original-title="Your IPTV service Username to login via APP"></i> <span class="label label-info">{$lang.username} :</span>  <strong class="text-domain">{$iptv_username} </strong> 
                        </div>  
                        <div class="list-group-item">
                            <i class="fas fa-shield text-grey" data-toggle="tooltip" data-placement="auto right" title="" data-original-title="Your IPTV service Password to login via APP"></i>
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
                                {if $pass_editable == "on"}
                                    <span id="updatepass" class="label status status-active"
                                        style="display: inline;cursor: pointer;" onclick="
                                                jQuery('#update_pass').css('display', 'inline-block');
                                                jQuery('#updatepass').css('display', 'none');
                                                jQuery('#hide').css('display', 'none');
                                                jQuery('#save_pass').css('display', 'inline-block');
                                                jQuery('#show').css('display', 'none');">
                                            Update
                                    </span>
                                {/if}
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
                            <span> Expiry Date:</span> <strong class="text-domain">{$exp_date|date_format:"%A, %B %e, %Y"} </strong>
                        </div> 
                        <div class="list-group-item">
                            MAG Portal! :  <strong class="text-domain"><a target="_blank" href='{$mag_portal}/c/'>{$mag_portal}/c/ </a></strong> 
                        </div> 
<div class="list-group-item">
                            <span> Edit Bouquets:</span>
                            <strong class="text-domain">
                                <button type="button" onclick="selectbouquetsFirst()" style="padding: 8px 0px 8px 0px;width: 30%;font-size: 14px;" class="btn btn-primary">Select Buquets</button>
                            </strong>
                        </div>
                        {if $customfields} 
                            {foreach from=$customfields item=field}
                                {if $lang.custom_field_mag == {$field.name}}
                                    <div class="list-group-item" >{$field.name} : <strong class="text-domain">{if $field.value neq ''}{$field.value}{else}None{/if}</strong> </div> 
                                {/if}
                            {/foreach} 
                        {/if} 
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div  class="panel panel-default panel-accent-green panelfont" style="margin-top:40px"> 
                    <div class="list-group">
                        <div class="list-group-item" >
                            Product : <strong class="text-domain">{$product} - {$groupname}</strong>
                        </div>
                        <div class="list-group-item" >
                            {$LANG.clientareastatus} : <span class="label status status-{$rawstatus}" style="display: inline;">{$status}</span>
                        </div>
                        <div class="list-group-item" >
                            {$LANG.clientareahostingregdate} : <strong class="text-domain"> {$regdate}</strong>
                        </div>

                        <div class="list-group-item" >
                            {$LANG.recurringamount} : <strong class="text-domain">{$recurringamount}</strong>
                        </div>
                        <div class="list-group-item" >
                            {$LANG.orderbillingcycle} : <strong class="text-domain"> {$billingcycle}</strong>
                        </div>
                        <div class="list-group-item" >
                            {$LANG.orderpaymentmethod} : <strong class="text-domain">{$paymentmethod}</strong>
                        </div>
                        <div class="list-group-item" >
                            {$LANG.firstpaymentamount} : <strong class="text-domain">{$firstpaymentamount}</strong>
                        </div>
                        {if $configurableoptions} 
                            {foreach from=$configurableoptions item=configoption}
                                <div class="list-group-item" >
                                    {$configoption.optionname} 
                                    <strong class="text-domain"> 
                        {if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}
                    </strong>
                </div>
            {/foreach}
        </div>
    {/if}
    {if $lastupdate}
        <div class="list-group-item" >
            {$LANG.clientareadiskusage} : <strong class="text-domain">{$diskusage}MB / {$disklimit}MB ({$diskpercent})</strong>
        </div>
        <div class="list-group-item" >
            {$LANG.clientareabwusage} : <strong class="text-domain">{$bwusage}MB / {$bwlimit}MB ({$bwpercent})</strong>
        </div>
    {/if} 
    {if $suspendreason}
        <div class="list-group-item" >
            {$LANG.suspendreason} : <strong class="text-domain">{$suspendreason}</strong>
        </div>
    {/if}
</div>
</div>
</div>
</div> 
</div>  
    {if $status eq 'Active'}  <p class="new_p">Your online WebTV Player to watch your HD Channels &amp; VOD 
            for WebTV Player Button</p> 
        <hr>
        <div class="row new_custom1"> 
        <div class="col-md-6"> 
            {if $watchstream eq 'on'}
                <form id="login" method="post" target="_blank" action="{$watchstrmurl}"> 
                    <input name="username" value="{$iptv_username}" type="hidden"> 
                    <input type="hidden" name="password"value="{$iptv_password}"> 
                    <input class="btn btn-default btn-block lovey_webtv" style="float:left;margin-right: 50px;" value='Watch Stream!' type="submit">
                </form>
            {/if}  
        </div> 
    </div> 


    {/if}


    {foreach $hookOutput as $output}
        <div>
            {$output}
        </div>
    {/foreach}  
    <script src="{$BASE_PATH_JS}/bootstrap-tabdrop.js"></script>
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

    {if $m3ulink eq 'on'} 
        <div class="list-group-item item_new"> 
            <div width="100%"> 
                <div style="width: 17%;float: left;margin-top: 8px;font-size: 14px;"><b>M3U File Type :</b></div>  <div> 
                    <label style="margin-right: 12px;margin-top: 6px;"> <input type="radio" style="margin-right: 6px;" name="m3u_output"  checked="checked" value="m3u_plus">M3U Plus</label>
                    <label style="margin-right: 12px;margin-top: 6px;"> <input type="radio" style="margin-right: 6px;" name="m3u_output"  value="m3u">M3U</label> </div>
            </div>  
            <div  width="100%" style="clear: both;margin-top: 12px;"> 
                <div style="width: 14%;float: left;margin-top: 8px;font-size: 14px;"><b>{$lang.playlist} :</b></div>  <div> 
                    <input style="width: 55%;float: left;margin-right: 15px;"  class="form-control" type="text" id="m3ulinks" value="{$m3uurl}/playlist/{$iptv_username}/{$iptv_password}/">
                    <a id="m3u_output" data-url="{$m3uurl}/playlist/{$iptv_username}/{$iptv_password}/"  href='{$m3uurl}/playlist/{$iptv_username}/{$iptv_password}/' class="btn btn-default btn-primary">
                        <i class="fa fa-download" aria-hidden="true"></i> Download
                    </a> 
                </div>
            </div>  
        </div> 
    {/if} 

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
                                        <div class="col-md-4 ml-auto"  style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 205px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-android fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">Android APP</h3>
                                            <span>({$applidata.name})</span>
                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" target="__blank" class="btn btn-success" style="font-size: 12px; ">DOWNLOAD NOW</a></center></div>

                                    {/if}
                                    {if {$applidata.apptype} == 'ios'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 205px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-apple fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">IOS APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}
                                    {if {$applidata.apptype} == 'linux'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 205px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-linux fa-5x"></i></center>
                                            <h3 class="text-center" style=" margin-top: 13px; ">Linux APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}
                                    {if {$applidata.apptype} == 'windows'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 205px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-windows fa-5x"></i></center>
                                            <h3 class="text-center" style="margin-top: 15px;font-size: 22px;">Windows APP</h3>
                                            <span>({$applidata.name})</span><br>

                                            <center style="position: absolute; bottom: 8px; width: 88%;"><a href="{$applidata.applink}" class="btn btn-success" style="font-size: 12px;">DOWNLOAD NOW</a></center>
                                        </div>
                                    {/if}

                                    {if {$applidata.apptype} == 'macos'}
                                        <div class="col-md-4 ml-auto" style="padding: 14px;background:#eaeaea;border-radius: 5px;height: 205px;border: solid 3px #fff; text-align:center;"><center><i class="fab fa-desktop fa-5x"></i></center>
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
       {if $is_trial eq 1}
                <p>Your Free Trial will be expire soon {if $exp_date neq ""} on {$exp_date|date_format:"%A, %B %e, %Y"}{/if}. Please upgrade to Paid Subscription below:</p>
            {/if}
        <div class="row new_custom_field"> 
            <div class="col-sm-6">
                <a href="upgrade.php?type=package&id={$service_id}">
                    <button type="submit" class="btn btn-default btn-block new_here1"> 
                        Upgrade Subscription                                
                    </button>   
                </a>
            </div>
            <div class="col-sm-6">
                <a href="index.php?rp=/knowledgebase">
                    <button type="submit" class="btn btn-default btn-block new_here2"> Setup Guide                                
                    </button>    
                </a>                         
            </div>
        </div>
    {else}
    {if $is_trial eq 1}
                <p>Your Free Trial will be expire soon {if $exp_date neq ""} on {$exp_date|date_format:"%A, %B %e, %Y"}{/if}. Please upgrade to Paid Subscription below:</p>
            {/if}
        <div class="row new_custom_field new_custom_field1"> 
            <div class="col-sm-12">
                <a href="index.php?rp=/knowledgebase">
                    <button type="submit" class="btn btn-default btn-block new_here2 new_custm" style="width: 45%;text-align: center;position: relative;left: 0;right: 0;margin: 0 auto;"> 
                        Setup Guide                                
                    </button> 
                </a>                                    
            </div>
        </div>
    {/if}
</div>