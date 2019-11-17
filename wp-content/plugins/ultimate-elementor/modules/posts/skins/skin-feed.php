<?php
/**
 * UAEL Feed Skin.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Modules\Posts\TemplateBlocks\Skin_Init;
use UltimateElementor\Classes\UAEL_Posts_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Skin_Feed
 */
class Skin_Feed extends Skin_Base {

	/**
	 * Get Skin Slug.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function get_id() {
		return 'feed';
	}

	/**
	 * Get Skin Title.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function get_title() {
		return __( 'Creative Feed', 'uael' );
	}

	/**
	 * Register controls on given actions.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		parent::_register_controls_actions();

		add_action( 'elementor/element/uael-posts/feed_section_general_field/before_section_end', [ $this, 'register_update_general_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_image_field/before_section_end', [ $this, 'register_update_image_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_design_blog/before_section_end', [ $this, 'register_blog_design_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_design_layout/before_section_end', [ $this, 'register_update_layout_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_meta_field/before_section_end', [ $this, 'register_update_meta_field_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_cta_field/before_section_end', [ $this, 'register_update_cta_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_meta_style/before_section_end', [ $this, 'register_update_meta_styles_controls' ] );

		add_action( 'elementor/element/uael-posts/feed_section_title_style/before_section_end', [ $this, 'register_update_title_styles_controls' ] );
	}

	/**
	 * Register controls callback.
	 *
	 * @param Widget_Base $widget Current Widget object.
	 * @since 1.7.0
	 * @access public
	 */
	public function register_sections( Widget_Base $widget ) {

		$this->parent = $widget;

		// Content Controls.
		$this->register_content_filters_controls();
		$this->register_content_slider_controls();
		$this->register_content_featured_controls();
		$this->register_content_image_controls();
		$this->register_content_title_controls();
		$this->register_content_meta_controls();
		$this->register_content_badge_controls();
		$this->register_content_excerpt_controls();
		$this->register_content_cta_controls();

		// Style Controls.
		$this->register_style_layout_controls();
		$this->register_style_blog_controls();
		$this->register_style_pagination_controls();
		$this->register_style_featured_controls();
		$this->register_style_title_controls();
		$this->register_style_meta_controls();
		$this->register_style_term_controls();
		$this->register_style_excerpt_controls();
		$this->register_style_cta_controls();
		$this->register_style_navigation_controls();
	}

