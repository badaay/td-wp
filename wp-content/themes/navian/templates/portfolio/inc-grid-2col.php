<?php 
$portfolio_link = navian_get_portfolio_link('zoom-line'); 
$categories_group = navian_portfolio_filters_group();
?>
<div class="col-sm-6 masonry-item project project-padding <?php echo esc_attr($categories_group); ?>">
    <?php echo wp_kses($portfolio_link['prefix'], navian_allowed_tags()); ?>
        <div class="image-box hover-meta radius-all">
            <?php the_post_thumbnail( 'navian_grid', array('class' => 'background-image') ); ?>
            <span class="overlay-default"></span>
            <span class="plus-icon"></span>
            <div class="meta-caption overlay-smaller radius-all">
                <h4 class="color-white to-top mt0 mb0"><?php echo get_the_title(); ?></h4>
                <h5 class="color-white to-top-after"><?php echo navian_the_terms( 'portfolio_category', ' / ', 'name' ); ?></h5>
            </div>
        </div>
    <?php echo wp_kses($portfolio_link['sufix'], navian_allowed_tags()); ?>
</div>