<?php
/**
 * UAEL WooCommerce Products.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Modules\Woocommerce\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Woo_Products.
 */
class Woo_Products extends Common_Widget {

	/**
	 * Products Query
	 *
	 * @var query
	 */
	private $query = null;

	/**
	 * Has Template content
	 *
	 * @var _has_template_content
	 */
	protected $_has_template_content = false;

	/**
	 * Retrieve Woo Product Grid Widget name.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Woo_Products' );
	}

	/**
	 * Retrieve Woo Product Grid Widget title.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Woo_Products' );
	}

	/**
	 * Retrieve Woo Product Grid Widget icon.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Woo_Products' );
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
		return parent::get_widget_keywords( 'Woo_Products' );
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
		return [ 'imagesloaded', 'jquery-slick', 'uael-woocommerce' ];
	}

	/**
	 * Register Register Skins.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_skins() {
		$this->add_skin( new Skins\Skin_Grid_Default( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Franko( $this ) );
	}

	/**
	 * Register Woo Product Grid controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		/* General Tab */
		$this->register_content_general_controls();
		$this->register_content_grid_controls();
		$this->register_content_slider_controls();
		$this->register_content_filter_controls();
		$this->register_content_pagination_controls();

		/* Style Tab */
		$this->register_style_layout_controls();
		$this->register_style_image_controls();
		$this->register_style_pagination_controls();
		$this->register_style_navigation_controls();

