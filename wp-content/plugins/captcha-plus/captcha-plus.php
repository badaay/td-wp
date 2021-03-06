<?php
/*
Plugin Name: Captcha Plus by BestWebSoft
Plugin URI: http://bestwebsoft.com/products/
Description: Plugin Captcha intended to prove that the visitor is a human being and not a spam robot. Plugin asks the visitor to answer a math question.
Author: BestWebSoft
Text Domain: captcha-plus
Domain Path: /languages
Version: 1.1.3
Author URI: http://bestwebsoft.com/
License: Proprietary
*/

if ( ! function_exists( 'cptchpls_admin_menu' ) ) {
	function cptchpls_admin_menu() {
		bws_general_menu();
		$settings_page = add_submenu_page( 'bws_plugins', __( 'Captcha Plus Settings', 'captcha-plus' ), 'Captcha Plus', 'manage_options', "captcha-plus.php", 'cptchpls_settings_page' );
		add_action( "load-{$settings_page}", 'cptchpls_add_tabs' );
	}
}

if ( ! function_exists( 'cptchpls_plugins_loaded' ) ) {
	function cptchpls_plugins_loaded() {
		/* Internationalization */
		load_plugin_textdomain( 'captcha-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
}

if ( ! function_exists ( 'cptchpls_init' ) ) {
	function cptchpls_init() {
		global $cptchpls_plugin_info;

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );

		if ( ! $cptchpls_plugin_info ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$cptchpls_plugin_info = get_plugin_data( __FILE__ );
		}
		/* Function check if plugin is compatible with current WP version  */
		bws_wp_min_version_check( plugin_basename( __FILE__ ), $cptchpls_plugin_info, '3.8', '3.1' );

		/* Call register settings function */
		if ( ! is_admin() || ( isset( $_GET['page'] ) && "captcha-plus.php" == $_GET['page'] ) )
			cptchpls_settings();			
	}
}

if ( ! function_exists ( 'cptchpls_admin_init' ) ) {
	function cptchpls_admin_init() {
		global $bws_plugin_info, $cptchpls_plugin_info;		
		/* Add variable for bws_menu */
		if ( ! isset( $bws_plugin_info ) || empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '145', 'version' => $cptchpls_plugin_info["Version"] );

		/* Function for deactivate free ver plugin */
		deactivate_plugins( 'captcha/captcha.php' );
	}
}

if ( ! function_exists( 'cptchpls_create_table' ) ) {
	function cptchpls_create_table() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "cptch_whitelist` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`ip` CHAR(31) NOT NULL,
			`ip_from_int` BIGINT,
			`ip_to_int` BIGINT,
			`add_time` DATETIME,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );

		$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "cptch_images` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`name` CHAR(100) NOT NULL,
			`package_id` INT NOT NULL,
			`number` INT NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );

		$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "cptch_packages` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`name` CHAR(100) NOT NULL,
			`folder` CHAR(100) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql );

		/* remove unnecessary columns from 'whitelist' table */
		$column_exists = $wpdb->query( "SHOW COLUMNS FROM `" . $wpdb->prefix . "cptch_whitelist` LIKE 'ip_from'" );
		if ( 0 < $column_exists )
			$wpdb->query( "ALTER TABLE `" . $wpdb->prefix . "cptch_whitelist` DROP `ip_from`;" );
		$column_exists = $wpdb->query( "SHOW COLUMNS FROM `" . $wpdb->prefix . "cptch_whitelist` LIKE 'ip_to'" );
		if ( 0 < $column_exists )
			$wpdb->query( "ALTER TABLE `" . $wpdb->prefix . "cptch_whitelist` DROP `ip_to`;" );
		/* add new columns to 'whitelist' table */
		$column_exists = $wpdb->query( "SHOW COLUMNS FROM `" . $wpdb->prefix . "cptch_whitelist` LIKE 'add_time'" );
		if ( 0 == $column_exists )
			$wpdb->query( "ALTER TABLE `" . $wpdb->prefix . "cptch_whitelist` ADD `add_time` DATETIME;" );
		/* add unique key */
		if ( 0 == $wpdb->query( "SHOW KEYS FROM `" . $wpdb->prefix . "cptch_whitelist` WHERE Key_name='ip'" ) )
			$wpdb->query( "ALTER TABLE `" . $wpdb->prefix  . "cptch_whitelist` ADD UNIQUE(`ip`);" );
		/* remove not necessary indexes */
		$indexes = $wpdb->get_results( "SHOW INDEX FROM `" . $wpdb->prefix . "cptch_whitelist` WHERE Key_name Like '%ip_%'" );
		if ( ! empty( $indexes ) ) {
			$query = "ALTER TABLE `" . $wpdb->prefix . "cptch_whitelist`";
			$drop = array();
			foreach( $indexes as $index )
				$drop[] = " DROP INDEX " . $index->Key_name;
			$query .= implode( ',', $drop );
			$wpdb->query( $query );
		}
	}
}

/**
 * Activation plugin function
 */
if ( ! function_exists( 'cptchpls_plugin_activate' ) ) {
	function cptchpls_plugin_activate( $networkwide ) {
		global $wpdb;
		/* Activation function for network, check if it is a network activation - if so, run the activation function for each blog id */
		if ( function_exists( 'is_multisite' ) && is_multisite() && $networkwide ) {
			$old_blog = $wpdb->blogid;
			/* Get all blog ids */
			$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
			foreach ( $blogids as $blog_id ) {
				switch_to_blog( $blog_id );
				cptchpls_settings();
				cptchpls_create_table();
			}
			switch_to_blog( $old_blog );
			return;
		}
		cptchpls_settings();
		cptchpls_create_table();
		if ( ! class_exists( 'Cptchpls_package_loader' ) ) 
			require_once( dirname( __FILE__ ) . '/includes/package_loader.php' );
		$package_loader = new Cptchpls_package_loader();
		$package_loader->parse_packages( dirname( __FILE__ ) . '/images/package' );
	}
}

/* Register settings function */
if ( ! function_exists( 'cptchpls_settings' ) ) {
	function cptchpls_settings() {
		global $cptchpls_options, $cptchpls_plugin_info, $cptchpls_option_defaults, $wpdb;
		$db_version = '1.2';

		$cptchpls_option_defaults = array(
			'plugin_option_version' 			=> $cptchpls_plugin_info["Version"],
			'plugin_db_version'					=> $db_version,
			'cptchpls_str_key'					=> array( 'time' => '', 'key' => '' ),
			'cptchpls_login_form'				=> '1',
			'cptchpls_register_form'			=> '1',
			'cptchpls_lost_password_form'		=> '1',
			'cptchpls_comments_form'			=> '1',
			'cptchpls_hide_register'			=> '1',
			'cptchpls_contact_form'				=> '0',
			'cptchpls_math_action_plus'			=> '1',
			'cptchpls_math_action_minus'		=> '1',
			'cptchpls_math_action_increase'		=> '1',
			'cptchpls_label_form'				=> '',
			'cptchpls_required_symbol'			=> '*',
			'cptchpls_error_empty_value'		=> __( 'Please enter a CAPTCHA value.', 'captcha-plus' ),
			'cptchpls_error_incorrect_value'	=> __( 'Please enter a valid CAPTCHA value.', 'captcha-plus' ),
			'cptchpls_error_time_limit'			=> __( 'Time limit is exhausted. Please enter CAPTCHA value again.', 'captcha-plus' ),
			'cptchpls_difficulty_number'		=> '1',
			'cptchpls_difficulty_word'			=> '1',
			'cptchpls_difficulty_image'			=> '0',
			'cptchpls_cf7'						=> '0',
			'display_settings_notice'			=> 1,
			'display_notice_about_images'		=> 1,
			'whitelist_message'					=> __( 'You are in the white list', 'captcha-plus' ),
			'use_limit_attempts_whitelist'		=> 0,
			'display_reload_button'				=> 1,
			'used_packages'						=> array(),
			'enlarge_images'					=> 0,
			'whitelist_is_empty'				=> true,
			'use_time_limit'					=> 0,
			'time_limit'						=> 120,
			'suggest_feature_banner'			=>	1,
		);

		/* Install the option defaults */
		if ( ! get_option( 'cptchpls_options' ) ) {
			if ( get_option( 'cptch_options' ) ) {
				$cptch_options = get_option( 'cptch_options' );
				foreach ( $cptchpls_option_defaults as $key => $value ) {
					$option = str_replace( 'cptchpls_', '', $key );
					if ( isset( $cptch_options['cptch_' . $option ] ) )
						$cptchpls_option_defaults[ $key ] = $cptch_options['cptch_' . $option ];
					elseif ( isset( $cptch_options[ $option ] ) )
						$cptchpls_option_defaults[ $key ] = $cptch_options[ $option ];
				}
			}
			add_option( 'cptchpls_options', $cptchpls_option_defaults );
		}	

		/* Get options from the database */
		$cptchpls_options = get_option( 'cptchpls_options' );

		/* Array merge incase this version has added new options */
		if ( ! isset( $cptchpls_options['plugin_option_version'] ) || $cptchpls_options['plugin_option_version'] != $cptchpls_plugin_info["Version"] ) {

			$cptchpls_option_defaults['display_settings_notice'] = 0;
			$cptchpls_option_defaults['display_notice_about_images'] = 0;
			if ( ! isset( $cptchpls_option_defaults['cptchpls_difficulty_image'] ) )
				$cptchpls_option_defaults['cptchpls_difficulty_image'] = 0;
			$cptchpls_options = array_merge( $cptchpls_option_defaults, $cptchpls_options );
			$cptchpls_options['plugin_option_version'] = $cptchpls_plugin_info["Version"];
			$update_option = true;
		}	
		/* Update tables when update plugin and tables changes*/
		if ( ! isset( $cptchpls_options['plugin_db_version'] ) || $cptchpls_options['plugin_db_version'] != $db_version ) {
			cptchpls_create_table();
			if ( ! class_exists( 'Cptchpls_package_loader' ) ) 
				require_once( dirname( __FILE__ ) . '/includes/package_loader.php' );
			$package_loader = new Cptchpls_package_loader();
			$package_loader->parse_packages( dirname( __FILE__ ) . '/images/package' );
			if ( ! is_null( $wpdb->get_var( "SELECT `id` FROM `{$wpdb->prefix}cptch_whitelist` LIMIT 1" ) ) )
				$cptchpls_options['whitelist_is_empty'] = false;
			/* update DB version */
			$cptchpls_options['plugin_db_version'] = $db_version;
			$update_option = true;
		}
		if ( isset( $update_option ) )
			update_option( 'cptchpls_options', $cptchpls_options );
	}
}

/* Generate key */
if ( ! function_exists( 'cptchpls_generate_key' ) ) {
	function cptchpls_generate_key( $lenght = 15 ) {
		global $cptchpls_options;
		/* Under the string $simbols you write all the characters you want to be used to randomly generate the code. */
		$simbols = get_bloginfo( "url" ) . time();
		$simbols_lenght = strlen( $simbols );
		$simbols_lenght--;
		$str_key = NULL;
		for ( $x = 1; $x <= $lenght; $x++ ) {
			$position = rand( 0, $simbols_lenght );
			$str_key .= substr( $simbols, $position, 1 );
		}

		$cptchpls_options['cptchpls_str_key']['key']	= md5( $str_key );
		$cptchpls_options['cptchpls_str_key']['time']	= time();
		update_option( 'cptchpls_options', $cptchpls_options );
	}
}

