<?php
/**
 * UAEL ImageGallery.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\ImageGallery\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Control_Media;


// UltimateElementor Classes.
use UltimateElementor\Classes\UAEL_Helper;
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class ImageGallery.
 */
class Image_Gallery extends Common_Widget {

	/**
	 * Retrieve ImageGallery Widget name.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Image_Gallery' );
	}

	/**
	 * Retrieve ImageGallery Widget title.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Image_Gallery' );
	}

	/**
	 * Retrieve ImageGallery Widget icon.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Image_Gallery' );
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
		return parent::get_widget_keywords( 'Image_Gallery' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [
			'uael-isotope',
			'imagesloaded',
			'jquery-slick',
			'uael-element-resize',
			'uael-frontend-script',
			'uael-justified',
		];
	}

	/**
	 * Image filter options.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param boolean $inherit if inherit option required.
	 * @return array Filters.
	 */
	protected function filter_options( $inherit = false ) {

		$inherit_ops = array();

		if ( $inherit ) {
			$inherit_ops = array(
				'' => __( 'Inherit', 'uael' ),
			);
		}

		$filter = array(
			'normal'    => __( 'Normal', 'uael' ),
			'a-1977'    => __( '1977', 'uael' ),
			'aden'      => __( 'Aden', 'uael' ),
			'earlybird' => __( 'Earlybird', 'uael' ),
			'hudson'    => __( 'Hudson', 'uael' ),
			'inkwell'   => __( 'Inkwell', 'uael' ),
			'perpetua'  => __( 'Perpetua', 'uael' ),
			'poprocket' => __( 'Poprocket', 'uael' ),
			'sutro'     => __( 'Sutro', 'uael' ),
			'toaster'   => __( 'Toaster', 'uael' ),
			'willow'    => __( 'Willow', 'uael' ),
		);

		return array_merge( $inherit_ops, $filter );
	}

	/**
	 * Register ImageGallery controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_content_image_controls();
		$this->register_content_grid_controls();
		$this->register_content_slider_controls();
		$this->register_content_general_controls();

		/* Style */
		$this->register_style_layout_controls();
		$this->register_style_thumbnail_controls();
		$this->register_style_caption_controls();
		$this->register_style_navigation_controls();
		$this->register_style_cat_filters_controls();

