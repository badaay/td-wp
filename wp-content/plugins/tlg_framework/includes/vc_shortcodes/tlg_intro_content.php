<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_intro_content_shortcode') ) {
	function tlg_framework_intro_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' 				=> '',
			'title' 				=> '',
			'title_link' 			=> '',
			'subtitle' 				=> '',
			'subtitle_style' 		=> '',
			'btn_link' 				=> '',
			'btn_size'				=> '',
			'button_text' 			=> '',
			'icon' 					=> '',
			'button_icon_hover' 	=> '',
			'button_layout'			=> 'btn btn-filled',
			'modal_embed' 			=> '',
			'css_animation' 		=> '',
			'layout' 				=> 'standard-right',
			'video_hover'			=> '',
			'hover' 				=> '',
			'customize_button' 		=> '',
			'btn_custom_layout' 	=> 'btn',
			'btn_color' 			=> '',
			'btn_color_hover' 		=> '',
			'btn_bg' 				=> '',
			'btn_bg_hover' 			=> '',
			'btn_border' 			=> '',
			'btn_border_hover' 		=> '',
			'btn_bg_gradient' 		=> '',
			'btn_bg_gradient_hover' => '',
		), $atts ) );
		$output 		= '';
		$custom_css 	= '';
		$custom_script 	= '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$modal 			= '';
		$modal_btn 		= '';
		$element_id 	= uniqid('btn-');
		$modal_id 		= uniqid('modal-');
		$btn_small_sm   = 'btn-sm-sm';
		$intro_content_class = '';

		// BUILD STYLE
		$styles_button 		= '';
		if ( 'yes' == $customize_button ) {
			$button_layout 		= 'btn-link' != $button_layout ? $btn_custom_layout : 'btn-link';
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
			$custom_script 		 = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		} else {
			if ("btn-action" == $button_layout) {
				$button_layout = "btn btn-filled btn-new ti-arrow-right";
				$btn_small_sm = '';
			}
		}
		if ( ! empty( $modal_embed ) ) {
			$modal = '<div class="modal-button"><div class="md-modal md-modal-7" id="'.esc_attr($modal_id).'">'.
			    '<div class="md-content"><div class="md-content-inner">'.wp_oembed_get($modal_embed).'</div></div>'.
			    '<div class="text-center"><a class="md-close inline-block mt24" href="#"><i class="ti-close"></i></a></div>'.
			    '</div><div class="md-overlay"></div></div>';
			$modal_link_prefix 	= '<a data-modal="'.esc_attr($modal_id).'" class="md-trigger m0 play" href= "#">';
			$modal_link_sufix 	= '</a>';
			$modal_text 		= '<div class="play-button inline"></div>';
			$modal_btn 			= '<div class="modal-video-mask">'.$modal_link_prefix.$modal_text.$modal_link_sufix.'</div>';
			$intro_content_class .= ' modal-video-wrap';
		}

		// GET STYLE
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
		}
		
		// LINK BUTTON
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

				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id).'" class="' .esc_attr($button_layout. ' ' . $btn_size . ' '. $icon . ' ' .$hover.' '.$btn_small_sm). ' text-center mr-0 mb0 '.('box-top' == $layout ? 'mt16' : 'mt24').'" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}
		$button = $button_text ? $link_prefix. $button_text.$icon_hover .$link_sufix : '';

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
		if (strpos($layout, 'box') !== false) {
			$heading_tag = "h5";
		} else {
			$heading_tag = "h2";
		}
		$intro_content = ( $subtitle && $layout != 'halfscreen-left' && $layout != 'halfscreen-right' ? '<div class="widgetsubtitle">'. ($subtitle) .'</div>' : '' ) .
						 ( $title ? $link_title_prefix."<$heading_tag ".' class="widgettitle mb8">'. ($title) ."</$heading_tag>".$link_title_sufix : '' ).'<div class="primary-line"></div>'.
						 (!empty($content) ? '<div class="intro-content-content">'.do_shortcode(wpautop($content)) .'</div>' : '').
					     $button;
		$title_content = ( $title ? $link_title_prefix."<$heading_tag ".' class="widgettitle mt0 '.($link_title_prefix ? 'dark-hover' : '').'">'. ($title) ."</$heading_tag>".$link_title_sufix : '' );
		$main_content = (!empty($content) ? '<div class="blog-boxed-content">'.do_shortcode(wpautop($content)) .'</div>' : '');
		// DISPLAY
		$intro_content_class .= ' '.tlg_framework_get_css_animation( $css_animation );
		switch ($layout) {
			case 'halfscreen-left':
				$tlg_image = wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				$output = '<section class="box-content image-half p0 '.esc_attr($intro_content_class).'">
						    <div class="col-lg-6 p0">
						    	<div class="intro-image">'. $tlg_image . $modal_btn. '</div>
						    </div>
						    <div class="container">
						        <div class="col-lg-6 col-lg-offset-1 pl-l-80 vertical-alignment right">'.
						        	($subtitle ? '<div class="widgetsubtitle">'. ($subtitle) .'</div>' : '').
						        	$intro_content.
						        '</div>
						    </div>'.$modal.'
						</section>';
				break;

			case 'halfscreen-right':
				$tlg_image = wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				$output = '<section class="box-content image-half p0 '.esc_attr($intro_content_class).'">
						    <div class="col-lg-6 p0 col-lg-push-6">
						    	<div class="intro-image">'. $tlg_image . $modal_btn. '</div>
						    </div>
						    <div class="container">
						        <div class="col-lg-6 col-lg-pull-0 pr-l-80 vertical-alignment">'.
						        	($subtitle ? '<div class="widgetsubtitle">'. ($subtitle) .'</div>' : '').
						        	$intro_content.
						        '</div>
						    </div>'.$modal.'
						</section>';
				break;

			case 'box-top':
				$tlg_image = wp_get_attachment_image( $image, 'navian_grid', 0, array('class' => 'background-image', 'alt' => 'page-header') );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				$output = '<div class="grid-blog no-border"><div class="intro-content-box icon-hover boxed-intro blog-boxed overflow-hidden heavy-shadow zoom-hover '.esc_attr($intro_content_class).'">
							<div class="overflow-hidden relative '.(!empty($subtitle) && 'box' == $subtitle_style ? 'pb16' : '').'">
                				<div class="intro-image overflow-hidden relative">'.$link_title_prefix.
									$tlg_image .($link_title_prefix ? '<span class="overlay-default"></span><span class="plus-icon"></span>' : '').$link_title_sufix.'
								</div>'.
								(!empty($subtitle) && 'box' == $subtitle_style ? '<span class="cat-name"><span class="cat-link"><i class="fa fa-tag pr-6"></i>' . ($subtitle) . '</span></span>' : '').
							'</div>
							<div class="intro-content">'.(empty($subtitle_style) && !empty($subtitle) ? '<div class="subtitle-box">' . ($subtitle) . '</div>' : '').$title_content.$main_content.$button.'</div>
						</div></div>';
				break;

			case 'video':
				$tlg_image = wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				if ('shadow' == $video_hover) {
					$output = '<div class="image-video text-center p0-sm-min border-radius-m shadow-img '.esc_attr($intro_content_class).'">
						    <div class="intro-image">'. $tlg_image .$modal_btn.'
							</div>'.$modal.'
						</div>';
				} else {
					$output = '<div class="image-video boxed-intro-content boxed-caption boxed-caption-bottom heavy-shadow zoom-hover bg-white '.esc_attr($intro_content_class).'">
							<div class="intro-image border-radius-0 overflow-hidden">'. $tlg_image .$modal_btn.'
							</div>'.$modal.'
						</div>';
				}
				break;

			case 'box-text-center':
				$tlg_image = wp_get_attachment_image( $image, 'full', 0 );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				$output = '<div class="relative pt120 pb120 image-box-center vertical-flex '.esc_attr($intro_content_class).'">'.
							($image ? '<div class="background-content">'. $tlg_image .'</div>' : '').'
							<div class="container vertical-flex-column">
								<div class="row">
									<div class="col-sm-12 text-center">
					        			<div class="box-center-caption">
											<div class="box-center-caption-border"></div>
											<div class="md-valign relative">
												<div class="box-center-caption-inner">'.
													$intro_content.
												'</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
				break;

			case 'standard-left':
				$tlg_image = wp_get_attachment_image( $image, 'full', 0 );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				$output = '<section class="box-content image-standard '.esc_attr($intro_content_class).'">
						    <div class="container p0-sm-min">
						        <div class="row vertical-flex">
						            <div class="col-md-7 col-sm-6 text-center mb-xs-24 p0-sm-min border-radius-m shadow-img">
						            	<div class="intro-image">'.$tlg_image .$modal_btn.'</div>
						            </div>
						            <div class="col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1 p0-sm-min">'.
							        	$intro_content.
						            '</div>
						        </div>
						    </div>'.$modal.'
						</section>';
				break;

			case 'standard-right':
			default:
				$tlg_image = wp_get_attachment_image( $image, 'full', 0 );
				if (empty($tlg_image)) {
					$tlg_image = '<img src="'.TLG_FRAMEWORK_PLACEHOLDER.'">';
				}
				$output = '<section class="box-content image-standard '.esc_attr($intro_content_class).'">
						    <div class="container p0-sm-min">
						        <div class="row vertical-flex">
						            <div class="col-md-4 col-sm-5 mb-xs-24 p0-sm-min">'.
						            	$intro_content.
						            '</div>
						            <div class="col-md-7 col-md-offset-1 col-sm-6 col-sm-offset-1 text-center p0-sm-min border-radius-m shadow-img">
						            	<div class="intro-image">'. $tlg_image .$modal_btn.'</div>
						            </div>
						        </div>
						    </div>'.$modal.'
						</section>';
				break;
		}
		
		return $output.$custom_script;
	}
	add_shortcode( 'tlg_intro_content', 'tlg_framework_intro_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_intro_content_shortcode_vc') ) {
	function tlg_framework_intro_content_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Intro content' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create fancy content image', 'tlg_framework' ),
		    'icon' 						=> 'tlg_vc_icon_intro_content',
		    'base'                    	=> 'tlg_intro_content',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params' 					=> array(
		    	array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
		    		'param_name' 	=> 'layout',
		    		'value' 		=> array(
		    			esc_html__( 'Standard image right', 'tlg_framework' ) 		=> 'standard-right',
		    			esc_html__( 'Standard image left', 'tlg_framework' ) 		=> 'standard-left',
		    			esc_html__( 'Half-screen image right', 'tlg_framework' ) 	=> 'halfscreen-right',
		    			esc_html__( 'Half-screen image left', 'tlg_framework' ) 	=> 'halfscreen-left',
		    			esc_html__( 'Boxed image', 'tlg_framework' ) 				=> 'box-top',
		    			esc_html__( 'Boxed center fullwidth', 'tlg_framework' ) 	=> 'box-text-center',
		    			esc_html__( 'Thumbnail Video', 'tlg_framework' ) 			=> 'video',
		    		),
		    		'admin_label' 	=> true,
		    	),
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Video hover', 'tlg_framework' ),
					'param_name' 	=> 'video_hover',
					'value' 		=> array(
						esc_html__( 'Standard', 'tlg_framework' ) 	=> '',
						esc_html__( 'Shadow', 'tlg_framework' ) 	=> 'shadow',
					),
					'dependency' 	=> array('element' => 'layout','value' => array('video')),
					'admin_label' 	=> false,
			  	),
		    	array(
		    		'type' 			=> 'attach_image',
		    		'heading' 		=> esc_html__( 'Intro Image', 'tlg_framework' ),
		    		'param_name' 	=> 'image'
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
					'dependency' 	=> array('element' => 'layout','value' => array('box-top')),
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
					'admin_label' 	=> false,
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
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Video URL (use with \'Play button\')', 'tlg_framework' ),
					'param_name' 	=> 'modal_embed',
					'description' 	=> wp_kses( __( 'Enter link to video. Please check out the embed service supported <a target="_blank" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">here</a>.', 'tlg_framework' ), tlg_framework_allowed_tags() ),
					'dependency' 	=> array('element' => 'layout','value' => array('standard-left','standard-right','stanndard-right','halfscreen-left','halfscreen-left','video')),
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
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_intro_content_shortcode_vc' );
}