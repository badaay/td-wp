<?php
/**
 * Theme Woocommerce
 *
 * @package TLG Theme
 *
 */

/**
	UPDATE CART IN HEADER
**/
if( ! function_exists( 'navian_woocommerce_update_cart' ) ) {
	function navian_woocommerce_update_cart( $cartInfo ) {
		global $woocommerce;
		ob_start(); ?>
		<span class="tlg-count"><?php echo wp_specialchars_decode($woocommerce->cart->get_cart_contents_count()); ?></span>
		<?php
		$cartInfo['span.tlg-count'] = ob_get_clean();
		return $cartInfo;
	}
	add_filter('woocommerce_add_to_cart_fragments', 'navian_woocommerce_update_cart');
}

/**
	NUMBER OF PRODUCTS PER PAGE
**/
if( ! function_exists( 'navian_woocommerce_ppp' ) ) {
	function navian_woocommerce_ppp() {
		$ppp = isset ($_GET['ppp'] ) ? $_GET['ppp'] : false;
		if (empty($ppp)) {
			$ppp = get_option( 'navian_shop_ppp', '' );
			if (empty($ppp)) {
				if (is_active_sidebar( 'shop' )) {
					$ppp = 6;
				} else {
					$ppp = 8;
				}
			}
		}
		return $ppp;
	}
	add_filter( 'loop_shop_per_page', 'navian_woocommerce_ppp', 20 );
}

/**
	WOOCOMMERCE SHARE
**/
if( ! function_exists( 'navian_woocommerce_share' ) ) {
	function navian_woocommerce_share() {
		if (function_exists('tlg_framework_setup')) {
			echo '<div class="mt32 overflow-hidden border-section">';
	        echo tlg_framework_share_display();
			echo '</div>';
		}
	}
	add_action( 'woocommerce_share', 'navian_woocommerce_share' );
}