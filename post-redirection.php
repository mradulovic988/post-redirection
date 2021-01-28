<?php
/**
 * Post Redirection
 *
 * @package           Post_Redirection
 * @author            M Lab Studio <info@mlab-studio.com>
 * @copyright         2021 M Lab Studio
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Post Redirection
 * Plugin URI:        https://wordpress.org/plugins/post-redirection
 * Description:       Post Redirection is a powerful and simple solution for single posts redirection
 * Version:           1.0.0
 * Requires at least: 4.6
 * Requires PHP:      7.1
 * Author:            M Lab Studio
 * Author URI:        https://mlab-studio.com/
 * Text Domain:       post_redirection
 * Domain Path:       /languages
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined('ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Post_Redirection' ) ) {
    
    class Post_Redirection {

        public function __construct() {
            if ( ! defined( 'PR_PLUGIN_PATH' ) ) {
                define( 'PR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
            }

            if ( ! defined( 'PR_PLUGIN_BASENAME' ) ) {
                define( 'PR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
            }

            if ( is_admin() ) {
                include PR_PLUGIN_PATH . '/includes/Pr_Dashboard.php';
                include PR_PLUGIN_PATH . '/admin/Pr_Admin.php';

                $this->pr_load_plugin_textdomain();
            } else {
                include PR_PLUGIN_PATH . '/public/Pr_Public.php';
            }
        }

        // Translation and Localization
        public function pr_load_plugin_textdomain() {
            load_plugin_textdomain(
                'agy',
                false,
                PR_PLUGIN_BASENAME . dirname( __FILE__ ) . '/languages'
            );
        }
    }

    new Post_Redirection();
}