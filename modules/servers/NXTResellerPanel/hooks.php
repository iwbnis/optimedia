<?php

use WHMCS\Database\Capsule;

include_once 'functions.php';
add_hook('AdminAreaFooterOutput', 1, function ($vars) {
    if ($vars['filename'] == 'configproducts') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $product_id = $_GET['id'];
            $product = Capsule::table('tblproducts')->where('id', $product_id)->first();
            if ($product->servertype == "NXTResellerPanel") {
                return moduleconfiguration_NXT();
            }
        }
    }
});
add_hook('ShoppingCartValidateProductUpdate', 1, function ($vars) {
    foreach ($vars['customfield'] as $customfieldId => $value) {
        $tblcustomfields = Capsule::table('tblcustomfields')->where("id", $customfieldId)->get();
        $fieldname = $tblcustomfields[0]->fieldname;
        if ($fieldname == "Select Product Type") {
            if ($value == "MAG") {
                $config = Capsule::table('nxt_settings')->get();
                foreach ($config as $value) {
                    $row[$value->setting] = $value->value;
                }
                $tblcustomfieldsData = Capsule::table('tblcustomfields')->where("relid", $tblcustomfields[0]->relid)->where("fieldname", $row['custom_field_mag'])->where("type", "product")->get();
                $str = $vars['customfield'][$tblcustomfieldsData[0]->id];
                if (empty($str)) {
                    return [
                        'MAG Address is required',
                    ];
                }
                $pattern = "/([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})/";
                if (preg_match($pattern, $str) != 1) {
                    return [
                        'MAG Address value is not valid',
                    ];
                }
            }
        }
    }
});
add_hook('ClientAreaHeadOutput', 1, function ($vars) {
    if ($vars['productinfo']['module'] == 'NXTResellerPanel' || $vars['module'] == 'NXTResellerPanel') {
        $pid = isset($vars['productinfo']['pid']) ? $vars['productinfo']['pid'] : $vars['pid'];
        $tblproducts = Capsule::table('tblproducts')->where("id", $pid)->get();
        if (($vars['pagetitle'] == "Shopping Cart" && $vars['displayTitle'] == "Shopping Cart" && $vars['action'] == "confproduct") || ($vars['pagetitle'] == "Client Area" && $vars['displayTitle'] == "Manage Product" && $vars['action'] == "productdetails")) {
            $config = Capsule::table('nxt_settings')->get();
            foreach ($config as $value) {
                $row[$value->setting] = $value->value;
            }
            $tblcustomfields = Capsule::table('tblcustomfields')->whereIn("fieldname", ['Select Product Type', $row['custom_field_username'], $row['custom_field_password'], $row['custom_field_mag'], 'Select Bouquets'])->where("relid", $pid)->get();
            foreach ($tblcustomfields as $values) {
                if ($values->fieldname == "Select Product Type") {
                    $product_type = $values->id;
                }
                if ($values->fieldname == "MAG Address") {
                    $mag_address = $values->id;
                }
                if ($values->fieldname == "Password") {
                    $password = $values->id;
                }
                if ($values->fieldname == "Select Bouquets") {
                    $fieldid =  $values->id;
                    $tblcustomfieldsvalues = Capsule::table('tblcustomfieldsvalues')->where('relid', $vars['serviceid'])->where('fieldid', $fieldid)->first();
                    $Bouquets = $tblcustomfieldsvalues->value;
                    if (isset($Bouquets) && !empty($Bouquets)) {
                        $getBouquets = $Bouquets;
                    } else {
                        $getBouquets = $tblproducts[0]->configoption12;
                    }
                    $bouquets = $values->id;
                }
            }
            $return = "";
            $action = $vars['action'];
            if ($vars['action'] == "confproduct") {
                $return .= '<button type="button" class="btn btn-primary" id="savebouquetcategories" onclick="saveCategorizeBouquets()">Save Changes</button>';
            }
            if ($vars['action'] == "productdetails") {
                if ($pid) {
                    $tblcustomfields = Capsule::table('tblcustomfields')->where('fieldname', 'Select Product type')->where('relid', $pid)->select('id')->get();
                    $fieldid =  $tblcustomfields[0]->id;
                    $productType = Capsule::table('tblcustomfieldsvalues')->where('relid', $vars['serviceid'])->where('fieldid', $fieldid)->first();
                    if ($tblproducts[0]->configoption3 == "magdevice") {
                        $return .= '<input type="hidden" id="MagAddressCustom" name="newMAC" value=""><input type="hidden" id="customAction" name="customAction" value="changeBouquets">';
                    }
                    if ($tblproducts[0]->configoption3 == "streamlineonly") {
                        $return .= '<input type="hidden" id="passwordCustom" name="pass_word" value=""><input type="hidden" id="customAction" name="customAction" value="update_bouquets">';
                    }
                }
                $serviceid = isset($vars['serviceid']) && !empty($vars['serviceid']) ? $vars['serviceid'] : "";
                $return .= '<input type="hidden" id="clientSelectedBouquets" name="clientSelectedBouquets" value="' . $getBouquets . '">
                <input type="hidden" id="serviceid" name="serviceid" value="' . $serviceid . '">
                <button type="button" class="btn btn-primary" id="savebouquetcategories" onclick="saveCategorizeBouquetsServicePage()">Save Changes</button>';
            }
            return <<<HTML
<div style="display:none" id="organizebouquetsCategoriesmodal" class="modal fade" role="dialog">
    <form action="" method="POST" id="saveCategorizeBouquetsform">
        <div class="modal-dialog" style="width:900px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bouquets List</h4>
                </div>
                <div class="modal-body" style="padding-bottom:0px;height: 450px;overflow:auto">
                    <div class="conatiner-fluid">
                        <!-- categories    -->
                        <div id="categories_title"></div>
                    </div>
                    <div class="conatiner-fluid">
                        <div class="col-sm-12">
                            <div class="row" id="bouquest_section" style="padding: 10px;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    $return
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
@media (max-width: 1000px) {
    #order-standard_cart {
        width: 100% !important;
        height: 700px !important;
        overflow: auto !important;
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    #order-standard_cart::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    #order-standard_cart {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
}

#lightbox {
    display: none !important;
}
</style> 
<script type="text/javascript"> 
    function categoriseBouquets(catid, bouquets, savedbouquets, cat_data, clientSavedBouquets) {
        ClientSavedBouquets = "";
        if (clientSavedBouquets.length > 0) {
            ClientSavedBouquets = clientSavedBouquets;
        }
        savedbouquets = jQuery.parseJSON(JSON.stringify(savedbouquets));
        $('.categories_select').removeClass('active');
        $('.categories_select').removeClass('activecat');
        $('.categories_select').find('a').removeClass('selected_cat');
        $("[data-catid=" + catid + "]").parent('.categories_select').addClass('active');
        $("[data-catid=" + catid + "]").parent('.categories_select').addClass('activecat');
        $('.categories_select').find('a').addClass('selected_cat');
        var html = "";
        if (cat_data == 0 || cat_data == null || cat_data == undefined || cat_data == "") {
            alert('No bouquets available.');
        } else {
            selectedBouquests = localStorage.getItem('selectedBouquests');
            if (selectedBouquests == "" || selectedBouquests == null || selectedBouquests == "null" || selectedBouquests == undefined) {
                selectedBouquests = [];
            } else {
                selectedBouquests = jQuery.parseJSON(selectedBouquests);
            }
            if (ClientSavedBouquets == "") {
                //show all the bouquets unchecked
                html += '<div style="margin-bottom: 10px;" class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp&nbsp Select All</label></div>';
                $.each(bouquets, function(bouquet_id, channel_name) {
                    $.each(savedbouquets, function(index, val) {
                        if (val == bouquet_id) {
                            checked = "";
                            $.each(selectedBouquests, function(index, seleted_bouquet_id) {
                                if (seleted_bouquet_id == val) {
                                    checked = "checked";
                                    return true;
                                }
                            });
                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined && cat_data[bouquet_id] != "uncategorized") {
                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                            }
                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] == "uncategorized" && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined) {
                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                            }
                        }
                    });
                });
            } else {
                //show client selected bouquets checked  
                html += '<div class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp&nbsp Select All</label></div>';
                $.each(bouquets, function(bouquet_id, channel_name) {
                    $.each(savedbouquets, function(index, val) {
                        if (val == bouquet_id) {
                            checked = "";
                            $.each(selectedBouquests, function(index, seleted_bouquet_id) {
                                if (seleted_bouquet_id == val) {
                                    checked = "checked";
                                    return true;
                                }
                            });
                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined && cat_data[bouquet_id] != "uncategorized") {
                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                            }
                            if (cat_data[bouquet_id] == catid && cat_data[bouquet_id] == "uncategorized" && cat_data[bouquet_id] != null && cat_data[bouquet_id] != "null" && cat_data[bouquet_id] != undefined) {
                                html += '<div><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input name="selectedbouquets" class="allbouquets" onchange="saveselectedbouquets()" data-bouquetname="' + channel_name + '" type="checkbox" value="' + bouquet_id + '" ' + checked + '>&nbsp&nbsp <span class="textToSort">' + channel_name + '</span></label></div>';
                            }
                        }
                    });
                });
            }
        }
        $("#bouquest_section").html('<div class="row">' + html + '</div>');
        $("#selectAll").bind("click", function() {
            if ($(this).is(":checked")) {
                $(".allbouquets").prop("checked", true);
            } else {
                $(".allbouquets").prop("checked", false);
            }
            saveselectedbouquets();
        });
        checkifchecked();
    }

    function saveCategorizeBouquets() {
        var newArraySelected = [];
        selectedBouquests = localStorage.getItem('selectedBouquests');
        if (selectedBouquests == "" || selectedBouquests == null || selectedBouquests == "null" || selectedBouquests == undefined) {
            selectedBouquests = [];
        } else {
            selectedBouquests = jQuery.parseJSON(selectedBouquests);
        }
        $.each(selectedBouquests, function(index, val) {
            if (val != "" && val != null && val != "null" && val != undefined) {
                newArraySelected.push(val);
            }
        });
        // alert(newArraySelected);
        $("#customfield$bouquets").val(newArraySelected);

        $("#organizebouquetsCategoriesmodal").modal("hide");
    }

    function saveCategorizeBouquetsServicePage() {
        var newArraySelected = [];
        selectedBouquests = localStorage.getItem('selectedBouquests');
        if (selectedBouquests == "" || selectedBouquests == null || selectedBouquests == "null" || selectedBouquests == undefined) {
            selectedBouquests = [];
        } else {
            selectedBouquests = jQuery.parseJSON(selectedBouquests);
        }
        $.each(selectedBouquests, function(index, val) {
            if (val != "" && val != null && val != "null" && val != undefined) {
                newArraySelected.push(val);
            }
        });
        //request to edit bouquets
        $("#clientSelectedBouquets").val(newArraySelected);
        $("#passwordCustom").val($("#pass_word").val());
        $("#MagAddressCustom").val($("#MagAddress").val());
        $("#saveCategorizeBouquetsform").submit();
        $("#organizebouquetsCategoriesmodal").modal("hide");
    }

    function saveselectedbouquets() {
        selected = localStorage.getItem('selectedBouquests');
        if (selected == "" || selected == null || selected == "null" || selected == undefined) {
            selected = [];
        } else {
            selected = jQuery.parseJSON(selected);
        }
        $(".allbouquets").each(function(index) {
            if ($(this).is(":checked")) {
                selected[$(this).val()] = $(this).val();
            } else {
                delete selected[$(this).val()];
            }
        });
        localStorage.setItem('selectedBouquests', JSON.stringify(selected));
        checkifchecked();
    }

    function saveselectedbouquetsForServicePage(clientSavedBouquets) {
        selected = localStorage.getItem('selectedBouquests');
        if (selected == "" || selected == null || selected == "null" || selected == undefined) {
            selected = [];
        } else {
            selected = jQuery.parseJSON(selected);
        }
        $.each(clientSavedBouquets, function(index, value) {
            selected[value] = value;
        });
        localStorage.setItem('selectedBouquests', JSON.stringify(selected));
        checkifchecked();
    }

    function checkifchecked() {
        totallength = $(".allbouquets").length;
        totallengthchecked = $('input[class="allbouquets"]:checked').length;
        if (totallength == totallengthchecked) {
            $("#selectAll").prop("checked", true);
        } else {
            $("#selectAll").prop("checked", false);
        }
    }

    function selectbouquets(category_Id) {
        response = localStorage.getItem('bouquetsforclientarea');
        var obj = jQuery.parseJSON(response);
        clientSavedBouquets = obj.clientSavedBouquets;
        uncategorizedLength = obj.uncategorizedLength;
        if (obj.status == "success") {
            cat_data = obj.cat_data;
            catid = $(".activecat").find(".selected_cat").data('catid');
            categories = obj.data;
            categories_title = "";
            categories_title += '<ul class="nav nav-tabs">';
            count = 0;
            savedbouquets = obj.savedbouquets;
            bouquets = obj.bouquets;
            savedbouquets = savedbouquets.split(",");
            $.each(categories, function(index, val) {
                $.each(val, function(index, category_name) {
                    category_id = index;
                    count++;
                    active = "";
                    selected_cat = "";
                    if (category_Id != "" && category_Id != undefined && category_Id && "undefined" && category_Id != null && category_Id != "null") {
                        if (category_id == category_Id) {
                            active = "active activecat";
                            selected_cat = "selected_cat";
                        }
                    } else {
                        if (count == 1) {
                            active = "active activecat";
                            selected_cat = "selected_cat";
                        }
                    }
                    categories_title += '<li role="presentation" class="categories_select ' + active + '"><a style="cursor: pointer;" data-catid="' + category_id + '" data-catname="' + category_name + '" class="' + selected_cat + '" onclick="selectbouquets(' + category_id + ')">' + category_name + '</a></li>';
                });
            });
            if (category_Id == "uncatgorized") {
                activeuncat = "active activecat";
                selected_uncat = "selected_cat";
            } else {
                activeuncat = "";
                selected_uncat = "";
            }
            uncatgorized = "uncatgorized";
            if (uncategorizedLength > 0) {
                categories_title += '<li role="presentation" class="categories_select ' + activeuncat + '"><a style="cursor: pointer;" data-catid="uncategorized" data-catname="uncategorized" class="' + selected_uncat + '" onclick="selectbouquets(' + uncatgorized + ')">Uncategorized</a></li></ul>';
            }
            $("#categories_title").html(categories_title);
            var html = "";
            if (cat_data == 0 || cat_data == null || cat_data == undefined || cat_data == "" || cat_data == "null" || cat_data == "undefined") {
                alert('No Bouquets available.');
            } else {
                catid = $(".activecat").find('.selected_cat').data('catid');
                categoriseBouquets(catid, bouquets, savedbouquets, cat_data, clientSavedBouquets);
                //----------------------------------------------------------------------------------------------------------------------------
                //sort channels alphabetically 
                sortedTextArray = $(".textToSort").sort(Ascending_sort);
                append = '<div class="row"><div style="margin-bottom: 10px;" class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp;&nbsp; Select All</label></div>';
                rowshouldbe = 3;
                totalaarray = sortedTextArray.length;
                perow = Math.ceil(totalaarray / rowshouldbe);
                nextperlow = perow;
                totalrows = 0;
                counter = 1;
                $.each(sortedTextArray, function(key, val) {
                    if (counter == 1) {
                        append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                    }
                    Parent = $(this).closest('div');
                    labelToAppend = Parent[0].outerHTML;
                    append += '<div class = "col-md-12 col-sm-12">' + labelToAppend + '</div>';

                    if (nextperlow == counter) {
                        nextperlow = nextperlow + perow;
                        totalrows = totalrows + 1;
                        append += '</div>';
                        if (totalrows < rowshouldbe) {
                            append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                        }
                    }
                    ++counter;
                });
                append += '</div>';
                //----------------------------------------------------------------------------------------------------------------------------
                $("#bouquest_section").html(append);
                checkifchecked();
                $("#message").hide();
                $("#organizebouquetsCategoriesmodal").modal("show");
            }
        } else {
            alert('No Bouquets found!');
        }
        checkifchecked();
        $("#selectAll").bind("click", function() {
            if ($(this).is(":checked")) {
                $(".allbouquets").prop("checked", true);
            } else {
                $(".allbouquets").prop("checked", false);
            }
            saveselectedbouquets();
        });
    }

    function selectbouquetsFirst() {
        //request to fetch bouquets
        $.ajax({
            type: "POST",
            url: "modules/servers/NXTResellerPanel/Config.php",
            data: {
                action: 'getBouquetCategoriesOnClientArea',
                productid: '$pid',
                serviceid: '$serviceid'
            },
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                clientSavedBouquets = obj.clientSavedBouquets;
                uncategorizedLength = obj.uncategorizedLength;
                localStorage.setItem('bouquetsforclientarea', response);
                if (obj.status == "success") {
                    cat_data = obj.cat_data;
                    catid = $(".activecat").find(".selected_cat").data('catid');
                    categories = obj.data;
                    categories_title = "";
                    categories_title += '<ul class="nav nav-tabs">';
                    count = 0;
                    savedbouquets = obj.savedbouquets;
                    bouquets = obj.bouquets;
                    savedbouquets = savedbouquets.split(",");
                    $.each(categories, function(index, val) {
                        $.each(val, function(index, category_name) {
                            category_id = index;
                            count++;
                            active = "";
                            selected_cat = "";
                            if (count == 1) {
                                active = "active activecat";
                                selected_cat = "selected_cat";
                            }
                            categories_title += '<li role="presentation" class="categories_select ' + active + '"><a style="cursor: pointer;" data-catid="' + category_id + '" data-catname="' + category_name + '" class="' + selected_cat + '" onclick="selectbouquets(' + category_id + ')">' + category_name + '</a></li>';
                        });
                    });
                    uncatgorized = "uncatgorized";
                    if (uncategorizedLength > 0) {
                        categories_title += '<li role="presentation" class="categories_select"><a style="cursor: pointer;" data-catid="uncategorized" data-catname="uncategorized" onclick="selectbouquets(' + uncatgorized + ')">Uncategorized</a></li></ul>';
                    }
                    $("#categories_title").html(categories_title);
                    var html = "";
                    if (cat_data == 0 || cat_data == null || cat_data == undefined || cat_data == "" || cat_data == "null" || cat_data == "undefined") {
                        alert('No Bouquets available.');
                    } else {
                        // $("#bouquest_section").html('<div class="row">' + html + '</div>');
                        catid = $(".activecat").find('.selected_cat').data('catid');
                        saveselectedbouquetsForServicePage(clientSavedBouquets);
                        categoriseBouquets(catid, bouquets, savedbouquets, cat_data, clientSavedBouquets);
                        $("#message").hide();
                        //----------------------------------------------------------------------------------------------------------------------------
                        //sort channels alphabetically 
                        sortedTextArray = $(".textToSort").sort(Ascending_sort);
                        append = '<div class="row"><div style="margin-bottom: 10px;" class="col-sm-12"><label style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><input id="selectAll" type="checkbox">&nbsp;&nbsp; Select All</label></div>';
                        rowshouldbe = 3;
                        totalaarray = sortedTextArray.length;
                        perow = Math.ceil(totalaarray / rowshouldbe);
                        nextperlow = perow;
                        totalrows = 0;
                        counter = 1;
                        $.each(sortedTextArray, function(key, val) {
                            if (counter == 1) {
                                append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                            }
                            Parent = $(this).closest('div');
                            labelToAppend = Parent[0].outerHTML;
                            append += '<div class = "col-md-12 col-sm-12">' + labelToAppend + '</div>';

                            if (nextperlow == counter) {
                                nextperlow = nextperlow + perow;
                                totalrows = totalrows + 1;
                                append += '</div>';
                                if (totalrows < rowshouldbe) {
                                    append += '<div style="padding:0px" class = "col-md-4 col-sm-4">';
                                }
                            }
                            ++counter;
                        });
                        append += '</div>';
                        //----------------------------------------------------------------------------------------------------------------------------
                        $("#bouquest_section").html(append);
                        checkifchecked();
                        $("#organizebouquetsCategoriesmodal").modal("show");
                        $("#selectAll").bind("click", function() {
                            if ($(this).is(":checked")) {
                                $(".allbouquets").prop("checked", true);
                            } else {
                                $(".allbouquets").prop("checked", false);
                            }
                            saveselectedbouquets();
                        });
                    }
                } else {
                    alert('No Bouquets found!');
                }
            },
            error: function() {
                alert('No Bouquets found!');
            }
        });
        checkifchecked();
    }

    function Ascending_sort(a, b) {
        return ($(b).text().toUpperCase()) <
            ($(a).text().toUpperCase()) ? 1 : -1;
    }
    $(document).ready(function() {  
        $("#selectAll").bind("click", function() {
            if ($(this).is(":checked")) {
                $(".allbouquets").prop("checked", true);
            } else {
                $(".allbouquets").prop("checked", false);
            }
            saveselectedbouquets();
        });

        $("#customfield$bouquets").parent('.form-group').hide();
        localStorage.setItem('selectedBouquests', '');
           
        $("#customfield$bouquets").parent('div').after('<div align="center"><button onclick="selectbouquetsFirst()" type="button" class="btn btn-primary">Select Bouquets</button></div>');
    });
