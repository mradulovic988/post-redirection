<?php
/**
 * Main class for all communication between front-end and with the back-end
 *
 * @class Pr_Dashboard
 * @package Pr_Dashboard
 * @version 1.0.0
 * @author M Lab Studio <info@mlab-studio.com>
 */

if ( ! class_exists( 'Pr_Dashboard' ) ) {

    /**
     * Class Pr_Dashboard
     *
     * Main communication between front-end and back-end
     *
     * @copyright  2021 M Lab Studio
     * @license    http://www.zend.com/license/3_0.txt   PHP License 3.0
     * @version    Release: 1.0.0
     * @link       https://mlab-studio.com/
     * @since      Class available since Release 1.0.0
     */
    class Pr_Dashboard {
        public function __construct() {
            if ( is_admin() ) {
                add_action( 'admin_menu', array( $this, 'pr_dashboard' ) );
                add_action( 'admin_notices', array( $this, 'pr_show_error_notice' ) );
                add_action( 'admin_init', array( $this, 'pr_register_settings' ) );
            }
        }

        // Notice
        public function pr_show_error_notice() {
            if ( isset( $_GET['settings-updated'] ) ) {
                $message = __( 'You have successfully saved your settings.', 'post_redirection' );
                add_settings_error( 'pr_settings_fields', 'sucess', $message, 'success' );
            }
        }

        // Adding submenu page
        public function pr_dashboard() {
            add_submenu_page( 'tools.php', __( 'Post Redirection', 'post_redirection' ), __( 'Post Redirection', 'post_redirection' ), 'manage_options', 'pr-dashboard', array(
                $this,
                'pr_dashboard_page'
            ) );
        }

        // Main form on admin part
        public function pr_dashboard_page() {
            ?>
            <div class="wrap">
                <form action="options.php" method="post">

                    <?php
                    settings_errors( 'pr_settings_fields' );
                    wp_nonce_field( 'pr_dashboard_save', 'pr_form_save_name' ); // CHECK THIS AT THE END
                    settings_fields( 'pr_settings_fields' );
                    do_settings_sections( 'pr_settings_section_tab' );

                    submit_button(
                        __( 'Save Changes', 'post_redirection' ),
                        '',
                        'pr_save_changes_btn',
                        true,
                        array( 'id' => 'pr-save-changes-btn' )
                    );
                    ?>

                </form>

                <?php
                if ( ! isset( $_POST['pr_form_save_name'] ) ||
                    ! wp_verify_nonce( $_POST['pr_form_save_name'], 'pr_dashboard_save' ) ) {
                    return;
                }
                ?>
            </div>
            <?php
        }

        // Description of admin page
        public function pr_settings_section_callback() {
            _e( 'Set your General settings.', 'post_redirection' );
        }

        /**
         * Checking type of the fields
         *
         * @param string $type
         * @param string $id
         * @param string $class
         * @param string $name
         * @param string $value
         * @param string $placeholder
         * @param string $description
         * @param string $required
         */
        protected function pr_settings_fields( string $type, string $id, string $class, string $name, string $value, $placeholder = '', $description = '', $required = '' ) {
            switch ( $type ) {
                case 'checkbox':
                    echo '<label class="pr-switch" for="' . $id . '"><input type="checkbox" id="' . $id . '" class="' . $class . '" name="pr_settings_fields[' . $name . ']" value="1" ' . $value . '><span class="pr-slider pr-round"></span></label><small class="pr-field-desc">' . $description . '</small>';
                    break;
                case 'url':
                    echo '<input type="url" id="' . $id . '" class="' . $class . '" name="pr_settings_fields[' . $name . ']" value="' . $value . '"placeholder="' . __( $placeholder, 'post_redirection' ) . '" ' . $required . '><small class="pr-field-desc">' . __( $description, 'post_redirection' ) . '</small>';
                    break;
            }
        }

        /**
         * Checking option data for every button except the radio button
         *
         * @param string $id
         * @return string
         */
        public function pr_options_check( string $id ): string {
            $options = get_option( 'pr_settings_fields' );

            return ( ! empty( $options[ $id ] ) ? $options[ $id ] : '' );
        }

        /**
         * Checking option data for every radio button
         *
         * @param string $id
         * @return string
         */
        public function pr_option_check_radio_btn( string $id ): string {
            $options = get_option( 'pr_settings_fields' );

            return isset( $options[ $id ] ) ? checked( 1, $options[ $id ], false ) : '';
        }

        // Settings API
        public function pr_register_settings() {

            register_setting('pr_settings_fields', 'pr_settings_fields', 'pr_sanitize_callback');

            // Adding sections
            add_settings_section('pr_section_id', __('General', 'post_redirection'), array(
                $this,
                'pr_settings_section_callback'
            ), 'pr_settings_section_tab');

            // Enabled / Disabled button
            add_settings_field( 'pr_section_id_enabled_disabled', __( 'Enable / Disable', 'post_redirection' ), array(
                $this,
                'pr_section_id_enabled_disabled'
            ), 'pr_settings_section_tab', 'pr_section_id' );

            // End page field
            add_settings_field( 'pr_section_id_end_page', __( 'End page redirection', 'post_redirection' ), array(
                $this,
                'pr_section_id_eng_page'
            ), 'pr_settings_section_tab', 'pr_section_id' );
        }


        public function pr_section_id_enabled_disabled() {
            $this->pr_settings_fields( 'checkbox', 'pr-enabled-disabled', 'pr-switch-input', 'enabled_disabled', $this->pr_option_check_radio_btn( 'enabled_disabled' ) );
        }

        public function pr_section_id_eng_page() {
            $this->pr_settings_fields( 'url', 'pr-end-page', 'pr-end-page', 'end_page', $this->pr_options_check( 'end_page' ), 'https://domain.com/end-page' );
        }
    }

    new Pr_Dashboard();
}