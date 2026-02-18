{if in_array('state', $optionalFields)}
    <script>
        var statesTab = 10;
        var stateNotRequired = true;
    </script>
{/if}

<script type="text/javascript" src="{$BASE_PATH_JS}/StatesDropdown.js"></script>
<script type="text/javascript" src="{$BASE_PATH_JS}/PasswordStrength.js"></script>
<script>
    window.langPasswordStrength = "{$LANG.pwstrength}";
    window.langPasswordWeak = "{$LANG.pwstrengthweak}";
    window.langPasswordModerate = "{$LANG.pwstrengthmoderate}";
    window.langPasswordStrong = "{$LANG.pwstrengthstrong}";
    jQuery(document).ready(function()
    {
        jQuery("#inputNewPassword1").keyup(registerFormPasswordStrengthFeedback);
    });
</script>
{if $registrationDisabled}
    {include file="$template/includes/alert.tpl" type="error" msg=$LANG.registerCreateAccount|cat:' <strong><a href="cart.php" class="alert-link">'|cat:$LANG.registerCreateAccountOrder|cat:'</a></strong>'}
{/if}


{if !$registrationDisabled}
<div class="container">
    <div class="row">
        <div class="auth-content-wrap col-sm-12">
            <div id="registration" class="logincontainer signupcontainer">
                <div class="auth-body">
                    <form method="post" class="using-password-strength" action="{$smarty.server.PHP_SELF}" role="form" name="orderfrm" id="frmCheckout">
                        <input type="hidden" name="register" value="true"/>
                
                        <div id="containerNewUserSignup">
                            <div class="header-lined auth-header text-center">
                                <!-- 
                                aClass = additional class if you want to pass add here or skip
                                logo = option: priamry or secondary. Primary will be color logo and Secondary will be white version logo
                                -->
                                {include file="$template/includes/logo.tpl" logo="primary"}
                                <h1>{$LANG.clientregistertitle}</h1>
                            </div>
                            {include file="$template/includes/flashmessage.tpl"}
                            
                            {if $errormessage}
                                {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
                            {/if}
                
                            <div class="sub-heading">
                                <h3>{$LANG.orderForm.personalInformation}</h3>
                            </div>
                            <div class="custom-card-block mb-40">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="firstname" id="inputFirstName" class="field form-control" placeholder="{$LANG.orderForm.firstName}" value="{$clientfirstname}" {if !in_array('firstname', $optionalFields)}required{/if} autofocus>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="lastname" id="inputLastName" class="field form-control" placeholder="{$LANG.orderForm.lastName}" value="{$clientlastname}" {if !in_array('lastname', $optionalFields)}required{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="email" name="email" id="inputEmail" class="field form-control" placeholder="{$LANG.orderForm.emailAddress}" value="{$clientemail}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="tel" name="phonenumber" id="inputPhone" class="field form-control" placeholder="{$LANG.orderForm.phoneNumber}" value="{$clientphonenumber}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                
                            <div class="sub-heading">
                                <h3>{$LANG.orderForm.billingAddress}</h3>
                            </div>
                            <div class="custom-card-block mb-40">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="companyname" id="inputCompanyName" class="field form-control" placeholder="{$LANG.orderForm.companyName} ({$LANG.orderForm.optional})" value="{$clientcompanyname}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="address1" id="inputAddress1" class="field form-control" placeholder="{$LANG.orderForm.streetAddress}" value="{$clientaddress1}"  {if !in_array('address1', $optionalFields)}required{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="address2" id="inputAddress2" class="field form-control" placeholder="{$LANG.orderForm.streetAddress2}" value="{$clientaddress2}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="city" id="inputCity" class="field form-control" placeholder="{$LANG.orderForm.city}" value="{$clientcity}"  {if !in_array('city', $optionalFields)}required{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="state" id="state" class="field form-control" placeholder="{$LANG.orderForm.state}" value="{$clientstate}"  {if !in_array('state', $optionalFields)}required{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group prepend-icon">
                                            <input type="text" name="postcode" id="inputPostcode" class="field form-control" placeholder="{$LANG.orderForm.postcode}" value="{$clientpostcode}" {if !in_array('postcode', $optionalFields)}required{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group prepend-icon">
                                            <select name="country" id="inputCountry" class="field form-control">
                                                {foreach $clientcountries as $countryCode => $countryName}
                                                    <option value="{$countryCode}"{if (!$clientcountry && $countryCode eq $defaultCountry) || ($countryCode eq $clientcountry)} selected="selected"{/if}>
                                                        {$countryName}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    {if $showTaxIdField}
                                        <div class="col-sm-12">
                                            <div class="form-group prepend-icon">
                                                <input type="text" name="tax_id" id="inputTaxId" class="field" placeholder="{$taxLabel} ({$LANG.orderForm.optional})" value="{$clientTaxId}">
                                            </div>
                                        </div>
                                    {/if}
                                </div>
                            </div>
                            
                            {if $customfields || $currencies}
                            <div class="sub-heading">
                                <h3>{$LANG.orderadditionalrequiredinfo}</h3>
                            </div>
                            
                            <div class="custom-card-block mb-40">
                                <div class="row">
                                {if $customfields}
                                    {foreach $customfields as $customfield}
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="customfield{$customfield.id}">{$customfield.name}</label>
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
                                    {if $customfields && count($customfields)%2 > 0 }
                                        <div class="clearfix"></div>
                                    {/if}
                                    {if $currencies}
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <select id="inputCurrency" name="currency" class="field form-control">
                                                {foreach from=$currencies item=curr}
                                                    <option value="{$curr.id}"{if !$smarty.post.currency && $curr.default || $smarty.post.currency eq $curr.id } selected{/if}>{$curr.code}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    {/if}
                                </div>
                            </div>
                            
                            {/if}
                        </div>
                        <div id="containerNewUserSecurity" {if $remote_auth_prelinked && !$securityquestions } class="hidden"{/if}>
                
                            <div class="sub-heading">
                                <h3>{$LANG.orderForm.accountSecurity}</h3>
                            </div>
                            <div class="custom-card-block mb-40">
                                <div id="containerPassword" class="row{if $remote_auth_prelinked && $securityquestions} hidden{/if}">
                                    <div id="passwdFeedback" style="display: none;" class="alert alert-info text-center col-sm-12"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="password" name="password" id="inputNewPassword1" data-error-threshold="{$pwStrengthErrorThreshold}" data-warning-threshold="{$pwStrengthWarningThreshold}" class="field form-control" placeholder="{$LANG.clientareapassword}" autocomplete="off"{if $remote_auth_prelinked} value="{$password}"{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="password" name="password2" id="inputNewPassword2" class="field form-control" placeholder="{$LANG.clientareaconfirmpassword}" autocomplete="off"{if $remote_auth_prelinked} value="{$password}"{/if}>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="password-strength-meter password-wrap form-group">
                                            <button type="button" class="btn outline-btn btn-sm generate-password" data-targetfields="inputNewPassword1,inputNewPassword2">
                                                {$LANG.generatePassword.btnLabel}
                                            </button>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="passwordStrengthMeterBar"></div>
                                                <p class="text-center small text-muted" id="passwordStrengthTextLabel">{$LANG.pwstrength}: {$LANG.pwstrengthenter}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                {if $securityquestions}
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <select name="securityqid" id="inputSecurityQId" class="field form-control">
                                            <option value="">{$LANG.clientareasecurityquestion}</option>
                                            {foreach $securityquestions as $question}
                                                <option value="{$question.id}"{if $question.id eq $securityqid} selected{/if}>
                                                    {$question.question}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group prepend-icon">
                                            <input type="password" name="securityqans" id="inputSecurityQAns" class="field form-control" placeholder="{$LANG.clientareasecurityanswer}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>
                            
                        </div>
                
                        {if $showMarketingEmailOptIn}
                            <div class="sub-heading">
                                <h3>{lang key='emailMarketing.joinOurMailingList'}</h3>
                            </div>
                            <div class="marketing-email-optin custom-card-block mb-20">
                                <p>{$marketingEmailOptInMessage}</p>
                                <div class="switch">
                                    <input type="checkbox" id="switch1" name="marketingoptin" value="1"{if $marketingEmailOptIn} checked{/if} class="no-icheck switch__input" data-size="small" data-on-text="{lang key='yes'}" data-off-text="{lang key='no'}">
                                    <label for="switch1" class="switch__label"></label>
                                </div>
                            </div>
                        {/if}
                
                        {include file="$template/includes/captcha.tpl"}
                
                        <br/>
                        {if $accepttos}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="sub-heading">
                                        <h3>{$LANG.ordertos}</h3>
                                    </div>
                                    <div class="custom-card-block terms-condition mb-40">
                                       <label class="checkbox">
                                            <input type="checkbox" name="accepttos" class="accepttos">
                                            {$LANG.ordertosagreement} <a href="{$tosurl}" target="_blank">{$LANG.ordertos}</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        
                        <p class="text-center">
                            <input class="btn primary-solid-btn{$captcha->getButtonClass($captchaForm)}" type="submit" value="{$LANG.clientregistertitle}"/>
                        </p>
                        {if $linkableProviders}
                        <div class="other-login-signup mt-20 mb-20">
                            <div class="or-login-signup text-center">
                                <strong>Or Sign Up With</strong>
                            </div>
                        </div>
                        <div class="custom-social-signup text-center">
                            {include file="$template/includes/linkedaccounts.tpl" linkContext="registration" }
                        </div>
                        {/if}
                    </form>
                </div>
                <div class="text-center auth-footer">Already registered with us? <a href="{$WEB_ROOT}/clientarea.php">{$LANG.login}</a> <span class="text-lowercase">Or</span> <a href="{routePath('password-reset-begin')}">{$LANG.forgotpw}</a></div>
            </div>
            {if $languagechangeenabled && count($locales) > 1}
                <div class="dropup language-chooser login-languase-chooser">
                    <span>Language:</span>
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {$activeLocale.localisedName}
                        <span class="caret"></span>
                    </a>
                  <ul class="dropdown-menu" aria-labelledby="languageChooser" id="languageChooserContent" class="hidden">
                    {foreach $locales as $locale}
                        <li>
                            <a href="{$currentpagelinkback}language={$locale.language}">{$locale.localisedName}</a>
                        </li>
                    {/foreach}
                  </ul>
                </div>
            {/if}
        </div>
    </div>
</div>
{/if}
