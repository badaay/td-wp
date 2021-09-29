<?php
/**
* This functions are used for adding captcha in Contact Form 7
**/

/* add shortcode handler */
if ( ! function_exists ( 'wpcf7_add_shortcode_bws_captcha' ) ) {
	function wpcf7_add_shortcode_bws_captcha() {
		if ( function_exists( 'wpcf7_add_shortcode' ) )
			wpcf7_add_shortcode( 'bwscaptcha', 'wpcf7_bws_captcha_shortcode_handler', TRUE );
	}
}
/* display captcha */
if ( ! function_exists ( 'wpcf7_bws_captcha_shortcode_handler' ) ) {
	function wpcf7_bws_captcha_shortcode_handler( $tag ) {
		if ( class_exists( 'WPCF7_Shortcode' ) ) {
			$tag = new WPCF7_Shortcode( $tag );

			if ( empty( $tag->name ) )
				return '';

			$validation_error = wpcf7_get_validation_error( $tag->name );
			$class = wpcf7_form_controls_class( $tag->type );

			if ( $validation_error )
				$class .= ' wpcf7-not-valid';

			$atts = array();
			$atts['class'] = $tag->get_class_option( $class, $tag->name );
			$atts['id'] = $tag->get_option( 'id', 'id', true );
			$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );
			$atts['aria-required'] = 'true';
			$atts['type'] = 'text';
			$atts['name'] = $tag->name;
			$atts['value'] = '';
			
			$cptchpls = cptchpls_display_captcha_custom( $atts['class'], $tag->name );

			$atts = wpcf7_format_atts( $atts );

			return sprintf( '<span class="wpcf7-form-control-wrap %1$s">' . $cptchpls . '%3$s</span>', $tag->name, $atts, $validation_error );
		} else {
			return '';
		}
	}
}

/* tag generator */
if ( ! function_exists ( 'wpcf7_add_tag_generator_bws_captcha' ) ) {
	function wpcf7_add_tag_generator_bws_captcha() {
		if ( ! function_exists( 'wpcf7_add_tag_generator' ) )
			return;
		$cf7_plugin_info = get_plugin_data( dirname( dirname( dirname( __FILE__ ) ) ) . "/contact-form-7/wp-contact-form-7.php" );
		if ( isset( $cf7_plugin_info ) && $cf7_plugin_info["Version"] >= '4.2' )
			wpcf7_add_tag_generator( 'bwscaptcha', __( 'BWS CAPTCHA', 'captcha-plus' ), 'wpcf7-bwscaptcha', 'wpcf7_tg_pane_bws_captcha_after_4_2' );
		elseif ( isset( $cf7_plugin_info ) && $cf7_plugin_info["Version"] >= '3.9' )
			wpcf7_add_tag_generator( 'bwscaptcha', __( 'BWS CAPTCHA', 'captcha-plus' ), 'wpcf7-bwscaptcha', 'wpcf7_tg_pane_bws_captcha_after_3_9' );
		else
			wpcf7_add_tag_generator( 'bwscaptcha', __( 'BWS CAPTCHA', 'captcha-plus' ), 'wpcf7-bwscaptcha', 'wpcf7_tg_pane_bws_captcha' );
	}
}

if ( ! function_exists ( 'wpcf7_tg_pane_bws_captcha' ) ) {
	function wpcf7_tg_pane_bws_captcha( &$contact_form ) { ?>
		<div id="wpcf7-bwscaptcha" class="hidden">
			<form action="">
				<table>
					<tr>
						<td>
							<?php _e( 'Name', 'contact-form-7' ); ?><br />
							<input type="text" name="name" class="tg-name oneline" />
						</td>
					</tr>
				</table>
				<div class="tg-tag">
					<?php _e( 'Copy this code and paste it into the form left.', 'contact-form-7' ); ?><br />
					<input type="text" name="bwscaptcha" class="tag" readonly="readonly" onfocus="this.select()" />
				</div>
			</form>
		</div>
	<?php }
}

