<?php
/**
 * Custom post types
 *
 * @package TLG Framework
 *
 */

/**
    PORTFOLIO
**/
function tlg_framework_register_portfolio() {
    $slug   = get_option( 'tlg_framework_portfolio_slug', 'portfolio' );
    $name   = ucwords(strtolower($slug));
    $labels = array( 
        'name'                  => $name,
        'singular_name'         => esc_html__( 'Portfolio', 'tlg_framework' ),
        'add_new'               => esc_html__( 'Add New', 'tlg_framework' ),
        'add_new_item'          => esc_html__( 'Add New Portfolio', 'tlg_framework' ),
        'edit_item'             => esc_html__( 'Edit Portfolio', 'tlg_framework' ),
        'new_item'              => esc_html__( 'New Portfolio', 'tlg_framework' ),
        'view_item'             => esc_html__( 'View Portfolio', 'tlg_framework' ),
        'search_items'          => esc_html__( 'Search Portfolios', 'tlg_framework' ),
        'not_found'             => esc_html__( 'No portfolios found', 'tlg_framework' ),
        'not_found_in_trash'    => esc_html__( 'No portfolios found in Trash', 'tlg_framework' ),
        'parent_item_colon'     => esc_html__( 'Parent Portfolio:', 'tlg_framework' ),
        'menu_name'             => esc_html__( 'Portfolio', 'tlg_framework' ),
    );
    $args = array( 
        'labels'                => $labels,
        'hierarchical'          => false,
        'description'           => esc_html__( 'Portfolio entries.', 'tlg_framework' ),
        'supports'              => array( 'title', 'editor', 'thumbnail', 'post-formats', 'comments' ),
        'taxonomies'            => array( 'portfolio-category' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_nav_menus'     => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'has_archive'           => true,
        'query_var'             => true,
        'can_export'            => true,
        'rewrite'               => array( 'slug' => $slug ),
        'capability_type'       => 'post'
    );
    register_post_type( 'portfolio', $args );
}
add_action( 'init', 'tlg_framework_register_portfolio', 10 );

function tlg_framework_create_portfolio_taxonomies() {
    $labels = array(
        'name'                 => _x( 'Portfolio Categories','tlg_framework' ),
        'singular_name'        => _x( 'Portfolio Category','tlg_framework' ),
        'search_items'         => esc_html__( 'Search Portfolio Categories','tlg_framework' ),
        'all_items'            => esc_html__( 'All Portfolio Categories','tlg_framework' ),
        'parent_item'          => esc_html__( 'Parent Portfolio Category','tlg_framework' ),
        'parent_item_colon'    => esc_html__( 'Parent Portfolio Category:','tlg_framework' ),
        'edit_item'            => esc_html__( 'Edit Portfolio Category','tlg_framework' ), 
        'update_item'          => esc_html__( 'Update Portfolio Category','tlg_framework' ),
        'add_new_item'         => esc_html__( 'Add New Portfolio Category','tlg_framework' ),
        'new_item_name'        => esc_html__( 'New Portfolio Category Name','tlg_framework' ),
        'menu_name'            => esc_html__( 'Portfolio Categories','tlg_framework' ),
    );  
    register_taxonomy('portfolio_category', array('portfolio'), array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => true,
    ));
}
add_action( 'init', 'tlg_framework_create_portfolio_taxonomies', 10 );

