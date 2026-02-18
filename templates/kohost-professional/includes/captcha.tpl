{if $captcha->isEnabled() && $captcha->isEnabledForForm($captchaForm)}
    <div class="row">
        <div class="col-md-12">
            {if $templatefile == 'homepage'}
                <div class="domainchecker-homepage-captcha">
            {/if}
    
            {if $captcha == "recaptcha"}
                <div id="google-recaptcha-domainchecker" class="form-group recaptcha-container"></div>
            {elseif !in_array($captcha, ['invisible', 'recaptcha'])}
                <div id="default-captcha-domainchecker" class="{if $filename == 'domainchecker'}input-group input-group-box {/if}">
                    <p>{lang key="captchaverify"}</p>

                    <div class="captchaimage">
                        <img id="inputCaptchaImage" data-src="{$systemurl}includes/verifyimage.php" src="{$systemurl}includes/verifyimage.php" align="left" />
                        <input id="inputCaptcha" type="text" name="code" maxlength="6" class="form-control {if $filename == 'register'}pull-left{/if}"
                               data-toggle="tooltip" data-placement="right" data-trigger="manual" title="{lang key='orderForm.required'}"/>
                    </div>
                </div>
            {/if}
    
            {if $templatefile == 'homepage'}
                </div>
            {/if}
        </div>
    </div>
{/if}
