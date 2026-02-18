<?php

use WHMCS\Database\Capsule;

function moduleconfiguration() {
    if ($_REQUEST['action'] == 'edit') {
        $productID = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "Undefined";
        $productdetailsare = Capsule::table('tblproducts')->where('id', $productID)->get();
        $productType = $productdetailsare[0]->servertype;
        if ($productType == 'XUIResellerPanel_Api') {
            $serversCustomCount = Capsule::table('xtreamui_servers')->count();
            if (isset($serversCustomCount) && !empty($serversCustomCount)) {
              $prouctid = $_REQUEST['id'];
              $productdata = Capsule::table('tblproducts')->where("id",$prouctid)->get();
             $serverid = $productdata[0]->configoption1;
                $serversCustom = Capsule::table('xtreamui_servers')->where("id",$serverid)->get();
                $products = array();
                $productdetails = array();
                foreach ($serversCustom as $server) {
                    $api_result = XtreamUIAPICall($server->resellerurl . '/' . $server->accesscode . "/index.php?api_key=" . $server->apikey, 'GET', 'packages');
                    if ($api_result['status'] == 'STATUS_SUCCESS') {
//                        print"<pre>";
//                        print_R($productdetailsare);
//                        exit;
                        foreach ($api_result['data'] as $data) {
                            if ($data['is_trial'] == '1') {
                                $productdetails['info' . $data['id']] = '<div id="package_info" style="">
                                     <table name="addserver" class="form" method="request" action="edit" id="" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tbody>
                <tr>
                    <td style="width: 40%;background-color: #efefef;" class="fieldlabel">Package Cost</td>
                    <td class="fieldarea"><b><input readonly=""  style="width: 70%;" type="text" class="form-control text-center"  value="' . $data['trial_credits'] . ' Credits"></b></td>
                </tr>
                <tr>
                    <td style="width: 40%;background-color: #efefef;" class="fieldlabel">Duration</td>
                    <td class="fieldarea"><b><input style="width: 70%;" readonly="" type="text" class="form-control text-center"   value="' . $data['trial_duration'] . ' ' . ucwords($data['trial_duration_in']) . '"></b></td>
                </tr>
                <tr>
                    <td style="width: 40%;background-color: #efefef;" class="fieldlabel">Max. Connections</td>
                    <td class="fieldarea"><b><input style="width: 70%;" readonly="" type="text" class="form-control text-center"  value="' . $data['max_connections'] . '"></b></td>
                </tr> 
            </tbody>
        </table> </div>';
                                if ($data['is_line'] == '1') {
                                    $selected = ($data['id'] == $productdetailsare[0]->configoption7) ? 'selected' : '';
                                    $products['linetrialproduct' . $server->id] .= "<option " . $selected . " value='" . $data['id'] . "'>" . $data['package_name'] . "</option>";
                                }
                                if ($data['is_mag'] == '1') {
                                    $selected = ($data['id'] == $productdetailsare[0]->configoption7) ? 'selected' : '';
                                    $products['magtrialproduct' . $server->id] .= "<option " . $selected . " value='" . $data['id'] . "'>" . $data['package_name'] . "</option>";
                                }
                                if ($data['is_e2'] == '1') {
                                    $selected = ($data['id'] == $productdetailsare[0]->configoption7) ? 'selected' : '';
                                    $products['engtrialproduct' . $server->id] .= "<option " . $selected . " value='" . $data['id'] . "'>" . $data['package_name'] . "</option>";
                                }
                            }
                            if ($data['is_official'] == '1') {
                                $productdetails['info' . $data['id']] = '
                                   <div id="package_info" style=""> <table name="addserver" class="form" method="request" action="edit" id="" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tbody>
                <tr>
                    <td style="width: 40%;background-color: #efefef;" class="fieldlabel">Package Cost</td>
                    <td class="fieldarea"><b><input readonly=""  style="width: 70%;" type="text" class="form-control text-center"  value="' . $data['official_credits'] . ' Credits"></b></td>
                </tr>
                <tr>
                    <td style="width: 40%;background-color: #efefef;" class="fieldlabel">Duration</td>
                    <td class="fieldarea"><b><input style="width: 70%;" readonly="" type="text" class="form-control text-center"   value="' . $data['official_duration'] . ' ' . ucwords($data['official_duration_in']) . '"></b></td>
                </tr>
                <tr>
                    <td style="width: 40%;background-color: #efefef;" class="fieldlabel">Max. Connections</td>
                    <td class="fieldarea"><b><input style="width: 70%;" readonly="" type="text" class="form-control text-center"  value="' . $data['max_connections'] . '"></b></td>
                </tr> 
            </tbody>
        </table></div> ';
                                if ($data['is_line'] == '1') {
                                    $selected = ($data['id'] == $productdetailsare[0]->configoption8) ? 'selected' : '';
                                    $products['lineproduct' . $server->id] .= "<option " . $selected . " value='" . $data['id'] . "'>" . $data['package_name'] . "</option>";
                                }
                                if ($data['is_mag'] == '1') {
                                    $selected = ($data['id'] == $productdetailsare[0]->configoption8) ? 'selected' : '';
                                    $products['magproduct' . $server->id] .= "<option " . $selected . " value='" . $data['id'] . "'>" . $data['package_name'] . "</option>";
                                }
                                if ($data['is_e2'] == '1') {
                                    $selected = ($data['id'] == $productdetailsare[0]->configoption8) ? 'selected' : '';
                                    $products['engproduct' . $server->id] .= "<option " . $selected . " value='" . $data['id'] . "'>" . $data['package_name'] . "</option>";
                                }
                            }
                        }
                    }
                    $user_info = XtreamUIAPICall($server->resellerurl . '/' . $server->accesscode . "/index.php?api_key=" . $server->apikey, 'GET', 'user_info');
                    if ($user_info['status'] == 'STATUS_SUCCESS') {
                        $products['users' . $server->id] = "<b id='usersinfo'>" . ucwords($user_info['data']['username']) . " (Credits - <font color='orange'><u>" . $user_info['data']['credits'] . "</u></font>)</b>";
                    }
                }
            }


            if (!empty($products)) {
                $jsondata = json_encode($products);
            } else {
                $jsondata = json_encode(array('No data!'));
            }
            if (!empty($productdetails)) {
                $productinfo = json_encode($productdetails);
            } else {
                $productinfo = json_encode(array('No data!'));
            }
            return <<<HTML
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript">
    jQuery(document).ajaxComplete(function () {
        var options = $jsondata; 
        jQuery("select[name='packageconfigoption[1]']").change(function () {
            $("#moduleSettingsLoader").show();
            setTimeout(function () {
                if ($("select[name='packageconfigoption[5]']").val() === 'trial') {
                    if ($("select[name='packageconfigoption[3]']").val() === 'streamlineonly') {
                        var linetrialproduct = 'linetrialproduct' + $("select[name='packageconfigoption[1]']").val();
                        var trialproducts = $("select[name='packageconfigoption[7]']");
                        trialproducts.empty().append(options[linetrialproduct]);
                    }
                    if ($("select[name='packageconfigoption[3]']").val() === 'magdevice') {
                        var magtrialproduct = 'magtrialproduct' + $("select[name='packageconfigoption[1]']").val();
                        var trialproducts = $("select[name='packageconfigoption[7]']");
                        trialproducts.empty().append(options[magtrialproduct]);
                    }
                    if ($("select[name='packageconfigoption[3]']").val() === 'engdevice') {
                        var engtrialproduct = 'engtrialproduct' + $("select[name='packageconfigoption[1]']").val();
                        var trialproducts = $("select[name='packageconfigoption[7]']");
                        trialproducts.empty().append(options[engtrialproduct]);
                    }
                } else {
                    if ($("select[name='packageconfigoption[3]']").val() === 'streamlineonly') {
                        var lineproduct = 'lineproduct' + $("select[name='packageconfigoption[1]']").val();
                        var productorg = $("select[name='packageconfigoption[8]']");
                        productorg.empty().append(options[lineproduct]);
                    }
                    if ($("select[name='packageconfigoption[3]']").val() === 'magdevice') {
                        var magproduct = 'magproduct' + $("select[name='packageconfigoption[1]']").val();
                        var productorg = $("select[name='packageconfigoption[8]']");
                        productorg.empty().append(options[magproduct]);
                    }
                    if ($("select[name='packageconfigoption[3]']").val() === 'engdevice') {
                        var engproduct = 'engproduct' + $("select[name='packageconfigoption[1]']").val();
                        var productorg = $("select[name='packageconfigoption[8]']");
                        productorg.empty().append(options[engproduct]);
                    }
                }
                packageinfoselected();
                var usersinfo = 'users' + $("select[name='packageconfigoption[1]']").val();
                $("#usersinfo").replaceWith(options[usersinfo]);
                $("#moduleSettingsLoader").hide();
            }, 1000);
        });
        jQuery("select[name='packageconfigoption[5]']").change(function () {
            $("#moduleSettingsLoader").show();
            setTimeout(function () {
                changeLineType();
                packageinfoselected();
                $("#moduleSettingsLoader").hide();
            }, 1000);
        });
        jQuery("select[name='packageconfigoption[3]']").change(function () {
            $("#moduleSettingsLoader").show();
            setTimeout(function () {
                changepackage();
                packageinfoselected();
                    hideextrafields();
                $("#moduleSettingsLoader").hide();
            }, 1000);
        });
        jQuery("select[name='packageconfigoption[7]']").change(function () {
            $("#moduleSettingsLoader").show();
            setTimeout(function () {
                packageinfoselected();
                $("#moduleSettingsLoader").hide();
            }, 1000);
        });
        jQuery("select[name='packageconfigoption[8]']").change(function () {
            $("#moduleSettingsLoader").show();
            setTimeout(function () {
                packageinfoselected();
                $("#moduleSettingsLoader").hide();
            }, 1000);
        });
        function changepackage() {
            if ($("select[name='packageconfigoption[3]']").val() === 'streamlineonly') {
                if ($("select[name='packageconfigoption[5]']").val() === 'trial') {
                    var linetrialproduct = 'linetrialproduct' + $("select[name='packageconfigoption[1]']").val();
                    var trialproducts = $("select[name='packageconfigoption[7]']");
                    trialproducts.empty().append(options[linetrialproduct]);
                } else {
                    var lineproduct = 'lineproduct' + $("select[name='packageconfigoption[1]']").val();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append(options[lineproduct]);
                }
            }
            if ($("select[name='packageconfigoption[3]']").val() === 'magdevice') {
                if ($("select[name='packageconfigoption[5]']").val() === 'trial') {
                    var magtrialproduct = 'magtrialproduct' + $("select[name='packageconfigoption[1]']").val();
                    var trialproducts = $("select[name='packageconfigoption[7]']");
                    trialproducts.empty().append(options[magtrialproduct]);
                } else {
                    var magproduct = 'magproduct' + $("select[name='packageconfigoption[1]']").val();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append(options[magproduct]);
                }
            }
            if ($("select[name='packageconfigoption[3]']").val() === 'engdevice') {
                if ($("select[name='packageconfigoption[5]']").val() === 'trial') {
                    var engtrialproduct = 'engtrialproduct' + $("select[name='packageconfigoption[1]']").val();
                    var trialproducts = $("select[name='packageconfigoption[7]']");
                    trialproducts.empty().append(options[engtrialproduct]);
                } else {
                    var engproduct = 'engproduct' + $("select[name='packageconfigoption[1]']").val();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append(options[engproduct]);
                }
            }
        }
        function hideextrafields() {
            if ($("select[name='packageconfigoption[3]']").val() === 'streamlineonly') {
                 $("#m3ulink").replaceWith('<td class="fieldlabel" width="20%">M3U link</td>');
                 $("#watchstreams").replaceWith('<td class="fieldlabel" width="20%">Watch Streams!</td>');
                 $("input[name='packageconfigoption[4]']").parent().show(); 
                 $("input[name='packageconfigoption[6]']").parent().show(); 
            }
            if ($("select[name='packageconfigoption[3]']").val() === 'magdevice') {
             $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "M3U link";
                    }).replaceWith('<div id="m3ulink"></div>');
                    
                     $("input[name='packageconfigoption[4]']").parent().hide();
             $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "Watch Streams!";
                    }).replaceWith('<div id="watchstreams"></div>');
                     $("input[name='packageconfigoption[6]']").parent().hide(); 
            }
            if ($("select[name='packageconfigoption[3]']").val() === 'engdevice') {
                 $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "M3U link";
                    }).replaceWith('<div id="m3ulink"></div>');
                    
                     $("input[name='packageconfigoption[4]']").parent().hide();
             $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "Watch Streams!";
                    }).replaceWith('<div id="watchstreams"></div>');
                     $("input[name='packageconfigoption[6]']").parent().hide(); 
            }
        }
        function changeLineType() {
            if ($("select[name='packageconfigoption[5]']").val() === 'trial') {
                if ($("select[name='packageconfigoption[3]']").val() === 'streamlineonly') {
                    var linetrialproduct = 'linetrialproduct' + $("select[name='packageconfigoption[1]']").val();
                    var trialproducts = $("select[name='packageconfigoption[7]']");
                    trialproducts.empty().append(options[linetrialproduct]);
                }
                if ($("select[name='packageconfigoption[3]']").val() === 'magdevice') {
                    var magtrialproduct = 'magtrialproduct' + $("select[name='packageconfigoption[1]']").val();
                    var trialproducts = $("select[name='packageconfigoption[7]']");
                    trialproducts.empty().append(options[magtrialproduct]);
                }
                if ($("select[name='packageconfigoption[3]']").val() === 'engdevice') {
                    var engtrialproduct = 'engtrialproduct' + $("select[name='packageconfigoption[1]']").val();
                    var trialproducts = $("select[name='packageconfigoption[7]']");
                    trialproducts.empty().append(options[engtrialproduct]);
                }
                $("#tblModuleSettings tbody tr td").filter(function () {
                    return $(this).text() === "Select Package";
                }).html('<td class="fieldlabel" width="20%" id="loveysingh"></td>');
                $("select[name='packageconfigoption[8]']").hide();
                $("#tblModuleSettings tbody tr td").filter(function () {
                    return $(this).text() === "Select Trial Package";
                }).show();
                $("select[name='packageconfigoption[7]']").parent().show();
            } else {
                if ($("select[name='packageconfigoption[3]']").val() === 'streamlineonly') {
                    var lineproduct = 'lineproduct' + $("select[name='packageconfigoption[1]']").val();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append(options[lineproduct]);
                }
                if ($("select[name='packageconfigoption[3]']").val() === 'magdevice') {
                    var magproduct = 'magproduct' + $("select[name='packageconfigoption[1]']").val();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append(options[magproduct]);
                }
                if ($("select[name='packageconfigoption[3]']").val() === 'engdevice') {
                    var engproduct = 'engproduct' + $("select[name='packageconfigoption[1]']").val();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append(options[engproduct]);
                }
                $("#tblModuleSettings tbody tr td").filter(function () {
                    return $(this).text() === "Select Package";
                }).show();
                    $("#loveysingh").html('Select Package');
                    
                $("select[name='packageconfigoption[8]']").show();
                    
                $("#tblModuleSettings tbody tr td").filter(function () {
                    return $(this).text() === "Select Trial Package";
                }).hide();
                $("select[name='packageconfigoption[7]']").parent().hide(); 
            } 
        }

        function packageinfoselected() {
                    var packageinfo = $productinfo;
            if ($("select[name='packageconfigoption[5]']").val() === 'trial') {
                var packgeinfordetails = $("select[name='packageconfigoption[7]']").val();
                if (packgeinfordetails !== null) {
                    $("#package_info").parent().show();
                    $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "Product Details";
                    }).show();
                    var data = 'info' + $("select[name='packageconfigoption[7]']").val();
                    $("#package_info").replaceWith(packageinfo[data]);
                } else {
                    var producttrial = $("select[name='packageconfigoption[7]']");
                    producttrial.empty().append("<option>No Product Found</option>");
                    $("#package_info").parent().hide();
                    $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "Product Details";
                    }).hide();
                }
            } else {
                var packgeinfordetails = $("select[name='packageconfigoption[8]']").val();
                if (packgeinfordetails !== null) {
                    $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "Product Details";
                    }).show();
                    $("#package_info").parent().show();
                    var data = 'info' + $("select[name='packageconfigoption[8]']").val();
                    $("#package_info").replaceWith(packageinfo[data]);
                } else {
                    $("#package_info").parent().hide();
                    $("#tblModuleSettings tbody tr td").filter(function () {
                        return $(this).text() === "Product Details";
                    }).hide();
                    var productorg = $("select[name='packageconfigoption[8]']");
                    productorg.empty().append("<option>No Product Found</option>");
                }
            }

        }
        changeLineType();
        packageinfoselected();
                    hideextrafields();
        var usersinfo = 'users' + $("select[name='packageconfigoption[1]']").val();
        $("#usersinfo").replaceWith(options[usersinfo]);
    });
</script>
HTML;
        }
    }
}

?>