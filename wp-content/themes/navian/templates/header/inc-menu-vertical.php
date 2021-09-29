<?php
if (has_nav_menu('primary')) {
    wp_nav_menu(
        array(
            'theme_location'    => 'primary',
            'depth'             => 3,
            'container'         => false,
            'container_class'   => false,
            'menu_class'        => 'mb40 mb-xs-24 offcanvas-menu',
            'fallback_cb'       => 'Navian_Nav_Walker::fallback',
            'walker'            => new Navian_Nav_Walker()
        )
    );
}