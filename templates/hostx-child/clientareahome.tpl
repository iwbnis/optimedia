<div class="row mb-4">
	<div class="col-md-12">
		<div class="title_des">
			  <h5 class="inter">Dashboard</h5>
			  <p class="mb-0">See all your shipment overview here.</p>
			  </div>
		</div>
</div>

{* === Desktop: 4-column grid === *}
<div class="row mb-4 clientareahome-boxes ent-dash-desktop">
    <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
        <a href="clientarea.php?action=services" class="box-link">
            <div class="dashboardbox inter">
                <div class="dashboardboxinner">
                    <h5><span class="iconboder"> <img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/order.png"> </span>
                        {lang key='navservices'}
                    </h5>
                    <div class="textgraph">
                        <h2>{$clientsstats.productsnumactive}</h2>
                        <img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/grappp.png">
                    </div>
                </div>
                <div class="vsmonth">
                    <p class="mb-0"><span style="color:#2BCE4F;">+21%</span> vs last month</p>
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
        <a href="clientarea.php?action=quotes" class="box-link">
            <div class="dashboardbox inter">
                <div class="dashboardboxinner">
                    <h5><span class="iconboder"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/delivered.png"></span>
                        {lang key='quotes'}
                    </h5>
                    <div class="textgraph">
                        <h2>{$clientsstats.numquotes}</h2>
                        <img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/grappp.png">
                    </div>
                </div>
                <div class="vsmonth">
                    <p class="mb-0"><span style="color:#2BCE4F;">+11%</span> vs last month</p>
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
        <a href="supporttickets.php" class="box-link">
            <div class="dashboardbox inter">
                <div class="dashboardboxinner">
                    <h5><span class="iconboder"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/shipped.png"></span>
                        {lang key='navtickets'}
                    </h5>
                    <div class="textgraph">
                        <h2>{$clientsstats.numactivetickets}</h2>
                        <img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/grappp.png">
                    </div>
                </div>
                <div class="vsmonth">
                    <p class="mb-0"><span style="color:#2BCE4F;">+6%</span> vs last month</p>
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 mb-3 mb-md-0">
        <a href="clientarea.php?action=invoices" class="box-link">
            <div class="dashboardbox inter">
                <div class="dashboardboxinner">
                    <h5><span class="iconboder"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/pending.png"></span>
                        {lang key='navinvoices'}
                    </h5>
                    <div class="textgraph">
                        <h2>{$clientsstats.numunpaidinvoices}</h2>
                        <img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/grappp.png">
                    </div>
                </div>
                <div class="vsmonth">
                    <p class="mb-0"><span style="color:#2BCE4F;">+19%</span> vs last month</p>
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>
        </a>
    </div>
</div>

