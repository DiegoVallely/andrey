<?php
/**
 * UAEL Base Skin.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;

use UltimateElementor\Classes\UAEL_Posts_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Skin_Base
 */
abstract class Skin_Base extends Elementor_Skin_Base {


	/**
	 * Query object
	 *
	 * @since 1.7.0
	 * @var object $query
	 */
	public static $query;

	/**
	 * Register controls on given actions.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		add_action( 'elementor/element/uael-posts/section_filter_field/after_section_end', [ $this, 'register_sections' ] );

		add_action( 'elementor/element/uael-posts/section_layout/after_section_end', [ $this, 'register_sections_before' ] );
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
	 * Register controls callback.
	 *
	 * @param Widget_Base $widget Current Widget object.
	 * @since 1.7.0
	 * @access public
	 */
	public function register_sections_before( Widget_Base $widget ) {

		$this->parent = $widget;

		// Content Controls.
		$this->register_content_general_controls();
	}

	/**
	 * Register Posts General Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_general_controls() {

		$this->start_controls_section(
			'section_general_field',
			[
				'label' => __( 'General', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'posts_per_page',
				[
					'label'       => __( 'Posts Per Page', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => '6',
					'label_block' => false,
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_responsive_control(
				'slides_to_show',
				[
					'label'          => __( 'Columns', 'uael' ),
					'type'           => Controls_Manager::NUMBER,
					'default'        => 3,
					'tablet_default' => 2,
					'mobile_default' => 1,
					'min'            => 1,
					'max'            => 8,
				]
			);

			$this->add_control(
				'post_structure',
				array(
					'label'   => __( 'Layout', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'normal',
					'options' => array(
						'normal'   => __( 'Grid', 'uael' ),
						'masonry'  => __( 'Masonry', 'uael' ),
						'carousel' => __( 'Carousel', 'uael' ),
						'featured' => __( 'Featured', 'uael' ),
					),
				)
			);

			$this->add_control(
				'featured_post',
				array(
					'label'     => __( 'Featured Post', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'inline',
					'options'   => array(
						'inline' => __( 'Inline', 'uael' ),
						'stack'  => __( 'Stack', 'uael' ),
					),
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				)
			);

			$this->add_control(
				'pagination',
				[
					'label'     => __( 'Pagination', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'     => __( 'None', 'uael' ),
						'numbers'  => __( 'Numbers', 'uael' ),
						'infinite' => __( 'Infinite', 'uael' ),
					],
					'condition' => [
						$this->get_control_id( 'post_structure' ) => [ 'normal', 'featured', 'masonry' ],
					],
				]
			);

			$this->add_control(
				'infinite_main_query',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'Note: Infinite Pagination will not work when query type is set to Main Query', 'uael' ),
					'condition'       => [
						$this->get_control_id( 'pagination' ) => 'infinite',
						'query_type' => 'main',
					],
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'max_pages',
				[
					'label'     => __( 'Page Limit', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 5,
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'numbers',
						$this->get_control_id( 'post_structure' ) => [ 'normal', 'featured', 'masonry' ],
					],
				]
			);

			$this->add_control(
				'infinite_event',
				[
					'label'     => __( 'Infinite Load Event', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'scroll',
					'options'   => [
						'scroll' => __( 'Scroll', 'uael' ),
						'click'  => __( 'Button', 'uael' ),
					],
					'condition' => [
						$this->get_control_id( 'pagination' ) => 'infinite',
						$this->get_control_id( 'post_structure' ) => [ 'normal', 'featured', 'masonry' ],
					],
				]
			);

			$this->add_control(
				'link_complete_box',
				[
					'label'        => __( 'Link Complete Box', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'description'  => __( 'Enable this to make entire blog box clickable.', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'prefix_class' => 'uael-post__link-complete-',
				]
			);

			$this->add_control(
				'link_complete_box_tab',
				[
					'label'        => __( 'Open in New Tab', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						$this->get_control_id( 'link_complete_box' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'equal_height',
				[
					'label'        => __( 'Equal Height', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'description'  => __( 'Enable this to display all posts with same height on carousel scroll.', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						$this->get_control_id( 'post_structure' ) => 'carousel',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Posts Featured Image Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_image_controls() {

		$this->start_controls_section(
			'section_image_field',
			[
				'label' => __( 'Image', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'image_position',
				array(
					'label'       => __( 'Image Position', 'uael' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT,
					'default'     => 'top',
					'options'     => array(
						'top'        => __( 'Top', 'uael' ),
						'background' => __( 'Background', 'uael' ),
						'none'       => __( 'None', 'uael' ),
					),
				)
			);

			$this->add_control(
				'image_size',
				array(
					'label'       => __( 'Image Size', 'uael' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT,
					'default'     => 'full',
					'options'     => UAEL_Posts_Helper::get_image_sizes(),
					'condition'   => [
						$this->get_control_id( 'image_position' ) => [ 'top', 'background' ],
					],
				)
			);

			$this->add_control(
				'image_custom_dimension',
				[
					'label'       => __( 'Image Dimension', 'uael' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'uael' ),
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						$this->get_control_id( 'image_size' ) => 'custom',
					],
				]
			);

			$this->add_control(
				'image_background_color',
				[
					'label'     => __( 'Overlay Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-post-image-background .uael-post__thumbnail::before' => 'background-color: {{VALUE}};',
					],
					'default'   => 'rgba(246,246,246,0.8)',
					'condition' => [
						$this->get_control_id( 'image_position' ) => 'background',
					],
				]
			);

			$this->add_control(
				'heading_image_hover_options',
				[
					'label'     => __( 'On Hover', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						$this->get_control_id( 'image_position' ) => [ 'top', 'background' ],
					],
				]
			);

			$this->add_control(
				'image_scale_hover',
				[
					'label'     => __( 'Scale', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 2,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__thumbnail:hover img' => 'transform: scale({{SIZE}});',
						'{{WRAPPER}}.uael-post__link-complete-yes .uael-post-image-background .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__thumbnail img' => 'transform: translate(-50%,-50%) scale({{SIZE}});',
						'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__thumbnail img' => 'transform: scale({{SIZE}});',
						'{{WRAPPER}}.uael-equal__height-yes .uael-post-image-background .uael-post__inner-wrap:hover img' => 'transform: translate(-50%,-50%) scale({{SIZE}});',
					],
					'condition' => [
						$this->get_control_id( 'image_position' ) => [ 'top', 'background' ],
					],
				]
			);

			$this->add_control(
				'image_opacity_hover',
				[
					'label'     => __( 'Opacity (%)', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 1,
					],
					'range'     => [
						'px' => [
							'max'  => 1,
							'min'  => 0,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__thumbnail:hover img' => 'opacity: {{SIZE}};',
						'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__thumbnail img' => 'opacity: {{SIZE}};',
						'{{WRAPPER}}.uael-equal__height-yes .uael-post-image-background .uael-post__inner-wrap:hover img' => 'opacity: {{SIZE}};',
					],
					'condition' => [
						$this->get_control_id( 'image_position' ) => [ 'top', 'background' ],
					],
				]
			);

			$this->add_control(
				'link_img',
				[
					'label'        => __( 'Link Image', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'description'  => __( 'Disable this option, if you do not wish to make the image clickable.', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'separator'    => 'before',
					'condition'    => [
						$this->get_control_id( 'image_position' ) => [ 'top', 'background' ],
					],
				]
			);

			$this->add_control(
				'link_new_tab',
				[
					'label'        => __( 'Open in New Tab', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						$this->get_control_id( 'link_img' ) => 'yes',
						$this->get_control_id( 'image_position' ) => [ 'top', 'background' ],
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Slider Controls.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	protected function register_content_slider_controls() {

		$this->start_controls_section(
			'section_slider_options',
			[
				'label'     => __( 'Carousel', 'uael' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => [
					$this->get_control_id( 'post_structure' ) => 'carousel',
				],
			]
		);

			$this->add_control(
				'navigation',
				[
					'label'   => __( 'Navigation', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'both',
					'options' => [
						'both'   => __( 'Arrows and Dots', 'uael' ),
						'arrows' => __( 'Arrows', 'uael' ),
						'dots'   => __( 'Dots', 'uael' ),
						'none'   => __( 'None', 'uael' ),
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
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'        => __( 'Autoplay', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'     => __( 'Autoplay Speed', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 5000,
					'condition' => [
						'autoplay' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
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
				]
			);

			$this->add_control(
				'transition_speed',
				[
					'label'       => __( 'Transition Speed (ms)', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'label_block' => true,
					'default'     => 500,
				]
			);

			$this->add_responsive_control(
				'slides_to_scroll',
				[
					'label'          => __( 'Slides to Scroll', 'uael' ),
					'type'           => Controls_Manager::NUMBER,
					'default'        => 1,
					'tablet_default' => 1,
					'mobile_default' => 1,
					'min'            => 1,
					'max'            => 6,
				]
			);

		$this->end_controls_section();
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
				'terms_position',
				[
					'label'   => __( 'Display Position', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'media'         => __( 'On Media', 'uael' ),
						'above_content' => __( 'Above Content', 'uael' ),
						''              => __( 'None', 'uael' ),
					],
					'default' => 'above_content',
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
						$this->get_control_id( 'terms_position!' ) => '',
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
					'condition'   => [
						$this->get_control_id( 'terms_position!' ) => '',
					],
					'label_block' => false,
				]
			);

			$this->add_control(
				'show_term_icon',
				[
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Term Icon', 'uael' ),
					'condition' => [
						$this->get_control_id( 'terms_position!' ) => '',
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
						$this->get_control_id( 'terms_position!' ) => '',
					],
				]
			);

		$this->end_controls_section();
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
						$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
						$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
						$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
							$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
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
					$this->get_control_id( 'post_structure' ) => [ 'masonry', 'normal' ],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register featured Posts Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_featured_controls() {

		$this->start_controls_section(
			'section_featured_field',
			[
				'label'     => __( 'Featured Post', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					$this->get_control_id( 'post_structure' ) => 'featured',
				],
			]
		);

			$this->add_control(
				'_f_meta',
				[
					/* translators: %s label */
					'label'       => __( 'Meta', 'uael' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'default'     => [ 'date', 'comment' ],
					'label_block' => true,
					'options'     => [
						'author'   => __( 'Author', 'uael' ),
						'date'     => __( 'Date', 'uael' ),
						'comment'  => __( 'Comment', 'uael' ),
						'category' => __( 'Category', 'uael' ),
						'tag'      => __( 'Tag', 'uael' ),
					],
					'condition'   => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'_f_excerpt_length',
				[
					'label'       => __( 'Featured Excerpt Length', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'label_block' => true,
					'default'     => apply_filters( 'uael_post_featured_excerpt_length', 25 ),
					'condition'   => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Posts Title Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_title_controls() {

		$this->start_controls_section(
			'section_title_field',
			[
				'label' => __( 'Title', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
				'link_title',
				[
					'label'        => __( 'Link Title', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'description'  => __( 'Disable this option, if you do not wish to make the title clickable.', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$this->get_control_id( 'show_title' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'link_title_new',
				[
					'label'        => __( 'Open in New Tab', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						$this->get_control_id( 'show_title' ) => 'yes',
						$this->get_control_id( 'link_title' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'title_tag',
				[
					'label'     => __( 'HTML Tag', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1' => __( 'H1', 'uael' ),
						'h2' => __( 'H2', 'uael' ),
						'h3' => __( 'H3', 'uael' ),
						'h4' => __( 'H4', 'uael' ),
						'h5' => __( 'H5', 'uael' ),
						'h6' => __( 'H6', 'uael' ),
					],
					'default'   => 'h3',
					'condition' => [
						$this->get_control_id( 'show_title' ) => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Posts meta Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_meta_controls() {

		$this->start_controls_section(
			'section_meta_field',
			[
				'label' => __( 'Meta', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'show_meta',
				[
					'label'        => __( 'Meta', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'meta_tag',
				[
					'label'     => __( 'HTML Tag', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => __( 'H1', 'uael' ),
						'h2'   => __( 'H2', 'uael' ),
						'h3'   => __( 'H3', 'uael' ),
						'h4'   => __( 'H4', 'uael' ),
						'h5'   => __( 'H5', 'uael' ),
						'h6'   => __( 'H6', 'uael' ),
						'div'  => __( 'DIV', 'uael' ),
						'span' => __( 'SPAN', 'uael' ),
					],
					'default'   => 'div',
					'condition' => [
						$this->get_control_id( 'show_meta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'link_meta',
				[
					'label'        => __( 'Link Meta', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'description'  => __( 'Disable this option, if you do not wish to make the meta clickable.', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$this->get_control_id( 'show_meta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'show_author',
				array(
					'label'        => __( 'Show Post Author', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'separator'    => 'before',
					'condition'    => array(
						$this->get_control_id( 'show_meta' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'show_author_icon',
				array(
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Author Icon', 'uael' ),
					'default'   => 'fa fa-user',
					'condition' => array(
						$this->get_control_id( 'show_meta' )   => 'yes',
						$this->get_control_id( 'show_author' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'show_date',
				array(
					'label'        => __( 'Show Post Date', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'separator'    => 'before',
					'condition'    => array(
						$this->get_control_id( 'show_meta' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'show_date_icon',
				array(
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Date Icon', 'uael' ),
					'default'   => 'fa fa-calendar',
					'condition' => array(
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_date' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'show_comments',
				array(
					'label'        => __( 'Show Post Comments', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'separator'    => 'before',
					'condition'    => array(
						$this->get_control_id( 'show_meta' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'show_comments_icon',
				array(
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Comments Icon', 'uael' ),
					'default'   => 'fa fa-comments',
					'condition' => array(
						$this->get_control_id( 'show_meta' )     => 'yes',
						$this->get_control_id( 'show_comments' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'show_categories',
				array(
					'label'        => __( 'Show Categories', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'separator'    => 'before',
					'default'      => '',
					'condition'    => array(
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'cat_meta_max_terms',
				[
					'label'     => __( 'Max Categories', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1,
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_categories' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'cat_meta_show_term_icon',
				[
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Category Icon', 'uael' ),
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_categories' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'cat_meta_term_divider',
				[
					'label'     => __( 'Category Divider', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '|',
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms-meta-cat .uael-listing__terms-link:not(:last-child):after' => 'content: "{{VALUE}}"; margin: 0 0.4em;',
					],
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_categories' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'show_tags',
				array(
					'label'        => __( 'Show Tags', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'separator'    => 'before',
					'condition'    => array(
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
					),
				)
			);

			$this->add_control(
				'tag_meta_max_terms',
				[
					'label'     => __( 'Max Tags', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1,
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_tags' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'tag_meta_show_term_icon',
				[
					'type'      => Controls_Manager::ICON,
					'label'     => __( 'Tag Icon', 'uael' ),
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_tags' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'tag_meta_term_divider',
				[
					'label'     => __( 'Tag Divider', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '|',
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms-meta-tag .uael-listing__terms-link:not(:last-child):after' => 'content: "{{VALUE}}"; margin: 0 0.4em;',
					],
					'condition' => [
						'post_type_filter' => 'post',
						$this->get_control_id( 'show_meta' ) => 'yes',
						$this->get_control_id( 'show_tags' ) => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Posts Excerpt Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_excerpt_controls() {

		$this->start_controls_section(
			'section_excerpt_field',
			[
				'label' => __( 'Excerpt', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'show_excerpt',
				[
					'label'        => __( 'Short Excerpt', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'excerpt_length',
				[
					'label'     => __( 'Excerpt Length', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => apply_filters( 'uael_post_excerpt_length', 25 ),
					'condition' => [
						$this->get_control_id( 'show_excerpt' ) => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Posts call to action Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_cta_controls() {

		$this->start_controls_section(
			'section_cta_field',
			[
				'label' => __( 'Call To Action', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'show_cta',
				[
					'label'        => __( 'Call To Action', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'cta_new_tab',
				[
					'label'        => __( 'Open in New Tab', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						$this->get_control_id( 'show_cta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'cta_text',
				[
					'label'     => __( 'Text', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => __( 'Read More →', 'uael' ),
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						$this->get_control_id( 'show_cta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'cta_icon',
				[
					'label'     => __( 'Icon', 'uael' ),
					'type'      => Controls_Manager::ICON,
					'default'   => '',
					'condition' => [
						$this->get_control_id( 'show_cta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'cta_icon_align',
				[
					'label'     => __( 'Icon Position', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'  => __( 'Before', 'uael' ),
						'right' => __( 'After', 'uael' ),
					],
					'condition' => [
						$this->get_control_id( 'show_cta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'cta_icon_indent',
				[
					'label'     => __( 'Icon Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'condition' => [
						$this->get_control_id( 'show_cta' ) => 'yes',
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
	 * Style Tab
	 */

	/**
	 * Register Style Layout Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_layout_controls() {

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
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post-grid .uael-post-wrapper' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'{{WRAPPER}} .uael-post-grid .uael-post-grid__inner' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
				],
				'condition' => [
					$this->get_control_id( 'slides_to_show' ) => [ 2, 3, 4, 5, 6, 7, 8 ],
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'     => __( 'Rows Gap', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 20,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post-grid .uael-post-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'post_structure' ) => [ 'normal', 'featured', 'masonry' ],
				],
			]
		);

		$this->add_control(
			'alignment',
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
					'{{WRAPPER}} .uael-post-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Blog Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_blog_controls() {

		$this->start_controls_section(
			'section_design_blog',
			[
				'label' => __( 'Blog', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'blog_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#f6f6f6',
					'selectors' => [
						'{{WRAPPER}} .uael-post__bg-wrap' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'blog_padding',
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

		$this->end_controls_section();
	}

	/**
	 * Register Style Pagination Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_pagination_controls() {

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => __( 'Pagination', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'post_structure' ) => [ 'normal', 'featured', 'masonry' ],
					$this->get_control_id( 'pagination' ) => [ 'numbers', 'infinite' ],
				],
			]
		);

			$this->add_control(
				'infinite_notice',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'Note: Infinite Load is prevented at the backend. You can see it working in the frontend,', 'uael' ),
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
	 * Register Style Blog Controls.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	protected function register_style_featured_controls() {

		$this->start_controls_section(
			'section_design_featured',
			[
				'label'     => __( 'Featured Post', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'post_structure' ) => 'featured',
				],
			]
		);

			$this->add_control(
				'_f_title_color',
				[
					'label'     => __( 'Title Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__title, {{WRAPPER}} .uael-post-wrapper-featured .uael-post__title a' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => '_f_title_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
					'selector'  => '{{WRAPPER}} .uael-post-wrapper-featured .uael-post__title, {{WRAPPER}} .uael-post-wrapper-featured .uael-post__title a',
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'_f_title_spacing',
				[
					'label'     => __( 'Below Title Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'_f_excerpt_spacing',
				[
					'label'     => __( 'Below Excerpt Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'_f_meta_color',
				[
					'label'     => __( 'Meta Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__meta-data' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'_f_meta_spacing',
				[
					'label'     => __( 'Below Meta Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'default'   => [
						'size' => 13,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__meta-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_meta' => 'yes',
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'_f_excerpt_color',
				[
					'label'     => __( 'Excerpt Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__excerpt' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

			$this->add_control(
				'featured_padding',
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
						'{{WRAPPER}} .uael-post-wrapper-featured .uael-post__content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'post_structure' ) => 'featured',
					],
				]
			);

		$this->end_controls_section();
	}


	/**
	 * Style Tab
	 */
	/**
	 * Register Style Title Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_title_controls() {

		$this->start_controls_section(
			'section_title_style',
			[
				'label'     => __( 'Title', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__title, {{WRAPPER}} .uael-post__title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__title:hover, {{WRAPPER}} .uael-post__title a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .uael-post__title',
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 5,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Meta Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_meta_controls() {

		$this->start_controls_section(
			'section_meta_style',
			[
				'label'     => __( 'Meta', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'show_meta' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#adadad',
				'selectors' => [
					'{{WRAPPER}} .uael-post__meta-data' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_link_color',
			[
				'label'     => __( 'Link Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-post__meta-data a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_link_hover_color',
			[
				'label'     => __( 'Link Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-post__meta-data a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__meta-data a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .uael-post__meta-data span',
			]
		);

		$this->add_control(
			'meta_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__meta-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'intermeta_spacing',
			[
				'label'     => __( 'Inter Meta Spacing', 'uael' ),
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
					'{{WRAPPER}} .uael-post__meta-data span' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-post__meta-data span:last-child, {{WRAPPER}} .uael-post__meta-data span.uael-listing__terms-link' => 'margin-right: 0;',
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
				'label'     => __( 'Taxonomy Badge', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
				],
			]
		);

			$this->add_control(
				'term_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default'    => [
						'top'    => '5',
						'bottom' => '5',
						'left'   => '10',
						'right'  => '10',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-post__terms' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
					],
				]
			);

			$this->add_control(
				'term_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-post__terms' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
					],
				]
			);

			$this->add_control(
				'term_alignment',
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
						'{{WRAPPER}} .uael-post__terms-wrap' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						$this->get_control_id( 'terms_position' ) => 'media',
						$this->get_control_id( 'image_position' ) => 'background',
					],
				]
			);

			$this->add_control(
				'term_alignment_media',
				[
					'label'       => __( 'Alignment', 'uael' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
						'left'  => [
							'title' => __( 'Left', 'uael' ),
							'icon'  => 'fa fa-align-left',
						],
						'right' => [
							'title' => __( 'Right', 'uael' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'default'     => 'left',
					'selectors'   => [
						'{{WRAPPER}} .uael-post__terms' => 'right:auto; left:auto; {{VALUE}} :0;',
					],
					'condition'   => [
						$this->get_control_id( 'terms_position' )  => 'media',
						$this->get_control_id( 'image_position' ) => 'top',
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
						'value' => Scheme_Color::COLOR_2,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
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
					'condition' => [
						$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
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
					'name'      => 'term_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
					'selector'  => '{{WRAPPER}} .uael-post__terms',
					'condition' => [
						$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
					],
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
						'size' => 20,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$this->get_control_id( 'terms_position' ) => [ 'media', 'above_content' ],
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Style Excerpt Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_excerpt_controls() {

		$this->start_controls_section(
			'section_excerpt_style',
			[
				'label'     => __( 'Excerpt', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-post__excerpt' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'excerpt_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .uael-post__excerpt',
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_spacing',
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
					'{{WRAPPER}} .uael-post__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style CTA Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_cta_controls() {

		$this->start_controls_section(
			'section_cta_style',
			[
				'label'     => __( 'Call To Action', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'show_cta' ) => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'cta_tabs_style' );

			$this->start_controls_tab(
				'cta_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_cta' ) => 'yes',
					],
				]
			);

				$this->add_control(
					'cta_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} a.uael-post__read-more' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_cta' ) => 'yes',
						],
					]
				);

				$this->add_control(
					'cta_background_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} a.uael-post__read-more' => 'background-color: {{VALUE}};',
						],
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'condition' => [
							$this->get_control_id( 'show_cta' ) => 'yes',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'cta_border',
						'label'     => __( 'Border', 'uael' ),
						'selector'  => '{{WRAPPER}} a.uael-post__read-more',
						'condition' => [
							$this->get_control_id( 'show_cta' ) => 'yes',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'cta_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						$this->get_control_id( 'show_cta' ) => 'yes',
					],
				]
			);

				$this->add_control(
					'cta_hover_color',
					[
						'label'     => __( 'Text Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} a.uael-post__read-more:hover' => 'color: {{VALUE}};',
							'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap a.uael-post__read-more' => 'color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_cta' ) => 'yes',
						],
					]
				);

				$this->add_control(
					'cta_background_hover_color',
					[
						'label'     => __( 'Background Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} a.uael-post__read-more:hover' => 'background-color: {{VALUE}};',
							'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap a.uael-post__read-more' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_cta' ) => 'yes',
						],
					]
				);

				$this->add_control(
					'cta_hover_border_color',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} a.uael-post__read-more:hover' => 'border-color: {{VALUE}};',
							'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap a.uael-post__read-more' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							$this->get_control_id( 'show_cta' ) => 'yes',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'cta_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => [
					'{{WRAPPER}} a.uael-post__read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => [
					$this->get_control_id( 'show_cta' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'cta_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.uael-post__read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => 10,
					'bottom' => 10,
					'left'   => 10,
					'right'  => 10,
					'unit'   => 'px',
				],
				'condition'  => [
					$this->get_control_id( 'show_cta' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'cta_full_width',
			[
				'label'        => __( 'Full Width', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'uael-post__cta-fullwidth-',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'cta_typography',
				'selector'  => '{{WRAPPER}} a.uael-post__read-more',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					$this->get_control_id( 'show_cta' ) => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Navigation Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_style_navigation_controls() {

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'navigation' ) => [ 'arrows', 'dots', 'both' ],
					$this->get_control_id( 'post_structure' ) => 'carousel',
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
						$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
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
					'prefix_class' => 'uael-post__arrow-',
					'condition'    => [
						$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'arrows_size',
				[
					'label'     => __( 'Arrows Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 20,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-grid .slick-slider .slick-prev i, {{WRAPPER}} .uael-post-grid .slick-slider .slick-next i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
					],
				]
			);

			$this->start_controls_tabs( 'arrow_tabs_style' );
				$this->start_controls_tab(
					'arrow_style_normal',
					[
						'label'     => __( 'Normal', 'uael' ),
						'condition' => [
							$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
						],
					]
				);
					$this->add_control(
						'arrows_color',
						[
							'label'     => __( 'Arrows Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-prev:before, {{WRAPPER}} .uael-post-grid .slick-slider .slick-next:before' => 'color: {{VALUE}};',
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow' => 'border-color: {{VALUE}}; border-style: solid;',
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow i' => 'color: {{VALUE}};',
							],
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
							'condition' => [
								$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
							],
						]
					);
					$this->add_control(
						'arrows_bg_color',
						[
							'label'     => __( 'Background Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
							],
						]
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'arrow_style_hover',
					[
						'label'     => __( 'Hover', 'uael' ),
						'condition' => [
							$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
						],
					]
				);
					$this->add_control(
						'arrows_hover_color',
						[
							'label'     => __( 'Hover Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-prev:before:hover, {{WRAPPER}} .uael-post-grid .slick-slider .slick-next:before:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow:hover' => 'border-color: {{VALUE}}; border-style: solid;',
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow:hover i' => 'color: {{VALUE}};',
							],
							'condition' => [
								$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
							],
						]
					);
					$this->add_control(
						'arrows_hover_bg_color',
						[
							'label'     => __( 'Background Hover Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow:hover' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'arrows_border_size',
				[
					'label'     => __( 'Arrows Border Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'arrow_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ '%' ],
					'default'    => [
						'top'    => '50',
						'bottom' => '50',
						'left'   => '50',
						'right'  => '50',
						'unit'   => '%',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-post-grid .slick-slider .slick-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						$this->get_control_id( 'navigation' ) => [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'heading_style_dots',
				[
					'label'     => __( 'Dots', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						$this->get_control_id( 'navigation' ) => [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_size',
				[
					'label'     => __( 'Dots Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 15,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post-grid .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$this->get_control_id( 'navigation' ) => [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_color',
				[
					'label'     => __( 'Dots Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-post-grid .slick-dots li button:before' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'navigation' ) => [ 'dots', 'both' ],
					],
				]
			);

		$this->end_controls_section();
	}
}
