<?php 
$testimonial_url = get_post_meta( $post->ID, '_tlg_testimonial_url', 1 );
$testimonial_content = get_post_meta( $post->ID, '_tlg_testimonial_content', 1 );
$testimonial_info = get_post_meta( $post->ID, '_tlg_testimonial_info', 1 );
?>
<li class="item move-cursor">
    <div class="boxed boxed-intro boxed-small image-round-100" 
        style="
                padding: 24px 0px 0px 24px;
                background: #FFFFFF;
                /* Shadow */

                box-shadow: 0px 4px 50px rgba(0, 0, 0, 0.1);
                border-radius: 12px;"
    >
        <span class="tlg-star-ratings mb8 mt8" ><span class="tlg-star-rating"><span></span></span></span>
        <?php echo !empty($testimonial_content) ? '<div class="content graytext-color">'.$testimonial_content.'</div>' : ''; ?>
        <?php the_post_thumbnail( 'full', array('class' => 'image-xs inline-block mt24') ); ?>
        <div class="display-block">
            <h5 class="capitalize inline-block">
            <?php 
            if( !filter_var( $testimonial_url, FILTER_VALIDATE_URL ) === false || $testimonial_url == '#' ) {
                echo '<a class="author-link" href="'. esc_url($testimonial_url) .'">'.get_the_title().'</a>';
            } else {
                echo get_the_title();
            }
            echo !empty($testimonial_info) ? '<span class="fade-color"> — '.$testimonial_info.'</span>' : '';
            ?>                
            </h5>
        </div>
    </div>
</li>