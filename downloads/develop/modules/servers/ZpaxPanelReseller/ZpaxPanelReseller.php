<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.1.0.1
* @ Author			:	DeZender
* @ Release on		:	29.08.2020
* @ Official site	:	http://DeZender.Net
*
*/

function ZpaxPanelReseller_MetaData()
{
	return ['DisplayName' => 'Zpax Panel Reseller', 'APIVersion' => '2.0.1', 'RequiresServer' => true];
}

function ZpaxPanelReseller_ConfigOptions()
{
	$returnData = [];
	$licenseinfo = ZpaxPanelReseller_CheckLicenseByKey();

	if ($licenseinfo['status'] == 'Active') {
		$moduledetails = Illuminate\Database\Capsule\Manager::table('tbladdonmodules')->where('module', '=', 'ZpaxResllerDashbord')->where('setting', '=', 'version')->get();

		if (empty($moduledetails)) {
			return [
				'serverstatus' => ['FriendlyName' => 'Module Status', 'Description' => '<span style=\'color:red;\'>Addon Module is not Activated Please Active it from Admin Area > Setup > Addon Modules > Zpax Reseller Dashboard<span>', 'Size' => 80]
			];
		}
		$productID = (isset($_REQUEST['id']) && !empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
		$productalldata = $checkServerAttached = Illuminate\Database\Capsule\Manager::table('tblproducts')->where('id', '=', $productID)->get();
		$ProductServer = (isset($checkServerAttached[0]->servertype) && !empty($checkServerAttached[0]->servertype) ? $checkServerAttached[0]->servertype : '');

		if ($ProductServer != 'ZpaxPanelReseller') {
			return [
				'serverstatus' => ['FriendlyName' => 'Server Status', 'Description' => '<span style=\'color:red;\'>Please click on Save changes to make settings.<span>', 'Size' => 80]
			];
		}

		$ExistingPanels = Illuminate\Database\Capsule\Manager::table('mod_ZRDpanelsdetails')->get();
		$PanelsList = ['' => 'No Panel Exists'];
		$descPanel = 'Click <a href=\'addonmodules.php?module=ZpaxResllerDashbord&action=addpanels&panel=add\' style=\'color: #3b3bb1;' . "\r\n" . '    font-weight: bold;text-decoration: underline;\'>here</a> to add panel';

		if (!empty($ExistingPanels)) {
			$PanelsList = [];

			foreach ($ExistingPanels as $panelData) {
				$PanelsList[$panelData->id] = $panelData->panelidentifier;
			}

			$descPanel = '<a id="TestConnectionBTN" href="javascript:;" onclick="testconnectionfunction()" class="conntestbtn btn btn-primary">Test connection </a> <a href="addonmodules.php?module=ZpaxResllerDashbord&action=addpanels&panel=add" class="btn btn-primary">Add New</a>';
		}
		$currentProducttype = (isset($productalldata[0]->configoption4) && !empty($productalldata[0]->configoption4) ? $productalldata[0]->configoption4 : 'streamlineonly');
		$moduleversion = $moduledetails[0]->value;
		$description = 'Module Version v' . $moduleversion . '<input type="hidden" id="loadonce" value="">';
		$returnData['Version'] = ['Description' => $description];
		$returnData['Panels'] = ['Type' => 'dropdown', 'Options' => $PanelsList, 'Description' => $descPanel, 'Size' => 80];
		$returnData['Reseller Details'] = ['Description' => '<span id="resellerDta" style="display:none;">Loading Data..</span>'];
		$returnData['Product'] = [
			'Type'        => 'dropdown',
			'Options'     => ['streamlineonly' => 'Streaming Line', 'magdevice' => 'MAG Device'],
			'Description' => 'What type is this product?',
			'Size'        => 80
		];
		$returnData['Select Line Type'] = [
			'Type'    => 'dropdown',
			'Options' => ['yes' => 'Trial', 'no' => 'Official']
		];
		$returnData['Select Package'] = ['Name' => 'addonpackages', 'Type' => 'text', 'Size' => '20', 'Default' => '0', 'Description' => '<br /><a id="" onclick="getpackagedata()" href="javascript:;" class="getpackagebtn">Assign package to this product here </a>'];
		$returnData['Select Bouquets'] = ['Name' => 'Bouquets', 'Type' => 'text', 'Size' => '20', 'Default' => '0', 'Description' => '<br /><a id="" onclick="getBouquet()" href="javascript:;" class="BouquetBtn">Assign Bouquets to this product here </a>'];
		$returnData[''] = ['Description' => '<center><a  href="javascript:;" onclick="CreateCustomFieldsZpax()" >Click  here to create required custom fields </a></center>', 'Size' => 80];
		$returnData['ISP Lock'] = ['Type' => 'yesno', 'Description' => 'Tick to enable isp lock'];

		if ($currentProducttype == 'streamlineonly') {
			$returnData['M3U link'] = ['Type' => 'yesno', 'Description' => 'Tick to Show M3U link in clientarea?'];
			$returnData['Watch Streams!'] = ['Type' => 'yesno', 'Default' => 'yes', 'Description' => 'Tick to show Xtream Codes’s client area link for watching streams online.'];
			$returnData['Other Device Section'] = ['Type' => 'yesno', 'Description' => 'Tick to show <b><a style="text-decoration:underline" target="_blank" href="https://drive.google.com/file/d/0Bxdm-R-xZmjYX2hfa0RPNDNHaGM/view?usp=drivesdk">Other Device Section</a></b> on the Client Area.', 'Default' => 'on'];
			$returnData['Is Username Editable'] = ['Type' => 'yesno', 'Description' => 'Tick If Username is editable.', 'Default' => 'on'];
			$returnData['Is Password Editable'] = ['Type' => 'yesno', 'Description' => 'Tick If Password is editable.', 'Default' => 'on'];
		}
		else if ($currentProducttype == 'magdevice') {
			$returnData['MAG Portal link'] = ['Type' => 'yesno', 'Default' => 'yes', 'Description' => 'Show MAG Portal link in Client Area'];
		}

		return $returnData;
	}
	else {
		return [
			'licenseKeyStatus' => ['FriendlyName' => 'License Key Status', 'Description' => '<span style=\'color:red;\'>Invalid or Expired license key.<span>', 'Size' => 80]
		];
	}
}

function ZpaxPanelReseller_CreateAccount(array $params)
{
	$licenseinfo = ZpaxPanelReseller_CheckLicenseByKey();

	if ($licenseinfo['status'] != 'Active') {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $licenseinfo, 'Invalid or expired license key. - Please check Zapx Reseller Dashboard addon configuration');
		return 'Something went wrong Please contact administrator';
	}

	$RequestFinal = [];
	$GlobalfunserviceID = $params['serviceid'];
	$configoptions = ZpaxPanelReseller_configfieldsofzpax();
	$currentFileName = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$trialconditionalarray = ['yes', 'no'];
	$productdetailsare = Illuminate\Database\Capsule\Manager::table('tblproducts')->where('id', $params['pid'])->get();
	$PanelID = $params['configoption2'];
	$Paneldata = ZpaxPanelReseller_paneldatabyid($PanelID);

	if (empty($Paneldata)) {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $PanelID, 'No panel data found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}

	$RequestFinal = $Paneldata;
	$RequestFinal['action'] = 'add_user';
	$currentProducttype = (isset($params['configoption4']) && !empty($params['configoption4']) ? $params['configoption4'] : '');

	if ($currentProducttype == '') {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $productdetailsare, 'No product type (streamline or magdevice) found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}

	$is_trial = $params['configoption5'];
	$trialinlink = '1';

	if (in_array($params['configoption5'], $trialconditionalarray)) {
		$is_trial = ($params['configoption5'] == 'yes' ? 'on' : '');
		$trialinlink = ($params['configoption5'] == 'yes' ? 1 : 0);
	}

	$package_id = $params['configoption6'];
	$explodePackageID = explode('|', $package_id);
	$package_id = $explodePackageID[0];
	$RequestFinal['requestdata']['package'] = $package_id;
	$bouquetsids = $params['configoption7'];
	$RequestFinal['requestdata']['current_bouquets'] = $bouquetsids;
	$isplocl = $params['configoption9'];
	$RequestFinal['requestdata']['is_isplock'] = ($isplocl == 'on' ? 'on' : '');
	$common_identifier = (isset($configoptions['common_identifier']) && !empty($configoptions['common_identifier']) ? $configoptions['common_identifier'] : 'WHMCS:');
	$RequestFinal['requestdata']['description'] = $common_identifier . $params['serviceid'];

	if ($currentProducttype == 'streamlineonly') {
		$RequestFinal['product_type'] = 'streamlineonly';
		$RequestFinal['sublink'] = 'lines/create-new/' . $trialinlink . '/line';
		$RequestFinal['requestdata']['mac'] = '';
		$RequestFinal['requestdata']['line_type'] = 'line';
		$RequestFinal['requestdata']['q'] = '';
		$username = $params['username'];
		$password = $params['password'];
		$usernamepermission = $params['configoption13'];

		if ($usernamepermission == 'on') {
			if (empty($username)) {
				$unamefieldname = (isset($configoptions['custom_field_username']) && !empty($configoptions['custom_field_username']) ? $configoptions['custom_field_username'] : 'Username');
				if (isset($params['customfields'][$unamefieldname]) && !empty($params['customfields'][$unamefieldname])) {
					$username = $params['customfields'][$unamefieldname];
				}
				else {
					$username = ZpaxPanelReseller_generate_ran();
				}

				Illuminate\Database\Capsule\Manager::table('tblhosting')->where('id', $params['serviceid'])->update(['username' => $username]);
			}

			$RequestFinal['requestdata']['username'] = $username;
		}

		if (!isset($RequestFinal['requestdata']['username'])) {
			$username = (!empty($username) ? $username : '');
			$RequestFinal['requestdata']['username'] = $username;
		}

		$passwordpermission = $params['configoption14'];

		if ($passwordpermission == 'on') {
			$passwordfieldname = (isset($configoptions['custom_field_password']) && !empty($configoptions['custom_field_password']) ? $configoptions['custom_field_password'] : 'Password');
			$PasswordIs = (isset($params['password']) && !empty($params['password']) ? $params['password'] : '');
			if (isset($params['customfields'][$passwordfieldname]) && !empty($params['customfields'][$passwordfieldname])) {
				$PasswordIs = $params['customfields'][$passwordfieldname];
			}
			if (isset($PasswordIs) && !empty($PasswordIs)) {
				$PasswordIs = $PasswordIs;
			}
			else {
				$PasswordIs = ZpaxPanelReseller_generate_ran();
			}

			$RequestFinal['requestdata']['password'] = $PasswordIs;
		}

		$responseforlogs = $api_result2 = ZpaxPanelReseller_CallApiRequest($RequestFinal);
		if (isset($api_result2['password']) && !empty($api_result2['password'])) {
			unset($responseforlogs['password']);
		}

		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $RequestFinal, $responseforlogs);

		if ($api_result2['result'] == 'success') {
			$username = $username;
			if (isset($api_result2['username']) && !empty($api_result2['username'])) {
				$username = $api_result2['username'];
			}
			if (isset($api_result2['password']) && !empty($api_result2['password'])) {
				$PasswordIs = $api_result2['password'];
			}
			if (isset($api_result2['password']) && !empty($api_result2['password'])) {
				$PasswordIs = $api_result2['password'];
			}

			$nextDueGet = '';
			if (isset($api_result2['expire_date']) && !empty($api_result2['expire_date'])) {
				$nextDueGet = date('Y-m-d', $api_result2['expire_date']);
				Illuminate\Database\Capsule\Manager::table('tblhosting')->where('id', $GlobalfunserviceID)->update(['nextduedate' => $nextDueGet]);
			}

			$command = 'EncryptPassword';
			$postData = ['password2' => $PasswordIs];
			$passworden = localAPI($command, $postData);
			$finalenpassword = (isset($passworden['password']) && !empty($passworden['password']) ? $passworden['password'] : '');
			Illuminate\Database\Capsule\Manager::table('tblhosting')->where('id', $GlobalfunserviceID)->update(['username' => $username, 'password' => $finalenpassword]);
			return 'success';
		}
		else {
			return isset($api_result2['message']) && !empty($api_result2['message']) ? $api_result2['message'] : 'No Response from the server! Please check the logs for more details';
		}
	}
	else if ($currentProducttype == 'magdevice') {
		$finalMagtoAdd = '';
		$MagCustomfield = (isset($configoptions['custom_field_mag']) && !empty($configoptions['custom_field_mag']) ? $configoptions['custom_field_mag'] : 'MAG Address');
		if (!empty($params['customfields'][$MagCustomfield]) && !empty($params['customfields'][$MagCustomfield])) {
			$finalMagtoAdd = $params['customfields'][$MagCustomfield];
		}

		if ($finalMagtoAdd == '') {
			return 'MAG Address field is reqiured!';
		}

		$RequestFinal['product_type'] = 'magdevice';
		$RequestFinal['sublink'] = 'lines/create-new/' . $trialinlink . '/mag';
		$RequestFinal['requestdata']['username'] = '';
		$RequestFinal['requestdata']['mac'] = $finalMagtoAdd;
		$RequestFinal['requestdata']['line_type'] = 'mag';
		$RequestFinal['requestdata']['q'] = '';
		$responseforlogs = $api_result2 = ZpaxPanelReseller_CallApiRequest($RequestFinal);
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $RequestFinal, $responseforlogs);

		if ($api_result2['result'] == 'success') {
			$nextDueGet = '';
			if (isset($api_result2['expire_date']) && !empty($api_result2['expire_date'])) {
				$nextDueGet = date('Y-m-d', $api_result2['expire_date']);
				Illuminate\Database\Capsule\Manager::table('tblhosting')->where('id', $GlobalfunserviceID)->update(['nextduedate' => $nextDueGet]);
			}

			return 'success';
		}
		else {
			return isset($api_result2['message']) && !empty($api_result2['message']) ? $api_result2['message'] : 'No Response from the server! Please check the logs for more details';
		}
	}

	return 'success';
}

