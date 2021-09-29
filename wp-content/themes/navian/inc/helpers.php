<?php
/**
 * Theme Helper
 *
 * @package TLG Theme
 *
 */

/**
	REGISTER REQUIRED PLUGINS
**/
if( !function_exists('navian_register_required_plugins') ) {
	function navian_register_required_plugins() {
		$plugins = array(
			array( 
				'name' => esc_html__( 'TLG Framework', 'navian' ),
				'slug' => 'tlg_framework',
				'source' => get_template_directory() . '/plugins/tlg_framework.zip',
				'required' => true,
				'force_activation' => false,
				'force_deactivation' => true,
				'version' => '3.0.8',
			),
			array( 
				'name' => esc_html__( 'WPBakery Page Builder (formerly Visual Composer)', 'navian' ),
				'slug' => 'js_composer',
				'source' => get_template_directory() . '/plugins/js_composer.zip',
				'required' => true,
				'force_activation' => false,
				'force_deactivation' => false,
				'version' => '6.6.0',
			),
			array( 
				'name' => esc_html__( 'Revolution Slider', 'navian' ),
				'slug' => 'revslider',
				'source' => get_template_directory() . '/plugins/revslider.zip',
				'required' => false,
				'force_activation' => false,
				'force_deactivation' => false,
				'version' => '6.4.11',
			),
			array( 
				'name' => esc_html__( 'Contact Form 7', 'navian' ), 
				'slug' => 'contact-form-7', 
				'required' => false,
				'force_activation' => false,
				'force_deactivation' => false,
			),
			array( 
				'name' => esc_html__( 'WooCommerce', 'navian' ), 
				'slug' => 'woocommerce', 
				'required' => false,
				'force_activation' => false,
				'force_deactivation' => false,
			),
		);
		tgmpa( $plugins, array( 'is_automatic' => true ) );
	}
	add_action( 'tgmpa_register', 'navian_register_required_plugins' );
}
	

/**
	THE PAGE TITLE
**/
if( !function_exists( 'navian_get_the_page_title' ) ) {
	function navian_get_the_page_title( $args = array() ) {
		$output = $title = $subtitle = $image = $background = $size = $layout = false;
		extract( $args );
		$layout = $layout ? $layout : 'center';
		$leadtitle = isset($leadtitle) ? $leadtitle : '';
		$bg_overlay = '';
		$styles_overlay = '';
		if (!in_array($layout, array('center','center-large','left','left-large'))) {
			if ('yes' == get_option( 'tlg_framework_page_layout_overlay', 'yes' )) {
				$overlay_color = get_option( 'tlg_framework_page_layout_color', '' );
				if (!empty($overlay_color)) {
					$styles_overlay = 'background-color:'.$overlay_color.';opacity:0.8;display: block;';
					$overlay_gradient = get_option( 'tlg_framework_page_layout_gradient', '' );
					if (!empty($overlay_gradient)) {
						$styles_overlay .= 'background: linear-gradient(to right,'.$overlay_color.' 0%,'.$overlay_gradient.' 100%);';
					}
				}
				$bg_overlay = '<div style="' . esc_attr( $styles_overlay ) . '" class="background-overlay"></div>';
			}
		}
		switch ( $layout ) {
			case 'center': $background = false; $image = false; $layout = 'center'; break;
			case 'center-large': $background = false; $image = false; $size = 'large'; $layout = 'center'; break;
			case 'center-bg': $background = 'image-bg overlay'; $layout = 'center'; break;
			case 'center-bg-large': $background = 'image-bg overlay'; $size = 'large'; $layout = 'center'; break;
			case 'center-parallax': $background = 'image-bg overlay parallax'; $layout = 'center'; break;
			case 'center-parallax-large': $background = 'image-bg overlay parallax'; $size = 'large'; $layout = 'center'; break;
			case 'left': $background = false; $image = false; $layout = 'left'; break;
			case 'left-large': $background = false; $image = false; $size = 'large'; $layout = 'left'; break;
			case 'left-bg': $background = 'image-bg overlay'; $layout = 'left'; break;
			case 'left-bg-large': $background = 'image-bg overlay'; $size = 'large'; $layout = 'left'; break;
			case 'left-parallax': $background = 'image-bg overlay parallax'; $layout = 'left'; break;
			case 'left-parallax-large': $background = 'image-bg overlay parallax'; $size = 'large'; $layout = 'left'; break;
			default: break;
		}
		$page_title_tag = get_option( 'tlg_framework_page_title_tag', 'h1' );
		if ( 'center' == $layout ) {
			$output = '<section class="page-title page-title-'.( 'large' == $size ? 'large-center' : 'center'  ).' '. esc_attr($background) .'">'.
							($image ? '<div class="background-content">'.$image.$bg_overlay.'</div>' : '').'
							<div class="container"><div class="row"><div class="col-lg-10 col-sm-12 col-lg-offset-1 text-center">
								'.navian_page_title_meta($leadtitle).'
					        	<'.$page_title_tag.' class="heading-title">'. $title .'</'.$page_title_tag.'>
					        	<p class="lead mb0">'. $subtitle .'</p>
					        	'.navian_breadcrumbs().'
							</div></div></div></section>';
		} elseif ( 'left' == $layout ) {
			$output = '<section class="page-title page-title-'.( 'large' == $size ? 'large' : 'basic'  ).' '. esc_attr($background) .'">'.
							($image ? '<div class="background-content">'.$image.$bg_overlay.'</div>' : '').'
							<div class="container"><div class="row">
								<div class="col-md-6">
									'.navian_page_title_meta($leadtitle).'
					        		<'.$page_title_tag.' class="heading-title">'. $title .'</'.$page_title_tag.'>
					        		<p class="lead mb0">'. $subtitle .'</p>
								</div>
								<div class="col-md-6 text-right pt8">'.navian_breadcrumbs().'</div>
							</div></div></section>';
		}
		return $output;
	}
}

