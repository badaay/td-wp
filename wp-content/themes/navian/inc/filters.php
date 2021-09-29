<?php
/**
 * Theme Filter
 *
 * @package TLG Theme
 *
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
if( !function_exists('navian_pingback_header') ) {
	function navian_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
	add_action( 'wp_head', 'navian_pingback_header' );
}

/**
	BODY CLASSES
**/
if( !function_exists('navian_body_classes') ) {
	function navian_body_classes( $classes ) {
		global $post;
		$classes[] = navian_get_body_layout();
		$classes[] = navian_get_container_layout();
		if ( 'yes' == get_option( 'navian_enable_preloader', 'no' ) ) {
			$classes[] = 'loading';
		}
		if( isset($post->ID) && get_post_meta( $post->ID, '_tlg_menu_effect', 1 ) ) {
			$classes[] = get_post_meta( $post->ID, '_tlg_menu_effect', 1 );
		} else {
			$classes[] = get_option( 'navian_menu_effect', 'menu-effect-line' );
		}
		if( isset($post->ID) && get_post_meta( $post->ID, '_tlg_menu_divider', 1 ) ) {
			$classes[] = get_post_meta( $post->ID, '_tlg_menu_divider', 1 );
		} else {
			$classes[] = get_option( 'navian_menu_divider', '' );
		}
		if( isset($post->ID) && get_post_meta( $post->ID, '_tlg_menu_hover', 1 ) ) {
			$classes[] = get_post_meta( $post->ID, '_tlg_menu_hover', 1 );
		} else {
			$classes[] = get_option( 'navian_menu_hover', '' );
		}
		return $classes;
	}
	add_filter( 'body_class', 'navian_body_classes' );
}

/**
	REMOVE WHITESPACE FROM EXPERT
**/
if( !function_exists('navian_excerpt_length') ) {
	function navian_excerpt_trim( $excerpt ) {
	    return preg_replace( '~^(\s*(?:&nbsp;)?)*~i', '', $excerpt );
	}
	add_filter( 'get_the_excerpt', 'navian_excerpt_trim', 999 );
}

/**
	EXPERT DEFAULT MORE
**/
if( !function_exists('navian_excerpt_more') ) {
	function navian_excerpt_more( $more ) {
		return esc_html__( '...', 'navian' );
	}
	add_filter( 'excerpt_more', 'navian_excerpt_more' );
}


