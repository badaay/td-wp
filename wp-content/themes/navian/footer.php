		<?php get_template_part( 'templates/footer/layout', navian_get_footer_layout() ); ?>
		<?php if ( 'yes' == get_option('navian_enable_scroll_top', 'yes') ) : ?>
			<div class="back-to-top"><a href="#" rel="nofollow"><?php esc_html_e( 'Back to top of page', 'navian' ) ?></a></div>
		<?php endif; ?>
	</div><!--END: main-container-->
	<?php get_template_part( 'templates/footer/inc', 'lightbox' ); ?>
	<?php wp_footer(); ?>
</body>
</html>