/**
    TEAM
**/    
function tlg_framework_register_team() {
    $labels = array( 
        'name'                  => esc_html__( 'Team Members', 'tlg_framework' ),
        'singular_name'         => esc_html__( 'Team Member', 'tlg_framework' ),
        'add_new'               => esc_html__( 'Add New', 'tlg_framework' ),
        'add_new_item'          => esc_html__( 'Add New Team Member', 'tlg_framework' ),
        'edit_item'             => esc_html__( 'Edit Team Member', 'tlg_framework' ),
        'new_item'              => esc_html__( 'New Team Member', 'tlg_framework' ),
        'view_item'             => esc_html__( 'View Team Member', 'tlg_framework' ),
        'search_items'          => esc_html__( 'Search Team Members', 'tlg_framework' ),
        'not_found'             => esc_html__( 'No Team Members found', 'tlg_framework' ),
        'not_found_in_trash'    => esc_html__( 'No Team Members found in Trash', 'tlg_framework' ),
        'parent_item_colon'     => esc_html__( 'Parent Team Member:', 'tlg_framework' ),
        'menu_name'             => esc_html__( 'Team Members', 'tlg_framework' ),
    );
    $args = array( 
        'labels'                => $labels,
        'hierarchical'          => false,
        'description'           => esc_html__( 'Team Member entries.', 'tlg_framework' ),
        'supports'              => array( 'title', 'thumbnail' ),
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_nav_menus'     => true,
        'publicly_queryable'    => false,
        'exclude_from_search'   => true,
        'has_archive'           => false,
        'query_var'             => false,
        'can_export'            => true,
        'rewrite'               => true,
        'capability_type'       => 'post'
    );
    register_post_type( 'team', $args );
}
add_action( 'init', 'tlg_framework_register_team', 10 );

