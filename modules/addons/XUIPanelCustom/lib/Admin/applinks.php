<?php
use WHMCS\Database\Capsule;
$result = array();
if (isset($_POST['addapp'])) {
    $insertresult = Capsule::table('xtreamui_applinks')->insert(['appfor' => $_POST['appfor'], 'appname' => $_POST['appname'], 'applink' => $_POST['applink']]);
    if ($insertresult) {
        $result['status'] = 'success';
        $result['message'] = 'New App link added!!';
    } else {
        $result['status'] = 'error';
        $result['message'] = 'Error While adding download link!!';
    }
}
if (isset($_POST['appdelete'])) {
    $appid = $_POST['appid'];
    $insertresult = Capsule::table('xtreamui_applinks')->where('id', $appid)->delete();
    if ($insertresult) {
        $result['status'] = 'success';
        $result['message'] = 'App Link Deleted';
    } else {
        $result['status'] = 'error';
        $result['message'] = 'Error Deleting app link!!';
    }
}
$applink = Capsule::table('xtreamui_applinks')->count();
if ($applink > 0) {
    $applink = Capsule::table('xtreamui_applinks')->get();
    foreach ($applink as $app) {
        $appdata .= '<tr><td>' . $app->appfor . '</td><td>' . $app->appname . '</td><td>' . $app->applink . '</td><td><form method="post" action="" id="deleteform' . $app->id . '"><input type="hidden" name="appdelete" value="' . $app->id . '"><button type="button" name="deleteapp" data-appid="' . $app->id . '" class="btn btn-danger deleteapp" id="deleteapp' . $app->id . '"><i class="fa fa-trash"></i></button><input type="hidden" name="appid" value="' . $app->id . '"></form></td></tr>';
    }
} else {
    $appdata = '<tr><td colspan="4">No Record Found!</td></tr>';
}
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="pull-left">Upload Application Links</h2><button class="btn btn-info pull-right" id="addserverbtn"><i class="fa fa-plus"></i> Add Application</button>
    </div>
</div>
<h5>Here, you can add your application link that will be displayed in the client area for your customers, so they can download your IPTV Application</h5>
<?php if ($result['status'] == 'success') {
?><div class="alert alert-success" role="alert"><?php echo $result['message']; ?></div><?php
                                                                                                } elseif ($result['status'] == 'error') {
                                                                                                    ?><div class="alert alert-error" role="alert"><?php echo $result['message']; ?></div><?php
                                                                                                }
                                                                                                    ?>

<table class="table table-bordered table-striped" style="margin-top: 10px;">
    <thead>
        <tr>
            <th>Application Type</th>
            <th>Name</th>
            <th>Link</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="serverslist">
        <?php echo $appdata; ?>
    </tbody>
</table>


<div class="modal fade" id="addServerModal" tabindex="-1" role="dialog" aria-labelledby="Add New Server" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style=" float: left; ">Add New App</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="server_frm1" name="server_frm" novalidate="novalidate" method="post" action="" class="fv-form fv-form-bootstrap">
                <div class="modal-body">
                    <button type="submit" class="fv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>

                    <div class="row">
                        <div class="form-group control-group col-md-6">
                            <div class="controls input-group">
                                <label class="control-label input-group-addon" for="appname1">Your App Name</label>
                                <input class="form-control" id="appname1" name="appname" placeholder="Eg. IPTV Smarters" data-fv-field="appname">
                            </div>
                            <small style="display: none;" class="help-block" data-fv-validator="notEmpty" data-fv-for="server_name" data-fv-result="NOT_VALIDATED"></small><small style="display: none;" class="help-block" data-fv-validator="stringLength" data-fv-for="server_name" data-fv-result="NOT_VALIDATED"></small>
                        </div>
                        <div class="form-group control-group col-md-6">
                            <div class="controls input-group">
                                <label class="control-label input-group-addon" for="appfor">App Type</label>
                                <select class="form-control" id="appfor1" name="appfor">
                                    <option value="android">Android</option>
                                    <option value="windows">Windows</option>
                                    <option value="ios">IOS</option>
                                    <option value="linux">Linux</option>
                                    <option value="macos">Mac OS</option>
                                </select>

                            </div>
                            <small style="display: none;" class="help-block" data-fv-validator="notEmpty" data-fv-for="server_name" data-fv-result="NOT_VALIDATED"></small><small style="display: none;" class="help-block" data-fv-validator="stringLength" data-fv-for="server_name" data-fv-result="NOT_VALIDATED"></small>
                        </div>

                        <div class="form-group control-group col-md-12">
                            <div class="controls input-group">
                                <label class="control-label input-group-addon" for="applink1">Download Link</label>
                                <input class="form-control" id="applink1" name="applink" placeholder="http://url/to/app.apk" data-fv-field="applink">
                            </div>
                            <small style="display: none;" class="help-block" data-fv-validator="notEmpty" data-fv-for="server_ip" data-fv-result="NOT_VALIDATED"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="addapp" id="addbtn">Save changes <i class="fa fa-spin fa-spinner loading" style="display: none;"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .error {
        border-color: #f00;
        box-shadow: 0px 0px 5px -2px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#addserverbtn').click(function(e) {
            $(document).find('#addServerModal').modal('show');
        });

        $(document).find('.deleteapp').click(function(e) {
            $(this).children('.loading').show();
            var appid = $(this).data('appid');
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this again!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                },
                function() {
                    $("#deleteform" + appid).submit();
                });

        });
    })
</script>