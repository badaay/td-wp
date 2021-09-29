<?php
global $post;
if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_footer', 1 ))) && 
	'yes' == get_option( 'navian_footer_menu', 'yes' ) && has_nav_menu('footer') ) {
    wp_nav_menu( 
        array(
            'theme_location'    => 'footer',
            'depth'             => 1,
            'container'         => false,
            'container_class'   => false,
            'menu_class'        => 'menu list-inline vertical-top mb0',
            'fallback_cb'       => 'Navian_Nav_Walker::fallback',
            'walker'            => new Navian_Nav_Walker()
        )
    );
}