/**
	REMOVE MORE LINK
**/
if( !function_exists('navian_remove_more_link_scroll') ) { 
	function navian_remove_more_link_scroll( $link ) {
		return preg_replace( '|#more-[0-9]+|', '', $link );
	}
	add_filter( 'the_content_more_link', 'navian_remove_more_link_scroll' );
}

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
if( !function_exists('navian_gutenberg_styles') ) { 
	function navian_gutenberg_styles() {
		wp_enqueue_style( 'navian-gutenberg', NAVIAN_THEME_DIRECTORY . 'assets/css/gutenberg.css');
		$custom_css = '';
		$primary_color = get_option('navian_color_primary', '#49c5b6');
		$light_color = get_option('navian_color_light', '#fff');
		$text_color = get_option('navian_color_text', '#595959');
		$dark_color = get_option('navian_color_dark', '#252525');
		$body_font = navian_parsing_fonts( get_option('navian_font'), 'Roboto', 400 );
		$heading_font = navian_parsing_fonts( get_option('navian_header_font'), 'Montserrat', 600 );
		$subtitle_font = navian_parsing_fonts( get_option('navian_subtitle_font'), 'Roboto', 400 );
		$custom_css .= 'body.block-editor-page .wp-block-preformatted pre, body.block-editor-page .wp-block-verse pre{border-left-color:'.$primary_color.'}';
		$custom_css .= 'body.block-editor-page .wp-block-pullquote, body.block-editor-page .wp-block-quote, body.block-editor-page .wp-block-quote:not(.is-large):not(.is-style-large) {background-color:'.$primary_color.'}';
		$custom_css .= 'body.block-editor-page .editor-styles-wrapper a, body.block-editor-page .editor-styles-wrapper a em, body.block-editor-page .editor-styles-wrapper a strong{color:'.$primary_color.'}';
		$custom_css .= 'body.block-editor-page .editor-styles-wrapper {background-color:'.$light_color.';color:'.$text_color.'}';
		$custom_css .= 'body.block-editor-page .edit-post-visual-editor p.wp-block-subhead{color:'.$text_color.'}';
		$custom_css .= 'body.block-editor-page .editor-styles-wrapper blockquote cite, body.block-editor-page editor-post-title__input, body.block-editor-page .editor-post-title__block .editor-post-title__input, body.block-editor-page .editor-styles-wrapper h1, body.block-editor-page .editor-styles-wrapper h2, body.block-editor-page .editor-styles-wrapper h3, body.block-editor-page .editor-styles-wrapper h4, body.block-editor-page .editor-styles-wrapper h5, body.block-editor-page .editor-styles-wrapper h6 {font-family: '.$heading_font['name'].';color:'.$dark_color.'}';
		$custom_css .= 'body.block-editor-page .wp-block-pullquote, body.block-editor-page .wp-block-quote, body.block-editor-page .wp-block-quote:not(.is-large):not(.is-style-large) {font-family: '.$subtitle_font['name'].';}';
		$custom_css .= 'body.block-editor-page .editor-styles-wrapper{font-family: '.$body_font['name'].';}';
		$custom_css .= 'body.block-editor-page .wp-block-quote cite, body.block-editor-page .wp-block-quote footer, body.block-editor-page .wp-block-quote__citation{font-family: '.$heading_font['name'].';}';
		if (!empty($custom_css)) {
			wp_add_inline_style( 'navian-gutenberg', $custom_css );
		}
	}
	add_action( 'enqueue_block_editor_assets', 'navian_gutenberg_styles' );
}

/**
	ADD CLEARFIX TO END CONTENT
**/
if( !function_exists('navian_add_clearfix') ) { 
	function navian_add_clearfix( $content ) { 
		if( is_single() ) {
	   		$content .= '<div class="clearfix"></div>';
		}
	    return $content;
	}
	add_filter( 'the_content', 'navian_add_clearfix' );
}

/**
	NAV MENU SELECTED
**/
if( !function_exists('navian_wp_nav_menu_args') ) {
	function navian_wp_nav_menu_args( $args = '' ) {
		global $post;
		$selected_menu_id = null;
		if (class_exists('Woocommerce')) {
			if (is_woocommerce() || is_cart() || is_checkout()) {
				$shop_menu_id = get_option( 'navian_shop_menu_override', '' );
				if (!empty($shop_menu_id)) {
					$selected_menu_id = $shop_menu_id;
				}
			}
		}
		if (isset($post->ID)) {
			$custom_menu_id = get_post_meta( $post->ID, '_tlg_menu_override', 1 );
			if (!empty($custom_menu_id)) {
				$selected_menu_id = $custom_menu_id;
			}
		}
		if (!empty($selected_menu_id) && is_nav_menu( $selected_menu_id ) && 'primary' == $args['theme_location'] ) {
			$args['theme_location'] = false;
			$args['menu'] = $selected_menu_id;
		}
		return $args;
	}
	add_filter( 'wp_nav_menu_args', 'navian_wp_nav_menu_args' );
}

/**
	SEARCH FILTER FOR POST ONLY
**/
if( !function_exists('navian_search_filter') && 'yes' == get_option( 'navian_enable_search_filter', 'yes' ) ) { 
	function navian_search_filter( $query ) {
		if ( $query->is_search ) {
			$query->set( 'post_type', array('post', 'product') );
		}
		return $query;
	}
	if (!is_admin()) {
		add_filter('pre_get_posts','navian_search_filter');
	}
}

/**
	FIX FOR EASY GOOGLE FONT PLUGIN USERS
**/
if( !function_exists('navian_force_styles') ) { 
	function navian_force_styles( $force_styles ) {
	    return true;
	}
	add_filter( 'tt_font_force_styles', 'navian_force_styles' );
}

