<section class="projects p0">
    <?php 
    $project_id = uniqid( "project_grid_" ); 
    echo navian_portfolio_filters($project_id, true);
    get_template_part( 'templates/post/inc','loader' ); 
    ?>
    <div id="<?php echo esc_attr($project_id) ?>" class="row masonry masonry-show project-content project-masonry-full">
        <div class="grid-sizer col-sm-4"></div>
        <?php 
        if ( have_posts() ) : 
            while ( have_posts() ) : the_post();
                get_template_part( 'templates/portfolio/inc', 'full-masonry-3col' );
            endwhile;
        else :
            get_template_part( 'templates/post/content', 'none' );
        endif;
        ?>
    </div>
</section>