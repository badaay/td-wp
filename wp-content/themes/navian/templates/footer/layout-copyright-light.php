<?php 
$header_info = navian_get_header_info();
$social_icons = navian_footer_social_icons();
if ( 'yes' == get_option( 'navian_enable_copyright', 'yes' ) && (!empty($header_info['footer_text']) || !empty($social_icons)) ) : ?>
<footer class="footer-widget bg-white p0">
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <span class="sub">
                        <?php echo wp_kses($header_info['footer_text'], navian_allowed_tags()); ?>
                    </span>
                </div>
                <div class="col-sm-6 text-right">
                    <?php if (!empty($social_icons)) { ?>
                    <ul class="list-inline social-list">
                        <?php echo !empty($social_icons) ? $social_icons : ''; ?>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php endif;