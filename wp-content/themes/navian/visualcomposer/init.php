<?php
/**
 * Force WPBakery Page Builder to initialize as "built into the theme".
 * This will hide certain tabs under the Settings -> WPBakery Page Builder page
 */
if( !function_exists('navian_vc_set_as_theme') ) {
	function navian_vc_set_as_theme() {
		vc_set_as_theme(true);
	}
	add_action( 'vc_before_init', 'navian_vc_set_as_theme' );
}

/**
 * Override directory where VC should look for template files for content elements
 */
if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
	vc_set_shortcodes_templates_dir( get_template_directory() . '/visualcomposer/vc_templates/' );
}

/**
 * Add parammeters
 */
if( !function_exists('navian_vc_add_params') && function_exists( 'vc_add_param' ) && function_exists( 'vc_remove_param' ) ) {
	function navian_vc_add_params() {
		vc_add_param('tlg_blog',  array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Blog category', 'navian' ),
			'param_name' 	=> 'filter',
			'value' 		=> navian_get_posts_category( 'category' )
		));
		vc_add_param('tlg_portfolio',  array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Portfolio category', 'navian' ),
			'param_name' 	=> 'filter',
			'value' 		=> navian_get_posts_category( 'portfolio_category' )
		));
		vc_add_param('tlg_clients',  array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Client category', 'navian' ),
			'param_name' 	=> 'filter',
			'value' 		=> navian_get_posts_category( 'client_category' )
		));
		vc_add_param('tlg_testimonial',  array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Testimonial category', 'navian' ),
			'param_name' 	=> 'filter',
			'value' 		=> navian_get_posts_category( 'testimonial_category' )
		));
		vc_add_param('tlg_team',  array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Team category', 'navian' ),
			'param_name' 	=> 'filter',
			'value' 		=> navian_get_posts_category( 'team_category' )
		));
		vc_add_param('tlg_shop',  array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Shop category', 'navian' ),
			'param_name' 	=> 'filter',
			'value' 		=> navian_get_posts_category( 'product_cat' )
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Container setting', 'navian' ),
			'param_name' 	=> 'tlg_large_container',
			'value' 		=> array(
				esc_html__( 'Standard', 'navian' ) 			=> '',
				esc_html__( 'Extra Large', 'navian' ) 		=> 'extra-container',
				esc_html__( 'Large', 'navian' ) 			=> 'wide-container',
				esc_html__( 'Small', 'navian' ) 			=> 'small-container'
			),
			'description' 	=> esc_html__( 'Select a container option for this row.', 'navian' ),
		));		
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row background color preset', 'navian' ),
			'param_name' 	=> 'tlg_background_style',
			'value' 		=> array(
				esc_html__( 'Light', 'navian' ) 		=> 'bg-light',
				esc_html__( 'Gray', 'navian' ) 			=> 'bg-secondary',
				esc_html__( 'Dark', 'navian' ) 			=> 'bg-dark',
				esc_html__( 'Highlight', 'navian' ) 	=> 'bg-primary',
			),
			'description' 	=> esc_html__( 'Select a preset background for this row.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row padding', 'navian' ),
			'param_name' 	=> 'tlg_padding',
			'value' 		=> array(
				esc_html__( 'Standard', 'navian' ) 		=> '',
				esc_html__( 'Large', 'navian' ) 		=> 'pt180 pb180 pt-xs-80 pb-xs-80',
				esc_html__( 'Small', 'navian' ) 		=> 'pt64 pb64',
				esc_html__( 'No Top', 'navian' ) 		=> 'pt0',
				esc_html__( 'No Bottom', 'navian' ) 	=> 'pb0',
				esc_html__( 'None', 'navian' ) 			=> 'pt0 pb0'
			),
			'description' 	=> esc_html__( 'Select a padding option for this row.', 'navian' ),
		));		
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Enable light color?', 'navian' ),
			'param_name' 	=> 'tlg_white_color',
			'value' 		=> array(
				esc_html__( 'No', 'navian' ) 			=> 'not-color',
				esc_html__( 'Yes', 'navian' ) 			=> 'color-white',
			),
			'description' 	=> esc_html__( 'Enable light color for this row.', 'navian' ),
		));
		vc_add_param('vc_row',array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Enable custom background overlay?', 'navian' ),
			'class' 		=> '',
			'admin_label' 	=> false,
			'param_name' 	=> 'tlg_enable_overlay',
			'value' 		=> array(
				esc_html__( 'No', 'navian' ) 	=> 'no',
				esc_html__( 'Yes', 'navian' ) 	=> 'yes',
			),
			'description' 	=> esc_html__( 'Customize overlay background color.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'colorpicker',
			'heading' 		=> esc_html__( 'Row overlay background color', 'navian' ),
			'param_name' 	=> 'tlg_bg_overlay',
			'dependency' 	=> array('element' => 'tlg_enable_overlay','value' => array('yes')),
			'description' 	=> esc_html__( 'Select your overlay color. Leave empty to use default overlay color.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'tlg_number',
			'heading' 		=> esc_html__( 'Row overlay value', 'navian' ),
			'param_name' 	=> 'tlg_bg_overlay_value',
			'min' 			=> 1,
			'min' 			=> 10,
			'suffix' 		=> '',
			'dependency' 	=> array('element' => 'tlg_enable_overlay','value' => array('yes')),
			'description' 	=> esc_html__( 'Enter a number from 0 to 10. Leave empty to use the default overlay value.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'colorpicker',
			'heading' 		=> esc_html__( 'Row gradient background color', 'navian' ),
			'param_name' 	=> 'tlg_bg_gradient_color',
			'dependency' 	=> array('element' => 'tlg_enable_overlay','value' => array('yes')),
			'description' 	=> esc_html__( 'To use combine with row overlay background color.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row gradient background type', 'navian' ),
			'param_name' 	=> 'tlg_bg_gradient_type',
			'dependency' 	=> array('element' => 'tlg_enable_overlay','value' => array('yes')),
			'value' 		=> array(
				esc_html__( 'Standard', 'navian' ) 			=> '',
				esc_html__( 'Rotate', 'navian' ) 			=> 'rotate'
			),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Enable parallax?', 'navian' ),
			'param_name' 	=> 'tlg_parallax',
			'value' 		=> array(
				esc_html__( 'Yes', 'navian' ) 			=> 'overlay parallax',
				esc_html__( 'No', 'navian' ) 			=> 'not-parallax'
			),
			'description' 	=> esc_html__( 'Enable parallax effect for this row (background image only).', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row text alignment?', 'navian' ),
			'param_name' 	=> 'tlg_text_align',
			'value' 		=> array(
				esc_html__( '(default)', 'navian' ) 		=> '',
				esc_html__( 'Center', 'navian' ) 			=> 'text-center',
				esc_html__( 'Left', 'navian' ) 				=> 'text-left',
				esc_html__( 'Right', 'navian' ) 			=> 'text-right',
			),
			'description' 	=> esc_html__( 'Center alignment for this row.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row vertically middle alignment?', 'navian' ),
			'param_name' 	=> 'tlg_vertical_align',
			'value' 		=> array(
				esc_html__( 'No', 'navian' ) 			=> 'no',
				esc_html__( 'Yes', 'navian' ) 			=> 'yes'
			),
			'description' 	=> esc_html__( 'Middle alignment for this row.', 'navian' ),
		));
		vc_add_param('vc_row', array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row equal height?', 'navian' ),
			'param_name' 	=> 'tlg_equal_height',
			'value' 		=> array(
				esc_html__( 'No', 'navian' ) 			=> 'not-equal',
				esc_html__( 'Yes', 'navian' ) 			=> 'equal-height',
			),
			'description' 	=> esc_html__( 'Enable equal columns for this row.', 'navian' ),
		));
		vc_add_param('vc_row',array(
			'type' 			=> 'dropdown',
			'heading' 		=> esc_html__( 'Row background video style', 'navian' ),
			'description' 	=> wp_kses( __( 'Select the kind of video background would you like to set for this row. <br>If you use background video here, please select also a background image (in "Design Options"), which will be displayed in case background video are restricted (fallback for mobile devices).', 'navian' ), navian_allowed_tags() ),
			'group' 		=> esc_html__( 'Background Video Options', 'navian' ),
			'class' 		=> '',
			'admin_label' 	=> false,
			'param_name' 	=> 'tlg_bg_video_style',
			'value' 		=> array(
				esc_html__( 'No', 'navian' ) 				=> 'no',
				esc_html__( 'YouTube video', 'navian' ) 	=> 'youtube',
				esc_html__( 'Hosted video', 'navian' ) 	=> 'video',
			),
		));
		vc_add_param('vc_row',array(
			'type' 			=> 'textfield',
			'heading' 		=> esc_html__( 'Link to the video in MP4 format', 'navian' ),
			'group' 		=> esc_html__( 'Background Video Options', 'navian' ),
			'class' 		=> '',
			'param_name' 	=> 'tlg_bg_video_url',
			'value' 		=> '',
			'dependency' 	=> array('element' => 'tlg_bg_video_style','value' => array('video')),
		));
		vc_add_param('vc_row',array(
			'type' 			=> 'textfield',
			'heading' 		=> esc_html__( 'Link to the video in WebM / Ogg format', 'navian' ),
			'group' 		=> esc_html__( 'Background Video Options', 'navian' ),
			'class' 		=> '',
			'param_name' 	=> 'tlg_bg_video_url_2',
			'value' 		=> '',
			'description' 	=> esc_html__( 'To display a video using HTML5, which works in the newest versions of all major browsers, you can serve your video in both WebM format and MPEG H.264 AAC format. You can upload the video through your Media Library.', 'navian'),
			'dependency' 	=> array('element' => 'tlg_bg_video_style','value' => array('video')),
		));
		vc_add_param('vc_row',array(
			'type' 			=> 'textfield',
			'heading' 		=> esc_html__( 'Enter YouTube video ID', 'navian' ),
			'description' 	=> wp_kses( __( 'Eg: https://www.youtube.com/watch?v=lMJXxhRFO1k <br>Enter the video ID: "lMJXxhRFO1k"', 'navian' ), navian_allowed_tags() ),
			'group' 		=> esc_html__( 'Background Video Options', 'navian' ),
			'class' 		=> '',
			'param_name' 	=> 'tlg_bg_youtube_url',
			'value' 		=> '',
			'dependency' 	=> array('element' => 'tlg_bg_video_style','value' => array('youtube')),
		));
		vc_remove_param('vc_row', 'video_bg');
		vc_remove_param('vc_row', 'video_bg_url');
		vc_remove_param('vc_row', 'video_bg_parallax');
		vc_remove_param('vc_row', 'parallax');
		vc_remove_param('vc_row', 'parallax_image');
		vc_remove_param('vc_row', 'parallax_speed_video');
		vc_remove_param('vc_row', 'parallax_speed_bg');
		vc_remove_param('vc_row', 'content_placement');
		vc_remove_param('vc_row', 'columns_placement');
		vc_remove_param('vc_row', 'equal_height');
		vc_remove_param('vc_row', 'gap');
		vc_remove_param('vc_row', 'rtl_reverse');
	}
	add_action('init', 'navian_vc_add_params', 999);
}

