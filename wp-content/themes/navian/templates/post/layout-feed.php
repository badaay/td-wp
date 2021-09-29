<section>
    <div class="container">
	    <?php 
    	if ( have_posts() ) : 
    		while ( have_posts() ) : the_post();
    			get_template_part( 'templates/post/inc', 'feed' );
    		endwhile;	
    	else :
    		get_template_part( 'templates/post/content', 'none' );
    	endif;
    	echo function_exists('navian_pagination') ? navian_pagination() : posts_nav_link();
	    ?>
    </div>
</section>