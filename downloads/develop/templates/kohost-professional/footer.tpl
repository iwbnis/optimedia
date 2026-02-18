{if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}
</div><!-- /.main-content -->
    {if !$inShoppingCart && $secondarySidebar->hasChildren()}
        <div class="col-md-3 pull-md-left sidebar sidebar-secondary">
            {include file="$template/includes/sidebar.tpl" sidebar=$secondarySidebar}
        </div>
    {/if}

<div class="clearfix"></div>
</div>
</div>
{/if}
</section>
{if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}
<!--footer section start-->
<footer id="footer" class="footer-section">
    <!--footer top start-->
    <div class="footer-top gradient-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="row footer-top-wrap">
                        <div class="col-sm-12">
                            <div class="footer-nav-wrap text-white">
                                <!-- 
                                aClass = additional class if you want to pass add here or skip
                                logo = option: priamry or secondary. Primary will be color logo and Secondary will be white version logo
                                -->
                                {include file="$template/includes/logo.tpl" logo="secondary"}
                                <p class="mt-20">The best IPTV subscription - watch over 10,000 channels from around the globe at affordable prices. Free trials available.</p>
                                <ul class="list-inline social-list background-color social-hover-2 mt-2">
									<li class="list-inline-item"><a class="youtube" href="https://www.youtube.com/channel/UC8gDdLOdo-flmIks8-y_byA/videos" target="_blank"><i class="fab fa-youtube"></i></a></li>
									<li class="list-inline-item"><a class="linkedin" href="https://ca.trustpilot.com/review/optimedia.tv" target="_blank"><i class="fa fa-star" style="color:yellow"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row footer-top-wrap">
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">IPTV Plans</h4>
                                <ul class="nav flex-column">
                                    <li>
                                    <a href="https://optimedia.tv/index.php?rp=/store/try-iptv">Free Trials</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/choice-server-plans">Choice server iptv plans</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/gator-server-plans">Gator server iptv plans</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/supreme-server-iptv-subscription-packages">Supreme server iptv plans</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/prime-server-plans">Prime server iptv plans </a>
                                </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">Reseller Plans</h4>
                                <ul class="nav flex-column">
                                   <li>
                                    <a href="https://optimedia.tv/index.php?rp=/store/try-iptv">Free Trials</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/choice-server-reseller-packages">Choice server reseller plans</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/gator-reseller-package">Gator server reseller plans</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/silver-reseller-package">Supreme server reseller plans</a>
                                </li>
                                <li>
                                    <a href="https://optimedia.tv/index.php/store/prime-reseller">Prime server reseller plans </a>
                                </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">Andrid Box</h4>
                                <ul class="nav flex-column">
                                     <li>
                                    <a href="https://optimedia.tv/mecool-km6-iptv-android-tv-box-google-certified">MeCool KM6</a>
									</li>
									<li>
										<a href="https://optimedia.tv/mecool-kd1-iptv-box-tv-stick-google-certified-android-tv-10-os">MeCool KM1</a>
									</li>
									<li>
										<a href="https://optimedia.tv/mecool-km2-iptv-android-tv-box-google-certified">MeCool KM2</a>
									</li>
									<li>
										<a href="https://optimedia.tv/t95-plusiptv-android-tv-box">T95 Plus</a>
									</li>
									<li>
										<a href="https://optimedia.tv/hk1-x4-iptv-android-box">HK1</a>
									</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">SUPPORT</h4>
                                <ul class="nav flex-column">
										<li>
										<a href="https://optimedia.tv/index.php/knowledgebase">Setting up iptv</a>
									</li>
									<li>
										<a href="https://optimedia.tv/index.php/login">Contact Support</a>
									</li>
									<li>
										<a href="https://optimedia.tv/supporttickets.php">My Tickets</a>
									</li>
									<li>
										<a href="https://optimedia.tv/index.php/download">Downloads</a>
									</li>
								   <li>
										<a href="about-us.php">About Us</a>
									</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="back-to-top-btn">
                <a href="#" class="back-to-top"><i class="fas fa-chevron-up"></i></a>
            </div>
        </div>
    </div>
    <!--footer top end-->

    <!--footer copyright start-->
    <div class="footer-bottom py-3">
        <div class="container">
            <div class="row align-items-center justify-content-between display-flex">
                <div class="col-md-8 col-lg-8 col-sm-7 col-xs-12">
                    <p class="copyright-text pb-0 mb-0 text-white">{lang key="copyrightFooterNotice" year=$date_year company=$companyname}</p>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-5 col-xs-12">
                    <div class="payment-method text-lg-right text-md-right text-left">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a class="small-text" href="#">Language :</a></li>
                            <li class="list-inline-item">
                                {if $languagechangeenabled && count($locales) > 1}
                                    <div class="dropup language-chooser">
                                      <button class="btn btn-default dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {$activeLocale.localisedName}
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" aria-labelledby="languageChooser" id="languageChooserContent" class="hidden">
                                        {foreach $locales as $locale}
                                            <li>
                                                <a href="{$currentpagelinkback}language={$locale.language}">{$locale.localisedName}</a>
                                            </li>
                                        {/foreach}
                                      </ul>
                                    </div>
                                {/if}
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--footer copyright end-->
</footer>
<!--footer section end-->
{/if}
<div id="fullpage-overlay" class="hidden">
    <div class="outer-wrapper">
        <div class="inner-wrapper">
            <img src="{$WEB_ROOT}/assets/img/overlay-spinner.svg">
            <br>
            <span class="msg"></span>
        </div>
    </div>
</div>

<div class="modal system-modal fade" id="modalAjax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{$LANG.close}</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body panel-body">
                {$LANG.loading}
            </div>
            <div class="modal-footer panel-footer">
                <div class="pull-left loader">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    {$LANG.loading}
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {$LANG.close}
                </button>
                <button type="button" class="btn btn-primary modal-submit">
                    {$LANG.submit}
                </button>
            </div>
        </div>
    </div>
</div>

{include file="$template/includes/generate-password.tpl"}

{$footeroutput}
<script src="{$WEB_ROOT}/templates/{$template}/js/custom.js?v={$versionHash}"></script>

</body>
</html>
