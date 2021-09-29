<?php
/**
    ADD DEMO IMPORT MENU
**/
if ( ! function_exists('navian_add_import_link') ) {
	function navian_add_import_link() {
		add_theme_page( 
			esc_html__( 'Install Demo', 'navian' ), 
			esc_html__( 'Install Demo', 'navian' ), 
			'manage_options', 
			'one-click-demo',
			'navian_import' );
	}
	add_action( 'admin_menu', 'navian_add_import_link' );
}

/**
    DEMO IMPORTER
**/
if ( ! function_exists( 'navian_import' ) ) {
	function navian_import() {
		$file = get_template_directory().'/inc/importer/demo-files/content.xml';
		if (isset($_POST['import'])) {
			if (isset($_POST['all']) && 'ON' == $_POST['all']) {
				navian_import_content( $file );
				navian_import_widgets();
				if (class_exists('RevSliderSliderImport')) {
					navian_import_slider();
				}
			}
			if (isset($_POST['content']) && 'ON' == $_POST['content']) {
				navian_import_content( $file );
			}
			if (isset($_POST['widget']) && 'ON' == $_POST['widget']) {
				navian_import_widgets();
			}
			if (isset($_POST['slider']) && 'ON' == $_POST['slider']) {
				if (class_exists('RevSliderSliderImport')) {
					navian_import_slider();
				}
			}
			?>
			<div class="wrap">
				<div class="tlg-import-msg finish">
					<h1><?php echo esc_html__( 'Import completed!', 'navian' ) ?></h1>
					<p><a href="<?php echo site_url(); ?>" target="_blank"><?php echo esc_html__( 'Visit Site.', 'navian' ) ?></a></p>
					<div class="tlg-importer-alert text-left">
						<strong><?php echo esc_html__( 'NOTES:', 'navian' ) ?></strong>
						<ol>
							<li><?php echo wp_kses( __( 'If the One-Click Import did not work for any reason, please refer to the <a href="http://www.themelogi.com/docs/navian/#!/demo_import" target="_blank">Theme Documentation</a> so you can install the Demo Content manually or check <a href="http://www.themelogi.com/docs/navian/#!/common_issue">common Import issues</a>.', 'navian' ), navian_allowed_tags() ) ?></li>
							<li><?php echo wp_kses( __( 'In case of any missing data, you can try to re-install demo content via <strong>Advanced demo content import</strong>.', 'navian' ), navian_allowed_tags() ) ?></li>
						</ol>
					</div>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="wrap">
				<form class="tlg-importer" action="?page=one-click-demo" method="post">
					<?php if( file_exists( $file ) ) { ?>
					<div>
						<h2><?php echo esc_html__( 'Install demo content', 'navian' ) ?></h2>
						<div class="tlg-importer-alert">
							<strong><?php echo esc_html__( 'NOTES:', 'navian' ) ?></strong>
							<ol>
								<li class="tlg-importer-note"><?php echo esc_html__( 'Please click on the Import button only once and wait, it can take few minutes. Please be patient and DO NOT close the browser or navigate away. The import procedure can take up to 15mins on slow servers and you will see the messages when the import is done.', 'navian' ) ?></li>
								<li><?php echo esc_html__( 'It\'s always recommended to run the import on a clean installtion of WordPress.', 'navian' ) ?></li>
								<li><?php echo esc_html__( 'Make sure you\'ve installed all the required plugins before running the Importer. Also, if the "WordPress Importer" plugin is installed and activated in your site. please deactivate it before you run this demo import process ', 'navian' ) ?></li>
								<li><?php echo esc_html__( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'navian' ) ?></li>
								<li><?php echo esc_html__( 'The images in demos are copyrighted which are not included in the theme package. Simply replace these images with your own.', 'navian' ) ?></li>
								<li><?php echo esc_html__( 'If the One-Click Import did not work for any reason (it is normally due to host performances), you can install the Demo Content manually as described in the Theme Documentation.', 'navian' ) ?></li>
							</ol>
						</div>
						<input name="import" type="submit" class="tlg_import_btn button button-primary button-large" value="<?php echo esc_html__( 'Import', 'navian' ) ?>">
						<input class="tlg-hide" id="all" type="checkbox" value="ON" name="all" checked="checked">
						<p><?php echo wp_kses( __( 'In case the One-Click Import did not work or any other missing data, you can try to re-install demo content using <strong><a href="#" class="advanded_import_btn">Advanced demo content import</a></strong> or have a look at our <strong><a href="http://www.themelogi.com/tickets/topic/faq/" target="_blank">FAQs page</a></strong> for the solution.', 'navian' ), navian_allowed_tags() ) ?></p>
					</div>
					<?php } else { ?>
						<div class="tlg-import-msg">
							<h1><?php echo esc_html__( 'The XML file containing the dummy content is not available or could not be read...', 'navian' ) ?></h1>
						</div>
					<?php } ?>
				</form>
				<div class="tlg-import-msg advanded" style="display:none">
					<form class="tlg-importer-advanded" action="?page=one-click-demo" method="post">
						<div>
							<h2><?php echo esc_html__( 'Advanced demo content import', 'navian' ) ?></h2>
							<div class="tlg-importer-alert">
								<p><?php echo wp_kses( __( 'If you have any problems with the importing, please refer to the <a href="http://www.themelogi.com/docs/navian/#!/common_issue" target="_blank">Common Issues with Importing Data</a> for the solutions.', 'navian' ), navian_allowed_tags() ) ?></p>
								</ol>
							</div>
							<input class="tlg-hide" id="content" type="checkbox" value="ON" name="content" checked="checked">
							<input type="hidden" name="ids" id="ids" class="ids" value="" />
							<input name="import" type="submit" class="tlg_import_btn_advanded button button-primary button-large" value="<?php echo esc_html__( 'Import Demo Content Only', 'navian' ) ?>">

							<p><a href="#" class="quick_import_btn"><?php echo esc_html__( 'Back to Quick demo content import', 'navian' ) ?></a></p>
						</div>
					</form>
					<form class="tlg-importer-advanded-meta" action="?page=one-click-demo" method="post">
						<div class="tlg-divider">
							<div>
								<label>
									<input id="widget" type="checkbox" value="ON" name="widget" checked="checked">
									<span><?php echo esc_html__( 'Import Widgets', 'navian' ) ?></span>
								</label>
								<?php if (class_exists('RevSliderSliderImport')) : ?>
								<span style="display:inline-block;width:20px;"></span>
								<label>
									<input id="slider" type="checkbox" value="ON" name="slider" checked="checked">
									<span><?php echo esc_html__( 'Import Revolution Sliders', 'navian' ) ?></span>
								</label>
								<?php endif; ?>
							</div>
							<div style="clear:both; margin-bottom: 20px;"></div>
							<input type="hidden" name="ids" id="ids" class="ids" value="" />
							<input name="import" type="submit" class="tlg_import_btn_advanded_meta button button-primary button-large" value="<?php echo esc_html__( 'Import', 'navian' ) ?>">
						</div>
					</form>
				</div>
				<div class="tlg-import-msg progress" style="display:none">
					<div class="tlg-spinner-wrap"><div class="tlg-spinner"></div></div>
					<h1><?php echo esc_html__( 'Importing Demo Content...', 'navian' ) ?></h1>
					<div class="tlg-importer-alert text-left">
						<strong><?php echo esc_html__( 'NOTES:', 'navian' ) ?></strong>
						<ol>
							<li><?php echo esc_html__( 'Please be patient and DO NOT close the browser or navigate away. The import procedure can take up to 15mins on slow servers and you will see the messages when the import is done.', 'navian' ) ?></li>
							<li><?php echo esc_html__( 'If you haven\'t had a notification in 20mins, use the fallback method in the Theme Documentation.', 'navian' ) ?></li>
						</ol>
					</div>
				</div>
			</div>
			<script>
				jQuery(document).ready(function() {
					jQuery(document).on('click', '.tlg_import_btn', function(e) {
						jQuery('.tlg-importer').fadeOut(0);
						jQuery('.tlg-import-msg.progress').fadeIn();
					});
					jQuery(document).on('click', '.tlg_import_btn_advanded', function(e) {
						jQuery('.tlg-import-msg.advanded').fadeOut(0);
						jQuery('.tlg-import-msg.progress').fadeIn();
						var ids = jQuery( 'form.tlg-importer-advanded' ).serialize();
						jQuery('.ids').val( ids );
					});
					jQuery(document).on('click', '.tlg_import_btn_advanded_meta', function(e) {
						jQuery('.tlg-import-msg.advanded').fadeOut(0);
						jQuery('.tlg-import-msg.progress').fadeIn();
					});
					jQuery(document).on('click', '.advanded_import_btn', function(e) {
						e.preventDefault();
						jQuery('.tlg-importer').fadeOut(0);
						jQuery('.tlg-import-msg.advanded').fadeIn();
					});
					jQuery(document).on('click', '.quick_import_btn', function(e) {
						e.preventDefault();
						jQuery('.tlg-import-msg.advanded').fadeOut(0);
						jQuery('.tlg-importer').fadeIn();
					});
				});
			</script>
			<?php
		}
	}
}