if ( ! function_exists( 'cptchpls_whitelisted_ip' ) ) {
	function cptchpls_whitelisted_ip() {
		global $cptchpls_options, $wpdb;
		$checked = false;
		if ( empty( $cptchpls_options ) )
			$cptchpls_options = get_option( 'cptchpls_options' );
		$table = 1 == $cptchpls_options['use_limit_attempts_whitelist'] ? 'lmtttmpts_whitelist' : 'cptch_whitelist';
		if ( 'lmtttmpts_whitelist' == $table || ( 'cptch_whitelist' == $table && ! $cptchpls_options['whitelist_is_empty'] ) ) {
			$whitelist_exist = $wpdb->query( "SHOW TABLES LIKE '{$wpdb->prefix}{$table}'" );
			if ( ! empty( $whitelist_exist ) ) {
				$ip = '';
				if ( isset( $_SERVER ) ) {
					$sever_vars = array( 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' );
					foreach( $sever_vars as $var ) {
						if ( isset( $_SERVER[ $var ] ) && ! empty( $_SERVER[ $var ] ) ) {
							if ( filter_var( $_SERVER[ $var ], FILTER_VALIDATE_IP ) ) {
								$ip = $_SERVER[ $var ];
								break;
							} else { /* if proxy */
								$ip_array = explode( ',', $_SERVER[ $var ] );
								if ( is_array( $ip_array ) && ! empty( $ip_array ) && filter_var( $ip_array[0], FILTER_VALIDATE_IP ) ) {
									$ip = $ip_array[0];
									break;
								}
							}
						}
					}
				}
				if ( ! empty( $ip ) ) {
					$ip_int = sprintf( '%u', ip2long( $ip ) );
					$result = $wpdb->get_var( 
						"SELECT `id` 
						FROM `{$wpdb->prefix}{$table}` 
						WHERE ( `ip_from_int` <= {$ip_int} AND `ip_to_int` >= {$ip_int} ) OR `ip` LIKE '{$ip}' LIMIT 1;" 
					);
					$checked = is_null( $result ) || ! $result ? false : true;
				}
			}
		}
		return $checked;
	}
}

/* Function for display captcha settings page in the admin area */
if ( ! function_exists( 'cptchpls_settings_page' ) ) {
	function cptchpls_settings_page() {
		global $cptchpls_options, $wp_version, $cptchpls_plugin_info, $cptchpls_option_defaults, $wpdb;
		$error = $message = "";

		$plugin_basename =  plugin_basename( __FILE__ );
		/* These fields for the 'Enable CAPTCHA on the' block which is located at the admin setting captcha page */
		$cptchpls_admin_fields_enable = array (
			array( 'cptchpls_login_form', __( 'Login form', 'captcha-plus' ), 'login_form.jpg' ),
			array( 'cptchpls_register_form', __( 'Registration form', 'captcha-plus' ), 'register_form.jpg' ),
			array( 'cptchpls_lost_password_form', __( 'Reset Password form', 'captcha-plus' ), 'lost_password_form.jpg' ),
			array( 'cptchpls_comments_form', __( 'Comments form', 'captcha-plus' ), 'comment_form.jpg' ),
		);
		$cptchpls_admin_fields_hide = array(
			array( 'cptchpls_hide_register', __( 'in Comments form for registered users', 'captcha-plus' ) ),
		);

		/* These fields for the 'Arithmetic actions for CAPTCHA' block which is located at the admin setting captcha page */
		$cptchpls_admin_fields_actions = array (
			array( 'cptchpls_math_action_plus', __( 'Plus (&#43;)', 'captcha-plus' ), __( 'Plus', 'captcha-plus' ) ),
			array( 'cptchpls_math_action_minus', __( 'Minus (&minus;)', 'captcha-plus' ), __( 'Minus', 'captcha-plus' ) ),
			array( 'cptchpls_math_action_increase', __( 'Multiplication (&times;)', 'captcha-plus' ), __( 'Multiply', 'captcha-plus' ) ),
		);

		/* This fields for the 'Difficulty for CAPTCHA' block which is located at the admin setting captcha page */
		$cptchpls_admin_fields_difficulty = array (
			array( 'cptchpls_difficulty_number', __( 'Numbers', 'captcha-plus' ) ),
			array( 'cptchpls_difficulty_word',   __( 'Words', 'captcha-plus' )   ),
			array( 'cptchpls_difficulty_image',  __( 'Images', 'captcha-plus' )  )
		);

		if ( isset( $_GET['action'] ) && 'advanced' == $_GET['action'] )
			$package_list = $wpdb->get_results( "SELECT `id`, `name` FROM `{$wpdb->base_prefix}cptch_packages` ORDER BY `name` ASC;" );

		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$all_plugins = get_plugins();
		$is_network  = is_multisite() && is_network_admin();
		$admin_url   = $is_network ? network_admin_url( '/' ) : admin_url( '/' );
		$bws_contact_form = cptchpls_plugin_status( array( 'contact-form-plugin/contact_form.php', 'contact-form-pro/contact_form_pro.php' ), $all_plugins, $is_network );
		$cf7_status       = cptchpls_plugin_status( 'contact-form-7/wp-contact-form-7.php', $all_plugins, $is_network );
	
		/* Save data for settings page */
		if ( isset( $_REQUEST['cptchpls_form_submit'] ) && check_admin_referer( $plugin_basename, 'cptchpls_nonce_name' ) ) {
			
			if ( ! isset( $_GET['action'] ) ) {
				/*Check option to display captcha for Contact Form 7 is enabled or disabled.*/
				if ( $cptchpls_options['cptchpls_cf7'] == 0 && isset( $_REQUEST['cptchpls_cf7'] ) )
					$cptchpls_cf7 = true;
				
				$cptchpls_options['cptchpls_login_form']			=	isset( $_REQUEST['cptchpls_login_form'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_register_form']			=	isset( $_REQUEST['cptchpls_register_form'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_lost_password_form']	=	isset( $_REQUEST['cptchpls_lost_password_form'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_comments_form'] 		=	isset( $_REQUEST['cptchpls_comments_form'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_contact_form'] 			=	isset( $_REQUEST['cptchpls_contact_form'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_cf7'] 					=	isset( $_REQUEST['cptchpls_cf7'] ) ? 1 : 0;

				$cptchpls_options['cptchpls_hide_register'] 		=	isset( $_REQUEST['cptchpls_hide_register'] ) ? 1 : 0;

				$cptchpls_options['cptchpls_label_form'] 			=	isset( $_REQUEST['cptchpls_label_form'] ) ? stripslashes( esc_html( $_REQUEST['cptchpls_label_form'] ) ) : '';
				$cptchpls_options['cptchpls_required_symbol'] 		=	isset( $_REQUEST['cptchpls_required_symbol'] ) ? stripslashes( esc_html( $_REQUEST['cptchpls_required_symbol'] ) ) : '';
				$cptchpls_options['display_reload_button']			=	isset( $_REQUEST['cptchpls_display_reload_button'] ) ? 1 : 0;

				$cptchpls_options['cptchpls_math_action_plus']		=	isset( $_REQUEST['cptchpls_math_action_plus'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_math_action_minus'] 	=	isset( $_REQUEST['cptchpls_math_action_minus'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_math_action_increase']	=	isset( $_REQUEST['cptchpls_math_action_increase'] ) ? 1 : 0;

				$cptchpls_options['cptchpls_difficulty_number']		=	isset( $_REQUEST['cptchpls_difficulty_number'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_difficulty_word'] 		=	isset( $_REQUEST['cptchpls_difficulty_word'] ) ? 1 : 0;
				$cptchpls_options['cptchpls_difficulty_image'] 		=	isset( $_REQUEST['cptchpls_difficulty_image'] ) ? 1 : 0;

				if ( 1 == $cptchpls_options['cptchpls_difficulty_image'] ) {
					$package_list = $wpdb->get_results( "SELECT `id`, `name` FROM `{$wpdb->base_prefix}cptch_packages` ORDER BY `name` ASC LIMIT 1;" ); 

					if ( empty( $package_list ) ) {
						if ( ! class_exists( 'Cptchpls_package_loader' ) ) 
							require_once( dirname( __FILE__ ) . '/includes/package_loader.php' );
						$package_loader = new Cptchpls_package_loader();
						$package_loader->parse_packages( dirname( __FILE__ ) . '/images/package' );
					}
				}

				/* Check select one point in the blocks Arithmetic actions and Difficulty on settings page */
				$arithmetic_actions = isset( $_REQUEST['cptchpls_math_action_plus'] ) || isset( $_REQUEST['cptchpls_math_action_minus'] ) || isset( $_REQUEST['cptchpls_math_action_increase'] ) ? true : false;
				$complexity_level = isset( $_REQUEST['cptchpls_difficulty_number'] ) || isset( $_REQUEST['cptchpls_difficulty_word'] ) || isset( $_REQUEST['cptchpls_difficulty_image'] ) ? true : false;
				/* if 'Arithmetic actions'- or 'Complexity level'- options are disabled */
				if ( ! $arithmetic_actions || ! $complexity_level )
					$error = __( "Please select one item in the block Arithmetic and Complexity for CAPTCHA", 'captcha-plus' );
			} else {

				$cptchpls_options['used_packages']					= isset( $_REQUEST['cptchpls_used_packages'] ) ? $_REQUEST['cptchpls_used_packages'] : array();

				if ( ! empty( $package_list ) && empty( $cptchpls_options['used_packages'] ) && 1 == $cptchpls_options['cptchpls_difficulty_image'] )
					$error = __( "Please select one item in the block Enable image packages", 'captcha-plus' );

				$cptchpls_options['enlarge_images']					=	isset( $_REQUEST['cptchpls_enlarge_images'] ) ? 1 : 0;
				$cptchpls_options['use_time_limit'] 				=	isset( $_REQUEST['cptchpls_use_time_limit'] ) ? 1 : 0;
				$cptchpls_options['time_limit']						= 
						! isset( $_REQUEST['cptchpls_time_limit'] ) ||
						! is_numeric( $_REQUEST['cptchpls_time_limit'] ) || 
						10 > $_REQUEST['cptchpls_time_limit'] 
					? 
						120 
					: 
						$_REQUEST['cptchpls_time_limit'];

				$cptchpls_options['cptchpls_error_empty_value']		= isset( $_REQUEST['cptchpls_error_empty_value'] ) ? stripslashes( esc_html( $_REQUEST['cptchpls_error_empty_value'] ) ) : '';
				$cptchpls_options['cptchpls_error_incorrect_value']	= isset( $_REQUEST['cptchpls_error_incorrect_value'] ) ? stripslashes( esc_html( $_REQUEST['cptchpls_error_incorrect_value'] ) ) : '';
				$cptchpls_options['whitelist_message'] 				= isset( $_REQUEST['cptchpls_whitelist_message'] ) ? stripslashes( esc_html( $_REQUEST['cptchpls_whitelist_message'] ) ) : '';
				$cptchpls_options['cptchpls_error_time_limit']		= isset( $_REQUEST['cptchpls_error_time_limit'] ) ? stripslashes( esc_html( $_REQUEST['cptchpls_error_time_limit'] ) ) : '';

				if ( $cptchpls_options['cptchpls_error_empty_value'] == '' )
					$cptchpls_options['cptchpls_error_empty_value'] = $cptchpls_option_defaults['cptchpls_error_empty_value'];
				if ( $cptchpls_options['cptchpls_error_incorrect_value'] == '' )
					$cptchpls_options['cptchpls_error_incorrect_value'] = $cptchpls_option_defaults['cptchpls_error_incorrect_value'];
				if ( $cptchpls_options['whitelist_message'] == '' )
					$cptchpls_options['whitelist_message'] = $cptchpls_option_defaults['whitelist_message'];
				if ( $cptchpls_options['cptchpls_error_time_limit'] == '' )
					$cptchpls_options['cptchpls_error_time_limit'] = $cptchpls_option_defaults['cptchpls_error_time_limit'];
			}
			
			if ( empty( $error ) ) {
				/* Update options in the database */
				update_option( 'cptchpls_options', $cptchpls_options );
				$message = __( "Settings saved.", 'captcha-plus' );
			}			
		}

		if ( ! class_exists( 'Cptchpls_package_loader' ) ) 
			require_once( dirname( __FILE__ ) . '/includes/package_loader.php' );
		$package_loader = new Cptchpls_package_loader();
		$error .= $package_loader->error;		

		if ( isset( $_REQUEST['bws_restore_confirm'] ) && check_admin_referer( $plugin_basename, 'bws_settings_nonce_name' ) ) {
			$cptchpls_options = $cptchpls_option_defaults;
			update_option( 'cptchpls_options', $cptchpls_options );
			$message = __( 'All plugin settings were restored.', 'captcha-plus' );
		}
		/* Display form on the setting page */ ?>
		<div class="wrap">
			<h1><?php _e( 'Captcha Plus Settings', 'captcha-plus' ); ?></h1>
			<ul class="subsubsub cptchpls_how_to_use">
				<li><a href="https://docs.google.com/document/d/11_TUSAjMjG7hLa53lmyTZ1xox03hNlEA4tRmllFep3I/edit" target="_blank"><?php _e( 'How to Use Step-by-step Instruction', 'captcha-plus' ); ?></a></li>
			</ul>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if ( ! isset( $_GET['action'] ) ) echo ' nav-tab-active'; ?>"  href="admin.php?page=captcha-plus.php"><?php _e( 'Basic', 'captcha-plus' ); ?></a>
				<a class="nav-tab<?php if ( isset( $_GET['action'] ) && 'advanced' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=captcha-plus.php&amp;action=advanced"><?php _e( 'Advanced', 'captcha-plus' ); ?></a>
				<a class="nav-tab <?php if ( isset( $_GET['action'] ) && 'whitelist' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=captcha-plus.php&amp;action=whitelist"><?php _e( 'Whitelist', 'captcha-plus' ); ?></a>
				<a class="nav-tab <?php if ( isset( $_GET['action'] ) && 'custom_code' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=captcha-plus.php&amp;action=custom_code"><?php _e( 'Custom code', 'captcha-plus' ); ?></a> 
			</h2>
			<?php if ( "" == $error && isset( $cptchpls_cf7 ) ) { /* Add notice when option to display captcha for Contact Form 7 is enabled */ ?>
				<div id="cptchpls_cf7_notice" class="updated fade below-h2"><p><strong><?php _e( "Notice:", 'captcha-plus' ); ?></strong> <?php _e( "Option to display captcha for Contact Form 7 is enabled. For correct work, please, dont forget to add the BWS CAPTCHA block to Contact Form 7 to the needed form (see", 'captcha-plus' ); ?>  <a href="http://bestwebsoft.com/products/captcha/faq/" target="_blank">FAQ</a>)</p></div> 
			<?php } ?>
			<div class="updated fade below-h2" <?php if ( '' == $message || "" != $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error below-h2" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<?php if ( ! isset( $_GET['action'] ) || ! in_array( $_GET['action'], array( 'whitelist', 'custom_code' ) ) ) { 
				if ( isset( $_REQUEST['bws_restore_default'] ) && check_admin_referer( $plugin_basename, 'bws_settings_nonce_name' ) ) {
					bws_form_restore_default_confirm( $plugin_basename );
				} else { 
					bws_show_settings_notice(); ?>
					<form class="bws_form" method="post" action="">
						<table class="form-table">
							<?php if ( ! isset( $_GET['action'] ) ) { ?>
								<tr valign="top">
									<th scope="row"><?php _e( 'Enable CAPTCHA for', 'captcha-plus' ); ?>:</th>
									<td>
										<fieldset>
											<legend class="screen-reader-text"><span><?php _e( 'Enable CAPTCHA for', 'captcha-plus' ); ?>:</span></legend>
											<p><i><?php _e( 'WordPress default', 'captcha-plus' ); ?></i></p>
											<?php foreach ( $cptchpls_admin_fields_enable as $fields ) { 
												if ( 
													in_array( $fields[0], array( 'cptchpls_register_form', 'cptchpls_lost_password_form' ) ) && 
													! in_array( get_current_blog_id(), array( 0, 1 ) ) 
												) {
													$notice = '<br /><span class="bws_info">' . __( 'This option is available only for main blog', 'captcha-plus' ) . '</span>';
													$disable_reg_form = ' disabled="disabled"';
													$checked = '';
												} else {
													$notice = $disable_reg_form = '';
													$checked = 1 == $cptchpls_options[ $fields[0] ] ? ' checked="checked"' : '';
												} ?>
												<label><input type="checkbox" name="<?php echo $fields[0]; ?>" value="1" <?php echo  $disable_reg_form . $checked; ?> /> <?php echo $fields[1]; ?></label>
												<div class="bws_help_box dashicons dashicons-editor-help cptchpls_thumb_block">
													<div class="bws_hidden_help_text">
														<img src="<?php echo plugins_url( 'captcha-plus/images') . '/' . $fields[2]; ?>" title="<?php echo $fields[1]; ?>" alt="<?php echo $fields[1]; ?>"/>
													</div>
												</div>
												<?php echo $notice; ?>
												<br />
											<?php } ?>
											<br />
											<p><i><?php _e( 'Plugins', 'captcha-plus' ); ?></i></p>
											<?php if ( 'actived' == $bws_contact_form['status'] ) {
												$disabled_attr = $info = '';
											} elseif ( 'deactivated' == $bws_contact_form['status'] ) { 
												$disabled_attr = "disabled='disabled'";
												$info = 
													'<span class="bws_info">' . 
														__( 'You should', 'captcha-plus' ) . '&nbsp;<a href="' . $admin_url . 'plugins.php">' . __( 'activate', 'captcha-plus' ) . '&nbsp;Contact Form&nbsp;' . ( is_network_admin() ? __( 'for network', 'captcha-plus' ) : '' ) . '</a>' . '&nbsp;' . __( 'to use this functionality', 'captcha-plus' ) . 
													'</span>';
											} elseif ( 'not_installed' == $bws_contact_form['status'] ) { 
												$disabled_attr = "disabled='disabled'";
												$info = 
													'<span class="bws_info">' . 
														__( 'You should', 'captcha-plus' ) . 
														'&nbsp;<a href="http://bestwebsoft.com/products/contact-form/?k=9ab9d358ad3a23b8a99a8328595ede2e&pn=72&v=' . $cptchpls_plugin_info["Version"] . '&wp_v=' . $wp_version . '" target="_blank">' . __( 'download', 'captcha-plus' ) . '&nbsp;Contact Form&nbsp;</a>' . 
														'&nbsp;' . __( 'to use this functionality', 'captcha-plus' ) . 
													'</span>';
											} ?>
											<label><input <?php echo $disabled_attr; ?> type="checkbox" name="cptchpls_contact_form" value="1" <?php if ( 1 == $cptchpls_options['cptchpls_contact_form'] ) echo 'checked="checked"'; ?> /> Contact Form by BestWebSoft</label> 
											<div class="bws_help_box dashicons dashicons-editor-help cptchpls_thumb_block">
												<div class="bws_hidden_help_text">
													<img src="<?php echo plugins_url( 'captcha-plus/images/contact_form.jpg' ); ?>" title="Contact Form" alt="Contact Form"/>
												</div>
											</div>
											<?php echo $info; ?>
											<br />
											<?php /* contact form 7 */
											if ( 'actived' == $cf7_status['status'] ) {
												if ( $cf7_status['plugin_info']['Version'] < '3.4' ) {
													$disabled_attr = 'disabled="disabled"';
													$info = $info = 
														'<span class="bws_info">' . 
															__( 'You should', 'captcha-plus' ) . '&nbsp;<a href="' . $admin_url . 'plugins.php">' . __( 'update', 'captcha-plus' ) . '&nbsp;Contact Form 7&nbsp;</a>' . '&nbsp;' . __( 'at least up to v3.4 to use this functionality', 'captcha-plus' ) . 
														'</span>';
												} else {
													$disabled_attr = $info = '';
												}
											} elseif ( 'deactivated' == $cf7_status['status'] ) {
												$disabled_attr = "disabled='disabled'";
												$info = 
													'<span class="bws_info">' . 
														__( 'You should', 'captcha-plus' ) . '&nbsp;<a href="' . $admin_url . 'plugins.php">' . __( 'activate', 'captcha-plus' ) . '&nbsp;Contact Form 7&nbsp;' . ( is_network_admin() ? __( 'for network', 'captcha-plus' ) : '' ) . '</a>' . '&nbsp;' . __( 'to use this functionality', 'captcha-plus' ) . 
													'</span>';
											} elseif ( 'not_installed' == $cf7_status['status'] ) {
												$disabled_attr = "disabled='disabled'";
												$info = 
													'<span class="bws_info">' . 
														__( 'You should', 'captcha-plus' ) . '&nbsp;<a href="http://wordpress.org/plugins/contact-form-7/" target="_blank">' . __( 'download', 'captcha-plus' ) . '&nbsp;Contact Form 7&nbsp;</a>' . '&nbsp;' . __( 'to use this functionality', 'captcha-plus' ) . 
													'</span>';
											} ?>
											<label><input <?php echo $disabled_attr; ?> type="checkbox" name="cptchpls_cf7" value="1" <?php if ( 1 == $cptchpls_options['cptchpls_cf7'] ) echo 'checked="checked"'; ?> /> Contact Form 7</label>
											<div class="bws_help_box dashicons dashicons-editor-help cptchpls_thumb_block">
												<div class="bws_hidden_help_text">
													<img src="<?php echo plugins_url( 'captcha-plus/images/contact_form.jpg' ); ?>" title="Contact Form" alt="Contact Form" />
												</div>
											</div>
											<?php echo $info .
											apply_filters( 'cptchpls_forms_list', '' ); ?>
											<br/><span class="bws_info"><?php _e( 'If you would like to add Captcha to a custom form, please see', 'captcha-plus' ); ?> <a href="http://bestwebsoft.com/products/captcha/faq" target="_blank">FAQ</a></span>
										</fieldset>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( 'Hide CAPTCHA', 'captcha-plus' ); ?></th>
									<td><?php foreach ( $cptchpls_admin_fields_hide as $fields ) { ?>
											<label><input type="checkbox" name="<?php echo $fields[0]; ?>" value="1" <?php if ( 1 == $cptchpls_options[ $fields[0] ] ) echo "checked=\"checked\""; ?> /> <?php echo $fields[1]; ?></label><br />
										<?php } ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( 'Title', 'captcha-plus' ); ?></th>
									<td><input class="cptchpls_settings_input" type="text" name="cptchpls_label_form" value="<?php echo $cptchpls_options['cptchpls_label_form']; ?>" maxlength="100" /></td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( "Required symbol", 'captcha-plus' ); ?></th>
									<td colspan="2">
										<input class="cptchpls_settings_input" type="text" name="cptchpls_required_symbol" value="<?php echo $cptchpls_options['cptchpls_required_symbol']; ?>" maxlength="100" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( 'Show "Reload" button', 'captcha-plus' ); ?></th>
									<td>
										<input type="checkbox" name="cptchpls_display_reload_button" value="1" <?php if ( 1 == $cptchpls_options['display_reload_button'] ) echo 'checked="checked"'; ?> />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( 'Arithmetic actions', 'captcha-plus' ); ?></th>
									<td colspan="2">
										<fieldset>
											<legend class="screen-reader-text"><span><?php _e( 'Arithmetic actions', 'captcha-plus' ); ?></span></legend>
											<?php foreach ( $cptchpls_admin_fields_actions as $actions ) { ?>
												<label><input type="checkbox" name="<?php echo $actions[0]; ?>" value="1" <?php if ( 1 == $cptchpls_options[$actions[0]] ) echo "checked=\"checked\""; ?> /> <?php echo $actions[1]; ?></label>
												<div class="bws_help_box dashicons dashicons-editor-help">
													<div class="bws_hidden_help_text"><?php cptchpls_display_example( $actions[0] ); ?></div>
												</div>				
												<br />
											<?php } ?>
										</fieldset>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( 'Complexity', 'captcha-plus' ); ?></th>
									<td colspan="2">
										<fieldset>
											<legend class="screen-reader-text"><span><?php _e( 'Complexity', 'captcha-plus' ); ?></span></legend>
											<?php foreach ( $cptchpls_admin_fields_difficulty as $diff ) {  ?>
												<label><input type="checkbox" name="<?php echo $diff[0]; ?>" value="1" <?php if ( 1 == $cptchpls_options[$diff[0]] ) echo "checked=\"checked\""; ?> /> <?php echo $diff[1]; ?></label>
												<div class="bws_help_box dashicons dashicons-editor-help">
													<div class="bws_hidden_help_text"><?php cptchpls_display_example( $diff[0] ); ?></div>
												</div>
												<br />
											<?php } ?>
										</fieldset>
									</td>
								</tr>
							<?php } else {
								if ( ! empty( $package_list ) ) { ?>
									<tr class="cptchpls_packages">
										<th scope="row"><?php _e( 'Enable image packages', 'captcha-plus' ); ?></th>
										<td>
											<select name="cptchpls_used_packages[]" multiple="multiple">
												<?php foreach( $package_list as $pack ) { ?>
													<option value="<?php echo $pack->id; ?>"<?php if ( in_array( $pack->id, $cptchpls_options['used_packages'] ) ) echo ' selected="selected"'; ?>><?php echo $pack->name; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr class="cptchpls_packages">
										<th scope="row"><?php _e( 'Enlarge images on mouseover', 'captcha-plus' ); ?></th>
										<td>
											<input type="checkbox" name="cptchpls_enlarge_images" value="1"<?php if ( 1 == $cptchpls_options['enlarge_images'] ) echo ' checked="checked"'; ?> /><br/>
										</td>
									</tr>
								<?php } ?>
								<tr valign="top">
									<th scope="row"><?php _e( 'Enable time limit', 'captcha-plus' ); ?></th>
									<td>
										<input type="checkbox" name="cptchpls_use_time_limit" value="1"<?php if ( 1 == $cptchpls_options['use_time_limit'] ) echo ' checked="checked"'; ?> />
									</td>
								</tr>
								<tr valign="top" class="cptchpls_limt_options"<?php if ( 0 == $cptchpls_options['use_time_limit'] ) echo ' style="display: none;"'; ?>>
									<th scope="row"><?php _e( 'Set time limit', 'captcha-plus' ); ?></th>
									<td>
										<label for="cptchpls_time_limit">
											<input type="number" name="cptchpls_time_limit" id ="cptchpls_time_limit" min="10" max="9999" step="1" value="<?php echo $cptchpls_options['time_limit']; ?>" style="width: 70px;"/>&nbsp;<?php _e( 'seconds', 'captcha-plus' ); ?>

										</label>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><?php _e( "Notification messages", 'captcha-plus' ); ?></th>
									<td colspan="2">
										<p><i><?php _e( "Error", 'captcha-plus' ); ?></i></p>
										<p><input class="cptchpls_settings_input" type="text" name="cptchpls_error_empty_value" value="<?php echo $cptchpls_options['cptchpls_error_empty_value']; ?>" maxlength="100" />&nbsp;<?php _e( 'If CAPTCHA field is empty', 'captcha-plus' ); ?></p>
										<p><input class="cptchpls_settings_input" type="text" name="cptchpls_error_incorrect_value" value="<?php echo $cptchpls_options['cptchpls_error_incorrect_value']; ?>" maxlength="100" />&nbsp;<?php _e( 'If CAPTCHA is incorrect', 'captcha-plus' ); ?></p>
										<p><input class="cptchpls_settings_input" type="text" name="cptchpls_error_time_limit" value="<?php echo $cptchpls_options['cptchpls_error_time_limit']; ?>" maxlength="100" />&nbsp;<?php _e( 'If time limit is exhausted', 'captcha-plus' ); ?></p>
										<p><i><?php _e( "Info", 'captcha-plus' ); ?></i></p>
										<p><input class="cptchpls_settings_input" type="text" name="cptchpls_whitelist_message" value="<?php echo $cptchpls_options['whitelist_message']; ?>" maxlength="100"  />&nbsp;<?php _e( 'If the user IP is added to the whitelist (this message will be displayed instead of CAPTCHA).', 'captcha-plus' ); ?></p>
									</td>
								</tr>
							<?php } ?>
						</table>
						<input type="hidden" name="cptchpls_form_submit" value="submit" />
						<p class="submit">
							<input id="bws-submit-button" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'captcha-plus' ) ?>" />
						</p>
						<?php wp_nonce_field( $plugin_basename, 'cptchpls_nonce_name' ); ?>
					</form>
					<?php bws_form_restore_default_settings( $plugin_basename );
				}
			} elseif ( 'custom_code' == $_GET['action'] ) {
				bws_custom_code_tab();			
			} elseif ( 'whitelist' == $_GET['action'] ) {
				$limit_attempts_info = cptchpls_plugin_status( array( 'limit-attempts/limit-attempts.php', 'limit-attempts-pro/limit-attempts-pro.php' ), $all_plugins, $is_network );
				require_once( dirname( __FILE__ ) . '/includes/whitelist.php' );
				$cptchpls_whitelist = new Cptchpls_Whitelist( $plugin_basename, $limit_attempts_info );
				$cptchpls_whitelist->display_content();
			} ?>
		</div>
	<?php } 
}

if ( ! function_exists( 'cptchpls_plugin_status' ) ) {
	function cptchpls_plugin_status( $plugins, $all_plugins, $is_network ) {
		$result = array(
			'status'      => '',
			'plugin'      => '',
			'plugin_info' => array(),
		);
		foreach ( (array)$plugins as $plugin ) {
			if ( array_key_exists( $plugin, $all_plugins ) ) {
				if ( 
					( $is_network && is_plugin_active_for_network( $plugin ) ) || 
					( ! $is_network && is_plugin_active( $plugin ) ) 
				) {
					$result['status']      = 'actived';
					$result['plugin']      = $plugin;
					$result['plugin_info'] = $all_plugins[$plugin];
					break;
				} else {
					$result['status']      = 'deactivated';
					$result['plugin']      = $plugin;
					$result['plugin_info'] = $all_plugins[$plugin];
				}

			}
		}
		if ( empty( $result['status'] ) )
			$result['status'] = 'not_installed';
		return $result; 
	}
}

if ( ! function_exists( 'cptchpls_version_check' )) {
	function cptchpls_version_check( $plugin, $all_plugins ) {
			switch ( $plugin ) {
				case 'contact-form-plugin/contact_form.php': 
					$min_version = '3.95';
					break;
				case 'contact-form-pro/contact_form_pro.php':
					$min_version = '2.0.6';
					break;
				default:
					$min_version = false;
					break;
			}
		return $min_version ? version_compare( $all_plugins[ $plugin ]['Version'], $min_version, '>' ) : false;
	}
}

/* This function adds captcha to the login form */
if ( ! function_exists( 'cptchpls_login_form' ) ) {
	function cptchpls_login_form() {
		global $cptchpls_options, $cptchpls_ip_in_whitelist;
		if ( ! $cptchpls_ip_in_whitelist ) {
			if ( "" == session_id() )
			@session_start();		

			if ( isset( $_SESSION["cptchpls_login"] ) ) 
				unset( $_SESSION["cptchpls_login"] );
		}

		echo '<p class="cptchpls_block">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )	
			echo '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] . '<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';
		if ( isset( $_SESSION['cptchpls_error'] ) ) {
			echo "<br /><span style='color:red'>" . $_SESSION['cptchpls_error'] . "</span><br />";
			unset( $_SESSION['cptchpls_error'] );
		}
		if ( ! $cptchpls_ip_in_whitelist )
			echo cptchpls_display_captcha();
		else
			echo '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';
		echo '</p><br />';
		return true;
	}
}
/* End function cptchpls_login_form */

/* This function checks the captcha posted with a login when login errors are absent */
if ( ! function_exists( 'cptchpls_login_check' ) ) {
	function cptchpls_login_check( $user ) {
		global $cptchpls_options;
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];

		if ( ! function_exists( 'is_plugin_active' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( "" == session_id() )
			@session_start();

		if ( isset( $_SESSION["cptchpls_login"] ) && true === $_SESSION["cptchpls_login"] )
			return $user;

		/* Delete errors, if they set */
		if ( isset( $_SESSION['cptchpls_error'] ) )
			unset( $_SESSION['cptchpls_error'] );

		if ( is_plugin_active( 'limit-login-attempts/limit-login-attempts.php' ) ) {
			if ( isset( $_REQUEST['loggedout'] ) && isset( $_REQUEST['cptchpls_number'] ) && "" ==  $_REQUEST['cptchpls_number'] ) {
				return $user;
			}	
		}		

		if ( cptchpls_limit_exhausted() ) {
			$_SESSION['cptchpls_login'] = false;
			$error = new WP_Error();
			$error->add( 'cptchpls_error', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>:' . '&nbsp;' . $cptchpls_options['cptchpls_error_time_limit'] );
			return $error;
		}
		/* Add error if captcha is empty */			
		if ( ( ! isset( $_REQUEST['cptchpls_number'] ) || "" ==  $_REQUEST['cptchpls_number'] ) && isset( $_REQUEST['loggedout'] ) ) {
			$error = new WP_Error();
			$error->add( 'cptchpls_error', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $cptchpls_options['cptchpls_error_empty_value'] );
			wp_clear_auth_cookie();
			return $error;
		}
		if ( isset( $_REQUEST['cptchpls_result'] ) && isset( $_REQUEST['cptchpls_number'] ) && isset( $_REQUEST['cptchpls_time'] ) ) {
			if ( 0 === strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] ) ) {
				/* Captcha was matched */
				$_SESSION['cptchpls_login'] = true;
				return $user;								
			} else {
				$_SESSION['cptchpls_login'] = false;
				wp_clear_auth_cookie();
				/* Add error if captcha is incorrect */
				$error = new WP_Error();
				if ( "" == $_REQUEST['cptchpls_number'] )
					$error->add( 'cptchpls_error', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $cptchpls_options['cptchpls_error_empty_value'] );
				else		
					$error->add( 'cptchpls_error', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $cptchpls_options['cptchpls_error_incorrect_value'] );
				return $error;
			}
		} else {
			/* Captcha was matched */
			if ( isset( $_REQUEST['log'] ) && isset( $_REQUEST['pwd'] ) ) {
				/* captcha was not found in _REQUEST */
				$_SESSION['cptchpls_login'] = false;
				$error = new WP_Error();
				$error->add( 'cptchpls_error', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $cptchpls_options['cptchpls_error_empty_value'] );
				return $error;
			} else {
				/* it is not a submit */
				return $user;
			}	
		}
	}
}
/* End function cptchpls_login_check */

/* This function adds captcha to the comment form */
if ( ! function_exists( 'cptchpls_comment_form' ) ) {
	function cptchpls_comment_form() {
		global $cptchpls_options, $cptchpls_ip_in_whitelist;
		/* Skip captcha if user is logged in and the settings allow */
		if ( is_user_logged_in() && 1 == $cptchpls_options['cptchpls_hide_register'] )
			return true;

		/* captcha html - comment form */
		echo '<p class="cptchpls_block">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )	
			echo '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] . '<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';
		if ( ! $cptchpls_ip_in_whitelist )
			echo cptchpls_display_captcha();
		else
			echo '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';
		echo '</p>';
		return true;
	}
}
/* End function cptchpls_comment_form */

/* This function adds captcha to the comment form */
if ( ! function_exists( 'cptchpls_comment_form_default_wp3' ) ) {
	function cptchpls_comment_form_default_wp3( $args ) {
		global $cptchpls_options;

		/* skip captcha if user is logged in and the settings allow */
		if ( is_user_logged_in() && 1 == $cptchpls_options['cptchpls_hide_register'] ) {
			return $args;
		}
		/* captcha html - comment form */
		$args['comment_notes_after'] .= cptchpls_custom_form( "" );

		remove_action( 'comment_form', 'cptchpls_comment_form' );

		return $args;
	}
}
/* End function cptchpls_comment_form_default_wp3 */

/* This function adds captcha to the comment form */
if ( ! function_exists( 'cptchpls_comment_form_wp3' ) ) {
	function cptchpls_comment_form_wp3() {
		global $cptchpls_options, $cptchpls_ip_in_whitelist;

		/* Skip captcha if user is logged in and the settings allow */
		if ( is_user_logged_in() && 1 == $cptchpls_options['cptchpls_hide_register'] )
			return true;

		/* captcha html - comment form */
		echo '<p class="cptchpls_block">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )	
			echo '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] . '<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';
		if ( ! $cptchpls_ip_in_whitelist )
			echo cptchpls_display_captcha();
		else
			echo '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';

		echo '</p>';
		remove_action( 'comment_form', 'cptchpls_comment_form' );
		return true;
	}
}
/* End function cptchpls_comment_form_wp3 */

/* This function checks captcha posted with the comment */
if ( ! function_exists( 'cptchpls_comment_post' ) ) {
	function cptchpls_comment_post( $comment ) {	
		global $cptchpls_options;

		if ( is_user_logged_in() && 1 == $cptchpls_options['cptchpls_hide_register'] )
			return $comment;
	    
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];

		$time_limit_exhausted = cptchpls_limit_exhausted();
		$error_message = $time_limit_exhausted ? $cptchpls_options['cptchpls_error_time_limit'] : $cptchpls_options['cptchpls_error_empty_value'];
		

		/* Added for compatibility with WP Wall plugin */
		/* This does NOT add CAPTCHA to WP Wall plugin, */
		/* It just prevents the "Error: You did not enter a Captcha phrase." when submitting a WP Wall comment */
		if ( function_exists( 'WPWall_Widget' ) && isset( $_REQUEST['wpwall_comment'] ) ) {
			/* Skip capthca */
			return $comment;
		}

		/* Skip captcha for comment replies from the admin menu */
		if ( isset( $_REQUEST['action'] ) && 'replyto-comment' == $_REQUEST['action'] &&
		( check_ajax_referer( 'replyto-comment', '_ajax_nonce', false ) || check_ajax_referer( 'replyto-comment', '_ajax_nonce-replyto-comment', false ) ) ) {
			/* Skip capthca */
			return $comment;
		}

		/* Skip captcha for trackback or pingback */
		if ( '' != $comment['comment_type'] && 'comment' != $comment['comment_type'] ) {
			/* Skip captcha */
			return $comment;
		}
		
		/* If captcha is empty */
		if ( ( isset( $_REQUEST['cptchpls_number'] ) && "" ==  $_REQUEST['cptchpls_number'] ) || $time_limit_exhausted )
			wp_die( __( 'Error', 'captcha-plus' ) . ':&nbsp' . $error_message . ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ? '' : ' ' . __( "Click the BACK button on your browser, and try again.", 'captcha-plus' ) ) );

		if ( isset( $_REQUEST['cptchpls_result'] ) && isset( $_REQUEST['cptchpls_number'] ) && isset( $_REQUEST['cptchpls_time'] ) && 0 === strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] ) ) {
			/* Captcha was matched */
			return( $comment );
		} else {
			wp_die( __( 'Error', 'captcha-plus' ) . ':&nbsp' . $cptchpls_options['cptchpls_error_incorrect_value'] . ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ? '' : ' ' . __( "Click the BACK button on your browser, and try again.", 'captcha-plus' ) ) );
		}
	}
}
/* End function cptchpls_comment_post */

/* This function adds the captcha to the register form */
if ( ! function_exists( 'cptchpls_register_form' ) ) {
	function cptchpls_register_form() {
		global $cptchpls_options, $cptchpls_ip_in_whitelist;

		/* the captcha html - register form */
		echo '<p class="cptchpls_block" style="text-align:left;">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )	
			echo '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] . '<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';
		if ( ! $cptchpls_ip_in_whitelist )
			echo cptchpls_display_captcha();
		else
			echo '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';
		echo '</p><br />';
		return true;
	}
}
/* End function cptchpls_register_form */


/* this function adds the captcha to the lost password form */
if ( ! function_exists ( 'cptchpls_lostpassword_form' ) ) {
	function cptchpls_lostpassword_form() {
		global $cptchpls_options, $cptchpls_ip_in_whitelist;
		/* the captcha html - register form */
		echo '<p class="cptchpls_block" style="text-align:left;">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )
			echo '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] . '<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';
		
		if ( ! $cptchpls_ip_in_whitelist )
			echo cptchpls_display_captcha();
		else
			echo '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';
		echo '</p><br />';
		return true;
	}
}

/* This function checks captcha posted with registration */
if ( ! function_exists( 'cptchpls_register_post' ) ) {
	function cptchpls_register_post( $login, $email, $errors ) {
		global $cptchpls_options;
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];
		$time_limit_exhausted = cptchpls_limit_exhausted();
		if ( $time_limit_exhausted ) {
			$error_slug    = 'captcha_time_limit';
			$error_message = $cptchpls_options['cptchpls_error_time_limit'];
		} else {
			$error_slug    = 'captcha_blank';
			$error_message = $cptchpls_options['cptchpls_error_empty_value'];
		}
		/* If captcha is blank - add error */
		if ( ( isset( $_REQUEST['cptchpls_number'] ) && "" ==  $_REQUEST['cptchpls_number'] ) || $time_limit_exhausted ) {
			$errors->add( $error_slug, '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $error_message );
			return $errors;
		}

		if ( isset( $_REQUEST['cptchpls_result'] ) && isset( $_REQUEST['cptchpls_number'] ) && isset( $_REQUEST['cptchpls_time'] )
			&& 0 === strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] ) ) {
			/* Captcha was matched */
		} else {
			$errors->add( 'captcha_wrong', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $cptchpls_options['cptchpls_error_incorrect_value'] );
		}
		return( $errors );
	}
}
/* End function cptchpls_register_post */

