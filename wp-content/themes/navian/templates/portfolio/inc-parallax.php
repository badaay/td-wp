<?php $portfolio_link = navian_get_portfolio_link('btn btn-rounded btn-filled btn-sm-sm'); ?>
<section class="image-bg bg-dark parallax project-parallax overlay z-index pt160 pb160">
    <div class="background-content">
        <?php the_post_thumbnail( 'full', array('class' => 'background-image') ); ?>
        <div class="background-overlay darker"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="widgetsubtitle mb16 uppercase-force">
                    <?php echo navian_the_terms( 'portfolio_category', ' / ', 'name' ) ?>
                </div>
                <?php 
                the_title( '<h5 class="widgettitle">', '</h5>' );
                echo wp_kses($portfolio_link['prefix'], navian_allowed_tags());
                esc_html_e( 'See Project', 'navian' );
                echo wp_kses($portfolio_link['sufix'], navian_allowed_tags());
                ?>
            </div>
        </div>
    </div>
</section>