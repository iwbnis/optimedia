<script type="text/x-template" id="t-mg-carousel-{$elementId|strtolower}"
        :component_id="component_id"
        :component_namespace="component_namespace"
        :component_index="component_index"
>
    <div id="mgSlider" class="mgSlider" v-show="areItems">
        <div class="lu-row lu-row--eq-height">
            <div class="lu-col-lg-12">
                <div id="cart-first-step-content" data-type="_tile">
                    <div class="lu-widget__header">
                        <h2 class="lu-h5">{$MGLANG->translate({$rawObject->getTitle()})}</h2>
                    </div>
                    <div class="widget-slider-container">
                        <div class="widget-slider-loader hidden"><i class="spinner"></i></div>
                        <div class="lSSlideOuter ">
                            <div class="lSSlideWrapper usingCss" style="transition-duration: 400ms; transition-timing-function: ease;">
                                <div class="row widget-slider lightSlider lSSlide lsGrab mg-nowrap">
                                    <div v-bind:class="itemClass"
{*                                    <div class="col-xs-6 additional-product-widget lslide slide-active"*}
                                         @mouseenter="slideInfoShow" @mouseleave="slideInfoHide"
                                         v-for="(item, index) in items">
                                        <div class="widget w-short product-widget-tile">
                                            {literal}
                                                <div class="widget-header">
                                                    <div class="header-title"
                                                         :style="{backgroundColor: item.backgroundColor}">

                                                        <div class="title-icon">
                                                            <span></span>
                                                            <img class="img-productInCarousel" :src="item.image" :alt="item.name"></div>
                                                    </div>
                                                    <div class="header-label">
                                                        <div class="label label-8  label-long" v-if="item.price.discount">
                                                            <b>-{{item.price.discount}}</b>{/literal}{$MGLANG->absoluteTranslate("price","discount")}{literal}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-body">
                                                    <h3 class="lu-m-b-2x" v-html="item.name"></h3>
                                                    <div class="info infoInCarousel">
                                                        <div class="info-content">
                                                            <p v-html="item.tag"></p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="price  price-discounted" v-if="item.price.newPrice">
                                                    <span class="price-line price-discount">{{item.price.regularPrice}}</span>
                                                    <b class="price-line price-final">{{item.price.newPrice}}</b>{{item.price.cycle}}
                                                </div>
                                                <div class="price  price-discounted" v-else>
                                                    <b class="price-line price-final">{{item.price.regularPrice}}</b>{{item.price.cycle}}
                                                </div>

                                                <div class="widget-actions" v-if="item.productType === 'addon' && item.availableProductIdsFromCart.length > 1" >
                                                    <button class="btn btn-xs btn-success btn-icon cart-order-product product-add-to-cart"
                                                            @click="addonClicked(item)"
                                                        data-toggle="modal" data-target="#chooseProductModal">
                                                            <span><i class="lu-zmdi lu-zmdi-shopping-cart"></i></span>
                                                            <span class="button-loader hidden"><i
                                                                        class="spinner"></i></span>
                                                            <div class="check-animate hidden"></div>
                                                    </button>
                                                </div>

                                                <div class="widget-actions" v-else-if="item.productType === 'addon' && item.availableProductIdsFromCart.length === 1" >
                                                    <button class="btn btn-xs btn-success btn-icon cart-order-product product-add-to-cart"
                                                            @click="addonClicked(item)"
                                                            @click="addToCart(clickedAddon.availableProductIdsFromCart[0].id, item.productType, $event, clickedAddon.id, clickedAddon.availableProductIdsFromCart[0].i, clickedAddon.availableProductIdsFromCart[0].existAddons)">
                                                        <span><i class="lu-zmdi lu-zmdi-shopping-cart"></i></span>
                                                        <span class="button-loader hidden"><i
                                                                    class="spinner"></i></span>
                                                        <div class="check-animate hidden"></div>
                                                    </button>
                                                </div>

                                                <div class="widget-actions" v-else-if="item.productType === 'product'" >
                                                    <button class="btn btn-xs btn-success btn-icon cart-order-product product-add-to-cart"
                                                            @click="addToCart(item.id, item.productType, $event)">
                                                        <span><i class="lu-zmdi lu-zmdi-shopping-cart"></i></span>
                                                        <span class="button-loader hidden"><i
                                                                    class="spinner"></i></span>
                                                        <div class="check-animate hidden"></div>
                                                    </button>
                                                </div>
                                            {/literal}
                                        </div>
                                    </div>
                                </div>
                                <div class="lSAction">
                                    <a class="lSPrev" v-show="moveArrow" :disabled="isAnimate" @click="moveCarousel(1, $event)" ><i class="lu-zmdi lu-zmdi-arrow-left"></i></a>
                                    <a class="lSNext" v-show="moveArrow" :disabled="isAnimate" @click="moveCarousel(-1, $event)" ><i class="lu-zmdi lu-zmdi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay"
                         v-show="loading_state">
                        <div class="lu-preloader lu-preloader--sm"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="chooseProductModal" class="modal fade" role="dialog" v-if="clickedAddon">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header mg-modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Choose Product</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-xs-6 my=1 additional-productToChoose-widget lslide slide-active"
                                 @mouseenter="slideInfoShow" @mouseleave="slideInfoHide"
                                 v-for="(item, index) in clickedAddon.availableProductIdsFromCart">
                                <div v-bind:class="item.class" style="padding-bottom: 0px; margin-bottom: 0px">
                                    {literal}

                                    <div class="widget-header">
                                        <div class="header-title"
                                             :style="{backgroundColor: item.backgroundColor}">

                                            <div class="title-icon">
                                                <span></span>
                                                <img :src="item.image" :alt="item.name"></div>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <h3 class="lu-m-b-2x" v-html="item.name"></h3>
                                        <div class="info infoInModal">
                                            <div class="info-content">
                                                <p v-if="item.domain !== false" v-html="item.domain"></p>
                                                <p v-html="item.description"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit ">
                                        <button class="btn btn-xs btn-success " data-dismiss="modal"
                                                @click="addToCart(item.id, clickedAddon.productType, $event, clickedAddon.id, item.i, item.existAddons, item.hostingId)"
                                                style="width: 90%; margin-bottom: 0px;">Submit
                                            <span class="button-loader hidden"><i
                                                        class="spinner"></i></span>
                                            <div class="check-animate hidden"></div>
                                        </button>
                                    </div>
                                    {/literal}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</script>



