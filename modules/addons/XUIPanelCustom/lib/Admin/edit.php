<?php

use WHMCS\Database\Capsule;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $count = Capsule::table('xui_paneldetails')->where('id', $_GET['id'])->count();
    if ($count > 0) {
        $xui_paneldetails = Capsule::table('xui_paneldetails')->where('id', $_GET['id'])->get();
    }
}
?>
<style type="text/css">
    .addborder {
        border: 1px solid red !important;
    }
</style>
<h2>Enter Your XUI Panel Details </h2>
<form method="post" id="saveserverdata">
    <table name="addserver" class="form" method="request" action="edit" id="" width="100%" border="0" cellspacing="2" cellpadding="3">
        <tbody>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Panel Name</td>
                <td class="fieldarea"><input class="form-control input-400 validateclass" style="float: left;" type="text" name="panel_name" id="panel_name" value="<?php echo $xui_paneldetails[0]->identifier; ?>">
                    <div style="font-size: 13px;  margin-top: 5px;"><i>(Anyname that you can give it for your own reference.)</i></div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Panel URL</td>
                <td class="fieldarea"><input class="form-control input-400 validateclass" style="float: left;" type="text" name="panel_url" id="panel_url" value="<?php echo $xui_paneldetails[0]->panel_link; ?>">
                    <div style="font-size: 13px;  margin-top: 5px;"><i>(Your Panel Url)</i></div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Username</td>
                <td class="fieldarea"><input class="form-control input-400 validateclass" style="float: left;" type="text" name="username" id="username" value="<?php echo $xui_paneldetails[0]->username; ?>">
                    <div style="font-size: 13px;  margin-top: 5px;"><i>(Username of your panel)</i></div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Password</td>
                <td class="fieldarea"><input class="form-control input-400 validateclass" style="float: left;" type="text" name="password" id="password" value="<?php echo $xui_paneldetails[0]->password; ?>">
                    <div style="font-size: 13px;  margin-top: 5px;"><i>(Password of your panel)</i></div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">MAG Portal URL</td>
                <td class="fieldarea">
                    <input class="form-control input-400 validateclass" style="float: left;" type="text" name="mag_portal" id="mag_portal" value="<?php echo $xui_paneldetails[0]->mag_portal; ?>">
                    <div style="font-size: 13px; margin-top: 5px;"><i>(MAG Portal Url of your panel)</i></div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">M3U URL</td>
                <td class="fieldarea">
                    <input class="form-control input-400 validateclass" style="float: left;" type="text" name="m3uurl" id="m3uurl" value="<?php echo $xui_paneldetails[0]->m3uurl; ?>">
                    <div style="font-size: 13px; margin-top: 5px;"><i>(M3U Url of your panel)</i></div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;" class="fieldlabel">Web Portal URL</td>
                <td class="fieldarea">
                    <input class="form-control input-400 validateclass" style="float: left;" type="text" name="watchstrmurl" id="watchstrmurl" value="<?php echo $xui_paneldetails[0]->watchstrmurl; ?>">
                    <div style="font-size: 13px; margin-top: 5px;"><i>(Web Portal of your panel)</i></div>
                </td>
            </tr>
            <input class="form-control" type="hidden" name="saveserversave">
        </tbody>
    </table>
    <div style="width:100%;">
        <div style=" margin-left: 570px; ">
            <p class="conRes" style="font-weight: 700;padding: 10px;width: 50%;margin: 0 auto;display: none;"></p>
            <input type="hidden" name="event" value="<?php echo $eventtoperform; ?>">
            <button type="button" name="btnsubmit" class="btn btn-success testconnection" id="savechangesbtn">Proceed <i style="display: none;" class="fas fa-spinner fa-spin custm_spin"></i></button>
            <button type="button" class="btn btn-danger" onclick="location.href = '<?php echo $modulelink ?>'">
                Cancel
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#savechangesbtn").click(function() {
            $(".custm_spin").show();
            validate = 'false';
            $(".validateclass").each(function() {
                if ($.trim($(this).val()) == "") {
                    validate = 'true';
                    $(this).css('border', '1px solid red');
                } else {
                    $(this).css('border', 'none');
                }
            });
            if (validate == 'false') {
                //request check panel details
                jQuery.ajax({
                    type: "POST",
                    url: "../modules/servers/XUIResellerPanel/Config.php",
                    dataType: "text",
                    data: {
                        action: 'testconnection',
                        task: <?php echo $_GET['id'] ?>,
                        panel_url: $("#panel_url").val(),
                        username: $("#username").val(),
                        password: $("#password").val(),
                        panel_name: $("#panel_name").val(),
                        mag_portal: $("#mag_portal").val(),
                        m3uurl: $("#m3uurl").val(),
                        watchstrmurl: $("#watchstrmurl").val(),
                    },
                    success: function(response2) {
                        $(".custm_spin").hide();
                        if (response2 == "success") {
                            window.location.href = 'addonmodules.php?module=XUIPanelCustom&action=addpanels';
                        } else {
                            alert('Invalid Details');
                        }
                    }
                });
            } else {
                $(".custm_spin").hide();
            }
        });
    });
</script>