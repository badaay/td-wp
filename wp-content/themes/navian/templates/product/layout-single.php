<section>
    <?php 
    if( 'yes' == get_option( 'navian_shop_enable_pagination', 'yes' ) ) { 
        get_template_part( 'templates/post/inc', 'pagination');
    }
    ?>
    <div class="container">
        <div class="product-single">
            <?php
            if ( post_password_required() ) {
                echo get_the_password_form();
            } else {
                woocommerce_content();
            }
            ?>
        </div>
    </div>
</section>