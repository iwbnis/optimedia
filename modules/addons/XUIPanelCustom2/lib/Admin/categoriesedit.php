<?php

use WHMCS\Database\Capsule;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    if (isset($_POST['addCategory'])) {
        $status = array();
        $catname = isset($_POST['catname']) && !empty($_POST['catname']) ? $_POST['catname'] : "";
        $hidden = isset($_POST['hidden']) && !empty($_POST['hidden']) ? "1" : "0";
        $order = isset($_POST['order']) && !empty($_POST['order']) ? $_POST['order'] : "";
        $update = Capsule::table('xui_cats')->where('id', $_GET['id'])->update(['date' => date("Y/m/d"), 'hidden' =>  $hidden, 'order' => $order, 'cat_name' => $catname]);
        if ($update) {
            $status = array(
                'status' => 'success',
                'message' => 'Your category has been edited successfully.'
            );
        } else {
            $status = array(
                'status' => 'error',
                'message' => 'Unable to edit category.'
            );
        }
    }
    $data = Capsule::table('xui_cats')->where('id', $_GET['id'])->get();
    $getdata = $data[0];
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
    <h1>Edit Category</h1>
    <ul class="nav nav-tabs admin-tabs" role="tablist">
        <li class="active" id="cat_tab">
            <a style="cursor: pointer;" onclick="myfunc(this)" class="tab-top">
                Edit Category
            </a>
        </li>
    </ul>
    <div class="tab-content admin-tabs">
        <div class="tab-pane active" id="tab1">
            <form method="post" action="">
                <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
                    <tbody>
                        <tr>
                            <td width="15%" class="fieldlabel">Category Name</td>
                            <td class="fieldarea">
                                <input type="text" name="catname" class="form-control input-inline input-300" value="<?php echo isset($getdata->cat_name) && !empty($getdata->cat_name) ? $getdata->cat_name : '' ?>">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="hidden" <?php echo isset($getdata->hidden) && !empty($getdata->hidden) ? 'checked' : '' ?>>
                                    Check to Hide </label>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%" class="fieldlabel">Order</td>
                            <td class="fieldarea">
                                <input type="number" name="order" class="form-control input-inline input-300" value="<?php echo isset($getdata->order) && !empty($getdata->order) ? $getdata->order : '' ?>">

                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="btn-container">
                    <button id="btnAddCategory" class="btn btn-primary" type="submit" name="addCategory">
                        Save Changes </button>
                </div>
            </form>
        </div>
    </div>
</div>