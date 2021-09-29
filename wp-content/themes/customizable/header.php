<?php
/**
 * The Header for our theme
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
 <?php  global $customizable_options; $customizable_options = get_option( 'faster_theme_options' ); 
 wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
  <div class="top_header">
    <div class="container customize-container">
      <div class="logo">
      <?php if(has_custom_logo() ):  the_custom_logo();  endif;
      if(display_header_text()):  ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
          <h6 class="site-description"><?php echo esc_html(get_bloginfo('description')); ?></h6>
        </a>        
        <?php endif; ?>
      </div>
      
      <div class="header_right">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle navbar-toggle-top" id="menu-trigger"> <span class="sr-only"></span> <span class="icon-bar icon-color"></span> <span class="icon-bar icon-color"></span> <span class="icon-bar icon-color"></span> </button>
        </div>
        <div class="rightmenu">                        
          <?php
              $customizablepro_defaults = array(
                  'theme_location' => 'primary',
                  'container' => 'div',                                    
                  'container_id' => 'mainmenu',
                  'menu_class' => 'navbar-nav mobile-menu',
                  'echo' => true,
                  'depth' => 0,
                  'walker' => '');

              wp_nav_menu($customizablepro_defaults);
          ?> 
        </div>
        <div class="search_box">
          <form id="form_search" name="form_search" method="get" action="<?php echo esc_url(site_url());?>">
            <input type="text" name="s" id="search_top" />
            <input type="button" name="btn1" id="btn_top" value="" />
          </form>
        </div>
      </div>
    </div>
    <?php if ( get_header_image() ) : ?>
    <div id="site-header"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"> <img src="<?php header_image(); ?>" width="<?php echo esc_attr(get_custom_header()->width); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>" alt=""> </a> </div>
    <?php endif; ?>
  </div>
</header>
