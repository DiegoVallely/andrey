<?php
/**
 * UAEL Video.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Video\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Control_Media;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Video.
 */
class Video extends Common_Widget {

	/**
	 * Retrieve Video Widget name.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Video' );
	}

	/**
	 * Retrieve Video Widget title.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Video' );
	}

	/**
	 * Retrieve Video Widget icon.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Video' );
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
		return parent::get_widget_keywords( 'Video' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'elementor-waypoints', 'uael-frontend-script', 'uael-video-subscribe', 'jquery-ui-draggable' ];
	}


	/**
	 * Register Video controls.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_video_content();
		$this->register_overlay_content();
		$this->register_video_icon_style();
		$this->register_video_sticky();
		$this->register_video_subscribe_bar();
		$this->register_helpful_information();
	}

	/**
	 * Video Tab.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_video_content() {

		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Video', 'uael' ),
			]
		);

			$this->add_control(
				'video_type',
				[
					'label'   => __( 'Video Type', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube' => __( 'YouTube', 'uael' ),
						'vimeo'   => __( 'Vimeo', 'uael' ),
					],
				]
			);

			$default_youtube = apply_filters( 'uael_video_default_youtube_link', 'https://www.youtube.com/watch?v=HJRzUQMhJMQ' );

			$default_vimeo = apply_filters( 'uael_video_default_vimeo_link', 'https://vimeo.com/274860274' );

			$this->add_control(
				'youtube_link',
				[
					'label'       => __( 'Link', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active'     => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'default'     => $default_youtube,
					'label_block' => true,
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);
			$this->add_control(
				'youtube_link_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the share URL.</br></br><b>Valid:</b>&nbsp;https://www.youtube.com/watch?v=HJRzUQMhJMQ</br><b>Invalid:</b>&nbsp;https://youtu.be/HJRzUQMhJMQ', 'uael' ) ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'video_type' => 'youtube',
					],
					'separator'       => 'none',
				]
			);

			$this->add_control(
				'vimeo_link',
				[
					'label'       => __( 'Link', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active'     => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'default'     => $default_vimeo,
					'label_block' => true,
					'condition'   => [
						'video_type' => 'vimeo',
					],
				]
			);
			$this->add_control(
				'vimeo_link_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '<b>Note:</b> Make sure you add the actual URL of the video and not the categorized URL.</br></br><b>Valid:</b>&nbsp;https://vimeo.com/274860274</br><b>Invalid:</b>&nbsp;https://vimeo.com/channels/staffpicks/274860274', 'uael' ) ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'video_type' => 'vimeo',
					],
					'separator'       => 'none',
				]
			);

			$this->add_control(
				'start',
				[
					'label'       => __( 'Start Time', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => __( 'Specify a start time (in seconds)', 'uael' ),
					'condition'   => [
						'video_type' => [ 'youtube', 'vimeo' ],
					],
				]
			);

			$this->add_control(
				'end',
				[
					'label'       => __( 'End Time', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => __( 'Specify an end time (in seconds)', 'uael' ),
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'aspect_ratio',
				[
					'label'        => __( 'Aspect Ratio', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'16_9' => '16:9',
						'4_3'  => '4:3',
						'3_2'  => '3:2',
					],
					'default'      => '16_9',
					'prefix_class' => 'uael-aspect-ratio-',
				]
			);

			$this->add_control(
				'heading_youtube',
				[
					'label'     => __( 'Video Options', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			// YouTube.
			$this->add_control(
				'yt_autoplay',
				[
					'label'     => __( 'Autoplay', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_rel',
				[
					'label'     => __( 'Related Videos From', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'no',
					'options'   => [
						'no'  => __( 'Current Video Channel', 'uael' ),
						'yes' => __( 'Any Random Video', 'uael' ),
					],
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_controls',
				[
					'label'     => __( 'Player Control', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_mute',
				[
					'label'     => __( 'Mute', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'yt_modestbranding',
				[
					'label'       => __( 'Modest Branding', 'uael' ),
					'description' => __( 'This option lets you use a YouTube player that does not show a YouTube logo.', 'uael' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => [
						'video_type'  => 'youtube',
						'yt_controls' => 'yes',
					],
				]
			);

			$this->add_control(
				'yt_privacy',
				[
					'label'       => __( 'Privacy Mode', 'uael' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'uael' ),
					'condition'   => [
						'video_type' => 'youtube',
					],
				]
			);

			// Vimeo.
			$this->add_control(
				'vimeo_autoplay',
				[
					'label'     => __( 'Autoplay', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_loop',
				[
					'label'     => __( 'Loop', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_muted',
				[
					'label'     => __( 'Mute', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_title',
				[
					'label'     => __( 'Intro Title', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_portrait',
				[
					'label'     => __( 'Intro Portrait', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_byline',
				[
					'label'     => __( 'Intro Byline', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Hide', 'uael' ),
					'label_on'  => __( 'Show', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_color',
				[
					'label'     => __( 'Controls Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-vimeo-title a'  => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-byline a' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-title a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-byline a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-title a:focus' => 'color: {{VALUE}}',
						'{{WRAPPER}} .uael-vimeo-byline a:focus' => 'color: {{VALUE}}',
					],
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'video_double_click',
				[
					'label'        => __( 'Enable Double Click on Mobile', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => __( 'No', 'uael' ),
					'label_on'     => __( 'Yes', 'uael' ),
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);

		if ( parent::is_internal_links() ) {

			$this->add_control(
				'video_double_click_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( 'Enable this option if you are not able to see custom thumbnail or overlay color on Mobile. Please read %1$s this article %2$s for more information.', 'uael' ), '<a href="https://uaelementor.com/docs/double-click-on-mobile-for-video/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Overlay Tab.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_overlay_content() {

		$this->start_controls_section(
			'section_image_overlay',
			[
				'label' => __( 'Thumbnail & Overlay', 'uael' ),
			]
		);

			$this->add_control(
				'yt_thumbnail_size',
				[
					'label'     => __( 'Thumbnail Size', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'maxresdefault' => __( 'Maximum Resolution', 'uael' ),
						'hqdefault'     => __( 'High Quality', 'uael' ),
						'mqdefault'     => __( 'Medium Quality', 'uael' ),
						'sddefault'     => __( 'Standard Quality', 'uael' ),
					],
					'default'   => 'maxresdefault',
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'show_image_overlay',
				[
					'label'        => __( 'Custom Thumbnail', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => __( 'No', 'uael' ),
					'label_on'     => __( 'Yes', 'uael' ),
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'image_overlay',
				[
					'label'     => __( 'Select Image', 'uael' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'image_overlay', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_overlay_size` and `image_overlay_custom_dimension`.
					'default'   => 'full',
					'separator' => 'none',
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_control(
				'image_overlay_color',
				[
					'label'     => __( 'Overlay Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-video__outer-wrap:before' => 'background: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'video_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-video__outer-wrap:before, 
						{{WRAPPER}} .uael-video__outer-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}}.uael-youtube-subscribe-yes .uael-subscribe-bar' => 'border-radius: 0{{UNIT}} 0{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}}.uael-youtube-subscribe-yes .uael-video__outer-wrap:before, 
						{{WRAPPER}}.uael-youtube-subscribe-yes .uael-video__outer-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0{{UNIT}} 0{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Style Tab.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_video_icon_style() {

		$this->start_controls_section(
			'section_play_icon',
			[
				'label' => __( 'Play Button', 'uael' ),
			]
		);

			$this->add_control(
				'play_source',
				[
					'label'   => __( 'Image/Icon', 'uael' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'default' => [
							'title' => __( 'Default', 'uael' ),
							'icon'  => 'fa fa-youtube-play',
						],
						'img'     => [
							'title' => __( 'Image', 'uael' ),
							'icon'  => 'fa fa-picture-o',
						],
						'icon'    => [
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
					'default'   => 'fa fa-play-circle',
					'condition' => [
						'play_source' => 'icon',
					],
				]
			);

			$this->add_responsive_control(
				'play_icon_size',
				[
					'label'     => __( 'Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 700,
						],
					],
					'default'   => [
						'size' => 72,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-video__play-icon:before' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .uael-video__play-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .uael-video__play-icon > img' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .uael-video__play-icon.uael-video__vimeo-play' => 'width: auto; height: auto;',
						'{{WRAPPER}} .uael-vimeo-icon-bg' => 'width: {{SIZE}}{{UNIT}};',
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
								'{{WRAPPER}} .uael-video__play-icon' => 'color: {{VALUE}}',
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
							'name'      => 'play_icon_text_shadow',
							'selector'  => '{{WRAPPER}} .uael-video__play-icon',
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
								'{{WRAPPER}} .uael-video__outer-wrap:hover .uael-video__play-icon' => 'color: {{VALUE}}',
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
							'selector'  => '{{WRAPPER}} .uael-video__outer-wrap:hover .uael-video__play-icon',
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

			$this->add_control(
				'default_play_icon_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-youtube-icon-bg, {{WRAPPER}} .uael-vimeo-icon-bg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'play_source' => 'default',
					],
				]
			);

			$this->add_control(
				'default_play_icon_hover_color',
				[
					'label'     => __( 'Hover Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-video__outer-wrap:hover .uael-video__play-icon .uael-youtube-icon-bg, {{WRAPPER}} .uael-video__outer-wrap:hover .uael-video__play-icon .uael-vimeo-icon-bg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'play_source' => 'default',
					],
				]
			);

			$this->add_control(
				'default_hover_animation',
				[
					'label'     => __( 'Hover Animation', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''                => __( 'None', 'uael' ),
						'grow'            => __( 'Grow', 'uael' ),
						'float'           => __( 'Float', 'uael' ),
						'sink'            => __( 'Sink', 'uael' ),
						'wobble-vertical' => __( 'Wobble Vertical', 'uael' ),
					],
					'condition' => [
						'play_source' => 'default',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Sticky feature for Video
	 *
	 * @since 1.9.2
	 * @access protected
	 */
	protected function register_video_sticky() {
		$this->start_controls_section(
			'section_sticky',
			[
				'label' => __( 'Sticky Video', 'uael' ),
			]
		);

			$this->add_control(
				'enable_sticky',
				[
					'label'     => __( 'Enable Sticky Video', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'No', 'uael' ),
					'label_on'  => __( 'Yes', 'uael' ),
					'default'   => 'no',
				]
			);

			$this->add_responsive_control(
				'sticky_video_width',
				[
					'label'          => __( 'Video Width (px)', 'uael' ),
					'type'           => Controls_Manager::SLIDER,
					'range'          => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
					],
					'default'        => [
						'size' => 320,
						'unit' => 'px',
					],
					'mobile_default' => [
						'size' => 250,
						'unit' => 'px',
					],
					'condition'      => [
						'enable_sticky' => 'yes',
					],
					'selectors'      => [
						'{{WRAPPER}}.uael-aspect-ratio-16_9 .uael-video__outer-wrap.uael-sticky-apply .uael-video-inner-wrap, 
						{{WRAPPER}}.uael-aspect-ratio-16_9 .uael-sticky-apply .uael-video__thumb' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.5625 );',
						'{{WRAPPER}}.uael-aspect-ratio-4_3 .uael-video__outer-wrap.uael-sticky-apply .uael-video-inner-wrap, 
						{{WRAPPER}}.uael-aspect-ratio-4_3 .uael-sticky-apply .uael-video__thumb' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.75 );',
						'{{WRAPPER}}.uael-aspect-ratio-3_2 .uael-video__outer-wrap.uael-sticky-apply .uael-video-inner-wrap, 
						{{WRAPPER}}.uael-aspect-ratio-3_2 .uael-sticky-apply .uael-video__thumb' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.6666666666666667 );',
					],
				]
			);

