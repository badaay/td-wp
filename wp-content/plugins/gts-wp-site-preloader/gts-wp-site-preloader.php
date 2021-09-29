<?php
/*
Plugin Name: WordPress Site Preloader
Plugin URI: http://www.gtsoftbd.com
Description: 'GTS WordPress Site Preloader' is a plugin to give nice effects while your site is in loading mode. You can use custom settings from plugin settings.
Version: 1.2.0
Author: Global Trend Soft.
Author URI: http://www.gtsoftbd.com
License: Single User License
*/

//getting the data to an array
$gtsData = get_option('preloader_options');

//Checking preloader state
$preloaderState = $gtsData['preloader_state'];
$onlyHomeState = $gtsData['home_state'];


function preloader_script_init(){

	$myPluginBasePath = plugin_dir_url(__FILE__);
	
	wp_enqueue_script('jquery');

	if( !is_admin() ){
	    wp_register_style('preloader-css-2', $myPluginBasePath.'css/preLoadMe.css');
		wp_enqueue_style('preloader-css-2');
	}
}

//Initializing Preloader action
add_action('init', 'preloader_script_init');

//Checking Preloader State, If found false, then removing action
if( isset($preloaderState) && $preloaderState == 0 ){
  remove_action('init', 'preloader_script_init');
}

//Adding preloader HTML block
function gts_preloader_footer_init() 
{
  $gtsData = get_option('preloader_options');
  $loadingText = $gtsData['loading_text'];
  $onlyHomeState = 0;
  $onlyHomeState = $gtsData['home_state'];
  
  if( empty($loadingText) ){
    $loadingText = "Loading Page...";
  }
  
?>
	<?php if ( $onlyHomeState == 1 ) { if ( is_front_page() ) { ?>
	<!-- Preloader -->
	<div id="preloader">
		<div id="status2"><?php echo $loadingText; ?></div>
		<div id="status">&nbsp;</div>
	</div>
	<?php  } } else{ ?>
	<!-- Preloader -->
	<div id="preloader">
		<div id="status2"><?php echo $loadingText; ?></div>
		<div id="status">&nbsp;</div>
	</div>	
	<?php } ?>
	
<?php

}

add_action('wp_footer', 'gts_preloader_footer_init');


//Adding Preloader Header code

function gts_preloader_head_init() 
{

 $myPluginBasePath = plugin_dir_url(__FILE__);
 
 $gtsData = get_option('preloader_options');
 
 //Icon
 $animationIcon = $gtsData['animaton_icon'];
 
 if(empty($animationIcon)){
    $animationIcon = 'icon1.gif';
 }
 
 $finalIconPath = $myPluginBasePath.'img/'.$animationIcon;
 
 if( !empty( $gtsData['custom_image_icon']['src'] ) && $gtsData['custom_image_icon']['src'] != "" ){
    $finalUploadPath = $gtsData['custom_image_icon']['src'];
	$finalIconPath = $finalUploadPath;
 }
 
 //Page Background
 $pageBgColor = $gtsData['page_bg_color'];
 
 if( empty($pageBgColor) ){
    $pageBgColor = "#000000";
 }
 
 //Page Background Color Opacity
 $pageBgColorOpacity = $gtsData['page_bg_opacity'];
 
 if( empty($pageBgColorOpacity) ){
    $pageBgColorOpacity = "0.8";
 }
 
 //Page Loading Label State
 $loadingLabelState = $gtsData['loading_state'];
 
 if( !isset($loadingLabelState) ){
    $loadingLabelState = true;
 }
 
 //Page Loading Label Color
 $loadingLabelColor = $gtsData['loading_text_color'];
 
 if( empty($loadingLabelColor) ){
    $loadingLabelColor = "#00ff00";
 }

?>
	<!-- Preloader -->
	
	<script type="text/javascript">
		
		//<![CDATA[
			jQuery(window).load(function() { // makes sure the whole site is loaded
				jQuery('#status').fadeOut(); // will first fade out the loading animation
				jQuery('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
				jQuery('body').delay(350).addClass("overflow_show_preload");
				jQuery('html').delay(350).addClass("overflow_show_preload");
			})
		//]]>
	</script>
	<style type="text/css">
	   #preloader{
			background: <?php echo $pageBgColor; ?>;
			opacity: <?php echo $pageBgColorOpacity; ?>;
		}
		
	   #status2 {
            <?php if( $loadingLabelState == false ) : ?>
			display: none !important;
			<?php endif; ?>
			color: <?php echo $loadingLabelColor; ?>;
		}
	   #status{
			<?php if( !empty($finalIconPath) ) : ?>
			background-image:url(<?php echo $finalIconPath; ?>);
			<?php endif; ?>
		}
	</style>
<?php

}

if( !isset($preloaderState) ){
  $preloaderState = 1;
}

if( isset($preloaderState) && $preloaderState != 0 ){
  add_action('wp_head', 'gts_preloader_head_init');
}

//Administrator Settings
require_once('admin-settings.php');