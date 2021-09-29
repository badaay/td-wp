<?php
/*
* Template Name: Home Page
*/

get_header(); 
$customizable_options = get_option( 'faster_theme_options' );
/*$DefaultSlider = array(
  array('url'=>isset($customizable_options['fburl'])?$foodrecipes_options['fburl']:'','icon'=>isset($foodrecipes_options['foodrecipes_fbcode'])?$foodrecipes_options['foodrecipes_fbcode']:'fa-facebook'),
  );*/
?>
<section class="main_section">
 <?php  if(get_theme_mod('hide_slider_section')==''){ ?>
<div class="callbacks_container">
<ul class="rslides" id="slider4">
<?php for($customizable_loop=1 ; $customizable_loop <5 ; $customizable_loop++): 
  $sliderimage_image = get_theme_mod ( 'slider_image_'.$customizable_loop,isset($customizable_options['slider-img-'.$customizable_loop])?customizable_get_image_id($customizable_options['slider-img-'.$customizable_loop]):'');  
     if(!empty($sliderimage_image)){ 
     $sliderimage_image_url = wp_get_attachment_image_src($sliderimage_image,'full'); ?>
    	<li><?php if(get_theme_mod('slide_link_'.$customizable_loop,$customizable_options['slidelink-'.$customizable_loop])!='') { ?><a href="<?php echo esc_url(get_theme_mod('slide_link_'.$customizable_loop,$customizable_options['slidelink-'.$customizable_loop]));?>" target="_blank"><img src="<?php echo esc_url($sliderimage_image_url[0]); ?>" alt="" /></a><?php }else{?><img src="<?php echo esc_url(get_theme_mod('slider_image_'.$customizable_loop,$customizable_options['slider-img-'.$customizable_loop])); ?>" alt="" /><?php } ?></li>
    <?php } ?>
<?php endfor;?>
</ul>
</div>
<?php } ?>
<div class="container customize-container"> 
   <?php  if(get_theme_mod('hide_first_section')==''){ ?>
    <div class="col-md-12 customizable-home-title">
        	<?php if(get_theme_mod('first_section_title',isset($customizable_options['sectionhead'])?$customizable_options['sectionhead']:'')!=''){ ?>
		<h1>
      <?php echo wp_kses_post(get_theme_mod('first_section_title',isset($customizable_options['sectionhead'])?$customizable_options['sectionhead']:'')); ?>
           <h6><span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/line-logo.png" /></span></h6>
        </h1>
        <?php } ?>
    </div>
     <div class="col-md-12 customizable-home-icom">
     
<?php
	 for($customizable_l=1; $customizable_l <= 3 ;$customizable_l++ ):
     $icon_image = get_theme_mod ( 'tab_'.$customizable_l.'_icon',isset($customizable_options['section-icon-'.$customizable_l])?customizable_get_image_id($customizable_options['section-icon-'.$customizable_l]):'');     
     if(!empty($icon_image)): 
     $icon_image_url = wp_get_attachment_image_src($icon_image,'thumbnail'); 	 ?>
		<div class="col-md-4 customizable-post">
        	 <div class="back-icon">	
	            <img class="fa icon-center" src="<?php echo esc_url($icon_image_url[0]); ?>" />
             </div>   
             <div>
             	<h1><?php if(get_theme_mod('tab_'.$customizable_l.'_title',isset($customizable_options['sectiontitle'.$customizable_l])?$customizable_options['sectiontitle'.$customizable_l]:'') != '') 
                  echo wp_kses_post( get_theme_mod('tab_'.$customizable_l.'_title',isset($customizable_options['sectiontitle'.$customizable_l])?$customizable_options['sectiontitle'.$customizable_l]:'')); ?></h1>
				<p><?php 
        if(get_theme_mod('tab_description_'.$customizable_l,isset($customizable_options['sectiondesc-'.$customizable_l])?$customizable_options['sectiondesc-'.$customizable_l]:'') != '') 
        echo wp_kses_post(get_theme_mod('tab_description_'.$customizable_l,isset($customizable_options['sectiondesc-'.$customizable_l])?$customizable_options['sectiondesc-'.$customizable_l]:''));
      ?></p>
             </div>
        </div>	 
	 <?php
	 endif;
	 endfor; ?>
    </div> 
<?php } 
if(get_theme_mod('hide_second_section')==''){ ?>
<!-- LATEST POST -->
	<div class="col-md-12 customizable-home-title"> 
          <?php if(get_theme_mod('recent_post_title',isset($customizable_options['post-title'])?$customizable_options['post-title']:'') != '') {
          ?>
    	<h1><?php echo wp_kses_post(get_theme_mod('recent_post_title',isset($customizable_options['post-title'])?$customizable_options['post-title']:'')); ?></h1>
        <h6><span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/line-logo.png" /></span></h6>
        <?php } ?>
        
    </div>
	<div class="row no-padding customizable-postcat">
    <?php 
        $customizable_args = array(
			   'cat'  => get_theme_mod('section_2_category',isset($customizable_options['post-category'])?$customizable_options['post-category']:''),
				'meta_query' => array(
					array(
					 'key' => '_thumbnail_id',
					 'compare' => 'EXISTS'
					),
				)
			);		
    $customizable_post = new WP_Query( $customizable_args );
    if ( $customizable_post->have_posts() ) { ?>
			<div class="owl-carousel" id="owl-demo" >
		   <?php
            while ( $customizable_post->have_posts() ) {
            $customizable_post->the_post();
            $customizable_feature_img_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_id())); ?>
    	<div class="col-md-3 post-blog" >
              <div>
				 <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><img src="<?php echo esc_url($customizable_feature_img_url); ?>"></a>
              </div>
              <h2> 
                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"> <?php echo get_the_title(); ?> </a>
              </h2>
              <span> <?php the_date(); ?> </span>
              <p> <?php echo esc_html(get_the_excerpt()); ?>	</p>
          	  <div class=" col-md-12 no-padding post-comment" >
                    <div class="col-md-6 no-padding post-comment-set">
                        <?php esc_html_e('Post By:','customizable') ?><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))); ?>"> <?php echo get_the_author(); ?></a>
                    </div>
                    <div class="col-md-6 no-padding post-comment-set text-right">
                        <?php esc_html_e('Comments:','customizable') ?> <?php echo esc_html(get_comments_number()); ?>
                    </div>
              </div>
        </div>
        <?php } ?> 
        </div>
			<?php } else {
            echo '<p>'.esc_html__('no posts found','customizable').'</p>'; } ?>
    </div>
<!-- END LATEST POST -->
<?php } ?>
</div>
<?php if(get_theme_mod('hide_download_section')==''){ ?>
<div class="col-md-12 no-padding download-theme">
 <div class="container customize-container">
    	<div class="col-md-10 buttone-left no-padding">
        	<p><?php if(get_theme_mod('download_caption',isset($customizable_options['downloadcaption'])?$customizable_options['downloadcaption']:'') != '')
          echo wp_kses_post(get_theme_mod('download_caption',isset($customizable_options['downloadcaption'])?$customizable_options['downloadcaption']:'')); ?></p>
        </div>
        <div class="col-md-2 btn-group no-padding">
        <?php if(get_theme_mod('download_link',isset($customizable_options['downloadlink'])?$customizable_options['downloadlink']:'') != ''){ ?>
		  <a href="<?php echo esc_url(get_theme_mod('download_link',isset($customizable_options['downloadlink'])?$customizable_options['downloadlink']:'')); ?>" class="btn btn-default download-button"><?php esc_html_e('Download ','customizable') ?></a>
          <?php } ?>
        </div>
    </div>
    </div>
<?php } ?>
</section>
<?php get_footer();?>