/* this function adds the captcha to the register form in multisite */
if ( ! function_exists ( 'wpmu_cptchpls_register_form' ) ) {
	function wpmu_cptchpls_register_form( $errors ) {	
		global $cptchpls_options, $cptchpls_ip_in_whitelist;

		/* the captcha html - register form */
		echo '<div class="cptchpls_block">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )	
			echo '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] . '<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';
		if ( ! $cptchpls_ip_in_whitelist ) {
			if ( is_wp_error( $errors ) ) {
				$error_codes = $errors->get_error_codes();
				if ( is_array( $error_codes ) && ! empty( $error_codes ) ) {
					foreach ( $error_codes as $error_code ) {
						if ( "captcha_" == substr( $error_code, 0, 8 ) ) {
							$error_message = $errors->get_error_message( $error_code );
							echo '<p class="error">' . $error_message . '</p>';
						}
					}
				}
			}
			echo cptchpls_display_captcha();
		} else
			echo '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';
		echo '</div><br />';
	}
}
/* End function wpmu_cptch_register_form */


/* this function checks the captcha posted with REGISTER form */
if ( ! function_exists ( 'cptchpls_register_check' ) ) {
	function cptchpls_register_check( $error ) {
		global $cptchpls_options;
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];

		if ( cptchpls_limit_exhausted() ) {
			if ( ! is_wp_error( $error ) )
				$error = new WP_Error();
			$error->add( 'captcha_error', __( 'ERROR', 'captcha-plus' ) . ':&nbsp;' . $cptchpls_options['cptchpls_error_time_limit'] );
		} elseif ( isset( $_REQUEST['cptchpls_number'] ) && "" == $_REQUEST['cptchpls_number'] ) {
			if ( ! is_wp_error( $error ) )
				$error = new WP_Error();
			$error->add( 'captcha_error', __( 'ERROR', 'captcha-plus' ) . ':&nbsp;' . $cptchpls_options['cptchpls_error_empty_value'] );
		} elseif ( 
			! isset( $_REQUEST['cptchpls_result'] ) || 
			! isset( $_REQUEST['cptchpls_number'] ) || 
			! isset( $_REQUEST['cptchpls_time'] ) ||
			0 !== strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] )
		) {
			if ( ! is_wp_error( $error ) )
				$error = new WP_Error();
			$error->add( 'captcha_error', __( 'ERROR', 'captcha-plus' ) . ':&nbsp;' . $cptchpls_options['cptchpls_error_incorrect_value'] );
		}
		return $error;
	}
}

