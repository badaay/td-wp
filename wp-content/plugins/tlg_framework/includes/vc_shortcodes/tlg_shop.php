<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_shop_shortcode') ) {
	function tlg_framework_shop_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		extract( shortcode_atts( array(
			'layout' 		=> 'standard',
			'pppage' 		=> '8',
			'filter' 		=> 'all',
			'orderby' 		=> 'date',
			'order' 		=> 'DESC',
			'css_animation' => '',
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		if( is_front_page() ) $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
		else $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$query_args = array(
			'post_type' 			=> 'product',
			'posts_per_page' 		=> $pppage,
			'paged' 				=> $paged,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'post_status'    		=> 'publish',
            'meta_query'     		=> array(
                array(
                    'key' => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => 'NOT IN'
                )
            )
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ){
				$filter = (int) icl_object_id( $filter, 'product_cat', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		ob_start();
		$shop_id = uniqid( "shop-" );
		$animation_class = tlg_framework_get_css_animation( $css_animation );
		switch ( $layout ) {
			case 'carouseldetail-3col':
				if ( is_rtl() ) {
					echo '<section id="'.esc_attr($shop_id).'" class="'.esc_attr($animation_class).' p0"><div class="woocommerce shop-carousel-rtl shop-carousel-detail owl-carousel owl-theme three-columns">';
				} else {
					echo '<section id="'.esc_attr($shop_id).'" class="'.esc_attr($animation_class).' p0"><div class="woocommerce shop-carousel shop-carousel-detail owl-carousel owl-theme three-columns">';
				}
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/product/content', 'product-full' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></section>';
				break;

			case 'standard':
			case 'carouseldetail-4col':
			default:
				if ( is_rtl() ) {
					echo '<section id="'.esc_attr($shop_id).'" class="'.esc_attr($animation_class).' p0"><div class="woocommerce shop-carousel-rtl shop-carousel-detail owl-carousel owl-theme four-columns">';
				} else {
					echo '<section id="'.esc_attr($shop_id).'" class="'.esc_attr($animation_class).' p0"><div class="woocommerce shop-carousel shop-carousel-detail owl-carousel owl-theme four-columns">';
				}
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/product/content', 'product-full' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></section>';
				break;
		}
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_shop', 'tlg_framework_shop_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_shop_shortcode_vc') ) {
	function tlg_framework_shop_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Product List', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Display product list', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_shop',
			'base' 			=> 'tlg_shop',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'Elements', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Product List layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array( esc_html__( 'Standard', 'tlg_framework' ) => 'standard' ) + array_flip(tlg_framework_get_woo_layouts()),
					'admin_label' 	=> true,
				),
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
					'heading' 		=> esc_html__( 'Order by', 'tlg_framework' ),
					'param_name' 	=> 'orderby',
					'value' 		=> array(
						esc_html__( 'Date', 'tlg_framework' ) 			=> 'date',
						esc_html__( 'ID', 'tlg_framework' ) 				=> 'ID',
						esc_html__( 'Most Commented', 'tlg_framework' ) 	=> 'comment_count'
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order', 'tlg_framework' ),
					'param_name' 	=> 'order',
					'value' 		=> array(
						esc_html__( 'Descending', 'tlg_framework' ) 	=> 'DESC',
						esc_html__( 'Ascending', 'tlg_framework' ) 	=> 'ASC',
					),
					'admin_label' 	=> true,
				),
				vc_map_add_css_animation(),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_shop_shortcode_vc' );
}