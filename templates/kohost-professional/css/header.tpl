<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{if $kbarticle.title}{$kbarticle.title} - {/if}{$pagetitle} - {$companyname}</title>

    <link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/customfiles/assets/css/main.css"/>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/jquery-3.5.1.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/popper.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/bootstrap.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/bootstrap-slider.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/jquery.easing.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/owl.carousel.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/countdown.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/jquery.waypoints.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/jquery.rcounterup.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/magnific-popup.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/validator.min.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/vendors/hs.megamenu.js"></script>
        <script src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/js/app.js"></script>

    {include file="$template/includes/head.tpl"}

    {$headoutput}

    {literal}
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '3016867318552964'); // Insert your pixel ID here.
            fbq('track', 'PageView');
        </script>

        <noscript>
            <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=123456&ev=PageView&noscript=1"/>
        </noscript>

        <!-- DO NOT MODIFY -->
        <!-- End Facebook Pixel Code -->
    {/literal}
    
    {literal}
        <!-- TrustBox script -->
        <!--<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>-->
        <!-- End TrustBox script -->
    {/literal}
    
    {literal}
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-220843875-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-220843875-1');
        </script>
    {/literal}

    <style type="text/css">
        
        .order-summary .total-due-today .content {
            display: block !important;
        }
        #order-standard_cart .order-summary .total-due-today-padded span {
            margin-top: 7px;
        }
        .listtable {
            border-radius: 6px;
            width: 100%;
            display: block;
        }
        .next {
            top: 0 !important;
            font-size: 11px !important;
            color: #777 !important;
            cursor: not-allowed !important;
            background-color: #fff !important;
            border-color: #ddd !important;
            font-weight: 400 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .pagination>li a {
            height: 35px;
            line-height: 35px;
            padding: 0 15px 0 !important;
            font-size: 13px;
        }
        .dataTables_wrapper {
            display: flex !important;
            flex-direction: row-reverse !important;
            gap: 15px !important;
            justify-content: space-between !important;
        }
    </style>
</head>



<body data-phone-cc-input="{$phoneNumberInputStyle}" class="body-wraper {$templatefile} {if in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}auth-wrap{/if}">
<div id="popup" style="z-index: 9999999; display: none; position: absolute; top: 60%; left: 50%; transform: translate(-50%, -20%); background-color: white; padding: 70px;width: 90%;border-style: solid; border-width: thin; border-color: gray">
		  <div style="float: right;">
			<button onclick="document.getElementById('popup').style.display = 'none';">X</button>
		  </div>
		  <p><h2>7-Day Money-Back Guarantee</h2>
		<p>At Choiceiptv.com, we are committed to providing our customers with the best possible IPTV experience. That's why we offer a 7-day money-back guarantee on all of our IPTV packages.</p>

		<h3>Refund Policy</h3>
		<ul>
		  <li>If for any reason you are not completely satisfied with our IPTV service within the first 7 days of your subscription, you can request a full refund of your purchase.</li>
		  <li>Simply contact our customer support team and let us know that you would like to cancel your subscription and receive a refund.</li>
		</ul>

		<h3>Eligibility</h3>
		<ul>
		  <li>The refund request must be made within 7 days of the original purchase date.</li>
		  <li>The refund request must be made by the original purchaser of the IPTV package.</li>
		  <li>You must provide proof of purchase, such as an order confirmation email or receipt.</li>
		  <li>You must have used our IPTV service for less than 7 days.</li>
		  <li>You must have not have used any of our add-on services</li>
		</ul>

		<h3>Refund Processing</h3>
		<p>Please note that refunds will be processed within 5-7 business days of receiving your request.</p>

		<h3>Contact Us</h3>
		<p>We want our customers to be completely satisfied with our IPTV service and we believe that our 7-day money-back guarantee is the best way to ensure that. If you have any questions or concerns about our money-back guarantee policy, please do not hesitate to <a href="contact.php">contact our customer support team</a>.</p>
		</p>
</div>

<!-- TODO: Remove this for client version-->

{$headeroutput}
</br>
	<div class="support-action d-inline-flex " style="text-align: center;">
	<!--	<a href="https://choiceiptv.com/contact.php" class="mr-3" style="color:#000000"><i class="fas fa-comment mr-1 color-accent"></i> <span>Email Us</span></a>
		<a href="sms:+16472649167" class="mb-0"><i class="fas fa-sms color-accent" style="color:#000000"></i> <span style="color:#000000">Text: +16472649167</span></a> -->
		<a href="https://t.me/+Uhi6IVd8S27Iiile" class="mb-0" style="color:#000000"><i class="fab fa-telegram color-accent"></i> <span>Telegram</span></a>
		<!--<a href="https://choiceiptv.com/index.php?rp=/store/try-iptv" class="mb-0" style="color:#000000"><i class="fas fa-smile color-accent"></i> <span>Free Trials</span></a></br>-->
		<a href="https://choiceiptv.com/index.php?rp=/store" class="mb-0" style="color:#000000"><i class="fas fa-smile color-accent"></i> <span>Start Now</span></a>
		<a href="https://choiceiptv.com/channel-list.php" class="mb-0" style="color:#000000"><i class="fas fa-list color-accent"></i> <span>Channel List</span></a>
		<a href="https://choiceiptv.com/affiliates.php" class="mb-0" style="color:#000000"><i class="fas fa-dollar-sign"></i> <span>Affiliates</span></a>
		<a href="http://webtv.choiceip.tv"  target=”_blank” class="mb-0" style="color:green"><i class="fas fa-tv color-accent"></i> <span>Watch Live TV</span></a></br>

		<hr>
		
	</div>

{if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}

<!-- TODO: Remove this for client version-->
{include file="kohost-professional/includes/alert-message.tpl" hide=true}
<header id="standard" class="white-bg header-main-menu">
    <div class="container">
        <div class="row">
            <section id="main-menu">
                <nav id="nav" class="navbar navbar-default navbar-main" role="navigation">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-nav">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                        <!-- 
                        aClass = additional class if you want to pass add here or skip
                        logo = option: priamry or secondary. Primary will be color logo and Secondary will be white version logo
                        -->
                        {include file="$template/includes/logo.tpl" aClass="navbar-brand" logo="primary"}
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="primary-nav">

                        <ul class="nav navbar-nav navbar-center">

                            {include file="$template/includes/navbar.tpl" navbar=$primaryNavbar}

                        </ul>

                        <ul class="nav navbar-nav navbar-right secondary-nav">
                            <li class="primary-action">
                                <a href="{$WEB_ROOT}/cart.php?a=view"> <i class="fas fa-shopping-basket" data-toggle="tooltip" data-placement="top" title="" data-original-title="{$LANG.viewcart}"></i></a>
                            </li>
                            <!--currency dropdown start-->
                            {if !$loggedin && count($multiCurrency) > 1}
                            <li class="dropdown" id="currency-dropdown">
                                {foreach $multiCurrency as $currency}
                                    {if $currency.id eq $selectedCurrency}
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                       <img  alt="{$currency.code}"src="{$WEB_ROOT}/{$currency.flag}" class="paises"> 
                                       <span>{$currency.prefix}</span> <b class="caret"></b>
                                   </a>
                                   {/if}
                               {/foreach}
                               <ul class="dropdown-menu">
                                   {foreach $multiCurrency as $currency}
                                      {if $currency.id neq $selectedCurrency}
                                        {if $isQueryExist eq true}
                                          <li><a href="{$urlForCurrentcy}&currency={$currency.id}"><img alt="{$currency.code}"src="{$WEB_ROOT}/{$currency.flag}" class="paises"><span>{$currency.prefix}</span></a></li>
                                        {else}  
                                          <li><a href="{$urlForCurrentcy}?currency={$currency.id}"><img alt="{$currency.code}"src="{$WEB_ROOT}/{$currency.flag}" class="paises"><span>{$currency.prefix}</span></a></li>
                                        {/if}
                                      {/if}
                                  {/foreach}
                              </ul>
                            </li>
                            {/if}
                            <!--currency dropdown end-->
                            {if $loggedin}
                                <li>
                                    <a href="#" data-toggle="popover" id="accountNotifications" data-placement="bottom" class="notification">
                                        <i class="fas fa-bell" data-toggle="tooltip" data-placement="top" data-original-title="{$LANG.notifications}"> </i>
                                        <span class="dot-circle"></span>
                                    </a>
                                    <div id="accountNotificationsContent" class="hidden">
                                        <ul class="client-alerts">
                                            {foreach $clientAlerts as $alert}
                                                <li>
                                                    <a href="{$alert->getLink()}">
                                                        <i class="fas fa-fw fa-{if $alert->getSeverity() == 'danger'}exclamation-circle{elseif $alert->getSeverity() == 'warning'}exclamation-triangle{elseif $alert->getSeverity() == 'info'}info-circle{else}check-circle{/if}"></i>
                                                        <div class="message">{$alert->getMessage()}</div>
                                                    </a>
                                                </li>
                                                {foreachelse}
                                                <li class="none">
                                                    {$LANG.notificationsnone}
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                </li>

                                {include file="$template/includes/navbar.tpl" navbar=$secondaryNavbar from="account"}
                            {else}
                                {if $condlinks.allowClientRegistration}
                                    <li class="primary-action">
                                        <a href="{$WEB_ROOT}/register.php" class="sign-up-btn">Sign Up</a>
                                    </li>
                                {/if}
                                <li class="primary-action">
                                    <a href="{$WEB_ROOT}/clientarea.php" class="login-btn">Login</a>
                                </li>
                            {/if}
                        </ul>

                    </div><!-- /.navbar-collapse -->
                </nav>
            </section>
        </div>
    </div>

    <section class="sticky-nav">
        <nav>
            <ul>
                <!--<li><a href="https://choiceiptv.com/cart.php?a=confproduct&i=0"> Free Trial</a></li> -->
                <li><a href="#plans-preview">Plans Preview</a></li>
                <li><a href="#iptv-plans">IPTV Plans</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#vpn">VPN</a></li>
                <li><a href="#iptv-apps">IPTV Apps</a></li>
                <li><a href="#reseller-plans">Reseller Plans</a></li>
                <li><a href="#channel-list">Channel List</a></li>
                <li><a href="#android-box">Android Box</a></li>
                <li><a href="#why-us">Why Us</a></li>						
                <li><a href="#reviews">Reviews</a></li>						
                <li><a href="#terms-of-service">Terms of Service</a></li>						
                <li><a href="#FAQs">FAQs</a></li>						
                <li><a href="#latest-news">Latest News</a></li>						
            </ul>
        </nav>
    </section>
</header>
{/if}

{if $templatefile == 'homepage'}
    <!-- {if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}
   <section id="home-banner" class="hero-equal-height" style="background: url('templates/{$template}/img/header5.jpg')no-repeat center center / cover">
    </section>
    {/if} -->    <!--promo section start-->
	<!--<section class="ptb-55 primary-bg" style="background-color:black">-->

	<section class="ptb-55" style="background-color:black !important;">
			</br>
		<!--	<h2 style="text-align: center;"><span style="color: #ffffff;"><a style="color: #ffffff;" href="https://choiceiptv.com/index.php?rp=/store/">THE ULTIMATE TV EXPERIENCE AWAITS! ORDER NOW!</a></span></h2>-->
			<div style="text-align:center; padding-bottom:10px">
				<h2 style="display:inline; color:white;"><a style="color:white;" href="https://choiceiptv.com/index.php/store/choice-no-adult-packages">Try IPTV Risk-Free with our 7-day Money-Back Guarantee.</a></h2>
				<button  onclick="document.getElementById('popup').style.display = 'inline';">Read more</button>
			</div>
		</section>
	<br>
<section>
            <div class="tvvideo-container"  style="margin-top:-30px" id="plans-preview">
                <div class="tvvideo-header">
                    <h3 class="tvvideo-heading" style="text-decoration: underline;-webkit-text-decoration-color:gray;text-decoration-color:gray">CHOOSE FROM 5 IPTV PACKAGES. </h3>
                    <div class="pill-nav-container" id="top-pillNav-container">
                        <button class="move-btn prev-btn">&langle;</button>
                            <div class="pill-nav" id="top-pillNav">
                                <button class="first-btn active" data-id="choice">Choice(All channels)</button>
                                <button  data-id="gator">Americas</button>
                                <button  data-id="americas">English</button>
                                <button  data-id="supreme">USA</button>
                                <button  data-id="prime" class="last-btn">Canada</button>
                               <!-- <button class="last-btn" data-id="cinema">Cinema HD</button>-->
                            </div>
                        <button class="move-btn next-btn">&rangle;</button>
                    </div>
                </div>



                <div class="tv" id="top-tv" style="margin-top:30px">
                    <video
                        autoplay
                        muted
                        loop
                        class="tv2 tvVideo"
                        id="myVideo-1"
                    >
                        <source
                            src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice.mp4"
                            type="video/mp4"
                        />
                        Your browser does not support HTML5 video.
                    </video>
                </div>

                <div class="loading-container">
                    <div class="spinner-container">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <h6> Loading Channel </h6>
                </div>

            </div>

    </section>
	<!--
    <section class="ptb-55" style="background-color:#0c8f51   !important;">
        <h2 style="text-align: center;"><span style="color: #ffffff;"><a style="color: #ffffff;" href="https://choiceiptv.com/vpn.php">Avoid ISP throttling with a VPN for IPTV</a></span></h2>
        <p style="color: #ffffff; text-align: center;"> <a style="color: #ffffff;" href="https://choiceiptv.com/vpn.php">Connect up to 10 devices at the same time. Click for details. </a></p>                  
    </section>
    -->

	
	 <section class="promo-section pt-100" style="margin-top:-50px" >
        <div class="container">
            <div class="row" style="display:flex;justify-content: center;">
          
                <!--<div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0"> 
                    <a id="btnOrderHosting" href="https://choiceiptv.com/index.php?rp=/store/"> ->
                      <!--  <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-server color-primary"></span>
                                </div>
                                <div class="promo-info">
                                     <h5>FREE TRIAL</h5>
                                     <p>Try IPTV for FREE. NO CREDIT CARD REQUIRED! NO RISK!</p>
                                </div>
                            </div>
                        </div>-->
                   <!--     <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-server color-primary"></span>
                                </div>
                                <div class="promo-info">
                                     <h5>VPN</h5>
                                     <p>Watch IPTV with minimal interruptions with our VPN service.</p>
                                </div>
                            </div>
                        </div>-->
                  <!--  </a>
                </div>-->
				 <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0" style="width:100%">
                    <a id="btnGetSupport" href="android-box">
                        <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-headset color-primary"></span>
                                </div>
                                <div class="promo-info">
                                    <h5>BEST SUPPORT</h5>
                                    <p>Great support builds trust and loyalty </p>
                                </div>
                            </div>
                        </div>
                    </a>
					</br>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0">
                    <a id="btnOrderHosting" href="#subscribe">
                        <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-server color-primary"></span>
                                </div>
                                <div class="promo-info">
                                     <h5>SUBSCRIBE</h5>
                                     <p>Subscribe to one of our high quality IPTV servers.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
				
                <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0" >
                    <a id="btnMakePayment" href="iptv-reseller.php">
                        <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-money-check-alt color-primary"></span>
                                </div>
                                <div class="promo-info">
                                     <h5>RESELLER SERVICES</h5>
                                    <p>Start your IPTV business with our reseller packages. </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

               
            </div>
        </div>
	<!-- TrustBox widget - Micro Review Count 
<div class="trustpilot-widget" data-locale="en-US" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="61eb368d8afc9ff67b78f6b3" data-style-height="24px" data-style-width="100%" data-theme="light" data-min-review-count="10">
  <a href="https://www.trustpilot.com/review/choiceiptv.com" target="_blank" rel="noopener">Trustpilot</a>
</div>-->
<!-- End TrustBox widget -->
</br>
</br>
    </section>
	
		<section class="ptb-55" style="background-color:#0948b3   !important;">
			</br>
			<h2 style="text-align: center;"><span style="color: #ffffff;"><a style="color: #ffffff;" href="https://choiceiptv.com/affiliates-program.php">Become an Affiliate and earn 25% on referrals.</a></span></h2>
			<p style="color: #ffffff; text-align: center;"> <a style="color: #ffffff;" href="https://choiceiptv.com/affiliates-program.php">Click here to sign up as an affiliate and get paid for every referral that subscribe to one of our IPTV packages. Payouts are done through PayPal.</a></p> 
			
        <div class="container">
        </div>			  
    </section>

<!--about section start-->
    <section class="about-section ptb-100" style="background-color: #e1e2e3;" id="features">
        <div class="container">
            <div class="row align-center-row">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2>A Superior Live And Video-On-Demand TV Experience</h2>
									<p>Enjoy HD & 4K picture quality, and fast
                                    channel change. Watch thousands of movies
                                    and popular series on demand on any device.  </p>                     
							<ul class="list-unstyled tech-feature-list">
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Live Channels:</strong> 10K+ HD channels</li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Movies:</strong> Large & diverse selection of on-demand movies</li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>TV Series: </strong> Thousands of on-demands tv series</li>
                        </ul>
                        <div class="action-btns">
                            <a href="https://choiceiptv.com/index.php/store/" class="btn outline-btn animated-btn mr-lg-3">Start Watching TV Now</a>
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <img loading="lazy" src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/tivimate_friends.jpg" alt="iptv subscription" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--about section end-->

<!--about section start-->
    <section class="about-section ptb-100" >
        <div class="container">
            <div class="row align-center-row">
			 <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <img loading="lazy" src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/choiceserver1.jpg" alt="best sports iptv" class="img-responsive"/>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2>The Ultimate Experience for Sports Enthusiasts</h2>
                        <p>Stream the greatest sports in the world. Get unlimited access to NFL, Premier League, 
						UEFA Champions League, Carabao Cup, Matchroom Boxing, Six Nations, WTA Tennis, PDC Darts, and much more.</p>
                        <ul class="list-unstyled tech-feature-list">
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Large Selection:</strong> Access to all sports around the globe</li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Eliminate Blackouts: </strong> Watch your favourite sports teams. No more black outs</li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>PPV :</strong> Watch live PPV events</li>
                        </ul>
                        <div class="action-btns">
                            <a href="https://choiceiptv.com/index.php/store/" class="btn outline-btn animated-btn mr-lg-3">Start Watching Sports Now</a>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>
    <!--about section end-->
<!--about section start-->
   <!-- <section class="about-section ptb-100" style="background-color: #e1e2e3;" id="vpn">
        <div class="container">
            <div class="row align-center-row">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2>Avoid ISP Throttling with VPN for IPTV</h2>
									<p>Get the best VPN for IPTV. Available for all plans for $5.00  </p>                     
							<ul class="list-unstyled tech-feature-list">
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Unlimited Bandwidth</strong> </li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Connect up to 10 devices</strong></li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Avoid ISP throttling </strong> </li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>No connection logs </strong> </li>
                            <li><span class="fa fa-check-circle color-primary"></span><strong>Available on: </strong>Windows, MAC, Android, Firestick, Android TV, iOS, Linux </li>
                          <!--  <li><span class="fa fa-check-circle color-primary"></span><strong>How to order: </strong>Select "VPN for IPTV" under Available Addons on IPTV product page. </li>
							-->
                 <!--       </ul>
                        <div class="action-btns">
                            <a href="https://choiceiptv.com/index.php/store/vpn" class="btn outline-btn animated-btn mr-lg-3">Stop ISP Throttling & Start Watching TV Now</a>
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <img loading="lazy" src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/best-vpn-for-iptv-us.jpg" alt="Vpn for Iptv" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!--about section end-->

 <!--services section start-->
	    <section class="ptb-55 primary-bg">
            <h2 class="text-white main-heading"><center>INDUSTRY-LEADER IN IPTV SUBSCRIPTION SERVICES </center></h2>		  
        </section>

    <section class="our-services ptb-100 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6b">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">5 IPTV PLANS</span> <br>5x Premium IPTV PLANS</h4>
                            <span class="fa fa-server fa-3x color-primary"></span>
                        </div>
                        <p>Choose from 5 premium IPTV plans and starting watching TV immediately.  </p>
                        <a href="https://choiceiptv.com/choice-server.php" class="btn outline-btn mt-3" style="font-size:12px">Choice</a>
                        <a href="https://choiceiptv.com/index.php/store/americas" class="btn outline-btn mt-3" style="font-size:12px">Americas</a>
                        <a href="https://choiceiptv.com/cart.php?gid=40" class="btn outline-btn mt-3" style="font-size:12px">USA</a>
                        <a href="https://choiceiptv.com/index.php/store/canada-premium-tv-no-adult" class="btn outline-btn mt-3" style="font-size:12px">Canada</a>
                        <a href="https://choiceiptv.com/cart.php?gid=41" class="btn outline-btn mt-3" style="font-size:12px">English</a>
				</div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">TV SERIES</span> <br>1700+ TV Shows</h4>
                            <span class="fas fa-tv fa-3x color-primary"></span>
                        </div>
                        <p>With our massive library of TV shows that are updated daily, there's always something to watch.  </p>
                        <a href="https://choiceiptv.com/index.php/store/" class="btn outline-btn mt-3" style="font-size:12px">STREAM TV SHOWS</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">VoD</span><br>10,000+ Movies </h4>
                            <span class="fa fa-film fa-3x color-primary"></span>
                        </div>
                        <p>Watch the latest movies in HD and 4K. Our VoD catalogue includes international movies as well.  </p>
                        <a href="https://choiceiptv.com/index.php/store/" class="btn outline-btn mt-3" style="font-size:12px">STREAM VOD</a>
						
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">SPORTS</span> <br>NBA, NHL, MLB, NFL, PPV</h4>
                            <span class="fas fa-basketball-ball fa-3x color-primary"></span>
                        </div>
                        <p>Access Premium SportS: UFC, PPV, NBA, NHL, NFL, MLB, Boxing, MMA, Cricket, DAZN, SuperSports, Astro Sports and Much More </p>
                        <a href="https://choiceiptv.com/index.php/store/" class="btn outline-btn mt-3" style="font-size:12px">WATCH PREMIUM SPORTS</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--services section end-->	
	 <!--call to action start-->

    <section class="ptb-55 primary-bg" id="iptv-apps">
        <h2 class="text-white main-heading"><center>CHOOSE FROM THE BEST IPTV APPS </center></h2>		  
    </section>

    <div class="tvvideo-container middle-tv-container" id="apps" >
        
        <div class="tvvideo-header" style="margin-top:-18px;">
            <div class="pill-nav-container" id="middle-pillNav-container">
                <button class="move-btn prev-btn">&langle;</button>
                <div class="pill-nav" id="middle-pillNav">
                    <button class="first-btn active" data-id="tivimate">Tivimate</button>
                    <button  data-id="xciptv">XCIPTV</button>
                    <button  data-id="purple">Purple</button>
                    <button  data-id="smarters">IPTV Smarters</button>
                    <button  data-id="xciptv2">XCIPTV Modern</button>
                    <button class="last-btn"  data-id="cinema">Cinema HD</button>
                </div>
                <button class="move-btn next-btn">&rangle;</button>
            </div>
        </div>
        

        <div class="tv" id="middle-tv" style="margin-top:10px;">
            <video
                autoplay
                muted
                loop
                class="tv2 tvVideo"
                id="myVideo-2"
                preload="none" 
            >
                <source
                    src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice.mp4"
                    type="video/mp4"
                />
                Your browser does not support HTML5 video.
            </video>
        </div>

        <div class="loading-container">
            <div class="spinner-container">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <h6> Loading Channel </h6>
        </div>
    </div>
    <!--call to action end-->
   
    <!--Beginning of plans sections-->
    {include file="$template/plans.tpl"}

    <!-- end of plans section --->
    <section class="ptb-55 primary-bg">
        <h2 class="text-white main-heading"><center>CHANNEL LIST</center></h2>	    	  
    </section>

    <div id="channel-list"> </div>
    {include file="$template/channel-list.tpl"}


    <!--Reseller packages-->
    <section  class="ptb-55 primary-bg" id="reseller-plans">
        <h2 class="text-white main-heading"><center>RESELLER PACKAGES </center></h2>  
    </section>
    <!--Reseller packages end-->
    
   <!--Reseller packages section start-->
     {include file="$template/reseller-credits.tpl"}

     <!--promo section end-->
    <!--about section start-->
  <!--
  <section id="androidbox" class="call-to-action ptb-100 gradient-overlay"
             style="background: url('templates/{$template}/img/hero-bg-4.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row align-center-row">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2 class="text-white main-heading">CIRKUD X88 KING</h2>
                        <p class="text-white main-heading">
                            Driven by Amlogc S922X Hexa-core CPU with 4Gb RAM and 128GB Storage, the X88 King is a world class media streaming player with intuitive user interface that is powered by Cirkud Media Center - a Kodi® Fork. If you are familiar with Kodi®, then you will be right at home.
                        </p>
                        <ul class="text-white main-heading">
                            <p><span class="fa fa-check-circle "></span><strong> CPU</strong>: Amlogic S922X Hexa-core 64bit ARM® Cortex™ A73 + A53
							GPU</p>
                            <p><span class="fa fa-check-circle "></span><strong> WIFI: </strong> 802.11 IEEE Dual WiFi a/b/g/n/ac; 2.4G / 5.8G</p>
                            <p><span class="fa fa-check-circle "></span><strong> MEMORY & STORAGE: </strong> 4GB LPDDR4 memory & 128GB eMMC Storage</p>
                            <p><span class="fa fa-check-circle "></span><strong> OPERATING SYSTEM: </strong> Android 9.0 OS</p>
                             <p><span class="fa fa-check-circle "></span><strong> INTERFACE: </strong> Cirkud Media Center (Forked Version of Kodi®)</p>
                            <p><span class="fa fa-check-circle "></span><strong> GOOGLE ASSISTANT: </strong> Control your media with your voice</p>
                        </ul>
                        <div class="action-btns">
                            <a href="https://cirkud.com/" target="_blank" class="btn solid-white-btn animated-btn">Buy Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <img loading="lazy" src="templates/{$template}/img/x88king.png" alt="hosting" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--about section end-->
 
    <!--about section start-->
	<!--
    <section class="about-section ptb-100">
        <div class="container">
            <div class="row align-center-row">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <img loading="lazy" src="templates/{$template}/img/max-img2.png" alt="hosting" class="img-responsive"/>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2 >CIRKUD X96 MAX PLUS</h2>
                        <p >Driven by Amlogic S905X3 Quad-core CPU with 4Gb RAM and 64GB Storage, the X96 Max Plus is a mid-range streaming media player with intuitive user interface that is powered by Cirkud Media Center - a Kodi® Fork. If you are familiar with Kodi®, then you will be right at home. </p>
							<ul class="list-unstyled tech-feature-list">
                            <p><span class="fa fa-check-circle color-primary"></span><strong> CPU:</strong>Amlogic S905X3 64-bit Quad-core</p>
                            <p><span class="fa fa-check-circle color-primary"></span><strong> WIFI: </strong> 802.11 IEEE WiFi a/b/g/n/ac; 2.4G / 5.8G</p>
                            <p><span class="fa fa-check-circle color-primary"></span><strong> MEMORY & STORAGE: </strong> 4GB LPDDR4 memory & 64GB eMMC Storage</p>
                            <p><span class="fa fa-check-circle color-primary"></span><strong> OPERATING SYSTEM:</strong> Android 9.0 OS</p>
                             <p><span class="fa fa-check-circle color-primary"></span><strong> INTERFACE: </strong> Cirkud Media Center (Forked Version of Kodi®)</p>
                           <p><span class="fa fa-check-circle color-primary"></span><strong> GOOGLE ASSISTANT: </strong> Control your media with your voice</p>
                        </ul>
                        <div class="action-btns">
                            <a href="https://cirkud.com/#Max" target="_blank" class="btn outline-btn animated-btn mr-lg-3">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    -->
    <!--services section end-->
    <!--
    <section class="ptb-55" style="background-color:black !important;" id="android-box">
        </br>
        <h2 style="text-align: center;"><span style="color: #ffffff;"><a style="color: #ffffff;" href="android-box">IPTV PLAYERS BUILT FOR STREAMING!</a></span></h2>
        <p style="color:white; text-align: center"> ****Android Boxes are not pre-loaded with any DMCA infringing apps*****</p>
    </section> <br>

	<section id="androidbox" class="about-section ptb-50 ">
        <div class="container">
            <div class="row align-center-row">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2 class="text-black">BEST SELLING IPTV BOX</h2>
                        <h4 class="text-black">Take your IPTV experience to the next level with our premium IPTV boxes. </h4>
                        <ul class="text-black">
                            <p><span class="fa fa-check-circle "></span><strong> FREE IPTV FOR 2 MONTHS</strong> </p>
                            <p><span class="fa fa-check-circle "></span><strong> EASY TO USE. PLUG & PLAY</strong></p>
                            <p><span class="fa fa-check-circle "></span><strong> FULL SUPPORT </strong> </p>
                            <p><span class="fa fa-check-circle "></span><strong> BLAZING FAST </strong> </p>
                            <p><span class="fa fa-check-circle "></span><strong> ANDROID TV INTERFACE AVAILABLE </strong> </p>
                            <p><span class="fa fa-check-circle "></span><strong> MORE FLEXIBLE THAN FIRESTICK, ROKU, or SMART TV </strong> </p>
                             <p><span class="fa fa-check-circle "></span><strong> PLAY GAMES (GAMEPAD REQUIRED) </strong> </p>
                           <p><span class="fa fa-check-circle "></span><strong> GOOGLE ASSISTANT ON ANDROID TV DEVICES </strong> </p>
                        </ul>
                        <div class="action-btns">
                            <a href="android-box" target="_blank" class="btn outline-btn animated-btn mr-lg-3">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <a href="android-box"><img loading="lazy" src="https://ae01.alicdn.com/kf/Hc875d0d9abe04a67b541bc6ae373aab4J.jpg" alt="Android IPTV Box" class="img-responsive"/></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
	</hr>-->


   
    <section class="ptb-55 primary-bg" id="why-us">
        <h2 class="text-white main-heading"><center>WHY CHOOSE US?</center></h2>		  
    </section>
    
    <!--feature section start-->
    <section class="feature-section ptb-100 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fal fa-list-alt icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Worldwide HD Channels</h5>
                            <p>Over 10,000+ HD channels from accross the globe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fas fa-tablet-alt icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Watch On Any Device</h5>
                            <p>Watch your favourite channels on the device of your choice: Apple, Android, MAG, Smart TV, Roku, Firestick, Android TV</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fal fa-check-square icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>1-Click Installer</h5>
                            <p>No need to dig into a bunch of documentation. Simply install one of our apps, and start watching TV</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fal fa-history icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>99.5% Uptime Guarantee</h5>
                            <p>With multiple datacenter locations, redundant cooling, emergency generators, and constant
                                monitoring, we are able to offer our 99.5% Uptime Guarantee.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fa fa-server icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Smart Load-Balaning</h5>
                            <p>Improved channel load times with smart load-balancing technology. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fal fa-headset icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Award-Winning Support</h5>
                            <p>No question is too simple, or too complex for our team of experts. Our in-house support staff and service team are here for you 24/7, 365.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--feature section end-->
	  <!--  <section class="ptb-55 primary-bg">
			<h2 class="text-white main-heading"><center>Plug & Play APPS</center></h2>		
    </section>

		<section id="apps">
				  </br>
			<div class="container">
					<div class="for-scroll">
						<ul id="cc" class="nav nav-pills" role="tablist">
							<li class="nav-item">
								<a class="nav-link videos1" data-toggle="pill" href="#movies">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/img/choiceiptv.jpg"></br>
										<p>Choice IPTV Player</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos2" data-toggle="pill" href="#tvshows">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/img/alpha2.png">
										<p>Alpha IPTV Player</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos3" data-toggle="pill" href="#music">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/img/xciptvchoice.png">
										<p>XCIPTV</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos4" data-toggle="pill" href="#livetv">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/img/choicesmarters.png">
										<p>IPTV Smarters</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos5" data-toggle="pill" href="#photos">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/img/choicetivimate.png">
										<p>TiviMate</p>
									</div>
								</a>
							</li>
							 <li class="nav-item">
								<a class="nav-link videos8" data-toggle="pill" href="#pip">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/img/choicekodi.png">
										<p>Kodi</p>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</section>-->

	<!------Installation Tuturials----------------------------->
   <!-- <section class="ptb-55 primary-bg">
			<h2 class="text-white main-heading"><center>INSTALLATION TUTORIALS</center></h2>		
    </section>

		<section id="apps">
				  </br>
			<div class="container">
			
					<div class="for-scroll">
						<ul id="cc" class="nav nav-pills" role="tablist">
							<li class="nav-item">
								<a class="nav-link videos1" data-toggle="pill" href="#movies">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/movies.png"></br>
										<p>Android Box</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos2" data-toggle="pill" href="#tvshows">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/tvshow.png">
										<p>Android TV</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos3" data-toggle="pill" href="#music">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/music.png">
										<p>Roku</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos4" data-toggle="pill" href="#livetv">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/livetv.png"></br>
										<p>VLC</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos5" data-toggle="pill" href="#photos">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/photos.png">
										<p>Samsung Tizen OS</p>
									</div>
								</a>
							</li>
							 <li class="nav-item">
								<a class="nav-link videos8" data-toggle="pill" href="#pip">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/pip.png">
										<p>LG webOS</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos9" data-toggle="pill" href="#addons">
									<div class="products-tab">
										<img loading="lazy" src="templates/{$template}/assets/img/rocket.png">
										<p>iOS</p>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
				</br>
				</br>
				</br>
			</section>
-->
<!--Customer reviews started-->
	
        <div class="section-heading text-center">
    <br></br>
        <h2>What Our Client Say About Our Services</h2>
        <p>
            We offer the one of the best iptv services. Our amazing client reviews are a testament to our iptv services.
        </p>
    </div>
{include file="$template/trustpilot-reviews.tpl"}

<!--Customer reviews End-->


   <section class="ptb-55 primary-bg" id="terms-of-service">
        <h2 class="text-white main-heading"><center>TERMS OF SERVICE</center></h2>
    </section>

    <!--services section start-->
    <section class="feature-section ptb-100 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fal fa-list-alt icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Terms Of Use</h5>
                            <p>Service is solely for viewing in your private residence. You agree that no services provided to you will be used or viewed in areas open to the public, 
							commercial establishments, public internet forums, social media, or other residential locations.
							Services may not be re-broadcasted, and admission may not be charged for listening to, using or viewing any services. 							
							We may disconnect your services with no refund if you do not abide by our policy.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fas fa-stream icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Streams</h5>
                            <p>We provide over 10,000+ high quality streams from many countries. The number of streams depends on type of iptv server ordered. 
							Although very uncommn, service interruptions can occur. Choice IPTV reserves the right to remove any streams or replace broken streams to 
							keep the service stable and reliable. Most streaming issues are fixed within hours of being notified. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fa fa-shopping-cart icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>After Purchase</h5>
                            <p>Your IPTV login details will be emailed to you within 2 hours after receiving payment. Please allow up to 24 hours before contacting support. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fas fa-exchange-alt icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Refunds</h5>
                            <p><strong>CANCEL ANYTIME</strong>. Once your account is created, the credits are applied and cannot be reversed. If you have never tried IPTV, 
							we suggest starting with a free trial to see if the service meets your needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fal fa-phone-laptop icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Hardware Requirements</h5>
                            <p>We recommend an internet connection speed of at least 30+ Mbps on the streaming device. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6b">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fa fa-question-circle icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Support</h5>
                            <p>Choice IPTV provies the best support in the industry. Support is provided for the duration of your subscription. 
							Supported is limited to our streaming services only. We do not support third party hardware.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--feature section end-->


    
    <!--faq started-->

    <section class="ptb-55 primary-bg" id="FAQs">
        <h2 class="text-white main-heading"><center>FREQUENTLY ASKED QUESTIONS</center></h2>
    </section>


    <!--faq section start-->
    <section id="faq" style="padding-top:50px;">
        <div class="container">
                <div class="col-md-12 col-lg-12">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Which IPTV server is right for me?</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body gray-light-bg">
                                    <p>We suggest thoroughly testing all the IPTV servers for at least 24hrs as all the servers have different content and prices.  
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Which devices do you support</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body gray-light-bg">
                                    <p>With the exception of the Prime Server which only supports Android/Firestick devices, we support Android, Firestick,
									MAG, iOS, Smart TV, Formuler Devices, and any M3U player applications.  
									
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">What's the recommended internet speed?</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body gray-light-bg">
                                    <p>A minimum of 30+ Mbps connection speed for smooth streams.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">How many devices can I use at the same time?</h6>
                            </a>
                            <div id="collapse3" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body gray-light-bg">
                                    <p>We have plans for up to 6 devices depending on type of server. 
                                    </p>
                                </div>
                            </div>
							</br>
							<p><center><h5> Still have questions? <a href="contact.php">Contact us</a></h5></center></p>

                        </div>
                    </div>
                </div>
        </div>
    </section>
    <!--faq section end-->
   

{else}
{include file="$template/includes/kohost-pageheader.tpl"}
{/if}

{include file="$template/includes/verifyemail.tpl"}
<section id="main-body" >
    {if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}
    <div class="container{if $skipMainBodyContainer}-fluid without-padding{/if}">
        <div class="row">
            {if !$inShoppingCart && ($primarySidebar->hasChildren() || $secondarySidebar->hasChildren())}
                <div class="col-md-3 pull-md-left sidebar">
                    {include file="$template/includes/sidebar.tpl" sidebar=$primarySidebar}
                </div>
            {/if}

            <!-- Container for main page display content -->
            <div class="{if !$inShoppingCart && ($primarySidebar->hasChildren() || $secondarySidebar->hasChildren())}col-md-9 pull-md-right{else}col-xs-12{/if} main-content">
    {/if}
<script>
	// Get the modal2

	var modal2parent = document.getElementsByClassName("modal2_multi");

	// Get the button that opens the modal2

	var modal2_btn_multi = document.getElementsByClassName("myBtn_multi");

	// Get the <span> element that closes the modal2
	var span_close_multi = document.getElementsByClassName("close_multi");

	// When the user clicks the button, open the modal2
	function setDataIndex() {

		for (i = 0; i < modal2_btn_multi.length; i++)
		{
			modal2_btn_multi[i].setAttribute('data-index', i);
			modal2parent[i].setAttribute('data-index', i);
			span_close_multi[i].setAttribute('data-index', i);
		}
	}



	for (i = 0; i < modal2_btn_multi.length; i++)
	{
		modal2_btn_multi[i].onclick = function() {
			var ElementIndex = this.getAttribute('data-index');
			modal2parent[ElementIndex].style.display = "block";
		};

		// When the user clicks on <span> (x), close the modal2
		span_close_multi[i].onclick = function() {
			var ElementIndex = this.getAttribute('data-index');
			modal2parent[ElementIndex].style.display = "none";
		};

	}

	window.onload = function() {
		setDataIndex();
	};

	window.onclick = function(event) {
		if (event.target === modal2parent[event.target.getAttribute('data-index')]) {
			modal2parent[event.target.getAttribute('data-index')].style.display = "none";
		}
	};

</script>
<script>
    // When the user clicks on div, open the popup
    function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
    }