/**
 * Auto activate VC Page Template
 */
if( !function_exists('navian_vc_page_template') ) {
	function navian_vc_page_template( $template ) {
		global $post;
		if ( is_archive() || is_404() || is_search() || ! isset( $post->post_content ) || 'no' == get_option( 'navian_auto_vc_' . $post->post_type ) ) {
			return $template;
		}
		if ( has_shortcode( $post->post_content, 'vc_row') ) {
			$vc_page_template = locate_template( array( 'page_visualcomposer.php' ) );
			if ( '' != $vc_page_template ) {
				return $vc_page_template;
			}
		}
		return $template;
	}
	add_filter( 'template_include', 'navian_vc_page_template', 99 );
}

/**
 * Disable default VC shortcodes
 */
if( function_exists( 'vc_remove_element' ) && 'no' == get_option( 'navian_enable_default_vc_shortcode', 'no' ) ) {
	vc_remove_element('vc_section');
	vc_remove_element('vc_tta_section');
	vc_remove_element('vc_tta_pageable');
	vc_remove_element('vc_wp_search');
	vc_remove_element('vc_wp_meta');
	vc_remove_element('vc_wp_recentcomments');
	vc_remove_element('vc_wp_calendar');
	vc_remove_element('vc_wp_pages');
	vc_remove_element('vc_wp_tagcloud');
	vc_remove_element('vc_wp_custommenu');
	vc_remove_element('vc_wp_text');
	vc_remove_element('vc_wp_posts');
	vc_remove_element('vc_wp_links');
	vc_remove_element('vc_wp_categories');
	vc_remove_element('vc_wp_archives');
	vc_remove_element('vc_wp_rss');
	vc_remove_element('vc_gallery');
	vc_remove_element('vc_teaser_grid');
	vc_remove_element('vc_button');
	vc_remove_element('vc_cta_button');
	vc_remove_element('vc_posts_grid');
	vc_remove_element('vc_images_carousel');
	vc_remove_element('vc_separator');
	vc_remove_element('vc_text_separator');
	vc_remove_element('vc_message');
	vc_remove_element('vc_facebook');
	vc_remove_element('vc_tweetmeme');
	vc_remove_element('vc_googleplus');
	vc_remove_element('vc_pinterest');
	vc_remove_element('vc_toggle');
	vc_remove_element('vc_posts_slider');
	vc_remove_element('vc_button2');
	vc_remove_element('vc_cta_button2');
	vc_remove_element('vc_gmaps');
	vc_remove_element('vc_flickr');
	vc_remove_element('vc_progress_bar');
	// vc_remove_element('vc_pie');
	vc_remove_element('vc_hoverbox');
	vc_remove_element('vc_zigzag');
	vc_remove_element('vc_empty_space');
	vc_remove_element('vc_custom_heading');
	vc_remove_element('vc_basic_grid');
	vc_remove_element('vc_media_grid');
	vc_remove_element('vc_masonry_grid');
	vc_remove_element('vc_masonry_media_grid');
	vc_remove_element('vc_icon');
	vc_remove_element('vc_btn');
	vc_remove_element('vc_cta');
	vc_remove_element('vc_line_chart');
	vc_remove_element('vc_round_chart');
	vc_remove_element('vc_tta_tabs');
	vc_remove_element('vc_tta_tour');
	vc_remove_element('vc_tta_accordion');
}

