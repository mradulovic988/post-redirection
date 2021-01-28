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
                echo $this->pr_data_collection( 'end_page', 'pr_hide_end_page' );
            }
        }

        public function pr_data_collection( string $id, string $attr_id ): string {
            $options = get_option( 'pr_settings_fields' );

            return ( ! empty( $options[ $id ] ) ? '<span style="display:none" id="' . $attr_id . '">' . $options[ $id ] . '</span>' : '' );
        }
    }

    new Pr_Public();
}