{* === Mobile: Horizontal pill tabs with click-to-reveal panels === *}
<div class="mb-4 ent-dash-mobile inter">
    <div class="ent-mob-tabs">
        <button class="ent-mob-tab active" data-tab="services">
            <span class="ent-mob-tab-icon"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/order.png"></span>
            <span class="ent-mob-tab-label">{lang key='navservices'}</span>
        </button>
        <button class="ent-mob-tab" data-tab="signups">
            <span class="ent-mob-tab-icon"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/delivered.png"></span>
            <span class="ent-mob-tab-label">Signups</span>
        </button>
        <button class="ent-mob-tab" data-tab="tickets">
            <span class="ent-mob-tab-icon"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/shipped.png"></span>
            <span class="ent-mob-tab-label">{lang key='navtickets'}</span>
        </button>
        <button class="ent-mob-tab" data-tab="invoices">
            <span class="ent-mob-tab-icon"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/pending.png"></span>
            <span class="ent-mob-tab-label">{lang key='navinvoices'}</span>
        </button>
        <button class="ent-mob-tab" data-tab="quickstart">
            <span class="ent-mob-tab-icon"><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/desktop.png"></span>
            <span class="ent-mob-tab-label">Quick Start</span>
        </button>
    </div>
    <div class="ent-mob-panels">
        <div class="ent-mob-panel active" data-panel="services">
            <div class="ent-mob-panel-inner">
                <div class="ent-mob-panel-count">{$clientsstats.productsnumactive}</div>
                <div class="ent-mob-panel-meta">
                    <span class="ent-mob-panel-trend"><i class="bi bi-arrow-up-right"></i> +21%</span>
                    <span class="ent-mob-panel-vs">vs last month</span>
                </div>
                <a href="clientarea.php?action=services" class="ent-mob-panel-link">View All <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div class="ent-mob-panel" data-panel="signups">
            <div class="ent-mob-panel-inner">
                <div class="ent-mob-panel-count">{$clientsstats.numquotes}</div>
                <div class="ent-mob-panel-meta">
                    <span class="ent-mob-panel-trend"><i class="bi bi-arrow-up-right"></i> +11%</span>
                    <span class="ent-mob-panel-vs">vs last month</span>
                </div>
                <a href="clientarea.php?action=quotes" class="ent-mob-panel-link">View All <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div class="ent-mob-panel" data-panel="tickets">
            <div class="ent-mob-panel-inner">
                <div class="ent-mob-panel-count">{$clientsstats.numactivetickets}</div>
                <div class="ent-mob-panel-meta">
                    <span class="ent-mob-panel-trend"><i class="bi bi-arrow-up-right"></i> +6%</span>
                    <span class="ent-mob-panel-vs">vs last month</span>
                </div>
                <a href="supporttickets.php" class="ent-mob-panel-link">View All <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div class="ent-mob-panel" data-panel="invoices">
            <div class="ent-mob-panel-inner">
                <div class="ent-mob-panel-count">{$clientsstats.numunpaidinvoices}</div>
                <div class="ent-mob-panel-meta">
                    <span class="ent-mob-panel-trend"><i class="bi bi-arrow-up-right"></i> +19%</span>
                    <span class="ent-mob-panel-vs">vs last month</span>
                </div>
                <a href="clientarea.php?action=invoices" class="ent-mob-panel-link">View All <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div class="ent-mob-panel" data-panel="quickstart">
            <div class="ent-mob-panel-inner ent-mob-panel-quickstart">
                <div class="ent-mob-panel-qs-title">Set up your device</div>
                <div class="ent-mob-panel-qs-links">
                    <a href="index.php?rp=/knowledgebase/63/Amazon-Firestick-Apps.html" class="ent-mob-qs-link">
                        <i class="fab fa-amazon"></i> Firestick
                    </a>
                    <a href="index.php?rp=/knowledgebase/38/ANDROID-DOWNLOAD-LINKS.html" class="ent-mob-qs-link">
                        <i class="fab fa-android"></i> Android
                    </a>
                    <a href="index.php?rp=/knowledgebase/51/How-to-Setup-iPTV-on-iOS-Devices-iPhone-iPad.html" class="ent-mob-qs-link">
                        <i class="fab fa-apple"></i> iPhone / iPad
                    </a>
                    <a href="index.php?rp=/knowledgebase/8/Smart-TV-Devices" class="ent-mob-qs-link">
                        <i class="fas fa-tv"></i> Smart TV
                    </a>
                    <a href="index.php?rp=/knowledgebase/49/How-to-Setup-IPTV-On-MAG-Devices.html" class="ent-mob-qs-link">
                        <i class="fas fa-hdd"></i> MAG Box
                    </a>
                    <a href="index.php?rp=/knowledgebase/45/VLC-Media-Player.html" class="ent-mob-qs-link">
                        <i class="fas fa-laptop"></i> PC / Mac
                    </a>
                    <a href="index.php?rp=/knowledgebase/71/Purple-Smart-IPTV-Player.html" class="ent-mob-qs-link">
                        <i class="fas fa-stream"></i> ROKU
                    </a>
                    <a href="index.php?rp=/knowledgebase/6/Setup-Tutorials" class="ent-mob-qs-link ent-mob-qs-link-all">
                        <i class="fas fa-book-open"></i> All Guides
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
<script>
jQuery(function($) {
    $('.ent-mob-tab').on('click', function() {
        var tab = $(this).data('tab');
        $('.ent-mob-tab').removeClass('active');
        $(this).addClass('active');
        $('.ent-mob-panel').removeClass('active');
        $('.ent-mob-panel[data-panel="' + tab + '"]').addClass('active');
    });
});
</script>
{/literal}


		{*
		<div class="row mb-4">
			<div class="col-md-12">
				<form class="d-flex formss mb-4" role="search">
				<input class="form-control me-2" type="search" placeholder="Enter question here to search our knowledge for answers..." aria-label="Search"/>
				<button class="btn inter" type="submit"><i class="bi bi-search"></i></button>
			  </form>
			  </div>
			  </div>
			  
			  <div class="row mb-4 bgwhite p-4 m-0  radius10">
			<div class="col-md-6">
				<div class="activeorder inter">
					<span class="iconboder"><i class="bi bi-briefcase"></i></span>
					<div class="activeorder">
					<h5 class="m-0"> Active Orders</h5>
					<p class="mb-0">Americas TV ( adult ) : 1 Month ( 2 connections )</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<ul class="btnsst inter">
				<li> <a href="#" class="btn bggreen">Active</a> </li>
				<li> <a href="#" class="btn brborder">View details</a> </li>
				<li> <a href="#" class="btn bgblue">View More</a> </li>
				</ul>
			</div>
		</div>		
		<div class="row mb-4 inter">
			<div class="col-md-12">
				<div class="title_des">
				  <h5>Shipping Details</h5>
				  <p>See all your shipment overview here.</p>
				  </div>
				  <div class="productbox mb-4">
				<a href="#" class="btn bgwhite" style="color: #28303F;box-shadow: 0px 3px 10px #f6f6f6;"> My services & products </a>
				<a href="#" class="btn ms-4" style="color: #fff;background:#FFA100;"> Shipping</a>
			  </div>
			  
			  <div class="bgwhite  radius10 p-4">
			    <div class="shippinglist mb-4">
					<h5 style="color:#232323; font-size: 16px;">Shipping List</h5>
					<div class="dropdown">
					  <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 14px; color: #374557;border: 1px solid #ddd;">
						<i class="bi bi-list"></i> Shorting
					  </button>
					  <ul class="dropdown-menu">
						<li><button class="dropdown-item" type="button">Dropdown item</button></li>
						<li><button class="dropdown-item" type="button">Dropdown item</button></li>
						<li><button class="dropdown-item" type="button">Dropdown item</button></li>
					  </ul>
					</div>
			    </div>
				<div class="table-responsive shipingtable">
				    <table class="table p-0">
					  <tr>
						  <th>Product Name</th>
						  <th>Status</th>
						  <th>Shipping Number</th>
						  <th>Status</th>
					  </tr>
					  <tr>
						  <td><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/emoet.png">  Iptv TV Box</td>
						  <td><a class="btn" style="color: #088B3A; background: #E7F7ED;">Complete </a></td>
						  <td>54245845454</td>
						  <td><a class="btn bluebg" style="background: #083C72;color: #fff;">Track Order</a></td>
					  </tr>
					  <tr>
						  <td><img src="https://test.choiceiptv.net/templates/hostx-child/imagenew/emoet.png"> Iptv TV Box</td>
						  <td><a class="btn" style="color: #ED6C3C; background: #FCECD6;">Cancel </a></td>
						  <td>54245845454</td>
						  <td><a class="btn bluebg" style="background: #083C72;color: #fff;">Track Order</a></td>
					  </tr>
				    </table>
				</div>
				</div>
			</div>
		</div>
		*}



