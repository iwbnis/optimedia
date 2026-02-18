jQuery(document).ready(function () {
    jQuery('body').on('click', '#active-popup a.close', function () {
        var id = this.getAttribute("value");
        
        defaultStyle.destroyPopup(jQuery('.active-popup-'+id).find('.popup'),id, true);
    });
    
    defaultStyle.loadPopupsArray();
    //defaultStyle.showPopup();
});

var defaultStyle = new function() {
    
    this.loadPopupsArray = function()
    {
       var popups = [];
       var popup = this.getNextPopup();
       var self = this;
       
        while (popup) {

            popups.push(popup);
            popup.remove();
            var popup = this.getNextPopup();
        }; 

        
        popups.forEach(function(item, index){
            self.loadPopup(item);
        })
        
    }
    this.loadPopup = function(popup)
    {
        var delay = popup.attr('data-popup-delay');
        var self = this;
        if(delay > 0)
        {
            setTimeout(function(){ 
                
                self.showPopup(popup); 
            }, delay*1000);
        }else{
             this.showPopup(popup); 
        }  
    }
    
    this.showPopup = function (popup) {
        //var popup = this.getNextPopup();
        if(popup === false) {
            $('#active-popup').remove();
            return false;
        }

        //popup = $('#popup-container > .popup.active-popup:nth-child(1)');
        if((typeof popup !== "undefined") && popup.length > 0) {
            var settings = this.getPopupSettings(popup);
            popup.find('.popup-attributes').remove();

            popup.removeClass('not-shown').addClass('active-popup');
            var id = popup.attr('data-popup-id');
            var html = '<div class="popup"  data-popup-id="'+id+'">'+popup.html()+'</div>';
            popup.remove();

            var pageHeight = jQuery(document).height();
            jQuery('body').prepend('<div class="active-popup-'+id+'" id="active-popup">'+html+'</div>');
            jQuery('#active-popup').css("height", pageHeight);
            var activePopup = jQuery('#active-popup .popup');
            var popupWindow = activePopup.find('.popup-window');
            activePopup.show();
            var mess = activePopup.find('.message');

            var w = (settings.width === 'auto')? mess.outerWidth(true)+1:settings.width;
            var h = (settings.height === 'auto')? mess.outerHeight(true):settings.height;

            let dimensions = {};

            if (settings.type === 'image' && parseInt(settings.width.replace('px', '')) > window.innerWidth)
            {
                dimensions = getResponsiveDimensions(settings.width, settings.height);

                w = dimensions.width;
                h = dimensions.height
            }

            var messer = {"height": h, "width": w};

            if(settings.width === 'auto') {
                delete messer.width;
            }

            if(settings.height === 'auto') {
                delete messer.height;
            }
            if(!jQuery.isEmptyObject(messer)){
                mess.css(messer);
            }
            
            if(activePopup.find('.notshow-container').length > 0) {
               var minwidth = $('[data-popup-id="'+id+'"]').find('.notshow-container').outerWidth(true);
                if (typeof dimensions !== 'undefined'){
                    $('[data-popup-id="'+id+'"]').find('.notshow-container').css('min-width', dimensions.width)
                }
               mess.css('min-width', '200px');
            }

            if ('none' !== settings.animation)
            {
                this.setAnimation(settings);
            }

            if (2 === settings.allow_not_show_again)
            {
                this.addClassToCloseButton(popupWindow, 'closePermanent');
            }

            popupWindow.addClass('ready');

            $.get(location.href, { popupShowed: id } );
        }
    };

    var getResponsiveDimensions = (width, height) => {
        width = parseInt(width.replace('px', ''));
        height = parseInt(height.replace('px', ''));

        const maxWidth = 0.55 * window.innerWidth;
        const scale = maxWidth/width;

        return {
            width: maxWidth,
            height: scale * height
        };
    };

    this.getNextPopup = function () {
        
        //var popup = $('#popup-container > .not-shown.popup');
        var popup = $('#popup-container > .not-shown.popup:nth-child(1)');

        popup.removeClass('not-shown').addClass('active-popup');
        if (popup.length > 0) {
            if(this.canPopupBeShown(popup)) {
                return popup;
            }
            else
            {
                popup.remove();
            }
        } else {
            return false;
        }

        return this.getNextPopup();
    };

    this.canPopupBeShown = function (popup) {
        if(this.getQuery('debug_popup') || this.getQuery('debug_styles')){
            return true;
        }
        var settings = this.getPopupSettings(popup);

        var resultDisplayLimitForAll = this.displayLimitForAllMatches(settings);
        if(resultDisplayLimitForAll !== true) {
            this.destroyPopup(popup,settings.id, false);
            return false;
        }
        var resultDisplayLimit = this.displayLimitMatches(settings);
        if(resultDisplayLimit !== true) {
            this.destroyPopup(popup,settings.id, false);
            return false;
        }
        var resultDates = this.datesMatches(settings);
        if(resultDates !== true) {
            this.destroyPopup(popup,settings.id, false);
            return false;
        }
        var resultTrigger = this.triggerMatches(settings, popup);
        if(resultTrigger !== true) {
            this.destroyPopup(popup,settings.id, false);
            return false;
        }

        return true;
    };

    this.destroyPopup = function(popup,id, shown) {

        if(shown === true) {
            var notShowAgain = (popup.find('input.not-show-again:checked').length)? 1:0;
            notShowAgain = (popup.find('.closePermanent').length) ? 1 : notShowAgain;
            cookie = {
                'notShowAgain': notShowAgain,
                'lastTriggered': Date.now()
            };
            this.setPopupCookie(popup, cookie);
        }
        popup.fadeOut();
        //popup.remove();
        $('.active-popup-'+id).remove();
    };

    this.displayLimitForAllMatches = function (settings) {

        var displayLimitForAll = settings.displayLimitForAll;
        var shown = settings.all_shown;

        return (displayLimitForAll >0 && displayLimitForAll <= shown) ? false : true;
    };

    this.displayLimitMatches = function (settings) {

        var displayLimit = settings.displayLimit;
        var shown = settings.shown;

        return (displayLimit > 0 && displayLimit <= shown) ? false : true;
    };

    this.datesMatches = function(settings) {    

        var tempdate = new Date(settings.start.replace(/-/g,'/'));
        var startDate = tempdate.getTime();
        var tempdate = new Date(settings.end.replace(/-/g,'/'));
        var endDate = tempdate.getTime();
        var nowDate = Date.now();

        return (nowDate > startDate && nowDate < endDate)? true:false;     
    };

    this.triggerMatches = function(settings, popup) {
        var cookie = this.getPopupCookie(popup);
        var notShowAgain = cookie.notShowAgain || 0;
        var lastTriggered = cookie.lastTriggered || false;
        var trigger = settings.trigger;

        if(notShowAgain === 1)
            return false;

        if(trigger === '-1')
            return true;

        if(lastTriggered === false)
            return true;

        var nowDate = Date.now();
        var diff = nowDate - lastTriggered;
        var minutes = diff / 1000 / 60;

        return (minutes > trigger)? true:false;
    };

    this.getPopupSettings = function(popup) {
        if(popup.find) {
            var settingsJson = popup.find('.popup-attributes').text();
            return jQuery.parseJSON(settingsJson);
        }
        return {};
    };

    this.getPopupCookie = function(popup){
        var popupId = popup.attr('data-popup-id');
        var popupCookieId = 'popup-'+popupId;
        var cookieJson = jQuery.cookie(popupCookieId) || '{}';
        var cookie = $.parseJSON(cookieJson);

        return cookie;
    };

    this.getQuery = function(q) {
        return (window.location.search.match(new RegExp('[?&]' + q + '=([^&]+)')) || [, null])[1];
    }

    this.setPopupCookie = function(popup, cookie) {
        var popupId = popup.attr('data-popup-id');
        var popupCookieId = 'popup-'+popupId;

        jQuery.cookie(popupCookieId, JSON.stringify(cookie));
    };

    this.setAnimation = function (settings) {

        var animation = settings.animation;
        var animationTime = settings.animationTime*1000;

        var popupWindow = $('body').find(`[data-popup-id='${settings.id}']`).find('.popup-window');
        var popupWindowWidth =  parseFloat(popupWindow.width());

        var pageHeight = jQuery(document).height();
        var pageWidth = jQuery(document).width();

        var positionTop = popupWindow.css("top");
        var positionLeft = popupWindow.css("left");

        if (settings.type === 'image' && parseInt(settings.width.replace('px', '')) > window.innerWidth)
        {
            const dimensions = getResponsiveDimensions(settings.width, settings.height);

            popupWindow.css('min-width', dimensions.width);
            popupWindow.css('max-width', dimensions.width);
            popupWindow.css('min-height', dimensions.height);
            popupWindow.css('max-height', dimensions.height);
        }

        if ('slideFromLeft' === animation)
        {
            popupWindow.css({left: -popupWindowWidth});
            popupWindow.css('min-width', popupWindowWidth);
            popupWindow.animate({left: positionLeft}, animationTime);
        }
        else if ('slideFromRight' === animation)
        {
            popupWindow.css({left: pageWidth});
            popupWindow.css('min-width', popupWindowWidth);
            popupWindow.animate({left: positionLeft}, animationTime);
        }
        else if ('slideFromTop' === animation)
        {
            popupWindow.css('top', "0px");
            popupWindow.animate({top: positionTop}, animationTime);
        }
        else if ('slideFromBottom' === animation)
        {
            popupWindow.css('top', pageHeight);
            popupWindow.animate({top: positionTop}, animationTime);
        }
        else if ('fadeIn' === animation)
        {
            popupWindow.css('display', 'none');
            popupWindow.fadeIn(animationTime);
        }

    }

    this.addClassToCloseButton = function (actualPopupWindow, className) {

        var closeButton = actualPopupWindow.find('a.close').first() ;
        closeButton.addClass(className);

    };

};
