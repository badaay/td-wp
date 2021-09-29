<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_intro_carousel_shortcode') ) {
	function tlg_framework_intro_carousel_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'intro-right',
			'css_animation' => '',
		), $atts ) );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		if( 'box-top' == $style ) {
			if ( is_rtl() ) {
				$output = '<section class="'.esc_attr($animation_class).' p0"><div class="intro-carousel-box blog-carousel-rtl owl-carousel owl-theme blog-carousel-detail three-columns">'. do_shortcode($content) .'</div></section>';
			} else {
				$output = '<section class="'.esc_attr($animation_class).' p0"><div class="intro-carousel-box blog-carousel owl-carousel owl-theme blog-carousel-detail three-columns">'. do_shortcode($content) .'</div></section>';
			}
		} else {
			$output = '<div class="intro-carousel owl-carousel owl-theme '.esc_attr($animation_class).' '.esc_attr($style).'">'. do_shortcode($content) .'</div>';
			if( substr_count( $content, '[tlg_intro_carousel_content' ) > 1 ) {
				if ( is_rtl() ) {
					$output .= '<script type="text/javascript">jQuery(document).ready(function() {jQuery(\'.intro-carousel\').owlCarousel({rtl: true, nav: true, navigation: true, dots: false, center: true, loop:true, animateIn: \'fadeIn\', animateOut: \'fadeOut\', responsive:{0:{items:1}}});});</script>';
				} else {
					$output .= '<script type="text/javascript">jQuery(document).ready(function() {jQuery(\'.intro-carousel\').owlCarousel({nav: true, navigation: true, dots: false, center: true, loop:true, animateIn: \'fadeIn\', animateOut: \'fadeOut\', responsive:{0:{items:1}}});});</script>';
				}
			}
		}
		return $output;
	}
	add_shortcode( 'tlg_intro_carousel', 'tlg_framework_intro_carousel_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/	
if( !function_exists('tlg_framework_text_image_shortcode') ) {
	function tlg_framework_intro_carousel_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'layout' 		=> '',
			'image' 		=> '',
			'title' 		=> '',
			'title_link' 	=> '',
			'subtitle' 		=> '',
			'subtitle_style' => '',
			'btn_link' 		=> '',
			'subtitle_link' => '',
			'button_text' 	=> '',
			'icon' 			=> '',
			'button_icon_hover' => '',
			'button_layout'	=> 'btn btn-filled',
			'style' 		=> 'right',
			'hover' 		=> '',
			'customize_button' 		 => '',
			'btn_custom_layout' 	 => 'btn',
			'btn_color' 			 => '',
			'btn_color_hover' 		 => '',
			'btn_bg' 				 => '',
			'btn_bg_hover' 			 => '',
			'btn_border' 			 => '',
			'btn_border_hover' 		 => '',
			'btn_bg_gradient' 		 => '',
			'btn_bg_gradient_hover'  => '',
		), $atts ) );
		$custom_css 	= '';
		$custom_script  = '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$element_id 	= uniqid('btn-');
		$btn_small_sm   = 'btn-sm-sm';

		// BUILD STYLE
		$styles_button 	= '';

		if ( 'yes' == $customize_button ) {
			$button_layout 		= $btn_custom_layout;
			$btn_color 			= $btn_color 				? $btn_color : '#565656';
			$btn_bg 			= $btn_bg 					? $btn_bg : 'transparent';
			$btn_bg 			= $btn_bg_gradient 			? 'linear-gradient(to right,'.$btn_bg.' 0%,'.$btn_bg_gradient.' 100%)' : $btn_bg;
			$btn_border 		= $btn_border 				? $btn_border : 'transparent';
			$btn_color_hover 	= $btn_color_hover 			? $btn_color_hover : $btn_color;
			$btn_bg_hover 		= $btn_bg_hover 			? $btn_bg_hover : $btn_bg;
			$btn_bg_hover 		= $btn_bg_gradient_hover 	? 'linear-gradient(to right,'.$btn_bg_hover.' 0%,'.$btn_bg_gradient_hover.' 100%)' : $btn_bg_hover;
			$btn_border_hover 	= $btn_border_hover ? $btn_border_hover : $btn_border;

			$styles_button 		.= 'color:'.$btn_color.';background:'.$btn_bg.';border-color:'.$btn_border.';'.($btn_bg_gradient ? 'border: none!important;' : '');
			$custom_css 		.= '<style type="text/css" id="tlg-custom-css-'.$element_id.'">#'.$element_id.':hover{color:'.$btn_color_hover.'!important;background:'.$btn_bg_hover.'!important;border-color:'.$btn_border_hover.'!important;}</style>';
			$custom_script = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		} else {
			if ("btn-action" == $button_layout) {
				$button_layout = "btn btn-filled btn-new ti-arrow-right";
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
				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id).'" class="' .esc_attr( $button_layout. ' ' . $icon . ' ' .$hover.' '.$btn_small_sm ). ' btn-sm text-center mr-0 mb0 '.('boxed' == $layout ? 'mt16' : 'mt24').'" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}
		// LINK TITLE
		$link_title_prefix = $link_title_sufix = '';
		if( '' != $title_link ) {
			$href = vc_build_link( $title_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_title_prefix 	= '<a href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_title_sufix 	= '</a>';
			}
		}
		if (strpos($layout, 'boxed') !== false) {
			$heading_tag = "h5";
		} else {
			$heading_tag = "h2";
		}
		$button = $button_text ? $link_prefix. $button_text.$icon_hover .$link_sufix : '';
		$title_content = ( $title ? $link_title_prefix."<$heading_tag ".' class="widgettitle '.('boxed' == $layout ? 'mt0' : ($subtitle ? 'm0' : '')).($link_title_prefix ? 'dark-hover' : '').'">'. ($title) ."</$heading_tag>".$link_title_sufix : '' );
		$subtitle_content = ( $subtitle ? '<div class="widgetsubtitle '.('boxed' == $layout ? '' : 'subtitle_light').'">'. ($subtitle) .'</div>' : '');
		$main_content = (!empty($content) ? '<div class="blog-boxed-content">'.do_shortcode(wpautop($content)) .'</div>' : '');
		if( 'boxed' == $layout ) {
			$tlg_image = wp_get_attachment_image( $image, 'navian_grid', 0, array('class' => 'background-image', 'alt' => 'page-header') );
			if (empty($tlg_image)) {
				$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
			}
			$output = '<div class="grid-blog layout-carousel"><div class="intro-content-box icon-hover boxed-intro blog-boxed overflow-hidden heavy-shadow zoom-hover">
							<div class="overflow-hidden relative  '.(!empty($subtitle) && 'box' == $subtitle_style ? 'pb16' : '').'">
                				<div class="intro-image overflow-hidden relative">'.$link_title_prefix.
									$tlg_image .($link_title_prefix ? '<span class="overlay-default"></span><span class="plus-icon"></span>' : '').$link_title_sufix.'
								</div>'.
								(!empty($subtitle) && 'box' == $subtitle_style ? '<span class="cat-name"><span class="cat-link"><i class="fa fa-tag pr-6"></i>' . ($subtitle) . '</span></span>' : '').
							'</div>
							<div class="intro-content">'.(empty($subtitle_style) && !empty($subtitle) ? '<div class="subtitle-box">' . ($subtitle) . '</div>' : '').$title_content.$main_content.$button.$custom_script.'</div>
						</div></div>';
		} else {
			$tlg_image = wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image', 'alt' => 'page-header') );
			if (empty($tlg_image)) {
				$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
			}
			$output = '<section class="image-square">
						<div class="col-md-6 image"><div class="background-content">'. $tlg_image .'</div>
						</div>
					    <div class="col-md-6 content">'.
					    $title_content.$subtitle_content.'<div class="primary-line"></div>'.
					    $main_content.$button.$custom_script.
					    '</div></section>';
		}
		return $output;
	}
	add_shortcode( 'tlg_intro_carousel_content', 'tlg_framework_intro_carousel_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_intro_carousel_shortcode_vc') ) {
	function tlg_framework_intro_carousel_shortcode_vc() {
		vc_map( array(
		    'name' 						=> esc_html__( 'Intro Carousel' , 'tlg_framework' ),
		    'description' 				=> esc_html__( 'Create fancy carousel image', 'tlg_framework' ),
		    'icon' 						=> 'tlg_vc_icon_intro_carousel',
		    'base' 						=> 'tlg_intro_carousel',
		    'as_parent' 				=> array('only' => 'tlg_intro_carousel_content'),
		    'content_element' 			=> true,
		    'show_settings_on_create' 	=> false,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params' 					=> array(
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' 	=> 'style',
					'value' 		=> array(
						esc_html__( 'Full Width - Image right', 'tlg_framework' ) => 'intro-right',
						esc_html__( 'Full Width - Image left', 'tlg_framework' ) => 'intro-left',
						esc_html__( 'Boxed - Image top', 'tlg_framework' ) => 'box-top',
					),
					'description' 	=> esc_html__( 'Choose a display style for this intro box.', 'tlg_framework' )
				),
				vc_map_add_css_animation(),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_intro_carousel_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/	
if( !function_exists('tlg_framework_intro_carousel_content_shortcode_vc') ) {
	function tlg_framework_intro_carousel_content_shortcode_vc() {
		vc_map( array(
		    'name'            => esc_html__( 'Intro Carousel Content', 'tlg_framework' ),
		    'description'     => esc_html__( 'Intro Carousel Content Element', 'tlg_framework' ),
		    'icon' 			  => 'tlg_vc_icon_intro_carousel',
		    'base'            => 'tlg_intro_carousel_content',
		    'category' 		  => wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' => true,
		    'as_child'        => array('only' => 'tlg_intro_carousel'),
		    'params'          => array(
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array(
						esc_html__( 'Half screen', 'tlg_framework' )  => '',
						esc_html__( 'Boxed', 'tlg_framework' ) 		  => 'boxed',
					),
			  	),
		    	array(
		    		'type' => 'attach_image',
		    		'heading' => esc_html__( 'Intro image', 'tlg_framework' ),
		    		'param_name' => 'image'
		    	),
		    	array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'holder' 		=> 'div',
				),
				array(
		    		'type' 			=> 'vc_link',
		    		'heading' 		=> esc_html__( 'Intro link', 'tlg_framework' ),
		    		'param_name' 	=> 'title_link',
		    		'admin_label' 	=> false,
		    	),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' 	=> 'subtitle',
					'holder' 		=> 'div',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Subtitle style', 'tlg_framework' ),
					'param_name' 	=> 'subtitle_style',
					'value' 		=> array(
						esc_html__( 'Standard', 'tlg_framework' ) 	=> '',
						esc_html__( 'Box', 'tlg_framework' ) 	=> 'box',
					),
					'dependency' 	=> array('element' => 'layout','value' => array('boxed')),
					'admin_label' 	=> false,
			  	),
		    	array(
					'type' 			=> 'textarea_html',
					'heading' 		=> esc_html__( 'Content', 'tlg_framework' ),
					'param_name' 	=> 'content',
					'holder' 		=> 'div'
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Button link', 'tlg_framework' ),
					'param_name' 	=> 'btn_link',
					'value' 		=> '',
			  	),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button text', 'tlg_framework' ),
					'param_name' => 'button_text',
					'admin_label' 	=> true,
				),
				array(
	            	'type' 			=> 'tlg_icons',
	            	'heading' 		=> esc_html__( 'Button icon', 'tlg_framework' ),
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
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button style', 'tlg_framework' ),
					'param_name' 	=> 'button_layout',
					'value' 		=> tlg_framework_get_button_layouts() + array( esc_html__( 'Link', 'tlg_framework' ) => 'btn-link' ) + array( esc_html__( 'Underline', 'tlg_framework' ) => 'btn-read-more' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
				),
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
						),
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
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
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_intro_carousel_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/
if(class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_tlg_intro_carousel extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tlg_intro_carousel_content extends WPBakeryShortCode {}
}