<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_spacer_shortcode') ) {
	function tlg_framework_spacer_shortcode( $atts, $content = null ) {
		$height = $height_tablet = $height_mobile = '';
		extract(shortcode_atts(array(
			'height' 		=> '10',
			'height_tablet' => '',
			'height_mobile' => '',
			'layout' 		=> '',
			'line_style'	=> '',
			'line_width' 	=> '',
			'line_height' 	=> '',
			'line_color' 	=> '',
		),$atts));
		if( $height_tablet == '' ) $height_tablet = $height;
		if( $height_mobile == '' ) $height_mobile = $height;
		$style  = 'clear:both;display:block;height:'.$height.'px;';
		$style .= $height < 0 ? 'margin-top:'.$height.'px;' : '';
		if( 'line' == $layout ) {
			$line_width = $line_width ? 'width:'.$line_width.';' : '';
			$line_height = $line_height ? 'border-width:'.$line_height.'!important;' : '';
			$line_color = $line_color ? 'border-bottom-color:'.$line_color.';' : '';
			$style .= 'margin-top: '.(int)(-$height/2).'px; margin-bottom: '.(int)($height/2).'px; '.$line_color.$line_width.$line_height;
		}
		return '<div class="tlg-spacer '.esc_attr($layout. ' '.$line_style).'" data-height="'.esc_attr($height).'" data-height-tablet="'.esc_attr($height_tablet).'" data-height-mobile="'.esc_attr($height_mobile).'" style="'.$style.'"></div>';
	}
	add_shortcode( 'tlg_spacer', 'tlg_framework_spacer_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_spacer_shortcode_vc') ) {
	function tlg_framework_spacer_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Spacer / Divider', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adjust space between components.', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_spacer',
			'base' 			=> 'tlg_spacer',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Spacer Height - On Desktop', 'tlg_framework' ),
					'param_name' 	=> 'height',
					'holder' 		=> 'div',
					'suffix' 		=> 'px',
					'description' 	=> esc_html__('Enter value in pixels', 'tlg_framework'),
				),
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Spacer Height - On Tablet', 'tlg_framework' ),
					'param_name' 	=> 'height_tablet',
					'holder' 		=> 'div',
					'suffix' 		=> 'px',
					'description' 	=> esc_html__('Enter value in pixels', 'tlg_framework'),
				),
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Spacer Height - On Mobile', 'tlg_framework' ),
					'param_name' 	=> 'height_mobile',
					'holder' 		=> 'div',
					'suffix' 		=> 'px',
					'description' 	=> esc_html__('Enter value in pixels', 'tlg_framework'),
				),
				array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
		    		'param_name' 	=> 'layout',
		    		'holder' 		=> 'div',
		    		'value' 		=> array(
		    			esc_html__( 'Blank space', 'tlg_framework' ) 	=> '',
		    			esc_html__( 'Divider', 'tlg_framework' ) 		=> 'line',
		    		)
		    	),
		    	array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Divider style', 'tlg_framework' ),
		    		'param_name' 	=> 'line_style',
		    		'admin_label' 	=> true,
		    		'value' 		=> array(
		    			esc_html__( '(default)', 'tlg_framework' ) 	=> '',
		    			esc_html__( 'Large', 'tlg_framework' ) 		=> 'spacer-large',
		    		),
		    		'dependency' 	=> array('element' => 'layout', 'value' => array('line')),
		    	),
		    	array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Line width', 'tlg_framework' ),
					'param_name' 	=> 'line_width',
					'holder' 		=> 'div',
					'description' 	=> esc_html__('Enter value in pixels or percentage. Ex: 100px, 70% (Leave empty to use the default line width).', 'tlg_framework'),
					'dependency' 	=> array('element' => 'layout', 'value' => array('line')),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Line height', 'tlg_framework' ),
					'param_name' 	=> 'line_height',
					'holder' 		=> 'div',
					'description' 	=> esc_html__('Enter value in pixels or percentage. Ex: 5px (Leave empty to use the default line height).', 'tlg_framework'),
					'dependency' 	=> array('element' => 'layout', 'value' => array('line')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Line color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for this line.', 'tlg_framework' ),
					'param_name' 	=> 'line_color',
					'admin_label' 	=> false,
					'dependency' 	=> array('element' => 'layout', 'value' => array('line')),
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_spacer_shortcode_vc' );
}