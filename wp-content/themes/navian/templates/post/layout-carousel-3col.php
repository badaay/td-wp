<section class="p0">
    <?php if ( is_rtl() ) { ?>
    <div class="blog-carousel-rtl owl-carousel owl-theme grid-blog three-columns">
    <?php } else { ?>
    <div class="blog-carousel owl-carousel owl-theme grid-blog three-columns">
    <?php } ?>
    	<?php
		if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'templates/post/inc', 'carousel' );
		    endwhile;
		else :
			get_template_part( 'templates/post/content', 'none' );
		endif;
    	?>
    </div>
</section>