<?php

use WHMCS\Database\Capsule;

if (isset($_POST['addCategory'])) {
    $status = array();
    $catname = isset($_POST['catname']) && !empty($_POST['catname']) ? $_POST['catname'] : "";
    $hidden = isset($_POST['hidden']) && !empty($_POST['hidden']) ? "1" : "0";
    $order = isset($_POST['order']) && !empty($_POST['order']) ? $_POST['order'] : "";
    $insert = Capsule::table('xui_cats')->insert(['date' => date("Y/m/d"), 'hidden' =>  $hidden, 'order' => $order, 'cat_name' => $catname]);
    if ($insert) {
        $status = array(
            'status' => 'success',
            'message' => 'Your category has been created successfully.'
        );
    } else {
        $status = array(
            'status' => 'error',
            'message' => 'Unable to create category.'
        );
    }
}
if (isset($_POST['delete']) && !empty($_POST['delete'])) {
    $delete = Capsule::table('xui_cats')->where('id', $_POST['delete'])->delete();
    if ($delete) {
        $status = array(
            'status' => 'success',
            'message' => 'Category has been deleted successfully.'
        );
    } else {
        $status = array(
            'status' => 'error',
            'message' => 'Unable to delete category.'
        );
    }
}
if (isset($status) && $status['status'] == "success") {
?>
    <div class="successbox"><strong><span class="title"><?php echo $status['message'] ?></span></strong></div>
<?php
} elseif (isset($status) && $status['status'] == "error") {
?>
    <div class="errorbox"><strong><span class="title"><?php echo $status['message'] ?></span></strong></div>
<?php
}
?>
<style>
    .styleaa {
        text-align: center;
        border-right: 1px solid grey;
        font-size: 20px;
        text-align: center;
    }
</style>


<div style="float:left;width:100%;">
    <h1>Categories</h1>
    <ul class="nav nav-tabs admin-tabs" role="tablist">
        <li class="" id="cat_tab">
            <a style="cursor: pointer;" onclick="myfunc(this)" class="tab-top">
                Add Category
            </a>
        </li>
    </ul>
    <div class="tab-content admin-tabs">
        <div class="tab-pane active" id="tab1" style="display: none;">
            <form method="post" action="">
                <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
                    <tbody>
                        <tr>
                            <td width="15%" class="fieldlabel">Category Name</td>
                            <td class="fieldarea">
                                <input type="text" name="catname" class="form-control input-inline input-300">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="hidden">
                                    Check to Hide </label>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%" class="fieldlabel">Order</td>
                            <td class="fieldarea">
                                <input type="number" name="order" class="form-control input-inline input-300">

                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="btn-container">
                    <button id="btnAddCategory" class="btn btn-primary" type="submit" name="addCategory">
                        Add Category </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="width: 100%;float: left;" id="tableBackground" class="tablebg">
    <form action="" method="POST">
        <table id="sortabletbl2" class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
            <tbody id="custom_sorting">
                <tr>
                    <th>Category Name</th>
                    <th>Date/Time</th>
                    <th>Hidden</th>
                    <th style="width: 2%;"></th>
                    <th style="width: 2%;"></th>
                </tr>
                <?php
                $count = Capsule::table('xui_cats')->orderBy('order')->count();
                if ($count > 0) {
                    $data = Capsule::table('xui_cats')->orderBy('order')->get();
                    foreach ($data as $val) {
                ?>
                        <tr>
                            <td align="center">
                                <?php echo $val->cat_name; ?>
                            </td>
                            <td align="center">
                                <?php echo $val->date; ?>
                            </td>
                            <td align="center">
                                <?php echo isset($val->hidden) && $val->hidden == 1 ? 'True' : 'False' ?>
                            </td>
                            <td style="width: 2%;">
                                <a href="addonmodules.php?module=XUIPanelCustom&action=categories&amp;id=<?php echo $val->id; ?>">
                                    <img src="images/edit.gif" width="16" height="16" border="0" alt="Edit">
                                </a>
                            </td>
                            <td style="width: 2%;" align="center">
                                <button type="submit" name="delete" value="<?php echo $val->id; ?>" style="border: none;background:none;" class="dodeletecustom">
                                    <img src="images/delete.gif" border="0" alt="Delete">
                                </button>
                            </td>
                            <!-- <td colspan="5" style="text-align: center;">No Record Found</td> -->
                        </tr>
                <?php
                    }
                }else {
                    ?>
                        <tr>
                            <td style="text-align: center;" colspan="5">No Categories added!</td>
                        </tr>
                    <?php
                    }
                ?>
            </tbody>
        </table>
    </form>
</div>
<script>
    function myfunc(THIS) {
        if ($("#tab1").css("display") == "none") {
            $("#tab1").show();
            $("#cat_tab").addClass("active");
        } else {
            $("#tab1").hide();
            $("#cat_tab").removeClass("active");
        }
    }
    $(document).ready(function() {
        $(".dodeletecustom").click(function() {
            var ok = confirm('Are you sure want to delete this category ?');
            if (ok == true) {
                return true;
            } else {
                return false;
            }
        });
    });
</script>