<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page weebly">

     <div class="content-block image-standout" id="overview">
         <div class="row">
            <div class="section-heading text-center">
                <h2>{lang key="store.websiteBuilder.headline"}</h2>
                <p class="lead">{lang key="store.websiteBuilder.tagline"}</p>
            </div>
        </div>
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-sm-5">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/dragdropeditor.png">
                </div>
                <div class="col-sm-7">
                    <h3>{lang key="store.websiteBuilder.ddEditor"}</h3>
                    <p>{lang key="store.websiteBuilder.introduction"}</p>
                    <p>{lang key="store.websiteBuilder.ddEditorDescription"}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block features gray-light-bg" id="features">
        <div class="container">
            <div class="row row-eq-height">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/builder.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.builder"}</h4>
                    <p>{lang key="store.websiteBuilder.features.builderDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/ecommerce.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.ecommerce"}</h4>
                    <p>{lang key="store.websiteBuilder.features.ecommerceDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/forms.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.forms"}</h4>
                    <p>{lang key="store.websiteBuilder.features.formsDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/templates.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.templates"}</h4>
                    <p>{lang key="store.websiteBuilder.features.templatesDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/gallery.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.gallery"}</h4>
                    <p>{lang key="store.websiteBuilder.features.galleryDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/blogging.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.blogging"}</h4>
                    <p>{lang key="store.websiteBuilder.features.bloggingDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/video.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.video"}</h4>
                    <p>{lang key="store.websiteBuilder.features.videoDescription"}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="feature">
                    <div class="icon"><img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/icons/seo.png" width="65"></div>
                    <h4>{lang key="store.websiteBuilder.features.seo"}</h4>
                    <p>{lang key="store.websiteBuilder.features.seoDescription"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block pricing" id="pricing">
        <div class="container">
            <div class="row">
                <div class="section-headding text-center">
                    <h2>Pricing Plan</h2>
                </div>
            </div>
            <div class="row justify-center d-flex">
                <div class="col-sm-9 text-center">
                    <div class="btn-group pricing-tab-btn" role="group">
                        {foreach $billingCycles as $cycle}
                            <button type="button" class="btn primary-solid-btn cycle-change{if $cycle@first} active{/if}" data-cycle="{$cycle}">
                                {lang key={'orderpaymentterm'|cat:$cycle}}
                            </button>
                        {/foreach}
                    </div>
                    <br><br>
                </div>
                {if !$loggedin && $currencies}
                    <div class="col-sm-3">
                        <form method="post" action="">
                            <select name="currency" class="form-control currency-selector" onchange="submit()">
                                <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                                {foreach $currencies as $currency}
                                    <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                                {/foreach}
                            </select>
                        </form>
                    </div>
                {/if}
            </div>

            {if $litePlan}
                <div class="weebly-lite-plan gray-light-bg border">
                    <div class="pricing pull-right">
                        {foreach $litePlan->pricing()->allAvailableCycles() as $pricing}
                            <h4 class="pricing-text {$pricing->cycle()}{if !$pricing@first} hidden{/if}">
                                {$pricing->toFullString()}
                            </h4>
                        {foreachelse}
                            {if $inPreview}
                                -
                            {/if}
                        {/foreach}
                        <h4 class="pricing-text not-available hidden">-</h4>
                    </div>
                    <h4>{lang key="store.websiteBuilder.pricing.free.headline"}</h4>
                    <h5>{lang key="store.websiteBuilder.pricing.free.tagline"}</h5>
                    <p>{$litePlan->description}</p>
                    <form method="post" action="{routePath('cart-order')}">
                        <input type="hidden" name="pid" value="{$litePlan->id}">
                        <input type="hidden" name="billingcycle" value="">
                        <button type="submit" class="btn primary-solid-btn btn-signup">
                            {lang key='getStartedNow'}
                        </button>
                    </form>
                </div>
            {/if}

            <div class="row weebly-plans">
                {if count($products) > 0}
                    {foreach $products as $key => $product}
                        <div class="{if count($products) == 1}col-sm-6 col-sm-offset-3{elseif count($products) == 2}col-sm-5{if $key == 0} col-sm-offset-1{/if}{elseif count($products) == 3}col-sm-4{else}col-sm-3{/if}">
                            <div class="pricing-item text-center single-pricing-pack border gray-light-bg">
                                <div class="top">
                                    <h5 class="mb-0">{$product->name}</h5>
                                    <p class="mb-0">{lang key="store.websiteBuilder.pricing.idealFor" for=$product->idealFor}</p>
                                </div>
                                <div class="header">
                                    <div class="price">
                                        {foreach $product->pricing()->allAvailableCycles() as $pricing}
                                            <span class="pricing-text {$pricing->cycle()}{if !$pricing@first} hidden{/if}">
                                                {$pricing->toFullString()}
                                            </span>
                                        {foreachelse}
                                            {if $inPreview}
                                                -
                                            {/if}
                                        {/foreach}
                                        <span class="pricing-text not-available hidden">
                                            -
                                        </span>
                                    </div>
                                </div>
                                <div class="feature-content">
                                    <div class="feature-heading">{lang key="store.websiteBuilder.pricing.siteFeatures"}</div>
                                    <ul class="site-features pricing-feature-list">
                                        {foreach $product->siteFeatures as $langKey => $feature}
                                            <li>
                                                {lang key="store.websiteBuilder.pricing.features.$langKey"}
                                            </li>
                                        {/foreach}
                                    </ul>
                                    <div class="feature-heading">{lang key="store.websiteBuilder.pricing.eCommerceFeatures"}</div>
                                    <ul class="ecommerce-features pricing-feature-list">
                                        {foreach $product->ecommerceFeatures as $langKey => $feature}
                                            <li>
                                                {lang key="store.websiteBuilder.pricing.features.$langKey"}
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <div class="footer">
                                    <form method="post" action="{routePath('cart-order')}">
                                        <input type="hidden" name="pid" value="{$product->id}">
                                        <input type="hidden" name="billingcycle" value="">
                                        <button type="submit" class="btn primary-solid-btn btn-signup">{lang key="signup"}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                {elseif $inPreview}
                    <div class="col-xs-12 lead text-center">
                        {lang key="store.websiteBuilder.adminPreview"}
                    </div>
                {/if}
            </div>

        </div>
    </div>

    <div class="content-block faq gray-light-bg" id="faq">
        <div class="container">
            <h3 class="text-center">{lang key="store.websiteBuilder.faq.title"}</h3>
            <div class="row">
                {foreach [[1,2,3], [4,5,6], [7,8]] as $columns}
                    <div class="col-md-4">
                        {foreach $columns as $row}
                            <h5>{lang key="store.websiteBuilder.faq.q$row"}</h5>
                            <p>{lang key="store.websiteBuilder.faq.a$row"}</p>
                            {if $row@last && $row != 8}
                                <div class="hidden-md hidden-lg"><hr></div>
                            {else}
                                <hr>
                            {/if}
                        {/foreach}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

    <div class="content-block trusted-by">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/weebly/logo.png">
                </div>
                <div class="col-sm-7 text-right">
                    {lang key="store.websiteBuilder.trust"}
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{$WEB_ROOT}/templates/{$template}/store/weebly/master.js"></script>
