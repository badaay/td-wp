<?php
if (is_active_sidebar( 'primary' )) {
    $page_class = 'col-md-9 mb-xs-24';
    $page_id = 'main-content';
    $post_class = 'p0 sidebar-right';
} else {
    $page_class = 'col-md-12';
    $page_id = '';
    $post_class = '';
}
?>
<section class="<?php echo esc_attr($post_class); ?>">
    <div class="container">
        <div class="row grid-blog">
            <div id="<?php echo esc_attr($page_id); ?>" class="<?php echo esc_attr($page_class); ?>">
            	<?php 
        		if ( have_posts() ) : 
                    while ( have_posts() ) : the_post();
            			get_template_part( 'templates/post/content' );
            		endwhile;
        		else :
        			get_template_part( 'templates/post/content', 'none' );
        		endif;
        		echo function_exists('navian_pagination') ? navian_pagination() : posts_nav_link();
            	?>
            </div>
            <?php 
            if (is_active_sidebar( 'primary' )) {
                get_sidebar('primary'); 
            }
            ?>
        </div>
    </div>
</section>