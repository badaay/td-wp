<?php if (function_exists('tlg_framework_setup') && ('yes' == get_option( 'tlg_framework_enable_share', 'yes' ) || 'yes' == get_option( 'tlg_framework_enable_like', 'yes' ))) : ?>
<section class="bg-secondary bg-secondary-light fixed-left">
    <div class="container">
        <div class="col-sm-12 portfolio-meta text-center">
            <div class="mb32">
                <?php echo tlg_framework_like_display(); ?>
            </div>
            <?php echo tlg_framework_share_display(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php if( 'yes' == get_option( 'navian_portfolio_enable_pagination', 'yes' ) ) :  ?>
<section class="p0 m0 bg-secondary">
    <?php
    $prev = get_previous_post();
    $next = get_next_post();
    $prev_date = $prev ? mysql2date('M d, Y', $prev->post_date, false) : false;
    $next_date = $next ? mysql2date('M d, Y', $next->post_date, false) : false;
    if ( $next || $prev ) { ?>
        <div class="projects-bottom-nav">
            <div class="row">
                <div class="col-sm-6 left-btn-part pt120 pb120">
                    <?php if ( $prev ) { ?>
                    <a href="<?php echo get_permalink( $prev->ID ) ?>">
                        <?php
                        $thumbnail_id = get_post_thumbnail_id( $prev->ID );
                        $url = wp_get_attachment_image_src( $thumbnail_id, 'navian_grid_big' );
                        if ( isset($url[0]) && $url[0] ) {
                            ?><div class="background-content"><img src="<?php echo esc_url( $url[0] ) ?>" alt="<?php echo esc_attr( $prev->post_title ) ?>" /></div><?php
                        } ?>
                        <span class="overlay-default"></span>
                        <div class="middle-holder left">
                            <div class="title">
                                <h5 class="mb32"><i class="ti-plus"></i></h5>
                                <h3 class="color-white"><?php echo esc_attr($prev->post_title); ?></h3>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-6 right-btn-part pt120 pb120">
                    <?php if ( $next ) { ?>
                    <a href="<?php echo get_permalink( $next->ID ) ?>">
                        <?php
                        $thumbnail_id = get_post_thumbnail_id( $next->ID );
                        $url = wp_get_attachment_image_src( $thumbnail_id, 'navian_grid_big' );
                        if ( isset($url[0]) && $url[0] ) {
                            ?><div class="background-content"><img src="<?php echo esc_url( $url[0] ) ?>" alt="<?php echo esc_attr( $next->post_title ) ?>" /></div><?php
                        } ?>
                        <span class="overlay-default"></span>
                        <div class="middle-holder right">
                            <div class="title">
                                <h5 class="mb32"><i class="ti-plus"></i></h5>
                                <h3 class="color-white"><?php echo esc_attr($next->post_title); ?></h3>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</section>
<?php endif; ?>