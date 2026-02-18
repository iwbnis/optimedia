{include file="orderforms/kohost_professional/common.tpl"}

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar sidebar">
            {include file="orderforms/kohost_professional/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-24">
                    {if $productGroup.headline}
                        {$productGroup.headline}
                    {else}
                        {$productGroup.name}
                    {/if}
                </h2>
                {if $productGroup.tagline}
                    <p>{$productGroup.tagline}</p>
                {/if}
            </div>
            {if $errormessage}
                <div class="alert alert-danger">
                    {$errormessage}
                </div>
            {elseif !$productGroup}
                <div class="alert alert-info">
                    {lang key='orderForm.selectCategory'}
                </div>
            {/if}

            {include file="orderforms/standard_cart/sidebar-categories-collapsed.tpl"}

            <div class="products" id="products">
                <div class="row row-eq-height">
                    {foreach $products as $key => $product}
                        <div class="col-lg-4 col-md-4 col-sm-6 col-4">
                            <div class="products price-table card text-center single-pricing-pack {if $product.isFeatured == true}popular-price{/if}" id="product{$product@iteration}">

                              {if $defaultimg{$product.pid} eq 'enable'}
                                  <!-- <img style="margin-bottom: 7px;" src="../modules/addons/shippingmodule/img/placeholder.png" width="100%" /> --->
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
                                             gallery_min_height: 210,
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


                                <header class="pricing-header">
                                    <h5 id="product{$product@iteration}-name">{$product.name}
                                        {if $product.tagLine}
                                            <p id="product{$product@iteration}-tag-line">{$product.tagLine}</p>
                                        {/if}
                                        {if $product.stockControlEnabled}
                                            <span class="qty">
                                                    {$product.qty} {$LANG.orderavailable}
                                                </span>
                                        {/if}
                                    </h5>
                                    {if $product.isFeatured}
                                        <div class="feature-badge">
                                            <span class="badge">{$LANG.featuredProduct|upper}</span>
                                        </div>
                                    {/if}
                                    <div class="product-pricing" id="product{$product@iteration}-price">
                                        {if $product.bid}
                                            {$LANG.bundledeal}<br />
                                            {if $product.displayprice}
                                                <span class="price">{$product.displayprice}</span>
                                            {/if}
                                        {else}
                                            {if $product.pricing.hasconfigoptions}
                                                <p class="mb-4">{$LANG.startingfrom}</p>
                                            {/if}
                                            <span class="price">{$product.pricing.minprice.price}</span>
                                            <br/>
                                            {if $product.pricing.minprice.cycle eq "monthly"}
                                                {$LANG.orderpaymenttermmonthly}
                                            {elseif $product.pricing.minprice.cycle eq "quarterly"}
                                                {$LANG.orderpaymenttermquarterly}
                                            {elseif $product.pricing.minprice.cycle eq "semiannually"}
                                                {$LANG.orderpaymenttermsemiannually}
                                            {elseif $product.pricing.minprice.cycle eq "annually"}
                                                {$LANG.orderpaymenttermannually}
                                            {elseif $product.pricing.minprice.cycle eq "biennially"}
                                                {$LANG.orderpaymenttermbiennially}
                                            {elseif $product.pricing.minprice.cycle eq "triennially"}
                                                {$LANG.orderpaymenttermtriennially}
                                            {/if}
                                            <br>
                                            {if $product.pricing.minprice.setupFee}
                                                <small>{$product.pricing.minprice.setupFee->toPrefixed()} {$LANG.ordersetupfee}</small>
                                            {/if}
                                        {/if}
                                    </div>
                                </header>
                                <div class="card-body">
                                    <ul class="list-unstyled pricing-feature-list">
                                        {foreach $product.features as $feature => $value}
                                            <li id="product{$product@iteration}-feature{$value@iteration}">
                                                <span>{$value}</span> {$feature}
                                            </li>
                                            {foreachelse}
                                            <li id="product{$product@iteration}-description">
                                                {$product.description}
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <footer>

                                    {if $product.qty eq "0"}
                                        <span id="product{$product@iteration}-unavailable" class="order-button unavailable">{$LANG.outofstock}</span>
                                    {else}
                                        <a href="{$WEB_ROOT}/cart.php?a=add&amp;{if $product.bid}bid={$product.bid}{else}pid={$product.pid}{/if}" class="btn {if $product.isFeatured == true}primary-solid-btn{else}outline-btn{/if}" id="product{$product@iteration}-order-button">
                                           {$LANG.ordernowbutton}
                                        </a>
                                    {/if}
                                </footer>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
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