		$this->register_helpful_information();
	}

	/**
	 * Register Woo Products General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_general_controls() {

		$this->start_controls_section(
			'section_general_field',
			[
				'label' => __( 'General', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'products_layout_type',
				[
					'label'     => __( 'Layout', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'grid',
					'options'   => [
						'grid'   => __( 'Grid', 'uael' ),
						'slider' => __( 'Carousel', 'uael' ),
					],
					'condition' => [
						'_skin' => [ 'grid-default', 'grid-franko' ],
					],
				]
			);
		$this->end_controls_section();
	}

	/**
	 * Render query type list.
	 *
	 * @since 0.0.1
	 * @return array Array of query type
	 * @access public
	 */
	public function get_query_type() {
		$query_type = array(
			'all'    => __( 'All Products', 'uael' ),
			'custom' => __( 'Custom Query', 'uael' ),
			'manual' => __( 'Manual Selection', 'uael' ),
			'main'   => __( 'Main Query', 'uael' ),
		);

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$query_type['related'] = __( 'Related Products', 'uael' );
		}

		return $query_type;
	}

	/**
	 * Register Woo Products Filter Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_filter_controls() {

		$this->start_controls_section(
			'section_filter_field',
			[
				'label' => __( 'Query', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'query_type',
				[
					'label'   => __( 'Source', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'all',
					'options' => $this->get_query_type(),
				]
			);

			$this->add_control(
				'category_filter_rule',
				[
					'label'     => __( 'Category Filter Rule', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'IN',
					'options'   => [
						'IN'     => __( 'Match Categories', 'uael' ),
						'NOT IN' => __( 'Exclude Categories', 'uael' ),
					],
					'condition' => [
						'query_type'  => 'custom',
						'query_type!' => 'related',
					],
				]
			);
			$this->add_control(
				'category_filter',
				[
					'label'     => __( 'Select Categories', 'uael' ),
					'type'      => Controls_Manager::SELECT2,
					'multiple'  => true,
					'default'   => '',
					'options'   => $this->get_product_categories(),
					'condition' => [
						'query_type'  => 'custom',
						'query_type!' => 'related',
					],
				]
			);
			$this->add_control(
				'tag_filter_rule',
				[
					'label'     => __( 'Tag Filter Rule', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'IN',
					'options'   => [
						'IN'     => __( 'Match Tags', 'uael' ),
						'NOT IN' => __( 'Exclude Tags', 'uael' ),
					],
					'condition' => [
						'query_type'  => 'custom',
						'query_type!' => 'related',
					],
				]
			);
			$this->add_control(
				'tag_filter',
				[
					'label'     => __( 'Select Tags', 'uael' ),
					'type'      => Controls_Manager::SELECT2,
					'multiple'  => true,
					'default'   => '',
					'options'   => $this->get_product_tags(),
					'condition' => [
						'query_type'  => 'custom',
						'query_type!' => 'related',
					],
				]
			);
			$this->add_control(
				'offset',
				[
					'label'       => __( 'Offset', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 0,
					'description' => __( 'Number of post to displace or pass over.', 'uael' ),
					'condition'   => [
						'query_type'  => 'custom',
						'query_type!' => 'related',
					],
				]
			);

			$this->add_control(
				'query_manual_ids',
				[
					'label'     => __( 'Select Products', 'uael' ),
					'type'      => 'uael-query-posts',
					'post_type' => 'product',
					'multiple'  => true,
					'condition' => [
						'query_type'  => 'manual',
						'query_type!' => 'related',
					],
				]
			);

			/* Exclude */
			$this->add_control(
				'query_exclude',
				[
					'label'     => __( 'Exclude', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'query_type!' => [ 'manual', 'main', 'related' ],
					],
				]
			);
			$this->add_control(
				'query_exclude_ids',
				[
					'label'       => __( 'Select Products', 'uael' ),
					'type'        => 'uael-query-posts',
					'post_type'   => 'product',
					'multiple'    => true,
					'description' => __( 'Select products to exclude from the query.', 'uael' ),
					'condition'   => [
						'query_type!' => [ 'manual', 'main', 'related' ],
					],
				]
			);
			$this->add_control(
				'query_exclude_current',
				[
					'label'        => __( 'Exclude Current Product', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'description'  => __( 'Enable this option to remove current product from the query.', 'uael' ),
					'condition'    => [
						'query_type!' => [ 'manual', 'main', 'related' ],
					],
				]
			);

			/* Advanced Filter */
			$this->add_control(
				'query_advanced',
				[
					'label'     => __( 'Advanced', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'query_type!' => [ 'main', 'related' ],
					],
				]
			);
			$this->add_control(
				'filter_by',
				[
					'label'     => __( 'Filter By', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''         => __( 'None', 'uael' ),
						'featured' => __( 'Featured', 'uael' ),
						'sale'     => __( 'Sale', 'uael' ),
					],
					'condition' => [
						'query_type!' => [ 'main', 'related' ],
					],
				]
			);
			$this->add_control(
				'orderby',
				[
					'label'     => __( 'Order by', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'date',
					'options'   => [
						'date'       => __( 'Date', 'uael' ),
						'title'      => __( 'Title', 'uael' ),
						'price'      => __( 'Price', 'uael' ),
						'popularity' => __( 'Popularity', 'uael' ),
						'rating'     => __( 'Rating', 'uael' ),
						'rand'       => __( 'Random', 'uael' ),
						'menu_order' => __( 'Menu Order', 'uael' ),
					],
					'condition' => [
						'query_type!' => [ 'main', 'related' ],
					],
				]
			);
			$this->add_control(
				'order',
				[
					'label'     => __( 'Order', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'desc',
					'options'   => [
						'desc' => __( 'Descending', 'uael' ),
						'asc'  => __( 'Ascending', 'uael' ),
					],
					'condition' => [
						'query_type!' => [ 'main', 'related' ],
					],
				]
			);

			$this->add_control(
				'noproducts_heading',
				[
					'label'     => __( 'If Products Not Found', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'no_results_text',
				[
					'label'       => __( 'Display Message', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'default'     => __( 'No products were found matching your selection.', 'uael' ),
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Pagination Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_pagination_controls() {

		$this->start_controls_section(
			'section_pagination_field',
			[
				'label'     => __( 'Pagination', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'grid',
				],
			]
		);

			$this->add_control(
				'pagination_type',
				[
					'label'     => __( 'Type', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''              => __( 'None', 'uael' ),
						'numbers'       => __( 'Numbers', 'uael' ),
						'numbers_arrow' => __( 'Numbers + Pre/Next Arrow', 'uael' ),
					],
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
					],
				]
			);

			$this->add_control(
				'pagination_prev_label',
				[
					'label'     => __( 'Previous Label', 'uael' ),
					'default'   => __( '←', 'uael' ),
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
						'pagination_type'      => 'numbers_arrow',
					],
				]
			);

			$this->add_control(
				'pagination_next_label',
				[
					'label'     => __( 'Next Label', 'uael' ),
					'default'   => __( '→', 'uael' ),
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
						'pagination_type'      => 'numbers_arrow',
					],
				]
			);

			$this->add_responsive_control(
				'pagination_align',
				[
					'label'        => __( 'Alignment', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
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
					'default'      => 'center',
					'prefix_class' => 'uael-woo-pagination%s-align-',
					'condition'    => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
						'pagination_type!'     => '',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register grid Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_grid_controls() {
		$this->start_controls_section(
			'section_grid_options',
			[
				'label'     => __( 'Grid Options', 'uael' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'grid',
				],
			]
		);
			$this->add_responsive_control(
				'products_columns',
				[
					'label'          => __( 'Columns', 'uael' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => '4',
					'tablet_default' => '3',
					'mobile_default' => '1',
					'options'        => [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
					'condition'      => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
					],
				]
			);

			$this->add_control(
				'products_per_page',
				[
					'label'     => __( 'Products Per Page', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => '8',
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
						'query_type!'          => 'main',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Slider Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_slider_controls() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label'     => __( 'Slider Options', 'uael' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'     => __( 'Navigation', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'both',
				'options'   => [
					'both'   => __( 'Arrows and Dots', 'uael' ),
					'arrows' => __( 'Arrows', 'uael' ),
					'dots'   => __( 'Dots', 'uael' ),
					'none'   => __( 'None', 'uael' ),
				],
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'slider_products_per_page',
			[
				'label'     => __( 'Total Products', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '8',
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'query_type!'          => 'main',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'          => __( 'Products to Show', 'uael' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 4,
				'tablet_default' => 3,
				'mobile_default' => 1,
				'condition'      => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label'          => __( 'Products to Scroll', 'uael' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'condition'      => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => __( 'Autoplay', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);
		$this->add_control(
			'autoplay_speed',
			[
				'label'     => __( 'Autoplay Speed', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'selectors' => [
					'{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
				],
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'autoplay'             => 'yes',
				],
			]
		);
		$this->add_control(
			'pause_on_hover',
			[
				'label'        => __( 'Pause on Hover', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'autoplay'             => 'yes',
				],
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'        => __( 'Infinite Loop', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label'     => __( 'Transition Speed (ms)', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab
	 */
	/**
	 * Register Layout Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_layout_controls() {
		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => __( 'Layout', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'     => __( 'Columns Gap', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 20,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce li.product' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'{{WRAPPER}} .uael-woocommerce ul.products' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'     => __( 'Rows Gap', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 35,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woocommerce li.product' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'grid',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'product_box_shadow',
				'selector' => '{{WRAPPER}} .uael-woo-product-wrapper',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'product_border',
				'label'     => __( 'Border', 'uael' ),
				'selector'  => '{{WRAPPER}} .uael-woo-product-wrapper',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Image Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_image_controls() {
		$this->start_controls_section(
			'section_design_image',
			[
				'label' => __( 'Image', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'products_hover_style',
				[
					'label'   => __( 'Image Hover Style', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''     => __( 'None', 'uael' ),
						'swap' => __( 'Swap Images', 'uael' ),
						'zoom' => __( 'Zoom Image', 'uael' ),
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Pagination Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_pagination_controls() {

		$this->start_controls_section(
			'section_design_pagination',
			[
				'label'     => __( 'Pagination', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				],
			]
		);

		$this->start_controls_tabs( 'pagination_tabs_style' );

			$this->start_controls_tab(
				'pagination_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
						'pagination_type!'     => '',
					],
				]
			);

				$this->add_control(
					'pagination_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} nav.uael-woocommerce-pagination ul li > .page-numbers' => 'color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'grid',
							'pagination_type!'     => '',
						],
					]
				);

				$this->add_control(
					'pagination_background_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} nav.uael-woocommerce-pagination ul li > .page-numbers' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'grid',
							'pagination_type!'     => '',
						],
					]
				);

				$this->add_control(
					'pagination_border_color',
					[
						'label'     => __( 'Border Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers, {{WRAPPER}} nav.uael-woocommerce-pagination ul li span.current' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'grid',
							'pagination_type!'     => '',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'pagination_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'grid',
						'pagination_type!'     => '',
					],
				]
			);

				$this->add_control(
					'pagination_hover_color',
					[
						'label'     => __( 'Text Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers:focus, {{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers:hover, {{WRAPPER}} nav.uael-woocommerce-pagination ul li span.current' => 'color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'grid',
							'pagination_type!'     => '',
						],
					]
				);

				$this->add_control(
					'pagination_background_hover_color',
					[
						'label'     => __( 'Background Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers:focus, {{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers:hover, {{WRAPPER}} nav.uael-woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'grid',
							'pagination_type!'     => '',
						],
					]
				);

				$this->add_control(
					'pagination_border_hover_color',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers:focus, {{WRAPPER}} nav.uael-woocommerce-pagination ul li .page-numbers:hover, {{WRAPPER}} nav.uael-woocommerce-pagination ul li span.current' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'grid',
							'pagination_type!'     => '',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'pagination_typography',
				'selector'  => '{{WRAPPER}} nav.uael-woocommerce-pagination ul li > .page-numbers',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				],

			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Navigation Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_navigation_controls() {
		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label'     => __( 'Arrows', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'        => __( 'Position', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'outside',
				'options'      => [
					'inside'  => __( 'Inside', 'uael' ),
					'outside' => __( 'Outside', 'uael' ),
				],
				'prefix_class' => 'uael-woo-slider-arrow-',
				'condition'    => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_style',
			[
				'label'        => __( 'Style', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'circle',
				'options'      => [
					''       => __( 'Default', 'uael' ),
					'circle' => __( 'Circle', 'uael' ),
					'square' => __( 'Square', 'uael' ),
				],
				'prefix_class' => 'uael-woo-slider-arrow-',
				'condition'    => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woo-products-slider .slick-slider .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'arrows', 'both' ],
				],
			]
		);

		$this->start_controls_tabs( 'arrow_tabs_style' );
			$this->start_controls_tab(
				'arrow_style_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'slider',
						'navigation'           => [ 'arrows', 'both' ],
					],
				]
			);
				$this->add_control(
					'arrows_color',
					[
						'label'     => __( 'Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-woo-products-slider .slick-slider .slick-arrow' => 'color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'slider',
							'navigation'           => [ 'arrows', 'both' ],
						],
					]
				);
				$this->add_control(
					'arrows_bg_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-woo-products-slider .slick-slider .slick-arrow' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'slider',
							'navigation'           => [ 'arrows', 'both' ],
							'arrows_style'         => [ 'circle', 'square' ],
						],
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'arrow_style_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						'_skin'                => [ 'grid-default', 'grid-franko' ],
						'products_layout_type' => 'slider',
						'navigation'           => [ 'arrows', 'both' ],
					],
				]
			);
				$this->add_control(
					'arrows_hover_color',
					[
						'label'     => __( 'Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-woo-products-slider .slick-slider .slick-arrow:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'slider',
							'navigation'           => [ 'arrows', 'both' ],
						],
					]
				);
				$this->add_control(
					'arrows_hover_bg_color',
					[
						'label'     => __( 'Background Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-woo-products-slider .slick-slider .slick-arrow:hover' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'_skin'                => [ 'grid-default', 'grid-franko' ],
							'products_layout_type' => 'slider',
							'navigation'           => [ 'arrows', 'both' ],
							'arrows_style'         => [ 'circle', 'square' ],
						],
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'heading_style_dots',
			[
				'label'     => __( 'Dots', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-woo-products-slider .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-woo-products-slider .slick-dots li button:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'_skin'                => [ 'grid-default', 'grid-franko' ],
					'products_layout_type' => 'slider',
					'navigation'           => [ 'dots', 'both' ],
				],
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/woo-products/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_9',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=NovIe5b2EkQ&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc&index=9" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to display products in Carousel / Grid? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-grid-and-carousel-layout-for-woocommerce-products/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to use Query Builder? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-display-exact-woocommerce-product-with-query-builder/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to exclude / hide particular product from view? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-exclude-woocommerce-products-with-woo-products-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to enable Quick View? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-enable-quick-view-for-woocommerce-products/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Availble Filters & Actions » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/filters-actions-for-woocommerce-products/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_7',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to set featured products? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-featured-products-in-woocommerce/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_8',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Carousel does not display correctly » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/woo-products-carousel-does-not-display-correctly/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Get WooCommerce Product Categories.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function get_product_categories() {

		$product_cat = array();

		$cat_args = array(
			'orderby'    => 'name',
			'order'      => 'asc',
			'hide_empty' => false,
		);

		$product_categories = get_terms( 'product_cat', $cat_args );

		if ( ! empty( $product_categories ) ) {

			foreach ( $product_categories as $key => $category ) {

				$product_cat[ $category->slug ] = $category->name;
			}
		}

		return $product_cat;
	}

	/**
	 * Get WooCommerce Product Tags.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function get_product_tags() {

		$product_tag = array();

		$tag_args = array(
			'orderby'    => 'name',
			'order'      => 'asc',
			'hide_empty' => false,
		);

		$terms = get_terms( 'product_tag', $tag_args );

		if ( ! empty( $terms ) ) {

			foreach ( $terms as $key => $tag ) {

				$product_tag[ $tag->slug ] = $tag->name;
			}
		}

		return $product_tag;
	}
}
