<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_page_title_shortcode') ) {
	function tlg_framework_page_title_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 	=> '',
			'layout' 	=> 'center',
			'image' 	=> '',
			'subtitle' 	=> ''
		), $atts ) );
		$page_args = array(
			'title'   	=> $title,
			'subtitle'  => $subtitle,
			'layout' 	=> $layout,
			'image'    	=> $image ? wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image', 'alt' => 'page-header') ) : false
		);
		return tlg_framework_get_the_page_title( $page_args );
	}
	add_shortcode( 'tlg_page_title', 'tlg_framework_page_title_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_page_title_shortcode_vc') ) {
	function tlg_framework_page_title_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Page Title', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds a page title.', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_page_title',
			'base' 			=> 'tlg_page_title',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div',
					'admin_label' 	=> true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' => 'subtitle',
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Page title layout', 'tlg_framework' ),
					'param_name' => 'layout',
					'value' => array_flip(tlg_framework_get_page_title_options()),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Page title background image', 'tlg_framework' ),
					'param_name' => 'image'
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_page_title_shortcode_vc' );
}