function ZpaxPanelReseller_SuspendAccount(array $params)
{
	return ZpaxPanelReseller_CommonDisableEnableDelete($params, 'disable');
}

function ZpaxPanelReseller_UnsuspendAccount(array $params)
{
	return ZpaxPanelReseller_CommonDisableEnableDelete($params, 'enable');
}

function ZpaxPanelReseller_TerminateAccount(array $params)
{
	return ZpaxPanelReseller_CommonDisableEnableDelete($params, 'delete');
}

function ZpaxPanelReseller_Renew(array $params)
{
	return ZpaxPanelReseller_CommonRenew_Changepackage($params, 'extend', 'renew');
}

function ZpaxPanelReseller_ChangePackage(array $params)
{
	return ZpaxPanelReseller_CommonRenew_Changepackage($params, 'extend', 'ChangePackage');
}

function ZpaxPanelReseller_CommonRenew_Changepackage($params = [], $funaction = '', $actionforlog = '')
{
	$RequestFinal = [];
	$GlobalfunserviceID = $params['serviceid'];
	$configoptions = ZpaxPanelReseller_configfieldsofzpax();
	$currentFileName = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$trialconditionalarray = ['yes', 'no'];
	$productdetailsare = Illuminate\Database\Capsule\Manager::table('tblproducts')->where('id', $params['pid'])->get();
	$PanelID = $params['configoption2'];
	$Paneldata = ZpaxPanelReseller_paneldatabyid($PanelID);

	if (empty($Paneldata)) {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $PanelID, 'No panel data found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}

	$RequestFinal = $Paneldata;
	$RequestFinal['action'] = $funaction;
	$currentProducttype = (isset($params['configoption4']) && !empty($params['configoption4']) ? $params['configoption4'] : '');

	if ($currentProducttype == '') {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $productdetailsare, 'No product type (streamline or magdevice) found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}

	$is_trial = $params['configoption5'];
	$trialinlink = '1';

	if (in_array($params['configoption5'], $trialconditionalarray)) {
		$is_trial = ($params['configoption5'] == 'yes' ? 'on' : '');
		$trialinlink = ($params['configoption5'] == 'yes' ? 1 : 0);
	}

	$package_id = $params['configoption6'];
	$explodePackageID = explode('|', $package_id);
	$package_id = $explodePackageID[0];
	$RequestFinal['requestdata']['package'] = $package_id;
	$bouquetsids = $params['configoption7'];
	$RequestFinal['requestdata']['current_bouquets'] = $bouquetsids;
	$common_identifier = (isset($configoptions['common_identifier']) && !empty($configoptions['common_identifier']) ? $configoptions['common_identifier'] : 'WHMCS:');
	$RequestFinal['requestdata']['description'] = $common_identifier . $params['serviceid'];

	if ($currentProducttype == 'streamlineonly') {
		$RequestFinal['product_type'] = 'streamlineonly';
		$RequestFinal['sublink'] = 'lines/extend-new';
		$RequestFinal['requestdata']['q'] = '';
		$username = $params['username'];
		$password = $params['password'];
		$RequestFinal['requestdata']['username'] = $username;
		$responseforlogs = $api_result2 = ZpaxPanelReseller_CallApiRequest($RequestFinal);
		if (isset($api_result2['password']) && !empty($api_result2['password'])) {
			unset($responseforlogs['password']);
		}

		logModuleCall('ZpaxPanelReseller', $actionforlog, $RequestFinal, $responseforlogs);

		if ($api_result2['result'] == 'success') {
			$nextDueGet = '';
			if (isset($api_result2['expire_date']) && !empty($api_result2['expire_date'])) {
				$nextDueGet = date('Y-m-d', $api_result2['expire_date']);
				Illuminate\Database\Capsule\Manager::table('tblhosting')->where('id', $GlobalfunserviceID)->update(['nextduedate' => $nextDueGet]);
			}

			return 'success';
		}
		else {
			return isset($api_result2['message']) && !empty($api_result2['message']) ? $api_result2['message'] : 'No Response from the server! Please check the logs for more details';
		}
	}
	else if ($currentProducttype == 'magdevice') {
		$finalMagtoAdd = '';
		$MagCustomfield = (isset($configoptions['custom_field_mag']) && !empty($configoptions['custom_field_mag']) ? $configoptions['custom_field_mag'] : 'MAG Address');
		if (!empty($params['customfields'][$MagCustomfield]) && !empty($params['customfields'][$MagCustomfield])) {
			$finalMagtoAdd = $params['customfields'][$MagCustomfield];
		}

		if ($finalMagtoAdd == '') {
			return 'MAG Address field is reqiured!';
		}

		$RequestFinal['product_type'] = 'magdevice';
		$RequestFinal['sublink'] = 'lines/extend-new';
		$RequestFinal['requestdata']['mac'] = $finalMagtoAdd;
		$RequestFinal['requestdata']['q'] = '';
		$responseforlogs = $api_result2 = ZpaxPanelReseller_CallApiRequest($RequestFinal);
		logModuleCall('ZpaxPanelReseller', $actionforlog, $RequestFinal, $responseforlogs);

		if ($api_result2['result'] == 'success') {
			$nextDueGet = '';
			if (isset($api_result2['expire_date']) && !empty($api_result2['expire_date'])) {
				$nextDueGet = date('Y-m-d', $api_result2['expire_date']);
				Illuminate\Database\Capsule\Manager::table('tblhosting')->where('id', $GlobalfunserviceID)->update(['nextduedate' => $nextDueGet]);
			}

			return 'success';
		}
		else {
			return isset($api_result2['message']) && !empty($api_result2['message']) ? $api_result2['message'] : 'No Response from the server! Please check the logs for more details';
		}
	}

	return 'success';
}

function ZpaxPanelReseller_CommonDisableEnableDelete($params = [], $funaction = '')
{
	$RequestFinal = [];
	$GlobalfunserviceID = $params['serviceid'];
	$configoptions = ZpaxPanelReseller_configfieldsofzpax();
	$currentFileName = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$trialconditionalarray = ['yes', 'no'];
	$productdetailsare = Illuminate\Database\Capsule\Manager::table('tblproducts')->where('id', $params['pid'])->get();
	$PanelID = $params['configoption2'];
	$Paneldata = ZpaxPanelReseller_paneldatabyid($PanelID);

	if (empty($Paneldata)) {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $PanelID, 'No panel data found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}

	$RequestFinal = $Paneldata;
	$RequestFinal['action'] = $funaction;
	$currentProducttype = (isset($params['configoption4']) && !empty($params['configoption4']) ? $params['configoption4'] : '');

	if ($currentProducttype == '') {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $productdetailsare, 'No product type (streamline or magdevice) found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}
	$common_identifier = (isset($configoptions['common_identifier']) && !empty($configoptions['common_identifier']) ? $configoptions['common_identifier'] : 'WHMCS:');
	$RequestFinal['requestdata']['description'] = $common_identifier . $params['serviceid'];

	if ($currentProducttype == 'streamlineonly') {
		$RequestFinal['product_type'] = 'streamlineonly';
		$RequestFinal['sublink'] = 'lines/' . $funaction;
		$username = $params['username'];
		$RequestFinal['requestdata']['username'] = $username;
		$responseforlogs = $api_result2 = ZpaxPanelReseller_CallApiRequest($RequestFinal);
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $RequestFinal, $responseforlogs);

		if ($api_result2['result'] == 'success') {
			return 'success';
		}
		else {
			return isset($api_result2['message']) && !empty($api_result2['message']) ? $api_result2['message'] : 'No Response from the server! Please check the logs for more details';
		}
	}
	else if ($currentProducttype == 'magdevice') {
		$finalMagtoAdd = '';
		$MagCustomfield = (isset($configoptions['custom_field_mag']) && !empty($configoptions['custom_field_mag']) ? $configoptions['custom_field_mag'] : 'MAG Address');
		if (!empty($params['customfields'][$MagCustomfield]) && !empty($params['customfields'][$MagCustomfield])) {
			$finalMagtoAdd = $params['customfields'][$MagCustomfield];
		}

		if ($finalMagtoAdd == '') {
			return 'MAG Address field is reqiured!';
		}

		$RequestFinal['product_type'] = 'magdevice';
		$RequestFinal['sublink'] = 'lines/' . $funaction;
		$RequestFinal['requestdata']['mac'] = $finalMagtoAdd;
		$responseforlogs = $api_result2 = ZpaxPanelReseller_CallApiRequest($RequestFinal);
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $RequestFinal, $responseforlogs);

		if ($api_result2['result'] == 'success') {
			return 'success';
		}
		else {
			return isset($api_result2['message']) && !empty($api_result2['message']) ? $api_result2['message'] : 'No Response from the server! Please check the logs for more details';
		}
	}

	return 'success';
}

function ZpaxPanelReseller_ClientArea(array $params)
{
	$response = '';
	$returndata = [];
	$returndata = ZpaxPanelReseller_configfieldsofzpax();
	$RequestFinal = [];
	$GlobalfunserviceID = $params['serviceid'];
	$configoptions = ZpaxPanelReseller_configfieldsofzpax();
	$currentFileName = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$trialconditionalarray = ['yes', 'no'];
	$productdetailsare = Illuminate\Database\Capsule\Manager::table('tblproducts')->where('id', $params['pid'])->get();
	$PanelID = $params['configoption2'];
	$Paneldata = ZpaxPanelReseller_panelAlldatabyid($PanelID);

	if (empty($Paneldata)) {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $PanelID, 'No panel data found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}
	$portal_url = (isset($Paneldata['portallink']) && !empty($Paneldata['portallink']) ? $Paneldata['portallink'] : '');
	$RequestFinal = $Paneldata;
	$currentProducttype = (isset($params['configoption4']) && !empty($params['configoption4']) ? $params['configoption4'] : '');

	if ($currentProducttype == '') {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $productdetailsare, 'No product type (streamline or magdevice) found please check selected panel from product configuration');
		return 'Something went wrong Please contact administrator';
	}
	$common_identifier = (isset($configoptions['common_identifier']) && !empty($configoptions['common_identifier']) ? $configoptions['common_identifier'] : 'WHMCS:');
	$RequestFinal['requestdata']['description'] = $common_identifier . $params['serviceid'];
	$requestedAction = (isset($_REQUEST['customAction']) ? $_REQUEST['customAction'] : '');

	if ($currentProducttype == 'streamlineonly') {
		$otherdevicesconfig = ($params['configoption12'] == 'on' ? 'on' : '');

		if ($requestedAction == 'manage') {
			$access_outputdata = ['HLS' => 'm3u8', 'MPEGTS - Default' => 'ts', 'RTMP' => 'rtmp'];
			$templateFile = 'templates/manage.tpl';
		}
		else {
			$templateFile = 'templates/overview.tpl';
		}
		$variabledata = ['iptv_username' => $params['username'], 'iptv_password' => $params['password'], 'ServerHostName' => $portal_url, 'response' => $response, 'message' => isset($result) && !empty($result) ? $result : $response, 'lang' => $returndata, 'otherdevicesconfig' => $otherdevicesconfig, 'm3ulink' => $params['configoption10'], 'watchstream' => $params['configoption11'], 'mag_portal' => $portal_url, 'usefulErrorHelper' => isset($error) && !empty($error) ? $error : '', 'accessoutput' => $access_outputdata, 'outputfirst' => 'ts', 'm3ulinkoutput' => 'ts', 'sitekey' => '', 'status' => $params['status'], 'showrefreshbtn' => 'no', 'refreshandrenew' => '0', 'checkcaptcha' => ''];
	}
	else if ($currentProducttype == 'magdevice') {
		$templateFile = 'templates/magtemplateSingle.tpl';
		$magdevice = (isset($magdata) && !empty($magdata) ? $magdata : $params['customfields'][$returndata['custom_field_mag']]);
		$variabledata = ['ServerHostName' => $portal_url, 'mag' => $magdevice, 'response' => $response, 'message' => isset($result) && !empty($result) ? $result : $response, 'lang' => $returndata, 'engma' => 'no', 'mag_portal' => $portal_url, 'status' => $params['status']];
		$variabledata['showrefreshbtn'] = 'no';
		$variabledata['checkcaptcha'] = '';
		$variabledata['sitekey'] = '';
	}

	try {
		return ['tabOverviewReplacementTemplate' => $templateFile, 'templateVariables' => $variabledata];
	}
	catch (Exception $e) {
		logModuleCall('xtreamCode', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
		return [
			'tabOverviewReplacementTemplate' => 'error.tpl',
			'templateVariables'              => ['usefulErrorHelper' => $e->getMessage()]
		];
	}
}

function ZpaxPanelReseller_CallApiRequest($Rqparams)
{
	$action = (isset($Rqparams['action']) && !empty($Rqparams['action']) ? $Rqparams['action'] : '');
	$cmslink = (isset($Rqparams['cmslink']) && !empty($Rqparams['cmslink']) ? $Rqparams['cmslink'] : '');
	$bar = '/';

	if (substr($cmslink, -1) == '/') {
		$bar = '';
	}

	$cmslink = $cmslink . $bar;
	$sublink = (isset($Rqparams['sublink']) && !empty($Rqparams['sublink']) ? $Rqparams['sublink'] : '');
	$resellerusername = (isset($Rqparams['username']) && !empty($Rqparams['username']) ? $Rqparams['username'] : '');
	$resellerpassword = (isset($Rqparams['password']) && !empty($Rqparams['password']) ? $Rqparams['password'] : '');
	$token = '';
	$cookie_path = dirname(__FILE__) . '/cookie.txt';
	$commoninit = $ch = curl_init($cmslink);
	curl_setopt($ch, CURLOPT_URL, $cmslink);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$tokenrequest = curl_exec($ch);
	$dom = new DOMDocument();
	@$dom->loadHTML($tokenrequest);
	$tags = $dom->getElementsByTagName('input');

	for ($i = 0; $i < $tags->length; $i++) {
		$grab = $tags->item($i);

		if ($grab->getAttribute('name') == '_token') {
			$token = $grab->getAttribute('value');
			break;
		}
	}

	$HearderToken = '';
	$tagsP = $dom->getElementsByTagName('meta');

	for ($i = 0; $i < $tagsP->length; $i++) {
		$grabP = $tagsP->item($i);

		if ($grabP->getAttribute('name') == 'csrf-token') {
			$HearderToken = $grabP->getAttribute('content');
		}
	}

	if ($token == '') {
		logModuleCall('ZpaxPanelReseller', __FUNCTION__, $Rqparams, 'No token found please concern with the provider');
		return ['result' => 'error', 'message' => 'Something went wrong Please contact administrator'];
	}

	$postdata = ['_token' => $token, 'username' => $resellerusername, 'password' => $resellerpassword];

	if ($action == 'getresellerdetails') {
		$returnData = [];
		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$resellerData = curl_exec($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($resellerData);
		$CreditsAre = '';
		$tags = $dom->getElementsByTagName('small');

		for ($i = 0; $i < $tags->length; $i++) {
			$grab = $tags->item($i);

			if (preg_match(strtoupper('/Credits/'), strtoupper($grab->textContent))) {
				$Cdata = explode(':', $grab->textContent);
				$CreditsAre = (isset($Cdata[1]) && !empty($Cdata[1]) ? trim($Cdata[1]) : '');
			}
		}

		$returnData['credits'] = $CreditsAre;
		return $returnData;
	}
	else if ($action == 'getpackagedata') {
		$endsublink = (isset($Rqparams['endsublink']) && !empty($Rqparams['endsublink']) ? $Rqparams['endsublink'] : 'yes');
		$linetype = (isset($Rqparams['linetype']) && !empty($Rqparams['linetype']) ? $Rqparams['linetype'] : 'yes');
		$linktoget = ($linetype == 'yes' ? '1' : '0');
		$returnData = [];
		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret2 = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink . '/create-new/' . $linktoget . '/' . $endsublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret4 = curl_exec($ch);
		$info = curl_getinfo($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($ret4);
		$packages = [];
		$select = $dom->getElementsByTagName('select');

		for ($i = 0; $i < $select->length; $i++) {
			$selectgrab = $select->item($i);

			if ($selectgrab->getAttribute('name') == 'package') {
				$optionTags = $selectgrab->getElementsByTagName('option');

				if (0 < $optionTags->length) {
					for ($i = 0; $i < $optionTags->length; $i++) {
						$packages[$optionTags->item($i)->getAttribute('value')] = $optionTags->item($i)->nodeValue;
					}
				}
			}
		}

		$returnData = $packages;
		return $returnData;
	}
	else if ($action == 'getBouquet') {
		$boquetsArray = [];
		$packageIId = $Rqparams['package_id'];
		$trial = $Rqparams['trial'];
		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret2 = curl_exec($ch);
		$boquetsData = ['package_id' => $packageIId, 'trial' => $trial];
		curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $boquetsData);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$headers = [];
		$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
		$headers[] = 'X-Requested-With:XMLHttpRequest';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$boquets = curl_exec($ch);
		$jsonBoquets = json_decode($boquets);
		$allBoquetsData = $jsonBoquets->bouquets;

		foreach ($allBoquetsData as $value) {
			$boquetsArray[$value->id] = $value->bouquet_name;
		}

		return $boquetsArray;
	}
	else if ($action == 'add_user') {
		$producttpe = $Rqparams['product_type'];
		$returnData = [];
		$returnData['result'] = 'error';
		$returnData['message'] = 'No respone from the server side..';
		$searchdata = [];
		$searchsublink = '';

		if ($producttpe == 'streamlineonly') {
			$searchsublink = 'lines/data';
			$RequestInac = $Rqparams['requestdata'];
			$datatosearch = (isset($RequestInac['username']) && !empty($RequestInac['username']) ? $RequestInac['username'] : $RequestInac['description']);
			$searchdata = ZpaxPanelReseller_getSearchingArrayStreamline($datatosearch, 'streamlineonly');
		}
		else if ($producttpe == 'magdevice') {
			$searchsublink = 'mags/data';
			$RequestInac = $Rqparams['requestdata'];
			$datatosearch = $RequestInac['description'];
			$searchdata = ZpaxPanelReseller_getSearchingArray($datatosearch, 'magdevice');
		}

		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret2 = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . $searchsublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $searchdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$headers = [];
		$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
		$headers[] = 'X-Requested-With:XMLHttpRequest';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$search = curl_exec($ch);
		$jsonSearch = json_decode($search);

		if (!empty($jsonSearch->data)) {
			$returnData['result'] = 'error';
			$returnData['message'] = $datatosearch . ' is already in use';
			return $returnData;
		}

		$AddLinetoken = '';
		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret2 = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . 'lines');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret3 = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret4 = curl_exec($ch);
		$info = curl_getinfo($ch);
		$dom = new DOMDocument();
		@$dom->loadHTML($ret4);
		$categories = [];
		$tags = $dom->getElementsByTagName('input');

		for ($i = 0; $i < $tags->length; $i++) {
			$grab = $tags->item($i);

			if ($grab->getAttribute('name') == '_token') {
				$AddLinetoken = $grab->getAttribute('value');
			}
		}

		$RequestInac['_token'] = $AddLinetoken;
		curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $RequestInac);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$addLine = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . $searchsublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $searchdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$headers = [];
		$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
		$headers[] = 'X-Requested-With:XMLHttpRequest';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$search = curl_exec($ch);
		$jsonSearch = json_decode($search);

		if (!empty($jsonSearch->data)) {
			$lineData = $jsonSearch->data;

			if ($producttpe == 'streamlineonly') {
				$returnData['result'] = 'success';
				$returnData['username'] = (isset($lineData[0]->username) && !empty($lineData[0]->username) ? $lineData[0]->username : '');
				$returnData['password'] = (isset($lineData[0]->password) && !empty($lineData[0]->password) ? $lineData[0]->password : '');
				$returnData['expire_date'] = (isset($lineData[0]->expire_date) && !empty($lineData[0]->expire_date) ? $lineData[0]->expire_date : '');
				$returnData['exp_date'] = (isset($lineData[0]->exp_date) && !empty($lineData[0]->exp_date) ? $lineData[0]->exp_date : '');
				$returnData['message'] = $datatosearch . ' username created successfully';
			}
			else if ($producttpe == 'magdevice') {
				$returnData['result'] = 'success';
				$returnData['mac'] = (isset($lineData[0]->mac) && !empty($lineData[0]->mac) ? base64_decode($lineData[0]->mac) : '');
				$returnData['expire_date'] = (isset($lineData[0]->expire_date) && !empty($lineData[0]->expire_date) ? $lineData[0]->expire_date : '');
				$returnData['exp_date'] = (isset($lineData[0]->exp_date) && !empty($lineData[0]->exp_date) ? $lineData[0]->exp_date : '');
				$returnData['message'] = $datatosearch . ' username created successfully';
			}

			return $returnData;
		}
		else {
			if ($producttpe == 'streamlineonly') {
				$returnData['result'] = 'error';
				$returnData['message'] = $datatosearch . ' Unable to create user';
			}
			else if ($producttpe == 'magdevice') {
				$returnData['result'] = 'error';
				$returnData['message'] = $datatosearch . ' Unable to create Mac';
			}

			return $returnData;
		}

		return $returnData;
	}
	else if (($action == 'disable') || ($action == 'enable') || ($action == 'delete')) {
		$producttpe = $Rqparams['product_type'];
		$returnData = [];
		$returnData['result'] = 'error';
		$returnData['message'] = 'No respone from the server side..';
		$searchdata = [];
		$searchsublink = '';

		if ($producttpe == 'streamlineonly') {
			$searchsublink = 'lines/data';
			$RequestInac = $Rqparams['requestdata'];
			$datatosearch = $RequestInac['username'];
			$searchdata = ZpaxPanelReseller_getSearchingArrayStreamline($datatosearch, 'streamlineonly');
		}
		else if ($producttpe == 'magdevice') {
			$searchsublink = 'mags/data';
			$RequestInac = $Rqparams['requestdata'];
			$datatosearch = $RequestInac['description'];
			$searchdata = ZpaxPanelReseller_getSearchingArray($datatosearch, 'magdevice');
		}

		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret2 = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . $searchsublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $searchdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$headers = [];
		$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
		$headers[] = 'X-Requested-With:XMLHttpRequest';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$search = curl_exec($ch);
		$jsonSearch = json_decode($search);

		if (!empty($jsonSearch->data)) {
			$lineData = $jsonSearch->data;
			$idforaction = (isset($lineData[0]->id) && !empty($lineData[0]->id) ? $lineData[0]->id : '');

			if ($idforaction != '') {
				curl_setopt($ch, CURLOPT_URL, $cmslink);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_COOKIESESSION, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$ret2 = curl_exec($ch);
				curl_setopt($ch, CURLOPT_URL, $cmslink . 'lines');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$ret3 = curl_exec($ch);
				curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink . '/' . $idforaction);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_COOKIESESSION, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$headers = [];
				$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
				$headers[] = 'X-Requested-With:XMLHttpRequest';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$disable = curl_exec($ch);

				if ($disable == 'true') {
					$returnData['result'] = 'success';
					$returnData['message'] = $action . ' successfully';
					return $returnData;
				}
				else {
					$returnData['result'] = 'error';
					$returnData['message'] = 'Unable to ' . $action;
					return $returnData;
				}
			}
			else {
				$returnData['result'] = 'error';
				$returnData['message'] = $datatosearch . ' not found';
				return $returnData;
			}
		}
		else {
			$returnData['result'] = 'error';
			$returnData['message'] = $datatosearch . ' not found';
			return $returnData;
		}

		return $returnData;
	}
	else if ($action == 'extend') {
		$producttpe = $Rqparams['product_type'];
		$returnData = [];
		$returnData['result'] = 'error';
		$returnData['message'] = 'No respone from the server side..';
		$searchdata = [];
		$searchsublink = '';

		if ($producttpe == 'streamlineonly') {
			$searchsublink = 'lines/data';
			$RequestInac = $Rqparams['requestdata'];
			$datatosearch = $RequestInac['username'];
			$searchdata = ZpaxPanelReseller_getSearchingArrayStreamline($datatosearch, 'streamlineonly');
			unset($RequestInac['username']);
		}
		else if ($producttpe == 'magdevice') {
			$searchsublink = 'mags/data';
			$RequestInac = $Rqparams['requestdata'];
			$datatosearch = $RequestInac['description'];
			$searchdata = ZpaxPanelReseller_getSearchingArray($datatosearch, 'magdevice');
			unset($RequestInac['mac']);
		}

		curl_setopt($ch, CURLOPT_URL, $cmslink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$ret2 = curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $cmslink . $searchsublink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $searchdata);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$headers = [];
		$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
		$headers[] = 'X-Requested-With:XMLHttpRequest';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$search = curl_exec($ch);
		$jsonSearch = json_decode($search);

		if (!empty($jsonSearch->data)) {
			$lineData = $jsonSearch->data;
			$idforaction = (isset($lineData[0]->id) && !empty($lineData[0]->id) ? $lineData[0]->id : '');
			$ExpiredoldDate = (isset($lineData[0]->expire_date) && !empty($lineData[0]->expire_date) ? $lineData[0]->expire_date : '');

			if ($idforaction != '') {
				$extendToken = '';
				curl_setopt($ch, CURLOPT_URL, $cmslink);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_COOKIESESSION, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$ret2 = curl_exec($ch);
				curl_setopt($ch, CURLOPT_URL, $cmslink . 'lines');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$ret3 = curl_exec($ch);
				curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink . '/' . $idforaction);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_COOKIESESSION, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$extendPage = curl_exec($ch);
				$info = curl_getinfo($ch);
				$dom = new DOMDocument();
				@$dom->loadHTML($extendPage);
				$tagsextendPage = $dom->getElementsByTagName('input');

				for ($i = 0; $i < $tagsextendPage->length; $i++) {
					$grabextendPage = $tagsextendPage->item($i);

					if ($grabextendPage->getAttribute('name') == '_token') {
						$extendToken = $grabextendPage->getAttribute('value');
					}
				}

				$RequestInac['_token'] = $extendToken;
				curl_setopt($ch, CURLOPT_URL, $cmslink . $sublink . '/' . $idforaction);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $RequestInac);
				curl_setopt($ch, CURLOPT_COOKIESESSION, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$extend = curl_exec($ch);
				curl_setopt($ch, CURLOPT_URL, $cmslink . $searchsublink);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $searchdata);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
				curl_setopt($ch, CURLOPT_COOKIESESSION, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				$headers = [];
				$headers[] = 'X-CSRF-TOKEN:' . $HearderToken;
				$headers[] = 'X-Requested-With:XMLHttpRequest';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$search = curl_exec($ch);
				$jsonSearch = json_decode($search);

				if (!empty($jsonSearch->data)) {
					$lineData = $jsonSearch->data;
					$NewDate = (isset($lineData[0]->expire_date) && !empty($lineData[0]->expire_date) ? $lineData[0]->expire_date : '');

					if ($ExpiredoldDate < $NewDate) {
						$returnData['result'] = 'success';
						$returnData['message'] = 'Service extended successfully';
						$returnData['newexpiredate'] = $NewDate;
						$returnData['expire_date'] = $NewDate;
						return $returnData;
					}
					else {
						$returnData['result'] = 'error';
						$returnData['message'] = 'Unable to extend';
						return $returnData;
					}
				}
				else {
					$returnData['result'] = 'error';
					$returnData['message'] = 'Unable to extend';
					return $returnData;
				}
			}
			else {
				$returnData['result'] = 'error';
				$returnData['message'] = $datatosearch . ' not found';
				return $returnData;
			}
		}
		else {
			$returnData['result'] = 'error';
			$returnData['message'] = $datatosearch . ' not found';
			return $returnData;
		}

		return $returnData;
	}
}

