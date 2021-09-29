<?php 
/**
 * Theme Metabox
 *
 * @package TLG Theme
 *
 */

if( !function_exists('navian_metaboxes') ) {
	function navian_metaboxes( $meta_boxes ) {
		$menus = wp_get_nav_menus();
		$menu_options = array();
		if( is_array($menus) && count($menus) ) {
			foreach($menus as $menu) {
				$menu_options[$menu->term_id] = $menu->name;
			}
		}
		$menu_options = array( 0 => esc_html__( '(default)', 'navian' ) ) + $menu_options;
		$title_options 	= array( 'default' => esc_html__( '(default)', 'navian' ) ) + tlg_framework_get_page_title_options();
		$layout_options = array( 'default' => esc_html__( '(default)', 'navian' ) ) + tlg_framework_get_site_layouts();
		$container_options = array( 'default' => esc_html__( '(default)', 'navian' ) ) + tlg_framework_get_container_layouts();
		$header_options = array( 'default' => esc_html__( '(default)', 'navian' ) ) + tlg_framework_get_header_options();
		$footer_options = array( 'default' => esc_html__( '(default)', 'navian' ) ) + tlg_framework_get_footer_options();
		$sidebar_options = array( 'default' => esc_html__( '(default)', 'navian' ) ) + tlg_framework_get_single_layouts();
		$yesno_options = array( 'default' => esc_html__( '(default)', 'navian' ), 'yes' => esc_html__( 'Yes', 'navian' ), 'no' => esc_html__( 'No', 'navian' ) );
		$text_options = array( '' => esc_html__( '(default)', 'navian' ), 'uppercase' => esc_html__( 'Uppercase', 'navian' ), 'capitalize' => esc_html__( 'Capitalize', 'navian' ), 'none' => esc_html__( 'None', 'navian' ) );
		$header_effects = array( '' => esc_html__( '(default)', 'navian' ), 'menu-effect-line' => esc_html__( 'Menu Line', 'navian' ), 'menu-effect-through' => esc_html__( 'Menu Line Through', 'navian' ), 'menu-effect-bg' => esc_html__( 'Menu Background', 'navian' ), 'menu-effect-none' => esc_html__( 'None', 'navian' ) );
		$header_dividers    = array( '' => esc_html__( '(default)', 'navian' ), 'menu-divider-light' => esc_html__( 'Light', 'navian' ), 'menu-divider-dark' => esc_html__( 'Dark', 'navian' ) );
		$prefix = '_tlg_';
		# POST SIDEBAR
		$meta_boxes[] = array(
			'id' => 'single_sidebar_metabox',
			'title' => esc_html__( 'Single Sidebar Settings', 'navian' ),
			'object_types' => array('post'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name'         	=> esc_html__( 'Single Sidebar Layout', 'navian' ),
					'desc'         	=> esc_html__( 'Default Single Sidebar Layout is set in: Appearance > Customize > Blog', 'navian' ),
					'id'           	=> $prefix . 'single_sidebar_override',
					'type'         	=> 'select',
					'options'      	=> $sidebar_options,
					'std'          	=> 'default'
				),
			),
		);
		# PORTFOLIO
		$meta_boxes[] = array(
			'id' => 'portfolio_metabox',
			'title' => esc_html__( 'Portfolio Settings', 'navian' ),
			'object_types' => array('portfolio'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
				    'name' 			=> esc_html__( 'Enable portfolio gallery lightbox?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Portfolio', 'navian' ),
				    'id'   			=> $prefix . 'portfolio_gallery',
				    'type' 			=> 'checkbox'
				),
				array(
					'name' => esc_html__( 'Link Portfolio Item to External URL', 'navian' ),
					'desc' => esc_html__( 'Enter a external URL for this project.', 'navian' ),
					'id'   => $prefix . 'portfolio_external_url',
					'type' => 'text',
				),
				array(
				    'name' => esc_html__( 'Open External URL in New Window', 'navian' ),
				    'desc' => esc_html__( 'Check this option to open external URL in new window.', 'navian' ),
				    'id'   => $prefix . 'portfolio_url_new_window',
				    'type' => 'checkbox'
				),
				array(
				    'name' => esc_html__( 'Add Nofollow for External URL', 'navian' ),
				    'desc' => esc_html__( 'Check this option to add rel=nofollow in external URL.', 'navian' ),
				    'id'   => $prefix . 'portfolio_url_nofollow',
				    'type' => 'checkbox'
				),
			),
		);
		# CLIENT
		$meta_boxes[] = array(
			'id' => 'clients_metabox',
			'title' => esc_html__( 'Client Settings', 'navian' ),
			'object_types' => array('client'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name' => esc_html__( 'Client URL', 'navian' ),
					'desc' => esc_html__( 'Enter a URL for this client.', 'navian' ),
					'id'   => $prefix . 'client_url',
					'type' => 'text',
				),
				array(
				    'name' => esc_html__( 'Open Client URL in New Window', 'navian' ),
				    'desc' => esc_html__( 'Check this option to open external URL in new window.', 'navian' ),
				    'id'   => $prefix . 'client_url_new_window',
				    'type' => 'checkbox'
				),
				array(
				    'name' => esc_html__( 'Add Nofollow for Client URL', 'navian' ),
				    'desc' => esc_html__( 'Check this option to add rel=nofollow in external URL.', 'navian' ),
				    'id'   => $prefix . 'client_url_nofollow',
				    'type' => 'checkbox'
				),
			),
		);
		# TEAM
		$meta_boxes[] = array(
			'id' => 'team_metabox',
			'title' => esc_html__( 'Team Member Settings', 'navian' ),
			'object_types' => array('team'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
				    'name' => esc_html__( 'Member description', 'navian' ),
				    'desc' => esc_html__( 'Member description for this person.', 'navian' ),
				    'id' => $prefix . 'team_about',
				    'type' => 'wysiwyg',
				    'options' => array(),
				),
				array(
					'name' => esc_html__( 'Member position', 'navian' ),
					'desc' => esc_html__( 'Member position for this person.', 'navian' ),
					'id'   => $prefix . 'team_position',
					'type' => 'text',
				),
				array(
				    'id'          => $prefix . 'team_social_icons',
				    'type'        => 'group',
				    'options'     => array(
				        'add_button'    => esc_html__( 'Add Icon', 'navian' ),
				        'remove_button' => esc_html__( 'Remove Icon', 'navian' ),
				        'sortable'      => true
				    ),
				    'fields' => array(
						array(
							'name' 			=> esc_html__( 'Social Icon', 'navian' ),
							'description' 	=> esc_html__( 'Leave text field blank for no icon.', 'navian' ),
							'id' 			=> $prefix . 'team_social_icon',
							'std' 			=> 'none',
							'type' 			=> 'tlg_social_icons',
						),
						array(
							'name' => esc_html__( 'Social URL', 'navian' ),
							'desc' => esc_html__( 'Enter the URL for Social Icon.', 'navian' ),
							'id'   => $prefix . 'team_social_icon_url',
							'type' => 'text_url',
						),
				    ),
				),
				array(
					'name' => esc_html__( 'Member URL (optional)', 'navian' ),
					'desc' => esc_html__( 'Enter a URL for this member.', 'navian' ),
					'id'   => $prefix . 'team_url',
					'type' => 'text',
				),
			)
		);
		# TESTIMONIAL
		$meta_boxes[] = array(
			'id' => 'testimonials_metabox',
			'title' => esc_html__( 'Testimonial Settings', 'navian' ),
			'object_types' => array('testimonial'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
				    'name' => esc_html__( 'Testimonial Content', 'navian' ),
				    'desc' => esc_html__( 'Enter the testimonial content.', 'navian' ),
				    'id' => $prefix . 'testimonial_content',
				    'type' => 'wysiwyg',
				    'options' => array(),
				),
				array(
					'name' => esc_html__( 'Author Info', 'navian' ),
					'desc' => esc_html__( 'Enter author infomation for this testimonial.', 'navian' ),
					'id'   => $prefix . 'testimonial_info',
					'type' => 'text',
				),
		        array(
					'name' => esc_html__( 'Author URL (optional)', 'navian' ),
					'desc' => esc_html__( 'Enter a URL for this author.', 'navian' ),
					'id'   => $prefix . 'testimonial_url',
					'type' => 'text',
				),
			)
		);
		# PAGE/POST
		$meta_boxes[] = array(
			'id' => 'page_metabox',
			'title' => esc_html__( 'Page Layout', 'navian' ),
			'object_types' => array( 'page', 'post', 'portfolio', 'product' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name'         	=> esc_html__( 'Site Layout', 'navian' ),
					'desc'         	=> esc_html__( 'Default Site Layout is set in: Appearance > Customize > Site Identity', 'navian' ),
					'id'           	=> $prefix . 'layout_override',
					'type'         	=> 'select',
					'options'      	=> $layout_options,
					'std'          	=> 'default'
				),
				array(
					'name'         	=> esc_html__( 'Container Layout', 'navian' ),
					'desc'         	=> esc_html__( 'Default Container Layout is set in: Appearance > Customize > Site Identity', 'navian' ),
					'id'           	=> $prefix . 'container_override',
					'type'         	=> 'select',
					'options'      	=> $container_options,
					'std'          	=> 'default'
				),
				array(
					'name'         	=> esc_html__( 'Header Layout', 'navian' ),
					'desc'         	=> esc_html__( 'Default Header Layout is set in: Appearance > Customize > Header', 'navian' ),
					'id'           	=> $prefix . 'header_override',
					'type'         	=> 'select',
					'options'      	=> $header_options,
					'std'          	=> 'default'
				),
				array(
					'name'         	=> esc_html__( 'Footer Layout', 'navian' ),
					'desc'         	=> esc_html__( 'Default Footer Layout is set in: Appearance > Customize > Footer', 'navian' ),
					'id'           	=> $prefix . 'footer_override',
					'type'         	=> 'select',
					'options'      	=> $footer_options,
					'std'          	=> 'default'
				),
			)
		);
		$meta_boxes[] = array(
			'id' => 'page_title_metabox',
			'title' => esc_html__( 'Default Page Title', 'navian' ),
			'object_types' => array( 'page', 'post', 'portfolio', 'product' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name' 			=> esc_html__( 'Page Title Layout', 'navian' ),
					'desc' 			=> wp_kses( __( 'Default setting is set in: Appearance > Customize > Header. <br><strong>Note:</strong> If you are using Slider or Single Header element in your page builder, please set this "Page Title Layout" option to "No Title" to remove the default title. Otherwise, if you want to display the page title with background image, please choose "Background" or "Parallax" option.', 'navian' ), navian_allowed_tags() ),
					'id' 			=> $prefix . 'page_title_layout',
					'type' 			=> 'select',
					'options' 		=> $title_options
				),
				array(
					'name' 			=> esc_html__( 'Page Title', 'navian' ),
					'desc' 			=> esc_html__( 'Enter a title for this page (optional). This will overwrite the default title.', 'navian' ),
					'id'   			=> $prefix . 'the_title',
					'type' 			=> 'text',
				),
				array(
					'name' 			=> esc_html__( 'Page Title Sub-title', 'navian' ),
					'desc' 			=> esc_html__( 'Enter a sub-title for this page (optional).', 'navian' ),
					'id'   			=> $prefix . 'the_subtitle',
					'type' 			=> 'text',
				),
				array(
					'name' 			=> esc_html__( 'Page Title Lead-title', 'navian' ),
					'desc' 			=> esc_html__( 'Enter a lead-title for this page (optional).', 'navian' ),
					'id'   			=> $prefix . 'the_leadtitle',
					'type' 			=> 'text',
				),
				array(
					'name' 			=> esc_html__( 'Page Title Background Type', 'navian' ),
					'desc' 			=> esc_html__( 'Select a background image type for page title Background or Parallax layouts.', 'navian' ),
					'id' 			=> $prefix . 'title_bg_featured',
					'type' 			=> 'select',
					'options' 		=> array( 'yes' => esc_html__( 'Featured Image', 'navian' ), 'no' => esc_html__( 'Custom Background Image', 'navian' ) )
				),
				array(
		            'name' 			=> esc_html__( 'Custom Background Image', 'navian' ),
		            'desc' 			=> esc_html__( 'Select image pattern for stunning header background.', 'navian' ),
		            'id'   			=> $prefix . 'title_bg_img',
	                'type' 			=> 'file',
		        ),
		        array(
				    'name' 			=> esc_html__( 'Hide Breadcrumbs?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Header', 'navian' ),
				    'id'   			=> $prefix . 'hide_breadcrumbs',
				    'type' 			=> 'checkbox'
				),
			)
		);
		# MENU
		$meta_boxes[] = array(
			'id' => 'menu_metabox',
			'title' => esc_html__( 'Menu Settings', 'navian' ),
			'object_types' => array( 'page', 'post', 'portfolio', 'product' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name'         	=> esc_html__( 'Selected Menu', 'navian' ),
					'desc'         	=> esc_html__( 'Default Selected Menu is the menu in primary location.', 'navian' ),
					'id'           	=> $prefix . 'menu_override',
					'type'         	=> 'select',
					'options'      	=> $menu_options,
					'std'          	=> 'default'
				),
				array(
					'name'         	=> esc_html__( 'Header Menu Hover Effect', 'navian' ),
					'desc'         	=> esc_html__( 'Default Menu Hover Effect is set in: Appearance > Customize > Header', 'navian' ),
					'id'           	=> $prefix . 'menu_effect',
					'type'         	=> 'select',
					'options'      	=> $header_effects,
				),
				array(
					'name'         	=> esc_html__( 'Header Megamenu Divider', 'navian' ),
					'desc'         	=> esc_html__( 'Default Header Megamenu Divider is set in: Appearance > Customize > Header', 'navian' ),
					'id'           	=> $prefix . 'menu_divider',
					'type'         	=> 'select',
					'options'      	=> $header_dividers,
				),
				array(
		            'name' 			=> esc_html__( 'Submenu Background Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Submenu Background Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'submenu_bg_color',
	                'type' 			=> 'colorpicker',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Submenu Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Submenu Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'submenu_color',
	                'type' 			=> 'colorpicker',
		        ),
		        array(
					'name'         	=> esc_html__( 'Menu Text Transform', 'navian' ),
					'desc'         	=> esc_html__( 'Default value is set in: Appearance > Customize > Fonts', 'navian' ),
					'id'           	=> $prefix . 'menu_text_transform',
					'type'         	=> 'select',
					'options'      	=> $text_options,
				),
				array(
					'name'         	=> esc_html__( 'Submenu Text Transform', 'navian' ),
					'desc'         	=> esc_html__( 'Default value is set in: Appearance > Customize > Fonts', 'navian' ),
					'id'           	=> $prefix . 'submenu_text_transform',
					'type'         	=> 'select',
					'options'      	=> $text_options,
				),
				array(
				    'name' 			=> esc_html__( 'Enable Boxed Header?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Header', 'navian' ),
				    'id'   			=> $prefix . 'header_boxed',
				    'type' 			=> 'checkbox'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Cart Icon?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Header', 'navian' ),
				    'id'   			=> $prefix . 'menu_hide_cart',
				    'type' 			=> 'checkbox'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Search Icon?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Header', 'navian' ),
				    'id'   			=> $prefix . 'menu_hide_search',
				    'type' 			=> 'checkbox'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Language Icon?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Header', 'navian' ),
				    'id'   			=> $prefix . 'menu_hide_language',
				    'type' 			=> 'checkbox'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Text Left?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Header', 'navian' ),
				    'id'   			=> $prefix . 'menu_hide_text',
				    'type' 			=> 'checkbox'
				),
				array(
					'name' 			=> esc_html__( 'Header Button Title', 'navian' ),
					'desc' 			=> esc_html__( 'Enter a Title for this button (for Center Header Layout only).', 'navian' ),
					'id'   			=> $prefix . 'header_btn_title',
					'type' 			=> 'text',
				),
				array(
					'name' 			=> esc_html__( 'Header Button URL', 'navian' ),
					'desc' 			=> esc_html__( 'Enter a URL for this button (for Center Header Layout only).', 'navian' ),
					'id'   			=> $prefix . 'header_btn_url',
					'type' 			=> 'text',
				),
				array(
				    'name' 			=> esc_html__( 'Hide Footer Menu?', 'navian' ),
				    'desc' 			=> esc_html__( 'Default setting is set in: Appearance > Customize > Footer', 'navian' ),
				    'id'   			=> $prefix . 'menu_hide_footer',
				    'type' 			=> 'checkbox'
				),
			)
		);
		# PAGE
		$meta_boxes[] = array(
			'id' => 'font_color_metabox',
			'title' => esc_html__( 'Colors &amp; Logo Settings', 'navian' ),
			'object_types' => array( 'page', 'post', 'portfolio', 'product' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
		            'name' 			=> esc_html__( 'Primary Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Primary Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'primary_color',
	                'type' 			=> 'colorpicker',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Primary Gradient Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Primary Gradient Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'primary_gradient_color',
	                'type' 			=> 'colorpicker',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Footer Background Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Footer Background Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'footerbg_color',
	                'type' 			=> 'colorpicker',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Footer Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Footer Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'footer_color',
	                'type' 			=> 'colorpicker',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Footer Link Color', 'navian' ),
		            'desc' 			=> esc_html__( 'Default Footer Link Color is set in: Appearance > Customize > Colors', 'navian' ),
		            'id'   			=> $prefix . 'footerlink_color',
	                'type' 			=> 'colorpicker',
		        ),
				array(
		            'name' 			=> esc_html__( 'Logo Image', 'navian' ),
		            'desc' 			=> esc_html__( 'Default logo is set in: Appearance > Customize > Header', 'navian' ),
		            'id'   			=> $prefix . 'logo',
	                'type' 			=> 'file',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Logo Image Light', 'navian' ),
		            'desc' 			=> esc_html__( 'Default light logo is set in: Appearance > Customize > Header', 'navian' ),
		            'id'   			=> $prefix . 'logo_light',
	                'type' 			=> 'file',
		        ),
		        array(
					'name'         	=> esc_html__( 'Enable Retina logo?', 'navian' ),
					'desc'         	=> esc_html__( 'Default value is set in: Appearance > Customize > Header', 'navian' ),
					'id'           	=> $prefix . 'enable_retina',
					'type'         	=> 'select',
					'options'      	=> $yesno_options,
				),
		        array(
		            'name' 			=> esc_html__( 'Logo Image (Retina Version)', 'navian' ),
		            'desc' 			=> esc_html__( 'Default retina logo is set in: Appearance > Customize > Header', 'navian' ),
		            'id'   			=> $prefix . 'logo_retina',
	                'type' 			=> 'file',
		        ),
		        array(
		            'name' 			=> esc_html__( 'Logo Image Light (Retina Version)', 'navian' ),
		            'desc' 			=> esc_html__( 'Default retina light logo is set in: Appearance > Customize > Header', 'navian' ),
		            'id'   			=> $prefix . 'logo_light_retina',
	                'type' 			=> 'file',
		        ),
			)
		);
		return $meta_boxes;
	}
	add_filter( 'cmb2_meta_boxes', 'navian_metaboxes' );
}