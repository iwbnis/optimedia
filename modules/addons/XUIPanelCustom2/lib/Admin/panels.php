<?php

use WHMCS\Database\Capsule;
?>
<style type="text/css">
    .showdatapass {
        cursor: pointer;
    }
</style>
<div class="alert alert-success alert-dismissible" id="success_alert" style="display:none;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> <span id="messagetxt"> Details successfully added. </span>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            On this page, you can add your Reseller Panel and connect it for automation.
        </div>
        <div class="col-sm-6">
            <button type="submit" onclick="location.href = '<?php echo $modulelink ?>&action=addserver';" style="
                        float: right;
                        margin-bottom: 10px;
                        " class="btn btn-primary">
                <i class="fas fa-plus fa-fw"></i>
                <span class="hidden-md">
                    Add New Panel
                </span>
            </button>
        </div>
    </div>
</div>

<table name="serversetupdetails" id="sortabletbl1" class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tbody>
        <tr>
            <th>Panel Name</th>
            <th>Panel URL</th>
            <th>Username</th>
            <th>Password</th>
            <th>Panel URLs</th>
            <th colspan="3">Action</th>
        </tr>
        <?php
        $count = Capsule::table('xui_paneldetails')->count();
        if ($count > 0) {
            $allserverdata = Capsule::table('xui_paneldetails')->get();
            foreach ($allserverdata as $serverdata) {
                $id = $serverdata->id;
                $Servername = $serverdata->identifier;
                $panel_link = $serverdata->panel_link;
                $username = $serverdata->username;
                $password = $serverdata->password;
                $m3uurl = $serverdata->m3uurl;
                $mag_portal = $serverdata->mag_portal;
                $watchstrmurl = $serverdata->watchstrmurl;
        ?>
                <tr>
                    <td align="center">
                        <a href="<?php echo $modulelink ?>&action=edit&id=<?php echo $id; ?>">
                            <?php echo $Servername; ?>
                        </a>
                    </td>
                    <td align="center">
                        <?php echo $panel_link; ?>
                    </td>
                    <td align="center" style="max-width: 200px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">
                        <?php echo $username; ?>
                    </td>
                    <td align="center" style=" text-align: center;">
                        <?php echo '*********'; ?>
                    </td>
                    <td align="center">
                        <strong>M3U Url: </strong><?php echo $m3uurl; ?><br><strong>MAG Portal Url: </strong><?php echo $mag_portal; ?><br><strong>Web TV Url: </strong><?php echo $watchstrmurl; ?><br>
                    </td>
                    <td align="center">
                        <a title="Enabled">
                            <img src="images/icons/tick.png" width="16" height="16" border="0" alt="Enabled">
                        </a>
                        <a href="<?php echo $modulelink ?>&action=edit&id=<?php echo $id; ?>" title="Edit">
                            <img src="images/edit.gif" width="16" height="16" border="0" alt="Edit">
                        </a>
                        <a href="#" class="deleteserverbtn" data-serverid="<?php echo $id; ?>">
                            <img src="images/delete.gif" width="16" height="16" border="0" alt="Delete">
                        </a>
                    </td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td align="center" colspan="6">
                    <b>
                        No Server Found!!!
                    </b>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $(".deleteserverbtn").click(function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this server?")) {
                idtodelete = $(this).data('serverid');
                jQuery.ajax({
                    type: "POST",
                    url: "../modules/servers/XUIResellerPanel/Config.php",
                    dataType: "text",
                    data: {
                        action: 'delete',
                        panelid: idtodelete,
                    },
                    success: function(response2) {
                        if (response2 == "success") {
                            window.location.href = 'addonmodules.php?module=XUIPanelCustom&action=addpanels';
                        }
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>