function ZpaxPanelReseller_CheckLicenseByKey()
{
	$result = Illuminate\Database\Capsule\Manager::table('tbladdonmodules')->where('module', '=', 'ZpaxResllerDashbord')->get();

	foreach ($result as $row) {
		$settings[$row->setting] = $row->value;
	}

	if ($settings['license']) {
		$localkey = $settings['localkey'];
		$result = ZpaxPanelReseller_CheckLicense($settings['license'], $localkey);
		$result['licensekey'] = $settings['license'];
	}
	else {
		$result['status'] = 'licensekeynotfound';
	}

	return $result;
}

function ZpaxPanelReseller_CheckLicense($licensekey, $localkey = '')
{
    $results["status"] = "Active";
    return $results;
}
function ZapxResellerPanel_encrypt($q, $salt = 'WHMCSSMARTERS')
{
	$string = $q;
	$output = false;
	$encrypt_method = 'AES-256-CBC';
	$secret_key = $salt;
	$secret_iv = $salt;
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	$output = base64_encode($output);
	return $output;
}

function ZapxResellerPanel_decrypt($q, $salt = 'WHMCSSMARTERS')
{
	$string = $q;
	$output = false;
	$encrypt_method = 'AES-256-CBC';
	$secret_key = $salt;
	$secret_iv = $salt;
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	$key = hash('sha256', $secret_key);
	$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	return $output;
}

