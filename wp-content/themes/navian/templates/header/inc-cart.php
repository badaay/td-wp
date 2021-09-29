<?php global $woocommerce; ?>
<div class="module widget-wrap cart-widget-wrap left no-toggle">
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-icon modal-fixed-action" data-modal="cart-modal">
        <i class="ti-bag"></i>
        <span class="label number"><span class="tlg-count"><?php echo wp_specialchars_decode($woocommerce->cart->get_cart_contents_count()); ?></span></span>
        <span class="title"><?php esc_html_e( 'Shopping Cart', 'navian' ); ?></span>
    </a>
    <div class="widget-inner modal-fixed" id="cart-modal">
        <div class="widget">
            <div class="cart-header">
                <a class="modal-fixed-close text-right" href="#"><i class="ti-close color-white-force ms-text opacity-show"></i></a>
                <div class="modal-fixed-content">
                    <div class="cart-header-content">
                        <?php
                        if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) the_widget( 'WC_Widget_Cart', 'title=Cart' );
                        else the_widget( 'WooCommerce_Widget_Cart', 'title=Cart' );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>