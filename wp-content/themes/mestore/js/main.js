
  (function ($) {

    $(window).load(function () {
        $("#pre-loader").delay(500).fadeOut();
        $(".loader-wrapper").delay(1000).fadeOut("slow");

    });

    $(document).ready(function () { 

        /* tooltip */
        $('[data-toggle="tooltip"]').tooltip();

        $( ".add_to_cart_button" ).after( "<span class='tooltiptext-1'>" +mestore_object.add_to_cart + "</span>" );
        $( ".yith-wcqv-button" ).after( "<span class='tooltiptext-2'>" +mestore_object.quick_view + "</span>" );
        $( ".add_to_wishlist" ).after( "<span class='tooltiptext-3'>" +mestore_object.add_to_wishlist + "</span>" );

        $(".toggle-button").click( function () {
            $(this).parent().toggleClass("menu-collapsed");
        });     

         /*--- adding dropdown class to menu -----*/
        $("ul.sub-menu").parent().addClass("dropdown");
        $("ul.sub-menu").addClass("dropdown-menu");
        $("ul#menuid li.dropdown a").addClass("dropdown-toggle");
        $("ul.sub-menu li a").removeClass("dropdown-toggle"); 
        $('nav li.dropdown > a').append('<span class="caret"></span>');
        $('a.dropdown-toggle').attr('data-toggle', 'dropdown'); 

        //Side Bar
        function hdSideBarMenu() {
            $('.hd-bar .side-menu').find('.dropdown').children('ul').hide();
            $('.hd-bar .side-menu').find('li.dropdown > .la').each(function () {
                $(this).on('click', function (e) {
                   e.preventDefault();
                    return false;
                });
            });
        }
        hdSideBarMenu();

        //hd Sidebar
        if ($('.hd-bar').length) {
            $('.hd-bar-opener').on('click', function () {
                $('.hd-bar').addClass('visible-sidebar');
            });
            $('.hd-bar-opener').on('focus', function () {
                $('.hd-bar').addClass('visible-sidebar');
            });
            $('.hd-bar-closer').on('click', function () {
                $('.hd-bar').removeClass('visible-sidebar');
            });
        }
        
        /*-- Mobile menu --*/
        if($('#navbar-collapse-2').length) {
            $('#navbar-collapse-2 .navigation li.dropdown').append(function () {
              return '<i class="la la-angle-down" aria-hd="true"></i>';
            });
            $('#navbar-collapse-2 .navigation li.dropdown .la').on('click', function () {
              $(this).parent('li').children('ul').slideToggle();
            });
        }

        /* hd Sidebar menu */
        /* if WooCommerce is not activated */
        if ($('body').hasClass('woocommerce-active')) {
            $(".hd-bar-wrapper .header-woo-links > li a").on("focusout", function() {
                if ($('.hd-bar').length) { 
                    $('.hd-bar').removeClass('visible-sidebar');
                }
            });
        }
        else {
            $(".hd-bar-wrapper ul.navigation > li:last-child a").on("focusout", function() {
                if ($('.hd-bar').length) { 
                    $('.hd-bar').removeClass('visible-sidebar');
                }
            }); 
        }
        

        /*-- Search toggle. -- */
        var searchbutton = $('li #search-toggle');
        var searchbox = $('li #search-box');

            searchbutton.on('click', function(){
            if (searchbutton.hasClass('menu-search')){
                searchbutton.removeClass('menu-search').addClass('menu-search-x');
                searchbox.addClass('show-search-box');
            }
            
            else{
                searchbutton.removeClass('menu-search-x').addClass('menu-search');
                searchbox.removeClass('show-search-box');
            }
        });


        /*-- Button Up --*/
        var btnUp = $('<div/>', { 'class': 'btntoTop' });
        btnUp.appendTo('body');
        $(document).on('click', '.btntoTop', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 700);
        });

        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 200)
                $('.btntoTop').addClass('active');
            else
                $('.btntoTop').removeClass('active');
        });

    });        

})(this.jQuery);