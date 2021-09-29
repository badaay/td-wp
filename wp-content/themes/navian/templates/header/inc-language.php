<?php 
$languages = icl_get_languages( 'skip_missing=0&orderby=code' );
if( !empty( $languages ) ) { ?>
    <div class="module widget-wrap language left">
        <ul class="menu menu-language">
            <li class="has-dropdown">
                <?php 
                $current_code = null;
                $current_flag = null;
                foreach( $languages as $language ) {
                    if (!empty( $language['active'])) {
                        $current_code = $language['language_code'];
                        $current_flag = $language['country_flag_url'];
                        break;
                    }
                }
                if (!empty($current_flag) && !empty($current_code)) { ?>
                    <a href="#"><?php echo '<img src="'.esc_url($current_flag).'" height="12" alt="'.esc_attr($current_code).'" width="18" />'.esc_attr($current_code);?></a>
                    <ul>
                        <?php 
                        foreach( $languages as $language ) {
                            echo '<li><a href="'.esc_url($language['url']).'">';
                            if( $language['country_flag_url'] ) {
                                echo '<img src="'.esc_url($language['country_flag_url']).'" height="12" alt="'.esc_attr($language['language_code']).'" width="18" />';
                            }
                            echo esc_attr($language['native_name']);
                            echo '</a></li>';
                        } 
                        ?>
                    </ul>
                <?php } ?>
            </li>
        </ul>
    </div>
    <?php 
}