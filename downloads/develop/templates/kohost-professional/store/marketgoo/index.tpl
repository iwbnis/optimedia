<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page marketgoo">
    <div class="content-block video-banner">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-md-6">
                    <div class="logo">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/logo.svg" class="img-responsive" width=" 450px">
                    </div>
                    <h2 class="strong-green">{lang key="store.marketgoo.headline"} {lang key="store.marketgoo.tagline"}</h2>
                </div>
                <div class="col-md-6">
                    <div class="embed-responsive">
                        <iframe src="https://player.vimeo.com/video/394484913" class="embed-responsive-item" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block feature-blocks" id="how">
        <div class="container">
            <div class="row row-eq-height justify-center">
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="block single-backup-feature">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/1-signup.svg" class="img-responsive" width="80">
                        <span>1. {lang key="store.marketgoo.features.1"}</span>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="block single-backup-feature">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/2-get-seo-plan.svg" class="img-responsive" width="80">
                        <span>2. {lang key="store.marketgoo.features.2"}</span>
                    </div>
                </div>
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="block single-backup-feature">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/3-follow-instructions.svg" class="img-responsive" width="80">
                        <span>3. {lang key="store.marketgoo.features.3"}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="block single-backup-feature gray-light-bg">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/4-start-improving.svg" class="img-responsive" width="80">
                        <span>4. {lang key="store.marketgoo.features.4"}</span>
                        <p>{lang key="store.marketgoo.featuresdetail.4"}</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="block single-backup-feature gray-light-bg">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/5-track-monitor.svg" class="img-responsive" width="80">
                        <span>5. {lang key="store.marketgoo.features.5"}</span>
                        <p>{lang key="store.marketgoo.featuresdetail.5"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content-block gray-light-bg" id="features">
        <div class="container">
            {if count($plans) > 0}
                <div class="visible-xs">
                    <form method="post" action="">
                        <select name="currency" class="form-control" onchange="submit()">
                            <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                            {foreach $currencies as $currency}
                                <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                            {/foreach}
                        </select>
                    </form>
                    <br><br>
                </div>
                <div class="plan-container">
                    {foreach $plans as $plan}
                        <div class="plan labels">
                            <div class="header">
                                {if !$loggedin && $currencies}
                                    <br>
                                    <form method="post" action="" class="hidden-xs">
                                        <select name="currency" class="form-control currency-selector" onchange="submit()">
                                            <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                                            {foreach $currencies as $currency}
                                                <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                                            {/foreach}
                                        </select>
                                    </form>
                                {/if}
                            </div>
                            <ul>
                                {foreach $plan->features as $label => $value}
                                    <li><span>{lang key="store.marketgoo.featurematrix."|cat:$value@iteration}</span></li>
                                {/foreach}
                            </ul>
                        </div>
                        <div class="plan {$plan->configoption1}">
                            <div class="header">
                                <h4>
                                    <span class="title">{$plan->name}</span>
                                    <span class="best-value">Best value!</span>
                                </h4>
                                <span class="pricing">
                                    {if $plan->isFree()}
                                        {lang key='orderpaymenttermfree'}
                                    {elseif $plan->pricing()->first()}
                                        {$plan->pricing()->first()->toPrefixedString()}
                                    {else}
                                        -
                                    {/if}
                                </span>
                            </div>
                            <ul>
                                {foreach $plan->features as $label => $value}
                                    <li>
                                        {if is_bool($value)}
                                            <i class="fal fa-check"></i>
                                        {else}
                                            {$value}
                                        {/if}
                                    </li>
                                {/foreach}
                            </ul>
                            <form action="{routePath('cart-order')}" method="post">
                                <input type="hidden" name="pid" value="{$plan->id}">
                                <button type="submit" class="btn primary-solid-btn btn-signup">
                                    {lang key='store.marketgoo.signup'}
                                </button>
                            </form>
                        </div>
                    {/foreach}
                </div>
            {elseif $inPreview}
                <div class="lead text-center">
                    {lang key="store.marketgoo.adminPreview"}
                </div>
            {/if}
        </div>
    </div>

    <div class="content-block testimonials" id="testimonials">
        <div class="container">
            <div class="row d-flex-align">
                <div class="col-md-6 col-lg-6">
                    <h2>Trusted by over 60,000+ users Worldwide</h2>
                    <p class="lead">We love it when our users love us! Here’s some of what they have to say.</p>
                </div>
                <div class="col-md-5 col-lg-5">
                    <div id="marketgoo-testimonials" class="carousel slide" data-ride="carousel" data-interval="10000">
                        <ol class="carousel-indicators">
                            <li data-target="#marketgoo-testimonials" data-slide-to="0" class="active"></li>
                            <li data-target="#marketgoo-testimonials" data-slide-to="1"></li>
                            <li data-target="#marketgoo-testimonials" data-slide-to="2"></li>
                            <li data-target="#marketgoo-testimonials" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <div class="item border single-review-wrap bg-white active">
                                <div class="testimonial">
                                    "marketgoo made the complicated simple for me. I never knew where to start with SEO until I started using this service. Literally, I more than doubled my traffic when I started using this."
                                </div>
                                <div class="user review-author d-flex-align">
                                    <div class="author-avatar">
                                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/user-testimonial-1.jpg">
                                        <span>“</span>
                                    </div>
                                    <div class="bio review-info">
                                        <h6>Heather Figi</h6>
                                        <span>Music for Young Violinists</span>
                                        <a href="https://www.marketgoo.com/blog-post/2018/08/30/review-music-for-violinists/" target="_blank">{lang key="store.marketgoo.testimonials.casestudy"}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item border single-review-wrap bg-white">
                                <div class="testimonial">
                                    "Without marketgoo I would never have been able to have my website on the first page of google for all the keywords that are linked to my business, its ease of use and the customer service when I’ve needed help has been first class."
                                </div>
                                <div class="user review-author d-flex-align">
                                    <div class="author-avatar">
                                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/user-testimonial-2.jpg">
                                        <span>“</span>
                                    </div>
                                    <div class="bio review-info">
                                        <h6>Ian Glass</h6>
                                        <span>Ian Glass Fitness</span>
                                        <a href="https://www.marketgoo.com/blog-post/2019/10/29/review-ian-glass-fitness/" target="_blank">{lang key="store.marketgoo.testimonials.casestudy"}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item border single-review-wrap bg-white">
                                <div class="testimonial">
                                    "Such a simple reliable platform! It’s helped me see where we stand next to our local competitors. Its part of our day to day. The best feature is the keyword tool."
                                </div>
                                <div class="user review-author d-flex-align">
                                    <div class="author-avatar">
                                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/user-testimonial-3.jpg">
                                        <span>“</span>
                                    </div>
                                    <div class="bio review-info">
                                        <h6>Simon Saleh</h6>
                                        <span>Wanderlust Ironworks</span>
                                        <a href="https://www.marketgoo.com/blog-post/2019/09/09/review-wanderlust-ironworks/" target="_blank">{lang key="store.marketgoo.testimonials.casestudy"}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item border single-review-wrap bg-white">
                                <div class="testimonial">
                                    "marketgoo reports give me everything I need to know for my site’s SEO. I am constantly fine tuning my site to work towards a higher rating. I read various marketgoo reports then immediately work out how to implement recommendations."
                                </div>
                                <div class="user review-author d-flex-align">
                                    <div class="author-avatar">
                                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/user-testimonial-4.jpg">
                                        <span>“</span>
                                    </div>
                                    <div class="bio review-info">
                                        <h6>Svein Koningen</h6>
                                        <span>Koningen Art</span>
                                        <a href="https://www.marketgoo.com/blog-post/2018/06/24/marketgoo-review-koningen-art/" target="_blank">{lang key="store.marketgoo.testimonials.casestudy"}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block faqs gray-light-bg" id="faqs">
        <div class="container">
            <h2 class="text-center">{lang key="store.marketgoo.faqs.title"}</h2>
            <div class="row d-flex justify-center">
                <div class="col-md-10">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.marketgoo.faqs.q1"}</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.marketgoo.faqs.a1"}</p>
                                     <a href="https://vimeo.com/whmcs/marketgoo-lite-vs-pro" target="_blank">
                                        <img src="{$WEB_ROOT}/assets/img/marketconnect/marketgoo/video-comparison.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.marketgoo.faqs.q2"}</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.marketgoo.faqs.a2"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.marketgoo.faqs.q3"}</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.marketgoo.faqs.a3"}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
