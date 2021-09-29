<?php 
$sticky = is_sticky() ? '<span class="featured-stick">'.esc_html__( 'Featured', 'navian' ).'</span>' : '';
$format = get_post_format(); 
$thumb = has_post_thumbnail() || get_post_meta( $post->ID, '_tlg_title_bg_img', true );
$limit = get_option( 'navian_blog_default_excerpt_length', 31 );
?>
<div class="boxed-intro blog-boxed overflow-hidden zoom-hover icon-hover mb70 blog-content">
    <?php 
    if( 'quote' == $format || 'link' == $format ) {
        get_template_part( 'templates/post/format', $format );
    } else {
        if ( $thumb ) : ?>
            <div class="overflow-hidden relative">
                <div class="intro-image overflow-hidden relative">
                    <a href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', array() ); ?>
                        <?php elseif (get_post_meta( $post->ID, '_tlg_title_bg_img', true )) : ?>
                            <img class="background-image" alt="<?php esc_html_e( 'post-image', 'navian' ); ?>" src="<?php echo esc_url(get_post_meta( $post->ID, '_tlg_title_bg_img', true )) ?>" />
                        <?php endif; ?>
                        <?php if( 'video' == $format ) : ?>
                            <div class="play-button-wrap">
                                <div class="play-button inline"></div>
                            </div>
                        <?php endif; ?>
                        <span class="overlay-default"></span>
                        <span class="plus-icon"></span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <div class="intro-content">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<div class="blog-categories">';
                $first_cat = true;
                foreach ($categories as $category) {
                    if (!$first_cat) {
                        echo ', ';
                    }
                    $first_cat = false;
                    echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                }
                echo '</div>';
            }
            ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_title('<h5 class="widgettitle dark-hover">'.$sticky, '</h5>'); ?>
            </a>
            <div class="blog-boxed-content"><?php echo navian_excerpt($limit); ?></div>
            <div class="entry-foot">
                <span class="read-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'navian' ); ?></a></span>
            </div>
        </div>
        <div class="entry-meta overflow-hidden">
            <div class="float-left entry-date">
                <span><i class="ti-time"></i><?php echo get_the_time(get_option('date_format')) ?></span>
            </div>
            <div class="float-left entry-author pl-16">
                <span><i class="ti-user"></i><?php the_author_posts_link(); ?></span>
            </div>
            <?php if (function_exists('tlg_framework_setup')) : ?>
                <span class="inline-block float-right post-action p0">
                <?php echo tlg_framework_like_display();  ?>
                </span>
            <?php endif; ?>
            <?php if ( !post_password_required() && 'yes' == get_option( 'navian_blog_comment', 'yes' ) && ( comments_open() || get_comments_number() ) ) : ?>
                <span class="inline-block float-right post-action">
                    <span class="comments-link"><?php comments_popup_link( '<i class="ti-comment"></i>'.esc_html__( '0', 'navian' ), '<i class="ti-comment"></i>'.esc_html__( '1', 'navian' ), '<i class="ti-comment"></i>'.esc_html__( '%', 'navian' ) ); ?></span>
                </span>
            <?php endif; ?>
        </div>
        <?php
    }
    ?>
</div>