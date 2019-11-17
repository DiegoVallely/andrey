<?php
/**
 * UAEL Price Table.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\PriceTable\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class PriceTable.
 */
class Price_Table extends Common_Widget {

	/**
	 * Retrieve Price Table Widget name.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Price_Table' );
	}

	/**
	 * Retrieve Price Table Widget title.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Price_Table' );
	}

	/**
	 * Retrieve Price Table Widget icon.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Price_Table' );
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
		return parent::get_widget_keywords( 'Price_Table' );
	}

	/**
	 * Register Price Table controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_general_controls();
		$this->register_heading_controls();
		$this->register_pricing_controls();
		$this->register_sub_heading_controls();
		$this->register_content_controls();
		$this->register_cta_controls();
		$this->register_separator_controls();
		$this->register_ribbon_controls();

		$this->register_heading_style_controls();
		$this->register_pricing_style_controls();
		$this->register_sub_heading_style_controls();
		$this->register_content_style_controls();
		$this->register_cta_style_controls();
		$this->register_separator_style_controls();
		$this->register_ribbon_style_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Price Table General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_general_controls() {
		$this->start_controls_section(
			'section_general_field',
			[
				'label' => __( 'General', 'uael' ),
			]
		);

		$this->add_control(
			'pricetable_style',
			[
				'label'       => __( 'Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'default'     => '1',
				'options'     => [
					'1' => 'Normal',
					'2' => 'Features at Bottom',
					'3' => 'Circular Background for Price',
				],
			]
		);

		$this->add_control(
			'box_hover_animation',
			[
				'label'        => __( 'Hover Animation', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => [
					''                => 'None',
					'float'           => 'Float',
					'sink'            => 'Sink',
					'wobble-vertical' => 'Wobble Vertical',
				],
				'prefix_class' => 'elementor-animation-',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Heading Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_heading_controls() {

		$this->start_controls_section(
			'section_header_field',
			[
				'label' => __( 'Heading', 'uael' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => __( 'Title', 'uael' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Unlimited', 'uael' ),
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'     => __( 'Description', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => __( 'Free trial 30 days.', 'uael' ),
				'condition' => [
					'pricetable_style!' => '2',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register Price Table Heading Controls for Style 3.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_sub_heading_controls() {

		$this->start_controls_section(
			'section_sub_heading_field',
			[
				'label'     => __( 'Description', 'uael' ),
				'condition' => [
					'pricetable_style' => '2',
				],
			]
		);

		$this->add_control(
			'sub_heading_style2',
			[
				'label'     => __( 'Description', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => __( 'Free trial 30 days.', 'uael' ),
				'condition' => [
					'pricetable_style' => '2',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Pricing Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_pricing_controls() {

		$this->start_controls_section(
			'section_pricing_fields',
			[
				'label' => __( 'Pricing', 'uael' ),
			]
		);
		$this->add_control(
			'price',
			[
				'label'   => __( 'Price', 'uael' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( '49.99', 'uael' ),
			]
		);
		$this->add_control(
			'sale',
			[
				'label'        => __( 'Offering Discount?', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'original_price',
			[
				'label'     => __( 'Original Price', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '59.99',
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'sale' => 'yes',
				],
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'   => __( 'Currency Symbol', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''             => __( 'None', 'uael' ),
					'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'uael' ),
					'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'uael' ),
					'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'uael' ),
					'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'uael' ),
					'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'uael' ),
					'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'uael' ),
					'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'uael' ),
					'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'uael' ),
					'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'uael' ),
					'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'uael' ),
					'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'uael' ),
					'real'         => 'R$ ' . _x( 'Real', 'Currency Symbol', 'uael' ),
					'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'uael' ),
					'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'uael' ),
					'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'uael' ),
					'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'uael' ),
					'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'uael' ),
					'custom'       => __( 'Custom', 'uael' ),
				],
				'default' => 'dollar',
			]
		);

		$this->add_control(
			'currency_symbol_custom',
			[
				'label'     => __( 'Currency Symbol', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'currency_symbol' => 'custom',
				],
			]
		);
		$this->add_control(
			'currency_format',
			[
				'label'   => __( 'Currency Format', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''  => 'Raised',
					',' => 'Normal',
				],
			]
		);
		if ( parent::is_internal_links() ) {

			$this->add_control(
				'help_doc_pricing',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => __( 'The raised option will add a Subscript / Superscript design to the fractional part of the Price.', 'uael' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'currency_format' => '',
					],
					'separator'       => 'none',
				]
			);
		}

		$this->add_control(
			'duration',
			[
				'label'   => __( 'Duration', 'uael' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Monthly', 'uael' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'duration_position',
			[
				'label'       => __( 'Duration Position', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'below'  => 'Below',
					'beside' => 'Beside',
				],
				'default'     => 'below',
				'condition'   => [
					'duration!'         => '',
					'pricetable_style!' => '3',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table separator Controls for Style 3.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_separator_controls() {

		$this->start_controls_section(
			'section_separator',
			[
				'label'     => __( 'Separator', 'uael' ),
				'condition' => [
					'pricetable_style' => '2',
				],
			]
		);

			$this->add_control(
				'pricetable_separator',
				[
					'label'        => __( 'Separator', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'pricetable_style' => '2',
					],
				]
			);

			$this->end_controls_section();
	}

	/**
	 * Register Price Table Content Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_controls() {

		$this->start_controls_section(
			'section_features',
			[
				'label' => __( 'Content', 'uael' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'   => __( 'Text', 'uael' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Feature', 'uael' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label'   => __( 'Icon', 'uael' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'fa fa-arrow-circle-right',
			]
		);

		$repeater->add_control(
			'item_advanced_settings',
			[
				'label'        => __( 'Override Global Settings', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label'     => __( 'Icon Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'condition' => [
					'item_icon!'             => '',
					'item_advanced_settings' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list {{CURRENT_ITEM}} i' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'item_text_color',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_advanced_settings' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'item_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_advanced_settings' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'features_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => [
					[
						'item_text' => __( 'List of Features', 'uael' ),
						'item_icon' => 'fa fa-arrow-circle-right',
					],
					[
						'item_text' => __( 'List of Features', 'uael' ),
						'item_icon' => 'fa fa-arrow-circle-right',
					],
					[
						'item_text' => __( 'List of Features', 'uael' ),
						'item_icon' => 'fa fa-arrow-circle-right',
					],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Call to Action Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_cta_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Call To Action', 'uael' ),
			]
		);

		$this->add_control(
			'price_cta_type',
			[
				'label'       => __( 'Type', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'button',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'uael' ),
					'link'   => __( 'Text', 'uael' ),
					'button' => __( 'Button', 'uael' ),
				],
			]
		);

		$this->add_control(
			'cta_text',
			[
				'label'     => __( 'Text', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Select Plan', 'uael' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'price_cta_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'cta_icon',
			[
				'label'     => __( 'Select Icon', 'uael' ),
				'type'      => Controls_Manager::ICON,
				'default'   => '',
				'condition' => [
					'price_cta_type' => [ 'button', 'link' ],
				],
			]
		);

		$this->add_control(
			'cta_icon_position',
			[
				'label'       => __( 'Icon Position', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'right',
				'label_block' => false,
				'options'     => [
					'right' => __( 'After Text', 'uael' ),
					'left'  => __( 'Before Text', 'uael' ),
				],
				'condition'   => [
					'price_cta_type' => [ 'button', 'link' ],
					'cta_icon!'      => '',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'uael' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'price_cta_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'footer_additional_info',
			[
				'label'   => __( 'Disclaimer Text', 'uael' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register Price Table Ribbon Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_ribbon_controls() {

		$this->start_controls_section(
			'section_ribbon',
			[
				'label' => __( 'Ribbon', 'uael' ),
			]
		);

		$this->add_control(
			'show_ribbon',
			[
				'label'       => __( 'Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none' => __( 'None', 'uael' ),
					'1'    => __( 'Corner Ribbon', 'uael' ),
					'2'    => __( 'Circular Ribbon', 'uael' ),
					'3'    => __( 'Flag Ribbon', 'uael' ),
				],
			]
		);

		$this->add_control(
			'ribbon_title',
			[
				'label'     => __( 'Title', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'NEW', 'uael' ),
				'condition' => [
					'show_ribbon!' => 'none',
				],
			]
		);

		$this->add_control(
			'ribbon_horizontal_position',
			[
				'label'       => __( 'Horizontal Position', 'uael' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'toggle'      => false,
				'options'     => [
					'left'  => [
						'title' => __( 'Left', 'uael' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'uael' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => 'right',
				'condition'   => [
					'show_ribbon!' => [ 'none', '3' ],
				],
			]
		);

		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'ribbon_distance',
			[
				'label'     => __( 'Distance', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-ribbon-1 .uael-price-table-ribbon-content' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
				'condition' => [
					'show_ribbon' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'em' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default'   => [
					'size' => '4',
					'unit' => 'em',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-ribbon-2 .uael-price-table-ribbon-content' => 'min-height: {{SIZE}}em; min-width: {{SIZE}}em; line-height: {{SIZE}}em; z-index: 1;',
				],
				'condition' => [
					'show_ribbon' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_top_distance',
			[
				'label'     => __( 'Top Distance', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-ribbon-3 .uael-price-table-ribbon-content' => 'top: {{SIZE}}%;',
				],
				'condition' => [
					'show_ribbon' => '3',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Heading Style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_heading_style_controls() {

		$this->start_controls_section(
			'section_header_style',
			[
				'label'      => __( 'Heading', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);
		$this->add_control(
			'header_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-header' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-pricing-style-3 .uael-pricing-heading-wrap, {{WRAPPER}} .uael-pricing-style-2 .uael-price-table-header, {{WRAPPER}} .uael-pricing-style-1 .uael-price-table-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_style',
			[
				'label'     => __( 'Title', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'heading_tag',
			[
				'label'   => __( 'Title Tag', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'  => __( 'H1', 'uael' ),
					'h2'  => __( 'H2', 'uael' ),
					'h3'  => __( 'H3', 'uael' ),
					'h4'  => __( 'H4', 'uael' ),
					'h5'  => __( 'H5', 'uael' ),
					'h6'  => __( 'H6', 'uael' ),
					'div' => __( 'div', 'uael' ),
					'p'   => __( 'p', 'uael' ),
				],
				'default' => 'h3',
			]
		);
		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-heading' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .uael-price-table-heading',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'sub_heading_style',
			[
				'label'     => __( 'Description', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pricetable_style!' => '2',
				],
			]
		);
		$this->add_control(
			'sub_heading_tag',
			[
				'label'     => __( 'Description Tag', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'  => __( 'H1', 'uael' ),
					'h2'  => __( 'H2', 'uael' ),
					'h3'  => __( 'H3', 'uael' ),
					'h4'  => __( 'H4', 'uael' ),
					'h5'  => __( 'H5', 'uael' ),
					'h6'  => __( 'H6', 'uael' ),
					'div' => __( 'div', 'uael' ),
					'p'   => __( 'p', 'uael' ),
				],
				'condition' => [
					'pricetable_style!' => '2',
				],
				'default'   => 'p',
			]
		);
		$this->add_control(
			'sub_heading_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'pricetable_style!' => '2',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-subheading' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sub_heading_typography',
				'selector'  => '{{WRAPPER}} .uael-price-table-subheading',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'pricetable_style!' => '2',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Description Style Controls for Style 3.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_sub_heading_style_controls() {

		$this->start_controls_section(
			'section_sub_heading_style2',
			[
				'label'      => __( 'Description', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'pricetable_style' => '2',
				],
			]
		);

		$this->add_control(
			'sub_heading_tag_style2',
			[
				'label'     => __( 'Description Tag', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'  => __( 'H1', 'uael' ),
					'h2'  => __( 'H2', 'uael' ),
					'h3'  => __( 'H3', 'uael' ),
					'h4'  => __( 'H4', 'uael' ),
					'h5'  => __( 'H5', 'uael' ),
					'h6'  => __( 'H6', 'uael' ),
					'div' => __( 'div', 'uael' ),
					'p'   => __( 'p', 'uael' ),
				],
				'condition' => [
					'pricetable_style' => '2',
				],
				'default'   => 'p',
			]
		);
		$this->add_control(
			'sub_heading_color_style2',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'pricetable_style' => '2',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-subheading' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sub_heading_typography_style2',
				'selector'  => '{{WRAPPER}} .uael-price-table-subheading',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'pricetable_style' => '2',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Pricing Style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_pricing_style_controls() {

		$this->start_controls_section(
			'section_pricing_element_style',
			[
				'label'      => __( 'Pricing', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'pricing_element_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-pricing-style-3 .uael-price-table-pricing, {{WRAPPER}} .uael-pricing-style-2 .uael-price-table-price-wrap, {{WRAPPER}} .uael-pricing-style-1 .uael-price-table-price-wrap' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'price_bg_size',
			[
				'label'      => __( 'Background Size', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 300,
					],
					'em' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'default'    => [
					'size' => '9',
					'unit' => 'em',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-pricing-style-3 .uael-price-table-pricing' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; margin-top: calc( -{{SIZE}}{{UNIT}} / 2 ); box-sizing: content-box;',
					'{{WRAPPER}} .uael-pricing-style-3 .uael-price-table-header' => 'padding-bottom: calc( {{SIZE}}{{UNIT}} / 2 );',
				],
				'condition'  => [
					'pricetable_style' => '3',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_element_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'condition'  => [
					'pricetable_style!' => '3',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-price-table-price-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'price_border_style3',
				'label'          => __( 'Border', 'uael' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'    => '3',
							'right'  => '3',
							'bottom' => '3',
							'left'   => '3',
						],
					],
				],
				'condition'      => [
					'pricetable_style' => '3',
				],
				'selector'       => '{{WRAPPER}} .uael-pricing-style-3 .uael-price-table-pricing',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'section_price_shadow',
				'condition' => [
					'pricetable_style' => '3',
				],
				'selector'  => '{{WRAPPER}} .uael-price-table-pricing',
			]
		);

		$this->add_control(
			'main_price_style',
			[
				'label'     => __( 'Price', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-currency, {{WRAPPER}} .uael-price-table-integer-part, {{WRAPPER}} .uael-price-table-fractional-part, {{WRAPPER}} .uael-price-currency-normal' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .uael-pricing-value',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_currency_style',
			[
				'label'     => __( 'Currency Symbol', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'currency_symbol!' => '',
					'currency_format!' => ',',
				],
			]
		);

		$this->add_responsive_control(
			'currency_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-currency' => 'font-size: calc({{SIZE}}em/100)',
				],
				'condition' => [
					'currency_symbol!' => '',
					'currency_format!' => ',',
				],
			]
		);

		$this->add_control(
			'currency_vertical_position',
			[
				'label'                => __( 'Vertical Position', 'uael' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'uael' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'condition'            => [
					'currency_symbol!' => '',
					'currency_format!' => ',',
				],
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .uael-price-table-currency' => 'align-self: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'fractional_part_style',
			[
				'label'     => __( 'Fractional Part', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'currency_format!' => ',',
				],
			]
		);

		$this->add_responsive_control(
			'fractional_part_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'currency_format!' => ',',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-fractional-part' => 'font-size: calc({{SIZE}}em/100)',
				],
			]
		);

		$this->add_control(
			'fractional_part_position',
			[
				'label'                => __( 'Vertical Position', 'uael' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'uael' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'condition'            => [
					'currency_format!' => ',',
				],
				'selectors'            => [
					'{{WRAPPER}} .uael-price-table-beside-price' => 'align-self: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_original_price_style',
			[
				'label'     => __( 'Original Price', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'original_price_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-original-price' => 'color: {{VALUE}};',
				],
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'original_price_typography',
				'selector'  => '{{WRAPPER}} .uael-price-table-original-price',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'original_price_vertical_position',
			[
				'label'                => __( 'Vertical Position', 'uael' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'uael' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default'              => 'middle',
				'selectors'            => [
					'{{WRAPPER}} .uael-price-table-original-price' => 'align-self: {{VALUE}}',
				],
				'condition'            => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'heading_duration_style',
			[
				'label'     => __( 'Duration', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'duration!' => '',
				],
			]
		);

		$this->add_control(
			'duration_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-duration' => 'color: {{VALUE}}',
				],
				'condition' => [
					'duration!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'duration_typography',
				'selector'  => '{{WRAPPER}} .uael-price-table-duration',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'duration!' => '',
				],
			]
		);

		$this->add_control(
			'duration_part_position',
			[
				'label'                => __( 'Vertical Position', 'uael' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'uael' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'bottom',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'condition'            => [
					'duration_position' => 'beside',
					'currency_format'   => ',',
					'pricetable_style!' => '2',
				],
				'selectors'            => [
					'{{WRAPPER}} .uael-price-table-beside-price' => 'align-self: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Content Style Controls for Style 3.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_separator_style_controls() {

		$this->start_controls_section(
			'section_separator_style',
			[
				'label'      => __( 'Separator', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'pricetable_style' => '2',
				],
			]
		);

		$this->add_control(
			'pricetable_separator_style',
			[
				'label'       => __( 'Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => [
					'solid'  => __( 'Solid', 'uael' ),
					'dashed' => __( 'Dashed', 'uael' ),
					'dotted' => __( 'Dotted', 'uael' ),
					'double' => __( 'Double', 'uael' ),
				],
				'condition'   => [
					'pricetable_separator' => 'yes',
					'pricetable_style'     => '2',
				],
				'selectors'   => [
					'{{WRAPPER}} .uael-separator' => 'border-top-style: {{VALUE}}; display: inline-block;',
				],
			]
		);

		$this->add_control(
			'pricetable_separator_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'condition' => [
					'pricetable_separator' => 'yes',
					'pricetable_style'     => '2',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-separator' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricetable_separator_thickness',
			[
				'label'      => __( 'Thickness', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 2,
					'unit' => 'px',
				],
				'condition'  => [
					'pricetable_separator' => 'yes',
					'pricetable_style'     => '2',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pricetable_separator_width',
			[
				'label'          => __( 'Width', 'uael' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1200,
					],
				],
				'default'        => [
					'size' => 70,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'label_block'    => true,
				'condition'      => [
					'pricetable_separator' => 'yes',
					'pricetable_style'     => '2',
				],
				'selectors'      => [
					'{{WRAPPER}} .uael-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table Content Style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_style_controls() {

		$this->start_controls_section(
			'section_features_list_style',
			[
				'label'      => __( 'Content', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'price_features_layout',
			[
				'label'        => __( 'Layout', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'simple',
				'label_block'  => false,
				'options'      => [
					'simple'    => __( 'Simple', 'uael' ),
					'divider'   => __( 'Divider between fields', 'uael' ),
					'borderbox' => __( 'Box Layout', 'uael' ),
					'strips'    => __( 'Stripped Layout', 'uael' ),
				],
				'prefix_class' => 'uael-price-features-',
			]
		);

		$this->add_control(
			'features_list_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'price_features_layout!' => 'strips',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list, {{WRAPPER}} .uael-pricing-style-3 .uael-price-table-price-wrap' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'features_list_padding',
			[
				'label'      => __( 'Box Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-price-table-features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_list_style_fields',
			[
				'label'     => __( 'Features List', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'features_icon_spacing',
			[
				'label'     => __( 'Icon Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 5,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_icon_color',
			[
				'label'     => __( 'Icon Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'features_list_color',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'features_list_typography',
				'selector' => '{{WRAPPER}} .uael-price-table-features-list li',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_responsive_control(
			'features_rows_padding',
			[
				'label'      => __( 'Item Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-price-table-feature-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'features_list_alignment',
			[
				'label'       => __( 'Alignment', 'uael' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
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
				'selectors'   => [
					'{{WRAPPER}} .uael-price-table-features-list' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'features_list_divider_heading',
			[
				'label'     => __( 'Divider', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'price_features_layout' => 'divider',
				],
			]
		);

		$this->add_control(
			'features_list_borderbox',
			[
				'label'     => __( 'Box Layout', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'price_features_layout' => 'borderbox',
				],
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label'     => __( 'Style', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'solid'  => __( 'Solid', 'uael' ),
					'double' => __( 'Double', 'uael' ),
					'dotted' => __( 'Dotted', 'uael' ),
					'dashed' => __( 'Dashed', 'uael' ),
				],
				'condition' => [
					'price_features_layout' => [ 'divider', 'borderbox' ],
				],
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}}.uael-price-features-divider .uael-price-table-features-list li:before, {{WRAPPER}}.uael-price-features-borderbox .uael-price-table-features-list li:before, {{WRAPPER}}.uael-price-features-borderbox .uael-price-table-features-list li:after' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'price_features_layout' => [ 'divider', 'borderbox' ],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list li:before, {{WRAPPER}}.uael-price-features-borderbox .uael-price-table-features-list li:after' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_weight',
			[
				'label'     => __( 'Weight', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'price_features_layout' => [ 'divider', 'borderbox' ],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-features-list li:before, {{WRAPPER}}.uael-price-features-borderbox .uael-price-table-features-list li:after' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'divider_width',
			[
				'label'     => __( 'Width', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '60',
					'unit' => 'px',
				],
				'condition' => [
					'price_features_layout' => 'divider',
				],
				'selectors' => [
					'{{WRAPPER}}.uael-price-features-divider .uael-price-table-features-list li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'features_even_odd_fields',
			[
				'label'     => __( 'Stripped Layout', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->start_controls_tabs( 'features_list_style' );

		$this->start_controls_tab(
			'features_even',
			[
				'label'     => __( 'Even', 'uael' ),
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->add_control(
			'features_bg_color_even',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .uael-price-table .uael-price-table-features-list li:nth-child(even)' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->add_control(
			'features_text_color_even',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-price-table .uael-price-table-features-list li:nth-child(even)' => 'color: {{VALUE}}',
				],
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_features_odd',
			[
				'label'     => __( 'Odd', 'uael' ),
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->add_control(
			'table_features_bg_color_odd',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'selectors' => [
					'{{WRAPPER}} .uael-price-table .uael-price-table-features-list li:nth-child(odd)' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->add_control(
			'table_features_text_color_odd',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-price-table .uael-price-table-features-list li:nth-child(odd)' => 'color: {{VALUE}}',
				],
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'features_spacing',
			[
				'label'     => __( 'Item Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => '0',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table .uael-price-table-features-list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'price_features_layout' => 'strips',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Price Table CTA style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_cta_style_controls() {

		$this->start_controls_section(
			'section_footer_style',
			[
				'label'      => __( 'Call To Action', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'footer_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-cta' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'footer_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-price-table-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_footer_link',
			[
				'label'     => __( 'Link', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'price_cta_type' => 'link',
				],
			]
		);

		$this->add_control(
			'link_text_color',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.uael-pricebox-cta-link' => 'color: {{VALUE}};',
				],
				'condition' => [
					'price_cta_type' => 'link',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'link_typography',
				'selector'  => '{{WRAPPER}} a.uael-pricebox-cta-link',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'price_cta_type' => 'link',
				],
			]
		);

		$this->add_control(
			'heading_footer_button',
			[
				'label'     => __( 'Button', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'selector'  => '{{WRAPPER}} .elementor-button, {{WRAPPER}} a.elementor-button',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'md',
				'options'   => [
					'xs' => __( 'Extra Small', 'uael' ),
					'sm' => __( 'Small', 'uael' ),
					'md' => __( 'Medium', 'uael' ),
					'lg' => __( 'Large', 'uael' ),
					'xl' => __( 'Extra Large', 'uael' ),
				],
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);
		$this->add_responsive_control(
			'button_custom_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'price_cta_type' => 'button',
				],
				'separator'  => 'after',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

			$this->start_controls_tab(
				'tab_button_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'price_cta_type' => 'button',
					],
				]
			);

			$this->add_control(
				'cta_text_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'price_cta_type' => 'button',
					],
				]
			);

			$this->add_control(
				'button_background_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'price_cta_type' => 'button',
					],
				]
			);

			$this->add_control(
				'button_border',
				[
					'label'       => __( 'Border Style', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'none',
					'label_block' => false,
					'options'     => [
						'none'   => __( 'None', 'uael' ),
						'solid'  => __( 'Solid', 'uael' ),
						'double' => __( 'Double', 'uael' ),
						'dotted' => __( 'Dotted', 'uael' ),
						'dashed' => __( 'Dashed', 'uael' ),
					],
					'condition'   => [
						'price_cta_type' => 'button',
					],
					'selectors'   => [
						'{{WRAPPER}} .elementor-button' => 'border-style: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_border_size',
				[
					'label'      => __( 'Border Width', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default'    => [
						'top'    => '1',
						'bottom' => '1',
						'left'   => '1',
						'right'  => '1',
						'unit'   => 'px',
					],
					'condition'  => [
						'price_cta_type' => 'button',
						'button_border!' => 'none',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-price-table .elementor-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'button_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'price_cta_type' => 'button',
						'button_border!' => 'none',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-price-table .elementor-button' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'button_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'price_cta_type' => 'button',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'button_box_shadow',
					'label'     => __( 'Button Shadow', 'uael' ),
					'condition' => [
						'price_cta_type' => 'button',
					],
					'selector'  => '{{WRAPPER}} .elementor-button',
				]
			);

			$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => __( 'Hover', 'uael' ),
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'price_cta_type' => 'button',
					'button_border!' => 'none',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_hover_box_shadow',
				'label'     => __( 'Hover Shadow', 'uael' ),
				'selector'  => '{{WRAPPER}} .elementor-button:hover',
				'separator' => 'before',
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'     => __( 'Animation', 'uael' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => [
					'price_cta_type' => 'button',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_additional_info',
			[
				'label'     => __( 'Disclaimer Text', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);
		$this->add_control(
			'additional_info_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-disclaimer' => 'color: {{VALUE}}',
				],
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'additional_info_typography',
				'selector'  => '{{WRAPPER}} .uael-price-table-disclaimer',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_control(
			'additional_info_margin',
			[
				'label'      => __( 'Margin', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 20,
					'right'  => 20,
					'bottom' => 20,
					'left'   => 20,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-price-table-disclaimer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [
					'footer_additional_info!' => '',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register Price Table Ribbon Style Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_ribbon_style_controls() {

		$this->start_controls_section(
			'section_ribbon_style',
			[
				'label'      => __( 'Ribbon', 'uael' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'show_ribbon!' => 'none',
				],
			]
		);
		$this->add_control(
			'ribbon_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-ribbon-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .uael-price-table-ribbon-3 .uael-price-table-ribbon-content:before' => 'border-left: 8px solid {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-price-table-ribbon-3 .uael-price-table-ribbon-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
				'condition'  => [
					'show_ribbon' => '3',
				],
			]
		);

		$this->add_control(
			'ribbon_text_color',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .uael-price-table-ribbon-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ribbon_typography',
				'selector' => '{{WRAPPER}} .uael-price-table-ribbon-content',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .uael-price-table-ribbon-content',
			]
		);
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/price-box-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_7',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=TJmcPWToHU0&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc&index=10" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Price Box styles » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/what-are-different-style-options-for-price-box/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Price value & Currency styling » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/normal-and-raised-format-for-price/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Content / Features area styling » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/box-and-stripped-layouts-for-content-in-price-box/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Ribbon styles » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/different-ribbon-styles-for-price-box/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Hover Animation effects » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/hover-animation-effects-for-price-box/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Method render_button
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_button( $settings ) {
		if ( 'link' == $settings['price_cta_type'] ) {

			$_nofollow = ( 'on' == $settings['link']['nofollow'] ) ? 'nofollow' : '';
			$_target   = ( 'on' == $settings['link']['is_external'] ) ? '_blank' : '';
			$_link     = ( isset( $settings['link']['url'] ) ) ? $settings['link']['url'] : '';

			if ( ! empty( $settings['link']['url'] ) ) {

				$this->add_render_attribute( 'cta_link', 'href', $settings['link']['url'] );
				$this->add_render_attribute( 'cta_link', 'class', 'uael-pricebox-cta-link' );

				if ( $settings['link']['is_external'] ) {
					$this->add_render_attribute( 'cta_link', 'target', '_blank' );
				}
				if ( $settings['link']['nofollow'] ) {
					$this->add_render_attribute( 'cta_link', 'rel', 'nofollow' );
				}
			}
			?>
			<a <?php echo $this->get_render_attribute_string( 'cta_link' ); ?>>
				<?php
				if ( ! empty( $settings['cta_icon'] ) && ( 'left' == $settings['cta_icon_position'] ) ) {
					?>
					<i class="uael-cta-link-icon uael-cta-link-icon-before fa <?php echo $settings['cta_icon']; ?>"></i>
					<?php } ?>
					<?php
					if ( ! empty( $settings['cta_text'] ) ) {
						?>
						<span class="elementor-inline-editing" data-elementor-setting-key="cta_text" data-elementor-inline-editing-toolbar="basic"><?php echo $settings['cta_text']; ?></span>
					<?php } ?>
				<?php
				if ( ! empty( $settings['cta_icon'] ) && 'right' == $settings['cta_icon_position'] ) {
					?>
					<i class="uael-cta-link-icon uael-cta-link-icon-after fa <?php echo $settings['cta_icon']; ?>"></i>
				<?php } ?>
			</a>
			<?php
		} elseif ( 'button' == $settings['price_cta_type'] ) {

			$this->add_render_attribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );
			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
				$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

				if ( $settings['link']['is_external'] ) {
					$this->add_render_attribute( 'button', 'target', '_blank' );
				}
				if ( $settings['link']['nofollow'] ) {
					$this->add_render_attribute( 'button', 'rel', 'nofollow' );
				}
			}
			$this->add_render_attribute( 'button', 'class', ' elementor-button' );
			if ( ! empty( $settings['button_size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
			}
			if ( ! empty( $settings['button_hover_animation'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
			}
			?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php
						$this->add_render_attribute( 'text', 'class', 'elementor-button-text' );
						$this->add_render_attribute( 'text', 'class', 'elementor-inline-editing' );
					?>
					<?php
					if ( ! empty( $settings['cta_icon'] ) && ( 'left' == $settings['cta_icon_position'] ) ) {
						?>
						<i class="uael-cta-link-icon uael-cta-link-icon-before fa <?php echo $settings['cta_icon']; ?>"></i>
					<?php } ?>
					<?php
					if ( ! empty( $settings['cta_text'] ) ) {
						?>
					<span <?php echo $this->get_render_attribute_string( 'text' ); ?>  data-elementor-setting-key="cta_text" data-elementor-inline-editing-toolbar="none"><?php echo $settings['cta_text']; ?></span>
					<?php } ?>
					<?php
					if ( ! empty( $settings['cta_icon'] ) && 'right' == $settings['cta_icon_position'] ) {
						?>
						<i class="uael-cta-link-icon uael-cta-link-icon-after fa <?php echo $settings['cta_icon']; ?>"></i>
				<?php } ?>
				</a>
			</div>
			<?php
		}
	}

	/**
	 * Method get_currency_symbol.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $symbol_name for currency symbol.
	 */
	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar'       => '&#36;',
			'franc'        => '&#8355;',
			'euro'         => '&#128;',
			'ruble'        => '&#8381;',
			'pound'        => '&#163;',
			'indian_rupee' => '&#8377;',
			'baht'         => '&#3647;',
			'shekel'       => '&#8362;',
			'yen'          => '&#165;',
			'guilder'      => '&fnof;',
			'won'          => '&#8361;',
			'peso'         => '&#8369;',
			'lira'         => '&#8356;',
			'peseta'       => '&#8359',
			'rupee'        => '&#8360;',
			'real'         => 'R$',
			'krona'        => 'kr',
		];
		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	/**
	 * Method render_heading_text
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_heading_text( $settings ) {
		if ( $settings['heading'] ) :
			if ( ! empty( $settings['heading'] ) ) :
				?>
				<div class="uael-price-heading-text">
					<<?php echo $settings['heading_tag']; ?> class="uael-price-table-heading elementor-inline-editing" data-elementor-setting-key="heading" data-elementor-inline-editing-toolbar="basic"><?php echo $settings['heading']; ?>
					</<?php echo $settings['heading_tag']; ?>>
				</div>
				<?php
			endif;
		endif;
	}

	/**
	 * Method render_subheading_text
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_subheading_text( $settings ) {

		if ( ! empty( $settings['sub_heading'] ) || ! empty( $settings['sub_heading_style2'] ) ) :
			?>
			<div class="uael-price-subheading-text">
				<?php if ( '2' == $settings['pricetable_style'] ) { ?>
					<<?php echo $settings['sub_heading_tag_style2']; ?> class="uael-price-table-subheading elementor-inline-editing" data-elementor-setting-key="sub_heading_style2" data-elementor-inline-editing-toolbar="basic">
						<?php echo $settings['sub_heading_style2']; ?>
					</<?php echo $settings['sub_heading_tag_style2']; ?>>
				<?php } else { ?>
					<<?php echo $settings['sub_heading_tag']; ?> class="uael-price-table-subheading elementor-inline-editing" data-elementor-setting-key="sub_heading" data-elementor-inline-editing-toolbar="basic">
						<?php echo $settings['sub_heading']; ?>
					</<?php echo $settings['sub_heading_tag']; ?>>
				<?php } ?>
			</div>
			<?php
		endif;
	}

	/**
	 * Method render_header
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_style_header( $settings ) {

		if ( '2' == $settings['pricetable_style'] ) {
			if ( $settings['heading'] ) :
				?>
				<div class="uael-price-table-header">
					<?php $this->render_heading_text( $settings ); ?>
				</div>
				<?php
			endif;
		} else {
			if ( $settings['heading'] || $settings['sub_heading'] ) :
				?>
				<div class="uael-price-table-header">
					<div class="uael-pricing-heading-wrap">
						<?php $this->render_heading_text( $settings ); ?>
						<?php $this->render_subheading_text( $settings ); ?>
					</div>
				</div>
				<?php
			endif;
		}
	}

	/**
	 * Method render_price
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_price( $settings ) {
		$symbols = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}

		$currency_format = empty( $settings['currency_format'] ) ? '.' : $settings['currency_format'];
		$price           = explode( $currency_format, $settings['price'] );
		$intvalue        = $price[0];
		$fraction        = '';
		if ( 2 === count( $price ) ) {
			$fraction = $price[1];
		}

		$duration_position = $settings['duration_position'];
		$duration_element  = '<span class="uael-price-table-duration uael-price-typo-excluded elementor-inline-editing" data-elementor-setting-key="duration" data-elementor-inline-editing-toolbar="basic">' . $settings['duration'] . '</span>';
		?>
		<div class="uael-price-table-price-wrap">
			<div class="uael-price-table-pricing">
				<div class="uael-pricing-container">
					<div class="uael-pricing-value">
						<?php if ( 'yes' === $settings['sale'] && ! empty( $settings['original_price'] ) ) : ?>
							<span class="uael-price-table-original-price uael-price-typo-excluded"><?php echo $symbol . $settings['original_price']; ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $symbol ) && ',' != $settings['currency_format'] ) : ?>
							<span class="uael-price-table-currency"><?php echo $symbol; ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $intvalue ) || 0 <= $intvalue ) : ?>
							<?php if ( ! empty( $symbol ) && ',' == $settings['currency_format'] ) : ?>
									<span class="uael-price-currency-normal"><?php echo $symbol; ?></span>
								<?php endif; ?>
							<span class="uael-price-table-integer-part"><?php echo $intvalue; ?></span>
						<?php endif; ?>

						<?php if ( '' !== $fraction || ( ! empty( $settings['duration'] ) && 'beside' === $duration_position ) ) : ?>
							<span class="uael-price-table-beside-price">
								<span class="uael-price-table-fractional-part"><?php echo $fraction; ?></span>
								<?php if ( ! empty( $settings['duration'] ) && 'beside' === $duration_position && '3' != $settings['pricetable_style'] ) : ?>
									<?php echo $duration_element; ?>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $settings['duration'] ) ) : ?>
						<?php if ( '3' === $settings['pricetable_style'] || 'below' === $settings['duration_position'] ) : ?>
							<div class="uael-pricing-duration">
								<?php echo $duration_element; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Method render_features
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_features( $settings ) {

		if ( ! empty( $settings['features_list'] ) ) :
			?>
			<ul class="uael-price-table-features-list">
				<?php foreach ( $settings['features_list'] as  $index => $item ) : ?>
					<?php
					$title_key = $this->get_repeater_setting_key( 'item_text', 'features_list', $index );
					$this->add_inline_editing_attributes( $title_key, 'basic' );
					?>
					<li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
						<div class="uael-price-table-feature-content">
							<?php if ( ! empty( $item['item_icon'] ) ) : ?>
								<i class="<?php echo esc_attr( $item['item_icon'] ); ?>"></i>
							<?php endif; ?>
							<?php
							if ( ! empty( $item['item_text'] ) ) :
								?>
							<span <?php echo $this->get_render_attribute_string( $title_key ); ?>><?php echo $item['item_text']; ?></span>
								<?php
							else :
								echo '&nbsp;';
							endif;
							?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php
		endif;
	}

	/**
	 * Method render_cta
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_cta( $settings ) {
		if ( 'none' != $settings['price_cta_type'] || ! empty( $settings['footer_additional_info'] ) ) :
			if ( ! empty( $settings['cta_text'] ) || ! empty( $settings['footer_additional_info'] ) || ! empty( $settings['cta_icon'] ) ) :
				?>
				<div class="uael-price-table-cta">
					<?php if ( 'none' != $settings['price_cta_type'] ) : ?>
							<?php $this->render_button( $settings ); ?>
					<?php endif; ?>

					<?php if ( ! empty( $settings['footer_additional_info'] ) ) : ?>
						<div class="uael-price-table-disclaimer elementor-inline-editing" data-elementor-setting-key="footer_additional_info" data-elementor-inline-editing-toolbar="basic"><?php echo $settings['footer_additional_info']; ?></div>
					<?php endif; ?>
				</div>
				<?php
			endif;
		endif;
	}

	/**
	 * Method render_separator
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_separator( $settings ) {
		if ( ! empty( $settings['features_list'] ) ) :
			if ( 'yes' == $settings['pricetable_separator'] && '2' == $settings['pricetable_style'] ) :
				?>
				<div class="uael-separator-parent">
					<div class="uael-separator"></div>
				</div>
			<?php endif; ?>
			<?php
		endif;
	}

	/**
	 * Method render_ribbon
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_ribbon( $settings ) {
		$ribbon_style = '';

		if ( ! empty( $settings['ribbon_title'] ) ) :
			if ( 'none' != $settings['show_ribbon'] ) :
				if ( '1' == $settings['show_ribbon'] ) {
					$ribbon_style = '1';
				} elseif ( '2' == $settings['show_ribbon'] ) {
					$ribbon_style = '2';
				} elseif ( '3' == $settings['show_ribbon'] ) {
					$ribbon_style = '3';
				}

				$this->add_render_attribute( 'ribbon-wrapper', 'class', 'uael-price-table-ribbon-' . $ribbon_style );

				if ( ! empty( $settings['ribbon_horizontal_position'] ) ) :
					$this->add_render_attribute( 'ribbon-wrapper', 'class', 'uael-ribbon-' . $settings['ribbon_horizontal_position'] );
				endif;

				?>
				<div <?php echo $this->get_render_attribute_string( 'ribbon-wrapper' ); ?>>
					<div class="uael-price-table-ribbon-content elementor-inline-editing" data-elementor-setting-key="ribbon_title" data-elementor-inline-editing-toolbar="none"><?php echo $settings['ribbon_title']; ?></div>
				</div>
				<?php
			endif;
		endif;
	}

	/**
	 * Render Price Table output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		ob_start();
		include 'template.php';
		$html = ob_get_clean();
		echo $html;
	}

	/**
	 * Render Price Table widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		function render_heading_text() {
			if ( settings.heading ) {
				if ( '' != settings.heading ) {
					#>
					<div class="uael-price-heading-text">
						<{{ settings.heading_tag }} class="uael-price-table-heading elementor-inline-editing" data-elementor-setting-key="heading" data-elementor-inline-editing-toolbar="basic"> {{{ settings.heading }}}
						</{{ settings.heading_tag }}>
					</div>
					<#
				}
			}
		}
		function render_subheading_text() {
			if ( settings.sub_heading ) {
				if ( '' != settings.sub_heading || '' != settings.sub_heading_style2 ) {
				#>
					<div class="uael-price-subheading-text">

						<# if ( '2' == settings.pricetable_style ) { #>
							<{{ settings.sub_heading_tag_style2 }} class="uael-price-table-subheading elementor-inline-editing" data-elementor-setting-key="sub_heading_style2" data-elementor-inline-editing-toolbar="basic">
								{{{ settings.sub_heading_style2 }}}
							</{{ settings.sub_heading_tag_style2 }}>
						<# } else { #>
							<{{ settings.sub_heading_tag }} class="uael-price-table-subheading elementor-inline-editing" data-elementor-setting-key="sub_heading" data-elementor-inline-editing-toolbar="basic">
								{{{ settings.sub_heading }}}
							</{{ settings.sub_heading_tag }}>
						<# } #>
					</div>
				<#
				}
			}
		}

		function render_style_header() {

			if ( '2' == settings.pricetable_style ) {
				if ( settings.heading ) {
					#>
					<div class="uael-price-table-header">
						<{{{ settings.heading_tag }}} class="uael-price-table-heading elementor-inline-editing" data-elementor-setting-key="heading" data-elementor-inline-editing-toolbar="basic">{{{ settings.heading }}}</{{{ settings.heading_tag }}}>
					</div>
					<#
				}
			} else {
				if ( settings.heading || settings.sub_heading ) {
					#>
					<div class="uael-price-table-header">
						<div class="uael-pricing-heading-wrap">
							<# render_heading_text(); #>
							<# render_subheading_text(); #>
						</div>
					</div>
					<#
				}
			}
		}

		function render_price() {
			var symbol = '';

			var symbols = {
				dollar: '&#36;',
				euro: '&#128;',
				franc: '&#8355;',
				pound: '&#163;',
				ruble: '&#8381;',
				shekel: '&#8362;',
				baht: '&#3647;',
				yen: '&#165;',
				won: '&#8361;',
				guilder: '&fnof;',
				peso: '&#8369;',
				peseta: '&#8359;',
				lira: '&#8356;',
				rupee: '&#8360;',
				indian_rupee: '&#8377;',
				real: 'R$',
				krona: 'kr'
			};

			if ( settings.currency_symbol ) {
				if ( 'custom' !== settings.currency_symbol ) {
					symbol = symbols[ settings.currency_symbol ] || '';
				} else {
					symbol = settings.currency_symbol_custom;
				}
			}

			var currencyFormat = settings.currency_format || '.',
				table_price = settings.price.toString(),
				price = table_price.split( currencyFormat ),
				intvalue = price[0],
				fraction = price[1];

			var	durationText = '<span class="uael-price-table-duration uael-price-typo-excluded elementor-inline-editing" data-elementor-setting-key="duration" data-elementor-inline-editing-toolbar="basic">' + settings.duration + '</span>';
			#>
			<div class="uael-price-table-price-wrap">
				<div class="uael-price-table-pricing">
					<div class="uael-pricing-container">
						<div class="uael-pricing-value">
							<# if ( settings.sale && settings.original_price ) { #>
								<div class="uael-price-table-original-price uael-price-typo-excluded">{{{ symbol + settings.original_price }}}</div>
							<# } #>

							<# if ( '' != symbol && ',' != settings.currency_format) { #>
								<span class="uael-price-table-currency">{{{ symbol }}}</span>
							<# } #>

							<# if ( '' != intvalue ) { #>
								<# if ( '' != symbol && ',' == settings.currency_format) { #>
									<span class="uael-price-currency-normal">{{{ symbol }}}</span>
								<# } #>
								<span class="uael-price-table-integer-part">{{{ intvalue }}}</span>
							<# } #>

							<span class="uael-price-table-beside-price">
								<# if ( '' != fraction ) { #>
									<span class="uael-price-table-fractional-part">{{{ fraction }}}</span>
								<# } #>
								<# if ( settings.duration && 'beside' === settings.duration_position && '3' != settings.pricetable_style ) { #>
									{{{ durationText }}}
								<# } #>
							</span>
						</div>
						<# if ( settings.duration ) { #>
							<# if ( '3' === settings.pricetable_style || 'below' === settings.duration_position ) { #>
								<div class="uael-pricing-duration">
									{{{ durationText }}}
								</div>
							<# } #>
						<# } #>
					</div>
				</div>
			</div>
			<#
		}

		function render_features() {
			if ( settings.features_list ) { #>
				<ul class="uael-price-table-features-list">
					<# _.each( settings.features_list, function( item ) { #>
						<li class="elementor-repeater-item-{{ item._id }}">
							<div class="uael-price-table-feature-content">
								<# if ( item.item_icon ) { #>
									<i class="{{ item.item_icon }}"></i>
								<# } #>
								<# if ( ! _.isEmpty( item.item_text.trim() ) ) { #>
									<span>{{{ item.item_text }}}</span>
								<# } else { #>
									&nbsp;
								<# } #>
							</div>
						</li>
					<# } ); #>
				</ul>
			<# }
		}

		function render_cta() {
			if ( 'none' != settings.price_cta_type || '' != settings.footer_additional_info ) {
				if ( settings.cta_text || settings.cta_icon || settings.footer_additional_info ) { #>
					<div class="uael-price-table-cta">
						<#
						if( 'none' != settings.price_cta_type ) {
							if( 'link' == settings.price_cta_type ) {
								if ( '' != settings.link.url ) {
									view.addRenderAttribute( 'cta_link', 'href', settings.link.url );
									view.addRenderAttribute( 'cta_link', 'class', 'uael-pricebox-cta-link' );
								}
								#>
								<a {{{ view.getRenderAttributeString( 'cta_link' ) }}}>
									<#
									if ( '' != settings.cta_icon && 'left' == settings.cta_icon_position ) {
									#>
										<i class="uael-cta-link-icon uael-cta-link-icon-before fa {{ settings.cta_icon }}"></i>
									<# } #>
									<#
									if ( '' != settings.cta_text ) {
									#>
									<span class="elementor-inline-editing" data-elementor-setting-key="cta_text" data-elementor-inline-editing-toolbar="basic">{{ settings.cta_text }}</span>
									<# } #>
									<#
									if ( '' != settings.cta_icon && 'right' == settings.cta_icon_position ) {
									#>
										<i class="uael-cta-link-icon uael-cta-link-icon-after fa {{ settings.cta_icon }}"></i>
									<# } #>
								</a>
								<#
							}

							if( 'button' == settings.price_cta_type ) {
								view.addRenderAttribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );

								if ( '' != settings.link.url ) {
									view.addRenderAttribute( 'button', 'href', settings.link.url );
									view.addRenderAttribute( 'button', 'class', 'elementor-button-link' );
								}

								view.addRenderAttribute( 'button', 'class', 'elementor-button' );

								if ( '' != settings.button_size ) {
									view.addRenderAttribute( 'button', 'class', 'elementor-size-' + settings.button_size );
								}

								if ( settings.button_hover_animation ) {
									view.addRenderAttribute( 'button', 'class', 'elementor-animation-' + settings.button_hover_animation );
								}

								#>
								<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
									<a {{{ view.getRenderAttributeString( 'button' ) }}}>
										<#
										view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );

										view.addRenderAttribute( 'text', 'class', 'elementor-inline-editing' );
										#>
										<#
										if ( '' != settings.cta_icon && 'left' == settings.cta_icon_position ) {
										#>
											<i class="uael-cta-link-icon uael-cta-link-icon-before fa {{ settings.cta_icon }}"></i>
										<# } #>
										<#
											if ( '' != settings.cta_text ) {
										#>
										<span {{{ view.getRenderAttributeString( 'text' ) }}} data-elementor-setting-key="cta_text" data-elementor-inline-editing-toolbar="none">{{{ settings.cta_text }}}</span>
										<# } #>
										<#
										if ( '' != settings.cta_icon && 'right' == settings.cta_icon_position ) {
										#>
											<i class="uael-cta-link-icon uael-cta-link-icon-after fa {{ settings.cta_icon }}"></i>
										<# } #>
									</a>
								</div>
							<# } #>
						<# } #>
						<# if ( settings.footer_additional_info ) { #>
							<div class="uael-price-table-disclaimer elementor-inline-editing" data-elementor-setting-key="footer_additional_info" data-elementor-inline-editing-toolbar="basic">{{{ settings.footer_additional_info }}}</div>
						<# } #>
					</div>
				<# }
			}
		}

		function render_separator() {
			if ( settings.features_list ) {
				if ( 'yes' == settings.pricetable_separator && '2' == settings.pricetable_style ) {
				#>
					<div class="uael-separator-parent">
						<div class="uael-separator"></div>
					</div>
				<# }
			}
		}

		function render_ribbon() {
		var ribbon_style = '';
		if ( '' != settings.ribbon_title ) {
			if ( 'none' != settings.show_ribbon ) {

				if ( '1' == settings.show_ribbon ) {
					ribbon_style = '1';
				} else if ( '2' == settings.show_ribbon ) {
					ribbon_style = '2';
				} else if ( '3' == settings.show_ribbon ) {
					ribbon_style = '3';
				}
				var ribbonClass = '';

				if ( settings.ribbon_horizontal_position ) {
					ribbonClass = 'uael-ribbon-' + settings.ribbon_horizontal_position;
				} #>
				<div class="uael-price-table-ribbon-{{ ribbon_style }} {{ ribbonClass }}">
					<div class="uael-price-table-ribbon-content elementor-inline-editing" data-elementor-setting-key="ribbon_title" data-elementor-inline-editing-toolbar="none">{{{ settings.ribbon_title }}}</div>
				</div>
			<# }
			}
		}
		#>

		<#
		if ( '1' == settings.pricetable_style ) { #>
			<div class="uael-module-content uael-price-table-container uael-pricing-style-{{ settings.pricetable_style }}">
				<div class="uael-price-table">
					<# render_style_header(); #>
					<# render_price(); #>
					<# render_features(); #>
					<# render_cta(); #>
				</div>
				<# render_ribbon(); #>
			</div>
		<# } else if ( '2' == settings.pricetable_style ) { #>
			<div class="uael-module-content uael-price-table-container uael-pricing-style-{{ settings.pricetable_style }}">
				<div class="uael-price-table">
					<# render_style_header(); #>
					<# render_price(); #>
					<# render_subheading_text(); #>
					<# render_cta(); #>
					<# render_separator(); #>
					<# render_features(); #>
				</div>
				<# render_ribbon(); #>
			</div>
		<# } else if ( '3' == settings.pricetable_style ) { #>
			<div class="uael-module-content uael-price-table-container uael-pricing-style-{{ settings.pricetable_style }}">
				<div class="uael-price-table">
					<# render_style_header(); #>
					<# render_price(); #>
					<# render_features(); #>
					<# render_cta(); #>
				</div>
				<# render_ribbon(); #>
			</div>
		<# }

		#>
		<?php
	}
}

