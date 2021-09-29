<?php 
get_header();
$page_title_args = array(
	'title'   	=> get_option( 'navian_portfolio_title', esc_html__( 'Our portfolio', 'navian' ) ),
	'subtitle'  => get_option( 'navian_portfolio_subtitle', '' ),
	'leadtitle' => get_option( 'navian_portfolio_leadtitle', '' ),
	'layout' 	=> get_option( 'navian_portfolio_header_layout', 'center' ),
	'image'    	=> get_option( 'navian_portfolio_header_image' ) ? '<img src="'. get_option( 'navian_portfolio_header_image' ) .'" alt="'.esc_attr( 'page-header' ).'" class="background-image" />' : false
);
echo navian_get_the_page_title( $page_title_args );
get_template_part( 'templates/portfolio/layout', get_option( 'navian_portfolio_layout', 'full-masonry-4col' ) );
get_footer();