function ZpaxPanelReseller_getsalt()
{
	$getSalt = Illuminate\Database\Capsule\Manager::table('tbladdonmodules')->where('module', '=', 'ZpaxResllerDashbord')->where('setting', '=', 'securitysalt')->get();
	$defaultsalt = 'WHMCSSMARTERSVALE';

	if (!empty($getSalt)) {
		$defaultsalt = (isset($getSalt[0]->value) && !empty($getSalt[0]->value) ? $getSalt[0]->value : $defaultsalt);
	}

	return $defaultsalt;
}

function ZpaxPanelReseller_paneldatabyid($id = '')
{
	$return = [];

	if ($id != '') {
		$PanelPanelData = Illuminate\Database\Capsule\Manager::table('mod_ZRDpanelsdetails')->where('id', '=', $id)->get();

		if (!empty($PanelPanelData)) {
			$defaultsalt = zpaxpanelreseller_getsalt();
			$cmslink = (isset($PanelPanelData[0]->cmslink) && !empty($PanelPanelData[0]->cmslink) ? $PanelPanelData[0]->cmslink : '');
			$username = (isset($PanelPanelData[0]->username) && !empty($PanelPanelData[0]->username) ? $PanelPanelData[0]->username : '');
			$encpassword = (isset($PanelPanelData[0]->password) && !empty($PanelPanelData[0]->password) ? $PanelPanelData[0]->password : '');
			$Orignalpassword = zapxresellerpanel_decrypt($encpassword, $defaultsalt);
			$return['cmslink'] = $cmslink;
			$return['username'] = $username;
			$return['password'] = $Orignalpassword;
		}
	}

	return $return;
}

