<section>
	<div class="container">
		<?php get_template_part( 'templates/post/inc', 'loader' ); ?>
		<div class="row grid-blog masonry masonry-show mb40">
		    <?php
	    	if ( have_posts() ) : 
	    		while ( have_posts() ) : the_post();
		    		get_template_part( 'templates/post/inc', 'masonry-3col' );
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
</section>