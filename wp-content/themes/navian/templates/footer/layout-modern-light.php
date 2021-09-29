<?php
$header_info = navian_get_header_info();
$logos = navian_get_logo();
$social_icons = navian_footer_social_icons();
?>
<footer class="footer-modern bg-white pt48 pb40 pr-xs-15 pl-xs-15">
	<div class="row">
	    <div class="col-md-offset-1 col-md-3 col-sm-4 text-center-xs">
	    	<div class="mb0">
				<?php get_template_part( 'templates/footer/inc', 'menu' ); ?>
            </div>
            <span class="sub <?php echo has_nav_menu('footer') ? 'mt16' : ''; ?>"><?php echo wp_kses($header_info['footer_text'], navian_allowed_tags()); ?></span>
	    </div>
	    <div class="col-sm-4 text-center mt-xx-24 mb-xx-24">
	        <a href="<?php echo esc_url(home_url('/')); ?>">
				<img alt="<?php echo esc_attr(get_bloginfo('title')); ?>" class="image-s fade-hover" src="<?php echo esc_url($logos['logo']); ?>" />
			</a>
			<?php if( $header_info['first_text'] ) : ?>
	        <span class="sub mt16"><?php echo wp_kses($header_info['first_icon'].$header_info['first_text'], navian_allowed_tags()); ?></span>
	        <?php endif; ?>
	        <?php if( $header_info['second_text'] ) : ?>
	        <span class="sub"><?php echo wp_kses($header_info['second_icon'].$header_info['second_text'], navian_allowed_tags()); ?></span>
	        <?php endif; ?>
	    </div>
	    <div class="col-md-3 col-sm-4 text-right text-center-xs">
	        <?php if (!empty($social_icons)) { ?>
	        <ul class="list-inline social-list mb0"><?php echo !empty($social_icons) ? $social_icons : ''; ?></ul>
	    	<?php } ?>
	    </div>
    </div>
</footer>