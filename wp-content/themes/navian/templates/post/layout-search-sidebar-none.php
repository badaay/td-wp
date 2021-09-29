<section class="p0">
    <div class="container">
        <div id="main-content" class="xs-container">
        	<?php 
    		if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
        			get_template_part( 'templates/post/content', 'search' );
        		endwhile;
    		else :
    			get_template_part( 'templates/post/content', 'none' );
    		endif;
    		echo function_exists('navian_pagination') ? navian_pagination() : posts_nav_link();
        	?>
        </div>
    </div>
</section>