<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{if $kbarticle.title}{$kbarticle.title} - {/if}{$pagetitle} - {$companyname}</title>

    {include file="$template/includes/head.tpl"}

    {$headoutput}

</head>
<body data-phone-cc-input="{$phoneNumberInputStyle}" class="body-wraper {if in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}auth-wrap{/if}">

<!-- TODO: Remove this for client version-->
{include file="kohost-professional/includes/theme-setting.tpl"}

{$headeroutput}

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
                                       <img alt="{$currency.code}"src="{$WEB_ROOT}/{$currency.flag}" class="paises"> 
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
</header>
{/if}

{if $templatefile == 'homepage'}
    {if !in_array($templatefile, ['login', 'clientregister', 'password-reset-container', 'logout'])}
    <section id="home-banner" class="hero-equal-height" style="background: url('templates/{$template}/img/header5.jpg')no-repeat center center / cover">
    </section>
    {/if}     <!--promo section start-->
	 
    <section class="promo-section pt-100">
        <div class="container">
            <div class="row">
                {if $registerdomainenabled || $transferdomainenabled}
                    <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0">
                         <a id="btnBuyADomain" href="domainchecker.php">
                            <div class="single-promo-card single-promo-hover text-center">
                                <div class="promo-body">
                                    <div class="promo-icon">
                                        <span class="fal fa-globe-americas color-primary"></span>
                                    </div>
                                    <div class="promo-info">
                                         <h5>{$LANG.buyadomain}</h5>
                                        <p>IPTV servers for all price points.</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                {/if}
                <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0">
                    <a id="btnOrderHosting" href="https://optimedia.tv/index.php?rp=/store/try-iptv">
                        <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-server color-primary"></span>
                                </div>
                                <div class="promo-info">
                                     <h5>FREE TRIAL</h5>
                                     <p>Try IPTV for before subscribing</p>
                                </div>
                            </div>
                        </div>
                    </a>
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
                                     <p>Subscribe to one of five high quality IPTV servers.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
				
                <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0">
                    <a id="btnMakePayment" href="#reseller">
                        <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-money-check-alt color-primary"></span>
                                </div>
                                <div class="promo-info">
                                     <h5>RESELLER SERVICES</h5>
                                    <p>Start IPTV business with our affordable reseller packages. </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-md-4 mb-lg-0">
                    <a id="btnGetSupport" href="#androidbox">
                        <div class="single-promo-card single-promo-hover text-center">
                            <div class="promo-body">
                                <div class="promo-icon">
                                    <span class="fal fa-headset color-primary"></span>
                                </div>
                                <div class="promo-info">
                                    <h5>ANDROID BOXES</h5>
                                    <p>Buy premium Android boxes and accessories </p>
                                </div>
                            </div>
                        </div>
                    </a>
					</br>
                </div>
            </div>
        </div>
    </section>
    <!--call to action start-->
    <section class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>THE BEST & MOST TRUSTED IPTV SERVICE PROVIDER</center></h2>
			
        <div class="container">
          
        </div>
		  
    </section>
    <!--call to action end-->
 <!-- Trigger/Open The Modal -->

    <!-- The choice Modal -->
    <div class="modal modal_multi">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close close_multi">×</span>
				<h4><i>Choice IPTV Server Content Overview</i></h4>
				<p><iframe width="560" height="315" src="https://www.youtube.com/embed/o44GGWnIuv8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
	   </div>

    </div>

    <!-- The global Modal -->
    <div  class="modal modal_multi">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close close_multi">×</span>
			<h4><i>Gold IPTV Server Content Overview</i></h4>
            <p><iframe width="560" height="315" src="https://www.youtube.com/embed/CAuMNY8mUkE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
        </div>

    </div>

    <!-- The gator Modal -->
    <div  class="modal modal_multi">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close close_multi">×</span>
			<h4><i>Gator IPTV Server Content Overview</i></h4>
            <p><iframe width="560" height="315" src="https://www.youtube.com/embed/bTkvE3R-8Yg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
        </div>

    </div>

    <!-- The silver Modal -->
    <div  class="modal modal_multi">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close close_multi">×</span>
			<h4><i>Silver IPTV Server Content Overview</i></h4>
            <p><iframe width="560" height="315" src="https://www.youtube.com/embed/jjPTfr94838" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
        </div>

    </div>

    <!-- The prime Modal -->
    <div  class="modal modal_multi">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close close_multi">×</span>
			<h4><i>Prime IPTV Server Content Overview</i></h4>
            <p><iframe width="560" height="315" src="https://www.youtube.com/embed/aFcQg_8CYRI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
        </div>

    </div>
	
