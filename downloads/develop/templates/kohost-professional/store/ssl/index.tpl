<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page ssl">

    {include file="$template/store/ssl/shared/nav.tpl" current=""}

    <div class="validation-levels">
        <div class="container">
            <h2>{lang key="store.ssl.landingPage.chooseLevel"}</h2>
            <div class="row row-eq-height">
                <div class="col-sm-6 col-md-4">
                    <div class="item">
                        <h4>{lang key="store.ssl.landingPage.dv"}</h4>
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-dv-icon.png">
                        <span>{lang key="store.ssl.landingPage.dvSubtitle"}</span>
                        <p>{lang key="store.ssl.landingPage.dvInformation"}</p>
                        <a href="{routePath('store-product-group', $routePathSlug, 'dv')}" class="btn primary-solid-btn">{lang key="store.ssl.landingPage.buy"}</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="item">
                        <h4>{lang key="store.ssl.landingPage.ov"}</h4>
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-ov-icon.png">
                        <span>{lang key="store.ssl.landingPage.ovSubtitle"}</span>
                        <p>{lang key="store.ssl.landingPage.ovInformation"}</p>
                        <a href="{routePath('store-product-group', $routePathSlug, 'ov')}" class="btn primary-solid-btn b">{lang key="store.ssl.landingPage.buy"}</a>
                    </div>
                </div>
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-0">
                    <div class="item">
                        <h4>{lang key="store.ssl.landingPage.ev"}</h4>
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-ev-icon.png">
                        <span>{lang key="store.ssl.landingPage.evSubtitle"}</span>
                        <p>{lang key="store.ssl.landingPage.evInformation"}</p>
                        <a href="{routePath('store-product-group', $routePathSlug, 'ev')}" class="btn primary-solid-btn b">{lang key="store.ssl.landingPage.buy"}</a>
                    </div>
                </div>
            </div>
            <p class="help-me-choose mb-0">
                <a href="#"><i class="fas fa-arrow-down"></i> {lang key="store.ssl.shared.helpMeChoose"}</a>
            </p>
        </div>
    </div>

    

    <div class="content-block what-is-ssl standout gray-light-bg">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-sm-7 col-md-6">
                    <h2>{lang key="store.ssl.landingPage.what"}</h2>

                    <div class="text-center visible-xs">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-multi.png" class="m-auto">
                        <br><br>
                    </div>

                    <p>{lang key="store.ssl.landingPage.whatInfo"}</p>
                    <ul class="feature-checklist">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            {lang key="store.ssl.landingPage.secureConnection"}
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            {lang key="store.ssl.landingPage.encrypts"}
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            {lang key="store.ssl.landingPage.padlock"}
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            {lang key="store.ssl.landingPage.authenticates"}
                        </li>
                    </ul>
                    <p>{lang key="store.ssl.landingPage.certTypeInfo" dvLink=routePath('store-product-group', $routePathSlug, 'dv') ovLink=routePath('store-product-group', $routePathSlug, 'ov') evLink=routePath('store-product-group', $routePathSlug, 'ev')}</p>

                </div>
                <div class="col-sm-5 col-md-6 hidden-xs">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-multi.png" class="img-responsive m-auto">
                </div>
            </div>
            <div class="row d-flex-align">
                <div class="col-sm-6 col-md-6 hidden-xs">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/ssl-multi.png" class="img-responsive m-auto">
                </div>
                
                <div class="col-sm-6 col-md-6">
                    <h2>{lang key="store.ssl.landingPage.benefits.title"}</h2>
                    
                    <h4>{lang key="store.ssl.landingPage.benefits.subtitle"}</h4>
                    
                    <p>{lang key="store.ssl.landingPage.benefits.higherResults"}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block ssl-benefits standout">
        <div class="container">
            <div class="row">
                <h3 class="text-center section-title">{lang key="store.ssl.landingPage.benefits.reasons"}</h3>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-benefits">
                        <div class="benefits-icon"><i class="fal fa-globe"></i></div>
                        <h5>{lang key="store.ssl.landingPage.benefits.encrypt"}</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-benefits">
                        <div class="benefits-icon"><i class="fal fa-user"></i></div>
                        <h5>{lang key="store.ssl.landingPage.benefits.privacy"}</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-benefits">
                        <div class="benefits-icon"><i class="fal fa-credit-card"></i></div>
                        <h5>{lang key="store.ssl.landingPage.benefits.secure"}</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-benefits">
                        <div class="benefits-icon"><i class="fal fa-lock"></i></div>
                        <h5>{lang key="store.ssl.landingPage.benefits.https"}</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-benefits">
                        <div class="benefits-icon"><i class="fal fa-trophy"></i></div>
                        <h5>{lang key="store.ssl.landingPage.benefits.legitimacy"}</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-benefits">
                        <div class="benefits-icon"><i class="fal fa-search"></i></div>
                        <h5>{lang key="store.ssl.landingPage.benefits.seo"}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="standout-1">
        <div class="container browser">
            <h3>{lang key="store.ssl.landingPage.browser.title"}</h3>
            <div class="browser-image">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/browser-warning.jpg">
            </div>
        </div>
        <div class="browser-notice">
            <div class="wrapper-container">
                <div class="wrapper">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/padlock-x.png">
                    {lang key="store.ssl.landingPage.browser.insecureNotice"}
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="content-block competitive-upgrade-promo">
        <div class="container">
            <h5 class="mb-0 text-white">{lang key="store.ssl.landingPage.secureInMinutes"}</h5>
        </div>
    </div>

    <div class="content-block standout">
        <div class="container">
            <h2>{lang key="store.ssl.landingPage.evs.upgradeTitle"}</h2>
            <p>{lang key="store.ssl.landingPage.evs.description"}</p>
            <p>{lang key="store.ssl.landingPage.evs.whatIs"}</p>
            <br>
            <div class="row text-center">
                <div class="col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/shopfront-dv.png" class="img-responsive">
                        <h4>{lang key="store.ssl.landingPage.dv"}</h4>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="item">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/shopfront-ov.png" class="img-responsive">
                        <h4>{lang key="store.ssl.landingPage.ov"}</h4>
                    </div>
                </div>
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-0">
                    <div class="item">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/shopfront-ev.png" class="img-responsive">
                        <h4>{lang key="store.ssl.landingPage.ev"}</h4>
                    </div>
                </div>
            </div>
            <br>
            <p class="text-center"><a href="{routePath('store-product-group', $routePathSlug, 'ev')}" class="btn primary-solid-btn btn-md">{lang key="store.ssl.landingPage.evs.learn"}</a></p>
        </div>
    </div>

    <div class="content-block detailed-info" id="sslDetail">
        <div class="container">
            <div class="row">
                <div class="text-center section-title">
                    <h2>{lang key="store.ssl.landingPage.help.title"}</h2>
                    <p class="lead">{lang key="store.ssl.landingPage.help.guide"}</p>
                </div>
            </div>
            
            <div class="section-content">
                <div class="row d-flex-align">
                    <div class="col-md-6">
                        <h4>{lang key="store.ssl.landingPage.help.dv.title"}</h4>

                        <ul>
                            <li>{lang key="store.ssl.landingPage.help.dv.verify"}</li>
                            <li>{lang key="store.ssl.landingPage.help.dv.issued"}</li>
                            <li>{lang key="store.ssl.landingPage.help.dv.compliance"}</li>
                        </ul>
    
                        <p class="ideal">{lang key="store.ssl.landingPage.help.dv.for"}</p>
                        <p class="ssl-types-expl">{lang key="store.ssl.landingPage.help.dv.type"}</p>
    
                        <a href="{routePath('store-product-group', $routePathSlug, 'dv')}" class="btn outline-btn btn-md">{lang key="store.ssl.landingPage.help.dv.browse"}</a>
                    </div>
                    <div class="col-md-6">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/card-library.png" class="img-responsive">
                    </div>
                </div>
            </div>
            
            <div class="section-content">
                <div class="row d-flex-align">
                    <div class="col-md-6">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/card-driving.png" class="img-responsive">
                    </div>
                    <div class="col-md-6">
                        <h4>{lang key="store.ssl.landingPage.help.ov.title"}</h4>

                        <ul>
                            <li>{lang key="store.ssl.landingPage.help.ov.verify"}</li>
                            <li>{lang key="store.ssl.landingPage.help.ov.issued"}</li>
                            <li>{lang key="store.ssl.landingPage.help.ov.compliance"}</li>
                        </ul>
    
                        <p class="ideal">{lang key="store.ssl.landingPage.help.ov.for"}</p>
                        <p class="ssl-types-expl">{lang key="store.ssl.landingPage.help.ov.type"}</p>
    
                        <a href="{routePath('store-product-group', $routePathSlug, 'ov')}" class="btn outline-btn btn-md">{lang key="store.ssl.landingPage.help.ov.browse"}</a>
                    </div>
                </div>
            </div>
            <div class="section-content">
                <div class="row d-flex-align">
                    <div class="col-md-6">
                        <h4>{lang key="store.ssl.landingPage.help.ev.title"}</h4>

                        <ul>
                            <li>{lang key="store.ssl.landingPage.help.ev.verify"}</li>
                            <li>{lang key="store.ssl.landingPage.help.ev.issued"}</li>
                            <li>{lang key="store.ssl.landingPage.help.ev.compliance"}</li>
                        </ul>
                        <p class="ideal">{lang key="store.ssl.landingPage.help.ev.for"}</p>
                        <p class="ssl-types-expl">{lang key="store.ssl.landingPage.help.ev.type"}</p>
    
                        <a href="{routePath('store-product-group', $routePathSlug, 'ev')}" class="btn outline-btn btn-md">{lang key="store.ssl.landingPage.help.ev.browse"}</a>
                    </div>
                    <div class="col-md-6">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/symantec/card-passport.png" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-block">
        <div class="container">
             <div class="row">
                <h2 class="text-center section-title">{lang key="store.ssl.landingPage.viewAll"}</h2>
            </div>
            {include file="$template/store/ssl/shared/currency-chooser.tpl"}
            <div class="ssl-certs-all row row-eq-height">
                {if count($certificates) > 0}
                    {foreach $certificates as $type => $products}
                        {foreach $products as $product}
                            <div class="col-sm-6 col-md-6">
                                <div class="package-wrap">
                                    <div class="package-header">
                                        <h4 class="mb-0">{$product->name}</h4>
                                        <strong>{$product->pricing()->best()->price()->toFull()}</strong>
                                    </div>
                                    <div class="package-content">
                                        <p>{$product->description}</p>
                                    </div>
                                    <div class="package-footer">
                                         <form method="post" action="{routePath('cart-order')}">
                                            <input type="hidden" name="pid" value="{$product->id}">
                                            <button type="submit" class="btn primary-solid-btn">{lang key="store.ssl.landingPage.buyNow"}</button>
                                        </form>
                                        <a href="{routePath("store-product-group", $routePathSlug, $type)}" class="btn outline-btn">{lang key="learnmore"}</a>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    {/foreach}
                {elseif $inPreview}
                    <div class="lead text-center">
                        {lang key="store.ssl.shared.noProducts"}
                    </div>
                {/if}
            </div>
        </div>
    </div>
    
    <div class="content-block gray-light-bg">
        <div class="container">
             <div class="row">
                <h2 class="text-center section-title">Frequently Asked Questions</h2>
            </div>
            <div class="row d-flex justify-center">
                <div class="col-md-10">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ssl.landingPage.faq.q1"}</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ssl.landingPage.faq.a1"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ssl.landingPage.faq.q2"}</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ssl.landingPage.faq.a2"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ssl.landingPage.faq.q3"}</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ssl.landingPage.faq.a3"}</p>
                                </div>
                            </div>
                        </div>
                        {if count($certificates.wildcard) > 0 || $inPreview}
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ssl.landingPage.faq.q4"}</h6>
                            </a>
                            <div id="collapse3" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ssl.landingPage.faq.a4"} <a href="{routePath('store-product-group', $routePathSlug, 'wildcard')}">{lang key="learnmore"}</a></p>
                                </div>
                            </div>
                        </div>
                        {/if}
                         {if count($certificates.ev) > 0 || $inPreview}
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ssl.landingPage.faq.q5"}</h6>
                            </a>
                            <div id="collapse4" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ssl.landingPage.faq.a5"}</p>
                                </div>
                            </div>
                        </div>
                         {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {include file="$template/store/ssl/shared/logos.tpl"}

</div>

<script>
jQuery(document).ready(function() {
  jQuery(".expand").on( "click", function() {
    $expand = jQuery(this).find(">:first-child");
    if($expand.html() == '<i class="fas fa-chevron-right"></i>') {
      $expand.html('<i class="fas fa-chevron-down"></i>');
    } else {
      $expand.html('<i class="fas fa-chevron-right"></i>');
    }
  });
  jQuery('p.help-me-choose').click(function(e) {
    e.preventDefault();
    if (!jQuery('#collapseHelpMeChoose').hasClass('in')) {
      jQuery('#collapseHelpMeChoose').collapse('show');
    }
    jQuery('html, body').animate({
      scrollTop: jQuery('#collapseHelpMeChoose').offset().top - 75
    }, 500);
  });
  var hash = location.hash.replace('#', '');
  if (hash == 'helpmechoose') {
    jQuery('html, body').animate({
      scrollTop: jQuery('#collapseHelpMeChoose').offset().top - 75
    }, 500);
  }
});
</script>