			$this->add_control(
				'align_sticky',
				[
					'label'        => __( 'Sticky Alignment', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'top_left',
					'options'      => [
						'top_left'     => __( 'Top Left', 'uael' ),
						'top_right'    => __( 'Top Right', 'uael' ),
						'bottom_left'  => __( 'Bottom Left', 'uael' ),
						'bottom_right' => __( 'Bottom Right', 'uael' ),
						'center_left'  => __( 'Center Left', 'uael' ),
						'center_right' => __( 'Center Right', 'uael' ),
					],
					'condition'    => [
						'enable_sticky' => 'yes',
					],
					'prefix_class' => 'uael-video-sticky-',
					'render_type'  => 'template',
				]
			);

			$this->add_responsive_control(
				'sticky_video_margin',
				[
					'label'              => __( 'Spacing from Edges', 'uael' ),
					'description'        => __( 'Note: This is spacing around the sticky video with respect to the Alignment chosen.', 'uael' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px' ],
					'selectors'          => [
						'{{WRAPPER}}.uael-video-sticky-top_right .uael-sticky-apply .uael-video-inner-wrap' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
						'{{WRAPPER}}.uael-video-sticky-top_left .uael-sticky-apply .uael-video-inner-wrap' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
						'.admin-bar {{WRAPPER}}.uael-video-sticky-top_left .uael-sticky-apply .uael-video-inner-wrap,
						.admin-bar {{WRAPPER}}.uael-video-sticky-top_right .uael-sticky-apply .uael-video-inner-wrap' => 'top: calc( {{TOP}}px + 32px );',
						'{{WRAPPER}}.uael-video-sticky-bottom_right .uael-sticky-apply .uael-video-inner-wrap' => 'bottom: {{BOTTOM}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
						'{{WRAPPER}}.uael-video-sticky-bottom_left .uael-sticky-apply .uael-video-inner-wrap' => 'bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
						'{{WRAPPER}}.uael-video-sticky-center_left .uael-sticky-apply .uael-video-inner-wrap' => 'left: {{LEFT}}{{UNIT}};',
						'{{WRAPPER}}.uael-video-sticky-center_right .uael-sticky-apply .uael-video-inner-wrap' => 'right: {{RIGHT}}{{UNIT}};',
					],
					'condition'          => [
						'enable_sticky' => 'yes',
					],
					'render_type'        => 'template',
					'frontend_available' => true,
				]
			);

			$this->add_responsive_control(
				'sticky_video_padding',
				[
					'label'      => __( 'Background Size', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-sticky-apply iframe, {{WRAPPER}} .uael-sticky-apply .uael-video__thumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'enable_sticky' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_video_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-video__outer-wrap.uael-sticky-apply .uael-video-inner-wrap' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'enable_sticky' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_hide_on',
				[
					'label'              => __( 'Hide Sticky Video on', 'uael' ),
					'type'               => Controls_Manager::SELECT2,
					'multiple'           => true,
					'options'            => [
						'desktop' => __( 'Desktop', 'uael' ),
						'tablet'  => __( 'Tablet', 'uael' ),
						'mobile'  => __( 'Mobile', 'uael' ),
					],
					'condition'          => [
						'enable_sticky' => 'yes',
					],
					'render_type'        => 'template',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'heading_sticky_close_button',
				[
					'label'     => __( 'Close Button', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'enable_sticky' => 'yes',
					],
				]
			);

			$this->add_control(
				'enable_sticky_close_button',
				[
					'label'     => __( 'Enable', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'No', 'uael' ),
					'label_on'  => __( 'Yes', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'enable_sticky' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_close_icon_color',
				[
					'label'     => __( 'Icon Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-sticky-apply .uael-video-sticky-close' => 'color: {{VALUE}};',
					],
					'condition' => [
						'enable_sticky'              => 'yes',
						'enable_sticky_close_button' => 'yes',
					],
				]
			);
			$this->add_control(
				'sticky_close_icon_bgcolor',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-sticky-apply .uael-video-sticky-close' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'enable_sticky'              => 'yes',
						'enable_sticky_close_button' => 'yes',
					],
				]
			);

			$this->add_control(
				'heading_sticky_info_bar',
				[
					'label'     => __( 'Info Bar', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'enable_sticky' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_info_bar_switch',
				[
					'label'       => __( 'Enable', 'uael' ),
					'description' => __( 'Enable this option to display the informative text under Sticky video.', 'uael' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_off'   => __( 'No', 'uael' ),
					'label_on'    => __( 'Yes', 'uael' ),
					'default'     => 'no',
					'condition'   => [
						'enable_sticky' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_info_bar_text',
				[
					'label'     => __( 'Text', 'uael' ),
					'type'      => Controls_Manager::TEXTAREA,
					'default'   => '<b>Now Playing:</b> Sticky Video',
					'rows'      => 2,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'enable_sticky'          => 'yes',
						'sticky_info_bar_switch' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_info_bar_color',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-sticky-apply .uael-video-sticky-infobar' => 'color: {{VALUE}};',
					],
					'condition' => [
						'enable_sticky'          => 'yes',
						'sticky_info_bar_switch' => 'yes',
					],
				]
			);

			$this->add_control(
				'sticky_info_bar_bgcolor',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-sticky-apply .uael-video-sticky-infobar' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'enable_sticky'          => 'yes',
						'sticky_info_bar_switch' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'sticky_info_bar_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'selector'  => '{{WRAPPER}} .uael-sticky-apply .uael-video-sticky-infobar',
					'condition' => [
						'enable_sticky'          => 'yes',
						'sticky_info_bar_switch' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'sticky_info_bar_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-sticky-apply .uael-video-sticky-infobar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'enable_sticky'          => 'yes',
						'sticky_info_bar_switch' => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Subscribe bar below Video.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function register_video_subscribe_bar() {

		$this->start_controls_section(
			'section_subscribe_bar',
			[
				'label'     => __( 'YouTube Subscribe Bar', 'uael' ),
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

			$this->add_control(
				'subscribe_bar',
				[
					'label'        => __( 'Enable Subscribe Bar', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => __( 'No', 'uael' ),
					'label_on'     => __( 'Yes', 'uael' ),
					'default'      => 'no',
					'condition'    => [
						'video_type' => 'youtube',
					],
					'prefix_class' => 'uael-youtube-subscribe-',
					'render_type'  => 'template',
				]
			);

			$this->add_control(
				'subscribe_bar_select',
				[
					'label'     => __( 'Select', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'channel_name' => __( 'Use Channel Name', 'uael' ),
						'channel_id'   => __( 'Use Channel ID', 'uael' ),
					],
					'default'   => 'channel_id',
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_channel_name',
				[
					'label'       => __( 'YouTube Channel Name', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'TheBrainstormForce',
					'label_block' => true,
					'condition'   => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_name',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_channel_id',
				[
					'label'       => __( 'YouTube Channel ID', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'UCtFCcrvupjyaq2lax_7OQQg',
					'label_block' => true,
					'condition'   => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_id',
					],
				]
			);

		if ( parent::is_internal_links() ) {

			$this->add_control(
				'subscribe_channel_id_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( 'Click %1$s here %2$s to find your YouTube Channel Name.', 'uael' ), '<a href="https://uaelementor.com/docs/youtube-channel-name-and-channel-id/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_name',
					],
				]
			);

			$this->add_control(
				'subscribe_channel_name_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( 'Click %1$s here %2$s to find your YouTube Channel ID.', 'uael' ), '<a href="https://uaelementor.com/docs/youtube-channel-name-and-channel-id/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'video_type'           => 'youtube',
						'subscribe_bar'        => 'yes',
						'subscribe_bar_select' => 'channel_id',
					],
				]
			);
		}

			$this->add_control(
				'subscribe_bar_channel_text',
				[
					'label'       => __( 'Subscribe to Channel Text', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Subscribe to our YouTube Channel',
					'label_block' => true,
					'condition'   => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_count',
				[
					'label'     => __( 'Show Subscribers Count', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'No', 'uael' ),
					'label_on'  => __( 'Yes', 'uael' ),
					'default'   => 'yes',
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-subscribe-bar-prefix' => 'color: {{VALUE}}',
					],
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_bgcolor',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#1b1b1b',
					'selectors' => [
						'{{WRAPPER}} .uael-subscribe-bar' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'subscribe_bar_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'selector'  => '{{WRAPPER}} .uael-subscribe-bar-prefix',
					'condition' => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'subscribe_bar_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-subscribe-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

			$this->add_control(
				'subscribe_bar_responsive',
				[
					'label'        => __( 'Stack on', 'uael' ),
					'description'  => __( 'Choose a breakpoint where the subscribe bar content will stack.', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'none',
					'options'      => [
						'none'    => __( 'None', 'uael' ),
						'desktop' => __( 'Desktop', 'uael' ),
						'tablet'  => __( 'Tablet', 'uael' ),
						'mobile'  => __( 'Mobile', 'uael' ),
					],
					'condition'    => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
					'prefix_class' => 'uael-subscribe-responsive-',
					'separator'    => 'before',
				]
			);

			$this->add_responsive_control(
				'subscribe_bar_spacing',
				[
					'label'      => __( 'Spacing', 'uael' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-subscribe-bar-prefix ' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.uael-subscribe-responsive-desktop .uael-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px;',
						'(tablet){{WRAPPER}}.uael-subscribe-responsive-tablet .uael-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px;',
						'(mobile){{WRAPPER}}.uael-subscribe-responsive-mobile .uael-subscribe-bar-prefix ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px;',
					],
					'condition'  => [
						'video_type'    => 'youtube',
						'subscribe_bar' => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.3.2
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/video-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=2RlvBU_EFV4&index=18&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Unable to edit Video widget » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/unable-to-edit-video-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Display YouTube Subscribe Bar for Video. » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/youtube-subscribe-bar-for-video/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Find YouTube Channel Name and Channel ID. » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/youtube-channel-name-and-channel-id/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Enable Sticky Video » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/sticky-video/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Returns Video Thumbnail Image.
	 *
	 * @param string $id Video ID.
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_video_thumb( $id ) {

		if ( '' == $id ) {
			return '';
		}

		$settings = $this->get_settings_for_display();
		$thumb    = '';

		if ( 'yes' == $settings['show_image_overlay'] ) {

			$thumb = Group_Control_Image_Size::get_attachment_image_src( $settings['image_overlay']['id'], 'image_overlay', $settings );

		} else {

			if ( 'youtube' == $settings['video_type'] ) {

				$thumb = 'https://i.ytimg.com/vi/' . $id . '/' . apply_filters( 'uael_video_youtube_image_quality', $settings['yt_thumbnail_size'] ) . '.jpg';
			} else {
				// @codingStandardsIgnoreStart
				$vimeo = unserialize( @file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
				// @codingStandardsIgnoreEnd
				$thumb = str_replace( '_640', '_840', $vimeo[0]['thumbnail_large'] );
			}
		}

		return $thumb;
	}

	/**
	 * Returns Video ID.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_video_id() {

		$settings = $this->get_settings_for_display();
		$id       = '';
		$url      = $settings[ $settings['video_type'] . '_link' ];

		if ( 'youtube' == $settings['video_type'] ) {

			if ( preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches ) ) {
				$id = $matches[1];
			}
		} elseif ( 'vimeo' == $settings['video_type'] ) {

			$id = preg_replace( '/[^\/]+[^0-9]|(\/)/', '', rtrim( $url, '/' ) );
		}

		return $id;
	}

	/**
	 * Returns Video URL.
	 *
	 * @param array  $params Video Param array.
	 * @param string $id Video ID.
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_url( $params, $id ) {

		$settings = $this->get_settings_for_display();
		$url      = '';

		if ( 'vimeo' == $settings['video_type'] ) {

			$url = 'https://player.vimeo.com/video/';
		} else {

			$cookie = '';

			if ( 'yes' == $settings['yt_privacy'] ) {
				$cookie = '-nocookie';
			}
			$url = 'https://www.youtube' . $cookie . '.com/embed/';
		}

		$url = add_query_arg( $params, $url . $id );

		$url .= ( empty( $params ) ) ? '?' : '&';

		$url .= 'autoplay=1';

		if ( 'vimeo' == $settings['video_type'] && '' != $settings['start'] ) {

			$time = date( 'H\hi\ms\s', $settings['start'] );
			$url .= '#t=' . $time;
		}

		$url = apply_filters( 'uael_video_url_filter', $url, $id );

		return $url;
	}

	/**
	 * Returns Vimeo Headers.
	 *
	 * @param string $id Video ID.
	 * @since 1.3.2
	 * @access protected
	 */
	function get_header_wrap( $id ) {

		$settings = $this->get_settings_for_display();

		if ( 'vimeo' != $settings['video_type'] ) {
			return;
		}

		// @codingStandardsIgnoreStart
		$vimeo = unserialize( @file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
		// @codingStandardsIgnoreEnd
		if (
			'yes' == $settings['vimeo_portrait'] ||
			'yes' == $settings['vimeo_title'] ||
			'yes' == $settings['vimeo_byline']
		) { ?>
		<div class="uael-vimeo-wrap">
			<?php if ( 'yes' == $settings['vimeo_portrait'] ) { ?>
			<div class="uael-vimeo-portrait">
				<a href="<?php $vimeo[0]['user_url']; ?>"><img src="<?php echo $vimeo[0]['user_portrait_huge']; ?>" alt=""></a>
			</div>
			<?php } ?>
			<?php
			if (
				'yes' == $settings['vimeo_title'] ||
				'yes' == $settings['vimeo_byline']
			) {
				?>
			<div class="uael-vimeo-headers">
				<?php if ( 'yes' == $settings['vimeo_title'] ) { ?>
				<div class="uael-vimeo-title">
					<a href="<?php $settings['vimeo_link']; ?>"><?php echo $vimeo[0]['title']; ?></a>
				</div>
				<?php } ?>
				<?php if ( 'yes' == $settings['vimeo_byline'] ) { ?>
				<div class="uael-vimeo-byline">
					<?php _e( 'from ', 'uael' ); ?> <a href="<?php $settings['vimeo_link']; ?>"><?php echo $vimeo[0]['user_name']; ?></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php
	}

	/**
	 * Render Video.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function get_video_embed() {

		$settings       = $this->get_settings_for_display();
		$sticky_hide    = [];
		$is_editor      = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$id             = $this->get_video_id();
		$embed_param    = $this->get_embed_params();
		$src            = $this->get_url( $embed_param, $id );
		$sticky         = ( 'yes' === $settings['enable_sticky'] ) ? 'yes' : 'no';
		$stick_desktop  = '';
		$stick_tablet   = '';
		$stick_mobile   = '';
		$sticky_infobar = ( 'yes' == $settings['sticky_info_bar_switch'] ) ? 'uael-sticky-infobar-wrap' : '';
		$sticky_bottom  = ( '' != $settings['sticky_video_margin']['bottom'] ) ? $settings['sticky_video_margin']['bottom'] : '';
		$viewport       = 0;
		$viewport       = apply_filters( 'uael_sticky_video_viewport', $viewport );

		if ( is_array( $settings['sticky_hide_on'] ) ) {
			foreach ( $settings['sticky_hide_on'] as $element ) {
				if ( 'desktop' == $element ) {
					$stick_desktop = 'desktop';
				} elseif ( 'tablet' == $element ) {
					$stick_tablet = 'tablet';
				} elseif ( 'mobile' == $element ) {
					$stick_mobile = 'mobile';
				}
			}
		} else {
			if ( 'desktop' == $settings['sticky_hide_on'] ) {
				$stick_desktop = 'desktop';
			} elseif ( 'tablet' == $settings['sticky_hide_on'] ) {
				$stick_tablet = 'tablet';
			} elseif ( 'mobile' == $settings['sticky_hide_on'] ) {
				$stick_mobile = 'mobile';
			}
		}

		if ( 'yes' == $settings['video_double_click'] ) {
			$device = 'false';
		} else {
			$device = ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) ) ? 'true' : 'false' );
		}

		if ( 'youtube' == $settings['video_type'] ) {
			$autoplay = ( 'yes' == $settings['yt_autoplay'] ) ? '1' : '0';
		} else {
			$autoplay = ( 'yes' == $settings['vimeo_autoplay'] ) ? '1' : '0';
		}

		$this->add_render_attribute( 'video-outer', 'class', 'uael-video__outer-wrap' );
		$this->add_render_attribute( 'video-outer', 'class', $sticky_infobar );

		$this->add_render_attribute( 'video-outer', 'data-autoplay', $autoplay );
		$this->add_render_attribute( 'video-outer', 'data-device', $device );
		$this->add_render_attribute( 'video-outer', 'data-vsticky', $sticky );
		$this->add_render_attribute( 'video-outer', 'data-stickybottom', $sticky_bottom );

		$this->add_render_attribute( 'video-outer', 'data-hidedesktop', $stick_desktop );
		$this->add_render_attribute( 'video-outer', 'data-hidetablet', $stick_tablet );
		$this->add_render_attribute( 'video-outer', 'data-hidemobile', $stick_mobile );

		$this->add_render_attribute( 'video-outer', 'data-vsticky-viewport', $viewport );

		$this->add_render_attribute( 'video-wrapper', 'class', 'uael-video__play' );
		$this->add_render_attribute( 'video-wrapper', 'data-src', $src );

		$this->add_render_attribute( 'video-thumb', 'class', 'uael-video__thumb' );
		$this->add_render_attribute( 'video-thumb', 'src', $this->get_video_thumb( $id ) );

		$this->add_render_attribute( 'video-play', 'class', 'uael-video__play-icon' );

		if ( 'default' == $settings['play_source'] ) {
			if ( 'youtube' == $settings['video_type'] ) {

				$html = '<svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="uael-youtube-icon-bg" d="m .66,37.62 c 0,0 .66,4.70 2.70,6.77 2.58,2.71 5.98,2.63 7.49,2.91 5.43,.52 23.10,.68 23.12,.68 .00,-1.3e-5 14.29,-0.02 23.81,-0.71 1.32,-0.15 4.22,-0.17 6.81,-2.89 2.03,-2.07 2.70,-6.77 2.70,-6.77 0,0 .67,-5.52 .67,-11.04 l 0,-5.17 c 0,-5.52 -0.67,-11.04 -0.67,-11.04 0,0 -0.66,-4.70 -2.70,-6.77 C 62.03,.86 59.13,.84 57.80,.69 48.28,0 34.00,0 34.00,0 33.97,0 19.69,0 10.18,.69 8.85,.84 5.95,.86 3.36,3.58 1.32,5.65 .66,10.35 .66,10.35 c 0,0 -0.55,4.50 -0.66,9.45 l 0,8.36 c .10,4.94 .66,9.45 .66,9.45 z" fill="#1f1f1e"></path><path d="m 26.96,13.67 18.37,9.62 -18.37,9.55 -0.00,-19.17 z" fill="#fff"></path><path d="M 45.02,23.46 45.32,23.28 26.96,13.67 43.32,24.34 45.02,23.46 z" fill="#ccc"></path></svg>';

			} elseif ( 'vimeo' == $settings['video_type'] ) {

				$this->add_render_attribute( 'video-play', 'class', 'uael-video__vimeo-play' );

				$html = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="uael-vimeo-icon-bg" x="0px" y="0px" width="100%" height="100%" viewBox="0 14.375 95 66.25" enable-background="new 0 14.375 95 66.25" xml:space="preserve" fill="rgba(23,34,35,.75)"><path d="M12.5,14.375c-6.903,0-12.5,5.597-12.5,12.5v41.25c0,6.902,5.597,12.5,12.5,12.5h70c6.903,0,12.5-5.598,12.5-12.5v-41.25 c0-6.903-5.597-12.5-12.5-12.5H12.5z"/><polygon fill="#FFFFFF" points="39.992,64.299 39.992,30.701 62.075,47.5 "/></svg>';
			}
		} elseif ( 'icon' == $settings['play_source'] ) {
			$html = '';
			$this->add_render_attribute( 'video-play', 'class', $settings['play_icon'] );

		} else {
			$html = '<img src="' . $settings['play_img']['url'] . '" alt="' . Control_Media::get_image_alt( $settings['play_img'] ) . '" />';
		}

		if ( 'img' == $settings['play_source'] ) {
			$this->add_render_attribute( 'video-play', 'class', 'uael-animation-' . $settings['hover_animation_img'] );
		} elseif ( 'default' == $settings['play_source'] ) {
			$this->add_render_attribute( 'video-play', 'class', 'uael-animation-' . $settings['default_hover_animation'] );
		} else {
			$this->add_render_attribute( 'video-play', 'class', 'uael-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'video-outer' ); ?>>
			<?php $this->get_header_wrap( $id ); ?>
			<div class="uael-video-inner-wrap">
				<div <?php echo $this->get_render_attribute_string( 'video-wrapper' ); ?>>
					<img <?php echo $this->get_render_attribute_string( 'video-thumb' ); ?> />
					<div <?php echo $this->get_render_attribute_string( 'video-play' ); ?>>
						<?php echo $html; ?>
					</div>
				</div>
				<?php if ( 'yes' === $settings['enable_sticky'] && 'yes' == $settings['enable_sticky_close_button'] ) { ?>
					<div class="uael-video-sticky-close">
						<i class="fa fa-close uael-sticky-close-icon"></i>
					</div>
				<?php } ?>
				<?php if ( 'yes' == $settings['sticky_info_bar_switch'] && '' != $settings['sticky_info_bar_text'] ) { ?>
					<div class="uael-video-sticky-infobar"><?php echo $settings['sticky_info_bar_text']; ?></div>
				<?php } ?>
			</div>
		</div>
		<?php
		if ( 'youtube' == $settings['video_type'] && 'yes' == $settings['subscribe_bar'] ) {
			$channel_name = ( '' != $settings['subscribe_bar_channel_name'] ) ? $settings['subscribe_bar_channel_name'] : '';

			$channel_id = ( '' != $settings['subscribe_bar_channel_id'] ) ? $settings['subscribe_bar_channel_id'] : '';

			$youtube_text = ( '' != $settings['subscribe_bar_channel_text'] ) ? $settings['subscribe_bar_channel_text'] : '';

			$subscriber_count = ( 'yes' == $settings['subscribe_count'] ) ? 'default' : 'hidden';

			?>
			<div class="uael-subscribe-bar">
				<div class="uael-subscribe-bar-prefix"><?php echo $youtube_text; ?></div>
				<div class="uael-subscribe-content">
					<?php if ( false !== $is_editor ) { ?>
						<script src="https://apis.google.com/js/platform.js"></script>
					<?php } ?>
					<?php if ( 'channel_name' == $settings['subscribe_bar_select'] ) { ?>
						<div class="g-ytsubscribe" data-channel="<?php echo $channel_name; ?>" data-count="<?php echo $subscriber_count; ?>"></div>
					<?php } elseif ( 'channel_id' == $settings['subscribe_bar_select'] ) { ?>
						<div class="g-ytsubscribe" data-channelid="<?php echo $channel_id; ?>" data-count="<?php echo $subscriber_count; ?>"></div>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Render Video output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.2
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( '' == $settings['youtube_link'] && 'youtube' == $settings['video_type'] ) {
			return '';
		}

		if ( '' == $settings['vimeo_link'] && 'vimeo' == $settings['video_type'] ) {
			return '';
		}

		$this->get_video_embed();
	}

	/**
	 * Render video widget as plain content.
	 *
	 * Override the default behavior, by printing the video URL insted of rendering it.
	 *
	 * @since 1.3.2
	 * @access public
	 */
	public function render_plain_content() {
		$settings = $this->get_settings_for_display();
		$url      = 'youtube' === $settings['video_type'] ? $settings['youtube_link'] : $settings['vimeo_link'];

		echo esc_url( $url );
	}

	/**
	 * Get embed params.
	 *
	 * Retrieve video widget embed parameters.
	 *
	 * @since 1.3.2
	 * @access public
	 *
	 * @return array Video embed parameters.
	 */
	public function get_embed_params() {

		$settings = $this->get_settings_for_display();

		$params = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$youtube_options = [ 'autoplay', 'rel', 'controls', 'mute', 'modestbranding' ];

			foreach ( $youtube_options as $option ) {

				if ( 'autoplay' == $option ) {
					if ( 'yes' === $settings['yt_autoplay'] ) {
						$params[ $option ] = '1';
					}
					continue;
				}

				$value             = ( 'yes' === $settings[ 'yt_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
				$params['start']   = $settings['start'];
				$params['end']     = $settings['end'];
			}
		}

		if ( 'vimeo' === $settings['video_type'] ) {
			$vimeo_options = [ 'autoplay', 'loop', 'title', 'portrait', 'byline', 'muted' ];

			foreach ( $vimeo_options as $option ) {

				if ( 'autoplay' == $option ) {
					if ( 'yes' === $settings['vimeo_autoplay'] ) {
						$params[ $option ] = '1';
					}
					continue;
				}

				$value             = ( 'yes' === $settings[ 'vimeo_' . $option ] ) ? '1' : '0';
				$params[ $option ] = $value;
			}

			$params['color']     = str_replace( '#', '', $settings['vimeo_color'] );
			$params['autopause'] = '0';
		}

		return $params;
	}
}

