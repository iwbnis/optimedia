<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page ssl">
    {include file="$template/store/ssl/shared/nav.tpl" current="wildcard"}

    <div class="content-block standout">
        <div class="container">

            <div class="row d-flex-align">
                <div class="col-sm-6 col-md-6">

                    <h3>{lang key="store.ssl.wildcard.descriptionTitle"}</h3>

                    <div class="text-center visible-xs">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-subs.png" class="img-responsive m-auto">
                        <br><br>
                    </div>

                    {lang key="store.ssl.wildcard.descriptionContent"}
                </div>
                <div class="col-sm-6 col-md-6 text-right hidden-xs">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-subs.png" class="img-responsive m-auto">
                </div>
            </div>

        </div>
    </div>

    {include file="$template/store/ssl/shared/certificate-pricing.tpl" type="wildcard"}

    {include file="$template/store/ssl/shared/features.tpl" type="wildcard"}

    {include file="$template/store/ssl/shared/logos.tpl"}

</div>
