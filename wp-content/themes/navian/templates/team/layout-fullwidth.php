<?php global $wp_query; ?>
<div class="row">
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			get_template_part( 'templates/team/inc', 'fullwidth' );
			if( ( $wp_query->current_post + 1 ) % 3 == 0 ) {
				echo '</div><div class="row">';
			}
		endwhile;
	else :
		get_template_part( 'templates/post/content', 'none' );
	endif;
	?>
</div>