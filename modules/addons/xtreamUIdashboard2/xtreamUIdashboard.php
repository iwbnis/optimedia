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

function xtreamUIdashboard_config()
{
	$configarray = [
		'name'        => 'xtream UI Reseller Panel',
		'description' => 'The module provide the  Xtream Codes UI User Management.',
		'author'      => '<a href="https://www.atoznull.net/" target="_blank"><img src="https://whmcs.atoznull.com/assets/img/logo.png"></a>',
		'language'    => 'english',
		'version'     => '1.1',
		'fields'      => [
			'licenseregto'   => ['FriendlyName' => 'License Registered To', 'Description' => 'Not Available'],
			'licenseregmail' => ['FriendlyName' => 'License Registered Email', 'Description' => 'Not Available'],
			'licenseduedate' => ['FriendlyName' => 'License Due Date', 'Description' => 'Not Available'],
			'licensestatus'  => ['FriendlyName' => 'License Status', 'Description' => 'Not Available'],
			'license'        => ['FriendlyName' => 'License', 'Type' => 'text', 'Size' => '35'],
			'deletetables'   => ['FriendlyName' => 'Delete Records', 'Type' => 'yesno', 'Size' => '25', 'Description' => 'Tick to check it should delete all the tables relative to this module on deactivation']
		]
	];
	$licenseinfo = xtreamUIdashboard_doCheckLicense();

	if ($licenseinfo['status'] != 'licensekeynotfound') {
		if (($licenseinfo['status'] == 'Active') && isset($licenseinfo['localkey']) && !empty($licenseinfo['localkey'])) {
			$moduledata = WHMCS\Database\Capsule::table('tbladdonmodules')->where('module', '=', 'xtreamUIdashboard')->where('setting', '=', 'localkey')->get();
			if (isset($moduledata) && !empty($moduledata)) {
				WHMCS\Database\Capsule::table('tbladdonmodules')->where('setting', 'localkey')->where('module', 'xtreamUIdashboard')->update(['value' => $licenseinfo['localkey']]);
			}
			else {
				WHMCS\Database\Capsule::table('tbladdonmodules')->insert(['setting' => 'localkey', 'value' => $licenseinfo['localkey'], 'module' => 'xtreamUIdashboard']);
			}
		}

		if ($licenseinfo['registeredname']) {
			$configarray['fields']['licenseregto']['Description'] = $licenseinfo['registeredname'];
		}

		if ($licenseinfo['email']) {
			$configarray['fields']['licenseregmail']['Description'] = $licenseinfo['email'];
		}

		if ($licenseinfo['nextduedate']) {
			$configarray['fields']['licenseduedate']['Description'] = $licenseinfo['nextduedate'];
		}

		$configarray['fields']['licensestatus']['Description'] = $licenseinfo['status'];
		$configarray['fields']['license']['Value'] = $licenseinfo['licensekey'];
	}

	return $configarray;
}

function xtreamUIdashboard_doCheckLicense()
{
	$result = WHMCS\Database\Capsule::table('tbladdonmodules')->where('module', '=', 'xtreamUIdashboard')->get();

	foreach ($result as $row) {
		$settings[$row->setting] = $row->value;
	}

	if ($settings['license']) {
		$localkey = $settings['localkey'];
		$result = xtreamUIdashboard_checkLicense($settings['license'], $localkey);
		$result['licensekey'] = $settings['license'];
	}
	else {
		$result['status'] = 'licensekeynotfound';
	}

	return $result;
}