	/**
	 * Register Posts Filter Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_filters_controls() {

		$this->start_controls_section(
			'section_filter_masonry',
			[
				'label'     => __( 'Filterable Tabs', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'query_type' => 'custom',
				],
			]
		);

			$this->add_control(
				'show_filters',
				[
					'label'        => __( 'Show Filters', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'query_type' => 'custom',
					],
				]
			);

		$post_types = UAEL_Posts_Helper::get_post_types();

		foreach ( $post_types as $key => $type ) {

			// Get all the taxanomies associated with the post type.
			$taxonomy = UAEL_Posts_Helper::get_taxonomy( $key );

			if ( ! empty( $taxonomy ) ) {

				$related_tax = [];

				// Get all taxonomy values under the taxonomy.
				foreach ( $taxonomy as $index => $tax ) {

					$terms = get_terms( $index );

					$related_tax[ $index ] = $tax->label;
				}

				// Add control for all taxonomies.
				$this->add_control(
					'tax_masonry_' . $key . '_filter',
					[
						'label'     => __( 'Filter By', 'uael' ),
						'type'      => Controls_Manager::SELECT,
						'options'   => $related_tax,
						'default'   => array_keys( $related_tax )[0],
						'condition' => [
							'post_type_filter' => $key,
							'query_type'       => 'custom',
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
						'separator' => 'before',
					]
				);
			}
		}

		$this->add_control(
			'filters_all_text',
			[
				'label'     => __( '"All" Tab Label', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'All', 'uael' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'query_type' => 'custom',
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'default_filter_switch',
			[
				'label'        => __( 'Default Tab on Page Load', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'label_off'    => __( 'First', 'uael' ),
				'label_on'     => __( 'Custom', 'uael' ),
				'condition'    => [
					'query_type' => 'custom',
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'default_filter',
			[
				'label'     => __( 'Enter Category Name', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => [
					'query_type' => 'custom',
					$this->get_control_id( 'show_filters' ) => 'yes',
					$this->get_control_id( 'default_filter_switch' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'tabs_dropdown',
			[
				'label'        => __( 'Responsive Support', 'uael' ),
				'description'  => __( 'Enable this option to display Filterable Tabs in a Dropdown on Mobile.', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'condition'    => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_alignment',
			[
				'label'        => __( 'Alignment', 'uael' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'render_type'  => 'template',
				'prefix_class' => 'uael-post__filter-align-',
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
				'separator'    => 'before',
				'selectors'    => [
					'{{WRAPPER}} .uael-post__header-filters' => 'text-align: {{VALUE}};',
					'(mobile){{WRAPPER}} .uael-posts-tabs-dropdown .uael-filters-dropdown' => 'text-align: {{VALUE}};',
				],
				'condition'    => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'filter_tabs_style' );

			$this->start_controls_tab(
				'filter_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_filters' ) => 'yes',
					],
				]
			);

				$this->add_control(
					'filter_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-posts-tabs-dropdown .uael-filters-dropdown-button,{{WRAPPER}} .uael-post__header-filter' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
					]
				);

				$this->add_control(
					'filter_background_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-posts-tabs-dropdown .uael-filters-dropdown-button,{{WRAPPER}} .uael-post__header-filter' => 'background-color: {{VALUE}};',
						],
						'default'   => '#e4e4e4',
						'condition' => [
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'filter_border',
						'label'     => __( 'Border', 'uael' ),
						'selector'  => '{{WRAPPER}} .uael-posts-tabs-dropdown .uael-filters-dropdown-button,{{WRAPPER}} .uael-post__header-filter',
						'condition' => [
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'filter_active',
				[
					'label'     => __( 'Active', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_filters' ) => 'yes',
					],
				]
			);

				$this->add_control(
					'filter_active_color',
					[
						'label'     => __( 'Text Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .uael-post__header-filter.uael-filter__current, {{WRAPPER}} .uael-post__header-filters .uael-post__header-filter:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
					]
				);

				$this->add_control(
					'filter_background_active_color',
					[
						'label'     => __( 'Background Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-post__header-filters .uael-post__header-filter.uael-filter__current, {{WRAPPER}} .uael-post__header-filters .uael-post__header-filter:hover' => 'background-color: {{VALUE}};',
						],
						'default'   => '#333333',
						'condition' => [
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
					]
				);

				$this->add_control(
					'filter_active_border_color',
					[
						'label'     => __( 'Border Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-post__header-filter.uael-filter__current, {{WRAPPER}} .uael-post__header-filter:hover' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_filters' ) => 'yes',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'filter_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => [
					'{{WRAPPER}} .uael-posts-tabs-dropdown .uael-filters-dropdown-button, {{WRAPPER}} .uael-post__header-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'(mobile){{WRAPPER}} .uael-posts-tabs-dropdown .uael-post__header-filter' => 'border-radius: 0px;',
				],
				'condition'  => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'filter_padding',
			[
				'label'      => __( 'Filter Tab Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__header-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => 4,
					'bottom' => 4,
					'left'   => 14,
					'right'  => 14,
					'unit'   => 'px',
				],
				'condition'  => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'filter_inner_padding',
			[
				'label'     => __( 'Spacing Between Tabs', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 5,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__header-filter' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-post__header-filter:last-child' => 'margin-right: 0;',
					'(mobile){{WRAPPER}} .uael-posts-tabs-dropdown .uael-post__header-filter' => 'margin-right: 0px; margin-bottom: 0px;',
				],
				'condition' => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'filter_bottom_padding',
			[
				'label'     => __( 'Filter Bottom Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__header-filters' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .uael-posts-tabs-dropdown .uael-post__header-filters' => 'padding-bottom: 0px;',
				],
				'condition' => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_separator_width',
			[
				'label'     => __( 'Filter Separator', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__header-filters' => 'border-bottom: {{SIZE}}{{UNIT}} solid #B7B7BF;',
					'(mobile){{WRAPPER}} .uael-posts-tabs-dropdown .uael-post__header-filters' => 'border: 0px solid;',
				],
				'condition' => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_separator_color',
			[
				'label'     => __( 'Filter Separator Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-post__header-filters' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'filter_typography',
				'selector'  => '{{WRAPPER}} .uael-posts-tabs-dropdown .uael-filters-dropdown-button,{{WRAPPER}} .uael-post__header-filter',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					$this->get_control_id( 'show_filters' ) => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Pagination Controls.
	 *
	 * @since 1.7.2
	 * @access public
	 */
	public function register_style_pagination_controls() {

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => __( 'Pagination', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'pagination' ) => [ 'numbers', 'infinite' ],
				],
			]
		);

			$this->add_control(
				'infinite_notice',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'Note: Infinite Load is prevented at the backend. You can see it working in the frontend.', 'uael' ),
					'condition'       => [
						$this->get_control_id( 'pagination' ) => 'infinite',
					],
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'load_more_text',
				[
					'label'     => __( '"Load More" Label', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => __( 'Load More', 'uael' ),
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'infinite',
						$this->get_control_id( 'infinite_event' ) => 'click',
					],
				]
			);

			$this->add_control(
				'pagination_alignment',
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
						'{{WRAPPER}} .uael-grid-pagination' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						$this->get_control_id( 'pagination' ) => 'numbers',
					],
				]
			);

			$this->add_control(
				'infinite_btn_alignment',
				[
					'label'     => __( 'Alignment', 'uael' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
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
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .uael-post__load-more-wrap' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'infinite',
						$this->get_control_id( 'infinite_event' ) => 'click',
					],
					'separator' => 'after',
				]
			);

			$this->add_control(
				'pagination_style',
				[
					'label'     => __( 'Pagination Style', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'flat',
					'separator' => 'before',
					'options'   => [
						'flat'        => __( 'Flat', 'uael' ),
						'transparent' => __( 'Transparent', 'uael' ),
					],
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'numbers',
					],
				]
			);

		$this->start_controls_tabs( 'pagination_tabs_style' );

			$this->start_controls_tab(
				'pagination_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'numbers',
					],
				]
			);

				$this->add_control(
					'pagination_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination a.page-numbers' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'numbers',
						],
					]
				);

				$this->add_control(
					'pagination_background_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f6f6f6',
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination a.page-numbers' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'pagination' => 'numbers',
							$this->get_control_id( 'pagination_style' ) => 'flat',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'pagination_border',
						'label'     => __( 'Border', 'uael' ),
						'selector'  => '{{WRAPPER}} .uael-grid-pagination a.page-numbers, {{WRAPPER}} .uael-grid-pagination span.page-numbers.current',
						'condition' => [
							$this->get_control_id( 'pagination' )        => 'numbers',
							$this->get_control_id( 'pagination_style!' ) => 'flat',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'pagination_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'numbers',
					],
				]
			);

				$this->add_control(
					'pagination_hover_color',
					[
						'label'     => __( 'Text Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'numbers',
						],
					]
				);

				$this->add_control(
					'pagination_background_hover_color',
					[
						'label'     => __( 'Background Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f6f6f6',
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination a.page-numbers:hover' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' )       => 'numbers',
							$this->get_control_id( 'pagination_style' ) => 'flat',
						],
					]
				);

				$this->add_control(
					'pagination_hover_border_color',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination a.page-numbers:hover' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' )        => 'numbers',
							$this->get_control_id( 'pagination_style!' ) => 'flat',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'pagination_active',
				[
					'label'     => __( 'Active', 'uael' ),
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'numbers',
					],
				]
			);

				$this->add_control(
					'pagination_active_color',
					[
						'label'     => __( 'Text Active Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination span.page-numbers.current' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'numbers',
						],
					]
				);

				$this->add_control(
					'pagination_background_active_color',
					[
						'label'     => __( 'Background Active Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination span.page-numbers.current' => 'background-color: {{VALUE}};',
						],
						'default'   => '#e2e2e2',
						'condition' => [
							$this->get_control_id( 'pagination' )       => 'numbers',
							$this->get_control_id( 'pagination_style' ) => 'flat',
						],
					]
				);

				$this->add_control(
					'pagination_active_border_color',
					[
						'label'     => __( 'Border Active Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-grid-pagination span.page-numbers.current' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' )        => 'numbers',
							$this->get_control_id( 'pagination_style!' ) => 'flat',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'pagination_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .uael-grid-pagination a.page-numbers, {{WRAPPER}} .uael-grid-pagination span.page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					$this->get_control_id( 'pagination' ) => 'numbers',
				],
			]
		);

		$this->add_control(
			'pagination_box_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .uael-grid-pagination a.page-numbers, {{WRAPPER}} .uael-grid-pagination span.page-numbers.current' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					$this->get_control_id( 'pagination' ) => 'numbers',
				],
			]
		);

		$this->add_control(
			'pagination_box_margin',
			[
				'label'     => __( 'Page Number Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-grid-pagination a.page-numbers, {{WRAPPER}} .uael-grid-pagination span.page-numbers.current' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-grid-pagination .page-numbers:last-child' => 'margin-right: 0;',
				],
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'numbers',
				],
			]
		);

		$this->start_controls_tabs( 'infinite_btn_tabs_style' );

			$this->start_controls_tab(
				'infinite_btn_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'infinite',
						$this->get_control_id( 'infinite_event' ) => 'click',
					],
				]
			);

				$this->add_control(
					'infinite_btn_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-post__load-more' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'infinite',
							$this->get_control_id( 'infinite_event' ) => 'click',
						],
					]
				);

				$this->add_control(
					'infinite_btn_background_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-post__load-more' => 'background-color: {{VALUE}};',
						],
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'infinite',
							$this->get_control_id( 'infinite_event' ) => 'click',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'infinite_btn_border',
						'label'     => __( 'Border', 'uael' ),
						'selector'  => '{{WRAPPER}} .uael-post__load-more',
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'infinite',
							$this->get_control_id( 'infinite_event' ) => 'click',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'infinite_btn_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'infinite',
						$this->get_control_id( 'infinite_event' ) => 'click',
					],
				]
			);

				$this->add_control(
					'infinite_btn_hover_color',
					[
						'label'     => __( 'Text Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-post__load-more:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'infinite',
							$this->get_control_id( 'infinite_event' ) => 'click',
						],
					]
				);

				$this->add_control(
					'infinite_btn_background_hover_color',
					[
						'label'     => __( 'Background Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-post__load-more:hover' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'infinite',
							$this->get_control_id( 'infinite_event' ) => 'click',
						],
					]
				);

				$this->add_control(
					'infinite_btn_hover_border_color',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-post__load-more:hover' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'pagination' ) => 'infinite',
							$this->get_control_id( 'infinite_event' ) => 'click',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'infinite_btn_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => [
					'{{WRAPPER}} .uael-post__load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					$this->get_control_id( 'pagination' ) => 'infinite',
					$this->get_control_id( 'infinite_event' ) => 'click',
				],
			]
		);

		$this->add_control(
			'infinite_btn_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => 10,
					'bottom' => 10,
					'left'   => 10,
					'right'  => 10,
					'unit'   => 'px',
				],
				'condition'  => [
					$this->get_control_id( 'pagination' ) => 'infinite',
					$this->get_control_id( 'infinite_event' ) => 'click',
				],
			]
		);

		$this->add_control(
			'loader_notice',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Note: This Loader is visible only when user clicks on Load More button.', 'uael' ),
				'condition'       => [
					$this->get_control_id( 'pagination' ) => 'infinite',
					$this->get_control_id( 'infinite_event' ) => 'click',
				],
				'content_classes' => 'uael-editor-doc',
				'separator'       => 'before',
			]
		);

		$this->add_control(
			'loader_color',
			[
				'label'     => __( 'Loader Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post-inf-loader > div' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'infinite',
				],
			]
		);

		$this->add_control(
			'loader_size',
			[
				'label'     => __( 'Loader Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 5,
					],
				],
				'default'   => [
					'size' => 18,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post-inf-loader > div' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'infinite',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'load_more_pagination_typography',
				'selector'  => '{{WRAPPER}} .uael-post__load-more',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'infinite',
					$this->get_control_id( 'infinite_event' ) => 'click',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'pagination_typography',
				'selector'  => '{{WRAPPER}} .uael-grid-pagination a.page-numbers, {{WRAPPER}} .uael-grid-pagination span.page-numbers.current',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'numbers',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Update Meta control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_meta_field_controls() {

		$this->update_control(
			'show_comments',
			[
				'default' => '',
			]
		);
	}

	/**
	 * Update Meta control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_cta_controls() {

		$this->update_control(
			'show_cta',
			[
				'default' => '',
			]
		);
	}

	/**
	 * Update Meta control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_meta_styles_controls() {

		$this->update_control(
			'meta_spacing',
			[
				'default' => [
					'size' => 0,
					'unit' => 'px',
				],
			]
		);
	}

	/**
	 * Update Meta control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_title_styles_controls() {

		$this->update_control(
			'title_spacing',
			[
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
			]
		);
	}

	/**
	 * Register Taxonomy Badge Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_badge_controls() {

		$this->start_controls_section(
			'section_terms_field',
			[
				'label' => __( 'Taxonomy Badge', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'show_taxonomy',
				[
					'label'        => __( 'Show Taxonomy Badge', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'terms_to_show',
				[
					'label'     => __( 'Select Taxonomy', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'category' => __( 'Category', 'uael' ),
						'post_tag' => __( 'Tag', 'uael' ),
					],
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_taxonomy' ) => 'yes',
					],
					'default'   => 'category',
				]
			);

			$this->add_control(
				'max_terms',
				[
					'label'       => __( 'Max Terms to Show', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 1,
					'label_block' => false,
					'condition'   => [
						$this->get_control_id( 'show_taxonomy' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'show_term_icon',
				[
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Term Icon', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_taxonomy' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'term_divider',
				[
					'label'     => __( 'Term Divider', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '|',
					'selectors' => [
						'{{WRAPPER}} .uael-listing__terms-link:not(:last-child):after' => 'content: "{{VALUE}}"; margin: 0 0.4em;',
					],
					'condition' => [
						$this->get_control_id( 'show_taxonomy' ) => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Style Taxonomy Badge Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_term_controls() {

		$this->start_controls_section(
			'section_term_style',
			[
				'label' => __( 'Taxonomy Badge', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'term_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default'    => [
						'top'    => '3',
						'bottom' => '3',
						'left'   => '10',
						'right'  => '10',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-post__terms' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'term_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default'    => [
						'top'    => '2',
						'bottom' => '2',
						'left'   => '2',
						'right'  => '2',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-post__terms' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'term_color',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms' => 'color: {{VALUE}};',
						'{{WRAPPER}} .uael-post__terms a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'term_hover_color',
				[
					'label'     => __( 'Hover Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms a:hover' => 'color: {{VALUE}};',
						'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__terms a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'term_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#e4e4e4',
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'term_typography',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
					'selector' => '{{WRAPPER}} .uael-post__terms',
				]
			);

			$this->add_control(
				'term_spacing',
				[
					'label'     => __( 'Bottom Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'default'   => [
						'size' => 10,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Update General control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_general_controls() {

		$this->remove_control( 'post_structure' );
		$this->remove_control( 'show_filters' );
		$this->remove_control( 'slides_to_show' );

		$this->update_control(
			'posts_per_page',
			[
				'default' => 3,
			]
		);

		$this->update_control(
			'pagination',
			[
				'condition' => [],
			]
		);

		$this->update_control(
			'max_pages',
			[
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'numbers',
				],
			]
		);

		$this->update_control(
			'infinite_event',
			[
				'condition' => [
					$this->get_control_id( 'pagination' ) => 'infinite',
				],
			]
		);
	}

	/**
	 * Update Image control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_image_controls() {

		$this->update_control(
			'image_position',
			[
				'default' => 'left',
				'options' => array(
					'left' => __( 'Left', 'uael' ),
					'none' => __( 'None', 'uael' ),
				),
			]
		);

		$this->update_control(
			'image_size',
			array(
				'condition' => [
					$this->get_control_id( 'image_position' ) => 'left',
				],
			)
		);

		$this->update_control(
			'heading_image_hover_options',
			[
				'condition' => [
					$this->get_control_id( 'image_position' ) => 'left',
				],
			]
		);

		$this->update_control(
			'image_scale_hover',
			[
				'condition' => [
					$this->get_control_id( 'image_position' ) => 'left',
				],
			]
		);

		$this->update_control(
			'image_opacity_hover',
			[
				'condition' => [
					$this->get_control_id( 'image_position' ) => 'left',
				],
			]
		);

		$this->update_control(
			'link_img',
			[
				'condition' => [
					$this->get_control_id( 'image_position' ) => 'left',
				],
			]
		);

		$this->update_control(
			'link_new_tab',
			[
				'condition' => [
					$this->get_control_id( 'image_position' ) => 'left',
				],
			]
		);

		$this->remove_control( 'image_background_color' );
	}

	/**
	 * Update Layout control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_update_layout_controls() {

		$this->update_control(
			'alignment',
			[
				'selectors' => [
					'{{WRAPPER}} .uael-post-wrapper' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .uael-post__separator-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->remove_control( 'column_gap' );

		$this->update_control(
			'row_gap',
			[
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 50,
				],
			]
		);

		$this->add_control(
			'separator_title',
			[
				'label'     => __( 'Separator', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'card_separator_height',
			[
				'label'      => __( 'Separator Width', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [
					'size' => 2,
					'unit' => 'px',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__separator' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_separator_width',
			[
				'label'      => __( 'Separator Length ( In Percentage )', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'size' => 25,
					'unit' => '%',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__separator' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_separator_color',
			[
				'label'     => __( 'Separator Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__separator' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_alignment',
			[
				'label'        => __( 'Separator Alignment', 'uael' ),
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
				'prefix_class' => 'uael-post__separator-',
			]
		);
	}

	/**
	 * Update Blog Design control.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_blog_design_controls() {

		$this->update_control(
			'blog_bg_color',
			[
				'label'     => __( 'Content Background Color', 'uael' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .uael-post__content-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'inner_blog_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f6f6f6',
				'selectors' => [
					'{{WRAPPER}} .uael-post__bg-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->update_control(
			'blog_padding',
			[
				'label'   => __( 'Content Padding', 'uael' ),
				'default' => [
					'top'    => '40',
					'bottom' => '40',
					'right'  => '40',
					'left'   => '40',
					'unit'   => 'px',
				],
			]
		);

		$this->add_control(
			'inner_blog_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '30',
					'bottom' => '30',
					'right'  => '30',
					'left'   => '30',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'feed_box_shadow',
				'selector' => '{{WRAPPER}} .uael-post__content-wrap',
			]
		);

		$this->add_control(
			'feed_max_width',
			[
				'label'      => __( 'Content Max Width', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'size' => 50,
					'unit' => '%',
				],
				'range'      => [
					'px' => [
						'min' => 30,
						'max' => 80,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__inner-wrap:not(.uael-post__noimage) .uael-post__content-wrap' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-post__thumbnail' => 'width: calc( 100% - {{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'feed_lift_up',
			[
				'label'      => __( 'Content Box Padding', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [
					'size' => 30,
					'unit' => 'px',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__inner-wrap:not(.uael-post__noimage) .uael-post__content-wrap' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-post__inner-wrap.uael-post__noimage' => 'padding: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-post-wrapper .uael-post__inner-wrap:not(.uael-post__noimage) .uael-post__content-wrap' => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-post-wrapper:first-child' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Render Main HTML.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	public function render() {

		$settings = $this->parent->get_settings_for_display();

		$skin = Skin_Init::get_instance( $this->get_id() );

		echo $skin->render( $this->get_id(), $settings, $this->parent->get_id() );
	}

}
