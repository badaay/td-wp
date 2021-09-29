<?php
$header_info = navian_get_header_info();
$header_class = navian_get_header_class();
$logos = navian_get_logo();
?>	
<div class="nav-utility big-utility <?php echo esc_attr( $header_class['nav_class'] ); ?>">
	<div class="row">
		<div class="text-left col-sm-5">
			<?php if( $header_info['first_text'] ) : ?>
			    <div class="module left">
			        <span class="sub"><?php echo wp_kses($header_info['first_icon'].$header_info['first_text'], navian_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		    <?php if( $header_info['second_text'] ) : ?>
			    <div class="module left">
			        <span class="sub"><?php echo wp_kses($header_info['second_icon'].$header_info['second_text'], navian_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		</div>
		<div class="text-center col-sm-2">
			<a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
				<?php if( $logos['logo_text'] && 'text' == $logos['site_logo'] ) : ?>
                    <h1 class="logo"><?php echo esc_attr($logos['logo_text']); ?></h1>
                <?php else: ?>
                <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo_light']); ?>" srcset="<?php echo esc_attr($logos['logo_light_srcset']); ?>" />
            	<img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url($logos['logo']); ?>" srcset="<?php echo esc_attr($logos['logo_srcset']); ?>" />
                <?php endif; ?>
            </a>
		</div>
		<div class="text-right col-sm-5">
			<?php 
	        $social_icons = navian_header_social_icons();
	        if (!empty($social_icons)) : ?>
			<div class="module">
				<ul class="list-inline social-list mb24">
		            <?php echo !empty($social_icons) ? $social_icons : ''; ?>
		        </ul>
		    </div>
		    <?php endif; ?>
		    <?php if( $header_info['third_text'] ) : ?>
			    <div class="module">
			        <span class="sub"><?php echo wp_kses($header_info['third_icon'].$header_info['third_text'], navian_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		</div>
	</div>
</div>