/**
	GET PAGE TITLE LAYOUT
**/
if( !function_exists('navian_get_page_title_layout') ) {
	function navian_get_page_title_layout() {
		global $post;
		$layout = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_page_title_layout', 1 ) : false;
		if( ! $layout || 'default' == $layout ) {
			$layout = get_option( 'navian_page_layout', 'center-large' );
		}
		return $layout;	
	}
}

/**
	GET BODY LAYOUT
**/
if( !function_exists('navian_get_body_layout') ) {
	function navian_get_body_layout() {
		global $post;
		$layout = isset( $_GET['layout'] ) ? $_GET['layout'] : false;
		if( $layout ) {
			if( 'boxed' ==  $layout || 'boxed-layout' ==  $layout ) $layout = 'boxed-layout';
			elseif( 'border' ==  $layout || 'frame-layout' ==  $layout ) $layout = 'frame-layout';
			else $layout = 'normal-layout';
		} else {
			$layout = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_layout_override', 1 ) : false;
			if( ! $layout || 'default' == $layout ) {
				$layout = get_option( 'navian_site_layout', 'normal-layout' );
			}
		}
		return $layout;
	}
}

/**
	GET CONTAINER LAYOUT
**/
if( !function_exists('navian_get_container_layout') ) {
	function navian_get_container_layout() {
		global $post;
		$container_layout = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_container_override', 1 ) : false;
		if( ! $container_layout || 'default' == $container_layout ) {
			$container_layout = get_option( 'navian_container_layout', 'normal-container' );
		}
		return $container_layout;
	}
}

/**
	GET HEADER LAYOUT
**/
if( !function_exists('navian_get_header_layout') ) {
	function navian_get_header_layout() {
		global $post;
		$default_header = get_option( 'navian_header_layout', 'standard' );
		$header = isset ($_GET['nav'] ) ? $_GET['nav'] : false;
		if( $header ) {
			return $header;
		}
		if( class_exists('Woocommerce') ) {
			if( is_shop() || is_product_category() || is_product_tag() ) {
				$shop_header = get_option( 'navian_shop_menu_layout', 'default' );
				if( $shop_header && 'default' != $shop_header ) {
					return $shop_header;
				}
			}
		}
		if( is_home() || is_archive() || is_search() || ! isset( $post->ID ) ) {
			return $default_header;
		}
		$header = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_header_override', 1 ) : false;
		if( ! $header || 'default' == $header ) {
			$header = $default_header;
		}
		return $header;	
	}
}

/**
	GET FOOTER LAYOUT
**/
if( !function_exists('navian_get_footer_layout') ) {
	function navian_get_footer_layout() {
		global $post;
		$footer = isset ($_GET['footer'] ) ? $_GET['footer'] : false;
		if( $footer ) {
			return $footer;
		}
		if( ! isset( $post->ID ) ) {
			return get_option( 'navian_footer_layout', 'standard' );
		}
		$footer = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_footer_override', 1 ) : false;
		if( ! $footer || 'default' == $footer || ( class_exists('Woocommerce') && ( is_shop() || is_product_category() || is_product_tag() ) ) ) {
			$footer = get_option( 'navian_footer_layout', 'standard' );
		}
		return $footer;	
	}
}

