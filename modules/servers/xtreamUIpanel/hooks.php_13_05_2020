<?php
use Illuminate\Database\Capsule\Manager as Capsule;
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

function xtreamUIResellercheckmodule($product_id)
{
	$config = WHMCS\Database\Capsule::table('tblproducts')->where('servertype', '=', 'xtreamUIpanel')->where('id', '=', $product_id)->get();
	return $config;
}

add_hook('AdminAreaFooterOutput', 1, function($vars) {
	$head_return = '';

	if ($vars['filename'] == 'configproducts') {
		if ($_REQUEST['action'] == 'edit') {
			$sitekey = '';
			$check = xtreamUIResellercheckmodule($_REQUEST['id']);
			if (isset($check) && !empty($check)) {
				$productID = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 'Undefined');
				$productdetailsare = WHMCS\Database\Capsule::table('tblproducts')->where('id', $productID)->get();
				$productType = $productdetailsare[0]->type;
				$checkcaptcha = (isset($productdetailsare[0]->configoption15) ? $productdetailsare[0]->configoption15 : '');
				$checkcaptcha = '';
				$selectedtrail = $selectedoffical = '';

				if ($checkcaptcha == 'on') {
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

					$checkselected = (isset($productdetailsare[0]->configoption3) ? $productdetailsare[0]->configoption3 : '');
					if (isset($checkselected) && !empty($checkselected)) {
						$selectedoffical = ($checkselected == 'official' ? 'selected=selected' : '');
						$selectedtrail = ($checkselected == 'trial' ? 'selected=selected' : '');
					}
				}

				$head_return .= "\r\n" . '                ' . "\r\n" . '            <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />' . "\r\n" . '            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>' . "\r\n" . '            <script type="text/javascript">' . "\r\n" . '        ' . "\r\n" . '          var $productType = "";' . "\r\n" . '                function tariffPlanForPcakage() {' . "\r\n" . '                    if($("#tab").val() == "3")' . "\r\n" . '                    {' . "\r\n" . '                        checkselval = jQuery("select[name=\'packageconfigoption[3]\']").val();' . "\r\n" . '                        var checkvalidation = checklinetypeisvalid();' . "\r\n" . '                        if(checkvalidation == "" || checkselval == "")' . "\r\n" . '                        {' . "\r\n" . '                            jQuery("select[name=\'packageconfigoption[3]\']").css("border","1px solid red");' . "\r\n" . '                            $("html, body").animate({' . "\r\n" . '                            scrollTop: jQuery("select[name=\'packageconfigoption[3]\']").offset().top - 20' . "\r\n" . '                            }, "slow");' . "\r\n" . '                            $("#errorline").show();' . "\r\n" . '                            setTimeout(function(){ $("#errorline").hide(); }, 1500);' . "\r\n" . '                        }' . "\r\n" . '                        else' . "\r\n" . '                        {' . "\r\n" . '                            ' . "\r\n" . '                            if ($("#conf-dialog").is(":data(dialog)"))' . "\r\n" . '                            {' . "\r\n" . '                                $("#conf-dialog").dialog("destroy");' . "\r\n" . '                            }' . "\r\n" . '                            $("#conf-dialog").attr("title", " Packages ");' . "\r\n" . '                            $("#conf-dialog").html("<p style=\\"text-align:center\\"><img src=\\"images/loading.gif\\" alt=\\"loading...\\"/></p>");' . "\r\n" . '                            $("#conf-dialog").dialog({minWidth: 650}); ' . "\r\n" . '                            var producttype = jQuery("select[name=\'packageconfigoption[2]\']").val();' . "\r\n" . '                            var bouquetval = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                            rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                            rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                            rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                            currentval = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                            selectedliyetype = jQuery("select[name=\'packageconfigoption[3]\']").val();' . "\r\n" . '                            var SecVar = "load-package-addon";' . "\r\n" . '                            jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php",{action:"get-packages",id:"' . $_REQUEST['id'] . '",username: rcusername, password: rcpassword, xc_url: rcurl,sectionIs:SecVar,currentval:currentval,producttype:producttype,selectedliyetype:selectedliyetype}, function(data){' . "\r\n" . '                            $("#conf-dialog").html(data);' . "\r\n\r\n" . '                            $( ".commanradioselector" ).bind( "click", function() {' . "\r\n" . '                            packgetid = $(this).val();' . "\r\n" . '                            if(packgetid != "")' . "\r\n" . '                            {' . "\r\n" . '                            $(".btnsectopn").addClass("hide");' . "\r\n" . '                            $(".packagecontainssec").html("");' . "\r\n" . '                            $(".packagecontainssec").addClass("hide");' . "\r\n" . '                            $(".btnsecof-"+packgetid).removeClass("hide");' . "\r\n" . '                            $(".onlybtn-"+packgetid).removeClass("hide");' . "\r\n" . '                            }' . "\r\n" . '                            });' . "\r\n\r\n\r\n" . '                            $( "#save" ).bind( "click", function() {' . "\r\n" . '                            selectedval = $("input[name=packid]:checked").val()+"|"+$("input[name=packid]:checked").data("valis"); ' . "\r\n" . '                            jQuery("input[name=\'packageconfigoption[4]\']").val(selectedval);' . "\r\n" . '                            $("#conf-dialog").dialog("destroy");' . "\r\n" . '                            $("#conf-dialog").hide();' . "\r\n\r\n" . '                            });' . "\r\n" . '                            });' . "\r\n\r\n" . '                        }                    ' . "\r\n" . '                    }' . "\r\n" . '                }' . "\r\n" . '                 function tariffPlanForReseller() { ' . "\r\n" . '                    if ($("#conf-dialog").is(":data(dialog)"))' . "\r\n" . '                        {' . "\r\n" . '                            $("#conf-dialog").dialog("destroy");' . "\r\n" . '                        }' . "\r\n" . '                        $("#conf-dialog").attr("title", " Packages ");' . "\r\n" . '                        $("#conf-dialog").html("<p style=\\"text-align:center\\"><img src=\\"images/loading.gif\\" alt=\\"loading...\\"/></p>");' . "\r\n" . '                        $("#conf-dialog").dialog({minWidth: 650}); ' . "\r\n" . '                    var producttype = jQuery("select[name=\'packageconfigoption[2]\']").val();' . "\r\n" . '                    var bouquetval = jQuery("input[name=\'packageconfigoption[18]\']").val();' . "\r\n" . '                    rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                    rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                    rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                    currentval = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                    var SecVar = "load-package-addon";' . "\r\n" . '                    jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php",{action:"get-packages-reseller",id:"' . $_REQUEST['id'] . '",username: rcusername, password: rcpassword, xc_url: rcurl,sectionIs:SecVar,currentval:currentval,producttype:producttype}, function(data){' . "\r\n" . '                          $("#conf-dialog").html(data);  ' . "\r\n" . '                           $( "#savechanges" ).bind( "click", function() {' . "\r\n" . '                               ' . "\r\n" . '            var favorite = [];' . "\r\n" . '            $.each($("input[name=\'packagesreseller\']:checked"), function(){            ' . "\r\n" . '                favorite.push($(this).val());' . "\r\n" . '            }); ' . "\r\n" . '                                jQuery("input[name=\'packageconfigoption[18]\']").val(favorite.join(","));' . "\r\n" . '                                $("#conf-dialog").dialog("destroy");' . "\r\n" . '                                $("#conf-dialog").hide();' . "\r\n" . '                                $("#savedlineis").val("");' . "\r\n" . '                                $("#ladedonce").val(""); ' . "\r\n" . '                            });' . "\r\n" . '                        });' . "\r\n" . '                }' . "\r\n" . '                function tariffPlanForPcakagerecphacha() {' . "\r\n" . '                    if ($("#conf-dialog").is(":data(dialog)"))' . "\r\n" . '                        {' . "\r\n" . '                            $("#conf-dialog").dialog("destroy");' . "\r\n" . '                        }' . "\r\n" . '                        $("#conf-dialog").attr("title", " Packages ");' . "\r\n" . '                        $("#conf-dialog").html("<p style=\\"text-align:center\\"><img src=\\"images/loading.gif\\" alt=\\"loading...\\"/></p>");' . "\r\n" . '                        $("#conf-dialog").dialog({minWidth: 650}); ' . "\r\n" . '                     var producttype = jQuery("select[name=\'packageconfigoption[2]\']").val();    ' . "\r\n" . '                    var bouquetval = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                    rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                    rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                    rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                    currentval = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                     rcrecaptcha = jQuery("#g-recaptcha-response").val();' . "\r\n" . '                    jQuery(\'#recaptchaproduct\').modal(\'hide\');' . "\r\n" . '                    var SecVar = "load-package-addon";' . "\r\n" . '                    jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php",{action:"get-packages",id:"' . $_REQUEST['id'] . '",username: rcusername, password: rcpassword, xc_url: rcurl,sectionIs:SecVar,currentval:currentval,recaptcha:rcrecaptcha,producttype:producttype}, function(data){' . "\r\n" . '                           $("#conf-dialog").html(data);' . "\r\n" . '                           ' . "\r\n" . '                           $( ".commanradioselector" ).bind( "click", function() {' . "\r\n" . '                                packgetid = $(this).val();' . "\r\n" . '                                if(packgetid != "")' . "\r\n" . '                                {' . "\r\n" . '                                    $(".btnsectopn").addClass("hide");' . "\r\n" . '                                    $(".packagecontainssec").html("");' . "\r\n" . '                                    $(".packagecontainssec").addClass("hide");' . "\r\n" . '                                    $(".btnsecof-"+packgetid).removeClass("hide");' . "\r\n" . '                                    $(".onlybtn-"+packgetid).removeClass("hide");' . "\r\n" . '                                }' . "\r\n" . '                           });' . "\r\n" . '                           $( ".showpackagecontainbtn" ).bind( "click", function() {' . "\r\n" . '                                packgetid = $(this).data("packgetid");' . "\r\n" . '                                varthis = $(this);' . "\r\n" . '                                if(packgetid != "")' . "\r\n" . '                                {' . "\r\n" . '                                    varthis.text("Loading....");' . "\r\n" . '                                    varthis.prop("disabled", true);' . "\r\n" . '                                    rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                                    rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                                    rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                                    currentval = packgetid; ' . "\r\n" . '                                    if(typeof rcurl !== "undefined" && typeof rcusername !== "undefined" && typeof rcpassword !== "undefined")' . "\r\n" . '                                        {' . "\r\n" . '                                            jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php", {action: "getPackagecontains", username: rcusername, password: rcpassword, xc_url: rcurl,packgetid:packgetid}, function (data) {' . "\r\n" . '                                                varthis.prop("disabled", false);' . "\r\n" . '                                                $(".onlybtn-"+packgetid).text("Show Contains packages");' . "\r\n" . '                                                $(".onlybtn-"+packgetid).addClass("hide");' . "\r\n" . '                                                $(".containsecof-"+packgetid).html(data);' . "\r\n" . '                                                $(".containsecof-"+packgetid).removeClass("hide");' . "\r\n" . '                                            });' . "\r\n" . '                                        }   ' . "\r\n" . '                                }' . "\r\n" . '                            });' . "\r\n\r\n" . '$( "#save" ).bind( "click", function() {' . "\r\n" . '                               selectedval = $("input[name=packid]:checked").val()+"|"+$("input[name=packid]:checked").data("valis"); ' . "\r\n" . '                                jQuery("input[name=\'packageconfigoption[4]\']").val(selectedval);' . "\r\n" . '                                $("#conf-dialog").dialog("destroy");' . "\r\n" . '                                $("#conf-dialog").hide();' . "\r\n" . '                                 $("#savedlineis").val("");' . "\r\n" . '                                 $("#ladedonce").val("");' . "\r\n" . '                                if(jQuery("input[name=\'packageconfigoption[15]\']").is(":checked")){}else{' . "\r\n" . '                                getLineTypeByselectedPackage("getData");}' . "\r\n" . '                            });' . "\r\n" . '                        });' . "\r\n" . '                        grecaptcha.reset();' . "\r\n" . '                }' . "\r\n" . '               function customfield(){  ' . "\r\n" . '               if($("#conf-dialog-custom-field").is(":data(dialog)"))' . "\r\n" . '                        {' . "\r\n" . '                            $("#conf-dialog-custom-field").dialog("destroy"); ' . "\r\n" . '                        }' . "\r\n" . '                        $("#conf-dialog-custom-field").attr("title", "Product Custom Fields");' . "\r\n" . '                        $("#conf-dialog-custom-field").html("<p style=\\"text-align:center\\"><img src=\\"images/loading.gif\\" alt=\\"loading...\\"/></p>");' . "\r\n" . '                        $("#conf-dialog-custom-field").dialog({minWidth: 650}); ' . "\r\n" . '                        val = $(this).parent().find("input").val(); ' . "\r\n" . '                        var selectedoption = jQuery("select[name=\'packageconfigoption[2]\']").val();' . "\r\n" . '                        var ispasswordeditable = "";' . "\r\n" . '                        if(jQuery("input[name=\'packageconfigoption[17]\']").is(":checked"))' . "\r\n" . '                        {' . "\r\n" . '                            ispasswordeditable = "on";' . "\r\n" . '                        }' . "\r\n\r\n" . '                         jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php",{stormajax:"create-config",id:"' . $_REQUEST['id'] . '",conf_id:"' . $_REQUEST['conf_id'] . '",selected_conf_id:selectedoption,ispasswordeditable:ispasswordeditable}, function(data){' . "\r\n" . '                            $("#conf-dialog-custom-field").html(data);' . "\r\n" . '                        });' . "\r\n" . '                   } ' . "\r\n" . '               function testconnectionfunction(){' . "\r\n" . '                    jQuery("#conf-dialog-custom-field2").hide();' . "\r\n" . '                    rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                    rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                    rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                    jQuery("#loader_div").show();' . "\r\n" . '                    jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php", {action: "test_connection", username: rcusername, password: rcpassword, xc_url: rcurl}, function (data) {' . "\r\n" . '                        jQuery("#loader_div").hide();' . "\r\n" . '                        jQuery("#conf-dialog-custom-field2").show();' . "\r\n" . '                        $("#conf-dialog-custom-field2").html(data);' . "\r\n" . '                        $("#ladedonce").val("");' . "\r\n" . '                       getLineTypeByselectedPackage("getdata");' . "\r\n" . '                    });' . "\r\n" . '                   } ' . "\r\n" . '                    function testconnectionrecaptcha(){  ' . "\r\n" . '                    jQuery("#conf-dialog-custom-field2").hide();' . "\r\n" . '                    if($productType == "reselleraccount")' . "\r\n" . '                    {' . "\r\n" . '                    rcurl = jQuery("input[name=\'packageconfigoption[3]\']").val();' . "\r\n" . '                    rcusername = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                    rcpassword = jQuery("input[name=\'packageconfigoption[5]\']").val();' . "\r\n" . '                    }' . "\r\n" . '                    else' . "\r\n" . '                    {' . "\r\n" . '                    rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                    rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                    rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                    }' . "\r\n" . '                    rcrecaptcha = jQuery("#g-recaptcha-response-1").val();' . "\r\n" . '                    jQuery(\'#recaptcha\').modal(\'hide\');' . "\r\n" . '                     jQuery("#loader_div").show(); ' . "\r\n" . '                    jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php", {action: "test_connection", username: rcusername, password: rcpassword, xc_url: rcurl,recaptcha:rcrecaptcha}, function (data) {' . "\r\n" . '                        jQuery("#loader_div").hide();' . "\r\n" . '                        jQuery("#conf-dialog-custom-field2").show();' . "\r\n" . '                        $("#conf-dialog-custom-field2").html(data);' . "\r\n" . '                         $("#ladedonce").val("");   ' . "\r\n" . '                            grecaptcha.reset();' . "\r\n" . '                    });' . "\r\n" . '                   } ' . "\r\n" . '                   ' . "\r\n" . '                   /*----------------------Reseller------------------------------*/' . "\r\n" . '               function testconnectionfunctionReseller(){' . "\r\n" . '               ' . "\r\n" . '                    jQuery("#conf-dialog-custom-field2").hide();' . "\r\n" . '                    rcurl = jQuery("input[name=\'packageconfigoption[3]\']").val();' . "\r\n" . '                    rcusername = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                    rcpassword = jQuery("input[name=\'packageconfigoption[5]\']").val();' . "\r\n" . '                    jQuery("#loader_div").show();' . "\r\n" . '                    jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php", {action: "test_connection", username: rcusername, password: rcpassword, xc_url: rcurl}, function (data) {' . "\r\n" . '                        jQuery("#loader_div").hide();' . "\r\n" . '                        jQuery("#conf-dialog-custom-field2").show();' . "\r\n" . '                        $("#conf-dialog-custom-field2").html(data);' . "\r\n" . '                        $("#ladedonce").val("");' . "\r\n" . '                       getLineTypeByselectedPackage("getdata");' . "\r\n" . '                    });' . "\r\n" . '                   } ' . "\r\n\r\n" . '              </script>' . "\r\n" . '              <div id="conf-dialog-custom-field" title="">' . "\r\n" . '              </div>';

				if ($checkcaptcha == 'on') {
					$head_return .= "\r\n" . '                  <script src="https://www.google.com/recaptcha/api.js" async defer></script>';
				}

				$head_return .= ' ' . "\r\n" . '            <script type="text/javascript">' . "\r\n" . '    jQuery(document).ready(function () { ' . "\r\n" . '          $("input[value=\'Save Changes\']").click(function(e) {' . "\r\n" . '                if($("#tab").val() == "3")' . "\r\n" . '                {' . "\r\n" . '                    var checkvalidation = checklinetypeisvalid();' . "\r\n" . '                    if(checkvalidation == "")' . "\r\n" . '                    {' . "\r\n" . '                        jQuery("select[name=\'packageconfigoption[3]\']").css("border","1px solid red");' . "\r\n" . '                        $("html, body").animate({' . "\r\n" . '                                scrollTop: jQuery("select[name=\'packageconfigoption[3]\']").offset().top - 20' . "\r\n" . '                            }, "slow");' . "\r\n" . '                        $("#errorline").show();' . "\r\n" . '                        setTimeout(function(){ $("#errorline").hide(); }, 1500);' . "\r\n" . '                        e.preventDefault();' . "\r\n" . '                    }                    ' . "\r\n" . '                }' . "\r\n" . '            });' . "\r\n" . '        jQuery(document).ajaxComplete(function () {' . "\r\n\r\n" . '            checkeditablepermission();' . "\r\n\r\n" . '              $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '                    return $(this).text() === "Is Captcha Enabled";' . "\r\n" . '                }).hide();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[16]\']").attr("readonly", "readonly");' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[15]\']").parent().parent().parent().hide();' . "\r\n" . '       ' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[11]\']").focus(function() {' . "\r\n" . '              jQuery("#passwordval").addClass("notsave");' . "\r\n" . '            });' . "\r\n" . '            if (!jQuery("#passwordval").hasClass("notsave")) {' . "\r\n" . '                 var onloadpasswordvalue = jQuery("#passwordval").val();' . "\r\n" . '                jQuery("input[name=\'packageconfigoption[11]\']").val(onloadpasswordvalue);' . "\r\n" . '                 var selectedoption=jQuery("select[name=\'packageconfigoption[2]\']").val();' . "\r\n" . '            } ' . "\r\n" . '            if(1 == 2){' . "\r\n" . '            jQuery("select[name=\'packageconfigoption[3]\']").addClass("linetypeseletor");' . "\r\n" . '               ' . "\r\n" . '        jQuery("select[name=\'packageconfigoption[3]\']").html(\'<option value="">--</option><option ' . $selectedoffical . ' value="official">Official Use</option><option ' . $selectedtrail . '  value="trial">Trial</option></select>\');' . "\r\n" . '        jQuery("#TestConnectionBTN").attr("onclick","jQuery(\'#recaptcha\').modal(\'show\');");' . "\r\n" . '        jQuery("#load-package-addon").attr("onclick","jQuery(\'#recaptchaproduct\').modal(\'show\');");' . "\r\n" . '        jQuery("#creditdDataContainer").hide();' . "\r\n" . '        jQuery("#creditdDataContainer1").hide();' . "\r\n" . '        jQuery("#creditdDataContainer").hide();' . "\r\n" . '         jQuery(".showpackagecontainbtn").hide();' . "\r\n" . '        ' . "\r\n" . '        }else{' . "\r\n" . '        getLineTypeByselectedPackage("getData");' . "\r\n" . '        }' . "\r\n" . '             enablefieldinxtream(selectedoption)' . "\r\n" . '            jQuery("select[name=\'packageconfigoption[2]\']").change(function () {' . "\r\n" . '                enablefieldinxtream(this.value);' . "\r\n" . '            }); ' . "\r\n" . '             $productType = "' . $productType . '";' . "\r\n" . '            ' . "\r\n" . '            if($productType !== "reselleraccount"){' . "\r\n" . '             jQuery("input[name=\'packageconfigoption[4]\']").attr("readonly", "readonly");' . "\r\n" . '             }' . "\r\n" . '        });' . "\r\n" . '    });' . "\r\n\r\n" . '    function checkeditablepermission()' . "\r\n" . '    {' . "\r\n" . '        console.log("checking");' . "\r\n" . '        if(jQuery("input[name=\'packageconfigoption[18]\']").is(":checked"))' . "\r\n" . '        {' . "\r\n" . '            $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '                return $(this).text() === "Is Password Editable";' . "\r\n" . '            }).show();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[17]\']").parent().show();' . "\r\n" . '          ' . "\r\n" . '           ' . "\r\n" . '        }' . "\r\n" . '        else' . "\r\n" . '        {' . "\r\n\r\n" . '             $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '                return $(this).text() === "Is Password Editable";' . "\r\n" . '            }).hide();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[17]\']").parent().hide();' . "\r\n" . '        }' . "\r\n" . '    }' . "\r\n\r\n" . '    function checklinetypeisvalid(){' . "\r\n" . '        onloadgetlinetypevalue = $(".linetypeseletor").val();' . "\r\n" . '        onloadgetlineText = $(".linetypeseletor option:selected").text();' . "\r\n" . '        validatebutton = "";' . "\r\n" . '        if(onloadgetlinetypevalue == "official" || onloadgetlinetypevalue == "trial")' . "\r\n" . '        {' . "\r\n" . '            jQuery("select[name=\'packageconfigoption[3]\']").css("border","none");' . "\r\n" . '            validatebutton = "1";' . "\r\n" . '        }' . "\r\n\r\n" . '        if(onloadgetlineText == "--")' . "\r\n" . '        {' . "\r\n" . '            validatebutton = "";' . "\r\n" . '        }' . "\r\n" . '        else' . "\r\n" . '        {' . "\r\n" . '            validatebutton = "1";' . "\r\n" . '        }' . "\r\n" . '        return validatebutton;' . "\r\n" . '    } ' . "\r\n\r\n" . '    function getLineTypeByselectedPackage(command = ""){   ' . "\r\n" . '        ladedonce = $("#ladedonce").val();' . "\r\n" . '        if(typeof ladedonce !== "undefined" )' . "\r\n" . '        {' . "\r\n" . '            if(ladedonce == "")' . "\r\n" . '            {' . "\r\n" . '                if(command == "getData")' . "\r\n" . '                {   ' . "\r\n" . '                    jQuery("select[name=\'packageconfigoption[3]\']").addClass("linetypeseletor");' . "\r\n" . '                    jQuery("select[name=\'packageconfigoption[3]\']").hide();' . "\r\n" . '                    jQuery("#loadinglinetype").html("Loading Data...");' . "\r\n" . '                    jQuery("#loadinglinetype").show();' . "\r\n" . '                    savedlineis = jQuery("#savedlineis").val();' . "\r\n" . '                    packageID = jQuery("input[name=\'packageconfigoption[4]\']").val();' . "\r\n" . '                    if($productType !== "reselleraccount")' . "\r\n" . '                    {' . "\r\n" . '                     rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                        rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                        rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                    }' . "\r\n" . '                    else' . "\r\n" . '                    {' . "\r\n" . '                        rcurl = jQuery("input[name=\'packageconfigoption[9]\']").val();' . "\r\n" . '                        rcusername = jQuery("input[name=\'packageconfigoption[10]\']").val();' . "\r\n" . '                        rcpassword = jQuery("input[name=\'packageconfigoption[11]\']").val();' . "\r\n" . '                    }' . "\r\n" . '                    if(typeof rcurl !== "undefined" && typeof rcusername !== "undefined" && typeof rcpassword !== "undefined")' . "\r\n" . '                    {' . "\r\n" . '                        if(packageID != "")' . "\r\n" . '                        {' . "\r\n" . '                            jQuery.post("../modules/servers/xtreamUIpanel/XtreamConfig.php", {action: "getlinetype", username: rcusername, password: rcpassword, xc_url: rcurl, packageid: packageID,savedlineis:savedlineis}, function (data) {' . "\r\n" . '                                var obj = jQuery.parseJSON(data); ' . "\r\n" . '                                console.log(obj);' . "\r\n" . '                                $("#ladedonce").val("ajaxloaded");' . "\r\n\r\n" . '                                   if(obj.creditsare != "")' . "\r\n" . '                                   {' . "\r\n" . '                                        $("#creditdDataContainer").html(obj.creditsare);' . "\r\n" . '                                   }' . "\r\n\r\n" . '                                   if(obj.reseller_id != "")' . "\r\n" . '                                   {' . "\r\n" . '                                    jQuery("input[name=\'packageconfigoption[16]\']").val(obj.reseller_id);' . "\r\n" . '                                   }' . "\r\n\r\n" . '                                   if(obj.linetype != "")' . "\r\n" . '                                   {' . "\r\n" . '                                    jQuery("#loadinglinetype").hide();' . "\r\n" . '                                    jQuery("select[name=\'packageconfigoption[3]\']").show(); ' . "\r\n" . '                                    jQuery("select[name=\'packageconfigoption[3]\']").html("");' . "\r\n" . '                                    jQuery("select[name=\'packageconfigoption[3]\']").append(obj.linetype);' . "\r\n" . '                                   }' . "\r\n" . '                                   else' . "\r\n" . '                                   {' . "\r\n" . '                                        jQuery("select[name=\'packageconfigoption[3]\']").show(); ' . "\r\n" . '                                        jQuery("select[name=\'packageconfigoption[3]\']").html("<option>No Line Found</option>");' . "\r\n" . '                                        jQuery("#loadinglinetype").html("<br><br>Select Valid Package");' . "\r\n" . '                                        jQuery("#loadinglinetype").show();' . "\r\n" . '                                   }' . "\r\n" . '                                });' . "\r\n" . '                        }' . "\r\n" . '                    }' . "\r\n" . '                } ' . "\r\n" . '            }' . "\r\n" . '        } ' . "\r\n" . '    }' . "\r\n\r\n" . '    function enablefieldinxtream($value)' . "\r\n" . '    {' . "\r\n" . '         if ($value == "streamlineonly") ' . "\r\n" . '         { ' . "\r\n" . '            showallconfigfirst();' . "\r\n" . '            $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '                return $(this).text() === "Credits" || $(this).text() === "Assign Packages";' . "\r\n" . '            }).hide();' . "\r\n" . '            $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '                return $(this).text() === "MAG Portal" || $(this).text() === "Is Password Editable" || $(this).text() === "Is Username Editable";' . "\r\n" . '            }).show();' . "\r\n" . '            jQuery("select[name=\'packageconfigoption[3]\']").show();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[12]\']").parent().show();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[15]\']").parent().show();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[16]\']").parent().show(); ' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[17]\']").parent().show(); ' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[18]\']").parent().show(); ' . "\r\n" . '           ' . "\r\n" . '            ' . "\r\n" . '        }' . "\r\n" . '        else if($value == "magdevice")' . "\r\n" . '        {' . "\r\n" . '            showallconfigfirst();' . "\r\n" . '            $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '                return $(this).text() === "AutoScript Section" || $(this).text() === "Other Device Section" || $(this).text() === "Max Con."|| $(this).text() === "Watch Streams!"|| $(this).text() === "M3U link"' . "\r\n" . '            || $(this).text() === "Credits" || $(this).text() === "Assign Packages" || $(this).text() === "Is Password Editable" || $(this).text() === "Is Username Editable";' . "\r\n" . '            }).hide();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[5]\']").parent().hide();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[6]\']").parent().hide();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[8]\']").parent().hide();' . "\r\n" . '            jQuery("select[name=\'packageconfigoption[3]\']").show();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[18]\']").parent().hide();' . "\r\n" . '            jQuery("input[name=\'packageconfigoption[17]\']").parent().hide();' . "\r\n" . '        }' . "\r\n" . '    }' . "\r\n" . '    function showallconfigfirst() {' . "\r\n" . '        $("#tblModuleSettings tbody tr td").filter(function () {' . "\r\n" . '            return $(this).text() === "MAG Portal link" || $(this).text() === "Max Con."|| $(this).text() === "Watch Streams!"|| $(this).text() === "M3U link" || $(this).text() === "Assign Packages" || $(this).text() === "Select Line Type" || $(this).text() === "Other Device Section" || $(this).text() === "Select Package" || $(this).text() === "Credits" || $(this).text() === "Is Username Editable" || $(this).text() === "Is Password Editable";' . "\r\n" . '        }).show();' . "\r\n\r\n" . '        jQuery("input[name=\'packageconfigoption[3]\']").parent().show(); ' . "\r\n" . '        jQuery("input[name=\'packageconfigoption[4]\']").parent().show(); ' . "\r\n" . '        jQuery("input[name=\'packageconfigoption[5]\']").parent().show(); ' . "\r\n" . '        jQuery("input[name=\'packageconfigoption[6]\']").parent().show(); ' . "\r\n" . '        jQuery("input[name=\'packageconfigoption[7]\']").parent().show();' . "\r\n" . '        jQuery("input[name=\'packageconfigoption[8]\']").parent().show();  ' . "\r\n" . '         jQuery("input[name=\'packageconfigoption[9]\']").parent().show();' . "\r\n" . '         jQuery("input[name=\'packageconfigoption[17]\']").parent().show();' . "\r\n" . '        jQuery("input[name=\'packageconfigoption[18]\']").parent().show();' . "\r\n" . '    } ' . "\r\n" . '</script>' . "\r\n" . '              <div id="conf-dialog" title="">' . "\r\n" . '              </div>' . "\r\n" . '              <div id="conf-dialog2" title="">' . "\r\n" . '              </div>' . "\r\n\r\n" . '            <div class="modal fade" id="recaptchaproduct" role="dialog" aria-labelledby="ModuleUnsuspendLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="recaptchaHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleUnsuspendLabel">Confirm ReCaptcha</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="recaptchaBody" class="modal-body panel-body">  ' . "\r\n" . '            <div class="margin-top-bottom-20 text-center">' . "\r\n" . '                                         <center>          <div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="' . $sitekey . '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div></center>' . "\r\n\r\n" . '            </div>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="recaptchaFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleUnsuspend-Yes" class="btn btn-primary" onclick="tariffPlanForPcakagerecphacha()">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleUnsuspend-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div> ' . "\r\n" . '            <div class="modal fade" id="recaptcha" role="dialog" aria-labelledby="ModuleUnsuspendLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="recaptchaHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleUnsuspendLabel">Confirm ReCaptcha</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="recaptchaBody" class="modal-body panel-body">  ' . "\r\n" . '            <div class="margin-top-bottom-20 text-center">' . "\r\n" . '                                         <center>          <div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="' . $sitekey . '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div></center>' . "\r\n\r\n" . '            </div>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="recaptchaFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleUnsuspend-Yes" class="btn btn-primary" onclick="testconnectionrecaptcha()">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleUnsuspend-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div> ' . "\r\n";
			}
		}
	}

	return $head_return;
});
add_hook('ClientAreaHeadOutput', 1, function($vars) {
	if (isset($vars['action']) && ($vars['action'] == 'checkout')) {
		$productID = (isset($vars['products'][0]['pid']) ? $vars['products'][0]['pid'] : 'Undefined');
		$productdetailsare = WHMCS\Database\Capsule::table('tblproducts')->where('id', $productID)->get();
		$checkcaptcha = (isset($productdetailsare[0]->configoption15) ? $productdetailsare[0]->configoption15 : '');
		$checkcaptcha = '';

		if ($checkcaptcha == 'on') {
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

			return '      <script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\r\n" . '    <script>' . "\r\n" . '        $(document).ready(function () {' . "\r\n" . '            $("#btnCompleteOrder").hide();' . "\r\n" . '            $("#btnCompleteOrder").parent().prepend(\'<div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="' . $sitekey . '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>\');' . "\r\n" . '            $("#btnCompleteOrder").parent().append(\'<button type="button" id="btnlovey" class="btn btn-primary btn-lg"> Validate &nbsp;<i class="fa fa-check-circle"></i></button>\');' . "\r\n" . '            $("#btnlovey").click(function () {' . "\r\n" . '                var src = $("#g-recaptcha-response").val();' . "\r\n" . '                if (src !== \'\') {' . "\r\n" . '                    $.post("modules/servers/xtreamUIpanel/XtreamConfig.php", {"recaptcha": src, "action": "get-recaptcha"});' . "\r\n" . '                    $("#btnlovey").hide();' . "\r\n" . '                    $("#btnCompleteOrder").show();' . "\r\n" . '                } else {' . "\r\n" . '                     $("#loveyerror").hide(); ' . "\r\n" . '                    $("#btnCompleteOrder").parent().prepend(\'<p id="loveyerror" style="color:red">Please check the reCAPTCHA<p>\');' . "\r\n" . '                }' . "\r\n" . '            });' . "\r\n" . '        });' . "\r\n\r\n" . '    </script>';
		}
	}
});
add_hook('AdminClientServicesTabFields', 1, function($vars) {
	if ($vars['id'] != '') {
		$HostingDataFromId = WHMCS\Database\Capsule::table('tblhosting')->where('id', $vars['id'])->get();
		$productID = (isset($HostingDataFromId[0]->packageid) ? $HostingDataFromId[0]->packageid : 'Undefined');
		$productdetailsare = WHMCS\Database\Capsule::table('tblproducts')->where('id', $productID)->get();
		$checkcaptcha = (isset($productdetailsare[0]->configoption15) ? $productdetailsare[0]->configoption15 : '');
		$checkcaptcha = '';

		if ($checkcaptcha == 'on') {
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

			echo '            <script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\r\n" . '            <script type="text/javascript">' . "\r\n" . '                $(document).ready(function () {' . "\r\n" . '                    $("#modalModuleCreate").remove();' . "\r\n" . '                    $("#modalModuleSuspend").remove();' . "\r\n" . '                    $("#modalModuleUnsuspend").remove();' . "\r\n" . '                    $("#modalModuleRenew").remove();' . "\r\n" . '                    $("#recaptcha").remove();' . "\r\n" . '                    $("#modalModuleTerminate").remove();' . "\r\n" . '                    var recaptcha = `<center style="margin-top:10px"><div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="';
			echo $sitekey;
			echo '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>' . "\r\n" . '                          </center>`;' . "\r\n" . '                    $("#modalModuleChangePackage").parent().append(`<div class="modal fade" id="modalModuleCreate" role="dialog" aria-labelledby="ModuleCreateLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="modalModuleCreateHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleCreateLabel">Confirm Module Command</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="modalModuleCreateBody" class="modal-body panel-body">' . "\r\n" . '                            Are you sure you want to run the create function?' . "\r\n" . '               ` + recaptcha + `' . "\r\n" . '                        <div id="modalModuleCreateFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleCreate-Yes" class="btn btn-primary" onclick="recaptchaget(\'create\')">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleCreate-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>`);' . "\r\n\r\n" . '                    //Suspendfunction   ' . "\r\n\r\n" . '                    $("#modalModuleChangePackage").parent().append(`' . "\r\n" . '               <div class="modal fade" id="modalModuleSuspend" role="dialog" aria-labelledby="ModuleSuspendLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="modalModuleSuspendHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleSuspendLabel">Confirm Module Command</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="modalModuleSuspendBody" class="modal-body panel-body">' . "\r\n" . '                            Are you sure you want to run the suspend function?<br>' . "\r\n" . '            <div class="margin-top-bottom-20 text-center">' . "\r\n" . '                                                                                                                                                                                                                                                                                               ' . "\r\n" . '                Suspension Reason:' . "\r\n" . '                <input type="text" id="suspreason" class="form-control input-inline input-300"><br><br>' . "\r\n" . '                <label class="checkbox-inline">' . "\r\n" . '                    <input type="checkbox" id="suspemail">' . "\r\n" . '                    Send Suspension Email' . "\r\n" . '                </label>' . "\r\n" . '            </div> ` + recaptcha + `' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="modalModuleSuspendFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleSuspend-Yes" class="btn btn-primary" onclick="recaptchaget(\'suspend\')">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleSuspend-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>    ' . "\r\n" . '              `);' . "\r\n\r\n" . '                    //UNSuspendfunction ' . "\r\n\r\n" . '                    $("#modalModuleChangePackage").parent().append(`<div class="modal fade" id="modalModuleUnsuspend" role="dialog" aria-labelledby="ModuleUnsuspendLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="recaptchaHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleUnsuspendLabel">Confirm Module Command</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="recaptchaBody" class="modal-body panel-body">' . "\r\n" . '                            Are you sure you want to run the unsuspend function?<br>' . "\r\n" . '                       ` + recaptcha + `' . "\r\n" . '            <div class="margin-top-bottom-20 text-center">' . "\r\n" . '                <label class="checkbox-inline">' . "\r\n" . '                    <input type="checkbox" id="unsuspended_email">' . "\r\n" . '                    Send Unsuspension Email' . "\r\n" . '                </label>' . "\r\n" . '            </div>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="recaptchaFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleUnsuspend-Yes" class="btn btn-primary" onclick="recaptchaget(\'unsuspend\')">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleUnsuspend-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>`);' . "\r\n\r\n\r\n" . '                    //Terminate function ' . "\r\n\r\n" . '                    $("#modalModuleChangePackage").parent().append(`<div class="modal fade" id="modalModuleTerminate" role="dialog" aria-labelledby="ModuleTerminateLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="modalModuleTerminateHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleTerminateLabel">Confirm Module Command</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="modalModuleTerminateBody" class="modal-body panel-body">' . "\r\n" . '                            Are you sure you want to run the terminate function?' . "\r\n" . '                       ` + recaptcha + ` </div>' . "\r\n" . '                                                                                                                                                                                                                                                                                               ' . "\r\n" . '                        <div id="modalModuleTerminateFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleTerminate-Yes" class="btn btn-primary" onclick="recaptchaget(\'terminate\')">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleTerminate-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>`);' . "\r\n" . '                    //Renew function ' . "\r\n\r\n" . '                    $("#modalModuleChangePackage").parent().append(`<div class="modal fade" id="modalModuleRenew" role="dialog" aria-labelledby="ModuleRenewLabel" aria-hidden="true">' . "\r\n" . '                <div class="modal-dialog">' . "\r\n" . '                    <div class="modal-content panel panel-primary">' . "\r\n" . '                        <div id="modalModuleRenewHeading" class="modal-header panel-heading">' . "\r\n" . '                            <button type="button" class="close" data-dismiss="modal">' . "\r\n" . '                                <span aria-hidden="true">×</span>' . "\r\n" . '                                <span class="sr-only">Close</span>' . "\r\n" . '                            </button>' . "\r\n" . '                            <h4 class="modal-title" id="ModuleRenewLabel">Confirm Module Command</h4>' . "\r\n" . '                        </div>' . "\r\n" . '                        <div id="modalModuleRenewBody" class="modal-body panel-body">' . "\r\n" . '                        The remote service provider may charge for renewal of this product.' . "\r\n" . '                        <br>' . "\r\n" . '                        <br>' . "\r\n" . '                        Are you sure you wish to execute a renewal action for this product?' . "\r\n" . '               ` + recaptcha + `' . "\r\n" . '                        <div id="modalModuleRenewFooter" class="modal-footer panel-footer">' . "\r\n" . '                            <button type="button" id="ModuleRenew-Yes" class="btn btn-primary" onclick="recaptchaget(\'renew\')">' . "\r\n" . '                Yes' . "\r\n" . '            </button><button type="button" id="ModuleRenew-No" class="btn btn-default" data-dismiss="modal">' . "\r\n" . '                No' . "\r\n" . '            </button>' . "\r\n" . '                        </div>' . "\r\n" . '                    </div>' . "\r\n" . '                </div>' . "\r\n" . '            </div>`);' . "\r\n" . '                });' . "\r\n" . '                function recaptchaget(action) {' . "\r\n" . '                    if (action === \'create\') {' . "\r\n" . '                        var src = $("#g-recaptcha-response").val();' . "\r\n" . '                    } else if (action === \'terminate\') {' . "\r\n" . '                        var src = $("#g-recaptcha-response-3").val();' . "\r\n" . '                    } else if (action === \'suspend\') {' . "\r\n" . '                        var src = $("#g-recaptcha-response-1").val();' . "\r\n" . '                    } else if (action === \'unsuspend\') {' . "\r\n" . '                        var src = $("#g-recaptcha-response-2").val();' . "\r\n" . '                    } else if (action === \'renew\') {' . "\r\n" . '                        var src = $("#g-recaptcha-response-4").val();' . "\r\n" . '                    }' . "\r\n\r\n" . '                    if (src !== \'\') {' . "\r\n" . '                        $.post("../modules/servers/xtreamUIpanel/XtreamConfig.php", {"recaptcha": src, "action": "get-recaptcha"});' . "\r\n" . '                        if (action === \'create\') {' . "\r\n" . '                            runModuleCommand("create");' . "\r\n" . '                        } else if (action === \'terminate\') {' . "\r\n" . '                            runModuleCommand("terminate");' . "\r\n" . '                        } else if (action === \'suspend\') {' . "\r\n" . '                            runModuleCommand("suspend");' . "\r\n" . '                        } else if (action === \'unsuspend\') {' . "\r\n" . '                            runModuleCommand("unsuspend");' . "\r\n" . '                        } else if (action === \'renew\') {' . "\r\n" . '                            runModuleCommand("renew");' . "\r\n" . '                        }' . "\r\n" . '                    } else {' . "\r\n" . '                        $("#loveyerror").hide();' . "\r\n" . '                        $("#google-recaptcha-domainchecker").parent().prepend(\'<p id="loveyerror" style="color:red">Please check the reCAPTCHA<p>\');' . "\r\n" . '                    }' . "\r\n" . '                }' . "\r\n" . '            </script> ' . "\r\n" . '            ';
		}
	}
});
add_hook('ClientAreaPageViewInvoice', 1, function($vars) {
	$InvoiceID = $vars['invoiceid'];
	$productdetailsare = WHMCS\Database\Capsule::table('tblinvoiceitems')->join('tblhosting', 'tblinvoiceitems.relid', '=', 'tblhosting.id')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->select('tblproducts.*', 'tblhosting.orderid as orderid')->where('tblinvoiceitems.invoiceid', '=', $InvoiceID)->where('tblinvoiceitems.type', 'Hosting')->get();
	$checkcaptcha = (isset($productdetailsare[0]->configoption15) ? $productdetailsare[0]->configoption15 : '');
	$checkcaptcha = '';

	if ($checkcaptcha == 'on') {
		$adminlink = (isset($productdetailsare[0]->configoption9) ? $productdetailsare[0]->configoption9 : '');
		$OrderIDis = (isset($productdetailsare[0]->orderid) ? $productdetailsare[0]->orderid : '');
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

		echo '        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>      ' . "\r\n" . '        <script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\r\n" . '        <script>' . "\r\n" . '            $(document).ready(function () {' . "\r\n" . '                $(".payment-btn-container").hide();' . "\r\n" . '                $(".small-text").first().after(\'<div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="';
		echo $sitekey;
		echo '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>\');' . "\r\n" . '                $("#google-recaptcha-domainchecker").after(\'<button type="button" id="btnlovey" class="btn btn-primary btn-lg"> Validate &nbsp;<i class="fa fa-check-circle"></i></button>\');' . "\r\n" . '                $("#btnlovey").click(function () {' . "\r\n" . '                    $("#loveyerror").hide();' . "\r\n" . '                    var src = $("#g-recaptcha-response").val();' . "\r\n" . '                    if (src !== \'\') {' . "\r\n" . '                        $.post("modules/servers/xtreamUIpanel/XtreamConfig.php", {"recaptcha": src, "action": "get-recaptcha", "orderid": "';
		echo $OrderIDis;
		echo '"});' . "\r\n" . '                        $("#btnlovey").hide();' . "\r\n" . '                        $(".payment-btn-container").show();' . "\r\n" . '                    } else {' . "\r\n" . '                        if ($("#loveyerror").length == 0)' . "\r\n" . '                        {' . "\r\n" . '                            $("#google-recaptcha-domainchecker").after(\'<p id="loveyerror" style="color:red">Please check the reCAPTCHA<p>\');' . "\r\n" . '                        } else' . "\r\n" . '                        {' . "\r\n" . '                            $("#loveyerror").show();' . "\r\n" . '                        }' . "\r\n" . '                    }' . "\r\n" . '                });' . "\r\n\r\n" . '            });' . "\r\n\r\n" . '        </script>' . "\r\n" . '        ';
	}
});
add_hook('ClientAreaPageUpgrade', 1, function($vars) {
	$productIdIS = $vars['upgrades'][0]['newproductid'];
	$productdetailsare = WHMCS\Database\Capsule::table('tblproducts')->where('id', $productIdIS)->get();
	$checkcaptcha = (isset($productdetailsare[0]->configoption15) ? $productdetailsare[0]->configoption15 : '');
	$checkcaptcha = '';

	if ($checkcaptcha == 'on') {
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

		echo '   ' . "\r\n" . '        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>     ' . "\r\n" . '        <script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\r\n" . '        <script>' . "\r\n" . '            $(document).ready(function () {' . "\r\n" . '                $("input[value=\'Click to Continue >>\']").hide();' . "\r\n" . '                $("input[value=\'Click to Continue >>\']").after(\'<div id="google-recaptcha-domainchecker" class="g-recaptcha center-block" data-sitekey="';
		echo $sitekey;
		echo '" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="Required"></div>\');' . "\r\n" . '                $("#google-recaptcha-domainchecker").after(\'<button type="button" id="btnlovey" class="btn btn-primary btn-lg"> Validate &nbsp;<i class="fa fa-check-circle"></i></button>\');' . "\r\n" . '                $("#btnlovey").click(function () {' . "\r\n" . '                    $("#loveyerror").hide();' . "\r\n" . '                    var src = $("#g-recaptcha-response").val();' . "\r\n" . '                    if (src !== \'\') {' . "\r\n" . '                        $.post("modules/servers/xtreamUIpanel/XtreamConfig.php", {"recaptcha": src, "action": "get-recaptcha"});' . "\r\n" . '                        $("#btnlovey").hide();' . "\r\n" . '                        $("input[value=\'Click to Continue >>\']").show();' . "\r\n" . '                    } else {' . "\r\n" . '                        if ($("#loveyerror").length == 0)' . "\r\n" . '                        {' . "\r\n" . '                            $("#google-recaptcha-domainchecker").after(\'<p id="loveyerror" style="color:red">Please check the reCAPTCHA<p>\');' . "\r\n" . '                        } else' . "\r\n" . '                        {' . "\r\n" . '                            $("#loveyerror").show();' . "\r\n" . '                        }' . "\r\n" . '                    }' . "\r\n" . '                });' . "\r\n" . '            });' . "\r\n\r\n" . '        </script>' . "\r\n" . '        ';
	}
});

add_hook('AfterShoppingCartCheckout', 1, function($vars){
	$serviceIds = $vars['ServiceIDs'];
	foreach($serviceIds as $serviceId){
			$hData = Capsule::select("select h.packageid from tblhosting h inner join tblproducts p on p.id=h.packageid where h.id='".$serviceId."' and p.servertype='xtreamUIpanel' ");
    	if(!empty($hData)){
    		$userField = Capsule::table("tblcustomfields")->select('id')->where('relid',$hData[0]->packageid)->where('type','product')->where('fieldname','Username')->first();
			$userFieldId = $userField->id;

			$userFieldValue = Capsule::table("tblcustomfieldsvalues")->select('value')->where('relid',$serviceId)->where('fieldid',$userFieldId)->first();
			$userFieldVal = $userFieldValue->value;
			if(!empty($userFieldVal)){
				Capsule::table("tblhosting")->where('id',$serviceId)->update(array('username'=>$userFieldVal));
			}


			$magField = Capsule::table("tblcustomfields")->select('id')->where('relid',$hData[0]->packageid)->where('type','product')->where('fieldname','MAG Address')->first();
			$magFieldId = $magField->id;

			$magFieldValue = Capsule::table("tblcustomfieldsvalues")->select('value')->where('relid',$serviceId)->where('fieldid',$magFieldId)->first();
			$magFieldVal = $magFieldValue->value;
			if(!empty($magFieldVal)){
				Capsule::table("tblhosting")->where('id',$serviceId)->update(array('username'=>$magFieldVal));
			}



			$passField = Capsule::table("tblcustomfields")->select('id')->where('relid',$hData[0]->packageid)->where('type','product')->where('fieldname','Password')->first();
			$passFieldId = $passField->id;

			$passFieldValue = Capsule::table("tblcustomfieldsvalues")->select('value')->where('relid',$serviceId)->where('fieldid',$passFieldId)->first();
			$passFieldVal = $passFieldValue->value;

			if(!empty($passFieldVal)){
				$command = 'EncryptPassword';
				$postData = array(
				    'password2' => $passFieldVal,
				);
				$adminUsername = ''; // Optional for WHMCS 7.2 and later
				$results = localAPI($command, $postData, $adminUsername);
				$password = $results['password'];
				Capsule::table("tblhosting")->where('id',$serviceId)->update(array('password'=>$password));
			}
    	}
	}
});


add_hook('ClientAreaHeadOutput', 1, function($vars) {
	global $smarty;
	//echo '<pre>'; print_r($smarty->tpl_vars['products']->value[0]['customfields']); die();
	$usernameId = '';  

if(isset($smarty->tpl_vars['customfields']->value) && !empty($smarty->tpl_vars['customfields']->value))
{
	foreach ($smarty->tpl_vars['customfields']->value as $customfield) {
		if($customfield['textid']=='username'){
			$usernameId = $customfield['id'];
		}
	}

	$cartKey = $_GET['i'];
if(!empty($usernameId)){	
	//echo '<pre>'; print_r($digitalnameId); die('DONE');
    $template = $vars['template'];
return <<<HTML
    
<script type="text/javascript">
  function validateUserName(id){
  	value = $('#'+id).attr('data');
  	if(value=='1'){
  		return true;
  	}
  	username = $('#customfield$usernameId').val(); 
  	$('#digitalNameError').remove();
  	$.ajax({
       type: "POST",
       url: '',
       data: "username="+username+"&cartKey=$cartKey&checkUserName=checkUserName", // serializes the form's elements.
       success: function(data)
       {
           res = $.parseJSON(data);
           if(res.status=='success'){
           	  $('#'+id).attr('data','1');
           	  $('#'+id).click();           	  
              //validateDigitalName(id);
           }else{           		
           	   $('#userNameError').remove();
               $('#customfield$usernameId').after('<span id="userNameError" style="color:red;">' + res.message + '</span>'); 
           }   
       }
     });
return false;
  }
</script>
HTML;
}
}
});

add_hook('ClientAreaPage', 0, function($vars){
	global $smarty;
	if(isset($_POST['checkUserName'])){
		if(!empty($_POST['username']))	
		{	
			include(__DIR__.'/xtreamUIpanel.php');
	    	$post_data = array(
			    'username' => $_POST['username'],
			);

	    	$cartKey = $_POST['cartKey'];
	    	$pid = $_SESSION['cart']['products'][$cartKey]['pid'];

	    	$productData = Capsule::table("tblproducts")->where('id',$pid)->first();
	    	//echo '<pre>'; print_r($productData); die();


			$xc_url = $productData->configoption9; //'http://panel.mkondoni.com:25500/';
			$detailsarray = array(
				'username' => $productData->configoption10,//'iwbnis@pm.me',
	    		'password' => $productData->configoption11,
			);
			$UsernameToCheck = $_POST['username'];
	    	$api_result = xtreamUIpanelAPICall('user_reseller.php', $post_data, 'add_user', $xc_url, $detailsarray, 'on', $UsernameToCheck);
	    	if($api_result['response']=='Username already in use..'){
	    		$result = array('status'=>'error','message'=> $api_result['response'],'link'=>'');
	   			echo json_encode($result);die();
	    	}else{
	    		$result = array('status'=>'success','message'=> '','link'=>'');
	   			echo json_encode($result);die();
	    	}
	    }else{
	    	$result = array('status'=>'success','message'=> '','link'=>'');
	   		echo json_encode($result);die();
	    }
    	die();    	
	}



	if($_GET['testby']=='developer')
    {    	
    	$serviceId = '29';
    	$hData = Capsule::select("select h.packageid from tblhosting h inner join tblproducts p on p.id=h.packageid where h.id='".$serviceId."' and p.servertype='xtreamUIpanel' ");
    	if(!empty($hData)){
    		$userField = Capsule::table("tblcustomfields")->select('id')->where('relid',$hData[0]->packageid)->where('type','product')->where('fieldname','Username')->first();
			$userFieldId = $userField->id;

			$userFieldValue = Capsule::table("tblcustomfieldsvalues")->select('value')->where('relid',$serviceId)->where('fieldid',$userFieldId)->first();
			$userFieldVal = $userFieldValue->value;
			if(!empty($userFieldVal)){
				Capsule::table("tblhosting")->where('id',$serviceId)->update(array('username'=>$userFieldVal));
			}

			$passField = Capsule::table("tblcustomfields")->select('id')->where('relid',$hData[0]->packageid)->where('type','product')->where('fieldname','Password')->first();
			$passFieldId = $passField->id;

			$passFieldValue = Capsule::table("tblcustomfieldsvalues")->select('value')->where('relid',$serviceId)->where('fieldid',$passFieldId)->first();
			$passFieldVal = $passFieldValue->value;

			if(!empty($passFieldVal)){
				$command = 'EncryptPassword';
				$postData = array(
				    'password2' => $passFieldVal,
				);
				$adminUsername = ''; // Optional for WHMCS 7.2 and later
				$results = localAPI($command, $postData, $adminUsername);
				$password = $results['password'];
				Capsule::table("tblhosting")->where('id',$serviceId)->update(array('password'=>$password));
			}
    	}
    	

    	include(__DIR__.'/xtreamUIpanel.php');
    	$post_data = array(
		    'username' => 'april16_trial',		    
		);
		$xc_url = 'http://panel.mkondoni.com:25500/';
		$detailsarray = array(
			'username' => 'iwbnis@pm.me',
    		'password' => 'P@$$w0rd35556'
		);
		$UsernameToCheck = 'april16_trial';
    	$api_result = xtreamUIpanelAPICall('user_reseller.php', $post_data, 'add_user', $xc_url, $detailsarray, 'on', $UsernameToCheck);
    	echo '<pre>'; print_r($api_result);
    	die('JMD');
    }
   //$smarty->assign('name', $dsdfs);
});

?>