function xtreamUIdashboard_checkLicense($licensekey, $localkey = '')
{
	$whmcsurl = 'https://whmcs.atoznull.com/';
	$licensing_secret_key = 'resellerpanel';
	$localkeydays = 14;
	$allowcheckfaildays = 5;
	$check_token = time() . md5(mt_rand(1000000000, 9999999999.0) . $licensekey);
	$checkdate = date('Ymdhis');
	$domain = $_SERVER['SERVER_NAME'];
	$usersip = (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR']);
	$dirpath = dirname(__FILE__);
	$verifyfilepath = 'modules/servers/licensing/verify1.php';
	$localkeyvalid = false;

	if ($localkey) {
		$localkey = str_replace("\n", '', $localkey);
		$localdata = substr($localkey, 0, strlen($localkey) - 32);
		$md5hash = substr($localkey, strlen($localkey) - 32);

		if ($md5hash == md5($localdata . $licensing_secret_key)) {
			$localdata = strrev($localdata);
			$md5hash = substr($localdata, 0, 32);
			$localdata = substr($localdata, 32);
			$localdata = base64_decode($localdata);
			$localkeyresults = unserialize($localdata);
			$originalcheckdate = $localkeyresults['checkdate'];

			if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
				$localexpiry = date('Ymdhis', mktime(date('h'), date('i'), date('s'), date('m'), date('d') - $localkeydays, date('Y')));

				if ($localexpiry < $originalcheckdate) {
					$localkeyvalid = true;
					$results = $localkeyresults;
					$validdomains = explode(',', $results['validdomain']);

					if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
						$localkeyvalid = false;
						$localkeyresults['status'] = 'Invalid';
						$results = [];
					}

					$validips = explode(',', $results['validip']);

					if (!in_array($usersip, $validips)) {
						$localkeyvalid = false;
						$localkeyresults['status'] = 'Invalid';
						$results = [];
					}

					$validdirs = explode(',', $results['validdirectory']);

					if (!in_array($dirpath, $validdirs)) {
						$localkeyvalid = false;
						$localkeyresults['status'] = 'Invalid';
						$results = [];
					}
				}
			}
		}
	}

	if (!$localkeyvalid) {
		$responseCode = 0;
		$postfields = ['licensekey' => $licensekey, 'domain' => $domain, 'ip' => $usersip, 'dir' => $dirpath];

		if ($check_token) {
			$postfields['check_token'] = $check_token;
		}

		$query_string = '';

		foreach ($postfields as $k => $v) {
			$query_string .= $k . '=' . urlencode($v) . '&';
		}

		if (function_exists('curl_exec')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $whmcsurl . $verifyfilepath);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'AtoZ');
			$data = curl_exec($ch);
			$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
		}
		else {
			$responseCodePattern = '/^HTTP\\/\\d+\\.\\d+\\s+(\\d+)/';
			$fp = @fsockopen($whmcsurl, 80, $errno, $errstr, 5);

			if ($fp) {
				$newlinefeed = "\r\n";
				$header = 'POST ' . $whmcsurl . $verifyfilepath . ' HTTP/1.0' . $newlinefeed;
				$header .= 'Host: ' . $whmcsurl . $newlinefeed;
				$header .= 'Content-type: application/x-www-form-urlencoded' . $newlinefeed;
				$header .= 'Content-length: ' . @strlen($query_string) . $newlinefeed;
				$header .= 'Connection: close' . $newlinefeed . $newlinefeed;
				$header .= $query_string;
				$data = $line = '';
				@stream_set_timeout($fp, 20);
				@fputs($fp, $header);
				$status = @socket_get_status($fp);

				while (!@feof($fp) && $status) {
					$line = @fgets($fp, 1024);
					$patternMatches = [];
					if (!$responseCode && preg_match($responseCodePattern, trim($line), $patternMatches)) {
						$responseCode = (empty($patternMatches[1]) ? 0 : $patternMatches[1]);
					}

					$data .= $line;
					$status = @socket_get_status($fp);
				}

				@fclose($fp);
			}
		}

		if ($responseCode != 200) {
			$localexpiry = date('Ymdhis', mktime(date('h'), date('i'), date('s'), date('m'), date('d') - ($localkeydays + $allowcheckfaildays), date('Y')));

			if ($localexpiry < $originalcheckdate) {
				$results = $localkeyresults;
			}
			else {
				$results = [];
				$results['status'] = 'Invalid';
				$results['description'] = 'Remote Check Failed';
				return $results;
			}
		}
		else {
			preg_match_all('/<(.*?)>([^<]+)<\\/\\1>/i', $data, $matches);
			$results = [];

			foreach ($matches[1] as $k => $v) {
				$results[$v] = $matches[2][$k];
			}
		}

		if (!is_array($results)) {
			exit('Invalid License Server Response');
		}
		if ($results['md5hash'] && ($results['md5hash'] != md5($licensing_secret_key . $check_token))) {
			$results['status'] = 'Invalid';
			$results['description'] = 'MD5 Checksum Verification Failed';
			return $results;
		}

		if ($results['status'] == 'Active') {
			$results['checkdate'] = $checkdate;
			$data_encoded = serialize($results);
			$data_encoded = base64_encode($data_encoded);
			$data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
			$data_encoded = strrev($data_encoded);
			$data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
			$data_encoded = wordwrap($data_encoded, 80, "\n", true);
			$results['localkey'] = $data_encoded;
		}

		$results['remotecheck'] = true;
	}

	unset($postfields, $data, $matches, $whmcsurl, $licensing_secret_key, $checkdate, $usersip, $localkeydays, $allowcheckfaildays, $md5hash);
	return $results;
}

