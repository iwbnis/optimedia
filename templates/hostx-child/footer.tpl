	{if $templatefile == 'homepage'}
	<footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{$WEB_ROOT}" class="logo d-flex align-items-center">
            <span class="sitename"><img src="{$WEB_ROOT}/templates/{$template}/imagenew/whitelogo.png" alt="{$companyname}"></span>
          </a>
          <div class="footer-contact pt-3">
            <p>Premium IPTV provider with over 14,000+ HD channels from around the globe at affordable prices. Stream on any device, anytime.</p>
            <ul>
              <li><a href="{$WEB_ROOT}/order.php">IPTV Canada</a></li>
              <li><a href="{$WEB_ROOT}/order.php">IPTV UK</a></li>
              <li><a href="{$WEB_ROOT}/order.php">IPTV Americas</a></li>
              <li><a href="{$WEB_ROOT}/order.php">Choice IPTV</a></li>
            </ul>
          </div>
          <img src="{$WEB_ROOT}/templates/{$template}/imagenew/payment.png" class="paymentimg" alt="Accepted payment methods">
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>IPTV Plans</h4>
          <ul>
            <li><a href="{$WEB_ROOT}/order.php">Choice (No Adult)</a></li>
            <li><a href="{$WEB_ROOT}/order.php">Choice (Adult)</a></li>
            <li><a href="{$WEB_ROOT}/order.php">Americas (No Adult)</a></li>
            <li><a href="{$WEB_ROOT}/order.php">Americas (Adult)</a></li>
            <li><a href="{$WEB_ROOT}/order.php">Canada (No Adult)</a></li>
            <li><a href="{$WEB_ROOT}/order.php">USA Premium</a></li>
            <li><a href="{$WEB_ROOT}/order.php">English Countries</a></li>
            <li><a href="{$WEB_ROOT}/order.php">MAG Devices</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Reseller Plans</h4>
          <ul>
            <li><a href="{$WEB_ROOT}/order.php">Reseller Packages</a></li>
            <li><a href="{$WEB_ROOT}/order.php">Reseller Websites</a></li>
            <li><a href="{$WEB_ROOT}/affiliates.php">Affiliate Program</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Support</h4>
          <ul>
            <li><a href="{$WEB_ROOT}/knowledgebase.php">Setup Instructions</a></li>
            <li><a href="{$WEB_ROOT}/submitticket.php">Contact Support</a></li>
            <li><a href="{$WEB_ROOT}/supporttickets.php">My Tickets</a></li>
            <li><a href="{$WEB_ROOT}/announcements.php">Announcements</a></li>
            <li><a href="http://webtv.tel" target="_blank">Watch Online</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Resources</h4>
          <ul>
            <li><a href="{$WEB_ROOT}/channel-list.php">Channel List</a></li>
            <li><a href="{$WEB_ROOT}/order.php">Free IPTV Box</a></li>
            <li><a href="{$WEB_ROOT}/knowledgebase.php">Knowledge Base</a></li>
            <li><a href="https://t.me/+Uhi6IVd8S27Iiile" target="_blank">Telegram</a></li>
          </ul>
        </div>

      </div>
    </div>

  </footer>

      <div class="copyright text-center">
		<p class="m-0">Copyright &copy; {$date_year} {$companyname}. All Rights Reserved.</p>
      </div>
	  
