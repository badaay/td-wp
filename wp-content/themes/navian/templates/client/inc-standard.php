<?php 
global $post;  
$client_url = get_post_meta( $post->ID, '_tlg_client_url', true );
$target = $client_url && get_post_meta( $post->ID, '_tlg_client_url_new_window', 1 )  ? '_blank' : '_self';
$rel = $client_url && get_post_meta( $post->ID, '_tlg_client_url_nofollow', 1 )  ? 'nofollow' : '';
?>
<div class="col-sm-3 text-center">
	<div class="inline-block">
		<?php
		if( $client_url ) echo '<a href="'. esc_url( $client_url ) .'" target="'.esc_attr($target).'" rel="'.esc_attr($rel).'">';
		the_post_thumbnail( 'full', array('class' => 'image-s mb-xs-8 fade-35') );
		if( $client_url ) echo '</a>';
		?>
	</div>
</div>