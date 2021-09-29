// JavaScript Document
jQuery(document).ready(function() {
/* Mobile */
	jQuery("#menu-trigger").on("click", function(){
		jQuery(".customize-menu").slideToggle();
	});
	
	// iPad
	var isiPad = navigator.userAgent.match(/iPad/i) != null;
		if (isiPad) jQuery('.linkedin-menu ul').addClass('no-transition');   
		
	jQuery(function () {

      // Slideshow 4
      jQuery("#slider4").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 500
		   });

    });
		var owl = jQuery("#owl-demo");
	 
	owl.owlCarousel({
			itemsCustom : [
			  [0, 1],
			  [450, 2],
			  [600, 2],
			  [700, 2],
			  [1000, 4],
			  [1200, 4],
			  [1400, 4],
			  [1600, 4]
			],
			itemsMobile : true,
			navigation : false,
			autoHeight : false,
	});	
	   
});      

(function ($) {
    var index = 0;
    $.fn.menumaker = function (options) {
        var mainmenu = jQuery(this),
            settings = jQuery.extend({
                title: "",
                breakpoint: 1024,
                format: "dropdown",
                sticky: false
            }, options);
        return this.each(function () {
            mainmenu.prepend('<div id="menu-button" class="fa fa-bars" aria-hidden="true">' + settings.title + '</div>');
            jQuery(this).find("#menu-button").on('click', function () {console.log('asd');
                jQuery(this).toggleClass('menu-opened');
                var mainmenu = jQuery(this).next('ul');
                if (mainmenu.hasClass('open')) {
                    mainmenu.slideToggle().removeClass('open');
                } else {
                    jQuery('ul.mobile-menu').slideToggle().addClass('open');
                    if (settings.format === "dropdown") {
                        mainmenu.find('ul').show();
                    }
                }
            });
            mainmenu.find('li ul').parent().addClass('has-sub');
            mainmenu.find('li ul').addClass('sub-menu');
            multiTg = function () {
                mainmenu.find(".has-sub").prepend('<span class="submenu-button fa fa-plus"></span>');
                mainmenu.find('.submenu-button').on('click', function () {
                    jQuery(this).toggleClass('submenu-opened');
                    if (jQuery(this).siblings('ul').hasClass('open')) {
                        jQuery(this).siblings('ul').slideToggle().removeClass('open');
                    } else {
                        jQuery(this).siblings('ul').slideToggle().addClass('open');
                    }
                });
            };
            if (settings.format === 'multitoggle') multiTg();
            else mainmenu.addClass('dropdown');
            if (settings.sticky === true) mainmenu.css('position', 'fixed');
            resizeFix = function () {
                if (jQuery(window).width() > 1024) {
                    mainmenu.find('ul').show();

                }
                if (jQuery(window).width() <= 1024) {
                    mainmenu.find('#menu-button').removeClass('menu-opened');
                    mainmenu.find('ul').hide().removeClass('open');
                }
            };
            resizeFix();
            return jQuery(window).on('resize', resizeFix);
        });
    };
})(jQuery);

(function ($) {
    jQuery(document).ready(function () {
        jQuery(document).ready(function () {
            jQuery("#mainmenu").menumaker({
                title: "",
                format: "multitoggle"
            });
            var foundActive = false,
                activeElement, linePosition = 0,
                width = 0,
                menuLine = jQuery("#mainmenu #menu-line"),
                lineWidth, defaultPosition, defaultWidth;
            jQuery("#mainmenu > ul > li").each(function () {
                if (jQuery(this).hasClass('current-menu-item')) {
                    activeElement = jQuery(this);
                    foundActive = true;
                }
            });
            if (foundActive != true) {
                activeElement = jQuery("#mainmenu > ul > li").first();
            }
            if (foundActive == true) {
                activeElement = jQuery("#mainmenu > ul > li").first();
            }
            defaultWidth = lineWidth = activeElement.width();
            defaultPosition = linePosition = (activeElement.position())?activeElement.position().left:'';
            menuLine.css("width", lineWidth);
            menuLine.css("left", linePosition);
            jQuery("#mainmenu > ul > li").hover(function () {
                    activeElement = $(this);
                    lineWidth = activeElement.width();
                    linePosition = activeElement.position().left;
                    menuLine.css("width", lineWidth);
                    menuLine.css("left", linePosition);
                },
                function () {
                    menuLine.css("left", defaultPosition);
                    menuLine.css("width", defaultWidth);
                });
        });
        /** Set Position of Sub-Menu **/
        var wapoMainWindowWidth = jQuery(window).width();
        jQuery('#mainmenu ul ul li').mouseenter(function () {
            var subMenuExist = jQuery(this).find('.sub-menu').length;
            if (subMenuExist > 0) {
                var subMenuWidth = jQuery(this).find('.sub-menu').width();
                var subMenuOffset = jQuery(this).find('.sub-menu').parent().offset().left + subMenuWidth;
                if ((subMenuWidth + subMenuOffset) > wapoMainWindowWidth) {
                    jQuery(this).find('.sub-menu').removeClass('submenu-left');
                    jQuery(this).find('.sub-menu').addClass('submenu-right');
                } else {
                    jQuery(this).find('.sub-menu').removeClass('submenu-right');
                    jQuery(this).find('.sub-menu').addClass('submenu-left');
                }
            }
        });
    });
})(jQuery);

/*Mobile Nav*/
function resize() {
    if (jQuery(window).width() <= 1024) {
        jQuery('#mainmenu > ul').addClass('mobile-menu');
    } else {
        jQuery('#mainmenu > ul').removeClass('mobile-menu');
    }
}    