if ( ! function_exists( 'cptchpls_register_validate' ) ) {
	function cptchpls_register_validate( $results ) {
		global $current_user, $cptchpls_options;

		if ( empty( $current_user->data->ID ) ) {
			$str_key = $cptchpls_options['cptchpls_str_key']['key'];
			$time_limit_exhausted = cptchpls_limit_exhausted();
			if ( $time_limit_exhausted ) {
				$error_slug    = 'captcha_time_limit';
				$error_message = $cptchpls_options['cptchpls_error_time_limit'];
			} else {
				$error_slug    = 'captcha_blank';
				$error_message = $cptchpls_options['cptchpls_error_empty_value'];
			}

			/* If captcha is blank - add error */
			if ( ( isset( $_REQUEST['cptchpls_number'] ) && "" ==  $_REQUEST['cptchpls_number'] ) || $time_limit_exhausted ) {
				$results['errors']->add( $error_slug, '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $error_message );
				return $results;
			}

			if ( 
				! isset( $_REQUEST['cptchpls_result'] ) || 
				! isset( $_REQUEST['cptchpls_number'] ) || 
				! isset( $_REQUEST['cptchpls_time'] ) ||
				0 !== strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] ) 
			)
				$results['errors']->add( 'captcha_wrong', '<strong>' . __( 'ERROR', 'captcha-plus' ) . '</strong>: ' . $cptchpls_options['cptchpls_error_incorrect_value'] );
			return $results;
		} else {
			return $results;
		}
	}
}
/* End function cptchpls_register_post */

