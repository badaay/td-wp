<?php 
global $wp_query;
if (is_active_sidebar( 'primary' )) {
    $page_class = 'col-md-9 col-sm-12';
    $page_id = 'main-content';
    $post_class = 'p0 sidebar-left';
} else {
    $page_class = 'col-md-12';
    $page_id = '';
    $post_class = '';
}
?>
<section class="<?php echo esc_attr($post_class); ?>">
	<div class="container">
		<div class="row">
			<?php 
            if (is_active_sidebar( 'primary' )) {
                get_sidebar('primary'); 
            }
            ?>
			<div id="<?php echo esc_attr($page_id); ?>" class="<?php echo esc_attr($page_class); ?>">
				<div class="grid-blog row">
				    <?php 
			    	if ( have_posts() ) : 
			    		while ( have_posts() ) : the_post();
				    		if( $wp_query->current_post % 2 == 0 && !( $wp_query->current_post == 0 ) ){
				    			echo '</div><div class="grid-blog row">';
				    		}
				    		get_template_part( 'templates/post/inc', 'grid-2col' );
				    	endwhile;	
			    	else :
			    		get_template_part( 'templates/post/content', 'none' );
			    	endif;
				    ?>
				</div>
				<div class="row">
				    <?php echo function_exists('navian_pagination') ? navian_pagination() : posts_nav_link(); ?>
				</div>
			</div>
		</div>
	</div>
</section>