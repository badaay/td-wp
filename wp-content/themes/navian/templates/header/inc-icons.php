<?php
global $post;
if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_search', 1 ))) && 
	'yes' == get_option( 'navian_header_search', 'yes' ) ) {
    get_template_part( 'templates/header/inc', 'search' );
}
if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_cart', 1 ))) && 
	'yes' == get_option( 'navian_header_cart', 'yes' ) && class_exists( 'Woocommerce' ) ) {
    get_template_part( 'templates/header/inc', 'cart' );
}
if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_language', 1 ))) && 
	'yes' == get_option( 'navian_header_language', 'yes' ) && function_exists( 'icl_get_languages' ) ) {
    get_template_part( 'templates/header/inc', 'language' );
}