/**
	GET SINGLE SIDEBAR LAYOUT
**/
if( !function_exists('navian_get_single_sidebar_layout') ) {
	function navian_get_single_sidebar_layout() {
		global $post;
		$sidebar = isset ($_GET['sb'] ) ? $_GET['sb'] : false;
		if( $sidebar ) return $sidebar;

		if( ! isset( $post->ID ) ) {
			return get_option( 'navian_post_layout', 'sidebar-none' );
		}
		$sidebar = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_single_sidebar_override', 1 ) : false;
		if( ! $sidebar || 'default' == $sidebar ) {
			$sidebar = get_option( 'navian_post_layout', 'sidebar-none' );
		}
		return $sidebar;	
	}
}

if( !function_exists('navian_get_menu_title') ) {
	function navian_get_menu_title( $theme_location, $default_name = '' ) {
		if ( $theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $theme_location ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $theme_location ] );
			if( $menu && $menu->name ) {
				return $menu->name;
			}
		}
		return $default_name;
	}
}

/**
	GET POSTS CATEGORY
**/
if( !function_exists('navian_get_posts_category') ) {
	function navian_get_posts_category( $taxonomy = 'category' ) {
		$cats = array( esc_html__( 'Show all categories', 'navian' ) => 'all' );
		$post_cats = get_categories( array( 'orderby' => 'name', 'hide_empty' => 0, 'hierarchical' => 1, 'taxonomy' => $taxonomy ) );
		if( is_array( $post_cats ) && count( $post_cats ) ) {
			foreach( $post_cats as $cat ) {
				if ( isset( $cat->name ) && isset( $cat->term_id ) ) {
					$cats[$cat->name] = $cat->term_id;
				}
			}
		}
		return $cats;
	}
}

/**
	GET PORTFOLIO LINK
**/
if( !function_exists('navian_get_portfolio_link') ) {
	function navian_get_portfolio_link( $class = '' ) {
		global $post;
		$link_prefix = '<a class="'.esc_attr($class).'" href="'.esc_url( get_permalink() ).'">';
		$link_sufix  = '</a>';
		$lightbox  = false;
		$gallery = isset ($_GET['gallery'] ) ? $_GET['gallery'] : false;
		$gallery_item = isset($post->ID) ? get_post_meta( $post->ID, '_tlg_portfolio_gallery', 1 ) : '';
		if ( $gallery || $gallery_item || 'yes' == get_option( 'navian_portfolio_gallery', 'no' ) ) {
		    $url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		    if ( isset($url[0]) && $url[0] ) {
		        $link_prefix = '<a class="'.esc_attr($class).'" href="'. esc_url($url[0]) .'" data-lightbox="true" data-title="'.get_the_title().'">';
		        $lightbox = true;
		    }
		} else {
		    $external_url = isset($post->ID) ? get_post_meta( $post->ID, '_tlg_portfolio_external_url', 1 ) : '';
		    if ($external_url) {
		        $target     = get_post_meta( $post->ID, '_tlg_portfolio_url_new_window', 1 )  ? '_blank' : '_self';
		        $rel        = get_post_meta( $post->ID, '_tlg_portfolio_url_nofollow', 1 )  ? 'nofollow' : '';
		        $link_prefix    = '<a class="'.esc_attr($class).'" href="'.esc_url( $external_url ).'" target="'.esc_attr($target).'" rel="'.esc_attr($rel).'">';
		    }
		}
		return array(
			'prefix' 	=> $link_prefix,
			'sufix' 	=> $link_sufix,
			'lightbox' 	=> $lightbox,
		);
	}
}

/**
	PORTFOLIO FILTERS
**/
if( !function_exists( 'navian_portfolio_filters' ) ) {
	function navian_portfolio_filters($project_id = '', $layout_full = false) {
		$output = '';
	    if (!empty($project_id)) {
	    	$terms = get_terms('portfolio_category');
	    	if (is_array($terms) && !empty($terms)) {
	    		$filter_effect = get_option( 'tlg_framework_portfolio_filter', '' );
	    		if ($layout_full) {
	    			$wrapper = '<div class="line-height-1">';
	    			$wrapper_end = '</div>';
	    			$class = "filters ".$filter_effect." pt40 pb40 mb0";
	    		} else {
	    			$wrapper = '<div class="row"><div class="col-sm-12">';
	    			$wrapper_end = '</div></div>';
	    			$class = "filters ".$filter_effect." mb0 pb40";
	    		}
		    	$output .= $wrapper.'<ul class="'.esc_attr($class).'" data-project-id="'.esc_attr($project_id).'">
		    		<li class="filter active" data-group="*"><a href="#">'.esc_html__( 'All', 'navian' ).'</a></li>';
		    	foreach ($terms as $term) {
		    	$output .= '<li class="filter" data-group=".'. esc_attr(md5(sanitize_title($term->name))) .'"><a href="#">'. esc_html($term->name) .'</a></li>';
		        }
		    	$output .= '</ul>'.$wrapper_end;
		    }
	    }
	    return $output;
	}
}