</script>
HTML;
        }
    }
});
add_hook('EmailPreSend', 1, function ($vars) {
    $merge_fields = [];
    $messagename = $vars['messagename'];
    $serviceID = $vars['relid'];
    if ($messagename == "IPTV Service Details") {
        $getserviceData = gethostingandproductbyserviceidNXT($serviceID);
        if (isset($getserviceData->id) && !empty($getserviceData->id)) {
            $productID = (isset($getserviceData->id) && !empty($getserviceData->id)) ? $getserviceData->id : "";
            $serviceid = (isset($getserviceData->serviceid) && !empty($getserviceData->serviceid)) ? $getserviceData->serviceid : "";
            $ptype = (isset($getserviceData->configoption3) && !empty($getserviceData->configoption3)) ? $getserviceData->configoption3 : "";
            if ($ptype == "magdevice") {
                $fielddata = getcustomfieldsandvaluesbyserviceidNXT($serviceid, $productID);
                $valueofofproduct = (isset($fielddata["Select Product Type"]) && !empty($fielddata["Select Product Type"])) ? $fielddata["Select Product Type"] : "";
                if ($valueofofproduct != "") {
                    if ($valueofofproduct == "MAG") {
                        $getemailtemplate = Capsule::table('tblemailtemplates')
                            ->where('name', '=', "IPTV MAG Service Details")
                            ->where('type', '=', "product")
                            ->count();
                        if ($getemailtemplate > 0) {
                            $command = 'SendEmail';
                            $postData = array(
                                'messagename' => 'IPTV MAG Service Details',
                                'id' => $serviceid
                            );
                            $results = localAPI($command, $postData);

                            $merge_fields['abortsend'] = true;
                            return $merge_fields;
                        }
                    }
                }
            }
        }
    }

    $getserviceData = gethostingandproductbyserviceidNXT($serviceID);
    if (isset($getserviceData->id) && !empty($getserviceData->id)) {
        $productID = (isset($getserviceData->id) && !empty($getserviceData->id)) ? $getserviceData->id : "";
        $serviceid = (isset($getserviceData->serviceid) && !empty($getserviceData->serviceid)) ? $getserviceData->serviceid : "";
        $Portallink = (isset($getserviceData->configoption12) && !empty($getserviceData->configoption12)) ? $getserviceData->configoption12 : "";
        $ptype = (isset($getserviceData->configoption3) && !empty($getserviceData->configoption3)) ? $getserviceData->configoption3 : "";
        if ($ptype == "streamlineonly" || $ptype == "magdevice") {
            $explodedPOrtals = explode(",", $Portallink);
            if ($messagename == "IPTV MAG Service Details") {
                $Portallink = $explodedPOrtals[1];
            } else if ($messagename == "IPTV Service Details") {
                $Portallink = $explodedPOrtals[0];
            }
        }

        $bar = "/";
        if (substr($Portallink, -1) == "/") {
            $bar = "";
        }
        $Portallink = $Portallink . $bar;

        $fielddata = getcustomfieldsandvaluesbyserviceidNXT($serviceid, $productID);

        if ($messagename == "IPTV MAG Service Details") {
            $magAddressIs = (isset($fielddata["MAG Address"]) && !empty($fielddata["MAG Address"])) ? $fielddata["MAG Address"] : "";
            $merge_fields['mag_address'] = $magAddressIs;
            $Portallink = $Portallink . "c";
        }
        $merge_fields['portal_url'] = $Portallink;
        $merge_fields['service_server_hostname'] = $Portallink;
        return $merge_fields;
    }
});