function ZpaxPanelReseller_panelAlldatabyid($id = '')
{
	$return = [];

	if ($id != '') {
		$PanelPanelData = Illuminate\Database\Capsule\Manager::table('mod_ZRDpanelsdetails')->where('id', '=', $id)->get();

		if (!empty($PanelPanelData)) {
			$defaultsalt = zpaxpanelreseller_getsalt();
			$cmslink = (isset($PanelPanelData[0]->cmslink) && !empty($PanelPanelData[0]->cmslink) ? $PanelPanelData[0]->cmslink : '');
			$username = (isset($PanelPanelData[0]->username) && !empty($PanelPanelData[0]->username) ? $PanelPanelData[0]->username : '');
			$portallink = (isset($PanelPanelData[0]->portallink) && !empty($PanelPanelData[0]->portallink) ? $PanelPanelData[0]->portallink : '');
			$encpassword = (isset($PanelPanelData[0]->password) && !empty($PanelPanelData[0]->password) ? $PanelPanelData[0]->password : '');
			$Orignalpassword = zapxresellerpanel_decrypt($encpassword, $defaultsalt);
			$return['cmslink'] = $cmslink;
			$return['username'] = $username;
			$return['password'] = $Orignalpassword;
			$return['portallink'] = $portallink;
		}
	}

	return $return;
}