/**
	PORTFOLIO FILTERS GROUP
**/
if( !function_exists( 'navian_portfolio_filters_group' ) ) {
	function navian_portfolio_filters_group() {
		global $post;
		$output = '';
		$categories = array();
		$terms = get_the_terms( $post->ID, 'portfolio_category');
		if (is_array($terms) && !empty($terms)) {
			foreach ($terms as $term) {
				$categories[] = md5(sanitize_title($term->name));
			}
			$output = implode(' ', $categories);
		}
		return $output;
	}
}

/**
	GET LOGO SETTING
**/
if( !function_exists('navian_get_logo') ) {
	function navian_get_logo() {
		global $post;
		$logo = get_option('navian_custom_logo', NAVIAN_THEME_DIRECTORY . 'assets/img/logo-dark.png');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_logo', true ) ) {
		    $logo = get_post_meta( $post->ID, '_tlg_logo', true );
		}
		$logo_light = get_option('navian_custom_logo_light', NAVIAN_THEME_DIRECTORY . 'assets/img/logo-light.png');
		if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_logo_light', true ) ) {
		    $logo_light = get_post_meta( $post->ID, '_tlg_logo_light', true );
		}
		$enable_retina = true;
		if( isset( $post->ID ) ) {
			$enable_retina = get_post_meta( $post->ID, '_tlg_enable_retina', true );
			if (empty($enable_retina)) {
				$enable_retina = ('yes' == get_option( 'navian_enable_retina', 'yes' ));
			} elseif ('no' == $enable_retina) {
				$enable_retina = false;
			} 
		} else {
			$enable_retina = ('yes' == get_option( 'navian_enable_retina', 'yes' ));
		}
		if ( $enable_retina ) {
			$logo_retina = get_option('navian_custom_logo_retina', NAVIAN_THEME_DIRECTORY . 'assets/img/logo-dark-2x.png');
			if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_logo_retina', true ) ) {
			    $logo_retina = get_post_meta( $post->ID, '_tlg_logo_retina', true );
			}
			$logo_light_retina = get_option('navian_custom_logo_light_retina', NAVIAN_THEME_DIRECTORY . 'assets/img/logo-light-2x.png');
			if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_logo_light_retina', true ) ) {
			    $logo_light_retina = get_post_meta( $post->ID, '_tlg_logo_light_retina', true );
			}
			$logo_srcset = $logo . ' 1x, ' . $logo_retina . ' 2x';
			$logo_light_srcset = $logo_light . ' 1x, ' . $logo_light_retina . ' 2x';
		} else {
			$logo_srcset = '';
			$logo_light_srcset = '';
		}
		$logo = preg_replace( '/^https?:/', '', $logo );
		$logo_light = preg_replace( '/^https?:/', '', $logo_light );
		$logo_srcset = preg_replace( '/^https?:/', '', $logo_srcset );
		$logo_light_srcset = preg_replace( '/^https?:/', '', $logo_light_srcset );
		$site_logo = get_option( 'navian_site_logo', 'image' ); 
        $logo_text = get_option( 'navian_logo_text', '' );
		return array(
			'logo' 				=> $logo,
			'logo_light' 		=> $logo_light,
			'logo_srcset' 		=> $logo_srcset,
			'logo_light_srcset' => $logo_light_srcset,
			'site_logo' 		=> $site_logo,
			'logo_text' 		=> $logo_text,
		);
	}
}

/**
	GET HEADER INFO
**/
if( !function_exists('navian_get_header_info') ) {
	function navian_get_header_info() {
		global $post;
		if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_text', 1 ))) && 'yes' == get_option( 'navian_header_text', 'yes' ) ) {
			$first_text = get_option('navian_header_first', '' );
			$second_text = get_option('navian_header_second', '' );
		} else {
			$first_text = $second_text = '';
		}
		$third_text = get_option('navian_header_third', '');
		$first_icon = get_option('navian_header_first_icon') ? '<i class="' . esc_attr(get_option("navian_header_first_icon")) . '"></i> ' : '';
		$second_icon = get_option('navian_header_second_icon') ? '<i class="' . esc_attr(get_option("navian_header_second_icon")) . '"></i> ' : '';
		$third_icon = get_option('navian_header_third_icon') ? '<i class="' . esc_attr(get_option("navian_header_third_icon")) . '"></i> ' : '';
		$footer_text = get_option('navian_footer_copyright', '');
		return array(
			'first_text' 	=> $first_text,
			'second_text' 	=> $second_text,
			'third_text' 	=> $third_text,
			'first_icon' 	=> $first_icon,
			'second_icon' 	=> $second_icon,
			'third_icon' 	=> $third_icon,
			'footer_text' 	=> $footer_text,
		);
	}
}

