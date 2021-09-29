<?php 
$testimonial_url = get_post_meta( $post->ID, '_tlg_testimonial_url', 1 );
$testimonial_content = get_post_meta( $post->ID, '_tlg_testimonial_content', 1 );
$testimonial_info = get_post_meta( $post->ID, '_tlg_testimonial_info', 1 );
?>
<li class="item move-cursor">
    <?php if (has_post_thumbnail()) : ?>
    <div class="col-sm-3">
        <div class="quote-author big-author image-round-100 testimonial-avatar mr-24">
            <?php the_post_thumbnail(); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="mt-xs-24 <?php echo has_post_thumbnail() ? 'col-sm-9' : 'col-sm-12' ?>">
        <?php echo !empty($testimonial_content) ? '<div class="quote text-left content">'.$testimonial_content.'</div>' : ''; ?>
        <div class="text-left">
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