<?php

use WHMCS\Database\Capsule;
use WHMCS\Module\Addon\XUIPanelCustom\Admin\AdminDispatcher;
use WHMCS\Module\Addon\XUIPanelCustom\Client\ClientDispatcher;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly"); 
}
function XUIPanelCustom_config()
{
    $configarray = array(
        'name' => 'XUI ONE Panel',
        'description' => 'The module provide the Xui Reseller Dashboard User Management with Username/Password',
        'author' => '<a href="https://www.whmcssmarters.com/" target="_blank"><img src="../modules/addons/XUIPanelCustom/logo.png" style="width: 100%;"></a>',
        'language' => 'english',
        'version' => '1.0',
        "fields" => array(
            "licenseregto" => array(
                "FriendlyName" => "License Registered To",
                "Description" => "Not Available"
            ),
            "licenseregmail" => array(
                "FriendlyName" => "License Registered Email",
                "Description" => "Not Available"
            ),
            "licenseduedate" => array(
                "FriendlyName" => "License Due Date",
                "Description" => "Not Available"
            ),
            "licensestatus" => array(
                "FriendlyName" => "License Status",
                "Description" => "Not Available"
            ),
            "license" => array(
                "FriendlyName" => "License",
                "Type" => "text",
                "Size" => "35"
            ),
        )
    );
    $licenseinfo = XUIPanelCustom_doCheckLicense();
    if ($licenseinfo['status'] != 'licensekeynotfound') {
        if ($licenseinfo['status'] == 'Active') {
            if (isset($licenseinfo['localkey']) && !empty($licenseinfo['localkey'])) {
                $moduledata = Capsule::table('tbladdonmodules')
                    ->where('module', '=', 'XUIPanelCustom')
                    ->where('setting', '=', 'localkey')
                    ->count();
                if (isset($moduledata) && !empty($moduledata)) {
                    Capsule::table('tbladdonmodules')
                        ->where('setting', 'localkey')
                        ->where('module', 'XUIPanelCustom')
                        ->update(['value' => $licenseinfo['localkey']]);
                } else {
                    Capsule::table('tbladdonmodules')->insert(
                        ['setting' => 'localkey', 'value' => $licenseinfo['localkey'], 'module' => 'XUIPanelCustom']
                    );
                }
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

function XUIPanelCustom_doCheckLicense()
{
    $result = Capsule::table('tbladdonmodules')->where('module', '=', 'XUIPanelCustom')->get();
    foreach ($result as $row) {
        $settings[$row->setting] = $row->value;
    }
    if ($settings['license']) {
        $localkey = $settings['localkey'];
        $result = XUIPanelCustom_checkLicense($settings['license'], $localkey);
        $result['licensekey'] = $settings['license'];
    } else {
        $result['status'] = 'licensekeynotfound';
    }
    return $result;
}


function XUIPanelCustom_checkLicense($licensekey, $localkey = '')
{
     $results['status'] = 'Active';
	return $results;
	
	$whmcsurl = "";
    $licensing_secret_key = "XUIResellerOne";
    $localkeydays = 14;
    $allowcheckfaildays = 5;
    $check_token = time() . md5(mt_rand(1000000000, 9999999999) . $licensekey);
    $checkdate = date("Ymdhis");
    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(__FILE__);
  //  $verifyfilepath = 'modules/servers/licensing/verify.php';
    $localkeyvalid = false;
    if ($localkey) {
        $localkey = str_replace("\n", '', $localkey); # Remove the line breaks
        $localdata = substr($localkey, 0, strlen($localkey) - 32); # Extract License Data
        $md5hash = substr($localkey, strlen($localkey) - 32); # Extract MD5 Hash
        if ($md5hash == md5($localdata . $licensing_secret_key)) {
            $localdata = strrev($localdata); # Reverse the string
            $md5hash = substr($localdata, 0, 32); # Extract MD5 Hash
            $localdata = substr($localdata, 32); # Extract License Data
            $localdata = base64_decode($localdata);
            $localkeyresults = unserialize($localdata);
            $originalcheckdate = $localkeyresults['checkdate'];
            if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                $localexpiry = date("Ymdhis", mktime(date("h"), date("i"), date("s"), date("m"), date("d") - $localkeydays, date("Y")));
                if ($originalcheckdate > $localexpiry) {
                    $localkeyvalid = true;
                    $results = $localkeyresults;
                    $validdomains = explode(',', $results['validdomain']);
                    if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validips = explode(',', $results['validip']);
                    if (!in_array($usersip, $validips)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validdirs = explode(',', $results['validdirectory']);
                    if (!in_array($dirpath, $validdirs)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                }
            }
        }
    }
    if (!$localkeyvalid) {
        $responseCode = 0;
        $postfields = array(
            'licensekey' => $licensekey,
            'domain' => $domain,
            'ip' => $usersip,
            'dir' => $dirpath
        );
        if ($check_token)
            $postfields['check_token'] = $check_token;
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
            $data = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $responseCodePattern = '/^HTTP\/\d+\.\d+\s+(\d+)/';
            $fp = @fsockopen($whmcsurl, 80, $errno, $errstr, 5);
            if ($fp) {
                $newlinefeed = "\r\n";
                $header = "POST " . $whmcsurl . $verifyfilepath . " HTTP/1.0" . $newlinefeed;
                $header .= "Host: " . $whmcsurl . $newlinefeed;
                $header .= "Content-type: application/x-www-form-urlencoded" . $newlinefeed;
                $header .= "Content-length: " . @strlen($query_string) . $newlinefeed;
                $header .= "Connection: close" . $newlinefeed . $newlinefeed;
                $header .= $query_string;
                $data = $line = '';
                @stream_set_timeout($fp, 20);
                @fputs($fp, $header);
                $status = @socket_get_status($fp);
                while (!@feof($fp) && $status) {
                    $line = @fgets($fp, 1024);
                    $patternMatches = array();
                    if (!$responseCode && preg_match($responseCodePattern, trim($line), $patternMatches)) {
                        $responseCode = (empty($patternMatches[1])) ? 0 : $patternMatches[1];
                    }
                    $data .= $line;
                    $status = @socket_get_status($fp);
                }
                @fclose($fp);
            }
        }
        if ($responseCode != 200) {
            $localexpiry = date("Ymdhis", mktime(date("h"), date("i"), date("s"), date("m"), date("d") - ($localkeydays + $allowcheckfaildays), date("Y")));
            if ($originalcheckdate > $localexpiry) {
                $results = $localkeyresults;
            } else {
                $results = array();
                $results['status'] = "Invalid";
                $results['description'] = "Remote Check Failed";
                return $results;
            }
        } else {
            preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches);
            $results = array();
            foreach ($matches[1] as $k => $v) {
                $results[$v] = $matches[2][$k];
            }
        }
        if (!is_array($results)) {
            die("Invalid License Server Response");
        }
        if ($results['md5hash']) {
            if ($results['md5hash'] != md5($licensing_secret_key . $check_token)) {
                $results['status'] = "Invalid";
                $results['description'] = "MD5 Checksum Verification Failed";
                return $results;
            }
        }
        if ($results['status'] == "Active") {
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

function XUIPanelCustom_activate()
{
    try {
        if (!Capsule::schema()->hasTable('xui_settings')) {
            Capsule::schema()->create(
                'xui_settings',
                function ($table) {
                    $table->text('setting');
                    $table->text('value');
                }
            );
        }
        if (!Capsule::schema()->hasTable('xui_paneldetails')) {
            Capsule::schema()->create(
                'xui_paneldetails',
                function ($table) {
                    $table->increments('id');
                    $table->text('identifier');
                    $table->text('panel_link');
                    $table->text('username');
                    $table->text('password');
                    $table->text('mag_portal');
                    $table->text('m3uurl');
                    $table->text('watchstrmurl');
                }
            );
        }
        if (!Capsule::schema()->hasTable('xui_logs')) {
            Capsule::schema()->create(
                'xui_logs',
                function ($table) {
                    $table->increments('id');
                    $table->text('date');
                    $table->text('action');
                    $table->longText('request');
                    $table->longText('response');
                }
            );
        }
        if (!Capsule::schema()->hasTable('xui_cats')) {
            Capsule::schema()->create(
                'xui_cats',
                function ($table) {
                    $table->increments('id');
                    $table->text('cat_name');
                    $table->text('date');
                    $table->text('hidden');
                    $table->text('order');
                }
            );
        }
        if (!Capsule::schema()->hasTable('xtreamui_applinks')) {
            Capsule::schema()->create('xtreamui_applinks', function ($table) {
                $table->increments('id');
                $table->text('appname');
                $table->text('applink');
                $table->text('appfor');
            }
            );
        }
        if (!Capsule::schema()->hasTable('xui_cat_data')) {
            Capsule::schema()->create(
                'xui_cat_data',
                function ($table) {
                    $table->increments('id');
                    $table->text('productid');
                    $table->longText('packageid');
                    $table->longText('categories_data');
                    $table->longText('cat_data_clientarea');
                }
            );
        }
        $configuration = array(
            'common_identifier' => 'WHMCS: {$service_id}',
            'custom_field_mag' => 'MAG Address',
            'custom_field_username' => 'Username',
            'custom_field_password' => 'Password',
            'checkmagdevice' => 'MAG Device',
            'mac_not_valid' => 'This MAC address is not valid!',
            'mac_change_success' => 'MAG Box network address(MAC) is changed',
            'mac_add_success' => 'Added new MAG box with address:',
            'mac_error' => 'MAC Address already exists! Please contact support!',
            'iptv_service_details' => 'IPTV Service Details',
            'devices' => 'Devices',
            'back_to_overview' => 'Back to overview',
            'product_service' => 'Product/Service',
            'username' => 'Username',
            'password' => 'Password',
            'playlist' => 'M3U Playlist',
            'mag_portal' => 'MAG Portal',
            'devices_desc' => 'You can manage your streaming devices here!',
            'add_mag_button' => 'Add new MAG device',
            'mag_desc' => 'MAG Box',
            'enigma2_devices' => 'Enigma2 Device',
            'current_mag' => 'Current MAG device:',
            'new_mag' => 'New MAG device:',
            'change_mag_button' => 'Change',
            'other_devices' => 'Other Devices',
            'autoscripts' => 'Auto-Scripts',
            'stream_output' => 'Stream output:',
            'dropdown_name' => 'Playlist/Script',
            'dropdown_action' => 'Choose Device',
            'creditapply' => 'on',
        );
        foreach ($configuration as $name => $value) {
            $configurationdata[] = array(
                'setting' => $name,
                'value' => $value
            );
        }
        Capsule::table('xui_settings')->delete();
        Capsule::table('xui_settings')->insert($configurationdata);

        $emailtemplates = Capsule::table('tblemailtemplates')->get();
        $emailtemplatesreturn = array();
        if (isset($emailtemplates) && !empty($emailtemplates)) {
            foreach ($emailtemplates as $emailtemplate) {
                $emailtemplatesreturn[] = $emailtemplate->name;
            }
        }
        $emailtemplatesoption = array_diff(array('IPTV Service Details', 'IPTV MAG Service Details', 'IPTV Reseller Credits Email', 'IPTV Reseller Email'), $emailtemplatesreturn);

        foreach ($emailtemplatesoption as $emailvalue) {
            if ($emailvalue == 'IPTV Service Details') {
                $emailvaluedataoption[] = array('type' => 'product', 'name' => 'IPTV Service Details', 'subject' => 'Your IPTV Service Info', 'message' => '<p>Dear {$client_name},</p>
                <p>Thank you for buying our IPTV subscription! Your product <strong>{$service_product_name}</strong> is now active.</p>
                <p>Please find below the login details for connecting : </p>
                <p>Username: {$service_username}<br />Password: {$service_password}<br />Portal URL: {$portal_url} </p>
                <p>If you would like to download your M3U Playlist you can do this <a href="{$portal_url}/get.php?username={$service_username}&amp;password={$service_password}&amp;type=m3u_plus&amp;output=ts">here</a>.</p>
                <p>If you face issues as a cause of poor bandwidth conditions on your Home/Phone, then we recommend switching to HLS mode of your M3U Playlist, you can download it <a href="{$portal_url}/get.php?username={$service_username}&amp;password={$service_password}&amp;type=m3u_plus&amp;output=hls">here</a>.</p>
                <hr />
                <p>Subscription Information:</p>
                <p>Product/Service: {$service_product_name}<br />Payment Method: {$service_payment_method}<br />Amount: {$service_recurring_amount}<br />Billing Cycle: {$service_billing_cycle}<br />Subscription Expiration: {$service_next_due_date}</p>
                <p><br />{$signature}</p>', 'disabled' => 0, 'custom' => 1, 'plaintext' => 0);
            }
            if ($emailvalue == 'IPTV MAG Service Details') {
                $emailvaluedataoption[] = array('type' => 'product', 'name' => $emailvalue, 'subject' => 'Your IPTV Service Info', 'message' => '<p>Dear {$client_name},</p>
                <p>Thank you for buying our IPTV subscription! Your product <strong>{$service_product_name}</strong> is now active.</p>
                <p>Please find below the MAG portal details for accessing our service,</p>
                <p>Portal URL: {$portal_url}</p>
                <p>Please, ensure your MAC address <strong>{$mag_address}</strong> is the right one listed on your MAG/STB device, otherwise you will not be able to connect to our platform from your MAG/STB device. If you have provided the wrong MAC address, no worries! You can change it on your Client area.</p>
                <p><br />Having troubles setting up your device? Feel free to submit a Support Ticket by clicking <a href="{$whmcs_url}/submitticket.php">here</a></p>
                <hr />
                <p>Subscription Information:</p>
                <p>Product/Service: {$service_product_name}<br />Payment Method: {$service_payment_method}<br />Amount: {$service_recurring_amount}<br />Billing Cycle: {$service_billing_cycle}<br />Subscription Expiration: {$service_next_due_date}</p>
                <p><br />{$signature}</p>', 'disabled' => 0, 'custom' => 1, 'plaintext' => 0);
            }
            if ($emailvalue == 'IPTV Reseller Credits Email') {
                $emailvaluedataoption[] = array('type' => 'product', 'name' => $emailvalue, 'subject' => 'Your IPTV Service Info', 'message' => '<div>
                <div>Dear {$client_name},</div>
                <br />
                <div>This is just a notification to let you know that your Reseller credits have been provisioned into your existing Reseller account.</div>
                <div></div>
                <div>Reseller Portal Username: {$reseller_username}</div>
                <div>Credits purchased: {$reseller_credits}</div>
                <div></div>
                <div>Have any questions? Feel free to submit a Support Ticket by clicking <a href="{$whmcs_url}/submitticket.php">here</a></div>
                <div></div>
                <div>{$signature}</div>
                </div>', 'disabled' => 0, 'custom' => 1, 'plaintext' => 0);
            }
            if ($emailvalue == 'IPTV Reseller Email') {
                $emailvaluedataoption[] = array('type' => 'product', 'name' => $emailvalue, 'subject' => 'Your IPTV Service Info', 'message' => '<div>
                <div>Dear {$client_name},</div>
                <br />
                <div>Thank you for becoming our IPTV Reseller! We are happy to welcome you to our team.</div>
                <div></div>
                <div>Your IPTV Reseller panel is now active, please find below the login details for connecting,</div>
                <div></div>
                <div>Reseller Portal URL: {$panel_url}</div>
                <div>Reseller Portal Username: {$reseller_username}</div>
                <div>Reseller Portal Password: {$reseller_password}</div>
                <div>Credits purchased:{$reseller_credits} </div>
                <div></div>
                <div>Feel free to submit a Support Ticket in our Reseller department by clicking <a href="{$whmcs_url}/submitticket.php">here</a></div>
                <div></div>
                <div>{$signature}</div>
                </div>', 'disabled' => 0, 'custom' => 1, 'plaintext' => 0);
            }
        }

        if (isset($emailvaluedataoption) && !empty($emailvaluedataoption))
            Capsule::table('tblemailtemplates')->insert($emailvaluedataoption);

        return [
            'status' => 'success',
            'description' => 'Module Activated Successfully.',
        ];
    } catch (\Exception $e) {
        return [
            'status' => "error",
            'description' =>  $e->getMessage(),
        ];
    }
}
function XUIPanelCustom_deactivate()
{
    try {
        Capsule::schema()
            ->dropIfExists('xui_settings');
        Capsule::schema()
            ->dropIfExists('xui_paneldetails');
        Capsule::schema()
            ->dropIfExists('xui_logs');
        Capsule::schema()
            ->dropIfExists('xui_cats');
        Capsule::schema()
            ->dropIfExists('xui_cat_data');
        return [
            'status' => 'success',
            'description' => 'Module Deactivated Successfully.',
        ];
    } catch (\Exception $e) {
        return [
            "status" => "error",
            "description" => $e->getMessage(),
        ];
    }
}
function XUIPanelCustom_output($vars)
{
    $licenseinfo = XUIPanelCustom_doCheckLicense();
    if ($licenseinfo['status'] != 'licensekeynotfound') {
        if ($licenseinfo['status'] == 'Active') {
            $dispatcher = new AdminDispatcher();
            $response = $dispatcher->dispatch($action, $vars);
            echo $response;
        } else {
            echo "Invalid License Key";
        }
    } else {
        echo "Invalid License Key";
    }
}
