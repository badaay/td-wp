<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_icon_title_list_shortcode') ) {
	function tlg_framework_icon_title_list_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'icon-list',
			'css_animation' => '',
		), $atts ) );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div class="'.esc_attr($animation_class).' icon_title_list-content '. esc_attr($style) .'"><ul class="icon_title_list">'. do_shortcode($content) .'</ul></div>';
	}
	add_shortcode( 'tlg_icon_title_list', 'tlg_framework_icon_title_list_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/		
if( !function_exists('tlg_icon_title_list_content_shortcode') ) {
	function tlg_icon_title_list_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 		=> '',
			'title_link' 	=> '',
			'icon' 			=> '',
			'number' 		=> '',
			'title_color' 	=> '',
			'icon_color' 	=> '',
			'icon_bg_color' => '',
			'icon_layout' 	=> '',
		), $atts ) );
		$output = '';

		// BUILD STYLE
		$styles_icon = '';
		$styles_icon .= $icon_color ? 'color:'.$icon_color.';' : '';
		$styles_icon .= $icon_bg_color && $icon_layout ? 'background-color:'.$icon_bg_color.';border-color:'.$icon_bg_color.';' : '';

		$styles_text = $title_color ? 'color:'.$title_color.';' : '';

		// GET STYLE
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}
		if ( ! empty( $styles_text ) ) {
			$style_text = 'style="' . esc_attr( $styles_text ) . '"';
		} else {
			$style_text = '';
		}

		// LINK
		$link_prefix = $link_sufix = '';
		if( '' != $title_link ) {
			$href = vc_build_link( $title_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		$output .= '<li><span class="inline-block mb8 mr-15">';
		$output .= $number ?  '<span '.$style_icon.' class="'.esc_attr($icon_layout).' inline-block number">'.$number.'</span>' : '';
		$output .= $icon ?  '<i '.$style_icon.' class="'.esc_attr($icon).' '.esc_attr($icon_layout).' inline-block"></i>' : '';
		$output .= '</span><span '.$style_text.'>'. $link_prefix.htmlspecialchars_decode($title).$link_sufix .'</span></li>';
		return $output;
	}
	add_shortcode( 'tlg_icon_title_list_content', 'tlg_icon_title_list_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_icon_title_list_shortcode_vc') ) {
	function tlg_framework_icon_title_list_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Icon Title List' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create a title list with icon', 'tlg_framework' ),
		    'icon' 				 	  	=> 'tlg_vc_icon_icon_title_list',
		    'base'                    	=> 'tlg_icon_title_list',
		    'as_parent'               	=> array('only' => 'tlg_icon_title_list_content'),
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
		    			esc_html__( 'Icon list', 'tlg_framework' ) 	=> 'icon-list',
		    			esc_html__( 'Icon list large', 'tlg_framework' ) 	=> 'icon-list-large',
		    			esc_html__( 'Number list', 'tlg_framework' ) 	=> 'number-list',
		    		)
		    	),
		    	vc_map_add_css_animation(),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_icon_title_list_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/		
if( !function_exists('tlg_framework_icon_title_list_content_shortcode_vc') ) {
	function tlg_framework_icon_title_list_content_shortcode_vc() {
		vc_map( array(
		    'name'            	=> esc_html__( 'Icon title list content', 'tlg_framework' ),
		    'description'     	=> esc_html__( 'Icon title list content element', 'tlg_framework' ),
		    'icon' 			  	=> 'tlg_vc_icon_icon_title_list',
		    'base'            	=> 'tlg_icon_title_list_content',
		    'category' 			=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' 	=> true,
		    'as_child'        	=> array('only' => 'tlg_icon_title_list'),
		    'params'          	=> array(
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
		    		'param_name' 	=> 'title',
		    		'holder' 		=> 'div'
		    	),
		    	array(
		    		'type' 			=> 'vc_link',
		    		'heading' 		=> esc_html__( 'Title Link', 'tlg_framework' ),
		    		'param_name' 	=> 'title_link',
		    		'admin_label' 	=> false,
		    	),
		    	array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Item number (in "Number list" only)', 'tlg_framework' ),
					'param_name' => 'number',
					'holder' => 'div',
					'min' => 1,
					'max' => 1000,
					'suffix' => '',
					'description' => esc_html__('Enter a number for this item', 'tlg_framework'),
				),
	            array(
	            	'type' 			=> 'tlg_icons',
	            	'heading' 		=> esc_html__( 'Item icon (in "Icon list" only)', 'tlg_framework' ),
	            	'description' 	=> esc_html__( 'Leave blank to hide icon.', 'tlg_framework' ),
	            	'param_name' 	=> 'icon',
	            ),
	            array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Icon/Number style', 'tlg_framework' ),
		    		'param_name' 	=> 'icon_layout',
		    		'value' 		=> array(
		    			esc_html__( 'Standard', 'tlg_framework' ) => '',
						esc_html__( 'Circle', 'tlg_framework' ) => 'circle-icon list-icon',
						esc_html__( 'Circle background', 'tlg_framework' ) => 'circle-icon circle-icon-bg list-icon',
						esc_html__( 'Square', 'tlg_framework' ) => 'square-icon list-icon',
						esc_html__( 'Square background', 'tlg_framework' ) => 'square-icon square-icon-bg list-icon',
		    		),
		    		'admin_label' 	=> true,
		    	),
	            array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon/Number color (optional)', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon/Number background color (optional)', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select background color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_bg_color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Text color (optional)', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select the text color.', 'tlg_framework' ),
					'param_name' 	=> 'title_color',
				),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_icon_title_list_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tlg_icon_title_list extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tlg_icon_title_list_content extends WPBakeryShortCode {}
}