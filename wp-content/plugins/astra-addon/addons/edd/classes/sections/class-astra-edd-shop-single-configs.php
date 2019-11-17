<?php
/**
 * Shop Options for our theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2019, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 1.6.10
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

if ( ! class_exists( 'Astra_Edd_Shop_Single_Configs' ) ) {

	/**
	 * Register Easy Digital Downloads shop single Layout Configurations.
	 */
	class Astra_Edd_Shop_Single_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads shop single Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Enable Ajax add to cart.
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[disable-edd-single-product-add-to-cart]',
					'default'  => astra_get_option( 'disable-edd-single-product-add-to-cart' ),
					'type'     => 'control',
					'section'  => 'section-edd-single',
					'title'    => __( 'Disable Add To Cart Button', 'astra-addon' ),
					'priority' => 18,
					'control'  => 'checkbox',
				),

			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_Shop_Single_Configs;





