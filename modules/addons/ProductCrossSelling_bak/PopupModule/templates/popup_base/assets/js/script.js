jQuery(document).ready(function () {
    jQuery('body').on('click', '[id^=active-popup] a.close', function (event) {
        destroyPopup(jQuery(event.target).parents('.popup'), true);
    });

    jQuery('body').on('click', '[id^=active-popup] button.mg-popup-close', function (event) {
        destroyPopup(jQuery(event.target).parents('.popup'), true);
    });

    showPopup();
});

//jQuery(document).mouseup(function (e) {
//    var container = jQuery('#active-popup');
//    if (!container.is(e.target) && container.has(e.target).length === 0){
//        destroyPopup(container.find('.popup'), true);
//    }
//
//});

var showPopup = function () {
    var popup = getNextPopup();
    if(popup === false) {
        popup.parents('[id^=active-popup]').remove();
        return false;
    }

    $('.popup-container > .popup.active-popup').each(function(e,p){
        var popup = $(p); 
        delay = popup.attr('data-popup-delay');
        if(delay > 0)
        {
            popup.parent('.popup-container').attr('hidden',true);
            setTimeout(function(){ 
                popup.parent('.popup-container').attr('hidden',false);
                displayPopup(popup); 
            }, delay*1000);
        }else{
             displayPopup(popup); 
        }  
    });
};

