<?php 
$testimonial_url = get_post_meta( $post->ID, '_tlg_testimonial_url', 1 );
$testimonial_content = get_post_meta( $post->ID, '_tlg_testimonial_content', 1 );
$testimonial_info = get_post_meta( $post->ID, '_tlg_testimonial_info', 1 );
?>
<li class="item move-cursor ml-15 mr-15 testimonial-standard testimonial-quote text-center">
    <div class="feature boxed image-round-100">
        <?php echo !empty($testimonial_content) ? '<div class="content quote-content">'.$testimonial_content.'</div>' : ''; ?>
        <div class="testimonial-avatar">
            <?php the_post_thumbnail( 'full', array('class' => 'image-m inline-block mb32') ); ?>
        </div>
        <div class="display-block">
            <h5 class="mb0">
            <?php 
            if( !filter_var( $testimonial_url, FILTER_VALIDATE_URL ) === false || $testimonial_url == '#' ) {
                echo '<a class="link-dark-title" href="'. esc_url($testimonial_url) .'">'.get_the_title().'</a>';
            } else {
                echo get_the_title();
            }
            ?>                
            </h5>
            <?php echo !empty($testimonial_info) ? '<span>'.$testimonial_info.'</span>' : ''; ?>
        </div>
    </div>
</li>