/* this function checks the captcha posted with lostpassword form */
if ( ! function_exists ( 'cptchpls_lostpassword_check' ) ) {
	function cptchpls_lostpassword_check( $allow ) {
		global $cptchpls_options;
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];
		$error   = '';

		if ( cptchpls_limit_exhausted() ) {
			$error = new WP_Error();
			$error->add( 'captcha_error', __( 'ERROR', 'captcha-plus' ) . ':&nbsp;' . $cptchpls_options['cptchpls_error_time_limit'] );
		} elseif ( isset( $_REQUEST['cptchpls_number'] ) && "" == $_REQUEST['cptchpls_number'] ) {
			$error = new WP_Error();
			$error->add( 'captcha_error', __( 'ERROR', 'captcha-plus' ) . ':&nbsp;' . $cptchpls_options['cptchpls_error_empty_value'] );
		} elseif ( 
			! isset( $_REQUEST['cptchpls_result'] ) || 
			! isset( $_REQUEST['cptchpls_number'] ) || 
			! isset( $_REQUEST['cptchpls_time'] ) ||
			0 !== strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] )
		) {
			$error = new WP_Error();
			$error->add( 'captcha_error', __( 'ERROR', 'captcha-plus' ) . ':&nbsp;' . $cptchpls_options['cptchpls_error_incorrect_value'] );
		} 
		return is_wp_error( $error ) ? $error : $allow;
	}
}
/* function cptchpls_lostpassword_check */

/* Functionality of the captcha logic work */
if ( ! function_exists( 'cptchpls_display_captcha' ) ) {
	function cptchpls_display_captcha() {
		global $cptchpls_options, $cptchpls_time, $cptchpls_plugin_info;

		if ( ! $cptchpls_plugin_info ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$cptchpls_plugin_info = get_plugin_data( __FILE__ );
		}

		if ( ! isset( $cptchpls_options['cptchpls_str_key'] ) )
			$cptchpls_options = get_option( 'cptchpls_options' );
		if ( '' == $cptchpls_options['cptchpls_str_key']['key'] || $cptchpls_options['cptchpls_str_key']['time'] < time() - ( 24 * 60 * 60 ) )
			cptchpls_generate_key();
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];
		

		/*
		 * array of math actions
		 */
		$math_actions = array();
		if ( 1 == $cptchpls_options['cptchpls_math_action_plus'] ) /* If Plus enabled */
			$math_actions[] = '&#43;';
		if ( 1 == $cptchpls_options['cptchpls_math_action_minus'] ) /* If Minus enabled */
			$math_actions[] = '&minus;';
		if ( 1 == $cptchpls_options['cptchpls_math_action_increase'] ) /* If Increase enabled */
			$math_actions[] = '&times;';
		/* current math action */
		$rand_math_action = rand( 0, count( $math_actions) - 1 );

		/*
		 * get elements of mathematical expression
		 */
		$array_math_expretion    = array();
		$array_math_expretion[0] = rand( 1, 9 ); /* first part */
		$array_math_expretion[1] = rand( 1, 9 ); /* second part */
		/* Calculation of the result */
		switch( $math_actions[ $rand_math_action ] ) {
			case "&#43;":
				$array_math_expretion[2] = $array_math_expretion[0] + $array_math_expretion[1];
				break;
			case "&minus;":
				/* Result must not be equal to the negative number */
				if ( $array_math_expretion[0] < $array_math_expretion[1] ) {
					$number = $array_math_expretion[0];
					$array_math_expretion[0] = $array_math_expretion[1];
					$array_math_expretion[1] = $number;
				}
				$array_math_expretion[2] = $array_math_expretion[0] - $array_math_expretion[1];
				break;
			case "&times;":
				$array_math_expretion[2] = $array_math_expretion[0] * $array_math_expretion[1];
				break;
		}

		/*
		 * array of allowed formats
		 */
		$allowed_formats = array();
		if ( 1 == $cptchpls_options["cptchpls_difficulty_number"] ) /* If Numbers enabled */
			$allowed_formats[] = 'number';
		if ( 1 == $cptchpls_options["cptchpls_difficulty_word"] ) /* If Words enabled */
			$allowed_formats[] = 'word';
		if ( 1 == $cptchpls_options["cptchpls_difficulty_image"] ) /* If Images enabled */
			$allowed_formats[] = 'image';
		$use_only_words = ( 1 == $cptchpls_options["cptchpls_difficulty_word"] && 0 == $cptchpls_options["cptchpls_difficulty_number"] ) || 0 == $cptchpls_options["cptchpls_difficulty_word"] ? true : false;
		/* number of field, which will be displayed as <input type="number" /> */
		$rand_input = rand( 0, 2 );

		/* 
		 * get current format for each operand 
		 * for example array( 'text', 'input', 'number' )
		 */
		$operand_formats = array();
		$max_rand_value = count( $allowed_formats ) - 1;
		for ( $i = 0; $i < 3; $i ++ ) {
			$operand_formats[] = $rand_input == $i ? 'input' : $allowed_formats[ mt_rand( 0, $max_rand_value ) ];
		}

		/*
		 * get value of each operand
		 */
		$operand = array();
		foreach ( $operand_formats as $key => $format ) {
			switch ( $format ) {
				case 'input':
					$operand[] = '<input id="cptchpls_input" class="cptchpls_input" type="text" autocomplete="off" name="cptchpls_number" value="" maxlength="2" size="2" aria-required="true" required="required" style="margin-bottom:0;display:inline;font-size: 15px;width: 18px;" />';
					break;
				case 'word':
					$operand[] = cptchpls_generate_value( $array_math_expretion[ $key ] );
					break;
				case 'image':
					$operand[] = cptchpls_get_image( $array_math_expretion[ $key ], $key, $cptchpls_options['used_packages'][ mt_rand( 0, abs( count( $cptchpls_options['used_packages'] ) - 1 ) ) ], $use_only_words );
					break;
				case 'number':
				default:
					$operand[] = $array_math_expretion[ $key ];
					break;
			}
		}
		/*
		 * get html-structure of CAPTCHA
		 */
		$reload_button = 
				1 == $cptchpls_options['display_reload_button']
			?
				'<span class="cptchpls_reload_button_wrap hide-if-no-js">
					<noscript>
						<style type="text/css">
							.hide-if-no-js {
								display: none !important;
							}
						</style>
					</noscript>
					<span class="cptchpls_reload_button dashicons dashicons-update"></span>
				</span>'
			:
				'';
		return 
			'<span class="cptchpls_wrap">
				<label class="cptchpls_label" for="cptchpls_input">
					<span class="cptchpls_span">' . $operand[0] . '</span>
					<span class="cptchpls_span">&nbsp;' . $math_actions[ $rand_math_action ] . '&nbsp;</span>
					<span class="cptchpls_span">' . $operand[1] . '</span>
					<span class="cptchpls_span">&nbsp;=&nbsp;</span>
					<span class="cptchpls_span">' . $operand[2] . '</span>
					<input type="hidden" name="cptchpls_result" value="' . cptchpls_encode( $array_math_expretion[ $rand_input ], $str_key, $cptchpls_time ) . '" />
					<input type="hidden" name="cptchpls_time" value="' . $cptchpls_time . '" />
					<input type="hidden" value="Version: ' . $cptchpls_plugin_info["Version"] . '" />
				</label>' .
				$reload_button .
			'</span>';
	}
}

/**
 * Display image in CAPTCHA
 * @param    int     $value       value of element of mathematical expression
 * @param    int     $place       which is an element in the mathematical expression
 * @param    array   $package_id  what package to use in current CAPTCHA ( if it is '-1' then all )
 * @return   string               html-structure of element
 */
