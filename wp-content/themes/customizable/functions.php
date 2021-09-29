<?php 
 /*
 * Customizable functions and definitions
*/
if ( ! function_exists( 'customizable_setup' ) ) :

function customizable_setup() {
	global $content_width;
	if ( ! isset( $content_width ) ) {
	$content_width = 750;
	}

	load_theme_textdomain( 'customizable' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', customizable_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'customizable-full-width', 1038, 576, true );
	add_image_size( 'customizable-blog-width', 730, 428, true );
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'customizable' ),
		'secondary' => __( 'Secondary menu in footer', 'customizable' ),
	) );
	/* Logo */
	add_theme_support( 'custom-logo',array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
        'priority' => 11,     
        'header-text' => array('img-responsive-logo', 'site-description-logo'),
    ) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );


	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'customizable_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'customizable_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // customizable_setup
add_action( 'after_setup_theme', 'customizable_setup' );

// Custome social widget
require_once('inc/social-custom-widget.php');
// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';
// Theme Customizer Setting.
require get_template_directory() . '/inc/customizer.php';

add_action('wp_enqueue_scripts','customizable_load_scripts');
function customizable_load_scripts(){
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.0.2' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '3.0.2' );
	wp_enqueue_style( 'customizable-style', get_stylesheet_uri(),array('bootstrap'));
	wp_enqueue_style('googlefontapi','//fonts.googleapis.com/css?family=Cabin',array(),'','');
	if(is_front_page()){
	wp_enqueue_style('owl-carousel',get_template_directory_uri().'/css/owl.carousel.css',array());	

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ));	
	wp_enqueue_script('sliderjs',get_template_directory_uri().'/js/responsiveslides.js',array('jquery'));
	}
	wp_enqueue_script('customizable-default-js', get_template_directory_uri() . '/js/default.js', array('jquery'),Null,false);
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}

//Theme Title
function customizable_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$customizable_site_description = get_bloginfo( 'description', 'display' );
	if ( $customizable_site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $customizable_site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		/* translators: 1: page */
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'customizable' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'customizable_wp_title', 10, 2 );

function customizable_font_url() {
	$customizable_font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'customizable' ) ) {
		$customizable_font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $customizable_font_url;
}

/**
 * Register customizable widget areas.
 *
 */
function customizable_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'customizable' ),
		'id'            => 'content-sidebar',
		'description'   => __( 'Additional sidebar that appears on the right.', 'customizable' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer area one', 'customizable' ),
		'id' => 'footer-one',
		'description' => __( 'Appears on footer side', 'customizable' ),
		'before_widget' => '<aside id="%1$s" class="col-md-12 footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer area two', 'customizable' ),
		'id' => 'footer-two',
		'description' => __( 'Appears on footer side', 'customizable' ),
		'before_widget' => '<aside id="%1$s" class="col-md-12 footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer area three', 'customizable' ),
		'id' => 'footer-three',
		'description' => __( 'Appears on footer side', 'customizable' ),
		'before_widget' => '<aside id="%1$s" class="col-md-12 footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer area four', 'customizable' ),
		'id' => 'footer-four',
		'description' => __( 'Appears on footer side', 'customizable' ),
		'before_widget' => '<aside id="%1$s" class="col-md-12 footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'customizable_widgets_init' );

function customizable_read_more( ) {
return ' ...';
 }
add_filter( 'excerpt_more', 'customizable_read_more' ); 

function customizable_breadcrumbs() {
    global $post;
    echo '<ol>';
    if (!is_home()) {
        echo '<li><a href="';
        echo esc_url(home_url());
        echo '">';
        esc_html_e('Home','customizable');
        echo '</a></li> / ';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li> / <li> ');
			
            if (is_single()) {
                echo '</li> / <li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $customizable_anc = get_post_ancestors( $post->ID );
                $customizable_title = get_the_title();
                foreach ( $customizable_anc as $customizable_ancestor ) {
                    $customizable_output = '<li><a href="'.get_permalink($customizable_ancestor).'" title="'.get_the_title($customizable_ancestor).'">'.get_the_title($customizable_ancestor).'</a></li> / ';
                }
                echo esc_html($customizable_output);
                echo '<strong title="'.esc_attr($customizable_title).'"> '.esc_html($customizable_title).'</strong>';
            } else {
                echo '<li><strong> '.esc_html(get_the_title()).'</strong></li>';
            }
        }
	if (is_tag()) {single_tag_title();}
if (is_day()) {echo"<li>".esc_html__('Archive for ','customizable'); get_the_date('F jS, Y'); echo'</li>';}
    if (is_month()) {echo"<li>".esc_html__('Archive for ','customizable'); get_the_date('F, Y'); echo'</li>';}
    if (is_year()) {echo"<li>".esc_html__('Archive for','customizable'); get_the_date('Y'); echo'</li>';}
    if (is_author()) {echo"<li>".esc_html__('Author Archive','customizable'); echo'</li>';}
    if (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>".esc_html__('Blog Archives','customizable'); echo'</li>';}
    if (is_search()) {echo"<li>".esc_html__('Search Results','customizable'); echo'</li>';}
	if (is_404()) {echo"<li>".esc_html__('404','customizable'); echo'</li>';}
    }
    
    echo '</ol>';
}

