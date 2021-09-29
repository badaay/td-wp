<?php
$header_info = navian_get_header_info();
$logos = navian_get_logo();
if ( wp_is_mobile() ) {
	get_template_part( 'templates/header/layout', 'standard-no-top' );
} else { ?>
<div class="nav-container vertical-menu">
	<nav class="absolute transparent">
		<div class="nav-bar">
			<div class="module left">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<?php if( $logos['logo_text'] && 'text' == $logos['site_logo'] ) : ?>
                        <h1 class="logo"><?php echo esc_attr($logos['logo_text']); ?></h1>
                    <?php else: ?>
				    <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo_light']); ?>" srcset="<?php echo esc_attr($logos['logo_light_srcset']); ?>" />
            		<img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo']); ?>" srcset="<?php echo esc_attr($logos['logo_srcset']); ?>" />
                    <?php endif; ?>
				</a>
			</div>
			<div class="module widget-wrap offcanvas-toggle right">
				<i class="ti-menu"></i>
			</div>
			<div class="module module-group right hide-xs">
		    	<?php get_template_part( 'templates/header/inc', 'icons' ); ?>
		    </div>
		    <?php if( $header_info['second_text'] ) : ?>
			    <div class="module right hide-xs">
			        <span class="sub"><?php echo wp_kses($header_info['second_icon'].$header_info['second_text'], navian_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		    <?php if( $header_info['first_text'] ) : ?>
			    <div class="module right hide-xs">
			        <span class="sub"><?php echo wp_kses($header_info['first_icon'].$header_info['first_text'], navian_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		</div>
		<div class="offcanvas-container text-center">
			<div class="close-nav"><a href="#">
				<i class="ti-close"></i>
			</a></div>
			<div class="vertical-alignment-no text-center mt120">
				<div class="mb40 ml-24 mr-24">
					<?php echo get_search_form(); ?>
				</div>
				<?php get_template_part( 'templates/header/inc', 'menu-vertical' ); ?>
			</div>
			<div class="vertical-bottom-no bg-white above pt24 pb96 pl-32 pr-32 text-center social-footer">
				<?php 
			    $social_icons = navian_header_social_icons();
			    if (!empty($social_icons)) : ?>
					<ul class="list-inline social-list"><?php echo !empty($social_icons) ? $social_icons : ''; ?></ul>
				<?php endif; ?>
				<?php if ( 'yes' == get_option( 'navian_enable_copyright', 'yes' ) ) : ?>
					<div class="heading-font footer-text s-text pt24"><?php echo wp_kses($header_info['footer_text'], navian_allowed_tags()); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</nav>
</div>
<?php }