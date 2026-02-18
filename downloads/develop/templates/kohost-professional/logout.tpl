<div class="container">
    <div class="row">
        <div class="auth-content-wrap col-sm-12">
            {if $assetLogoPath}
                    <a href="{$WEB_ROOT}/index.php" class="logo"><img src="{$assetLogoPath}" width="120" class="img-responsive" alt="{$companyname}"></a>
                {else}
                    <a href="{$WEB_ROOT}/index.php" class="logo logo-text">{$companyname}</a>
            {/if}
            <div class="logincontainer">
                <div class="header-lined auth-header text-center">
                    <h1>{$LANG.logouttitle}</h1>
                </div>


                {include file="$template/includes/alert.tpl" type="success" msg=$LANG.logoutsuccessful textcenter=false}

                <div class="main-content">
                    <p class="text-center">
                        <a href="index.php" class="btn outline-btn">{$LANG.logoutcontinuetext}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
