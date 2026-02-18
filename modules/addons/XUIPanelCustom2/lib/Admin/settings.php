<?php

use WHMCS\Database\Capsule;

if (isset($_POST['save_changes'])) {
    unset($_POST['token']);
    unset($_POST['save_changes']);
    foreach ($_POST as $name => $value) {
        $configurationdata[] = array(
            'setting' => $name,
            'value' => $value
        );
    }
    Capsule::table('xui_settings')->delete();
    Capsule::table('xui_settings')->insert($configurationdata);
}

$getSettings = Capsule::table('xui_settings')->get();
$row = array();
foreach ($getSettings as $setting => $val) {
    $row[$val->setting] = $val->value;
}
// echo "<pre>";
// print_r($row);
// exit;
?>

Here you can change the text of displaying messages or field text here

<form method="POST">
    <h2>Common Identifier</h2>
    <div style="width:100%;">
        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tbody>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Common Identifier</td>
                    <td class="fieldarea"><input id="input_common_identifier" class="form-control input-200" type="text" name="common_identifier" value="<?php echo isset($row['common_identifier']) && !empty($row['common_identifier']) ? $row['common_identifier'] : '' ?>" readonly style="float: left; margin-right: 10px;"><a style="float: left;" id="eventcommonidentifier" data-currentstatus="1" href=""><i id="faiconlock" class="fa fa-lock" aria-hidden="true" style="display: block;padding-bottom: 10px;position: relative;font-size: 26px;top: 4px;"></i></a><br><i style="padding-top: 18px;display: block;">You can we any variable from list {$service_id},{$client_id},{$client_name},{$client_email},{$client_phonenumber}</i></td>
                </tr>
            </tbody>
        </table>
    </div>
    <h2>Custom Fields</h2>
    <div style="width:100%;">
        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tbody>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Custom Field Username</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="custom_field_username" value="<?php echo isset($row['custom_field_username']) && !empty($row['custom_field_username']) ? $row['custom_field_username'] : '' ?>"> </td>
                </tr>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Custom Field Password</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="custom_field_password" value="<?php echo isset($row['custom_field_password']) && !empty($row['custom_field_password']) ? $row['custom_field_password'] : '' ?>"> <span></span></td>
                </tr>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Custom Field MAG Device</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="custom_field_mag" value="<?php echo isset($row['custom_field_mag']) && !empty($row['custom_field_mag']) ? $row['custom_field_mag'] : '' ?>"> </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 style="margin-top:15px;">Success & Error Messages</h2>
    <div style="width:100%;">
        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tbody>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Mac Not Valid</td>
                    <td class="fieldarea"><input class="form-control input-400" type="text" name="mac_not_valid" value="<?php echo isset($row['mac_not_valid']) && !empty($row['mac_not_valid']) ? $row['mac_not_valid'] : '' ?>"></label></td>
                </tr>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Mac Change Success</td>
                    <td class="fieldarea"><input class="form-control input-400" type="text" name="mac_change_success" value="<?php echo isset($row['mac_change_success']) && !empty($row['mac_change_success']) ? $row['mac_change_success'] : '' ?>"></label></td>
                </tr>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Mac Add Success</td>
                    <td class="fieldarea"><input class="form-control input-400" type="text" name="mac_add_success" value="<?php echo isset($row['mac_add_success']) && !empty($row['mac_add_success']) ? $row['mac_add_success'] : '' ?>"></label></td>
                </tr>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Mac Error</td>
                    <td class="fieldarea"><input class="form-control input-400" type="text" name="mac_error" value="<?php echo isset($row['mac_error']) && !empty($row['mac_error']) ? $row['mac_error'] : '' ?>"></label></td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 style="margin-top:15px;">Auto-Generation Settings</h2>
    <div style="width:100%;">
        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tbody>
                <tr>
                    <td style="width: 5%;" class="fieldlabel"></td>
                    <td colspan="2" class="fieldarea"><b>Random Username/ Password Format</b> - While creating streamline, our system generates random username and password if customer leaves it blank. So, generated format should be as below type </td>
                </tr>
                <tr class="activationcode">
                    <td style="width: 5%;"></td>
                    <td style="width: 25%;" class="fieldlabel">Username Format </td>
                    <td class="fieldarea">
                        <div class="radio_custom"> 
                            <input type="radio" name="usernameformat" <?php echo (isset($row['usernameformat']) && ($row['usernameformat'] == 'onlydigits') ? 'checked="checked"' : '') ?> value="onlydigits"> Only Digits<br>
                            <input type="radio" name="usernameformat"  <?php echo (isset($row['usernameformat']) && ($row['usernameformat'] == 'digits_alphabet') ? 'checked="checked"' : '') ?> value="digits_alphabet"> Digit + Alphabet
                        </div>
                        <span class="format_custom"><input name="usernamedigits" class="form-control input-100" value="<?php echo (isset($row['usernamedigits']) ? $row['usernamedigits'] : '') ?>" type="text"><span class="sub_formta_custom">(Number of Only Digits Default 10 )</span> </span>
                    </td>
                </tr>
                <tr class="activationcode">
                    <td style="width: 5%;"></td>
                    <td style="width: 25%;" class="fieldlabel">Password Format </td>
                    <td class="fieldarea">
                        <input type="radio" onclick="jQuery(' #showstaticfield').hide(500);" name="passwordformat" <?php echo (isset($row['passwordformat']) && ($row['passwordformat'] == 'onlydigits') ? 'checked="checked"' : '') ?> value="onlydigits"> Only Digits <br>
                        <div class="radio_custom"> <input type="radio" name="passwordformat" onclick="jQuery(' #showstaticfield').hide(500);" value="digits_alphabet" <?php echo (isset($row['passwordformat']) && ($row['passwordformat'] == 'digits_alphabet') ? 'checked="checked"' : '') ?>> Digit + Alphabet </div>
                        <div class="format_custom" style="top: -15px;"><input type="text" name="passworddigits" class="form-control input-100" value="<?php echo (isset($row['passworddigits']) ? $row['passworddigits'] : '') ?>"><span class="sub_formta_custom">(Number of Only Digits Default 10 )</span> </div>
                        <div class="psw_custom"> <input type="radio" name="passwordformat" onclick="jQuery(' #showstaticfield').show(1000);" value="static" <?php echo (isset($row[' passwordformat']) && ($row['passwordformat'] == 'static') ? 'checked="checked"' : '') ?>> Static/Same Password for every streaming line created<br>
                            <div id="showstaticfield" style="display:none;"><input type="text" name="staticPassword" class="form-control input-200" value="<?php echo (isset($row['staticPassword']) ? $row['staticPassword'] : '') ?>"> <b>Enter Password here</b> </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 style="margin-top:15px;">Buttons & Links</h2>

    <div style="width:100%;">

        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
                <td style="width: 25%;" class="fieldlabel">Iptv Service Details</td>
                <td class="fieldarea"><input class="form-control input-200" type="text" name="iptv_service_details" value="<?php echo isset($row['iptv_service_details']) && !empty($row['iptv_service_details']) ? $row['iptv_service_details'] : '' ?>"></label> </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Devices</td>
                <td class="fieldarea"><input class="form-control input-200" type="text" name="devices" value="<?php echo isset($row['devices']) && !empty($row['devices']) ? $row['devices'] : '' ?>"></label> </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Back to overview</td>
                <td class="fieldarea"><input class="form-control input-200" type="text" name="back_to_overview" value="<?php echo isset($row['back_to_overview']) && !empty($row['back_to_overview']) ? $row['back_to_overview'] : '' ?>"></label> </td>
            </tr>
            </tbody>
        </table>

    </div>

    <h2 style="margin-top:15px;">Service Details Page</h2>

    <div style="width:100%;">

        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">

            <tbody>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Product/Service</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="product_service" value="<?php echo isset($row['product_service']) && !empty($row['product_service']) ? $row['product_service'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Username</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="username" value="<?php echo isset($row['username']) && !empty($row['username']) ? $row['username'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Password</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="password" value="<?php echo isset($row['password']) && !empty($row['password']) ? $row['password'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">M3U Playlist</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="playlist" value="<?php echo isset($row['playlist']) && !empty($row['playlist']) ? $row['playlist'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">MAG Portal</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="mag_portal" value="<?php echo isset($row['mag_portal']) && !empty($row['mag_portal']) ? $row['mag_portal'] : '' ?>"></label> </td>
                </tr>
            </tbody>
        </table>

    </div>



    <h2 style="margin-top:15px;">Devices Page</h2>

    <div style="width:100%;">

        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">

            <tbody>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Devices Desc</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="devices_desc" value="<?php echo isset($row['devices_desc']) && !empty($row['devices_desc']) ? $row['devices_desc'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Mag Desc</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="mag_desc" value="<?php echo isset($row['mag_desc']) && !empty($row['mag_desc']) ? $row['mag_desc'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Current Mag</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="current_mag" value="<?php echo isset($row['current_mag']) && !empty($row['current_mag']) ? $row['current_mag'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">New Mag</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="new_mag" value="<?php echo isset($row['new_mag']) && !empty($row['new_mag']) ? $row['new_mag'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Change Mag Button</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="change_mag_button" value="<?php echo isset($row['change_mag_button']) && !empty($row['change_mag_button']) ? $row['change_mag_button'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Add Mag Button</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="add_mag_button" value="<?php echo isset($row['add_mag_button']) && !empty($row['add_mag_button']) ? $row['add_mag_button'] : '' ?>"></label> </td>
                </tr>
                <tr>
                    <td style="width: 25%;" class="fieldlabel">Other Devices Desc</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="other_devices" value="<?php echo isset($row['other_devices']) && !empty($row['other_devices']) ? $row['other_devices'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Autoscripts</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="autoscripts" value="<?php echo isset($row['autoscripts']) && !empty($row['autoscripts']) ? $row['autoscripts'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Stream Output</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="stream_output" value="<?php echo isset($row['stream_output']) && !empty($row['stream_output']) ? $row['stream_output'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Dropdown Name</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="dropdown_name" value="<?php echo isset($row['dropdown_name']) && !empty($row['dropdown_name']) ? $row['dropdown_name'] : '' ?>"></label> </td>
                </tr>

                <tr>
                    <td style="width: 25%;" class="fieldlabel">Choose Device</td>
                    <td class="fieldarea"><input class="form-control input-200" type="text" name="dropdown_action" value="<?php echo isset($row['dropdown_action']) && !empty($row['dropdown_action']) ? $row['dropdown_action'] : '' ?>"></label> </td>
                </tr>

            </tbody>
        </table>

    </div>
    <div style="width:100%;">
        <tr>
            <td colspan="4">
                <center><input type="submit" name="save_changes" class="btn btn-primary" value="Save Changes"></center>
            </td>
        </tr>

        </tbody>

        </table>
    </div>

</form>

<script>
    $(document).ready(function() {
        $("#eventcommonidentifier").click(function(e) {
            e.preventDefault();
            if ($(this).data("currentstatus") == 1) {
                $(this).data("currentstatus", 2);
                $("#input_common_identifier").attr("readonly", false);
                $("#faiconlock").removeClass("fa-lock");
                $("#faiconlock").addClass("fa-unlock");
            } else {
                $(this).data("currentstatus", 1);
                $("#input_common_identifier").attr("readonly", true);
                $("#faiconlock").removeClass("fa-unlock");
                $("#faiconlock").addClass("fa-lock");
            }
        });
    });
</script>