if ( ! function_exists( 'cptchpls_get_image' ) ) {
	function cptchpls_get_image( $value, $place, $package_id, $use_only_words ) {
		global $wpdb, $cptchpls_options;

		$result = array();
		if ( empty( $cptchpls_options ) )
			$cptchpls_options = get_option( 'cptchpls_options' );
		
		if ( empty( $cptchpls_options['used_packages'] ) )
			return cptchpls_generate_value( $value, $use_only_words );
		
		$where = -1 == $package_id ? ' IN (' . implode( ',', $cptchpls_options['used_packages'] ) . ')' : '=' . $package_id;
		$images = $wpdb->get_results(
			"SELECT 
				`{$wpdb->base_prefix}cptch_images`.`name` AS `file`, 
				`{$wpdb->base_prefix}cptch_packages`.`folder` AS `folder`
			FROM 
				`{$wpdb->base_prefix}cptch_images`
			LEFT JOIN
				`{$wpdb->base_prefix}cptch_packages`
			ON
				`{$wpdb->base_prefix}cptch_packages`.`id`=`{$wpdb->base_prefix}cptch_images`.`package_id`
			WHERE
				`{$wpdb->base_prefix}cptch_images`.`package_id` {$where}
				AND
				`{$wpdb->base_prefix}cptch_images`.`number`={$value};",
			ARRAY_N
		);
		if ( empty( $images ) )
			return cptchpls_generate_value( $value, $use_only_words );
		if ( is_multisite() ) {
			switch_to_blog( 1 );
			$upload_dir = wp_upload_dir();
			restore_current_blog();
		} else {
			$upload_dir = wp_upload_dir();
		}
		$current_image = $images[ mt_rand( 0, count( $images ) - 1 ) ];
		$src = $upload_dir['basedir'] . '/bws_captcha_images/' . $current_image[1] . '/' . $current_image[0];
		if ( file_exists( $src ) ) {
			if ( 1 == $cptchpls_options['enlarge_images'] ) {
				switch( $place ) {
					case 0:
						$class = 'cptchpls_left'; 
						break;
					case 1:
						$class = 'cptchpls_center'; 
						break;
					case 2:
						$class = 'cptchpls_right'; 
						break;
					default:
						$class = '';
						break;
				}
			} else {
				$class = '';
			}
			$src = $upload_dir['basedir'] . '/bws_captcha_images/' . $current_image[1] . '/' . $current_image[0];
			$image_data = getimagesize( $src );
			return isset( $image_data['mime'] ) && ! empty( $image_data['mime'] ) ? '<img class="cptchpls_img ' . $class . '" src="data: ' . $image_data['mime'] . ';base64,'. base64_encode( file_get_contents( $src ) ) . '" />' :  cptchpls_generate_value( $value, $use_only_words );
		} else {
			return cptchpls_generate_value( $value, $use_only_words );
		}
	}
}

if ( ! function_exists( 'cptchpls_generate_value' ) ) {
	function cptchpls_generate_value( $value, $use_only_words = true ) {
		$random = $use_only_words  ? 1 : mt_rand( 0, 1 );
		if ( 1 == $random ) {
			$number_string = array( 
				0 => __( 'zero', 'captcha-plus' ),
				1 => __( 'one', 'captcha-plus' ),
				2 => __( 'two', 'captcha-plus' ),
				3 => __( 'three', 'captcha-plus' ),
				4 => __( 'four', 'captcha-plus' ),
				5 => __( 'five', 'captcha-plus' ),
				6 => __( 'six', 'captcha-plus' ),
				7 => __( 'seven', 'captcha-plus' ),
				8 => __( 'eight', 'captcha-plus' ),
				9 => __( 'nine', 'captcha-plus' ),

				10 => __( 'ten', 'captcha-plus' ),
				11 => __( 'eleven', 'captcha-plus' ),
				12 => __( 'twelve', 'captcha-plus' ),
				13 => __( 'thirteen', 'captcha-plus' ),
				14 => __( 'fourteen', 'captcha-plus' ),
				15 => __( 'fifteen', 'captcha-plus' ),
				16 => __( 'sixteen', 'captcha-plus' ),
				17 => __( 'seventeen', 'captcha-plus' ),
				18 => __( 'eighteen', 'captcha-plus' ),
				19 => __( 'nineteen', 'captcha-plus' ),

				20 => __( 'twenty', 'captcha-plus' ),
				21 => __( 'twenty one', 'captcha-plus' ),
				22 => __( 'twenty two', 'captcha-plus' ),
				23 => __( 'twenty three', 'captcha-plus' ),
				24 => __( 'twenty four', 'captcha-plus' ),
				25 => __( 'twenty five', 'captcha-plus' ),
				26 => __( 'twenty six', 'captcha-plus' ),
				27 => __( 'twenty seven', 'captcha-plus' ),
				28 => __( 'twenty eight', 'captcha-plus' ),
				29 => __( 'twenty nine', 'captcha-plus' ),

				30 => __( 'thirty', 'captcha-plus' ),
				31 => __( 'thirty one', 'captcha-plus' ),
				32 => __( 'thirty two', 'captcha-plus' ),
				33 => __( 'thirty three', 'captcha-plus' ),
				34 => __( 'thirty four', 'captcha-plus' ),
				35 => __( 'thirty five', 'captcha-plus' ),
				36 => __( 'thirty six', 'captcha-plus' ),
				37 => __( 'thirty seven', 'captcha-plus' ),
				38 => __( 'thirty eight', 'captcha-plus' ),
				39 => __( 'thirty nine', 'captcha-plus' ),

				40 => __( 'forty', 'captcha-plus' ),
				41 => __( 'forty one', 'captcha-plus' ),
				42 => __( 'forty two', 'captcha-plus' ),
				43 => __( 'forty three', 'captcha-plus' ),
				44 => __( 'forty four', 'captcha-plus' ),
				45 => __( 'forty five', 'captcha-plus' ),
				46 => __( 'forty six', 'captcha-plus' ),
				47 => __( 'forty seven', 'captcha-plus' ),
				48 => __( 'forty eight', 'captcha-plus' ),
				49 => __( 'forty nine', 'captcha-plus' ),

				50 => __( 'fifty', 'captcha-plus' ),
				51 => __( 'fifty one', 'captcha-plus' ),
				52 => __( 'fifty two', 'captcha-plus' ),
				53 => __( 'fifty three', 'captcha-plus' ),
				54 => __( 'fifty four', 'captcha-plus' ),
				55 => __( 'fifty five', 'captcha-plus' ),
				56 => __( 'fifty six', 'captcha-plus' ),
				57 => __( 'fifty seven', 'captcha-plus' ),
				58 => __( 'fifty eight', 'captcha-plus' ),
				59 => __( 'fifty nine', 'captcha-plus' ),

				60 => __( 'sixty', 'captcha-plus' ),
				61 => __( 'sixty one', 'captcha-plus' ),
				62 => __( 'sixty two', 'captcha-plus' ),
				63 => __( 'sixty three', 'captcha-plus' ),
				64 => __( 'sixty four', 'captcha-plus' ),
				65 => __( 'sixty five', 'captcha-plus' ),
				66 => __( 'sixty six', 'captcha-plus' ),
				67 => __( 'sixty seven', 'captcha-plus' ),
				68 => __( 'sixty eight', 'captcha-plus' ),
				69 => __( 'sixty nine', 'captcha-plus' ),

				70 => __( 'seventy', 'captcha-plus' ),
				71 => __( 'seventy one', 'captcha-plus' ),
				72 => __( 'seventy two', 'captcha-plus' ),
				73 => __( 'seventy three', 'captcha-plus' ),
				74 => __( 'seventy four', 'captcha-plus' ),
				75 => __( 'seventy five', 'captcha-plus' ),
				76 => __( 'seventy six', 'captcha-plus' ),
				77 => __( 'seventy seven', 'captcha-plus' ),
				78 => __( 'seventy eight', 'captcha-plus' ),
				79 => __( 'seventy nine', 'captcha-plus' ),

				80 => __( 'eighty', 'captcha-plus' ),
				81 => __( 'eighty one', 'captcha-plus' ),
				82 => __( 'eighty two', 'captcha-plus' ),
				83 => __( 'eighty three', 'captcha-plus' ),
				84 => __( 'eighty four', 'captcha-plus' ),
				85 => __( 'eighty five', 'captcha-plus' ),
				86 => __( 'eighty six', 'captcha-plus' ),
				87 => __( 'eighty seven', 'captcha-plus' ),
				88 => __( 'eighty eight', 'captcha-plus' ),
				89 => __( 'eighty nine', 'captcha-plus' ),

				90 => __( 'ninety', 'captcha-plus' ),
				91 => __( 'ninety one', 'captcha-plus' ),
				92 => __( 'ninety two', 'captcha-plus' ),
				93 => __( 'ninety three', 'captcha-plus' ),
				94 => __( 'ninety four', 'captcha-plus' ),
				95 => __( 'ninety five', 'captcha-plus' ),
				96 => __( 'ninety six', 'captcha-plus' ),
				97 => __( 'ninety seven', 'captcha-plus' ),
				98 => __( 'ninety eight', 'captcha-plus' ),
				99 => __( 'ninety nine', 'captcha-plus' )
			);
			$value = cptchpls_converting( $number_string[ $value ] );
		} 
		return $value;
	}
}

if ( ! function_exists ( 'cptchpls_converting' ) ) {
	function cptchpls_converting( $number_string ) {
		global $cptchpls_options;

		if ( 1 == $cptchpls_options["cptchpls_difficulty_word"] && 'en-US' == get_bloginfo( 'language' ) ) {
			/* Array of htmlspecialchars for numbers and english letters */
			$htmlspecialchars_array			=	array();
			$htmlspecialchars_array['a']	=	'&#97;';
			$htmlspecialchars_array['b']	=	'&#98;';
			$htmlspecialchars_array['c']	=	'&#99;';
			$htmlspecialchars_array['d']	=	'&#100;';
			$htmlspecialchars_array['e']	=	'&#101;';
			$htmlspecialchars_array['f']	=	'&#102;';
			$htmlspecialchars_array['g']	=	'&#103;';
			$htmlspecialchars_array['h']	=	'&#104;';
			$htmlspecialchars_array['i']	=	'&#105;';
			$htmlspecialchars_array['j']	=	'&#106;';
			$htmlspecialchars_array['k']	=	'&#107;';
			$htmlspecialchars_array['l']	=	'&#108;';
			$htmlspecialchars_array['m']	=	'&#109;';
			$htmlspecialchars_array['n']	=	'&#110;';
			$htmlspecialchars_array['o']	=	'&#111;';
			$htmlspecialchars_array['p']	=	'&#112;';
			$htmlspecialchars_array['q']	=	'&#113;';
			$htmlspecialchars_array['r']	=	'&#114;';
			$htmlspecialchars_array['s']	=	'&#115;';
			$htmlspecialchars_array['t']	=	'&#116;';
			$htmlspecialchars_array['u']	=	'&#117;';
			$htmlspecialchars_array['v']	=	'&#118;';
			$htmlspecialchars_array['w']	=	'&#119;';
			$htmlspecialchars_array['x']	=	'&#120;';
			$htmlspecialchars_array['y']	=	'&#121;';
			$htmlspecialchars_array['z']	=	'&#122;';

			$simbols_lenght = strlen( $number_string );
			$simbols_lenght--;
			$number_string_new	=	str_split( $number_string );
			$converting_letters	=	rand( 1, $simbols_lenght );
			while ( $converting_letters != 0 ) {
				$position = rand( 0, $simbols_lenght );
				$number_string_new[ $position ] = isset( $htmlspecialchars_array[ $number_string_new[ $position ] ] ) ? $htmlspecialchars_array[ $number_string_new[ $position ] ] : $number_string_new[ $position ];
				$converting_letters--;
			}
			$number_string = '';
			foreach ( $number_string_new as $key => $value ) {
				$number_string .= $value;
			}
			return $number_string;
		} else
			return $number_string;
	}
}

/* Function for encodinf number */
if ( ! function_exists( 'cptchpls_encode' ) ) {
	function cptchpls_encode( $String, $Password, $cptchpls_time ) {
		/* Check if key for encoding is empty */
		if ( ! $Password ) die ( __( "Encryption password is not set", 'captcha-plus' ) );

		$Salt	=	md5( $cptchpls_time, true );
		$String	=	substr( pack( "H*", sha1( $String ) ), 0, 1 ) . $String;
		$StrLen	=	strlen( $String );
		$Seq	=	$Password;
		$Gamma	=	'';
		while ( strlen( $Gamma ) < $StrLen ) {
			$Seq = pack( "H*", sha1( $Seq . $Gamma . $Salt ) );
			$Gamma .= substr( $Seq, 0, 8 );
		}

		return base64_encode( $String ^ $Gamma );
	}
}

/* Function for decoding number */
if ( ! function_exists( 'cptchpls_decode' ) ) {
	function cptchpls_decode( $String, $Key, $cptchpls_time ) {
		/* Check if key for encoding is empty */
		if ( ! $Key ) die ( __( "Decryption password is not set", 'captcha-plus' ) );

		$Salt	=	md5( $cptchpls_time, true );
		$StrLen	=	strlen( $String );
		$Seq	=	$Key;
		$Gamma	=	'';
		while ( strlen( $Gamma ) < $StrLen ) {
			$Seq = pack( "H*", sha1( $Seq . $Gamma . $Salt ) );
			$Gamma .= substr( $Seq, 0, 8 );
		}

		$String = base64_decode( $String );
		$String = $String^$Gamma;

		$DecodedString = substr( $String, 1 );
		$Error = ord( substr( $String, 0, 1 ) ^ substr( pack( "H*", sha1( $DecodedString ) ), 0, 1 )); 

		return $Error ? false : $DecodedString;
	}
}

