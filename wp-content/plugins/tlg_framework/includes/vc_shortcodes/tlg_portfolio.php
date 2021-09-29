<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_portfolio_shortcode') ) {
	function tlg_framework_portfolio_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		extract( shortcode_atts( array(
			'layout' 		=> 'grid-2col',
			'pppage' 		=> '8',
			'show_filter' 	=> 'Yes',
			'filter' 		=> 'all',
			'orderby' 		=> 'date',
			'order' 		=> 'DESC'
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		$cats = array();
		$query_args = array(
			'post_type' 	=> 'portfolio',
			'posts_per_page' => $pppage,
			'orderby' 		 => $orderby,
			'order' 		 => $order,
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ) {
				$filter = (int)icl_object_id( $filter, 'portfolio_category', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'id',
					'terms' => $filter
				)
			);
			$cats = get_categories( 'taxonomy=portfolio_category&exclude='. $filter .'&child_of='. $filter );
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
		ob_start();
		if ( $tlg_query->have_posts() ) {
			$class_column 			= '';
			$project_id 			= uniqid( "project-" );
			$project_filter 		= tlg_framework_portfolio_filters($project_id, false, $cats);
			$project_filter_full 	= tlg_framework_portfolio_filters($project_id, true, $cats);
			if (strpos($layout, '2col') !== false) {
			    $class_column = 'col-sm-6';
			}
			if (strpos($layout, '3col') !== false) {
			    $class_column = 'col-sm-4';
			}
			if (strpos($layout, '4col') !== false) {
			    $class_column = 'col-sm-3';
			}
			switch ( $layout ) {

				case 'parallax-full':
				case 'parallax-small':
				case 'parallax':
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					break;

				case 'full-modern-2col':
				case 'full-modern-3col':
				case 'full-modern-4col':
				case 'full-masonry-2col':
				case 'full-masonry-3col':
				case 'full-masonry-4col':
				case 'full-grid-2col':
				case 'full-grid-3col':
				case 'full-grid-4col':
					$padding_class = 'p0';
					if (!in_array($layout, array('full-masonry-2col', 'full-masonry-3col', 'full-masonry-4col'))) {
						$padding_class = 'pt0 pb0 pr-32 pl-32 p0-xs';
					}
					$layout_class = '';
					if (in_array($layout, array('full-modern-2col', 'full-modern-3col', 'full-modern-4col'))) {
						$layout_class = 'grid-blog';
					}
					echo '<section class="projects '.esc_attr($padding_class).'">';
			    	echo 'Yes' == $show_filter ? $project_filter_full : ''; 
			    	get_template_part( 'templates/post/inc', 'loader' );
			    	echo '<div id="'.esc_attr($project_id).'" class="row '.esc_attr($layout_class).' masonry m0 masonry-show project-content project-full">
			    				<div class="grid-sizer '.esc_attr($class_column).'"></div>';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					echo '</div></section>';
					break;

				case 'modern-2col':
				case 'modern-3col':
				case 'modern-4col':
				case 'masonry-2col':
				case 'masonry-3col':
				case 'masonry-4col':
				case 'grid-2col':
				case 'grid-3col':
				case 'grid-4col':
				default:
					$layout_class = '';
					if (in_array($layout, array('modern-2col', 'modern-3col', 'modern-4col'))) {
						$layout_class = 'grid-blog';
					}
					echo '<section class="projects"><div class="container '.esc_attr($layout).'">';
			    	echo 'Yes' == $show_filter ? $project_filter : ''; 
			    	get_template_part( 'templates/post/inc', 'loader' ); 
			    	echo '<div id="'.esc_attr($project_id).'" class="row '.esc_attr($layout_class).' masonry masonry-show project-content project-masonry">
			    				<div class="grid-sizer '.esc_attr($class_column).'"></div>';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					echo '</div></div></section>';
					break;
			}
		} else get_template_part( 'templates/post/content', 'none' );
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_portfolio', 'tlg_framework_portfolio_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_portfolio_shortcode_vc') ) {
	function tlg_framework_portfolio_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Portfolio', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds portfolio feeds', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_portfolio',
			'base' 			=> 'tlg_portfolio',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number of posts to show', 'tlg_framework' ),
					'param_name' 	=> 'pppage',
					'value' 		=> '8',
					'description' 	=> esc_html__('Enter \'-1\' to show all posts', 'tlg_framework'),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Portfolio layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_portfolio_layouts()),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Show filters?', 'tlg_framework' ),
					'param_name' 	=> 'show_filter',
					'value' 		=> array( esc_html__( 'Yes', 'tlg_framework' ), esc_html__( 'No', 'tlg_framework' ) ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order by', 'tlg_framework' ),
					'param_name' 	=> 'orderby',
					'value' 		=> array(
						esc_html__( 'Date', 'tlg_framework' ) 			=> 'date',
						esc_html__( 'ID', 'tlg_framework' ) 			=> 'ID',
						esc_html__( 'Alphabetical', 'tlg_framework' ) 	=> 'title',
						esc_html__( 'Random', 'tlg_framework' ) 		=> 'rand',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order', 'tlg_framework' ),
					'param_name' 	=> 'order',
					'value' 		=> array(
						esc_html__( 'Descending', 'tlg_framework' ) 	=> 'DESC',
						esc_html__( 'Ascending', 'tlg_framework' ) 		=> 'ASC',
					),
					'admin_label' 	=> true,
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_portfolio_shortcode_vc' );
}