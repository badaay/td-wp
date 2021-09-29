<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_testimonial_shortcode') ) {
	function tlg_framework_testimonial_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		extract( shortcode_atts( array(
			'pppage' 			=> '8',
			'filter' 			=> 'all',
			'layout' 			=> 'standard',
			'avatar_display' 	=> '',
			'css_animation' 	=> '',
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		$query_args = array(
			'post_type' 		=> 'testimonial',
			'posts_per_page' 	=> $pppage
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ) {
				$filter = (int) icl_object_id( $filter, 'testimonial_category', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'testimonial_category',
					'field' 	=> 'id',
					'terms' 	=> $filter
				)
			);
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		ob_start();
		$testimonial_id = uniqid( "testimonial_" );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		if ( $tlg_query->have_posts() ) {
			switch ( $layout ) {
				case 'carousel':
					if ( is_rtl() ) {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-standard"><ul class="slides carousel-one-item-rtl owl-carousel owl-theme">';
					} else {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-standard"><ul class="slides carousel-one-item owl-carousel owl-theme">';
					}
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-quote':
					if ( is_rtl() ) {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-quote quote-standard"><ul class="slides carousel-one-item-rtl owl-carousel owl-theme">';
					} else {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-quote quote-standard"><ul class="slides carousel-one-item owl-carousel owl-theme">';
					}
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-widget':
					if ( is_rtl() ) {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-left slider-quote slider-widget"><ul class="slides carousel-one-item-rtl owl-carousel owl-theme">';
					} else {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-left slider-quote slider-widget"><ul class="slides carousel-one-item owl-carousel owl-theme">';
					}
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-column':
					if ( is_rtl() ) {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-quote slider-column"><ul class="slides carousel-one-item-rtl owl-carousel owl-theme">';
					} else {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-quote slider-column"><ul class="slides carousel-one-item owl-carousel owl-theme">';
					}
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-no-control':
					if ( is_rtl() ) {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-rotator-rtl"><ul class="slides owl-carousel owl-theme">';
					} else {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider text-center slider-rotator"><ul class="slides owl-carousel owl-theme">';
					}
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-padding':
					if ( is_rtl() ) {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider slider-quote"><ul class="carousel-padding-rtl slides owl-carousel owl-theme">';
					} else {
						echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials text-slider slider-quote"><ul class="carousel-padding slides owl-carousel owl-theme">';
					}
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
					endwhile;
					echo '</ul></div>';
					break;

				case 'boxed':
				case 'boxed-dark':
					echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials"><div class="row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', $layout );
						if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row">';
					endwhile;
					echo '</div></div>';
					break;

				case 'standard':
				default:
					echo '<div id="'.esc_attr($testimonial_id).'" class="'.esc_attr($animation_class . ' ' . $avatar_display).' testimonials"><div class="row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', 'standard' );
						if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row">';
					endwhile;
					echo '</div></div>';
					break;
			}
		} else get_template_part( 'templates/post/content', 'none' );
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 			
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_testimonial', 'tlg_framework_testimonial_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_testimonial_shortcode_vc') ) {
	function tlg_framework_testimonial_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Testimonials', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds testimonials content', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_testimonial',
			'base' 			=> 'tlg_testimonial',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' => array(
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Number of posts to show', 'tlg_framework' ),
					'param_name' 	=> 'pppage',
					'holder' 		=> 'div',
					'min' 			=> -1,
					'value' 		=> '8',
					'description' 	=> esc_html__('Enter \'-1\' to show all posts', 'tlg_framework'),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Testimonial layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_testimonial_layouts()),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Enable avatar?', 'tlg_framework' ),
					'param_name' 	=> 'avatar_display',
					'value' 		=> array(
						esc_html__( 'Yes', 'tlg_framework' ) => '',
						esc_html__( 'No', 'tlg_framework' ) => 'hide-avatar',
					),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_testimonial_shortcode_vc' );
}