/* This function adds captcha to the custom form */
if ( ! function_exists( 'cptchpls_custom_form' ) ) {
	function cptchpls_custom_form( $error_message, $content = "" ) {
		$cptchpls_options = get_option( 'cptchpls_options' );
		
		/* captcha html - login form */
		$content .= '<p class="cptchpls_block" style="text-align:left;">';
		if ( "" != $cptchpls_options['cptchpls_label_form'] )	
			$content .= '<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] .'<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>';

		if ( isset( $error_message['error_captcha'] ) ) {
			$content .= "<span class='cptchpls_error' style='color:red'>" . $error_message['error_captcha'] . "</span><br />";
		}
		$content .= cptchpls_display_captcha_custom();
		$content .= '</p>';
		return $content;
	}
}
/*  End function cptchpls_contact_form */

/* This function check captcha in the custom form */
if ( ! function_exists( 'cptchpls_check_custom_form' ) ) {
	function cptchpls_check_custom_form( $display_error = true ) {
		/** 
		 * this condition is necessary for compatibility 
		 * with Contact Form ( Free and Pro ) by BestWebsoft plugins versions
		 * that use $_POST as parameter for hook 
		 * apply_filters( 'cntctfrmpr_check_form', $_POST );
		 * @todo remove after some while
		 */
		if ( is_array( $display_error ) && ( isset( $_REQUEST['cntctfrm_contact_action'] ) || isset( $_REQUEST['cntctfrmpr_contact_action'] ) ) )
			$display_error = false;

		global $cptchpls_options, $cptchpls_ip_in_whitelist;
		if ( empty( $cptchpls_ip_in_whitelist ) )
			$cptchpls_ip_in_whitelist = cptchpls_whitelisted_ip();
		if ( ! $cptchpls_ip_in_whitelist ) {
			$str_key = $cptchpls_options['cptchpls_str_key']['key'];
			$time_limit_exhausted = cptchpls_limit_exhausted();

			if ( isset( $_REQUEST['cntctfrm_contact_action'] ) || isset( $_REQUEST['cntctfrmpr_contact_action'] ) ) {
				/* If captcha doesn't entered */
				if ( ( isset( $_REQUEST['cptchpls_number'] ) && "" ==  $_REQUEST['cptchpls_number'] ) || $time_limit_exhausted ) {
					$error = $time_limit_exhausted ? $cptchpls_options['cptchpls_error_time_limit'] : $cptchpls_options['cptchpls_error_empty_value'];
					return $display_error ? $error : false;
				}
				
				/* Check entered captcha */
				if ( isset( $_REQUEST['cptchpls_result'] ) && isset( $_REQUEST['cptchpls_number'] ) && isset( $_REQUEST['cptchpls_time'] ) && 
					0 === strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] ) ) {
					return true;
				} else {
					return $display_error ? $cptchpls_options['cptchpls_error_incorrect_value'] : false;
				}
			} else
				return false;
		} else {
			return true;
		}
	}
}
/* End function cptchpls_check_contact_form */

/* Functionality of the captcha logic work for custom form */
if ( ! function_exists( 'cptchpls_display_captcha_custom' ) ) {
	function cptchpls_display_captcha_custom( $class_name = "", $cptchpls_input_name = 'cptchpls_number' ) {
		global $cptchpls_options, $cptchpls_time, $cptchpls_plugin_info, $cptchpls_ip_in_whitelist;
		if ( empty( $cptchpls_ip_in_whitelist ) )
			$cptchpls_ip_in_whitelist = cptchpls_whitelisted_ip();
		
		if ( ! $cptchpls_ip_in_whitelist ) {
			if ( ! $cptchpls_plugin_info ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				$cptchpls_plugin_info = get_plugin_data( __FILE__ );
			}

			if ( ! isset( $cptchpls_options['cptchpls_str_key'] ) )
				$cptchpls_options = get_option( 'cptchpls_options' );
			if ( '' == $cptchpls_options['cptchpls_str_key']['key'] || $cptchpls_options['cptchpls_str_key']['time'] < time() - ( 24 * 60 * 60 ) )
				cptchpls_generate_key();
			$str_key = $cptchpls_options['cptchpls_str_key']['key'];
			
			/*
			 * array of math actions
			 */
			$math_actions = array();
			if ( 1 == $cptchpls_options['cptchpls_math_action_plus'] ) /* If Plus enabled */
				$math_actions[] = '&#43;';
			if ( 1 == $cptchpls_options['cptchpls_math_action_minus'] ) /* If Minus enabled */
				$math_actions[] = '&minus;';
			if ( 1 == $cptchpls_options['cptchpls_math_action_increase'] ) /* If Increase enabled */
				$math_actions[] = '&times;';
			/* current math action */
			$rand_math_action = rand( 0, count( $math_actions) - 1 );

			/*
			 * get elements of mathematical expression
			 */
			$array_math_expretion    = array();
			$array_math_expretion[0] = rand( 1, 9 ); /* first part */
			$array_math_expretion[1] = rand( 1, 9 ); /* second part */
			/* Calculation of the result */
			switch( $math_actions[ $rand_math_action ] ) {
				case "&#43;":
					$array_math_expretion[2] = $array_math_expretion[0] + $array_math_expretion[1];
					break;
				case "&minus;":
					/* Result must not be equal to the negative number */
					if ( $array_math_expretion[0] < $array_math_expretion[1] ) {
						$number = $array_math_expretion[0];
						$array_math_expretion[0] = $array_math_expretion[1];
						$array_math_expretion[1] = $number;
					}
					$array_math_expretion[2] = $array_math_expretion[0] - $array_math_expretion[1];
					break;
				case "&times;":
					$array_math_expretion[2] = $array_math_expretion[0] * $array_math_expretion[1];
					break;
			}

			/*
			 * array of allowed formats
			 */
			$allowed_formats = array();
			if ( 1 == $cptchpls_options["cptchpls_difficulty_number"] ) /* If Numbers enabled */
				$allowed_formats[] = 'number';
			if ( 1 == $cptchpls_options["cptchpls_difficulty_word"] ) /* If Words enabled */
				$allowed_formats[] = 'word';
			if ( 1 == $cptchpls_options["cptchpls_difficulty_image"] ) /* If Images enabled */
				$allowed_formats[] = 'image';
			$use_only_words = ( 1 == $cptchpls_options["cptchpls_difficulty_word"] && 0 == $cptchpls_options["cptchpls_difficulty_number"] ) || 0 == $cptchpls_options["cptchpls_difficulty_word"] ? true : false;
			/* number of field, which will be displayed as <input type="text"/> */
			$rand_input = rand( 0, 2 );

			/* 
			 * get current format for each operand 
			 * for example array( 'text', 'input', 'number' )
			 */
			$operand_formats = array();
			$max_rand_value = count( $allowed_formats ) - 1;
			for ( $i = 0; $i < 3; $i ++ ) {
				$operand_formats[] = $rand_input == $i ? 'input' : $allowed_formats[ mt_rand( 0, $max_rand_value ) ];
			}

			/*
			 * get value of each operand
			 */
			$operand    = array();
			$id_postfix = rand( 0, 100 );
			foreach ( $operand_formats as $key => $format ) {
				switch ( $format ) {
					case 'input':
						$operand[] = '<input id="cptchpls_input_' . $id_postfix . '" class="cptchpls_input ' . $class_name . '" type="text" autocomplete="off" name="' . $cptchpls_input_name . '" value="" maxlength="2" size="2" aria-required="true" required="required" style="margin-bottom:0;display:inline;font-size: 15px;width: 18px;" />';
						break;
					case 'word':
						$operand[] = cptchpls_generate_value( $array_math_expretion[ $key ] );
						break;
					case 'image':
						$operand[] = cptchpls_get_image( $array_math_expretion[ $key ], $key, $cptchpls_options['used_packages'][ mt_rand( 0, abs( count( $cptchpls_options['used_packages'] ) - 1 ) ) ], $use_only_words );
						break;
					case 'number':
					default:
						$operand[] = $array_math_expretion[ $key ];
						break;
				}
			}
			/*
			 * get html-structure of CAPTCHA
			 */
			$reload_button = 
					1 == $cptchpls_options['display_reload_button']
				?
					'<span class="cptchpls_reload_button_wrap hide-if-no-js">
						<noscript>
							<style type="text/css">
								.hide-if-no-js {
									display: none !important;
								}
							</style>
						</noscript>
						<span class="cptchpls_reload_button dashicons dashicons-update"></span>
					</span>'
				:
					'';
			if ( empty( $class_name ) ) {
				$label = $tag_open = $tag_close = '';
			} else {
				$label = 
						"" != $cptchpls_options['cptchpls_label_form'] 
					? 
						'<span class="cptchpls_title">' . $cptchpls_options['cptchpls_label_form'] .'<span class="required"> ' . $cptchpls_options['cptchpls_required_symbol'] . '</span></span>' 
					: '';
				$tag_open  = '<p class="cptchpls_block" style="text-align:left;">';
				$tag_close = '</p>';
			}
			$hidden_result_name = $cptchpls_input_name == 'cptchpls_number' ? 'cptchpls_result' : $cptchpls_input_name . '-cptchpls_result';
			return
				$tag_open .
				$label .
				'<span class="cptchpls_wrap">
					<label class="cptchpls_label" for="cptchpls_input_' . $id_postfix . '">
						<span class="cptchpls_span">' . $operand[0] . '</span>
						<span class="cptchpls_span">&nbsp;' . $math_actions[ $rand_math_action ] . '&nbsp;</span>
						<span class="cptchpls_span">' . $operand[1] . '</span>
						<span class="cptchpls_span">&nbsp;=&nbsp;</span>
						<span class="cptchpls_span">' . $operand[2] . '</span>
						<input type="hidden" name="' . $hidden_result_name . '" value="' . cptchpls_encode( $array_math_expretion[ $rand_input ], $str_key, $cptchpls_time ) . '" />
						<input type="hidden" name="cptchpls_time" value="' . $cptchpls_time . '" />
						<input type="hidden" value="Version: ' . $cptchpls_plugin_info["Version"] . '" />
					</label>' .
					$reload_button .
				'</span>' .
				$tag_close;
		} else {
			return '<label class="cptchpls_whitelist_message">' . $cptchpls_options['whitelist_message'] . '</label>';
		}
	}
}


/**
 * Check CAPTCHA life time
 * @return boolean
 */
if ( ! function_exists( 'cptchpls_limit_exhausted' ) ) {
	function cptchpls_limit_exhausted() {
		global $cptchpls_options;
		if ( empty( $cptchpls_options ) )
			$cptchpls_options = get_option( 'cptchpls_options' );
		return 
				1 == $cptchpls_options['use_time_limit'] &&       /* if 'Enable time limit' option is enabled */
				isset( $_REQUEST['cptchpls_time'] ) &&            /* if form was sended */
				$cptchpls_options['time_limit'] < time() - $_REQUEST['cptchpls_time'] /* if time limit is exhausted */
			? 
				true 
			: 
				false;
	}
}

if ( ! function_exists ( 'cptchpls_display_example' ) ) {
	function cptchpls_display_example( $action ) {
		echo "<div class='cptchpls_example_fields_actions'>";
		switch( $action ) {
			case "cptchpls_math_action_plus":
				echo __( 'seven', 'captcha-plus' ) . ' &#43; 1 = <img src="' . plugins_url( 'images/cptchpls_input.jpg' , __FILE__ ) . '" alt="" title="" />';
				break;
			case "cptchpls_math_action_minus":
				echo __( 'eight', 'captcha-plus' ) . ' &minus; 6 = <img src="' . plugins_url( 'images/cptchpls_input.jpg' , __FILE__ ) . '" alt="" title="" />';
				break;
			case "cptchpls_math_action_increase":
				echo '<img src="' . plugins_url( 'images/cptchpls_input.jpg' , __FILE__ ) . '" alt="" title="" /> &times; 1 = ' . __( 'seven', 'captcha-plus' );
				break;
			case "cptchpls_difficulty_number":
				echo '5 &minus; <img src="' . plugins_url( 'images/cptchpls_input.jpg' , __FILE__ ) . '" alt="" title="" /> = 1';
				break;
			case "cptchpls_difficulty_word":
				echo __( 'six', 'captcha-plus' ) . ' &#43; ' . __( 'one', 'captcha-plus' ) . ' = <img src="' . plugins_url( 'images/cptchpls_input.jpg' , __FILE__ ) . '" alt="" title="" />';
				break;
			case 'cptchpls_difficulty_image': 
				echo '<label class="cptchpls_label">
						<span class="cptchpls_span"><img src="' . plugins_url( 'images/6.png' , __FILE__ ) . '" /></span>' . 
						'<span class="cptchpls_span">&nbsp;&#43;&nbsp;</span>' . 
						'<span class="cptchpls_span"><img src="' . plugins_url( 'images/cptchpls_input.jpg' , __FILE__ ) . '" /></span> 
						<span class="cptchpls_span">&nbsp;=&nbsp;</span>
						<span class="cptchpls_span"><img src="' . plugins_url( 'images/7.png' , __FILE__ ).'" /></span>
					<label>';
				break;
			default:
				break;
		}
		echo "</div>";
	}
}


