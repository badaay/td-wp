<?php
if (is_active_sidebar( 'primary' )) {
    $page_class = 'col-md-9';
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
        <div class="row">
            <div id="<?php echo esc_attr($page_id); ?>" class="<?php echo esc_attr($page_class); ?>">
                <?php get_template_part( 'templates/post/inc', 'loader' ); ?>
                <div class="row grid-blog masonry masonry-show mb40">
                    <?php 
                	if ( have_posts() ) : 
                        while ( have_posts() ) : the_post();
                    		get_template_part( 'templates/post/inc', 'masonry-2col' );
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
            <?php 
            if (is_active_sidebar( 'primary' )) {
                get_sidebar('primary'); 
            }
            ?>
        </div>
    </div>
</section>