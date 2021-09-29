<?php 
get_header();
the_post();
$page_title_args = array(
	'title'   	=> get_post_meta( $post->ID, '_tlg_the_title', true ) ? get_post_meta( $post->ID, '_tlg_the_title', true ) : get_the_title(),
	'subtitle'  => get_post_meta( $post->ID, '_tlg_the_subtitle', true ),
	'layout' 	=> navian_get_page_title_layout(),
	'image'     => get_post_meta( $post->ID, '_tlg_title_bg_featured', true ) == 'yes' ? 
        ( has_post_thumbnail() ? wp_get_attachment_image( get_post_thumbnail_id(), 'full', 0, array('class' => 'background-image', 'alt' => 'page-header') ) : false ) :
        ( get_post_meta( $post->ID, '_tlg_title_bg_img', true ) ? '<img class="background-image" alt="'.esc_attr( 'page-header' ).'" src="'.esc_url(get_post_meta( $post->ID, '_tlg_title_bg_img', true )).'" />' : false )
);
echo navian_get_the_page_title( $page_title_args );
?>
<div class="tlg-page-wrapper">
	<a id="home" href="#"></a>
	<?php 
	the_content();
	if ((is_singular('post') && 'yes' == get_option( 'navian_blog_enable_pagination', 'no' ))
    	|| (is_singular('portfolio') && 'yes' == get_option( 'navian_portfolio_enable_pagination_single', 'yes' ))
    	|| (class_exists('Woocommerce') && is_product() && 'yes' == get_option( 'navian_shop_enable_pagination', 'no'))
    ) {
    	get_template_part( 'templates/post/inc', 'pagination');
    }
    if ( is_singular( 'portfolio' ) ) {
		get_template_part( 'templates/portfolio/inc', 'meta');
	}
	?>
</div>
<?php if ( comments_open() && 'yes' == get_option('navian_enable_page_comment', 'no') ) : ?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<?php get_footer();