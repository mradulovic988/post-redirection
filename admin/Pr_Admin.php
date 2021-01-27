<?php
/**
* Main class for all communication between back-end
*
* @class Pr_Admin
* @package Pr_Admin
* @version 1.0.0
* @author M Lab Studio <info@mlab-studio.com>
*/

if ( ! class_exists( 'Pr_Admin' ) ) {
    class Pr_Admin {
        public function __construct() {
            if ( is_admin() ) {
                add_action( 'admin_enqueue_scripts', array( $this, 'pr_enqueue_admin_styles' ) );
            }
        }

        public function pr_enqueue_admin_styles() {
            wp_enqueue_style( 'pr_admin_css', plugins_url( '/assets/css/pr_admin_style.css', __FILE__ ) );
            wp_enqueue_script( 'pr_admin_js', plugins_url( '/assets/js/pr_admin_script.js', __FILE__ ), array(), '1.0.0', true );
        }
    }

    new Pr_Admin();
}