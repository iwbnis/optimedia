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

function SRXtreamUIPanelCheckMAGexists($params)
{
	$cart = $_SESSION['cart'];

	foreach ($cart['products'] as $product) {
		$servers = WHMCS\Database\Capsule::table('tblproducts')->join('tblservergroupsrel', 'tblproducts.servergroup', '=', 'tblservergroupsrel.groupid')->join('tblservers', 'tblservergroupsrel.serverid', '=', 'tblservers.id')->where('tblproducts.id', '=', $product['pid'])->select('tblservers.*')->get();
		$xtreamConfig = WHMCS\Database\Capsule::table('xtreamuserpanel_Config')->get();
		$returndata = [];
		if (isset($xtreamConfig) && !empty($xtreamConfig)) {
			foreach ($xtreamConfig as $config) {
				$returndata[$config->setting] = $config->value;
			}
		}

		foreach ($servers as $server) {
			$sqlusername = $server->username;
			$sqlpassword = decrypt($server->password);
			$sqldbname = $server->accesshash;
			list($sqlhost, $sqlport) = explode(':', $server->ipaddress);
		}
	}
}

if (!defined('WHMCS')) {
	exit('This file cannot be accessed directly');
}

add_hook('ClientLogout', 1, function($vars) {
	unset($_SESSION['xtreamuserid']);
	unset($_SESSION['xtreampasswordhash']);
});
add_hook('EmailPreSend', 1, function($vars) {
	$merge_fields = [];
	$GettingPortalLInkDatra = WHMCS\Database\Capsule::table('tblhosting')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where('tblhosting.id', '=', $vars['relid'])->select('tblproducts.*', 'tblhosting.id as serviceid')->get();

	if (!empty($GettingPortalLInkDatra)) {
		if (($GettingPortalLInkDatra[0]->servertype == 'xtreamUIpanel') && ($GettingPortalLInkDatra[0]->configoption12 != '')) {
			$merge_fields['portal_url'] = $GettingPortalLInkDatra[0]->configoption12;
			$merge_fields['service_server_hostname'] = $GettingPortalLInkDatra[0]->configoption12;
			return $merge_fields;
		}
	}
});

?>