function tlg_framework_create_team_taxonomies() {
    $labels = array(
        'name'                    => _x( 'Team Categories','tlg_framework' ),
        'singular_name'           => _x( 'Team Category','tlg_framework' ),
        'search_items'            => esc_html__( 'Search Team Categories','tlg_framework' ),
        'all_items'               => esc_html__( 'All Team Categories','tlg_framework' ),
        'parent_item'             => esc_html__( 'Parent Team Category','tlg_framework' ),
        'parent_item_colon'       => esc_html__( 'Parent Team Category:','tlg_framework' ),
        'edit_item'               => esc_html__( 'Edit Team Category','tlg_framework' ), 
        'update_item'             => esc_html__( 'Update Team Category','tlg_framework' ),
        'add_new_item'            => esc_html__( 'Add New Team Category','tlg_framework' ),
        'new_item_name'           => esc_html__( 'New Team Category Name','tlg_framework' ),
        'menu_name'               => esc_html__( 'Team Categories','tlg_framework' ),
    ); 
    register_taxonomy( 'team_category', array( 'team' ), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
}
add_action( 'init', 'tlg_framework_create_team_taxonomies', 10 );

/**
    CLIENT
**/     
function tlg_framework_register_client() {
    $labels = array( 
        'name'                  => esc_html__( 'Clients', 'tlg_framework' ),
        'singular_name'         => esc_html__( 'Client', 'tlg_framework' ),
        'add_new'               => esc_html__( 'Add New', 'tlg_framework' ),
        'add_new_item'          => esc_html__( 'Add New Client', 'tlg_framework' ),
        'edit_item'             => esc_html__( 'Edit Client', 'tlg_framework' ),
        'new_item'              => esc_html__( 'New Client', 'tlg_framework' ),
        'view_item'             => esc_html__( 'View Client', 'tlg_framework' ),
        'search_items'          => esc_html__( 'Search Clients', 'tlg_framework' ),
        'not_found'             => esc_html__( 'No Clients found', 'tlg_framework' ),
        'not_found_in_trash'    => esc_html__( 'No Clients found in Trash', 'tlg_framework' ),
        'parent_item_colon'     => esc_html__( 'Parent Client:', 'tlg_framework' ),
        'menu_name'             => esc_html__( 'Clients', 'tlg_framework' ),
    );
    $args = array( 
        'labels'                => $labels,
        'hierarchical'          => false,
        'description'           => esc_html__( 'Client entries.', 'tlg_framework' ),
        'supports'              => array( 'title', 'thumbnail' ),
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_nav_menus'     => true,
        'publicly_queryable'    => false,
        'exclude_from_search'   => true,
        'has_archive'           => false,
        'query_var'             => false,
        'can_export'            => true,
        'rewrite'               => true,
        'capability_type'       => 'post'
    );
    register_post_type( 'client', $args );
}
add_action( 'init', 'tlg_framework_register_client', 10 );

function tlg_framework_create_client_taxonomies(){
    $labels = array(
        'name'                => _x( 'Client Categories','tlg_framework' ),
        'singular_name'       => _x( 'Client Category','tlg_framework' ),
        'search_items'        => esc_html__( 'Search Client Categories','tlg_framework' ),
        'all_items'           => esc_html__( 'All Client Categories','tlg_framework' ),
        'parent_item'         => esc_html__( 'Parent Client Category','tlg_framework' ),
        'parent_item_colon'   => esc_html__( 'Parent Client Category:','tlg_framework' ),
        'edit_item'           => esc_html__( 'Edit Client Category','tlg_framework' ), 
        'update_item'         => esc_html__( 'Update Client Category','tlg_framework' ),
        'add_new_item'        => esc_html__( 'Add New Client Category','tlg_framework' ),
        'new_item_name'       => esc_html__( 'New Client Category Name','tlg_framework' ),
        'menu_name'           => esc_html__( 'Client Categories','tlg_framework' ),
    );  
    register_taxonomy( 'client_category', array('client'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));
}
add_action( 'init', 'tlg_framework_create_client_taxonomies', 10 );

/**
    TESTIMONIAL
**/ 
function tlg_framework_register_testimonial() {
    $labels = array( 
        'name'                  => esc_html__( 'Testimonials', 'tlg_framework' ),
        'singular_name'         => esc_html__( 'Testimonial', 'tlg_framework' ),
        'add_new'               => esc_html__( 'Add New', 'tlg_framework' ),
        'add_new_item'          => esc_html__( 'Add New Testimonial', 'tlg_framework' ),
        'edit_item'             => esc_html__( 'Edit Testimonial', 'tlg_framework' ),
        'new_item'              => esc_html__( 'New Testimonial', 'tlg_framework' ),
        'view_item'             => esc_html__( 'View Testimonial', 'tlg_framework' ),
        'search_items'          => esc_html__( 'Search Testimonials', 'tlg_framework' ),
        'not_found'             => esc_html__( 'No Testimonials found', 'tlg_framework' ),
        'not_found_in_trash'    => esc_html__( 'No Testimonials found in Trash', 'tlg_framework' ),
        'parent_item_colon'     => esc_html__( 'Parent Testimonial:', 'tlg_framework' ),
        'menu_name'             => esc_html__( 'Testimonials', 'tlg_framework' ),
    );
    $args = array( 
        'labels'                => $labels,
        'hierarchical'          => false,
        'description'           => esc_html__( 'Testimonial entries.', 'tlg_framework' ),
        'supports'              => array( 'title', 'thumbnail' ),
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-editor-quote',
        'show_in_nav_menus'     => true,
        'publicly_queryable'    => false,
        'exclude_from_search'   => true,
        'has_archive'           => false,
        'query_var'             => false,
        'can_export'            => true,
        'rewrite'               => true,
        'capability_type'       => 'post'
    );
    register_post_type( 'testimonial', $args );
}
add_action( 'init', 'tlg_framework_register_testimonial', 10 );

function tlg_framework_create_testimonial_taxonomies(){
    $labels = array(
        'name'                => _x( 'Testimonial Categories','tlg_framework' ),
        'singular_name'       => _x( 'Testimonial Category','tlg_framework' ),
        'search_items'        => esc_html__( 'Search Testimonial Categories','tlg_framework' ),
        'all_items'           => esc_html__( 'All Testimonial Categories','tlg_framework' ),
        'parent_item'         => esc_html__( 'Parent Testimonial Category','tlg_framework' ),
        'parent_item_colon'   => esc_html__( 'Parent Testimonial Category:','tlg_framework' ),
        'edit_item'           => esc_html__( 'Edit Testimonial Category','tlg_framework' ), 
        'update_item'         => esc_html__( 'Update Testimonial Category','tlg_framework' ),
        'add_new_item'        => esc_html__( 'Add New Testimonial Category','tlg_framework' ),
        'new_item_name'       => esc_html__( 'New Testimonial Category Name','tlg_framework' ),
        'menu_name'           => esc_html__( 'Testimonial Categories','tlg_framework' ),
    );
    register_taxonomy( 'testimonial_category', array( 'testimonial' ), array(
        'hierarchical'        => true,
        'labels'              => $labels,
        'show_ui'             => true,
        'show_admin_column'   => true,
        'query_var'           => true,
        'rewrite'             => true,
    ));
}
add_action( 'init', 'tlg_framework_create_testimonial_taxonomies', 10 );