var displayPopup = function(popup)
{
    if((typeof popup !== "undefined") || popup.length) {
        var settings = getPopupSettings(popup);
        popup.find('.popup-attributes').remove();

        popup.removeClass('not-shown').addClass('active-popup');
        var id = popup.attr('data-popup-id');
        var html = '<div class="popup" data-popup-id="'+id+'">'+popup.html()+'</div>';
        popup.remove();
        var idStyle = '#active-popup-'+popup.attr('data-popup-style');
        
        var pageHeight = jQuery(document).height();
        jQuery('body').prepend('<div id="active-popup-'+popup.attr('data-popup-style')+'">'+html+'</div>');
        //jQuery(idStyle).css("height", pageHeight);
        var activePopup = jQuery(idStyle+' .popup');

        var popupWindow = activePopup.find('.popup-window');
        activePopup.show();
        var mess = $('[data-popup-id="'+id+'"]').find('.message');
        var actualPopupWindow = $('[data-popup-id="'+id+'"]').find('.popup-window').first();

        var w = (settings.width === 'auto')? mess.outerWidth(true)+1:settings.width;
        var h = (settings.height === 'auto')? mess.outerHeight(true):settings.height;

        let dimensions = {};

        if (settings.type === 'image' && parseInt(settings.width.replace('px', '')) > window.innerWidth)
        {
            dimensions = getResponsiveDimensions(settings.width, settings.height);

            w = dimensions.width;
            h = dimensions.height
        }

        var messer = {"height": h, "width": w-1};
        if(settings.width === 'auto') {
            delete messer.width;
            mess.parents('.popup-window').css('max-width','50%');
        }

        if(settings.height === 'auto') {
            delete messer.height;
        }
        if(!jQuery.isEmptyObject(messer)){
            mess.css(messer);
        }

        if ('auto' !== settings.width)
        {
            actualPopupWindow.css('max-width', settings.width);
        }


        if($('[data-popup-id="'+id+'"]').find('.notshow-container').length > 0) {
               var minwidth = $('[data-popup-id="'+id+'"]').find('.notshow-container').outerWidth(true);
               if (typeof dimensions !== 'undefined'){
                   $('[data-popup-id="'+id+'"]').find('.notshow-container').css('min-width', dimensions.width)
               }
               actualPopupWindow.width() <= 240 ? actualPopupWindow.css('min-width', minwidth).css('max-width', minwidth+2) : actualPopupWindow.css('min-width', settings.width).css('max-width', settings.width);
        }

        var mediaQueryMobile = window.matchMedia('(max-width: 800px)');
        if(settings.width === 'auto' && mediaQueryMobile.matches) {
            mess.parents('.popup-window').css('max-width','90%');
            mess.parents('.popup-window').css('min-width','90%');
        }

        var settingsWidth = parseInt(settings.width.replace('px', ''));
        if ('center_popup_close_btn_4_overlay' === settings.style && !(340 >= actualPopupWindow.width()) && !(340 >= settingsWidth))
        {
            actualPopupWindow.css('max-width', settings.width);
            actualPopupWindow.find(".notshow-container").addClass("col-sm-8").css('width', '66%');
            actualPopupWindow.find(".popup-close").addClass("col-sm-4").css('width', '33%').css('padding-left', '0');
            var popupCloseBoxHeight  = actualPopupWindow.find(".notshow-container").length >0 ? actualPopupWindow.find(".notshow-container").outerHeight() + 30 : '70px';
            actualPopupWindow.find(".mg-popupClose-box").css("height", popupCloseBoxHeight);
        }

        if ('none' !== settings.animation)
        {
            setAnimation(settings, actualPopupWindow);
        }

        if (2 === settings.allow_not_show_again)
        {
            addClassToCloseButton(actualPopupWindow, 'closePermanent');
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

var getNextPopup = function () {
    $('.popup-container > .not-shown.popup').each(function(e,p){

        var popup = $(p);
        popup.removeClass('not-shown').addClass('active-popup');
        if (popup.length > 0) {
            if(canPopupBeShown(popup)) {
                return popup;
            }
            else{
                popup.remove();
            }
        } else {
            return false;
        }
    });


    //getNextPopup();
};

var canPopupBeShown = function (popup) {

    if(getQuery('debug_popup') || getQuery('debug_styles')){
        return true;
    }

    var settings = getPopupSettings(popup);
    var resultDisplayLimitForAll = displayLimitForAllMatches(settings);
    if(resultDisplayLimitForAll !== true) {
        this.destroyPopup(popup,settings.id, false);
        return false;
    }
    var resultDisplayLimit = displayLimitMatches(settings);
    if (resultDisplayLimit !== true) {
        destroyPopup(popup, false);
        return false;
    }
    var resultDates = datesMatches(settings);
    if(resultDates !== true) {
        destroyPopup(popup, false);
        return false;
    }
    var resultTrigger = triggerMatches(settings, popup);
    if(resultTrigger !== true) {
        destroyPopup(popup, false);
        return false;
    }
    
    return true;
};

var destroyPopup = function(popup, shown) {
    if(shown === true) {

        var notShowAgain = (popup.find('input.not-show-again:checked').length)? 1:0;
        notShowAgain = (popup.find('.closePermanent').length) ? 1 : notShowAgain;
        cookie = {
            'notShowAgain': notShowAgain,
            'lastTriggered': Date.now()
        };
        setPopupCookie(popup, cookie);
    }
    
    popup.fadeOut();
    //popup.remove();
    popup.parents('[id^=active-popup]').remove();
    //showPopup();
};

var displayLimitForAllMatches = function (settings) {

    var displayLimitForAll = settings.displayLimitForAll;
    var shown = settings.all_shown;

    return (displayLimitForAll >0 && displayLimitForAll <= shown) ? false : true;
};

var displayLimitMatches = function (settings) {

    var displayLimit = settings.displayLimit;
    var shown = settings.shown;

    return (displayLimit > 0 && displayLimit <= shown) ? false : true;

}

var datesMatches = function(settings) {
    var tempdate = new Date(settings.start.replace(/-/g,'/'));
    var startDate = tempdate.getTime();
    var tempdate = new Date(settings.end.replace(/-/g,'/'));
    var endDate = tempdate.getTime();
    var nowDate = Date.now();
    return (nowDate > startDate && nowDate < endDate)? true:false;    
};

var triggerMatches = function(settings, popup) {
    var cookie = getPopupCookie(popup);
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

var getPopupSettings = function(popup) {
    if(popup.find) {
        var settingsJson = popup.find('.popup-attributes').text();
        return JSON.parse(settingsJson);
    }
    return {};
};

var getPopupCookie = function(popup){
    var popupId = popup.attr('data-popup-id');
    var popupCookieId = 'popup-'+popupId;
    var cookieJson = jQuery.cookie(popupCookieId) || '{}';
    var cookie = $.parseJSON(cookieJson);
    return cookie;
};

var getQuery = function(q) {
    return (window.location.search.match(new RegExp('[?&]' + q + '=([^&]+)')) || [, null])[1];
};

var setAnimation = function (settings, popupWindow) {

    var animation = settings.animation;
    var animationTime = settings.animationTime;
    var style = settings.style;

    var pageHeight = parseFloat(jQuery(window).height());
    var pageWidth = parseFloat(jQuery(document).width());

    var popupWindowWidth =  parseFloat(popupWindow.width());
    var popupWindowHeight =  parseFloat(popupWindow.height());

    var top = parseFloat(popupWindow.css("top"));
    var left = parseFloat(popupWindow.css("left"));
    var bottom = parseFloat(popupWindow.css('bottom'));

    popupWindow.css('min-width', popupWindowWidth);
    popupWindow.css('min-height', settings.height);

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
        popupWindow.css('max-width', popupWindowWidth+2);
        popupWindow.css('left', -popupWindowWidth);
        popupWindow.animate({left: left}, animationTime);
    }
    else if ('slideFromRight' === animation)
    {
        popupWindow.css('max-width', popupWindowWidth+2);
        popupWindow.css('left', pageWidth+popupWindowWidth/2);
        popupWindow.animate({left: left}, animationTime);
    }
    else if ('slideFromTop' === animation)
    {
        popupWindow.css('max-height', popupWindowHeight + 2);
        if ( style.indexOf('down') !== -1)
        {
            popupWindow.css('bottom', pageHeight);
            popupWindow.animate({bottom: bottom}, animationTime);
            return;
        }
        var cssTop = ($('#active-popup-'+style)[0].offsetTop + popupWindowHeight);
        popupWindow.css('top', -cssTop);

        if (style.indexOf('down') !== -1 && style.indexOf('overlay') !== -1)
        {
            top = pageHeight - bottom - popupWindowHeight
        }
        popupWindow.animate({top: top}, animationTime);
    }
    else if ('slideFromBottom' === animation)
    {
        popupWindow.css('max-height', popupWindowHeight+2);
        if (style.indexOf('down') !== -1)
        {
            popupWindow.css('bottom', -popupWindowHeight);
            popupWindow.animate({bottom: bottom}, animationTime);
            return;
        }

        popupWindow.css('top', pageHeight+popupWindowHeight);
        popupWindow.animate({top: top}, animationTime);
    }
    else if ('fadeIn' === animation)
    {
        popupWindow.css('display', 'none');
        popupWindow.fadeIn(animationTime);
    }

};

var setPopupCookie = function(popup, cookie) {
    var popupId = popup.attr('data-popup-id');
    var popupCookieId = 'popup-'+popupId;

    jQuery.cookie(popupCookieId, JSON.stringify(cookie));
};


var addClassToCloseButton = function (actualPopupWindow, className) {

    var closeButton = actualPopupWindow.find('button.mg-popup-close').first().length ? actualPopupWindow.find('button.mg-popup-close').first() : actualPopupWindow.find('a.close').first() ;
    closeButton.addClass(className);

    };