{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">

    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>

        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">{$LANG.orderconfirmation}</h2>
            </div>

            {include file="orderforms/kohost_professional/sidebar-categories-collapsed.tpl"}

            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info order-confirmation">
                        <p>{$LANG.orderreceived} {$LANG.ordernumberis} <strong>{$ordernumber}</strong></p> 
                    </div>
                </div>
            </div>

            <div class="available-block gray-bg">
                <p>{$LANG.orderfinalinstructions}</p>
    
                {if $expressCheckoutInfo}
                    <div class="alert alert-info">
                        {$expressCheckoutInfo}
                    </div>
                {elseif $expressCheckoutError}
                    <div class="alert alert-danger">
                        {$expressCheckoutError}
                    </div>
                {elseif $invoiceid && !$ispaid}
                    <div class="alert alert-warning">
                        {$LANG.ordercompletebutnotpaid}
                        <a href="{$WEB_ROOT}/viewinvoice.php?id={$invoiceid}" target="_blank" class="alert-link">
                            {$LANG.invoicenumber}{$invoiceid}
                        </a>
                    </div>
                {/if}
    
                {foreach $addons_html as $addon_html}
                    <div class="order-confirmation-addon-output">
                        {$addon_html}
                    </div>
                {/foreach}
    
                {if $ispaid}
                    <!-- Enter any HTML code which should be displayed when a user has completed checkout here -->
                    <!-- Common uses of this include conversion and affiliate tracking scripts -->
                {/if}
    
               <a href="{$WEB_ROOT}/clientarea.php" class="btn primary-solid-btn">
                    {$LANG.orderForm.continueToClientArea}
                    &nbsp;<i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
			<h2 style="text-decoration: underline">CHECK SPAM FOLDER FOR IPTV LOGIN INFO</h2> </br></br>
			
			<p><span style="color: #ff0000;"><strong><span style="font-size: small;"><span style="color: #008000;">Introducing Choice Hub – your comprehensive solution for managing all your IPTV services and seamlessly downloading movies and TV series. Available now on the Google Play Store. Explore the video below to discover all the remarkable features. Download today for an enhanced entertainment experience.</span></span></strong></span></p>
		<p style=" text-align: center;"><video controls="controls" width="549" height="309" style="max-width: 100%;"><source src="https://www.dropbox.com/scl/fi/ol0k0gzdy8i70ns6tq5v4/choicehub4.mp4?rlkey=13vmttbobpbetmch9j2pav2ev&raw=1" type="video/mp4" /> Your browser does not support the video tag. </video></p>

			<h3 style="text-decoration: underline"><a name="android"> SETUP INSTRUCTIONS FOR ALL SUPPORTED PLATFORMS </a></h3> </br></br>

			<div class="btn-group" >
				  <button> <a href="#android-devices">Android/Firestick Devices</a></button>
				  <button><a href="#smarttv">Smart TVs</a></button>
				  <button><a href="#ios">iOS Devices<a/></button>
				  <button><a href="#webplayer">Web Browser<a/></button>
				  <button><a href="#roku">Roku<a/></button><br></br>
				  <button><a href="#mag">MAG Devices<a/></button>
				  <button><a href="#formulerz">Formulerz<a/></button>
				  <button><a href="#windows">Windows<a/></button>
				  <button><a href="#kodi">Kodi<a/></button>
				  <button><a href="#vpn">VPN Setup<a/></button>

			</div>			</br></br>
			<!------------------------------TV----------------------------->
			<!--
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
								<button class="last-btn" data-id="cinema">Unity Stream</button>
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
			
			-->
			<!---------------------end of tv-------------------------->
			
			
			
			
			
			</br></br>
 </br> </br>
			<!---------------Android Devices ------------------------>
			<h3><a id="android-devices"> Setup Instructions for Android & Firestick devices in 4 Steps </a></h3>
			<h5>1. Install the downloader app from the Google Playstore or Amazon app store:</h5></br>
			   Google Play</br>
			  <a href="https://play.google.com/store/apps/details?id=com.esaba.downloader" target="_blank"> Downloader Google Playstore </a> </br> </br>
			   Amazon App store </br>
			  <a href="https://www.amazon.com/dp/B01N0BP507" target="_blank"> Downloader Amazon App Store </a> </br></br>
			<h5>2. Download our app using the below url:</br> </br></h5>
			   <a href="http://apps.eztv.cx" target="_blank">apps.eztv.cx</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to app store</br></br>
			   <a href="http://edge.eztv.cx" target="_blank">edge.eztv.cx</a> &nbsp;&nbsp;&nbsp;&nbsp;Purple IPTV Player </br></br>
			   <a href="http://tivimate.eztv.cx" target="_blank">tivimate.eztv.cx</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to TiviMate App </br></br>
			   <a href="http://smarters.eztv.cx" target="_blank">smarters.eztv.cx</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to IPTV Smarters app </br> </br>
			   <a href="http://tvhub.eztv.cx" target="_blank">tvhub.eztv.cx</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to to XCIPTV App </br></br>
			    <a href="http://vod.eztv.cx" target="_blank">http://vod.eztv.cx</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to VoD app. Watch movies and tv series </br></br></br>
			 <h5>3. Install the app of your choice. </h5></br>
			 <h5>4. After installing app, open the app and enter username and password.</br> 
			 Username and password can be found in your email address inbox/spam folder or in the <a href="https://optimedia.tv/clientarea.php?action=services" target="_blank">Client Area. </a> </br>Click on the service in the client area to see all details.  </br> </br></h5>
  
			 <hr> </br>
			 <!---------------Web player ------------------------>

			 <h3><a name="webplayer"> How to watch iptv on your browser </a></h3></br></br>
			 <h5><a href="http://webtv.tel/" target="_blank">http://webtv.tel/</a> </h5></br></br>
			 <hr>
			 <!---------------Smart TV ------------------------>
			 
			<h3><a name="smarttv"> Setup Instructions for Smart TV devices </a></h3>

				<h5>FOLLOW THE STEPS BELOW TO INSTALL AND ADD APPS TO THE HOME SCREEN.</h5>

				<ol>
					<li>1. Press the Home button on your Smart Remote, then navigate to Apps.</li>
					<li>2. Then select the Search icon in the top-right corner.</li>
					<li>3. Enter the App Name “IPTV Smarters Pro” and Install it.</li>
					<li>4. Open the Application and Accept the “License Agreement”.</li>
					<li>5. Enter Your Playlist Details ( Username, Password, and Server URL).</li>
					<li>6. Once you enter your playlist, It will take you to the Dashboard. Enjoy IPTV Smarters App</li>
				</ol>
				</br></br>
				
				<h5>FOLLOW THE STEPS BELOW TO INSTALL SS-IPTV</h5>
			<p> <h5><a href="https://ss-iptv.com/en/users/documents/installing" target="_blank">Installation instructions for LG, Samsung, Philips and Sony Smart TVs</a> </h5></p></br>

<hr>
						 <!--------------iOS ------------------------>
						 
			<h3><a name="ios"> Setup Instructions for iOS Devices</a></h3> </br></br>
			<h5> Purple IPTV Player </h5>
			<p>Download Purple IPTV Player from:<a href="https://apps.apple.com/us/app/purple-playlist-player/id1547219704"target="_blank"> https://apps.apple.com/us/app/purple-playlist-player/id1547219704 </a> </p>
			<h5>Login with Code:</h5>
			<h4>10ZA8Q</h5></br></br>
			<p> Login with provided IPTV username and password.


			<h5> Download TVID Pro or rIPTV iOS app </h5></br>
			<a href="https://apps.apple.com/us/app/tvid-pro/id1516595735" target="_blank">‎TVID PRO</a></br>
			
			<a href="https://itunes.apple.com/be/app/riptv/id1060510958#?platform=iphone" target="_blank">rIPTV</a></br>
			<h5>How to setup IPTV on rIPTV app</h5>
				<strong>Step 1: </strong> Start by clicking on the "+" button on the middle of the screen and click on "Load from playlist"></br>

				<strong>Step 2: </strong> Now on the first field insert a name for your Playlist and on the second field insert your M3U URL and then click on "Save".</br>

				<strong>Step 3: </strong> After inserting the M3U URL you can see a "Loading" sign and after the loading is finished you can start watching your IPTV channels on your iOS device.</br>
			 
			 <!------------------------ROKU----------------------------->
			 <br>For ROku: 

			 <hr>
			 </br>
			 <h3><a name="roku"> Setup Instructions for Roku</a> </h3> </br></br>
			 <h5> Download Roku zip file: </h5>
			 <a href="https://tinyurl.com/rokutvpurple" target="_blank"> https://tinyurl.com/rokutvpurple</a></br>
			 <h5>User Guide Installation:</h5>
			 <a href=" https://developer.roku.com/en-gb/docs/developer-program/getting-started/developer-setup.md
			" target="_blank">  https://developer.roku.com/en-gb/docs/developer-program/getting-started/developer-setup.md</a></br>
			<h5> Login with Code: <strong>10ZA8Q </strong> </h5>
			 
			 
			 
			 <!---------------Mag Devices ------------------------>
			 <hr>
			</br><h3><a name="mag"> Setup Instructions for MAG Devices </a></h3></br>
			<strong>Step 1: </strong> When the box is being loaded the main portal screen appears. After that click on “settings”, press remote button “SETUP/SET”.</br>
			<strong>Step 2: </strong> Then press on “System settings” and click on “Servers”.	</br>	
			<strong>Step 3: </strong> Select “Portals”.</br>
	        <strong>Step 4: </strong> In the “Portal 1 name” line enter the following ” IPTV “.In the “Portal 1 URL” enter the portal address provided by your IPTV distributor. First, you must provide your device Mac address which can be found on the back side of your box to your IPTV distributor. <br>		
		    <strong>Step 5: </strong> When all the operations listed above is done, then press “OK”. When the settings are being saved click “EXIT” on the remote control and press option “General”. In the “NTP server,” line enter the following address “pool.ntp.org or us.pool.ntp.org“ for North America.	</br> 
			<strong>Step 6: </strong> Press “OK” to save the changes you made. When all the steps listed above are done press”EXIT” 2 times on the remote control and restart the portal. Now everything is ready to start watching Live TV... </br></br>

            <h5>Password for adult content</h5></br>
			The password for adult content on MAG is usually 0000 unless it is changed manually by the user.</br>
			 <!---------------FormulerZ Boxes ------------------------>
			 <hr>
			</br><h3><a name="formulerz"> Setup Instructions for FormulerZ Boxes </a></h3></br>
			<p>The FormulerZ Boxes have both Mac and ID, you can find the MAC address in the catalog of device or in the back of box. It is number like this MAC: 00:1E:B8:XX:XX:XX , to change it to box ID you need to replace 6 first digit  and make it like this ID: 00:1A:79:XX:XX:XX</p>
			</br> 
			<strong>Step 1: </strong> Start by downloading MyTVOnline app form the Google Play store and then open MYTV Online.</br>
			<strong>Step 2: </strong>  Now click on "Edit Service" and then click "Edit".</br>
			<strong>Note:</strong> Be sure you register with your right ID Address (Do not use the MAC address).
			Please note, this mac address must be given to your IPTV provider.
			Add the ID as MAG and use MAG portal.</br>
			<strong>Step 3: </strong> Enter "Service Nickname" (Example: MyIPTV) and click on "OK". </br>
			<strong>Step 4: </strong> Enter IPTV Server URL (STB MAG Emulator/ Portal URL) you get from your IPTV provider and click on "OK". You can ask for portal URL from your IPTV service provider. </br>
			<strong>Step 5: </strong> Enter Username and Password is NOT necessary.</br>
			<strong>Step 6: </strong> Click on "OK" and proceed to the next step. Please note, this might take a little time.</br>
			<strong>Step 7: </strong> Connecting to IPTV Server (with your registered data) is in progress now.</br>
			<strong>Step 8: </strong> Successful Connection! You receive all channels associated with your account.</br>
						 <!---------------Windows ------------------------>
			</br><h3><a name="windows"> Setup Instructions VLC Media Player  </a></h3></br>
			<hr>
			<p>Download VLC media player from <a href="http://www.videolan.org/vlc/index.nl.html" target="_blank">here</a> and follow the steps and Install VLC Media Player. </p>	</br>
			<strong>Step 1: </strong> When the application is opened press on "Media". </br>
			<strong>Step 2: </strong> Click on the "Open network stream".</br>
			<strong>Step 3: </strong> Enter the M3U URL provided by your IPTV distributor and press "Play".</br>
			<strong>Note:</strong> The progressive IPTV providers give you a dashboard which you can generate your M3U url in dashboard. </br>
			<strong>Step 4: </strong> Now your playlist is loaded, Press the combination between CTRL+L to bring up the playlist.</br>
			Here you can choose or search for your desired channel and start watching Live TV... </br> </br>
			 <hr>
						 <!---------------Kodi ------------------------>
						</br><h3><a name="kodi"> Setup Instructions Kodi </a></h3></br>	
				<strong>There are 2 IPTV players for Kodi, TVHub IPTV Simple and TVHub player. Instructions for both are below:</strong>			
			<h2><span style="text-decoration: underline;"><em><span style="font-size: 16px;"><strong>TVHub IPTV Simple Client Setup</strong></span></em></span></h2>
			<p><em><span style="font-size: 16px;"><strong><span style="font-size: 12pt;">1. Enable unknown sources</span></strong></span></em></p>
			<p style="color: #626262;"><video controls="controls" width="549" height="309" style="max-width: 100%;">
			<source src="https://www.dropbox.com/scl/fi/s63bfrpkypzhun1b9d8pb/unknown-sources.mp4?rlkey=dl4pc2p3n3bxhpsv75o7kxo34&amp;dl&amp;raw=1" /></video></p>
			<p><span style="font-size: 12pt;"><strong>2. Install our repository by entering the following url: </strong></span></p>
			<p><span style="font-size: 12pt;"><strong><a href="https://repo.panel1.xyz/tvhub">https://repo.panel1.xyz/tvhub</a></strong></span></p>
			<p><video controls="controls" width="549" height="309" style="max-width: 100%;">
			<source src="https://www.dropbox.com/scl/fi/9wvt8ofd5uhmhb6epcztc/tvhub-repo.mp4?rlkey=zisxj4cew3zi2wgvdmzv03vya&amp;dl&amp;raw=1" /></video></p>
			<p><span style="font-size: 12pt;"><strong>3. Install Addons (Install all addons)</strong></span></p>
			<ol>
			<li><strong><span style="font-size: 12pt;">Install <em>"TVHub IPTV Simple Login"</em> Addon</span></strong></li>
			<li><span style="font-size: 12pt;"><strong>Install <em>"IPTV Simple Reset"</em> Addon</strong></span></li>
			<li><span style="font-size: 12pt;"><strong>Install <em>"TVHub Player"</em> Addon</strong></span></li>
			</ol>
			<p><video controls="controls" width="549" height="309" style="max-width: 100%;">
			<source src="https://www.dropbox.com/scl/fi/wxt91ocssennzi54h45i4/install-addons.mp4?rlkey=p6z8ryf0duqefb6byfonv9tp6&amp;dl&amp;raw=1" /></video></p>
			<p> </p>
			<p><span style="font-size: 12pt;"><strong>4. WATCHING TV WITH IPTV SIMPLE PLAYER</strong></span></p>
			<p><span style="font-size: 12pt;"><strong>LOG INTO IPTV SIMPLE</strong></span></p>
			<ol>
			<li><span style="font-size: 16px;"><strong>Close and re-open Kodi</strong></span></li>
			<li><span style="font-size: 16px;"><strong>Select "Edge" Server</strong></span></li>
			<li><span style="font-size: 16px;"><strong>Enter your username and password</strong></span></li>
			</ol>
			<p><video controls="controls" width="549" height="309" style="max-width: 100%;" data-mce-fragment="1">
			<source src="https://www.dropbox.com/scl/fi/w83zvhak4j6c8dntbcwnd/iptv-simple-lgoin.mp4?rlkey=g5589gj0awli32cerhiy2yd97&amp;dl&amp;raw=1" /></video></p>
			<p> </p>			
						
						<h2><span style="text-decoration: underline;"><em><span style="font-size: 16px;"><strong>TVHub IPTV Simple Client Setup</strong></span></em></span></h2>
			<p><em><span style="font-size: 16px;"><strong><span style="font-size: 12pt;">1. Enable unknown sources</span></strong></span></em></p>
			<p style="color: #626262;"><video controls="controls" width="549" height="309" style="max-width: 100%;" data-mce-fragment="1">
			<source src="https://www.dropbox.com/scl/fi/s63bfrpkypzhun1b9d8pb/unknown-sources.mp4?rlkey=dl4pc2p3n3bxhpsv75o7kxo34&amp;dl&amp;raw=1" /></video></p>
			<p><span style="font-size: 12pt;"><strong>2. Install our repository by entering the following url: </strong></span></p>
			<p><span style="font-size: 12pt;"><strong><a href="https://repo.panel1.xyz/tvhub">https://repo.panel1.xyz/tvhub</a></strong></span></p>
			<p><video controls="controls" width="549" height="309" style="max-width: 100%;" data-mce-fragment="1">
			<source src="https://www.dropbox.com/scl/fi/9wvt8ofd5uhmhb6epcztc/tvhub-repo.mp4?rlkey=zisxj4cew3zi2wgvdmzv03vya&amp;dl&amp;raw=1" /></video></p>
			<p><span style="font-size: 12pt;"><strong>3. Install Addons (Install all addons)</strong></span></p>
			<ol>
			<li><strong><span style="font-size: 12pt;">Install <em>"TVHub IPTV Simple Login"</em> Addon</span></strong></li>
			<li><span style="font-size: 12pt;"><strong>Install <em>"IPTV Simple Reset"</em> Addon</strong></span></li>
			<li><span style="font-size: 12pt;"><strong>Install <em>"TVHub Player"</em> Addon</strong></span></li>
			</ol>
			<p><video controls="controls" width="549" height="309" style="max-width: 100%;" data-mce-fragment="1">
			<source src="https://www.dropbox.com/scl/fi/wxt91ocssennzi54h45i4/install-addons.mp4?rlkey=p6z8ryf0duqefb6byfonv9tp6&amp;dl&amp;raw=1" /></video></p>
			<p> </p>
			<p><span style="font-size: 12pt;"><strong>4. WATCHING TV WITH TVHUB PLAYER</strong></span></p>
			<p><span style="font-size: 12pt;"><strong>LOG INTO TVHub Player</strong></span></p>
			<ol>
			<li><span style="font-size: 16px;"><strong>Open the TVHub video add. Watch the video to learn how. </strong></span></li>
			<li><span style="font-size: 16px;"><strong>Login with your IPTV credentials</strong></span></li>
			<li><span style="font-size: 16px;"><strong>Select same settings as in the video. </strong></span></li>
			</ol>
			<p><video controls="controls" width="549" height="309" style="max-width: 100%;" data-mce-fragment="1">
			<source src="https://www.dropbox.com/scl/fi/309hfx808tdsl5so80ooy/tvhub-addon2.mp4?rlkey=hul2tt85spq9diszmqdfbzn84&amp;dl&amp;raw=1" /></video></p>
		</div>
    </div>
</div>

<style>
.btn-group button {
  background-color: #000000; /* Green background */
  border: 1px solid white; /* Green border */
  color: #ffffff; /* White text */
  padding: 10px 24px; /* Some padding */
  cursor: pointer; /* Pointer/hand icon */
  float: left; /* Float the buttons side by side */
}

/* Clear floats (clearfix hack) */
.btn-group:after {
  content: "";
  clear: both;
  display: table;
}

.btn-group button:not(:last-child) {
  border-right: none; /* Prevent double borders */
}

/* Add a background color on hover */
.btn-group button:hover {
  background-color: #ffffff;
}
div.a {
  text-indent: 50px;
}
</style>