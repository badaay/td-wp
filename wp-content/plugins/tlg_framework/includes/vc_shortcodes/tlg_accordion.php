<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_accordion_shortcode') ) {
	function tlg_framework_accordion_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'accordion-style-1',
			'color' => '',
			'close' => '',
			'css_animation' => '',
		), $atts ) );
		$custom_css = '';
		$element_id = uniqid( "accordion-" );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div id="'.esc_attr($element_id).'"><ul class="'.esc_attr($animation_class).' accordion '. esc_attr($style.' '.$color.' '.$close) .'">'. do_shortcode($content) .'</ul></div>';
	}
	add_shortcode( 'tlg_accordion', 'tlg_framework_accordion_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/
if( !function_exists('tlg_accordion_content_shortcode') ) {
	function tlg_accordion_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'icon' => ''
		), $atts ) );
		return '<li><div class="title">'. ( $icon && 'none' != $icon ?  '<i class="'. esc_attr($icon) .' icon"></i>' : '' ) .'<span>'. htmlspecialchars_decode($title) .'</span></div><div class="content">'. do_shortcode($content) .'</div></li>';
	}
	add_shortcode( 'tlg_accordion_content', 'tlg_accordion_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_accordion_shortcode_vc') ) {
	function tlg_framework_accordion_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Accordion' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create a accordion module', 'tlg_framework' ),
		    'icon'				      	=> 'tlg_vc_icon_accordion',
		    'base'                    	=> 'tlg_accordion',
		    'as_parent'               	=> array('only' => 'tlg_accordion_content'),
		    'content_element'         	=> true,
		    'show_settings_on_create' 	=> true,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params'          			=> array(
		    	array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
		    		'param_name' 	=> 'style',
		    		'value' 		=> array(
		    			esc_html__( 'Standard', 'tlg_framework' ) 				=> 'accordion-style-1',
		    			esc_html__( 'Standard auto close', 'tlg_framework' ) 	=> 'accordion-style-1 accordion-auto-close',
		    			esc_html__( 'Line', 'tlg_framework' ) 					=> 'accordion-style-2',
		    			esc_html__( 'Line auto close', 'tlg_framework' ) 		=> 'accordion-style-2 accordion-auto-close',
		    			esc_html__( 'Gray', 'tlg_framework' ) 					=> 'accordion-style-3',
		    			esc_html__( 'Gray auto close', 'tlg_framework' ) 		=> 'accordion-style-3 accordion-auto-close',
		    		),
		    		'admin_label' 	=> true,
		    	),
		    	array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Open first section by default', 'tlg_framework' ),
					'param_name' => 'close',
					'value' => array(
						esc_html__( 'Yes', 'tlg_framework' ) => '',
						esc_html__( 'No', 'tlg_framework' ) => 'closed-all',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display color', 'tlg_framework' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Default', 'tlg_framework' ) 	=> '',
						esc_html__( 'Light', 'tlg_framework' ) 		=> 'color-white',
					),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_accordion_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/
if( !function_exists('tlg_framework_accordion_content_shortcode_vc') ) {
	function tlg_framework_accordion_content_shortcode_vc() {
		vc_map( array(
		    'name'            			=> esc_html__( 'Accordion content', 'tlg_framework' ),
		    'description'     			=> esc_html__( 'Accordion content element', 'tlg_framework' ),
		    'icon' 			  			=> 'tlg_vc_icon_accordion',
		    'base'            			=> 'tlg_accordion_content',
		    'category' 		  			=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' 			=> true,
		    'as_child'        			=> array('only' => 'tlg_accordion'),
		    'params'          			=> array(
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
		    		'param_name' 	=> 'title',
		    		'holder' 		=> 'div'
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
	add_action( 'vc_before_init', 'tlg_framework_accordion_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/
if( class_exists('WPBakeryShortCodesContainer') ) {
    class WPBakeryShortCode_tlg_accordion extends WPBakeryShortCodesContainer {}
}
if( class_exists('WPBakeryShortCode') ) {
    class WPBakeryShortCode_tlg_accordion_content extends WPBakeryShortCode {}
}