<style>
    .nav-container nav.transparent .menu > li > a, .nav-container nav.transparent .module.widget-wrap i, .nav-container nav.transparent .nav-utility, .nav-container nav.transparent .nav-utility a, .nav-container nav.transparent h1.logo {
        color: #000;
    }
</style>
<?php $header_class = navian_get_header_class(); ?>
<div class="nav-container <?php echo esc_attr( $header_class['menu_class']. ' '.$header_class['menu_standard_class'] ); ?>">
    <nav>
        <?php get_template_part( 'templates/header/inc', 'header-standard' ); ?>
    </nav>
</div>