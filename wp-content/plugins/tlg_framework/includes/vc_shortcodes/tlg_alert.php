<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_alert_shortcode') ) {
	function tlg_framework_alert_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'warning',
			'style' => ''
		), $atts ) );
		switch ( $color ) {
			case 'success':
				$output = '<div class="alert alert-success alert-dismissible '.esc_attr($style).'" role="alert">'.
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				htmlspecialchars_decode($content) .'</div>';
				break;
			case 'danger':
				$output = '<div class="alert alert-danger alert-dismissible '.esc_attr($style).'" role="alert">'.
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				htmlspecialchars_decode($content) .'</div>';
				break;
			case 'dark':
				$output = '<div class="alert alert-dark alert-dismissible '.esc_attr($style).'" role="alert">'.
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				htmlspecialchars_decode($content) .'</div>';
				break;
			case 'primary':
				$output = '<div class="alert alert-primary alert-dismissible '.esc_attr($style).'" role="alert">'.
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				htmlspecialchars_decode($content) .'</div>';
				break;
			case 'warning':
			default:
				$output = '<div class="alert alert-warning alert-dismissible '.esc_attr($style).'" role="alert">'.
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				htmlspecialchars_decode($content) .'</div>';
				break;
		}
		return $output;
	}
	add_shortcode( 'tlg_alert', 'tlg_framework_alert_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_alert_shortcode_vc') ) {
	function tlg_framework_alert_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Alert Bar', 'tlg_framework' ),
			'description' 	=> esc_html__( 'An alert bar content', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_alert',
			'base' 			=> 'tlg_alert',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' .esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'textarea_html',
					'heading' 		=> esc_html__( 'Alert content', 'tlg_framework' ),
					'param_name' 	=> 'content',
					'holder' 		=> 'div'
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Alert color', 'tlg_framework' ),
					'param_name' 	=> 'color',
					'value' 		=> array(
						esc_html__( 'Warning', 'tlg_framework' ) 		=> 'warning',
						esc_html__( 'Danger', 'tlg_framework' ) 		=> 'danger',
						esc_html__( 'Success', 'tlg_framework' ) 		=> 'success',
						esc_html__( 'Highlight', 'tlg_framework' ) 	=> 'primary',
						esc_html__( 'Dark', 'tlg_framework' ) 	=> 'dark',
					),
					'description' 	=> esc_html__( 'Choose a color type for this alert.', 'tlg_framework' ),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' 	=> 'style',
					'value' 		=> array(
						esc_html__( 'Border line', 'tlg_framework' ) 			=> '',
						esc_html__( 'Solid background', 'tlg_framework' ) 	=> 'alert-bg',
					),
					'description' 	=> esc_html__( 'Choose a display style for this alert.', 'tlg_framework' ),
					'admin_label' 	=> true,
				)
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_alert_shortcode_vc' );
}