function xtreamUIdashboard_activate()
{
	try {
		if (!WHMCS\Database\Capsule::schema()->hasTable('mod_xtreamUIdashboardconfig')) {
			WHMCS\Database\Capsule::schema()->create('mod_xtreamUIdashboardconfig', function($table) {
				$table->string('setting');
				$table->string('value');
			});
			$configuration = ['custom_field_mag' => 'MAG Address', 'common_identifier' => 'WHMCS:', 'checkmagdevice' => 'MAG Device', 'iptv_service_details' => 'IPTV Service Details', 'devices' => 'Devices', 'back_to_overview' => 'Back to overview', 'product_service' => 'Product/Service', 'username' => 'Username', 'password' => 'Password', 'devices_desc' => 'You can manage your streaming devices here!', 'mag_desc' => 'MAG Box', 'current_mag' => 'Current', 'new_mag' => 'New', 'change_mag_button' => 'Change', 'add_mag_button' => 'Add new MAG device', 'other_devices' => 'Other Devices', 'autoscripts' => 'Auto-Scripts', 'stream_output' => 'Stream output:', 'dropdown_name' => 'Playlist/Script', 'dropdown_action' => 'Choose Device'];

			foreach ($configuration as $name => $value) {
				$configurationdata[] = ['setting' => $name, 'value' => $value];
			}

			WHMCS\Database\Capsule::table('mod_xtreamUIdashboardconfig')->delete();

			try {
				WHMCS\Database\Capsule::table('mod_xtreamUIdashboardconfig')->insert($configurationdata);
			}
			catch (Exception $e) {
				return ['status' => 'error', 'description' => $e->getMessage() . '. There is an error while activating this module'];
			}
		}

		if (!WHMCS\Database\Capsule::schema()->hasTable('mod_wsxtreamUIreseller_recaptchadata')) {
			WHMCS\Database\Capsule::schema()->create('mod_wsxtreamUIreseller_recaptchadata', function($table) {
				$table->increments('id');
				$table->text('orderid');
				$table->longText('recaptcha');
			});
		}

		$emailtemplates = WHMCS\Database\Capsule::table('tblemailtemplates')->get();
		$emailtemplatesreturn = [];
		if (isset($emailtemplates) && !empty($emailtemplates)) {
			foreach ($emailtemplates as $emailtemplate) {
				$emailtemplatesreturn[] = $emailtemplate->name;
			}
		}

		$emailtemplatesoption = array_diff(['IPTV Service Details'], $emailtemplatesreturn);

		foreach ($emailtemplatesoption as $emailvalue) {
			if ($emailvalue == 'IPTV Service Details') {
				$emailvaluedataoption[] = ['type' => 'product', 'name' => 'IPTV Service Details', 'subject' => 'Your IPTV Service Info', 'message' => '   ' . "\r\n\r\n" . '              <span style="font-size: small;">Dear {$client_name},</span><br /><span style="font-size: small;"><br />Thanks for buying our service.  Your service {$service_product_name} has now activated. </span><br /><span style="font-size: small;">Please use the following to details to use your service. </span><br /><br /><span style="font-size: small;"><strong>Your IPTV Service Details are:</strong> <br /></span><br /><span style="font-size: small;"><strong>Your Username :</strong> {$service_username}</span><br /><br /><span style="font-size: small;"><strong>Your Password  :</strong>  {$service_password}<br /><br /><strong>M3u Playlist URL :</strong> http://iptv.dguk.co.uk:80/get.php?username=<span>{$service_username}</span>&amp;password=<span>{$service_password}</span>&amp;type=m3u&amp;output=ts<br /><br /></span><span style="font-size: small;"><strong>M3u Plus Playlist URL :</strong> http://iptv.dguk.co.uk:80/get.php?username=<span>{$service_username}</span>&amp;password=<span>{$service_password}</span>&amp;type=m3u_plus&amp;output=ts</span><br /><br /><span style="font-size: small;"><span style="font-size: small;"><strong>Enigma2 OE 2.0 Auto Script :</strong> wget -O /etc/enigma2/iptv.sh "http://iptv.dguk.co.uk:80/get.php?username=<span>{$service_username}</span>&amp;password=<span>{$service_password}</span>&amp;type=enigma22_script&amp;output=ts" &amp;&amp; chmod 777 /etc/enigma2/iptv.sh &amp;&amp; /etc/enigma2/iptv.sh </span></span><span style="font-size: small;">&amp;&amp; cd /etc/enigma2/ &amp;&amp; cp iptv.sh /usr/script/ &amp;&amp; cd /usr/script/ &amp;&amp; chmod 775 iptv.sh</span>' . "\r\n" . '<p><span style="font-size: small;">Then on your box:</span></p>' . "\r\n" . '<p><span style="font-size: small;">Press Menu, Timers, Cron Timers.</span></p>' . "\r\n" . '<p><span style="font-size: small;">Green Button to "add"</span></p>' . "\r\n" . '<p><span style="font-size: small;">Run how often?: daily</span><br /><span style="font-size: small;">Time to execute Command or Script: 06:00 (your Preference of time)</span><br /><span style="font-size: small;">Command Type: Predefined</span><br /><span style="font-size: small;">Command To Run: iptv.sh</span></p>' . "\r\n" . '<p><span style="font-size: small;">Green Button to save.<br /><br /></span></p>' . "\r\n" . '<span style="font-size: small;"><strong>MAG Portal URL :</strong> http://{$service_server_hostname}:80/c</span><br /><br /><span style="font-size: small;"><span style="font-size: small;"><a href="{$company_domain}/clientarea.php?action=productdetails&amp;id={$service_id}" target="_blank">Get or Download your m3u Playlist here<br /><br /></a></span></span><hr />' . "\r\n" . '<p><span style="font-size: small;"><strong>Billing Info: </strong></span></p>' . "\r\n" . '<p><span style="font-size: small;">Product/Service: {$service_product_name}</span><br /><span style="font-size: small;">Payment Method: {$service_payment_method}</span><br /><span style="font-size: small;">Amount: {$service_recurring_amount}</span><br /><span style="font-size: small;">Billing Cycle: {$service_billing_cycle}</span><br /><span style="font-size: small;">Next Due Date: {$service_next_due_date}</span></p>' . "\r\n" . '<p><span style="font-size: small;">Thank you for choosing us.</span></p>' . "\r\n" . '<p><span style="font-size: small;">{$signature}</span></p>  ' . "\r\n\r\n" . '            ', 'disabled' => 0, 'custom' => 1, 'plaintext' => 0];
			}
		}
		if (isset($emailvaluedataoption) && !empty($emailvaluedataoption)) {
			WHMCS\Database\Capsule::table('tblemailtemplates')->insert($emailvaluedataoption);
		}
	}
	catch (Exception $e) {
		return ['status' => 'error', 'description' => $e->getMessage() . '. There is an error while activating this module'];
	}

	return ['status' => 'success', 'description' => 'Xtream Reseller Panel Dashboard Module Activated Successfully!'];
}

