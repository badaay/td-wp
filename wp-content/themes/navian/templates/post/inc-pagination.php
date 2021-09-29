<?php
$prev = get_previous_post();
$next = get_next_post();
$prev_link = $prev ? get_permalink($prev->ID) : false;
$next_link = $next ? get_permalink($next->ID) : false;
$prev_title = $prev ? get_the_title($prev->ID) : false;
$next_title = $next ? get_the_title($next->ID) : false;
$prev_subtitle = $prev ? ( get_post_meta($prev->ID, '_tlg_portfolio_date', 1) ? date("M d, Y", get_post_meta($prev->ID, '_tlg_portfolio_date', 1)) : mysql2date('M d, Y', $prev->post_date, false) ) : false;
$next_subtitle = $next ? ( get_post_meta($next->ID, '_tlg_portfolio_date', 1) ? date("M d, Y", get_post_meta($next->ID, '_tlg_portfolio_date', 1)) : mysql2date('M d, Y', $next->post_date, false) ) : false;
if( is_singular( 'product' ) ) {
	$prev_cats =  isset($prev->ID) ? get_the_terms( $prev->ID, 'product_cat' ) : null;
	$prev_subtitle = isset($prev_cats[0]) ? $prev_cats[0]->name : $prev_subtitle;
	$next_cats = isset($next->ID) ? get_the_terms( $next->ID, 'product_cat' ) : null;
	$next_subtitle = isset($next_cats[0]) ? $next_cats[0]->name : $next_subtitle;
}
if( is_singular( 'portfolio' ) ) {
	$prev_cats = isset($prev->ID) ? get_the_terms( $prev->ID, 'portfolio_category' ) : null;
	$prev_subtitle = isset($prev_cats[0]) ? $prev_cats[0]->name : $prev_subtitle;
	$next_cats = isset($next->ID) ? get_the_terms( $next->ID, 'portfolio_category' ) : null;
	$next_subtitle = isset($next_cats[0]) ? $next_cats[0]->name : $next_subtitle;
}
?>
<div class="page-nav mobile-hide">
	<?php if( $prev_link ) : ?>
		<a class="nav-prev" href="<?php echo esc_url($prev_link); ?>">
			<div class="nav-control"><i class="ti-angle-left"></i></div>
			<div class="nav-title">
				<div class="nav-name"><?php echo esc_attr( $prev_title ); ?></div>
				<div class="subtitle"><?php echo esc_attr( $prev_subtitle ); ?></div>
			</div>
		</a>
	<?php endif; ?>
	<?php if( $next_link ) : ?>
		<a class="nav-next" href="<?php echo esc_url($next_link); ?>">
			<div class="nav-control"><i class="ti-angle-right"></i></div>
			<div class="nav-title">
				<div class="nav-name"><?php echo esc_attr( $next_title ); ?></div>
				<div class="subtitle"><?php echo esc_attr( $next_subtitle ); ?></div>
			</div>
		</a>
	<?php endif; ?>
</div>