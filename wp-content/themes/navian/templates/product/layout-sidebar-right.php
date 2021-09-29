<?php
if (is_active_sidebar( 'shop' )) {
    $page_class = 'col-md-9';
    $product_layout = 'product';
} else {
    $page_class = 'col-md-12';
    $product_layout = 'product-4col';
}
?>
<section class="p0 sidebar-right">
    <div class="container">
        <div class="row">
            <div id="main-content" class="<?php echo esc_attr($page_class); ?>">
                <?php
            	/**
            	 * woocommerce_before_shop_loop hook
            	 *
            	 * @hooked woocommerce_result_count - 20
            	 * @hooked woocommerce_catalog_ordering - 30
            	 */
            	do_action( 'woocommerce_before_shop_loop' );
                ?>
                <?php if ( have_posts() ) : ?>
	                <div class="row masonry">
	    				<?php woocommerce_product_subcategories(); ?>
	    				<?php while ( have_posts() ) : the_post(); ?>
	    					<?php get_template_part( 'templates/product/content', $product_layout ); ?>
	    				<?php endwhile; ?>
	    			</div>
	    		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>	
                <div class="text-center mt40">
                    <?php get_template_part( 'templates/product/inc', 'pagination' ); ?>
                </div>
            </div>
            <?php
        	/**
        	 * woocommerce_sidebar hook
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