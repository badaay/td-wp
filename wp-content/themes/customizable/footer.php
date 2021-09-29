<?php
/**
 * The template for displaying the footer
**/ 
?>
<footer class="main_footer">
  <div class="top_footer">
    <div class="container customize-container">
      <?php get_sidebar('footer');?>
    </div>
  </div>
  <div class="bottom_footer">
    <div class="container customize-container">
      <p><?php
  global $customizable_options;
  if(get_theme_mod('footerCopyright',isset($customizable_options['footertext'])?$customizable_options['footertext']:'') != '')
  {
	  echo wp_kses_post(get_theme_mod('footerCopyright',isset($customizable_options['footertext'])?$customizable_options['footertext']:'')).' ';
  }
  /* translators: 1: wordpress, 2: Customizable */
	  printf( esc_html__( 'Powered by %1$s and %2$s', 'customizable' ), '<a href="http://wordpress.org" target="_blank">WordPress</a>', '<a href="https://fasterthemes.com/wordpress-themes/customizable" target="_blank">Customizable</a>' ); ?>
	</p>
    <?php wp_nav_menu(array('theme_location'  => 'secondary', 'fallback_cb' => false)); ?>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
