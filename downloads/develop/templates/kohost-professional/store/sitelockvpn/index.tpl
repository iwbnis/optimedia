<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page sitelockvpn">

    <div class="hero">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-md-6">
                    <h1>{lang key='store.sitelockvpn.subtitle1'}<br>{lang key='store.sitelockvpn.subtitle2'}</h1>
                    <p class="lead text-white">{lang key='store.sitelockvpn.tagline1'} {lang key='store.sitelockvpn.tagline2'}</p>
                    <a href="#plans" class="btn outline-primary-btn">{lang key='store.sitelockvpn.getStarted'}</a>
                </div>
                <div class="col-md-6">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/header-img.png" class="img-responsive hidden-xs">
                </div>
            </div>
        </div>
    </div>

    <div class="feature">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-sm-5 text-center">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/feature-icon-01.png">
                </div>
                <div class="col-sm-7">
                    <h3>{lang key='store.sitelockvpn.feature1.title'}</h3>
                    <p>{lang key='store.sitelockvpn.feature1.subtitle'}</p>
                    <ul class="highlights">
                        <li>{lang key='store.sitelockvpn.feature1.highlights.one'}</li>
                        <li>{lang key='store.sitelockvpn.feature1.highlights.two'}</li>
                        <li>{lang key='store.sitelockvpn.feature1.highlights.three'}</li>
                        <li>{lang key='store.sitelockvpn.feature1.highlights.four'}</li>
                        <li>{lang key='store.sitelockvpn.feature1.highlights.five'}</li>
                        <li>{lang key='store.sitelockvpn.feature1.highlights.six'}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="feature gray-light-bg">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-sm-7">
                    <h3>{lang key='store.sitelockvpn.feature2.title'}</h3>
                    <p>{lang key='store.sitelockvpn.feature2.subtitle'}</p>
                    <ul class="highlights">
                        <li>{lang key='store.sitelockvpn.feature2.highlights.one'}</li>
                        <li>{lang key='store.sitelockvpn.feature2.highlights.two'}</li>
                        <li>{lang key='store.sitelockvpn.feature2.highlights.three'}</li>
                        <li>{lang key='store.sitelockvpn.feature2.highlights.four'}</li>
                        <li>{lang key='store.sitelockvpn.feature2.highlights.five'}</li>
                        <li>{lang key='store.sitelockvpn.feature2.highlights.six'}</li>
                    </ul>
                </div>
                <div class="col-sm-5 text-center">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/feature-icon-02.png">
                </div>
            </div>
        </div>
    </div>

    <div class="feature alternate-bg devices">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-sm-5 text-center">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/feature-icon-03.png">
                </div>
                <div class="col-sm-7">
                    <h3>{lang key='store.sitelockvpn.feature3.title'}</h3>
                    <p>{lang key='store.sitelockvpn.feature3.subtitle'}</p>
                    <p>{lang key='store.sitelockvpn.feature3.subtitle2'}</p>
                    <p><sup class='text-muted'>{lang key='store.sitelockvpn.feature3.subtitle3'}</sup></p>
                </div>
            </div>
            <div class="logos">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/logo-ios.png">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/logo-apple.png">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/logo-windows.png">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/logo-android.png">
                <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/logo-linux.png">
            </div>
        </div>
    </div>

    <a name="plans"></a>
    <div class="feature pricing">
        <div class="container">
            <h2 class="text-center">
                {lang key='store.sitelockvpn.pricing.oneSubscription'}<br>
                <strong>{lang key='store.sitelockvpn.pricing.fiveDevices'}</strong>
            </h2>
            {if count($plans) > 0}
                {if !$loggedin && $currencies}
                    <div class="row">
                        <div class="col-md-3 col-md-offset-9">
                            <form method="post" action="">
                                <select name="currency" class="form-control currency-selector" onchange="submit()">
                                    <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                                    {foreach $currencies as $currency}
                                        <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                                    {/foreach}
                                </select>
                            </form>
                        </div>
                    </div>
                {/if}
                <div class="row">
                    {foreach $plans as $plan}
                        {foreach $pricings[$plan->id] as $pricing}
                            <div class="{if $pricing@total == 1}col-sm-4 col-sm-offset-4{elseif $pricing@total == 2}col-sm-6{elseif $pricing@total == 2}col-sm-6{elseif $pricing@total == 3}col-md-4 col-sm-4{elseif $pricing@total == 4}col-lg-3 col-sm-6{elseif $pricing@total == 5}col-md-4 col-sm-6{else}col-lg-3 col-sm-4{/if}">
                                <div class="pricing-box text-center single-pricing-pack">
                                    <div class="cycle pricing-header">
                                        {if $inPreview && is_array($pricing)}
                                            {$pricing['term']}
                                            {if $pricing@last}
                                                <span class="label label-info">
                                                    {lang key='store.save' saving='-'}
                                                </span>
                                            {/if}
                                        {else}
                                            {if $pricing->isYearly()}
                                                {$pricing->cycleInYears()}
                                            {else}
                                                {$pricing->cycleInMonths()}
                                            {/if}
                                            {if $pricing->calculatePercentageDifference($highestMonthlyPrice) > 0}
                                                <span class="label label-info">
                                                    {lang key='store.save' saving=$pricing->calculatePercentageDifference($highestMonthlyPrice)}
                                                </span>
                                            {/if}
                                        {/if}
                                         <div class="price">
                                            {if $inPreview && is_array($pricing)}
                                                {$pricing['price']}
                                            {else}
                                                {$pricing->toPrefixedString()}
                                            {/if}
                                        </div>
                                    </div>
                                    <ul class="pricing-feature-list">
                                        {if $inPreview}
                                            <li>
                                                <strong>{lang key='store.sampleProduct'}</strong>
                                            </li>
                                        {/if}
                                        {foreach $plan->planFeatures as $langKey => $feature}
                                            <li>
                                                {lang key="store.sitelockvpn.pricing.features.$langKey"}
                                            </li>
                                        {/foreach}
                                        {if $inPreview}
                                            <li>
                                                <strong>{lang key='store.sampleProduct'}</strong>
                                            </li>
                                        {/if}
                                    </ul>
                                    <div class="signup text-center">
                                        <form method="post" action="{routePath('cart-order')}">
                                            <input type="hidden" name="pid" value="{$plan->id}">
                                            {if !$inPreview}
                                                <input type="hidden" name="billingcycle" value="{$pricing->cycle()}">
                                            {/if}
                                            <button type="submit" class="btn primary-solid-btn btn-signup{if $pricing@iteration == ($pricing@total - 1)} highlight1{elseif $pricing@iteration == $pricing@total} highlight2{/if}">
                                                {lang key="signup"}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    {/foreach}
                </div>
            {elseif $inPreview}
                <h2 class="lead text-center">
                    {lang key="store.sitelockvpn.adminPreview"}
                </h2>
            {/if}
        </div>
    </div>

    <div class="feature all-plans gray-light-bg">
        <div class="container">
            <h2 class="section-title text-center">{lang key='store.sitelockvpn.plans.features.allInclude'}:</h2>

            <div class="row row-eq-height">
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                         <i class="fal fa-check-circle"></i>
                         <h5>{lang key='store.sitelockvpn.plans.features.noRestrictions'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.highSpeed'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.unlimited'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.encryption'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.protocol'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.simultaneous'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.apps'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.switching'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.countries'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.servers'}</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="plans-single-feature">
                        <i class="fal fa-check-circle"></i>
                        <h5>{lang key='store.sitelockvpn.plans.features.support'}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="feature world">
        <div class="container">
            <h2 class="section-title text-center">{lang key='store.sitelockvpn.world.features.title'}</h2>

            <div class="row d-flex justify-center">
                <div class="col-md-9 text-center">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/world-map.png">
                </div>
            </div>
            <div class="row  d-flex justify-center">
                <div class="col-xs-6 col-sm-4 col-md-4">
                    <div class="single-feature-counter text-center">
                        <em>{lang key='store.sitelockvpn.world.features.servers'}</em>
                        <span>1000+</span>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4">
                    <div class="single-feature-counter text-center">
                        <em>{lang key='store.sitelockvpn.world.features.countries'}</em>
                        <span>40+</span>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="single-feature-counter text-center">
                        <em>{lang key='store.sitelockvpn.world.features.bandwidth'}</em>
                        <span>{lang key='store.sitelockvpn.world.features.unlimited'}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="feature countries gray-light-bg">
        <div class="container text-center">
            <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelockvpn/flags.png">
        </div>
    </div>

</div>