function ZpaxPanelReseller_generate_ran($length = 9, $add_dashes = false, $available_sets = 'lud')
{
	$sets = [];

	if (strpos($available_sets, 'l') !== false) {
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	}

	if (strpos($available_sets, 'u') !== false) {
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	}

	if (strpos($available_sets, 'd') !== false) {
		$sets[] = '23456789';
	}

	$all = '';
	$password = '';

	foreach ($sets as $set) {
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}

	$all = str_split($all);

	for ($i = 0; $i < ($length - count($sets)); $i++) {
		$password .= $all[array_rand($all)];
	}

	$password = str_shuffle($password);

	if (!$add_dashes) {
		return $password;
	}

	$dash_len = floor(sqrt($length));
	$dash_str = '';

	while ($dash_len < strlen($password)) {
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}

	$dash_str .= $password;
	return $dash_str;
}

function ZpaxPanelReseller_configfieldsofzpax()
{
	$configreturn = [];
	$ZapxConfig = Illuminate\Database\Capsule\Manager::table('mod_ZRDconfig')->get();
	if (isset($ZapxConfig) && !empty($ZapxConfig)) {
		foreach ($ZapxConfig as $config) {
			$configreturn[$config->setting] = $config->value;
		}
	}

	return $configreturn;
}

function ZpaxPanelReseller_getSearchingArray($Tosearch = '', $typei = 'streamlineonly')
{
	$datavala = 'username';

	if ($typei = 'magdevice') {
		$datavala = 'mac2';
	}

	$newdata = [];
	$newdata[0] = ['data' => 'id', 'name' => 'users.id', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[1] = ['data' => 'online', 'name' => 'user_activity_now.activity_id', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[2] = ['data' => $datavala, 'name' => 'mag_devices.mac', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[3] = ['data' => 'exp_date_show', 'name' => 'users.exp_date', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[4] = ['data' => 'expired', 'name' => 'users.exp_date', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[5] = ['data' => 'stb_type', 'name' => 'mag_devices.stb_type', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[6] = ['data' => 'admin_notes_show', 'name' => 'users.reseller_notes', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[7] = ['data' => 'speed', 'name' => 'speed', 'searchable' => 'false', 'orderable' => 'false'];
	$newdata[8] = ['data' => 'connections', 'name' => 'active_connections', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[9] = ['data' => 'display_name', 'name' => 'streams.stream_display_name', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[10] = ['data' => 'watch_ip_show', 'name' => 'user_activity_now.user_ip', 'searchable' => 'false', 'orderable' => 'false'];
	$newdata[11] = ['data' => 'isp_desc_show', 'name' => 'isp_desc', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[12] = ['data' => 'owner', 'name' => 'reg_users.username', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[13] = ['data' => 'created_at', 'name' => 'created_at', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[14] = ['data' => 'action', 'name' => 'action', 'searchable' => 'false', 'orderable' => 'false'];
	$NewPostData = [];
	$NewPostData['draw'] = '1';

	for ($i = 0; $i <= 14; $i++) {
		$NewPostData['columns[' . $i . '][data]'] = $newdata[$i]['data'];
		$NewPostData['columns[' . $i . '][name]'] = $newdata[$i]['name'];
		$NewPostData['columns[' . $i . '][searchable]'] = $newdata[$i]['searchable'];
		$NewPostData['columns[' . $i . '][orderable]'] = $newdata[$i]['orderable'];
		$NewPostData['columns[' . $i . '][search][value]'] = '';
		$NewPostData['columns[' . $i . '][search][regex]'] = 'false';
	}

	$NewPostData['order[0][column]'] = '0';
	$NewPostData['order[0][dir]'] = 'desc';
	$NewPostData['start'] = '0';
	$NewPostData['length'] = '-1';
	$NewPostData['search[value]'] = $Tosearch;
	$NewPostData['search[regex]'] = 'false';
	$NewPostData['filter'] = '';
	$NewPostData['user'] = '';
	return $NewPostData;
}

function ZpaxPanelReseller_getSearchingArrayStreamline($Tosearch = '', $typei = 'streamlineonly')
{
	$datavala = 'username';

	if ($typei == 'magdevice') {
		$datavala = 'mac2';
	}

	$newdata = [];
	$newdata[0] = ['data' => 'id', 'name' => 'id', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[1] = ['data' => 'online', 'name' => 'user_activity_now.activity_id', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[2] = ['data' => $datavala, 'name' => 'username', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[3] = ['data' => 'password', 'name' => 'password', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[4] = ['data' => 'exp_date_show', 'name' => 'users.exp_date', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[5] = ['data' => 'expired', 'name' => 'expire_date', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[6] = ['data' => 'admin_notes_show', 'name' => 'reseller_notes', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[7] = ['data' => 'speed', 'name' => 'speed', 'searchable' => 'false', 'orderable' => 'false'];
	$newdata[8] = ['data' => 'connections', 'name' => 'active_connections', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[9] = ['data' => 'display_name', 'name' => 'streams.stream_display_name', 'searchable' => 'true', 'orderable' => 'true'];
	$newdata[10] = ['data' => 'watch_ip_show', 'name' => 'user_activity_now.user_ip', 'searchable' => 'false', 'orderable' => 'false'];
	$newdata[11] = ['data' => 'isp_desc_show', 'name' => 'isp_desc', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[12] = ['data' => 'owner', 'name' => 'reg_users.username', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[13] = ['data' => 'created_at', 'name' => 'created_at', 'searchable' => 'false', 'orderable' => 'true'];
	$newdata[14] = ['data' => 'action', 'name' => 'action', 'searchable' => 'false', 'orderable' => 'false'];
	$NewPostData = [];
	$NewPostData['draw'] = '1';

	for ($i = 0; $i <= 14; $i++) {
		$NewPostData['columns[' . $i . '][data]'] = $newdata[$i]['data'];
		$NewPostData['columns[' . $i . '][name]'] = $newdata[$i]['name'];
		$NewPostData['columns[' . $i . '][searchable]'] = $newdata[$i]['searchable'];
		$NewPostData['columns[' . $i . '][orderable]'] = $newdata[$i]['orderable'];
		$NewPostData['columns[' . $i . '][search][value]'] = '';
		$NewPostData['columns[' . $i . '][search][regex]'] = 'false';
	}

	$NewPostData['order[0][column]'] = '0';
	$NewPostData['order[0][dir]'] = 'desc';
	$NewPostData['start'] = '0';
	$NewPostData['length'] = '50';
	$NewPostData['search[value]'] = $Tosearch;
	$NewPostData['search[regex]'] = 'false';
	$NewPostData['filter'] = '';
	$NewPostData['user'] = '';
	return $NewPostData;
}

if (!defined('WHMCS')) {
	exit('This file cannot be accessed directly');
}

require_once 'hooks.php';

?>