/**
	GET HEADER CLASS
**/
if( !function_exists('navian_get_header_class') ) {
	function navian_get_header_class() {
		global $post;
		$menu_class = '';
		$menu_standard_class = '';
		$nav_class 	= '';
		if( 'yes' == get_option( 'navian_header_full', 'yes' ) ) {
		    $menu_class 	= 'full-menu';
		}
		if ((isset($post->ID) && get_post_meta($post->ID, '_tlg_header_boxed', 1)) || 'yes' == get_option('navian_header_boxed', 'no')) {
			$menu_class 	= 'full-menu';
		    $nav_class 		= 'container container-sm-full';
		}
		if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_text', 1 ))) && 'yes' == get_option( 'navian_header_text', 'yes' ) ) {
			// do nothing
		} else {
			$menu_standard_class = 'hide-header-text';
		}
		return array(
			'menu_class' 			=> $menu_class,
			'menu_standard_class' 	=> $menu_standard_class,
			'nav_class' 			=> $nav_class,
		);
	}
}

/**
	GET FONTS SETTING
**/
if( !function_exists('navian_get_fonts') ) {
	function navian_get_fonts() {
		global $post;
		$body_font 		= navian_parsing_fonts( get_option('navian_font'), 'Poppins', 400 );
		$heading_font 	= navian_parsing_fonts( get_option('navian_header_font'), 'Poppins', 500 );
		$subtitle_font 	= navian_parsing_fonts( get_option('navian_subtitle_font'), 'Poppins', 600 );
		$menu_font 		= navian_parsing_fonts( get_option('navian_menu_font'), 'Roboto', 400 );
		$submenu_font 	= navian_parsing_fonts( get_option('navian_submenu_font'), 'Roboto', 400 );
		$button_font 	= navian_parsing_fonts( get_option('navian_button_font'), 'Poppins', 500 );
		return array(
			'body_font' 	=> $body_font,
			'heading_font' 	=> $heading_font,
			'subtitle_font' => $subtitle_font,
			'menu_font' 	=> $menu_font,
			'submenu_font' 	=> $submenu_font,
			'button_font' 	=> $button_font,
		);
	}
}

/**
	PARSING GOOGLE FONTS
**/
if( !function_exists('navian_parsing_fonts') ) {
	function navian_parsing_fonts( $gg_font = false, $default_font = '', $default_weight = 400 ) {
		$font = array(
			'name' 		=> $default_font,
			'weight' 	=> $default_weight,
			'style' 	=> 'normal',
			'url' 		=> false,
			'family' 	=> $default_font.':'.$default_weight.',100,300,400,400italic,600,700',
		);
		if ( $gg_font ) {
	        $parsing_font 	= explode( ':tlg:', $gg_font );
	        $font_style 	= isset($parsing_font[2]) ? $parsing_font[2] : '400';
	        if ( 'regular' == $font_style ) $font_style = '400';
	        if ( 'italic'  == $font_style ) $font_style = '400italic';
	        if ( isset($parsing_font[0]) && isset($parsing_font[1]) ) {
	        	$font = array(
					'name' 		=> $parsing_font[0],
					'url' 		=> $parsing_font[1],
					'weight' 	=> intval( $font_style ),
					'style' 	=> strpos( $font_style, 'italic' ) ? 'italic' : 'normal',
					'family' 	=> $parsing_font[0].':'.$font_style.',100,300,400,600,700',
				);
	        }
	    }
	    return $font;
	}
}

/**
	SANITIZE CUSTOMIZER OPTION
**/
if( !function_exists('navian_sanitize') ) {
    function navian_sanitize( $input ) {
        return $input;
    }
}

/**
	SANITIZE TITLE
**/
if( !function_exists( 'navian_sanitize_title' ) ) {
	function navian_sanitize_title($string) {
		$string = strtolower(str_replace(' ', '-', $string));
		$string = preg_replace('/[^A-Za-z\-]/', '', $string);
		return preg_replace('/-+/', '-', $string);
	}
}

/**
	CHECK BLOG PAGES
**/
if( !function_exists('navian_is_blog_page') ) {
	function navian_is_blog_page() {
	    global $post;
	    if ( ( is_home() || is_archive() || is_single() ) && 'post' == get_post_type($post) ) {
	    	return true;
	    }
	   	return false;
	}
}

