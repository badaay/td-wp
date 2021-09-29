<?php
/**
 * The Template for displaying all single posts
 *
*/ get_header();?>

<section>
  <div class="customize-breadcrumb">
    <div class="container customize-container">
      <h1>
        <?php the_title();?>
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
          <h4><?php echo esc_html(customizable_entry_meta());?></h4>
          <div class="content">
            <?php the_content();
                wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'customizable' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );?>
          </div>
        </div>
      </article>
      <nav class="customizable-nav"> <span class="customizable-nav-previous pull-left">
        <?php previous_post_link(); ?>
        </span> <span class="customizable-nav-next pull-right">
        <?php next_post_link(); ?>
        </span> </nav>
      <!-- .nav-single -->
      <?php endwhile;?>
      <?php  if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
          ?>
      <?php 
		   else : 
		   ?>
      <p> no posts found </p>
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
