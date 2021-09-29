<?php $header_class = navian_get_header_class(); ?>
<div class="nav-container <?php echo esc_attr( $header_class['menu_class']. ' '.$header_class['menu_standard_class'] ); ?>">
    <nav class="transparent absolute nav-dark">
    	<?php get_template_part( 'templates/header/inc', 'header-standard' ); ?>
    </nav>
</div>