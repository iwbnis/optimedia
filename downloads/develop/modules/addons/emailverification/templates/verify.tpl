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
<style>
    @media (min-width: 768px){
        .col-sm-offset-3 {
            margin-left: 25%;
        }
    }
    .panel-title,.modal-title {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 16px;
        color: inherit;
    }

</style>
{if $template eq "GigaTick"}<section id="whmcscontentarea">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="whmcscontentbox">
                        <div id="whmcsthemes">
                            <section id="main-body">
                            {/if}    
                            {if $template eq "flare"}
                                <div class="col-md-12">
                                    <div class="col-md-9 col-center-block">
                                    {/if}    
                                    <div class="{if $template != "flattern" && $template != "clouder" && $template != "XMartHost"}container{/if} {if $template == "supreme-host"}containerwhmcs{/if} text-center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel card card-primary panel-primary  text-center">
                                                    <div class="card-header panel-heading">
                                                        <h3 class="panel-title">{$alang.tdesc}</h3>
                                                    </div>
                                                    <div class="card-body panel-body">
                                                        <div class="{if $template != "flattern" && $template != "clouder" && $template != "XMartHost"}{/if}">
                                                            <div class="row">
                                                                <div class="col-md-12" style="font-size: 16px;margin-bottom: 17px;">
                                                                    {$alang.EmailValidationForm}
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-offset-3 col-sm-6">
                                                                    <form method="post">
                                                                        <div class="form-group">
                                                                            <label for="validate-email">{$alang.ValidateEmail}</label>
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">{$alang.SecurityCODE}</h4>
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
                                    {if $template eq "GigaTick"}</section></div></div></div></div></div></section> {/if}    
            {if $template eq "flare"}</div></div>{/if}