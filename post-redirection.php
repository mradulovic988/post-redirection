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

                add_filter( 'plugin_action_links', array( $this, 'pr_settings_link' ), 10, 2 );
                add_filter( 'plugin_row_meta', array( $this, 'pr_set_plugin_meta' ), 10, 2 );
            } else {
                include PR_PLUGIN_PATH . '/public/Pr_Public.php';
            }
        }

        // Settings link for the plugin
        public function pr_settings_link( $links, $file ): array {
            $plugin = plugin_basename( __FILE__ );

            if ( $file == $plugin && current_user_can( 'manage_options' ) ) {
                array_unshift(
                    $links,
                    sprintf( '<a href="%s">' . __( 'Settings', 'post_redirection' ), 'tools.php?page=pr-dashboard' ) . '</a>'
                );
            }

            return $links;
        }

        // Settings link for the plugin
        public function pr_set_plugin_meta( $links, $file ): array {
            $plugin = plugin_basename( __FILE__ );

            if ( $file == $plugin && current_user_can( 'manage_options' ) ) {
                array_push(
                    $links,
                    sprintf( '<a target="_blank" href="%s">' . __( 'Docs & FAQs', 'post_redirection' ) . '</a>', 'https://wordpress.org/support/plugin/post-redirection' )
                );

                array_push(
                    $links,
                    sprintf( '<a target="_blank" href="%s">' . __( 'GitHub', 'post_redirection' ) . '</a>', 'https://github.com/mradulovic988/post-redirection' )
                );
            }

            return $links;
        }
    }

    new Post_Redirection();
}