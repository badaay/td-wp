<?php
$header_class = navian_get_header_class();
$logos = navian_get_logo();
?>
<div class="nav-bar <?php echo esc_attr($header_class['nav_class']); ?>">
    <div class="module left visible-sm visible-xs inline-block">
        <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php if ($logos['logo_text'] && 'text' == $logos['site_logo']) : ?>
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
        <div class="text-left col-sm-2 module-group hidden-sx">
            <div class="module widget-wrap left">
                <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if ($logos['logo_text'] && 'text' == $logos['site_logo']) : ?>
                        <h1 class="logo"><?php echo esc_attr($logos['logo_text']); ?></h1>
                    <?php else: ?>
                    <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo_light']); ?>" srcset="<?php echo esc_attr($logos['logo_light_srcset']); ?>" />
                    <img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo']); ?>" srcset="<?php echo esc_attr($logos['logo_srcset']); ?>" />
                    <?php endif; ?>
                </a>
            </div>
        </div>
        <div class="text-center col-sm-8 module-group">
            <div class="module text-left">
                <?php get_template_part('templates/header/inc', 'menu'); ?>
            </div>
        </div>
        <div class="text-right col-sm-2 module-group right">
            <?php get_template_part('templates/header/inc', 'button'); ?>
            <a style="margin:10px;color:#ffffff;background:#008fd6;border-color:transparent;" class="btn btn-xs text-center mt-xs-24" href="https://terusberbagi.com/" target="_blank">
                Donasi Sekarang
            </a>
        </div>
    </div>
</div>