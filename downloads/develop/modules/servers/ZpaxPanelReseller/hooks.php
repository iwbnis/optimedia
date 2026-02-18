<?php

use WHMCS\Database\Capsule;

add_hook('AdminAreaFooterOutput', 1, function($vars) {
    $head_return = '';

    if ($vars['filename'] == 'configproducts') {
        if ($_REQUEST['action'] == 'edit') {
            $productID = (isset($_REQUEST["id"]) && !empty($_REQUEST["id"]))?$_REQUEST["id"]:"";
            $checkServerAttached = Capsule::table('tblproducts')->where('id', '=', $productID)->get();
            $ProductServer = (isset($checkServerAttached[0]->servertype) && !empty($checkServerAttached[0]->servertype)) ? $checkServerAttached[0]->servertype : "";
            if ($ProductServer == "ZpaxPanelReseller") 
            {
                $SuccessConn = "<h2><span style='padding:2px 10px;background-color:#5bb75b;color:#fff;font-weight:bold;'><i class='fa fa-check hideOnload' ></i> Connection successfully connected</span></h2>";
                $ErroConn = "<h2><span style='padding:2px 10px;background-color:#cc0000;color:#fff;line-height: 1.9;'><i class='fa fa-times hideOnload' ></i> Failed to connect to Reseller Panel: Connection Failed, Please check the details and try again</span></h2>";
                $succesFaicon = "<i class='fa fa-check' ></i>";
                $closeFaicon = "<i class='fa fa-times' ></i>";
                $head_return.= '<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
                <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery(document).ajaxComplete(function () {
                            jQuery("input[name=\'packageconfigoption[6]\']").attr("readonly", "readonly");
                            jQuery("input[name=\'packageconfigoption[7]\']").attr("readonly", "readonly");
                            checkloadonce = $("#loadonce").val();
                            if(checkloadonce == "")
                            {
                                getResellerDataFunction();
                                jQuery("select[name=\'packageconfigoption[5]\']").change(function() {
                                    jQuery("input[name=\'packageconfigoption[6]\']").val("0|none");
                                    jQuery("input[name=\'packageconfigoption[7]\']").val("0|none");
                                })
                                jQuery("select[name=\'packageconfigoption[4]\']").change(function() {
                                    producttype = $(this).val();
                                    jQuery("select[name=\'packageconfigoption[4]\']").prop("disabled", false);
                                    jQuery.ajax({
                                        type:"POST",
                                        url:"../modules/servers/ZpaxPanelReseller/Zpaxconfig.php",
                                        dataType:"text",
                                        data:{
                                        action:"saveproducttype",
                                        productid:"'.$productID.'",
                                        producttype:producttype
                                        },  
                                        success:function(response){
                                          window.location.href = "configproducts.php?action=edit&id='.$productID.'";
                                        }
                                    }); 
                                });
                            }
                        });
                    });
                function testconnectionfunction()
                {
                    panelid = jQuery("select[name=\'packageconfigoption[2]\']").val();
                    thisvarcheck = jQuery(".conntestbtn");
                    thisvarcheck.html("Processing");
                    thisvarcheck.removeClass("btn-danger btn-success");
                    thisvarcheck.addClass("btn-primary");
                    jQuery.ajax({
                        type:"POST",
                        url:"../modules/servers/ZpaxPanelReseller/Zpaxconfig.php",
                        dataType:"text",
                        data:{
                        action:"testconnrecheck",
                        panelid:panelid
                        },  
                        success:function(response){
                            thisvarcheck.removeClass("btn-primary");
                            if(response == "success")
                            {
                                $("#connectionmodalbody").html("'.$SuccessConn.'");
                                thisvarcheck.addClass("btn-success");
                                thisvarcheck.html("'.$succesFaicon.' Test Connection");
                                getResellerDataFunction();
                            }
                            else
                            {
                               $("#connectionmodalbody").html("'.$ErroConn.'");
                               thisvarcheck.addClass("btn-danger");
                                thisvarcheck.html("'.$closeFaicon.' Test Connection");
                            }
                            jQuery("select[name=\'packageconfigoption[2]\']").change(function() {
                                jQuery(".conntestbtn").removeClass("btn-danger btn-success");
                                jQuery(".conntestbtn").addClass("btn-primary");
                                jQuery(".conntestbtn").html("Test Connection");
                            });
                            $("#connectionmodal").modal("show");
                        }
                    }); 
                }

                function getResellerDataFunction()
                {
                    panelid = jQuery("select[name=\'packageconfigoption[2]\']").val();
                    $("#resellerDta").show();
                    $("#resellerDta").html("Loading Data..");
                    jQuery.ajax({
                        type:"POST",
                        url:"../modules/servers/ZpaxPanelReseller/Zpaxconfig.php",
                        dataType:"text",
                        data:{
                        action:"getresellerdata",
                        panelid:panelid
                        },  
                        success:function(response){
                            $("#resellerDta").show();
                            $("#resellerDta").html(response);
                            $("#loadonce").val("loadedonce");
                        }
                    }); 
                }

                function getpackagedata()
                {
                    panelid = jQuery("select[name=\'packageconfigoption[2]\']").val();
                    ptype = jQuery("select[name=\'packageconfigoption[4]\']").val();
                    linetype = jQuery("select[name=\'packageconfigoption[5]\']").val();
                    currentval = jQuery("input[name=\'packageconfigoption[6]\']").val();
                    $("#packagemodal").modal("show");
                    $(".titleforbothbp").text("Select Package");
                    $("#packagemodalbody").html("<div><center>Loading Data..</center></div>");
                    jQuery.ajax({
                        type:"POST",
                        url:"../modules/servers/ZpaxPanelReseller/Zpaxconfig.php",
                        dataType:"text",
                        data:{
                        action:"getpackagedata",
                        ptype:ptype,
                        currentval:currentval,
                        linetype:linetype,
                        panelid:panelid
                        },  
                        success:function(response){
                            $("#packagemodalbody").html(response);
                            $( "#savePackage" ).bind( "click", function() {
                                selectedval = $("input[name=checknumber]:checked").val(); 
                                if (typeof selectedval  !== "undefined")
                                {
                                    jQuery("input[name=\'packageconfigoption[6]\']").val(selectedval);
                                    $("#packagemodal").modal("hide");
                                }
                                else
                                {
                                    alert("Select Package");
                                }
                            });
                        }
                    }); 
                }


               function getBouquet()
                {
                    panelid = jQuery("select[name=\'packageconfigoption[2]\']").val();
                    linetype = jQuery("select[name=\'packageconfigoption[5]\']").val();
                    currentpackage = jQuery("input[name=\'packageconfigoption[6]\']").val();
                    currentval = jQuery("input[name=\'packageconfigoption[7]\']").val();
                    $("#packagemodal").modal("show");
                    $(".titleforbothbp").text("Select Bouquets");
                    $("#packagemodalbody").html("<div><center>Loading Data..</center></div>");
                    jQuery.ajax({
                        type:"POST",
                        url:"../modules/servers/ZpaxPanelReseller/Zpaxconfig.php",
                        dataType:"text",
                        data:{
                        action:"getBouquet",
                        currentpackage:currentpackage,
                        currentval:currentval,
                        linetype:linetype,
                        panelid:panelid
                        },  
                        success:function(response){
                            $("#packagemodalbody").html(response);                            
                            $( "#saveBouquetss" ).bind( "click", function() {
                                if($("input[name=bouquetslists]:checked").length > 0)
                                {
                                    total = $("input[name=bouquetslists]:checked").length;
                                    counter = 1;
                                    TosaveData = "";
                                    $("input[name=bouquetslists]:checked").each(function () {
                                        scomma = ",";
                                        if(total == counter)
                                        {
                                            scomma = "";
                                        }
                                        TosaveData+=$(this).val()+scomma;
                                        counter = Number(counter)+Number(1);
                                    });
                                   jQuery("input[name=\'packageconfigoption[7]\']").val(TosaveData);
                                   $("#packagemodal").modal("hide");
                                }
                                else
                                {
                                    alert("Bouquets is required");
                                }                               
                            });
                        }
                    }); 
                }


                function CreateCustomFieldsZpax()
                {
                    var isuname = "";
                    if(jQuery("input[name=\'packageconfigoption[13]\']").is(":checked"))
                    {
                        isuname = "on";
                    }
                    var ispass = "";
                    if(jQuery("input[name=\'packageconfigoption[14]\']").is(":checked"))
                    {
                        ispass = "on";
                    }


                    $(".customfilds").addClass("redirection");
                    ptype = jQuery("select[name=\'packageconfigoption[4]\']").val();
                    $("#packagemodal").modal("show");
                    $(".titleforbothbp").text("Creating Required Custom Fields");
                    $("#packagemodalbody").html("<div><center>Loading Data..</center></div>");
                    jQuery.ajax({
                        type:"POST",
                        url:"../modules/servers/ZpaxPanelReseller/Zpaxconfig.php",
                        dataType:"text",
                        data:{
                        action:"createrequiredfields",
                        productid:"'.$productID.'",
                        isuname:isuname,
                        ispass:ispass,
                        ptype:ptype
                        },  
                        success:function(response){
                            $("#packagemodalbody").html(response);
                            $( ".redirection" ).bind( "click", function() {
                                window.location.href = "configproducts.php?action=edit&id='.$productID.'#tab=4";
                            });
                        }
                    }); 
                }

                </script>

                <div class="modal fade" id="connectionmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title">Panel Connection Status</h2>                            
                        </div>
                      <div class="modal-body" id="connectionmodalbody" style="text-align: center;padding-top: 30px;">
                        ...
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="packagemodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close customfilds" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title titleforbothbp">Select Package</h2>                            
                        </div>
                      <div class="modal-body" id="packagemodalbody" style="padding-top: 30px;padding-left: 50px;max-height: 450px;overflow: hidden;overflow-y: scroll;">
                        ...
                      </div>
                    </div>
                  </div>
                </div>
                ';
            }
        }
    }

    return $head_return;
});
