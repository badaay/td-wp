<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_button_shortcode') ) {
	function tlg_framework_button_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'title' 	=> '',
			'btn_link' 	=> '',
			'btn_size' 	=> '',
			'layout' 	=> 'btn btn-filled',
			'hover' 	=> '',
			'icon' 		=> '',
			'alignment' => '',
			'button_icon_hover' => '',
			'button_inline' 	=> '',
			'customize_button' 	=> '',
			'btn_custom_layout' => 'btn',
			'btn_color' 		=> '',
			'btn_color_hover' 	=> '',
			'btn_bg' 			=> '',
			'btn_bg_hover' 		=> '',
			'btn_border' 		=> '',
			'btn_border_hover' 	=> '',
			'css_animation' 	=> '',
			'btn_bg_gradient' 		=> '',
			'btn_bg_gradient_hover' => '',
		), $atts ) );
		$custom_css = '';
		$custom_script 	= '';
		$element_id = uniqid('btn-');
		$btn_small_sm   = 'btn-sm-sm';

		// BUILD STYLE
		$styles_button 	= '';

		if ( 'yes' == $customize_button ) {
			$layout 			= $btn_custom_layout;
			$btn_color 			= $btn_color 				? $btn_color : '#565656';
			$btn_bg 			= $btn_bg 					? $btn_bg : 'transparent';
			$btn_bg 			= $btn_bg_gradient 			? 'linear-gradient(to right,'.$btn_bg.' 0%,'.$btn_bg_gradient.' 100%)' : $btn_bg;
			$btn_border 		= $btn_border 				? $btn_border : 'transparent';
			$btn_color_hover 	= $btn_color_hover 			? $btn_color_hover : $btn_color;
			$btn_bg_hover 		= $btn_bg_hover 			? $btn_bg_hover : $btn_bg;
			$btn_bg_hover 		= $btn_bg_gradient_hover 	? 'linear-gradient(to right,'.$btn_bg_hover.' 0%,'.$btn_bg_gradient_hover.' 100%)' : $btn_bg_hover;
			$btn_border_hover 	= $btn_border_hover 		? $btn_border_hover : $btn_border;

			$styles_button 		.= 'color:'.$btn_color.';background:'.$btn_bg.';border-color:'.$btn_border.';'.($btn_bg_gradient ? 'border: none!important;' : '');
			$custom_css 		.= '<style type="text/css" id="tlg-custom-css-'.$element_id.'">#'.$element_id.':hover{color:'.$btn_color_hover.'!important;background:'.$btn_bg_hover.'!important;border-color:'.$btn_border_hover.'!important;}</style>';
			$custom_script 	= "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		} else {
			if ("btn-action" == $layout) {
				$layout = "btn btn-filled btn-new ti-arrow-right";
				$btn_small_sm = '';
			}
		}

		// GET STYLE
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
		}

		// LINK
		$link_prefix = $link_sufix = '';
		$icon_hover = '';
		if( '' != $btn_link ) {
			$href = vc_build_link( $btn_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				if( $icon && 'yes' == $button_icon_hover ) {
					$icon_hover = '<i class="'.esc_attr($icon).'"></i>';
					$icon = '';
				}
				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id).'" class="'.esc_attr($layout . ' ' .$btn_size . ' ' .$icon . ' ' .$hover.' '.$btn_small_sm).'" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		$button_class = '';
		$button_class .= tlg_framework_get_css_animation( $css_animation );
		$button_class .= 'yes' == $button_inline  ? ' inline-block' : '';
		$button_class .= ' text-'.esc_attr($alignment);
		return '<div class="'.esc_attr($button_class).'">'.$link_prefix.$title.$icon_hover.$link_sufix.'</div>'.$custom_script;
	}
	add_shortcode( 'tlg_button', 'tlg_framework_button_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_button_shortcode_vc') ) {
	function tlg_framework_button_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Advanced Button', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds a button element', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_button',
			'base' 			=> 'tlg_button',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'value' 		=> '',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Button link', 'tlg_framework' ),
					'param_name' 	=> 'btn_link',
					'value' 		=> '',
			  	),
			  	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button size', 'tlg_framework' ),
					'param_name' 	=> 'btn_size',
					'value' 		=> array(
						esc_html__( 'Normal', 'tlg_framework' ) 	=> '',
						esc_html__( 'Mini', 'tlg_framework' ) 	=> 'btn-xs',
						esc_html__( 'Small', 'tlg_framework' ) 	=> 'btn-sm',
						esc_html__( 'Large', 'tlg_framework' ) 	=> 'btn-lg',
						esc_html__( 'Block', 'tlg_framework' ) 	=> 'btn-block',
					),
					'admin_label' 	=> true,
			  	),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> tlg_framework_get_button_layouts(),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Inline display?', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select \'Yes\' if you want to enable inline display on this button.', 'tlg_framework' ),
					'class' 		=> '',
					'admin_label' 	=> false,
					'param_name' 	=> 'button_inline',
					'value' 		=> array(
						esc_html__( 'No', 'tlg_framework' ) => '',
						esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
					),
			  	),
			  	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Alignment', 'tlg_framework' ),
					'param_name' 	=> 'alignment',
					'value' 		=> array(
						esc_html__( '(default)', 'tlg_framework' ) => '',
						esc_html__( 'Left', 'tlg_framework' ) => 'left',
						esc_html__( 'Right', 'tlg_framework' ) => 'right',
						esc_html__( 'Center', 'tlg_framework' ) => 'center',
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
					'admin_label' 	=> true,
				),
				array(
	            	'type' 			=> 'tlg_icons',
	            	'heading' 		=> esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
	            	'description' 	=> esc_html__( 'Leave blank to hide icons.', 'tlg_framework' ),
	            	'param_name' 	=> 'icon',
	            ),
	            array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Enable icon hover?', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select \'Yes\' if you want to enable icon hover on this button.', 'tlg_framework' ),
					'class' 		=> '',
					'admin_label' 	=> false,
					'param_name' 	=> 'button_icon_hover',
					'value' 		=> array(
						esc_html__( 'No', 'tlg_framework' ) => '',
						esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
					),
			  	),
			  	vc_map_add_css_animation(),
	            
	            // Customize buttons - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		            array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize button?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize colors/layout for this button.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_button',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
				  	),
				  	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Button customize layout', 'tlg_framework' ),
						'param_name' 	=> 'btn_custom_layout',
						'value' 		=> array(
							esc_html__( 'Standard', 'tlg_framework' ) => 'btn',
							esc_html__( 'Rounded', 'tlg_framework' ) 	=> 'btn btn-rounded',
							esc_html__( 'Standard Flat', 'tlg_framework' ) 	=> 'btn border-radius-0',
						),
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
						'admin_label' 	=> true,
				  	),
		            array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button background color (gradient)', 'tlg_framework' ),
						'description' 	=> esc_html__( 'To use combine with button background color above', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg_gradient',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER background color (gradient)', 'tlg_framework' ),
						'description' 	=> esc_html__( 'To use combine with button HOVER background color above', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg_gradient_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_button_shortcode_vc' );
}