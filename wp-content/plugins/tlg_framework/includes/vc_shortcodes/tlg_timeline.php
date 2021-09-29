<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_timeline_shortcode') ) {
	function tlg_framework_timeline_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'css_animation' => '',
		), $atts ) );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return '<div class="'.esc_attr($animation_class).' timeline">'. do_shortcode($content) .'</div>';
	}
	add_shortcode( 'tlg_timeline', 'tlg_framework_timeline_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/
if( !function_exists('tlg_timeline_content_shortcode') ) {
	function tlg_timeline_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' 	=> 'date',
			'icon' 		=> '',
			'image' 	=> '',
			'text' 		=> '',
			'title' 	=> '',
			'datetime' 	=> '',
			'title_color' 		=> '',
			'content_color' 	=> '',
			'icon_color' 		=> '',
			'icon_color_hover' 	=> '',
		), $atts ) );
		$element_id   = uniqid('timeline-');
		$timelineNode = '';
		$custom_css   = '';
		$custom_script = '';
		$styles_title 	= $title_color 		? 'color:'.$title_color.';' : '';
		$styles_content = $content_color 	? 'color:'.$content_color.';' : '';
		$styles_icon 	= $icon_color 		? 'background-color:'.$icon_color.';' : '';

		if( $icon_color_hover ) {
			$custom_css .= '<style type="text/css" id="tlg-custom-css-'.$element_id.'">#'.$element_id.'.timeline-item:hover .timeline-dot{background-color:'.$icon_color_hover.'!important;}</style>';
			$custom_script = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		// GET STYLE
		if ( ! empty( $styles_title ) ) {
			$style_title = 'style="' . esc_attr( $styles_title ) . '"';
		} else {
			$style_title = '';
		}
		if ( ! empty( $styles_content ) ) {
			$style_content = 'style="' . esc_attr( $styles_content ) . '"';
		} else {
			$style_content = '';
		}
		if ( ! empty( $styles_icon ) ) {
			$style_icon    = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon    = '';
		}

		if( ! $style || 'date' == $style ) {
			if( $datetime ) {
				$datetime 		= new DateTime($datetime);
				$timelineNode 	= '<div class="day">'. $datetime->format('d').'</div><div class="month">'. $datetime->format('M').' '. $datetime->format('Y') .'</div>';
			}
		} elseif ( 'text' == $style ) {
			$timelineNode = '<div class="month-text pt10">'.$text.'</div>';
		} elseif ( 'image' == $style ) {
			$image_src 		= wp_get_attachment_image_src($image, 'thumbnail');
			if( isset($image_src[0]) && $image_src[0] ) {
				$timelineNode = '<div class="image-round-100"><img src="'.$image_src[0].'" alt=="'.esc_html__( 'timeline-item', 'tlg_framework' ).'" /></div>';
			}
		}
		return '<article id="'.esc_attr($element_id).'" class="timeline-item">
					<div class="timeline-dot" '.$style_icon.'>'.( $icon ? '<i class="'.$icon.'"></i>' : '' ).'</div>
					<div class="timeline-date '.('image' == $style ? 'mt0' : '').'"><div class="linetime">'. $timelineNode . '</div></div>
					<div class="timeline-body"><div class="timeline-text">'.
						( $title ? '<h5 '.$style_title.'>'. htmlspecialchars_decode($title) .'</h5>' : '' ) . 
						'<div '.$style_content.'>'.wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
					</div></div>
				</article>'.$custom_script;
	}
	add_shortcode( 'tlg_timeline_content', 'tlg_timeline_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_timeline_shortcode_vc') ) {
	function tlg_framework_timeline_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Timeline' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create a timeline module', 'tlg_framework' ),
		    'icon'				      	=> 'tlg_vc_icon_timeline',
		    'base'                    	=> 'tlg_timeline',
		    'as_parent'               	=> array('only' => 'tlg_timeline_content'),
		    'content_element'         	=> true,
		    'show_settings_on_create' 	=> true,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params'          			=> array(
				vc_map_add_css_animation(),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_timeline_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/
if( !function_exists('tlg_framework_timeline_content_shortcode_vc') ) {
	function tlg_framework_timeline_content_shortcode_vc() {
		vc_map( array(
		    'name'            			=> esc_html__( 'Timeline content', 'tlg_framework' ),
		    'description'     			=> esc_html__( 'Timeline content element', 'tlg_framework' ),
		    'icon' 			  			=> 'tlg_vc_icon_timeline',
		    'base'            			=> 'tlg_timeline_content',
		    'category' 		  			=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' 			=> true,
		    'as_child'        			=> array('only' => 'tlg_timeline'),
		    'params'          			=> array(
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Node display style', 'tlg_framework' ),
					'class' 		=> '',
					'admin_label' 	=> false,
					'param_name' 	=> 'style',
					'value' 		=> array(
						esc_html__( 'Datetime', 'tlg_framework' ) 	=> 'date',
						esc_html__( 'Text', 'tlg_framework' ) 		=> 'text',
						esc_html__( 'Image', 'tlg_framework' ) 		=> 'image',
					),
			  	),
			  	array(
		    		'type' 			=> 'attach_image',
		    		'heading' 		=> esc_html__( 'Image', 'tlg_framework' ),
		    		'param_name' 	=> 'image',
		    		'admin_label' 	=> true,
		    		'dependency' 	=> array('element' => 'style', 'value' => array('image')),
		    	),
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Text', 'tlg_framework' ),
		    		'param_name' 	=> 'text',
		    		'holder' 		=> 'div',
		    		'dependency' 	=> array('element' => 'style', 'value' => array('text')),
		    	),
		    	array(
			   		'type' 			=> 'tlg_datetime',
					'class' 		=> '',
					'heading' 		=> esc_html__( 'Datetime', 'tlg_framework' ),
					'param_name' 	=> 'datetime',
					'value' 		=> '', 
					'admin_label' 	=> true,
					'description' 	=> esc_html__( 'Date and time format (yyyy/mm/dd).', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'style', 'value' => array('date')),
				),
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Content Title', 'tlg_framework' ),
		    		'param_name' 	=> 'title',
		    		'holder' 		=> 'div'
		    	),
	            array(
	            	'type' 			=> 'textarea_html',
	            	'heading' 		=> esc_html__( 'Content Text', 'tlg_framework' ),
	            	'param_name' 	=> 'content'
	            ),
	            array(
	            	'type' 			=> 'tlg_icons',
	            	'heading' 		=> esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
	            	'description' 	=> esc_html__( 'Leave blank to hide icons.', 'tlg_framework' ),
	            	'param_name' 	=> 'icon',
	            ),
	            array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Title color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for title.', 'tlg_framework' ),
					'param_name' 	=> 'title_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Content color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for content.', 'tlg_framework' ),
					'param_name' 	=> 'content_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
	            array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
	            array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon background color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color_hover',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_timeline_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/
if( class_exists('WPBakeryShortCodesContainer') ) {
    class WPBakeryShortCode_tlg_timeline extends WPBakeryShortCodesContainer {}
}
if( class_exists('WPBakeryShortCode') ) {
    class WPBakeryShortCode_tlg_timeline_content extends WPBakeryShortCode {}
}