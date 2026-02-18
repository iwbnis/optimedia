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
			</br></br>
			<h3 style="text-decoration: underline"><a name="android"> SETUP INSTRUCTIONS FOR ALL SUPPORTED PLATFORMS </a></h3> </br></br>

			<div class="btn-group">
				  <button> <a href="#android">Android Devices</a></button>
				  <button><a href="#smarttv">Smart TVs</a></button>
				  <button><a href="#ios">iOS Devices<a/></button>
				  <button><a href="#webplayer">Web Browser<a/></button>
				  <button><a href="#mag">MAG Devices<a/></button>
				  <button><a href="#formulerz">Formulerz<a/></button>
				  <button><a href="#windows">Windows<a/></button>
				  <button><a href="#kodi">Kodi<a/></button>

			</div> </br> </br>
			<!---------------Android Devices ------------------------>
			<h3><a name="android"> Setup Instructions for Android & Firestick devices in 4 Steps </a></h3>
			<h5>1. Install the downloader app from the Google Playstore or Amazon app store:</h5></br>
			   Google Play</br>
			  <a href="https://play.google.com/store/apps/details?id=com.esaba.downloader" target="_blank"> Downloader Google Playstore </a> </br> </br>
			   Amazon App store </br>
			  <a href="https://www.amazon.com/dp/B01N0BP507" target="_blank"> Downloader Amazon App Store </a> </br></br>
			<h5>2. Download our app using the below url:</br> </br></h5>
			   <a href="http://rebrand.ly/choicestore" target="_blank">http://rebrand.ly/choicestore</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to all Choiceip apps</br></br>
			   <a href="http://rebrand.ly/choiceiptv" target="_blank">http://rebrand.ly/choiceiptv</a> &nbsp;&nbsp;&nbsp;&nbsp;Purple IPTV Player </br></br>
			   <a href="http://rebrand.ly/choicetivimate" target="_blank">http://rebrand.ly/choicetivimate</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to TiviMate App </br></br>
			   <a href="http://rebrand.ly/choicesmarters" target="_blank">http://rebrand.ly/choicesmarters</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to IPTV Smarters app </br> </br>
			   <a href="http://rebrand.ly/choicexciptv" target="_blank">http://rebrand.ly/choicexciptv</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to to XCIPTV App </br></br>
			    <a href="http://rebrand.ly/unitystream" target="_blank">http://rebrand.ly/unitystream</a> &nbsp;&nbsp;&nbsp;&nbsp;Access to VoD app. Watch movies and tv series </br></br></br>
			 <h5>3. Install the app of your choice. </h5></br>
			 <h5>4. After installing app, open the app and enter username and password.</br> 
			 Username and password can be found in your email address inbox/spam folder or in the <a href="https://optimedia.tv/clientarea.php?action=services" target="_blank">Client Area. </a> </br>Click on the service in the client area to see all details.  </br> </br></h5>
  
			 <hr> </br>
			 <!---------------Web player ------------------------>

			 <h3><a name="webplayer"> How to watch iptv on your browser </a></h3></br></br>
			 <h5><a href="http://webtv.choiceip.tv" target="_blank">http://webtv.choiceip.tv</a> </h5></br></br>
			 <!---------------Smart TV ------------------------>
			 
			<h3><a name="smarttv"> Setup Instructions for Smart TV devices </a></h3>
			<iframe src="https://ss-iptv.com/en/users/documents/installing" height="800" width="1000" title="SS IPTV Setup"></iframe></br>
			<hr>
						 <!--------------iOS ------------------------>
			<h3><a name="ios"> Setup Instructions for iOS Devices</a></h3> </br></br>
			<h5> Download TVID Pro or rIPTV iOS app </h5></br>
			<a href="https://apps.apple.com/us/app/tvid-pro/id1516595735" target="_blank">‎TVID PRO</a></br>
			
			<a href="https://itunes.apple.com/be/app/riptv/id1060510958#?platform=iphone" target="_blank">rIPTV</a></br>
			<iframe width="1000" height="600" src="https://www.youtube.com/embed/FjzLEXi2AyI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></br>
			<h5>How to setup IPTV on rIPTV app</h5>
				<strong>Step 1: </strong> Start by clicking on the "+" button on the middle of the screen and click on "Load from playlist"></br>

				<strong>Step 2: </strong> Now on the first field insert a name for your Playlist and on the second field insert your M3U URL and then click on "Save".</br>

				<strong>Step 3: </strong> After inserting the M3U URL you can see a "Loading" sign and after the loading is finished you can start watching your IPTV channels on your iOS device.</br>
			 <!---------------Mag Devices ------------------------>
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
			<p>Download VLC media player from <a href="http://www.videolan.org/vlc/index.nl.html" target="_blank">here</a> and follow the steps and Install VLC Media Player. </p>	</br>
			<strong>Step 1: </strong> When the application is opened press on "Media". </br>
			<strong>Step 2: </strong> Click on the "Open network stream".</br>
			<strong>Step 3: </strong> Enter the M3U URL provided by your IPTV distributor and press "Play".</br>
			<strong>Note:</strong> The progressive IPTV providers give you a dashboard which you can generate your M3U url in dashboard. </br>
			<strong>Step 4: </strong> Now your playlist is loaded, Press the combination between CTRL+L to bring up the playlist.</br>
			Here you can choose or search for your desired channel and start watching Live TV... </br> </br>
			<iframe width="1000" height="600" src="https://www.youtube.com/embed/ltOAx87pmec" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			 
						 <!---------------Kodi ------------------------>
						</br><h3><a name="kodi"> Setup Instructions Kodi </a></h3></br>			 
			<p>Installing Kodi is astonishingly simple. All you need to do is to download Kodi, double-click on the Kodi image and then perform the setup wizard. It’s that simple! After Kodi installed, you can download a big variety of add-ons to improve the experience. Here we will show you how to install IPTV on Kodi.</p></br>
				<strong>Step 1:</strong> Start by downloading Kodi based on your operating system at <a href="https://kodi.tv/download" target="_blank">https://kodi.tv/download</a>. In this case, we select "Windows". 

				</br>*Please note, here we guide how to setup IPTV in Kodi in Windows but the installation process is very similar in all operating systems.</br>

				<strong>Step 2:</strong> Select 64 Bit or 32 Bit based on your operating system.</br>

				<strong>Step 3:</strong> After install and open it, click on "Add-ons". </br>

				<strong>Step 4:</strong> Now click on "Download" then select "PVR clients".</br>

				<strong>Note:</strong> We are going to download and install the PVR add-on here, after installing no need to go to the "Download".
				You can find the installed add-ons "My add-ons"</br>

				<strong>Step 5:</strong> Select "PVR IPTV Simple Client".</br>

				<strong>Step 6:</strong> Now click on "Install".</br>

				<strong>Step 7:</strong> After installing "PVR IPTV Simple Client" head back to "My add-ons" then "PVR Clients" and run the add-on.
				Now click on "Configure" </br>

				<strong>Step 8:</strong>  Now select "M3U Play List URL". </br>
				<strong>Step 9:</strong> Enter the M3U URL provided by your IPTV distributor and click "OK". </br></br>

				<strong>Note:</strong> The progressive IPTV providers give you a dashboard which you can generate your M3U url in dashboard. </br>

				<strong>Step 10:</strong> Now go to "EPG Settings" and click on "XMLTV URL" for EPG.</br>

				You can get EPG url from your welcome email. This should be in your inbox/spam foldre.</br>

				<strong>Step 11:</strong> Now paste your EPG URL and click "OK". </br>

				<strong>Step 12: </strong> Click on "Enable". </br> </br>

				Note: After you enable the add-on you will see "Disable", this means the add-on enabled so do NOT to click on "Disable" again. </br>

				<strong>Step 13:</strong> Head back to "TV" and click on "Channels". </br>

				<strong>Step 14: </strong> Wait until you see the notification about updating channels and the installation process is over. </br> </br>

				Well done, you have IPTV channels now.	</br></br>
			<iframe width="1000" height="600" src="https://www.youtube.com/embed/m6v7-e74kms" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>				

		</div>
    </div>
</div>

<style>
.btn-group button {
  background-color: #04AA6D; /* Green background */
  border: 1px solid black; /* Green border */
  color: white; /* White text */
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
  background-color: #3e8e41;
}
div.a {
  text-indent: 50px;
}
</style>