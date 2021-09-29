<?php 
if ( post_password_required() ) return; 
global $post;
$comment_class = (!comments_open() && !have_comments() && !navian_check_pings($post->ID)) ? 'hide' : '';
?>
<div class="comments <?php echo esc_attr($comment_class); ?>" id="comments">
    <?php if( have_comments() || navian_check_pings($post->ID) ) : ?>
		<h6 class="widgettitle">
    		<?php comments_number( esc_html__( '0 Comment', 'navian' ), esc_html__( '1 Comment', 'navian' ), esc_html__( '% Comments', 'navian' ) ); ?>
    	</h6>
		<ul id="singlecomments" class="comments-list">
			<?php wp_list_comments( 'type=comment&callback=navian_comment' ); ?>
			<?php wp_list_comments( 'type=pings&callback=navian_pings' ); ?>
		</ul>
	<?php endif;
	paginate_comments_links();
	if ( comments_open() ) {
		comment_form(
			array(
				'fields' => apply_filters( 'comment_form_default_fields', array(
				    'author' => '<div class="row"><div class="col-sm-4"><input type="text" id="author" name="author" placeholder="' . esc_attr__( 'Name *', 'navian' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" /></div>',
				    'email'  => '<div class="col-sm-4"><input name="email" type="text" id="email" placeholder="' . esc_attr__( 'Email *', 'navian' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" /></div>',
				    'url'    => '<div class="col-sm-4"><input name="url" type="text" id="url" placeholder="' . esc_attr__( 'Website', 'navian' ) . '" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" /></div></div>')
				),
				'comment_field' 		=> '<textarea name="comment" placeholder="' . esc_attr__( 'Your Comment Here', 'navian' ) . '" id="comment" aria-required="true" rows="3"></textarea>',
				'cancel_reply_link' 	=> esc_html__( 'Cancel' , 'navian' ),
				'comment_notes_before' 	=> '',
				'comment_notes_after' 	=> '',
				'label_submit' 			=> esc_html__( 'Submit' , 'navian' )
			)
		);
	} else { ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'navian' ) ?></p>
	<?php } ?>
</div>