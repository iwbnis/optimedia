<link href="{assetPath file='store.css'}" rel="stylesheet">

<div class="landing-page mail-services">
    <div class="content-block" id="overview">
        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h2>{lang key="store.emailServices.headline"}</h2>
                    <p class="lead">{lang key="store.emailServices.tagline"} {lang key="store.emailServices.blockSpamHeadline"}</p>
                </div>
            </div>
            {if $numberOfFeaturedProducts > 0}
                <div class="row row-eq-height">
                    {if $products.incoming}
                        <div class="{if $numberOfFeaturedProducts == 1}col-sm-6 col-sm-offset-3{elseif $numberOfFeaturedProducts == 2}col-sm-6{else}col-sm-6 col-md-4{/if}">
                            <div class="single-pricing-pack-2 rounded border text-center">
                                 <div class="pricing-icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                               <h4 class="package-title">{lang key="store.emailServices.incoming.title"}</h4>
                               <p>{lang key="store.emailServices.overview.incoming.tagline"}</p>
                               <div class="pricing-price pt-4">
                                    <p>{lang key="store.emailServices.overview.incoming.headline"}</p>
                                    <small>Starting from</small>
                                    {if $products.incoming->pricing()->best()}
                                        <div class="price h2 mb-0">{$products.incoming->pricing()->best()->toFullString()}</div>
                                    {elseif $inPreview}
                                        <div class="price">-</div>
                                    {/if}
                                    <small>Per {lang key="store.emailServices.domain"}</small>
                               </div>
                               <br>
                                <a href="#" class="btn outline-btn" data-target="incoming">
                                    {lang key="store.emailServices.overview.learn"}
                                </a>
                                <a href="#" class="btn btn-buy primary-solid-btn" data-target="incoming">
                                    {lang key="store.emailServices.overview.buy"}
                                </a>
                            </div>
                        </div>
                    {/if}
                    {if $products.outgoing}
                        <div class="{if $numberOfFeaturedProducts == 1}col-sm-6 col-sm-offset-3{elseif $numberOfFeaturedProducts == 2}col-sm-6{else}col-sm-6 col-md-4{/if}">
                            <div class="single-pricing-pack-2 rounded border text-center">
                                <div class="pricing-icon">
                                    <i class="fal fa-envelope-open"></i>
                                </div>
                               <h4 class="package-title">{lang key="store.emailServices.outgoing.title"}</h4>
                                <p>{lang key="store.emailServices.overview.outgoing.tagline"}</p>
                                <div class="pricing-price pt-4">
                                    <p>{lang key="store.emailServices.overview.outgoing.headline"}</p>
                                    <small>Starting from</small>
                                    {if $products.outgoing->pricing()->best()}
                                        <div class="price h2 mb-0">{$products.outgoing->pricing()->best()->toFullString()}</div>
                                    {elseif $inPreview}
                                        <div class="price">-</div>
                                    {/if}
                                    <small>Per {lang key="store.emailServices.domain"}</small>
                               </div>
                               <br>
                               <a href="#" class="btn outline-btn" data-target="outgoing">
                                    {lang key="store.emailServices.overview.learn"}
                                </a>
                                <a href="#" class="btn btn-buy primary-solid-btn" data-target="outgoing">
                                    {lang key="store.emailServices.overview.buy"}
                                </a>
                            </div>
                        </div>
                    {/if}
                    {if $products.incomingarchiving || $products.outgoingarchiving || $products.incomingoutgoingarchiving}
                        <div class="{if $numberOfFeaturedProducts == 1}col-sm-6 col-sm-offset-3{elseif $numberOfFeaturedProducts == 2}col-sm-6{else}col-sm-6 col-md-4{/if}">
                            <div class="single-pricing-pack-2 rounded border text-center">
                                <div class="pricing-icon">
                                    <i class="fal fa-cube"></i>
                                </div>
                                <h4 class="package-title">{lang key="store.emailServices.archiving.title"}</h4>
                                <p>{lang key="store.emailServices.overview.archiving.tagline"}</p>
                                <div class="pricing-price pt-4">
                                    <p>{lang key="store.emailServices.overview.archiving.headline"}</p>
                                    <small>Starting from</small>
                                    {if $products.incomingarchiving && $products.incomingarchiving->pricing()->best()}
                                        <div class="price h2 mb-0">{$products.incomingarchiving->pricing()->best()->toFullString()}</div>
                                    {elseif $products.outgoingarchiving && $products.outgoingarchiving->pricing()->best()}
                                        <div class="price h2 mb-0">{$products.outgoingarchiving->pricing()->best()->toFullString()}</div>
                                    {elseif $products.incomingoutgoingarchiving->pricing()->best()}
                                        <div class="price h2 mb-0">{$products.incomingoutgoingarchiving->pricing()->best()->toFullString()}</div>
                                    {elseif $inPreview}
                                        <div class="price">-</div>
                                    {/if}
                                    <small>Per {lang key="store.emailServices.domain"}</small>
                               </div>
                               <br>
                                <a href="#" class="btn outline-btn" data-target="archiving">
                                    {lang key="store.emailServices.overview.learn"}
                                </a>
                                <a href="#" class="btn btn-buy primary-solid-btn" data-target="incomingoutgoingarchiving">
                                    {lang key="store.emailServices.overview.buy"}
                                </a>
                            </div>
                        </div>
                    {/if}
                </div>
            {elseif $inPreview}
                <div class="text-center lead preview-text">Email service products you activate will be displayed here</div>
            {/if}
        </div>
    </div>
    <div class="content-block tabs light-grey-bg" id="howitworks">
        <div class="container">
                <ul class="nav nav-tabs email-services-tab" role="tablist">
                    {if $products.incoming || $inPreview}
                        <li role="presentation" class="active">
                            <a href="#incoming" aria-controls="incoming" role="tab" data-toggle="tab">{lang key="store.emailServices.incoming.title"}</a>
                        </li>
                    {/if}
                    {if $products.outgoing || $inPreview}
                        <li role="presentation">
                            <a href="#outgoing" aria-controls="outgoing" role="tab" data-toggle="tab">{lang key="store.emailServices.outgoing.title"}</a>
                        </li>
                    {/if}
                    {if $products.incomingarchiving || $products.outgoingarchiving || $products.incomingoutgoingarchiving || $inPreview}
                        <li role="presentation">
                            <a href="#archiving" aria-controls="archiving" role="tab" data-toggle="tab">{lang key="store.emailServices.archiving.title"}</a>
                        </li>
                    {/if}
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="incoming">

                        <div class="benefits">
                            <h3>{lang key="store.emailServices.benefits.incoming.title"}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.1"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.2"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.3"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.4"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.5"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.6"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.7"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.incoming.8"}
                                </div>
                            </div>
                        </div>

                        <h5{lang key="store.emailServices.benefits.incoming.q1"}</h5>
                        <p>{lang key="store.emailServices.benefits.incoming.a1"}</p>

                        <h5>{lang key="store.emailServices.benefits.incoming.q2"}</h5>
                        <p>{lang key="store.emailServices.benefits.incoming.a2"}</p>

                        <h5>{lang key="store.emailServices.benefits.incoming.q3"}</h5>
                        <p>{lang key="store.emailServices.benefits.incoming.a3"}</p>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="outgoing">

                        <div class="benefits">
                            <h3>{lang key="store.emailServices.benefits.outgoing.title"}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.outgoing.1"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.outgoing.2"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fas fa-check"></i>
                                    {lang key="store.emailServices.benefits.outgoing.3"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.outgoing.4"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.outgoing.5"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.outgoing.6"}
                                </div>
                            </div>
                        </div>

                        <h5>{lang key="store.emailServices.benefits.outgoing.q1"}</h5>
                        <p>{lang key="store.emailServices.benefits.outgoing.a1"}</p>

                        <h5>{lang key="store.emailServices.benefits.outgoing.q2"}</h5>
                        <p>{lang key="store.emailServices.benefits.outgoing.a2"}</p>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="archiving">

                        <div class="benefits">
                            <h3>{lang key="store.emailServices.benefits.archiving.title"}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.1"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.2"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.3"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.4"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.5"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.6"}
                                </div>
                                <div class="col-md-6">
                                    <i class="fal fa-check"></i>
                                    {lang key="store.emailServices.benefits.archiving.7"}
                                </div>
                            </div>
                        </div>

                        <h5>{lang key="store.emailServices.benefits.archiving.q1"}</h5>
                        <p>{lang key="store.emailServices.benefits.archiving.a1"}</p>

                        <h5>{lang key="store.emailServices.benefits.archiving.q2"}</h5>
                        <p>{lang key="store.emailServices.benefits.archiving.a2a"}</p>
                        <p>{lang key="store.emailServices.benefits.archiving.a2b"}</p>

                    </div>
                </div>
        </div>
    </div>

    <div class="content-block get-started" id="pricing">
        <div class="container">
            <form method="post" action="{routePath('cart-order')}">
                <input type="hidden" name="productkey" value="{$products.incoming->productKey}" id="productKey">
                <div class="row d-flex justify-center">
                    <div class="col-md-12">
                        <h2 class="text-center section-title text-white">{lang key="store.emailServices.signup.title"}</h2>
                    </div>
                    <div class="col-sm-10">
                        <div class="pricing-wrap">
                            <div class="pricing-content">
                                <h5>{lang key="store.emailServices.signup.choose"}</h5>
                                {if $numberOfFeaturedProducts > 0}
                                    <div class="btn-group choose-product" role="group">
                                        {if $products.incoming}
                                            <button type="button" class="btn outline-btn active" data-product="incoming">{lang key="store.emailServices.options.incomingFilter"}</button>
                                        {/if}
                                        {if $products.outgoing}
                                            <button type="button" class="btn outline-btn" data-product="outgoing">{lang key="store.emailServices.options.outgoingFilter"}</button>
                                        {/if}
                                    </div>
                                {elseif $inPreview}
                                    {lang key="store.emailServices.preview"}
                                {/if}
                                <br><br>
                                <h5>{lang key="store.emailServices.signup.additional"}</h5>
                                <div class="additional-options">
                                    {foreach $productOptions as $productKey => $options}
                                        <div class="option options-{$productKey}">
                                            {foreach $options as $option}
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="options" value="{$option.product}">
                                                    {lang key="store.emailServices.options.addFor" description=$option.description pricing=$option.pricing->toFullString()}
                                                </label><br>
                                            {foreachelse}
                                                {lang key="store.emailServices.signup.none"}
                                            {/foreach}
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                            <div class="pricing-btn">
                                {if $products.incoming && $products.incoming->pricing()->best()}
                                    <span class="price price-incoming">{$products.incoming->pricing()->best()->toFullString()}</span>
                                {/if}
                                {if $products.incomingarchiving && $products.incomingarchiving->pricing()->best()}
                                    <span class="price price-incomingarchiving">{$products.incomingarchiving->pricing()->best()->toFullString()}</span>
                                {/if}
                                {if $products.outgoing && $products.outgoing->pricing()->best()}
                                    <span class="price price-outgoing">{$products.outgoing->pricing()->best()->toFullString()}</span>
                                {/if}
                                {if $products.outgoingarchiving && $products.outgoingarchiving->pricing()->best()}
                                    <span class="price price-outgoingarchiving">{$products.outgoingarchiving->pricing()->best()->toFullString()}</span>
                                {/if}
                                {if $products.incomingoutgoing && $products.incomingoutgoing->pricing()->best()}
                                    <span class="price price-incomingoutgoing">{$products.incomingoutgoing->pricing()->best()->toFullString()}</span>
                                {/if}
                                {if $products.incomingoutgoingarchiving && $products.incomingoutgoingarchiving->pricing()->best()}
                                    <span class="price price-incomingoutgoingarchiving">{$products.incomingoutgoingarchiving->pricing()->best()->toFullString()}</span>
                                {/if}
                                <button type="submit" class="btn btn-order-now primary-solid-btn">
                                    {lang key="store.emailServices.signup.order"}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {if !$loggedin && $currencies}
                <br>
                <form method="post" action="">
                    <select name="currency" class="form-control ssl-currency-selector" onchange="submit()" style="width:250px;">
                        <option>{lang key="changeCurrency"} ({$activeCurrency.prefix} {$activeCurrency.code})</option>
                        {foreach $currencies as $currency}
                            <option value="{$currency['id']}">{$currency['prefix']} {$currency['code']}</option>
                        {/foreach}
                    </select>
                </form>
            {/if}

        </div>
    </div>

    <div class="content-block faq" id="faq">
        <div class="container">
            <h2 class="text-center">{lang key="store.emailServices.faqs.title"}</h2>
            <div class="row d-flex justify-center">
                <div class="col-md-10">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.emailServices.faqs.q1"}</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.emailServices.faqs.a1"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.emailServices.faqs.q2"}</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.emailServices.faqs.a2"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.emailServices.faqs.q3"}</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.emailServices.faqs.a3"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.emailServices.faqs.q4"}</h6>
                            </a>
                            <div id="collapse3" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.emailServices.faqs.a4"}</p>
                                </div>
                            </div>
                        </div>
                         <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.emailServices.faqs.q5"}</h6>
                            </a>
                            <div id="collapse4" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.emailServices.faqs.a5"}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">{lang key="store.emailServices.faqs.q6"}</h6>
                            </a>
                            <div id="collapse5" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>{lang key="store.emailServices.faqs.a6"}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#inputDomainChooser').multiselect({
            buttonWidth: '250px',
            dropRight: true,
            nonSelectedText: 'Choose domain(s)'
        });
        $('.landing-page.mail-services .get-started .choose-product button').click(function(e) {
            var product = $(this).data('product');
            $('.landing-page.mail-services .get-started .choose-product button').removeClass('active');
            $(this).addClass('active');
            $('.landing-page.mail-services .get-started .additional-options .option').hide();
            $('.landing-page.mail-services .get-started .additional-options .options-' + product).show();
            $('.landing-page.mail-services .get-started .price').hide();
            $('.landing-page.mail-services .get-started .price-' + product).show();
            $('#productKey').val('spamexperts_' + product);
        });
        $('.landing-page.mail-services .get-started .additional-options input[type="checkbox"]').click(function(e) {
            if ($(this).is(":checked")) {
                $('.landing-page.mail-services .get-started .additional-options input[type="checkbox"]').not($(this)).prop('checked', false);
                $('.landing-page.mail-services .get-started .price').hide();
                $('.landing-page.mail-services .get-started .price-' + $(this).val()).show();
                $('#productKey').val('spamexperts_' + $(this).val());
            } else {
                var product = $('.landing-page.mail-services .get-started .choose-product button.active').data('product');
                $('.landing-page.mail-services .get-started .price').hide();
                $('.landing-page.mail-services .get-started .price-' + product).show();
                $('#productKey').val('spamexperts_' + product);
            }
        });
        $('.btn-learn-more').click(function(e) {
            e.preventDefault();
            $('#howitworks a[href="#' + $(this).data('target') + '"]').tab('show');
            smoothScroll('#howitworks');
        });
        $('.btn-buy').click(function(e) {
            e.preventDefault();
            var target = $(this).data('target'),
                pricing = $('#pricing');
            if (target === 'incomingoutgoingarchiving') {
                if (pricing.find('button[data-product="incoming"]').length) {
                    pricing.find('button[data-product="incoming"]').click();
                } else {
                    pricing.find('button[data-product="outgoing"]').click();
                }
                var option = $('input[name="options"][value="incomingoutgoingarchiving"]').first();
                if (option.is(':checked')) {
                    option.click();
                }
                option.click();
            } else {
                pricing.find('button[data-product="' + $(this).data('target') + '"]').click();
            }
            smoothScroll('#pricing');
        });
    });
</script>
