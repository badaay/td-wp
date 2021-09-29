<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_image_caption_shortcode') ) {
	function tlg_framework_image_caption_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' 		=> '',
			'style' 		=> 'hover-caption',
			'title' 		=> '',
			'subtitle' 		=> '',
			'image_link' 	=> '',
			'title_size' 	=> '',
			'subtitle_size' => '',
			'css_animation' => '',

			'button_text' 		=> '',
			'title_color' 		=> '',
			'subtitle_color' 	=> '',
			'bgcolor' 			=> '',
		), $atts ) );
		$output 		= '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$custom_css 	= '';
		$element_id 	= uniqid('capion-');

		// BUILD STYLE
		$styles_title 		= '';
		$styles_subtitle 	= '';
		$styles_caption 	= '';

		$styles_title 		.= $title_size 		? 'font-size:'.$title_size.'px;line-height:'.($title_size+10).'px;' : '';
		$styles_title 		.= $title_color 	? 'color:'.$title_color.'!important;' : '';

		$styles_subtitle 	.= $subtitle_size 	? 'font-size:'.$subtitle_size.'px;line-height:'.($subtitle_size+5).'px;' : '';
		$styles_subtitle 	.= $subtitle_color 	? 'color:'.$subtitle_color.'!important;' : '';

		$styles_caption 	.= $bgcolor 		? 'background-color:'.$bgcolor.';' : '';
		
		// GET STYLE
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
		if ( ! empty( $styles_caption ) ) {
			$style_caption = 'style="' . esc_attr( $styles_caption ) . '"';
		} else {
			$style_caption = '';
		}
		
		// LINK
		if( '' != $image_link ) {
			$href = vc_build_link( $image_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		$tlg_image = wp_get_attachment_image($image, 'full');
		if (empty($tlg_image)) {
			$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
		}
		if ( 'hover-caption' == $style ) {
			$output = $link_prefix.'<div class="image-caption '.esc_attr($style).'">'. $tlg_image .
				        '<div class="caption">'.
				            '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>'.
				    		'<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>'.
				        '</div></div>'.$link_sufix;
		} else if ( 'visible-caption' == $style ) {
			$output = $link_prefix.'<div class="image-caption overlay-caption '.esc_attr($style).'">'. $tlg_image .
				        '<div '.$style_caption.' class="caption">'.
				            '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>'.
				    		'<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>'.
				    		'<span class="btn--icon">'.($button_text ? $button_text : esc_html__( 'View More', 'tlg_framework' )).'<i class="ti-angle-right"></i></span>'.
				        '</div></div>'.$link_sufix;
		} else {
			$output = '<div class="tlg-banner"><figure class="'.esc_attr($style).'">'. $tlg_image .
						'<figcaption>'.
							'<div><h2 '.$style_title.'>'. htmlspecialchars_decode($title) .'</h2>'.
							'<p '.$style_subtitle.' >'. htmlspecialchars_decode($subtitle) .'</p></div>'. 
							( $link_prefix && $link_sufix ? $link_prefix. esc_html__( 'View More', 'tlg_framework' ) . $link_sufix : '' ) .
						'</figcaption></figure></div>';
		}
		return '<div class="'.esc_attr($animation_class).' image-captions">'.$output.'</div>';
	}
	add_shortcode( 'tlg_image_caption', 'tlg_framework_image_caption_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_image_caption_shortcode_vc') ) {
	function tlg_framework_image_caption_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Image Caption', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds image with hover caption', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_image_caption',
			'base' 			=> 'tlg_image_caption',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'tlg_framework' ),
					'param_name' => 'image'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Standard hover', 'tlg_framework' ) 	=> 'hover-caption',
						esc_html__( 'Hover style 1', 'tlg_framework' ) 		=> 'hover-caption-1',
		  				esc_html__( 'Hover style 2', 'tlg_framework' ) 		=> 'hover-caption-2',
						esc_html__( 'Hover style 3', 'tlg_framework' ) 		=> 'hover-caption-3',
						esc_html__( 'Hover style 4', 'tlg_framework' ) 		=> 'hover-caption-4',
		 				esc_html__( 'Hover style 5', 'tlg_framework' ) 		=> 'hover-caption-5',
		 				esc_html__( 'Visible caption', 'tlg_framework' ) 	=> 'visible-caption',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' => 'subtitle',
					'holder' => 'div',
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Image caption link (optional)', 'tlg_framework' ),
					'param_name' 	=> 'image_link',
					'value' 		=> '',
			  	),
			  	array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Title font size', 'tlg_framework' ),
					'param_name' 	=> 'title_size',
					'holder' 		=> 'div',
					'min' 			=> 1,
					'suffix' 		=> 'px',
					'admin_label' 	=> false,
					'description' 	=> esc_html__( 'Leave empty to use the default title font style.', 'tlg_framework' ),
				),
			  	array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Subtitle font size', 'tlg_framework' ),
					'param_name' 	=> 'subtitle_size',
					'holder' 		=> 'div',
					'min' 			=> 1,
					'suffix' 		=> 'px',
					'admin_label' 	=> false,
					'description' 	=> esc_html__( 'Leave empty to use the default subtitle font style.', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Title color', 'tlg_framework' ),
					'param_name' 	=> 'title_color',
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Subtitle color', 'tlg_framework' ),
					'param_name' 	=> 'subtitle_color',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Visible text button', 'tlg_framework' ),
					'param_name' 	=> 'button_text',
					'holder' 		=> 'div',
					'dependency' 	=> array('element' => 'style','value' => array('visible-caption')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Visible caption background color', 'tlg_framework' ),
					'param_name' 	=> 'bgcolor',
					'dependency' 	=> array('element' => 'style','value' => array('visible-caption')),
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_image_caption_shortcode_vc' );
}