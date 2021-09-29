<?php 
$header_info = navian_get_header_info();
$logos = navian_get_logo(); 
?>
<div class="show-sm">
	<?php get_template_part( 'templates/header/layout', 'standard-no-top-dark' ); ?>
</div>
<div class="nav-container right-menu vertical-menu hide-sm bg-dark">
	<nav class="absolute transparent side-menu height-full">
		<div class="text-center bg-dark pl-32 pr-32 height-full">
			<div class="vertical-top-no bg-dark above pt40 pb24">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<?php if( $logos['logo_text'] && 'text' == $logos['site_logo'] ) : ?>
                        <h1 class="logo"><?php echo esc_attr($logos['logo_text']); ?></h1>
                    <?php else: ?>
					<img class="image-xs mb40 mb-xs-24" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo_light']); ?>" srcset="<?php echo esc_attr($logos['logo_light_srcset']); ?>" />
					<?php endif; ?>
				</a>
			</div>
			<div class="vertical-alignment-no ml--32 mr--32 text-left">
				<?php get_template_part( 'templates/header/inc', 'menu-vertical' ); ?>
			</div>
			<div class="vertical-bottom-no bg-dark above pt24 pb24 text-left social-footer">
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