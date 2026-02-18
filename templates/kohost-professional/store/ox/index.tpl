<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page ox">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-6 text-center">
                    <img src="{$WEB_ROOT}/assets/img/marketconnect/ox/display-email.png" class="header-img">
                </div>
                <div class="col-md-6 col-md-pull-6">
                    <div class="header-content">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/ox/logo-inv.png" class="logo-img">
                        <h1>{lang key="store.ox.promoHeading"}</h1>
                        <button type="button" class="btn outline-primary-btn" onclick="smoothScroll('#oxPricing')">
                            {lang key="store.ox.viewPricing"}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-block gray-light-bg">
        <div class="container">
            <div class="row row-eq-height justify-center">
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-promo-card single-promo-hover">
                        <div class="promo-body">
                            <div class="promo-icon">
                                <span class="fal fa-envelope color-primary"></span>
                            </div>
                            <div class="promo-info">
                                 <h5>{lang key="store.ox.standout.feature1.title"}</h5>
                                 <ul>
                                    <li>{lang key="store.ox.standout.feature1.bullet1"}</li>
                                    <li>{lang key="store.ox.standout.feature1.bullet2"}</li>
                                    <li>{lang key="store.ox.standout.feature1.bullet3"}</li>
                                    <li>{lang key="store.ox.standout.feature1.bullet4"}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-promo-card single-promo-hover">
                        <div class="promo-body">
                            <div class="promo-icon">
                                <span class="fal fa-server color-primary"></span>
                            </div>
                            <div class="promo-info">
                                 <h5>{lang key="store.ox.standout.feature2.title"}</h5>
                                 <p>{lang key="store.ox.standout.feature2.detail"}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="single-promo-card single-promo-hover">
                        <div class="promo-body">
                            <div class="promo-icon">
                                <span class="fal fa-globe-americas color-primary"></span>
                            </div>
                            <div class="promo-info">
                                 <h5>{lang key="store.ox.standout.feature3.title"}</h5>
                                 <p>{lang key="store.ox.standout.feature3.detail"}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="features content-block ">
        <div class="container">
            <h2 class="text-center">{lang key="store.ox.featuresHeadline"}</h2>
            <div class="row row-eq-height">
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded text-center">
                        <i class="fab fa-mixcloud"></i>
                        <div class="content">
                            <p class="title">{lang key="store.ox.feature1.title"}</p>
                            <p>{lang key="store.ox.feature1.detail"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded text-center">
                        <i class="fal fa-calendar-alt"></i>
                        <div class="content">
                            <p class="title">{lang key="store.ox.feature2.title"}</p>
                            <p>{lang key="store.ox.feature2.detail"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded text-center">
                        <i class="fal fa-envelope"></i>
                        <div class="content">
                            <p class="title">{lang key="store.ox.feature3.title"}</p>
                            <p>{lang key="store.ox.feature3.detail"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded text-center">
                        <i class="fal fa-copy"></i>
                        <div class="content">
                            <p class="title">{lang key="store.ox.feature4.title"}</p>
                            <p>{lang key="store.ox.feature4.detail"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded text-center">
                        <i class="fal fa-bring-forward"></i>
                        <div class="content">
                            <p class="title">{lang key="store.ox.feature5.title"}</p>
                            <p>{lang key="store.ox.feature5.detail"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded text-center">
                        <i class="fal fa-user-secret"></i>
                        <div class="content">
                            <p class="title">{lang key="store.ox.feature6.title"}</p>
                            <p>{lang key="store.ox.feature6.detail"}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pricing content-block gray-light-bg" id="oxPricing">
        <div class="container">
            <h2 class="section-title text-center">{lang key="store.ox.pricingHeadline"}</h2>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table>
                        <tr>
                            <td class="no-border"></td>
                            {foreach $plans as $plan}
                                <th{if $plan.configoption1 == 'ox_productivity'} class="feature"{/if}>
                                    {$plan->name}
                                    <div class="pricing-label">
                                        {if $inPreview}
                                            -
                                        {else}
                                            {$plan->pricing()->first()->toFullString()}
                                            <small>Per user</small>
                                        {/if}
                                    </div>
                                </th>
                            {/foreach}
                        </tr>
                        {foreach $plans[0]['features'] as $feature => $value}
                            <tr>
                                <td>{$feature}</td>
                                {foreach $plans as $plan}
                                    <td>
                                        {if is_bool($plan['features'][$feature])}
                                            <i class="fal fa-check"></i>
                                        {else}
                                            {$plan['features'][$feature]}
                                        {/if}
                                    </td>
                                {/foreach}
                            </tr>
                        {/foreach}
                        <tr>
                            <td class="no-border no-bg"></td>
                            {foreach $plans as $plan}
                                <td class="no-border buy">
                                    <form method="post" action="{routePath('cart-order')}">
                                        <input type="hidden" name="pid" value="{$plan->id}">
                                        <button type="submit" class="btn primary-solid-btn">
                                            {lang key="store.ssl.landingPage.buyNow"}
                                        </button>
                                    </form>
                                </td>
                            {/foreach}
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="faqs">
        <div class="container">
            <h2 class="section-title text-center">Frequently Asked Questions</h2>
            <div class="row d-flex justify-center">
                <div class="col-md-10">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq1.question"}</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq1.answer"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq2.question"}</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq2.answer"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq3.question"}</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq3.answer"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq4.question"}</h6>
                            </a>
                            <div id="collapse3" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq4.answer"}<br>
                                    {lang key="store.ox.faq4.devices"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq5.question"}</h6>
                            </a>
                            <div id="collapse4" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq5.answer"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq6.question"}</h6>
                            </a>
                            <div id="collapse5" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq6.answer"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse6" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq7.question"}</h6>
                            </a>
                            <div id="collapse6" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq7.answer"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse7" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.ox.faq8.question"}</h6>
                            </a>
                            <div id="collapse7" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.ox.faq8.answer"}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

