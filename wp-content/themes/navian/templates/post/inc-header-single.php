<div class="entry-data entry-data-big mt24">
	<figure class="entry-data-author">
		<?php echo get_avatar( get_the_author_meta('ID') , 95 ); ?>
	</figure>
	<div class="entry-data-summary">
		<span class="inline-block author-name"><?php the_author_posts_link() ?></span>
		<?php if( get_the_author_meta( 'description') ) : ?>
			<p><?php echo nl2br( get_the_author_meta( 'description') ); ?></p>
		<?php endif; ?>
		<?php if( get_the_author_meta('url') ) : ?>
		<p><?php esc_html_e( 'Website:', 'navian' ) ?> <a href="<?php echo get_the_author_meta('url'); ?>" target="_blank"><?php echo get_the_author_meta('url'); ?></a></p>
		<?php endif; ?>
		<ul class="list-inline social-list modern-social">
			<?php if( get_the_author_meta('twitter') ) : ?>
				<li><a class="icon-twitter" href="<?php echo get_the_author_meta('twitter'); ?>" target="_blank"><i class="ti-twitter-alt"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('googleplus') ) : ?>
				<li><a class="icon-google" href="<?php echo get_the_author_meta('googleplus'); ?>" target="_blank"><i class="ti-google"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('facebook') ) : ?>
				<li><a class="icon-facebook" href="<?php echo get_the_author_meta('facebook'); ?>" target="_blank"><i class="ti-facebook"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('instagram') ) : ?>
				<li><a class="icon-instagram" href="<?php echo get_the_author_meta('instagram'); ?>" target="_blank"><i class="ti-instagram"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('github') ) : ?>
				<li><a class="icon-github" href="<?php echo get_the_author_meta('github'); ?>" target="_blank"><i class="ti-github"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('vimeo') ) : ?>
				<li><a class="icon-vimeo" href="<?php echo get_the_author_meta('vimeo'); ?>" target="_blank"><i class="ti-vimeo-alt"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('youtube') ) : ?>
				<li><a class="icon-youtube" href="<?php echo get_the_author_meta('youtube'); ?>" target="_blank"><i class="ti-youtube"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('linkedin') ) : ?>
				<li><a class="icon-linkedin" href="<?php echo get_the_author_meta('linkedin'); ?>" target="_blank"><i class="ti-linkedin"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('tumblr') ) : ?>
				<li><a class="icon-tumblr" href="<?php echo get_the_author_meta('tumblr'); ?>" target="_blank"><i class="ti-tumblr-alt"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('dribbble') ) : ?>
				<li><a class="icon-dribbble" href="<?php echo get_the_author_meta('dribbble'); ?>" target="_blank"><i class="ti-dribbble"></i></a></li>
			<?php endif; ?>
			<?php if( get_the_author_meta('pinterest') ) : ?>
				<li><a class="icon-pinterest" href="<?php echo get_the_author_meta('pinterest'); ?>" target="_blank"><i class="ti-pinterest"></i></a></li>
			<?php endif; ?>                 
        </ul>
	</div>
</div>