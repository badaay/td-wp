<?php 	
get_header();
$term = get_queried_object();
$term_name = esc_html__( 'Archives', 'navian' );
$term_desc = '';
if ( !$term ) {
	if ( is_day() )
		$term_name = get_the_date();
	elseif ( is_month() )
		$term_name = get_the_date( _x( 'F Y', 'monthly archives date format', 'navian' ) );
	elseif ( is_year() )
		$term_name = get_the_date( _x( 'Y', 'yearly archives date format', 'navian' ) );
} else {
	if ( isset ($term->name) ) {
		$term_name = $term->name;
	} elseif ( isset ($term->display_name) ) {
		$term_name = $term->display_name;
	}
	$term_desc = isset ($term->description) ? $term->description : '';
}
$page_title_args = array(
	'title'   	=> $term_name,
	'subtitle'  => $term_desc,
	'leadtitle' => get_option( 'navian_blog_leadtitle', '' ),
	'layout' 	=> get_option( 'navian_blog_header_layout', 'center' ),
	'image'    	=> get_option( 'navian_blog_header_image' ) ? '<img src="'. get_option( 'navian_blog_header_image' ) .'" alt="'.esc_attr( 'page-header' ).'" class="background-image" />' : false
);
echo navian_get_the_page_title( $page_title_args );
get_template_part( 'templates/post/layout', get_option( 'navian_blog_layout', 'masonry-sidebar-right' ) );
get_footer();