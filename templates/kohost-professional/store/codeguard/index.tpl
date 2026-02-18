<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
<![endif]-->

<link type="text/css" rel="stylesheet" href="{$BASE_PATH_CSS}/ion.rangeSlider.css" property="stylesheet" />
<link type="text/css" rel="stylesheet" href="{$BASE_PATH_CSS}/ion.rangeSlider.skinHTML5.css" property="stylesheet" />
<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page codeguard">
    <div class="content-block image-standout" id="overview">
        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h2 class="strong-green">{lang key="store.codeGuard.headline"}</h2>
                    <p class="lead">{lang key="store.codeGuard.tagline"}</p>
                </div>
            </div>
            <div class="row d-flex-align">
                <div class="col-sm-5 text-center">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/codeguard/hero-image-a.png" class="img-responsive">
                </div>
                <div class="col-sm-7">
                    <h3 class="strong-green">{lang key="store.codeGuard.leadTitle"}</h3>
                    <p>{lang key="store.codeGuard.leadText1"}</p>
                    <p>{lang key="store.codeGuard.leadText2"}</p>
                </div>
            </div>
            <br>
            <div class="row row-eq-height justify-center">
                 <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-backup-feature">
                        <i class="fal fa-recycle"></i>
                        <span>{lang key="store.codeGuard.dailyBackup"}</span>
                    </div>
                 </div>
                 <div class="col-lg col-md-4 col-sm-6">
                     <div class="single-backup-feature">
                        <i class="fal fa-users"></i>
                        <span>{lang key="store.codeGuard.timeMachine"}</span>
                     </div>
                 </div>
                 <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-backup-feature">
                        <i class="fab fa-wordpress-simple"></i>
                        <span>{lang key="store.codeGuard.wpPlugin"}</span>
                    </div>
                 </div>
                 <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-backup-feature">
                        <i class="fal fa-bell"></i>
                        <span>{lang key="store.codeGuard.changeAlerts"}</span>
                    </div>
                 </div>
                 <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-backup-feature">
                        <i class="fal fa-bug"></i>
                        <span>{lang key="store.codeGuard.malwareProtection"}</span>
                    </div>
                 </div>
            </div>

        </div>
    </div>

    
    <div class="content-block pricing" id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-title text center">
                     <h2 class="text-white">{lang key='store.codeGuard.chooseBackupPlan'}</h2>
                </div>
            </div>
            <div class="row">
                {if count($products) > 0}
                    <div class="col-md-9">
                        {if !$loggedin && $currencies}
                            <form method="post" action="{routePath('store-product-group', $routePathSlug)}" class="pull-right">
                                <select name="currency" class="form-control currency-selector" onchange="submit()">
                                    <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                                    {foreach $currencies as $currency}
                                        <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                                    {/foreach}
                                </select>
                            </form>
                        {/if}
                        <div class="price-calc-top">
                            <input type="hidden" id="codeGuardPlanSelector" name="codeguardplan" value="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="price-calc-container">
                            <div class="pricing-container">
                                <div id="pricingAmount" class="price">--</div>
                                <div id="pricingCycle"></div>
                            </div>
                            <form action="{routePath('cart-order')}" method="post" class="pull-right">
                                <input id="selectedProductId" type="hidden" name="pid" value="">
                                <button type="submit" class="btn primary-solid-btn order-btn" id="product-order-button">
                                    {lang key='ordernowbutton'}
                                </button>
                            </form>
                        </div>
                    </div>
                {elseif $inPreview}
                    <div class="col-xs-12 lead text-center">
                        {lang key="store.codeGuard.adminPreview"}
                    </div>
                {/if}
            </div>
        </div>
    </div>

    <div class="content-block features" id="features">
        <div class="container">
            <div class="row row-eq-height">
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-browser"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.dailyBackup"}</h4>
                        <p>{lang key="store.codeGuard.features.dailyBackupDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-database"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.unlimitedFiles"}</h4>
                        <p>{lang key="store.codeGuard.features.unlimitedFilesDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-mouse-pointer"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.oneClickRestore"}</h4>
                        <p>{lang key="store.codeGuard.features.oneClickRestoreDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-bug"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.malwareMonitoring"}</h4>
                        <p>{lang key="store.codeGuard.features.malwareMonitoringDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-plug"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.wp"}</h4>
                        <p>{lang key="store.codeGuard.features.wpDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-copy"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.fileMonitoring"}</h4>
                        <p>{lang key="store.codeGuard.features.fileMonitoringDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-window-restore"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.servers"}</h4>
                        <p>{lang key="store.codeGuard.features.serversDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-mailbox"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.email"}</h4>
                        <p>{lang key="store.codeGuard.features.emailDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="feature">
                        <div class="icon">
                            <i class="fad fa-robot"></i>
                        </div>
                        <h4>{lang key="store.codeGuard.features.api"}</h4>
                        <p>{lang key="store.codeGuard.features.apiDescription"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block faqs gray-light-bg" id="faq">
        <div class="container">
            <h2 class="text-center section-title">{lang key="store.codeGuard.faq.title"}</h2>
            <div class="row">
                {foreach $codeGuardFaqs as $faq}
                    <div class="col-md-4 col-sm-6">
                        <h5>{$faq['question']}</h5>
                        <p>{$faq['answer']}</p>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

<!-- RangeSlider JS -->
<script type="text/javascript" src="{$BASE_PATH_JS}/ion.rangeSlider.js"></script>
<script type="text/javascript">

    var sliderActivated = false;

    var sliderProductNames = [
    {foreach $products as $product}
        "{$product->diskSpace}",
    {/foreach}
    ];

    var allProducts = {
        {foreach $products as $num => $product}
        "{$num}": {
            "pid": "{$product->id}",
            "name": "{$product->name}",
            "desc": "{$product->formattedProductFeatures.featuresDescription|nl2br|trim}",
            "price": "{$product->pricing()->first()->price()}",
            "cycle": "{lang key={'orderpaymentterm'|cat:$product->pricing()->first()->cycle()}}"
        },
        {/foreach}
    };

    var definedProducts = {
        {foreach $products as $product}
            "{$product->id}": "{$product@index}"{if !($product@last)},{/if}
        {/foreach}
    };

    {foreach $products as $product}
        {if $product->isFeatured}
            var firstFeatured = definedProducts["{$product->id}"];
            {break}
        {/if}
    {/foreach}

    var rangeSliderValues = {
        type: "single",
        grid: true,
        grid_snap: true,
        hide_min_max: true,
        step: 1,
        from: 1,
        onStart: refreshSelectedProduct,
        {if $products|@count eq 1}
            disable: true,
        {/if}
        onChange: refreshSelectedProduct,
        values: sliderProductNames
    };

    if (typeof firstFeatured !== 'undefined') {
        rangeSliderValues['from'] = firstFeatured;
    }

    function refreshSelectedProduct(data)
    {
        var featureName = "";
        var featureMarkup = "";
        var i = parseInt(data.from);
        if (isNaN(i)) {
            i = 0;
            jQuery(".irs-single").text(sliderProductNames[0]);
            jQuery(".irs-grid-text").text('');
        }

        jQuery("#selectedProductId").val(allProducts[i].pid);
        jQuery("#productDescription").html(allProducts[i].desc);
        jQuery("#pricingAmount").html(allProducts[i].price);
        jQuery("#pricingCycle").html(allProducts[i].cycle);
    }

    jQuery("#codeGuardPlanSelector").ionRangeSlider(rangeSliderValues);
    {if $products|@count eq 1}
    jQuery(".irs-single").text(sliderProductNames[0]);
    jQuery(".irs-grid-text").text('');
    {/if}

    sliderActivated = true;
</script>
