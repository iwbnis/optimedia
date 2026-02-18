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

include_once '../../../init.php';
include_once 'xtreamUIpanel.php';
include_once 'hooks.php';

if ($_POST['stormajax'] == 'create-config') {
	ob_clean();
	$config = Illuminate\Database\Capsule\Manager::table('mod_xtreamUIdashboardconfig')->get();

	foreach ($config as $value) {
		$row[$value->setting] = $value->value;
	}

	$product_id = $_POST['id'];
	$mac_address_array = ['fieldname' => $row['custom_field_mag'], 'fieldtype' => 'text', 'description' => 'Format 00:1A:79:12:34:5A', 'regexpr' => '/([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/', 'required' => '', 'showorder' => 'on', 'showinvoice' => 'on'];
	$eng_address_array = ['fieldname' => $row['custom_field_eng'], 'fieldtype' => 'text', 'description' => 'Format 00:1A:79:12:34:5A', 'regexpr' => '/([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/', 'required' => '', 'showorder' => 'on', 'showinvoice' => 'on'];
	$username = ['fieldname' => 'Username', 'fieldtype' => 'text', 'description' => 'Leave it empty for auto generated', 'regexpr' => '', 'required' => '', 'showorder' => 'on', 'showinvoice' => 'on'];
	$passwordfield = ['fieldname' => 'Password', 'fieldtype' => 'password', 'description' => 'Leave it blank to Auto Generate Random Chars', 'regexpr' => '', 'required' => '', 'showorder' => 'on', 'showinvoice' => 'on'];
	if (isset($_POST['selected_conf_id']) && !empty($_POST['selected_conf_id'])) {
		if ($_POST['selected_conf_id'] == 'magdevice') {
			$custom_fields = [$row['custom_field_mag'] => $mac_address_array];
		}
		else if ($_POST['selected_conf_id'] == 'streamlineonly') {
			$custom_fields = ['Username' => $username, 'Password' => $passwordfield];

			if ($_POST['ispasswordeditable'] == '') {
				unset($custom_fields['Password']);
			}
		}
		else if ($_POST['selected_conf_id'] == 'engdevice') {
			$custom_fields = [$row['custom_field_eng'] => $eng_address_array];
		}
	}
	if (isset($custom_fields) && !empty($custom_fields)) {
		foreach ($custom_fields as $field_name => $field_value) {
			if (0 == mysql_num_rows(mysql_query('SELECT * FROM `tblcustomfields` WHERE relid=\'' . $product_id . '\' AND fieldname=\'' . $field_name . '\''))) {
				if (mysql_query('INSERT INTO  `tblcustomfields` (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`) VALUES (\'product\', \'' . $product_id . '\', \'' . $field_name . '\',\'' . $field_value['fieldtype'] . '\',\'' . $field_value['description'] . '\', \'\', \'' . $field_value['regexpr'] . '\', \'\', \'' . $field_value['required'] . '\', \'' . $field_value['showorder'] . '\',\'' . $field_value['showinvoice'] . '\', \'0\')')) {
					$result[] = 'success';
				}
				else {
					$result[] = 'error';
				}
			}
		}

		if (!in_array('error', $result)) {
			echo '<div class="successbox"><strong><span class="title">Changes Saved Successfully!</span></strong><br>Your changes have been saved.</div> ';
		}
		else {
			echo '<div class="errorbox"><strong><span class="title">Error in Creating Custom Field(s)!</span></strong></div> ';
		}

		echo ' <script type="text/javascript">' . "\r\n" . '                $(function(){' . "\r\n" . '                    $(".ui-icon-closethick").click(function(event){ ' . "\r\n" . '                        event.preventDefault(); ' . "\r\n" . '                        $("#conf-dialog-custom-field").dialog("destroy");' . "\r\n" . '                        $("#conf-dialog-custom-field").hide();' . "\r\n" . '                        window.location.reload(); ' . "\r\n" . '                    });' . "\r\n" . '                });' . "\r\n" . '              </script>';
		exit();
	}
	else {
		exit();
	}
}
else if ($_REQUEST['action'] == 'get-packages') {
	$detailsarray = ['username' => $_POST['username'], 'password' => $_POST['password']];
	$line_type_is = (isset($_POST['selectedliyetype']) && !empty($_POST['selectedliyetype']) ? $_POST['selectedliyetype'] : 'trial');
	$Filelinkcheck = ($line_type_is == 'trial' ? '?trial' : '');
	$filename = 'user_reseller.php' . $Filelinkcheck;
	if (isset($_POST['producttype']) && ($_POST['producttype'] == 'magdevice')) {
		$filename = 'user_reseller.php' . $Filelinkcheck;
	}

	$packages = xtreamUIpanelAPICall($filename, '', 'packages', $_POST['xc_url'], $detailsarray);

	if (!empty($packages)) {
		echo '        <style type="text/css">' . "\r\n" . '            .packagecontainssec {' . "\r\n" . '                height: 200px;' . "\r\n" . '                overflow-x: scroll;' . "\r\n" . '                background-color: #ccec91;' . "\r\n" . '                border: 1px solid #719e37;' . "\r\n" . '                padding: 10px;' . "\r\n" . '                width: 100%;' . "\r\n" . '                font-size: 12px;' . "\r\n" . '            }' . "\r\n" . '        </style>' . "\r\n" . '        <div class="row">       ' . "\r\n" . '        ';

		foreach ($packages as $key => $val) {
			echo '                <div class="col-md-12 col-sm-12">' . "\r\n" . '                    <div class="col-md-6 col-sm-6">' . "\r\n\r\n" . '                        <input type="radio" name="packid" value="';
			echo $key;
			echo '" id="rd-';
			echo $key;
			echo '" ';
			echo $_POST['currentval'] == $key ? 'checked="checked"' : '';
			echo ' data-valis="';
			echo $val;
			echo '" class="commanradioselector"> ' . "\r\n\r\n" . '                        <label for="rd-';
			echo $key;
			echo '">' . "\r\n\r\n" . '                        ';
			echo $val != '--' ? $key . '|' . $val : $val;
			echo ' ' . "\r\n\r\n" . '                        </label>' . "\r\n" . '                        <br>' . "\r\n" . '                    </div>' . "\r\n\r\n" . '                    <div class="col-md-6 col-sm-6 btnsectopn btnsecof-';
			echo $key;
			echo ' ';
			echo $_POST['currentval'] == $key ? 'showbtnclass' : 'hide';
			echo '"> ' . "\r\n" . '                    </div>' . "\r\n\r\n" . '                </div>' . "\r\n" . '            ';
		}

		echo '        </div>  ' . "\r\n" . '        <center> ' . "\r\n\r\n" . '            <input class="btn btn-success" type="button" data-sectionIs="';
		echo $_POST['sectionIs'];
		echo '" id="save" name="save" value="Save Changes" >' . "\r\n\r\n" . '        </center>' . "\r\n" . '                   ';
	}
	else {
		echo '        <center>' . "\r\n" . '            <h4>' . "\r\n" . '                No Package Found!!!' . "\r\n" . '                <br>' . "\r\n" . '            </h4>' . "\r\n" . '        </center> ' . "\r\n" . '        ';
	}

	exit();
}
else if ($_REQUEST['action'] == 'get-packages-reseller') {
	$detailsarray = ['login' => $_POST['username'], 'pass' => $_POST['password'], 'g-recaptcha-response' => $_REQUEST['recaptcha']];
	$filename = 'add_subreseller.php';
	$packages = xtreamUIpanelAPICall($filename, '', 'reseller-packages', $_POST['xc_url'], $detailsarray);

	if (c) {
		echo '        <style type="text/css">' . "\r\n" . '            .packagecontainssec {' . "\r\n" . '                height: 200px;' . "\r\n" . '                overflow-x: scroll;' . "\r\n" . '                background-color: #ccec91;' . "\r\n" . '                border: 1px solid #719e37;' . "\r\n" . '                padding: 10px;' . "\r\n" . '                width: 100%;' . "\r\n" . '                font-size: 12px;' . "\r\n" . '            }' . "\r\n" . '        </style>' . "\r\n" . '        <div class="row">       ' . "\r\n" . '        ';
		$i = 0;

		foreach ($packages['name'] as $package) {
			$name = str_replace('packages', '', $package);
			$name = str_replace('[assign]', '', $name);
			$name = str_replace('[', '', $name);
			$name = str_replace(']', '', $name);
			$packageName = $packages['packageName'][$i];
			echo '                <div class="input-group mb-3">' . "\r\n" . '                    <div class="input-group-prepend">' . "\r\n" . '                        <div class="input-group-text">' . "\r\n" . '                            <input type="checkbox" name="packagesreseller" value="';
			echo $name . '|' . $packageName;
			echo '"> <label for="rd-';
			echo $name;
			echo '"> ';
			echo $packageName;
			echo ' </label>' . "\r\n" . '                        </div> ' . "\r\n" . '                    </div>' . "\r\n\r\n" . '                </div>' . "\r\n" . '            ';
			$i++;
		}

		echo '        </div>  ' . "\r\n" . '        <center>  ' . "\r\n" . '            <input class="btn btn-success" id="savechanges" type="button" name="save" value="Save Changes" >' . "\r\n\r\n" . '        </center>' . "\r\n" . '        ';
	}
	else {
		echo '        <center>' . "\r\n" . '            <h4>' . "\r\n" . '                No Result Found!!!' . "\r\n" . '                <br>' . "\r\n" . '                <br>' . "\r\n" . '                Please check your test conncetion.' . "\r\n" . '            </h4>' . "\r\n" . '        </center> ' . "\r\n" . '        ';
	}

	exit();
}
else {
	if ($_REQUEST['action'] == 'getlinetype') {
		$returndata = [];
		$detailsarray = ['username' => $_POST['username'], 'password' => $_POST['password']];
		$explodePackageID = explode('|', $_POST['packageid']);
		$post_data = ['packageid' => $explodePackageID[0], 'savedlineis' => $_POST['savedlineis']];
		$data = xtreamUIpanelAPICall('user_reseller.php', $post_data, 'GetLineType', $_POST['xc_url'], $detailsarray);

		if ($data['credits'] != '') {
			$returndata['creditsare'] = $_POST['username'] . ' (<font color=\'orange\'><u>' . $data['credits'] . '</u></font>)';
		}
		else {
			$returndata['creditsare'] = 'No Credits Found!! Check the Test connection';
		}

		if ($data['linetype'] != '') {
			$returndata['linetype'] = $data['linetype'];
		}
		else {
			$returndata['linetype'] = '';
		}

		if ($data['reseller_id'] != '') {
			$returndata['reseller_id'] = $data['reseller_id'];
		}
		else {
			$returndata['reseller_id'] = '';
		}

		echo json_encode($returndata);
		exit();
	}

	if ($_REQUEST['action'] == 'getPackagecontains') {
		$returndata = '';
		$detailsarray = ['login' => $_POST['username'], 'pass' => $_POST['password']];
		$post_data = ['packageid' => $_POST['packgetid']];
		$getPackagecontains = xtreamUIpanelAPICall('add_user.php', $post_data, 'getPackagecontains', $_POST['xc_url'], $detailsarray);

		if ($getPackagecontains != '') {
			$returndata = $getPackagecontains;
		}
		else {
			$returndata = '<p>No Contains Package Found</p>';
		}

		echo $returndata;
		exit();
	}

	if ($_REQUEST['action'] == 'test_connection') {
		$URL = $_REQUEST['xc_url'];
		$postdata = ['username' => $_REQUEST['username'], 'password' => $_REQUEST['password']];
		$cookie_path = dirname(__FILE__) . '/cookie.txt';
		$ch = curl_init($URL);
		curl_setopt($ch, CURLOPT_URL, $URL . 'login.php');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$login_html = curl_exec($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($login_html);
		$tags = $dom->getElementsByTagName('a');
		$loggedin = 0;

		for ($i = 0; $i < $tags->length; $i++) {
			$grab = $tags->item($i);

			foreach ($grab->attributes as $attr) {
				if ($attr->value == './logout.php') {
					$loggedin = 1;
				}
			}
		}

		if ($loggedin) {
			echo '        <span style="padding:2px 10px;background-color:#5bb75b;color:#fff;font-weight:bold;">SUCCESSFUL!</span>' . "\r\n\r\n" . '        ';
		}
		else {
			echo ' ' . "\r\n" . '        <span style="padding:2px 10px;background-color:#cc0000;color:#fff;"><strong>FAILED :</strong> Failed to connect to Reseller Panel: Connection Failed, Please check the details and try again</span>' . "\r\n" . '        ';
		}
	}

	if ($_REQUEST['action'] == 'get-recaptcha') {
		if (!Illuminate\Database\Capsule\Manager::schema()->hasTable('mod_wsreseller_recaptchadata')) {
			Illuminate\Database\Capsule\Manager::schema()->create('mod_wsreseller_recaptchadata', function($table) {
				$table->increments('id');
				$table->text('orderid');
				$table->longText('recaptcha');
			});
		}
		if (isset($_REQUEST['orderid']) && ($_REQUEST['orderid'] != '')) {
			$orderiduse = $_REQUEST['orderid'];

			if (Illuminate\Database\Capsule\Manager::schema()->hasTable('mod_wsreseller_recaptchadata')) {
				$checkrecaptchaexists = Illuminate\Database\Capsule\Manager::table('mod_wsreseller_recaptchadata')->where('orderid', $orderiduse)->get();

				if (!empty($checkrecaptchaexists)) {
					Illuminate\Database\Capsule\Manager::table('mod_wsreseller_recaptchadata')->where('orderid', $orderiduse)->delete();
				}

				$data = ['orderid' => $orderiduse, 'recaptcha' => $_REQUEST['recaptcha']];
				Illuminate\Database\Capsule\Manager::table('mod_wsreseller_recaptchadata')->insert($data);
			}
		}

		$_SESSION['recaptcha'] = $_REQUEST['recaptcha'];
	}
}

?>