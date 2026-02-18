<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.0.10.0
* @ Author			:	DeZender
* @ Release on		:	09.04.2020
* @ Official site	:	http://DeZender.Net
*
*/

class Controller2
{
	public function index($vars)
	{
		if (isset($_POST['save_changes'])) {
			unset($_POST['token']);
			unset($_POST['save_changes']);

			foreach ($_POST as $name => $value) {
				$data[] = ['setting' => $name, 'value' => trim($value)];
			}

			WHMCS\Database\Capsule::table('mod_xtreamUIdashboardconfig')->delete();

			try {
				WHMCS\Database\Capsule::table('mod_xtreamUIdashboardconfig')->insert($data);
				$response['status'] = 'success';
				$response['msg'] = 'Saved Successfully!';
			}
			catch (Exception $e) {
				$response['status'] = 'error';
				$response['msg'] = 'A problem has been occurred while submitting your data.';
				$response['sql_err'] = mysql_error();
			}
		}

		$config = WHMCS\Database\Capsule::table('mod_xtreamUIdashboardconfig')->get();

		foreach ($config as $value) {
			$row[$value->setting] = $value->value;
		}
		if (isset($response) && !empty($response)) {
			if ($response['status'] == 'success') {
				echo '<div class="alert alert-success fade in">' . "\n" . '                    <a href="#" class="close" data-dismiss="alert">&times;</a>' . "\n" . '                    <strong>Success!</strong> ';
				echo $response['msg'];
				echo '                </div>' . "\n" . '            ';
			}
			else if ($response['status'] == 'error') {
				echo ' ' . "\n" . '                <div class="alert alert-danger fade in">' . "\n" . '                    <a href="#" class="close" data-dismiss="alert">&times;</a>' . "\n" . '                    <strong>Error!</strong> ';
				echo $response['msg'];
				echo '                </div>' . "\n" . '                ';
			}
		}

		return ' ' . "\n" . '  <script>' . "\n" . '            $(document).ready(function () {' . "\n" . '                $("#eventcommonidentifier").click(function (e) {' . "\n" . '                    e.preventDefault();' . "\n" . '                    if ($(this).data("currentstatus") == 1)' . "\n" . '                    {' . "\n" . '                        $(this).data("currentstatus", 2);' . "\n" . '                        $("#input_common_identifier").attr("readonly", false);' . "\n" . '                        $("#faiconlock").removeClass("fa-lock");' . "\n" . '                        $("#faiconlock").addClass("fa-unlock");' . "\n" . '                    } else' . "\n" . '                    {' . "\n" . '                        $(this).data("currentstatus", 1);' . "\n" . '                        $("#input_common_identifier").attr("readonly", true);' . "\n" . '                        $("#faiconlock").removeClass("fa-unlock");' . "\n" . '                        $("#faiconlock").addClass("fa-lock");' . "\n" . '                    }' . "\n" . '                });' . "\n" . '                var activation_code=jQuery("input[name=activationcode]:checked").val();' . "\n" . '                if(activation_code=="off"){' . "\n" . '                jQuery(\'.activationcode\').show(); ' . "\n" . '                jQuery(\'.activationcodedigits\').hide();' . "\n" . '                }else{' . "\n" . '                jQuery(\'.activationcodedigits\').show();' . "\n" . '                jQuery(\'.activationcode\').hide();' . "\n" . '                }' . "\n" . '                 var passwordformat=jQuery("input[name=passwordformat]:checked").val();' . "\n" . '                 if(passwordformat=="static"){' . "\n" . '                jQuery(\'#showstaticfield\').show();}' . "\n" . '            });' . "\n" . '        </script>' . "\n" . '        <style>' . "\n" . '        .psw_custom {' . "\n" . ' margin-top: -10px;' . "\n" . '}' . "\n" . '        .format_custom {' . "\n" . ' position: relative;' . "\n" . ' left: 150px;' . "\n" . ' top: 4px;' . "\n" . ' display: flex;' . "\n" . '}' . "\n" . '.sub_formta_custom {' . "\n" . ' position: relative;' . "\n" . ' top: 5px;' . "\n" . ' left: 10px;' . "\n" . '}' . "\n" . '.radio_custom {' . "\n" . ' float: left;' . "\n" . '} ' . "\n" . '        </style>' . "\n" . '<div class="tab-content admin-tabs">' . "\n" . '    <div class="tab-pane active"> ' . "\n" . '<i><h3 style="color: #2439ca;"><b> Here we can change the text / content according to our needs that would be changed in the client area. <b></h3></i>    ' . "\n" . '<form method="POST"> ' . "\n" . '    ' . "\n" . '<h2 style="display:none">Common Identifier</h2>' . "\n" . '<div style="width:100%;display:none">  ' . "\n" . '            <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">  ' . "\n" . '                <tbody> ' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Common Identifier</td><td class="fieldarea"><input id="input_common_identifier" class="form-control input-200"  type="text" name="common_identifier" value="' . (isset($row['common_identifier']) ? $row['common_identifier'] : '') . '" readonly style="float: left; margin-right: 10px;"><a style="float: left;" id="eventcommonidentifier" data-currentstatus="1" href=""><i id="faiconlock" class="fa fa-lock" aria-hidden="true" style="display: block;padding-bottom: 10px;position: relative;font-size: 26px;top: 4px;"></i></a><br><i style="padding-top: 18px;display: block;">it\'s linking variable between billng panel and xtream codes. It needs to change only if you are using our more than one billing panel with the single xtream codes</i></td></tr>' . "\n" . '                </tbody>' . "\n" . '            </table> ' . "\n" . '        </div>' . "\n" . '<h2>Custom Fields</h2>' . "\n" . '<h3>- Our system has setup with the default values you might need to change only if you make changes in our default system otherwise it don\'t need to change settings anymore  </h3>' . "\n" . '    <div style="width:100%; display: none;">  ' . "\n" . '            <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">  ' . "\n" . '                <tbody> ' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Custom Field MAG Device' . "\n" . '                    </td><td class="fieldarea"><input class="form-control input-200"  type="text" name="custom_field_mag" value="' . (isset($row['custom_field_mag']) ? $row['custom_field_mag'] : '') . '"> <i>Enter the same name of customer field that created for product for inputting MAC Address from end-users while ordering</i></td></tr> ' . "\n" . '                     </tbody>' . "\n" . '            </table> ' . "\n" . '        </div>  ' . "\n" . '   <h2 style="margin-top:15px;">Buttons & Links</h2>' . "\n" . '<div style="width:100%;">  ' . "\n" . '            <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">  ' . "\n" . '                <tbody>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Iptv Service Details</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="iptv_service_details" value="' . (isset($row['iptv_service_details']) ? $row['iptv_service_details'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Devices</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="devices" value="' . (isset($row['devices']) ? $row['devices'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Back to overview</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="back_to_overview" value="' . (isset($row['back_to_overview']) ? $row['back_to_overview'] : '') . '"></label>  </td></tr>' . "\n" . '                </tbody>' . "\n" . '             </table> ' . "\n" . '        </div>' . "\n" . '        <h2 style="margin-top:15px;">Service Details Page</h2>' . "\n" . '<div style="width:100%;">  ' . "\n" . '            <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">  ' . "\n" . '                <tbody>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Product/Service</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="product_service" value="' . (isset($row['product_service']) ? $row['product_service'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Username</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="username" value="' . (isset($row['username']) ? $row['username'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Password</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="password" value="' . (isset($row['password']) ? $row['password'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">M3U Playlist</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="playlist" value="' . (isset($row['playlist']) ? $row['playlist'] : '') . '"></label>  </td></tr>' . "\n" . ' <tr><td style="width: 25%;" class="fieldlabel">MAG Portal</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="mag_portal" value="' . (isset($row['mag_portal']) ? $row['mag_portal'] : '') . '"></label>  </td></tr>' . "\n" . '             </tbody></table> ' . "\n" . '        </div> ' . "\n" . '         ' . "\n" . '         <h2 style="margin-top:15px;">Devices Page</h2>' . "\n" . '<div style="width:100%;">  ' . "\n" . '            <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">  ' . "\n" . '                <tbody>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Devices Desc</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="devices_desc" value="' . (isset($row['devices_desc']) ? $row['devices_desc'] : '') . '"></label>  </td></tr>' . "\n" . '                     <tr><td style="width: 25%;" class="fieldlabel">Mag Desc</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="mag_desc" value="' . (isset($row['mag_desc']) ? $row['mag_desc'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Current Device</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="current_mag" value="' . (isset($row['current_mag']) ? $row['current_mag'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">New Device</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="new_mag" value="' . (isset($row['new_mag']) ? $row['new_mag'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Change Mag Button</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="change_mag_button" value="' . (isset($row['change_mag_button']) ? $row['change_mag_button'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Add Mag Button</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="add_mag_button" value="' . (isset($row['add_mag_button']) ? $row['add_mag_button'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Other Devices Desc</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="other_devices" value="' . (isset($row['other_devices']) ? $row['other_devices'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Autoscripts</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="autoscripts" value="' . (isset($row['autoscripts']) ? $row['autoscripts'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Stream Output</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="stream_output" value="' . (isset($row['stream_output']) ? $row['stream_output'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Dropdown Name</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="dropdown_name" value="' . (isset($row['dropdown_name']) ? $row['dropdown_name'] : '') . '"></label>  </td></tr>' . "\n" . '                    <tr><td style="width: 25%;" class="fieldlabel">Choose Device</td><td class="fieldarea"><input class="form-control input-200"  type="text" name="dropdown_action" value="' . (isset($row['dropdown_action']) ? $row['dropdown_action'] : '') . '"></label>  </td></tr>' . "\n\n" . '             </tbody></table> ' . "\n" . '        </div>' . "\n" . '          ' . "\n" . '     <div style="width:100%;">  <tr><td colspan="4"><center><input type="submit" name="save_changes" class="btn btn-primary" value="Save Changes"></center></td></tr>' . "\n" . '        </tbody>' . "\n" . '    </table>  </div>' . "\n" . '</form></div></div>';
	}

	public function logs()
	{
		include_once 'logs.php';
	}

	public function manualaction($vars)
	{
		global $CONFIG;
		$modulelink = (isset($vars['modulelink']) ? $vars['modulelink'] : 'addonmodules.php?module=SuperResellerPanelDashboard');
		include_once 'manualaction.php';
	}
}

?>