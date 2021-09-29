<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_instagram_shortcode') ) {
	function tlg_framework_instagram_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'number' 		=> 8,
			'target' 		=> '_blank',
			'style' 		=> 'col-6',
			'css_animation' => '',
		), $atts ) );
		$output = '';
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		$access_token = get_option( 'tlg_framework_instagram_token', '' );
		if (!empty($access_token)) {
			$media_array = tlg_framework_get_instagram( $access_token, $transient = 'element' );
			if ( is_wp_error( $media_array ) ) {
				echo wp_kses_post( $media_array->get_error_message() );
			} else {
				$media_array = array_slice( $media_array, 0, $number );
				$output .= '<div class="'.esc_attr($animation_class).' instagram-feed '.esc_attr($style).'"><ul>';
				foreach ( $media_array as $item ) {
					$output .= '<li class="p0 m0">
									<div class="image-box hover-meta text-center mb0">
										<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'">
											<img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_html__( 'instagram-image', 'tlg_framework' ) .'">
											<div class="meta-caption">
										    	<h5 class="color-white to-top mb8"><i class="ti-instagram"></i>'.esc_attr( $item['username'] ).'</h5>
										    	<h6 class="color-white to-top-after">'.esc_attr( tlg_framework_limit_text($item['description'], 40) ).'</h6>
										    </div>
										</a>
									</div>
								</li>';
				}
				$output .= '</ul></div>';
			}
		} else {
			$output .= '<div class="container"><p class="fade-color"><i>'.esc_html__( 'Instagram Access Token is missing, please add the access token in your Dashboard > Appearances > Customize > System > Instagram Access Token.', 'tlg_framework' ).'</i></p></div>';
		}
		return $output;
	}
	add_shortcode( 'tlg_instagram', 'tlg_framework_instagram_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_instagram_shortcode_vc') ) {
	function tlg_framework_instagram_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Instagram', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Instagram feed images', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_instagram',
			'base' 			=> 'tlg_instagram',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' .esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Number of images', 'tlg_framework' ),
					'param_name' => 'number',
					'holder' => 'div',
					'min' => 1,
					'max' => 12,
					'value' => '8',
					'description' => esc_html__( '* In order to use Instagram widget, please make sure you\'ve added an Access Token in your Dashboard > Appearances > Customize > System > Instagram Access Token.', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Open images in', 'tlg_framework' ),
					'param_name' 	=> 'target',
					'value' 		=> array(
						esc_html__( 'New window', 'tlg_framework' ) 	=> '_blank',
						esc_html__( 'Current window', 'tlg_framework' ) => '_self',
					),
					'admin_label' 	=> false,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' 	=> 'style',
					'value' 		=> array(
						esc_html__( '6 Columns', 'tlg_framework' ) 	=> 'col-6', // 16.66%
						esc_html__( '4 Columns', 'tlg_framework' ) 	=> 'col-4', // 25%
						esc_html__( '2 Columns', 'tlg_framework' ) 	=> 'col-2', // 50%
						esc_html__( '8 Columns', 'tlg_framework' ) 	=> 'col-8', // 12.5%
					),
					'description' 	=> esc_html__( 'Choose a display style for this instagram.', 'tlg_framework' ),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_instagram_shortcode_vc' );
}