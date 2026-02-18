<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page sitelock">

    <div class="content-block gradient-bg">
        <div class="container">
             <div class="row">
                <div class="section-title text-center">
                    <h2 class="text-white">{lang key="store.sitelock.tagline"}</h2>
                </div>
            </div>
            <br>
            <div class="row row-eq-height">
                <div class="col-sm-5">
                    <div class="white-bg sitelock-bg">
                        <img src="{$WEB_ROOT}/assets/img/marketconnect/sitelock/logo.png" class="img-responsive">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="sitelock-content text-white">
                        <h3 class="text-white">{lang key="store.sitelock.contentHeadline"}</h3>
                        <p>{lang key="store.sitelock.contentBodyParagraph1"}</p>
                        <p>{lang key="store.sitelock.contentBodyParagraph2"}</p>
                        <p>{lang key="store.sitelock.contentBodyParagraph3"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-block plans gray-light-bg" id="plans">
        <div class="container">

            {if !$loggedin && $currencies}
                <form method="post" action="" class="pull-right">
                    <select name="currency" class="form-control currency-selector" onchange="submit()">
                        <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                        {foreach $currencies as $currency}
                            <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                        {/foreach}
                    </select>
                </form>
            {/if}
            <div class="row">
                <div class="section-title text-center">
                    <h2>{lang key="store.sitelock.comparePlans"}</h2>
                    <p class="lead">{lang key="store.sitelock.comparePlansSubtitle"}</p>
                </div>
            </div>

            <div class="row plan-comparison">
                {foreach $plans as $plan}
                    <div class="col-lg-{if count($plans) == 4}3{elseif count($plans) == 3}4{elseif count($plans) == 2}6{else}12{/if} col-md-{if count($plans) == 3}4{/if} col-sm-6">
                        <div class="plan text-center single-pricing-pack">
                            <div class="top">
                                <h5 class="mb-0">{$plan->name}</h5>
                                <p class="mb-0">{$plan->description}</p>
                            </div>
                            <div class="header">
                                <h4 class="text-white mb-0">
                                    {if $plan->isFree()}
                                        FREE
                                    {elseif $plan->pricing()->annually()}
                                        {$plan->pricing()->annually()->toPrefixedString()}
                                    {elseif $plan->pricing()->first()}
                                        {$plan->pricing()->first()->toPrefixedString()}
                                    {else}
                                        -
                                    {/if}
                                </h4>
                            </div>
                            <ul class="pricing-feature-list">
                                {foreach $plan->features as $label => $value}
                                    <li>
                                        {if is_bool($value)}
                                            <i class="fal fa-{if $value}check{else}times{/if}"></i>
                                        {else}
                                            <span>{$value}</span>
                                        {/if}
                                        {$label}
                                    </li>
                                {/foreach}
                            </ul>
                            <div class="footer">
                                <form method="post" action="{routePath('cart-order')}">
                                    <input type="hidden" name="pid" value="{$plan->id}">
                                    <select name="billingcycle" class="form-control">
                                        {foreach $plan->pricing()->allAvailableCycles() as $cycle}
                                            <option value="{$cycle->cycle()}">
                                                {if $cycle->isRecurring()}
                                                    {if $cycle->isYearly()}
                                                        {$cycle->cycleInYears()}
                                                    {else}
                                                        {$cycle->cycleInMonths()}
                                                    {/if}
                                                    -
                                                {/if}
                                                {$cycle->toFullString()}</option>
                                        {/foreach}
                                    </select>
                                    <button type="submit" class="btn primary-solid-btn btn-block">Purchase now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>

        </div>
    </div>

    <div class="content-block features" id="features">
        <div class="container">

           <div class="row">
               <div class="text-center">
                    <h2>{lang key="store.sitelock.featuresTitle"}</h2>
                    <p class="lead">{lang key="store.sitelock.featuresHeadline"}</p>
               </div>
           </div>
            <div class="row row-eq-height">
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-search fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresMalwareTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresMalwareContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-wrench fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresMalwareRemovalTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresMalwareRemovalContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-code fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresVulnerabilityTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresVulnerabilityContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-file-code fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresOWASPTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresOWASPContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-trophy fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresTrustSealTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresTrustSealContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-shield-alt fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresFirewallTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresFirewallContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-lock fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresReputationTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresReputationContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-star fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresSetupTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresSetupContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box border p-4 rounded">
                        <i class="fal fa-globe fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.featuresCDNTitle"}</h5>
                            <p>{lang key="store.sitelock.featuresCDNContent"}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {if !is_null($emergencyPlan)}
    <div class="content-block emergency" id="emergency">
        <div class="container">

            <div class="row">
                <div class="section-title text-center">
                    <h2 class="text-danger">{lang key="store.sitelock.emergencyPlanTitle"}</h2>
                    <p class="lead text-white">{lang key="store.sitelock.emergencyPlanHeadline"}</p>
                    <p class="text-white">{lang key="store.sitelock.emergencyPlanBody"}</p>
                </div>
            </div>

            <div class="row row-eq-height">
                <div class="col-md-6 col-lg-4">
                    <div class="features-box mt-4 text-center border rounded p-4 gray-light-bg">
                        <i class="fal fa-clock fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.emergencyPlanResponseTitle"}</h5>
                            <p>{lang key="store.sitelock.emergencyPlanResponseContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box mt-4 text-center border rounded p-4 gray-light-bg">
                        <i class="fal fa-times fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.emergencyPlanMalwareTitle"}</h5>
                            <p>{lang key="store.sitelock.emergencyPlanMalwareContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box mt-4 text-center border rounded p-4 gray-light-bg">
                        <i class="fal fa-exclamation-circle fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.emergencyPlanPriorityTitle"}</h5>
                            <p>{lang key="store.sitelock.emergencyPlanPriorityContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box mt-4 text-center border rounded p-4 gray-light-bg">
                        <i class="fal fa-calendar-check fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.emergencyPlanAftercareTitle"}</h5>
                            <p>{lang key="store.sitelock.emergencyPlanAftercareContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box mt-4 text-center border rounded p-4 gray-light-bg">
                        <i class="fal fa-envelope fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.emergencyPlanUpdatesTitle"}</h5>
                            <p>{lang key="store.sitelock.emergencyPlanUpdatesContent"}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="features-box mt-4 text-center border rounded p-4 gray-light-bg">
                        <i class="fal fa-star fa-fw"></i>
                        <div class="content">
                            <h5>{lang key="store.sitelock.emergencyPlanPaymentTitle"}</h5>
                            <p>{lang key="store.sitelock.emergencyPlanPaymentContent"}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix mt-20 text-center">
                <div class="price text-white">
                    {lang key="store.sitelock.emergencyPlanOnlyCost" price="{if $emergencyPlan->pricing()->best()}{$emergencyPlan->pricing()->best()->toFullString()}{else}-{/if}" }
                </div>
                <br>
                <form method="post" action="{routePath('cart-order')}">
                    <input type="hidden" name="pid" value="{$emergencyPlan->id}">
                    <button type="submit" class="btn outline-primary-btn">
                        {lang key="store.sitelock.buyNow"}
                    </button>
                </form>
            </div>

        </div>
    </div>
    {/if}

    <div class="content-block faq gray-light-bg" id="faq">
        <div class="container">
             <div class="row">
                <h2 class="text-center section-title">{lang key="store.sitelock.faqTitle"}</h2>
            </div>
            <div class="row d-flex justify-center">
                <div class="col-md-10">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.sitelock.faqOneTitle"}</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.sitelock.faqOneBody"}</p>
                                <br>
                                    <p>{lang key="store.sitelock.faqOneBodyLearnMore" learnMoreLink={$learnMoreLink}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.sitelock.faqTwoTitle"}</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.sitelock.faqTwoBody"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.sitelock.faqThreeTitle"}</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.sitelock.faqThreeBody"}</p>
                                    <br>
                                    <ul>
                                        <li><Strong>{lang key="store.sitelock.faqThreeBodyList1Title"} :</Strong> {lang key="store.sitelock.faqThreeBodyList1"}</li>
                                        <li><strong>{lang key="store.sitelock.faqThreeBodyList2Title"} :</strong> {lang key="store.sitelock.faqThreeBodyList2"}</li>
                                        <li><strong>{lang key="store.sitelock.faqThreeBodyList3Title"} :</strong> {lang key="store.sitelock.faqThreeBodyList3"}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.sitelock.faqFourTitle"}</h6>
                            </a>
                            <div id="collapse3" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                   <p>{lang key="store.sitelock.faqFourBodyParagraph1" vulnerabilityStrong="<strong>{lang key="store.sitelock.websiteVulnerability"}</strong>"}
                                    <br><br>
                                       {lang key="store.sitelock.faqFourBodyParagraph2" malwareStrong="<strong>{lang key="store.sitelock.malware"}</strong>"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.sitelock.faqFiveTitle"}</h6>
                            </a>
                            <div id="collapse4" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.sitelock.faqFiveBody"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.sitelock.faqSixTitle"}</h6>
                            </a>
                            <div id="collapse5" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.sitelock.faqSixBody"}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
