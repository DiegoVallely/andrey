<?php
/**
 * UAEL WooCommerce Skin Grid - Default.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Woocommerce\Skins;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

use UltimateElementor\Modules\Woocommerce\TemplateBlocks\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Skin_Grid_Default
 *
 * @property Products $parent
 */
class Skin_Grid_Default extends Skin_Grid_Base {

	/**
	 * Get ID.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function get_id() {
		return 'grid-default';
	}

	/**
	 * Get title.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function get_title() {
		return __( 'Classic', 'uael' );
	}

	/**
	 * Register control actions.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		/* Content Controls */
		add_action( 'elementor/element/uael-woo-products/section_filter_field/after_section_end', [ $this, 'register_content_content_controls' ] );
		add_action( 'elementor/element/uael-woo-products/section_design_image/after_section_end', [ $this, 'register_style_content_controls' ] );

		/* Flash Notification Controls */
		add_action( 'elementor/element/uael-woo-products/section_filter_field/after_section_end', [ $this, 'register_content_sale_controls' ] );
		add_action( 'elementor/element/uael-woo-products/section_design_image/after_section_end', [ $this, 'register_style_sale_controls' ] );

		add_action( 'elementor/element/uael-woo-products/section_filter_field/after_section_end', [ $this, 'register_content_featured_controls' ] );
		add_action( 'elementor/element/uael-woo-products/section_design_image/after_section_end', [ $this, 'register_style_featured_controls' ] );
	}

	/**
	 * Register content control section.
	 *
	 * @since 0.0.1
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_content_content_controls( Widget_Base $widget ) {

		$this->parent = $widget;

		$this->start_controls_section(
			'section_content_field',
			[
				'label' => __( 'Content', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'show_category',
				[
					'label'        => __( 'Category', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'show_title',
				[
					'label'        => __( 'Title', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'show_ratings',
				[
					'label'        => __( 'Ratings', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'show_price',
				[
					'label'        => __( 'Price', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'show_short_desc',
				[
					'label'        => __( 'Short Description', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'show_add_cart',
				[
					'label'        => __( 'Add to Cart', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Content Controls.
	 *
	 * @since 0.0.1
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_style_content_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'        => __( 'Alignment', 'uael' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => true,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'uael' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'uael' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'uael' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'      => 'left',
				'prefix_class' => 'uael-woo%s--align-',
			]
		);

		$this->add_responsive_control(
			'product_content_padding',
			[
				'label'      => __( 'Spacing Around Content', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-woo-products-summary-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_content_bg_color',
			[
				'label'     => __( 'Content Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .uael-woo-product-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_category_style',
			[
				'label'     => __( 'Category', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_category' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_category_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-woo-product-category' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_category' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'product_category_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-woo-product-category',
				'condition' => [
					$this->get_control_id( 'show_category' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_category_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-woo-product-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_category' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_title_style',
			[
				'label'     => __( 'Title', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-loop-product__link, {{WRAPPER}} .uael-woocommerce .woocommerce-loop-product__title' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_title_hover_color',
			[
				'label'     => __( 'Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-loop-product__link:hover .woocommerce-loop-product__title' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'product_title_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-loop-product__link, {{WRAPPER}} .uael-woocommerce .woocommerce-loop-product__title',
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_title_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_rating_style',
			[
				'label'     => __( 'Rating', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_ratings' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_rating_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .star-rating, {{WRAPPER}} .uael-woocommerce .star-rating::before' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_ratings' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_rating_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_ratings' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_price_style',
			[
				'label'     => __( 'Price', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_price' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce li.product .price' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_price' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'product_price_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .uael-woocommerce li.product .price',
				'condition' => [
					$this->get_control_id( 'show_price' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_price_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce li.product .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_price' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_short_desc_style',
			[
				'label'     => __( 'Short Description', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_short_desc' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_short_desc_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-woo-products-description' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_short_desc' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'product_short_desc_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-woo-products-description',
				'condition' => [
					$this->get_control_id( 'show_short_desc' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_short_desc_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-woo-products-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_short_desc' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'product_add_cart_style',
			[
				'label'     => __( 'Add to Cart', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_add_cart' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_add_cart_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'product_add_cart_tabs_style' );

			$this->start_controls_tab(
				'product_add_cart_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_add_cart' ) => 'yes',
					],
				]
			);

				$this->add_control(
					'product_add_cart_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_add_cart' ) => 'yes',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'product_add_cart_background_color',
						'label'          => __( 'Background Color', 'uael' ),
						'types'          => [ 'classic', 'gradient' ],
						'selector'       => '{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button',
						'condition'      => [
							$this->get_control_id( 'show_add_cart' ) => 'yes',
						],
						'fields_options' => [
							'color' => [
								'scheme' => [
									'type'  => Scheme_Color::get_type(),
									'value' => Scheme_Color::COLOR_4,
								],
							],
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'product_add_cart_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_add_cart' ) => 'yes',
					],
				]
			);

				$this->add_control(
					'product_add_cart_hover_color',
					[
						'label'     => __( 'Text Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_add_cart' ) => 'yes',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'product_add_cart_background_hover_color',
						'label'     => __( 'Background Hover Color', 'uael' ),
						'types'     => [ 'classic', 'gradient' ],
						'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button:hover',
						'condition' => [
							$this->get_control_id( 'show_add_cart' ) => 'yes',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'product_add_cart_typography',
				'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					$this->get_control_id( 'show_add_cart' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_add_cart_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce .uael-woo-products-summary-wrap .button' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_add_cart' ) => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register pagination control section.
	 *
	 * @since 0.0.1
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_content_sale_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_content_sale',
			[
				'label' => __( 'Sale Flash', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'show_sale',
				[
					'label'        => __( 'Flash', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'sale_flash_content',
				[
					'label'     => __( 'Flash Content', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''       => __( 'Default', 'uael' ),
						'custom' => __( 'Custom', 'uael' ),
					],
					'default'   => '',
					'condition' => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'sale_flash_custom_string',
				[
					'label'       => __( 'Flash String', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '[value]%',
					'description' => __( 'Show Sale % Value ( [value] Autocalculated offer value will replace this ).', 'uael' ),
					'condition'   => [
						$this->get_control_id( 'show_sale' ) => 'yes',
						$this->get_control_id( 'sale_flash_content' ) => 'custom',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Sale style Controls.
	 *
	 * @since 0.0.1
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_style_sale_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_sale',
			[
				'label'     => __( 'Sale Flash', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'show_sale' ) => 'yes',
				],
			]
		);
			$this->add_control(
				'sale_flash_style',
				[
					'label'        => __( 'Flash Style', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => __( 'Circle', 'uael' ),
						'square' => __( 'Square', 'uael' ),
						'custom' => __( 'Custom', 'uael' ),
					],
					'default'      => 'circle',
					'condition'    => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
					'prefix_class' => 'uael-sale-flash-',
				]
			);
			$this->add_responsive_control(
				'sale_flash_size',
				[
					'label'      => __( 'Size', 'uael' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range'      => [
						'px' => [
							'min' => 20,
							'max' => 200,
						],
						'em' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'default'    => [
						'size' => 3,
						'unit' => 'em',
					],
					'condition'  => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-sale-flash-wrap .uael-onsale' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

					],
				]
			);
			$this->add_responsive_control(
				'sale_flash_radius',
				[
					'label'      => __( 'Rounded Corners', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '',
						'bottom' => '',
						'left'   => '',
						'right'  => '',
						'unit'   => 'px',
					],
					'condition'  => [
						$this->get_control_id( 'show_sale' ) => 'yes',
						$this->get_control_id( 'sale_flash_style' ) => 'custom',

					],
					'selectors'  => [
						'{{WRAPPER}} .uael-sale-flash-wrap .uael-onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'sale_flash_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-sale-flash-wrap .uael-onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'show_sale' ) => 'yes',
						$this->get_control_id( 'sale_flash_style' ) => 'custom',
					],
				]
			);
			$this->add_responsive_control(
				'sale_flash_margin',
				[
					'label'      => __( 'Margin', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '',
						'bottom' => '',
						'left'   => '',
						'right'  => '',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-sale-flash-wrap .uael-onsale' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
				]
			);
			$this->add_control(
				'sale_flash_color',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-woocommerce .uael-onsale' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'sale_flash_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-woocommerce .uael-onsale' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'sale_flash_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-onsale',
					'condition' => [
						$this->get_control_id( 'show_sale' ) => 'yes',
					],
				]
			);
		$this->end_controls_section();
	}
	/**
	 * Register pagination control section.
	 *
	 * @since 0.0.1
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_content_featured_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_content_featured',
			[
				'label' => __( 'Featured Flash', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'show_featured',
				[
					'label'        => __( 'Flash', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'featured_flash_string',
				[
					'label'     => __( 'Flash Content', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => __( 'New', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
				]
			);
		$this->end_controls_section();
	}

	/**
	 * Register Style Flash Controls.
	 *
	 * @since 0.0.1
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_style_featured_controls( Widget_Base $widget ) {

		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_flash_notification',
			[
				'label'     => __( 'Featured Flash', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'show_featured' ) => 'yes',
				],
			]
		);
			$this->add_control(
				'featured_flash_style',
				[
					'label'        => __( 'Flash Style', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => __( 'Circle', 'uael' ),
						'square' => __( 'Square', 'uael' ),
						'custom' => __( 'Custom', 'uael' ),
					],
					'default'      => 'circle',
					'condition'    => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
					'prefix_class' => 'uael-featured-flash-',
				]
			);
			$this->add_responsive_control(
				'featured_flash_size',
				[
					'label'      => __( 'Size', 'uael' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range'      => [
						'px' => [
							'min' => 20,
							'max' => 200,
						],
						'em' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'default'    => [
						'size' => 3,
						'unit' => 'em',
					],
					'condition'  => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-featured' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

					],
				]
			);
			$this->add_responsive_control(
				'featured_flash_radius',
				[
					'label'      => __( 'Rounded Corners', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '',
						'bottom' => '',
						'left'   => '',
						'right'  => '',
						'unit'   => 'px',
					],
					'condition'  => [
						$this->get_control_id( 'show_featured' ) => 'yes',
						$this->get_control_id( 'featured_flash_style' ) => 'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-featured' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'featured_flash_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'show_featured' ) => 'yes',
						$this->get_control_id( 'featured_flash_style' ) => 'custom',
					],
				]
			);
			$this->add_responsive_control(
				'featured_flash_margin',
				[
					'label'      => __( 'Margin', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '',
						'bottom' => '',
						'left'   => '',
						'right'  => '',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-featured-flash-wrap .uael-featured' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
				]
			);
			$this->add_control(
				'featured_flash_color',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-woocommerce .uael-featured' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'featured_flash_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-woocommerce .uael-featured' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'featured_flash_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'selector'  => '{{WRAPPER}} .uael-woocommerce .uael-featured',
					'condition' => [
						$this->get_control_id( 'show_featured' ) => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Render Main HTML.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	public function render() {

		$settings = $this->parent->get_settings();

		$skin = Skin_Init::get_instance( $this->get_id() );

		echo $skin->render( $this->get_id(), $settings, $this->parent->get_id() );
	}
}
