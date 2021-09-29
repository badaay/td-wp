<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_team_shortcode') ) {
	function tlg_framework_team_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		extract( shortcode_atts( array(
			'type' 		=> 'large',
			'pppage' 	=> '8',
			'filter' 	=> 'all',
			'layout' 	=> 'grid',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'column'			=> '',
			'css_animation' 	=> '',
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		$query_args = array(
			'post_type' 		=> 'team',
			'orderby' 			=> $orderby,
			'order' 			=> $order,
			'posts_per_page' 	=> $pppage
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ) {
				$filter = (int) icl_object_id( $filter, 'team_category', true );
			}
			$query_args['tax_query'] = array( array(
				'taxonomy' 	=> 'team_category',
				'field' 	=> 'id',
				'terms' 	=> $filter
			) );
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		ob_start();
		$element_id = uniqid('team-');
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		if ( $tlg_query->have_posts() ) {
			switch ( $layout ) {

				case 'fullwidth':
					echo '<div id="'.$element_id.'"><div class="'.esc_attr($animation_class).' row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						if( '4col' == $column ) {
							get_template_part( 'templates/team/inc', 'fullwidth-4col');
		    				if( ($tlg_query->current_post + 1) % 4 == 0 ) echo '</div><div class="row">';
						} elseif( '2col' == $column ) {
							get_template_part( 'templates/team/inc', 'fullwidth-2col');
		    				if( ($tlg_query->current_post + 1) % 2 == 0 ) echo '</div><div class="row">';
						} else {
							get_template_part( 'templates/team/inc', 'fullwidth');
							if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row">';
						}
					endwhile;
					echo '</div></div>';
					break;

				case 'circle':
					echo '<div id="'.$element_id.'"><div class="'.esc_attr($animation_class).' row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						if( '4col' == $column ) {
							get_template_part( 'templates/team/inc', 'circle-4col');
		    				if( ($tlg_query->current_post + 1) % 4 == 0 ) echo '</div><div class="row mt24">';
						} elseif( '2col' == $column ) {
							get_template_part( 'templates/team/inc', 'circle-2col');
		    				if( ($tlg_query->current_post + 1) % 2 == 0 ) echo '</div><div class="row mt24">';
						} else {
							get_template_part( 'templates/team/inc', 'circle');
							if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row mt24">';
						}
					endwhile;
					echo '</div></div>';
					break;

				case 'standard':
				default:
					echo '<div id="'.$element_id.'"><div class="'.esc_attr($animation_class).' row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						if( '4col' == $column ) {
							get_template_part( 'templates/team/inc', 'standard-4col');
		    				if( ($tlg_query->current_post + 1) % 4 == 0 ) echo '</div><div class="row mt24">';
						} elseif( '2col' == $column ) {
							get_template_part( 'templates/team/inc', 'standard-2col');
		    				if( ($tlg_query->current_post + 1) % 2 == 0 ) echo '</div><div class="row mt24">';
						} else {
							get_template_part( 'templates/team/inc', 'standard');
							if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row mt24">';
						}
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
	add_shortcode( 'tlg_team', 'tlg_framework_team_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_team_shortcode_vc') ) {
	function tlg_framework_team_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Team', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Add your team to the page.', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_team',
			'base' 			=> 'tlg_team',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
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
					'heading' 		=> esc_html__( 'Team layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_team_layouts()),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Columns', 'tlg_framework' ),
					'param_name' 	=> 'column',
					'value' 		=> array(
						esc_html__( '3 Columns', 'tlg_framework' ) => '',
						esc_html__( '4 Columns', 'tlg_framework' ) => '4col',
						esc_html__( '2 Columns', 'tlg_framework' ) => '2col',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order by', 'tlg_framework' ),
					'param_name' 	=> 'orderby',
					'value' 		=> array(
						esc_html__( 'Date', 'tlg_framework' ) => 'date',
						esc_html__( 'ID', 'tlg_framework' ) => 'ID',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order', 'tlg_framework' ),
					'param_name' 	=> 'order',
					'value' 		=> array(
						esc_html__( 'Descending', 'tlg_framework' ) => 'DESC',
						esc_html__( 'Ascending', 'tlg_framework' ) 	=> 'ASC',
					),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_team_shortcode_vc');
}