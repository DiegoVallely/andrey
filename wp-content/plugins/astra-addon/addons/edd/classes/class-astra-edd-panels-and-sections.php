<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
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

if ( ! class_exists( 'Astra_Edd_Panels_And_Sections' ) ) {

	/**
	 * Register Easy Digital Downloads Panels and sections Layout Configurations.
	 */
	class Astra_Edd_Panels_And_Sections extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads Panels and sections Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Section General
				 */
				array(
					'name'     => 'section-edd-general',
					'title'    => __( 'General', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-layout',
					'section'  => 'section-edd-group',
					'priority' => 5,
				),

				/**
				 * Section Checkout Page
				 */
				array(
					'name'     => 'section-edd-checkout-page',
					'priority' => 25,
					'title'    => __( 'Checkout Page', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-layout',
					'section'  => 'section-edd-group',
				),

				/**
				 * Easy Digital Downloads
				 *
				 * Customizer > Typography
				 */
				array(
					'name'     => 'section-edd-typo',
					'priority' => 60,
					'title'    => __( 'Easy Digital Downloads', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-typography',
				),

				/**
				 * General
				 *
				 * Customizer > Typography > Easy Digital Downloads
				 */
				array(
					'name'     => 'section-edd-general-typo',
					'priority' => 5,
					'title'    => __( 'General', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-typography',
					'section'  => 'section-edd-typo',
				),

				/**
				 * Product Archive
				 *
				 * Customizer > Typography > Easy Digital Downloads
				 */
				array(
					'name'     => 'section-edd-archive-typo',
					'priority' => 10,
					'title'    => __( 'Product Archive', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-typography',
					'section'  => 'section-edd-typo',
				),

				/**
				 * Single Product
				 *
				 * Customizer > Typography > Easy Digital Downloads
				 */
				array(
					'name'     => 'section-edd-single-product-typo',
					'priority' => 15,
					'title'    => __( 'Single Product', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-typography',
					'section'  => 'section-edd-typo',
				),

				/**
				 * Easy Digital Downloads
				 *
				 * Customizer > Colors & Background
				 */
				array(
					'name'     => 'section-edd-colors-bg',
					'priority' => 60,
					'title'    => __( 'Easy Digital Downloads', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-colors-background',
				),

				/**
				 * General
				 *
				 * Customizer > Colors & Background > Easy Digital Downloads
				 */
				array(
					'name'     => 'section-edd-general-color',
					'priority' => 5,
					'title'    => __( 'General', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-colors-background',
					'section'  => 'section-edd-colors-bg',
				),

				/**
				 * Product Archive
				 *
				 * Customizer > Colors & Background > Easy Digital Downloads
				 */
				array(
					'name'     => 'section-edd-archive-color',
					'priority' => 10,
					'title'    => __( 'Product Archive', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-colors-background',
					'section'  => 'section-edd-colors-bg',
				),

				/**
				 * Single Product
				 *
				 * Customizer > Colors & Background > Easy Digital Downloads
				 */
				array(
					'name'     => 'section-edd-single-product-color',
					'priority' => 15,
					'title'    => __( 'Single Product', 'astra-addon' ),
					'type'     => 'section',
					'panel'    => 'panel-colors-background',
					'section'  => 'section-edd-colors-bg',
				),

			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_Panels_And_Sections;





