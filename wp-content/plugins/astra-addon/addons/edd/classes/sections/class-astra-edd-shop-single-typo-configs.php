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

if ( ! class_exists( 'Astra_Edd_Shop_Single_Typo_Configs' ) ) {

	/**
	 * Register Blog Single Layout Configurations.
	 */
	class Astra_Edd_Shop_Single_Typo_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Blog Single Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Single Product Title Divider
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[typo-edd-product-title-divider]',
					'section'   => 'section-edd-single-product-typo',
					'title'     => __( 'Product Title', 'astra-addon' ),
					'type'      => 'control',
					'required'  => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'control'   => 'ast-divider',
					'priority'  => 5,
					'settings'  => array(),
					'separator' => false,
				),

				/**
				 * Option: Single Product Title Font Family
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[font-family-edd-product-title]',
					'default'   => astra_get_option( 'font-family-edd-product-title' ),
					'type'      => 'control',
					'control'   => 'ast-font',
					'font-type' => 'ast-font-family',
					'title'     => __( 'Font Family', 'astra-addon' ),
					'section'   => 'section-edd-single-product-typo',
					'required'  => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-edd-product-title]',
					'priority'  => 5,
				),

				/**
				 * Option: Single Product Title Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[font-weight-edd-product-title]',
					'default'           => astra_get_option( 'font-weight-edd-product-title' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'title'             => __( 'Font Weight', 'astra-addon' ),
					'section'           => 'section-edd-single-product-typo',
					'required'          => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'connect'           => ASTRA_THEME_SETTINGS . '[font-family-edd-product-title]',
					'priority'          => 5,
				),

				/**
					 * Option: Single Product Title Text Transform
					 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[text-transform-edd-product-title]',
					'default'   => astra_get_option( 'text-transform-edd-product-title' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'section'   => 'section-edd-single-product-typo',
					'title'     => __( 'Text Transform', 'astra-addon' ),
					'required'  => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'control'   => 'select',
					'priority'  => 5,
					'choices'   => array(
						''           => __( 'Inherit', 'astra-addon' ),
						'none'       => __( 'None', 'astra-addon' ),
						'capitalize' => __( 'Capitalize', 'astra-addon' ),
						'uppercase'  => __( 'Uppercase', 'astra-addon' ),
						'lowercase'  => __( 'Lowercase', 'astra-addon' ),
					),
				),

				/**
				 * Option: Single Product Title Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-edd-product-title]',
					'default'     => astra_get_option( 'font-size-edd-product-title' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-responsive',
					'section'     => 'section-edd-single-product-typo',
					'priority'    => 5,
					'title'       => __( 'Font Size', 'astra-addon' ),
					'required'    => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),

				/**
				 * Option: Single Product Title Line Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[line-height-edd-product-title]',
					'default'     => '',
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'section-edd-single-product-typo',
					'title'       => __( 'Line Height', 'astra-addon' ),
					'control'     => 'ast-slider',
					'required'    => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'priority'    => 5,
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
				),

				/**
				 * Option: Single Product Content Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[typo-edd-product-content-divider]',
					'section'  => 'section-edd-single-product-typo',
					'title'    => __( 'Product Content', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 20,
					'settings' => array(),
				),

				/**
				 * Option: Single Product Content Font Family
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[font-family-edd-product-content]',
					'default'   => astra_get_option( 'font-family-edd-product-content' ),
					'type'      => 'control',
					'control'   => 'ast-font',
					'font-type' => 'ast-font-family',
					'title'     => __( 'Font Family', 'astra-addon' ),
					'section'   => 'section-edd-single-product-typo',
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-edd-product-content]',
					'priority'  => 20,
				),

				/**
				 * Option: Single Product Content Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[font-weight-edd-product-content]',
					'default'           => astra_get_option( 'font-weight-edd-product-content' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'title'             => __( 'Font Weight', 'astra-addon' ),
					'section'           => 'section-edd-single-product-typo',
					'connect'           => ASTRA_THEME_SETTINGS . '[font-family-edd-product-content]',
					'priority'          => 20,
				),

				/**
					 * Option: Single Product Content Text Transform
					 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[text-transform-edd-product-content]',
					'default'   => astra_get_option( 'text-transform-edd-product-content' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'section'   => 'section-edd-single-product-typo',
					'title'     => __( 'Text Transform', 'astra-addon' ),
					'control'   => 'select',
					'priority'  => 20,
					'choices'   => array(
						''           => __( 'Inherit', 'astra-addon' ),
						'none'       => __( 'None', 'astra-addon' ),
						'capitalize' => __( 'Capitalize', 'astra-addon' ),
						'uppercase'  => __( 'Uppercase', 'astra-addon' ),
						'lowercase'  => __( 'Lowercase', 'astra-addon' ),
					),
				),

				/**
				 * Option: Single Product Content Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-edd-product-content]',
					'default'     => astra_get_option( 'font-size-edd-product-content' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-responsive',
					'section'     => 'section-edd-single-product-typo',
					'priority'    => 20,
					'title'       => __( 'Font Size', 'astra-addon' ),
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),

				/**
				 * Option: Single Product Content Line Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[line-height-edd-product-content]',
					'default'     => '',
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'section-edd-single-product-typo',
					'title'       => __( 'Line Height', 'astra-addon' ),
					'control'     => 'ast-slider',
					'priority'    => 20,
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
				),

			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_Shop_Single_Typo_Configs;





