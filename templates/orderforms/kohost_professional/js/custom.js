// fixed navbar
jQuery(document).ready(function () {
    jQuery( "body" ).scroll(function() {
      // checks if window is scrolled more than 500px, adds/removes solid class
        if (jQuery(this).scrollTop() > 0) {
            jQuery('.header-main-menu').addClass('header-fixed');
        } else {
            jQuery('.header-main-menu').removeClass('header-fixed');
        }
    });
    
});
