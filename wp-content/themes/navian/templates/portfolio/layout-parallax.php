<?php 
if ( have_posts() ) : 
	while ( have_posts() ) : the_post();
		get_template_part( 'templates/portfolio/inc', 'parallax' );
	endwhile;	
else :
	get_template_part( 'templates/post/content', 'none' );
endif;