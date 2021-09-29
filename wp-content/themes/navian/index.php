<?php
get_header();
$page_title_args = array(
	'title'   	=> get_option( 'tlg_framework_blog_title', esc_html__( 'Our Blog', 'navian' ) ),
	'subtitle'  => get_option( 'navian_blog_subtitle', '' ),
	'leadtitle' => get_option( 'navian_blog_leadtitle', '' ),
	'layout' 	=> get_option( 'navian_blog_header_layout', 'center' ),
	'image'    	=> get_option( 'navian_blog_header_image' ) ? '<img src="'. get_option( 'navian_blog_header_image' ) .'" alt="'.esc_attr( 'page-header' ).'" class="background-image" />' : false
);
echo navian_get_the_page_title( $page_title_args );
get_template_part( 'templates/post/layout', get_option( 'navian_blog_layout', 'masonry-sidebar-right' ) );
get_footer();