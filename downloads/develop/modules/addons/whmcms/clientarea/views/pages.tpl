<div id="whmcms">
    <div class="container">
        
        <div class="row">
            <div class="col-xs-12">{$content}</div>
        </div>
    
        <div class="clear"></div>
        
        {if $social.facebookButton || $social.twitterButton || $social.googlePlusButton}
        <br>
        <div class="row">
            <div class="col-xs-12">
            	{* Facebook Like Button *}
        		{if $social.facebookButton}
                <div class="whmcms-social-button whmcms-social-button-facebook">
                    <div class="fb-like" data-href="{$social.url}" data-width="150" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
                </div>
            	{/if}
				{* Twitter Share Button *}
            	{if $social.twitterButton}
                <div class="whmcms-social-button whmcms-social-button-twitter">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="{$social.url}" data-text="{$social.title}" data-via="sentq" data-hashtags="whmcms">Tweet</a>
                </div>
            	{/if}
				{* Google+ Share Button *}
				{if $social.googlePlusButton}
                <div class="whmcms-social-button whmcms-social-button-googleplus">
                    <div class="g-plusone" data-size="medium" data-href="{$social.url}"></div>
                </div>
				{/if}
            </div>
        </div>
        {/if}
        
        {* Facebook Comments *}
        {if $social.facebookComments}
        <div class="row">
            <div class="col-xs-12">
                <hr>
                <div class="fb-comments" data-href="{$social.url}" data-width="500"></div>
            </div>
        </div><!-- Social Elements -->
        {/if}
        
    </div><!-- Container End -->
</div><!-- WHMCMS Wrapper -->