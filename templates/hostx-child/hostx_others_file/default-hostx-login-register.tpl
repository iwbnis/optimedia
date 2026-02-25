<style>
.om-login-wrapper {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #0a0e27 0%, #1a1f4e 40%, #0d1333 100%);
    position: relative;
    overflow: hidden;
}
.om-login-wrapper::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -30%;
    width: 80%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(108,92,231,0.12) 0%, transparent 70%);
    pointer-events: none;
}
.om-login-wrapper::after {
    content: '';
    position: absolute;
    bottom: -40%;
    right: -20%;
    width: 60%;
    height: 150%;
    background: radial-gradient(ellipse, rgba(0,206,201,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.om-login-container {
    display: flex;
    max-width: 960px;
    width: 100%;
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 25px 60px rgba(0,0,0,0.4);
    overflow: hidden;
    position: relative;
    z-index: 1;
}

/* Left branding panel */
.om-login-brand {
    width: 420px;
    flex-shrink: 0;
    background: linear-gradient(160deg, #083C72 0%, #0a2d5c 50%, #061e3f 100%);
    padding: 48px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.om-login-brand::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -40%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(108,92,231,0.15) 0%, transparent 60%);
}
.om-login-brand::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: -20%;
    width: 80%;
    height: 80%;
    background: radial-gradient(circle, rgba(0,206,201,0.1) 0%, transparent 60%);
}
.om-brand-content {
    position: relative;
    z-index: 1;
}
.om-brand-logo img {
    height: 42px;
    margin-bottom: 32px;
    filter: brightness(10);
}
.om-brand-title {
    font-family: 'DM Sans', sans-serif;
    font-size: 28px;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 16px;
}
.om-brand-title span {
    background: linear-gradient(135deg, #6c5ce7, #00cec9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.om-brand-desc {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: rgba(205,224,245,0.7);
    line-height: 1.6;
    margin-bottom: 32px;
}
.om-brand-features {
    list-style: none;
    padding: 0;
    margin: 0;
}
.om-brand-features li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: rgba(255,255,255,0.85);
}
.om-brand-features li svg {
    flex-shrink: 0;
    color: #00cec9;
}

/* Right form panel */
.om-login-form-panel {
    flex: 1;
    padding: 48px 44px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #fff;
}
.om-form-tabs {
    display: flex;
    gap: 0;
    margin-bottom: 28px;
    border-bottom: 2px solid #f0f0f5;
}
.om-form-tab {
    padding: 10px 24px 12px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #999;
    text-decoration: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s ease;
}
.om-form-tab:hover {
    color: #555;
    text-decoration: none;
}
.om-form-tab.active {
    color: #083C72;
    border-bottom-color: #6c5ce7;
}
.om-form-heading {
    font-family: 'DM Sans', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 6px;
}
.om-form-subheading {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #888;
    margin-bottom: 24px;
}
.om-form-group {
    margin-bottom: 18px;
}
.om-form-group label {
    display: block;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #444;
    margin-bottom: 6px;
}
.om-form-group .form-control {
    padding: 12px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    transition: all 0.2s ease;
    background: #fafbfc;
}
.om-form-group .form-control:focus {
    border-color: #6c5ce7;
    box-shadow: 0 0 0 3px rgba(108,92,231,0.1);
    background: #fff;
    outline: none;
}
.om-form-group .input-group {
    position: relative;
}
.om-form-group .input-group .btn-reveal-pw {
    position: absolute;
    right: 4px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    padding: 8px;
    z-index: 5;
    cursor: pointer;
}
.om-form-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.om-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #666;
    cursor: pointer;
}
.om-remember input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #6c5ce7;
}
.om-forgot {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #6c5ce7;
    text-decoration: none;
    font-weight: 500;
}
.om-forgot:hover {
    color: #5a4bd1;
    text-decoration: underline;
}
.om-login-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #6c5ce7, #00cec9);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 4px 15px rgba(108,92,231,0.3);
    letter-spacing: 0.3px;
}
.om-login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(108,92,231,0.4);
}
.om-login-btn:active {
    transform: translateY(0);
}
.om-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    margin: 22px 0;
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    color: #bbb;
}
.om-divider::before, .om-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #eee;
}
.om-social-btns {
    display: flex;
    gap: 12px;
}
.om-social-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 16px;
    background: #f8f9fa;
    border: 1.5px solid #e8ecf0;
    border-radius: 12px;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #444;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}
.om-social-btn:hover {
    background: #f0f2f5;
    border-color: #d0d5dd;
    color: #333;
    text-decoration: none;
}
.om-signup-link {
    text-align: center;
    margin-top: 22px;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #888;
}
.om-signup-link a {
    color: #6c5ce7;
    font-weight: 600;
    text-decoration: none;
}
.om-signup-link a:hover {
    text-decoration: underline;
}