{/if}      
	  
				   </div>
                        {if $hostx_theme_settings.enable_secondary_sidebar_right neq 'on'}
                            {include file="$template/hostx_menus/side-menu-hostx/whmcs-default-side-bars.tpl"}
                        {/if}
                    </div>
					
                <div class="clearfix"></div>
            </div>
        </div>
        {if $whmcsDefaultPagesHostx eq 'true' && $loggedin}
            <div class="footer-part-client-area-page">
                {include file="$template/blocks/copyright.tpl"}
                <button class="scroll-to-top" onclick="smoothScroll('#main-body');">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </div>
        {/if}
    </section>
    {* if $whmcsDefaultPagesHostx neq 'true' || $templatefile == 'login' || $templatefile == 'clientregister' || $templatefile == 'password-reset-container'}
        {if $hostx_theme_settings.login_register_layout eq '1'}
            {if $templatefile != 'login' && $templatefile != 'clientregister' && $templatefile != 'password-reset-container'}
                {if $hostx_theme_settings.disable_footer_inner_page neq 'on'}
                    {if $hostx_theme_settings.footer_layout eq '1'}
                        {include file="$template/blocks/footer_block_latest.tpl"}
                    {else}
                        {include file="$template/blocks/footer_block.tpl"}
                    {/if}
                {else if $hostx_theme_settings.disable_footer_inner_page eq 'on'}
                    {if $whmcsDefaultPagesHostx eq 'true'}
                        {if $hostx_theme_settings.footer_layout eq '1'}
                            {include file="$template/blocks/footer_block_latest.tpl"}
                        {else}
                            {include file="$template/blocks/footer_block.tpl"}
                        {/if}           
                    {/if}    
                {/if}
                {include file="$template/blocks/copyright.tpl"}
            {/if}
        {else}
            {if $hostx_theme_settings.disable_footer_inner_page neq 'on'}
                {if $hostx_theme_settings.footer_layout eq '1'}
                    {include file="$template/blocks/footer_block_latest.tpl"}
                {else}
                    {include file="$template/blocks/footer_block.tpl"}
                {/if}
            {else if $hostx_theme_settings.disable_footer_inner_page eq 'on'}
                {if $whmcsDefaultPagesHostx eq 'true'}
                    {if $hostx_theme_settings.footer_layout eq '1'}
                        {include file="$template/blocks/footer_block_latest.tpl"}
                    {else}
                        {include file="$template/blocks/footer_block.tpl"}
                    {/if}           
                {/if}    
            {/if}
            {include file="$template/blocks/copyright.tpl"}
        {/if}
    {/if *}
    <script src="{assetPath file='slick.min.js'}"></script>
    <script src="{assetPath file='owl.carousel.min.js'}"></script>
    {if $templatefile neq 'configureproduct'}
        <script type="text/javascript" src="{$BASE_PATH_JS}/ion.rangeSlider.min.js"></script>
    {/if}
    <script src="{assetPath file='hostx.js'}?v={$versionHash}"></script>
    {if $overridesJsChild}
        <script src="{assetPath file='override.js'}?v={$versionHash}"></script>
    {/if}
    <div id="fullpage-overlay" class="w-hidden">
        <div class="outer-wrapper">
            <div class="inner-wrapper">
                <img src="{$WEB_ROOT}/assets/img/overlay-spinner.svg" alt="">
                <br>
                <span class="msg"></span>
            </div>
        </div>
    </div>
    <div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">{lang key='close'}</span>
                    </button>
                </div>
                <div class="modal-body">
                    {lang key='loading'}
                </div>
                <div class="modal-footer">
                    <div class="float-left loader">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        {lang key='loading'}
                    </div>
                    <button type="button" class="button-style hx-secondary" data-dismiss="modal">
                        {lang key='close'}
                    </button>
                    <button type="button" class="btn btn-primary modal-submit button-style hx-primary-btn">
                        {lang key='submit'}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form method="get" action="{$currentpagelinkback}">
        <div class="modal modal-localisation" id="modalChooseLanguage" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        {if $languagechangeenabled && count($locales) > 1}
                            <h5 class="h5 pt-5 pb-3">{lang key='chooselanguage'}</h5>
                            <div class="row item-selector">
                            <input type="hidden" name="language" value="">
                                {foreach $locales as $locale}
                                    <div class="col-4">
                                        <a href="#" class="item{if $language == $locale.language} active{/if}" data-value="{$locale.language}">
                                            {$locale.localisedName}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                        {if !$loggedin && $currencies}
                            <p class="h5 pt-5 pb-3">{lang key='choosecurrency'}</p>
                            <div class="row item-selector">
                                <input type="hidden" name="currency" value="">
                                {foreach $currencies as $selectCurrency}
                                    <div class="col-4">
                                        <a href="#" class="item{if $activeCurrency.id == $selectCurrency.id} active{/if}" data-value="{$selectCurrency.id}">
                                            {$selectCurrency.prefix} {$selectCurrency.code}
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                        {/if}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">{lang key='apply'}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {if !$loggedin && $adminLoggedIn}
        <a href="{$WEB_ROOT}/logout.php?returntoadmin=1" class="btn btn-return-to-admin" data-toggle="tooltip" data-placement="bottom" title="{if $adminMasqueradingAsClient}{lang key='adminmasqueradingasclient'} {lang key='logoutandreturntoadminarea'}{else}{lang key='adminloggedin'} {lang key='returntoadminarea'}{/if}">
            <i class="fas fa-redo-alt"></i>
            <span class="d-none d-md-inline-block">{lang key="admin.returnToAdmin"}</span>
        </a>
    {/if}

    {include file="$template/includes/generate-password.tpl"}
    {include file="$template/hostx_others_file/cookie-offers.tpl"}
    {$footeroutput}



</body>
</html>
