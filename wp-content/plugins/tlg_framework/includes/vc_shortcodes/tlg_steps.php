<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_steps_shortcode') ) {
	function tlg_framework_steps_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'steps-style-1',
			'size'  => '',
			'color' => '',
			'css_animation' => '',
		), $atts ) );
		$custom_css = '';
		$element_id = uniqid( "step-" );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div id="'.esc_attr($element_id).'" class="'.esc_attr($animation_class).' steps-content '. esc_attr($style.' '.$size) .'"><ol class="steps">'. do_shortcode($content) .'</ol></div>';
	}
	add_shortcode( 'tlg_steps', 'tlg_framework_steps_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/
if( !function_exists('tlg_steps_content_shortcode') ) {
	function tlg_steps_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 			=> '',
			'subtitle' 			=> '',
			'icon' 				=> '',
			'step_link'  		=> '',
			'text_color' 		=> '',
			'text_color_hover' 	=> '',
			'icon_color' 		=> '',
			'icon_color_hover' 	=> '',
			'bg_color' 			=> '',
			'bg_color_hover' 	=> '',
		), $atts ) );
		$element_id 	= uniqid('step-item-');
		$custom_css 	= '';
		$custom_script 	= '';
		$link_prefix 	= '';
		$link_sufix 	= '';

		// STYLES
		$icon_color = $icon_color ? 'color:'.$icon_color.';' : '';
		$text_color = $text_color ? 'color:'.$text_color.';' : '';
		$bg_color = $bg_color ? 'background-color:'.$bg_color.';' : '';

		if( $bg_color_hover || $text_color_hover || $icon_color_hover ) {
			$custom_css .= '<style type="text/css" id="tlg-custom-css-'.$element_id.'">.steps-style-1 #'.$element_id.':hover .steps-item-inner{background:'.$bg_color_hover.'!important;}.steps-style-2 #'.$element_id.':hover .steps-item-inner .steps-icon i{background:'.$bg_color_hover.'!important;}#'.$element_id.':hover .steps-item-inner i{color:'.$icon_color_hover.'!important;}#'.$element_id.':hover .steps-item-inner .step-title, #'.$element_id.':hover .steps-item-inner .step-content{color:'.$text_color_hover.'!important;}</style>';
			$custom_script = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		// LINK
		
		if( '' != $step_link ) {
			$href = vc_build_link( $step_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a class="inherit" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}
		return '<li id="'.esc_attr($element_id).'" class="steps-item">'.$link_prefix.'
					<div class="steps-item-inner" style="'.$bg_color.'">'.
						( $icon && 'none' != $icon ?  '<div class="steps-icon"><i style="'.$icon_color.$bg_color.'" class="'. esc_attr($icon) .' inline-block"></i></div>' : '' ).
						'<div class="steps-main">
							<h5 class="step-title" style="'.$text_color.'"><span>'. htmlspecialchars_decode($title) .'</span></h5>
							<div class="step-content" style="'.$text_color.'">'. htmlspecialchars_decode($subtitle) .'</div>
						</div>
					</div>'.$link_sufix.$custom_script.'
				</li>';
	}
	add_shortcode( 'tlg_steps_content', 'tlg_steps_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_steps_shortcode_vc') ) {
	function tlg_framework_steps_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Process Steps' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create a stepbed module', 'tlg_framework' ),
		    'icon' 				 	  	=> 'tlg_vc_icon_step',
		    'base'                    	=> 'tlg_steps',
		    'as_parent'               	=> array('only' => 'tlg_steps_content'),
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
		    			esc_html__( 'Standard', 'tlg_framework' ) 	=> 'steps-style-1',
		    			esc_html__( 'Rounded', 'tlg_framework' ) 	=> 'steps-style-2',
		    		),
		    		'admin_label' 	=> true,
		    	),
		    	array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display size', 'tlg_framework' ),
		    		'param_name' 	=> 'size',
		    		'value' 		=> array(
		    			esc_html__( 'Small', 'tlg_framework' ) 		=> '',
		    			esc_html__( 'Large', 'tlg_framework' ) 		=> 'steps-large',
		    		),
		    		'admin_label' 	=> true,
		    		'dependency' 	=> array('element' => 'style','value' => array('steps-style-1')),
		    	),
				vc_map_add_css_animation(),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_steps_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/	
if( !function_exists('tlg_framework_steps_content_shortcode_vc') ) {
	function tlg_framework_steps_content_shortcode_vc() {
		vc_map( array(
		    'name'            	=> esc_html__( 'Process Steps content', 'tlg_framework' ),
		    'description'     	=> esc_html__( 'Step content element', 'tlg_framework' ),
		    'icon' 			  	=> 'tlg_vc_icon_step',
		    'base'            	=> 'tlg_steps_content',
		    'category' 			=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' 	=> true,
		    'as_child'        	=> array('only' => 'tlg_steps'),
		    'params'          	=> array(
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
		    		'param_name' 	=> 'title',
		    		'holder' 		=> 'div',
		    		'admin_label' 	=> false,
		    	),
	            array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' 	=> 'subtitle',
					'holder' 		=> 'div',
				),
	            array(
	            	'type' 			=> 'tlg_icons',
	            	'heading' 		=> esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
	            	'description' 	=> esc_html__( 'Leave blank to hide icon.', 'tlg_framework' ),
	            	'param_name' 	=> 'icon',
	            ),
	            array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Step link', 'tlg_framework' ),
					'param_name' 	=> 'step_link',
					'value' 		=> '',
			  	),

	            // Colors
	            array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Text color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select text color for this step.', 'tlg_framework' ),
					'admin_label' 	=> false,
					'param_name' 	=> 'text_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Text color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select text color hover for this step.', 'tlg_framework' ),
					'admin_label' 	=> false,
					'param_name' 	=> 'text_color_hover',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select icon color for this step.', 'tlg_framework' ),
					'admin_label' 	=> false,
					'param_name' 	=> 'icon_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select icon color hover for this step.', 'tlg_framework' ),
					'admin_label' 	=> false,
					'param_name' 	=> 'icon_color_hover',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
	            array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select background color for this step.', 'tlg_framework' ),
					'admin_label' 	=> false,
					'param_name' 	=> 'bg_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Background color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select background color hover for this step.', 'tlg_framework' ),
					'admin_label' 	=> false,
					'param_name' 	=> 'bg_color_hover',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_steps_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/	
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tlg_steps extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tlg_steps_content extends WPBakeryShortCode {}
}