/**
	CUSTOM MEDIA GALLERY STYLE
**/
if( !function_exists('navian_add_gallery_settings') ) { 
	function navian_add_gallery_settings() { ?>
		<script type="text/html" id="tmpl-tlg_gallery-setting">
			<label class="setting">
				<span><?php esc_html_e('Layout', 'navian'); ?></span>
				<select data-setting="layout">
					<option value="default"><?php esc_html_e( '(default)', 'navian' ); ?></option>
					<option value="slider"><?php esc_html_e( 'Slider', 'navian' ); ?></option>
					<option value="slider-padding"><?php esc_html_e( 'Slider Featured (Stretch Row layout)', 'navian' ); ?></option>
					<option value="slider-thumb"><?php esc_html_e( 'Slider Thumbnail', 'navian' ); ?></option>
					<option value="lightbox"><?php esc_html_e( 'Lightbox Grid', 'navian' ); ?></option>
					<option value="lightbox-fullwidth"><?php esc_html_e( 'Lightbox Grid Fullwidth', 'navian' ); ?></option>
					<option value="masonry"><?php esc_html_e( 'Lightbox Masonry', 'navian' ); ?></option>
					<option value="masonry-flip-photoswipe"><?php esc_html_e( 'Lightbox Masonry PhotoSwipe', 'navian' ); ?></option>
					<option value="fullwidth"><?php esc_html_e( 'Full Width', 'navian' ); ?></option>
					<option value="autoplay"><?php esc_html_e( 'Autoplay', 'navian' ); ?></option>
				</select>
			</label>
		</script>
		<script>
			jQuery(document).ready(function() {
				jQuery.extend(wp.media.gallery.defaults, { layout: 'default' });
				wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
					template: function(view) {
					  return wp.media.template('gallery-settings')(view) + wp.media.template('tlg_gallery-setting')(view);
					}
				});
			});
		</script>
	<?php
	}
	add_action( 'print_media_templates', 'navian_add_gallery_settings' );
}

