<?php 
$header_info = navian_get_header_info();
$logos = navian_get_logo();
$social_icons = navian_footer_social_icons();
?>
<footer class="footer-modern bg-white pt48 pb40 pr-xs-15 pl-xs-15 text-center-xs">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <a href="<?php echo esc_url(home_url('/')); ?>">
					<img alt="<?php echo esc_attr(get_bloginfo('title')); ?>" class="image-s fade-hover" src="<?php echo esc_url($logos['logo']); ?>" />
				</a>
                <div class="mt16">
					<?php get_template_part( 'templates/footer/inc', 'menu' ); ?>
	            </div>
            </div>
            <div class="col-sm-6 text-right text-center-xs">
                <?php if (!empty($social_icons)) { ?>
                <ul class="list-inline social-list mb0 mt-xs-16"><?php echo !empty($social_icons) ? $social_icons : ''; ?></ul>
                <?php } ?>
                <?php if( $header_info['second_text'] ) : ?>
		        	<span class="sub <?php echo !empty($social_icons) ? 'mt16' : ''; ?>"><?php echo wp_kses($header_info['second_icon'].$header_info['second_text'], navian_allowed_tags()); ?></span>
		        <?php endif; ?>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php if( $header_info['first_text'] ) : ?>
		        	<span class="sub"><?php echo wp_kses($header_info['first_icon'].$header_info['first_text'], navian_allowed_tags()); ?></span>
		        <?php endif; ?>
            </div>
            <div class="col-sm-6 text-right text-center-xs">
                <span class="sub"><?php echo wp_kses($header_info['footer_text'], navian_allowed_tags()); ?></span>
            </div>
        </div>
    </div>
</footer>