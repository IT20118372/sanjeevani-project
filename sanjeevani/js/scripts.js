$(window).on('load', function(){
    commonScripts();
    mainSlider();
    // Mobile menu expand function
    mobileExpander();
});


//trigger the scroll
$(window).scroll(function() {
    var currentPoint = $(this).scrollTop();
    if ( currentPoint > 170 ){
        $('.navigation').addClass('fixed');
    }else{
        $('.navigation').removeClass('fixed');
    }
});

/* When documents is ready */
$(document).ready(function(){
    var $mainMenuState = $('#main-menu-state');
    if ($mainMenuState.length) {
        // animate mobile menu
        $mainMenuState.change(function(e) {
            var $menu = $('#main-menu');
            if (this.checked) {
                $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
            } else {
                $menu.show().slideUp(250, function() { $menu.css('display', ''); });
            }
        });
        // hide mobile menu beforeunload
        $(window).on('beforeunload unload', function() {
            if ($mainMenuState[0].checked) {
                $mainMenuState[0].click();
            }
        });
    }

    if (window.matchMedia("(min-width: 992px)").matches){
        var windowInnerHeight = $(window).innerHeight();
        $('.main-banner.home-page').css('height', windowInnerHeight);
    }

    $(window).resize(function(){
        if (window.matchMedia("(min-width: 992px)").matches){
            var windowInnerHeight = $(window).innerHeight();
            $('.main-banner.home-page').css('height', windowInnerHeight);
        }else{
            $('.main-banner.home-page').css('height', 'auto');
        }
    });
});

/* When documents is resize */
$(window).on('resize',function(event){});

// Main slider all functionality including video slider

function mainSlider(){
    if ( rest_of_slide.length ){
        var mainSliderArgs = {
            items: 1,
            dots: false,
            nav: false,
            autoplay: true,
            autoplayTimeout: 10000,
            loop: true,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            responsive: {
                1200: {
                    dots: false,
                    nav: true
                }
            }
        }
        $('.main-banner').append(rest_of_slide).owlCarousel(mainSliderArgs);
    }
}

// All the common js goes here
function commonScripts(){

    $("#readmore").owlCarousel({
		loop: true,
		responsive: {
			0: {
				items: 1,
				margin: 10,
                dots: true,
			},
			600: {
				items: 1,
				margin: 10,
                dots: true,
			},
			1000: {
				items: 1,
				margin: 60,
			},
			1200: {
				items: 3,
				margin: 20,
			},
		},
	});
}

function slidrerOnlyMobile(elem, breakpoint, args) {
	
    if ($(elem)[0]) {
        var s = $(elem);
        
        if (window.innerWidth < breakpoint) {
            s.owlCarousel(args)
		} else s.addClass("off"); 
		
        $(window).resize(function (e) {
            if (window.innerWidth < breakpoint) {
                if ($(elem).hasClass("off")) {
                    s.owlCarousel(args);
                    s.removeClass("off")
                }
            } else $(elem).hasClass("off") || (s.addClass("off").trigger("destroy.owl.carousel"), s.find(".owl-stage-outer").children(":eq(0)").unwrap())
        })
    }
}

function mobileExpander(){
    var svgElePlus      =   '<svg width="30" height="30" aria-hidden="true"><use xmlns:xlink="http://www.w3.org/1999/xlink"  xlink:href="#menu_plus"></use></svg>';
    var svgEleMinus     =   '<svg width="30" height="30" aria-hidden="true"><use xmlns:xlink="http://www.w3.org/1999/xlink"  xlink:href="#menu_minus"></use></svg>';

    $('#main-menu li').each(function(){
        if($(this).hasClass('menu-item-has-children')){
            $(this).find('a').first().after('<div class="expicon">'+svgElePlus+'</div>');
        }
    });

    if (window.matchMedia("(min-width: 1200px)").matches) {
        $("#main-menu li").each(function(){
            if($(this).hasClass('menu-item-has-children')){
                $(this).addClass('hasExpanded');
            }
        });
        $('.hasExpanded').mouseenter(function(){
            $(this).find('.expicon').first().html(svgEleMinus);
            $(this).find('.sub-menu').slideDown();
        });

        $('.hasExpanded').mouseleave(function(){
            $(this).find('.expicon').first().html(svgElePlus);
            $(this).find('.sub-menu').slideUp();
        })
    }else{
        $('.menu-item-has-children .expicon').on('click', function(){
            $(this).parent().find('.sub-menu').first().slideToggle();
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                $(this).html(svgEleMinus);
            }else{
                $(this).html(svgElePlus);
            }
        });
    }
}

// Script for larger screen
if(window.matchMedia("(min-width: 1200px)").matches){}