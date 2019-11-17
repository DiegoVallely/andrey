<?php
/**
 * Plugin Name: HT Mega - Absolute Addons for Elementor Page Builder
 * Description: The HTMega is a elementor addons package for Elementor page builder plugin for WordPress.
 * Plugin URI: 	http://demo.wphash.com/htmega/
 * Author: 		HasThemes
 * Author URI: 	https://hasthemes.com/
 * Version: 	1.2.2
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: htmega-addons
 * Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly
define( 'HTMEGA_VERSION', '1.2.2' );
define( 'HTMEGA_ADDONS_PL_URL', plugins_url( '/', __FILE__ ) );
define( 'HTMEGA_ADDONS_PL_PATH', plugin_dir_path( __FILE__ ) );

// Required File
require_once ( HTMEGA_ADDONS_PL_PATH.'includes/class.htmega.php' );

// Add settings link on plugin page.
function htmega_pl_setting_links( $links ) {
    $htmega_settings_link = '<a href="admin.php?page=htmega_addons_options">'.esc_html__( 'Settings', 'htmega-addons' ).'</a>';
    array_unshift( $links, $htmega_settings_link );
    if( !is_plugin_active('htmega-pro/htmega_pro.php') ){
        $links['htmegago_pro'] = sprintf('<a href="https://hasthemes.com/plugins/ht-mega-pro/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro','htmega-addons') . '</a>');
    }
    return $links; 
} 
$htmega_plugin_name = plugin_basename(__FILE__);
add_filter("plugin_action_links_$htmega_plugin_name", 'htmega_pl_setting_links' );

// Plugins After Install
if ( did_action( 'elementor/loaded' ) ) {
    register_activation_hook( __FILE__, 'htmega_plugin_activate' );
    add_action('admin_init', 'htmega_plugin_redirect_option_page');
    function htmega_plugin_activate() {
        add_option('htmega_do_activation_redirect', true);
    }
    function htmega_plugin_redirect_option_page() {
        if ( get_option('htmega_do_activation_redirect', false) ) {
            delete_option('htmega_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ){
                wp_redirect( admin_url("admin.php?page=htmega_addons_options") );
            }
        }
    }
}