function getcustomfieldsandvaluesbyserviceidNXT($serviceID = "", $productid = "")
{
    $returnData = array();
    $checkcustomfield = Capsule::table('tblcustomfields')
        ->join('tblcustomfieldsvalues', 'tblcustomfields.id', '=', 'tblcustomfieldsvalues.fieldid')
        ->where('tblcustomfields.relid', '=', $productid)
        ->where('tblcustomfields.type', '=', "product")
        ->where('tblcustomfieldsvalues.relid', '=', $serviceID)
        ->select(
            'tblcustomfieldsvalues.*'
        )
        ->count();
    if ($checkcustomfield > 0) {
        $getcustomfield = Capsule::table('tblcustomfields')
            ->join('tblcustomfieldsvalues', 'tblcustomfields.id', '=', 'tblcustomfieldsvalues.fieldid')
            ->where('tblcustomfields.relid', '=', $productid)
            ->where('tblcustomfields.type', '=', "product")
            ->where('tblcustomfieldsvalues.relid', '=', $serviceID)
            ->select(
                'tblcustomfieldsvalues.*',
                'tblcustomfields.fieldname'
            )
            ->get();
        foreach ($getcustomfield as $fielddata) {
            $returnData[$fielddata->fieldname] = $fielddata->value;
        }
    }
    return $returnData;
}

function gethostingandproductbyserviceidNXT($serviceID = "")
{
    $returnData = array();
    $checkdata = Capsule::table('tblhosting')
        ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
        ->where('tblhosting.id', '=', $serviceID)
        ->where('tblproducts.servertype', '=', "NXTResellerPanel")
        ->select(
            'tblproducts.*',
            'tblhosting.id as serviceid'
        )
        ->count();
    if ($checkdata > 0) {
        $getdata = Capsule::table('tblhosting')
            ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
            ->where('tblhosting.id', '=', $serviceID)
            ->where('tblproducts.servertype', '=', "NXTResellerPanel")
            ->select(
                'tblproducts.*',
                'tblhosting.id as serviceid'
            )
            ->get();
        $returnData = $getdata[0];
    }
    return $returnData;
}
