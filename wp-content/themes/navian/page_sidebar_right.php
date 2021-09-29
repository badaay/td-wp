<?php 
/*
Template Name: Sidebar Right Template
*/
get_header();
the_post();
$page_title_args = array(
	'title'   	=> get_the_title(),
	'subtitle'  => get_post_meta( $post->ID, '_tlg_the_subtitle', true ),
	'layout' 	=> navian_get_page_title_layout(),
	'image'     => get_post_meta( $post->ID, '_tlg_title_bg_featured', true ) == 'yes' ? 
        ( has_post_thumbnail() ? wp_get_attachment_image( get_post_thumbnail_id(), 'full', 0, array('class' => 'background-image', 'alt' => 'page-header') ) : false ) :
        ( get_post_meta( $post->ID, '_tlg_title_bg_img', true ) ? '<img class="background-image" alt="'.esc_attr( 'page-header' ).'" src="'.esc_url(get_post_meta( $post->ID, '_tlg_title_bg_img', true )).'" />' : false )
);
echo navian_get_the_page_title( $page_title_args );
if (is_active_sidebar( 'page' )) {
	$page_class = 'col-md-9 col-sm-12 post-content';
	$page_id = 'main-content';
	$post_class = 'p0 sidebar-right';
} else {
	$page_class = 'col-lg-10 col-sm-12 col-lg-offset-1';
	$page_id = '';
	$post_class = '';
}
?>
<section id="page-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<div class="container">
	    <div class="row">
	        <div id="<?php echo esc_attr($page_id); ?>" class="<?php navian_the_page_class($page_class); ?>">
	        	<?php the_content(); wp_link_pages(); comments_template(); ?>
	        </div>
	        <?php 
	    	if (is_active_sidebar( 'page' )) {
	    		get_sidebar( 'page' ); 
	    	}
	    	?>
	    </div>
	</div>
</section>
<?php get_footer();