<div class="client-dashboard-area hostx-client-dashboard">
{include file="$template/includes/flashmessage.tpl"}
<div class="services_list">
	<div class="row"><div class="col-sm-12"><div class="dasboard-home"><h1>{$LANG.mydashboard}</h1></div></div></div>
	{if $marketConnectPromosData && !empty($addons_html)}
	<div class="row mrkt-upr-row">
		<div class="col-sm-9">
			<div class="gridster-item">
				<div class="dashboard-widget-max">
					<div class="alladmintextHeader hoverbggray">
						<div class="widgetLabel">
							<h2 class="widgetTitle" id="home-promo-widget-title"></h2>
						</div>
					</div>
					<div class="body-promo-bnr">
						<div class="row">
						{if $marketConnectPromosData.symantec eq '1' || $marketConnectPromosData.spamexperts  eq '1' || $marketConnectPromosData.xovinow   eq '1' || $marketConnectPromosData.sitebuilder eq '1' || $marketConnectPromosData.weebly  eq '1' || $marketConnectPromosData.ox  eq '1'}
						<div class="col-md-6" id="left-side-promo-div">
							{if $marketConnectPromosData.symantec eq '1'}
							<div class="promo-cont-block w-hidden" id="ssl-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/ssl/{$layoutStyle}/ssl.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="rapidSslTitle"></a>
									<div id="rapidSslDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.spamexperts eq '1'}
							<div class="promo-cont-block w-hidden" id="spamexpert-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/spamexperts/{$layoutStyle}/spamexpert.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="spamexpertTitle"></a>
									<div id="spamexpertDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.xovinow eq '1'}
							<div class="promo-cont-block w-hidden" id="xovinow-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/xovinow/{$layoutStyle}/xovinow.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="xovinowTitle"></a>
									<div id="xovinowDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.sitebuilder eq '1'}
							<div class="promo-cont-block w-hidden" id="sitebuilder-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/sitebuilder/{$layoutStyle}/sitebuilder.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="sitebuilderTitle"></a>
									<div id="sitebuilderDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.weebly  eq '1'}
							<div class="promo-cont-block w-hidden" id="weebly-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/weebly/{$layoutStyle}/weebly.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="weeblyTitle"></a>
									<div id="weeblyDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.ox eq '1'}
							<div class="promo-cont-block w-hidden" id="ox-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/ox/{$layoutStyle}/ox.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="oxTitle"></a>
									<div id="oxDescp"></div>
								</div>
							</div>
							{/if}
						</div>
						{/if}
						{if $marketConnectPromosData.sitelock eq '1' || $marketConnectPromosData.codeguard  eq '1' || $marketConnectPromosData.marketgoo   eq '1' || $marketConnectPromosData.threesixtymonitoring  eq '1' || $marketConnectPromosData.nordvpn eq '1'}
						<div class="col-md-6" id="right-side-promo-div">
							{if $marketConnectPromosData.codeguard   eq '1'}
							<div class="promo-cont-block w-hidden" id="codeguard-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/codeguard/{$layoutStyle}/codeguard.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="codeguardTitle"></a>
									<div id="codeguardDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.marketgoo eq '1'}
							<div class="promo-cont-block w-hidden" id="marketgo-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/marketgoo/{$layoutStyle}/marketgoo.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="marketgooTitle"></a>
									<div id="marketgooDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.nordvpn eq '1'}
							<div class="promo-cont-block w-hidden" id="nordvpn-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/nordvpn/{$layoutStyle}/nordvpn.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="nordvpnTitle"></a>
									<div id="nordvpnDescp"></div>
								</div>
							</div>
							{/if}

							{if $marketConnectPromosData.sitelock eq '1'}
							<div class="promo-cont-block w-hidden" id="sitelock-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/sitelock/{$layoutStyle}/sitelock.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="sitelockTitle"></a>
									<div id="sitelockDescp"></div>		
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.sitelockvpn eq '1'}
							<div class="promo-cont-block w-hidden" id="sitelockvpn-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/sitelockvpn/{$layoutStyle}/sitelockvpn.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="sitelockvpnTitle"></a>
									<div id="sitelockvpnDescp"></div>
								</div>
							</div>
							{/if}
							{if $marketConnectPromosData.threesixtymonitoring eq '1'}
							<div class="promo-cont-block w-hidden" id="threesixtymonitoring-promo-blk">
								<div class="pcb-icon">
									<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/marketconnect/threesixtymonitoring/{$layoutStyle}/threesixtymonitoring.png">
								</div>
								<div class="promo-cont-inner">
									<a href="" id="threesixtymonitoringTitle"></a>
									<div id="threesixtymonitoringDescp"></div>
								</div>
							</div>
							{/if}
						</div>
						{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="gridster-item">
				<div class="dashboard-widget-max order-div-mx">
					<div class="alladmintextHeader hoverbggray">
						<div class="widgetLabel">
							<h2 class="widgetTitle">{$LANG.ordertitle}</h2>
						</div>
					</div>
					<div class="body-promo-bnr-ord-right">
						<div class="promo-cont-block-img">
							<img src="{$WEB_ROOT}/templates/{$hostx_theme_settings.template_name_custom}/images/{$layoutStyle}/cart-order-home.png">
						</div>
						<p>{$LANG.addnewproducttitle}</p>
					</div>
					<p class="bottom-buttom">
						<a href="{$WEB_ROOT}/cart.php">{$LANG.navservicesorder}</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	{/if}
	<div class="row ent-dash-widget-row">
	    <div class="col-sm-3">
			<div class="gridster-item">
				<div class="dashboard-widget">
					<div class="alladmintextHeader hoverbggray">
						<div class="widgetLabel">
							<h2 class="widgetTitle">{$LANG.navservices}</h2>
						</div>
					</div>
					<div class="widgetBody alladmintext">
						<h3 class="boxttl">{$clientsstats.productsnumactive} {$LANG.activeservicetitle}</h3>
						<p>{$LANG.activeservicedesc}</p>
					</div>
					<p class="bottom-buttom">
						<a href="clientarea.php?action=services">{$LANG.clientareanavservices} </a>
						<a href="cart.php">{$LANG.navservicesorder}</a>
					</p>
				</div>
			</div>
	    </div>
	   {if $clientsstats.numdomains || $registerdomainenabled || $transferdomainenabled}
			<div class="col-sm-3">
				<div class="gridster-item">
					<div class="dashboard-widget">
						<div class="alladmintextHeader hoverbggray">
							<div class="widgetLabel">
								<h2 class="widgetTitle">{$LANG.navdomains}</h2>
							</div>
						</div>
						<div class="widgetBody alladmintext">
							<h3 class="boxttl">{$clientsstats.numactivedomains} {$LANG.activedomiantitle}</h3>
							<p>{$LANG.activedomiandesc}</p>
						</div>
						<p class="bottom-buttom">
							<a href="clientarea.php?action=domains">{$LANG.mydomaintitle}</a>
							<a href="domainchecker.php">{$LANG.registernewdomain}</a>
						</p>
					</div>
				</div>
			</div>
	   {elseif $condlinks.affiliates && $clientsstats.isAffiliate}
			<div class="col-sm-3">
				<div class="gridster-item">
					<div class="dashboard-widget">
						<div class="alladmintextHeader hoverbggray">
							<div class="widgetLabel">
								<h2 class="widgetTitle">{$LANG.affiliatessignups}</h2>
							</div>
						</div>
						<div class="widgetBody alladmintext">
							<h3 class="boxttl">{$clientsstats.numactivedomains}</h3>
							<p>{$LANG.affilatedescription}</p>
						</div>
						<p class="bottom-buttom">
							<a href="affiliates.php">{$LANG.myaffilates}</a>
						</p>
					</div>
				</div>
			</div>
		{else}
			<div class="col-sm-3">
				<div class="gridster-item">
					<div class="dashboard-widget">
						<div class="alladmintextHeader hoverbggray">
							<div class="widgetLabel">
								<h2 class="widgetTitle">{$LANG.quotes}</h2>
							</div>
						</div>
						<div class="widgetBody alladmintext">
							<h3 class="boxttl">{$clientsstats.numquotes} {$LANG.activquotes}</h3>
							<p>{$LANG.myquotesdescp}</p>
						</div>
						<p class="bottom-buttom">
							<a href="clientarea.php?action=quotes">{$LANG.myquotes}</a>
						</p>
					</div>
				</div>
			</div>
		{/if}
	    <div class="col-sm-3">
			<div class="gridster-item">
				<div class="dashboard-widget">
					<div class="alladmintextHeader hoverbggray">
						<div class="widgetLabel">
							<h2 class="widgetTitle">{$LANG.navtickets}</h2>
						</div>
					</div>
					<div class="widgetBody alladmintext">
						<h3 class="boxttl">{$clientsstats.numactivetickets} {$LANG.opentickettitle}</h3>
						<p>{$LANG.openticketdesc}</p>
					</div>
					<p class="bottom-buttom">
						<a href="supporttickets.php">{$LANG.mytickets}</a>
						<a href="submitticket.php">{$LANG.navopenticket}</a>
					</p>
				</div>
			</div>
	    </div>
	    <div class="col-sm-3">
			<div class="gridster-item">
				<div class="dashboard-widget">
					<div class="alladmintextHeader hoverbggray">
						<div class="widgetLabel">
							<h2 class="widgetTitle">{$LANG.navinvoices}</h2>
						</div>
					</div>
					<div class="widgetBody alladmintext">
						<h3 class="boxttl">{$clientsstats.numunpaidinvoices} {$LANG.unpaidinvoicetitle}</h3>
						<p>{$LANG.unpaidinvoicedesc}</p>
					</div>
					<p class="bottom-buttom">
						<a href="clientarea.php?action=invoices">{$LANG.invoices}</a>
						<a href="clientarea.php?action=masspay&all=true">{$LANG.masspayall}</a>
					</p>
				</div>
			</div>
	    </div>
	</div>
</div>
<div class="support_tickets wgs-margin-top-zero">
		<div class="home-promo-product">
		{foreach from=$addons_html item=addon_html}
			<div>
				{$addon_html}
			</div>
		{/foreach}
		</div>

		{if $captchaError}
			<div class="alert alert-danger">
				{$captchaError}
			</div>
		{/if}

	 <div class="row">
	   <div class="col-sm-6">
			{function name=outputHomePanels}
			{if $item->getName() neq 'Register a New Domain'}
				<div menuItemName="{$item->getName()}" class="home-panel-summary {if $item->getName() eq 'Recent News'}support_tickets_col wgs-recen{else}support_tickets_col {$item->getName()|truncate:5:'':true|lower}{/if}" {if $item->getAttribute('id')} id="{$item->getAttribute('id')}"{/if}>
					<div class="inner-body-home-panel">
						<div class="panel-head-home">
							<div class="wid-level">
								<h3 class="panel-title">
									{if $item->getExtra('btn-link') && $item->getExtra('btn-text')}
										<div class="pull-right wgs-a-btn">
											<a href="{$item->getExtra('btn-link')}">
												{if $item->getExtra('btn-icon')}{/if}
												{$item->getExtra('btn-text')}
											</a>
										</div>
									{/if}
									{$item->getLabel()}
									{if $item->hasBadge()}&nbsp;<span class="badge">{$item->getBadge()}</span>{/if}
								</h3>
							</div>
						</div>
						{if $item->hasBodyHtml()}
							<div class="panel-body">
								{$item->getBodyHtml()}
							</div>
						{/if}
						{if $item->hasChildren()}
							<div class="list-group{if $item->getChildrenAttribute('class')} {$item->getChildrenAttribute('class')}{/if}">
								{foreach $item->getChildren() as $childItem}
									{if $childItem->getUri()}
										<a menuItemName="{$childItem->getName()}" href="{$childItem->getUri()}" class="list-group-item{if $childItem->getClass()} {$childItem->getClass()}{/if}{if $childItem->isCurrent()} active{/if}"{if $childItem->getAttribute('dataToggleTab')} data-toggle="tab"{/if}{if $childItem->getAttribute('target')} target="{$childItem->getAttribute('target')}"{/if} id="{$childItem->getId()}">
											{if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>&nbsp;{/if}
											{$childItem->getLabel()}
											{if $childItem->hasBadge()}&nbsp;<span class="badge">{$childItem->getBadge()}</span>{/if}
										</a>
									{else}
										<div menuItemName="{$childItem->getName()}" class="list-group-item{if $childItem->getClass()} {$childItem->getClass()}{/if}" id="{$childItem->getId()}">
											{if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>&nbsp;{/if}
											{$childItem->getLabel()}
											{if $childItem->hasBadge()}&nbsp;<span class="badge">{$childItem->getBadge()}</span>{/if}
										</div>
									{/if}
								{/foreach}
							</div>
						{/if}
						<div class="col-sm-12">
							{if $item->hasFooterHtml()}
								{$item->getFooterHtml()}
							{/if}
						</div>
					</div>
				</div>
			{/if} 
			{/function}
			{foreach $panels as $item}
                {if $item->getExtra('colspan')}
                    {outputHomePanels}
                    {assign "panels" $panels->removeChild($item->getName())}
                {/if}
            {/foreach}
			
			{foreach $panels as $item}
				{if $item@iteration is odd}
					{outputHomePanels}
				{/if}
			{/foreach}
	   </div>
	   <div class="col-sm-6">
			{foreach $panels as $item}
				{if $item@iteration is even}
					{outputHomePanels}
				{/if}
			{/foreach}
	   </div>
	 </div>
</div>	
</div>
<script>
    function homePagePromoProducts(){
        /**
             * Market connect promo functionality 
             */
        if(jQuery(".home-promo-product").length > 0){
            jQuery("#home-promo-widget-title").html(jQuery(".home-promo-product").find("h3").eq(0).html());		
        }
        var leftDiv = false;
        var rightDiv = false;
        if(jQuery(".promo-banner.symantec").length > 0){
            leftDiv = true;
            jQuery("#ssl-promo-blk").removeClass("w-hidden");
            jQuery("#rapidSslTitle").html(jQuery(".promo-banner.symantec").find(".card-body").find(".content").find("h3").html());
            jQuery("#rapidSslTitle").attr("href",jQuery(".promo-banner.symantec").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#rapidSslDescp").html(jQuery(".promo-banner.symantec").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.spamexperts").length > 0){
            leftDiv = true;
            jQuery("#spamexpert-promo-blk").removeClass("w-hidden");
            jQuery("#spamexpertTitle").html(jQuery(".promo-banner.spamexperts").find(".card-body").find(".content").find("h3").html());
            jQuery("#spamexpertTitle").attr("href",jQuery(".promo-banner.spamexperts").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#spamexpertDescp").html(jQuery(".promo-banner.spamexperts").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.xovinow").length > 0){
            leftDiv = true;
            jQuery("#xovinow-promo-blk").removeClass("w-hidden");
            jQuery("#xovinowTitle").html(jQuery(".promo-banner.xovinow").find(".card-body").find(".content").find("h3").html());
            jQuery("#xovinowTitle").attr("href",jQuery(".promo-banner.xovinow").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#xovinowDescp").html(jQuery(".promo-banner.xovinow").find(".card-body").find(".content").find("h4").html());
        }
		if(jQuery(".promo-banner.sitebuilder").length > 0){
            leftDiv = true;
            jQuery("#sitebuilder-promo-blk").removeClass("w-hidden");
            jQuery("#sitebuilderTitle").html(jQuery(".promo-banner.sitebuilder").find(".card-body").find(".content").find("h3").html());
            jQuery("#sitebuilderTitle").attr("href",jQuery(".promo-banner.sitebuilder").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#sitebuilderDescp").html(jQuery(".promo-banner.sitebuilder").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.weebly").length > 0){
            leftDiv = true;
            jQuery("#weebly-promo-blk").removeClass("w-hidden");
            jQuery("#weeblyTitle").html(jQuery(".promo-banner.weebly").find(".card-body").find(".content").find("h3").html());
            jQuery("#weeblyTitle").attr("href",jQuery(".promo-banner.weebly").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#weeblyDescp").html(jQuery(".promo-banner.weebly").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.ox").length > 0){
            leftDiv = true;
            jQuery("#ox-promo-blk").removeClass("w-hidden");
            jQuery("#oxTitle").html(jQuery(".promo-banner.ox").find(".card-body").find(".content").find("h3").html());
            jQuery("#oxTitle").attr("href",jQuery(".promo-banner.ox").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#oxDescp").html(jQuery(".promo-banner.ox").find(".card-body").find(".content").find("h4").html());
        }
		/*** Right Side Section ***/
		if(jQuery(".promo-banner.sitelock").length > 0){
            rightDiv = true;
            jQuery("#sitelock-promo-blk").removeClass("w-hidden");
            jQuery("#sitelockTitle").html(jQuery(".promo-banner.sitelock").find(".card-body").find(".content").find("h3").html());
            jQuery("#sitelockTitle").attr("href",jQuery(".promo-banner.sitelock").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#sitelockDescp").html(jQuery(".promo-banner.sitelock").find(".card-body").find(".content").find("h4").html());
        }		
        if(jQuery(".promo-banner.codeguard").length > 0){
            rightDiv = true;
            jQuery("#codeguard-promo-blk").removeClass("w-hidden");
            jQuery("#codeguardTitle").html(jQuery(".promo-banner.codeguard").find(".card-body").find(".content").find("h3").html());
            jQuery("#codeguardTitle").attr("href",jQuery(".promo-banner.codeguard").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#codeguardDescp").html(jQuery(".promo-banner.codeguard").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.marketgoo").length > 0){
            rightDiv = true;
            jQuery("#marketgo-promo-blk").removeClass("w-hidden");
            jQuery("#marketgooTitle").html(jQuery(".promo-banner.marketgoo").find(".card-body").find(".content").find("h3").html());
            jQuery("#marketgooTitle").attr("href",jQuery(".promo-banner.marketgoo").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#marketgooDescp").html(jQuery(".promo-banner.marketgoo").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.threesixtymonitoring").length > 0){
            rightDiv = true;
            jQuery("#threesixtymonitoring-promo-blk").removeClass("w-hidden");
            jQuery("#threesixtymonitoringTitle").html(jQuery(".promo-banner.threesixtymonitoring").find(".card-body").find(".content").find("h3").html());
            jQuery("#threesixtymonitoringTitle").attr("href",jQuery(".promo-banner.threesixtymonitoring").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#threesixtymonitoringDescp").html(jQuery(".promo-banner.threesixtymonitoring").find(".card-body").find(".content").find("h4").html());
        }
        if(jQuery(".promo-banner.nordvpn").length > 0){
            rightDiv = true;
            jQuery("#nordvpn-promo-blk").removeClass("w-hidden");
            jQuery("#nordvpnTitle").html(jQuery(".promo-banner.nordvpn").find(".card-body").find(".content").find("h3").html());
            jQuery("#nordvpnTitle").attr("href",jQuery(".promo-banner.nordvpn").find(".card-body").find(".content").find("h3").find("a").attr("href"));
            jQuery("#nordvpnDescp").html(jQuery(".promo-banner.nordvpn").find(".card-body").find(".content").find("h4").html());
        }
        if(!leftDiv){
            jQuery("#left-side-promo-div").addClass("w-hidden");
        }
        if(!rightDiv){
            jQuery("#right-side-promo-div").addClass("w-hidden");
        }
        var leftCount = -1;
        var rightCount = -1;
        if(!jQuery("#left-side-promo-div").hasClass("w-hidden")){
            leftCount = parseInt(4)-parseInt(jQuery("#left-side-promo-div").find(".w-hidden").length);
        }
        if(!jQuery("#right-side-promo-div").hasClass("w-hidden")){
            rightCount = parseInt(3)-parseInt(jQuery("#right-side-promo-div").find(".w-hidden").length);
        }
        if(leftCount > 0){
            if(leftCount > rightCount){
                jQuery(".order-div-mx").addClass("rows-"+leftCount);
            }else{
                jQuery(".order-div-mx").addClass("rows-"+rightCount);
            }
        }
        if(rightCount > 0){
            if(rightCount > leftCount){
                jQuery(".order-div-mx").addClass("rows-"+rightCount);	
            }else{
                jQuery(".order-div-mx").addClass("rows-"+leftCount);
            }
        }
    }
    homePagePromoProducts();
	var activeServiceDiv = jQuery(".support_tickets_col.activ").outerHeight();
	var recentNewsDiv = jQuery(".support_tickets_col.recen").outerHeight();
	var newsRecentDiv = jQuery(".support_tickets_col.wgs-recen").outerHeight();
	if(activeServiceDiv > 300){
		jQuery(".support_tickets_col.activ").addClass('sb-container');
		//jQuery(".sb-container").scrollBox();
	}
	if(recentNewsDiv > 300){
		jQuery(".support_tickets_col.recen").addClass('sb-container');
		//jQuery(".sb-container").scrollBox();
	}
	if(newsRecentDiv > 300){
		jQuery(".support_tickets_col.wgs-recen").addClass('sb-container');
		//jQuery(".sb-container").scrollBox();
	}
</script>

{literal}
<script>
(function() {
    'use strict';

    var cache = {};
    var manageCache = {};
    var activePanel = null;

    function init() {
        var serviceItems = document.querySelectorAll('.div-service-item[data-href*="productdetails"]');
        var listItems = document.querySelectorAll('.list-group-item[href*="productdetails"]');

        serviceItems.forEach(function(item) { setupItem(item, item.getAttribute('data-href')); });
        listItems.forEach(function(item) { setupItem(item, item.getAttribute('href')); });
    }

    function setupItem(item, href) {
        if (!href) return;
        var cleanHref = href.replace(/&amp;/g, '&');
        var match = cleanHref.match(/id=(\d+)/);
        if (!match) return;
        var serviceId = match[1];

        item.classList.add('ent-expandable-item');
        item.style.cursor = 'pointer';

        jQuery(item).off('click');

        var chevron = document.createElement('span');
        chevron.className = 'ent-expand-chevron fas fa-chevron-right';
        chevron.style.cssText = 'float:right; margin-top:2px; margin-left:10px;';
        item.appendChild(chevron);

        var panel = document.createElement('div');
        panel.className = 'ent-expand-panel';
        panel.setAttribute('data-service-id', serviceId);
        item.parentNode.insertBefore(panel, item.nextSibling);

        jQuery(item).on('click', function(e) {
            if (e.ctrlKey || e.metaKey || e.button === 1) return;
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            togglePanel(serviceId, panel, chevron, item, cleanHref);
            return false;
        });

        preloadManageData(serviceId, item, cleanHref);
    }

    function preloadManageData(serviceId, item, href) {
        var titleSpan = item.querySelector('.div-service-name .font-weight-bold');
        if (!titleSpan) titleSpan = item.querySelector('.font-weight-bold');

        var fetchUrl = href.replace(/&amp;/g, '&');
        if (fetchUrl.indexOf('http') !== 0 && fetchUrl.indexOf('/') !== 0) {
            fetchUrl = '/' + fetchUrl;
        }

        jQuery.ajax({
            url: fetchUrl,
            method: 'POST',
            data: { id: serviceId, customAction: 'manage' },
            dataType: 'html',
            timeout: 15000,
            success: function(html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var data = { username: '', password: '', fields: [] };

                var listItems = doc.querySelectorAll('.list-group-item');
                listItems.forEach(function(li) {
                    var text = li.textContent.trim();
                    var strong = li.querySelector('strong.text-domain');
                    var val = strong ? strong.textContent.trim() : '';

                    if (/username/i.test(text) && !/password/i.test(text)) {
                        data.username = val;
                    } else if (/password/i.test(text)) {
                        var showSpan = li.querySelector('#show');
                        if (showSpan) data.password = showSpan.textContent.trim();
                    } else if (/product/i.test(text) && /service/i.test(text)) {
                        data.productName = val;
                    } else if (val) {
                        var colonIdx = text.indexOf(':');
                        if (colonIdx > 0) {
                            var label = text.substring(0, colonIdx).trim();
                            if (label && !/product/i.test(label)) {
                                data.fields.push({ label: label, value: val });
                            }
                        }
                    }
                });

                if (!data.username) {
                    var detailRows = doc.querySelectorAll('.ent-detail-row');
                    detailRows.forEach(function(row) {
                        var label = row.querySelector('.ent-detail-label strong');
                        var value = row.querySelector('.ent-detail-value');
                        if (label && value && /username/i.test(label.textContent)) {
                            data.username = value.textContent.trim();
                        }
                    });
                }

                manageCache[serviceId] = data;

                if (data.username && titleSpan) {
                    titleSpan.innerHTML = '<span class="ent-service-username"><i class="fas fa-user"></i>' + escapeHtml(data.username) + '</span><br>' + titleSpan.innerHTML;
                }
            },
            error: function() {}
        });
    }

    function togglePanel(serviceId, panel, chevron, item, href) {
        if (panel.classList.contains('ent-expand-open')) {
            closePanel(panel, chevron, item);
            activePanel = null;
            return;
        }

        if (activePanel && activePanel.panel !== panel) {
            closePanel(activePanel.panel, activePanel.chevron, activePanel.item);
        }

        chevron.classList.add('ent-expand-chevron-open');
        item.classList.add('ent-expand-active');
        panel.classList.add('ent-expand-open');
        activePanel = { panel: panel, chevron: chevron, item: item };

        if (cache[serviceId]) {
            panel.innerHTML = cache[serviceId];
            bindPanelLinks(panel);
            return;
        }

        // Build panel from manage page data (already pre-fetched)
        var md = manageCache[serviceId];
        if (md) {
            var content = buildPanelHtml(md, serviceId, href);
            cache[serviceId] = content;
            panel.innerHTML = content;
            bindPanelLinks(panel);
            return;
        }

        // Fallback: show loading and fetch manage page
        panel.innerHTML = '<div class="ent-expand-loading"><i class="fas fa-spinner fa-spin"></i><span>Loading details...</span></div>';

        var fetchUrl = href.replace(/&amp;/g, '&');
        if (fetchUrl.indexOf('http') !== 0 && fetchUrl.indexOf('/') !== 0) {
            fetchUrl = '/' + fetchUrl;
        }

        jQuery.ajax({
            url: fetchUrl,
            method: 'POST',
            data: { id: serviceId, customAction: 'manage' },
            dataType: 'html',
            timeout: 15000,
            success: function(html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var data = { username: '', password: '', fields: [] };
                var listItems = doc.querySelectorAll('.list-group-item');
                listItems.forEach(function(li) {
                    var text = li.textContent.trim();
                    var strong = li.querySelector('strong.text-domain');
                    var val = strong ? strong.textContent.trim() : '';
                    if (/username/i.test(text) && !/password/i.test(text)) {
                        data.username = val;
                    } else if (/password/i.test(text)) {
                        var showSpan = li.querySelector('#show');
                        if (showSpan) data.password = showSpan.textContent.trim();
                    } else if (val) {
                        var colonIdx = text.indexOf(':');
                        if (colonIdx > 0) {
                            var label = text.substring(0, colonIdx).trim();
                            if (label && !/product/i.test(label)) {
                                data.fields.push({ label: label, value: val });
                            }
                        }
                    }
                });
                manageCache[serviceId] = data;
                var content = buildPanelHtml(data, serviceId, fetchUrl);
                cache[serviceId] = content;
                if (panel.classList.contains('ent-expand-open')) {
                    panel.innerHTML = content;
                    bindPanelLinks(panel);
                }
            },
            error: function() {
                var errorHtml = '<div class="ent-expand-error">' +
                    '<p>Could not load details.</p>' +
                    '<a href="' + fetchUrl + '" class="ent-expand-btn ent-expand-btn-primary">' +
                    '<i class="fas fa-external-link-alt"></i> Open Full Details</a></div>';
                if (panel.classList.contains('ent-expand-open')) {
                    panel.innerHTML = errorHtml;
                }
            }
        });
    }

    function buildPanelHtml(md, serviceId, detailsUrl) {
        var productName = md.productName || 'Service #' + serviceId;
        var username = md.username || '';
        var password = md.password || '';

        var h = '<div class="ent-expand-header">';
        h += '<div class="ent-expand-header-info">';
        h += '<div class="ent-expand-header-title">' + escapeHtml(productName) + '</div>';
        h += '</div>';
        h += '</div>';

        // Service details (username, password, extra fields)
        if (username || password || (md.fields && md.fields.length > 0)) {
            var pwId = 'pw-' + serviceId;
            h += '<div class="ent-expand-service-details">';
            if (username) {
                h += '<div class="ent-expand-detail-row">';
                h += '<span class="ent-expand-detail-label"><i class="fas fa-user"></i> Username :</span>';
                h += '<span class="ent-expand-detail-value">' + escapeHtml(username) + '</span>';
                h += '</div>';
            }
            if (password) {
                h += '<div class="ent-expand-detail-row">';
                h += '<span class="ent-expand-detail-label"><i class="fas fa-key"></i> Password :</span>';
                h += '<span class="ent-expand-detail-value">';
                h += '<span id="' + pwId + '-hide">********</span>';
                h += '<span id="' + pwId + '-show" style="display:none;">' + escapeHtml(password) + '</span>';
                h += ' <button type="button" class="ent-pw-toggle" data-hide="' + pwId + '-hide" data-show="' + pwId + '-show">Show</button>';
                h += '</span>';
                h += '</div>';
            }
            if (md.fields && md.fields.length > 0) {
                md.fields.forEach(function(f) {
                    // Skip bouquet field - render as button in actions instead
                    if (/bouquet/i.test(f.label)) return;
                    h += '<div class="ent-expand-detail-row">';
                    h += '<span class="ent-expand-detail-label">' + escapeHtml(f.label) + ' :</span>';
                    h += '<span class="ent-expand-detail-value">' + escapeHtml(f.value) + '</span>';
                    h += '</div>';
                });
            }
            h += '</div>';
        }

        h += '<div class="ent-expand-actions">';
        h += '<a href="' + escapeAttr(detailsUrl) + '" class="ent-expand-btn ent-expand-btn-primary" onclick="event.stopPropagation()">';
        h += '<i class="fas fa-eye"></i> View Full Details</a>';
        h += '<button type="button" class="ent-expand-btn ent-expand-btn-secondary ent-bouquet-btn" data-url="' + escapeAttr(detailsUrl) + '" data-serviceid="' + serviceId + '">';
        h += '<i class="fas fa-tv"></i> Edit Bouquets</button>';
        h += '</div>';
        return h;
    }

    function closePanel(panel, chevron, item) {
        panel.classList.remove('ent-expand-open');
        chevron.classList.remove('ent-expand-chevron-open');
        item.classList.remove('ent-expand-active');
    }

    function bindPanelLinks(panel) {
        panel.querySelectorAll('a').forEach(function(a) {
            a.addEventListener('click', function(e) { e.stopPropagation(); });
        });
        // Password show/hide toggle
        panel.querySelectorAll('.ent-pw-toggle').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var hideEl = document.getElementById(btn.getAttribute('data-hide'));
                var showEl = document.getElementById(btn.getAttribute('data-show'));
                if (hideEl && showEl) {
                    if (hideEl.style.display === 'none') {
                        hideEl.style.display = '';
                        showEl.style.display = 'none';
                        btn.textContent = 'Show';
                    } else {
                        hideEl.style.display = 'none';
                        showEl.style.display = '';
                        btn.textContent = 'Hide';
                    }
                }
            });
        });
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    function escapeAttr(str) {
        return str.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

// Edit Bouquets - open modal with channel categories
(function() {
    var bouquetData = {};
    var selectedBouquets = {};

    // Create modal HTML
    var modalHtml = '<div id="entBouquetOverlay" class="ent-bq-overlay" style="display:none;">'
        + '<div class="ent-bq-modal">'
        + '<div class="ent-bq-header">'
        + '<div class="ent-bq-header-title"><i class="fas fa-tv"></i> Channel Categories</div>'
        + '<button type="button" class="ent-bq-close" id="entBqClose">&times;</button>'
        + '</div>'
        + '<div class="ent-bq-body">'
        + '<div id="entBqLoading" class="ent-bq-loading"><div class="ent-bq-spinner"></div><p>Loading categories...</p></div>'
        + '<div id="entBqError" class="ent-bq-error" style="display:none;"></div>'
        + '<div id="entBqContent" style="display:none;">'
        + '<div id="entBqCats" class="ent-bq-cats"></div>'
        + '<div class="ent-bq-selectall"><label><input type="checkbox" id="entBqSelectAll"> Select All</label></div>'
        + '<div id="entBqChannels" class="ent-bq-channels"></div>'
        + '</div>'
        + '</div>'
        + '<div class="ent-bq-footer">'
        + '<button type="button" class="ent-bq-btn ent-bq-btn-save" id="entBqSave"><i class="fas fa-save"></i> Save Changes</button>'
        + '<button type="button" class="ent-bq-btn ent-bq-btn-cancel" id="entBqCancel">Close</button>'
        + '</div>'
        + '</div></div>';

    jQuery('body').append(modalHtml);

    function openModal() {
        jQuery('#entBouquetOverlay').fadeIn(200);
        jQuery('body').css('overflow', 'hidden');
    }

    function closeModal() {
        jQuery('#entBouquetOverlay').fadeOut(200);
        jQuery('body').css('overflow', '');
    }

    jQuery('#entBqClose, #entBqCancel').on('click', closeModal);
    jQuery('#entBouquetOverlay').on('click', function(e) {
        if (e.target === this) closeModal();
    });

    function renderCategories(data, activeCatId) {
        var cats = data.data;
        var catData = data.cat_data;
        var bouquets = data.bouquets;
        var savedArr = data.savedbouquets ? data.savedbouquets.split(',') : [];
        var clientSaved = data.clientSavedBouquets || [];
        var uncatLen = data.uncategorizedLength || 0;

        // Build category tabs
        var tabsHtml = '';
        var firstCatId = null;
        jQuery.each(cats, function(i, catObj) {
            jQuery.each(catObj, function(catId, catName) {
                if (!firstCatId) firstCatId = catId;
                var active = '';
                if (activeCatId) {
                    active = (catId == activeCatId) ? ' ent-bq-cat-active' : '';
                } else if (!firstCatId || catId == firstCatId) {
                    firstCatId = catId;
                }
                tabsHtml += '<button class="ent-bq-cat' + active + '" data-catid="' + catId + '">' + catName + '</button>';
            });
        });
        if (uncatLen > 0) {
            tabsHtml += '<button class="ent-bq-cat" data-catid="uncategorized">Uncategorized</button>';
        }
        jQuery('#entBqCats').html(tabsHtml);

        // If no active, activate first
        if (!activeCatId && firstCatId) {
            activeCatId = firstCatId;
            jQuery('#entBqCats .ent-bq-cat').first().addClass('ent-bq-cat-active');
        }

        renderChannels(activeCatId, bouquets, savedArr, catData, clientSaved);

        // Tab click handler
        jQuery('#entBqCats').off('click', '.ent-bq-cat').on('click', '.ent-bq-cat', function() {
            jQuery('.ent-bq-cat').removeClass('ent-bq-cat-active');
            jQuery(this).addClass('ent-bq-cat-active');
            renderChannels(jQuery(this).data('catid'), bouquets, savedArr, catData, clientSaved);
        });
    }

    function renderChannels(catId, bouquets, savedArr, catData, clientSaved) {
        if (!catData || jQuery.isEmptyObject(catData)) {
            jQuery('#entBqChannels').html('<p class="ent-bq-empty">No bouquets available.</p>');
            return;
        }

        var html = '<div class="ent-bq-channel-grid">';
        var items = [];
        jQuery.each(bouquets, function(bouquetId, channelName) {
            jQuery.each(savedArr, function(idx, val) {
                if (val == bouquetId) {
                    var assignedCat = catData[bouquetId];
                    if (assignedCat == catId) {
                        var checked = '';
                        if (selectedBouquets[bouquetId]) {
                            checked = ' checked';
                        }
                        items.push({name: channelName, id: bouquetId, checked: checked});
                    }
                }
            });
        });

        // Sort alphabetically
        items.sort(function(a, b) {
            return a.name.toUpperCase().localeCompare(b.name.toUpperCase());
        });

        if (items.length === 0) {
            html += '<p class="ent-bq-empty">No channels in this category.</p>';
        } else {
            jQuery.each(items, function(i, item) {
                html += '<label class="ent-bq-channel">'
                    + '<input type="checkbox" class="ent-bq-ch-check" value="' + item.id + '"' + item.checked + '>'
                    + '<span class="ent-bq-ch-name">' + item.name + '</span></label>';
            });
        }
        html += '</div>';
        jQuery('#entBqChannels').html(html);
        updateSelectAll();
    }

    function updateSelectAll() {
        var total = jQuery('.ent-bq-ch-check').length;
        var checked = jQuery('.ent-bq-ch-check:checked').length;
        jQuery('#entBqSelectAll').prop('checked', total > 0 && total === checked);
    }

    // Checkbox changes
    jQuery(document).on('change', '.ent-bq-ch-check', function() {
        var id = jQuery(this).val();
        if (jQuery(this).is(':checked')) {
            selectedBouquets[id] = id;
        } else {
            delete selectedBouquets[id];
        }
        updateSelectAll();
    });

    // Select All
    jQuery('#entBqSelectAll').on('change', function() {
        var isChecked = jQuery(this).is(':checked');
        jQuery('.ent-bq-ch-check').each(function() {
            jQuery(this).prop('checked', isChecked);
            var id = jQuery(this).val();
            if (isChecked) {
                selectedBouquets[id] = id;
            } else {
                delete selectedBouquets[id];
            }
        });
    });

    // Open modal on Edit Bouquets click
    jQuery(document).on('click', '.ent-bouquet-btn', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var serviceId = jQuery(this).data('serviceid');
        if (!serviceId) return;

        // Store current service ID for save
        jQuery('#entBqSave').data('serviceid', serviceId);

        // Reset UI
        jQuery('#entBqLoading').show();
        jQuery('#entBqError').hide();
        jQuery('#entBqContent').hide();
        selectedBouquets = {};

        openModal();

        // Fetch bouquet data
        jQuery.ajax({
            type: 'POST',
            url: 'bouquet_api.php',
            data: {action: 'getBouquets', serviceid: serviceId},
            dataType: 'json',
            success: function(resp) {
                jQuery('#entBqLoading').hide();
                if (resp.status === 'success') {
                    bouquetData = resp;
                    // Initialize selected bouquets from client saved
                    selectedBouquets = {};
                    if (resp.clientSavedBouquets && resp.clientSavedBouquets.length > 0) {
                        jQuery.each(resp.clientSavedBouquets, function(i, v) {
                            if (v) selectedBouquets[v] = v;
                        });
                    }
                    jQuery('#entBqContent').show();
                    renderCategories(resp, null);
                } else {
                    jQuery('#entBqError').html('<i class="fas fa-exclamation-circle"></i> ' + (resp.message || 'Failed to load bouquets')).show();
                }
            },
            error: function() {
                jQuery('#entBqLoading').hide();
                jQuery('#entBqError').html('<i class="fas fa-exclamation-circle"></i> Network error. Please try again.').show();
            }
        });
    });

    // Save Changes
    jQuery('#entBqSave').on('click', function() {
        var serviceId = jQuery(this).data('serviceid');
        var arr = [];
        jQuery.each(selectedBouquets, function(k, v) {
            if (v) arr.push(v);
        });
        var btn = jQuery(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        jQuery.ajax({
            type: 'POST',
            url: 'bouquet_api.php',
            data: {action: 'saveBouquets', serviceid: serviceId, selectedBouquets: arr.join(',')},
            dataType: 'json',
            success: function(resp) {
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Changes');
                if (resp.status === 'success') {
                    btn.html('<i class="fas fa-check"></i> Saved!');
                    setTimeout(function() {
                        btn.html('<i class="fas fa-save"></i> Save Changes');
                    }, 2000);
                } else {
                    alert(resp.message || 'Save failed');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Changes');
                alert('Network error. Please try again.');
            }
        });
    });
})();
</script>
{/literal}