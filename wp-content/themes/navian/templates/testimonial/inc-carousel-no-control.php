<?php 
$testimonial_url = get_post_meta( $post->ID, '_tlg_testimonial_url', 1 );
$testimonial_content = get_post_meta( $post->ID, '_tlg_testimonial_content', 1 );
$testimonial_info = get_post_meta( $post->ID, '_tlg_testimonial_info', 1 );
?>
<li>
    <?php echo !empty($testimonial_content) ? '<div class="text-center content">'.$testimonial_content.'</div>' : ''; ?>
    <div class="quote-author image-round-100">
        <div class="testimonial-avatar">
            <?php the_post_thumbnail( 'full', array('class' => 'image-m inline-block mb32') ); ?>
        </div>
        <h4 class="mb0">
        <?php 
        if( !filter_var( $testimonial_url, FILTER_VALIDATE_URL ) === false || $testimonial_url == '#' ) {
            echo '<a class="link-dark-title" href="'. esc_url($testimonial_url) .'">'.get_the_title().'</a>';
        } else {
            echo get_the_title();
        }
        ?>
        </h4>
        <?php echo !empty($testimonial_info) ? '<span class="fade-color">'.$testimonial_info.'</span>' : ''; ?>
    </div>
</li>