function xtreamUIdashboard_deactivate()
{
	$results = WHMCS\Database\Capsule::table('tbladdonmodules')->where('module', '=', 'xtreamUIdashboard')->get();

	foreach ($results as $row) {
		$settings[$row->setting] = $row->value;
	}
	if (isset($settings['deletetables']) && !empty($settings['deletetables']) && ($settings['deletetables'] == 'on')) {
		WHMCS\Database\Capsule::schema()->dropIfExists('mod_xtreamUIpanelconfig');

		if (WHMCS\Database\Capsule::schema()->hasTable('mod_wsxtreamUIreseller_recaptchadata')) {
			WHMCS\Database\Capsule::schema()->dropIfExists('mod_wsxtreamUIreseller_recaptchadata');
		}

		if (WHMCS\Database\Capsule::schema()->hasTable('mod_wsxtreamUIdashboarddetails')) {
			WHMCS\Database\Capsule::schema()->dropIfExists('mod_wsxtreamUIdashboarddetails');
		}

		if (WHMCS\Database\Capsule::schema()->hasTable('mod_wsxtreamUIreseller_recaptchadata')) {
			WHMCS\Database\Capsule::schema()->dropIfExists('mod_wsxtreamUIreseller_recaptchadata');
		}
	}

	return ['status' => 'success', 'description' => 'Xtream Coder Dashboard modules deactivated successfully!'];
}

function xtreamUIdashboard_output($vars)
{
	$modulelink = $vars['modulelink'];
	$version = $vars['version'];
	$_lang = $vars['_lang'];
	include_once 'xtreamtabs.php';
	$action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');
	$dispatcher = new AdminDispatcher2();
	$response = $dispatcher->dispatch($action, $vars);
	echo $response;
}

if (!defined('WHMCS')) {
	exit('This file cannot be accessed directly');
}

require_once __DIR__ . '/lib/Admin/AdminDispatcher2.php';
require_once __DIR__ . '/lib/Admin/Controller2.php';

?>