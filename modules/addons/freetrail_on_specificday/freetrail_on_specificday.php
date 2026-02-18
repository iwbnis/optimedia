<?php

use Illuminate\Database\Capsule\Manager as Capsule;

function freetrail_on_specificday_config()
{
    $configarray = array(
        "name" => "Free Trail for Specific Time",
        "description" => "This Module allow you to make trial for special day.",
        "version" => "1.5",
        'author' => '<a style="text-decoration: none;" href="http://whmcssmarters.com/" target="_blank"><img src="../modules/addons/freetrail_on_specificday/logo.png" style="width: 220px;height: auto;"><br>WHMCS SMARTERS</a>',
        "fields" => array(
            "licenseregto" => array("FriendlyName" => "License Registered To", "Description" => "Not Available"),
            "licenseregmail" => array("FriendlyName" => "License Registered Email", "Description" => "Not Available"),
            "licenseduedate" => array("FriendlyName" => "License Due Date", "Description" => "Not Available"),
            "licensestatus" => array("FriendlyName" => "License Status", "Description" => "Not Available"),
            "license" => array("FriendlyName" => "License", "Type" => "text", "Size" => "35"),
        )
    );
    $licenseinfo = freetrial_doCheckLicense();
    if ($licenseinfo['status'] != 'licensekeynotfound') {
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


function freetrial_doCheckLicense()
{
    $result = Capsule::table('tbladdonmodules')
        ->where('module', '=', 'freetrail_on_specificday')
        ->get();
    foreach ($result as $row) {
        $settings[$row->setting] = $row->value;
    }
    if ($settings['license']) {
        $localkey = $settings['localkey'];
        $licenseinfo = $result = freetrial_checkLicense($settings['license'], $localkey);
        if (isset($licenseinfo['localkey']) && !empty($licenseinfo['localkey'])) {
            $moduledata = Capsule::table('tbladdonmodules')
                ->where('module', '=', 'freetrail_on_specificday')
                ->where('setting', '=', 'localkey')
                ->count();
            if ($moduledata > 0) {
                Capsule::table('tbladdonmodules')
                    ->where('setting', 'localkey')
                    ->where('module', 'freetrail_on_specificday')
                    ->update(['value' => $licenseinfo['localkey']]);
            } else {
                Capsule::table('tbladdonmodules')->insert(
                    ['setting' => 'localkey', 'value' => $licenseinfo['localkey'], 'module' => 'freetrail_on_specificday']
                );
            }
        }
        $result['licensekey'] = $settings['license'];
    } else {
        $result['status'] = 'licensekeynotfound';
    }
    return $result;
}


function freetrial_checkLicense($licensekey, $localkey = "")
{
    $whmcsurl = "https://www.whmcssmarters.com/clients/";
    $licensing_secret_key = "FREETRAIL";
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
            'dir' => $dirpath,
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
                    if (
                        !$responseCode && preg_match($responseCodePattern, trim($line), $patternMatches)
                    ) {
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

function freetrail_on_specificday_activate()
{
    if (!Capsule::schema()->hasTable('table_weakDays')) {
        Capsule::schema()->create(
            'table_weakDays',
            function ($table) {
                $table->increments('id');
                $table->string('pid');
                $table->string('time_data');
            }
        );
    }
}

function freetrail_on_specificday_deactivate()
{
    if (Capsule::schema()->hasTable('table_weakDays')) {
        Capsule::schema()->drop('table_weakDays');
    }
}

function freetrail_on_specificday_output($vars)
{
    $licenseinfo = freetrial_doCheckLicense();
    if ($licenseinfo['status'] == 'Active') {
?>
        <style type="text/css">
            .switch {
                position: relative;
                display: inline-block;
                width: 51px;
                height: 26px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 19px;
                width: 17px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #2196F3;
            }

            input:focus+.slider {
                box-shadow: 0 0 1px #2196F3;
            }

            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
        </style>
        <?php
        $gdata = Capsule::table('tblproductgroups')->get();
        if (isset($_POST['btnsubmit'])) {
            Capsule::table('table_weakDays')->delete();
            $arrayToInsert = array();
            foreach ($_POST['selectedProduct'] as $productId) {
                $arrayToInsert[$productId]["starting_date"] = $_POST['starting_date'][$productId];
                $arrayToInsert[$productId]["closing_date"] = $_POST['closing_date'][$productId];
                $arrayToInsert[$productId]["starting_time"] = $_POST['starting_time'][$productId];
                $arrayToInsert[$productId]["closing_time"] = $_POST['closing_time'][$productId];
            }
            foreach ($arrayToInsert as $productId => $valueToInsert) {
                Capsule::table('table_weakDays')->insert(array(
                    'pid' => $productId,
                    'time_data' => serialize($valueToInsert),
                ));
            }
        }
        $savedDatafinalArray = array();
        $SavedData = Capsule::table('table_weakDays')->get();
        foreach ($SavedData as $value) {
            $savedDatafinalArray[$value->pid] = unserialize($value->time_data);
        }
        ?>
        <form method="post">
            <div id="tableBackground" class="tablebg">
                <b><span style="font-size: 17px;">Note: </span>Enable Product To show for a specific time. Leave disabled to show for all time.</b>
                <table class="datatable sort-groups no-margin" data-id="group|1|0" width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tbody>
                        <tr>
                            <th style="width: 23%;">Products</th>
                            <th style="width: 23%;">Start Schedule</th>
                            <th style="width: 23%;">End Schedule</th>
                        </tr>
                    </tbody>
                    <?php
                    foreach ($gdata as $grpdata) {
                    ?>
                        <tbody>
                            <?php
                            $data = Capsule::table('tblproducts')->where('gid', $grpdata->id)->get();
                            ?>
                            <tr>
                                <td colspan="6" style="width: 96%; background-color:#f3f3f3;">
                                    <div class="prodGroup" align="left">
                                        &nbsp;
                                        <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
                                        &nbsp;<strong>Group Name:</strong>
                                        <?php echo $grpdata->name; ?>
                                    </div>
                                    <?php ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php
                        foreach ($data as $pdata) {
                            $productid = $pdata->id;
                        ?>
                            <tbody id="tbodyGroupProduct1" class="list-group">
                                <tr class="product text-center" data-id=>
                                    <td style="width: 23%;" class="text-left">
                                        <label class="switch">
                                            <input type="checkbox" class="productsToShow" name="selectedProduct[]" value="<?php echo $productid ?>" <?php echo isset($savedDatafinalArray[$productid]) ? "checked" : "" ?>>
                                            <span class="slider round"></span>
                                        </label>
                                        <?php echo $pdata->name; ?>
                                    </td>
                                    <td style="width: 23%;">
                                        <div align="center">
                                            <select style="width: 50%;float: left;" name="starting_date[<?php echo $productid; ?>]" class="selectpicker form-control">
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Sunday" ? "selected" : "" ?> value="Sunday">Sunday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Monday" ? "selected" : "" ?> value="Monday">Monday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Tuesday" ? "selected" : "" ?> value="Tuesday">Tuesday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Wednesday" ? "selected" : "" ?> value="Wednesday">Wednesday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Thursday" ? "selected" : "" ?> value="Thursday">Thursday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Friday" ? "selected" : "" ?> value="Friday">Friday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['starting_date']) && $savedDatafinalArray[$productid]['starting_date'] == "Saturday" ? "selected" : "" ?> value="Saturday">Saturday</option>
                                            </select>
                                            <input style="width: 30%;" type="time" class="form-control" name="starting_time[<?php echo $productid; ?>]" value="<?php echo isset($savedDatafinalArray[$productid]['starting_time']) && !empty($savedDatafinalArray[$productid]['starting_time']) ? $savedDatafinalArray[$productid]['starting_time'] : "" ?>">
                                        </div>
                                    </td>
                                    <td style="width: 23%;">
                                        <div align="center">
                                            <select style="width: 50%;float: left;" name="closing_date[<?php echo $productid; ?>]" class="selectpicker form-control">
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Sunday" ? "selected" : "" ?> value="Sunday">Sunday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Monday" ? "selected" : "" ?> value="Monday">Monday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Tuesday" ? "selected" : "" ?> value="Tuesday">Tuesday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Wednesday" ? "selected" : "" ?> value="Wednesday">Wednesday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Thursday" ? "selected" : "" ?> value="Thursday">Thursday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Friday" ? "selected" : "" ?> value="Friday">Friday</option>
                                                <option <?php echo isset($savedDatafinalArray[$productid]['closing_date']) && $savedDatafinalArray[$productid]['closing_date'] == "Saturday" ? "selected" : "" ?> value="Saturday">Saturday</option>
                                            </select>
                                            <input style="width: 30%;" type="time" class="form-control" name="closing_time[<?php echo $productid; ?>]" value="<?php echo isset($savedDatafinalArray[$productid]['closing_time']) && !empty($savedDatafinalArray[$productid]['closing_time']) ? $savedDatafinalArray[$productid]['closing_time'] : "" ?>">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <center>
                <input type="submit" class="btn btn-success" name="btnsubmit" value="Save Changes " />
            </center>
        </form>
        <script>
            $(document).ready(function() {
                $("#checkall").click(function() {
                    if ($(this).is(':checked')) {
                        $('input[type="checkbox"]').prop('checked', true);
                    } else {
                        $('input[type="checkbox"]').prop('checked', false);
                    }
                });
                $(".productsToShow").click(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest("tr").find('td:eq(1)').find("select").prop("disabled", false);
                        $(this).closest("tr").find('td:eq(1)').find("input").prop("disabled", false);
                        $(this).closest("tr").find('td:eq(2)').find("select").prop("disabled", false);
                        $(this).closest("tr").find('td:eq(2)').find("input").prop("disabled", false);
                    } else {
                        $(this).closest("tr").find('td:eq(1)').find("select").prop("disabled", true);
                        $(this).closest("tr").find('td:eq(1)').find("input").prop("disabled", true);
                        $(this).closest("tr").find('td:eq(2)').find("select").prop("disabled", true);
                        $(this).closest("tr").find('td:eq(2)').find("input").prop("disabled", true);
                    }
                });
                $("input.productsToShow").each(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest("tr").find('td:eq(1)').find("select").prop("disabled", false);
                        $(this).closest("tr").find('td:eq(1)').find("input").prop("disabled", false);
                        $(this).closest("tr").find('td:eq(2)').find("select").prop("disabled", false);
                        $(this).closest("tr").find('td:eq(2)').find("input").prop("disabled", false);
                    } else {
                        $(this).closest("tr").find('td:eq(1)').find("select").prop("disabled", true);
                        $(this).closest("tr").find('td:eq(1)').find("input").prop("disabled", true);
                        $(this).closest("tr").find('td:eq(2)').find("select").prop("disabled", true);
                        $(this).closest("tr").find('td:eq(2)').find("input").prop("disabled", true);
                    }
                });
            });
        </script>
<?php
    } else {
        echo "Inavlid License Key";
    }
}