</script>

<style>
        html {
                scroll-behavior: smooth;
        }
            * {
                box-sizing: border-box;
            }

            body {
                font-family: Verdana, sans-serif;
                margin: 0;
            }


            img {
                vertical-align: middle;
            }

            /* Next & previous buttons */
            .prev,
            .next {
                cursor: pointer;
                position: absolute;
                top: 50%;
                width: auto;
                padding: 16px;
                margin-top: -22px;
                color: white;
                font-weight: bold;
                font-size: 18px;
                transition: 0.6s ease;
                border-radius: 0 3px 3px 0;
                user-select: none;
            }

            /* Position the "next button" to the right */
            .next {
                right: 0;
                border-radius: 3px 0 0 3px;
            }

            /* On hover, add a black background color with a little bit see-through */
            .prev:hover,
            .next:hover {
                background-color: rgba(0, 0, 0, 0.8);
            }

            /* Caption text */
            .text2 {
                color: #ffffff;
                font-size: 50px;
                padding: 8px 12px;
                position: absolute;
                bottom: 8px;
                width: 100%;
                text-align: center;
                top: -5px;
            }

            /* Number text (1/3 etc) */
            .numbertext {
                color: #ffffff;
                font-size: 12px;
                padding: 8px 12px;
                position: absolute;
                top: 0;
            }

            /* The dots/bullets/indicators */
            .dot {
                cursor: pointer;
                height: 15px;
                width: 15px;
                margin: 0 2px;
                background-color: #999999;
                border-radius: 50%;
                display: inline-block;
                transition: background-color 0.6s ease;
            }

            .dot:hover {
                background-color: #111111;
            }

            /* Fading animation */
            .fade {
                -webkit-animation-name: fade;
                -webkit-animation-duration: 6.5s;
                animation-name: fade;
                animation-duration: 6.5s;
            }

            @-webkit-keyframes fade {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 1;
                }
            }
            @keyframes fade {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 1;
                }
            }

            /* On smaller screens, decrease text size */
            @media (max-width: 1200px) {
                .prev,
                .next,
                .text2 {
                    position: relative;
                    font-size: 30px;
                    top: -100px;
                }
                .slideshow-container {
                    width: 100%;
                    position: relative;
                    margin: auto;
                    z-index: 9;
                }
                .col-xs-12 {
                    width: 100%;
                }
            }

            @media (min-width: 1201px) {
                .prev,
                .next,
                .text2 {
                    position: relative;
                    font-size: 30px;
                    top: -100px;
                }
                .slideshow-container {
                    width: 100%;
                    position: relative;
                    margin: auto;
                }
            }

            /* LOADING START */
            
            .loading-container {
                position:absolute;
                top: 25%;
                left:50%;
                transform:translateX(-50%);
                width: 150px;
                height: 150px;
                display: inline-block;
                background: none;
                color:#fff;
                text-align:center;
            }

            .spinner-container {
                width: 100%;
                height: 100%;
                position: relative;
                transform: translateZ(0) scale(1);
                backface-visibility: hidden;
                transform-origin: 0 0; /* see note above */
            }
            .spinner-container {
                transform: translateX(-30px);
            }
            .spinner-container div {
                box-sizing: content-box;
            }

            .spinner-container div {
                left: 50%;
                top: 50%;
                position: absolute;
                animation: spin linear 1s infinite;
                background: #ffffff;
                width: 8px;
                height: 8px;
                border-radius: 6px / 6px;
                transform-origin: 30px;
            }

            @keyframes spin {
                0% {
                    opacity: 1;
                }
                100% {
                    opacity: 0;
                }
            }

            .spinner-container div:nth-child(1) {
                transform: rotate(0deg);
                animation-delay: -0.9166666666666666s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(2) {
                transform: rotate(30deg);
                animation-delay: -0.8333333333333334s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(3) {
                transform: rotate(60deg);
                animation-delay: -0.75s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(4) {
                transform: rotate(90deg);
                animation-delay: -0.6666666666666666s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(5) {
                transform: rotate(120deg);
                animation-delay: -0.5833333333333334s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(6) {
                transform: rotate(150deg);
                animation-delay: -0.5s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(7) {
                transform: rotate(180deg);
                animation-delay: -0.4166666666666667s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(8) {
                transform: rotate(210deg);
                animation-delay: -0.3333333333333333s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(9) {
                transform: rotate(240deg);
                animation-delay: -0.25s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(10) {
                transform: rotate(270deg);
                animation-delay: -0.16666666666666666s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(11) {
                transform: rotate(300deg);
                animation-delay: -0.08333333333333333s;
                background: #ffffff;
            }
            .spinner-container div:nth-child(12) {
                transform: rotate(330deg);
                animation-delay: 0s;
                background: #ffffff;
            }
			/* LOADING END */
			.d-lg-block {
			  display: block !important;
			  margin-left: -15px;
			}


            .tvvideo-container {
                background-image: url({$WEB_ROOT}/templates/{$template}/customfiles/assets/img/tv-bg.png);
                background-position: bottom;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
                padding: 40px 0;
                margin-bottom: 40px;

                min-height: 100vh;
                position:relative;

                display: flex;
                align-items: center;
                justify-content: center;
            }
            .tvvideo-container#apps {
                background-image: url({$WEB_ROOT}/templates/{$template}/customfiles/assets/img/tv-bg-2.png);
                background-position: 0 0 ;
                background-repeat: no-repeat;
                background-size: 100% 100%;
            }

            .pill-nav-container {
                padding: 0 40px;
                overflow-x: hidden;
                position:relative;

            }
            .pill-nav-container.bottomPillNavContainer {
                background-color: #fff;
                padding-top: 30px;
                padding-bottom: 10px;
            }
      

            .tvvideo-header {
                position: absolute;
                top: 20px;
                left:0;
                width: 100%; 
            }
            .tvvideo-header .tvvideo-heading {
                font-size: 25px;
                text-align:center;
                color: #fff;
            }
            
            .pill-nav-container .move-btn{
                display:none;
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                color: #fff;
                border-radius: 5px;
                background: #000;
                z-index: 5;
                cursor: pointer;
            }
            .pill-nav-container .move-btn.prev-btn{
                left: 5px;
            }
            .pill-nav-container .move-btn.next-btn{
                right: 5px;
            }
            .pill-nav-container.bottomPillNavContainer .move-btn {
                top: 63%;
            }
            .pill-nav {
                text-align: center;       
                width: 100%;     
            }

            .pill-nav button {
                width:max-content;
                min-width: 135px;
                display: inline-block;
                color: black;
                text-align: center;
                padding: 5px 10px;
                text-decoration: none;
                font-size: 14px;
                border-radius: 5px;
                background-color: #ddd;
            }

            .pill-nav button:hover {
                background-color: #ddd;
                color: black;
            }

            .pill-nav-container .move-btn:hover,
            .pill-nav button.active {
                background-color: dodgerblue;
                color: white;
            }

            .tv {
                position: relative;
                background:#000;
                top: -85px;
                max-width: 40vw;
                max-height: 50vh;
                width:100%;
                height:100%;
                outline: 10px solid #000;
            }

            .middle-tv-container {
                min-height: 115vh;
            }
            .tv#middle-tv {
                top: -180px;
            }

            .tv  video.tvVideo {
                    width:100%;
                    height:100%;
            }
            .tv .tvVideo {
                position:relative;
                transform: scaleY(1.04);
                top:4px;
                z-index: 3;
            }



            .collapse.in {
                display: none;
            }

            .collapse {
                max-height: 120vh;
                overflow-y: scroll;
            }

            #faq .accordion,
            #faq .collapse {
                max-height: 100%;
                overflow-y: auto;
            }
            .accordion > .card {
                max-height: 45vh;
                overflow: hidden;
            }        
            .content {
                position: relative;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                color: #f1f1f1;
                width: 100%;
                padding: 20px;
                top: -240px;
            }

            #myBtn {
                width: 200px;
                font-size: 18px;
                padding: 10px;
                border: none;
                background: #000;
                color: #fff;
                cursor: pointer;
            }

            #myBtn:hover {
                background: #ddd;
                color: black;
            }

            .hosting-promo-content h5 {
                text-align: center;
            }
            .hosting-promo-icon {
                justify-content: center;
            }

            .single-service p iframe {
                width:100%;
            }

            .owl-carousel.owl-drag .owl-item.active {
                background: transparent; 
            }

            .channel-list-container {
               display: none;
            }
            .channel-list-container.active {
                display: block;
                background: transparent;
            }

            .feature-section .row {
                position: static;
                grid-gap: 2rem;
                display: grid;
                grid-template-columns: repeat(2,1fr);
            }
            .feature-section .row::before,
            .feature-section .row::after {
                content: none;
            }
            .feature-section .row .col-md-6 {
                max-width: 100% !important;
                float: none !important;
                width: 100% !important;
            }
            .feature-section .row .features-box {
                height: 100%;
            }

			/* ----------------------------- */
			/* STATICNAV START */
			/* ----------------------------- */

			.sticky-nav {
				display:none;
				position: absolute !important;
				top: 60px;
				left: 0;

				background: #fff;
				z-index: 8;
				padding: 0 20px;

				width: 100%;
				overflow: hidden;
			}
			#standard .sticky-nav {
				top: 100%;
            }

			.sticky-nav ul {
				padding: 0 15px;
				overflow-x: auto;

				display: grid;
				grid-auto-flow: column;
				justify-items: initial !important;
				justify-content: initial !important;
				grid-gap: 2rem;
				font-size: 14px;
				border-bottom: 1px solid #eee;
                list-style: none;
                margin-bottom: 0;
			}



			/* .sticky-nav ul::-mosc, */
			.sticky-nav ul::-webkit-scrollbar {
				height: 2px;
			}

			/* Track */
			.sticky-nav ul::-webkit-scrollbar-track {
				background: #f1f1f1;
			}

			/* Handle */
			.sticky-nav ul::-webkit-scrollbar-thumb {
				background: #888;
			}

			/* Handle on hover */
			.sticky-nav ul::-webkit-scrollbar-thumb:hover {
				background: #555;
			}

			.sticky-nav ul li {
				padding: 10px 0;
				width: max-content;
				border-bottom: 2px solid #fff;
			}
			.sticky-nav ul li a {
				width: max-content;
			}
			.sticky-nav ul li.active {
				border-bottom: 2px solid #0069d9;
			}
			#accordion {
				max-height: 60vh;
				overflow-y: scroll;
			}

            #myflex {
                display:flex;
                justify-content:center;
            }

			/* ----------------------------- */
			/* STATICNAV END */
			/* ----------------------------- */

			/* MEDIA QUERIES */

            @media only screen and (min-width: 1900px){
                .tv#middle-tv {
                    top: -240px;
                }
            }      
            @media only screen and (max-width: 1440px){
                .tv#middle-tv {
                    top: -180px;
                }
            }

            @media only screen and (max-width: 1370px){
                .tv#middle-tv {
                    top: -180px;
                }
            }

            @media only screen and (max-width: 1180px){
                .tv#middle-tv {
                        to18 -155px;
                }
            }

            @media only screen and (max-width: 1135px){
                .tv {
                    top: -40px;          
                }

                .middle-tv-container {
                    min-height: 105vh;
                }
                .tv#middle-tv {
                    top: -180px;
                }

                .middle-tv-container .loading-container {
                    top: 20%;
                }
            }

            @media only screen and (max-width: 1030px){
                .promo-section .row {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                .tv {
                    top: -50px;          
                }
            }

            @media only screen and (max-width: 800px){
                .tv {
                    max-width: 45vw;
                }
                .tv#middle-tv {
                    top: -185px;
                }

				.sticky-nav {
					top: 73px;
				}
				.sticky-nav ul {
					font-size: 16px;
                    justify-content: stretch;
				}

                
                .pill-nav {
                    display: grid;
                    grid-auto-flow: column;
                    align-items: center;
                    overflow-x: scroll;
                }    
                .feature-section .row {
                    grid-template-columns: 1fr;
                }
            }

            @media only screen and (max-width: 710px){
                .pill-nav-container .move-btn{
                    display: inline-block;
                }
            }


            @media only screen and (max-width: 430px){
                .spacing {
                    display: block;
                }
                .single-service  {
                    padding: 5px !important;
                }

                .tv {
                    max-width: 82%;
                    width:100%;
                    height:100%;
                }

				.sticky-nav ul {
					padding: 0 1rem;
					gap: 1rem;
					text-align: center;
				}
                #myflex {
                    flex-direction:column;
                }
                .middle-tv-container .loading-container {
                    top: 19%;
                }

                .tvvideo#apps {
                    background-position: center;
                    background-size: cover;
                }
            }

            @media only screen and (max-width: 380px){
                .tv {
                    max-width: 93%;
                }
            }

            @media only screen and (max-width: 320px){
                .tv {
                    max-width: 90%;
                }
            }

            @media only screen 
                and (min-device-width: 768px) 
                and (max-device-width: 1024px) 
                and (orientation: portrait) {
                    .tv {
                        top: -140px; 
                    }
                      .middle-tv-container .loading-container {
                            top: 30%;
                        }
			}
			/* line 8, node_modules/bootstrap/scss/_images.scss */
			.img-fluid {
			  max-width: 100%;
			  height: auto;
			}
       .main-heading {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }
        </style>



