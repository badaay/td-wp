<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_tabs_shortcode') ) {
	function tlg_framework_tabs_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'tabs-style-1',
			'color' => '',
			'css_animation' => '',
		), $atts ) );
		$custom_css = '';
		$element_id = uniqid( "tab-" );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div id="'.esc_attr($element_id).'" class="'.esc_attr($animation_class).' tabs-content '. esc_attr($style.' '.$color) .'"><ul class="tabs">'. do_shortcode($content) .'</ul></div>';
	}
	add_shortcode( 'tlg_tabs', 'tlg_framework_tabs_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/
if( !function_exists('tlg_tabs_content_shortcode') ) {
	function tlg_tabs_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'icon' => ''
		), $atts ) );
		return '<li><div class="tab-title">'. ( $icon && 'none' != $icon ?  '<i class="'. esc_attr($icon) .' icon"></i>' : '' ) .
				'<span>'. htmlspecialchars_decode($title) .'</span></div>'.
				'<div class="tab-content">'. do_shortcode($content) .'</div></li>';
	}
	add_shortcode( 'tlg_tabs_content', 'tlg_tabs_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_tabs_shortcode_vc') ) {
	function tlg_framework_tabs_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Tabs' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create a tabbed module', 'tlg_framework' ),
		    'icon' 				 	  	=> 'tlg_vc_icon_tab',
		    'base'                    	=> 'tlg_tabs',
		    'as_parent'               	=> array('only' => 'tlg_tabs_content'),
		    'content_element'         	=> true,
		    'show_settings_on_create' 	=> true,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params' 					=> array(
		    	array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
		    		'param_name' 	=> 'style',
		    		'value' 		=> array(
		    			esc_html__( 'Standard', 'tlg_framework' ) 			=> 'tabs-style-1',
		    			esc_html__( 'Standard vertical', 'tlg_framework' ) 	=> 'tabs-style-1 vertical',
		    			esc_html__( 'Icon center', 'tlg_framework' ) 		=> 'tabs-style-2',
		    			esc_html__( 'Icon left', 'tlg_framework' ) 			=> 'tabs-style-2 tabs-left',
		    			esc_html__( 'Icon right', 'tlg_framework' ) 		=> 'tabs-style-2 tabs-right',
		    			esc_html__( 'Icon title', 'tlg_framework' ) 		=> 'tabs-style-2 tabs-style-title',
		    			esc_html__( 'Modern', 'tlg_framework' ) 			=> 'tabs-style-3',
		    			esc_html__( 'Modern vertical', 'tlg_framework' ) 	=> 'tabs-style-3 vertical',
		    		),
		    		'admin_label' 	=> true,
		    	),
		    	array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display color', 'tlg_framework' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Default', 'tlg_framework' ) => '',
						esc_html__( 'Light', 'tlg_framework' ) => 'color-white',
					),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_tabs_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/	
if( !function_exists('tlg_framework_tabs_content_shortcode_vc') ) {
	function tlg_framework_tabs_content_shortcode_vc() {
		vc_map( array(
		    'name'            	=> esc_html__( 'Tabs content', 'tlg_framework' ),
		    'description'     	=> esc_html__( 'Tab content element', 'tlg_framework' ),
		    'icon' 			  	=> 'tlg_vc_icon_tab',
		    'base'            	=> 'tlg_tabs_content',
		    'category' 			=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' 	=> true,
		    'as_child'        	=> array('only' => 'tlg_tabs'),
		    'params'          	=> array(
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
		    		'param_name' 	=> 'title',
		    		'holder' 		=> 'div',
		    		'admin_label' 	=> false,
		    	),
	            array(
	            	'type' 			=> 'textarea_html',
	            	'heading' 		=> esc_html__( 'Content', 'tlg_framework' ),
	            	'param_name' 	=> 'content'
	            ),
	            array(
	            	'type' 			=> 'tlg_icons',
	            	'heading' 		=> esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
	            	'description' 	=> esc_html__( 'Leave blank to hide icon.', 'tlg_framework' ),
	            	'param_name' 	=> 'icon',
	            ),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_tabs_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/	
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tlg_tabs extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tlg_tabs_content extends WPBakeryShortCode {}
}