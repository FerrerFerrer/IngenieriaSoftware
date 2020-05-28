jQuery(document).ready(function($) {
    if ( book_landing_page_ajax.ed_scrollbar ) {
        $("body").niceScroll({
            cursorcolor: "#63b03e",
            zindex: "10",
            cursorborder: "none",
            cursoropacitymin: "0",
            cursoropacitymax: "1",
            cursorwidth: "8px",
            cursorborderradius: "0px;"
        });
    }

    $('.widget_newsletterwidget .widget-title').each(function() {
        $(this.nextSibling).wrap('<span></span>');
    });

    //mobile-menu
    var winWidth = $(window).width();

    if (winWidth < 1025) {
        $('#menu-opener').click(function() {
            $('body').addClass('menu-open');

            $('.btn-close-menu').click(function() {
                $('body').removeClass('menu-open');
            });
        });

        $('.overlay').click(function() {
            $('body').removeClass('menu-open');
        });

        $('.main-navigation').prepend('<div class="btn-close-menu"></div>');

        $('.main-navigation ul .menu-item-has-children').append('<div class="angle-down"></div>');

        $('.main-navigation ul li .angle-down').click(function() {
            $(this).prev().slideToggle();
            $(this).toggleClass('active');
        });
    }

    if (winWidth > 1024) {
        //accessible menu in IE
        jQuery("#site-navigation ul li a").focus(function(){
            jQuery(this).parents("li").addClass("focus");
        }).blur(function(){
            jQuery(this).parents("li").removeClass("focus");
       });
    }


});