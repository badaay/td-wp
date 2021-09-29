<?php

  //include the main class file
  require_once("admin-settings/admin-page-class.php");
  
  
  /**
   * configure your admin page
   */
  $config = array(    
    'menu'           => array('top' => 'gts-preloader'), //sub page to settings page
    'page_title'     => __('GTS Preloader','apc'), //The name of this page 
    'capability'     => 'edit_themes', // The capability needed to view the page 
    'option_group'   => 'preloader_options', //the name of the option to create in the database
    'id'             => 'admin_page', // meta box id, unique per page
    'fields'         => array(), // list of fields (can be added by field arrays)
    'local_images'   => false, // Use local or hosted images (meta box images for add/remove)
    'icon_url'   => plugin_dir_url(__FILE__).'img/loader.png', // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );  
  
  /**
   * instantiate your admin page
   */
  $options_panel = new BF_Admin_Page_Class($config);
  $options_panel->OpenTabs_container('');
  
  /**
   * define your admin page tabs listing
   */
  $options_panel->TabsListing(array(
    'links' => array(
      'options_1' =>  __('Preloader Settings','apc'),
      'options_2' =>  __('Help','apc'),
    )
  ));
  
  /**
   * Open admin page first tab
   */
  $options_panel->OpenTab('options_1');

  /**
   * Add fields to your admin page first tab
   * 
   * Simple options:
   * input text, checbox, select, radio 
   * textarea
   */
  //title
  $options_panel->Title(__("Preloader Options","apc"));
  //An optionl paragraph
  $options_panel->addParagraph(__("Here you can manage setting for <b>'GTS Preloader'</b> plugin. Please see the help tab to find settings related help. Thanks for using GTS plugins.","apc"));
  
  //preloader status
  $options_panel->addCheckbox('preloader_state',array('name'=> __('Preloader Status ','apc'), 'std' => true, 'desc' => __('You can on/off your site preloader from this option.','apc')));
  
  //show only in homepage
  $options_panel->addCheckbox('home_state',array('name'=> __('Show only in Front/Home Page ','apc'), 'std' => false, 'desc' => __('If you want to load preloader in only home page or front page, then make this option ON.','apc')));
  
  //select field for prestyle animation
  $options_panel->addSelect('animaton_icon',array('icon1.gif'=>'Icon 1','icon2.gif'=>'Icon 2','icon3.gif'=>'Icon 3','icon4.gif'=>'Icon 4','icon5.gif'=>'Icon 5','icon6.gif'=>'Icon 6','icon7.gif'=>'Icon 7','icon8.gif'=>'Icon 8','icon9.gif'=>'Icon 9','icon10.gif'=>'Icon 10'),array('name'=> __('Select Animation Icon ','apc'), 'std'=> array('Icon 1'), 'desc' => __('Select your site\'s loading icon.','apc')));
  
  //Image field
  $options_panel->addImage('custom_image_icon',array('name'=> __('Upload A Custom Loading Icon ','apc'),'preview_height' => '120px', 'preview_width' => '120px', 'desc' => __('You can upload your custom loading icon here. You can generate your own loader from this url : http://preloaders.net/','apc')));
  
  //Page BG Color field
  $options_panel->addColor('page_bg_color',array('name'=> 'Page Background Color ', 'std'=> '#000', 'desc' => __('Select the background color of loading page. #000 is default.','apc') ) );
  
  //Page BG Color opacity field
  $options_panel->addText('page_bg_opacity', array('name'=> __('Page Background Color Opacity ','apc'), 'std'=> '0.8', 'desc' => __('Opacity for page background color. 1 means full opacity. 0.5 means half fill opacity. 0.8 is default','apc')));
  
  //preloader loading status
  $options_panel->addCheckbox('loading_state',array('name'=> __('Loading Label Status ','apc'), 'std' => true, 'desc' => __('You can on/off your site preloader \'Loading\' label from this option.','apc')));
  
  //Page BG Color field
  $options_panel->addText('loading_text', array('name'=> __('Loading Label Text ','apc'), 'std'=> 'Page Loading...', 'desc' => __('You can set loading label text from here.','apc')));
  
  //Page loading text Color field
  $options_panel->addColor('loading_text_color',array('name'=> 'Loading Label Text Color ', 'std'=> '#fff', 'desc' => __('Select the text color of loading label text.','apc') ) );
  
  /**
   * Close first tab
   */   
  $options_panel->CloseTab();

   
  /**
   * Open admin page Second tab
   */
  $options_panel->OpenTab('options_2');
  
  $options_panel->addParagraph(__("<b>'GTS Preloader'</b> is a WordPress plugin that enable a nice loading effect while your site or page is in loading mode.
<br/>
<br/>
You can manage settings for this plugin from <b>'Admin Dashboard --> GTS Preloader'</b>","apc"));

  $options_panel->addParagraph(__("
  <b>Options:</b>
    <br/><br/>
	1. <b>Preloader Status</b><br/><br/>

	   Status of preloader. Default is 'On'. You can switch preloader off from this option.
	<br/><br/>  
	2. <b>Select Animation Icon</b><br/><br/>

	   From this option you can select a loading icon for your site/page.
	  <br/><br/> 
	3. <b>Upload a Custom Loading Icon</b><br/><br/>

	   You can upload and set your own page loading icon from this option. To generate your own icon you can visit website 
	   like: http://preloaders.net/
	   <br/><br/>
	4. <b>Page Background Color</b><br/><br/>

	   Page background color while your site is in loading mode. Default color is #000 (Black). You can pick your own color
	   as loading page background color.
	   <br/><br/>
	5. <b>Page Background Color Opacity</b><br/><br/>

	   Opacity of page background color while your site is in loading mode. 
	   Default opacity value is 0.8 (80% of your page background color). You can set your own value here. 
	   1 means 100%, 0.5 means 50% opacity.
	   <br/><br/>
	6. <b>Loading Label Status</b><br/><br/>

	   Status of your loading label. If you keep this feature 'On', then label like 'Loading...' or something set by you 
	   will show when your page is loading.
	   <br/><br/>
	7. <b>Loading Label Text</b><br/><br/>

	   Text for 'Loading' label. Default is 'Page Loading...'. You can type your own status label.
	   <br/><br/>
	8. <b>Loading Label Text Color</b><br/><br/>

	   Text color for loading label. Default is '#FFF' (White). You can choose your own color.
	   <br/>
  ","apc"));
  
  /**
   * Close second tab
   */ 
  $options_panel->CloseTab();