/**
	GET PAGE CLASS
**/
if( !function_exists('navian_the_page_class') ) {
	function navian_the_page_class($class = '') {
	    echo !navian_is_shop_page() ? esc_attr( 'post-content '.$class ) : esc_attr( 'shop-content'.(navian_is_cart_empty() ? ' text-center' : '') );
	}
}

/**
	CHECK SHOP PAGES
**/
if( !function_exists('navian_is_shop_page') ) {
	function navian_is_shop_page() {
	    if( class_exists('Woocommerce') ) {
		    if ( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url() || is_woocommerce() ) {
		    	return true;
		    }
		}
	   	return false;
	}
}

/**
	CHECK CART EMPTY
**/
if( !function_exists('navian_is_cart_empty') ) {
	function navian_is_cart_empty() {
	    if( class_exists('Woocommerce') ) {
	    	global $woocommerce;
		    if( is_cart() && !$woocommerce->cart->get_cart_contents_count() ) return true;
		}
	   	return false;
	}
}

/**
	ALLOWED HTML TAGS
**/
if( !function_exists('navian_allowed_tags') ) {
	function navian_allowed_tags() {
		return array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array(), 'target' => array(), 'rel' => array(), 'data-lightbox' => array(), 'data-title' => array() ), 'br' => array(), 'em' => array(), 'i' =>  array( 'class' => array() ), 'u' => array(), 'strong' => array(), 'p' => array( 'class' => array() ), 'blockquote' => array( 'class' => array() ), 'cite' => array( 'class' => array() ) );	
	}
}

/**
	DISPLAY HEADER SOCIAL ICONS
**/
if( !function_exists('navian_header_social_icons') ) { 
	function navian_header_social_icons() {
		$output = false;
		for( $i = 1; $i < 11; $i++ ) {
			if( get_option("navian_header_social_url_$i") ) {
				$output .= '<li><a class="icon-' . esc_attr(preg_replace("/[\s-]+/", "", get_option("navian_header_social_icon_$i"))) . '" href="' . esc_url(get_option("navian_header_social_url_$i")) . '" target="_blank"><i class="' . esc_attr(get_option("navian_header_social_icon_$i")) . '"></i></a></li>';
			}
		} 
		return $output;
	}
}

/**
	DISPLAY FOOTER SOCIAL ICONS
**/
if( !function_exists('navian_footer_social_icons') ) { 
	function navian_footer_social_icons() {
		$output = false;
		for( $i = 1; $i < 11; $i++ ) {
			if( get_option("navian_footer_social_url_$i") ) {
				$output .= '<li><a class="icon-' . esc_attr(preg_replace("/[\s-]+/", "", get_option("navian_header_social_icon_$i"))) . '" href="' . esc_url(get_option("navian_footer_social_url_$i")) . '" target="_blank"><i class="' . esc_attr(get_option("navian_footer_social_icon_$i")) . '"></i></a></li>';
			}
		} 
		return $output;
	}
}

/**
	PORTFOLIO UNLIMITED
**/
if( !function_exists( 'navian_excerpt' ) ) {
	function navian_excerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		} else {
			$excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
		return '<p>'.$excerpt.'</p>';
	}
}

/**
	PORTFOLIO UNLIMITED
**/
if( !function_exists( 'navian_portfolio_unlimited' ) ) {
	function navian_portfolio_unlimited( $query ) {
	    if ( !is_admin() && $query->is_main_query() && ( is_post_type_archive('portfolio') || is_tax('portfolio_category') ) ) {
	        $query->set( 'posts_per_page', '-1' );
	    }    
	    return;
	}
	add_action( 'pre_get_posts', 'navian_portfolio_unlimited' );
}

/**
	PORTFOLIO TAXONOMY TERMS
**/
if( !function_exists( 'navian_the_terms' ) ) {
	function navian_the_terms( $cat, $sep, $value, $args = array() ) {	
		global $post;
		$terms = get_the_terms( $post->ID, $cat, '', $sep, '' );
		if( is_array($terms) ) {
			foreach( $terms as $term ) {
				$args[] = $value;	
			}
			$terms = array_map( 'navian_get_term_name', $terms, $args );
			return implode( $sep, $terms);
		}
	}
}

/**
	PORTFOLIO GET TAXONOMY TERMS
**/
if( !function_exists('navian_get_term_name') ) {
	function navian_get_term_name( $term, $value ) { 
		if( 'slug' == $value ) {
			return $term->slug;
		} elseif( 'link' == $value ) {
			return '<a href="'.get_term_link( $term, 'portfolio_category' ).'">'.$term->name.'</a>';
		} else {
			return $term->name; 
		}
	}
}

