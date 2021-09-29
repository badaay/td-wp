<?php
namespace SiteGround_Optimizer\Rest;

use SiteGround_Optimizer\Php_Checker\Php_Checker;
use SiteGround_Optimizer\Options\Options;
use SiteGround_Optimizer\Ssl\Ssl;
use SiteGround_Optimizer\Htaccess\Htaccess;
		
/**
 * Rest Helper class that manages enviroment optimisation settings.
 */

class Rest_Helper_Environment extends Rest_Helper{

	/**
	 * Link to json containing SiteGround supported PHP versions.
	 *
	 * @since 5.5.8
	 */
	const SUPPORTED_VERSIONS = 'https://updates.sgvps.net/supported-versions.json';

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->options  = new Options();
		$this->checker  = new Php_Checker();
		$this->htaccess = new Htaccess();
		$this->ssl      = new Ssl();
	}

	/**
	 * Switch the current php version.
	 *
	 * @since  5.0.0
	 *
	 * @param  object $request Request data.
	 */
	public function switch_php( $request ) {
		// Get the php version.
		$php_version = $this->validate_and_get_option_value( $request, 'php_version' );
		// Get the supported versions.
		$php_versions_request = wp_remote_get( self::SUPPORTED_VERSIONS );
		// Decode the response.
		$php_versions = json_decode( wp_remote_retrieve_body( $php_versions_request ), true );
		// Add the new recommended php version.
		$php_versions['versions'][] = 'recommended-php';

		if ( ! in_array( $php_version, $php_versions['versions'], false ) ) {
			wp_send_json(
				array(
					'success' => false,
					'data'    => array(
						'message' => __( 'Cannot change PHP Version', 'sg-cachepress' ),
					),
				)
			);
		}

		$this->htaccess->disable( 'php' );
		$result = $this->htaccess->enable(
			'php',
			array(
				'search'  => 'recommended-php' === $php_version ? 'php_PHPVERSION_' : '_PHPVERSION_',
				'replace' => str_replace( '.', '', $php_version ),
			)
		);

		// Reset the compatibility.
		$this->checker->complete();
		update_option( 'siteground_optimizer_phpcompat_is_compatible', 0 );
		update_option( 'siteground_optimizer_phpcompat_result', array() );

		wp_send_json(
			array(
				'success' => $result,
				'data'    => array(
					'message' => $result ? __( 'PHP Version has been changed', 'sg-cachepress' ) : __( 'Cannot change PHP Version', 'sg-cachepress' ),
				),
			)
		);
	}

	/**
	 * Enable the ssl
	 *
	 * @param  object $request Request data.
	 *
	 * @since  5.0.0
	 */
	public function enable_ssl( $request ) {
		$key    = $this->validate_and_get_option_value( $request, 'option_key' );
		// Bail if the domain doens't nove ssl certificate.
		if ( ! $this->ssl->has_certificate() ) {
			wp_send_json_error(
				array(
					'message' => __( 'Please, install an SSL certificate first!', 'sg-cachepress' ),
				)
			);
		}

		$result = $this->ssl->enable();

		wp_send_json(
			array(
				'success' => $result,
				'data' => array(
					'message' => $this->options->get_response_message( $result, $key, true ),
				),
			)
		);
	}

	/**
	 * Disable the ssl.
	 *
	 * @param  object $request Request data.
	 *
	 * @since  5.0.0
	 */
	public function disable_ssl( $request ) {
		$key    = $this->validate_and_get_option_value( $request, 'option_key' );
		$result = $this->ssl->disable();

		wp_send_json(
			array(
				'success' => $result,
				'data' => array(
					'message' => $this->options->get_response_message( $result, $key, false ),
				),
			)
		);
	}
}
