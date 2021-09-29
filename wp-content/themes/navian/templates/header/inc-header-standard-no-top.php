<?php
$header_class = navian_get_header_class();
$logos = navian_get_logo();
?>
<div class="nav-bar <?php echo esc_attr( $header_class['nav_class'] ); ?>">
    <div class="module left">
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
    <div class="module-group right">
        <div class="module left">
            <?php get_template_part( 'templates/header/inc', 'menu' ); ?>
        </div>
		<?php get_template_part( 'templates/header/inc', 'icons' ); ?>
                
        <button style="margin:10px;color:#ffffff;background:#008fd6;border-color:transparent;" class="btn btn-xs text-center mt-xs-24" href="https://www.youtube.com/channel/UCkyhyt51XW1jcUOPOWTc9-A" >
            Donasi Sekarang
        </button>
        
    </div>

</div>