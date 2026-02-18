;(function ($) {
"use strict";


        /*--
        Menu Sticky
    -----------------------------------*/
    var $window = $(window);
    $window.on('scroll', function() {
        var scroll = $window.scrollTop();
        if (scroll < 300) {
            $(".header-navbar").removeClass("stick");
        }else{
            $(".header-navbar").addClass("stick");
        }
    });
    

    
    $(".news-ticker-slider").owlCarousel({
        items : 1,
        loop : true,
        nav : true,
        dots : false,
        navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
    });
    
    var featured_owl =  $(".featured-slider")
    featured_owl.owlCarousel({
        items : 1,
        loop : true,
        autoHeight: true,
    });

    // featured_owl.on('mousewheel', '.owl-stage', function (e) {
    //     if (e.deltaY>0) {
    //         if(!$('.featured-slider .owl-dots .owl-dot:first').hasClass('active')) {
    //             featured_owl.trigger('prev.owl');
    //             e.preventDefault();
    //         }
    //     } else {
    //         if(!$('.featured-slider .owl-dots .owl-dot:last').hasClass('active')) {
    //             featured_owl.trigger('next.owl');
    //             e.preventDefault();
    //         }
    //     }
    // });
    
    
    $('.testimonial-slider').owlCarousel({
        center: true,
        items: 2,
        loop: true,
        margin: 30,
        responsive: {
          600: {
            items: 4
          }
        }
    });
    
    $(".collapse.show").each(function(){
        $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
    });

    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
    }).on('hide.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
    });


    




})(jQuery);