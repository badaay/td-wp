<?php 
$header_info = navian_get_header_info();
$logos = navian_get_logo(); 
$social_icons = navian_footer_social_icons();
?>
<footer class="footer-basic bg-dark section-small">
	<div class="container">
		<div class="row">
			<div class="text-center">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img alt="<?php echo esc_attr(get_bloginfo('title')); ?>" class="image-small mb8 fade-hover" src="<?php echo esc_url($logos['logo_light']); ?>" srcset="<?php echo esc_attr($logos['logo_light_srcset']); ?>" />
				</a>
				<?php if ( 'yes' == get_option( 'navian_enable_copyright', 'yes' ) ) : ?>
				<p class="mb8 sub"><?php echo wp_kses($header_info['footer_text'], navian_allowed_tags()); ?></p>
				<?php endif; ?>
				<div class="mb0">
					<?php if (!empty($social_icons)) { ?>
					<ul class="list-inline social-list mb0"><?php echo !empty($social_icons) ? $social_icons : ''; ?></ul>
					<?php } ?>
				</div>
				<div class="mb0">
					<?php get_template_part( 'templates/footer/inc', 'menu' ); ?>
                </div>
			</div>
		</div>
	</div>
</footer>