/**
 * Add default menu style if menu is not set from the backend.
*/ 
function customizable_add_menuid ($page_markup) {
preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $customizable_matches);
$customizable_toreplace = array('<div class="menu">', '</div>');
$customizable_replace = array('', '');
$customizable_new_markup = str_replace($customizable_toreplace,$customizable_replace, $page_markup);
$customizable_new_markup= preg_replace('/<ul/', '<ul', $customizable_new_markup);
return $customizable_new_markup; } //}
add_filter('wp_page_menu', 'customizable_add_menuid');

if ( ! function_exists( 'customizable_comment' ) ) :

function customizable_comment( $comment, $args, $depth ) {	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <p>
    <?php esc_html_e( 'Pingback:', 'customizable' ); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link( esc_html__( 'Edit', 'customizable' ), '<span class="edit-link">', '</span>' ); ?>
  </p>
</li>
<?php
			break;
		default :
		// Proceed with normal comments.
		if($comment->comment_approved	==1)
		{
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <article id="comment-<?php comment_ID(); ?>" class="comment col-md-12 margin-top-bottom">
    <figure class="avtar"> <a href="#"><?php echo get_avatar( get_the_author_meta(), '80'); ?></a> </figure>
    <div class="txt-holder">
      <?php
                            printf( '<b class="fn">%1$s',
                                get_comment_author_link(),
                                ( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author ', 'customizable' ) . '</span>' : ''
                            );
						?>
      <?php
                            
                            echo ' '.get_comment_date().'</b>';
							echo '<a href="#" class="reply pull-right">'.comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'customizable' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ).'</a>';
							
                        ?>
      <div class="comment-content comment">
        <?php comment_text(); ?>
      </div>
      <!-- .comment-content --> 
    </div>
    <!-- .txt-holder --> 
  </article>
  <!-- #comment-## -->
  <?php
		}
		break;
	endswitch; // end comment_type check
}
endif;

function customizable_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'customizable_post_classes' );

function customizable_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_page_template( 'page-templates/contributors.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'customizable_body_classes' );

if ( ! function_exists( 'customizable_entry_meta' ) ) :

function customizable_entry_meta() {

	$customizable_category_list = get_the_category_list( ', ', 'customizable' );

	$customizable_tag_list = get_the_tag_list(', ', 'customizable' );

	$customizable_date = sprintf( '<a href="%1$s" title="%2$s" ><time datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	/* translators: 1: author post url, 2: Author name, 3:author name */
	$customizable_author = sprintf( '<span><a href="%1$s" title="%2$s" >%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		/* translators: 1: author name,*/
		esc_attr( sprintf( esc_html__( 'View all posts by %s', 'customizable' ), get_the_author() ) ),
		get_the_author()
	);
    

	
		if ( $customizable_tag_list ) {
			/* translators: 1: category name, 2: date time, 3: post author */
			$customizable_utility_text = esc_html__( 'Posted in : %1$s  on %3$s by : %4$s ', 'customizable' );
		} elseif ( $customizable_category_list ) {
			/* translators: 1: category name, 2: date time, 3: post author */
			$customizable_utility_text = esc_html__( 'Posted in : %1$s  on %3$s by : %4$s ', 'customizable' );
		} else {
			/* translators: 1: date time, 2: author name */
			$customizable_utility_text = esc_html__( 'Posted on : %3$s by : %4$s ', 'customizable' );
		}		
	
	printf(
		$customizable_utility_text,
		$customizable_category_list,
		$customizable_tag_list,
		$customizable_date,
		$customizable_author
	);
	?>
  <span class="post-tag">
  <?php the_tags(); ?>
  </span>
  <?php }

endif;

function customizable_change_excerpt_more( $more ) {
    return (is_front_page()) ? '' : '...';
}
add_filter('excerpt_more', 'customizable_change_excerpt_more');
function customizable_excerpt_length( $length ) {
    return (is_front_page()) ? 8 : 25;
}
add_filter( 'excerpt_length', 'customizable_excerpt_length', 999 );
// retrieves the attachment ID from the file URL
function customizable_get_image_id($image_url) {
    global $wpdb;
    $customizable_attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return (empty($customizable_attachment))?0:$customizable_attachment[0]; 
}

add_action( 'admin_menu', 'customizable_admin_menu');
function customizable_admin_menu( ) {
    add_theme_page( __('Pro Feature','customizable'), __('Customizable Pro','customizable'), 'manage_options', 'customizable-pro-buynow', 'customizable_pro_buy_now', 300 ); 
  
}
function customizable_pro_buy_now(){ ?>  
  <div class="customizable_pro_version">
  <a href="<?php echo esc_url('https://fasterthemes.com/wordpress-themes/customizablepro/'); ?>" target="_blank">
    <img src ="<?php echo esc_url(get_template_directory_uri().'/images/customizable-pro-feature.png') ?>" width="70%" height="auto" />
  </a>
</div>
<?php }