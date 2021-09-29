<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_icon_box_shortcode') ) {
	function tlg_framework_icon_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 		 		=> '',
			'subtitle' 		 		=> '',
			'customize_icon' 		=> 'no',
			'icon' 			 		=> '',
			'image' 		 		=> '',
			'icon_color' 	 		=> '',
			'icon_border_color' 	=> '',
			'icon_bg_color'  		=> '',
			'icon_color_hover' 	 	=> '',
			'icon_bg_color_hover'  	=> '',
			'icon_layout' 	 		=> '',
			'box_border_color' 		=> '',
			'box_bg_color' 			=> '',
			'box_bg_gradient_color' => '',
			'box_bg_color_hover' 	=> '',
			'icon_size' 	 		=> '',
			'box_layout' 	 		=> '',
			'animate_bg_color'		=> '',
			'animate_gd_color'		=> '',
			'icon_box_link'  		=> '',
			'color' 		 		=> '',
			'hover_color'	 		=> '',
			'bg_color' 				=> '',
			'css_animation'  		=> '',
			'title_color' 			=> '',
			'title_hover_color' 	=> '',
			'subtitle_color' 		=> '',
			'content_color' 		=> '',
			'image_hover_color' 	=> '',
			'customize_font' 		=> '',
			'title_size' 			=> '',
			'subtitle_size' 		=> '',
			'title_uppercase' 	 	=> 'yes',
			'subtitle_uppercase' 	=> 'no',
			// button
			'btn_link' 				=> '',
			'btn_size'				=> '',
			'button_text' 			=> '',
			'btn_icon' 				=> '',
			'button_icon_hover' 	=> '',
			'button_layout'			=> 'btn btn-filled',
			'hover' 				=> '',
			// customize button
			'customize_button' 	=> '',
			'btn_custom_layout' => 'btn',
			'btn_color' 		=> '',
			'btn_color_hover' 	=> '',
			'btn_bg' 			=> '',
			'btn_bg_hover' 		=> '',
			'btn_border' 		=> '',
			'btn_border_hover' 	=> '',
			'btn_bg_gradient' 		=> '',
			'btn_bg_gradient_hover' => '',
		), $atts ) );
		$output 		= '';
		$custom_css 	= '';
		$custom_script  = '';
		$icon_image 	= '';
		$animate_box_img = '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$element_id 	= uniqid('iconbox-');
		$btn_element_id = uniqid('btn-');
		$btn_small_sm   = 'btn-sm-sm';
		$fonts 			= array();

		// BUILD STYLE
		$styles_title 		= '';
		$styles_subtitle 	= '';
		$styles_content 	= '';
		$styles_icon 		= '';
		$styles_box 		= '';
		$styles_button		= '';
		
		$styles_title 		.= $title_color 					? 'color:'.$title_color.'!important;' : '';
		$styles_subtitle 	.= $subtitle_color 					? 'color:'.$subtitle_color.'!important;' : '';
		$styles_content 	.= $content_color 					? 'color:'.$content_color.'!important;' : '';
		$styles_icon 		.= $icon_size && !$icon_layout 		? 'font-size:'.$icon_size.'px!important;' : '';
		$styles_icon 		.= $icon_color 						? 'color:'.$icon_color.';' : '';
		$styles_icon 		.= $icon_border_color				? 'border-color:'.$icon_border_color.';' : '';
		$styles_icon 		.= $icon_bg_color && $icon_layout 	? 'background-color:'.$icon_bg_color.';border-color:'.$icon_bg_color.';' : '';
		$styles_box 		.= $box_border_color 				? "border-bottom: 3px solid ".$box_border_color.";" : '';
		$styles_box 		.= $box_bg_color 					? "background-color: ".$box_bg_color.";" : '';
		$styles_box 		.= !empty($box_bg_gradient_color) 	? 'background: linear-gradient(125deg,'.$box_bg_color.' 0%,'.$box_bg_gradient_color.' 100%);' : '';

		if ( 'yes' == $customize_font ) {
			$styles_title 		.= '' != $title_size 			? 'font-size:'.$title_size.'px!important;line-height:'.($title_size+10).'px;' : '';
			$styles_title 		.= 'yes' == $title_uppercase 	? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
			$styles_subtitle 	.= '' != $subtitle_size 		? 'font-size:'.$subtitle_size.'px!important;line-height:'.($subtitle_size+5).'px;' : '';
			$styles_subtitle 	.= 'yes' == $subtitle_uppercase ? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
		}

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
			$custom_css 		.= '#'.$btn_element_id.':hover{color:'.$btn_color_hover.'!important;background:'.$btn_bg_hover.'!important;border-color:'.$btn_border_hover.'!important;}';
		} else {
			if ("btn-action" == $button_layout) {
				$button_layout = "btn btn-filled btn-new ti-arrow-right";
				$btn_small_sm = '';
			}
		}
		
		// LINK
		if( '' != $icon_box_link ) {
			$href = vc_build_link( $icon_box_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a class="inherit" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// GET STYLE
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
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
		if ( ! empty( $styles_content ) ) {
			$style_content = 'style="' . esc_attr( $styles_content ) . '"';
		} else {
			$style_content = '';
		}
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}
		if ( ! empty( $styles_box ) ) {
			$style_box = 'style="' . esc_attr( $styles_box ) . '"';
		} else {
			$style_box = '';
		}

		// LINK BUTTON
		$icon_hover = '';
		$btn_link_prefix = '';
		$btn_link_sufix = '';
		if( '' != $btn_link ) {
			$href = vc_build_link( $btn_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				if( $btn_icon && 'yes' == $button_icon_hover ) {
					$icon_hover = '<i class="'.esc_attr($btn_icon).'"></i>';
					$btn_icon = '';
				}
				$btn_link_prefix 	= '<a '.$style_button.' id="'.esc_attr($btn_element_id).'" class="' .esc_attr($button_layout. ' ' . $btn_size . ' '. $btn_icon . ' ' .$hover . ' '.$btn_small_sm).' text-center mr-0 mb0 mt8" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$btn_link_sufix 	= '</a>';
				$link_prefix = $link_sufix = '';
			}
		}
		$button = $button_text ? $btn_link_prefix. $button_text.$icon_hover .$btn_link_sufix : '';
		$icon_title 		= $title ? '<h5 '.$style_title.' class="widgettitle ">'. htmlspecialchars_decode($title) .'</h5>': '';
		$icon_subtitle 		= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
		$icon_content 		= $content ? '<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>' : '';
		$icon_title_2 		= $title ? '<h5 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h5>' : '';
		$icon_subtitle_2 	= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
		$icon_content_2 	= $content ? '<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>' : '';
		$icon_subtitle_3 	= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
		// ICON IMAGE
		if ( 'yes' == $customize_icon && isset($image) && !empty($image) ) {
			$url = wp_get_attachment_image_src($image, 'full');
	    	if ( isset($url[0]) && !empty($url[0]) ) {
	    		$image_url = tlg_framework_resize_image($url[0], 600, 600, true);
	    	} else {
	    		$image_url = TLG_FRAMEWORK_PLACEHOLDER_SQUARE;
	    	}
	    	$icon_image = '<div class="icon-image">';
			$icon_image .= ('animate' == $box_layout ? '<span class="'. esc_attr($icon) .' behind-icon"></span>' : '');
			$icon_image .= '<img src="'.esc_url($image_url).'" alt="icon-image" /><div class="image-overlay"><div class="image-overlay-inner">
    						<i '.$style_icon.' class="'. esc_attr($icon) .'"></i><h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>'.
							$icon_subtitle_3.'</div></div></div>';
			$animate_box_img = '<div class="box-bg" style="background-image: url('.esc_url($image_url).'); "></div>';
		}
		// DISPLAY
		switch ($box_layout) {
			case 'left':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ' inline-block mr-30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div class="display-table mb-xs-24 text-left">
				    		<div class="display-cell '.($icon_content ? 'vertical-top mb-xs-24' : '').'">'.( $icon_image ? $icon_image : $icon ).'</div>
				    		<div class="display-cell">'.$icon_title.$icon_subtitle.$icon_content.$button.'</div>
				    	</div>'. $link_sufix;
				break;

			case 'right':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ' inline-block ml-30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div class="display-table mb-xs-24 text-right">
							<div class="display-cell">'.$icon_title.$icon_subtitle.$icon_content.$button.'</div>
							<div class="display-cell '.($icon_content ? 'vertical-top mt-xs-24' : '').'">'.( $icon_image ? $icon_image : $icon ).'</div>
						</div>'. $link_sufix;
				break;

			case 'center-box':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) .' inline-block mb30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div '.$style_box.' class="boxed-icon boxed boxed-intro relative mb0 text-center radius-large">
								'.( $icon_image ? $icon_image : $icon ).$icon_title_2.$icon_subtitle_2.$icon_content_2.$button.'</div>'. $link_sufix;
				break;

			case 'center-box-left':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) .' inline-block mb30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div '.$style_box.' class="boxed-icon boxed boxed-intro boxed-left relative mb0 text-left radius-large">
							'.( $icon_image ? $icon_image : $icon ).$icon_title_2.$icon_subtitle_2.$icon_content_2.$button.'</div>'. $link_sufix;
				break;

			case 'center-box-right':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) .' inline-block mb30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div '.$style_box.' class="boxed-icon boxed boxed-intro boxed-right relative mb0 text-right radius-large">
							'.( $icon_image ? $icon_image : $icon ).$icon_title_2.$icon_subtitle_2.$icon_content_2.$button.'</div>'. $link_sufix;
				break;
			
			case 'center':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . '  inline-block mb30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div class="relative mb0 text-center">'.( $icon_image ? $icon_image : $icon ).$icon_title.$icon_subtitle_2.$icon_content_2.$button.'</div>'. $link_sufix;
				break;

			case 'animate':
				$icon1 = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) .' inline-block mb30 lg-text icon-lg"></i>';
				$icon2 = '<i class="'. esc_attr( $icon .' '. $icon_layout ) .' white-color inline-block mb24 icon-text"></i>';
				$output = $link_prefix .'<div class="boxed boxed-intro boxed-animate animate-center relative mb0 inner-title hover-reveal '. ( $icon_layout ? ' mt50 ' : '' ) .' '.( $icon_image ? 'boxed-image' : '' ).'">
							'.( $icon_image ? $icon_image : 
								$icon1.'<h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>'.
								$icon_subtitle_3 ).'
							<div class="title">'.$icon2.'
								<h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>'.$icon_content_2.$button.'
							</div>
						</div>'. $link_sufix;
				break;

			case 'animate-box':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ' icon-animate inline-block mb30 icon-text icon-lg"></i>';
				$output = '<div class="icon-animate-box">
								<div class="animate-box-wrap">
									'.$animate_box_img.'
									<div class="animate-box-inner">
										<div class="animate-box-inner-wrap">
											'.$icon.'
											<h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>
											'.$icon_content_2.$button.'
										</div>
									</div>  
								</div> 
							</div>';
				break;

			case 'animate-icon':
				$icon = '<div class="icon-center-box"><i class="'. esc_attr( $icon .' '. $icon_layout ) . ' icon-animate inline-block icon-text icon-lg"></i></div>';
				$output = '<div class="icon-animate-box animate-icon mt48">
								<div class="animate-box-wrap">
									'.$animate_box_img.'
									<div class="animate-box-inner">
										<div class="animate-box-inner-wrap">
											'.$icon.'
											<h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>
											'.$icon_content_2.$button.'
										</div>
									</div>  
								</div> 
							</div>';
				break;

			case 'animate-scroll':
				$icon1 = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) .' inline-block mb30 lg-text icon-lg"></i>';
				$icon2 = '<i class="'. esc_attr( $icon .' '. $icon_layout ) .' white-color inline-block mb24 icon-text"></i>';
				$icon3 = '<span class="'. esc_attr($icon) .' behind-icon"></span>';
				$output = $link_prefix .'<div class="boxed boxed-intro boxed-animate boxed-scroll relative mb0 inner-title hover-reveal '. ( $icon_layout ? ' mt50 ' : '' ) .' '.( $icon_image ? 'boxed-image' : '' ).'">
							'.( $icon_image ? $icon_image : 
								$icon1.'<h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>'.
								$icon_subtitle_3 ).'
							<div class="title">'.$icon3.$icon2.'
								<h2 '.$style_title.' class="widgettitle">'. htmlspecialchars_decode($title) .'</h2>'.$icon_content_2.$button.'
							</div>
						</div>'. $link_sufix;
				break;

			case 'behind':
				$output = $link_prefix .'<div class="relative mb0">
							<div '.$style_subtitle.' class="widgetsubtitle behind-left bold">'. htmlspecialchars_decode($subtitle) .'</div>
							<h5 '.$style_title.' class="widgettitle mb30 relative padding-left large-widgettitle">'. htmlspecialchars_decode($title) .'</h5>
							<div '.$style_content.' class="icon-content relative padding-left">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .$button.'</div> 
						</div>'. $link_sufix;
				break;

			default:
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . '  inline-block mb30 icon-text icon-lg"></i>';
				$output = $link_prefix .'<div class="relative mb0">'.( $icon_image ? $icon_image : $icon ).$icon_title.$icon_subtitle_2.$icon_content_2.$button.'</div>'. $link_sufix;
				break;
		}

		// CUSTOM CSS
		$custom_css .= $content_color ? '#'.$element_id.' .icon-link .icon-content p{color:'.$content_color.'!important;}' : '';
		$custom_css .= $image_hover_color && $icon_image ? '#'.$element_id.' .icon-link:hover .icon-image .image-overlay{background: '.tlg_framework_hex2rgba($image_hover_color, 0.8).';}' : '';
		$custom_css .= $title_hover_color ? '#'.$element_id.' .icon-link:hover .widgettitle{color:'.$title_hover_color.'!important;}' : '';
		$custom_css .= $icon_color_hover ? '#'.$element_id.' .icon-link:hover i.icon-text{color:'.$icon_color_hover.'!important;}' : '';
		$custom_css .= $icon_bg_color_hover ? '#'.$element_id.' .icon-link:hover i.icon-text{background-color:'.$icon_bg_color_hover.'!important;border-color:'.$icon_bg_color_hover.'!important;}' : '';
		$custom_css .= $box_bg_color_hover ? '#'.$element_id.' .boxed-icon:hover{background-color:'.$box_bg_color_hover.'!important;}' : '';
		$custom_css .= $box_bg_color_hover ? '#'.$element_id.' .boxed-animate:before{background-color:'.$box_bg_color_hover.'!important;}' : '';
		$custom_css .= $box_bg_color_hover ? '#'.$element_id.' .boxed.boxed-intro.boxed-scroll .title{background-color:'.$box_bg_color_hover.'!important;}' : '';
		$custom_css .= $box_bg_color_hover ? '#'.$element_id.' .boxed.boxed-intro.boxed-scroll .icon-image .image-overlay-inner .widgettitle:before{background-color:'.$box_bg_color_hover.'!important;}' : '';
		$custom_css .= $box_bg_color_hover ? '#'.$element_id.' .animate-center .image-overlay-inner .widgettitle:before{background-color:'.$box_bg_color_hover.'!important;}' : '';
		if (empty($box_bg_color_hover)) {
			$custom_css .= $icon_color ? '#'.$element_id.' .boxed-animate.boxed-scroll .title .widgettitle:after{background-color:'.$icon_color.'!important;}' : '';

		}
		$custom_css .= $animate_bg_color ? '#'.$element_id.' .icon-animate-box:hover .box-bg:after{background-color:'.$animate_bg_color.'!important;}' : '';
		$custom_css .= $animate_bg_color && $animate_gd_color ? '#'.$element_id.' .icon-animate-box:hover .box-bg:after{background: linear-gradient(to bottom right,'.$animate_bg_color.','.$animate_gd_color.');}' : '';
		$custom_css = $custom_css ? '<style type="text/css" id="tlg-custom-css-'.$element_id.'">'.$custom_css.'</style>' : '';
		
		// ANIMATE
		$animation_class = tlg_framework_get_css_animation( $css_animation );

		// OUTPUT
		$output = '<div id="'.esc_attr($element_id).'" class="'.esc_attr($animation_class).' '.esc_attr($color . ' ' . $hover_color . ' ' . $bg_color).'"><div class="icon-link">'.$output.'</div></div>';
		if ( $custom_css ) {
			$output .= "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}
		return $output;
	}
	add_shortcode( 'tlg_icon_box', 'tlg_framework_icon_box_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_icon_box_shortcode_vc') ) {
	function tlg_framework_icon_box_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Icon Box', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds icon contents', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_icon_box',
			'base' 			=> 'tlg_icon_box',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Enable icon image?', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select \'Yes\' if you want to use icon as image.', 'tlg_framework' ),
					'class' 		=> '',
					'admin_label' 	=> false,
					'param_name' 	=> 'customize_icon',
					'value' 		=> array(
						esc_html__( 'No', 'tlg_framework' ) => 'no',
						esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
					),
			  	),
			  	array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Icon Image', 'tlg_framework' ),
					'param_name' 	=> 'image',
					'description' => esc_html__( 'Leave blank to hide the image.', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('yes')),
				),
				array(
					'type' => 'tlg_icons',
					'heading' => esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'param_name' => 'icon',
					'description' => esc_html__( 'Leave blank to hide icons.', 'tlg_framework' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div',
					'admin_label' 	=> false,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' => 'subtitle',
					'holder' => 'div',
					'admin_label' 	=> false,
				),
				array(
					'type' => 'textarea_html',
					'heading' => esc_html__( 'Content', 'tlg_framework' ),
					'param_name' => 'content',
					'holder' => 'div'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon style', 'tlg_framework' ),
					'param_name' => 'icon_layout',
					'value' => array(
						esc_html__( 'Standard', 'tlg_framework' ) 					=> '',
						esc_html__( 'Circle line', 'tlg_framework' ) 				=> 'circle-icon',
						esc_html__( 'Circle line small', 'tlg_framework' ) 			=> 'circle-icon small-icon',
						esc_html__( 'Circle solid', 'tlg_framework' ) 				=> 'circle-icon circle-icon-bg',
						esc_html__( 'Circle solid small', 'tlg_framework' ) 		=> 'circle-icon circle-icon-bg small-icon',
						esc_html__( 'Square line', 'tlg_framework' ) 				=> 'square-icon',
						esc_html__( 'Square line small', 'tlg_framework' ) 			=> 'square-icon small-icon',
						esc_html__( 'Square solid', 'tlg_framework' ) 				=> 'square-icon square-icon-bg',
						esc_html__( 'Square solid small', 'tlg_framework' ) 		=> 'square-icon square-icon-bg small-icon',
					),
					'admin_label' 	=> true,
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('no')),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Box style', 'tlg_framework' ),
					'param_name' 	=> 'box_layout',
					'value' 		=> array(
						esc_html__( 'Default', 'tlg_framework' ) 					=> '',
						esc_html__( 'Center', 'tlg_framework' ) 					=> 'center',
						esc_html__( 'Center boxed', 'tlg_framework' ) 				=> 'center-box',
						esc_html__( 'Center boxed icon left', 'tlg_framework' ) 	=> 'center-box-left',
						esc_html__( 'Center boxed icon right', 'tlg_framework' ) 	=> 'center-box-right',
						esc_html__( 'Left', 'tlg_framework' ) 						=> 'left',
						esc_html__( 'Right', 'tlg_framework' ) 						=> 'right',
						esc_html__( 'Animate hover', 'tlg_framework' ) 				=> 'animate',
						esc_html__( 'Animate boxed', 'tlg_framework' ) 				=> 'animate-box',
						esc_html__( 'Animate icon', 'tlg_framework' ) 				=> 'animate-icon',
						esc_html__( 'Animate scroll', 'tlg_framework' ) 			=> 'animate-scroll',
						esc_html__( 'Subtitle behind title', 'tlg_framework' ) 		=> 'behind',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Animate boxed background color', 'tlg_framework' ),
					'param_name' 	=> 'animate_bg_color',
					'dependency' 	=> array('element' => 'box_layout', 'value' => array('animate-box')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Animate boxed gradient color', 'tlg_framework' ),
					'param_name' 	=> 'animate_gd_color',
					'dependency' 	=> array('element' => 'box_layout', 'value' => array('animate-box')),
				),
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Icon size', 'tlg_framework' ),
					'param_name' 	=> 'icon_size',
					'holder' 		=> 'div',
					'min' 			=> 1,
					'suffix' 		=> 'px',
					'dependency' 	=> array('element' => 'icon_layout', 'value' => array('')),
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('no')),
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Icon link', 'tlg_framework' ),
					'param_name' 	=> 'icon_box_link',
					'description'  => esc_html__( 'Only use if Button link is empty.', 'tlg_framework' ),
					'value' 		=> '',
			  	),
			  	// Button
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
	            	'param_name' 	=> 'btn_icon',
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
					'value' 		=> tlg_framework_get_button_layouts() + array( esc_html__( 'Link', 'tlg_framework' ) => 'btn-link' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
				),
			  	vc_map_add_css_animation(),

			  	// Primary Colors  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			  		array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Enable primary icon color', 'tlg_framework' ),
						'param_name' => 'color',
						'value' => array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) => 'primary-color-icon',
						),
						'admin_label' 	=> true,
						'group' 		=> esc_html__( 'Primary Colors', 'tlg_framework' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Enable primary icon hover color', 'tlg_framework' ),
						'param_name' => 'hover_color',
						'value' => array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) => 'primary-color-icon-hover',
						),
						'admin_label' 	=> true,
						'group' 		=> esc_html__( 'Primary Colors', 'tlg_framework' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Enable primary background icon color', 'tlg_framework' ),
						'param_name' => 'bg_color',
						'value' => array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) => 'primary-bgcolor-icon',
						),
						'admin_label' 	=> true,
						'group' 		=> esc_html__( 'Primary Colors', 'tlg_framework' ),
					),

			  	// Custom Colors  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			  		array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
						'param_name' 	=> 'icon_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Icon border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select border color for icon.', 'tlg_framework' ),
						'param_name' 	=> 'icon_border_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Icon background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select background color for icon.', 'tlg_framework' ),
						'param_name' 	=> 'icon_bg_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Title color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for title.', 'tlg_framework' ),
						'param_name' 	=> 'title_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Subtitle color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for subtitle.', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Content color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for content.', 'tlg_framework' ),
						'param_name' 	=> 'content_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Icon hover color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover color for icon.', 'tlg_framework' ),
						'param_name' 	=> 'icon_color_hover',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Icon hover background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover background color for icon.', 'tlg_framework' ),
						'param_name' 	=> 'icon_bg_color_hover',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Title hover color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover color for title.', 'tlg_framework' ),
						'param_name' 	=> 'title_hover_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Image hover color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover color for image.', 'tlg_framework' ),
						'param_name' 	=> 'image_hover_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Border color (Boxed layout)', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select border color for icon box.', 'tlg_framework' ),
						'param_name' 	=> 'box_border_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Background color (Boxed layout)', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select background color for icon box.', 'tlg_framework' ),
						'param_name' 	=> 'box_bg_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Background gradient color (Boxed layout)', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select background gradient color for icon box.', 'tlg_framework' ),
						'param_name' 	=> 'box_bg_gradient_color',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Hover background color (Boxed layout)', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover background color for icon box.', 'tlg_framework' ),
						'param_name' 	=> 'box_bg_color_hover',
						'group' 		=> esc_html__( 'Custom Colors', 'tlg_framework' ),
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

			  	// Font - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	            	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize font?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize font style for this heading.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_font',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
				  	),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Title uppercase?', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'title_uppercase',
						'value' 		=> array(
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
							esc_html__( 'No', 'tlg_framework' ) => 'no',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
				  	),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Title font size', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'title_size',
						'holder' 		=> 'div',
						'min' 			=> 1,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default title font style.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Subtitle uppercase?', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'subtitle_uppercase',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => 'no',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
				  	),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Subtitle font size', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_size',
						'holder' 		=> 'div',
						'min' 			=> 1,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default subtitle font style.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_icon_box_shortcode_vc' );
}