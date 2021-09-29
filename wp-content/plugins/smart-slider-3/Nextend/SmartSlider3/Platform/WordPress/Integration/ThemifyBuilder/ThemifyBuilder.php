<?php

namespace Nextend\SmartSlider3\Platform\WordPress\Integration\ThemifyBuilder;

use Nextend\SmartSlider3\Platform\WordPress\Shortcode\Shortcode;
use Themify_Builder_Model;

class ThemifyBuilder {

    public function __construct() {

        add_action('themify_builder_setup_modules', array(
            $this,
            'init'
        ));
    }

    //WORKING
    public function init() {
        if (class_exists('Themify_Builder_Model', false)) {
            /**
             * Themify Builder loads the editor with AJAX. The slider will be in an iframe, but our Widget controls are outside of the iframe.
             * Our scripts and styles won't be called in on the editor page, so we need to call them in manually.
             */
            if (current_user_can('manage_options') && current_user_can('smartslider_edit')) {
                add_action('wp_ajax_module_widget_get_form', function () {
                    if (isset($_POST['tb_load_nonce'])) {
                        //Remove "Select slider" button as it can not trigger the slider selecting in the iframed editor of Themify Builder.
                        add_filter('smartslider3_display_widget_button', function () {
                            return false;
                        });
                    }
                }, 9);
            }
        }

        /**
         * Fix for slider shortcode appearance in Themmify Builder frontend editor
         */
        add_action('wp_ajax_tb_render_element_shortcode', array(
            $this,
            'forceShortcodeIframe'
        ));
        /**
         * Fix for newly added slider widget appearance in Themmify Builder frontend editor
         */
        add_action('wp_ajax_tb_load_module_partial', array(
            $this,
            'forceShortcodeIframe'
        ));
        /**
         * Fix for already added slider widget appearance in Themmify Builder frontend editor
         */
        add_action('wp_ajax_tb_render_element', array(
            $this,
            'forceShortcodeIframe'
        ));


    }

    public function forceShortcodeIframe() {
        Shortcode::forceIframe('Themify Builder', true);
    }
}