<?php
$header_info = navian_get_header_info();
$header_class = navian_get_header_class();
$social_icons = navian_header_social_icons();
if (!empty($header_info['first_text']) || !empty($header_info['second_text']) || !empty($header_info['third_text']) || !empty($social_icons)) {
?>	
<div class="nav-utility <?php echo esc_attr( $header_class['nav_class'] ); ?>">
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
    <?php 
    if (!empty($social_icons)) : ?>
	<div class="module right">
		<ul class="list-inline social-list mb24">
            <?php echo !empty($social_icons) ? $social_icons : ''; ?>
        </ul>
    </div>
    <?php endif; ?>
    <?php if( $header_info['third_text'] ) : ?>
	    <div class="module right no-float-xs">
	        <span class="sub"><?php echo wp_kses($header_info['third_icon'].$header_info['third_text'], navian_allowed_tags()); ?></span>
	    </div>
    <?php endif; ?>
</div>
<?php } ?>