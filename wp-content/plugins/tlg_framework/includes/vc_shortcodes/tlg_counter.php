<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_counter_shortcode') ) {
	function tlg_framework_counter_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'to' => '2009',
			'suffix_text' => '',
			'title' => '',
			'icon' => '',
			'layout' => '',
			'color' => '',
			'icon_color' => '',
			'bg_color' => '',
			'title_color' => '',
			'text_color' => '',
			'icon_color_primary' => '',
			'text_color_primary' => '',
			'title_color_primary' => '',
		), $atts ) );
		$output = '';

		$styles_icon 	= $icon_color ? 'color:'.$icon_color.'!important;' : '';
		$styles_bg 		= $bg_color ? 'background-color:'.$bg_color.'!important;' : '';
		$styles_text    = $text_color ? 'color:'.$text_color.'!important;' : '';
		$styles_title   = $title_color ? 'color:'.$title_color.'!important;' : '';

		// GET STYLE
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}
		if ( ! empty( $styles_bg ) ) {
			$style_bg = 'style="' . esc_attr( $styles_bg ) . '"';
		} else {
			$style_bg = '';
		}
		if ( ! empty( $styles_text ) ) {
			$style_text = 'style="' . esc_attr( $styles_text ) . '"';
		} else {
			$style_text = '';
		}
		if ( ! empty( $styles_title ) ) {
			$style_title = 'style="' . esc_attr( $styles_title ) . '"';
		} else {
			$style_title = '';
		}

		switch ( $layout ) {

			case 'boxed':
				$output = '<div '.$style_bg.' class="fact-counter fact-boxed boxed boxed-intro shadow-hover '.esc_attr( $color ).'">
						<i '.$style_icon.' class="lg-text mb40 '. esc_attr( $icon. ' '.$icon_color_primary ) .' icon"></i>
						<div class="counter mb8">
							<span '.$style_text.' class="'.esc_attr( $text_color_primary ).' counter-number">'. $to .'</span>'.
							( $suffix_text ? '<span '.$style_text.' class="'.esc_attr( $text_color_primary ).' counter-suffix">'.$suffix_text.'</span>' : '' ).
						'</div>
						<span '.$style_title.' class="fact-title mb0 '.esc_attr( $title_color_primary ).' capitalize">'. $title .'</span>
					</div>';
				break;

			case 'side':
				$output = '<div class="fact-counter fact-side '.esc_attr( $color ).'">
						<div class="counter m0">
							<i '.$style_icon.' class="icon-text mb16 '. esc_attr( $icon. ' '.$icon_color_primary ) .' icon mr-15"></i>
							<span '.$style_text.' class="'.esc_attr( $text_color_primary ).' counter-number">'. $to .'</span>'.
							( $suffix_text ? '<span '.$style_text.' class="'.esc_attr( $text_color_primary ).' counter-suffix">'.$suffix_text.'</span>' : '' ).
							'</div>
						<span '.$style_title.' class="fact-title '.esc_attr( $title_color_primary ).' capitalize">'. $title .'</span>
					</div>';
				break;

			default:
				$output = '<div class="fact-counter fact-default '.esc_attr( $color ).'">
						<i '.$style_icon.' class="lg-text mb40 '. esc_attr( $icon. ' '.$icon_color_primary ) .' icon"></i>
						<div class="counter">
							<span '.$style_text.' class="'.esc_attr( $text_color_primary ).' counter-number">'. $to .'</span>'.
							( $suffix_text ? '<span '.$style_text.' class="'.esc_attr( $text_color_primary ).' counter-suffix">'.$suffix_text.'</span>' : '' ).
						'</div>
						<span '.$style_title.' class="fact-title '.esc_attr( $title_color_primary ).' capitalize">'. $title .'</span>
					</div>';
				break;
		}
		return $output;
	}
	add_shortcode( 'tlg_counter', 'tlg_framework_counter_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_counter_shortcode_vc') ) {
	function tlg_framework_counter_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Fact Counter', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds fact counter element', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_counter',
			'base' 			=> 'tlg_counter',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'To number', 'tlg_framework' ),
					'param_name' => 'to',
					'holder' => 'div',
					'min' => 1,
					'description' => esc_html__('Enter target number value', 'tlg_framework'),
					'value' => '2009',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Suffix text', 'tlg_framework' ),
					'param_name' 	=> 'suffix_text',
					'value' 		=> '',
					'admin_label' 	=> true,
					'description' => esc_html__( 'Enter a text/character after counter number, Ex: %.', 'tlg_framework' )
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'value' 		=> '',
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Default', 'tlg_framework' ) => '',
						esc_html__( 'Side', 'tlg_framework' ) => 'side',
						esc_html__( 'Boxed', 'tlg_framework' ) => 'boxed',
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
				array(
					'type' => 'tlg_icons',
					'heading' => esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'param_name' => 'icon',
					'description' => esc_html__( 'Leave blank to hide icon.', 'tlg_framework' )
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for background.', 'tlg_framework' ),
					'param_name' 	=> 'bg_color',
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Enable primary Icon color', 'tlg_framework' ),
					'param_name' => 'icon_color_primary',
					'value' => array(
						esc_html__( 'No', 'tlg_framework' ) => '',
						esc_html__( 'Yes', 'tlg_framework' ) => 'primary-color',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Enable primary Title color', 'tlg_framework' ),
					'param_name' => 'title_color_primary',
					'value' => array(
						esc_html__( 'No', 'tlg_framework' ) => '',
						esc_html__( 'Yes', 'tlg_framework' ) => 'primary-color',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Enable primary Text color', 'tlg_framework' ),
					'param_name' => 'text_color_primary',
					'value' => array(
						esc_html__( 'No', 'tlg_framework' ) => '',
						esc_html__( 'Yes', 'tlg_framework' ) => 'primary-color',
					),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Title color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for title.', 'tlg_framework' ),
					'param_name' 	=> 'title_color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Text color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for text.', 'tlg_framework' ),
					'param_name' 	=> 'text_color',
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_counter_shortcode_vc' );
}