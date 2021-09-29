<?php 
// register widget
function customize_social_widgets_func() {
  return register_widget("customize_social_widget");
}
add_action( 'widgets_init', 'customize_social_widgets_func' );
/**** 
S O C I A L  W I D G E T 
* * * * * * * * * * * */
class customize_social_widget extends WP_Widget {
// constructor
	public function __construct() {
		 parent::__construct(false, $customizable_name = __('customize Social Link', 'customizable') );
	}
	// widget form creation
function form($customizable_instance) {

// Check values
if( $customizable_instance) {
   $customizable_title = esc_attr($customizable_instance['title']);
	 $customizable_facebook = esc_attr($customizable_instance['facebook']);
	 $customizable_twitter = esc_attr($customizable_instance['twitter']);
	 $customizable_pinterest = esc_attr($customizable_instance['pinterest']);
	 $customizable_gplus = esc_attr($customizable_instance['gplus']);
	
} else {
   $customizable_title = '';
	 $customizable_facebook = '';
	 $customizable_twitter = '';
	 $customizable_pinterest = '';
	 $customizable_gplus = '';
}
?>
<p>
  <label for="<?php echo esc_html($this->get_field_id('title')); ?>">
    <?php esc_html_e('Widget Title', 'customizable'); ?>
  </label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($customizable_title); ?>" />
</p>
<!-- F A C E B O O K -->
<p>
  <label for="<?php echo esc_html($this->get_field_id('facebook')); ?>">
    <?php esc_html_e('Facebook', 'customizable'); ?>
  </label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($customizable_facebook); ?>" />
</p>
<!-- T W I T T E R -->
<p>
  <label for="<?php echo esc_html($this->get_field_id('twitter')); ?>">
    <?php esc_html_e('Twitter', 'customizable'); ?>
  </label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($customizable_twitter); ?>" />
</p>
<!-- P I N T R E S T -->
<p>
  <label for="<?php echo esc_html($this->get_field_id('pinterest')); ?>">
    <?php esc_html_e('Pinterest', 'customizable'); ?>
  </label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" type="text" value="<?php echo esc_attr($customizable_pinterest); ?>" />
</p>
<!-- G PLUS -->
<p>
  <label for="<?php echo esc_html($this->get_field_id('gplus')); ?>">
    <?php esc_html_e('Google+', 'customizable'); ?>
  </label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('gplus')); ?>" name="<?php echo esc_attr($this->get_field_name('gplus')); ?>" type="text" value="<?php echo esc_attr($customizable_gplus); ?>" />
</p>
<?php
}

// update widget
function update($customizable_new_instance, $customizable_old_instance) {
      $customizable_instance = $customizable_old_instance;
      // Fields
		$customizable_instance['title'] = strip_tags($customizable_new_instance['title']);
		$customizable_instance['facebook'] = strip_tags($customizable_new_instance['facebook']);
		$customizable_instance['twitter'] = strip_tags($customizable_new_instance['twitter']);
		$customizable_instance['pinterest'] = strip_tags($customizable_new_instance['pinterest']);
		$customizable_instance['gplus'] = strip_tags($customizable_new_instance['gplus']);
     return $customizable_instance;
}

	// widget display
	// display widget
function widget($args, $customizable_instance) {
   extract( $args );
   // these are the widget options
		$customizable_title = apply_filters('widget_title', $customizable_instance['title']);
		$customizable_facebook = esc_attr($customizable_instance['facebook']);
		$customizable_twitter = esc_attr($customizable_instance['twitter']);
		$customizable_pinterest = esc_attr($customizable_instance['pinterest']);
		$customizable_gplus = esc_attr($customizable_instance['gplus']);
   
   echo $before_widget;
   // Check if title is set
   if ( $customizable_title ) {
      echo $before_title . $customizable_title . $after_title;
   }?>
<ul class="social_icon">
  <?php if(!empty($customizable_facebook));?><li><a href="<?php echo esc_url($customizable_facebook);?>" class="icon_f"><img src="<?php echo esc_url(get_template_directory_uri());?>/images/s-icon2.png" /></a></li>
    <?php if(!empty($customizable_gplus));?><li><a href="<?php echo esc_url($customizable_gplus);?>" class="icon_t"><img src="<?php echo esc_url(get_template_directory_uri());?>/images/s-icon1.png" /></a></li>
      <?php if(!empty($customizable_twitter));?><li><a href="<?php echo esc_url($customizable_twitter);?>" class="icon_g"><img src="<?php echo esc_url(get_template_directory_uri());?>/images/s-icon3.png" /></a></li>
  <?php if(!empty($customizable_pinterest));?><li><a href="<?php echo esc_url($customizable_pinterest);?>" class="icon_i"><img src="<?php echo esc_url(get_template_directory_uri());?>/images/s-icon4.png" /></a></li> 
</ul>
<?php
   echo $after_widget;
}
}