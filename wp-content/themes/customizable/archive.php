<?php 
/**
 * The template for displaying Archive pages
*/
get_header();?>
<section>
  <div class="customize-breadcrumb">
    <div class="container customize-container">
      <h1>
        <?php
						if ( is_day() ) :
            esc_html_e('Daily Archives','customizable'); echo ": ". get_the_date();
        elseif ( is_month() ) :
            esc_html_e('Monthly Archives','customizable'); echo ": ". get_the_date('F Y');
        elseif ( is_year() ) :
            esc_html_e('Yearly Archives','customizable'); echo ": ". get_the_date('Y');
        else :
            esc_html_e( 'Archives', 'customizable' );
        endif;  
					?>
      </h1>
      <?php customizable_breadcrumbs();?>
    </div>
  </div>
</section>
<section class="main_section">
  <div class="container customize-container">
    <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
    <div class="left_section">
      <?php if(have_posts()):?>
      <?php while(have_posts()): the_post();?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="section_post border-none">
          <?php if(has_post_thumbnail()) {echo get_the_post_thumbnail(get_the_ID(), 'customizable-blog-width',array('class'=>''));}?>
          <h3>
            <?php the_title(); ?>
          </h3>
          <h4><?php customizable_entry_meta();?></h4>
          <div class="content"> <?php the_excerpt();?></div>
          <a class="read-more" href="<?php echo esc_url(get_permalink());?>"><?php esc_html_e('READ MORE','customizable') ?></a> </div>
      </article>
      <?php endwhile;?>
        <!--Pagination Start-->
        <?php if(function_exists('faster_pagination')) { ?> 
            <?php faster_pagination();?>
        <?php }else { ?>
        <?php if(get_option('posts_per_page ') < $wp_query->found_posts) { ?>
        <div class="col-md-12 customizable-default-pagination">
            <span class="customizable-previous-link"><?php previous_posts_link(); ?></span>
            <span class="customizable-next-link"><?php next_posts_link(); ?></span>
        </div>
        <?php } ?>
        <?php }//is plugin active ?>
		<!--Pagination End-->

      <?php
		   else : 
		   ?>
      <p><?php esc_html_e('no posts found','customizable') ?>  </p>
      <?php  endif;?>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
    <div class="side_bar">
      <?php get_sidebar();?>
    </div>
  </div>
</div>
  </div>
</section>
<?php get_footer();?>
