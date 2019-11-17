<?php
/**
 * Plugin Name: HT Mega Pro
 * Description: The HTMega is a elementor addons package for Elementor page builder plugin for WordPress.
 * Plugin URI:  http://demo.wphash.com/htmega/
 * Author:      HasThemes
 * Author URI:  https://hasthemes.com/plugins/ht-mega-pro/
 * Version:     1.0.2
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: htmega-pro
 * Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'HTMEGA_VERSION_PRO', '1.0.2' );
define( 'HTMEGA_ADDONS_PL_URL_PRO', plugins_url( '/', __FILE__ ) );
define( 'HTMEGA_ADDONS_PL_PATH_PRO', plugin_dir_path( __FILE__ ) );
define( 'HTMEGA_ADDONS_PL_ROOT_PRO', __FILE__ );

// Plugins Name
define( 'HTMEGA_ITEM_NAME_PRO', 'HTMega Pro' );

// Required File
require_once ( HTMEGA_ADDONS_PL_PATH_PRO.'includes/class.htmega-pro.php' );