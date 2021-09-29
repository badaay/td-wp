<?php get_header(); ?>
<section class="fullscreen bg-light">
    <div class="container">
        <div class="xs-container">
            <div class="text-center">
                <h1><?php esc_html_e('404', 'navian'); ?></h1>
                <h2 class="notfound-title"><?php echo wp_kses( __("SORRY, WE CAN'T FIND THE PAGE YOU'RE LOOKING FOR.", 'navian' ), navian_allowed_tags() ); ?></h2>
                <p class="notfound-subtitle"><?php echo wp_kses( __("Perhaps searching can help.", 'navian' ), navian_allowed_tags() ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer();