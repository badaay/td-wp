<?php $header_class = navian_get_header_class(); ?>
<div class="nav-container <?php echo esc_attr( $header_class['menu_class'] ); ?>">
    <nav class="absolute nav-box">
    	<?php get_template_part( 'templates/header/inc', 'header-standard' ); ?>
    </nav>
</div>