<script> 
    window.addEventListener('load',e => {
        console.log("HEADER");
        function switchSetter (containerID,ulID,tvID = null) {

            const prevBtn = document.querySelector(containerID + ' .prev-btn');
            const nextBtn = document.querySelector(containerID + ' .next-btn');

            const pillNav = document.querySelector(ulID);
            const pillNavBtns = document.querySelectorAll(ulID + ' button');

            const firstBtn = pillNav.querySelector('.first-btn');
            const lastBtn = pillNav.querySelector('.last-btn');

            const tv = tvID ?  document.querySelector(tvID) : null;
            const channelListContainers = document.querySelectorAll('.channel-list-container');

            pillNav.addEventListener('click',e => {
                let id = e.target.dataset.id;
                let list = e.target.dataset.list;

                if(id) {
                    removeActiveBtns(pillNavBtns);
                    e.target.classList.add('active');

                    switch (id) {
                        case 'choice':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-1"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'gator':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-1"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/tivimate-gator.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'americas':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-1"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/americas.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        case 'supreme':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-1"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/tivimate-supreme.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        case 'prime':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-1"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/tivimate-prime.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'cinema':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-1"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/cinema-hd.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'xciptv':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/xciptv-choice.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                       
							case 'tivimate':
                            tv.innerHTML = `
                                    <video
                                        autoplay
                                        muted
                                        loop
                                        class="tv2 tvVideo"
                                        id="myVideo-2"
                                        preload="none" 
                                    >
                                        <source
                                            src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice2.mp4"
                                            type="video/mp4"
                                        />
                                        Your browser does not support HTML5 video.
                                    </video>
                            `
                            break;
                        
                        case 'prime-tivimate':
                            tv.innerHTML = `
                                    <video
                                        autoplay
                                        muted
                                        loop
                                        class="tv2 tvVideo"
                                        id="myVideo-2"
                                        preload="none" 
                                    >
                                        <source
                                            src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/tivimate-prime.mp4"
                                            type="video/mp4"
                                        />
                                        Your browser does not support HTML5 video.
                                    </video>
                            `
                            break;
                        
                        case 'supreme-tivimate':
                            tv.innerHTML = `
                                    <video
                                        autoplay
                                        muted
                                        loop
                                        class="tv2 tvVideo"
                                        id="myVideo-2"
                                        preload="none" 
                                    >
                                        <source
                                            src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/tivimate-supreme.mp4"
                                            type="video/mp4"
                                        />
                                        Your browser does not support HTML5 video.
                                    </video>
                            `
                            break;

                        case 'purple':
                            tv.innerHTML = `                   
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/purple-supreme.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        
                        case 'prime-purple':
                            tv.innerHTML = `                   
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/purple-prime.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        
                        case 'supreme-purple':
                            tv.innerHTML = `                   
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/purple-supreme.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'smarters':
                            tv.innerHTML = `                   
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/smarters-choice.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'prime-smarters':
                            tv.innerHTML = `                   
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/smarters-prime.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        
                        case 'supreme-smarters':
                            tv.innerHTML = `                   
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/smarters-supreme.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'xciptv2':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice-xciptvmodern.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        
                        case 'choice-xciptvmodern':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice-xciptvmodern.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        case 'prime-xciptvmodern':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/prime-xciptvmodern.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        
                        case 'supreme-xciptvmodern':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/choice-xciptvmodern.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                       
                        case 'gator-xciptvmodern':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/xciptvmodern-gator.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                            
                        case 'prime-xciptv':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/xciptv_prime.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                       
                        case 'supreme-xciptv':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/xciptv_supreme.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                       
                        case 'gator-xciptv':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/xciptv_supreme.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;
                        case 'americas-xciptv':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/americas-xciptv.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break; 
                        case 'americas-xciptvmodern':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/americas-xciptvmodern.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;                         
                        case 'americas-smarters':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/americas-smarters.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break; 
                        case 'americas-purple':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/americas-purple.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break; 							
							case 'cinema':
                            tv.innerHTML = `
                                <video
                                    autoplay
                                    muted
                                    loop
                                    class="tv2 tvVideo"
                                    id="myVideo-2"
                                    preload="none" 
                                >
                                    <source
                                        src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/cinema-hd.mp4"
                                        type="video/mp4"
                                    />
                                    Your browser does not support HTML5 video.
                                </video>
                            `
                            break;

                        default:
                            break;

                    }

                } else if (list) {
                    removeActiveBtns(pillNavBtns);
                    e.target.classList.add('active');

                    channelListContainers.forEach(cont => {
                        if(cont.id === list) cont.classList.add('active');
                        else cont.classList.remove('active');
                    })
                }
            });

            let pillNavScrollWidth = pillNav.scrollWidth;

            let scrollPos = pillNav.clientWidth;
            let btnWidth = 134;

            prevBtn.addEventListener("click", (e) => {  
                if (scrollPos >= 0 && scrollPos - btnWidth >= 0) {
                    if (scrollPos === pillNavScrollWidth) {
                        pillNav.scrollTo(pillNavScrollWidth - pillNav.clientWidth, 0); 
                        scrollPos = pillNavScrollWidth - pillNav.clientWidth; 
                    }
                    
                    if(scrollPos - btnWidth >= 0){
                        scrollPos -= btnWidth;
                        pillNav.scrollTo(scrollPos, 0);
                    }
                } else {
                    pillNav.scrollTo(0, 0);
                    scrollPos = 0;
                }
            });

            nextBtn.addEventListener("click", (e) => {
                if (
                    scrollPos <= pillNavScrollWidth &&
                    scrollPos + btnWidth < pillNavScrollWidth
                ) {
                    scrollPos += btnWidth;
                    pillNav.scrollTo(scrollPos, 0);
                } else {
                    pillNav.scrollTo(pillNavScrollWidth, 0);
                    scrollPos = pillNavScrollWidth;
                }

            });


            const observer = new IntersectionObserver(entries => {
                if(entries[0].target.classList.contains('first-btn')) {
                    if(entries[0].isIntersecting) {
                        pillNav.scrollTo(0, 0);
                        scrollPos = 0;
                        prevBtn.disabled=true;
                        nextBtn.disabled=false;
                    } else {
                        prevBtn.disabled=false;
                    }
                }

                if(entries[0].target.classList.contains('last-btn')) {
                    if(entries[0].isIntersecting) {
                        pillNav.scrollTo(pillNavScrollWidth, 0);
                        scrollPos = pillNavScrollWidth;
                        prevBtn.disabled=false;
                        nextBtn.disabled=true;
                    } else {
                        nextBtn.disabled=false;
                    }
                }
            })

            observer.observe(lastBtn)
            observer.observe(firstBtn)
        }

        function throttle(func, limit = 300) {
            let lastFunc;
            let lastRan;
            return function () {
                if (!lastRan) {
                    func.apply(this, arguments);
                    lastRan = Date.now();
                } else {
                    clearTimeout(lastFunc);
                    lastFunc = setTimeout(function () {
                        if (Date.now() - lastRan >= limit) {
                            func.apply(this, arguments);
                            lastRan = Date.now();
                        }
                    }, limit - (Date.now() - lastRan));
                }
            };
        }

        function removeActiveBtns(btns) {
            btns.forEach(btn => {
                btn.classList.remove('active')
            })
        }


        const topPillNav = document.querySelector('#top-pillNav-container');
        const topPillNav2 = document.querySelector('#top-pillNav-container2');
        const middlePillNav = document.querySelector('#middle-pillNav-container');
        const bottomPillNav2 = document.querySelector('#bottom-pillNav-container2');

        const checkScroll = throttle(()=>{
        if(window.pageYOffset >= 3) stickyNav.style.display = 'block';
            else stickyNav.style.display = 'none';
        })

        const stickyNav  = document.querySelector(".sticky-nav");
        addEventListener('scroll',checkScroll);
        
        if(topPillNav) {
            switchSetter('#top-pillNav-container','#top-pillNav','#top-tv')
        }

        if(middlePillNav) {
            switchSetter('#middle-pillNav-container','#middle-pillNav','#middle-tv')
        }

        if(topPillNav2) {
            switchSetter('#top-pillNav-container2','#top-pillNav2')
        }
        if(bottomPillNav2) {
            switchSetter('#bottom-pillNav-container2','#bottom-pillNav2')
        }

        const videoObserver = new IntersectionObserver(entries => {
            if(entries[0].isIntersecting) {
                entries[0].target.play();
            } else {
                entries[0].target.pause();
            }
        })


        let video1 = document.getElementById("myVideo-1");
        let video2 = document.getElementById("myVideo-2");
        if(video1 ) {
            videoObserver.observe(video1);
        }

        if(video2 ) {
            videoObserver.observe(video2);
        }

        const channelListPage = document.querySelector('.channelList-page');
        if(channelListPage) {
            switchSetter('#channelList-pillNav-container','#channelList-pillNav')
        }
 
        const magserversPage = document.querySelector('.magservers-page');
        if(magserversPage) {
            switchSetter('#magservers-pillNav-container','#magservers-pillNav')
        }
    })