/**
    CONTENT IMPORTER
**/
if ( ! function_exists( 'navian_import_content' ) ) {
	function navian_import_content($file) {
		set_time_limit(0);
		global $wp_filesystem;
		if (!defined('WP_LOAD_IMPORTERS')) {
			define('WP_LOAD_IMPORTERS', true);
		}
		if (!class_exists('WP_Import')) {
			require_once (TLG_FRAMEWORK_PATH . 'includes/lib/importer/wordpress-importer.php');
		}
		if (empty($wp_filesystem)) {
		  	require_once (ABSPATH . '/wp-admin/includes/file.php');
		  	WP_Filesystem();
		}
		$response = $wp_filesystem->get_contents($file);
		if ($response) {
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			$wp_import->import( $file );
			$menu = get_term_by('name', 'Quick links', 'nav_menu');
			if (isset($menu->term_id)) {
				set_theme_mod( 'nav_menu_locations', array( 'search' => $menu->term_id ) );
			}
			$menu = get_term_by('name', 'Footer Menu', 'nav_menu');
			if (isset($menu->term_id)) {
				set_theme_mod( 'nav_menu_locations', array( 'footer' => $menu->term_id ) );
			}
			$menu = get_term_by('name', 'Primary Menu', 'nav_menu');
			if (isset($menu->term_id)) {
				set_theme_mod( 'nav_menu_locations', array( 'primary' => $menu->term_id ) );
			}
			$home = get_page_by_title( 'Home' );
			if (isset($home->ID)) {
				update_option('page_on_front',  $home->ID);
				update_option('show_on_front', 'page');
			}
		}
	}
}

