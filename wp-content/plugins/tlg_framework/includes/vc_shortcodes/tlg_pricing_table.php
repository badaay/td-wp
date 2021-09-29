<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_pricing_table_shortcode') ) {
	function tlg_framework_pricing_table_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 		=> '',
			'subtitle' 		=> '',
			'icon' 			=> '',
			'amount' 		=> '200',
			'currency'		=> esc_html__( '$', 'tlg_framework' ),
			'period' 		=> esc_html__( '/ month', 'tlg_framework' ),
			'btn_text' 		=> esc_html__( 'Choose plan', 'tlg_framework' ),
			'btn_link' 		=> '',
			'btn_layout' 	=> 'btn btn-filled',
			'btn_size' 		=> '',
			'btn_hover' 	=> '',
			'css_animation' => '',
			'customize_button' 			=> '',
			'btn_custom_layout' 		=> 'btn',
			'btn_color' 				=> '',
			'btn_color_hover' 			=> '',
			'btn_bg' 					=> '',
			'btn_bg_hover' 				=> '',
			'btn_border' 				=> '',
			'btn_border_hover' 			=> '',
			'btn_bg_gradient' 			=> '',
			'btn_bg_gradient_hover' 	=> '',
			'customize_table' 			=> '',
			'tbl_header_bg_color'		=> '',
			'tbl_icon_color'			=> '',
			'tbl_icon_bgcolor' 			=> '',
			'tbl_title_color'			=> '',
			'tbl_subtitle_color'		=> '',
			'tbl_color'					=> '',
			'tbl_price_bg_color'		=> '',
			'tbl_price_border_color'	=> '',
			'tbl_price_color' 			=> '',
			'tbl_list_color' 			=> '',
			'tbl_bg'					=> '',
			'tbl_border'				=> '',
		), $atts ) );
		$output 		= '';
		$custom_css 	= '';
		$custom_script  = '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$element_id 	= uniqid('btn-');
		$element_id_tbl = uniqid('tbl-');
		$btn_small_sm   = 'btn-sm-sm';

		// BUILD STYLE
		$styles_button 		= '';
		$styles_table 		= '';
		$styles_title 		= '';
		$styles_subtitle 	= '';
		$styles_price 		= '';
		$styles_header 		= '';
		$styles_icon 		= '';

		if ( 'yes' == $customize_button ) {
			$btn_layout 		= $btn_custom_layout;
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
		} else {
			if ("btn-action" == $btn_layout) {
				$btn_layout = "btn btn-filled btn-new ti-arrow-right";
				$btn_small_sm = '';
			}
		}
		
		if ( 'yes' == $customize_table ) {
			$tbl_header_bg_color 	= $tbl_header_bg_color 		? $tbl_header_bg_color : '';
			$tbl_color 				= $tbl_color 				? $tbl_color : '#565656';
			$tbl_price_bg_color 	= $tbl_price_bg_color 		? $tbl_price_bg_color : 'rgba(0,0,0,.15)';
			$tbl_price_border_color = $tbl_price_border_color 	? $tbl_price_border_color : '';
			$tbl_price_color 		= $tbl_price_color 			? $tbl_price_color : '#28262b';
			$tbl_bg 				= $tbl_bg 					? $tbl_bg : '';
			$tbl_border 			= $tbl_border 				? $tbl_border : '';
			$tbl_icon_color 		= $tbl_icon_color 			? $tbl_icon_color : '#28262b';
			$tbl_icon_bgcolor 		= $tbl_icon_bgcolor 		? $tbl_icon_bgcolor : '';
			$tbl_title_color 		= $tbl_title_color 			? $tbl_title_color : '#28262b';
			$tbl_subtitle_color 	= $tbl_subtitle_color 		? $tbl_subtitle_color : '#bcbcbc';

			$styles_table 		.= 'color:'.$tbl_color.';background-color:'.$tbl_bg.';border-color:'.$tbl_border.';';
			$styles_header 		.= 'background-color:'.$tbl_header_bg_color.';';
			$styles_icon		.= 'color:'.$tbl_icon_color.';background-color:'.$tbl_icon_bgcolor.';';
			$styles_title 		.= 'color:'.$tbl_title_color.';';
			$styles_subtitle 	.= 'color:'.$tbl_subtitle_color.';';
			$styles_price 		.= 'color:'.$tbl_price_color.';background-color:'.$tbl_price_bg_color.';border-color:'.$tbl_price_border_color.';';
			if (!empty($tbl_list_color)) {
				$custom_css 	.= '<style type="text/css" id="tlg-custom-css-'.$element_id_tbl.'">#'.$element_id_tbl.' ul li:nth-child(odd){background-color:'.$tbl_list_color.';}</style>';
			}
		}

		if ( ! empty( $custom_css ) ) {
			$custom_script = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		// GET STYLE
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
		}
		if ( ! empty( $styles_table ) ) {
			$style_table = 'style="' . esc_attr( $styles_table ) . '"';
		} else {
			$style_table = '';
		}
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}
		if ( ! empty( $styles_title ) ) {
			$style_title = 'style="' . esc_attr( $styles_title ) . '"';
		} else {
			$style_title = '';
		}
		if ( ! empty( $styles_subtitle ) ) {
			$style_subtitle = 'style="' . esc_attr( $styles_subtitle ) . '"';
		} else {
			$style_subtitle = '';
		}
		if ( ! empty( $styles_price ) ) {
			$style_price = 'style="' . esc_attr( $styles_price ) . '"';
		} else {
			$style_price = '';
		}
		if ( ! empty( $styles_header ) ) {
			$style_header = 'style="' . esc_attr( $styles_header ) . '"';
		} else {
			$style_header = '';
		}

		// LINK
		if( '' != $btn_link ) {
			$href = vc_build_link( $btn_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id).'" class="'.esc_attr($btn_layout . ' ' .$btn_hover . ' ' . $btn_size.' '.$btn_small_sm).' mb0" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div '.$style_table.' id="'.esc_attr($element_id_tbl).'" class="'.esc_attr($animation_class).' pricing-standard text-center">'.
			'<div class="pricing-header" '.$style_header.'>'.
				( $icon ? '<div class="pricing-icon text-center"><i '.$style_icon.' class="l-text m-text mb24 inline-block '.esc_attr($icon).'"></i></div>' : '').
				( $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '' ).
				( $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ).
			'</div>'.
			'<div class="pricing" '.$style_price.'>'.
				( $amount ? '<span class="price"><span>'. htmlspecialchars_decode($currency). '</span>' .htmlspecialchars_decode($amount) .'</span>' : '').
				( $period ? '<p class="lead">'. htmlspecialchars_decode($period) .'</p>' : '' ).
			'</div>'.
			( wpautop(do_shortcode(htmlspecialchars_decode($content))) ).
			( $btn_text ? $link_prefix.htmlspecialchars_decode($btn_text).$link_sufix : '' ).'</div>'.$custom_script;
	}
	add_shortcode( 'tlg_pricing_table', 'tlg_framework_pricing_table_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_pricing_table_shortcode_vc') ) {
	function tlg_framework_pricing_table_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Pricing Table', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Add a pricing table to the page', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_pricing_table',
			'base' 			=> 'tlg_pricing_table',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'holder' 		=> 'div',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' 	=> 'subtitle',
					'holder' 		=> 'div',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Amount', 'tlg_framework' ),
					'param_name' 	=> 'amount',
					'value' 		=> esc_html__( '200', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Currency', 'tlg_framework' ),
					'param_name' 	=> 'currency',
					'value' 		=> esc_html__( '$', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Period', 'tlg_framework' ),
					'param_name' 	=> 'period',
					'value' 		=> esc_html__( '/ month', 'tlg_framework' ),
				),
			  	array(
					'type' 			=> 'textarea_html',
					'heading' 		=> esc_html__( 'Content', 'tlg_framework' ),
					'param_name' 	=> 'content'
				),
				array(
					'type' 			=> 'tlg_icons',
					'heading' 		=> esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'param_name' 	=> 'icon',
					'description' 	=> esc_html__( 'Leave blank to hide icon.', 'tlg_framework' )
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Button text', 'tlg_framework' ),
					'param_name' 	=> 'btn_text',
					'value' 		=> esc_html__( 'Choose Plan', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Button link', 'tlg_framework' ),
					'param_name' 	=> 'btn_link',
					'value' 		=> '',
			  	),
			  	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button display style', 'tlg_framework' ),
					'param_name' 	=> 'btn_layout',
					'value' 		=> tlg_framework_get_button_layouts(),
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
					'heading' 		=> esc_html__( 'Button animation', 'tlg_framework' ),
					'param_name' 	=> 'btn_hover',
					'value' 		=> tlg_framework_get_hover_effects(),
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
						'description' 	=> esc_html__( 'To use combine with button background color above.', 'tlg_framework' ),
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
					
				// Customize table - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		            array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize table?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize colors/layout for this table.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_table',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
				  	),
				  	array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table header background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select background color for table header.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_header_bg_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table icon background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table background icon.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_icon_bgcolor',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table icon color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table icon.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_icon_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
				  	array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table title color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table title.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_title_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table subtitle color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table subtitle.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_subtitle_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table price background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select background color for table price.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_price_bg_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table price border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select border color for table price.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_price_border_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table price color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select text color for table price.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_price_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
		            array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table text.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Feature list background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for feature list background color.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_list_color',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table background.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_bg',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Table border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for table border.', 'tlg_framework' ),
						'param_name' 	=> 'tbl_border',
						'group' 		=> esc_html__( 'Table Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_table','value' => array('yes')),
					),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_pricing_table_shortcode_vc' );
}