mgJsComponentHandler.addDefaultComponent('mg-carousel', {
    template: '#t-mg-carousel',
    props: [
        'component_id',
        'component_namespace',
        'component_index'
    ],
    data: function () {
        return {
            items: [],
            cartItems: [],
            areItems: true,
            loading_state: true,
            allowedIdsToReload: [
                'relatedProducts',
                'recommendedProducts'
            ],
            isAnimate: false,
            cartItemSelector: null,
            cartSummarySelector: null,
            moveArrow: false,

            sliderClicked: false,
            sliderClickedElement: false,
            sliderXPosition: 0,
            sliderClickStartPosition: false,
            clickedAddon: null,
            itemClass: null,
            itemsQuantity: null,
            billingCycle: null,

        }
    },
    created: function () {

        var self = this;
        self.$nextTick(function () {
            self.loadAjaxData();
            self.addBillingCycleChangeEventListener();
        });
    },
    watch:{
        billingCycle: function(val)
        {
            this.updateItemsPrice();
        },
        items: function(val)
        {
            this.updateItemsPrice();
        },
        cartItems: function(items)
        {
            if(items.length !== 1)
            {
                return;
            }

            if(items[0].billingcycle && this.billingCycle === null)
            {
                this.billingCycle = items[0].billingcycle;
            }
        }
    },
    methods: {
        addonClicked: function(item){
            this.clickedAddon = item;
        },
        loadAjaxData: function () {
            var self = this;

            self.loading_state = true;


            var requestParams = {
                loadData: self.component_id,
                namespace: self.component_namespace,
                index: self.component_index
            };

            var response = mgPageControler.vueLoader.vloadData(requestParams);

            return response.done(function (data) {
                self.cartItemSelector = data.data.rawData.customData.cartItemSelector;
                self.cartSummarySelector = data.data.rawData.customData.cartSummarySelector;
                self.items = data.data.rawData.items;
                self.itemClass = data.data.rawData.customData.itemClass;
                self.itemsQuantity = data.data.rawData.customData.itemsQuantity;
                self.cartItems = data.data.rawData.cartItems;

                var listOfObjects = Object.keys(self.items).map(function (key) {
                    return self.items[key]
                });
                self.items = listOfObjects;

                var listOfCartObjects = Object.keys(self.cartItems).map(function (key) {
                    return self.cartItems[key]
                });
                self.cartItems = listOfCartObjects;

                self.areItems = true;
                if(self.items.length < 1)
                {
                    self.areItems = false;
                }

                self.appendCartLoader();
                self.isMoveArrow();
                self.loading_state = false;

            }).fail(function () {
                self.loading_state = false;

            });
        },

        addToCart: function (productId, productType, event, addonId = null, i = null, existAddons = null, hostingId = false) {

            if (productType === 'product')
            {
                this.addProductToCart(productId, productType, event);
            }
            else
            {
                if (hostingId !== false)
                {

                    this.addAddonToHostingProduct(hostingId, addonId, productType, event, productId);
                }
                else
                {
                    this.addAddonToCartProduct(productId, productType, event, addonId, i, existAddons);
                }

            }

        },
        addProductToCart:function(productId, productType, event)
        {
            var self = this;
            self.loading_state = true;

            let item = self.items.filter(res => res.id === productId)[0];
            let billingCycle = false;
            if(item !== undefined && item.price !== undefined && item.price.recurring !== undefined && item.price.recurring[self.billingCycle] !== undefined)
            {
                billingCycle = self.billingCycle;
            }
            event.preventDefault();
            var addToCartWhmcsUrl = "cart.php?a=add&skipconfig=true&i=0&pid=" + productId;

            if(billingCycle !== false){
                addToCartWhmcsUrl += '&billingcycle=' + billingCycle;
            }
            $.get(addToCartWhmcsUrl).done(function (data) {
                self.addToCartContinue(productId, productType, event);
            }).fail(function (data) {
                self.addToCartContinue(productId, productType, event);
            });
        },
        addAddonToCartProduct: function(productId, productType, event, addonId, i, existAddons)
        {
            var self = this;
            self.loading_state = true;
            var addons = {};
            // addons[addonId] = addonId;

            let addonString = '&addons['+addonId+']=on';
            $.each(existAddons, function (key, value) {
                // addons[value] = parseInt(value);
                addonString += '&addons['+value+']=on';
            });
            event.preventDefault();

            var addToCartWhmcsUrl = "cart.php?a=confproduct&configure=true" + addonString + '&i=' + i;

            if(!productId)
            {
                let item = self.items.filter(item => item.productType == 'addon' && item.id == addonId)[0];
                productId = item.availableProductIdsFromCart[0].id
            }

            let cartItem = self.cartItems.filter(product => product.pid == productId)[0]

            if(cartItem !== undefined  && cartItem.billingcycle)
            {
                addToCartWhmcsUrl += '&billingcycle='+ cartItem.billingcycle;
            }

            $.get(addToCartWhmcsUrl).done(function (data) {
                self.addToCartContinue(productId, productType, event, addonId, i, addons);
            }).fail(function (data) {
                self.addToCartContinue(productId, productType, event, addonId, i, addons);
            });
        },
        addAddonToHostingProduct: function(hostingId, addonid, productType, event, productId){

            var self = this;
            self.loading_state = true;

            event.preventDefault();

            var addToCartWhmcsUrl = "cart.php?a=add&aid=" + addonid + "&productid=" + hostingId;
            $.get(addToCartWhmcsUrl).done(function (data) {
                self.addToCartContinue(productId, productType, event, addonid, null, null, hostingId);
            }).fail(function (data) {
                self.addToCartContinue(productId, productType, event, hostingId);
            });

        },
        addToCartContinue: function(productId, productType, event, addonId = null, i = null, existAddons = null, hostingId = null)
        {
            var self = this;
            var requestParams = {
                loadData: self.component_id,
                namespace: self.component_namespace,
                index: self.component_index,
                crossSellerAction: 'addToCart',
                productId: productId,
                productType: productType,
                addonId: addonId,
                i: i,
                existAddons: existAddons,
                hostingId: hostingId,
            };

            self.toggleCartLoader(true);
            var response = mgPageControler.vueLoader.vloadData(requestParams);

            response.done(function (data) {
                var url = "cart.php?a=view"; //hardcoded but it will be always the same URI
                var request = $.get(url, function (data) {
                    $(document).find(self.cartItemSelector).replaceWith($(data).find(self.cartItemSelector));
                    if (self.cartSummarySelector !== null && (self.urlParams().a === 'view' || self.urlParams().a === 'checkout')) { //lagom use checkout page..
                        // $(document).find(self.cartSummarySelector).replaceWith($(data).find(self.cartSummarySelector));
                        $(document).find(self.cartSummarySelector).html($(data).find(self.cartSummarySelector).html());
                    }
                    self.toggleCartLoader();
                });
                $.each(mgPageControler.vueLoader.$children, function (key, value) {
                    if (self.allowedIdsToReload.indexOf(value.component_id) !== -1) {
                        value.loadAjaxData();
                    }
                });
            });

            response.fail(function (data) {
                self.loadAjaxData();
                self.toggleCartLoader();
            });
        },
        appendCartLoader: function () {
            var self = this;

            if ($('#crossSeller').length > 0) {
                return;
            }
            var loader = '<div id="crossSeller" style="display: none;"><div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay" ><div class="lu-preloader lu-preloader--sm"></div></div>';
            $(document).find(self.cartItemSelector).closest('form').append(loader);
        },
        toggleCartLoader: function (show) {
            var self = this;
            var form = $(document).find(self.cartItemSelector).closest('form');
            var loader = $('#crossSeller').children('.lu-preloader-container');

            var height = form.height();
            loader.css('min-height', height + "px");
            if (form.length) {
                var offsetTop = form[0].offsetTop;
                loader.css('top', offsetTop + "px");
            }
            if (show) {
                $('#crossSeller').show();
                return;
            }
            $('#crossSeller').hide();
        },
        urlParams: function () { //przerobic to jeszcze
            var urlParams;
            (window.onpopstate = function () {
                var match,
                    pl = /\+/g,  // Regex for replacing addition symbol with a space
                    search = /([^&=]+)=?([^&]*)/g,
                    decode = function (s) {
                        return decodeURIComponent(s.replace(pl, " "));
                    },
                    query = window.location.search.substring(1);

                urlParams = {};
                while (match = search.exec(query))
                    urlParams[decode(match[1])] = decode(match[2]);
            })();
            return urlParams;
        },
        isMoveArrow: function () {
            this.moveArrow = this.items.length > this.getNumberOfShowItemsByWindowSize() ? true : false;
        },
        getNumberOfShowItemsByWindowSize: function () {

            let windowWidth = $(window).width();

            switch (true) {
                case (windowWidth < 540):
                    return 1;
                case (540 <= windowWidth < 728):
                    return this.itemsQuantity.itemsOfSmall;
                case (768 <= windowWidth < 992):
                    return this.itemsQuantity.itemsOfMedium;
                case (992 <= windowWidth):
                    return this.itemsQuantity.itemsOfLarge;
            }

        },
        slideInfoShow: function () {

            var widget = $(event.target).find('.widget-body');
            if(widget.is(':animated'))
            {
                return;
            }
            if (parseInt(widget.css("top")) < 0) {
                return;
            }
            widget.find(('.info')).css('visibility', 'visible')
            widget.animate({
                top: "+=" + (parseInt(widget.css("top")) - 100) + "px"
            }, 500);

            this.addScroolbar();
        },
        slideInfoHide: function () {
            var widget = $(event.target).find('.widget-body');
            widget.animate({
                top: "0px"
            }, 500, function () {
                widget.find(('.info')).css('visibility', 'hidden')
            });

        },

        hasItemsLeft: function(allowedPx, translateX, actual)
        {
            return actual < 0;
        },
        hasItemsRight: function(allowedPx, translateX, actual)
        {
            return allowedPx <= translateX;
        },
        moveCarousel: function (px,event) {

            var wrapper = $(event.target.closest('.lSSlideWrapper')).find(".lSSlide.lsGrab");
            var exampleItem = wrapper.find('.additional-product-widget:first');
            var wrapperWidth = wrapper.width();

            var oneMarginWidth = -0.0008*wrapperWidth;
            var itemWidth = exampleItem.outerWidth();

            var margin = parseInt(exampleItem[0].offsetLeft) * 2;
            var width = exampleItem.outerWidth();
            var numberOfVisibleElements = Math.round(wrapperWidth/width);
            if (100 < margin)
            {
                numberOfVisibleElements = 1;
            }

            if (numberOfVisibleElements === 2)
            {
                oneMarginWidth = 0;
                if (itemWidth < 235)
                {
                    oneMarginWidth = -0.0005*wrapperWidth;
                }
            }
            if (numberOfVisibleElements === 3)
            {
                oneMarginWidth = 0.0035*wrapperWidth;
                if ($(window).width() < 767)
                {
                    oneMarginWidth = 0.0095*wrapperWidth;
                }
            }
            if (numberOfVisibleElements === 4 )
            {
                oneMarginWidth = 0.0074*wrapperWidth;
                if ($(window).width() < 992)
                {
                    oneMarginWidth = 0.004*wrapperWidth;
                }
            }

            var width = exampleItem.outerWidth() + oneMarginWidth;

            width =  px > 0 ? margin + width : -margin + (width * -1) ;

            var actual = parseInt($(wrapper).css('transform').split(',')[4]);
            var translateX = actual + width;
            var allowedPx = width * (this.items.length - numberOfVisibleElements);

            if(px < 0 && !this.hasItemsRight(allowedPx, translateX, actual))
            {
                return;
            }
            if(px > 0 && !this.hasItemsLeft(allowedPx, translateX, actual))
            {
                return;
            }
            self = this;
            self.isAnimate = true;
            $(wrapper).css('transform', 'translate3d(' + (translateX) + 'px, 0px, 0px)');

            setTimeout(function()
            {
                self.isAnimate = false;
            }, 300);

        },

        addScroolbar: function () {
            $('#mgSlider .widget-body .info > .info-content').each(function(){
                const ps = new PerfectScrollbar($(this)[0]);
            });

        },

        addBillingCycleChangeEventListener: function(){

            /**
             * Six template select integration
             */
            let self = this;
            let bcElement = document.getElementById("inputBillingcycle");
            if(bcElement !== null && bcElement !== undefined)
            {
                self.billingCycle = bcElement.value ? bcElement.value : null;
                bcElement.addEventListener('change', res => {
                    self.billingCycle = bcElement.value;
                })
            }
            /**
             * Lagom template checkbox integration
             */
            if(!bcElement)
            {
                $('[data-change-billingcycle]').on('click', function(){
                    let val = $(this).find('[name=billingcycle]').val();
                    if(val){
                        self.billingCycle = val;
                    }
                })
            }
        },
        updateItemsPrice: function(){

            let self = this;
            this.items.forEach((object, index) => {
                if(object.price.recurring === null || object.price.recurring === undefined){
                    return;
                }

                let cyclePrice = object.price.recurring[self.billingCycle];
                if(cyclePrice === undefined){
                    cyclePrice = object.price.recurring['minPrice'];
                }
                self.items[index].price.cycle = cyclePrice.cycle;
                self.items[index].price.regularPrice = cyclePrice.regularPrice;

            });
        }

    }
});

