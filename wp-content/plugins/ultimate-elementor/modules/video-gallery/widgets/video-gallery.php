<?php
/**
 * UAEL Video_Gallery.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\VideoGallery\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use Elementor\Widget_Button;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Control_Media;
use Elementor\Modules\DynamicTags\Module as TagsModule;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Classes\UAEL_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Video_Gallery.
 */
class Video_Gallery extends Common_Widget {

	/**
	 * Retrieve Video_Gallery Widget name.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Video_Gallery' );
	}

	/**
	 * Retrieve Video_Gallery Widget title.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Video_Gallery' );
	}

	/**
	 * Retrieve Video_Gallery Widget icon.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Video_Gallery' );
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
		return parent::get_widget_keywords( 'Video_Gallery' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [
			'uael-isotope',
			'uael-frontend-script',
			'uael-fancybox',
			'imagesloaded',
			'jquery-slick',
			'uael-element-resize',
		];
	}

	/**
	 * Register Buttons controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function _register_controls() {

		// Content Tab.
		$this->register_video_gallery_controls();
		$this->register_video_general_controls();
		$this->register_video_filter_setting_controls();
		$this->register_carousel_controls();
		$this->register_helpful_information();

		// Style Tab.
		$this->register_style_layout_controls();
		$this->register_style_title_filter_controls();
		$this->register_style_filter_controls();
		$this->register_style_play_controls();
		$this->register_style_caption_controls();
		$this->register_style_navigation_controls();
	}

	/**
	 * Register Gallery General Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_video_gallery_controls() {

		$this->start_controls_section(
			'section_gallery',
			[
				'label' => __( 'Gallery', 'uael' ),
			]
		);

			$vimeo = apply_filters( 'uael_video_gallery_vimeo_link', 'https://vimeo.com/274860274' );

			$youtube = apply_filters( 'uael_video_gallery_youtube_link', 'https://www.youtube.com/watch?v=HJRzUQMhJMQ' );

			$this->add_control(
				'gallery_items',
				[
					'label'       => '',
					'type'        => Controls_Manager::REPEATER,
					'show_label'  => true,
					'fields'      => [
						[
							'name'    => 'type',
							'label'   => __( 'Video Type', 'uael' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'youtube',
							'options' => [
								'youtube' => __( 'YouTube Video', 'uael' ),
								'vimeo'   => __( 'Vimeo Video', 'uael' ),
							],
						],
						[
							'name'        => 'video_url',
							'label'       => __( 'Video URL', 'uael' ),
							'type'        => Controls_Manager::TEXT,
							'label_block' => true,
							'dynamic'     => [
								'active'     => true,
								'categories' => [
									TagsModule::POST_META_CATEGORY,
									TagsModule::URL_CATEGORY,
								],
							],
						],
						[
							'name'            => 'youtube_link_doc',
							'type'            => Controls_Manager::RAW_HTML,
							/* translators: %1$s doc link */
							'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the share URL.</br></br><b>Valid:</b>&nbsp;https://www.youtube.com/watch?v=HJRzUQMhJMQ</br><b>Invalid:</b>&nbsp;https://youtu.be/HJRzUQMhJMQ', 'uael' ) ),
							'content_classes' => 'uael-editor-doc',
							'condition'       => [
								'type' => 'youtube',
							],
							'separator'       => 'none',
						],
						[
							'name'            => 'vimeo_link_doc',
							'type'            => Controls_Manager::RAW_HTML,
							/* translators: %1$s doc link */
							'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the categorized URL.</br></br><b>Valid:</b>&nbsp;https://vimeo.com/274860274</br><b>Invalid:</b>&nbsp;https://vimeo.com/channels/staffpicks/274860274', 'uael' ) ),
							'content_classes' => 'uael-editor-doc',
							'condition'       => [
								'type' => 'vimeo',
							],
							'separator'       => 'none',
						],
						[
							'name'        => 'title',
							'label'       => __( 'Caption', 'uael' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => '',
							'label_block' => true,
							'dynamic'     => [
								'active' => true,
							],
							'title'       => __( 'This title will be visible on hover.', 'uael' ),
						],
						[
							'name'        => 'tags',
							'label'       => __( 'Categories', 'uael' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => '',
							'label_block' => true,
							'dynamic'     => [
								'active' => true,
							],
							'title'       => __( 'Add comma separated categories. These categories will be shown for filteration.', 'uael' ),
						],
						[
							'name'      => 'yt_thumbnail_size',
							'label'     => __( 'Thumbnail Size', 'uael' ),
							'type'      => Controls_Manager::SELECT,
							'options'   => [
								'maxresdefault' => __( 'Maximum Resolution', 'uael' ),
								'hqdefault'     => __( 'High Quality', 'uael' ),
								'mqdefault'     => __( 'Medium Quality', 'uael' ),
								'sddefault'     => __( 'Standard Quality', 'uael' ),
							],
							'default'   => 'hqdefault',
							'condition' => [
								'type' => 'youtube',
							],
						],
						[
							'name'         => 'custom_placeholder',
							'label'        => __( 'Custom Thumbnail', 'uael' ),
							'type'         => Controls_Manager::SWITCHER,
							'default'      => '',
							'label_on'     => __( 'Yes', 'uael' ),
							'label_off'    => __( 'No', 'uael' ),
							'return_value' => 'yes',
						],
						[
							'name'        => 'placeholder_image',
							'label'       => __( 'Select Image', 'uael' ),
							'type'        => Controls_Manager::MEDIA,
							'default'     => [
								'url' => Utils::get_placeholder_image_src(),
							],
							'description' => __( 'This image will act as a placeholder image for the video.', 'uael' ),
							'dynamic'     => [
								'active' => true,
							],
							'condition'   => [
								'custom_placeholder' => 'yes',
							],
						],
					],
					'default'     => [
						[
							'type'              => 'youtube',
							'video_url'         => $youtube,
							'title'             => __( 'First Video', 'uael' ),
							'tags'              => 'YouTube',
							'placeholder_image' => '',
						],
						[
							'type'              => 'vimeo',
							'video_url'         => $vimeo,
							'title'             => __( 'Second Video', 'uael' ),
							'tags'              => 'Vimeo',
							'placeholder_image' => '',
						],
						[
							'type'              => 'youtube',
							'video_url'         => $youtube,
							'title'             => __( 'Third Video', 'uael' ),
							'tags'              => 'YouTube',
							'placeholder_image' => '',
						],
						[
							'type'              => 'vimeo',
							'video_url'         => $vimeo,
							'title'             => __( 'Fourth Video', 'uael' ),
							'tags'              => 'Vimeo',
							'placeholder_image' => '',
						],
						[
							'type'              => 'youtube',
							'video_url'         => $youtube,
							'title'             => __( 'Fifth Video', 'uael' ),
							'tags'              => 'YouTube',
							'placeholder_image' => '',
						],
						[
							'type'              => 'vimeo',
							'video_url'         => $vimeo,
							'title'             => __( 'Sixth Video', 'uael' ),
							'tags'              => 'Vimeo',
							'placeholder_image' => '',
						],
					],
					'title_field' => '{{{ title }}}',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Video Gallery General Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_video_general_controls() {

		$this->start_controls_section(
			'section_general',
			[
				'label' => __( 'General', 'uael' ),
			]
		);

			$this->add_control(
				'layout',
				[
					'label'   => __( 'Layout', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'grid'     => __( 'Grid', 'uael' ),
						'carousel' => __( 'Carousel', 'uael' ),
					],
					'default' => 'grid',
				]
			);

			$this->add_responsive_control(
				'gallery_columns',
				[
					'label'          => __( 'Columns', 'uael' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => '3',
					'tablet_default' => '2',
					'mobile_default' => '1',
					'options'        => [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
					'prefix_class'   => 'uael-video-gallery%s__column-',
					'render_type'    => 'template',
				]
			);

			$this->add_control(
				'video_ratio',
				[
					'label'   => __( 'Aspect Ratio', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'16_9' => '16:9',
						'4_3'  => '4:3',
						'3_2'  => '3:2',
					],
					'default' => '16_9',
				]
			);

			$this->add_control(
				'click_action',
				[
					'label'   => __( 'Click Action', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'lightbox' => 'Play in Lighbox',
						'inline'   => 'Play Inline',
					],
					'default' => 'lightbox',
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

		$this->end_controls_section();
	}

	/**
	 * Register Video Filters General Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_video_filter_setting_controls() {

		$this->start_controls_section(
			'section_filter_content',
			[
				'label'     => __( 'Filterable Tabs', 'uael' ),
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label'        => __( 'Filterable Video Gallery', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'label_off'    => __( 'No', 'uael' ),
				'label_on'     => __( 'Yes', 'uael' ),
				'condition'    => [
					'layout' => 'grid',
				],
			]
		);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'video_filters_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s admin link */
					'raw'             => sprintf( __( 'Learn : %1$sHow to design filterable Video Gallery?%2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-design-filterable-video-gallery/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'layout'      => 'grid',
						'show_filter' => 'yes',
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
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'layout'      => 'grid',
						'show_filter' => 'yes',
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
						'layout'      => 'grid',
						'show_filter' => 'yes',
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
						'default_filter_switch' => 'yes',
						'layout'                => 'grid',
						'show_filter'           => 'yes',
					],
				]
			);

		if ( parent::is_internal_links() ) {

			$this->add_control(
				'default_filter_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s admin link */
					'raw'             => sprintf( __( 'Note: Enter the category name that you wish to set as a default on page load. Read %1$s this article %2$s for more information.', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-display-specific-video-category-tab-as-a-default-on-page-load/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'default_filter_switch' => 'yes',
						'layout'                => 'grid',
						'show_filter'           => 'yes',
					],
				]
			);
		}

		$this->add_control(
			'show_filter_title',
			[
				'label'        => __( 'Title for Filterable Tab', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'label_off'    => __( 'No', 'uael' ),
				'label_on'     => __( 'Yes', 'uael' ),
				'condition'    => [
					'layout'      => 'grid',
					'show_filter' => 'yes',
				],
			]
		);

		$this->add_control(
			'filters_heading_text',
			[
				'label'     => __( 'Title Text', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'My Videos', 'uael' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'layout'            => 'grid',
					'show_filter'       => 'yes',
					'show_filter_title' => 'yes',
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
					'layout'      => 'grid',
					'show_filter' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Slider Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_carousel_controls() {

		$this->start_controls_section(
			'section_slider_options',
			[
				'label'     => __( 'Carousel', 'uael' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => [
					'layout' => 'carousel',
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
				'autoplay',
				[
					'label'        => __( 'Autoplay', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'no',
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
				'pause_on_hover',
				[
					'label'        => __( 'Pause on Hover', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'autoplay' => 'yes',
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/video-gallery-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_01',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=88kTeBv4mWY" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Set categories for videos » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-categories-for-videos/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Display specific video category tab as a default on page load » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-display-specific-video-category-tab-as-a-default-on-page-load/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Design filterable Video Gallery » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-design-filterable-video-gallery/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Set a custom placeholder image for the video » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-a-custom-placeholder-image-for-the-video/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Set overlay color on the video thumbnail on mouse hover » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-set-overlay-color-on-the-video-thumbnail-on-mouse-hover/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Show video caption on hover » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-show-video-caption-on-hover/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Style Tab
	 */
	/**
	 * Register Layout Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_style_layout_controls() {

		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => __( 'Spacing', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'column_gap',
				[
					'label'     => __( 'Columns Gap', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 10,
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-video__gallery-item' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
						'{{WRAPPER}} .uael-video-gallery-wrap' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
						'{{WRAPPER}} .uael-vg__overlay' => 'width: calc(100% - {{SIZE}}{{UNIT}}); left: calc({{SIZE}}{{UNIT}}/2);',
					],
				]
			);

			$this->add_responsive_control(
				'row_gap',
				[
					'label'     => __( 'Rows Gap', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 10,
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'condition' => [
						'layout' => 'grid',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-video__gallery-item' => 'padding-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .uael-vg__overlay' => 'height: calc( 100% - {{SIZE}}{{UNIT}} );',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Category Filters Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_style_title_filter_controls() {
		$this->start_controls_section(
			'section_style_title_filters',
			[
				'label'     => __( 'Title', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter'       => 'yes',
					'layout'            => 'grid',
					'show_filter_title' => 'yes',
				],
			]
		);

			$this->add_control(
				'filter_title_tag',
				[
					'label'     => __( 'HTML Tag', 'uael' ),
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
					'default'   => 'h3',
					'condition' => [
						'layout'            => 'grid',
						'show_filter'       => 'yes',
						'show_filter_title' => 'yes',
					],
				]
			);

			$this->add_control(
				'filter_title_color',
				[
					'label'     => __( 'Title Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-video-gallery-title-text' => 'color: {{VALUE}};',
					],
					'condition' => [
						'layout'            => 'grid',
						'show_filter'       => 'yes',
						'show_filter_title' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'filter_title_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'selector'  => '{{WRAPPER}} .uael-video-gallery-title-text',
					'condition' => [
						'layout'            => 'grid',
						'show_filter'       => 'yes',
						'show_filter_title' => 'yes',
					],
				]
			);

			$this->add_control(
				'filters_tab_heading_stack',
				[
					'label'        => __( 'Stack On', 'uael' ),
					'description'  => __( 'Choose at what breakpoint the Title & Filter Tabs will stack.', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'mobile',
					'options'      => [
						'none'   => __( 'None', 'uael' ),
						'tablet' => __( 'Tablet (1023px >)', 'uael' ),
						'mobile' => __( 'Mobile (767px >)', 'uael' ),
					],
					'condition'    => [
						'layout'            => 'grid',
						'show_filter'       => 'yes',
						'show_filter_title' => 'yes',
					],
					'prefix_class' => 'uael-video-gallery-stack-',
				]
			);
		$this->end_controls_section();
	}

	/**
	 * Register Category Filters Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_style_filter_controls() {

		$this->start_controls_section(
			'section_style_cat_filters',
			[
				'label'     => __( 'Filterable Tabs', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter' => 'yes',
					'layout'      => 'grid',
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
					'prefix_class' => 'uael%s-vgallery-filter-align-',
					'selectors'    => [
						'{{WRAPPER}} .uael-video__gallery-filters' => 'text-align: {{VALUE}};',
						'(mobile){{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-filters-dropdown' => 'text-align: {{VALUE}};',
					],
					'condition'    => [
						'show_filter_title!' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'all_typography',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .uael-video__gallery-filter,{{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-filters-dropdown-button',
				]
			);
			$this->add_responsive_control(
				'cat_filter_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-video__gallery-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .uael-video__gallery-filter' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-video__gallery-filter' => 'margin-left: 0px; margin-right: 0px;',
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
						'{{WRAPPER}} .uael-video__gallery-filters' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-filters-dropdown' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'separator' => 'after',
				]
			);

			$this->start_controls_tabs( 'cat_filters_tabs_style' );

			$this->start_controls_tab(
				'cat_filters_normal',
				[
					'label' => __( 'Normal', 'uael' ),
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
							'{{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-filters-dropdown-button, {{WRAPPER}} .uael-video__gallery-filter' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'cat_filter_bg_color',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-filters-dropdown-button,{{WRAPPER}} .uael-video__gallery-filter' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'cat_filter_border',
						'label'    => __( 'Border', 'uael' ),
						'selector' => '{{WRAPPER}} .uael-video__gallery-filter,{{WRAPPER}} .uael-vgallery-tabs-dropdown .uael-filters-dropdown-button',
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'cat_filters_hover',
				[
					'label' => __( 'Hover', 'uael' ),
				]
			);

				$this->add_control(
					'cat_filter_hover_color',
					[
						'label'     => __( 'Text Active / Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .uael-video__gallery-filter:hover, {{WRAPPER}} .uael-video__gallery-filter.uael-filter__current' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .uael-video__gallery-filter:hover, {{WRAPPER}} .uael-video__gallery-filter.uael-filter__current' => 'background-color: {{VALUE}};',
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
							'{{WRAPPER}} .uael-video__gallery-filter:hover, {{WRAPPER}} .uael-video__gallery-filter.uael-filter__current' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'cat_filter_border_border!' => '',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Play Button Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_style_play_controls() {

		$this->start_controls_section(
			'section_design_play',
			[
				'label' => __( 'Play Button', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'play_source',
				[
					'label'   => __( 'Image/Icon', 'uael' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'img'  => [
							'title' => __( 'Image', 'uael' ),
							'icon'  => 'fa fa-picture-o',
						],
						'icon' => [
							'title' => __( 'Icon', 'uael' ),
							'icon'  => 'fa fa-info-circle',
						],
					],
					'default' => 'icon',
				]
			);

			$this->add_control(
				'play_img',
				[
					'label'     => __( 'Select Image', 'uael' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'play_source' => 'img',
					],
				]
			);

			$this->add_control(
				'play_icon',
				[
					'label'     => __( 'Select Icon', 'uael' ),
					'type'      => Controls_Manager::ICON,
					'default'   => 'fa fa-play',
					'condition' => [
						'play_source' => 'icon',
					],
				]
			);

			$this->add_responsive_control(
				'play_icon_size',
				[
					'label'          => __( 'Size', 'uael' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 60,
					],
					'tablet_default' => [
						'size' => 45,
					],
					'mobile_default' => [
						'size' => 35,
					],
					'range'          => [
						'size' => 30,
					],
					'range'          => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .uael-video__content i, {{WRAPPER}} .uael-video__content .uael-vg__play' => 'font-size: {{SIZE}}px;line-height: {{SIZE}}px;height: {{SIZE}}px;width: {{SIZE}}px;',
						'{{WRAPPER}} .uael-video__content img.uael-vg__play-image, {{WRAPPER}} .uael-video__content .uael-vg__play' => 'width: {{SIZE}}px;',
						'{{WRAPPER}} .uael-vg__play i.uael-vg__play-icon' => 'font-size: {{SIZE}}px;line-height: {{SIZE}}px;height: {{SIZE}}px;width: {{SIZE}}px;',
						'{{WRAPPER}} .uael-vg__play img.uael-vg__play-image' => 'width: {{SIZE}}px;',
						'{{WRAPPER}} .uael-vg__play' => 'width: {{SIZE}}px;',
					],
				]
			);

			$this->add_control(
				'hover_animation_img',
				[
					'label'     => __( 'Hover Animation', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''                => __( 'None', 'uael' ),
						'grow'            => __( 'Grow', 'uael' ),
						'shrink'          => __( 'Shrink', 'uael' ),
						'pulse'           => __( 'Pulse', 'uael' ),
						'pulse-grow'      => __( 'Pulse Grow', 'uael' ),
						'pulse-shrink'    => __( 'Pulse Shrink', 'uael' ),
						'push'            => __( 'Push', 'uael' ),
						'pop'             => __( 'Pop', 'uael' ),
						'float'           => __( 'Float', 'uael' ),
						'sink'            => __( 'Sink', 'uael' ),
						'wobble-vertical' => __( 'Wobble Vertical', 'uael' ),
					],
					'condition' => [
						'play_source' => 'img',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_style' );

				$this->start_controls_tab(
					'tab_normal',
					[
						'label'     => __( 'Normal', 'uael' ),
						'condition' => [
							'play_icon!'  => '',
							'play_source' => 'icon',
						],
					]
				);

					$this->add_control(
						'play_icon_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-video__content i' => 'color: {{VALUE}};',
								'{{WRAPPER}} .uael-vg__play i.uael-vg__play-icon'   => 'color: {{VALUE}};',
							],
							'default'   => '#ffffff',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Text_Shadow::get_type(),
						[
							'name'      => 'play_icon_text_shadow',
							'label'     => __( 'Icon Shadow', 'uael' ),
							'selector'  => '{{WRAPPER}} .uael-video__content i, {{WRAPPER}} .uael-vg__play i.uael-vg__play-icon',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_hover',
					[
						'label'     => __( 'Hover', 'uael' ),
						'condition' => [
							'play_icon!'  => '',
							'play_source' => 'icon',
						],
					]
				);

					$this->add_control(
						'play_icon_hover_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-video__gallery-item:hover .uael-vg__play i.uael-vg__play-icon, {{WRAPPER}} .uael-video__gallery-item:hover .uael-video__content i' => 'color: {{VALUE}}',
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Text_Shadow::get_type(),
						[
							'name'      => 'play_icon_hover_text_shadow',
							'label'     => __( 'Icon Shadow', 'uael' ),
							'selector'  => '{{WRAPPER}} .uael-video__gallery-item:hover .uael-vg__play i.uael-vg__play-icon, {{WRAPPER}} .uael-video__gallery-item:hover .uael-video__content i',
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

					$this->add_control(
						'hover_animation',
						[
							'label'     => __( 'Hover Animation', 'uael' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => '',
							'options'   => [
								''                => __( 'None', 'uael' ),
								'grow'            => __( 'Grow', 'uael' ),
								'shrink'          => __( 'Shrink', 'uael' ),
								'pulse'           => __( 'Pulse', 'uael' ),
								'pulse-grow'      => __( 'Pulse Grow', 'uael' ),
								'pulse-shrink'    => __( 'Pulse Shrink', 'uael' ),
								'push'            => __( 'Push', 'uael' ),
								'pop'             => __( 'Pop', 'uael' ),
								'float'           => __( 'Float', 'uael' ),
								'sink'            => __( 'Sink', 'uael' ),
								'wobble-vertical' => __( 'Wobble Vertical', 'uael' ),
							],
							'condition' => [
								'play_icon!'  => '',
								'play_source' => 'icon',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Caption Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_style_caption_controls() {

		$this->start_controls_section(
			'section_design_caption',
			[
				'label' => __( 'Content', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'overlay_background_color',
				[
					'label'     => __( 'Overlay Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-vg__overlay' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'overlay_background_hover_color',
				[
					'label'     => __( 'Overlay Hover Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-video__gallery-item:hover .uael-vg__overlay' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'caption_typo',
				[
					'label'     => __( 'Caption', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'show_caption',
				[
					'label'        => __( 'Show Caption on Hover', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'return_value' => 'yes',
					'label_off'    => __( 'No', 'uael' ),
					'label_on'     => __( 'Yes', 'uael' ),
				]
			);

			$this->add_control(
				'caption_color',
				[
					'label'     => __( 'Caption Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-video__caption' => 'color: {{VALUE}};',
					],
					'condition' => [
						'show_caption' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'caption_typography',
					'selector'  => '{{WRAPPER}} .uael-video__caption',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'condition' => [
						'show_caption' => 'yes',
					],
				]
			);

			$this->add_control(
				'tag_typo',
				[
					'label'     => __( 'Category', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'show_tag',
				[
					'label'        => __( 'Show Category on Hover', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'return_value' => 'yes',
					'label_off'    => __( 'No', 'uael' ),
					'label_on'     => __( 'Yes', 'uael' ),
				]
			);

			$this->add_control(
				'tag_color',
				[
					'label'     => __( 'Category Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-video__tags' => 'color: {{VALUE}};',
					],
					'condition' => [
						'show_tag' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'tag_typography',
					'selector'  => '{{WRAPPER}} .uael-video__tags',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'condition' => [
						'show_tag' => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Style Navigation Controls.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function register_style_navigation_controls() {

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
					'layout'     => 'carousel',
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
						'navigation' => [ 'arrows', 'both' ],
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
						'{{WRAPPER}} .slick-slider .slick-prev i, {{WRAPPER}} .slick-slider .slick-next i' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
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
						'{{WRAPPER}} .slick-slider .slick-arrow' => 'border-color: {{VALUE}}; border-style: solid;',
						'{{WRAPPER}} .slick-slider .slick-arrow i' => 'color: {{VALUE}};',
					],
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

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
					'selectors' => [
						'{{WRAPPER}} .slick-slider .slick-arrow' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
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
						'{{WRAPPER}} .slick-slider .slick-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'navigation' => [ 'arrows', 'both' ],
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
						'navigation' => [ 'dots', 'both' ],
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
						'navigation' => [ 'dots', 'both' ],
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
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

		$this->end_controls_section();
	}



	/**
	 * Get Wrapper Classes.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function get_slider_attr() {

		$settings = $this->get_settings_for_display();

		if ( 'carousel' !== $settings['layout'] ) {
			return;
		}

		$is_rtl      = is_rtl();
		$direction   = $is_rtl ? 'rtl' : 'ltr';
		$show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slick_options = [
			'slidesToShow'   => ( $settings['gallery_columns'] ) ? absint( $settings['gallery_columns'] ) : 4,
			'slidesToScroll' => 1,
			'autoplaySpeed'  => ( $settings['autoplay_speed'] ) ? absint( $settings['autoplay_speed'] ) : 5000,
			'autoplay'       => ( 'yes' === $settings['autoplay'] ),
			'infinite'       => ( 'yes' === $settings['infinite'] ),
			'pauseOnHover'   => ( 'yes' === $settings['pause_on_hover'] ),
			'speed'          => ( $settings['transition_speed'] ) ? absint( $settings['transition_speed'] ) : 500,
			'arrows'         => $show_arrows,
			'dots'           => $show_dots,
			'rtl'            => $is_rtl,
			'prevArrow'      => '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="fa fa-angle-left"></i></button>',
			'nextArrow'      => '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="fa fa-angle-right"></i></button>',
		];

		if ( $settings['gallery_columns_tablet'] || $settings['gallery_columns_mobile'] ) {

			$slick_options['responsive'] = [];

			if ( $settings['gallery_columns_tablet'] ) {

				$tablet_show   = absint( $settings['gallery_columns_tablet'] );
				$tablet_scroll = $tablet_show;

				$slick_options['responsive'][] = [
					'breakpoint' => 1024,
					'settings'   => [
						'slidesToShow'   => $tablet_show,
						'slidesToScroll' => $tablet_scroll,
					],
				];
			}

			if ( $settings['gallery_columns_mobile'] ) {

				$mobile_show   = absint( $settings['gallery_columns_mobile'] );
				$mobile_scroll = $mobile_show;

				$slick_options['responsive'][] = [
					'breakpoint' => 767,
					'settings'   => [
						'slidesToShow'   => $mobile_show,
						'slidesToScroll' => $mobile_scroll,
					],
				];
			}
		}

		$this->add_render_attribute(
			'uael-vg-slider',
			[
				'data-vg_slider' => wp_json_encode( $slick_options ),
			]
		);

		return $this->get_render_attribute_string( 'uael-vg-slider' );
	}


	/**
	 * Get masonry script.
	 *
	 * Returns the post masonry script.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function render_masonry_script() {
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {

				$( '.uael-video-gallery-wrap' ).each( function() {

					var $node_id 	= '<?php echo $this->get_id(); ?>';
					var	scope 		= $( '[data-id="' + $node_id + '"]' );
					var selector 	= $(this);

					if ( selector.closest( scope ).length < 1 ) {
						return;
					}

					if ( ! selector.hasClass( 'uael-video-gallery-filter' ) ) {
						return;
					}

					var filters = scope.find( '.uael-video__gallery-filters' );
					var def_cat = '*';

					if ( filters.length > 0 ) {

						var def_filter = filters.data( 'default' );

						if ( '' !== def_filter ) {

							def_cat 	= def_filter;
							def_cat_sel = filters.find( '[data-filter="' + def_filter + '"]' );

							if ( def_cat_sel.length > 0 ) {
								def_cat_sel.siblings().removeClass( 'uael-filter__current' );
								def_cat_sel.addClass( 'uael-filter__current' );
							}
						}
					}

					var $obj = {};

					selector.imagesLoaded( function( e ) {

						$obj = selector.isotope({
							filter: def_cat,
							layoutMode: 'masonry',
							itemSelector: '.uael-video__gallery-item',
						});

						selector.find( '.uael-video__gallery-item' ).resize( function() {
							$obj.isotope( 'layout' );
						});
					});

				});
			});
		</script>
		<?php
	}

	/**
	 * Render Tag Classes.
	 *
	 * @param Array $item Current video array.
	 * @since 1.5.0
	 * @access public
	 */
	public function get_tag_class( $item ) {

		$tags = explode( ',', $item['tags'] );
		$tags = array_map( 'trim', $tags );

		$tags_array = [];

		foreach ( $tags as $key => $value ) {
			$arr_value                                = 'filter-' . $value;
			$tags_array[ $this->clean( $arr_value ) ] = $value;
		}

		return $tags_array;
	}

	/**
	 * Render Placeholder Image HTML.
	 *
	 * @param Array $item Current video array.
	 * @since 1.5.0
	 * @access public
	 */
	public function get_placeholder_image( $item ) {

		$url       = '';
		$vid_id    = '';
		$video_url = $item['video_url'];

		if ( 'youtube' == $item['type'] ) {
			if ( preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches ) ) {
				$vid_id = $matches[1];
			}
		} elseif ( 'vimeo' == $item['type'] ) {
			$vid_id = preg_replace( '/[^\/]+[^0-9]|(\/)/', '', rtrim( $video_url, '/' ) );
		}

		if ( 'yes' == $item['custom_placeholder'] ) {

			$url = $item['placeholder_image']['url'];
		} else {

			if ( 'youtube' == $item['type'] ) {

				$url = 'https://i.ytimg.com/vi/' . $vid_id . '/' . apply_filters( 'uael_vg_youtube_image_quality', $item['yt_thumbnail_size'] ) . '.jpg';

			} elseif ( 'vimeo' == $item['type'] ) {

				if ( '' != $vid_id && 0 != $vid_id ) {

					$vimeo = unserialize( file_get_contents( "https://vimeo.com/api/v2/video/$vid_id.php" ) );

					$url = $vimeo[0]['thumbnail_large'];
				}
			}
		}

		return array(
			'url'      => $url,
			'video_id' => $vid_id,
		);

	}

	/**
	 * Render Play Button.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function get_play_button() {

		$settings = $this->get_settings_for_display();

		if ( 'icon' == $settings['play_source'] ) {
			?>

			<i class="<?php echo $settings['play_icon'] . ' elementor-animation-' . $settings['hover_animation']; ?> uael-vg__play-icon"></i>

		<?php } else { ?>
			<img class="uael-vg__dummy-image" alt="" />
			<img class="uael-vg__play-image <?php echo 'elementor-animation-' . $settings['hover_animation_img']; ?>" src="<?php echo $settings['play_img']['url']; ?>" alt="<?php echo Control_Media::get_image_alt( $settings['play_img'] ); ?>"/>

			<?php
		}
	}


	/**
	 * Render Gallery Data.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function render_gallery_inner_data() {

		$settings    = $this->get_settings_for_display();
		$new_gallery = array();
		$gallery     = $settings['gallery_items'];
		$vurl        = '';

		if ( 'rand' === $settings['gallery_rand'] ) {

			$keys = array_keys( $gallery );
			shuffle( $keys );

			foreach ( $keys as $key ) {
				$new_gallery[ $key ] = $gallery[ $key ];
			}
		} else {
			$new_gallery = $gallery;
		}

		foreach ( $new_gallery as $index => $item ) {

			$url = $this->get_placeholder_image( $item );

			$this->add_render_attribute( 'grid-item' . $index, 'class', 'uael-video__gallery-item' );

			// Render filter / tags classes.
			if ( 'yes' === $settings['show_filter'] && 'grid' == $settings['layout'] ) {

				if ( '' !== $item['tags'] ) {

					$tags = $this->get_tag_class( $item );

					$this->add_render_attribute( 'grid-item' . $index, 'class', array_keys( $tags ) );
				}
			}

			// Render video link attributes.
			$this->add_render_attribute(
				'video-grid-item' . $index,
				[
					'class' => 'uael-vg__play',
				]
			);

			$this->add_render_attribute(
				'video-container-link' . $index,
				[
					'class' => 'elementor-clickable uael-vg__play_full',
					'href'  => $item['video_url'],
				]
			);

			if ( 'inline' != $settings['click_action'] ) {

				$this->add_render_attribute( 'video-container-link' . $index, 'data-fancybox', 'uael-video-gallery-' . $this->get_id() );
			} else {

				if ( 'youtube' == $item['type'] ) {
					$vurl = 'https://www.youtube.com/embed/' . $url['video_id'] . '?autoplay=1&version=3&enablejsapi=1';
				} else {
					$vurl = 'https://player.vimeo.com/video/' . $url['video_id'] . '?autoplay=1&version=3&enablejsapi=1';
				}

				$this->add_render_attribute( 'video-container-link' . $index, 'data-url', $vurl );
			}

			?>
			<div <?php echo $this->get_render_attribute_string( 'grid-item' . $index ); ?>>

				<div class="uael-video__gallery-iframe" style="background-image:url('<?php echo $url['url']; ?>');">
					<a <?php echo $this->get_render_attribute_string( 'video-container-link' . $index ); ?>>
						<div class="uael-video__content-wrap">
							<div class="uael-video__content">

								<?php $this->get_caption( $item ); ?>

								<div <?php echo $this->get_render_attribute_string( 'video-grid-item' . $index ); ?>>
									<?php $this->get_play_button(); ?>
								</div>

								<?php $this->get_tag( $item ); ?>

							</div>
						</div>
					</a>
				</div>
				<div class="uael-vg__overlay"></div>
			</div>
			<?php
		}

	}

	/**
	 * Returns the Caption HTML.
	 *
	 * @param Array $item Current video array.
	 * @since 1.5.0
	 * @access public
	 */
	public function get_caption( $item ) {

		$settings = $this->get_settings_for_display();

		if ( '' == $item['title'] ) {
			return;
		}

		if ( 'yes' != $settings['show_caption'] ) {
			return;
		}
		?>

		<h4 class="uael-video__caption"><?php echo $item['title']; ?></h4>

		<?php
	}

	/**
	 * Returns the Filter HTML.
	 *
	 * @param Array $item Current video array.
	 * @since 1.5.0
	 * @access public
	 */
	public function get_tag( $item ) {

		$settings = $this->get_settings_for_display();

		if ( '' == $item['tags'] ) {
			return;
		}

		if ( 'yes' != $settings['show_tag'] ) {
			return;
		}
		?>

		<span class="uael-video__tags"><?php echo $item['tags']; ?></span>

		<?php
	}

	/**
	 * Clean string - Removes spaces and special chars.
	 *
	 * @since 1.5.0
	 * @param String $string String to be cleaned.
	 * @return array Google Map languages List.
	 */
	public function clean( $string ) {

		// Replaces all spaces with hyphens.
		$string = str_replace( ' ', '-', $string );

		// Removes special chars.
		$string = preg_replace( '/[^A-Za-z0-9\-]/', '', $string );

		// Turn into lower case characters.
		return strtolower( $string );
	}

	/**
	 * Get Filter taxonomy array.
	 *
	 * Returns the Filter array of objects.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function get_filter_values() {

		$settings = $this->get_settings_for_display();

		$filters = array();

		if ( ! empty( $settings['gallery_items'] ) ) {

			foreach ( $settings['gallery_items'] as $key => $value ) {

				$tags = $this->get_tag_class( $value );

				if ( ! empty( $tags ) ) {

					$filters = array_unique( array_merge( $filters, $tags ) );
				}
			}
		}

		return $filters;
	}

	/**
	 * Get Filters.
	 *
	 * Returns the Filter HTML.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function render_gallery_filters() {

		$settings = $this->get_settings_for_display();

		$filters = $this->get_filter_values();

		$filters = apply_filters( 'uael_video_gallery_filters', $filters );

		$default = '';

		$tab_responsive = ( 'yes' == $settings['tabs_dropdown'] ) ? ' uael-vgallery-tabs-dropdown' : '';

		if ( 'yes' === $settings['default_filter_switch'] && '' !== $settings['default_filter'] ) {
			$default = '.' . trim( $settings['default_filter'] );
			$default = strtolower( str_replace( ' ', '-', $default ) );
		}

		?>
		<div class="uael-video-gallery-filters-wrap<?php echo $tab_responsive; ?>">
			<?php if ( 'yes' == $settings['show_filter_title'] ) { ?>
				<div class="uael-video-gallery-title-filters">
					<div class="uael-video-gallery-title">
						<<?php echo $settings['filter_title_tag']; ?> class="uael-video-gallery-title-text"><?php echo $settings['filters_heading_text']; ?></<?php echo $settings['filter_title_tag']; ?>>
					</div>
			<?php } ?>
					<ul class="uael-video__gallery-filters" data-default="<?php echo $default; ?>">
						<li class="uael-video__gallery-filter uael-filter__current" data-filter="*"><?php echo $settings['filters_all_text']; ?></li>
						<?php foreach ( $filters as $key => $value ) { ?>
							<li class="uael-video__gallery-filter" data-filter="<?php echo '.' . $key; ?>"><?php echo $value; ?></li>
						<?php } ?>
					</ul>

					<?php if ( 'yes' == $settings['tabs_dropdown'] ) { ?>
						<div class="uael-filters-dropdown">
							<div class="uael-filters-dropdown-button"><?php echo $settings['filters_all_text']; ?></div>

							<ul class="uael-filters-dropdown-list uael-video__gallery-filters" data-default="<?php echo $default; ?>">
								<li class="uael-filters-dropdown-item uael-video__gallery-filter uael-filter__current" data-filter="*"><?php echo $settings['filters_all_text']; ?></li>
								<?php foreach ( $filters as $key => $value ) { ?>
									<li class="uael-filters-dropdown-item uael-video__gallery-filter" data-filter="<?php echo '.' . $key; ?>"><?php echo $value; ?></li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
			<?php if ( 'yes' == $settings['show_filter_title'] ) { ?>
				</div>
			<?php } ?>
		</div>
		<?php

	}

	/**
	 * Render Buttons output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$node_id = $this->get_id();

		$filters = $this->get_filter_values();

		$this->add_render_attribute( 'wrap', 'class', 'uael-video-gallery-wrap' );
		$this->add_render_attribute( 'wrap', 'class', 'uael-vg__layout-' . $settings['layout'] );
		$this->add_render_attribute( 'wrap', 'class', 'uael-vg__action-' . $settings['click_action'] );
		$this->add_render_attribute( 'wrap', 'data-action', $settings['click_action'] );
		$this->add_render_attribute( 'wrap', 'data-layout', $settings['layout'] );
		$this->add_render_attribute( 'wrap', 'class', 'uael-aspect-ratio-' . $settings['video_ratio'] );

		$this->add_render_attribute( 'wrap', 'data-all-filters', json_encode( array_keys( $filters ) ) );

		if ( 'yes' === $settings['show_filter'] && 'grid' === $settings['layout'] ) {
			$this->add_render_attribute( 'wrap', 'class', 'uael-video-gallery-filter' );

			$this->add_render_attribute( 'wrap', 'data-filter-default', $settings['filters_all_text'] );

			$this->render_gallery_filters();
		}

		echo '<div ' . $this->get_render_attribute_string( 'wrap' ) . ' ' . $this->get_slider_attr() . '>';

			$this->render_gallery_inner_data();

		echo '</div>';

		$this->render_masonry_script();
	}

}