		$this->register_helpful_information();
	}

	/**
	 * Register ImageGallery General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_image_controls() {

		$this->start_controls_section(
			'section_content_images',
			[
				'label' => __( 'Gallery', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'gallery_style',
				[
					'label'     => __( 'Layout', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'grid',
					'options'   => [
						'grid'      => __( 'Grid', 'uael' ),
						'masonry'   => __( 'Masonry', 'uael' ),
						'justified' => __( 'Justified', 'uael' ),
						'carousel'  => __( 'Carousel', 'uael' ),
					],
					'separator' => 'after',
				]
			);

			$this->add_control(
				'wp_gallery',
				[
					'label'   => '',
					'type'    => Controls_Manager::GALLERY,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$gallery = new Repeater();

			$gallery->add_control(
				'image',
				[
					'label'   => __( 'Choose Image', 'uael' ),
					'type'    => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register ImageGallery General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_grid_controls() {
		$this->start_controls_section(
			'section_content_grid',
			[
				'label'     => __( 'Grid / Masonry / Justified', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'gallery_style' => [ 'grid', 'masonry', 'justified' ],
				],
			]
		);
			$this->add_responsive_control(
				'gallery_columns',
				[
					'label'          => __( 'Columns', 'uael' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => '4',
					'tablet_default' => '3',
					'mobile_default' => '2',
					'options'        => [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
					'prefix_class'   => 'uael-img-grid%s__column-',
					'condition'      => [
						'gallery_style!' => [ 'justified', 'carousel' ],
					],
				]
			);

			$this->add_control(
				'justified_row_height',
				[
					'label'     => __( 'Row Height', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 120,
					],
					'range'     => [
						'px' => [
							'min' => 50,
							'max' => 500,
						],
					],
					'condition' => [
						'gallery_style' => 'justified',
					],
				]
			);

			$this->add_control(
				'last_row',
				[
					'label'     => __( 'Last Row Layout', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'nojustify',
					'options'   => [
						'nojustify' => __( 'No Justify', 'uael' ),
						'justify'   => __( 'Justify', 'uael' ),
						'hide'      => __( 'Hide', 'uael' ),
					],
					'condition' => [
						'gallery_style' => 'justified',
					],
				]
			);

			$this->add_control(
				'masonry_filters_enable',
				[
					'label'        => __( 'Filterable Image Gallery', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'condition'    => [
						'gallery_style' => [ 'grid', 'masonry', 'justified' ],
					],
				]
			);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'masonry_filters_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s admin link */
					'raw'             => sprintf( __( 'Learn : %1$s How to design filterable image gallery? %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-design-filterable-image-gallery/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);
		}

			$this->add_control(
				'filters_all_text',
				[
					'label'     => __( '"All" Tab Label', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => __( 'All', 'uael' ),
					'condition' => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
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
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
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
						'default_filter_switch'  => 'yes',
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'default_filter_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s admin link */
					'raw'             => sprintf( __( 'Note: Enter the category name that you wish to set as a default on page load. Read %1$s this article %2$s for more information.', 'uael' ), '<a href="https://uaelementor.com/docs/display-specific-category-tab-as-a-default/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'default_filter_switch'  => 'yes',
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);
		}

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
					'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
					'masonry_filters_enable' => 'yes',
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
				'label'     => __( 'Carousel', 'uael' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => [
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'          => __( 'Images to Show', 'uael' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 4,
				'tablet_default' => 3,
				'mobile_default' => 2,
				'condition'      => [
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label'          => __( 'Images to Scroll', 'uael' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'condition'      => [
					'gallery_style' => 'carousel',
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
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => __( 'Autoplay Speed (ms)', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay'      => 'yes',
					'gallery_style' => 'carousel',
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
					'autoplay'      => 'yes',
					'gallery_style' => 'carousel',
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
					'gallery_style' => 'carousel',
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
					'gallery_style' => 'carousel',
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
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register ImageGallery General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_content_general_controls() {

		$this->start_controls_section(
			'section_content_general',
			[
				'label' => __( 'Additional Options', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'image',
					'label'   => __( 'Image Size', 'uael' ),
					'default' => 'medium',
				]
			);
			$this->add_control(
				'click_action',
				[
					'label'   => __( 'Click Action', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'file',
					'options' => [
						'lightbox'   => __( 'Lightbox', 'uael' ),
						'file'       => __( 'Media File', 'uael' ),
						'attachment' => __( 'Attachment Page', 'uael' ),
						'custom'     => __( 'Custom Link', 'uael' ),
						''           => __( 'None', 'uael' ),
					],
				]
			);
		if ( parent::is_internal_links() ) {
			$this->add_control(
				'click_action_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s admin link */
					'raw'             => sprintf( __( 'Learn : %1$s How to assign custom link for images? %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-a-custom-link-for-the-image/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'click_action' => 'custom',
					],
				]
			);
		}
			$this->add_control(
				'link_target',
				[
					'label'     => __( 'Link Target', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '_blank',
					'options'   => [
						'_self'  => __( 'Same Window', 'uael' ),
						'_blank' => __( 'New Window', 'uael' ),
					],
					'condition' => [
						'click_action' => [ 'file', 'attachment', 'custom' ],
					],
				]
			);
			$this->add_control(
				'gallery_rand',
				[
					'label'   => __( 'Ordering', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						''     => __( 'Default', 'uael' ),
						'rand' => __( 'Random', 'uael' ),
					],
					'default' => '',
				]
			);
			$this->add_control(
				'gallery_caption',
				[
					'label'   => __( 'Show Caption', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''         => __( 'Never', 'uael' ),
						'on-image' => __( 'On Image', 'uael' ),
						'on-hover' => __( 'On Hover', 'uael' ),
					],
				]
			);
		if ( parent::is_internal_links() ) {
			$this->add_control(
				'caption_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s admin link */
					'raw'             => sprintf( __( 'Learn : %1$s How to assign captions for images? %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-a-caption-for-the-image/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'gallery_caption!' => '',
					],
				]
			);
		}

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
				'condition' => [
					'gallery_style!' => 'justified',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-img-gallery-wrap .uael-grid-item' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'{{WRAPPER}} .uael-img-gallery-wrap' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-img-gallery-wrap .uael-grid-item-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'gallery_style' => [ 'grid', 'masonry' ],
				],
			]
		);

		$this->add_responsive_control(
			'justified_margin',
			[
				'label'     => __( 'Image Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'condition' => [
					'gallery_style' => 'justified',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-img-justified-wrap .uael-grid-item-content' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'images_valign',
			[
				'label'     => __( 'Image Vertical Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => __( 'Bottom', 'uael' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'gallery_style' => 'grid',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-img-gallery-wrap .uael-grid-item' => 'align-items: {{VALUE}}; display: inline-grid;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Thumbnail Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_thumbnail_controls() {
		$this->start_controls_section(
			'section_design_thumbnail',
			[
				'label' => __( 'Thumbnail', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->start_controls_tabs( 'thumb_style' );

				$this->start_controls_tab(
					'thumb_style_normal',
					[
						'label' => __( 'Normal', 'uael' ),
					]
				);

					$this->add_control(
						'image_scale',
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
								'{{WRAPPER}} .uael-grid-img-thumbnail img' => 'transform: scale({{SIZE}});',
							],
						]
					);

					$this->add_control(
						'image_opacity',
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
								'{{WRAPPER}} .uael-grid-img-thumbnail img' => 'opacity: {{SIZE}}',
							],
						]
					);

					$this->add_control(
						'image_filter',
						[
							'label'        => __( 'Image Effect', 'uael' ),
							'type'         => Controls_Manager::SELECT,
							'default'      => 'normal',
							'options'      => $this->filter_options(),
							'prefix_class' => 'uael-ins-',
						]
					);

					$this->add_control(
						'overlay_background_color',
						[
							'label'     => __( 'Overlay Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-grid-img-overlay' => 'background-color: {{VALUE}};',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'image_style_hover',
					[
						'label' => __( 'Hover', 'uael' ),
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
								'{{WRAPPER}} .uael-grid-gallery-img:hover .uael-grid-img-thumbnail img' => 'transform: scale({{SIZE}});',
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
								'{{WRAPPER}} .uael-grid-gallery-img:hover .uael-grid-img-thumbnail img' => 'opacity: {{SIZE}}',
							],
						]
					);

					$this->add_control(
						'image_filter_hover',
						[
							'label'        => __( 'Image Effect', 'uael' ),
							'type'         => Controls_Manager::SELECT,
							'default'      => '',
							'options'      => $this->filter_options( true ),
							'prefix_class' => 'uael-ins-hover-',
						]
					);

					$this->add_control(
						'overlay_background_color_hover',
						[
							'label'     => __( 'Overlay Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-grid-gallery-img:hover .uael-grid-img-overlay' => 'background-color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'overlay_image_type',
						[
							'label'   => __( 'Overlay Icon', 'uael' ),
							'type'    => Controls_Manager::CHOOSE,
							'options' => [
								'photo' => [
									'title' => __( 'Image', 'uael' ),
									'icon'  => 'fa fa-picture-o',
								],
								'icon'  => [
									'title' => __( 'Font Icon', 'uael' ),
									'icon'  => 'fa fa-info-circle',
								],
							],
							'default' => '',
							'toggle'  => true,
						]
					);
					$this->add_control(
						'overlay_icon_hover',
						[
							'label'     => __( 'Select Overlay Icon', 'uael' ),
							'type'      => Controls_Manager::ICON,
							'default'   => 'fa fa-search',
							'condition' => [
								'overlay_image_type' => 'icon',
							],
						]
					);

					$this->add_control(
						'overlay_icon_color_hover',
						[
							'label'     => __( 'Overlay Icon Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'condition' => [
								'overlay_image_type'  => 'icon',
								'overlay_icon_hover!' => '',
							],
							'default'   => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .uael-grid-gallery-img .uael-grid-img-overlay i' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_responsive_control(
						'overlay_icon_size_hover',
						[
							'label'      => __( 'Overlay Icon Size', 'uael' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', 'rem' ],
							'range'      => [
								'px' => [
									'min' => 1,
									'max' => 200,
								],
							],
							'default'    => [
								'size' => 40,
								'unit' => 'px',
							],
							'condition'  => [
								'overlay_image_type'  => 'icon',
								'overlay_icon_hover!' => '',
							],
							'selectors'  => [
								'{{WRAPPER}} .uael-grid-gallery-img .uael-grid-img-overlay i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
							],
						]
					);
					$this->add_control(
						'overlay_image_hover',
						[
							'label'     => __( 'Overlay Image', 'uael' ),
							'type'      => Controls_Manager::MEDIA,
							'default'   => [
								'url' => Utils::get_placeholder_image_src(),
							],
							'condition' => [
								'overlay_image_type' => 'photo',
							],
						]
					);
					$this->add_responsive_control(
						'overlay_image_size_hover',
						[
							'label'      => __( 'Overlay Image Width', 'uael' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', 'rem' ],
							'range'      => [
								'px' => [
									'min' => 1,
									'max' => 2000,
								],
							],
							'default'    => [
								'size' => 50,
								'unit' => 'px',
							],
							'condition'  => [
								'overlay_image_type' => 'photo',
							],
							'selectors'  => [
								'{{WRAPPER}} .uael-grid-gallery-img .uael-grid-img-overlay img' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Layout Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_caption_controls() {
		$this->start_controls_section(
			'section_design_caption',
			[
				'label'     => __( 'Caption', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'gallery_caption!' => '',
				],
			]
		);

			$this->add_control(
				'caption_alignment',
				[
					'label'       => __( 'Text Alignment', 'uael' ),
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
					'default'     => 'center',
					'selectors'   => [
						'{{WRAPPER}} .uael-img-gallery-wrap .uael-grid-img-caption' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						'gallery_caption!' => '',
					],
				]
			);
			$this->add_control(
				'caption_valign',
				[
					'label'        => __( 'Vertical Alignment', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'bottom',
					'options'      => [
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
					'condition'    => [
						'gallery_caption!' => '',
					],
					'prefix_class' => 'uael-img-caption-valign-',
				]
			);
			$this->add_control(
				'caption_tag',
				[
					'label'     => __( 'HTML Tag', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'  => 'H1',
						'h2'  => 'H2',
						'h3'  => 'H3',
						'h4'  => 'H4',
						'h5'  => 'H5',
						'h6'  => 'H6',
						'div' => 'div',
					],
					'default'   => 'h4',
					'condition' => [
						'gallery_caption!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'caption_typography',
					'label'     => __( 'Typography', 'uael' ),
					'selector'  => '{{WRAPPER}} .uael-grid-img-caption .uael-grid-caption-text',
					'condition' => [
						'gallery_caption!' => '',
					],
				]
			);

			$this->add_control(
				'caption_text_color',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-grid-img-caption .uael-grid-caption-text' => 'color: {{VALUE}};',
					],
					'condition' => [
						'gallery_caption!' => '',
					],
				]
			);

			$this->add_control(
				'caption_background_color',
				[
					'label'     => __( 'Background', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-grid-img-caption' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'gallery_caption!' => '',
					],
				]
			);

			$this->add_responsive_control(
				'caption_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-grid-img-caption'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'gallery_caption!' => '',
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
					'navigation'    => [ 'arrows', 'dots', 'both' ],
					'gallery_style' => 'carousel',
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
					'navigation'    => [ 'arrows', 'both' ],
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'        => __( 'Arrows Position', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'outside',
				'options'      => [
					'inside'  => __( 'Inside', 'uael' ),
					'outside' => __( 'Outside', 'uael' ),
				],
				'prefix_class' => 'uael-img-carousel-arrow-',
				'condition'    => [
					'navigation'    => [ 'arrows', 'both' ],
					'gallery_style' => 'carousel',
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
					'{{WRAPPER}} .slick-slider .slick-prev:before, {{WRAPPER}} .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation'    => [ 'arrows', 'both' ],
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Arrows Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slick-slider .slick-prev:before, {{WRAPPER}} .slick-slider .slick-next:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation'    => [ 'arrows', 'both' ],
					'gallery_style' => 'carousel',
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
					'navigation'    => [ 'dots', 'both' ],
					'gallery_style' => 'carousel',
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
					'{{WRAPPER}} .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation'    => [ 'dots', 'both' ],
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Dots Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation'    => [ 'dots', 'both' ],
					'gallery_style' => 'carousel',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Category Filters Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_style_cat_filters_controls() {

		$this->start_controls_section(
			'section_style_cat_filters',
			[
				'label'     => __( 'Filterable Tabs', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
					'masonry_filters_enable' => 'yes',
				],
			]
		);
			$this->add_responsive_control(
				'cat_filter_align',
				[
					'label'        => __( 'Tab Alignment', 'uael' ),
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
					'toggle'       => false,
					'render_type'  => 'template',
					'prefix_class' => 'uael%s-gallery-filter-align-',
					'selectors'    => [
						'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters' => 'text-align: {{VALUE}};',
					],
					'condition'    => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'all_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'condition' => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
					'selector'  => '{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter,{{WRAPPER}} .uael-img-gallery-tabs-dropdown .uael-filters-dropdown-button',
				]
			);
			$this->add_responsive_control(
				'cat_filter_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'cat_filter_bet_spacing',
				[
					'label'     => __( 'Spacing Between Tabs', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .uael-gallery-parent .uael-img-gallery-tabs-dropdown .uael-masonry-filters .uael-masonry-filter' => 'margin-left: 0px; margin-right: 0px;',
					],
					'condition' => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'cat_filter_spacing',
				[
					'label'     => __( 'Tabs Bottom Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
					'separator' => 'after',
				]
			);

			$this->start_controls_tabs( 'cat_filters_tabs_style' );

			$this->start_controls_tab(
				'cat_filters_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);

				$this->add_control(
					'cat_filter_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-img-gallery-tabs-dropdown .uael-filters-dropdown-button, {{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter' => 'color: {{VALUE}};',
						],
						'condition' => [
							'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
							'masonry_filters_enable' => 'yes',
						],
					]
				);

				$this->add_control(
					'cat_filter_bg_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter, {{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-filters-dropdown-button' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
							'masonry_filters_enable' => 'yes',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'cat_filter_border',
						'label'     => __( 'Border', 'uael' ),
						'selector'  => '{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter, {{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-filters-dropdown-button',
						'condition' => [
							'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
							'masonry_filters_enable' => 'yes',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'cat_filters_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
						'masonry_filters_enable' => 'yes',
					],
				]
			);

				$this->add_control(
					'cat_filter_hover_color',
					[
						'label'     => __( 'Text Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter:hover, {{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-current' => 'color: {{VALUE}};',
						],
						'condition' => [
							'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
							'masonry_filters_enable' => 'yes',
						],
					]
				);

				$this->add_control(
					'cat_filter_bg_hover_color',
					[
						'label'     => __( 'Background Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter:hover, {{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-current' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'gallery_style'          => [ 'grid', 'masonry', 'justified' ],
							'masonry_filters_enable' => 'yes',
						],
					]
				);

				$this->add_control(
					'cat_filter_border_hover_color',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-masonry-filter:hover, {{WRAPPER}} .uael-gallery-parent .uael-masonry-filters .uael-current' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'gallery_style'             => [ 'grid', 'masonry', 'justified' ],
							'masonry_filters_enable'    => 'yes',
							'cat_filter_border_border!' => '',
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
	 * @since 0.0.1
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
				'help_doc_0',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/image-gallery-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=7Q-3fAKKhbg&index=11&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Design filterable Image Gallery » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-design-filterable-image-gallery/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Open lightbox on the click of an image » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/image-gallery-widget/#open-lightbox" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Open a webpage on the click of an image » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-open-a-webpage-with-the-click-of-an-image/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Apply scale, opacity, overlay, effects to images » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-customize-images/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Display specific category tab as a default on page load » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/display-specific-category-tab-as-a-default/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_7',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Set icon on image hover » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-icon-on-image-hover/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}
	/**
	 * Render Image thumbnail.
	 *
	 * @param array $image Image object.
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render_image_thumbnail( $image ) {

		$settings                = $this->get_settings();
		$settings['image_index'] = $image;
		$output                  = '<div class="uael-grid-img-thumbnail uael-ins-target">';
		$output                 .= Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'image_index' );
		$output                 .= '</div>';

		return $output;
	}

	/**
	 * Render Image Overlay.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render_image_overlay() {

		$settings = $this->get_settings();

		$output = '<div class="uael-grid-img-overlay">';

		if ( 'icon' === $settings['overlay_image_type'] ) {

			if ( '' !== $settings['overlay_icon_hover'] ) {
				$output .= '<i class="uael-overlay-icon ' . $settings['overlay_icon_hover'] . '"></i>';
			}
		} elseif ( 'photo' === $settings['overlay_image_type'] ) {

			if ( ! empty( $settings['overlay_image_hover']['url'] ) ) {
				$output .= '<img class="uael-overlay-img" src="' . $settings['overlay_image_hover']['url'] . '" alt="' . Control_Media::get_image_alt( $settings['overlay_image_hover'] ) . '">';
			}
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Render Image caption.
	 *
	 * @param array $image Image object.
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render_image_caption( $image ) {

		$settings = $this->get_settings();

		if ( '' === $settings['gallery_caption'] || ! $image['caption'] ) {
			return;
		}

		$output              = '<figcaption class="uael-grid-img-content">';
			$output         .= '<div class="uael-grid-img-caption">';
				$output     .= '<' . $settings['caption_tag'] . ' class="uael-grid-caption-text">';
					$output .= $image['caption'];
				$output     .= '</' . $settings['caption_tag'] . '>';
			$output         .= '</div>';
		$output             .= '</figcaption>';

		return $output;
	}

	/**
	 * Render Gallery Inner Data.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render_gallery_inner_data() {
		$settings = $this->get_settings_for_display();

		$images = $this->get_wp_gallery_image_data( $settings['wp_gallery'] );

		$this->render_gallery_image( $images );
	}

	/**
	 * Get WordPress Gallery Data.
	 *
	 * @since 0.0.1
	 * @param array $images raw array of images.
	 * @access protected
	 */
	protected function get_wp_gallery_image_data( $images ) {

		$gallery = $images;

		foreach ( $images as $i => $data ) {

			$gallery[ $i ]['custom_link'] = get_post_meta( $data['id'], 'uael-custom-link', true );
		}

		return $gallery;
	}

	/**
	 * Render Gallery Images.
	 *
	 * @since 0.0.1
	 * @param array $images array of images.
	 * @access protected
	 */
	protected function render_gallery_image( $images ) {

		$settings       = $this->get_settings();
		$gallery        = $images;
		$img_size       = $settings['image_size'];
		$new_gallery    = array();
		$output         = '';
		$cat_filter     = array();
		$tab_responsive = ( 'yes' == $settings['tabs_dropdown'] ) ? ' uael-img-gallery-tabs-dropdown' : '';

		if ( ! is_array( $gallery ) ) {
			return;
		}

		if ( 'rand' === $settings['gallery_rand'] ) {

			$keys = array_keys( $gallery );
			shuffle( $keys );

			foreach ( $keys as $key ) {
				$new_gallery[ $key ] = $gallery[ $key ];
			}
		} else {
			$new_gallery = $gallery;
		}

		$click_action = $settings['click_action'];
		$img_wrap_tag = 'figure';

		foreach ( $new_gallery as $index => $item ) {

			$image = UAEL_Helper::get_image_data( $item['id'], $item['url'], $img_size );

			$image_cat = array();

			$image_link = wp_get_attachment_image_src( $item['id'], 'full' );

			if ( empty( $image ) || false === $image_link ) {
				continue;
			}

			if ( ( 'grid' === $settings['gallery_style'] || 'masonry' === $settings['gallery_style'] || 'justified' === $settings['gallery_style'] ) && 'yes' === $settings['masonry_filters_enable'] ) {
				$cat = get_post_meta( $item['id'], 'uael-categories', true );

				if ( '' !== $cat ) {
					$cat_arr = explode( ',', $cat );

					foreach ( $cat_arr as $value ) {
						$cat      = trim( $value );
						$cat_slug = strtolower( str_replace( ' ', '-', $cat ) );

						$image_cat[]             = $cat_slug;
						$cat_filter[ $cat_slug ] = $cat;
					}
				}
			}

			$this->add_render_attribute(
				'grid-media-' . $index,
				'class',
				[
					'uael-grid-img',
					'uael-grid-gallery-img',
					'uael-ins-hover',
				]
			);

			if ( '' !== $click_action ) {

				$img_wrap_tag = 'a';
				$item_link    = 'javascript:void(0);';
				$lightbox     = 'no';

				if ( 'lightbox' === $click_action ) {

					if ( $item['id'] ) {
						$item_link = $image_link;
						$item_link = $item_link[0];
					} else {
						$item_link = $item['url'];
					}

					$lightbox = 'yes';
				} elseif ( 'file' === $click_action ) {

					if ( $item['id'] ) {
						$item_link = $image_link;
						$item_link = $item_link[0];
					} else {
						$item_link = $item['url'];
					}
				} elseif ( 'attachment' === $click_action ) {

					$item_link = get_permalink( $item['id'] );

				} elseif ( 'custom' === $click_action ) {

					if ( ! empty( $item['custom_link'] ) ) {

						$item_link = $item['custom_link'];
					}
				}

				$this->add_render_attribute(
					'grid-media-' . $index,
					[
						'class'                        => 'elementor-clickable',
						'data-elementor-open-lightbox' => $lightbox,
						'data-elementor-lightbox-slideshow' => $this->get_id(),
					]
				);

				if ( 'carousel' === $settings['gallery_style'] ) {
					$this->add_render_attribute(
						'grid-media-' . $index,
						[
							'data-elementor-lightbox-index' => $index,
						]
					);
				}

				if ( 'file' === $click_action || 'attachment' === $click_action || ( 'custom' === $click_action && '' !== $item_link ) ) {

					$link_target = $settings['link_target'];

					$this->add_render_attribute( 'grid-media-' . $index, 'target', $link_target );

					if ( '_blank' === $link_target ) {
						$this->add_render_attribute( 'grid-media-' . $index, 'rel', 'nofollow' );
					}
				}

				$this->add_render_attribute( 'grid-media-' . $index, 'href', $item_link );
			}

			if ( 'justified' === $settings['gallery_style'] ) {
				$output         .= '<div class="uael-grid-item ' . implode( ' ', $image_cat ) . '">';
					$output     .= '<div class="uael-grid-item-content">';
						$output .= '<' . $img_wrap_tag . ' ' . $this->get_render_attribute_string( 'grid-media-' . $index ) . '>';

							$output .= $this->render_image_thumbnail( $image );

							$output .= $this->render_image_overlay();

						$output .= '</' . $img_wrap_tag . '>';

						$output .= $this->render_image_caption( $image );

					$output .= '</div>';
				$output     .= '</div>';
			} else {
				$output         .= '<div class="uael-grid-item ' . implode( ' ', $image_cat ) . ' uael-img-gallery-item-' . ( $index + 1 ) . '">';
					$output     .= '<div class="uael-grid-item-content">';
						$output .= '<' . $img_wrap_tag . ' ' . $this->get_render_attribute_string( 'grid-media-' . $index ) . '>';

							$output .= $this->render_image_thumbnail( $image );

							$output .= $this->render_image_overlay();

						$output .= '</' . $img_wrap_tag . '>';

						$output .= $this->render_image_caption( $image );

					$output .= '</div>';
				$output     .= '</div>';
			}
		}

		if ( ( 'grid' === $settings['gallery_style'] || 'masonry' === $settings['gallery_style'] || 'justified' === $settings['gallery_style'] ) && 'yes' === $settings['masonry_filters_enable'] ) {

			ksort( $cat_filter );
			$cat_filter = apply_filters( 'uael_image_gallery_tabs', $cat_filter );

			$default_cat = '';

			if ( 'yes' === $settings['default_filter_switch'] && '' !== $settings['default_filter'] ) {
				$default_cat = '.' . trim( $settings['default_filter'] );
				$default_cat = strtolower( str_replace( ' ', '-', $default_cat ) );
			}

			$filters_output = '<div class="uael-masonry-filters-wrapper' . $tab_responsive . '">';

				$filters_output     .= '<div class="uael-masonry-filters" data-default="' . $default_cat . '">';
					$filters_output .= '<div class="uael-masonry-filter uael-current" data-filter="*">' . $settings['filters_all_text'] . '</div>';

			foreach ( $cat_filter as $key => $value ) {
				$filters_output .= '<div class="uael-masonry-filter" data-filter=".' . $key . '">' . $value . '</div>';
			}

				$filters_output .= '</div>';

			if ( 'yes' == $settings['tabs_dropdown'] ) {

				$filters_output .= '<div class="uael-filters-dropdown uael-masonry-filters" data-default="' . $default_cat . '">';

					$filters_output .= '<div class="uael-filters-dropdown-button">' . $settings['filters_all_text'] . '</div>';

					$filters_output .= '<ul class="uael-filters-dropdown-list">';

						$filters_output .= '<li class="uael-filters-dropdown-item uael-masonry-filter uael-current" data-filter="*">' . $settings['filters_all_text'] . '</li>';

				foreach ( $cat_filter as $key => $value ) {
					$filters_output .= '<li class="uael-filters-dropdown-item uael-masonry-filter" data-filter=".' . $key . '">' . $value . '</li>';
				}

					$filters_output .= '</ul>';
					$filters_output .= '</div>';
			}

			$filters_output .= '</div>';

			echo $filters_output;
		}

		echo '<div ' . $this->get_render_attribute_string( 'grid-wrap' ) . '>';
			echo $output;
		echo '</div>';
	}

	/**
	 * Render Masonry Script.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render_editor_script() {

		?><script type="text/javascript">
			jQuery( document ).ready( function( $ ) {

				$( '.uael-img-grid-masonry-wrap' ).each( function() {

					var $node_id 	= '<?php echo $this->get_id(); ?>';
					var	scope 		= $( '[data-id="' + $node_id + '"]' );
					var selector 	= $(this);

					if ( selector.closest( scope ).length < 1 ) {
						return;
					}

					var $justified_selector	= scope.find('.uael-img-justified-wrap');
					var row_height	= $justified_selector.data( 'rowheight' );
					var lastrow		= $justified_selector.data( 'lastrow' );
					var layoutMode = 'fitRows';
					var filter_cat;

					if ( selector.hasClass('uael-masonry') ) {
						layoutMode = 'masonry';
					}

					var filters = scope.find('.uael-masonry-filters');
					var def_cat = '*';

					if ( filters.length > 0 ) {

						var def_filter = filters.attr('data-default');

						if ( '' !== def_filter ) {

							def_cat 	= def_filter;
							def_cat_sel = filters.find('[data-filter="'+def_filter+'"]');

							if ( def_cat_sel.length > 0 ) {
								def_cat_sel.siblings().removeClass('uael-current');
								def_cat_sel.addClass('uael-current');
							}
						}
					}
					if ( $justified_selector.length > 0 ) {
						$justified_selector.imagesLoaded( function() {
						})
						.done(function( instance ) {
							$justified_selector.justifiedGallery({
								filter: def_cat,
								rowHeight : row_height,
								lastRow : lastrow,
								selector : 'div',
							});
						});
					} else {
						var masonryArgs = {
							// set itemSelector so .grid-sizer is not used in layout
							filter 			: def_cat,
							itemSelector	: '.uael-grid-item',
							percentPosition : true,
							layoutMode		: layoutMode,
							hiddenStyle 	: {
								opacity 	: 0,
							},
						};

						var $isotopeObj = {};

						selector.imagesLoaded( function() {

							$isotopeObj = selector.isotope( masonryArgs );

							selector.find('.uael-grid-item').resize( function() {
								$isotopeObj.isotope( 'layout' );
							});
						});
					}

					if ( selector.hasClass('uael-cat-filters') ) {
						// bind filter button click
						scope.on( 'click', '.uael-masonry-filter', function() {

							var $this 		= $(this);
							var filterValue = $this.attr('data-filter');

							$this.siblings().removeClass('uael-current');
							$this.addClass('uael-current');
							if( '*' === filterValue ) {
								filter_cat = scope.find('.uael-img-gallery-wrap').data('filter-default');
							} else {
								filter_cat = filterValue.substr(1);
							}
							scope.find('.uael-filters-dropdown-button').text( filter_cat.toUpperCase() );

							if ( $justified_selector.length > 0 ) {
								$justified_selector.justifiedGallery({
									filter: filterValue,
									rowHeight : row_height,
									lastRow : lastrow,
									selector : 'div',
								});
							} else {
								$isotopeObj.isotope({ filter: filterValue });
							}
						});
					}
				});
			});
		</script>
		<?php
	}

	/**
	 * Get Wrapper Classes.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function get_carousel_attr() {

		$settings = $this->get_settings();

		if ( 'carousel' !== $settings['gallery_style'] ) {
			return;
		}

		$is_rtl      = is_rtl();
		$direction   = $is_rtl ? 'rtl' : 'ltr';
		$show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slick_options = [
			'slidesToShow'   => ( $settings['slides_to_show'] ) ? absint( $settings['slides_to_show'] ) : 4,
			'slidesToScroll' => ( $settings['slides_to_scroll'] ) ? absint( $settings['slides_to_scroll'] ) : 1,
			'autoplaySpeed'  => ( $settings['autoplay_speed'] ) ? absint( $settings['autoplay_speed'] ) : 5000,
			'autoplay'       => ( 'yes' === $settings['autoplay'] ),
			'infinite'       => ( 'yes' === $settings['infinite'] ),
			'pauseOnHover'   => ( 'yes' === $settings['pause_on_hover'] ),
			'speed'          => ( $settings['transition_speed'] ) ? absint( $settings['transition_speed'] ) : 500,
			'arrows'         => $show_arrows,
			'dots'           => $show_dots,
			'rtl'            => $is_rtl,
		];

		if ( $settings['slides_to_show_tablet'] || $settings['slides_to_show_mobile'] ) {

			$slick_options['responsive'] = [];

			if ( $settings['slides_to_show_tablet'] ) {

				$tablet_show   = absint( $settings['slides_to_show_tablet'] );
				$tablet_scroll = ( $settings['slides_to_scroll_tablet'] ) ? absint( $settings['slides_to_scroll_tablet'] ) : $tablet_show;

				$slick_options['responsive'][] = [
					'breakpoint' => 1024,
					'settings'   => [
						'slidesToShow'   => $tablet_show,
						'slidesToScroll' => $tablet_scroll,
					],
				];
			}

			if ( $settings['slides_to_show_mobile'] ) {

				$mobile_show   = absint( $settings['slides_to_show_mobile'] );
				$mobile_scroll = ( $settings['slides_to_scroll_mobile'] ) ? absint( $settings['slides_to_scroll_mobile'] ) : $mobile_show;

				$slick_options['responsive'][] = [
					'breakpoint' => 767,
					'settings'   => [
						'slidesToShow'   => $mobile_show,
						'slidesToScroll' => $mobile_scroll,
					],
				];
			}
		}

		$slick_options = apply_filters( 'uael_image_gallery_carousel_options', $slick_options );

		$this->add_render_attribute(
			'grid-wrap',
			[
				'data-image_carousel' => wp_json_encode( $slick_options ),
			]
		);
	}

	/**
	 * Render ImageGallery output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render() {

		$settings    = $this->get_settings();
		$node_id     = $this->get_id();
		$is_editor   = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$row_height  = '';
		$unjustified = '';
		$row_margin  = '';

		$wrap_class = [
			'uael-img-gallery-wrap',
			'uael-img-' . $settings['gallery_style'] . '-wrap',
		];

		if ( 'grid' === $settings['gallery_style'] || 'masonry' === $settings['gallery_style'] || 'justified' === $settings['gallery_style'] ) {
			$wrap_class[] = 'uael-img-grid-masonry-wrap';

			if ( 'masonry' === $settings['gallery_style'] ) {
				$wrap_class[] = 'uael-masonry';
			}

			if ( 'yes' === $settings['masonry_filters_enable'] ) {
				$wrap_class[] = 'uael-cat-filters';
			}
		}

		if ( 'carousel' === $settings['gallery_style'] ) {
			$wrap_class[] = 'uael-nav-' . $settings['navigation'];
			$this->get_carousel_attr();
		}

		$this->add_render_attribute( 'grid-wrap', 'class', $wrap_class );
		$this->add_render_attribute( 'grid-wrap', 'data-filter-default', $settings['filters_all_text'] );

		if ( 'justified' === $settings['gallery_style'] ) {

			$row_height = ( '' != $settings['justified_row_height']['size'] ) ? $settings['justified_row_height']['size'] : 120;

			$this->add_render_attribute(
				'grid-wrap',
				[
					'data-rowheight' => $row_height,
					'data-lastrow'   => $settings['last_row'],
				]
			);
		}

		if ( 'justified' != $settings['gallery_style'] ) {
			$unjustified = 'uael-gallery-unjustified';
		}

		echo '<div class="uael-gallery-parent uael-caption-' . $settings['gallery_caption'] . ' ' . $unjustified . '">';

			$this->render_gallery_inner_data();

		echo '</div>';

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {

			if ( ( 'grid' === $settings['gallery_style'] && 'yes' === $settings['masonry_filters_enable'] ) || 'masonry' === $settings['gallery_style'] || 'justified' === $settings['gallery_style'] ) {

				/* Scripts will load for editor changes */
				$this->render_editor_script();
			}
		}
	}
}

