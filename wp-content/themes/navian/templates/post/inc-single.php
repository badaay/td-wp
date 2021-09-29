<?php
$enable_like_share = function_exists('tlg_framework_setup') && ('yes' == get_option( 'tlg_framework_enable_share', 'yes' ) || 'yes' == get_option( 'tlg_framework_enable_like', 'yes' ));
?>
<div class="post-wrap mb0 overflow-visible">
    <div class="inner-wrap">
        <div class="post-content">
            <?php 
            if ( has_post_thumbnail() && 'yes' == get_option( 'navian_blog_show_feature', 'no' ) ) {
                the_post_thumbnail( 'full', array( 'class' => 'mb16' ) );
            }
            the_content(); wp_link_pages(); 
            ?>
        </div>
    </div>
    <?php if (has_tag()) : ?>
    <div class="overflow-hidden mt32 <?php echo !empty($enable_like_share) ? '' : 'mb48'; ?>">
        <div class="tags">
            <label><?php esc_html_e( 'Tags', 'navian' ); ?></label>
            <?php the_tags( '', ' ', '' ); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($enable_like_share) : ?>
    <div class="mt32 mb48 overflow-hidden border-section">
        <div class="pull-left">
            <?php echo tlg_framework_like_display(); ?>
        </div>
        <div class="pull-right">
            <?php echo tlg_framework_share_display(); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if ( 'yes' == get_option( 'navian_blog_author_info', 'no' ) ) : ?>
    <div class="author-box">
        <?php get_template_part( 'templates/post/inc', 'header-single' ); ?>
    </div>
    <?php endif; ?>
</div>