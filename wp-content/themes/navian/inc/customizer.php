<?php
/**
 * Theme Customizer
 *
 * @package TLG Theme
 *
 */

include_once( ABSPATH . 'wp-includes/class-wp-customize-control.php' );

class Navian_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
    public function render_content() {
    ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="3" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>
    <?php
    }
}

class Navian_Customize_Range_Control extends WP_Customize_Control {
    public $type = 'range';
    public function render_content() {
    ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <input <?php $this->link(); ?> name="<?php echo esc_html( navian_sanitize_title($this->label) ); ?>" type="range" min="<?php echo esc_attr($this->choices['min']); ?>" max="<?php echo esc_attr($this->choices['max']); ?>" step="<?php echo esc_attr($this->choices['step']); ?>" value="<?php echo intval( $this->value() ); ?>" class="tlg-range" />
            <input type="text" name="<?php echo esc_html( navian_sanitize_title($this->label) ); ?>" class="tlg-range-output" value="<?php echo intval( $this->value() ); ?>" disabled/>
        </label>
    <?php
    }
}

if( !function_exists('navian_register_options') ) {
    function navian_register_options( $wp_customize ) {
        $prefix             = 'navian_';
        $footer_layouts     = tlg_framework_get_footer_options();
        $header_layouts     = tlg_framework_get_header_options();
        $font_options       = tlg_framework_get_font_options();
        $social_list        = tlg_framework_get_social_icons();
        $portfolio_layouts  = tlg_framework_get_portfolio_layouts();
        $blog_layouts       = tlg_framework_get_blog_layouts();
        $page_titles        = tlg_framework_get_page_title_options();
        $shop_layouts       = tlg_framework_get_shop_layouts();
        $single_layouts     = tlg_framework_get_single_layouts();
        $site_layouts       = tlg_framework_get_site_layouts();
        $container_layouts  = tlg_framework_get_container_layouts();
        $menus = wp_get_nav_menus();
        $menu_options = array();
        if( is_array($menus) && count($menus) ) {
            foreach($menus as $menu) {
                $menu_options[$menu->term_id] = $menu->name;
            }
        }
        $menu_options       = array( 0 => esc_html__( '(default)', 'navian' ) ) + $menu_options;
        $yesno_options      = array( 'yes' => esc_html__( 'Yes', 'navian' ), 'no' => esc_html__( 'No', 'navian' ) );
        $logo_options       = array( 'image' => esc_html__( 'Image', 'navian' ), 'text' => esc_html__( 'Text', 'navian' ) );
        $text_options       = array( 'uppercase' => esc_html__( 'Uppercase', 'navian' ), 'capitalize' => esc_html__( 'Capitalize', 'navian' ), 'none' => esc_html__( 'None', 'navian' ) );
        $header_effects     = array( 'menu-effect-line' => esc_html__( 'Menu Line', 'navian' ), 'menu-effect-through' => esc_html__( 'Menu Line Through', 'navian' ), 'menu-effect-bg' => esc_html__( 'Menu Background', 'navian' ), 'menu-effect-none' => esc_html__( 'None', 'navian' ) );
        $filter_effects     = array( '' => esc_html__( 'Line Through', 'navian' ), 'filter-line' => esc_html__( 'Underline', 'navian' ), 'filter-none' => esc_html__( 'None', 'navian' ) );
        $header_dividers    = array( '' => esc_html__( '(default)', 'navian' ), 'menu-divider-light' => esc_html__( 'Light', 'navian' ), 'menu-divider-dark' => esc_html__( 'Dark', 'navian' ) );
        $page_title_tag    = array( 'h1' => esc_html__( 'H1', 'navian' ), 'h2' => esc_html__( 'H2', 'navian' ), 'h3' => esc_html__( 'H3', 'navian' ), 'h4' => esc_html__( 'H4', 'navian' ), 'h5' => esc_html__( 'H5', 'navian' ), 'h6' => esc_html__( 'H6', 'navian' ) );
        foreach( $social_list as $icon ) $social_options[$icon]  = ucfirst(str_replace(array('ti-', 'fa fa-'), '', $icon));

# SITE IDENTITY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - 
        $wp_customize->add_setting( $prefix .'site_layout', array( 'default' => 'normal-layout', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'site_layout', array( 'priority' => 1, 'label' => esc_html__( 'Site Layout', 'navian' ), 'type' => 'select', 'section' => 'title_tagline', 'settings'=> $prefix .'site_layout', 'choices' => $site_layouts ));
        $wp_customize->add_setting( $prefix .'container_layout', array( 'default' => 'normal-container', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'container_layout', array( 'priority' => 1, 'label' => esc_html__( 'Container Layout', 'navian' ), 'type' => 'select', 'section' => 'title_tagline', 'settings'=> $prefix .'container_layout', 'choices' => $site_layouts ));
        $wp_customize->add_setting( 'tlg_framework_login_logo', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tlg_framework_login_logo', array( 'priority' => 2, 'label' => esc_html__( 'Login Logo', 'navian' ), 'section' => 'title_tagline', 'settings' => 'tlg_framework_login_logo' )));
        
# COLORS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_setting( $prefix .'color_text', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#616a66', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_text', array( 'priority' => 1, 'label' => esc_html__( 'Text Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_text' )));
        $wp_customize->add_setting( $prefix .'color_primary', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#49c5b6', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_primary', array( 'priority' => 2, 'label' => esc_html__( 'Primary Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_primary' )));
        $wp_customize->add_setting( $prefix .'color_primary_gradient', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_primary_gradient', array( 'priority' => 2, 'label' => esc_html__( 'Primary Gradient Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_primary_gradient' )));
        $wp_customize->add_setting( $prefix .'color_bg_dark', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#222', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_bg_dark', array( 'priority' => 5, 'label' => esc_html__( 'Background Dark Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_bg_dark' )));
        $wp_customize->add_setting( $prefix .'color_secondary', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#f7f7f7', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_secondary', array( 'priority' => 7, 'label' => esc_html__( 'Background Secondary Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_secondary' )));
        $wp_customize->add_setting( $prefix .'color_submenu_bg', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#1b1a1a', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_submenu_bg', array( 'priority' => 900, 'label' => esc_html__( 'Submenu Background Color Only', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_submenu_bg' ))); 
        $wp_customize->add_setting( $prefix .'color_submenu', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#fff', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_submenu', array( 'priority' => 901, 'label' => esc_html__( 'Submenu Color Only', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_submenu' ))); 
        $wp_customize->add_setting( $prefix .'color_menu_bg', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_menu_bg', array( 'priority' => 902, 'label' => esc_html__( 'Menu & Submenu Background Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_menu_bg' ))); 
        $wp_customize->add_setting( $prefix .'color_menu', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_menu', array( 'priority' => 903, 'label' => esc_html__( 'Menu & Submenu Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_menu' ))); 
        $wp_customize->add_setting( $prefix .'color_menu_badge', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#fc1547', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_menu_badge', array( 'priority' => 904, 'label' => esc_html__( 'Menu Badge Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_menu_badge' )));
        $wp_customize->add_setting( $prefix .'color_footer_bg', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_footer_bg', array( 'priority' => 905, 'label' => esc_html__( 'Footer Background Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_footer_bg' ))); 
        $wp_customize->add_setting( $prefix .'color_footer', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_footer', array( 'priority' => 906, 'label' => esc_html__( 'Footer Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_footer' ))); 
        $wp_customize->add_setting( $prefix .'color_footer_link', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_footer_link', array( 'priority' => 907, 'label' => esc_html__( 'Footer Link Color', 'navian' ), 'section' => 'colors', 'settings' => $prefix .'color_footer_link' ))); 
        
# FONTS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'styling_section', array( 'title' => esc_html__( 'Fonts', 'navian' ), 'priority' => 211 ));
        $wp_customize->add_setting( $prefix .'font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'font', array( 'priority' => 1, 'label' => esc_html__( 'Body Font', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'subtitle_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'subtitle_font', array( 'priority' => 2, 'label' => esc_html__( 'Subtitle Font', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'subtitle_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'header_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_font', array( 'priority' => 3, 'label' => esc_html__( 'Heading Font', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'header_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'button_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'button_font', array( 'priority' => 4, 'label' => esc_html__( 'Button Font', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'button_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'menu_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'menu_font', array( 'priority' => 5, 'label' => esc_html__( 'Menu Font', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'menu_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'submenu_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'submenu_font', array( 'priority' => 5, 'label' => esc_html__( 'Submenu Font', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'submenu_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'menu_text_transform', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'menu_text_transform', array( 'priority' => 6, 'label' => esc_html__( 'Menu Text Transform', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'menu_text_transform', 'choices' => $text_options ));
        $wp_customize->add_setting( $prefix .'menu_font_size', array( 'default' => '15', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'menu_font_size', array( 'priority' => 7, 'label' => esc_html__( 'Menu Font Size (default: 15px)', 'navian' ), 'section' => 'styling_section', 'settings' => $prefix .'menu_font_size', 'choices' => array('min' => '10', 'max' => '20', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'submenu_text_transform', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'submenu_text_transform', array( 'priority' => 8, 'label' => esc_html__( 'Submenu Text Transform', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'submenu_text_transform', 'choices' => $text_options ));
        $wp_customize->add_setting( $prefix .'submenu_font_size', array( 'default' => '15', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'submenu_font_size', array( 'priority' => 8, 'label' => esc_html__( 'Submenu Font Size (default: 15px)', 'navian' ), 'section' => 'styling_section', 'settings' => $prefix .'submenu_font_size', 'choices' => array('min' => '10', 'max' => '20', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'button_text_transform', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'button_text_transform', array( 'priority' => 9, 'label' => esc_html__( 'Button Text Transform', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'button_text_transform', 'choices' => $text_options ));
        $wp_customize->add_setting( $prefix .'header_text_transform', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_text_transform', array( 'priority' => 10, 'label' => esc_html__( 'Header Text Transform', 'navian' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'header_text_transform', 'choices' => $text_options ));
        $wp_customize->add_setting( $prefix .'header_font_size', array( 'default' => '30', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'header_font_size', array( 'priority' => 11, 'label' => esc_html__( 'Heading Title Font Size (default: 40px)', 'navian' ), 'section' => 'styling_section', 'settings' => $prefix .'header_font_size', 'choices' => array('min' => '10', 'max' => '100', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'subtitle_font_size', array( 'default' => '15', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'subtitle_font_size', array( 'priority' => 11, 'label' => esc_html__( 'Subtitle Font Size (default: 14px)', 'navian' ), 'section' => 'styling_section', 'settings' => $prefix .'subtitle_font_size', 'choices' => array('min' => '10', 'max' => '100', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'widget_font_size', array( 'default' => '20', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'widget_font_size', array( 'priority' => 12, 'label' => esc_html__( 'Widget Title Font Size (default: 20px)', 'navian' ), 'section' => 'styling_section', 'settings' => $prefix .'widget_font_size', 'choices' => array('min' => '10', 'max' => '100', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'body_font_size', array( 'default' => '16', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'body_font_size', array( 'priority' => 13, 'label' => esc_html__( 'Body Font Size (default: 14px)', 'navian' ), 'section' => 'styling_section', 'settings' => $prefix .'body_font_size', 'choices' => array('min' => '5', 'max' => '100', 'step' => '1') )));

# HEADER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'header_section', array( 'title' => esc_html__( 'Header', 'navian' ), 'priority' => 212 ));        
        $wp_customize->add_setting( $prefix .'site_logo', array( 'default' => 'image', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'site_logo', array( 'priority' => 0, 'label' => esc_html__( 'Site Logo', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'site_logo', 'choices' => $logo_options ));        
        $wp_customize->add_setting( $prefix .'logo_text', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'logo_text', array( 'priority' => 1, 'label' => esc_html__( 'Logo Text', 'navian' ), 'section' => 'header_section', 'settings'=> $prefix .'logo_text' ));
        $wp_customize->add_setting( $prefix .'custom_logo', array( 'default' => NAVIAN_THEME_DIRECTORY . 'assets/img/logo-dark.png', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'custom_logo', array( 'priority' => 1, 'label' => esc_html__( 'Logo', 'navian' ), 'section' => 'header_section', 'settings' => $prefix .'custom_logo' )));
        $wp_customize->add_setting( $prefix .'custom_logo_light', array( 'default' => NAVIAN_THEME_DIRECTORY . 'assets/img/logo-light.png', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'custom_logo_light', array( 'priority' => 2, 'label' => esc_html__( 'Logo Light', 'navian' ), 'section' => 'header_section', 'settings' => $prefix .'custom_logo_light' )));
        $wp_customize->add_setting( $prefix .'enable_retina', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_retina', array( 'priority' => 3, 'label' => esc_html__( 'Enable Retina logo?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'enable_retina', 'choices' => $yesno_options, 'description' => wp_kses( __( 'Most of the modern devices nowadays use retina and high definition screens and you may want to upload 2x sized logo so your logo won\'t look blurred on high definition screens. If your current logo is 200 X 50, just upload 400 X 100 (twice the size) in the Retina logo options below.', 'navian' ), navian_allowed_tags() ) ));
        $wp_customize->add_setting( $prefix .'custom_logo_retina', array( 'default' => NAVIAN_THEME_DIRECTORY . 'assets/img/logo-dark-2x.png', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'custom_logo_retina', array( 'priority' => 3, 'label' => esc_html__( 'Logo (Retina Version, twice the size)', 'navian' ), 'section' => 'header_section', 'settings' => $prefix .'custom_logo_retina' )));
        $wp_customize->add_setting( $prefix .'custom_logo_light_retina', array( 'default' => NAVIAN_THEME_DIRECTORY . 'assets/img/logo-light-2x.png', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'custom_logo_light_retina', array( 'priority' => 3, 'label' => esc_html__( 'Logo Light (Retina Version, twice the size)', 'navian' ), 'section' => 'header_section', 'settings' => $prefix .'custom_logo_light_retina' )));
        $wp_customize->add_setting( $prefix .'menu_height', array( 'default' => '58', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'menu_height', array( 'priority' => 4, 'label' => esc_html__( 'Menu Height (default: 58px)', 'navian' ), 'section' => 'header_section', 'settings' => $prefix .'menu_height', 'choices' => array('min' => '55', 'max' => '250', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'header_layout', array( 'default' => 'standard', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_layout', array( 'priority' => 8, 'label' => esc_html__( 'Header Layout', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_layout', 'choices' => $header_layouts ));
        $wp_customize->add_setting( $prefix .'menu_effect', array( 'default' => 'menu-effect-line', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'menu_effect', array( 'priority' => 8, 'label' => esc_html__( 'Header Menu Hover Effect', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'menu_effect', 'choices' => $header_effects ));
        $wp_customize->add_setting( $prefix .'menu_divider', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'menu_divider', array( 'priority' => 9, 'label' => esc_html__( 'Header Megamenu Divider Color', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'menu_divider', 'choices' => $header_dividers ));
        $wp_customize->add_setting( $prefix .'header_boxed', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_boxed', array( 'priority' => 9, 'label' => esc_html__( 'Boxed Header?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_boxed', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_sticky', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_sticky', array( 'priority' => 9, 'label' => esc_html__( 'Sticky Header?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_sticky', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_sticky_mobile', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_sticky_mobile', array( 'priority' => 9, 'label' => esc_html__( 'Sticky Header on mobile?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_sticky_mobile', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_top_mobile', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_top_mobile', array( 'priority' => 9, 'label' => esc_html__( 'Topbar Header on Mobile?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_top_mobile', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'menu_open', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'menu_open', array( 'priority' => 9, 'label' => esc_html__( 'Force to open submenu on Mobile?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'menu_open', 'choices' => $yesno_options ));  
        $wp_customize->add_setting( $prefix .'header_full', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_full', array( 'priority' => 10, 'label' => esc_html__( 'Header Megamenu Full Width?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_full', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_search', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_search', array( 'priority' => 11, 'label' => esc_html__( 'Show Header Search?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_search', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_cart', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_cart', array( 'priority' => 12, 'label' => esc_html__( 'Show Header Cart?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_cart', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_language', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_language', array( 'priority' => 13, 'label' => esc_html__( 'Show Header Language? (require WPML plugin)', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_language', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_text', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_text', array( 'priority' => 13, 'label' => esc_html__( 'Show Header Text (Left)?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_text', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_first', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_first', array( 'priority' => 14, 'label' => esc_html__( 'Header First Text (Left)', 'navian' ), 'section' => 'header_section', 'settings'=> $prefix .'header_first' ));
        $wp_customize->add_setting( $prefix .'header_first_icon', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_first_icon', array( 'priority' => 14, 'label' => esc_html__( 'Header First Icon ', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_first_icon', 'choices' => $social_options ));
        $wp_customize->add_setting( $prefix .'header_second', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_second', array( 'priority' => 15, 'label' => esc_html__( 'Header Second Text (Left)', 'navian' ), 'section' => 'header_section', 'settings'=> $prefix .'header_second' ));
        $wp_customize->add_setting( $prefix .'header_second_icon', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_second_icon', array( 'priority' => 15, 'label' => esc_html__( 'Header Second Icon ', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_second_icon', 'choices' => $social_options ));
        $wp_customize->add_setting( $prefix .'header_third', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_third', array( 'priority' => 16, 'label' => esc_html__( 'Header Text (Right)', 'navian' ), 'section' => 'header_section', 'settings'=> $prefix .'header_third' ));
        $wp_customize->add_setting( $prefix .'header_third_icon', array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_third_icon', array( 'priority' => 16, 'label' => esc_html__( 'Header Text Icon ', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_third_icon', 'choices' => $social_options ));
        $wp_customize->add_setting( $prefix .'header_btn_title', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_btn_title', array( 'priority' => 17, 'label' => esc_html__( 'Header Button Title (Center Header Layout)', 'navian' ), 'section' => 'header_section', 'settings'=> $prefix .'header_btn_title' ));
        $wp_customize->add_setting( $prefix .'header_btn_url', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'header_btn_url', array( 'priority' => 18, 'label' => esc_html__( 'Header Button URL (Center Header Layout)', 'navian' ), 'section' => 'header_section', 'settings'=> $prefix .'header_btn_url' ));
        $wp_customize->add_setting( $prefix .'enable_minimal_line', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_minimal_line', array( 'priority' => 18, 'label' => esc_html__( 'Enable separator line (Minimal Header Layout)', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'enable_minimal_line', 'choices' => $yesno_options ));
        for( $i = 1; $i < 7; $i++ ) {
            $wp_customize->add_setting( $prefix .'header_social_icon_' . $i, array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
            $wp_customize->add_control( $prefix .'header_social_icon_' . $i, array( 'priority' => (18 + $i + $i), 'label' => esc_html__( 'Header Social Icon ', 'navian' ) . $i, 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_social_icon_' . $i, 'choices' => $social_options ));
            $wp_customize->add_setting( $prefix .'header_social_url_' . $i, array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
            $wp_customize->add_control( $prefix .'header_social_url_' . $i, array( 'priority' => (19 + $i + $i), 'label' => esc_html__( 'Header Social URL ', 'navian' ) . $i, 'section' => 'header_section', 'settings'=> $prefix .'header_social_url_' . $i ));
        }
        $wp_customize->add_setting( $prefix .'page_layout', array( 'default' => 'center-large', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'page_layout', array( 'priority' => 31, 'label' => esc_html__( 'Default Page Title Layout', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'page_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( 'tlg_framework_page_layout_overlay', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_page_layout_overlay', array( 'priority' => 31, 'label' => esc_html__( 'Enable Page Title Overlay Color?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> 'tlg_framework_page_layout_overlay', 'choices' => $yesno_options ));
        $wp_customize->add_setting( 'tlg_framework_page_layout_color', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tlg_framework_page_layout_color', array( 'priority' => 32, 'label' => esc_html__( 'Page Title Overlay Color', 'navian' ), 'section' => 'header_section', 'settings' => 'tlg_framework_page_layout_color' )));
        $wp_customize->add_setting( 'tlg_framework_page_layout_gradient', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tlg_framework_page_layout_gradient', array( 'priority' => 33, 'label' => esc_html__( 'Page Title Overlay Gradient', 'navian' ), 'section' => 'header_section', 'settings' => 'tlg_framework_page_layout_gradient' )));
        $wp_customize->add_setting( 'tlg_framework_show_breadcrumbs', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_show_breadcrumbs', array( 'priority' => 34, 'label' => esc_html__( 'Enable Breadcrumbs?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> 'tlg_framework_show_breadcrumbs', 'choices' => $yesno_options ));
        $wp_customize->add_setting( 'tlg_framework_show_breadcrumbs_cat', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_show_breadcrumbs_cat', array( 'priority' => 34, 'label' => esc_html__( 'Enable Category in Breadcrumbs?', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> 'tlg_framework_show_breadcrumbs_cat', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'page_title_height', array( 'default' => '400', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new Navian_Customize_Range_Control( $wp_customize, $prefix .'page_title_height', array( 'priority' => 35, 'label' => esc_html__( 'Page Title Height (default: 400px)', 'navian' ), 'section' => 'header_section', 'settings' => $prefix .'page_title_height', 'choices' => array('min' => '200', 'max' => '800', 'step' => '20') )));
        $wp_customize->add_setting( 'tlg_framework_page_title_tag', array( 'default' => 'h1', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_page_title_tag', array( 'priority' => 36, 'label' => esc_html__( 'Header Page Title Heading', 'navian' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> 'tlg_framework_page_title_tag', 'choices' => $page_title_tag ));
        
# FOOTER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'footer_section', array( 'title' => esc_html__( 'Footer', 'navian' ), 'priority' => 213 ));
        $wp_customize->add_setting( $prefix .'footer_layout', array( 'default' => 'standard', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'footer_layout', array( 'priority' => 1, 'label' => esc_html__( 'Footer Layout', 'navian' ), 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'footer_layout', 'choices' => $footer_layouts ));
        $wp_customize->add_setting( $prefix .'footer_menu', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'footer_menu', array( 'priority' => 2, 'label' => esc_html__( 'Enable Footer Menu?', 'navian' ), 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'footer_menu', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_copyright', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_copyright', array( 'priority' => 2, 'label' => esc_html__( 'Enable Footer Copyright?', 'navian' ), 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'enable_copyright', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'footer_copyright', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'footer_copyright', array( 'priority' => 3, 'label' => esc_html__( 'Footer Copyright Text', 'navian' ), 'section' => 'footer_section', 'settings'=> $prefix .'footer_copyright' ));
        for( $i = 1; $i < 7; $i++ ) {
            $wp_customize->add_setting( $prefix .'footer_social_icon_' . $i, array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
            $wp_customize->add_control( $prefix .'footer_social_icon_' . $i, array( 'priority' => (4 + $i + $i), 'label' => esc_html__( 'Footer Social Icon ', 'navian' ) . $i, 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'footer_social_icon_' . $i, 'choices' => $social_options ));
            $wp_customize->add_setting( $prefix .'footer_social_url_' . $i, array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
            $wp_customize->add_control( $prefix .'footer_social_url_' . $i, array( 'priority' => (5 + $i + $i), 'label' => esc_html__( 'Footer Social URL ', 'navian' ) . $i, 'section' => 'footer_section', 'settings'=> $prefix .'footer_social_url_' . $i ));
        }

# SEARCH - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'search_section', array( 'title' => esc_html__( 'Search', 'navian' ), 'priority' => 214 ));
        $wp_customize->add_setting( $prefix .'search_layout', array( 'default' => 'sidebar-none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'search_layout', array( 'priority' => 1, 'label' => esc_html__( 'Archives Layout', 'navian' ), 'type' => 'select', 'section' => 'search_section', 'settings'=> $prefix .'search_layout', 'choices' => $single_layouts ));
        $wp_customize->add_setting( $prefix .'search_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'search_header_layout', array( 'priority' => 2, 'label' => esc_html__( 'Search Title Layout', 'navian' ), 'type' => 'select', 'section' => 'search_section', 'settings'=> $prefix .'search_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( $prefix .'search_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'search_header_image', array( 'priority' => 3, 'label' => esc_html__( 'Search Header Background', 'navian' ), 'section' => 'search_section', 'settings' => $prefix .'search_header_image' )));
        $wp_customize->add_setting( $prefix .'search_enable_navigation', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'search_enable_navigation', array( 'priority' => 4, 'label' => esc_html__( 'Enable Search Navigation?', 'navian' ), 'type' => 'select', 'section' => 'search_section', 'settings'=> $prefix .'search_enable_navigation', 'choices' => $yesno_options ));

# BLOG - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'blog_section', array( 'title' => esc_html__( 'Blog', 'navian' ), 'priority' => 215 ));
        $wp_customize->add_setting( $prefix .'post_layout', array( 'default' => 'sidebar-right', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'post_layout', array( 'priority' => 1, 'label' => esc_html__( 'Single Layout', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'post_layout', 'choices' => $single_layouts ));
        $wp_customize->add_setting( $prefix .'blog_layout', array( 'default' => 'masonry-sidebar-right', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_layout', array( 'priority' => 2, 'label' => esc_html__( 'Archives Layout', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_layout', 'choices' => $blog_layouts ));
        $wp_customize->add_setting( $prefix .'blog_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_header_layout', array( 'priority' => 3, 'label' => esc_html__( 'Blog Title Layout', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( 'tlg_framework_blog_title', array( 'default' => esc_html__( 'Our Blog', 'navian' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_blog_title', array( 'priority' => 4, 'label' => esc_html__( 'Blog Title', 'navian' ), 'section' => 'blog_section', 'settings'=> 'tlg_framework_blog_title' ));
        $wp_customize->add_setting( $prefix .'blog_subtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_subtitle', array( 'priority' => 5, 'label' => esc_html__( 'Blog Subtitle', 'navian' ), 'section' => 'blog_section', 'settings'=> $prefix .'blog_subtitle' ));
        $wp_customize->add_setting( $prefix .'blog_leadtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_leadtitle', array( 'priority' => 5, 'label' => esc_html__( 'Blog Lead Title', 'navian' ), 'section' => 'blog_section', 'settings'=> $prefix .'blog_leadtitle' ));
        $wp_customize->add_setting( $prefix .'blog_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'blog_header_image', array( 'priority' => 6, 'label' => esc_html__( 'Blog Header Background', 'navian' ), 'section' => 'blog_section', 'settings' => $prefix .'blog_header_image' )));
        $wp_customize->add_setting( $prefix .'blog_enable_single_meta', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_enable_single_meta', array( 'priority' => 7, 'label' => esc_html__( 'Show header post information?', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_enable_single_meta', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_show_feature', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_show_feature', array( 'priority' => 7, 'label' => esc_html__( 'Show feature image on single post?', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_show_feature', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_enable_pagination', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_enable_pagination', array( 'priority' => 8, 'label' => esc_html__( 'Enable Single Pagination?', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_enable_pagination', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_author_info', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_author_info', array( 'priority' => 9, 'label' => esc_html__( 'Enable Author Info?', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_author_info', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_related', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_related', array( 'priority' => 10, 'label' => esc_html__( 'Enable Related Posts', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_related', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_comment', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_comment', array( 'priority' => 11, 'label' => esc_html__( 'Enable Post Comment?', 'navian' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_comment', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_excerpt_length', array( 'default' => 13, 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_excerpt_length', array( 'priority' => 12, 'label' => esc_html__( 'Number of words in Grid blog', 'navian' ), 'section' => 'blog_section', 'settings'=> $prefix .'blog_excerpt_length' ));
        $wp_customize->add_setting( $prefix .'blog_default_excerpt_length', array( 'default' => 31, 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_default_excerpt_length', array( 'priority' => 13, 'label' => esc_html__( 'Number of words in Standard blog', 'navian' ), 'section' => 'blog_section', 'settings'=> $prefix .'blog_default_excerpt_length' ));

# PORTFOLIO - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'portfolio_section', array( 'title' => esc_html__( 'Portfolio', 'navian' ), 'priority' => 216, 'description' => wp_kses( __( '* When you make change on \'Portfolio URL slug\', please make sure to refresh the permalinks by going to <a target="_blank" href="options-permalink.php">Settings > Permalinks</a> and click on the \'Save Changes\' button. Otherwise, the change will do not work properly.', 'navian' ), navian_allowed_tags() ) ));
        $wp_customize->add_setting( 'tlg_framework_portfolio_slug', array( 'default' => 'portfolio', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_portfolio_slug', array( 'priority' => 1, 'label' => esc_html__( '* Portfolio URL slug', 'navian' ), 'section' => 'portfolio_section', 'settings'=> 'tlg_framework_portfolio_slug' ));
        $wp_customize->add_setting( $prefix .'portfolio_layout', array( 'default' => 'full-grid-4col', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_layout', array( 'priority' => 2, 'label' => esc_html__( 'Archives Layout', 'navian' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_layout', 'choices' => $portfolio_layouts ));
        $wp_customize->add_setting( $prefix .'portfolio_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_header_layout', array( 'priority' => 3, 'label' => esc_html__( 'Portfolio Title Layout', 'navian' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( $prefix .'portfolio_title', array( 'default' => esc_html__( 'Our Portfolio', 'navian' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_title', array( 'priority' => 4, 'label' => esc_html__( 'Portfolio Title', 'navian' ), 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_title' ));
        $wp_customize->add_setting( $prefix .'portfolio_subtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_subtitle', array( 'priority' => 5, 'label' => esc_html__( 'Portfolio Subtitle', 'navian' ), 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_subtitle' ));
        $wp_customize->add_setting( $prefix .'portfolio_leadtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_leadtitle', array( 'priority' => 5, 'label' => esc_html__( 'Portfolio Lead Title', 'navian' ), 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_leadtitle' ));
        $wp_customize->add_setting( $prefix .'portfolio_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'portfolio_header_image', array( 'priority' => 6, 'label' => esc_html__( 'Portfolio Header Background', 'navian' ), 'section' => 'portfolio_section', 'settings' => $prefix .'portfolio_header_image' )));
        $wp_customize->add_setting( $prefix .'portfolio_enable_pagination', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_enable_pagination', array( 'priority' => 8, 'label' => esc_html__( 'Enable Next/Previous Projects?', 'navian' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_enable_pagination', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'portfolio_enable_pagination_single', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_enable_pagination_single', array( 'priority' => 9, 'label' => esc_html__( 'Enable Single Pagination?', 'navian' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_enable_pagination_single', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'portfolio_gallery', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_gallery', array( 'priority' => 10, 'label' => esc_html__( 'Enable portfolio gallery lightbox?', 'navian' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_gallery', 'choices' => $yesno_options ));
        $wp_customize->add_setting( 'tlg_framework_portfolio_filter', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_portfolio_filter', array( 'priority' => 11, 'label' => esc_html__( 'Portfolio Filter Effect', 'navian' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> 'tlg_framework_portfolio_filter', 'choices' => $filter_effects ));

# SHOP - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'shop_section', array( 'title' => esc_html__( 'Shop', 'navian' ), 'priority' => 217 ));
        $wp_customize->add_setting( $prefix .'shop_ppp', array( 'default' => 6, 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_ppp', array( 'priority' => 1, 'label' => esc_html__( 'Number of Products per Page', 'navian' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_ppp' ));
        $wp_customize->add_setting( $prefix .'shop_layout', array( 'default' => 'sidebar-right', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_layout', array( 'priority' => 2, 'label' => esc_html__( 'Archives Layout', 'navian' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_layout', 'choices' => $shop_layouts ));
        $wp_customize->add_setting( $prefix .'shop_menu_layout', array( 'default' => 'default', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_menu_layout', array( 'priority' => 3, 'label' => esc_html__( 'Header Layout', 'navian' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_menu_layout', 'choices' => array( 'default' => esc_html__( '(default layout)', 'navian' ) ) + $header_layouts ));
        $wp_customize->add_setting( $prefix .'shop_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_header_layout', array( 'priority' => 4, 'label' => esc_html__( 'Shop Title Layout', 'navian' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( $prefix .'shop_title', array( 'default' => esc_html__( 'Our Shop', 'navian' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_title', array( 'priority' => 5, 'label' => esc_html__( 'Shop Title', 'navian' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_title' ));
        $wp_customize->add_setting( $prefix .'shop_subtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_subtitle', array( 'priority' => 6, 'label' => esc_html__( 'Shop Subtitle', 'navian' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_subtitle' ));
        $wp_customize->add_setting( $prefix .'shop_leadtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_leadtitle', array( 'priority' => 6, 'label' => esc_html__( 'Shop Lead Title', 'navian' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_leadtitle' ));
        $wp_customize->add_setting( $prefix .'shop_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'shop_header_image', array( 'priority' => 7, 'label' => esc_html__( 'Shop Header Background', 'navian' ), 'section' => 'shop_section', 'settings' => $prefix .'shop_header_image' )));
        $wp_customize->add_setting( $prefix .'shop_enable_pagination', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_enable_pagination', array( 'priority' => 8, 'label' => esc_html__( 'Enable Single Pagination?', 'navian' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_enable_pagination', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'shop_menu_override', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_menu_override', array( 'priority' => 9, 'label' => esc_html__( 'Shop Selected Menu', 'navian' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_menu_override', 'choices' => $menu_options ));

# SYSTEM - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'system_section', array( 'title' => esc_html__( 'System', 'navian' ), 'priority' => 218 ));
        $wp_customize->add_setting( 'tlg_framework_gmaps_key', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_gmaps_key', array( 'priority' => 0, 'label' => esc_html__( 'Google Maps API key', 'navian' ), 'section' => 'system_section', 'settings'=> 'tlg_framework_gmaps_key', 'description' => wp_kses( __( 'As per Google announcement, usage of the Google Maps now requires a key. Please have a look at the <a target="_blank" href="https://developers.google.com/maps/documentation/embed/get-api-key">Google Maps APIs documentation</a> to get a key and add it to the field below.', 'navian' ), navian_allowed_tags() ) ));
        $wp_customize->add_setting( 'tlg_framework_instagram_token', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_instagram_token', array( 'priority' => 0, 'label' => esc_html__( 'Instagram Access Token', 'navian' ), 'section' => 'system_section', 'settings'=> 'tlg_framework_instagram_token', 'description' => wp_kses( __( 'Due to recent changes in the Instagram API – you\'ll need to provide Access Token in order to show Instagram photos on your site. Please have a look at <a href="http://www.themelogi.com/how-to-get-instagram-access-token/" target="_blank">Instagram Access Token documentation</a> to retrieve an access token.', 'navian' ), navian_allowed_tags() ) ));
        $wp_customize->add_setting( 'tlg_framework_custom_fonts', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_custom_fonts', array( 'priority' => 0, 'label' => esc_html__( 'Custom Google Font', 'navian' ), 'section' => 'system_section', 'settings'=> 'tlg_framework_custom_fonts', 'description' => wp_kses( __( 'Please have a look at <a target="_blank" href="http://www.themelogi.com/tickets/topic/faq/#custom_google_font">our FAQs page</a> for more details about adding custom Google fonts.', 'navian' ), navian_allowed_tags() ) ) );
        $wp_customize->add_setting( 'tlg_framework_custom_icons', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_custom_icons', array( 'priority' => 0, 'label' => esc_html__( 'Custom Icons Font Classes (separated by commas)', 'navian' ), 'section' => 'system_section', 'settings'=> 'tlg_framework_custom_icons' ));
        $wp_customize->add_setting( $prefix .'enable_preloader', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_preloader', array( 'priority' => 0, 'label' => esc_html__( 'Enable Preloader?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_preloader', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_portfolio_comment', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_portfolio_comment', array( 'priority' => 0, 'label' => esc_html__( 'Enable Portfolio Comment?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_portfolio_comment', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_page_comment', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_page_comment', array( 'priority' => 0, 'label' => esc_html__( 'Enable Page Comment?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_page_comment', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_portfolio', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_portfolio', array( 'priority' => 1, 'label' => esc_html__( 'Enable Portfolio?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_portfolio', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_team', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_team', array( 'priority' => 2, 'label' => esc_html__( 'Enable Team Members?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_team', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_client', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_client', array( 'priority' => 3, 'label' => esc_html__( 'Enable Clients?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_client', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_testimonial', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_testimonial', array( 'priority' => 4, 'label' => esc_html__( 'Enable Testimonials?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_testimonial', 'choices' => $yesno_options ));
        $wp_customize->add_setting( 'tlg_framework_enable_like', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_enable_like', array( 'priority' => 6, 'label' => esc_html__( 'Enable Like feature?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> 'tlg_framework_enable_like', 'choices' => $yesno_options ));
        $wp_customize->add_setting( 'tlg_framework_enable_share', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_enable_share', array( 'priority' => 6, 'label' => esc_html__( 'Enable Share feature?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> 'tlg_framework_enable_share', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_scroll_top', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_scroll_top', array( 'priority' => 6, 'label' => esc_html__( 'Enable Scroll To Top button?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_scroll_top', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_scroll_top_mobile', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_scroll_top_mobile', array( 'priority' => 6, 'label' => esc_html__( 'Enable Scroll To Top on mobile?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_scroll_top_mobile', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_search_filter', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_search_filter', array( 'priority' => 7, 'label' => esc_html__( 'Exclude Pages from Search Results?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_search_filter', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_page', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_page', array( 'priority' => 8, 'label' => esc_html__( 'Auto activate WPBakery Page Builder for Page?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_page', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_post', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_post', array( 'priority' => 9, 'label' => esc_html__( 'Auto activate WPBakery Page Builder for Post?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_post', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_portfolio', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_portfolio', array( 'priority' => 10, 'label' => esc_html__( 'Auto activate WPBakery Page Builder for Portfolio?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_portfolio', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_product', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_product', array( 'priority' => 11, 'label' => esc_html__( 'Auto activate WPBakery Page Builder for Product?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_product', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_default_vc_shortcode', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_default_vc_shortcode', array( 'priority' => 12, 'label' => esc_html__( 'Enable WPBakery Page Builder Default Shortcode?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_default_vc_shortcode', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_vc_templates', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_vc_templates', array( 'priority' => 12, 'label' => esc_html__( 'Enable WPBakery Page Builder Default Templates?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_vc_templates', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_default_wc_shortcode', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'navian_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_default_wc_shortcode', array( 'priority' => 12, 'label' => esc_html__( 'Enable WooCommerce Default Shortcode?', 'navian' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_default_wc_shortcode', 'choices' => $yesno_options ));
    }
    add_action( 'customize_register', 'navian_register_options' );
}