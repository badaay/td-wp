<?php
$header_class = navian_get_header_class();
$logos = navian_get_logo();
get_template_part( 'templates/header/inc', 'top-center' );
?>
<div class="nav-bar <?php echo esc_attr( $header_class['nav_class'] ); ?>">
    <div class="module left visible-sm visible-xs inline-block">
        <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php if( $logos['logo_text'] && 'text' == $logos['site_logo'] ) : ?>
                <h1 class="logo"><?php echo esc_attr($logos['logo_text']); ?></h1>
            <?php else: ?>
            <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo_light']); ?>" srcset="<?php echo esc_attr($logos['logo_light_srcset']); ?>" />
            <img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo']); ?>" srcset="<?php echo esc_attr($logos['logo_srcset']); ?>" />
            <?php endif; ?>
        </a>
    </div>
    <div class="module widget-wrap mobile-toggle right visible-sm visible-xs">
        <i class="ti-menu"></i>
    </div>
    <div class="row">
        <div class="text-left col-sm-9 module-group menu-left">
            <div class="module text-left">
                <?php get_template_part( 'templates/header/inc', 'menu' ); ?>
            </div>
        </div>
        <div class="text-right col-sm-3 module-group right">
            <?php
            get_template_part( 'templates/header/inc', 'button' );
            if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_search', 1 ))) && 
                'yes' == get_option( 'navian_header_search', 'yes' ) ) {
                get_template_part( 'templates/header/inc', 'search' );
            }
            if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_cart', 1 ))) && 
                'yes' == get_option( 'navian_header_cart', 'yes' ) && class_exists( 'Woocommerce' ) ) {
                get_template_part( 'templates/header/inc', 'cart' );
            }
            if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_language', 1 ))) && 
                'yes' == get_option( 'navian_header_language', 'yes' ) && function_exists( 'icl_get_languages' ) ) {
                get_template_part( 'templates/header/inc', 'language' );
            }
            ?>
        </div>
    </div>
</div>