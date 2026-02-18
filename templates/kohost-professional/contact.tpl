{if $sent}
    {include file="$template/includes/alert.tpl" type="success" msg=$LANG.contactsent textcenter=true}
{/if}

{if $errormessage}
    {include file="$template/includes/alert.tpl" type="error" errorshtml=$errormessage}
{/if}

{if !$sent}
    <div class="custom-card-block account-eidt">
        <form method="post" class="row" action="contact.php" class="form-horizontal" role="form">
            <input type="hidden" name="action" value="send" />
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputName" class="control-label">{$LANG.supportticketsclientname}</label>
                    <input type="text" name="name" value="{$name}" class="form-control" id="inputName" placeholder="John" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail" class="control-label">{$LANG.supportticketsclientemail}</label>
                    <input type="email" name="email" value="{$email}" class="form-control" id="inputEmail" placeholder="john@yourdomain.com" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputSubject" class="control-label">{$LANG.supportticketsticketsubject}</label>
                    <input type="subject" name="subject" value="{$subject}" class="form-control" id="inputSubject" placeholder="General Support" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputMessage" class="control-label">{$LANG.contactmessage}</label>
                    <textarea name="message" rows="7" class="form-control" id="inputMessage" placeholder="Message goes here...">{$message}</textarea>
                </div>
            </div>

            <div class="col-md-12">
                {if $captcha}
                    <div class="margin-bottom">
                        {include file="$template/includes/captcha.tpl"}
                    </div>
                {/if}
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn primary-solid-btn{$captcha->getButtonClass($captchaForm)}">{$LANG.contactsend}</button>
            </div>

        </form>
    </div>
{/if}
