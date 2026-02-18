<link rel="stylesheet" type="text/css" href="modules/servers/xtreamUIpanel/templates/newstyle.css" />
<p>Here you can see details related to iptv service.</p>

<div class="row">
    <div class="col-lg-9 panel_design">
        <div class="panel panel-default panel-accent-blue">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-info"></i>&nbsp;My IPTV Subscription Details
                </h3>
            </div>
            <div class="list-group">
                <div class="list-group-item">
                    {$lang.product_service} :  <strong class="text-domain">  {$groupname} - {$product}</strong>
                </div>  
                <div class="list-group-item">
                    {$lang.username} :  <strong class="text-domain">{$iptv_username} </strong>
                </div>  
                <div class="list-group-item">
                    <span>{$lang.password} :</span> {if $iptv_password neq ''}<strong class="text-domain"><span style="display:none;" id="show">{$iptv_password}</span> <span id="hide">********</span>
                         
                            <input type="text" id="show1" name="newPassword" value="{$iptv_password}" style="display:none;">
                    </strong> &nbsp;&nbsp;<span onclick="jQuery('#show').css('display', 'inline'); jQuery('#hide').css('display', 'none')" class="label status status-active" style="display: inline;cursor: pointer;">Show</span>
                    
                    {else}-{/if}
                </div>
                {if $mag_portal eq 'on'} 
                    <div class="list-group-item">
                        <div width="100%" class="">      
                            <div style="width: 12%;float: left;margin-top: 0px;">MAG Portal! :</div>  <div> 
                                <a target="_blank" href='{$ServerHostName}/c/' style="
                                   margin-right: 15px;
                                   ">                                {$ServerHostName}/c/
                                </a>


                            </div>
                        </div>  
                    </div>
                {/if}  
                {if $customfields} 
                    {foreach from=$customfields item=field}
                        {if $lang.custom_field_mag == {$field.name}}
                            <div class="list-group-item" >{$field.name} : <strong class="text-domain">{if $field.value neq ''}{$field.value}{else}None{/if}</strong> </div> 
                        {/if}
                    {/foreach} 
                {/if} 
            </div>
        </div>

        {if $watchstream eq 'on'}
            <center>
                <form id="login" method="post" target="_blank" action="{$ServerHostName}/client_area/index.php"> 
                    <input name="username" value="{$iptv_username}" type="hidden"> 
                    <input type="hidden" name="password"value="{$iptv_password}"> 
                    <input class="btn btn-default btn-primary" value='Web TV Player' type="submit"> <i class="fa fa-television tv_custom" aria-hidden="true"></i>

                </form></center> {/if}     


        </div>
    </div>

    <!--- ISP LOCK -->
    {if !empty($isplock_desc)}
        <div class="row">
            <div class="col-sm-5">
                {$translate_isplock}
            </div>
            <div class="col-sm-7">
                {$isplock_desc}
            </div>
        </div>
    {/if}  

    <div class="row"> 
        {if !empty($isplock_desc)}
            <div class="col-sm-4">
                <form method="post" action="clientarea.php?action=productdetails">
                    <input type="hidden" name="id" value="{$serviceid}" />
                    <input type="hidden" name="customAction" value="resetisp" />

                    <button type="submit" class="btn btn-default btn-block">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                        {$translate_reset_btn}
                    </button>
                </form>
            </div>
        {/if}
    </div>  
    {if $m3ulink eq 'on'} 
        <div class="list-group-item item_new"> 
            <div width="100%"> 
                <div class="list_itm_here" style="width: 17%;float: left;margin-top: 8px;font-size: 14px;"><b>M3U File Type :</b></div>  <div> 
                    <label style="margin-right: 12px;margin-top: 6px;"> <input type="radio" style="margin-right: 6px;" name="m3u_output"  checked="checked" value="m3u_plus">M3U Plus</label>
                    <label style="margin-right: 12px;margin-top: 6px;"> <input type="radio" style="margin-right: 6px;" name="m3u_output"  value="m3u">M3U</label> </div>
            </div>  
            <div  width="100%" style="clear: both;margin-top: 12px;"> 
                <div class="list_itm_here_new" style="width: 14%;float: left;margin-top: 8px;font-size: 14px;"><b>{$lang.playlist} :</b></div>  <div> 
                    <input style="width: 55%;float: left;margin-right: 15px;"  class="form-control" type="text" id="m3ulinks" readonly value="{$ServerHostName}/get.php?username={$iptv_username}&password={$iptv_password}&output={$m3ulinkoutput}&type=">
                    <button class="btn btnclipboard new_btn_custom" style="width: 10%;" id="M3UPlaylistid" data-clipboard-target="#m3ulinks"><img src="modules/servers/xtreamUIpanel/templates/image/copy-button.png"></button>
                </div>
            </div>  
        </div> 
        <center>   <a id="m3u_output" data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$iptv_password}&output={$m3ulinkoutput}&type="  href='{$ServerHostName}/get.php?username={$iptv_username}&password={$iptv_password}&output={$m3ulinkoutput}&type=' class="btn btn-default btn-primary">
                Download M3u File  <i class="fa fa-download download_icn_set" aria-hidden="true"></i>
            </a> </center>
        {/if}

   
     