/**
    SLIDER IMPORTER
**/
if ( ! function_exists( 'navian_import_slider' ) ) {
	function navian_import_slider() {
		set_time_limit(0);
		ob_start();
		$sliders = array('home-slider-1', 'home-slider-2', 'home-slider-3', 'home-slider-4', 'home-slider-5');
		foreach ($sliders as $slider) {
			$file = get_template_directory().'/inc/importer/demo-files/sliders/'.$slider.'.zip';
			if (file_exists($file)) {
				$_FILES["import_file"]["tmp_name"] = $file;
				$slider = new RevSliderSliderImport();
				$slider->import_slider();
				unset($slider);
			}
		}
		ob_end_clean();
	}
}

/**
    WIDGETS IMPORTER
**/
if ( ! function_exists( 'navian_import_widgets' ) ) {
	function navian_import_widgets() {
		set_time_limit(0);
		global $wp_registered_sidebars, $wp_filesystem;
		$file = get_template_directory().'/inc/importer/demo-files/widgets.json';
		if (file_exists($file)) {
			if (empty($wp_filesystem)) {
			  	require_once (ABSPATH . '/wp-admin/includes/file.php');
			  	WP_Filesystem();
			}
			$response = $wp_filesystem->get_contents($file);
			$data = json_decode( $response, false );
			if (!empty($data)) {
				$list_widgets = navian_list_widgets();
				$widget_instances = array();
				if (count($list_widgets)) {
					foreach ($list_widgets as $widget_data) {
						$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
					}
				}
				foreach ($data as $sidebar_id => $widgets) {
					if ('wp_inactive_widgets' == $sidebar_id) continue;
					if (isset($wp_registered_sidebars[$sidebar_id])) {
						$sidebar_available = true;
						$use_sidebar_id = $sidebar_id;
					} else {
						$sidebar_available = false;
						$use_sidebar_id = 'wp_inactive_widgets';
					}
					foreach ($widgets as $widget_instance_id => $widget) {
						$fail = false;
						$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
						$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );
						if (!$fail && !isset($list_widgets[$id_base])) {
							$fail = true;
						}
						if (!$fail && isset($widget_instances[$id_base])) {
							$sidebars_widgets = get_option( 'sidebars_widgets' );
							$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array();
							$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
							foreach ($single_widget_instances as $check_id => $check_widget) {
								if (in_array("$id_base-$check_id", $sidebar_widgets) && (array) $widget == $check_widget) {
									$fail = true;
									break;
								}
							}
						}
						if (!$fail) {
							$single_widget_instances = get_option( 'widget_' . $id_base );
							$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 );
							$single_widget_instances[] = (array) $widget;
							end( $single_widget_instances );
							$new_instance_id_number = key( $single_widget_instances );
							if ('0' === strval( $new_instance_id_number)) {
								$new_instance_id_number = 1;
								$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
								unset( $single_widget_instances[0] );
							}
							if (isset($single_widget_instances['_multiwidget'])) {
								$multiwidget = $single_widget_instances['_multiwidget'];
								unset($single_widget_instances['_multiwidget']);
								$single_widget_instances['_multiwidget'] = $multiwidget;
							}
							update_option('widget_' . $id_base, $single_widget_instances);
							$sidebars_widgets = get_option('sidebars_widgets');
							$new_instance_id = $id_base . '-' . $new_instance_id_number;
							$sidebars_widgets[$use_sidebar_id][] = $new_instance_id;
							update_option('sidebars_widgets', $sidebars_widgets);
						}
					}
				}
			}
		}
	}
}

/**
    LIST WIDGETS
**/
if ( ! function_exists( 'navian_list_widgets' ) ) {
	function navian_list_widgets() {
    	global $wp_registered_widget_controls;
    	$widget_controls = $wp_registered_widget_controls;
    	$list_widgets = array();
    	foreach ($widget_controls as $widget) {
    		if (!empty($widget['id_base']) && !isset($list_widgets[$widget['id_base']])) {
    			$list_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
    			$list_widgets[$widget['id_base']]['name'] = $widget['name'];
    		}
    	}
    	return $list_widgets;
	}
}