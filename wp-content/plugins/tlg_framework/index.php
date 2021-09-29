<?php
/*
Plugin Name: TLG Framework
Plugin URI: http://www.themelogi.com
Description: The custom post types, widgets and shortcodes for THEMELOGI's WordPress Themes.
Version: 3.0.8
Author: THEMELOGI
Author URI: http://www.themelogi.com
*/
define( 'TLG_FRAMEWORK_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'TLG_FRAMEWORK_URL', trailingslashit(plugin_dir_url(__FILE__)) );
define( 'TLG_FRAMEWORK_PLACEHOLDER', TLG_FRAMEWORK_URL . 'assets/img/placeholder.png');
define( 'TLG_FRAMEWORK_PLACEHOLDER_SQUARE', TLG_FRAMEWORK_URL . 'assets/img/placeholder_square.png');

if( !function_exists( 'tlg_framework_textdomain' ) ) {
	function tlg_framework_textdomain() {
	  	load_plugin_textdomain( 'tlg_framework', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	add_action( 'plugins_loaded', 'tlg_framework_textdomain' );
}

if( !function_exists( 'tlg_framework_setup' ) ) {
	function tlg_framework_setup() {
	    wp_enqueue_script( 'tlg_framework-script', TLG_FRAMEWORK_URL. 'assets/js/admin.js', array('jquery') );
	    wp_enqueue_style( 'tlg_framework-admin-style', TLG_FRAMEWORK_URL. 'assets/css/admin.css', array());
	    wp_localize_script( 'tlg_framework-script', 'wp_ajax', array(
	    	'ajax_url' => admin_url( 'admin-ajax.php' ),
			'theme_name' => wp_get_theme()->get( 'Name' ),
		));
	}
	add_action( 'admin_enqueue_scripts','tlg_framework_setup' );
}

require_once( TLG_FRAMEWORK_PATH . 'includes/lib/lessc.inc.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/wp-less.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/aq_resize.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/metaboxes/init.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_cpt.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_helper.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_layouts.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_shortcodes.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_widgets.php' );
if( function_exists( 'vc_set_as_theme' ) ) {
	require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_modules.php' );
	function tlg_framework_vc_modules_setup() {
	    new TLGFrameworkVCModules();
	}
	add_action('admin_init', 'tlg_framework_vc_modules_setup');
}