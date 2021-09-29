<?php if( !has_post_thumbnail() ) return false; ?>
<div class="project post-carousel mb0 bg-dark">
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'navian_grid', array( 'class' => 'radius-all-img' ) ); ?>                
		</a>
	</div>
	<div class="post-caption">
		<?php
        $categories = get_the_category();
        if ( ! empty( $categories ) && isset($categories[0]) ) {
            echo '<span class="cat-name"><span class="cat-link"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span></span>';
        }
        ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_title('<h5 class="widgettitle">', '</h5>'); ?>
        </a>
        <div class="entry-meta mt16 overflow-hidden">
            <div class="flex-style pt8 pr-16 float-left">
                <div class="flex-first">
                    <figure class="entry-data-author image-round-100">
                        <?php echo get_avatar( get_the_author_meta('ID') , 24 ); ?>
                    </figure>
                </div>
                <div class="flex-second">
                    <div class="entry-meta mb0 dark-hover-a">
                        <?php the_author_posts_link(); ?>
                        <span class="pl-6"><?php echo get_the_time(get_option('date_format')) ?></span> 
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>