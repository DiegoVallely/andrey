<?php
/**
 * Plugin Name: Schema Pro
 * Plugin URI: https://wpschema.com
 * Author: Brainstorm Force
 * Author URI: https://www.brainstormforce.com
 * Description: Integrate Schema.org JSON-LD code in your website and improve SEO.
 * Version: 1.3.0
 * Text Domain: wp-schema-pro
 * License: GPL2
 *
 * @package Schema Pro
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

// Refresh bundled products on activate.
register_activation_hook( __FILE__, 'on_bsf_aiosrs_pro_activate' );
register_deactivation_hook( __FILE__, 'on_bsf_aiosrs_pro_deactivate' );

/**
 * Bsf aiosrs pro activate
 *
 * @since 1.1.0
 * @return void
 */
function on_bsf_aiosrs_pro_activate() {
	update_site_option( 'bsf_force_check_extensions', true );
	set_transient( 'wp-schema-pro-activated', true );
}

/**
 * Bsf aiosrs pro deactivate
 *
 * @since 1.3.0
 * @return void
 */
function on_bsf_aiosrs_pro_deactivate() {
	delete_option( 'sp_hide_label' );

	if ( is_network_admin() ) {
		$branding = get_site_option( 'wp-schema-pro-branding-settings' );
	} else {
		$branding = get_option( 'wp-schema-pro-branding-settings' );
	}

	if ( isset( $branding['sp_hide_label'] ) && false != $branding['sp_hide_label'] ) {

		$branding['sp_hide_label'] = 'disabled';

		if ( is_network_admin() ) {

			update_site_option( 'wp-schema-pro-branding-settings', $branding );

		} else {
			update_option( 'wp-schema-pro-branding-settings', $branding );
		}
	}
}
/**
 * Set constants.
 */
define( 'BSF_AIOSRS_PRO_FILE', __FILE__ );
define( 'BSF_AIOSRS_PRO_BASE', plugin_basename( BSF_AIOSRS_PRO_FILE ) );
define( 'BSF_AIOSRS_PRO_DIR', plugin_dir_path( BSF_AIOSRS_PRO_FILE ) );
define( 'BSF_AIOSRS_PRO_URI', plugins_url( '/', BSF_AIOSRS_PRO_FILE ) );
define( 'BSF_AIOSRS_PRO_VER', '1.3.0' );

/**
 * Initial file.
 */
require_once BSF_AIOSRS_PRO_DIR . 'classes/class-bsf-aiosrs-pro.php';

/**
 * Brainstorm Updater.
 */
require_once BSF_AIOSRS_PRO_DIR . 'classes/class-brainstorm-update-aiosrs-pro.php';
