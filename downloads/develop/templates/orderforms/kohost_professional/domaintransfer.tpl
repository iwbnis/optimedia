{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">
                    {lang key='orderForm.transferToUs'}
                </h2>
                <p>{lang key='orderForm.transferExtend'}*</p>
            </div>
            {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

            <form method="post" action="{$WEB_ROOT}/cart.php" id="frmDomainTransfer">
                <input type="hidden" name="a" value="addDomainTransfer">
                <div class="domain-checker-container domain-transfer-wrap">
                    <h5>{lang key='orderForm.singleTransfer'}</h5>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="inputTransferDomain">{lang key='domainname'}</label>
                                <input type="text" class="form-control" name="domain" id="inputTransferDomain" value="{$lookupTerm}" placeholder="{lang key='yourdomainplaceholder'}.{lang key='yourtldplaceholder'}" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="{lang key='orderForm.enterDomain'}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputAuthCode" style="width:100%;">
                                    {lang key='orderForm.authCode'}
                                    <a href="" data-toggle="tooltip" data-placement="top" title="{lang key='orderForm.authCodeTooltip'}"><i class="fas fa-question-circle"></i></a>
                                </label>
                                <input type="text" class="form-control" name="epp" id="inputAuthCode" placeholder="{lang key='orderForm.authCodePlaceholder'}" data-toggle="tooltip" data-placement="left" data-trigger="manual" title="{lang key='orderForm.required'}" />
                            </div>
                        </div>
                        <div id="transferUnavailable" class="alert alert-warning slim-alert text-center w-hidden"></div>
                        {if $captcha->isEnabled() && !$captcha->recaptcha->isEnabled()}
                            <div class="captcha-container" id="captchaContainer">
                                <div class="default-captcha">
                                    <p>{lang key="cartSimpleCaptcha"}</p>
                                    <div>
                                        <img id="inputCaptchaImage" src="{$systemurl}includes/verifyimage.php" />
                                        <input id="inputCaptcha" type="text" name="code" maxlength="6" class="form-control input-sm" data-toggle="tooltip" data-placement="right" data-trigger="manual" title="{lang key='orderForm.required'}" />
                                    </div>
                                </div>
                            </div>
                        {elseif $captcha->isEnabled() && $captcha->recaptcha->isEnabled() && !$captcha->recaptcha->isInvisible()}
                            <div class="text-center">
                                <div class="form-group recaptcha-container" id="captchaContainer"></div>
                            </div>
                        {/if}
                        <div class="col-md-3">
                            <button type="submit" id="btnTransferDomain" class="btn transfer-btn btn-transfer{$captcha->getButtonClass($captchaForm)}">
                                <span class="loader w-hidden" id="addTransferLoader">
                                    <i class="fas fa-fw fa-spinner fa-spin"></i>
                                </span>
                                <span id="addToCart">{lang key="orderForm.addToCart"}</span>
                            </button>
                        </div>
                    </div>

                    <p class="small mb-0 renew-alert">* {lang key='orderForm.extendExclusions'}</p>
                </div>
            </form>
        </div>
    </div>
</div>
