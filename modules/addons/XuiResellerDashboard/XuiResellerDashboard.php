<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

// Also, perform any initialization required by the service's library.
require_once __DIR__ . '/lib/Admin/AdminDispatcher.php';
require_once __DIR__ . '/lib/Admin/Controller.php';

use WHMCS\Module\Addon\XUIONE\Admin\AdminDispatcher;
use WHMCS\Database\Capsule;

function XuiResellerDashboard_config() {
    $configarray = array(
        'name' => 'XUI Reseller API Panel', // Display name for your module
        'description' => 'The module provide the  Xui Reseller Dashboard User Management with API', // Description displayed within the admin interface
        'author' => '<a href="https://www.smarters.shop/" target="_blank"><img src="../modules/addons/XuiResellerDashboard/smartersshop.png"></a>',
        'language' => 'english', // Default language
        'version' => '1.0.6', // Version number 
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
    $licenseinfo = XuiResellerDashboard_doCheckLicense();
    if ($licenseinfo['status'] != 'licensekeynotfound') {
        if ($licenseinfo['status'] == 'Active') {
            if (isset($licenseinfo['localkey']) && !empty($licenseinfo['localkey'])) {
                $moduledata = Capsule::table('tbladdonmodules')
                        ->where('module', '=', 'XuiResellerDashboard')
                        ->where('setting', '=', 'localkey')
                        ->count();
                if (isset($moduledata) && !empty($moduledata)) {
                    Capsule::table('tbladdonmodules')
                            ->where('setting', 'localkey')
                            ->where('module', 'XuiResellerDashboard')
                            ->update(['value' => $licenseinfo['localkey']]);
                } else {
                    Capsule::table('tbladdonmodules')->insert(
                            ['setting' => 'localkey', 'value' => $licenseinfo['localkey'], 'module' => 'XuiResellerDashboard']
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

function XuiResellerDashboard_activate() {
    // Create custom tables and schema required by your module
    try {
        if (!Capsule::schema()->hasTable('xtreamui_userdata')) {
            Capsule::schema()->create('xtreamui_userdata', function ($table) {
                $table->increments('id');
                $table->text('serviceid');
                $table->text('xtreamoneid');
            }
            );
        }
        if (!Capsule::schema()->hasTable('xtreamuione_config')) {
            Capsule::schema()->create(
                    'xtreamuione_config', function ($table) {
                $table->string('setting');
                $table->string('value');
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
        $configuration = array
            (
            'custom_field_mag' => 'MAG Address',
            'custom_field_eng' => 'XtreamTV ID',
            'custom_field_username' => 'Username',
            'custom_field_password' => 'Password',
            'checkmagdevice' => 'MAG Device',
            'checkengdevice' => 'Enigma Device',
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
            'mag_desc' => 'MAG Box',
            'enigma2_devices' => 'Enigma2 Device',
            'current_mag' => 'Current MAG device:',
            'new_mag' => 'New MAG device:',
            'change_mag_button' => 'Change',
            'add_eng_button' => 'Add new Enigma device',
            'new_eng' => 'New Enigma device',
            'change_eng_button' => 'Change',
            'add_eng_button' => 'Add new Enigma device',
            'other_devices' => 'Other Devices',
            'autoscripts' => 'Auto-Scripts',
            'stream_output' => 'Stream output:',
            'dropdown_name' => 'Playlist/Script',
            'dropdown_action' => 'Choose Device',
            'creditapply' => 'on',
        );
        foreach ($configuration as $name => $value) {
            $configurationdata[] = array('setting' => $name, 'value' => $value);
        }
        Capsule::table('xtreamuione_config')->delete();
        try {
            Capsule::table('xtreamuione_config')->insert($configurationdata);
        } catch (\Exception $e) {
            return array('status' => 'error', 'description' => $e->getMessage() . '. There is an error while activating this module');
        }
        $emailtemplates = Capsule::table('tblemailtemplates')->get();
        $emailtemplatesreturn = array();
        if (isset($emailtemplates) && !empty($emailtemplates)) {
            foreach ($emailtemplates as $emailtemplate) {
                $emailtemplatesreturn[] = $emailtemplate->name;
            }
        }
        $emailtemplatesoption = array_diff(array(
            'IPTV Service Details'
                ), $emailtemplatesreturn);
        foreach ($emailtemplatesoption as $emailvalue) {
            if ($emailvalue == 'IPTV Service Details') {
                $emailvaluedataoption[] = array('type' => 'product', 'name' => 'IPTV Service Details', 'subject' => 'Your IPTV Service Info', 'message' => '   
              <span style="font-size: small;">Dear {$client_name},</span><br /><span style="font-size: small;"><br />Thanks for buying our service.  Your service {$service_product_name} has now activated. </span><br /><span style="font-size: small;">Please use the following to details to use your service. </span><br /><br /><span style="font-size: small;"><strong>Your IPTV Service Details are:</strong> <br /></span><br /><span style="font-size: small;"><strong>Your Username :</strong> {$service_username}</span><br /><br /><span style="font-size: small;"><strong>Your Password  :</strong>  {$service_password}<br /><br /><strong>M3u Playlist URL :</strong> http://iptv.dguk.co.uk:80/get.php?username=<span>{$service_username}</span>&amp;password=<span>{$service_password}</span>&amp;type=m3u&amp;output=ts<br /><br /></span><span style="font-size: small;"><strong>M3u Plus Playlist URL :</strong> http://iptv.dguk.co.uk:80/get.php?username=<span>{$service_username}</span>&amp;password=<span>{$service_password}</span>&amp;type=m3u_plus&amp;output=ts</span><br /><br /><span style="font-size: small;"><span style="font-size: small;"><strong>Enigma2 OE 2.0 Auto Script :</strong> wget -O /etc/enigma2/iptv.sh "http://iptv.dguk.co.uk:80/get.php?username=<span>{$service_username}</span>&amp;password=<span>{$service_password}</span>&amp;type=enigma22_script&amp;output=ts" &amp;&amp; chmod 777 /etc/enigma2/iptv.sh &amp;&amp; /etc/enigma2/iptv.sh </span></span><span style="font-size: small;">&amp;&amp; cd /etc/enigma2/ &amp;&amp; cp iptv.sh /usr/script/ &amp;&amp; cd /usr/script/ &amp;&amp; chmod 775 iptv.sh</span>
<p><span style="font-size: small;">Then on your box:</span></p>
<p><span style="font-size: small;">Press Menu, Timers, Cron Timers.</span></p>
<p><span style="font-size: small;">Green Button to "add"</span></p>
<p><span style="font-size: small;">Run how often?: daily</span><br /><span style="font-size: small;">Time to execute Command or Script: 06:00 (your Preference of time)</span><br /><span style="font-size: small;">Command Type: Predefined</span><br /><span style="font-size: small;">Command To Run: iptv.sh</span></p>
<p><span style="font-size: small;">Green Button to save.<br /><br /></span></p>
<span style="font-size: small;"><strong>MAG Portal URL :</strong> http://{$service_server_hostname}:80/c</span><br /><br /><span style="font-size: small;"><span style="font-size: small;"><a href="{$company_domain}/clientarea.php?action=productdetails&amp;id={$service_id}" target="_blank">Get or Download your m3u Playlist here<br /><br /></a></span></span><hr />
<p><span style="font-size: small;"><strong>Billing Info: </strong></span></p>
<p><span style="font-size: small;">Product/Service: {$service_product_name}</span><br /><span style="font-size: small;">Payment Method: {$service_payment_method}</span><br /><span style="font-size: small;">Amount: {$service_recurring_amount}</span><br /><span style="font-size: small;">Billing Cycle: {$service_billing_cycle}</span><br /><span style="font-size: small;">Next Due Date: {$service_next_due_date}</span></p>
<p><span style="font-size: small;">Thank you for choosing us.</span></p>
<p><span style="font-size: small;">{$signature}</span></p>  
            ', 'disabled' => 0, 'custom' => 1, 'plaintext' => 0);
            }
        }
        if (isset($emailvaluedataoption) && !empty($emailvaluedataoption))
            Capsule::table('tblemailtemplates')->insert($emailvaluedataoption);
    } catch (\Exception $e) {
        return array('status' => 'error', 'description' => $e->getMessage() . '. There is an error while activating this module');
    }

    return array(
        'status' => 'success', // Supported values here include: success, error or info
        'description' => 'XUI One Reseller Panel Dashboard Module Activated Successfully!',
    );
}

function XuiResellerDashboard_deactivate() {
    // Undo any database and schema modifications made by your module here
    Capsule::schema()->dropIfExists('xtreamuione_config');
    Capsule::schema()->dropIfExists('xtreamui_applinks');
    return array(
        'status' => 'success', // Supported values here include: success, error or info
        'description' => 'Xui Reseller Dashboard modules deactivated successfully!',
    );
}

function XuiResellerDashboard_output($vars) {
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];
    include_once 'xtreamtabs.php';
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    $dispatcher = new AdminDispatcher();
    $response = $dispatcher->dispatch($action, $vars);
    echo $response;
}

function XuiResellerDashboard_doCheckLicense() {
    $result = Capsule::table('tbladdonmodules')->where('module', '=', 'XuiResellerDashboard')->get();
    foreach ($result as $row) {
        $settings[$row->setting] = $row->value;
    }
    if ($settings['license']) {
        $localkey = $settings['localkey'];
        $result = XuiResellerDashboard_checkLicense($settings['license'], $localkey);
        $result['licensekey'] = $settings['license'];
    } else {
        $result['status'] = 'licensekeynotfound';
    }
    return $result;
}

function XuiResellerDashboard_checkLicense($licensekey, $localkey = '') {
    $whmcsurl = "https://www.whmcssmarters.com/clients/";
    $licensing_secret_key = "XUIResellerOne";
    $localkeydays = 14;
    $allowcheckfaildays = 5;
    $check_token = time() . md5(mt_rand(1000000000, 9999999999) . $licensekey);
    $checkdate = date("Ymdhis");
    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(__FILE__);
    $verifyfilepath = 'modules/servers/licensing/verify.php';
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
        foreach ($postfields AS $k => $v) {
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
            foreach ($matches[1] AS $k => $v) {
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
