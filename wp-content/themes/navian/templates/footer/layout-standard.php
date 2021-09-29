<?php 
$header_info = navian_get_header_info(); 
$social_icons = navian_footer_social_icons();
?>
<footer class="footer-widget bg-graydark <?php echo ( !is_active_sidebar('footer1') && !is_active_sidebar('footer2') && !is_active_sidebar('footer3') && !is_active_sidebar('footer4') ) ? 'p0' : '' ?> ">
    <div class="container">
        <div class="row">
        	<?php
				echo '<div class="col-sm-6">';
					dynamic_sidebar('footer1');
					get_template_part( 'templates/footer/inc', 'menu' );
					if (!empty($social_icons)) { ?>
						<ul class="list-inline social-list mt-xs-8 ml-25 ml-sm-0 display-block-sm">
							<?php echo !empty($social_icons) ? $social_icons : ''; ?>
						</ul><?php 
					} 
				echo '</div><div class="col-md-3">';
				
				echo '</div><div class="col-md-3">';
					dynamic_sidebar('footer4');
				echo '</div><div class="clear"></div>';
        		// if( is_active_sidebar('footer1') && !( is_active_sidebar('footer2') ) && !( is_active_sidebar('footer3') ) && !( is_active_sidebar('footer4') ) ){
        		// 	echo '<div class="col-sm-12">';
        		// 		dynamic_sidebar('footer1');
        		// 	echo '</div>';
        		// }
        		// if( is_active_sidebar('footer2') && !( is_active_sidebar('footer3') ) && !( is_active_sidebar('footer4') ) ){
        		// 	echo '<div class="col-sm-6">';
        		// 		dynamic_sidebar('footer1');
        		// 	echo '</div><div class="col-sm-6">';
        		// 		dynamic_sidebar('footer2');
        		// 	echo '</div><div class="clear"></div>';
        		// }
        		// if( is_active_sidebar('footer3') && !( is_active_sidebar('footer4') ) ){
        		// 	echo '<div class="col-md-4">';
        		// 		dynamic_sidebar('footer1');
        		// 	echo '</div><div class="col-md-4">';
        		// 		dynamic_sidebar('footer2');
        		// 	echo '</div><div class="col-md-4">';
        		// 		dynamic_sidebar('footer3');
        		// 	echo '</div><div class="clear"></div>';
        		// }
        		// if( ( is_active_sidebar('footer4') ) ){
        		// 	echo '<div class="col-md-3">';
        		// 		dynamic_sidebar('footer1');
        		// 	echo '</div><div class="col-md-3">';
        		// 		dynamic_sidebar('footer2');
        		// 	echo '</div><div class="col-md-3">';
        		// 		dynamic_sidebar('footer3');
        		// 	echo '</div><div class="col-md-3">';
        		// 		dynamic_sidebar('footer4');
        		// 	echo '</div><div class="clear"></div>';
        		// }
        	?>
        </div>
    </div>
    <?php if ( 'yes' == get_option( 'navian_enable_copyright', 'yes' ) && 
                (!empty($header_info['footer_text']) || !empty($social_icons) || has_nav_menu('footer')) ) : ?>
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <span class="sub">
                            <?php echo wp_kses($header_info['footer_text'], navian_allowed_tags()); ?>
                        </span>
                    </div>
                    <div class="col-md-7 text-right text-left-sm">
                        <?php 
                        get_template_part( 'templates/footer/inc', 'menu' );
                        if (!empty($social_icons)) { ?>
                            <ul class="list-inline social-list mt-xs-8 ml-25 ml-sm-0 display-block-sm">
                                <?php// echo !empty($social_icons) ? $social_icons : ''; ?>
                            </ul><?php 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>