/**
	CUSTOM POST GALLERY STYLE
**/
if( !function_exists('navian_post_gallery') ) {
	function navian_post_gallery( $output, $attr) {
		global $post, $wp_locale;
	    static $instance = 0; $instance++;
	    extract(shortcode_atts(array(
	        'order'      => 'ASC',
	        'orderby'    => 'menu_order ID',
	        'id'         => $post->ID,
	        'itemtag'    => 'div',
	        'icontag'    => 'dt',
	        'captiontag' => 'dd',
	        'columns'    => 3,
	        'size'       => 'large',
	        'include'    => '',
	        'exclude'    => '',
	        'layout'     => ''
	    ), $attr));
	    $output = $image = '';
	    if ( 'RAND' == $order ) $orderby = 'none';
	    if ( !empty($include) ) {
	        $include = preg_replace( '/[^0-9,]+/', '', $include );
	        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	        $attachments = array();
	        foreach ( $_attachments as $key => $val ) $attachments[$val->ID] = $_attachments[$key];
	    } elseif ( empty($exclude) ) {
	    	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	    } else {
	        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
	        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	    }
	    if ( empty($attachments) ) return '';
	    switch ($layout) {
	    	case 'autoplay':
	    		if ( is_rtl() ) {
		    		$output = '<div class="clearfix"><ul class="carousel-one-item-auto-rtl owl-carousel owl-theme carousel-olw-nav carousel-no-control">';
		    	} else {
		    		$output = '<div class="clearfix"><ul class="carousel-one-item-auto owl-carousel owl-theme carousel-olw-nav carousel-no-control">';
		    	}
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'full');
	    			if ( isset($url[0]) && $url[0] ) {
		    		    $output .= '<li><img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" /></li>';
	    			}
	    		}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'slider':
	    		if ( is_rtl() ) {
		    		$output = '<div class="clearfix mb32 mt0-vc"><ul class="carousel-one-item-rtl owl-carousel owl-theme carousel-olw-nav slides post-slider">';
		    	} else {
		    		$output = '<div class="clearfix mb32 mt0-vc"><ul class="carousel-one-item owl-carousel owl-theme carousel-olw-nav slides post-slider">';
		    	}
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'navian_grid_big');
	    			if ( isset($url[0]) && $url[0] ) {
	    				$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_caption = $img_caption ? '<div class="bg-mask mask-none"><div class="mask-desc"><h4 class="color-white">'.$img_caption.'</h4></div></div>' : '';
		    		    $output .= '<li class="bg-overlay move-cursor"><img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />'.$img_caption.'</li>';
	    			}
	    		}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'slider-padding':
	    		if ( is_rtl() ) {
	    			$output = '<div class="clearfix mt16 mt0-vc hide-icon"><div class="carousel-padding-item-rtl slides owl-carousel owl-theme move-cursor">';
	    		} else {
	    			$output = '<div class="clearfix mt16 mt0-vc hide-icon"><div class="carousel-padding-item slides owl-carousel owl-theme move-cursor">';
	    		}
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'full');
	    			if ( isset($url[0]) && $url[0] ) {
	    				$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_desc = isset($img_meta['description']) ? $img_meta['description'] : '';
						$img_caption = $img_caption ? '<div class="bg-mask mask-none"><div class="mask-desc"><h3 class="color-white mb8 bold">'.$img_caption.'</h3><h4 class="color-white">'.$img_desc.'</h4></div></div>' : '';
	    		    	$output .= '<div class="bg-overlay move-cursor"><img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />'.$img_caption.'</div>';
	    			}
	    		}
	    		$output .= '</div></div>';
	    		break;

	    	case 'slider-thumb':
	    		if ( is_rtl() ) {
	    			$output = '<div class="clearfix slider-thumb-rtl mt16 mt0-vc"><ul class="slides">';
	    		} else {
	    			$output = '<div class="clearfix slider-thumb mt16 mt0-vc"><ul class="slides">';
	    		}
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'navian_grid_big');
	    			if ( isset($url[0]) && $url[0] ) {
	    				$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_caption = $img_caption ? '<div class="bg-mask mask-none"><div class="mask-desc"><h4 class="color-white">'.$img_caption.'</h4></div></div>' : '';
	    		    	$output .= '<li class="bg-overlay default-cursor"><img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />'.$img_caption.'</li>';
	    			}
	    		} 
		    	$output .= '</ul></div>';
	    		break;

	    	case 'masonry':
	    	case 'masonry-flip':
	    		$output = '<div><ul class="masonry-flip flip-photoswipe-center effect-scale" id="masonry-flip">';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    		if ( isset($url[0]) && $url[0] ) {
		    			$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_desc = isset($img_meta['description']) ? $img_meta['description'] : '';
		    	    	$output .= '<li class="project flip-column-'.esc_attr($columns).'">
		    	    					<a href="'. esc_url($url[0]) .'" data-lightbox="true" data-title="'.esc_attr($img_caption).'">
											<div class="image-box zoom-hover hover-meta text-center">
											    <img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />
											    <span class="overlay-default"></span>
											    <div class="meta-caption">
											    	<h3 class="color-white to-top mb0 bold">'.$img_caption.'</h3>
											    	<h4 class="color-white to-top-after">'.$img_desc.'</h4>
											    	<i class="ti-search circled-icon to-top-after-after"></i>
											    </div>
											</div>
										</a>
									</li>';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'masonry-flip-photoswipe':
	    	case 'flip-photoswipe-center':
	    		$output = '<div><ul class="masonry-flip masonry-flip-photoswipe flip-photoswipe-center effect-scale" id="masonry-flip">';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    		if ( isset($url[0]) && $url[0] ) {
		    			$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_desc = isset($img_meta['description']) ? $img_meta['description'] : '';
						$img_width = isset($img_meta['width']) ? $img_meta['width'] : '';
						$img_height = isset($img_meta['height']) ? $img_meta['height'] : '';
		    	    	$output .= '<li class="project flip-column-'.esc_attr($columns).'">
		    	    					<a href="'. esc_url($url[0]) .'" data-size="'.esc_attr($img_width).'x'.esc_attr($img_height).'">
											<div class="image-box zoom-hover hover-meta text-center">
											    <img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />
											    <span class="overlay-default"></span>
											    <div class="meta-caption">
											    	<h3 class="color-white to-top mb0 bold">'.$img_caption.'</h3>
											    	<h4 class="color-white to-top-after">'.$img_desc.'</h4>
											    	<i class="ti-search circled-icon to-top-after-after"></i>
											    </div>
											</div>
										</a>
										<figcaption>'.$img_caption.'</figcaption>
									</li>';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'lightbox':
	    		$output = '<div class="lightbox-gallery mt16 mt0-vc '.( 3 == $columns ? 'third-thumbs' : ( 2 == $columns ? 'half-thumbs' : 'fourth-thumbs' ) ).'" data-gallery-title="'. esc_attr(get_the_title()) .'"><ul>';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url_full = wp_get_attachment_image_src($id, 'full');
	    			$url = wp_get_attachment_image_src($id, 'navian_grid_big');
		    		if ( isset($url_full[0]) && isset($url[0]) && $url[0] ) {
		    			$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_desc = isset($img_meta['description']) ? $img_meta['description'] : '';
		    	    	$output .= '<li>
		    	    					<a href="'. esc_url($url_full[0]) .'" data-lightbox="true" data-title="'.esc_attr($img_caption).'">
		    	    						<div class="image-box hover-meta zoom-hover text-center">
											    <img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />
											    <div class="meta-caption">
											    	<h3 class="color-white to-top mb0 bold">'.$img_caption.'</h3>
											    	<h4 class="color-white to-top-after">'.$img_desc.'</h4>
											    </div>
											</div>
	    	    	        			</a>
	    	    	        		</li>';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'lightbox-fullwidth':
	    		$output = '<div class="lightbox-gallery lightbox-fullwidth mt16 mt0-vc '.( 3 == $columns ? 'third-thumbs' : ( 2 == $columns ? 'half-thumbs' : 'fourth-thumbs' ) ).'" data-gallery-title="'. esc_attr(get_the_title()) .'"><ul>';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url_full = wp_get_attachment_image_src($id, 'full');
	    			$url = wp_get_attachment_image_src($id, 'navian_grid_big');
		    		if ( isset($url_full[0]) && isset($url[0]) && $url[0] ) {
		    			$img_meta = wp_prepare_attachment_for_js( $id );
						$img_caption = isset($img_meta['caption']) ? $img_meta['caption'] : '';
						$img_desc = isset($img_meta['description']) ? $img_meta['description'] : '';
		    	    	$output .= '<li class="project">
		    	    					<a href="'. esc_url($url_full[0]) .'" data-lightbox="true" data-title="'.esc_attr($img_caption).'">
		    	    						<div class="image-box hover-meta zoom-hover text-center">
											    <img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" />
											    <span class="overlay-default"></span>
											    <div class="meta-caption">
											    	<h3 class="color-white to-top mb0 bold">'.$img_caption.'</h3>
											    	<h4 class="color-white to-top-after">'.$img_desc.'</h4>
											    	<i class="ti-search circled-icon to-top-after-after"></i>
											    </div>
											</div>
		    	    	        		</a>
		    	    	        	</li>';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'fullwidth':
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    	    $output .= isset($url[0]) && $url[0] ? '<figure><img src="'. esc_url($url[0]) .'" alt="'.esc_attr( 'gallery-item' ).'" /></figure>' : '';
		    	}
	    		break;
	    	
	    	default:
	    		if ( is_feed() ) {
			        $output = "\n";
			        foreach ( $attachments as $id => $attachment ) {
			            $output .= wp_get_attachment_link($id, $size, true) . "\n";
			        }
			    }
	    		break;
	    }
	    return $output;
	}
	add_filter( 'post_gallery', 'navian_post_gallery', 10, 2 );
}