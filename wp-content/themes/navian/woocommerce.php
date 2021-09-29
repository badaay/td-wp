<?php
get_header( 'shop' );
if( is_product() ) {
	$page_title_args = array(
		'title'   	=> get_post_meta( $post->ID, '_tlg_the_title', true ) ? get_post_meta( $post->ID, '_tlg_the_title', true ) : get_the_title(),
		'subtitle'  => get_post_meta( $post->ID, '_tlg_the_subtitle', true ),
		'layout' 	=> navian_get_page_title_layout(),
		'image'    	=> get_post_meta( $post->ID, '_tlg_title_bg_featured', true ) == 'yes' ? 
	        ( has_post_thumbnail() ? wp_get_attachment_image( get_post_thumbnail_id(), 'full', 0, array('class' => 'background-image', 'alt' => 'page-header') ) : false ) :
	        ( get_post_meta( $post->ID, '_tlg_title_bg_img', true ) ? '<img class="background-image" alt="'.esc_attr( 'page-header' ).'" src="'.esc_url(get_post_meta( $post->ID, '_tlg_title_bg_img', true )).'" />' : false )
	);
	echo navian_get_the_page_title( $page_title_args );
	get_template_part( 'templates/product/layout', 'single' );
} elseif( is_shop() || is_product_category() || is_product_tag() ) {
	$layout 	= isset($_GET['style']) ? $_GET['style'] : false;
	$layout 	= $layout ? $layout : get_option( 'navian_shop_layout', 'sidebar-right' );
	$image 		= get_option( 'navian_shop_header_image' ) ? '<img src="'. get_option( 'navian_shop_header_image' ) .'" alt="'.esc_attr( 'page-header' ).'" class="background-image" />' : false;
	$term_name 	= '';
	$term_desc 	= '';
	if( is_product_category() || is_product_tag() ) {
		$term 		= get_queried_object();
		$term_name 	= isset($term->name) ? $term->name : '';
		$term_desc 	= $term_name && isset($term->description) ? $term->description : '';
		$term_thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
        $term_image = wp_get_attachment_url($term_thumbnail_id);
        if( $term_image ) {
        	$image = '<img src="'. esc_url($term_image) .'" alt="'.esc_attr( 'page-header' ).'" class="background-image" />';
        }
	}
	$page_title_args = array(
		'title'   	=> $term_name ? $term_name : get_option( 'navian_shop_title', esc_html__( 'Our shop', 'navian' ) ),
		'subtitle'  => $term_desc ? $term_desc : get_option( 'navian_shop_subtitle', '' ),
		'leadtitle' => get_option( 'navian_shop_leadtitle', '' ),
		'layout' 	=> get_option( 'navian_shop_header_layout', 'center'),
		'image'    	=> $image
	); 
	echo navian_get_the_page_title( $page_title_args );
	get_template_part( 'templates/product/layout', $layout );
} elseif( is_search() ) {
	global $wp_query;
	$layout 			= isset($_GET['style']) ? $_GET['style'] : false;
	$layout 			= $layout ? $layout : get_option( 'navian_shop_layout', 'sidebar-right' );
	$results 			= $wp_query->found_posts;
	$search_term 		= get_search_query();
	$page_title_args 	= array(
		'title'   	=> esc_html__( 'Search Results for: ', 'navian' ) . ( $search_term ? $search_term : esc_html__( 'Empty', 'navian' ) ), 
		'subtitle'  => $search_term ? esc_html__( 'Found ' ,'navian' ) . $results . ( '1' == $results ? esc_html__(' Item', 'navian') : esc_html__( ' Items', 'navian' ) ) : '',
		'layout' 	=> get_option( 'navian_shop_header_layout', 'center'),
		'image'    	=> get_option( 'navian_shop_header_image' ) ? '<img src="'. get_option( 'navian_shop_header_image' ) .'" alt="'.esc_attr( 'page-header' ).'" class="background-image" />' : false
	);
	echo navian_get_the_page_title( $page_title_args );
	echo '<div class="woocommerce">';
	get_template_part( 'templates/product/layout', get_option( 'navian_shop_layout', $layout ) );
	echo '</div>';
} else {
	if (is_active_sidebar( 'shop' )) {
	    $page_class = 'col-md-9';
	} else {
	    $page_class = 'col-md-12';
	}
	?>
	<section class="p0 sidebar-right">
	    <div class="container">
	        <div class="row">
	            <div id="main-content" class="<?php echo esc_attr($page_class); ?>">
	                <?php
						/**
						 * Hook: woocommerce_before_main_content.
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 * @hooked WC_Structured_Data::generate_website_data() - 30
						 */
						do_action( 'woocommerce_before_main_content' );

						?>
						<header class="woocommerce-products-header">
							<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
								<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
							<?php endif; ?>

							<?php
							/**
							 * Hook: woocommerce_archive_description.
							 *
							 * @hooked woocommerce_taxonomy_archive_description - 10
							 * @hooked woocommerce_product_archive_description - 10
							 */
							do_action( 'woocommerce_archive_description' );
							?>
						</header>
						<?php
						if ( woocommerce_product_loop() ) {

							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked woocommerce_output_all_notices - 10
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );

							woocommerce_product_loop_start();

							if ( wc_get_loop_prop( 'total' ) ) {
								while ( have_posts() ) {
									the_post();

									/**
									 * Hook: woocommerce_shop_loop.
									 */
									do_action( 'woocommerce_shop_loop' );

									wc_get_template_part( 'content', 'product' );
								}
							}

							woocommerce_product_loop_end();

							/**
							 * Hook: woocommerce_after_shop_loop.
							 *
							 * @hooked woocommerce_pagination - 10
							 */
							do_action( 'woocommerce_after_shop_loop' );
						} else {
							/**
							 * Hook: woocommerce_no_products_found.
							 *
							 * @hooked wc_no_products_found - 10
							 */
							do_action( 'woocommerce_no_products_found' );
						}

						/**
						 * Hook: woocommerce_after_main_content.
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action( 'woocommerce_after_main_content' );
						?>
					</div>
				    <?php
					/**
					 * Hook: woocommerce_sidebar.
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					if (is_active_sidebar( 'shop' )) {
						do_action( 'woocommerce_sidebar' );
					}
				  	?>
	        </div>
	    </div>
	</section>
	<?php
}
get_footer( 'shop' );