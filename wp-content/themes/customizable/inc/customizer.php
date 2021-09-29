<?php
/**
*  Customization options
**/
function customizable_sanitize_checkbox( $checked ) {
  return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
//select sanitization function
function customizable_sanitize_select( $input, $setting ){         
//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
$input = sanitize_key($input); 
//get the list of possible select options 
$choices = $setting->manager->get_control( $setting->id )->choices;                             
//return input if valid or return default option
return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
}
// URL
function customizable_sanitize_url( $url ) {
  return esc_url_raw( $url );
}
function customizable_customize_register( $wp_customize ) 
{
  $customizable_options = get_option( 'faster_theme_options' );

$wp_customize->add_panel(
    'general',
    array(
        'title' => __( 'General', 'customizable' ),
        'description' => __('styling options','customizable'),
        'priority' => 20, 
    )
  );
  $wp_customize->get_section('title_tagline')->panel = 'general';
  $wp_customize->get_section('static_front_page')->panel = 'general';
  $wp_customize->get_section('header_image')->panel = 'general';
  $wp_customize->get_section('title_tagline')->title = __('Header & Logo','customizable');
  
$wp_customize->add_section(
  'headerNlogo',
  array(
    'title' => __('Header & Logo','customizable'),
    'panel' => 'general'
  )
);

  /* ------------- Start Homepage setting panel ------------- */
 
    $wp_customize->add_panel(
      'homepage_setting',
      array(
          'title' => __( 'Front Page Settings', 'customizable' ),
          'description' => __('Front Page Settings','customizable'),
          'priority' => 20, 
      )
    );
  // Start Slider Section 
   $wp_customize->add_section( 'slider_setting', array(
      'capability'     => 'edit_theme_options',
      'theme_supports' => '',
      'title'          => esc_html__('Slider', 'customizable'),
      'description'    => '',
      'panel'          => 'homepage_setting'
    ) );
   /* Checkbox Field */
    $wp_customize->add_setting( 'hide_slider_section', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'customizable_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'hide_slider_section', array(
        'type' => 'checkbox',
        'section' => 'slider_setting', // Add a default or your own section
        'label' => esc_html__( 'Please check this box, if you want to hide this section.', 'customizable' ),
        'description' => '',
    ) );
  /* Image  Field */
  for($i=1;$i<=5;$i++)
  {
  $wp_customize->add_setting( 'slider_image_'.$i, array(
    'default' => isset($customizable_options['slider-img-'.$i])?$customizable_options['slider-img-'.$i]:'',
     'capability'     => 'edit_theme_options',
     'sanitize_callback' => 'absint',
  ) ); 
  $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'slider_image_'.$i, array(
        'section'     => 'slider_setting',
        'label'       => __( 'Upload Slider Image ' ,'customizable').$i,
        'description' => __( 'Image (Recommended Size : 1350px * 539px)' ,'customizable'),
        'flex_width'  => true,
        'flex_height' => true,
        'width'       => 1350,
        'height'      => 539,   
        ) ) );
  /* Title */
  $wp_customize->add_setting( 'slide_link_'.$i, array(
    'default' => isset($customizable_options['slidelink-'.$i])?$customizable_options['slidelink-'.$i]:'',
   
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'slide_link_'.$i, array(
      'type' => 'url',
      'priority' => 10,
      'section' => 'slider_setting',
      'description' => '',
       'input_attrs' => array(
            'placeholder' => esc_html__( 'Slide Link', 'customizable' ),
        )
  ) );
  }
   // End Slider Section 

   // Start First Section 
   $wp_customize->add_section( 'first_section', array(
      'capability'     => 'edit_theme_options',
      'theme_supports' => '',
      'title'          => esc_html__('First Section', 'customizable'),
      'description'    => '',
      'panel'          => 'homepage_setting'
    ) );
   /* Checkbox Field */
    $wp_customize->add_setting( 'hide_first_section', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'customizable_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'hide_first_section', array(
        'type' => 'checkbox',
        'section' => 'first_section', // Add a default or your own section
        'label' => esc_html__( 'Please check this box, if you want to hide this section.', 'customizable' ),
        'description' => '',
    ) );
  // First Section Title
  $wp_customize->add_setting( 'first_section_title', array(
    'default' => isset($customizable_options['sectionhead'])?$customizable_options['sectionhead']:'',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'first_section_title', array(
      'type' => 'text',
      'priority' => 10,
      'section' => 'first_section',
      'label' => esc_html__( 'First Section Title', 'customizable' ),
      'description' => '',
  ) );
  for($i=1;$i<=3;$i++)
  {
    /* Section Icon */
    $wp_customize->add_setting( 'tab_'.$i.'_icon', array(
      'default' => isset($customizable_options['section-icon-'.$i])?$customizable_options['section-icon-'.$i]:'',
       'capability'     => 'edit_theme_options',
     'sanitize_callback' => 'absint',
    ) );    
    $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'tab_'.$i.'_icon', array(
        'section'     => 'first_section',
        'label'       => __( 'Upload icon Image ' ,'customizable').$i,
        'description' => __( 'Image (Recommended Size : 50px * 50px)' ,'customizable'),
        'flex_width'  => true,
        'flex_height' => true,
        'width'       => 50,
        'height'      => 50,  
        
    ) ) );
    /* Section Title */
    $wp_customize->add_setting( 'tab_'.$i.'_title', array(
      'default' => isset($customizable_options['sectiontitle'.$i])?$customizable_options['sectiontitle'.$i]:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'tab_'.$i.'_title', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'first_section',
        'description' => '',
        'input_attrs' => array(
            'placeholder' => esc_html__( 'Section Title', 'customizable' ),
            ),
        'description' => esc_html__( 'Enter title for your home template.', 'customizable' ),
    ) );
    /* Section Description */
    $wp_customize->add_setting( 'tab_description_'.$i, array(
      'default' => isset($customizable_options['sectiondesc-'.$i])?$customizable_options['sectiondesc-'.$i]:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'tab_description_'.$i, array(
        'type' => 'textarea',
        'priority' => 10,
        'section' => 'first_section',
        'description' => '',
        'input_attrs' => array(
            'placeholder' => esc_html__( 'Section Description', 'customizable' ),
            ),
        'description' => esc_html__( 'Enter description for your home template.', 'customizable' ),
    ) );
  }
  // End First Section 
  // Start Second Section 
   $wp_customize->add_section( 'second_section', array(
      'capability'     => 'edit_theme_options',
      'theme_supports' => '',
      'title'          => esc_html__('Second Section', 'customizable'),
      'description'    => '',
      'panel'          => 'homepage_setting'
    ) );
   /* Checkbox Field */
    $wp_customize->add_setting( 'hide_second_section', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'customizable_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'hide_second_section', array(
        'type' => 'checkbox',
        'section' => 'second_section', // Add a default or your own section
        'label' => esc_html__( 'Please check this box, if you want to hide this section.', 'customizable' ),
        'description' => '',
    ) );
    // Recent Post Title
    $wp_customize->add_setting( 'recent_post_title', array(
      'default' => isset($customizable_options['post-title'])?$customizable_options['post-title']:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'recent_post_title', array(
        'type' => 'text',
        'section' => 'second_section',
        'label'   => __('Recent Post Title','customizable'),
    ) );
  /* Post Category select box */
  $cats = array();
  $cats['']='Select Category';
  foreach ( get_categories() as $categories => $category ){
      $cats[$category->term_id] = $category->name;
  }
  $wp_customize->add_setting( 'section_2_category', array(
    'default' => isset($customizable_options['post-category'])?$customizable_options['post-category']:'',
    'sanitize_callback' => 'customizable_sanitize_select',
  ) );
  $wp_customize->add_control( 'section_2_category', array(
      'type' => 'select',
      'choices' => $cats,
      'section' => 'second_section',
      'label' => esc_html__( 'Category', 'customizable' ),
  ) );
  // End Second Section
  // Start Download Setting Section 
   $wp_customize->add_section( 'download_setting', array(
      'capability'     => 'edit_theme_options',
      'theme_supports' => '',
      'title'          => esc_html__('Download Settings', 'customizable'),
      'description'    => '',
      'panel'          => 'homepage_setting'
    ) );
    /* Checkbox Field */
    $wp_customize->add_setting( 'hide_download_section', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'customizable_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'hide_download_section', array(
        'type' => 'checkbox',
        'section' => 'download_setting', // Add a default or your own section
        'label' => esc_html__( 'Please check this box, if you want to hide this section.', 'customizable' ),
        'description' => '',
    ) );
   // Download Caption Text
   $wp_customize->add_setting( 'download_caption', array(
      'default' => isset($customizable_options['downloadcaption'])?$customizable_options['downloadcaption']:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'download_caption', array(
        'type' => 'textarea',
        'section' => 'download_setting',
        'label'   => __('Download Caption','customizable'),
    ) );
    // Download Link
    $wp_customize->add_setting( 'download_link', array(
      'default' => isset($customizable_options['downloadlink'])?$customizable_options['downloadlink']:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'customizable_sanitize_url',
    ) );
    $wp_customize->add_control( 'download_link', array(
        'type' => 'url',
        'section' => 'download_setting',
        'label'   => __('Download Link','customizable'),
    ) );
   // End Download Setting Section
   // Start Home Page Heading Text Section 
    $wp_customize->add_section( 'home_header_section', array(
      'capability'     => 'edit_theme_options',
      'theme_supports' => '',
      'title'          => esc_html__('Home Page Title', 'customizable'),
      'description'    => esc_html__('Some text regarding default home page title.', 'customizable'),
      'panel'          => 'homepage_setting'
    ) );
    $wp_customize->add_setting( 'home_page_title', array(
      'default' => isset($customizable_options['headingtext'])?$customizable_options['headingtext']:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'home_page_title', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'home_header_section',
        'label'   => __('Home Page Title','customizable'),
        'description' => '',
    ) );
/* ------------- End Homepage setting panel ------------- */
/* ------------- Start Footer Settings Section ------------- */
  // Copyright Section
   $wp_customize->add_section( 'footer_setting', array(
      'capability'     => 'edit_theme_options',
      'theme_supports' => '',
      'title'          => esc_html__('Footer Settings', 'customizable'),
      'description' => '',
    ) );
    $wp_customize->add_setting( 'footerCopyright', array(
      'default' => isset($customizable_options['footertext'])?$customizable_options['footertext']:'',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'footerCopyright', array(
        'type' => 'textarea',
        'section' => 'footer_setting',
        'label'   => __('Copyright Text','customizable'),
        'description' => esc_html__('Some text regarding copyright of your site, you would like to display in the footer.', 'customizable'),
    ) );
  /* ------------- End Footer Section ------------- */
 // $wp_customize->get_section('title_tagline')->panel = 'general';
}
add_action( 'customize_register', 'customizable_customize_register' );