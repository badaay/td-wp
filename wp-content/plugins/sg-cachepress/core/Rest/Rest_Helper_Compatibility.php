<?php
namespace SiteGround_Optimizer\Rest;

use SiteGround_Optimizer\Php_Checker\Php_Checker;

/**
 * Rest Helper class that manages enviroment optimisation settings.
 */
class Rest_Helper_Compatibility extends Rest_Helper {
	/**
	 * Handle compatibility check.
	 *
	 * @since  5.0.0
	 *
	 * @param  object $request Request data.
	 */
	public function handle_compatibility_check( $request ) {
		// Init the Checker.
		$checker = new Php_Checker();
		// Get the php version.
		$php_version = $this->validate_and_get_option_value( $request, 'php_version' );
		// Add the background processes.
		$checker->initialize( $php_version );
		// Send successful response.
		wp_send_json_success();
	}

	/**
	 * Return the status of current compatibility check.
	 *
	 * @since  5.0.0
	 */
	public function handle_compatibility_status_check() {
		wp_send_json_success(
			array(
				'phpcompat_status'        => (int) get_option( 'siteground_optimizer_phpcompat_status', 0 ),
				'phpcompat_progress'      => (int) get_option( 'siteground_optimizer_phpcompat_progress', 1 ),
				'phpcompat_is_compatible' => (int) get_option( 'siteground_optimizer_phpcompat_is_compatible', 0 ),
				'phpcompat_result'        => get_option( 'siteground_optimizer_phpcompat_result' ),
			)
		);
	}
}
