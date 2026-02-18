<div class="container">
    <div class="row">
        <div class="auth-content-wrap col-sm-12" style="background-color:#ffffff;");>
           
            <div class="logincontainer{if $linkableProviders} with-social{/if}">
                
                <div class="auth-body">
                    <div class="header-lined auth-header text-center">
                        <!-- 
                        aClass = additional class if you want to pass add here or skip
                        logo = option: priamry or secondary. Primary will be color logo and Secondary will be white version logo
                        -->
                        {include file="$template/includes/logo.tpl" logo="primary"}
                        <h1>{$LANG.clientLogin}</h1>
                        {if $LANG.restrictedpage}<p class="mb-0">{$LANG.restrictedpage}</p>{/if}
                    </div>
    
                    {include file="$template/includes/flashmessage.tpl"}
    
                    <div class="providerLinkingFeedback"></div>
    
                    <div class="row">
                        <div class="col-md-12">
    
                            <form method="post" action="{routePath('login-validate')}" class="login-form" role="form">
                                <div class="form-group">
                                    <label for="inputEmail">{$LANG.clientareaemail}</label>
                                    <input type="email" name="username" value="" class="form-control" id="inputEmail" placeholder="{$LANG.enteremail}" autofocus>
                                </div>
    
                                <div class="form-group">
                                    <label for="inputPassword">{$LANG.clientareapassword}</label>
                                    <a href="{routePath('password-reset-begin')}" class="forgot-link text-right">{$LANG.forgotpw}</a>
                                    <input type="password" name="password" value="" class="form-control" id="inputPassword" placeholder="{$LANG.clientareapassword}" autocomplete="off" >
                                </div>
    
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="rememberme" /> {$LANG.loginrememberme}
                                    </label>
                                </div>
                                {if $captcha->isEnabled()}
                                    <div class="margin-bottom">
                                        {include file="$template/includes/captcha.tpl"}
                                    </div>
                                {/if}
                                <div align="center">
                                    <input id="login" type="submit" class="btn btn-block primary-solid-btn{$captcha->getButtonClass($captchaForm)}" value="{$LANG.loginbutton}" />
                                </div>
    
                            </form>
                            {if $linkableProviders}
                             <div class="other-login-signup mt-20 mb-20">
                                <div class="or-login-signup text-center">
                                    <strong>Or Sign In With</strong>
                                </div>
                            </div>
                            <div class="custom-social-signup text-center">
                                {include file="$template/includes/linkedaccounts.tpl" linkContext="login" customFeedback=true}
                            </div>
                            {/if}
            
                        </div>
                    </div>
                </div>
                <div class="auth-footer">
                    <p class="text-center register-link mb-0">
                        Don't have an account yet? <a href="{$WEB_ROOT}/register.php">{$LANG.register}</a>
                    </p>
                </div>
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