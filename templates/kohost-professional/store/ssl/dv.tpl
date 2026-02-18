<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page ssl">

    {include file="$template/store/ssl/shared/nav.tpl" current="dv"}

    <div class="content-block standout">
        <div class="container">

            <div class="row d-flex-align">
                <div class="col-sm-6 col-md-6">
                    <h3>{lang key="store.ssl.dv.descriptionTitle"}</h3>

                    <div class="text-center visible-xs">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl.png" class="img-responsive m-auto">
                        <br><br>
                    </div>

                    {lang key="store.ssl.dv.descriptionContent"}

                    <br>
                    <h4>{lang key="store.ssl.useCases.title"}</h4>
                    <div class="row ideal-for dv row-eq-height">
                        <div class="col-sm-4">
                            <div class="single-feature-box">
                                <i class="fas fa-comment-alt-lines"></i>
                                <h6>{lang key="store.ssl.useCases.blogs"}</h6>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="single-feature-box">
                                <i class="fas fa-file-alt"></i>
                                <h6>{lang key="store.ssl.useCases.infoPages"}</h6>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="single-feature-box">
                                <i class="fas fa-server"></i>
                                <h6>{lang key="store.ssl.useCases.serverComms"}</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6 hidden-xs">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl.png" class="img-responsive m-auto">
                </div>
            </div>
        </div>
    </div>

    {include file="$template/store/ssl/shared/certificate-pricing.tpl" type="dv"}

    {include file="$template/store/ssl/shared/features.tpl" type="dv"}

    {include file="$template/store/ssl/shared/logos.tpl"}

</div>
