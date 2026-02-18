<div id="whmcms">
    <div class="container-fluid" style="padding-top:30px;">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <a href="http://www.whmcms.com" target="_blank">
                    <img src="../modules/addons/whmcms/assets/img/whmcms.png" alt="WHMCMS">
                </a>
                <div class="clearline"></div>
                <br>
            </div>
            <div class="col-lg-8 col-lg-offset-2">
                <div class="well">
                    <form action="{$modurl}" method="post">
                        <input type="hidden" name="action" value="updatelicensekey">
                        <div class="form-group">
                            <input type="text" name="licensekey" id="licensekey" value="{$licensekey}" class="form-control" placeholder="Enter Your License Key .." autofocus>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary span3">Activate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="clearline"></div>
        
        {if $licenseMessage}
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="alert alert-danger">
                    <strong>License Error</strong>
                    <p>{$licenseMessage}</p>
                </div>
            </div>
        </div>
        {/if}
        
    </div>
</div>