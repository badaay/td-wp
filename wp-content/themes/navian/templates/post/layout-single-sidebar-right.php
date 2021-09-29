<div class="container sidebar-right">
    <div class="row">
		<div id="main-content" class="col-md-9 mb-xs-24">
		    <?php
		    get_template_part( 'templates/post/inc', 'single' );
		    get_template_part( 'templates/post/inc', 'related' );
		    if ( 'yes' == get_option( 'navian_blog_comment', 'yes' ) && (have_comments() || navian_check_pings($post->ID) || comments_open()) ) {
		    	comments_template();
		    }
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>