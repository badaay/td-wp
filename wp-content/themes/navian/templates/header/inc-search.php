<div class="module widget-wrap search-widget-wrap left">
    <div class="search">
        <a href="#" class="modal-fixed-action" data-modal="search-modal"><i class="ti-search"></i></a>
        <span class="title"><?php esc_html_e( 'Search Site', 'navian' ); ?></span>
    </div>
    <div class="widget-inner modal-fixed" id="search-modal">
	    <a class="modal-fixed-close hidden-sx text-right" href="#"><i class="ti-close color-white-force ms-text opacity-show"></i></a>
	    <div class="modal-fixed-content">
        	<?php echo get_search_form(); ?>
            <?php if( 'yes' == get_option( 'navian_search_enable_navigation', 'yes' ) ) {  ?>
            <div class="search__suggestion mt40 hide-sm">
                <h3><?php echo navian_get_menu_title('search'); ?></h3>
                <?php
                if (has_nav_menu('search')) {
                    wp_nav_menu( 
                        array(
                            'theme_location'    => 'search',
                            'depth'             => 1,
                            'container'         => false,
                            'container_class'   => false,
                            'menu_class'        => 'menu list-inline vertical-top mb0',
                            'fallback_cb'       => 'Navian_Nav_Walker::fallback',
                            'walker'            => new Navian_Nav_Walker()
                        )
                    );
                }
                ?>
            </div>
            <?php } ?>
	    </div>
    </div>
</div>