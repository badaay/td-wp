<?php 
/**
 * Theme Script
 *
 * @package TLG Theme
 *
 */

if( !function_exists('navian_fonts_url') ) {
	function navian_fonts_url() {
	    $fonts = navian_get_fonts();
	    $fonts_family  = array();

	    /*
	    Translators: If there are characters in your language that are not supported
	    by chosen font(s), translate this to 'off'. Do not translate into your own language.
	     */
	    if ( 'off' !== _x( 'on', 'Body font: on or off', 'navian' ) ) {
	    	$fonts_family[] = $fonts['body_font']['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Heading font: on or off', 'navian' ) ) {
	    	$fonts_family[] = $fonts['heading_font']['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Subtitle font: on or off', 'navian' ) ) {
	    	$fonts_family[] = $fonts['subtitle_font']['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Menu font: on or off', 'navian' ) ) {
	    	$fonts_family[] = $fonts['menu_font']['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Button font: on or off', 'navian' ) ) {
	    	$fonts_family[] = $fonts['button_font']['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'navian' ) ) {
	    	$fonts_family[] = 'Open Sans:400';
	    }
	    $query_args = array(
			'family' => urlencode( implode( '|', $fonts_family ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	    return esc_url_raw( $fonts_url );
	}
}

if( !function_exists('navian_load_scripts') ) {
	function navian_load_scripts() {
		global $post;
		wp_enqueue_style( 'navian-google-fonts', navian_fonts_url() );
		wp_enqueue_style( 'navian-libs', NAVIAN_THEME_DIRECTORY . 'assets/css/libs.css' );
		if( class_exists('bbPress') ) {
			wp_enqueue_style( 'navian-bbpress', NAVIAN_THEME_DIRECTORY . 'assets/css/bbpress.css' );
		}
		if (function_exists( 'tlg_framework_setup')) {
			wp_enqueue_style( 'navian-theme-styles', NAVIAN_THEME_DIRECTORY . 'assets/css/theme.less' );
		} else {
			wp_enqueue_style( 'navian-theme-styles', NAVIAN_THEME_DIRECTORY . 'assets/css/theme.min.css' );
		}
		wp_enqueue_style( 'navian-style', get_stylesheet_uri() );
		$custom_css = '';
		if( 'no' == get_option( 'navian_header_sticky', 'yes' ) ) {
		    $custom_css .= '.nav-container nav.fixed{position:absolute;}';
		}
		if( 'no' == get_option( 'navian_header_top_mobile', 'no' ) ) {
		    $custom_css .= '@media (max-width: 990px){.nav-container nav .nav-utility {display: none!important;}}';
		}
		if( 'yes' == get_option('navian_enable_scroll_top_mobile', 'no') ) {
			$custom_css .= '@media (max-width: 990px){.back-to-top {display: block!important;}}';
		}
		if( 'no' == get_option('navian_enable_minimal_line', 'yes') ) {
			$custom_css .= '.nav-container.minimal-header .social-list:before{display: none!important;}.nav-container.minimal-header .social-list {padding-left: 16px;}';
		}
		if( 'yes' == get_option('navian_header_sticky_mobile', 'no') ) {
		    $custom_css .= '@media (max-width: 990px) {nav {position: fixed!important;width: 100%;z-index: 9;}nav.fixed, nav.absolute {position: fixed!important;}.site-scrolled nav{background:#fff!important;top:0!important;}.site-scrolled nav .sub,.site-scrolled nav h1.logo,.site-scrolled nav .module.widget-wrap i{color:#252525!important;}.site-scrolled nav .logo-light{display:none!important;} .site-scrolled nav .logo-dark{display:inline-block!important;}}';
		}
		$primary_gradient_color = get_option('navian_color_primary_gradient', '');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_primary_gradient_color', true ) ) {
		    $primary_gradient_color = get_post_meta( $post->ID, '_tlg_primary_gradient_color', true );
		}
		if( $primary_gradient_color ) {
			$primary_color = get_option('navian_color_primary', '#49c5b6');
			if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_primary_color', true ) ) {
			    $primary_color = get_post_meta( $post->ID, '_tlg_primary_color', true );
			}
			$custom_css .= '.widget .title span, .widget .title cite, .widgettitle span, .widgettitle cite, .widgetsubtitle span, .widgetsubtitle cite, .lead span, .lead cite, .heading-title-standard span, .heading-title-standard cite, .heading-title-thin span, .heading-title-thin cite, .heading-title-bold span, .heading-title-bold cite, .primary-color, .primary-color a, .primary-color-hover:hover, .primary-color-hover:hover a, .primary-color-icon i, .primary-color-icon-hover:hover i, .primary-color .icon-link i{background: linear-gradient(to right, '.$primary_color.' 0%,'.$primary_gradient_color.' 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}';
		}
		$menu_bgcolor = get_option('navian_color_menu_bg', '');
		$menu_color = get_option('navian_color_menu', '');
		if( $menu_bgcolor || $menu_color ) {
			$custom_css .= '.vertical-menu .side-menu, .vertical-menu .subnav{background:'.$menu_bgcolor.'!important;}.vertical-menu li,.vertical-menu li a{border:none!important;} .vertical-menu li i {color: '.$menu_color.'!important;}.vertical-menu,.vertical-menu .text-center,.vertical-menu [class*="vertical-"]{background:'.$menu_bgcolor.'!important;color:'.$menu_color.'!important;}.vertical-menu a,.vertical-menu li{color:'.$menu_color.'!important;}.offcanvas-container.bg-dark .menu-line .menu--line{background-color:'.$menu_color.'!important;}.nav-container nav:not(.transparent), .nav-container nav.transparent.nav-show, nav .menu > li ul { background: '.$menu_bgcolor.'!important;}.nav-container nav:not(.transparent) .nav-utility { border-bottom-color: '.$menu_bgcolor.'; color: '.$menu_color.'; }.nav-container nav:not(.transparent) .nav-utility .social-list a, .nav-container nav:not(.transparent) .menu li:not(.menu-item-btn) a, nav .menu > li > ul li a, .mega-menu .has-dropdown > a, .nav-container nav:not(.transparent) .widget-wrap.module i, nav .has-dropdown:after, nav .menu > li ul > .has-dropdown:hover:after, nav .menu > li > ul > li a i, .nav-container nav.transparent.nav-show .menu li:not(.menu-item-btn) a, .nav-container nav.transparent.nav-show .widget-wrap.module i, .nav-container nav:not(.transparent) h1.logo, .nav-container nav.transparent.nav-show h1.logo {opacity: 1!important; color: '.$menu_color.'!important;}@media (max-width: 990px) {.nav-container nav .module-group .menu > li > a, .nav-container nav .module-group .menu > li > span.no-link, .nav-container nav .module-group .widget-wrap a, .nav-container nav .module-group .widget-wrap .search {background-color: '.$menu_bgcolor.'!important; border: none;}.nav-container nav .module-group .menu > li > a, .nav-container nav .module-group .module.widget-wrap i, .nav-container nav .module-group .widget-wrap a,.nav-container nav .module-group .has-dropdown:after{color: '.$menu_color.'!important;}}.mega-menu .has-dropdown > a{border-bottom:none;}';
		}
		$footer_bgcolor = get_option('navian_color_footer_bg', '');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_footerbg_color', true ) ) {
		    $footer_bgcolor = get_post_meta( $post->ID, '_tlg_footerbg_color', true );
		}
		$footer_color = get_option('navian_color_footer', '');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_footer_color', true ) ) {
		    $footer_color = get_post_meta( $post->ID, '_tlg_footer_color', true );
		}
		$footer_linkcolor = get_option('navian_color_footer_link', '');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_footerlink_color', true ) ) {
		    $footer_linkcolor = get_post_meta( $post->ID, '_tlg_footerlink_color', true );
		}
		if( $footer_bgcolor || $footer_color || $footer_linkcolor ) {
			$custom_css .= 'footer h1, footer h2, footer h3, footer h4, footer h5, footer h6{color:'.$footer_color.';} .sub-footer .menu a:after{background:'.$footer_linkcolor.'!important;} .footer-widget.bg-white .widget .tlg-posts-widget .tlg-posts-item .tlg-posts-content .tlg-posts-title:hover, .footer-widget.bg-white .widget .tlg-posts-widget .tlg-posts-item .tlg-posts-content .tlg-posts-title:focus,footer .sub-footer .social-list a,footer .sub-footer .menu a,.footer-widget .widget .twitter-feed .timePosted a, .footer-widget .widget .twitter-feed .timePosted a,.footer-widget .widget .twitter-feed .tweet a,footer a, footer a:hover, footer a:focus, footer h3 a, footer .widget_nav_menu li a, footer .widget_layered_nav li a, footer .widget_product_categories li a, footer .widget_categories .widget-archive li a, footer .widget_categories .post-categories li a, footer .widget_categories li a, footer .widget_archive .widget-archive li a, footer .widget_archive .post-categories li a, footer .widget_archive li a, footer .widget_meta li a, footer .widget_recent_entries li a, footer .widget_pages li a,.sub-footer .menu a,.bg-dark .sub-footer .menu a, .bg-graydark .sub-footer .menu a{color:'.$footer_linkcolor.'!important;} footer, footer .widget .title, footer .widget .widgettitle,.footer-widget .widget .twitter-feed .tweet,.footer-widget .widget .tlg-posts-widget .tlg-posts-item .tlg-posts-content .tlg-posts-date,footer .sub {color:'.$footer_color.'!important;} footer{background:'.$footer_bgcolor.'!important;} footer .sub-footer, footer .sub-footer{background:'.$footer_bgcolor.'!important;}footer .sub-footer, footer .sub-footer{border-top-color:'.$footer_color.'!important;}.bg-dark .widget .tlg-posts-widget .tlg-posts-item, .bg-graydark .widget .tlg-posts-widget .tlg-posts-item{border-bottom-color:'.$footer_bgcolor.'!important;}.btn-gray{border-color:'.$footer_color.'!important;}';
		}
		wp_add_inline_style( 'navian-style', $custom_css );
		wp_enqueue_script( 'bootstrap', NAVIAN_THEME_DIRECTORY . 'assets/js/bootstrap.js', array('jquery'), false, true );
		wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'jquery-equalheights', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.equalHeights.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-smooth-scroll', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.smooth-scroll.js', array('jquery'), false, true );
		wp_enqueue_script( 'owl-carousel', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/owl.carousel.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-flexslider', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.flexslider.js', array('jquery'), false, true );
		wp_enqueue_script( 'flickr', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/flickr.js', array('jquery'), false, true );
		wp_enqueue_script( 'jsparallax', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jsparallax.js', array('jquery'), false, true );
		wp_enqueue_script( 'waypoint', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/waypoint.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-counterup', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.counterup.js', array('jquery'), false, true );
		wp_enqueue_script( 'lightbox', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/lightbox.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-mb-ytplayer', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.mb.YTPlayer.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-countdown', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.countdown.js', array('jquery'), false, true );
		wp_enqueue_script( 'fluidvids', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/fluidvids.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-mcustomscrollbar', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.mCustomScrollbar.js', array('jquery'), false, true );
		wp_enqueue_script( 'modernizr', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/modernizr.js', array('jquery'), false, true );
		wp_enqueue_script( 'classie', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/classie.js', array('jquery'), false, true );
		wp_enqueue_script( 'animonscroll', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/animOnScroll.js', array('jquery'), false, true );
		wp_enqueue_script( 'gmap3', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/gmap3.js', array('jquery'), false, true );
		wp_enqueue_script( 'isotope', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/isotope.pkgd.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-photoswipe', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/jquery.photoswipe.js', array('jquery'), false, true );
		wp_enqueue_script( 'iscroll', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/iscroll.js', array('jquery'), false, true );
		wp_enqueue_script( 'fullpage', NAVIAN_THEME_DIRECTORY . 'assets/js/lib/fullpage.js', array('jquery'), false, true );
		wp_enqueue_script( 'navian-scripts', NAVIAN_THEME_DIRECTORY . 'assets/js/scripts.js', array('jquery'), false, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_localize_script( 'navian-scripts', 'wp_data', array(
			'navian_ajax_url' 	 => esc_js(admin_url( 'admin-ajax.php' )),
			'navian_menu_height' => esc_js(get_option( 'navian_menu_height', '58' )),
			'navian_menu_open' 	 => esc_js(get_option( 'navian_menu_open', 'yes' )),
		));
	}
	add_action( 'wp_enqueue_scripts', 'navian_load_scripts', 110 );
}

if( !function_exists('navian_admin_load_scripts') ) {
	function navian_admin_load_scripts() {
		wp_enqueue_style( 'navian-google-fonts', navian_fonts_url() );
		wp_enqueue_style( 'navian-fonts', NAVIAN_THEME_DIRECTORY . 'assets/css/fonts.css' );
		wp_enqueue_style( 'navian-admin-css', NAVIAN_THEME_DIRECTORY . 'assets/css/admin.css' );
		$custom_css = '';
		if( 'no' == get_option( 'navian_enable_portfolio', 'yes' ) ) {
			$custom_css .= '#menu-posts-portfolio,[data-element="tlg_portfolio"]{display:none!important;}';
		}
		if( 'no' == get_option( 'navian_enable_team', 'yes' ) ) {
			$custom_css .= '#menu-posts-team,[data-element="tlg_team"]{display:none!important;}';
		}
		if( 'no' == get_option( 'navian_enable_client', 'yes' ) ) {
			$custom_css .= '#menu-posts-client,[data-element="tlg_clients"]{display:none!important;}';
		}
		if( 'no' == get_option( 'navian_enable_testimonial', 'yes' ) ) {
			$custom_css .= '#menu-posts-testimonial,[data-element="tlg_testimonial"]{display:none!important;}';
		}
		if( 'no' == get_option( 'navian_enable_vc_templates', 'no' ) ) {
			$custom_css .= '#vc_templates-editor-button {display: none!important;}';
		}
		if( $custom_css ) {
			wp_add_inline_style( 'navian-admin-css', $custom_css );
		}
		wp_enqueue_media();
		wp_enqueue_script( 'navian-admin-js', NAVIAN_THEME_DIRECTORY . 'assets/js/admin.js', array('jquery'), false, true );
	}
	add_action( 'admin_enqueue_scripts', 'navian_admin_load_scripts', 200 );
}

if( !function_exists('navian_less_vars') ) {
	function navian_less_vars( $vars, $handle = 'navian-theme-styles' ) {
		global $post;
		$primary_color = get_option('navian_color_primary', '#49c5b6');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_primary_color', true ) ) {
		    $primary_color = get_post_meta( $post->ID, '_tlg_primary_color', true );
		}
		$submenu_bg_color = get_option('navian_color_submenu_bg', '#1b1a1a');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_submenu_bg_color', true ) ) {
		    $submenu_bg_color = get_post_meta( $post->ID, '_tlg_submenu_bg_color', true );
		}
		$submenu_color = get_option('navian_color_submenu', '#fff');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_submenu_color', true ) ) {
		    $submenu_color = get_post_meta( $post->ID, '_tlg_submenu_color', true );
		}
		$menu_text_transform = get_option('navian_menu_text_transform', 'none');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_menu_text_transform', true ) ) {
		    $menu_text_transform = get_post_meta( $post->ID, '_tlg_menu_text_transform', true );
		}
		$submenu_text_transform = get_option('navian_submenu_text_transform', 'none');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_submenu_text_transform', true ) ) {
		    $submenu_text_transform = get_post_meta( $post->ID, '_tlg_submenu_text_transform', true );
		}
		$fonts = navian_get_fonts();
		$vars['body-font']       	 		= $fonts['body_font']['name'];
		$vars['body-font-weight']    		= $fonts['body_font']['weight'];
		$vars['body-font-style']   	 		= $fonts['body_font']['style'];
		$vars['heading-font']    	 		= $fonts['heading_font']['name'];
		$vars['heading-font-weight'] 		= $fonts['heading_font']['weight'];
		$vars['heading-font-style']  		= $fonts['heading_font']['style'];
		$vars['subtitle-font']    	 		= $fonts['subtitle_font']['name'];
		$vars['subtitle-font-weight']    	= $fonts['subtitle_font']['weight'];
		$vars['menu-font']    	 	 		= $fonts['menu_font']['name'];
		$vars['menu-font-weight']  	 		= $fonts['menu_font']['weight'];
		$vars['submenu-font']    	 	 	= $fonts['submenu_font']['name'];
		$vars['submenu-font-weight']  	 	= $fonts['submenu_font']['weight'];
		$vars['button-font']    	 		= $fonts['button_font']['name'];
		$vars['button-font-weight']  		= $fonts['button_font']['weight'];
		$vars['widget-font-weight']  		= '100' == $fonts['heading_font']['weight'] ? '300' : ('700' == $fonts['heading_font']['weight'] ? '600' : $fonts['heading_font']['weight']);
		$vars['primary-color']   	 		= $primary_color;
		$vars['submenu-bg-color'] 	 		= $submenu_bg_color;
		$vars['submenu-color'] 	 			= $submenu_color;
		$vars['menu-text']   	 	 		= $menu_text_transform;
		$vars['submenu-text']   	 	 	= $submenu_text_transform;
		$vars['text-color']    	 	 		= get_option('navian_color_text', '#616a66');
		$vars['bg-dark-color']       		= get_option('navian_color_bg_dark', '#222');
		$vars['secondary-color'] 	 		= get_option('navian_color_secondary', '#f7f7f7');
		$vars['menu-badge-color'] 	 		= get_option('navian_color_menu_badge', '#fc1547');
		$vars['menu-height']   		 		= get_option('navian_menu_height', '58').'px';
		$vars['page-title-height']   		= get_option('navian_page_title_height', '400').'px';
		$vars['body-font-size']    			= get_option('navian_body_font_size', '16').'px';
		$vars['menu-font-size']   	 		= get_option('navian_menu_font_size', '15').'px';
		$vars['submenu-font-size']   		= get_option('navian_submenu_font_size', '15').'px';
		$vars['header-font-size']    		= get_option('navian_header_font_size', '30').'px';
		$vars['subtitle-font-size']    		= get_option('navian_subtitle_font_size', '15').'px';
		$vars['widget-font-size']    		= get_option('navian_widget_font_size', '20').'px';
		$vars['header-text']   	 	 		= get_option('navian_header_text_transform', 'none');
		$vars['button-text']   	 	 		= get_option('navian_button_text_transform', 'none');
	    return $vars;
	}
	if (function_exists( 'tlg_framework_setup')) {
		add_filter( 'less_vars', 'navian_less_vars', 10, 2 );
	}
}