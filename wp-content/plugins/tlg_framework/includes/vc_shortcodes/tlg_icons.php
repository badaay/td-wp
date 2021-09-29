<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_icons_shortcode') ) {
	function tlg_framework_icons_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'align' => 'text-center'
		), $atts ) );
		return '<div class="'.esc_attr($align).'">'. do_shortcode($content) .'</div>';
	}
	add_shortcode( 'tlg_icons', 'tlg_framework_icons_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/
if( !function_exists('tlg_framework_text_image_shortcode') ) {
	function tlg_framework_icons_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'icon' 		=> '',
			'link' 		=> '',
			'title' 	=> '',
			'layout' 	=> '',
			'size' 		=> '32',
			'spacer'	=> '10',
			'color' 	=> '',
			'border_color' 			=> '',
			'bg_color' 				=> '',
			'hover_color' 			=> '',
			'hover_border_color' 	=> '',
			'hover_bg_color' 		=> '',
			'hover' 	=> '',
			'css_animation'  => '',
		), $atts ) );
		$icon_id 	 	= uniqid( "icon-" );
		$custom_css  	= '';
		$custom_script 	= '';
		$link_prefix 	= '';
		$link_sufix  	= '';

		// BUILD STYLE
		$styles_icon = '';
		$styles_icon .= $size 					 ? 'font-size:'.$size.'px;' : '';
		$styles_icon .= $color 					 ? 'color:'.$color.';' : '';
		$styles_icon .= $bg_color && $layout 	 ? 'background-color:'.$bg_color.';border-color:'.$bg_color.';' : '';
		$styles_icon .= $border_color && $layout ? 'border-color:'.$border_color.';' : '';
		$styles_icon .= $spacer 				 ? 'margin:0 '.$spacer.'px;' : '';

		// CUSTOM STYLE
		if ( $hover_color || $hover_bg_color || $hover_border_color ) {
			$custom_css .= '<style type="text/css" id="tlg-custom-css-'.$icon_id.'">#'.$icon_id.':hover{color:'.$hover_color.'!important;background-color:'.$hover_bg_color.'!important;border-color:'.$hover_border_color.'!important;}</style>';
			$custom_script = "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		// GET STYLE
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}

		// LINK
		if( '' != $link ) {
			$href = vc_build_link( $link );
			if( $href['url'] !== "" ) {
				$icon_tooltip = $title ? 'data-toggle="tooltip" data-placement="top" title="'.
								  esc_attr($title).'" data-original-title="'.esc_attr($title).'"' : '';
				$target 	  = isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 		  = isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix  = '<a class="' .esc_attr($hover). ' link-dark inline-block" href= "'.esc_url($href['url']).'" '.$target.' '.$rel.' '.$icon_tooltip .'>';
				$link_sufix   = '</a>';
			}
		}

		// DISPLAY
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		return $link_prefix.'<i id="'. esc_attr( $icon_id ) .'" '.$style_icon.' class="'. esc_attr( $icon .' '. $layout . ' ' .$animation_class ) .' inline-block custom-icon"></i>'.$link_sufix.$custom_script;
	}
	add_shortcode( 'tlg_icons_content', 'tlg_framework_icons_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_icons_shortcode_vc') ) {
	function tlg_framework_icons_shortcode_vc() {
		vc_map( array(
		    'name' 						=> esc_html__( 'Icons' , 'tlg_framework' ),
		    'description' 				=> esc_html__( 'Create an icon with custom style', 'tlg_framework' ),
		    'icon' 						=> 'tlg_vc_icon_icons',
		    'base' 						=> 'tlg_icons',
		    'as_parent' 				=> array('only' => 'tlg_icons_content'),
		    'content_element' 			=> true,
		    'show_settings_on_create' 	=> false,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params' 					=> array(
		    	array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Alignment', 'tlg_framework' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'tlg_framework' ) => 'text-center',
						esc_html__( 'Left', 'tlg_framework' ) => 'text-left',
						esc_html__( 'Right', 'tlg_framework' ) => 'text-right',
					)
				),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_icons_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/		
if( !function_exists('tlg_framework_icons_content_shortcode_vc') ) {
	function tlg_framework_icons_content_shortcode_vc() {
		vc_map( array(
		    'name'            => esc_html__( 'Icons Content', 'tlg_framework' ),
		    'description'     => esc_html__( 'Icons Content Element', 'tlg_framework' ),
		    'icon' 			  => 'tlg_vc_icon_icons',
		    'base'            => 'tlg_icons_content',
		    'category' 		  => wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' => true,
		    'as_child'        => array('only' => 'tlg_icons'),
		    'params' 		=> array(
				array(
					'type' => 'tlg_icons',
					'heading' => esc_html__( 'Icon', 'tlg_framework' ),
					'param_name' => 'icon',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Icon link', 'tlg_framework' ),
					'param_name' 	=> 'link',
					'value' 		=> '',
			  	),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Tooltip (optional)', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon style', 'tlg_framework' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Standard', 'tlg_framework' ) => '',
						esc_html__( 'Circle', 'tlg_framework' ) => 'circle-icon',
						esc_html__( 'Circle small', 'tlg_framework' ) => 'circle-icon small-icon',
						esc_html__( 'Circle background', 'tlg_framework' ) => 'circle-icon circle-icon-bg',
						esc_html__( 'Circle background small', 'tlg_framework' ) => 'circle-icon circle-icon-bg small-icon',
						esc_html__( 'Square', 'tlg_framework' ) => 'square-icon',
						esc_html__( 'Square small', 'tlg_framework' ) => 'square-icon small-icon',
						esc_html__( 'Square background', 'tlg_framework' ) => 'square-icon square-icon-bg',
						esc_html__( 'Square background small', 'tlg_framework' ) => 'square-icon square-icon-bg small-icon',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
					'admin_label' 	=> false,
				),
				vc_map_add_css_animation(),
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Icon size', 'tlg_framework' ),
					'param_name' => 'size',
					'min' => 1,
					'value' => 32,
					'suffix' => 'px',
					'description' => esc_html__('Enter value in pixels', 'tlg_framework'),
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Icon margin', 'tlg_framework' ),
					'param_name' => 'spacer',
					'min' => 1,
					'value' => 10,
					'suffix' => 'px',
					'description' => esc_html__('Enter value in pixels', 'tlg_framework'),
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'color',
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select background color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'bg_color',
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon border color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select border color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'border_color',
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select hover color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'hover_color',
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon background color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select hover background color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'hover_bg_color',
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon border color hover', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select hover border color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'hover_border_color',
					'admin_label' 	=> false,
					'group' 		=> esc_html__( 'Customize Icon', 'tlg_framework' ),
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_icons_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/		
if(class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_tlg_icons extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tlg_icons_content extends WPBakeryShortCode {}
}