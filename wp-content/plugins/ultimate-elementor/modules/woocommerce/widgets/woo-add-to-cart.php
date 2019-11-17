<?php
/**
 * UAEL WooCommerce Add To Cart Button.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Woo_Add_To_Cart.
 */
class Woo_Add_To_Cart extends Common_Widget {

	/**
	 * Retrieve Widget name.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Woo_Add_To_Cart' );
	}

	/**
	 * Retrieve Widget title.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Woo_Add_To_Cart' );
	}

	/**
	 * Retrieve Widget icon.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Woo_Add_To_Cart' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Woo_Add_To_Cart' );
	}

	/**
	 * Get Script Depends.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return array scripts.
	 */
	public function get_script_depends() {
		return [ 'uael-woocommerce' ];
	}

	/**
	 * Register controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		/* Product Control */
		$this->register_content_product_controls();
		/* Button Control */
		$this->register_content_button_controls();
		/* Button Style */
		$this->register_style_button_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Content Product Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_product_controls() {

		$this->start_controls_section(
			'section_product_field',
			[
				'label' => __( 'Product', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'product_id',
				[
					'label'     => __( 'Select Product', 'uael' ),
					'type'      => 'uael-query-posts',
					'post_type' => 'product',
				]
			);

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {

			$this->add_control(
				'dynamic_product',
				[
					'label'        => __( 'Use Dynamic Product', 'uael' ),
					'description'  => __( 'Enable this option to use Add to Cart button on the single product page.', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'dynamic_product_id',
				[
					'label'     => __( 'Select Product', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'dynamic_product' => 'yes',
					],
				]
			);

		}

			$this->add_control(
				'quantity',
				[
					'label'   => __( 'Quantity', 'uael' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 1,
				]
			);

			$this->add_control(
				'enable_redirect',
				[
					'label'        => __( 'Auto Redirect', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
					'description'  => __( 'Enable this option to redirect cart page after the product gets added to cart', 'uael' ),
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Content Button Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_button_controls() {
		$this->start_controls_section(
			'section_button_field',
			[
				'label' => __( 'Button', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'btn_text',
				[
					'label'   => __( 'Text', 'uael' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __( 'Add to cart', 'uael' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_responsive_control(
				'align',
				[
					'label'        => __( 'Alignment', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'    => [
							'title' => __( 'Left', 'uael' ),
							'icon'  => 'fa fa-align-left',
						],
						'center'  => [
							'title' => __( 'Center', 'uael' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'   => [
							'title' => __( 'Right', 'uael' ),
							'icon'  => 'fa fa-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'uael' ),
							'icon'  => 'fa fa-align-justify',
						],
					],
					'prefix_class' => 'uael-add-to-cart%s-align-',
					'default'      => 'left',
				]
			);
			$this->add_control(
				'btn_size',
				[
					'label'   => __( 'Size', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => [
						'xs' => __( 'Extra Small', 'uael' ),
						'sm' => __( 'Small', 'uael' ),
						'md' => __( 'Medium', 'uael' ),
						'lg' => __( 'Large', 'uael' ),
						'xl' => __( 'Extra Large', 'uael' ),
					],
				]
			);
			$this->add_responsive_control(
				'btn_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'btn_icon',
				[
					'label'       => __( 'Icon', 'uael' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
					'default'     => 'fa fa-shopping-cart',
				]
			);
			$this->add_control(
				'btn_icon_align',
				[
					'label'     => __( 'Icon Position', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'  => __( 'Before', 'uael' ),
						'right' => __( 'After', 'uael' ),
					],
					'condition' => [
						'btn_icon!' => '',
					],
				]
			);
			$this->add_control(
				'btn_icon_indent',
				[
					'label'     => __( 'Icon Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'condition' => [
						'btn_icon!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
	}

	/**
	 * Register Style Button Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_button_controls() {

		$this->start_controls_section(
			'section_design_button',
			[
				'label' => __( 'Button', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .uael-button',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->start_controls_tabs( 'button_tabs_style' );

			$this->start_controls_tab(
				'button_normal',
				[
					'label' => __( 'Normal', 'uael' ),
				]
			);

				$this->add_control(
					'button_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-button' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'button_background_color',
						'label'          => __( 'Background Color', 'uael' ),
						'types'          => [ 'classic', 'gradient' ],
						'selector'       => '{{WRAPPER}} .uael-button',
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

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'        => 'button_border',
						'placeholder' => '',
						'default'     => '',
						'selector'    => '{{WRAPPER}} .uael-button',
					]
				);

				$this->add_control(
					'border_radius',
					[
						'label'      => __( 'Border Radius', 'uael' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .uael-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'     => 'button_box_shadow',
						'selector' => '{{WRAPPER}} .uael-button',
					]
				);

				$this->add_control(
					'view_cart_color',
					[
						'label'     => __( 'View Cart Text', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .added_to_cart' => 'color: {{VALUE}};',
						],
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'button_hover',
				[
					'label' => __( 'Hover', 'uael' ),
				]
			);

				$this->add_control(
					'button_hover_color',
					[
						'label'     => __( 'Text Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-button:focus, {{WRAPPER}} .uael-button:hover' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'button_background_hover_color',
						'label'          => __( 'Background Color', 'uael' ),
						'types'          => [ 'classic', 'gradient' ],
						'selector'       => '{{WRAPPER}} .uael-button:focus, {{WRAPPER}} .uael-button:hover',
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

				$this->add_control(
					'button_border_hover_color',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'condition' => [
							'button_border_border!' => '',
						],
						'selectors' => [
							'{{WRAPPER}} .uael-button:focus, {{WRAPPER}} .uael-button:hover' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'hover_animation',
					[
						'label' => __( 'Hover Animation', 'uael' ),
						'type'  => Controls_Manager::HOVER_ANIMATION,
					]
				);

				$this->add_control(
					'view_cart_hover_color',
					[
						'label'     => __( 'View Cart Text Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .added_to_cart:hover' => 'color: {{VALUE}};',
						],
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.1.0
	 * @access protected
	 */
	protected function register_helpful_information() {

		if ( parent::is_internal_links() ) {
			$this->start_controls_section(
				'section_helpful_info',
				[
					'label' => __( 'Helpful Information', 'uael' ),
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-woocommerce-add-to-cart-button-on-the-page/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Render Woo Product Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		$atc_html = '';
		$product  = false;

		if ( ! empty( $settings['product_id'] ) ) {
			$product_data = get_post( $settings['product_id'] );

		} elseif ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			if ( 'yes' == $settings['dynamic_product'] ) {
				$product_data = get_post( $settings['dynamic_product_id'] );
			}
		}

		$product = ! empty( $product_data ) && in_array( $product_data->post_type, [ 'product', 'product_variation' ] ) ? wc_setup_product_data( $product_data ) : false;

		if ( $product ) {

			$product_id   = $product->get_id();
			$product_type = $product->get_type();

			$class = [
				'uael-button',
				'elementor-button',
				'elementor-animation-' . $settings['hover_animation'],
				'elementor-size-' . $settings['btn_size'],
				'product_type_' . $product_type,
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			];

			if ( 'yes' === $settings['enable_redirect'] ) {
				$class[] = 'uael-redirect';
			}

			$this->add_render_attribute(
				'button',
				[
					'rel'             => 'nofollow',
					'href'            => $product->add_to_cart_url(),
					'data-quantity'   => ( isset( $settings['quantity'] ) ? $settings['quantity'] : 1 ),
					'data-product_id' => $product_id,
					'class'           => $class,
				]
			);

			$this->add_render_attribute(
				'icon-align',
				'class',
				[
					'uael-atc-icon-align',
					'elementor-align-icon-' . $settings['btn_icon_align'],
				]
			);

			$atc_html     .= '<div class="uael-woo-add-to-cart">';
				$atc_html .= '<a ' . $this->get_render_attribute_string( 'button' ) . '>';
				$atc_html .= '<span class="uael-atc-content-wrapper">';

			if ( ! empty( $settings['btn_icon'] ) ) :
				$atc_html     .= '<span ' . $this->get_render_attribute_string( 'icon-align' ) . '">';
					$atc_html .= '<i class="' . $settings['btn_icon'] . '" aria-hidden="true"></i>';
				$atc_html     .= '</span>';
				endif;

				$atc_html .= '<span class="uael-atc-btn-text">' . $settings['btn_text'] . '</span>';
				$atc_html .= '</span>';
				$atc_html .= '</a>';
			$atc_html     .= '</div>';

			echo $atc_html;
		} elseif ( current_user_can( 'manage_options' ) ) {

			$class = implode(
				' ',
				array_filter(
					[
						'button',
						'uael-button',
						'elementor-animation-' . $settings['hover_animation'],
					]
				)
			);
			$this->add_render_attribute(
				'button',
				[ 'class' => $class ]
			);

			$atc_html     .= '<div class="uael-woo-add-to-cart">';
				$atc_html .= '<a ' . $this->get_render_attribute_string( 'button' ) . '>';
				$atc_html .= __( 'Please select the product', 'uael' );
				$atc_html .= '</a>';
			$atc_html     .= '</div>';

			echo $atc_html;
		}
	}
}