/**
	BREADCRUMBS
**/
if( !function_exists('navian_page_title_meta') ) { 
	function navian_page_title_meta($leadtitle = '') {
		global $post;
		$single_meta = '';
		if (!empty($leadtitle)) {
			$single_meta = '<p class="header-single-meta mb8 uppercase display-inline top-subtitle">'.$leadtitle.'</p>';
		} else {
			if (is_singular('post') && 'yes' == get_option('navian_blog_enable_single_meta', 'yes')) {
				$single_meta = '<p class="header-single-meta mb8 uppercase display-inline top-subtitle">'. get_avatar( get_the_author_meta( 'ID' ), 32 ).get_the_author_meta( 'display_name' ).' <span class="dot-divider"></span> '.get_the_time(get_option('date_format'));
				if ( !post_password_required() && 'yes' == get_option( 'navian_blog_comment', 'yes' ) && ( comments_open() || get_comments_number() ) ) {
					$comments_count = get_comments_number();
	                if ($comments_count) {
	                	$single_meta .= ' <span class="hide-xs"><span class="dot-divider"></span> '. $comments_count . ' '. ($comments_count > 1 ? esc_html__( 'comments', 'navian' ) : esc_html__( 'comment', 'navian' )).'</span>';
	                }
	            }
	            $single_meta .= '</p>';
	    	} elseif (isset($post->ID) && !empty($post->ID)) {
	    		$leadtitle = get_post_meta( $post->ID, '_tlg_the_leadtitle', true );
	    		if (!empty($leadtitle)) {
	    			$single_meta = '<h5 class="header-single-meta uppercase display-inline top-subtitle">'.$leadtitle.'</h5>';
	    		}
	    	}
		}
    	return $single_meta;
	}
}


/**
	BREADCRUMBS
**/
if( !function_exists('navian_breadcrumbs') ) { 
	function navian_breadcrumbs() {
		if ( is_front_page() || is_search() || 'no' == get_option( 'tlg_framework_show_breadcrumbs', 'yes' ) ) return;
		global $post;
		if( isset($post->ID) && get_post_meta( $post->ID, '_tlg_hide_breadcrumbs', 1 ) ) return;
		$post_type 	= get_post_type();
		$ancestors 	= array_reverse( get_post_ancestors( $post->ID ) );
		$before 	= '<ol class="breadcrumb breadcrumb-style">';
		$after 		= '</ol>';
		$home 		= '<li><a href="' . esc_url( home_url( "/" ) ) . '" class="home-link" rel="home">' . esc_html__( 'Home', 'navian' ) . '</a></li>';
		$portfolio_slug = get_option( 'tlg_framework_portfolio_slug', 'portfolio' );
		if( 'portfolio' == $post_type ) {
			if( 'portfolio' != $portfolio_slug ) {
				$home  .= '<li class="active"><a href="' . esc_url( home_url( "/".$portfolio_slug."/" ) ) . '">' . esc_html(ucwords(strtolower($portfolio_slug))) . '</a></li>';
			} else {
				$home  .= '<li class="active"><a href="' . esc_url( home_url( "/portfolio/" ) ) . '">' . esc_html__( 'Portfolio', 'navian' ) . '</a></li>';
			}
		}
		if( 'team' == $post_type ) {
			$home  .= '<li class="active"><a href="' . esc_url( home_url( "/team/" ) ) . '">' . esc_html__( 'Team', 'navian' ) . '</a></li>';
		}
		if( 'product' == $post_type && !(is_archive()) ) {
			$home  .= '<li class="active"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'Shop', 'navian' ) . '</a></li>';
		} elseif( 'product' == $post_type && is_archive() ) {
			$home  .= '<li class="active">' . esc_html__( 'Shop', 'navian' ) . '</li>';
		}
		$breadcrumb = '';
		if ( $ancestors ) {
			foreach ( $ancestors as $ancestor ) {
				$breadcrumb .= '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
			}
		}
		if( navian_is_blog_page() && is_single() ) {
			$category_link = '';
			if ( 'yes' == get_option( 'tlg_framework_show_breadcrumbs_cat', 'no' ) ) {
				$category = get_the_category($post->ID);
				if ( ! empty( $category ) ) {
					$category_link = '<li><a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_html( $category[0]->name ) . '</a></li>';
				}
			}
			$breadcrumb .= '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html( get_option( 'tlg_framework_blog_title', esc_html__( 'Our Blog', 'navian' ) ) ) . '</a></li>'.$category_link.'<li class="active">' . esc_html( get_the_title( $post->ID ) ) . '</li>';

		} elseif( navian_is_blog_page() ) {
			$breadcrumb .= '<li class="active">' . get_option( 'tlg_framework_blog_title', esc_html__( 'Our Blog', 'navian' ) ) . '</li>';
		} elseif( is_post_type_archive('product') || is_archive() ) {
			// nothing
		} else {
			$product_cat = '';
			if ( 'yes' == get_option( 'tlg_framework_show_breadcrumbs_cat', 'no' ) ) {
				if ('product' == $post_type && is_single()) {
					$term_list = wp_get_post_terms($post->ID,'product_cat');
					if (!empty($term_list)) {
						$product_cat = '<li><a href="' . esc_url( get_term_link ($term_list[0]->term_id, 'product_cat') ) . '">' . esc_html( $term_list[0]->name ) . '</a></li>';
					}
				}
			}
			$breadcrumb .= $product_cat.'<li class="active">' . esc_html( get_the_title( $post->ID ) ) . '</li>';
		}
		if( 'team' == get_post_type() ) {
			rewind_posts();
		}
		return $before . $home . $breadcrumb . $after;
	}
}

