<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_showcase_shortcode') ) {
	function tlg_framework_showcase_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'show_filter' => 'Yes',
			'show_category' => 'Yes',
		), $atts ) );
		$project_id = uniqid( "project_grid_" );
		return '<section class="projects showcase p0">'.
					('Yes' == $show_filter ? 
					'<div class="row pb16 mb32">
						<div class="col-sm-12 text-center">
							<ul class="filters filter-showcase mb0" data-project-id="'.esc_attr($project_id).'"></ul>
						</div>
					</div>' : '').
					get_template_part( 'templates/post/inc', 'loader' ). 
					'<div id="'.esc_attr($project_id).'" data-id="'.esc_attr($project_id).'" 
							data-all-name="'.esc_html__( 'All', 'tlg_framework' ).'" 
							class="row masonry masonry-show project-content project-masonry '.( 'Yes' == $show_category ? '' : 'hide-category' ).'"><div class="grid-sizer col-sm-4"></div>'.
						do_shortcode( $content ). 
					'</div>
				</section>';
	}
	add_shortcode( 'tlg_showcase', 'tlg_framework_showcase_shortcode' );
}
	
/**
	DISPLAY SHORTCODE CHILD
**/		
if( !function_exists('tlg_showcase_content_shortcode') ) {
	function tlg_showcase_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 	=> '',
			'subtitle' 	=> '',
			'image' 	=> '',
			'link' 		=> '',
			'category' 	=> '',
			'badge_text' => '',
			'badge_color' => '',
		), $atts ) );
		$output 		= '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$badge 			= '';

		$categories_slug = array();
		$categories = $category ? explode( ',', $category ) : array();
		if( count($categories) ) {
			foreach ($categories as $c) {
				$categories_slug[] = trim(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $c))));
			}
		}

		// LINK
		if( '' != $link ) {
			$href = vc_build_link( $link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a class="inherit zoom-line" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		if ( isset($badge_text) && $badge_text ) {
			$badge = '<span class="showcase-badge" '.( $badge_color ? 'style="background-color:'.$badge_color.'"' : '' ).'>'.$badge_text.'</span>';
		}
		if ( isset($image) && $image ) {
			$url = wp_get_attachment_image_src($image, 'full');
	    	if ( isset($url[0]) && $url[0] ) {
	    		$output = 
	    			'<div class="col-sm-4 masonry-item project showcase-single filter__'.implode( ' filter__', $categories_slug ).'" data-filter="'.implode( ',', $categories ).'" >'.
	    				$link_prefix.'
						    <div class="image-box text-center overflow-hidden-force radius-all-small relative">
							    <div class="zoom-line-image">
							    	<img src="'.esc_url($url[0]).'" alt="showcase-image" width="'.esc_attr($url[1]).'" height="'.esc_attr($url[2]).'" />
							    	<span class="overlay-default"></span>
							    	<span class="plus-icon"></span>
							    </div>
						    </div>
						    <div class="zoom-line-caption__inner text-center mt24">
				                <div class="zoom-line__title">
				                    <h3 class="xs-text mb0">'.$title.'</h3>
				                </div>'.
				                ($subtitle ? '<div class="zoom-line__sub s-text gray-text-hover mt8">'.$subtitle.'</div>' : '' ).
				            '</div>'.$badge.
					    $link_sufix.
					'</div>';
	    	}
		}
		return $output;
	}
	add_shortcode( 'tlg_showcase_content', 'tlg_showcase_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_showcase_shortcode_vc') ) {
	function tlg_framework_showcase_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Showcase' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create a list of showcase items', 'tlg_framework' ),
		    'icon' 				 	  	=> 'tlg_vc_icon_showcase',
		    'base'                    	=> 'tlg_showcase',
		    'as_parent'               	=> array('only' => 'tlg_showcase_content'),
		    'content_element'         	=> true,
		    'show_settings_on_create' 	=> true,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'params' 					=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Show filters?', 'tlg_framework' ),
					'param_name' 	=> 'show_filter',
					'value' 		=> array( esc_html__( 'Yes', 'tlg_framework' ), esc_html__( 'No', 'tlg_framework' ) ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Show category?', 'tlg_framework' ),
					'param_name' 	=> 'show_category',
					'value' 		=> array( esc_html__( 'Yes', 'tlg_framework' ), esc_html__( 'No', 'tlg_framework' ) ),
				),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_showcase_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/		
if( !function_exists('tlg_framework_showcase_content_shortcode_vc') ) {
	function tlg_framework_showcase_content_shortcode_vc() {
		vc_map( array(
		    'name'            	=> esc_html__( 'Showcase content', 'tlg_framework' ),
		    'description'     	=> esc_html__( 'Showcase content element', 'tlg_framework' ),
		    'icon' 			  	=> 'tlg_vc_icon_showcase',
		    'base'            	=> 'tlg_showcase_content',
		    'category' 			=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
		    'content_element' 	=> true,
		    'as_child'        	=> array('only' => 'tlg_showcase'),
		    'params'          	=> array(
		    	array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Image', 'tlg_framework' ),
					'param_name' 	=> 'image',
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
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Link', 'tlg_framework' ),
					'param_name' 	=> 'link',
					'value' 		=> '',
			  	),
			  	array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Category', 'tlg_framework' ),
					'param_name' => 'category',
					'admin_label' 	=> true,
					'description' => esc_html__( 'Enter category names separated by a comma.', 'tlg_framework' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Badge text', 'tlg_framework' ),
					'description' => esc_html__( 'Leave empty to hide badge.', 'tlg_framework' ),
					'param_name' => 'badge_text',
					'holder' => 'div',
					'admin_label' 	=> false,
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Badge color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Leave empty to use default color.', 'tlg_framework' ),
					'param_name' 	=> 'badge_color',
				),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_showcase_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/		
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tlg_showcase extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tlg_showcase_content extends WPBakeryShortCode {}
}