{if $autoscriptconfig == "on"} <p>{$lang.devices_desc}</p>  
    {if !empty($autoscript)} 
        <div class="panel panel-default panel_design_here">
            <!-- Default panel contents -->
            <div class="panel-heading">{$lang.autoscripts}</div> 
            <div class="panel-body panel_no_padding"> 
                {assign var="customcount" value=0}
                {foreach from=$autoscript key=scriptname item=scriptvalue}
                    {assign "find" array('{$serverhostname}', '{$iptv_username}', '{$iptv_password}','{$outputfirst}')}
                    {assign "repl" array($ServerHostName, {$iptv_username}, {$iptv_password},{$outputfirst})}  
                    <div class="list-group-item">
                        <div width="100%"> 
                            <div class="panel_sub_custom" style="width: 18%;float: left;margin-top: 8px;font-size: 14px;">{$scriptname}
                                : 
                            </div>
                            <div>
                                <input style="width: 70%;float: left;margin-right: 15px;"  class="form-control btn_set_width" type="text" id="custominputid{$customcount}" value="{$scriptvalue|replace:$find:$repl}">
                                <button class="btn btnclipboard" style="width: 10%;" id="EQGis{$customcount}" data-clipboard-target="#custominputid{$customcount}"><img src="modules/servers/xtreamUIpanel/templates/image/copy-button.png" /></button>
                            </div>
                        </div> 
                    </div>
                    {assign var=customcount value=$customcount+1} 
                {/foreach}  
            </div>
        </div>  
    {/if}
{/if}
{if $otherdevicesconfig == "on"}
    <div class="device_option">
        <div class="panel-heading">
            <h3>{$lang.other_devices}</h3>
        </div>
        <div class="device_option_here">
            {$lang.stream_output}
            {foreach from=$accessoutput key=name item=output}
                <div class="radio">
                    <label><input type="radio" name="stream_output" {if $outputfirst eq {$output}} checked="checked"{/if} value="{$output}">{$name}</label>
                </div> 
            {/foreach} 
        </div>
        <div class="mydropdown new_dropdown">
            {$lang.dropdown_name}
            <button class="btn btn-primary dropdown-toggle btn_new" type="button" data-toggle="dropdown">{$lang.dropdown_action}
                <span class="caret"></span></button>
            <ul class="dropdown-menu mydropdown" style="left: 175px;top: 88.5%;">
                <li>
                    <a target="_blank"
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=enigma16&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=enigma16&output=">Enigma2 OE 1.6
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=dreambox&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=dreambox&output=">Enigma2 OE 2.0
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=gigablue&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=gigablue&output=">Gigablue
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=simple&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=simple&output=">Simple List
                    </a>
                </li>
                <li>
                    <a target="_blank"
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=octagon&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=octagon&output=">Octagon
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=starlivev3&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=starlivev3&output=">Starlive/Starsat
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=mediastart&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=mediastart&output=">Mediastart/Geant/Tiger
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=starlivev5&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=starlivev5&output=">Starlive v5
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=webtvlist&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=webtvlist&output=">WebTV List
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=ariva&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=ariva&output=">Ariva
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=fps&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=fps&output=">Fortec999/Prifix9400/Starport
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=spark&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=spark&output=">Spark
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=revosun&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=revosun&output=">Revolution6060/Sunplus
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=starsat7000&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=starsat7000&output=">Starsat7000
                    </a>
                </li>
                <li>
                    <a target="_blank" 
                       data-url="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=zorro&output="
                       href="{$ServerHostName}/get.php?username={$iptv_username}&password={$password}&type=zorro&output=">Zorro
                    </a>
                </li>
            </ul>
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
                            var clipboard = new ClipboardJS("#"+id);
                            clipboard.on('success', function (e) {
                                $('.btnclipboard').html('<img src="modules/servers/xtreamUIpanel/templates/image/copy-button.png" />');
                                $('#' + id).html('Copied!');
                            });
                            clipboard.on('error', function (e) {
                                console.log(e);
                            });
                        });

</script>
<br>


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

{literal}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script> 
    <!--script type="text/javascript" >
                        $(document).ready(function () {
                            $.validator.addMethod("newMAC", function (value, element) {
                                return this.optional(element) || /([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/.test(value);
                            }, "Please enter a valid MAC address.");
                            
                            $.validator.addMethod("newENG", function (value, element) {
                                return this.optional(element) || /([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/.test(value);
                            }, "Please enter a valid MAC address.");
                            // Validate signup form
                            $(".macaddress").validate({
                                rules: {
                                    newMAC: "required newMAC",
                                },
                            });
                        });
    </script-->
{/literal}