if ( ! function_exists( 'cptchpls_front_end_scripts' ) ) {
	function cptchpls_front_end_scripts() {
		if ( ! is_admin() ) {
			global $cptchpls_options;
			if ( empty( $cptchpls_options ) )
				$cptchpls_options = get_option( 'cptchpls_options' );
			wp_enqueue_style( 'cptchpls_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_style( 'dashicons' );
			
			$device_type = isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Windows Phone|Opera Mini/i', $_SERVER['HTTP_USER_AGENT'] ) ? 'mobile' : 'desktop';
			wp_enqueue_style( "cptchpls_{$device_type}_style", plugins_url( "css/{$device_type}_style.css", __FILE__ ) );
			
			wp_enqueue_script( 'cptchpls_front_end_script', plugins_url( 'js/front_end_script.js' , __FILE__ ), array( 'jquery' ) );
			$cptchpls_vars = array(
				'nonce'   => wp_create_nonce( 'cptchpls', 'cptchpls_nonce' ),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'enlarge' => $cptchpls_options['enlarge_images']
			);
			wp_localize_script( 'cptchpls_front_end_script', 'cptchpls_vars', $cptchpls_vars );
		}
	}
}

if ( ! function_exists ( 'cptchpls_admin_head' ) ) {
	function cptchpls_admin_head() {
		if ( isset( $_REQUEST['page'] ) && 'captcha-plus.php' == $_REQUEST['page'] ) {			
			wp_enqueue_style( 'cptchpls_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_script( 'cptchpls_script', plugins_url( 'js/script.js', __FILE__ ) );

			if ( isset( $_GET['action'] ) && 'custom_code' == $_GET['action'] )
				bws_plugins_include_codemirror();
		}
	}
}

if ( ! function_exists( 'cptchpls_reload' ) ) {
	function cptchpls_reload() {
		check_ajax_referer( 'cptchpls', 'cptchpls_nonce' );
		$input_class = trim( preg_replace( '/cptchpls_input/', '', $_REQUEST['cptchpls_input_class'] ) );
		echo empty( $input_class ) ? cptchpls_display_captcha() : cptchpls_display_captcha_custom( $input_class, $_REQUEST['cptchpls_input_name'] );
		die();
	}
}

if ( ! function_exists( 'cptchpls_plugin_action_links' ) ) {
	function cptchpls_plugin_action_links( $links, $file ) {		
		if ( ! is_network_admin() ) {
			static $this_plugin;
			if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

			if ( $file == $this_plugin ) {
				$settings_link = '<a href="admin.php?page=captcha-plus.php">' . __( 'Settings', 'captcha-plus' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}

if ( ! function_exists( 'cptchpls_register_plugin_links' ) ) {
	function cptchpls_register_plugin_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() )
				$links[]	=	'<a href="admin.php?page=captcha-plus.php">' . __( 'Settings', 'captcha-plus' ) . '</a>';
			$links[]	=	'<a href="http://wordpress.org/plugins/captcha/faq/" target="_blank">' . __( 'FAQ', 'captcha-plus' ) . '</a>';
			$links[]	=	'<a href="http://support.bestwebsoft.com">' . __( 'Support', 'captcha-plus' ) . '</a>';
		}
		return $links;
	}
}

if ( ! function_exists ( 'cptchpls_plugin_banner' ) ) {
	function cptchpls_plugin_banner() {
		global $hook_suffix, $cptchpls_plugin_info, $cptchpls_options;
		$captcha_page = isset( $_GET['page'] ) && 'captcha-plus.php' == $_GET['page'] ? true : false;
		
		if ( 'plugins.php' == $hook_suffix ) {
			bws_plugin_banner_to_settings( $cptchpls_plugin_info, 'cptchpls_options', 'captcha', 'admin.php?page=captcha-plus.php' );
		}

		if ( $hook_suffix == 'plugins.php' || $captcha_page ) {
			if ( empty( $cptchpls_options ) )
				$cptchpls_options = get_option( 'cptchpls_options' );
			if ( ! isset( $cptchpls_options['display_notice_about_images'] ) || 1 == $cptchpls_options['display_notice_about_images'] ) { 
				if ( $captcha_page ) {
					$cptchpls_options['display_notice_about_images'] = 0;
					update_option( 'cptchpls_options', $cptchpls_options ); 
					$settings_link = 'Captcha';
				} else {
					$settings_link = '<a href="' . admin_url( 'admin.php?page=captcha-plus.php' ) .'">Captcha</a>';
				} ?>
				<div class="update-nag"><?php echo sprintf( __( 'Try New %s: with Pictures Now!', 'captcha-plus' ), $settings_link ); ?></div>
			<?php }
		}
		
		if ( $captcha_page ) {
			bws_plugin_suggest_feature_banner( $cptchpls_plugin_info, 'cptchpls_options', 'captcha' );
		}
	}
}

/* Function for interaction with Limit Attempts plugin */
if ( ! function_exists( 'cptchpls_lmtttmpts_interaction' ) ) {
	function cptchpls_lmtttmpts_interaction() {
		global $cptchpls_options;
		$str_key = $cptchpls_options['cptchpls_str_key']['key'];
		if ( 1 == $cptchpls_options['cptchpls_login_form'] ) { /* check for captcha existing in login form */
			if ( isset( $_REQUEST['cptchpls_result'] ) && isset( $_REQUEST['cptchpls_number'] ) && isset( $_REQUEST['cptchpls_time'] ) ) { /* check for existing request by captcha */
				if ( 0 !== strcasecmp( trim( cptchpls_decode( $_REQUEST['cptchpls_result'], $str_key, $_REQUEST['cptchpls_time'] ) ), $_REQUEST['cptchpls_number'] ) ) { /* is captcha wrong */
					if ( isset( $_SESSION["cptchpls_login"] ) && false === $_SESSION["cptchpls_login"] ) {
						return false; /* wrong captcha */
					}
				}
			}
		}
		return true; /* no captcha in login form or its right */
	}
}


/* add help tab */
if ( ! function_exists( 'cptchpls_add_tabs' ) ) {
	function cptchpls_add_tabs() {
		$args = array(
			'id'      => 'cptchpls',
			'section' => '200538879'
		);
		bws_help_tab( get_current_screen(), $args );
	}
}

/* Function for delete delete options */
if ( ! function_exists ( 'cptchpls_delete_options' ) ) {
	function cptchpls_delete_options() {
		global $wpdb;
		$all_plugins = get_plugins();
		$another_captcha = array_key_exists( 'captcha/captcha.php', $all_plugins ) || array_key_exists( 'captcha-pro/captcha-pro.php', $all_plugins ) ? true : false;
		if ( is_multisite() ) {
			$old_blog = $wpdb->blogid;
			/* Get all blog ids */
			$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
			foreach ( $blogids as $blog_id ) {
				switch_to_blog( $blog_id );
				delete_option( 'cptchpls_options' );
				if ( ! $another_captcha ) {
					$prefix = 1 == $blog_id ? $wpdb->base_prefix : $wpdb->base_prefix . $blog_id . '_';
					$wpdb->query( "DROP TABLE `{$prefix}cptch_whitelist`;" );
				}
			}
			switch_to_blog( $old_blog );
		} else {
			delete_option( 'cptchpls_options' );
			if ( ! $another_captcha )
				$wpdb->query( "DROP TABLE `{$wpdb->prefix}cptch_whitelist`;" );
		}
		/* delete images */
		if ( ! $another_captcha ) {
			$wpdb->query( "DROP TABLE `{$wpdb->base_prefix}cptch_images`, `{$wpdb->base_prefix}cptch_packages`;" );
			if ( is_multisite() ) {
				switch_to_blog( 1 );
				$upload_dir = wp_upload_dir();
				restore_current_blog();
			} else {
				$upload_dir = wp_upload_dir();
			}
			$images_dir = $upload_dir['basedir'] . '/bws_captcha_images';
			$packages   = scandir( $images_dir );
			if ( is_array( $packages ) ) {
				foreach ( $packages as $package ) {
					if ( ! in_array( $package, array( '.', '..' ) ) ) {
						/* remove all files from package */
						array_map( 'unlink', glob( $images_dir . "/" . $package . "/*.*" ) ); 
						/* remove package */
						rmdir( $images_dir . "/" . $package );
					}
				}
			}
			rmdir( $images_dir );
		}

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}

/* Add global setting for Captcha */
global $cptchpls_options, $cptchpls_ip_in_whitelist, $cptchpls_time;
$cptchpls_time            = time();
$cptchpls_options         = get_option( 'cptchpls_options' );
if ( empty( $cptchpls_options ) ) {
	cptchpls_settings();
	$cptchpls_options = get_option( 'cptchpls_options' );
}

$cptchpls_ip_in_whitelist = is_admin() ? false : cptchpls_whitelisted_ip();

if ( ! $cptchpls_ip_in_whitelist || ! empty( $cptchpls_options['whitelist_message'] ) ) {
	/* Add captcha into login form */
	if ( 1 == $cptchpls_options['cptchpls_login_form'] ) {
		add_action( 'login_form', 'cptchpls_login_form' );
		if ( ! $cptchpls_ip_in_whitelist )
			add_filter( 'authenticate', 'cptchpls_login_check', 21, 1 );	
	}
	/* Add captcha into comments form */
	if ( 1 == $cptchpls_options['cptchpls_comments_form'] ) {
		global $wp_version;
		if ( version_compare( $wp_version,'3','>=' ) ) { /* wp 3.0 + */
			add_action( 'comment_form_after_fields', 'cptchpls_comment_form_wp3', 1 );
			add_action( 'comment_form_logged_in_after', 'cptchpls_comment_form_wp3', 1 );
		}
		/* For WP before WP 3.0 */
		add_action( 'comment_form', 'cptchpls_comment_form' );
		if ( ! $cptchpls_ip_in_whitelist )
			add_filter( 'preprocess_comment', 'cptchpls_comment_post' );	 
	}
	/* Add captcha in the register form */
	if ( 1 == $cptchpls_options['cptchpls_register_form'] ) {
		add_action( 'register_form', 'cptchpls_register_form' );		
		add_action( 'signup_extra_fields', 'wpmu_cptchpls_register_form' );
		add_action( 'signup_blogform', 'wpmu_cptchpls_register_form' );
		if ( ! $cptchpls_ip_in_whitelist ) {
			add_filter( 'registration_errors', 'cptchpls_register_check', 10, 1 );
			if ( function_exists( 'is_multisite' ) ) {
				if ( is_multisite() ) {
					add_filter( 'wpmu_validate_user_signup', 'cptchpls_register_validate' );
				}
			}
		}
	}
	/* Add captcha into lost password form */
	if ( 1 == $cptchpls_options['cptchpls_lost_password_form'] ) {
		add_action( 'lostpassword_form', 'cptchpls_lostpassword_form' );
		if ( ! $cptchpls_ip_in_whitelist )
			add_filter( 'allow_password_reset', 'cptchpls_lostpassword_check' );
	}
	if ( isset( $cptchpls_options['cptchpls_contact_form'] ) && 1 == $cptchpls_options['cptchpls_contact_form'] ) {
		add_filter( 'cntctfrm_display_captcha', 'cptchpls_custom_form', 10, 3 );		
		add_filter( 'cntctfrmpr_display_captcha', 'cptchpls_custom_form', 10, 3 );
		if ( ! $cptchpls_ip_in_whitelist ) {
			add_filter( 'cntctfrm_check_form', 'cptchpls_check_custom_form' );
			add_filter( 'cntctfrmpr_check_form', 'cptchpls_check_custom_form' );
		}
	}
}
/* Add captcha to Contact Form 7 */
if ( isset( $cptchpls_options['cptchpls_cf7'] ) && 1 == $cptchpls_options['cptchpls_cf7'] ) {
	require_once( dirname( __FILE__ ) . '/includes/captcha_for_cf7.php' );
	/* add shortcode handler */
	add_action( 'init', 'wpcf7_add_shortcode_bws_captcha', 5 );
	/* tag generator */
	add_action( 'admin_init', 'wpcf7_add_tag_generator_bws_captcha', 45 );
	if ( ! $cptchpls_ip_in_whitelist ) {
		/* validation for captcha */
		add_filter( 'wpcf7_validate_bwscaptcha', 'wpcf7_bws_captcha_validation_filter', 10, 2 );
		/* add messages for Captha errors */
		add_filter( 'wpcf7_messages', 'wpcf7_bwscaptcha_messages' );
		/* add warning message */
		add_action( 'wpcf7_admin_notices', 'wpcf7_bwscaptcha_display_warning_message' );
	}
}

register_activation_hook( __FILE__, 'cptchpls_plugin_activate' );

add_action( 'admin_menu', 'cptchpls_admin_menu' );

add_action( 'init', 'cptchpls_init' );
add_action( 'admin_init', 'cptchpls_admin_init' );

add_action( 'plugins_loaded', 'cptchpls_plugins_loaded' );

/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'cptchpls_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'cptchpls_register_plugin_links', 10, 2 );

add_action( 'admin_notices', 'cptchpls_plugin_banner' );

add_action( 'admin_enqueue_scripts', 'cptchpls_admin_head' );
add_action( 'wp_enqueue_scripts', 'cptchpls_front_end_scripts' );
add_action( 'login_enqueue_scripts', 'cptchpls_front_end_scripts' );

add_action( 'wp_ajax_cptchpls_reload', 'cptchpls_reload' );
add_action( 'wp_ajax_nopriv_cptchpls_reload', 'cptchpls_reload' );

register_uninstall_hook( __FILE__, 'cptchpls_delete_options' );