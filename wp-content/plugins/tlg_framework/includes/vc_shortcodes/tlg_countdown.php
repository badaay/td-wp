<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_countdown_shortcode') ) {
	function tlg_framework_countdown_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'datetime' 			=> '',
			'color' 			=> '',
			'border_color'		=> '',
			'bg_color'			=> '',
			'color_number' 		=> '',
			'layout' 			=> 'standard',
			'align' 			=> 'text-center',
			'caption_day' 		=> esc_html__( 'days', 'tlg_framework' ),
			'caption_week' 		=> esc_html__( 'weeks', 'tlg_framework' ),
			'caption_day_2' 	=> esc_html__( 'days', 'tlg_framework' ),
			'caption_hour' 		=> esc_html__( 'hr', 'tlg_framework' ),
			'caption_minute' 	=> esc_html__( 'min', 'tlg_framework' ),
			'caption_second' 	=> esc_html__( 'sec', 'tlg_framework' ),
		), $atts ) );
		$element_id = uniqid('countdown-');
		$custom_css = '';
		$custom_script = '';
		$color 			= $color ? 'color:'.$color.'!important;' : '';
		$color_number 	= $color_number ? 'color:'.$color_number.'!important;' : '';
		$bg_color 		= $bg_color ? 'background-color:'.$bg_color.'!important;' : '';
		$border_color 	= $border_color ? 'border: 1px solid '.$border_color.'!important;' : '';

		if( $color || $bg_color || $border_color ) {
			$custom_css .= '#'.$element_id.' .countdown-part{'.$color_number.$bg_color.$border_color .'}';
			$custom_css .= '#'.$element_id.' .countdown-part span{'.$color.'}';
			$custom_css = '<style type="text/css" id="tlg-custom-css-'.$element_id.'">'.$custom_css.'</style>';
			$custom_script = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		$cd_class = $layout && 'standard' != $layout ? 'countdown-legacy '.$layout : 'countdown';
		if ( $layout && 'standard' != $layout ) {
			$cd_class = 'countdown-legacy '.$layout;
			$el_data = ' data-week="'. esc_attr($caption_week) .'" data-day="'. esc_attr($caption_day_2) .'" data-hour="'. esc_attr($caption_hour) .'" data-minute="'. esc_attr($caption_minute) .'" data-second="'. esc_attr($caption_second) .'" ';
		} else {
			$cd_class = 'countdown';
			$el_data = ' data-day="'. esc_attr($caption_day) .'" ';
		}
		return '<div id="'.esc_attr($element_id).'" class="'. esc_attr($cd_class). ' ' .esc_attr($align) .'" data-date="'. esc_attr($datetime) . '"' .$el_data. '></div>'.$custom_script;
	}
	add_shortcode( 'tlg_countdown', 'tlg_framework_countdown_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_countdown_shortcode_vc') ) {
	function tlg_framework_countdown_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Countdown', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds countdown element', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_countdown',
			'base' 			=> 'tlg_countdown',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
			   		'type' => 'tlg_datetime',
					'class' => '',
					'heading' => esc_html__( 'Target time for countdown', 'tlg_framework' ),
					'param_name' => 'datetime',
					'value' => '', 
					'admin_label' => true,
					'description' => esc_html__( 'Date and time format (yyyy/mm/dd).', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Text color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for the countdown text.', 'tlg_framework' ),
					'param_name' 	=> 'color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Number color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for the countdown number.', 'tlg_framework' ),
					'param_name' 	=> 'color_number',
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select background color for the countdown.', 'tlg_framework' ),
					'param_name' 	=> 'bg_color',
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Border color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select border color for the countdown.', 'tlg_framework' ),
					'param_name' 	=> 'border_color',
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Standard', 'tlg_framework' ) => 'standard',
						esc_html__( 'Boxed', 'tlg_framework' ) => 'boxed',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Alignment', 'tlg_framework' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'tlg_framework' ) => 'text-center',
						esc_html__( 'Left', 'tlg_framework' ) => 'text-left',
						esc_html__( 'Right', 'tlg_framework' ) => 'text-right',
					),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Day caption', 'tlg_framework' ),
					'class' 		=> '',
					'param_name' 	=> 'caption_day',
					'value' 		=> esc_html__( 'days', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'layout','value' => array('standard')),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Week caption', 'tlg_framework' ),
					'class' 		=> '',
					'param_name' 	=> 'caption_week',
					'value' 		=> esc_html__( 'weeks', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Day caption', 'tlg_framework' ),
					'class' 		=> '',
					'param_name' 	=> 'caption_day_2',
					'value' 		=> esc_html__( 'days', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Hour caption', 'tlg_framework' ),
					'class' 		=> '',
					'param_name' 	=> 'caption_hour',
					'value' 		=> esc_html__( 'hr', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Minute caption', 'tlg_framework' ),
					'class' 		=> '',
					'param_name' 	=> 'caption_minute',
					'value' 		=> esc_html__( 'min', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Second caption', 'tlg_framework' ),
					'class' 		=> '',
					'param_name' 	=> 'caption_second',
					'value' 		=> esc_html__( 'sec', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_countdown_shortcode_vc' );
}