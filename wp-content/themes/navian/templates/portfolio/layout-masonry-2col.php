<section class="projects pt48">
    <div class="container">
        <?php 
        $project_id = uniqid( "project_grid_" ); 
        echo navian_portfolio_filters($project_id);
        get_template_part( 'templates/post/inc','loader' );
        ?>
        <div id="<?php echo esc_attr($project_id) ?>" class="row masonry masonry-show project-content project-masonry">
            <div class="grid-sizer col-sm-6"></div>
            <?php 
            if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
                    get_template_part( 'templates/portfolio/inc', 'masonry-2col' );
                endwhile;
            else :
                get_template_part( 'templates/post/content', 'none' );
            endif;
            ?>
        </div>
    </div>
</section>