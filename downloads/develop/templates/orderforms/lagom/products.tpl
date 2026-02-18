{if isset($RSThemes['pages']['products'])}
    {include file=$RSThemes['pages']['products']['fullPath']}
{else}
    {include file="orderforms/$carttpl/common.tpl"}

    <div class="col-md-3 pull-md-left main-sidebar sidebar hidden-xs hidden-sm">
        {include file="orderforms/$carttpl/sidebar-categories.tpl"}
    </div>
    <div class="main-content col-md-9 pull-md-right">
        {include file="orderforms/$carttpl/sidebar-categories-collapsed.tpl"}
        {if $errormessage}
            <div class="alert alert-danger">
                {$errormessage}
            </div>
        {elseif !$productGroup}
            <div class="alert alert-info">
                {lang key='orderForm.selectCategory'}
            </div>
        {/if}
        {foreach $hookAboveProductsOutput as $output}
            <div>
                {$output}
            </div>
        {/foreach}
        <div class="products" id="products">
            <div class="row row-eq-height row-eq-height-sm">
                {foreach $products as $key => $product}
                    <div class="col-lg-4 col-sm-6">

                        <div class="package {if $product.isFeatured}package-featured{/if}" id="product{$product@iteration}">
                            {if $product.isFeatured}
                                <span class="label-corner label-primary">{$rslang->trans('order.featured')}</span>
                            {/if}
{if $defaultimg{$product.pid} eq 'enable'}
    <img style="margin-bottom: 7px;" src="../modules/addons/shippingmodule/img/placeholder_l.png" width="100%" />
{else}
<div id="gallery{$product.pid}" style="display:none; margin-bottom: 10px;">

  {foreach from=$image{$product.pid}.photos item=image}
  {assign var="imagedata" value="|"|explode:$image}
    <img class="my-image{$image@iteration}"
     alt="{$imagedata.2}"
     src="{$temppath}{$imagedata.0}"
     data-image="{$path}{$imagedata.0}"
     >
  {/foreach}


  {foreach from=$image{$product.pid}.videos item=video}
  {assign var="videodata" value="|"|explode:$video}

    <img alt="{$videodata.2}"
     src="{$path}{$videodata.0}"
     data-type="html5video"
     data-image="{$modpath}img/video.png"
     data-thumb="{$modpath}img/video.png"
     data-videoogv="{$path}{$videodata.0}"
     data-videowebm="{$path}{$videodata.1}"
     data-videomp4="{$path}{$videodata.0}"

     >
  {/foreach}

  {foreach from=$image{$product.pid}.others item=video}
  {assign var="videodata" value="|"|explode:$video}

      <img alt="{$videodata.2}"
         data-type="{$videodata.1}"

         {if $videodata.1 eq "vimeo" || $videodata.1 eq "html5video"}
            data-thumb="{$modpath}img/video.png"
         {/if}

         {if $videodata.1 neq "html5video"}
            data-videoid="{$videodata.0}"
         {/if}

         {if $videodata.1 eq "html5video"}
           data-videoogv="{$videodata.0}"
           data-videowebm="{$videodata.0}"
           data-videomp4="{$videodata.0}"
         {/if}
        >
  {/foreach}


