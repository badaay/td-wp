<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_skill_bar_block_shortcode') ) {
	function tlg_framework_skill_bar_block_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'amount' => '',
			'style' => 'standard',
			'color' => 'warning',
			'custom_color' => '',
			'custom_text_color' => '',
			'css_animation' => '',
		), $atts ) );
		$styles_color = $custom_color ? 'background-color:'.$custom_color.';' : '';
		$styles_text_color = $custom_text_color ? 'color:'.$custom_text_color.';' : '';
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div class="'.esc_attr($animation_class).' progress-bars '. esc_attr($style) .'">
					<div style="'.$styles_text_color.'" class="maintitle capitalize">'. $title .'</div>
					<div class="meter '. esc_attr($color) .'">
						<span style="'.$styles_color.'width: '. (int) esc_attr($amount) . esc_html__( '%', 'tlg_framework' ) . '">
							<strong style="'.$styles_text_color.'">'. (int) esc_attr($amount) . esc_html__( '%', 'tlg_framework' ) .'</strong>
						</span>
					</div>
				</div>';
	}
	add_shortcode( 'tlg_skill_bar', 'tlg_framework_skill_bar_block_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_skill_bar_block_shortcode_vc') ) {
	function tlg_framework_skill_bar_block_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Skill Bar', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Progress bars for your skills', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_skill_bar',
			'base' 			=> 'tlg_skill_bar',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Skill title', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div',
				),
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Skill amount', 'tlg_framework' ),
					'param_name' => 'amount',
					'holder' => 'div',
					'min' => 1,
					'max' => 100,
					'suffix' => '%',
					'description' => esc_html__('Enter value between 0 - 100', 'tlg_framework'),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Skill color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Choose a color type for this skill bar.', 'tlg_framework' ),
					'param_name' 	=> 'color',
					'value' 		=> array(
						esc_html__( 'Warning', 'tlg_framework' ) 		=> 'warning',
						esc_html__( 'Danger', 'tlg_framework' ) 		=> 'danger',
						esc_html__( 'Success', 'tlg_framework' ) 		=> 'success',
						esc_html__( 'Highlight', 'tlg_framework' ) 	=> 'primary'
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Skill Custom Color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select the color schema. Leave empty to use default skill color', 'tlg_framework' ),
					'param_name' 	=> 'custom_color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Skill Text Color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select the color schema. Leave empty to use default skill color', 'tlg_framework' ),
					'param_name' 	=> 'custom_text_color',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Standard', 'tlg_framework' ) => 'standard',
						esc_html__( 'Big progress', 'tlg_framework' ) => 'big-progress'
					),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_skill_bar_block_shortcode_vc' );
}