/**
	PAGINATION
**/
if( !function_exists('navian_pagination') ) {
	function navian_pagination( $pages = '', $range = 2 ) {
		global $paged, $wp_query;
		$showitems 	= ($range * 2)+1;
		$output 	= '';
		if( empty($paged) ) {
			$paged = get_query_var( 'page' );
		}
		if( empty($paged) ) {
			$paged = 1;
		}
		if( $pages == '' ) {
			$pages = $wp_query->max_num_pages;
			if( !$pages ) {
				$pages = 1;
			}
		}
		if( 1 != $pages ) {
			$output .= "<div class='text-center mt40'><ul class='pagination'>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) {
				$output .= "<li><a href='".esc_url(get_pagenum_link(1))."' aria-label='". esc_attr__( 'Previous', 'navian' ) ."'><span aria-hidden='true'>&laquo;</span></a></li> ";
			}
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					$output .= ($paged == $i)? "<li class='active'><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li> ":"<li><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li> ";
				}
			}
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
				$output .= "<li><a href='".esc_url(get_pagenum_link($pages))."' aria-label='". esc_attr__( 'Next', 'navian' ) ."'><span aria-hidden='true'>&raquo;</span></a></li> ";
			}
			$output.= "</ul></div>";
		}
		return $output;
	}
}

/**
	COMMENTS
**/
if( !function_exists('navian_comment') ) {
	function navian_comment( $comment, $args, $depth ) { 
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>"> 
			<div class="comment-body"> 
				<div class="comment-inner clearfix"> 
					<?php echo get_avatar( $comment->comment_author_email, 90 ); ?>
					<div class="comment-content"> 
						<h4 class="comment-title dark-hover-a">
							<?php echo get_comment_author_link() ?>
						</h4> 
						<span class="comment-date"><?php echo get_comment_date( 'd M Y - g:m a' ) ?></span> 
						<div class="comment-text">
							<?php echo wpautop( get_comment_text() ); ?>
							<?php if ( $comment->comment_approved == '0' ) : ?>
							<p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'navian' ) ?></em></p>
							<?php endif; ?>	
						</div> 
						<div class="comment-reply"> 
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div> 
					</div> 
				</div>
			</div>
		<?php
	}
}

/**
	PINGS
**/
if( !function_exists('navian_pings') ) {
	function navian_pings($comment, $args, $depth) {
	   $GLOBALS['comment'] = $comment; ?>
	   <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>"> 
			<div class="comment-body"> 
				<div class="comment-inner clearfix"> 
					<?php echo get_avatar( $comment->comment_author_email, 90 ); ?>
					<div class="comment-content"> 
						<h4 class="comment-title dark-hover-a">
							<?php echo get_comment_author_link() ?>
						</h4> 
						<span class="comment-date"><?php echo get_comment_date( 'd M Y - g:m a' ) ?></span> 
						<div class="comment-text">
							<?php echo wpautop( get_comment_text() ); ?>
							<?php if ( $comment->comment_approved == '0' ) : ?>
							<p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'navian' ) ?></em></p>
							<?php endif; ?>	
						</div> 
						<div class="comment-reply"> 
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div> 
					</div> 
				</div>
			</div>
		<?php
	}
}

/**
	CHECK PINGS
**/
if( !function_exists('navian_check_pings') ) {
	function navian_check_pings($postId) {
	    $comments = get_comments('status=approve&type=pings&post_id=' . $postId );
		$comments = separate_comments($comments);
		return !empty($comments['pings']);
	}
}