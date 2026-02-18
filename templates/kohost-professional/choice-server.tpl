<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!--build:css-->
        <link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/customfiles/assets/css/main.css"/>
        <!-- endbuild -->
		<!---<link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/css/custom.css"/>-->

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
                background: url({$WEB_ROOT}/templates/{$template}/customfiles/assets/img/tv-bg.png);
                background-position: center;
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
        
            .pill-nav-container {
                padding: 0 40px;
                overflow-x: hidden;
                position:relative;
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


            section#main-body {
                padding: 0;
            }
            section#main-body >  .container{
                width: 100%;
                padding: 0;
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

            .feature-section .row {
                display:flex;
            }
            .owl-carousel.owl-drag .owl-item.active {
                background: transparent; 
            }
            .page-header-content h1 {
                margin-bottom: 0;
                font-size: 32px;
                font-weight: 300;
                margin-left: 0px;
                width: 100%;
                text-align:center;
            }
            .page-header-section .custom-breadcrumb {
                display: none;
            }
            .page-header-section .col-md-7.col-lg-6 {
                width: 100% !important;
                max-width: 100% !important;
            }

			/* ----------------------------- */
			/* STATICNAV START */
			/* ----------------------------- */

			.sticky-nav {
				display:none;
				position: fixed;
				top: 60px;
				left: 0;

				background: #fff;
				z-index: 8;
				padding: 0 20px;

				width: 100%;
				overflow: hidden;
			}

			.sticky-nav ul {
				padding: 0 15px;
				overflow-x: auto;

				display: grid;
				grid-auto-flow: column;
				justify-items: center;
				grid-gap: 2rem;
				font-size: 14px;
				border-bottom: 1px solid #eee;
				justify-content: center;
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
            .sticky-nav ul li a.active {
                color: #0948b3;
                background-color: #fff;
            }
			.sticky-nav ul li.active {
				border-bottom: 2px solid #0069d9;
			}

			#accordion {
				max-height: 60vh;
				overflow-y: scroll;
			}

			/* ----------------------------- */
			/* STATICNAV END */
			/* ----------------------------- */

			/* MEDIA QUERIES */

            @media only screen and (max-width: 1135px){
                .tv {
                    top: -40px;          
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

				.sticky-nav {
					top: 73px;
				}
				.sticky-nav ul {
					font-size: 16px;
				}

                
                .pill-nav {
                    display: grid;
                    grid-auto-flow: column;
                    align-items: center;
                    overflow-x: scroll;
                }    
            }

            @media only screen and (max-width: 710px){
                .pill-nav-container .move-btn{
                    display: inline-block;
                }
            }
            @media only screen and (max-width: 650px){
                .feature-section .row {
                    flex-direction: column;
                    gap:2rem;
                }
                .feature-section .row .details {
                    order: 1;
                    padding-bottom: 10px;
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
					justify-content: stretch;

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
			.mr-lg-3, .mx-lg-3 {
			  margin-right: 1rem !important;
			  font-size: 12px;
			}
        </style>

    </head>

    <body style="overflow-x:hidden;">
	        <section class="sticky-nav">
				<nav>
					<ul>
						<li><a href="/cart.php?a=confproduct&i=0"> Free Trial</a></li>
						<li><a href="#apps"> Apps</a></li>
						<li><a href="#features">Features</a></li>
						<li><a href="#supported-devices">Supported Devices</a></li>
						<li><a href="#app-store">App Store</a></li>
						<li><a href="#channel-list">Channel List</a></li>
						<li><a href="#iptv-plans">Plans & Comparison</a></li>
						<li><a href="#reviews">Reviews</a></li>

					</ul>
				</nav>
			</section>

            <div class="tvvideo-container">
			    <div class="tvvideo-header">
				    <h3 class="tvvideo-heading" style="text-decoration: underline;-webkit-text-decoration-color:gray;text-decoration-color:gray">CHOOSE FROM 6 USER-FRIENDLY APPS</h3>
					<div class="pill-nav-container" id="top-pillNav-container">
						<button class="move-btn prev-btn"><</button>
							<div class="pill-nav" id="top-pillNav">
								<button class="first-btn active" data-id="tivimate">Tivimate</button>
								<button  data-id="xciptv">XCIPTV</button>
								<button  data-id="smarters">IPTV Smarters</button>
								<button  data-id="purple">Purple</button>
								<button  data-id="choice-xciptvmodern">XCIPTV Modern</button>
								<button class="last-btn" data-id="cinema">Cinema HD</button>
							</div>
						<button class="move-btn next-btn">></button>
					</div>
				</div>


                <div class="tv" id="top-tv">
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

        
        <div class="main">
            <!--hosting promo start-->
            <section class="promo-section" id="features">
                <!-- style="position:relative; top:-150px">-->

                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div
                                class="card hosting-promo border-0 rounded-custom p-4 mt-4 shadow"
                            >
                                <div class="card-body">
                                    <div
                                        class="hosting-promo-icon mb-3 d-flex center"
                                    >
                                        <span
                                            class="fas fa-tv icon-size-lg color-primary"
                                        ></span>
                                    </div>
                                    <div class="hosting-promo-content">
                                        <h5 class="h6 ">Live TV</h5>
                                        <p>
                                            Access over 5000+ premium VIP
                                            channels at affordable prices. Cut
                                            your cable service and start saving
                                            with the Choice Server

                                            </br ></br>
                                        </p>
                                        <a
                                            href="/index.php/store/choice-server-plans"
                                            
                                            class="small-text d-inline-flex align-items-center"
                                        >
                                            <span>See Plans</span>
                                            <i
                                                class="fad fa-arrow-right ml-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div
                                class="card hosting-promo border-0 rounded-custom p-4 mt-4 shadow"
                            >
                                <div class="card-body">
                                    <div
                                        class="hosting-promo-icon mb-3 d-flex  center"
                                    >
                                        <span
                                            class="fad fa-video icon-size-lg color-primary"
                                        ></span>
                                    </div>
                                    <div class="hosting-promo-content">
                                        <h5 class="h6 ">
                                            Movies & TV Series
                                        </h5>
                                        <p>
                                            Access over 15,000 movies and tv
                                            series, all on-demand. Everything
                                            from classics and blockbuster hits
                                            to cult favorites and new releases.
                                        </p>
                                        <a
                                            href="/index.php/store/choice-server-plans"
                                           
                                            class="small-text d-inline-flex align-items-center"
                                        >
                                            <span>See Plans</span>
                                            <i
                                                class="fad fa-arrow-right ml-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div
                                class="card hosting-promo border-0 rounded-custom p-4 mt-4 shadow"
                            >
                                <div class="card-body">
                                    <div
                                        class="hosting-promo-icon mb-3 d-flex  center"
                                    >
                                        <span
                                            class="fas fa-basketball-ball icon-size-lg color-primary"
                                        ></span>
                                    </div>
                                    <div class="hosting-promo-content">
                                        <h5 class="h6 ">
                                            Best HD Sports
                                        </h5>
                                        <p>
                                            Access all HD sports around the
                                            globe. From domestic sports such as
                                            the NFL, NBA, and MLB to
                                            international sports such as FIFA,
                                            NHL and PPV. No MORE BLACKOUTS
                                        </p>
                                        <a
                                            href="/index.php/store/choice-server-plans"
                                           
                                            class="small-text d-inline-flex align-items-center"
                                        >
                                            <span>See Plans</span>
                                            <i
                                                class="fad fa-arrow-right ml-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--hosting promo end-->

            <!--features section start-->
            <div class="feature-section ptb-100 gray-light-bg">
                <!--style="margin-top:-200px" >-->
                <div class="container">
                    <div
                        class="row align-items-center"
                        style="background-color: #e1e2e3;"
                    >
                        <div
                            class="col-md-5 col-lg-6  d-md-block d-lg-block"
                        >
                            <div class="feature-img-wrap text-center">
                                <img
                                    src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/tivimate_friends.jpg"
                                    class="img-fluid"
                                    alt="choice iptv subscriptioin"
                                />
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-6 details">
                            <div class="feature-content-wrap">
                                <h2>
                                    A Superior Live and on Demand TV Experience
                                </h2>
                                <p>
                                    Enjoy HD & 4K picture quality, and fast
                                    channel change. Watch thousands of movies
                                    and popular series on demand on any device.
                                </p>
                                <a
                                    href="/cart.php?gid=2"
                                    class="btn btn-outline-brand-01 mt-3"
                                    target="_blank"
                                    >Start Watching TV Now</a
                                >
                            </div>
                        </div>
                    </div>
						</br></br>
                    <div class="row align-items-center mt-5" >
                        <div class="col-md-7 col-lg-6 details">
                            <div
                                class="feature-content-wrap"
                            >
                                <h2>
                                    The Ultimate Experience for Sports
                                    Enthusiasts
                                </h2>
                                <p>
                                    Stream the greatest sports in the world. Get
                                    unlimited access to NFL, Premier League,
                                    UEFA Champions League, Carabao Cup,
                                    Matchroom Boxing, Six Nations, WTA Tennis,
                                    PDC Darts, and much more.
                                </p>
                                <a
                                    href="/cart.php?gid=2"
                                    class="btn btn-outline-brand-01 mt-3"
                                    target="_blank"
                                    >Start Watching Sports Now</a
                                >
                            </div>
                        </div>

                        <div
                            class="col-md-5 col-lg-6  d-md-block d-lg-block"
                        >
                            <div class="feature-img-wrap text-center">
                                <img
                                    src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/choiceserver1.jpg"
                                    class="img-fluid"
                                    alt="choice iptv subscriptioin"
                                />
                            </div>
                        </div>
                    </div>
						</br></br>
                    <div
                        class="row align-items-center mt-5"
                        style="background-color: #e1e2e3;">
                    
                        <div
                            class="col-md-5 col-lg-6  d-md-block d-lg-block">
                        
                            <div class="feature-img-wrap text-center">
                                <img
                                    src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/all_devices.jpg"
                                    class="img-fluid"
                                    alt="choice iptv subscriptioin"
                                />
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-6 details" id="supported-devices">
                            <div
                                class="feature-content-wrap" >
                           
                                <h2>Watch on any Device</h2>
                                <p>
                                    Choice TV gives you the flexibility to watch
                                    TV on more devices than any other provider.
                                    Enjoy amazing content on any of your mobile
                                    devices, computer or Smart TV, Google
                                    Chromecast, Android TV, Amazon Fire TV, or
                                    Apple TV.
                                </p>
                                <a
                                    href="/cart.php?gid=2"
                                    class="btn btn-outline-brand-01 mt-3"
                                    target="_blank"
                                    >Start Watching Movies Now</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		

            <!--features section end-->
			
<!--services section start-->
   {include file="$template/plans.tpl"}
		<!--channel list start-->
    <section class="ptb-55 primary-bg" style="margin-top:-40px">
    <br/>
			<h2 class="text-white" id="channel-list"><center>Choice Server Channel Lineup</center></h2>	
    <br/>
    </section>
<p style=" text-align: center;color:red;"><strong> Below lists are rough idea of channels. Channel lists may not always be 100% accurate and will change without notice.</strong> </p>

        {include file="$template/choice-channel-list.tpl"}

            
            <!--channel list end-->
          
            <!--call to action start-->
            <section class="ptb-60 primary-bg" id="app-store">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-12 col-lg-6 ">
                            <div class="cta-content-wrap text-white">
                                <h2 class="text-white">
                                    Convenient App Store <br />
                                    With All Our Apps
                                </h2>
                                <p>
                                    Conveniently access our all apps from centralized location by installing our app store.
									App store is compatible on Android and Firestick devices.
                                </p>
                            </div>
                            <div class="action-btns mt-4">
                                <a href="/cart.php?gid=2" class="btn btn-brand-03">
                                    Order Choice IPTV Now
                                </a>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6 text-center mt-4">
                                <p>
                                    <video
                                        autoplay
                                        muted
                                        loop
                                        class="tv2 tvVideo"
                                        id="myVideo-2"
                                        style="width:100%;height:100%;"
                                    >
                                        <source
                                            src="{$WEB_ROOT}/templates/{$template}/customfiles/assets/img/video/app-store.mp4"
                                            type="video/mp4"
                                        />
                                        Your browser does not support HTML5 video.
                                    </video>
                                </p>
                                <a
                                    href="https://rebrand.ly/choicestore"
                                    class="btn btn-brand-03"
                                >
                                    Download
                                </a>
                        </div>
                    </div>
                </div>
            </section>
            <!--call to action end-->

           
            
          

            <!--testimonial section start-->
            <div class="section-heading text-center">
			<br></br>
                <h2>What Our Client Say About Our Services</h2>
                <p>
                    We offer the one of the best iptv services. Our amazing client reviews are a testament to our iptv services.
                </p>
            </div>
			{include file="$template/trustpilot-reviews.tpl"}

<!-- End TrustBox widget -->

            </section>
            <!--testimonial section end-->
        </div>

        <!--scroll bottom to top button end-->
        <!--build:js-->
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
        <!--endbuild-->

    </body>

    

</html>
