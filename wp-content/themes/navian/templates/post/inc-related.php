<?php
if ( 'yes' == get_option( 'navian_blog_related', 'yes' ) ) {
    $tags = wp_get_post_tags( get_the_ID() );
    if ( $tags ) {
        $tag_ids = array();
        foreach( $tags as $individual_tag ) {
            $tag_ids[] = $individual_tag->term_id;
        }
        $args = array (
            'tag__in' => $tag_ids,
            'post__not_in' => array( $post->ID ),
            'posts_per_page' => 3,
            'ignore_sticky_posts' => 1,
            'orderby' => 'rand', 
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field'    => 'slug',
                    'terms'    => array( 'post-format-quote', 'post-format-link' ),
                    'operator' => 'NOT IN'
                ),
            ),
            'meta_query' => array( 
                array(
                    'key' => '_thumbnail_id'
                ) 
            )
        );
        $related_query = new  WP_Query( $args );
        if ( $related_query->have_posts() ) { ?>
            <section>
                <h3 class="related-title hide"><?php esc_html_e( 'Related Articles', 'navian' ) ?></h3>
                <div class="related-blog grid-blog row mb48">
                    <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                    <div class="col-sm-4 col-xs-12 mb-xs-24">
                        <?php get_template_part( 'templates/post/inc', 'carousel' ); ?>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section><?php
        }
    }
}
wp_reset_postdata();