<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page ssl">

    {include file="$template/store/ssl/shared/nav.tpl" current="ov"}

    <div class="content-block standout">
        <div class="container">

            <div class="row d-flex-align">
                <div class="col-sm-6 col-md-6">

                    <h3>{lang key="store.ssl.ov.descriptionTitle"}</h3>

                    <div class="text-center visible-xs">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-subs.png" class="img-responsive m-auto">
                        <br><br>
                    </div>

                    {lang key="store.ssl.ov.descriptionContent"}

                    <br>
                    <h4>{lang key="store.ssl.useCases.title"}</h4>
                    <div class="row ideal-for dv row-eq-height">
                        <div class="col-sm-4">
                            <div class="single-feature-box">
                                <i class="fas fa-lock-alt"></i>
                                <h6>{lang key="store.ssl.useCases.loginPages"}</h6>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="single-feature-box">
                                <i class="fas fa-project-diagram"></i>
                                <h6>{lang key="store.ssl.useCases.intranetSites"}</h6>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="single-feature-box">
                                <i class="fas fa-inbox"></i>
                                <h6>{lang key="store.ssl.useCases.webmail"}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 hidden-xs">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-subs.png" class="img-responsive m-auto">
                </div>
            </div>

        </div>
    </div>

    {include file="$template/store/ssl/shared/certificate-pricing.tpl" type="ov"}

    <div class="content-block dashed-border standout">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-lg-push-7 col-md-5 col-md-push-7">
                    <br>
                    <h4>{lang key="store.ssl.ov.orgInfo"}</h4>
                    <p>{lang key="store.ssl.ov.orgInfoDescription"}</p>
                </div>
                <div class="col-lg-6 col-lg-pull-2 col-md-7 col-md-pull-4">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/cert-details-ov.png">
                </div>
            </div>
        </div>
    </div>

    {include file="$template/store/ssl/shared/features.tpl" type="ov"}

    {include file="$template/store/ssl/shared/logos.tpl"}

</div>
