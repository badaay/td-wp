<?php 
$sticky = is_sticky() ? '<span class="featured-stick">'.esc_html__( 'Featured', 'navian' ).'</span>' : '';
$format = get_post_format(); 
$limit = get_option( 'navian_blog_default_excerpt_length', 31 );
?>
<div class="feed-item">
    <div class="xs-container mb-xs-0">
        <div class="pt48 pt-xs-32 pb48 pb-xs-32 border-bottom mb0">
            <?php if( 'quote' != $format && 'link' != $format ) : ?>
                <div class="feed-title">
                    <div class="feed-meta flex-style mb8">
                        <div class="flex-first">
                            <figure class="entry-data-author image-round-100">
                                <?php echo get_avatar( get_the_author_meta('ID') , 40 ); ?>
                            </figure>
                        </div>
                        <div class="flex-second">
                            <div class="entry-meta mb0"><?php the_author_posts_link(); ?></div>
                            <div class="entry-meta mb8">
                                <?php 
                                echo get_the_time(get_option('date_format')); 
                                if (has_category()) {
                                    echo esc_html__( ' - ', 'navian' ); the_category( ',</span><span class="inline-block">' );
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php endif; ?>
            <div class="radius-all-img">
                <?php get_template_part( 'templates/post/format', $format ); ?>
            </div>
            <?php if( 'quote' != $format && 'link' != $format ) : ?>
                <?php the_title('<h3 class="mt32"><a class="link-primary-title" href="'. esc_url(get_permalink()) .'">'.$sticky, '</a></h3>'); ?>
                <div class="mt16 clearfloat">
                    <?php echo navian_excerpt($limit); ?>
                </div>
                <div class="entry-meta mb8 mt-xs-32 overflow-hidden">
                    <div class="overflow-hidden">
                        <div class="pull-left">
                            <span class="read-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'navian' ); ?></a></span>
                        </div>
                        <div class="pull-right">
                            <?php if ( !post_password_required() && 'yes' == get_option( 'navian_blog_comment', 'yes' ) && ( comments_open() || get_comments_number() ) ) : ?>
                                <span class="inline-block">
                                    <span class="comments-link"><?php comments_popup_link( '<i class="ti-comment"></i>'.esc_html__( '0', 'navian' ), '<i class="ti-comment"></i>'.esc_html__( '1', 'navian' ), '<i class="ti-comment"></i>'.esc_html__( '%', 'navian' ) ); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php 
                            if (function_exists('tlg_framework_setup')) {
                                echo tlg_framework_like_display(); 
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>