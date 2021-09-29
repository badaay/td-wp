<?php
global $post;
$btn_url = get_option('navian_header_btn_url', '');
if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_header_btn_url', true ) ) {
    $btn_url = get_post_meta( $post->ID, '_tlg_header_btn_url', true );
}
$btn_title = get_option('navian_header_btn_title', '');
if( isset( $post->ID ) && get_post_meta( $post->ID, '_tlg_header_btn_title', true ) ) {
    $btn_title = get_post_meta( $post->ID, '_tlg_header_btn_title', true );
}
if ($btn_url && $btn_title) { ?>
	<div class="module widget-wrap left header-button">
		<a href="<?php echo esc_url( $btn_url ) ?>" class="btn-header btn btn-filled btn-rounded btn-sm-sm m0"><?php echo wp_kses($btn_title, navian_allowed_tags()); ?></a>
	</div><?php 
}