</script>

<!---Reviews section--->
<style>

    /* line 2, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap {
    position: relative;
    }

    /* line 5, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-tb-shape {
    position: absolute;
    }

    /* line 7, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-tb-shape.shape-top {
    top: -60px;
    right: 20%;
    }

    /* line 11, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-tb-shape.shape-bottom {
    bottom: -88px;
    right: 50%;
    }

    /* line 19, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-shape:before {
    content: "";
    position: absolute;
    top: 60px;
    left: 20px;
    width: 99%;
    height: 69%;
    background: #f67a3c;
    -webkit-transform: rotate(-6deg);
    transform: rotate(-6deg);
    z-index: -1;
    border-radius: 4px;
    }

    /* line 32, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-shape .testimonial-quote-wrap {
    background: #1062fe;
    padding: 30px 40px;
    z-index: 4;
    margin-top: 30px;
    border-radius: 4px;
    }

    /* line 39, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-shape .testimonial-quote-wrap .author-info .author-img {
    border-radius: 4px;
    border: 4px solid #fff;
    width: 100px;
    position: absolute;
    top: 0;
    }

    /* line 46, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-shape .testimonial-quote-wrap .author-info .media-body {
    position: relative;
    left: 120px;
    }

    /* line 51, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-shape .testimonial-quote-wrap .author-info i {
    font-size: 40px;
    }

    /* line 63, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap {
    border-radius: 20px;
    }

    /* line 66, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap .review-body p {
    height: 115px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    }

    @media (min-width: 320px) and (max-width: 768px) {
    /* line 77, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap .review-body p {
        height: 100px;
    }
    }

    /* line 83, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap .review-top span.ratting-color {
    font-size: 16px;
    font-weight: 700;
    color: #fca326;
    }

    /* line 89, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap .review-author {
    margin-left: 15px;
    }

    /* line 91, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap .review-author .author-avatar {
    width: 64px;
    height: 64px;
    line-height: 64px;
    margin-right: 10px;
    position: relative;
    }

    /* line 98, src/assets/scss/components/review-section/_review-1.scss */
    .single-review-wrap .review-author .author-avatar span {
    background-color: #1062fe;
    width: 32px;
    height: 32px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-line-pack: center;
        align-content: center;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    color: #fff;
    line-height: 60px;
    border-radius: 100%;
    font-size: 48px;
    position: absolute;
    top: 0;
    left: -16px;
    }

    @media (min-width: 320px) and (max-width: 1199px) {
    /* line 119, src/assets/scss/components/review-section/_review-1.scss */
    .testimonial-content-wrap .testimonial-tb-shape.shape-top, .testimonial-content-wrap .testimonial-tb-shape.shape-bottom {
        display: none;
    }
    }

    .row2 {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    body {
        overflow-x: hidden !important;
    }
</style>

</body>