</div>
	<script type="text/javascript">

		jQuery(document).ready(function(){

			jQuery("#gallery{$product.pid}").unitegallery({
               gallery_theme:"compact",
               gallery_skin: "alexis",
               gallery_min_width: 210,
               gallery_min_height: 283,
               slider_enable_zoom_panel: false,
               slider_videoplay_button_type: "round",
               thumb_width:50,
               thumb_height:50,
                slider_scale_mode: "down",
                gallery_background_color: "	#FFFFFF",
                thumb_loader_type:"light",
                slider_play_button_align_hor:"left",
                tile_enable_textpanel: true,		 	//enable textpanel
                slider_enable_text_panel:true,
                thumb_image_overlay_effect:true,

            });

		});

	</script>
{/if}

                            <h3 class="package-name">{$product.name}</h3>
                            <div class="package-price">
                                {if $product.bid}
                                    <div class="package-starting-from">{$LANG.bundledeal}</div>
                                    {if $product.displayprice}
                                        <span class="price"><span class="price-prefix">{$currency.prefix}</span>{$product.displayprice->toSuffixed()}</span>
                                    {/if}
                                {else}
                                    {if $product.pricing.hasconfigoptions}
                                        <div class="package-starting-from ">{$LANG.startingfrom}</div>
                                    {/if}
                                    {if $DiscountCenterAddonIsActive}
                                        <div class="price">{$product.pricing.minprice.price}{if $product.pricing.type !=="free" && $product.pricing.type !=="onetime"}<span class="price-cycle">/{if $product.pricing.minprice.cycle eq "monthly"}{$LANG.pricingCycleShort.monthly}{elseif $product.pricing.minprice.cycle eq "quarterly"}{$LANG.pricingCycleShort.quarterly}{elseif $product.pricing.minprice.cycle eq "semiannually"}{$LANG.pricingCycleShort.semiannually}{elseif $product.pricing.minprice.cycle eq "annually"}{$LANG.pricingCycleShort.annually}{elseif $product.pricing.minprice.cycle eq "biennially"}{$LANG.pricingCycleShort.biennially}{elseif $product.pricing.minprice.cycle eq "triennially"}{$LANG.pricingCycleShort.triennially}{/if}</span>{/if}</div>
                                    {else}
                                        <div class="price">{if $currency.prefix}<span class="price-prefix">{$currency.prefix}</span>{/if}{$product.pricing.minprice.price|replace:$currency.suffix:""|replace:$currency.prefix:""}{if $currency.suffix}{$currency.suffix}{/if}{if $product.pricing.type !=="free" && $product.pricing.type !=="onetime"}<span class="price-cycle">/{if $product.pricing.minprice.cycle eq "monthly"}{$LANG.pricingCycleShort.monthly}{elseif $product.pricing.minprice.cycle eq "quarterly"}{$LANG.pricingCycleShort.quarterly}{elseif $product.pricing.minprice.cycle eq "semiannually"}{$LANG.pricingCycleShort.semiannually}{elseif $product.pricing.minprice.cycle eq "annually"}{$LANG.pricingCycleShort.annually}{elseif $product.pricing.minprice.cycle eq "biennially"}{$LANG.pricingCycleShort.biennially}{elseif $product.pricing.minprice.cycle eq "triennially"}{$LANG.pricingCycleShort.triennially}{/if}</span>{/if}</div>
                                    {/if}
                                    {if $product.pricing.minprice.setupFee}
                                        <small class="package-setup-fee">{$product.pricing.minprice.setupFee->toPrefixed()} {$LANG.ordersetupfee}</small>
                                    {/if}
                                {/if}
                            </div>
                            {if $product.features}
                            <ul class="package-features">
                                {foreach $product.features as $feature => $value}
                                    <li id="product{$product@iteration}-feature{$value@iteration}">
                                        {$feature} {$value}
                                    </li>
                                {/foreach}
                            </ul>
                            {/if}
                            {if $product.featuresdesc}
                                <div class="package-content">
                                    <p>{$product.featuresdesc}</p>
                                </div>
                            {/if}
                            <div class="package-footer">
                                <a href="cart.php?a=add&{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}" class="btn btn-lg btn-primary" id="product{$product@iteration}-order-button">
                                    {$LANG.ordernowbutton}
                                </a>
                                {if $product.qty || $product.qty == "0"}
                                    <div class="package-qty">
                                        {$product.qty} {$LANG.orderavailable}
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>

	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-common-libraries.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-functions.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-thumbsgeneral.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-thumbsstrip.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-touchthumbs.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-panelsbase.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-strippanel.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-gridpanel.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-thumbsgrid.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-tiles.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-tiledesign.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-avia.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-slider.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-sliderassets.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-touchslider.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-zoomslider.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-video.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-gallery.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-lightbox.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-carousel.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/js/ug-api.js'></script>
	<script type='text/javascript' src='{$modpath}unitegallery/themes/compact/ug-theme-compact.js'></script>


    <style>
        @import url('{$modpath}unitegallery/css/unite-gallery.css');
        @import url('{$modpath}unitegallery/themes/default/ug-theme-default.css');
        @import url('{$modpath}unitegallery/skins/alexis/alexis.css');

        .ug-button-play
        {
            left:50px !important;
            top:9px !important;
        }

        .ug-panel-handle-tip{
          left:auto !important;
          right:0px !important;
        }

        .ug-videoplayer .ug-videoplayer-button-close{
          right: 5px !important;
      top: 5px !important;
      left:auto !important;
      zoom:0.4;
        }

        .ug-slider-control{
          zoom:0.8;
        }
        .ug-arrow-right{
          left:auto !important;
          right: 20px;
        }
    </style>


        {if count($productGroup.features) > 0}
            <div class="section m-t-24">
                <h3>{$LANG.orderForm.includedWithPlans}</h3>
                <div class="panel panel-form">
                    <div class="panel-body">
                        <ul class="list-features list-info">
                            {foreach $productGroup.features as $features name=foo}
                                <li class="{if !$smarty.foreach.foo.last}m-b-10{/if} align-center"><i class="lm lm-check m-r-8 text-primary "></i><span class="h6 m-b-0">{$features.feature}<span></li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        {/if}
        {foreach $hookBelowProductsOutput as $output}
            <div>
                {$output}
            </div>
        {/foreach}
    </div>
{/if}
