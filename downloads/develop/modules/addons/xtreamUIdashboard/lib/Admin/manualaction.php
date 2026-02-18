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

function WSResellerPanelDashboard_AdminUsername()
{
	$result_admin = WHMCS\Database\Capsule::table('tbladmins')->where('roleid', '=', '1')->get();
	$adminUsername = $result_admin[0]->username;
	return $adminUsername;
}

function ResellerXCSuspendAccountAll($arraydata, $recaptcha)
{
	$product_id = (isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
	$result = WHMCS\Database\Capsule::table('tblproducts')->where('id', '=', $product_id)->get();
	$params = $result[0];
	$xc_url = $params->configoption9;
	$xc_username = $params->configoption10;
	$xc_password = $params->configoption11;
	$detailsarray = ['login' => $xc_username, 'pass' => $xc_password, 'g-recaptcha-response' => $recaptcha];

	foreach ($arraydata as $data) {
		$result = explode('|', $data);
		$command = 'DecryptPassword';
		$postData = ['password2' => $result[1]];
		$adminUsername = wsresellerpaneldashboard_adminusername();
		$APiresults = localAPI($command, $postData, $adminUsername);
		$realPassword = (isset($APiresults['password']) ? $APiresults['password'] : '');
		$username[] = $result[0];
		$password[] = $realPassword;
	}

	if ($params->configoption2 == 'streamlineonly') {
		$post_data = ['current' => '1', 'username' => $username, 'password' => $password];
		$api_result = DashboardXtreamResellerAPI('mnglines.php', $post_data, 'suspendall', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}
	else if ($params->configoption2 == 'magdevice') {
		$xtreamConfig = WHMCS\Database\Capsule::table('mod_wsresellerpanelconfig')->get();
		$returndata = [];
		if (isset($xtreamConfig) && !empty($xtreamConfig)) {
			foreach ($xtreamConfig as $config) {
				$returndata[$config->setting] = $config->value;
			}
		}

		if (!empty($params->customfields[$returndata['custom_field_mag']])) {
			$post_data = ['current' => '1', 'mac' => $params->customfields[$returndata['custom_field_mag']]];
		}

		$api_result = DashboardXtreamResellerAPI('manage_mag.php', $post_data, 'enabled', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}

	return 'success';
}

function ResellerXCSuspendAccount($username, $password, $product_id, $recaptcha)
{
	$result = WHMCS\Database\Capsule::table('tblproducts')->where('id', '=', $product_id)->get();
	$params = $result[0];
	$xc_url = $params->configoption9;
	$xc_username = $params->configoption10;
	$xc_password = $params->configoption11;
	$detailsarray = ['login' => $xc_username, 'pass' => $xc_password, 'g-recaptcha-response' => $recaptcha];

	if ($params->configoption2 == 'streamlineonly') {
		$post_data = ['current' => '1', 'username' => $username, 'password' => $password];
		$api_result = DashboardXtreamResellerAPI('mnglines.php', $post_data, 'enabled', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}
	else if ($params->configoption2 == 'magdevice') {
		$xtreamConfig = WHMCS\Database\Capsule::table('mod_wsresellerpanelconfig')->get();
		$returndata = [];
		if (isset($xtreamConfig) && !empty($xtreamConfig)) {
			foreach ($xtreamConfig as $config) {
				$returndata[$config->setting] = $config->value;
			}
		}

		if (!empty($params->customfields[$returndata['custom_field_mag']])) {
			$post_data = ['current' => '1', 'mac' => $params->customfields[$returndata['custom_field_mag']]];
		}

		$api_result = DashboardXtreamResellerAPI('manage_mag.php', $post_data, 'enabled', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}

	return 'success';
}

function WSResellerPanelTerminateAccount($username, $password, $product_id, $recaptcha)
{
	$result = WHMCS\Database\Capsule::table('tblproducts')->where('id', '=', $product_id)->get();
	$params = $result[0];
	$xc_url = $params->configoption9;
	$xc_username = $params->configoption10;
	$xc_password = $params->configoption11;
	$detailsarray = ['login' => $xc_username, 'pass' => $xc_password, 'g-recaptcha-response' => $recaptcha];

	if ($params->configoption2 == 'streamlineonly') {
		$post_data = ['username' => $username, 'password' => $password];
		$api_result = DashboardXtreamResellerAPI('mnglines.php', $post_data, 'user_delete', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}
	else if ($params->configoption2 == 'magdevice') {
		$xtreamConfig = WHMCS\Database\Capsule::table('mod_wsresellerpanelconfig')->get();
		$returndata = [];
		if (isset($xtreamConfig) && !empty($xtreamConfig)) {
			foreach ($xtreamConfig as $config) {
				$returndata[$config->setting] = $config->value;
			}
		}

		if (!empty($params['customfields'][$returndata['custom_field_mag']])) {
			$post_data = ['current' => '0', 'mac' => $params['customfields'][$returndata['custom_field_mag']]];
		}

		$api_result = XtreamPanelAPICall('manage_mag.php', $post_data, 'delete', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}
}

function WSResellerPanelTerminateAccountAll($arraydata, $recaptcha)
{
	$product_id = (isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
	$result = WHMCS\Database\Capsule::table('tblproducts')->where('id', '=', $product_id)->get();
	$params = $result[0];
	$xc_url = $params->configoption9;
	$xc_username = $params->configoption10;
	$xc_password = $params->configoption11;
	$detailsarray = ['login' => $xc_username, 'pass' => $xc_password, 'g-recaptcha-response' => $recaptcha];

	foreach ($arraydata as $data) {
		$result = explode('|', $data);
		$command = 'DecryptPassword';
		$postData = ['password2' => $result[1]];
		$adminUsername = wsresellerpaneldashboard_adminusername();
		$APiresults = localAPI($command, $postData, $adminUsername);
		$realPassword = (isset($APiresults['password']) ? $APiresults['password'] : '');
		$username[] = $result[0];
		$password[] = $realPassword;
	}

	if ($params->configoption2 == 'streamlineonly') {
		$post_data = ['username' => $username, 'password' => $password];
		$api_result = DashboardXtreamResellerAPI('mnglines.php', $post_data, 'user_delete_all', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}
	else if ($params->configoption2 == 'magdevice') {
		$xtreamConfig = WHMCS\Database\Capsule::table('mod_wsresellerpanelconfig')->get();
		$returndata = [];
		if (isset($xtreamConfig) && !empty($xtreamConfig)) {
			foreach ($xtreamConfig as $config) {
				$returndata[$config->setting] = $config->value;
			}
		}

		if (!empty($params['customfields'][$returndata['custom_field_mag']])) {
			$post_data = ['current' => '0', 'mac' => $params['customfields'][$returndata['custom_field_mag']]];
		}

		$api_result = XtreamPanelAPICall('manage_mag.php', $post_data, 'delete', $xc_url, $detailsarray);
		logModuleCall('XtreamCode', __FUNCTION__, $post_data, $api_result);
		return 'success';
	}
}

function DashboardXtreamResellerAPI($request_url, $post_data, $action, $adminurl = '', $admindetails = [])
{
	$row = [];
	$row['xc_cms_url'] = $adminurl;
	$bar = '/';

	if (substr($row['xc_cms_url'], -1) == '/') {
		$bar = '';
	}

	$URL = $row['xc_cms_url'] . 'index.php';
	$row['xc_cms_url'] = $row['xc_cms_url'] . $bar;
	$postdata = $admindetails;
	$orginalurl = $row['xc_cms_url'] . 'userpanel/';
	$cookie_path = dirname(__FILE__) . '/cookie.txt';
	$ch = curl_init($URL);
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$ret1 = curl_exec($ch);
	$orginalurl = $orginalurl . $request_url;
	curl_setopt($ch, CURLOPT_URL, $orginalurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
	$ret2 = curl_exec($ch);
	$dom = new DOMDocument();
	@$dom->loadHTML($ret2);
	if (($action == 'enabled') || ($action == 'user_delete') || ($action == 'suspendall') || ($action == 'user_delete_all')) {
		$div = $dom->getElementsByTagName('a');

		for ($i = 0; $i < $div->length; $i++) {
			$grab = $div->item($i);
			$parts = parse_url($grab->getAttribute('href'));
			parse_str($parts['query'], $query);
			if (isset($query['csrf_token']) && !empty($query['csrf_token'])) {
				$csrf_token = $query['csrf_token'];
			}
		}

		$postdata2 = ['csrf_token' => $csrf_token];
		$orginalaction = $orginalurl . '?action=load_users';
		curl_setopt($ch, CURLOPT_URL, $orginalaction);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata2);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret3 = curl_exec($ch);
		$ara = json_decode($ret3, true);

		if ($action == 'delete') {
			foreach ($ara['records'] as $record) {
				if (strip_tags($record['mac_address']) == $post_data['mac']) {
					$ExplodedAaarat = explode('</a>', $record['options']);

					foreach ($ExplodedAaarat as $val) {
						if (strpos($val, 'Delete User') !== false) {
							preg_match('/href=["\']?([^"\'>]+)["\']?/', $val, $match);
						}
					}

					$info = parse_url($match[1]);
					parse_str($info['query'], $values);
					$orginalurl = $orginalurl . '?action=' . $action;
					$postdatavalue = ['csrf_token' => $values['csrf_token'], 'mag_id' => $values['mag_id']];
					$post_data = array_merge($post_data, $postdatavalue);
					curl_setopt($ch, CURLOPT_URL, $orginalurl);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
					curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					$response = curl_exec($ch);
					$dom = new DOMDocument();
					@$dom->loadHTML($response);
					$xpath = new DOMXpath($dom);
					$result = $xpath->query('//h4[contains(@class, "alert_success")]');

					for ($i = 0; $i < $result->length; $i++) {
						$message['status'] = 'success';
						$message['response'] = $result->item($i)->nodeValue;
						return $message;
					}
				}
			}
		}
		else if (($action == 'suspendall') || ($action == 'user_delete_all')) {
			$actionhit = ($action == 'suspendall' ? 'enabled' : 'user_delete');

			foreach ($ara['records'] as $record) {
				foreach ($post_data['username'] as $username) {
					if (strip_tags($record['username']) == $username) {
						$url = preg_match('/href=["\']?([^"\'>]+)["\']?/', $record['statistics'], $match);
						$info = parse_url($match[1]);
						parse_str($info['query'], $values);
						echo $sendurl = $orginalurl . '?action=' . $action . '&csrf_token=' . $values['csrf_token'] . '&action=' . $actionhit . '&current=1&user_id=' . $values['user_id'];
						curl_setopt($ch, CURLOPT_URL, $sendurl);
						curl_setopt($ch, CURLOPT_POST, 0);
						curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
						$response = curl_exec($ch);
						$dom = new DOMDocument();
						@$dom->loadHTML($response);
						$xpath = new DOMXpath($dom);
						$result = $xpath->query('//h4[contains(@class, "alert_success")]');

						for ($i = 0; $i < $result->length; $i++) {
							$message['status'] = 'success';
							$message['response'] = $result->item($i)->nodeValue;
							$array[] = $message;
						}
					}
				}
			}

			return $array;
		}
		else if (($action == 'enabled') || ($action == 'user_delete')) {
			foreach ($ara['records'] as $record) {
				if (strip_tags($record['username']) == $post_data['username']) {
					$url = preg_match('/href=["\']?([^"\'>]+)["\']?/', $record['statistics'], $match);
					$info = parse_url($match[1]);
					parse_str($info['query'], $values);
					$orginalurl = $orginalurl . '?action=' . $action;
					$postdatavalue = ['csrf_token' => $values['csrf_token'], 'user_id' => $values['user_id']];
					$post_data = array_merge($post_data, $postdatavalue);
					curl_setopt($ch, CURLOPT_URL, $orginalurl);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
					curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					$response = curl_exec($ch);
					$dom = new DOMDocument();
					@$dom->loadHTML($response);
					$xpath = new DOMXpath($dom);
					$result = $xpath->query('//h4[contains(@class, "alert_success")]');

					for ($i = 0; $i < $result->length; $i++) {
						$message['status'] = 'success';
						$message['response'] = $result->item($i)->nodeValue;
						return $message;
					}
				}
			}
		}
	}
}

$CurrentAction = 'Suspended';
$btnName = 'Suspend';
$actualForlinks = $modulelink . '&action=manualaction';

if (isset($_REQUEST['section'])) {
	if ($_REQUEST['section'] == 'terminate') {
		$actualForlinks = $modulelink . '&action=manualaction&section=terminate';
		$xtab3 = 'active';
		$CurrentAction = 'Terminated';
		$btnName = 'Terminate';
	}
	else {
		$xtab1 = 'active';
	}
}
else {
	$xtab1 = 'active';
}

$actual_link = $modulelink . '&action=manualaction&section=terminate';
if (isset($_REQUEST['pageno']) && ($_REQUEST['pageno'] != '')) {
	$actual_link = $actual_link . '&pageno=' . $_REQUEST['pageno'];
}

echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\n" . '<style type="text/css">' . "\n" . '    a.customanchors {' . "\n" . '        color: #2f2f58 !important;' . "\n" . '        text-decoration: underline !important;' . "\n" . '    }' . "\n" . '    a.customanchors:hover {' . "\n" . '        color: #5f5f86 !important;' . "\n" . '        text-decoration: none !important;' . "\n" . '    }' . "\n" . '    .btnshowhide {' . "\n" . '        cursor: pointer;' . "\n" . '    }' . "\n" . '    .showhideall {' . "\n" . '        cursor: pointer;' . "\n" . '    }' . "\n\n" . '    .filtersection {' . "\n" . '        text-align: center;' . "\n" . '    }' . "\n" . '    .addborder' . "\n" . '    {' . "\n" . '        border: 1px solid red !important;' . "\n" . '    }' . "\n" . '</style>' . "\n\n" . '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">' . "\n" . '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>' . "\n\n\n" . '<div class="row">' . "\n" . '    <div class="col-md-12" style="margin-top: 20px;">' . "\n" . '        <ul class="nav nav-tabs admin-tabs" role="tablist">  ' . "\n" . '            <li class="';

if (isset($xtab1)) {
	echo $xtab1;
}

echo '">' . "\n" . '                <a style="font-size: 15px;"class="tab-top" href="';
echo $modulelink;
echo '&action=manualaction" >' . "\n" . '                    Suspend' . "\n" . '                </a>' . "\n" . '            </li>' . "\n" . '            <li class="';

if (isset($xtab3)) {
	echo $xtab3;
}

echo '">' . "\n" . '                <a style="font-size: 15px;"class="tab-top" href="';
echo $modulelink;
echo '&action=manualaction&section=terminate" >' . "\n" . '                    Terminate' . "\n" . '                </a>' . "\n" . '            </li>' . "\n" . '        </ul> ' . "\n" . '        <div class="col-md-12" style="margin-top: 10px;">' . "\n" . '            ';
$showmaessahe = [];

if (isset($_POST['Terminateall'])) {
	if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
		$response[] = WSResellerPanelTerminateAccountAll($_POST['data'], $_POST['g-recaptcha-response']);
		$showmaessahe['result'] = 'success';
		$showmaessahe['messae'] = 'Server ' . $CurrentAction . ' Successfully! You can check logs for more details!';
		$showmaessahe['alertclass'] = 'success';
	}
	else {
		$showmaessahe['result'] = 'error';
		$showmaessahe['messae'] = 'recaptcha is required!';
		$showmaessahe['alertclass'] = 'danger';
	}
}

if (isset($_POST['Suspendall'])) {
	if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
		$response[] = ResellerXCSuspendAccountAll($_POST['data'], $_POST['g-recaptcha-response']);
		$showmaessahe['result'] = 'success';
		$showmaessahe['messae'] = 'Server ' . $CurrentAction . ' Successfully! You can check logs for more details!';
		$showmaessahe['alertclass'] = 'success';
	}
	else {
		$showmaessahe['result'] = 'error';
		$showmaessahe['messae'] = 'recaptcha is required!';
		$showmaessahe['alertclass'] = 'danger';
	}
}

if (isset($_POST['Suspend'])) {
	if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
		$command = 'DecryptPassword';
		$postData = ['password2' => $_POST['password']];
		$adminUsername = WSResellerPanelDashboard_AdminUsername();
		$APiresults = localAPI($command, $postData, $adminUsername);
		$realPassword = (isset($APiresults['password']) ? $APiresults['password'] : '');
		$response = ResellerXCSuspendAccount($_POST['username'], $realPassword, $_POST['product_id'], $_POST['g-recaptcha-response']);

		if ($response == 'success') {
			$showmaessahe['result'] = 'success';
			$showmaessahe['messae'] = 'Server ' . $CurrentAction . ' Successfully!';
			$showmaessahe['alertclass'] = 'success';
		}
		else {
			$showmaessahe['result'] = 'error';
			$showmaessahe['messae'] = 'Error in make service ' . $CurrentAction . ' check logs!';
			$showmaessahe['alertclass'] = 'danger';
		}
	}
	else {
		$showmaessahe['result'] = 'error';
		$showmaessahe['messae'] = 'recaptcha is required!';
		$showmaessahe['alertclass'] = 'danger';
	}
}

if (isset($_POST['Terminate'])) {
	if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
		$command = 'DecryptPassword';
		$postData = ['password2' => $_POST['password']];
		$adminUsername = WSResellerPanelDashboard_AdminUsername();
		$APiresults = localAPI($command, $postData, $adminUsername);
		$realPassword = (isset($APiresults['password']) ? $APiresults['password'] : '');
		$response = WSResellerPanelTerminateAccount($_POST['username'], $realPassword, $_POST['product_id'], $_POST['g-recaptcha-response']);

		if ($response == 'success') {
			$showmaessahe['result'] = 'success';
			$showmaessahe['messae'] = 'Server ' . $CurrentAction . ' Successfully!';
			$showmaessahe['alertclass'] = 'success';
		}
		else {
			$showmaessahe['result'] = 'error';
			$showmaessahe['messae'] = 'Error in make service ' . $CurrentAction . ' check logs!';
			$showmaessahe['alertclass'] = 'danger';
		}
	}
	else {
		$showmaessahe['result'] = 'error';
		$showmaessahe['messae'] = 'recaptcha is required!';
		$showmaessahe['alertclass'] = 'danger';
	}
}

if (!empty($showmaessahe)) {
	echo '                <div class="alert alert-';
	echo $showmaessahe['alertclass'];
	echo ' alert-dismissible">' . "\n" . '                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . "\n" . '                    <strong>';
	echo ucfirst($showmaessahe['result']);
	echo ' !</strong>  ';
	echo $showmaessahe['messae'];
	echo '                </div>' . "\n" . '                ';
}

echo '            <div class="col-md-12">' . "\n" . '                ';
if (isset($_REQUEST['pid']) && ($_REQUEST['pid'] != '')) {
	$actual_link = $actual_link . '&pid=' . $_REQUEST['pid'];
	$productID = (isset($_REQUEST['pid']) ? $_REQUEST['pid'] : 'Undefined');
	$productdetailsare = WHMCS\Database\Capsule::table('tblproducts')->where('id', $productID)->get();
	$checkcaptcha = (isset($productdetailsare[0]->configoption15) ? $productdetailsare[0]->configoption15 : '');
	$adminlink = (isset($productdetailsare[0]->configoption9) ? $productdetailsare[0]->configoption9 : '');
	$bar = '/';

	if (substr($adminlink, -1) == '/') {
		$bar = '';
	}

	$adminlink = $adminlink . $bar;
	$URL = $adminlink . 'index.php';
	$cookie_path = dirname(__FILE__) . '/cookie.txt';
	$ch = curl_init($URL);
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$ret1 = curl_exec($ch);
	$dom = new DOMDocument();
	@$dom->loadHTML($ret1);
	$tags = $dom->getElementsByTagName('div');

	for ($i = 0; $i < $tags->length; $i++) {
		$grab = $tags->item($i);

		if ($grab->hasAttribute('data-sitekey')) {
			$sitekey = $grab->getAttribute('data-sitekey');
			break;
		}
	}

	$limitnum = 20;

	if (isset($_REQUEST['pageno'])) {
		$nextPage = $_REQUEST['pageno'] + 1;
		$currentPage = $_REQUEST['pageno'];
		$previousPage = $_REQUEST['pageno'] - 1;

		if ($_REQUEST['pageno'] != 1) {
			$limitstart = ($_REQUEST['pageno'] * $limitnum) - $limitnum;
		}
		else {
			$limitstart = 0;
		}
	}
	else {
		$currentPage = 1;
		$nextPage = 2;
		$limitstart = 0;
	}

	$whereData = [];
	$whereDateData = [];
	$whereData[] = ['tblhosting.domainstatus', '=', $CurrentAction];
	$whereData[] = ['tblproducts.servertype', '=', 'WSResellerPanel'];
	$whereData[] = ['tblproducts.id', '=', $productID];
	$whereData[] = ['tblproducts.configoption15', '=', 'on'];
	$pagingwithsearch = '';

	if ($CurrentAction == 'Terminated') {
		if (isset($_REQUEST['fromdate']) && !empty($_REQUEST['fromdate']) && isset($_REQUEST['todate']) && !empty($_REQUEST['todate'])) {
			$fromdateforPaging = '&fromdate=' . $_REQUEST['fromdate'];
			$_REQUEST['fromdate'] = strtotime('+1 day', $_REQUEST['fromdate']);
			$fromdateIs = date('Y-m-d', $_REQUEST['fromdate']);
			$datepickerdate = date('m/d/Y', $_REQUEST['fromdate']);
			$todateforPaging = '&todate=' . $_REQUEST['todate'];
			$_REQUEST['todate'] = strtotime('+1 day', $_REQUEST['todate']);
			$todateIs = date('Y-m-d', $_REQUEST['todate']);
			$datepickerdateTodate = date('m/d/Y', $_REQUEST['todate']);
			$pagingwithsearch = $fromdateforPaging . $todateforPaging;
		}
		else {
			$whereData[] = ['tblhosting.termination_date', '=', date('Y-m-d')];
		}
	}
	if (isset($fromdateIs) && isset($todateIs)) {
		$totalRecords = WHMCS\Database\Capsule::table('tblhosting')->join('tblclients', 'tblhosting.userid', '=', 'tblclients.id')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where($whereData)->whereDate('tblhosting.termination_date', '>=', $fromdateIs)->whereDate('tblhosting.termination_date', '<=', $todateIs)->orderBy('tblhosting.domain', 'asc')->select('tblhosting.*', 'tblclients.email as clientemail', 'tblclients.id as clientid', 'tblproducts.name as productname')->count();
		$results = WHMCS\Database\Capsule::table('tblhosting')->join('tblclients', 'tblhosting.userid', '=', 'tblclients.id')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where($whereData)->whereDate('tblhosting.termination_date', '>=', $fromdateIs)->whereDate('tblhosting.termination_date', '<=', $todateIs)->orderBy('tblhosting.domain', 'asc')->select('tblhosting.*', 'tblclients.email as clientemail', 'tblclients.id as clientid', 'tblproducts.name as productname')->offset($limitstart)->limit($limitnum)->get();
	}
	else {
		$totalRecords = WHMCS\Database\Capsule::table('tblhosting')->join('tblclients', 'tblhosting.userid', '=', 'tblclients.id')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where($whereData)->orderBy('tblhosting.domain', 'asc')->select('tblhosting.*', 'tblclients.email as clientemail', 'tblclients.id as clientid', 'tblproducts.name as productname')->count();
		$results = WHMCS\Database\Capsule::table('tblhosting')->join('tblclients', 'tblhosting.userid', '=', 'tblclients.id')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where($whereData)->orderBy('tblhosting.domain', 'asc')->select('tblhosting.*', 'tblclients.email as clientemail', 'tblclients.id as clientid', 'tblproducts.name as productname')->offset($limitstart)->limit($limitnum)->get();
	}

	$totalPage = ceil($totalRecords / $limitnum);

	if ($CurrentAction == 'Terminated') {
		echo '                        <div class="filtersection"> ' . "\n" . '                            <input type="text" id="fromdate" class="c-datepicker" placeholder="From Date" value="';
		echo isset($datepickerdate) ? $datepickerdate : '';
		echo '">' . "\n" . '                            &nbsp;  ' . "\n" . '                            <input type="text" id="todate" class="c-datepicker" placeholder="To Date" value="';
		echo isset($datepickerdateTodate) ? $datepickerdateTodate : '';
		echo '">' . "\n" . '                            <button class="filterNow btn btn-primary">Filter</button>' . "\n" . '                        </div>  ' . "\n" . '                        ';
	}

	if (!empty($results)) {
		echo '                        <p style="text-align: right;float: right">' . "\n" . '                            ';
		echo ' Total ' . $totalRecords . ' Records found, Page ' . $currentPage . ' of ' . $totalPage;
		echo '                        </p>' . "\n" . '                        <button class="btn btn-primary" style="padding: 11px 40px;font-size: 15px;" onclick="jQuery(\'#modalModule';
		echo $btnName;
		echo '\').modal(\'show\');" >';
		echo $btnName;
		echo ' All</button>' . "\n" . '                        <form method="POST"> ' . "\n" . '                            <div class="modal fade" id="modalModule';
		echo $btnName;
		echo '" role="dialog" aria-labelledby="Module';
		echo $btnName;
		echo 'Label" aria-hidden="true">' . "\n" . '                                <div class="modal-dialog">' . "\n" . '                                    <div class="modal-content panel panel-primary">' . "\n" . '                                        <div id="modalModuleSuspendHeading" class="modal-header panel-heading">' . "\n" . '                                            <button type="button" class="close" data-dismiss="modal">' . "\n" . '                                                <span aria-hidden="true">×</span>' . "\n" . '                                                <span class="sr-only">Close</span>' . "\n" . '                                            </button>' . "\n" . '                                            <h4 class="modal-title" id="Module';
		echo $btnName;
		echo 'Label">Confirm ';
		echo $btnName;
		echo ' Command</h4>' . "\n" . '                                        </div>' . "\n" . '                                        <div id="modalModuleSuspendBody" class="modal-body panel-body">' . "\n" . '                                            Are you sure you want to run the ';
		echo $btnName;
		echo ' function?<br>' . "\n" . '                                            <div class="margin-top-bottom-20 text-center">' . "\n" . '                                                <div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="';
		echo $sitekey;
		echo '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>' . "\n" . '                                            </div>  ' . "\n" . '                                        </div>' . "\n" . '                                        <div id="modalModuleSuspendFooter" class="modal-footer panel-footer"> ' . "\n" . '                                            ';

		foreach ($results as $servicedetails) {
			echo '                                                <input type="hidden" name="data[]" value="';
			echo $servicedetails->username . '|' . $servicedetails->password . '|' . $servicedetails->packageid;
			echo '">' . "\n" . '                                            ';
		}

		echo '                                            <input type="submit" name="';
		echo $btnName . 'all';
		echo '" id="ModuleSuspend-Yes" class="btn btn-primary" value="Yes">' . "\n" . '                                            <button type="button" id="ModuleSuspend-No" class="btn btn-default" data-dismiss="modal">' . "\n" . '                                                No' . "\n" . '                                            </button>' . "\n" . '                                        </div>' . "\n" . '                                    </div>' . "\n" . '                                </div>' . "\n" . '                            </div>' . "\n" . '                        </form> ' . "\n" . '                        <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">' . "\n" . '                            <thead>' . "\n" . '                                <tr>' . "\n" . '                                    <th scope="col">#</th>' . "\n" . '                                    <th scope="col">Client Email</th>' . "\n" . '                                    <th scope="col">Username</th>' . "\n" . '                                    <th scope="col">Password <span class="showhideall label label-info" data-current="show">Show All</span></th>' . "\n" . '                                    <th scope="col">';
		echo $CurrentAction == 'Terminated' ? 'Terminated On' : 'Expiry Date';
		echo '</th>' . "\n" . '                                    <th scope="col">Package Name</th>' . "\n" . '                                    <th scope="col">Action</th>' . "\n" . '                                </tr>' . "\n" . '                            </thead>' . "\n" . '                            <tbody>' . "\n" . '                                ';

		foreach ($results as $servicedetails) {
			$command = 'DecryptPassword';
			$postData = ['password2' => $servicedetails->password];
			$adminUsername = WSResellerPanelDashboard_AdminUsername();
			$APiresults = localAPI($command, $postData, $adminUsername);
			$realPassword = (isset($APiresults['password']) ? $APiresults['password'] : '');
			echo '  ' . "\n" . '                                    <tr>' . "\n" . '                                        <td>' . "\n" . '                                            <a href="clientsservices.php?userid=';
			echo $servicedetails->clientid;
			echo '&id=';
			echo $servicedetails->id;
			echo '" class="customanchors" target="_blank">      ' . "\n" . '                                                ';
			echo $servicedetails->id;
			echo '                                            </a>' . "\n" . '                                        </td>' . "\n" . '                                        <td>' . "\n" . '                                            <a href="clientssummary.php?userid=';
			echo $servicedetails->clientid;
			echo '" class="customanchors" target="_blank">     ' . "\n" . '                                                ';
			echo $servicedetails->clientemail;
			echo '                                            </a>            ' . "\n" . '                                        </td>' . "\n" . '                                        <td>        ' . "\n" . '                                            ';
			echo $servicedetails->username;
			echo '                                        </td>' . "\n" . '                                        <td>' . "\n" . '                                            <span class="displaysec-';
			echo $servicedetails->id;
			echo '">**********</span>           ' . "\n" . '                                            <span ' . "\n" . '                                                class="btnshowhide label label-info" ' . "\n" . '                                                data-rpass="';
			echo $realPassword;
			echo '" ' . "\n" . '                                                data-displayclass="displaysec-';
			echo $servicedetails->id;
			echo '" ' . "\n" . '                                                data-current="show">' . "\n" . '                                                Show' . "\n" . '                                            </span>' . "\n" . '                                        </td>' . "\n" . '                                        <td>        ' . "\n" . '                                            ';
			$Dateis = ($CurrentAction == 'Terminated' ? $servicedetails->termination_date : $servicedetails->nextduedate);
			echo date('l, d F Y', strtotime($Dateis));
			echo '                                        </td>' . "\n" . '                                        <td>' . "\n" . '                                            <a href="configproducts.php?action=edit&id=';
			echo $servicedetails->packageid;
			echo '" class="customanchors" target="_blank">        ' . "\n" . '                                                ';
			echo $servicedetails->productname;
			echo '                                            </a>    ' . "\n" . '                                        </td>' . "\n" . '                                        <td>  ' . "\n" . '                                            <button class="btn btn-primary" onclick="jQuery(\'#modalModule';
			echo $btnName;
			echo '-';
			echo $servicedetails->id;
			echo '\').modal(\'show\');" data-username="';
			echo $servicedetails->username;
			echo '">';
			echo $btnName;
			echo '</button>' . "\n" . '                                            <form method="POST"> ' . "\n" . '                                                <div class="modal fade" id="modalModule';
			echo $btnName;
			echo '-';
			echo $servicedetails->id;
			echo '" role="dialog" aria-labelledby="Module';
			echo $btnName;
			echo 'Label" aria-hidden="true">' . "\n" . '                                                    <div class="modal-dialog">' . "\n" . '                                                        <div class="modal-content panel panel-primary">' . "\n" . '                                                            <div id="modalModuleSuspendHeading" class="modal-header panel-heading">' . "\n" . '                                                                <button type="button" class="close" data-dismiss="modal">' . "\n" . '                                                                    <span aria-hidden="true">×</span>' . "\n" . '                                                                    <span class="sr-only">Close</span>' . "\n" . '                                                                </button>' . "\n" . '                                                                <h4 class="modal-title" id="Module';
			echo $btnName;
			echo 'Label">Confirm Module Command</h4>' . "\n" . '                                                            </div>' . "\n" . '                                                            <div id="modalModuleSuspendBody" class="modal-body panel-body">' . "\n" . '                                                                Are you sure you want to run the ';
			echo $btnName;
			echo ' function?<br>' . "\n" . '                                                                <div class="margin-top-bottom-20 text-center">' . "\n" . '                                                                    <div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="';
			echo $sitekey;
			echo '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>' . "\n" . '                                                                </div>  ' . "\n" . '                                                            </div>' . "\n" . '                                                            <div id="modalModuleSuspendFooter" class="modal-footer panel-footer"> ' . "\n" . '                                                                <input type="hidden" name="username" value="';
			echo $servicedetails->username;
			echo '">' . "\n" . '                                                                <input type="hidden" name="password" value="';
			echo $servicedetails->password;
			echo '">' . "\n" . '                                                                <input type="hidden" name="product_id" value="';
			echo $servicedetails->packageid;
			echo '">' . "\n" . '                                                                <input type="submit" name="';
			echo $btnName;
			echo '" id="ModuleSuspend-Yes" class="btn btn-primary" value="Yes">' . "\n" . '                                                                <button type="button" id="ModuleSuspend-No" class="btn btn-default" data-dismiss="modal">' . "\n" . '                                                                    No' . "\n" . '                                                                </button>' . "\n\n\n" . '                                                            </div>' . "\n" . '                                                        </div>' . "\n" . '                                                    </div>' . "\n" . '                                                </div>' . "\n" . '                                            </form> ' . "\n" . '                                        </td>' . "\n" . '                                    </tr>' . "\n" . '                                    ';
		}

		echo '                            </tbody>' . "\n" . '                        </table>    ' . "\n" . '                        <p align="center">' . "\n" . '                            ';
		if (isset($previousPage) && !empty($previousPage) && ($previousPage != 0)) {
			echo '                                <a href="';
			echo $modulelink;
			echo '&action=manualaction&section=';
			echo $_REQUEST['section'];
			echo '&pid=';
			echo $productID;
			echo '&pageno=';
			echo $previousPage . $pagingwithsearch;
			echo '">&#171; Previous Page </a>&nbsp; ' . "\n" . '                                ';
		}
		else {
			echo '&#171; Previous Page &nbsp;';
		}

		echo '                            ';
		if (isset($nextPage) && !empty($nextPage) && !($totalPage < $nextPage)) {
			echo '                                <a href="';
			echo $modulelink;
			echo '&action=manualaction&section=';
			echo $_REQUEST['section'];
			echo '&pid=';
			echo $productID;
			echo '&pageno=';
			echo $nextPage . $pagingwithsearch;
			echo '">Next Page &#187; </a>&nbsp; ' . "\n" . '                                ';
		}
		else {
			echo 'Next Page &#187;';
		}

		echo '                        </p>' . "\n" . '                        ';
	}
	else {
		echo '                        <center><h4>No result Found</h4></center>' . "\n" . '                        ';
	}
}
else {
	$whereData = [];
	$whereData[] = ['tblhosting.domainstatus', '=', $CurrentAction];
	$whereData[] = ['tblproducts.configoption15', '=', 'on'];
	$PackagesData = WHMCS\Database\Capsule::table('tblproducts')->join('tblhosting', 'tblproducts.id', '=', 'tblhosting.packageid')->groupBy('tblproducts.id')->select('tblproducts.*')->where($whereData)->get();

	if (!empty($PackagesData)) {
		echo '                        <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">' . "\n" . '                            <thead>' . "\n" . '                                <tr>' . "\n" . '                                    <th scope="col">#</th>' . "\n" . '                                    <th scope="col">Name</th>' . "\n" . '                                    <th scope="col">Billing Cycle</th>' . "\n" . '                                    <th scope="col">Action</th>' . "\n" . '                                </tr>' . "\n" . '                            </thead>' . "\n" . '                            <tbody>' . "\n" . '                                ';

		foreach ($PackagesData as $pkdata) {
			echo '                                    <tr>' . "\n" . '                                        <td >' . "\n" . '                                            <a href="configproducts.php?action=edit&id=';
			echo $pkdata->id;
			echo '" class="customanchors" target="_blank">' . "\n" . '                                                ';
			echo $pkdata->id;
			echo '                                            </a>' . "\n" . '                                        </td>' . "\n" . '                                        <td >' . "\n" . '                                            <a href="configproducts.php?action=edit&id=';
			echo $pkdata->id;
			echo '" class="customanchors" target="_blank">' . "\n" . '                                                ';
			echo $pkdata->name;
			echo '                                            </a>' . "\n" . '                                        </td>' . "\n" . '                                        <td > ';
			echo $pkdata->paytype;
			echo '</td>' . "\n" . '                                        <td >' . "\n" . '                                            <a href="';
			echo $actualForlinks . '&pid=' . $pkdata->id;
			echo '" class="btn btn-primary">View ';
			echo $CurrentAction;
			echo ' Services</a>' . "\n" . '                                        </td>' . "\n" . '                                    </tr>' . "\n" . '                                    ';
		}

		echo '                            </tbody>' . "\n" . '                        </table>' . "\n" . '                        ';
	}
	else {
		echo '                        <center><h4>No result Found</h4></center>' . "\n" . '                        ';
	}
}

echo '            </div>' . "\n" . '        </div>' . "\n" . '    </div>' . "\n" . '</div>' . "\n\n" . '<script type="text/javascript">' . "\n" . '    $(document).ready(function () {' . "\n" . '        $(".btnshowhide").click(function () {' . "\n" . '            current = $(this).data("current");' . "\n" . '            displayclass = $(this).data("displayclass");' . "\n" . '            rpass = $(this).data("rpass");' . "\n" . '            if (current == "show")' . "\n" . '            {' . "\n" . '                $(this).data("current", "hide");' . "\n" . '                $(this).text("Hide");' . "\n" . '                $("." + displayclass).text(rpass);' . "\n" . '            } else' . "\n" . '            {' . "\n" . '                $(this).data("current", "show");' . "\n" . '                $(this).text("Show");' . "\n" . '                $("." + displayclass).text("**********");' . "\n" . '            }' . "\n" . '        });' . "\n\n\n" . '        $(".filterNow").click(function () {' . "\n" . '            $(".c-datepicker").removeClass("addborder");' . "\n" . '            if ($("#fromdate").val() != "" && $("#todate").val() != "")' . "\n" . '            {' . "\n" . '                fromdate = fettimestamp($("#fromdate").val());' . "\n" . '                todate = fettimestamp($("#todate").val());' . "\n" . '                //console.log("';
echo $actual_link;
echo '&fromdate="+s);' . "\n" . '                window.location.href = "';
echo $actual_link;
echo '&fromdate=" + fromdate + "&todate=" + todate;' . "\n" . '            } else' . "\n" . '            {' . "\n" . '                if ($("#fromdate").val() == "")' . "\n" . '                {' . "\n" . '                    $("#fromdate").addClass("addborder");' . "\n" . '                }' . "\n" . '                if ($("#todate").val() == "")' . "\n" . '                {' . "\n" . '                    $("#todate").addClass("addborder");' . "\n" . '                }' . "\n" . '            }' . "\n" . '        });' . "\n\n\n" . '        $(".showhideall").click(function () {' . "\n" . '            current = $(this).data("current");' . "\n" . '            if (current == "show")' . "\n" . '            {' . "\n" . '                $(this).data("current", "hide");' . "\n" . '                $(this).text("Hide All");' . "\n" . '                $(".btnshowhide").each(function () {' . "\n" . '                    rpass = $(this).data("rpass");' . "\n" . '                    displayclass = $(this).data("displayclass");' . "\n" . '                    $(this).data("current", "hide");' . "\n" . '                    $(this).text("Hide");' . "\n" . '                    $("." + displayclass).text(rpass);' . "\n" . '                });' . "\n" . '            } else' . "\n" . '            {' . "\n" . '                $(this).data("current", "show");' . "\n" . '                $(this).text("Show All");' . "\n" . '                $(".btnshowhide").each(function () {' . "\n" . '                    rpass = $(this).data("rpass");' . "\n" . '                    displayclass = $(this).data("displayclass");' . "\n" . '                    $(this).data("current", "show");' . "\n" . '                    $(this).text("Show");' . "\n" . '                    $("." + displayclass).text("**********");' . "\n" . '                });' . "\n" . '            }' . "\n" . '        });' . "\n" . '    });' . "\n\n" . '    function fettimestamp(dateval)' . "\n" . '    {' . "\n" . '        stringyDate = dateval;' . "\n" . '        var dateyDate = new Date(stringyDate);' . "\n" . '        var ms = dateyDate.valueOf();' . "\n" . '        var s = ms / 1000;' . "\n" . '        return s;' . "\n" . '    }' . "\n\n" . '    $(function () {' . "\n" . '        $(".c-datepicker").datepicker({maxDate: 0});' . "\n" . '    });' . "\n" . '</script>' . "\n\n";

?>