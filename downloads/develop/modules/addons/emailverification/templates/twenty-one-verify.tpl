<link href="modules/addons/emailverification/assets/styles.css" rel="stylesheet">
{if $template eq "GigaTick"}
    <style>
        h1, h2, h3, h4, h5, h6 {
            color: #f5f5f5;
            font-weight: normal;
        }
    </style>
{/if}
{if $template eq "flare"}
    <style>
        .panel-heading {
            padding: 10px 15px !important;
            background-color: #337ab7 !important;
        }
    </style>
{/if}
<div class="card text-center">
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label style="font-size:14px" for="validate-email">{$alang.warning}</label>
                <div class="input-group" data-validate="email">
                    <input type="text" {if $notlogged == 'yes'}{if $clock != ''}readonly="readonly"{/if}{/if} value="{$d_email}" class="form-control" style="text-align: center;" name="validate-email" id="validate-email" placeholder="{$alang.ValidateEmail}" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                </div>
            </div>
            <button id="sendemailnow" type="button" class="btn btn-primary" disabled>{$alang.SendVerificationCode}</button> 
            {if $notlogged != 'yes'}<button id="haveaccount" type="button" class="btn btn-info">{$alang.Alreadyhaveaccount}</button>{/if}
        </form>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left" id="myModalLabel">{$alang.SecurityCODE}</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{$alang.Close}</span></button>
            </div>
            <div class="modal-body">
                <div id="resmessage">
                    <div class="alert alert-info">
                        <strong>{$alang.success}</strong> {$alang.codesent}
                    </div>
                    <div class="alert alert-success">
                        <strong>{$alang.success}</strong> {$alang.esuccess}
                        <br>{$alang.Redirecting}
                    </div>      
                    <div class="alert alert-danger">
                        <strong>{$alang.error}</strong> {$alang.Cwrong}
                    </div>                         
                </div>
                <p>{$alang.sdesc}</p>

                <form action="" method="post" style="text-align: center;">
                    <div class="input-group" style="margin: 0 auto;max-width: 50%;">
                        <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                        <input type="number" id="securticode" class="form-control" placeholder="XXXXXX">
                    </div>
                    <br />
                    <button disabled="disabled" id="loccat" type="button" value="sub" name="sub" class="btn btn-primary">{$alang.VerificationNow}</button>
                    <button id="btnSendAgain" type="button" value="sub" name="resub" class="btn btn-danger">{$alang.Resendemail}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{$alang.Emailnotsent}</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{$alang.Close}</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>{$alang.Error}</strong> {$alang.erdesc}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var callbackurl = '{$callbackurl}';
</script>
<script src="modules/addons/emailverification/assets/scripts.js?f=134"></script>
