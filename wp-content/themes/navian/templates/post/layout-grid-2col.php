<?php global $wp_query; ?>
<section>
	<div class="container">
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
</section>