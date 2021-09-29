<?php 
$portfolio_link = navian_get_portfolio_link(); 
$categories_group = navian_portfolio_filters_group();
?>
<div class="col-sm-4 masonry-item project project-padding <?php echo esc_attr($categories_group); ?>">
    <div class="boxed-intro overflow-hidden zoom-hover boxed-shadow">
        <div class="intro-image overflow-hidden relative">
            <?php 
            echo wp_kses($portfolio_link['prefix'], navian_allowed_tags());
            the_post_thumbnail( 'navian_grid', array('class' => 'background-image') );
            ?>
            <span class="overlay-default"></span>
            <span class="plus-icon"></span>
            <?php
            echo wp_kses($portfolio_link['sufix'], navian_allowed_tags());
            ?>
        </div>
        <div class="intro-content intro-content-small">
            <div class="entry-meta overflow-hidden text-center">
                <?php
                echo !$portfolio_link['lightbox'] ? wp_kses($portfolio_link['prefix'], navian_allowed_tags()) : '';
                the_title('<h4 class="bold link-primary-title">', '</h4><h6 class="sms-text subtitle regular mb0">'. navian_the_terms( 'portfolio_category', ' / ', 'name' ) .'</h6>');
                echo !$portfolio_link['lightbox'] ? wp_kses($portfolio_link['sufix'], navian_allowed_tags()) : '';
                ?>
            </div>
        </div>
    </div>
</div>