/**
 * Disable Woocommerce VC shortcodes
 */
if( !function_exists('navian_vc_remove_woocommerce') && 'no' == get_option( 'navian_enable_default_wc_shortcode', 'yes' ) ) {
	function navian_vc_remove_woocommerce() {
	    if (function_exists( 'vc_remove_element' ) && class_exists('Woocommerce')) {
	        vc_remove_element( 'woocommerce_cart' );
	        vc_remove_element( 'woocommerce_checkout' );
	        vc_remove_element( 'woocommerce_order_tracking' );
			vc_remove_element( 'woocommerce_my_account' );
			vc_remove_element( 'product' );
			vc_remove_element( 'products' );
			vc_remove_element( 'add_to_cart' );
			vc_remove_element( 'add_to_cart_url' );
			vc_remove_element( 'product_page' );
			vc_remove_element( 'product_categories' );
			vc_remove_element( 'product_attribute' );
			vc_remove_element( 'recent_products' );
			vc_remove_element( 'featured_products' );
			vc_remove_element( 'product_category' );
			vc_remove_element( 'sale_products' );
			vc_remove_element( 'best_selling_products' );
			vc_remove_element( 'top_rated_products' );
	    }
	}
	// Hook for admin editor.
	add_action( 'vc_build_admin_page', 'navian_vc_remove_woocommerce', 11 );
	// Hook for frontend editor.
	add_action( 'vc_load_shortcode', 'navian_vc_remove_woocommerce', 11 );
}