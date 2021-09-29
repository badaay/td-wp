<section class="p0 text-left">
    <?php if ( is_rtl() ) { ?>
    <div class="blog-carousel-rtl blog-carousel-detail owl-carousel owl-theme grid-blog four-columns">
    <?php } else { ?>
    <div class="blog-carousel blog-carousel-detail owl-carousel owl-theme grid-blog four-columns">
    <?php } ?>
    	<?php
		if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'templates/post/inc', 'carouseldetail' );
		    endwhile;
		else :
			get_template_part( 'templates/post/content', 'none' );
		endif;
    	?>
    </div>
</section>