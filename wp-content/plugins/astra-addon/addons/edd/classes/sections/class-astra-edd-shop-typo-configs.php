<?php
/**
 * Shop Options for our theme.
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

if ( ! class_exists( 'Astra_Edd_Shop_Typo_Configs' ) ) {

	/**
	 * Register Easy Digital Downloads Shop Typo Layout Configurations.
	 */
	class Astra_Edd_Shop_Typo_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads Shop Typo Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Product Title Divider
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[typo-edd-archive-product-title-divider]',
					'section'   => 'section-edd-archive-typo',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
					'title'     => __( 'Product Title', 'astra-addon' ),
					'type'      => 'control',
					'control'   => 'ast-divider',
					'priority'  => 5,
					'settings'  => array(),
					'separator' => false,
				),

				/**
				 * Option: Product Title Font Family
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[font-family-edd-archive-product-title]',
					'default'   => astra_get_option( 'font-family-edd-archive-product-title' ),
					'type'      => 'control',
					'control'   => 'ast-font',
					'font-type' => 'ast-font-family',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
					'title'     => __( 'Font Family', 'astra-addon' ),
					'section'   => 'section-edd-archive-typo',
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-edd-archive-product-title]',
					'priority'  => 5,
				),

				/**
				 * Option: Product Title Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[font-weight-edd-archive-product-title]',
					'default'           => astra_get_option( 'font-weight-edd-archive-product-title' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'required'          => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
					'title'             => __( 'Font Weight', 'astra-addon' ),
					'section'           => 'section-edd-archive-typo',
					'connect'           => ASTRA_THEME_SETTINGS . '[font-family-edd-archive-product-title]',
					'priority'          => 5,
				),

				/**
					 * Option: Product Title Text Transform
					 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[text-transform-edd-archive-product-title]',
					'default'   => astra_get_option( 'text-transform-edd-archive-product-title' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'section'   => 'section-edd-archive-typo',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
					'title'     => __( 'Text Transform', 'astra-addon' ),
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
				 * Option: Product Title Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-edd-archive-product-title]',
					'default'     => astra_get_option( 'font-size-edd-archive-product-title' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-responsive',
					'section'     => 'section-edd-archive-typo',
					'priority'    => 5,
					'required'    => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
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
				 * Option: Product Title Line Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[line-height-edd-archive-product-title]',
					'default'     => '',
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'section-edd-archive-typo',
					'required'    => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
					'title'       => __( 'Line Height', 'astra-addon' ),
					'control'     => 'ast-slider',
					'priority'    => 5,
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
				),

				/**
				 * Option: Product Price Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[typo-edd-archive-price-divider]',
					'section'  => 'section-edd-archive-typo',
					'required' => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'price' ),
					'title'    => __( 'Product Price', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 10,
					'settings' => array(),
				),

				/**
				 * Option: Product Price Font Family
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[font-family-edd-archive-product-price]',
					'default'   => astra_get_option( 'font-family-edd-archive-product-price' ),
					'type'      => 'control',
					'control'   => 'ast-font',
					'font-type' => 'ast-font-family',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'price' ),
					'title'     => __( 'Font Family', 'astra-addon' ),
					'section'   => 'section-edd-archive-typo',
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-edd-archive-product-price]',
					'priority'  => 10,
				),

				/**
				 * Option: Product Price Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[font-weight-edd-archive-product-price]',
					'default'           => astra_get_option( 'font-weight-edd-archive-product-price' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'required'          => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'price' ),
					'title'             => __( 'Font Weight', 'astra-addon' ),
					'section'           => 'section-edd-archive-typo',
					'connect'           => ASTRA_THEME_SETTINGS . '[font-family-edd-archive-product-price]',
					'priority'          => 10,
				),

				/**
				 * Option: Product Price Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-edd-archive-product-price]',
					'default'     => astra_get_option( 'font-size-edd-archive-product-price' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-responsive',
					'section'     => 'section-edd-archive-typo',
					'priority'    => 10,
					'required'    => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'price' ),
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
				 * Option: Product Price Line Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[line-height-edd-archive-product-price]',
					'default'     => '',
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'section-edd-archive-typo',
					'required'    => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'price' ),
					'title'       => __( 'Line Height', 'astra-addon' ),
					'control'     => 'ast-slider',
					'priority'    => 10,
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
				),

				/**
				 * Option: Product Content Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[typo-edd-product-archive-content-divider]',
					'section'  => 'section-edd-archive-typo',
					'title'    => __( 'Product Content', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 15,
					'settings' => array(),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Product Content Font Family
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[font-family-edd-archive-product-content]',
					'default'   => astra_get_option( 'font-family-edd-archive-product-content' ),
					'type'      => 'control',
					'control'   => 'ast-font',
					'font-type' => 'ast-font-family',
					'title'     => __( 'Font Family', 'astra-addon' ),
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
					'section'   => 'section-edd-archive-typo',
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-edd-archive-product-content]',
					'priority'  => 15,
				),

				/**
				 * Option: Product Content Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[font-weight-edd-archive-product-content]',
					'default'           => astra_get_option( 'font-weight-edd-archive-product-content' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'title'             => __( 'Font Weight', 'astra-addon' ),
					'required'          => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
					'section'           => 'section-edd-archive-typo',
					'connect'           => ASTRA_THEME_SETTINGS . '[font-family-edd-archive-product-content]',
					'priority'          => 15,
				),

				/**
				 * Option: Product Title Text Transform
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[text-transform-edd-archive-product-content]',
					'default'   => astra_get_option( 'text-transform-edd-archive-product-content' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'section'   => 'section-edd-archive-typo',
					'title'     => __( 'Text Transform', 'astra-addon' ),
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
					'control'   => 'select',
					'priority'  => 15,
					'choices'   => array(
						''           => __( 'Inherit', 'astra-addon' ),
						'none'       => __( 'None', 'astra-addon' ),
						'capitalize' => __( 'Capitalize', 'astra-addon' ),
						'uppercase'  => __( 'Uppercase', 'astra-addon' ),
						'lowercase'  => __( 'Lowercase', 'astra-addon' ),
					),
				),

				/**
				 * Option: Product Content Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-edd-archive-product-content]',
					'default'     => astra_get_option( 'font-size-edd-archive-product-content' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-responsive',
					'section'     => 'section-edd-archive-typo',
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
					'priority'    => 15,
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
				 * Option: Product Content Line Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[line-height-edd-archive-product-content]',
					'default'     => '',
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'section-edd-archive-typo',
					'title'       => __( 'Line Height', 'astra-addon' ),
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
					'control'     => 'ast-slider',
					'priority'    => 15,
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


new Astra_Edd_Shop_Typo_Configs;





