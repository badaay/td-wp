<section>
    <div class="container">
        <div class="row grid-blog">
            <div class="col-md-10 col-md-offset-1">
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
        </div>
    </div>
</section>