<?php $header_class = navian_get_header_class(); ?>
<div class="nav-container minimal-header <?php echo esc_attr( $header_class['menu_class'] ); ?>">
    <nav>
        <?php get_template_part( 'templates/header/inc', 'header-minimal' ); ?>
    </nav>
</div>