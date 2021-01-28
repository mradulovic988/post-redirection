<?php
/**
 * Main class for all communication between front-end
 *
 * @class Pr_Public
 * @package Pr_Public
 * @version 1.0.0
 * @author M Lab Studio <info@mlab-studio.com>
 */

if ( ! class_exists( 'Pr_Public' ) ) {
    class Pr_Public {
        public function __construct() {
            if ( ! is_admin() ) {
                $option_data = get_option( 'pr_settings_fields' ); // Get option data

                echo $this->pr_data_collection( 'end_page', 'pr_hide_end_page' ); // Sending data to front-end

                // If enabled/disabled field is turned on enqueue the script
                if ( $option_data[ 'enabled_disabled' ] == 1 ) {
                    add_action( 'wp_enqueue_scripts', array( $this, 'pr_enqueue_public_styles' ) );
                }
            }
        }

        // Collect data from option data
        public function pr_data_collection( string $id, string $attr_id = '' ): string {
            $options = get_option( 'pr_settings_fields' );

            return ( ! empty( $options[ $id ] ) ? '<span style="display:none" id="' . $attr_id . '">' . $options[ $id ] . '</span>' : '' );
        }

        public function pr_enqueue_public_styles() {
            wp_enqueue_script( 'pr_public_js', plugins_url( '/assets/js/pr_public_script.js', __FILE__ ), array(), '1.0.0', true );
        }
    }

    new Pr_Public();
}