<?php $limit = get_option( 'navian_blog_default_excerpt_length', 31 ); ?>
<div class="post-wrap mb64">
	<div class="inner-wrap border-none p0">
		<div class="inner-left">
			<div class="day"><?php echo get_the_time('d') ?></div>
			<div class="month"><?php echo get_the_time('M') ?></div>
		</div>
		<div class="inner-right">
		    <?php
		    get_template_part( 'templates/post/inc', 'header' );
			echo navian_excerpt($limit);
			?>
			<div class="overflow-hidden">
				<div class="pull-left">
					<span class="read-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'navian' ); ?></a></span>
				</div>
			</div>
		</div>
	</div>
</div>