/* Register form overrides */
.om-register-form .card {
    border: none;
    box-shadow: none;
    margin-bottom: 0 !important;
}
.om-register-form .card-body {
    padding: 0 !important;
}
.om-register-form .card-title {
    font-family: 'DM Sans', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f5;
}
.om-register-form .form-group label {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #444;
}
.om-register-form .form-control,
.om-register-form .field {
    padding: 11px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    background: #fafbfc;
}
.om-register-form .form-control:focus,
.om-register-form .field:focus {
    border-color: #6c5ce7;
    box-shadow: 0 0 0 3px rgba(108,92,231,0.1);
    background: #fff;
}
.om-register-form .btn-primary {
    background: linear-gradient(135deg, #6c5ce7, #00cec9) !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 14px 40px !important;
    font-family: 'Inter', sans-serif !important;
    font-weight: 700 !important;
    font-size: 15px !important;
    box-shadow: 0 4px 15px rgba(108,92,231,0.3) !important;
}
.om-register-form .svg-img-ar-login-register { display: none; }
.om-register-form .generate-password { border-radius: 8px; margin-top: 24px; }

/* Login page captcha */
.om-login-captcha { margin-bottom: 16px; }

/* Responsive */
@media (max-width: 768px) {
    .om-login-wrapper {
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(160deg, #083C72 0%, #0a2d5c 50%, #061e3f 100%);
        align-items: stretch;
    }
    .om-login-container {
        flex-direction: column;
        max-width: 100%;
        border-radius: 0;
        border: none;
        box-shadow: none;
        background: none;
        backdrop-filter: none;
        min-height: 100vh;
    }
    .om-login-brand { display: none; }
    .om-login-form-panel {
        flex: 1;
        padding: 32px 24px;
        border-radius: 24px 24px 0 0;
        margin-top: 20px;
    }
    .om-form-heading { font-size: 22px; }
    .om-form-subheading { font-size: 13px; }
}
@media (max-width: 480px) {
    .om-login-form-panel { padding: 28px 18px; }
    .om-social-btns { flex-direction: column; }
    .om-login-btn { font-size: 14px; padding: 13px 20px; }
}
</style>

<div class="om-login-wrapper">
    <div class="om-login-container">
        <!-- Left Branding Panel -->
        <div class="om-login-brand">
            <div class="om-brand-content">
                <div class="om-brand-logo">
                    {if !empty($hostx_theme_settings.lg_pw_logo)}
                        <img src="{$hostx_theme_settings.lg_pw_logo}" alt="{$companyname}">
                    {else}
                        <img src="{$WEB_ROOT}/templates/{$template}/imagenew/whitelogo.png" alt="{$companyname}">
                    {/if}
                </div>
                <h2 class="om-brand-title">Stream <span>14,000+</span> HD Channels Worldwide</h2>
                <p class="om-brand-desc">Premium IPTV service with crystal-clear quality. Access live TV, sports, movies, and more on any device.</p>
                <ul class="om-brand-features">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        14,000+ HD & 4K Channels
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Watch on Any Device, Anywhere
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Zero Buffering Guarantee
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        24/7 Customer Support
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="om-login-form-panel">
            <div class="om-form-tabs">
                <a href="{$WEB_ROOT}/login.php" class="om-form-tab {if $templatefile == 'login'}active{/if}">{$LANG.loginbutton}</a>
                <a href="{$WEB_ROOT}/order.php" class="om-form-tab {if $templatefile == 'clientregister'}active{/if}">{$LANG.register}</a>
            </div>

            {if $templatefile == 'login'}
                <h3 class="om-form-heading">Welcome Back</h3>
                <p class="om-form-subheading">Sign in to manage your IPTV subscription</p>

                <form method="post" action="{routePath('login-validate')}" class="login-form-hostx-default" role="form">
                    {include file="$template/includes/flashmessage.tpl"}

                    <div class="om-form-group">
                        <label for="inputEmail">{lang key='clientareaemail'}</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="username" id="inputEmail" placeholder="name@example.com" autocomplete="off" autofocus>
                        </div>
                    </div>

                    <div class="om-form-group">
                        <label for="inputPassword">{lang key='clientareapassword'}</label>
                        <div class="input-group">
                            <input type="password" class="form-control pw-input" name="password" id="inputPassword" placeholder="Enter your password" autocomplete="off">
                            <button class="btn btn-default btn-reveal-pw" type="button" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="om-form-row">
                        <label class="om-remember">
                            <input type="checkbox" name="rememberme" />
                            {lang key='loginrememberme'}
                        </label>
                        <a href="{routePath('password-reset-begin')}" class="om-forgot">{lang key='forgotpw'}</a>
                    </div>

                    {if $captcha->isEnabled()}
                        <div class="om-login-captcha">
                            {include file="$template/includes/captcha.tpl"}
                        </div>
                    {/if}

                    <button id="login" type="submit" class="om-login-btn{$captcha->getButtonClass($captchaForm)}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        {lang key='loginbutton'}
                    </button>
                </form>


                <p class="om-signup-link">
                    Don't have an account? <a href="{$WEB_ROOT}/order.php">{$LANG.register}</a>
                </p>

            {elseif $templatefile == 'clientregister'}
                <h3 class="om-form-heading">Create Account</h3>
                <p class="om-form-subheading">Join thousands of happy IPTV subscribers</p>

                {if $registrationDisabled}
                    {include file="$template/includes/alert.tpl" type="error" msg="{lang key='registerCreateAccount'}"|cat:' <strong><a href="'|cat:"$WEB_ROOT"|cat:'/cart.php" class="alert-link">'|cat:"{lang key='registerCreateAccountOrder'}"|cat:'</a></strong>'}
                {/if}
                {if $errormessage}
                    {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
                {/if}
                {if !$registrationDisabled}
                    <div id="registration" class="om-register-form">
                        <form method="post" class="using-password-strength" action="{$smarty.server.PHP_SELF}" role="form" name="orderfrm" id="frmCheckout">
                            <input type="hidden" name="register" value="true"/>
                            <div id="containerNewUserSignup">
                                <div class="card mb-4">
                                    <div class="card-body p-4" id="personalInformation">
                                        <h3 class="card-title">{lang key='orderForm.personalInformation'}</h3>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputFirstName">{lang key='orderForm.firstName'}</label>
                                                    <input type="text" name="firstname" id="inputFirstName" class="field form-control" value="{$clientfirstname}" {if !in_array('firstname', $optionalFields)}required{/if} autofocus>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputLastName">{lang key='orderForm.lastName'}</label>
                                                    <input type="text" name="lastname" id="inputLastName" class="field form-control" value="{$clientlastname}" {if !in_array('lastname', $optionalFields)}required{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputEmail">{lang key='orderForm.emailAddress'}</label>
                                                    <input type="email" name="email" id="inputEmail" class="field form-control" value="{$clientemail}" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputPhone">{lang key='orderForm.phoneNumber'}</label>
                                                    <input type="tel" name="phonenumber" id="inputPhone" class="field form-control" value="{$clientphonenumber}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-body p-4">
                                        <h3 class="card-title">{lang key='orderForm.billingAddress'}</h3>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputCompanyName">{lang key='orderForm.companyName'} ({lang key='orderForm.optional'})</label>
                                                    <input type="text" name="companyname" id="inputCompanyName" class="field form-control" value="{$clientcompanyname}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputAddress1">{lang key='orderForm.streetAddress'}</label>
                                                    <input type="text" name="address1" id="inputAddress1" class="field form-control" value="{$clientaddress1}" {if !in_array('address1', $optionalFields)}required{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputAddress2">{lang key='orderForm.streetAddress2'}</label>
                                                    <input type="text" name="address2" id="inputAddress2" class="field form-control" value="{$clientaddress2}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputCity">{lang key='orderForm.city'}</label>
                                                    <input type="text" name="city" id="inputCity" class="field form-control" value="{$clientcity}" {if !in_array('city', $optionalFields)}required{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="stateinput">{lang key='orderForm.state'}</label>
                                                    <input type="text" name="state" id="state" class="field form-control" value="{$clientstate}" {if !in_array('state', $optionalFields)}required{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputPostcode">{lang key='orderForm.postcode'}</label>
                                                    <input type="text" name="postcode" id="inputPostcode" class="field form-control" value="{$clientpostcode}" {if !in_array('postcode', $optionalFields)}required{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputCountry">{$LANG.clientareacountry}</label>
                                                    <select name="country" id="inputCountry" class="field form-control" autocomplete="off">
                                                        {foreach $clientcountries as $countryCode => $countryName}
                                                            <option value="{$countryCode}"{if (!$clientcountry && $countryCode eq $defaultCountry) || ($countryCode eq $clientcountry)} selected="selected"{/if}>
                                                                {$countryName}
                                                            </option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            {if $showTaxIdField}
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="inputTaxId">{$taxLabel} ({lang key='orderForm.optional'})</label>
                                                        <input type="text" name="tax_id" id="inputTaxId" class="field form-control" value="{$clientTaxId}">
                                                    </div>
                                                </div>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                                {if $customfields || $currencies}
                                    <div class="card mb-4">
                                        <div class="card-body p-4">
                                            <h3 class="card-title">{lang key='orderadditionalrequiredinfo'}</h3>
                                            <div class="row">
                                                {if $customfields}
                                                    {foreach $customfields as $customfield}
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label for="customfield{$customfield.id}">{$customfield.name} {$customfield.required}</label>
                                                                <div class="control">
                                                                    {$customfield.input}
                                                                    {if $customfield.description}
                                                                        <span class="field-help-text">{$customfield.description}</span>
                                                                    {/if}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {/foreach}
                                                {/if}
                                                {if $currencies}
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="inputCurrency">{$LANG.choosecurrency}</label>
                                                            <select id="inputCurrency" name="currency" class="field form-control">
                                                                {foreach $currencies as $curr}
                                                                    <option value="{$curr.id}"{if !$smarty.post.currency && $curr.default || $smarty.post.currency eq $curr.id} selected{/if}>{$curr.code}</option>
                                                                {/foreach}
                                                            </select>
                                                        </div>
                                                    </div>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            </div>
                            <div id="containerNewUserSecurity" {if $remote_auth_prelinked && !$securityquestions} class="w-hidden"{/if}>
                                <div class="card mb-4">
                                    <div class="card-body p-4">
                                        <h3 class="card-title">{lang key='orderForm.accountSecurity'}</h3>
                                        <div id="containerPassword" class="row{if $remote_auth_prelinked && $securityquestions} hidden{/if}">
                                            <div id="passwdFeedback" class="alert alert-info text-center col-sm-12 w-hidden"></div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputNewPassword1">{lang key='clientareapassword'}</label>
                                                    <input type="password" name="password" id="inputNewPassword1" data-error-threshold="{$pwStrengthErrorThreshold}" data-warning-threshold="{$pwStrengthWarningThreshold}" class="field form-control" autocomplete="off"{if $remote_auth_prelinked} value="{$password}"{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputNewPassword2">{lang key='clientareaconfirmpassword'}</label>
                                                    <input type="password" name="password2" id="inputNewPassword2" class="field form-control" autocomplete="off"{if $remote_auth_prelinked} value="{$password}"{/if}>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default btn-sm btn-sm-block generate-password" data-targetfields="inputNewPassword1,inputNewPassword2">
                                                        {lang key='generatePassword.btnLabel'}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="password-strength-meter">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success bg-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="passwordStrengthMeterBar"></div>
                                                    </div>
                                                    <p class="text-center small text-muted" id="passwordStrengthTextLabel">{lang key='pwstrength'}: {lang key='pwstrengthenter'}</p>
                                                </div>
                                            </div>
                                        </div>
                                        {if $securityquestions}
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <select name="securityqid" id="inputSecurityQId" class="field form-control">
                                                        <option value="">{lang key='clientareasecurityquestion'}</option>
                                                        {foreach $securityquestions as $question}
                                                            <option value="{$question.id}"{if $question.id eq $securityqid} selected{/if}>{$question.question}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="inputSecurityQAns">{lang key='clientareasecurityanswer'}</label>
                                                        <input type="password" name="securityqans" id="inputSecurityQAns" class="field form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                            {if $showMarketingEmailOptIn}
                                <div class="card mb-4">
                                    <div class="card-body p-4">
                                        <h3 class="card-title">{lang key='emailMarketing.joinOurMailingList'}</h3>
                                        <p>{$marketingEmailOptInMessage}</p>
                                        <input type="checkbox" name="marketingoptin" value="1"{if $marketingEmailOptIn} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='yes'}" data-off-text="{lang key='no'}">
                                    </div>
                                </div>
                            {/if}
                            <div class="register-page-captcha">
                                {include file="$template/includes/captcha.tpl"}
                            </div>
                            {if $accepttos}
                                <p class="text-center" style="margin:16px 0;">
                                    <label class="form-check" style="font-size:13px;color:#666;">
                                        <input type="checkbox" name="accepttos" class="form-check-input accepttos">
                                        {lang key='ordertosagreement'} <a href="{$tosurl}" target="_blank" style="color:#6c5ce7;">{lang key='ordertos'}</a>
                                    </label>
                                </p>
                            {/if}
                            <p class="text-center" style="margin-top:20px;">
                                <input class="om-login-btn{$captcha->getButtonClass($captchaForm)}" type="submit" value="{lang key='clientregistertitle'}" style="cursor:pointer;"/>
                            </p>
                        </form>
                    </div>
                {/if}

                <p class="om-signup-link">
                    Already have an account? <a href="{$WEB_ROOT}/login.php">{$LANG.loginbutton}</a>
                </p>
            {/if}
        </div>
    </div>
</div>