{if $hostx_theme_settings.dashboard_layout eq '1'}
<div class="client-dashboard-area whmcs-default-client-dashboard">
    {include file="$template/includes/flashmessage.tpl"}
    
    {foreach $addons_html as $addon_html}
        <div>
            {$addon_html}
        </div>
    {/foreach}

    {if $captchaError}
        <div class="alert alert-danger">
            {$captchaError}
        </div>
    {/if}

    <div class="client-home-cards">
        <div class="row">
            <div class="col-12">
                {function name=outputHomePanels}
                    <div menuItemName="{$item->getName()}" class="card card-accent-{$item->getExtra('color')}{if $item->getClass()} {$item->getClass()}{/if}"{if $item->getAttribute('id')} id="{$item->getAttribute('id')}"{/if}>
                        <div class="card-header">
                            <h3 class="card-title m-0">
                                {if $item->getExtra('btn-link') && $item->getExtra('btn-text')}
                                    <div class="float-right">
                                        <a href="{$item->getExtra('btn-link')}" class="btn btn-default bg-color-{$item->getExtra('color')} btn-xs">
                                            {if $item->getExtra('btn-icon')}<i class="{$item->getExtra('btn-icon')}"></i>{/if}
                                            {$item->getExtra('btn-text')}
                                        </a>
                                    </div>
                                {/if}
                                {if $item->hasIcon()}<i class="{$item->getIcon()}"></i>&nbsp;{/if}
                                {$item->getLabel()}
                                {if $item->hasBadge()}&nbsp;<span class="badge">{$item->getBadge()}</span>{/if}
                            </h3>
                        </div>
                        {if $item->hasBodyHtml()}
                            <div class="card-body">
                                {$item->getBodyHtml()}
                            </div>
                        {/if}
                        {if $item->hasChildren()}
                            <div class="list-group{if $item->getChildrenAttribute('class')} {$item->getChildrenAttribute('class')}{/if}">
                                {foreach $item->getChildren() as $childItem}
                                    {if $childItem->getUri()}
                                        <a menuItemName="{$childItem->getName()}" href="{$childItem->getUri()}" class="list-group-item list-group-item-action{if $childItem->getClass()} {$childItem->getClass()}{/if}{if $childItem->isCurrent()} active{/if}"{if $childItem->getAttribute('dataToggleTab')} data-toggle="tab"{/if}{if $childItem->getAttribute('target')} target="{$childItem->getAttribute('target')}"{/if} id="{$childItem->getId()}">
                                            {if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>&nbsp;{/if}
                                            {$childItem->getLabel()}
                                            {if $childItem->hasBadge()}&nbsp;<span class="badge">{$childItem->getBadge()}</span>{/if}
                                        </a>
                                    {else}
                                        <div menuItemName="{$childItem->getName()}" class="list-group-item list-group-item-action{if $childItem->getClass()} {$childItem->getClass()}{/if}" id="{$childItem->getId()}">
                                            {if $childItem->hasIcon()}<i class="{$childItem->getIcon()}"></i>&nbsp;{/if}
                                            {$childItem->getLabel()}
                                            {if $childItem->hasBadge()}&nbsp;<span class="badge">{$childItem->getBadge()}</span>{/if}
                                        </div>
                                    {/if}
                                {/foreach}
                            </div>
                        {/if}
                        <div class="card-footer">
                            {if $item->hasFooterHtml()}
                                {$item->getFooterHtml()}
                            {/if}
                        </div>
                    </div>
                {/function}

                {foreach $panels as $item}
                    {if $item->getExtra('colspan')}
                        {outputHomePanels}
                        {assign "panels" $panels->removeChild($item->getName())}
                    {/if}
                {/foreach}

            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 testing">

                {foreach $panels as $item}
                    {if $item@iteration is odd}
                        {outputHomePanels}
                    {/if}
                {/foreach}

            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">

                {foreach $panels as $item}
                    {if $item@iteration is even}
                        {outputHomePanels}
                    {/if}
                {/foreach}

            </div>
        </div>
    </div>
</div>
{else}
    {include file="$template/hostx_others_file/latest-dashboard.tpl"}
{/if}