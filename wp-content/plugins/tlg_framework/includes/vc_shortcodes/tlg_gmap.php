<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_gmap_shortcode') ) {
	function tlg_framework_gmap_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'embed'				=> 'standard',
			'locations' 		=> '',
			'height' 			=> '300',
			'zoom' 				=> '14',
			'enable_zoom' 		=> '',
			'enable_grayscale' 	=> '',
			'marker_image' 		=> '',
			'style' 			=> '',
			'css_animation' 	=> '',
		), $atts ) );
		// Default Embed
		if( isset($embed) && 'standard' == $embed ) {
			$animation_class = tlg_framework_get_css_animation( $css_animation );
			if( !isset($enable_grayscale) || empty($enable_grayscale) ) {
				$grayscale = '';
			} else {
				$grayscale = 'tlg-grayscale';
			}
			return sprintf(
				'<div class="tlg-custom-embed '.esc_attr($animation_class . ' ' . $grayscale).'"><iframe style="height: ' . esc_attr($height) . 'px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near" aria-label="%s"></iframe></div>',
				rawurlencode( $locations ),
				absint( $zoom ),
				esc_attr( $locations )
			);
		} 
		// Embed API
		else {
			$map_key = get_option( 'tlg_framework_gmaps_key', '' );
			wp_enqueue_script( 'gmaps', '//maps.google.com/maps/api/js?key='.$map_key, false, null, false, true );
			$map_style = array(
				'light_blue' 		=> '[{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}]',
				'green' 			=> '[{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]',
				'brown' 			=> '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
				'black' 			=> '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
				'light_blue_2' 		=> '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]',
				'green_2' 			=> '[{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]',
				'gray' 				=> '[{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-77}]},{"featureType":"road"}]',
				'dark_blue' 		=> '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]',
				'blue_green' 		=> '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#004358"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#1f8a70"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#1f8a70"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#fd7400"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#1f8a70"},{"lightness":-20}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#1f8a70"},{"lightness":-17}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"visibility":"on"},{"weight":0.9}]},{"elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#1f8a70"},{"lightness":-10}]},{},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#1f8a70"},{"weight":0.7}]}]',
				'light_blue_gray' 	=> '[{"stylers":[{"saturation":-100}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#0099dd"}]},{"elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#aadd55"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{}]',
				'dark_gray' 		=> '[{"stylers":[{"visibility":"on"},{"saturation":-100},{"gamma":0.54}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#4d4946"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"gamma":0.48}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"gamma":7.18}]}]',
			);
			$map_id = uniqid( "map_" );
			if( !isset($enable_zoom) || empty($enable_zoom) ) {
				$enable_zoom = 'false';
			}
			$map_marker_image = '';
			if ( !empty( $marker_image ) ) {
				$map_marker_image = wp_get_attachment_image_src( $marker_image, 'full' );
				$map_marker_image = $map_marker_image[0];
			}
			$map_address = '';
			$map_location = explode( "\n", $locations );
			if ( $map_location ) {
				$address = array();
				foreach ( $map_location as $l ) {
					$address[] = '{address: " ' . strip_tags( $l ) . '" , data:"' . strip_tags( $l ) . '", '. ($map_marker_image ? 'options:{icon: "' . $map_marker_image . '"}' : '') . '}';
				}
				$map_address .= implode( ',', $address );
			}
			$animation_class = tlg_framework_get_css_animation( $css_animation );
			return '<div class="'.esc_attr($animation_class).'" id="' . esc_attr($map_id) . '" style="height: ' . esc_attr($height) . 'px;"></div>
					<script type="text/javascript">
			 			jQuery(document).ready(function () {
					 		jQuery("#' . esc_js($map_id) . '").bind(\'gmap-reload\', function() { init_gmap(); });
					 		init_gmap();
					 		function init_gmap() {
						 		jQuery("#' . esc_js($map_id) . '").gmap3(\'destroy\');
						 		jQuery("#' . esc_js($map_id) . '").gmap3({
								 	marker: {
									 	values: [' . $map_address . '],
									 	events:{
										 	click: function(marker, event, context){
											 	var map = jQuery(this).gmap3("get"), infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
											 	if (infowindow){
												 	infowindow.open(map, marker); infowindow.setContent(\'<div>\'+context.data+\'</div>\');
											 	} else {
												 	jQuery(this).gmap3({
													 	infowindow:{ anchor:marker, options:{content: \'<div>\'+context.data+\'</div>\'} }
												 	});
											 	}
										 	}
									 	}
								 	},
									map: {
								 		options: {
								 			scrollwheel: false,
											streetViewControl: false,
											mapTypeControl: false,
											zoom: ' . esc_js($zoom) . ',
											navigationControl: ' . esc_js($enable_zoom) . ','
											. ( $style && isset($map_style[$style]) ? 'styles:' . $map_style[$style] . ',' : '' ) . '
										}
							 		}
								});
							}
				 		});
	    			</script>';
		}
	}
	add_shortcode( 'tlg_gmap', 'tlg_framework_gmap_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_gmap_shortcode_vc') ) {
	function tlg_framework_gmap_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Google Maps', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds google map schema styles', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_gmap',
			'base' 			=> 'tlg_gmap',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Map embed type', 'tlg_framework' ),
					'param_name' => 'embed',
					'value'      => array(
						esc_html__( '(default)', 'tlg_framework' ) 	=> 'standard',
						esc_html__( 'Embed API', 'tlg_framework' ) => 'api',
					),
					'description' 	=> wp_kses( __( 'As per Google announcement, usage of the Google Maps <strong>Embed API</strong> now requires a key. Please have a look at the <a target="_blank" href="https://developers.google.com/maps/documentation/embed/get-api-key">Google Maps APIs documentation</a> to get a key and add it into your Dashboard > Appearances > Customize > System > Google Maps API key.', 'navian' ), tlg_framework_allowed_tags() )
				),
				array(
					'type'        	=> 'textarea',
					'heading'     	=> esc_html__( 'Map location', 'tlg_framework' ),
					'param_name'  	=> 'locations',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Map height', 'tlg_framework' ),
					'param_name' 	=> 'height',
					'holder' 		=> 'div',
					'min' 			=> 1,
					'max' 			=> 5000,
					'suffix' 		=> 'px',
					'description' 	=> esc_html__( 'Enter value in pixels - Example: 300', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Map marker image', 'tlg_framework' ),
					'param_name' 	=> 'marker_image',
					'dependency' 	=> array('element' => 'embed','value' => array('api')),
				),
				array(
					'type'        	=> 'checkbox',
					'heading'     	=> esc_html__( 'Map zoom in/out?', 'tlg_framework' ),
					'param_name'  	=> 'enable_zoom',
					'value'       	=> array( esc_html__( 'Yes, please', 'tlg_framework' ) => true ),
					'dependency' 	=> array('element' => 'embed','value' => array('api')),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Map zoom', 'tlg_framework' ),
					'param_name' => 'zoom',
					'value'      => array(
						esc_html__( 'Standard', 'tlg_framework' ) => 14,
						esc_html__( 'Small', 'tlg_framework' ) 	=> 5,
						esc_html__( 'Large', 'tlg_framework' ) 	=> 20,
					)
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Map style', 'tlg_framework' ),
					'param_name' => 'style',
					'value'      => array(
						esc_html__( '(default)', 'tlg_framework' ) 	=> '',
						esc_html__( 'Light blue', 'tlg_framework' ) 		=> 'light_blue',
						esc_html__( 'Light blue 2', 'tlg_framework' ) 	=> 'light_blue_2',
						esc_html__( 'Green', 'tlg_framework' ) 			=> 'green',
						esc_html__( 'Green 2', 'tlg_framework' ) 			=> 'green_2',
						esc_html__( 'Brown', 'tlg_framework' ) 			=> 'brown',
						esc_html__( 'Black', 'tlg_framework' ) 			=> 'black',
						esc_html__( 'Gray', 'tlg_framework' ) 			=> 'gray',
						esc_html__( 'Dark blue', 'tlg_framework' ) 		=> 'dark_blue',
						esc_html__( 'Blue green', 'tlg_framework' ) 		=> 'blue_green',
						esc_html__( 'Light blue gray', 'tlg_framework' ) 	=> 'light_blue_gray',
						esc_html__( 'Dark gray', 'tlg_framework' ) 		=> 'dark_gray',
					),
					'admin_label' 	=> true,
					'dependency' 	=> array('element' => 'embed','value' => array('api')),
				),
				array(
					'type'        	=> 'checkbox',
					'heading'     	=> esc_html__( 'Map grayscale?', 'tlg_framework' ),
					'param_name'  	=> 'enable_grayscale',
					'value'       	=> array( esc_html__( 'Yes, please', 'tlg_framework' ) => true ),
					'dependency' 	=> array('element' => 'embed','value' => array('standard')),
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_gmap_shortcode_vc' );
}