if ( ! function_exists ( 'wpcf7_tg_pane_bws_captcha_after_3_9' ) ) {
	function wpcf7_tg_pane_bws_captcha_after_3_9( $contact_form ) { ?>
		<div id="wpcf7-bwscaptcha" class="hidden">
			<form action="">
				<table>
					<tr>
						<td>
							<?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?><br />
							<input type="text" name="name" class="tg-name oneline" />
						</td>
					</tr>
				</table>
				<div class="tg-tag">
					<?php echo esc_html( __( "Copy this code and paste it into the form left.", 'contact-form-7' ) ); ?><br />
					<input type="text" name="bwscaptcha" class="tag" readonly="readonly" onfocus="this.select()" />
				</div>
			</form>
		</div>
	<?php }
}

if ( ! function_exists ( 'wpcf7_tg_pane_bws_captcha_after_4_2' ) ) {
	function wpcf7_tg_pane_bws_captcha_after_4_2( $contact_form, $args = '' ) {
		$args = wp_parse_args( $args, array() );
		$type = 'bwscaptcha'; ?>
		<div class="control-box">
			<fieldset>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
							<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
		<div class="insert-box">
			<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
			<div class="submitbox">
				<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
			</div>
		</div>
	<?php }
}

/* validation for captcha */
if ( ! function_exists ( 'wpcf7_bws_captcha_validation_filter' ) ) {
	function wpcf7_bws_captcha_validation_filter( $result, $tag ) {
		global $cptchpls_options, $wpdb;
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];

		if ( class_exists( 'WPCF7_Shortcode' ) ) {
			$tag = new WPCF7_Shortcode( $tag );
			$name = $tag->name;
			
			if ( isset( $_POST[ $name ] ) ) {
				if ( cptchpls_limit_exhausted() ) {
					$result_reason = wpcf7_get_message( 'timeout_bwscaptcha' );
				} elseif ( 
					! empty( $_POST[ $name ] ) &&
					isset( $_POST[ $name . '-cptchpls_result'] ) && 
					isset( $_POST[ 'cptchpls_time'] ) && 
					0 != strcasecmp( trim( cptchpls_decode( $_POST[ $name . '-cptchpls_result'], $str_key, $_POST[ 'cptchpls_time'] ) ), $_POST[ $name ] )
				) {
					$result_reason = wpcf7_get_message( 'wrong_bwscaptcha' );
				} elseif( empty( $_POST[ $name ] ) ) {
					$result_reason = wpcf7_get_message( 'fill_bwscaptcha' );
				}

				if ( isset( $result_reason ) ) {
					if ( is_array( $result ) ) {
						$result['valid'] = FALSE;
						$result['reason'][ $name ] = $result_reason;
					} elseif ( is_object( $result ) ) {
						/* cf after v4.1 */
						$result->invalidate( $tag, $result_reason );
					}					
				}
			}
			return $result;
		}
	}
}

/* add messages for Captha errors */
if ( ! function_exists ( 'wpcf7_bwscaptcha_messages' ) ) {
	function wpcf7_bwscaptcha_messages( $messages ) {
		global $cptchpls_options;
		return array_merge(
			$messages,
			array(
				'wrong_bwscaptcha'	=> array(
					'description'	=> $cptchpls_options['cptchpls_error_incorrect_value'],
					'default'		=> $cptchpls_options['cptchpls_error_incorrect_value']
				),
				'fill_bwscaptcha'	=> array(
					'description'	=> $cptchpls_options['cptchpls_error_empty_value'],
					'default'		=> $cptchpls_options['cptchpls_error_empty_value']
				),
				'timeout_bwscaptcha' => array(
					'description'	=> $cptchpls_options['cptchpls_error_time_limit'],
					'default'		=> $cptchpls_options['cptchpls_error_time_limit']
				)
			)
		);
	}
}

/* add warning message */
if ( ! function_exists ( 'wpcf7_bwscaptcha_display_warning_message' ) ) {
	function wpcf7_bwscaptcha_display_warning_message() {
		if ( empty( $_GET['post'] ) || ! ( $contact_form = wpcf7_contact_form( $_GET['post'] ) ) )
			return;

		$has_tags = (bool)$contact_form->form_scan_shortcode( array( 'type' => array( 'bwscaptcha' ) ) );

		if ( ! $has_tags )
			return;
	}
} ?>