<!--services section start-->
    <section id="subscribe" class="compare-pricing-section ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <h2><center>Our IPTV Packages</center></h2>
                   
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table w-100 table-hover table-bordered comparision-table text-center">
                                <thead class="comparision-table-head">
                                    <tr class="active">
                                        <th class="text-left">
                                           
                                        </th>
                                        <th>
											<center><button class="myBtn_multi fas fa-external-link-alt color-primary" >
											<strong class="h5 mb-0">Choice Server </strong></button></center>
											
                                            <center><strong class="badge color-1 color-1-bg">#1 Seller</strong></center>
                                        </th>
                                        <th>
											<center><button class="myBtn_multi fas fa-external-link-alt color-primary" >
											<strong class="h5 mb-0">Gold Server </strong></button></center>
											
                                            <center><strong class="badge color-1 color-1-bg">Most Content - Great Value</strong></center>
										
                                        </th>
                                        <th>
											<center><button class="myBtn_multi fas fa-external-link-alt color-primary" >
											<strong class="h5 mb-0">Gator Server </strong></button></center>
											
                                            <center><strong class="badge color-1 color-1-bg">Best International Channels/VoD</strong></center>
										
                                        </th>
                                        <th>
											<center><button class="myBtn_multi fas fa-external-link-alt color-primary" >
											<strong class="h5 mb-0">Silver Server </strong></button></center>											
                                            <center><strong class="badge color-1 color-1-bg">Best Value</strong></center>
										
                                        </th>
                                        <th>
											<center><button class="myBtn_multi fas fa-external-link-alt color-primary" >
											<strong class="h5 mb-0">Prime Server </strong></button></center>											
                                            <center><strong class="badge color-1 color-1-bg">#1 Best UK Channels</strong></center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="comparision-table-body">
                                    <tr>
                                        <td>
                                            <p class="mb-0 comparision-price-title text-left"><strong>Price</strong></p>
                                        </td>
                                        <td class="py-4">
											<p class="popup" style="color:green" onclick="myFunction()">1-5 Connections 
											<span class="fa fa-question-circle color-primary"> <span class="popuptext" id="myPopup">Devices connected at the same time.</span></span></p>
											<!--<p class="text-muted text-sm">1-5 Connections</p>-->
                                            <h5 class="mb-0 comparision-price">$10.99 USD  <span>/month</span></h5>
                                            <a href="https://optimedia.tv/cart.php?a=add&pid=7" class="btn outline-btn animated-btn mr-lg-3">Try Now</a>
                                        </td>
                                        <td class="py-4">
											<p class="popup" style="color:green" onclick="myFunction()">2-6 Connections 
											<span class="fa fa-question-circle color-primary"> <span class="popuptext" id="myPopup">Devices connected at the same time.</span></span></p>
                                            <h5 class="mb-0 comparision-price">$19.00 USD <span>/month</span></h5>
                                            <a href="https://optimedia.tv/cart.php?a=add&pid=108" class="btn outline-btn animated-btn mr-lg-3">Try Now</a>
                                        </td>
                                        <td class="py-4">
											<p class="popup" style="color:green" onclick="myFunction()">1 Connection
											<span class="fa fa-question-circle color-primary"> <span class="popuptext" id="myPopup">Devices connected at the same time.</span></span></p>
                                            <h5 class="mb-0 comparision-price">$10.99 USD <span>/month</span></h5>
                                            <a href="https://optimedia.tv/cart.php?a=add&pid=109" class="btn outline-btn animated-btn mr-lg-3">Try Now</a>
                                        </td>
                                        <td class="py-4">
											<p class="popup" style="color:green" onclick="myFunction()">5 Connections 
											<span class="fa fa-question-circle color-primary"> <span class="popuptext" id="myPopup">Devices connected at the same time.</span></span></p>
                                            <h5 class="mb-0 comparision-price">$9.99 USD <span>/month</span></h5>
                                            <a href="https://optimedia.tv/cart.php?a=add&pid=79" class="btn outline-btn animated-btn mr-lg-3">Try Now</a>
                                        </td>
                                        <td class="py-4">
											<p class="popup" style="color:green" onclick="myFunction()">1-4 Connections 
											<span class="fa fa-question-circle color-primary"> <span class="popuptext" id="myPopup">Devices connected at the same time.</span></span></p>
                                            <h5 class="mb-0 comparision-price">$8.99 USD <span>/month</span></h5>
                                            <a href="https://optimedia.tv/cart.php?a=add&pid=92" class="btn outline-btn animated-btn mr-lg-3">Try Now</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>Live Channels</strong></p>
                                        </td>
                                        <td>8,500+</td>
                                        <td>13,000+</td>
                                        <td>10,000+</td>
                                        <td>2,700+</td>
                                        <td>6,900+</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>4K Channels</strong></p>
                                        </td>
                                        <td>10+</td>
                                        <td>8+</td>
                                        <td>38+</td>
                                        <td>3+</td>
                                        <td>5+</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>VoD</strong></p>
                                        </td>
                                        <td>14,000+</td>
                                        <td>20,000+</td>
                                        <td>26,000+</td>
                                        <td>1,800+</td>
                                        <td>540+</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>TV Series</strong></p>
                                        </td>
                                        <td>800+</td>
                                        <td>5,400+</td>
                                        <td>3,200+</td>
                                        <td>200+</td>
                                        <td>200+</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>Sports Categories</strong></p>
                                        </td>
                                        <td>NBA, NHL, NFL, MLB and More</td>
                                        <td>NBA, NHL, NFL, MLB and More</td>
                                        <td>NBA, NHL, NFL, MLB and More</td>
                                        <td>NBA, NHL, NFL, MLB and More</td>
                                        <td>NBA, NHL, NFL, MLB and More</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>24/7</strong></p>
                                        </td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>PPV Channels</strong></p>
                                        </td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>EPG</strong></p>
                                        </td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>Adult</strong></p>
                                        </td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                        <td><p class="fa fa-check-circle" style="color:green"></p></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>Supported Devices</strong></p>
                                            <p class="text-left">Android/Firestick</p>
                                            <p class="text-left">SmartTV/iOS</p>
                                            <p class="text-left">Windows/Mac</p>
                                            <p class="text-left">MAG</p>
											
                                        </td>
                                        <td>
										</br>
										</br>
										</br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p>
										</td>
                                        <td>
										</br>
										</br>
										</br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p>
										</td>
                                        <td>
										</br>
										</br>
										</br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p>
										</td>
                                        <td><!------prime media---->
										</br>
										</br>
										</br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-check-circle" style="color:green"></p>
										</td>
                                        <td>
										</br>
										</br>
										</br>
										<p class="fa fa-check-circle" style="color:green"></p></br>
										<p class="fa fa-times-circle" style="color:red"></p></br>
										<p class="fa fa-times-circle" style="color:red"></p></br>
										<p class="fa fa-times-circle" style="color:red"></p></br>										</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>VoD App</strong></p>
                                        </td>
										<td><p class="fa fa-times-circle" style="color:red"></p></td>
										<td><p class="fa fa-check-circle" style="color:green"></p></td>
										<td><p class="fa fa-times-circle" style="color:red"></p></td>
										<td><p class="fa fa-check-circle" style="color:green"></p></td>
										<td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>Connections</strong></p>
                                        </td>
                                        <td><p>1,2,3,5</p></td>
                                        <td><p>2,4,6</p></td>
                                        <td><p>1</p></td>
                                        <td><p>5</p></td>
                                        <td><p>1,2,4</p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>Geoblocking</strong></p>
                                        </td>
                                        <td><p>North America/UK</br> Permitted</p></td>
                                        <td><p>No Restrictions</p></td>
                                        <td><p>No Restrictions</p></td>
                                        <td><p>No Restrictions</p></td>
                                        <td><p>No Restrictions</p></td>
                                    </tr>
									
									<tr>
                                        <td>
                                            <p class="text-left"><strong>Trial</strong></p>
                                        </td>
                                        
                                        <td><a href="https://optimedia.tv/cart.php?gid=2" class="btn outline-btn animated-btn mr-lg-3">Buy Now</a></td>
                                        <td><a href="https://optimedia.tv/cart.php?gid=21" class="btn outline-btn animated-btn mr-lg-3">Buy Now</a></td>
                                        <td><a href="https://optimedia.tv/cart.php?gid=17" class="btn outline-btn animated-btn mr-lg-3">Buy Now</a></td>
                                        <td><a href="https://optimedia.tv/cart.php?gid=16" class="btn outline-btn animated-btn mr-lg-3">Buy Now</a></td>
                                        <td><a href="https://optimedia.tv/cart.php?gid=15" class="btn outline-btn animated-btn mr-lg-3">Buy Now</a></td>
                                    </tr>


                                   
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    <!--Reseller packages-->
    <section id="reseller" class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>RESELLER PACKAGES </center></h2>
			
        <div class="container">
          
        </div>
		  
    </section>
    <!--Reseller packages end-->
    
   <!--Reseller packages section start-->
    <section class="compare-pricing-section ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <h2><center>Reseller Credits Overview</center></h2>
                   
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table w-100 table-hover table-bordered comparision-table text-center">
                                <thead class="comparision-table-head">
                                    <tr class="active">
                                        <th class="text-left">
                                           
                                        </th>
                                        <th><center><strong class="h5 mb-0">Choice Server <span
                                            class="badge color-1 color-1-bg">#1 Seller </span></strong>
                                            <p class="text-muted text-sm">Credits</p></center>
                                        </th>
                                        <th><center><strong class="h5 mb-0">Gold Server <span
                                            class="badge color-1 color-1-bg">Most Content - Great Value</span></strong>
                                            <p class="text-muted text-sm">Credits</p></center>
                                        </th>
                                        <th><center><strong class="h5 mb-0">Gator Server <span
                                            class="badge color-1 color-1-bg">Best International Channels</span></strong>
                                            <p class="text-muted text-sm">Credits</p></center>
                                        </th>
                                        <th><center><strong class="h5 mb-0">Silver Server <span
                                            class="badge color-1 color-1-bg">Best Value</span></strong>
                                            <p class="text-muted text-sm">Credits</p></center>
                                        </th>
                                        <th><center><strong class="h5 mb-0">Prime Server <span
                                            class="badge color-1 color-1-bg">Best UK Channels </span></strong>
                                            <p class="text-muted text-sm">Credits</p></center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="comparision-table-body">
                                    <tr>
                                        <td>
                                            <p class="mb-0 comparision-price-title text-left"><strong>Subscription Plans</strong></p>
                                        </td>
                                        <td class="py-4">
											<p class="text-muted text-sm">Starting From</p>
                                            <h4 class="mb-0 comparision-price">$200 </h4>
                                            <a href="https://optimedia.tv/cart.php?gid=7" class="btn outline-btn animated-btn mr-lg-3">BUY NOW</a>
                                        </td>
                                        <td class="py-4">
											<p class="text-muted text-sm">Starting From</p>
                                            <h4 class="mb-0 comparision-price">$200</h4>
                                            <a href="https://optimedia.tv/cart.php?gid=22" class="btn outline-btn animated-btn mr-lg-3">BUY NOW</a>
                                        </td>
                                        <td class="py-4">
											<p class="text-muted text-sm">Starting From</p>
                                            <h4 class="mb-0 comparision-price">$200</h4>
                                            <a href="https://optimedia.tv/cart.php?gid=23" class="btn outline-btn animated-btn mr-lg-3">BUY NOW</a>
                                        </td>
                                        <td class="py-4">
											<p class="text-muted text-sm">Starting From</p>
                                            <h4 class="mb-0 comparision-price">$175</span></h4>
                                            <a href="https://optimedia.tv/cart.php?gid=16" class="btn outline-btn animated-btn mr-lg-3">BUY NOW</a>
                                        </td>
                                        <td class="py-4">
											<p class="text-muted text-sm">Starting From</p>
                                            <h4 class="mb-0 comparision-price">$125</span></h4>
                                            <a href="https://optimedia.tv/cart.php?gid=25" class="btn outline-btn animated-btn mr-lg-3">BUY NOW</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>1 Month/1 Device</strong></p>
                                        </td>
                                        <td>1 Credit</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>10 Credits</p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>1 Credit</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>1 Month/2 Devices</strong></p>
                                        </td>
                                        <td>2 Credits</td>
                                        <td>1 Credit</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>2 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>1 Month/3 Devices</strong></p>
                                        </td>
                                        <td>3 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>1 Month/4 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>2 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>4 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>1 Month/5 Devices</strong></p>
                                        </td>
                                        <td>4 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>1 Credit</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>1 Month/6 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>3 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>3 Month/1 Device</strong></p>
                                        </td>
                                        <td>2 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>15 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>3 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>3 Month/2 Devices</strong></p>
                                        </td>
                                        <td>3 Credits</td>
                                        <td>3 credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>6 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>3 Month/3 Devices</strong></p>
                                        </td>
                                        <td>6 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>3 Month/4 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>5 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>10 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>3 Month/5 Devices</strong></p>
                                        </td>
                                        <td>12 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>3 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>3 Month/6 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>7 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>6 Months/1 Device</strong></p>
                                        </td>
                                        <td>1 Credit</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>20 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>6 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>6 Months/2 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>5 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>10 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>6 Months/3 Devices</strong></p>
                                        </td>
                                        <td>3 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>6 Months/4 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>6 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>15 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>6 Months/5 Devices</strong></p>
                                        </td>
                                        <td>4 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>6 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>6 Months/6 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>10 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>12 Months/1 Device</strong></p>
                                        </td>
                                        <td>2 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>30 Credits</p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>8 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>12 Months/2 Devices</strong></p>
                                        </td>
                                        <td>3 Credits</td>
                                        <td>8 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>14 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>12 Months/3 Devices</strong></p>
                                        </td>
                                        <td>6 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>12 Months/4 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>12 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>20 Credits</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>12 Months/5 Devices</strong></p>
                                        </td>
                                        <td>12 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>12 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>									
                                    <tr>
                                        <td>
                                            <p class="text-left"><strong>12 Months/6 Devices</strong></p>
                                        </td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td>15 Credits</td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                        <td><p class="fa fa-times-circle" style="color:red"></p></td>
                                    </tr>									
									<tr>
                                        <td>
                                            <p class="text-left"><strong>Panel</strong></p>
                                        </td>
                                        
                                        <td>Xtream UI</a></td>
                                        <td>ZapX</a></td>
                                        <td>Custom Panel</a></td>
                                        <td>Xtream UI</a></td>
                                        <td>Xtream UI</a></td>
                                    </tr>
                                    <tr>
									<td>
										<p class="text-left"><strong>Geoblocking</strong></p>
									</td>
										<td><p>North America/UK</br> Permitted</p></td>
										<td><p>No Restrictions</p></td>
										<td><p>No Restrictions</p></td>
										<td><p>No Restrictions</p></td>
										<td><p>No Restrictions</p></td>
									</tr>


                                   
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>

     <!--promo section end-->
    <!--about section start-->
    <section id="androidbox" class="call-to-action ptb-100 gradient-overlay"
             style="background: url('templates/{$template}/img/hero-bg-4.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row align-center-row">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <h2 class="text-white">CIRKUD X88 KING</h2>
                        <p class="text-white">Driven by Amlogc S922X Hexa-core CPU with 4Gb RAM and 128GB Storage, the X88 King is a world class media streaming player with intuitive user interface that is powered by Cirkud Media Center - a Kodi® Fork. If you are familiar with Kodi®, then you will be right at home. </p>
                        <ul class="text-white">
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
                        <img src="templates/{$template}/img/x88king.png" alt="hosting" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--about section end-->
 
    <!--about section start-->
    <section class="about-section ptb-100">
        <div class="container">
            <div class="row align-center-row">
			                <div class="col-md-6 col-lg-6">
                    <div class="cta-new-wrap">
                        <img src="templates/{$template}/img/max-img2.png" alt="hosting" class="img-responsive"/>
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

    <!--services section end-->

    
    <!--pricing section start-->
	<!--
	{if count($myproducts) gt 0 && ($myproducts.0.monthly gt 0 || $myproducts.0.annually gt 0 || $myproducts.0.biennially gt 0 || $myproducts.0.triennially gt 0)}
    <section class="pricing-section ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12">
                    <div class="section-heading-center text-center">
                        <h2>Our Flexible Pricing Plan</h2>
                        <p class="lead">
                            Distinctively recaptiualize principle-centered core competencies through client-centered
                            core competencies. Enthusiastically provide access.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between">
                {foreach $myproducts as $productKey => $myproduct}
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="text-center gray-light-bg single-pricing-pack-2 mt-4 rounded border">
                            <div class="pricing-icon">
                                {if $productKey eq 0}
                                    <img src="{$WEB_ROOT}/templates/{$template}/img/dadicate-web-hosting.svg" width="60" alt="hosing">
                                {elseif $productKey eq 1}
                                    <img src="{$WEB_ROOT}/templates/{$template}/img/vps-hosting.svg" width="60" alt="hosing">
                                {elseif $productKey eq 2}
                                    <img src="{$WEB_ROOT}/templates/{$template}/img/cloud-hosting.svg" width="60" alt="hosing">
                                {/if}
                            </div>
                            <h4 class="package-title">{$myproduct.name}{if $myproduct.is_featured == '1'} <span class="badge color-1 color-1-bg">Popular</span>{/if}</h4>
                            
                            <div class="pricing-price pt-4">
                                <small>Starting at</small>
                                <div class="h2">{$myproduct.prefix}{$myproduct.monthly} <span class="price-cycle h4">/mo</span></div>
                            </div>
                            <a href="cart.php?a=add&pid={$myproduct.relid}" class="btn {if $myproduct.is_featured == '1'}primary-solid-btn{else}outline-btn{/if} mt-20">Get Started Now</a>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </section>
    {/if}
	-->

    <!--services section start-->
    <section class="our-services ptb-100 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">5 IPTV SERVERS</span> <br>5x Premium IPTV Servers</h4>
                            <span class="fa fa-server fa-3x color-primary"></span>
                        </div>
                        <p>Choose from 1 of 5 premium IPTV servers and starting watching TV immediately.  </p>
                        <a href="#" class="btn outline-btn mt-3">START WATHING NOW</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">TV SERIES</span> <br>1700+ TV Shows</h4>
                            <span class="fas fa-tv fa-3x color-primary"></span>
                        </div>
                        <p>With our massive library of TV shows that are updated daily, there's always something to watch.  </p>
                        <a href="#" class="btn outline-btn mt-3">START WATHING NOW</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">VoD</span><br>10,000+ Movies </h4>
                            <span class="fa fa-film fa-3x color-primary"></span>
                        </div>
                        <p>Watch the latest movies in HD and 4K. Our VoD catalogue includes international movies as well.  </p>
                        <a href="#" class="btn outline-btn mt-3">START WATHING NOW</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="single-service rounded border white-bg">
                        <div class="service-header d-flex align-items-center justify-content-between">
                            <h4><span class="h5 text-uppercase">SPORTS</span> <br>NBA, NHL, MLB, NFL, PPV</h4>
                            <span class="fas fa-basketball-ball fa-3x color-primary"></span>
                        </div>
                        <p>Access Premium SportS: UFC, PPV, NBA, NHL, NFL, MLB, Boxing, MMA, Cricket, DAZN, SuperSports, Astro Sports and Much More </p>
                        <a href="#" class="btn outline-btn mt-3">START WATHING NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--services section end-->
    <section class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>WHY CHOOSE US?</center></h2>
			
        <div class="container">
          
        </div>
		  
    </section>
    
    <!--feature section start-->
    <section class="feature-section ptb-100 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
                    <div class="features-box">
                        <div class="features-box-icon">
                            <span class="fa fa-server icon-md color-primary"></span>
                        </div>
                        <div class="features-box-content">
                            <h5>Smart LoadBalaning</h5>
                            <p>Improved channel load times with smart loadbalancing technology. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
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
	    <section class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>Plug & Play APPS</center></h2>		
    </section>

		<section id="apps">
				  </br>
			<div class="container">
					<div class="for-scroll">
						<ul id="cc" class="nav nav-pills" role="tablist">
							<li class="nav-item">
								<a class="nav-link videos1" data-toggle="pill" href="#movies">
									<div class="products-tab">
										<img src="templates/{$template}/img/choiceiptv.jpg"></br>
										<p>Choice IPTV Player</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos2" data-toggle="pill" href="#tvshows">
									<div class="products-tab">
										<img src="templates/{$template}/img/alpha2.png">
										<p>Alpha IPTV Player</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos3" data-toggle="pill" href="#music">
									<div class="products-tab">
										<img src="templates/{$template}/img/xciptvchoice.png">
										<p>XCIPTV</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos4" data-toggle="pill" href="#livetv">
									<div class="products-tab">
										<img src="templates/{$template}/img/choicesmarters.png">
										<p>IPTV Smarters</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos5" data-toggle="pill" href="#photos">
									<div class="products-tab">
										<img src="templates/{$template}/img/choicetivimate.png">
										<p>TiviMate</p>
									</div>
								</a>
							</li>
							 <li class="nav-item">
								<a class="nav-link videos8" data-toggle="pill" href="#pip">
									<div class="products-tab">
										<img src="templates/{$template}/img/choicekodi.png">
										<p>Kodi</p>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</section>

	<!------Installation Tuturials----------------------------->
   <!-- <section class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>INSTALLATION TUTORIALS</center></h2>		
    </section>

		<section id="apps">
				  </br>
			<div class="container">
			
					<div class="for-scroll">
						<ul id="cc" class="nav nav-pills" role="tablist">
							<li class="nav-item">
								<a class="nav-link videos1" data-toggle="pill" href="#movies">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/movies.png"></br>
										<p>Android Box</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos2" data-toggle="pill" href="#tvshows">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/tvshow.png">
										<p>Android TV</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos3" data-toggle="pill" href="#music">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/music.png">
										<p>Roku</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos4" data-toggle="pill" href="#livetv">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/livetv.png"></br>
										<p>VLC</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos5" data-toggle="pill" href="#photos">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/photos.png">
										<p>Samsung Tizen OS</p>
									</div>
								</a>
							</li>
							 <li class="nav-item">
								<a class="nav-link videos8" data-toggle="pill" href="#pip">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/pip.png">
										<p>LG webOS</p>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link videos9" data-toggle="pill" href="#addons">
									<div class="products-tab">
										<img src="templates/{$template}/assets/img/rocket.png">
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
    <section class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>TERMS OF SERVICE</center></h2>
			
        <div class="container">
          
        </div>
		  
    </section>

    <!--services section start-->
    <section class="feature-section ptb-100 gray-light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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

    <!--feature section end-->

    <section class="ptb-55 primary-bg">
			</br>
			<h2 class="text-white"><center>FREQUENTLY ASKED QUESTIONS</center></h2>
			
        <div class="container">
          
        </div>
		  
    </section>


    <!--faq section start-->
    <section id="faq" class="ptb-100">
        <div class="container">
            <div class="row">
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
        </div>
    </section>
    <!--faq section end-->
    <!--call to action section start-->
    <section class="ptb-60 primary-bg">
        <div class="container">
            <div class="row align-items-center justify-content-between d-flex">
                <div class="col-md-12 col-lg-6">
                    <div class="cta-content-wrap text-white">
                        <h2 class="text-white">24/7 Support </h2>
                    </div>
                    <div class="support-action d-inline-flex flex-wrap">
                        <a href="https://unitychan.nl/contact.php" class="mr-3"><i class="fas fa-comment mr-1 color-accent"></i> <span>Email Us</span></a>
                        <a href="tel:+16473629036" class="mb-0"><i class="fas fa-sms color-accent"></i> <span>Text: +00123456789</span></a>
                        <a href="https://t.me/choiceiptv" class="mb-0"><i class="fab fa-telegram color-accent"></i> <span>Telegram</span></a>
						
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-md-6 col-lg-4 hidden-md hidden-sm hidden-xs">
                    <div class="cta-img-wrap text-center">
                        <img src="templates/{$template}/img/call-center-support.svg" width="250" class="img-fluid" alt="server room">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--call to action section end-->

    <!--testimonial and review section start-->
 <!--   <section class="client-review-section ptb-100 gray-light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12">
                    <div class="section-heading-center text-center">
                        <h2>What Our Customers Say About Us?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="single-testimonial white-bg rounded">
                        <ul class="list-inline ratting-list">
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                        </ul>
                        <div class="ratting-content">
                            <h5>Awesome technical support</h5>
                            <p>Objectively envisioneer magnetic manufactured products and dynamic models. Progressively maximize 2.0 relationships  methodologies.</p>
                        </div>
                        <div class="ratting-author">
                            <h6>Alex Khamer</h6>
                            <small class="text-right">6 days ago</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="single-testimonial white-bg rounded">
                        <ul class="list-inline ratting-list">
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                        </ul>
                        <div class="ratting-content">
                            <h5>Pleasant support experience</h5>
                            <p>Objectively envisioneer magnetic manufactured products and dynamic models.Conveniently re-engineer tactical methodologies via inexpensive.</p>
                        </div>
                        <div class="ratting-author">
                            <h6>Peter Anderson</h6>
                            <small class="text-right">3 days ago</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="single-testimonial white-bg rounded">
                       <ul class="list-inline ratting-list">
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                            <li class="list-inline-item"><span class="fas fa-star"></span></li>
                        </ul>
                        <div class="ratting-content">
                            <h5>Contacted support Midnight</h5>
                            <p>Objectively envisioneer magnetic manufactured products and dynamic models. Globally mesh sustainable scenarios via real-time  deploy stand-alone.</p>
                        </div>
                        <div class="ratting-author">
                            <h6>Jolio Darix</h6>
                            <small class="text-right">8 days ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	-->
    <!--testimonial and review section end-->
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
	// Get the modal

	var modalparent = document.getElementsByClassName("modal_multi");

	// Get the button that opens the modal

	var modal_btn_multi = document.getElementsByClassName("myBtn_multi");

	// Get the <span> element that closes the modal
	var span_close_multi = document.getElementsByClassName("close_multi");

	// When the user clicks the button, open the modal
	function setDataIndex() {

		for (i = 0; i < modal_btn_multi.length; i++)
		{
			modal_btn_multi[i].setAttribute('data-index', i);
			modalparent[i].setAttribute('data-index', i);
			span_close_multi[i].setAttribute('data-index', i);
		}
	}



	for (i = 0; i < modal_btn_multi.length; i++)
	{
		modal_btn_multi[i].onclick = function() {
			var ElementIndex = this.getAttribute('data-index');
			modalparent[ElementIndex].style.display = "block";
		};

		// When the user clicks on <span> (x), close the modal
		span_close_multi[i].onclick = function() {
			var ElementIndex = this.getAttribute('data-index');
			modalparent[ElementIndex].style.display = "none";
		};

	}

	window.onload = function() {

		setDataIndex();
	};

	window.onclick = function(event) {
		if (event.target === modalparent[event.target.getAttribute('data-index')]) {
			modalparent[event.target.getAttribute('data-index')].style.display = "none";
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