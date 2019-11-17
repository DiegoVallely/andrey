<?php
/**
 * UAEL Hotspot.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Hotspot\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Hotspot.
 */
class Hotspot extends Common_Widget {

	/**
	 * Retrieve Hotspot Widget name.
	 *
	 * @since 1.9.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Hotspot' );
	}

	/**
	 * Retrieve Hotspot Widget title.
	 *
	 * @since 1.9.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Hotspot' );
	}

	/**
	 * Retrieve Hotspot Widget icon.
	 *
	 * @since 1.9.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Hotspot' );
	}

	/**
	 * Retrieve the list of styles needed for Hotspot.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 1.9.0
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return [ 'uael-hotspot' ];
	}

	/**
	 * Retrieve the list of scripts the Hotspot widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.9.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-frontend-script', 'uael-hotspot' ];
	}

	/**
	 * Register Hotspot controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_image_content_controls();
		$this->register_hotspot_content_controls();
		$this->register_tooltip_content_controls();
		$this->register_hotspot_tour_controls();
		$this->register_helpful_information();

		$this->register_image_style_controls();
		$this->register_hotspot_style_controls();
		$this->register_tooltip_style_controls();
		$this->register_hotspot_overlay_controls();
	}

	/**
	 * Register Hotspot Image Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_image_content_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'uael' ),
			]
		);

			$this->add_control(
				'image',
				[
					'label'   => __( 'Choose Image', 'uael' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'image',
					'label'   => __( 'Image Size', 'uael' ),
					'default' => 'large',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Hotspot content Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_hotspot_content_controls() {
		$this->start_controls_section(
			'section_hotspot',
			[
				'label'     => __( 'Markers', 'uael' ),
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

			$repeater = new Repeater();

			$repeater->start_controls_tabs( 'marker_repeater' );

				$repeater->start_controls_tab( 'general_tab', [ 'label' => __( 'General', 'uael' ) ] );

					$repeater->add_control(
						'hotspot',
						[
							'label'   => __( 'Marker Type', 'uael' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'icon',
							'options' => [
								'text'  => __( 'Text', 'uael' ),
								'icon'  => __( 'Icon', 'uael' ),
								'image' => __( 'Image', 'uael' ),
							],
						]
					);

					$repeater->add_control(
						'text',
						[
							'default'   => __( 'Marker Text', 'uael' ),
							'type'      => Controls_Manager::TEXT,
							'label'     => __( 'Title', 'uael' ),
							'separator' => 'none',
							'dynamic'   => [
								'active' => true,
							],
						]
					);

					$repeater->add_control(
						'icon',
						[
							'label'              => __( 'Marker Icon', 'uael' ),
							'type'               => Controls_Manager::ICON,
							'label_block'        => true,
							'default'            => 'fa fa-dot-circle-o',
							'condition'          => [
								'hotspot' => 'icon',
							],
							'frontend_available' => true,
						]
					);

					$repeater->add_control(
						'repeater_image',
						[
							'label'     => __( 'Choose Image', 'uael' ),
							'type'      => Controls_Manager::MEDIA,
							'default'   => [
								'url' => Utils::get_placeholder_image_src(),
							],
							'dynamic'   => [
								'active' => true,
							],
							'condition' => [
								'hotspot' => 'image',
							],
						]
					);

					$repeater->add_control(
						'hotspot_position_heading',
						[
							'label' => __( 'Position', 'uael' ),
							'type'  => Controls_Manager::HEADING,
						]
					);

					$repeater->add_responsive_control(
						'tooltip_pos_horizontal',
						[
							'label'     => __( 'Horizontal position (%)', 'uael' ),
							'type'      => Controls_Manager::SLIDER,
							'range'     => [
								'px' => [
									'min'  => 0,
									'max'  => 100,
									'step' => 0.1,
								],
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}%; transform: translate(-{{SIZE}}%, 0);',
							],
						]
					);

					$repeater->add_responsive_control(
						'tooltip_pos_vertical',
						[
							'label'     => __( 'Vertical position (%)', 'uael' ),
							'type'      => Controls_Manager::SLIDER,
							'range'     => [
								'px' => [
									'min'  => 0,
									'max'  => 100,
									'step' => 0.1,
								],
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}%; transform: translate(0, -{{SIZE}}%);',
							],
						]
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab( 'content_tab', [ 'label' => __( 'Content', 'uael' ) ] );

					$repeater->add_control(
						'content',
						[
							'label'   => __( 'Tooltip Content', 'uael' ),
							'type'    => Controls_Manager::WYSIWYG,
							'default' => __( 'This is a tooltip', 'uael' ),
							'dynamic' => [
								'active' => true,
							],
						]
					);

					$repeater->add_control(
						'marker_link',
						[
							'label'       => __( 'Marker Link', 'uael' ),
							'description' => __( 'Note: Applicable only when tooltips trigger is set to Hover. Also, when Hotspot Tour option is enabled link will not work', 'uael' ),
							'type'        => Controls_Manager::URL,
							'placeholder' => __( 'https://your-link.com', 'uael' ),
							'default'     => [
								'url' => '',
							],
							'dynamic'     => [
								'active' => true,
							],
						]
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab( 'style_tab', [ 'label' => __( 'Style', 'uael' ) ] );

					$repeater->add_responsive_control(
						'hotspot_img_size',
						[
							'label'      => __( 'Image Size', 'uael' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', 'rem' ],
							'range'      => [
								'px' => [
									'min' => 1,
									'max' => 100,
								],
							],
							'default'    => [
								'size' => 30,
								'unit' => 'px',
							],
							'condition'  => [
								'hotspot' => 'image',
							],
							'selectors'  => [
								'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$repeater->add_control(
						'hotspot_marker_options',
						[
							'label'        => __( 'Override Global Settings', 'uael' ),
							'type'         => Controls_Manager::SWITCHER,
							'default'      => 'no',
							'label_on'     => __( 'Yes', 'uael' ),
							'label_off'    => __( 'No', 'uael' ),
							'return_value' => 'yes',
						]
					);

					$repeater->add_responsive_control(
						'hotspot_icon_size',
						[
							'label'      => __( 'Icon Size', 'uael' ),
							'type'       => Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', 'rem' ],
							'range'      => [
								'px' => [
									'min' => 1,
									'max' => 100,
								],
							],
							'condition'  => [
								'hotspot_marker_options' => 'yes',
								'hotspot'                => 'icon',
							],
							'selectors'  => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .uael-hotspot-content' => 'font-size: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$repeater->add_control(
						'hotspot_icons_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .uael-hotspot-content, 
								{{WRAPPER}} {{CURRENT_ITEM}} .uael-hotspot-content.uael-hotspot-anim:before' => 'color: {{VALUE}};',
							],
							'condition' => [
								'hotspot_marker_options' => 'yes',
								'hotspot'                => [ 'text', 'icon' ],
							],
						]
					);

					$repeater->add_control(
						'hotspot_marker_bgcolor',
						[
							'label'     => __( 'Background Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'condition' => [
								'hotspot_marker_options' => 'yes',
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}} .uael-hotspot-content, 
								{{WRAPPER}} {{CURRENT_ITEM}} .uael-hotspot-content.uael-hotspot-anim:before' => 'background-color: {{VALUE}};',
							],
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$this->add_control(
				'hotspots_list',
				[
					'label'       => __( 'Hotspot', 'uael' ),
					'show_label'  => false,
					'type'        => Controls_Manager::REPEATER,
					'default'     => [
						[
							'text' => 'Marker 1',
							'icon' => 'fa fa-dot-circle-o',
						],
					],
					'fields'      => array_values( $repeater->get_controls() ),
					'title_field' => '{{{ text }}}',
					'condition'   => [
						'image[url]!' => '',
					],
					'separator'   => 'none',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Hotspot Tour Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_hotspot_tour_controls() {
		$this->start_controls_section(
			'section_tour',
			[
				'label'     => __( 'Hotspot Tour', 'uael' ),
				'condition' => [
					'hotspot_tooltip_data' => 'yes',
				],
			]
		);

		$this->add_control(
			'hotspot_tour',
			[
				'label'        => __( 'Enable Tour', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hotspot_tour_repeat',
			[
				'label'        => __( 'Repeat Tour', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'condition'    => [
					'image[url]!'  => '',
					'hotspot_tour' => 'yes',
				],
			]
		);

		$this->add_control(
			'hotspot_tour_autoplay',
			[
				'label'        => __( 'Autoplay', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'condition'    => [
					'image[url]!'  => '',
					'hotspot_tour' => 'yes',
				],
			]
		);

		if ( parent::is_internal_links() ) {

			$this->add_control(
				'help_doc_tour_repeat',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( 'Note: Tour autoplay option will only work on the frontend.', 'uael' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'image[url]!'           => '',
						'hotspot_tour'          => 'yes',
						'hotspot_tour_autoplay' => 'yes',

					],
				]
			);
		}

		$this->add_control(
			'tour_interval',
			[
				'label'              => __( 'Interval between Tooltips (sec)', 'uael' ),
				'description'        => __( 'Next tooltip will be displayed after this time interval', 'uael' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => [
					'sec' => [
						'min' => 1,
						'max' => 9,
					],
				],
				'default'            => [
					'size' => 4,
					'unit' => 'sec',
				],
				'condition'          => [
					'image[url]!'           => '',
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_options',
			[
				'label'     => __( 'Launch Tour', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'click',
				'options'   => [
					'click' => __( 'On Button Click', 'uael' ),
					'auto'  => __( 'When Widget is in Viewport', 'uael' ),
				],
				'condition' => [
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'hotspot_nonactive_markers',
			[
				'label'        => __( 'Hide Non-Active Markers', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'condition'    => [
					'image[url]!'  => '',
					'hotspot_tour' => 'yes',
				],
			]
		);

		$this->add_control(
			'overlay_button_heading',
			[
				'label'     => __( 'Overlay Button', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
					'autoplay_options'      => 'click',
				],
			]
		);

		$this->add_control(
			'overlay_button_text',
			[
				'label'     => __( 'Button Text', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Start Tour', 'uael' ),
				'condition' => [
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
					'autoplay_options'      => 'click',
				],
				'dynamic'   => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'overlay_button_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'sm',
				'options'   => [
					'xs' => __( 'Extra Small', 'uael' ),
					'sm' => __( 'Small', 'uael' ),
					'md' => __( 'Medium', 'uael' ),
					'lg' => __( 'Large', 'uael' ),
					'xl' => __( 'Extra Large', 'uael' ),
				],
				'condition' => [
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
					'autoplay_options'      => 'click',
				],
			]
		);

		$this->add_control(
			'overlay_pos_horizontal',
			[
				'label'     => __( 'Horizontal position (%)', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 0.1,
					],
				],
				'condition' => [
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
					'autoplay_options'      => 'click',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-overlay-button' => 'left: {{SIZE}}%; transform: translate(-{{SIZE}}%, 0);',
				],
			]
		);

		$this->add_control(
			'overlay_pos_vertical',
			[
				'label'     => __( 'Vertical position (%)', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 0.1,
					],
				],
				'condition' => [
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
					'autoplay_options'      => 'click',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-overlay-button' => 'top: {{SIZE}}%; transform: translate(0, -{{SIZE}}%);',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.9.0
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
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/hotspot-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_6',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s How Hotspot Tour works? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-hotspot-tour-works/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_2',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s Styling a Marker in Hotspot widget » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/styling-hotspot-marker/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_3',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s Unable to access the URL assigned to marker? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/unable-to-access-the-url-assigned-to-marker/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_4',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s How Max-height option works? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-max-height-option-works/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_5',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s Unable to click on markers when Hotspot Tour option is enabled? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/unable-to-click-on-markers/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_7',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s Filters/Actions » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/filters-actions-for-hotspot-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

			$this->end_controls_section();
		}
	}

	/**
	 * Register Hotspot Tooltip Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_tooltip_content_controls() {
		$this->start_controls_section(
			'section_tooltip',
			[
				'label' => __( 'Tooltip', 'uael' ),

			]
		);

		$this->add_control(
			'hotspot_tooltip_data',
			[
				'label'        => __( 'Enable Tooltip', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
			]
		);

			$this->add_control(
				'position',
				[
					'label'              => __( 'Position', 'uael' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'top',
					'options'            => [
						'top'    => __( 'Top', 'uael' ),
						'bottom' => __( 'Bottom', 'uael' ),
						'left'   => __( 'Left', 'uael' ),
						'right'  => __( 'Right', 'uael' ),
					],
					'condition'          => [
						'image[url]!'          => '',
						'hotspot_tooltip_data' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'trigger',
				[
					'label'              => __( 'Display on', 'uael' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'hover',
					'options'            => [
						'hover' => __( 'Hover', 'uael' ),
						'click' => __( 'Click', 'uael' ),
					],
					'condition'          => [
						'image[url]!'          => '',
						'hotspot_tour!'        => 'yes',
						'hotspot_tooltip_data' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'arrow',
				[
					'label'     => __( 'Arrow', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'true',
					'options'   => [
						'true'  => __( 'Show', 'uael' ),
						'false' => __( 'Hide', 'uael' ),
					],
					'condition' => [
						'image[url]!'          => '',
						'hotspot_tooltip_data' => 'yes',
					],
				]
			);

			$this->add_control(
				'distance',
				[
					'label'       => __( 'Distance', 'uael' ),
					'description' => __( 'The distance between the marker and the tooltip.', 'uael' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 6,
						'unit' => 'px',
					],
					'range'       => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'condition'   => [
						'image[url]!'          => '',
						'hotspot_tooltip_data' => 'yes',
					],
				]
			);

			$this->add_control(
				'tooltip_anim',
				[
					'label'     => __( 'Animation Type', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'fade',
					'options'   => [
						'fade'  => __( 'Default', 'uael' ),
						'grow'  => __( 'Grow', 'uael' ),
						'swing' => __( 'Swing', 'uael' ),
						'slide' => __( 'Slide', 'uael' ),
						'fall'  => __( 'Fall', 'uael' ),
					],
					'condition' => [
						'hotspot_tooltip_data' => 'yes',
					],
				]
			);

			$this->add_control(
				'hotspot_tooltip_adv',
				[
					'label'        => __( 'Advanced Settings', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'condition'    => [
						'hotspot_tooltip_data' => 'yes',
					],
				]
			);

			$this->add_control(
				'anim_duration',
				[
					'label'              => __( 'Animation Duration', 'uael' ),
					'type'               => Controls_Manager::SLIDER,
					'range'              => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
					],
					'default'            => [
						'size' => 350,
						'unit' => 'px',
					],
					'condition'          => [
						'image[url]!'          => '',
						'hotspot_tooltip_adv'  => 'yes',
						'hotspot_tooltip_data' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_responsive_control(
				'tooltip_height',
				[
					'label'              => __( 'Max Height', 'uael' ),
					'description'        => __( 'Note: If Tooltip Content is large, a vertical scroll will appear. Set Max Height to manage the content window height.', 'uael' ),
					'type'               => Controls_Manager::SLIDER,
					'range'              => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
					],
					'condition'          => [
						'image[url]!'          => '',
						'hotspot_tooltip_adv'  => 'yes',
						'hotspot_tooltip_data' => 'yes',
					],
					'selectors'          => [
						'.tooltipster-base.tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .tooltipster-content' => 'max-height: {{SIZE}}px;',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'zindex',
				[
					'label'       => __( 'Z-Index', 'uael' ),
					'description' => __( 'Note: Increase the z-index value if you are unable to see the tooltip. For example - 99, 999, 9999 ', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => '99',
					'min'         => -9999999,
					'step'        => 1,
					'condition'   => [
						'image[url]!'          => '',
						'hotspot_tooltip_adv'  => 'yes',
						'hotspot_tooltip_data' => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Hotspot Image Style Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_image_style_controls() {
		$this->start_controls_section(
			'section_img_style',
			[
				'label' => __( 'Image', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'opacity',
				[
					'label'     => __( 'Opacity (%)', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 1,
					],
					'range'     => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-hotspot img' => 'opacity: {{SIZE}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Hotspot Style Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_hotspot_style_controls() {
		$this->start_controls_section(
			'section_hotspot_style',
			[
				'label' => __( 'Marker', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'hotspot_anim',
				[
					'label'        => __( 'Glow Effect', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
				]
			);

			$this->add_responsive_control(
				'hotspot_bg_size',
				[
					'label'      => __( 'Background Size', 'uael' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em' ],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						'em' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'default'    => [
						'size' => '2',
						'unit' => 'em',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-hotspot-content, 
						{{WRAPPER}} .uael-hotspot-content.uael-hotspot-anim:before' => 'min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'hotspot_typography',
					'selector' => '{{WRAPPER}} .uael-hotspot-content',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				]
			);

			$this->start_controls_tabs( 'hotspot_tabs_style' );

				$this->start_controls_tab(
					'hotspot_normal',
					[
						'label' => __( 'Normal', 'uael' ),
					]
				);
					$this->add_control(
						'hotspot_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content, 
								{{WRAPPER}} .uael-hotspot-content.uael-hotspot-anim:before' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'hotspot_background_color',
						[
							'label'     => __( 'Background Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_1,
							],
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content, 
								{{WRAPPER}} .uael-hotspot-content.uael-hotspot-anim:before' => 'background-color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'hotspot_border',
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
							'selectors'   => [
								'{{WRAPPER}} .uael-hotspot-content' => 'border-style: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'hotspot_border_size',
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
								'hotspot_border!' => 'none',
							],
							'selectors'  => [
								'{{WRAPPER}} .uael-hotspot-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'hotspot_border_color',
						[
							'label'     => __( 'Border Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_1,
							],
							'condition' => [
								'hotspot_border!' => 'none',
							],
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'hotspot_border_radius',
						[
							'label'     => __( 'Rounded Corners', 'uael' ),
							'type'      => Controls_Manager::SLIDER,
							'default'   => [
								'size' => 100,
							],
							'range'     => [
								'px' => [
									'max' => 100,
									'min' => 0,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content, 
								{{WRAPPER}} .uael-hotspot-content.uael-hotspot-anim:before' => 'border-radius: {{SIZE}}px;',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'hotspot_box_shadow',
							'selector'  => '{{WRAPPER}} .uael-hotspot-content',
							'separator' => '',
						]
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'hotspot_hover',
					[
						'label' => __( 'Hover / Active', 'uael' ),
					]
				);
					$this->add_control(
						'hotspot_hover_color',
						[
							'label'     => __( 'Text Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content:hover, {{WRAPPER}} .uael-hotspot-tour .uael-hotspot-content.open' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'hotspot_hover_bgcolor',
						[
							'label'     => __( 'Background Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_1,
							],
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content:hover, 
								{{WRAPPER}} .uael-hotspot-content.uael-hotspot-anim:hover:before, 
								{{WRAPPER}} .uael-hotspot-tour .uael-hotspot-content.open, 
								{{WRAPPER}} .uael-hotspot-tour .open.uael-hotspot-anim:before' => 'background-color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'hotspot_hover_border_color',
						[
							'label'     => __( 'Border Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'condition' => [
								'hotspot_border!' => 'none',
							],
							'selectors' => [
								'{{WRAPPER}} .uael-hotspot-content:hover, {{WRAPPER}} .uael-hotspot-tour .uael-hotspot-content.open' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'hotspot_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .uael-hotspot-content:hover, {{WRAPPER}} .uael-hotspot-tour .uael-hotspot-content.open',
							'separator' => '',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Hotspot General Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_tooltip_style_controls() {

		$this->start_controls_section(
			'section_tooltip_style',
			[
				'label'     => __( 'Tooltip', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'hotspot_tooltip_data' => 'yes',
				],
			]
		);

			$this->add_control(
				'uael_tooltip_align',
				[
					'label'     => __( 'Text Alignment', 'uael' ),
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
					'selectors' => [
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .tooltipster-content' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'uael_tooltip_typography',
					'label'    => __( 'Typography', 'uael' ),
					'selector' => '.tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .tooltipster-content, .tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .uael-tour li a',
				]
			);

			$this->add_control(
				'uael_tooltip_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}}.uael-tooltipster-active .tooltipster-content, .tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .uael-tour li a, .tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .uael-tour-active .uael-hotspot-end a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'uael_tooltip_bgcolor',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}}.uael-tooltipster-active .tooltipster-box' => 'background-color: {{VALUE}};',
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}}.tooltipster-noir.tooltipster-bottom .tooltipster-arrow-background' => 'border-bottom-color: {{VALUE}};',
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}}.tooltipster-noir.tooltipster-left .tooltipster-arrow-background' => 'border-left-color: {{VALUE}};',
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}}.tooltipster-noir.tooltipster-right .tooltipster-arrow-background' => 'border-right-color: {{VALUE}};',
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}}.tooltipster-noir.tooltipster-top .tooltipster-arrow-background' => 'border-top-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'uael_tooltip_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default'    => [
						'top'    => '20',
						'bottom' => '20',
						'left'   => '20',
						'right'  => '20',
						'unit'   => 'px',
					],
					'selectors'  => [
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .tooltipster-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'uael_tooltip_radius',
				[
					'label'      => __( 'Rounded Corners', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default'    => [
						'top'    => '10',
						'bottom' => '10',
						'left'   => '10',
						'right'  => '10',
						'unit'   => 'px',
					],
					'selectors'  => [
						'.tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .tooltipster-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'uael_tooltip_shadow',
					'selector'  => '.tooltipster-sidetip.uael-tooltip-wrap-{{ID}} .tooltipster-box',
					'separator' => '',
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register Hotspot Tour Style Controls.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function register_hotspot_overlay_controls() {

		$this->start_controls_section(
			'section_overlay',
			[
				'label'     => __( 'Hotspot Tour', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'hotspot_tooltip_data'  => 'yes',
					'hotspot_tour'          => 'yes',
					'hotspot_tour_autoplay' => 'yes',
					'autoplay_options'      => 'click',
				],
			]
		);

			$this->add_control(
				'overlay_bg_color',
				[
					'label'     => __( 'Overlay Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0, 0, 0, 0.57)',
					'selectors' => [
						'{{WRAPPER}} .uael-hotspot-overlay' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'hotspot_tour'          => 'yes',
						'hotspot_tour_autoplay' => 'yes',
						'autoplay_options'      => 'click',
					],
				]
			);

			$this->add_control(
				'overlay_button_style',
				[
					'label'     => __( 'Overlay Button', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'hotspot_tour'          => 'yes',
						'hotspot_tour_autoplay' => 'yes',
						'autoplay_options'      => 'click',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'overlay_button_typography',
					'label'     => __( 'Typography', 'uael' ),
					'selector'  => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
					'condition' => [
						'hotspot_tour'          => 'yes',
						'hotspot_tour_autoplay' => 'yes',
						'autoplay_options'      => 'click',
					],
				]
			);

			$this->add_responsive_control(
				'overlay_button_custom_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'hotspot_tour'          => 'yes',
						'hotspot_tour_autoplay' => 'yes',
						'autoplay_options'      => 'click',
					],
				]
			);

			$this->start_controls_tabs( 'overlay_tabs_button_style' );

				$this->start_controls_tab(
					'overlay_button_normal',
					[
						'label'     => __( 'Normal', 'uael' ),
						'condition' => [
							'hotspot_tour'          => 'yes',
							'hotspot_tour_autoplay' => 'yes',
							'autoplay_options'      => 'click',
						],
					]
				);
					$this->add_control(
						'overlay_button_text_color',
						[
							'label'     => __( 'Text Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'condition' => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
							],
							'selectors' => [
								'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'overlay_button_bgcolor',
							'label'          => __( 'Background Color', 'uael' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .elementor-button',
							'condition'      => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
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

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'      => 'overlay_button_border',
							'selector'  => '{{WRAPPER}} .elementor-button',
							'condition' => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
							],
						]
					);

					$this->add_control(
						'overlay_button_radius',
						[
							'label'      => __( 'Rounded Corners', 'uael' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'default'    => [
								'top'    => '0',
								'bottom' => '0',
								'left'   => '0',
								'right'  => '0',
								'unit'   => 'px',
							],
							'selectors'  => [
								'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
							'condition'  => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'overlay_button_box_shadow',
							'selector'  => '{{WRAPPER}} .elementor-button',
							'condition' => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'overlay_button_hover',
					[
						'label'     => __( 'Hover', 'uael' ),
						'condition' => [
							'hotspot_tour'          => 'yes',
							'hotspot_tour_autoplay' => 'yes',
							'autoplay_options'      => 'click',
						],
					]
				);
					$this->add_control(
						'overlay_button_hover_color',
						[
							'label'     => __( 'Text Hover Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'condition' => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
							],
							'selectors' => [
								'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'overlay_button_hover_bgcolor',
							'label'          => __( 'Background Hover Color', 'uael' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover',
							'condition'      => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
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

					$this->add_control(
						'overlay_button_border_hover_color',
						[
							'label'     => __( 'Border Hover Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'condition' => [
								'hotspot_tour'          => 'yes',
								'hotspot_tour_autoplay' => 'yes',
								'autoplay_options'      => 'click',
							],
							'selectors' => [
								'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Get Data Attributes.
	 *
	 * @since 1.9.0
	 * @param array   $settings The settings array.
	 * @param boolean $device specifies mobile devices.
	 * @return string Data Attributes
	 * @access public
	 */
	public function get_data_attrs( $settings, $device ) {

		$marker_length = sizeof( $settings['hotspots_list'] );

		$side             = $settings['position'];
		$trigger          = '';
		$tour_autoplay    = '';
		$tour_repeat      = '';
		$tour_overlay     = '';
		$arrow            = $settings['arrow'];
		$animation        = $settings['tooltip_anim'];
		$zindex           = ( 'yes' == $settings['hotspot_tooltip_adv'] ) ? $settings['zindex'] : 99;
		$interval_val     = $settings['tour_interval']['size'];
		$delay            = 300;
		$anim_duration    = ( 'yes' == $settings['hotspot_tooltip_adv'] ) ? $settings['anim_duration']['size'] : 350;
		$distance         = ( '' != $settings['distance']['size'] ) ? $settings['distance']['size'] : 6;
		$action_auto      = ( 'auto' == $settings['autoplay_options'] ) ? 'auto' : '';
		$hotspot_viewport = 90;
		$maxwidth         = 250;
		$minwidth         = 0;

		if ( '' == $interval_val ) {
			$tour_interval = 4000;
		} else {
			$tour_interval = $interval_val * 1000;
		}

		if ( 'yes' == $settings['hotspot_tour'] && 'yes' == $settings['hotspot_tooltip_data'] ) {
			$trigger = 'custom';

			if ( 'yes' == $settings['hotspot_tour_autoplay'] ) {
				$tour_autoplay = 'yes';
				$tour_overlay  = ( 'click' == $settings['autoplay_options'] ) ? 'yes' : 'no';
				if ( 'yes' == $settings['hotspot_tour_repeat'] ) {
					$tour_repeat = 'yes';
				} else {
					$tour_repeat = 'no';
				}
			} else {
				$tour_autoplay = 'no';
				$tour_overlay  = 'no';
				if ( 'yes' == $settings['hotspot_tour_repeat'] ) {
					$tour_repeat = 'yes';
				} else {
					$tour_repeat = 'no';
				}
			}
		} else {
			if ( true == $device ) {
				$trigger = 'click';
			} else {
				$trigger = $settings['trigger'];
			}
		}

		$hotspot_viewport = apply_filters( 'uael_hotspot_viewport', $hotspot_viewport );

		$maxwidth = apply_filters( 'uael_tooltip_maxwidth', $maxwidth, $settings );
		$minwidth = apply_filters( 'uael_tooltip_minwidth', $minwidth, $settings );

		$data_attr  = 'data-side="' . $side . '" ';
		$data_attr .= 'data-hotspottrigger="' . $trigger . '" ';
		$data_attr .= 'data-arrow="' . $arrow . '" ';
		$data_attr .= 'data-distance="' . $distance . '" ';
		$data_attr .= 'data-delay="' . $delay . '" ';
		$data_attr .= 'data-animation="' . $animation . '" ';
		$data_attr .= 'data-animduration="' . $anim_duration . '" ';
		$data_attr .= 'data-zindex="' . $zindex . '" ';
		$data_attr .= 'data-length="' . $marker_length . '" ';
		$data_attr .= 'data-autoplay="' . $tour_autoplay . '" ';
		$data_attr .= 'data-repeat="' . $tour_repeat . '" ';
		$data_attr .= 'data-tourinterval="' . $tour_interval . '" ';
		$data_attr .= 'data-overlay="' . $tour_overlay . '" ';
		$data_attr .= 'data-autoaction="' . $action_auto . '" ';
		$data_attr .= 'data-hotspotviewport="' . $hotspot_viewport . '" ';
		$data_attr .= 'data-tooltip-maxwidth="' . $maxwidth . '" ';
		$data_attr .= 'data-tooltip-minwidth="' . $minwidth . '" ';

		return $data_attr;

	}

	/**
	 * Render Hotspot output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function render() {
		$html     = '';
		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		$device   = false;

		$iphone  = ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) ) ? true : false );
		$ipad    = ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) ) ? true : false );
		$android = ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) ) ? true : false );

		if ( $iphone || $ipad || $android ) {
			$device = true;
		}

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$hotspot_tour   = '';
		$tour_enable    = '';
		$hide_nonactive = '';

		$tooltip_enable = ( 'yes' == $settings['hotspot_tooltip_data'] ) ? 'uael-hotspot-tooltip-yes' : '';

		if ( 'yes' == $settings['hotspot_tour'] ) {
			$hotspot_tour = 'uael-tour-active';
			$tour_enable  = ' uael-hotspot-tour';
			if ( 'yes' == $settings['hotspot_nonactive_markers'] ) {
				$hide_nonactive = 'uael-hotspot-marker-nonactive';
			}
		} else {
			$hotspot_tour = 'uael-tour-inactive';
		}
		?>

		<div class="uael-hotspot <?php echo $tour_enable . ' ' . $tooltip_enable; ?> ">
			<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>		
			<?php
			if ( $settings['hotspots_list'] ) :
				$counter = 1;
				?>

			<div class="uael-hotspot-container" <?php echo $this->get_data_attrs( $settings, $device ); ?>>

				<?php
				foreach ( $settings['hotspots_list'] as $index => $item ) :

					$hotspot_icon = false;
					$hotspot_img  = false;
					$tooltip_data = $this->get_repeater_setting_key( 'content', 'hotspots_list', $index );
					$content_id   = $this->get_id() . '-' . $item['_id'];
					$hotspot_glow = '';

					if ( ! empty( $item['marker_link']['url'] ) ) {
						$this->add_render_attribute( 'url-' . $item['_id'], 'href', $item['marker_link']['url'] );

						if ( $item['marker_link']['is_external'] ) {
							$this->add_render_attribute( 'url-' . $item['_id'], 'target', '_blank' );
						}

						if ( ! empty( $item['marker_link']['nofollow'] ) ) {
							$this->add_render_attribute( 'url-' . $item['_id'], 'rel', 'nofollow' );
						}
						$link = $this->get_render_attribute_string( 'url-' . $item['_id'] );
					}

					$this->add_render_attribute(
						$tooltip_data,
						[
							'class' => 'uael-tooltip-text ' . $hotspot_tour,
							'id'    => 'uael-tooltip-content-' . $content_id,
						]
					);

					if ( 'icon' === $item['hotspot'] && ! empty( $item['icon'] ) ) {
						$hotspot_icon = true;

						$icon_data = 'icon-' . $index;

						$this->add_render_attribute( $icon_data, 'class', esc_attr( $item['icon'] ) );
					}
					if ( 'image' === $item['hotspot'] && ! empty( $item['repeater_image'] ) ) {
						$hotspot_img = true;

						$this->add_render_attribute( 'hotspot_image' . $index, 'src', $item['repeater_image']['url'] );
						$this->add_render_attribute( 'hotspot_image' . $index, 'class', 'uael-hotspot-img image-' . $index );
						$image_html = '<img ' . $this->get_render_attribute_string( 'hotspot_image' . $index ) . '>';
					}

					if ( 'yes' == $settings['hotspot_anim'] ) {
						$hotspot_glow = ' uael-hotspot-anim';
					}
					?>
					<?php if ( ! empty( $item['marker_link']['url'] ) ) { ?>
						<?php if ( 'yes' == $settings['hotspot_tooltip_data'] ) { ?>
							<?php if ( 'yes' !== $settings['hotspot_tour'] && 'hover' == $settings['trigger'] ) { ?>
								<a <?php echo $link; ?> >
							<?php } ?>
						<?php } else { ?>
							<a <?php echo $link; ?> >
						<?php } ?>
					<?php } ?>
					<span class="uael-tooltip elementor-repeater-item-<?php echo $item['_id']; ?>">
						<span class="uael-hotspot-main-<?php echo $node_id; ?> uael-hotspot-content<?php echo $hotspot_glow; ?> <?php echo $hide_nonactive; ?>" id="uael-tooltip-id-<?php echo $node_id . '-' . $counter; ?>" data-uaeltour="<?php echo $counter; ?>" data-tooltip-content="<?php echo '#uael-tooltip-content-' . $content_id; ?>">
							<?php
							if ( $hotspot_icon ) {
								?>
								<i <?php echo $this->get_render_attribute_string( $icon_data ); ?>></i>
												<?php
							} elseif ( $hotspot_img ) {
								echo $image_html;
							} else {
								echo '<span class="uael-hotspot-text">' . $item['text'] . '</span>';
							}
							?>
						</span>
					</span>
					<?php if ( ! empty( $item['marker_link']['url'] ) ) { ?>
						<?php if ( 'yes' == $settings['hotspot_tooltip_data'] ) { ?>
							<?php if ( 'yes' !== $settings['hotspot_tour'] && 'hover' == $settings['trigger'] ) { ?>
								</a>
							<?php } ?>
						<?php } else { ?>
							</a>
						<?php } ?>
					<?php } ?>

					<?php
						$next_label     = __( 'Next', 'uael' );
						$previous_label = __( 'Previous', 'uael' );
						$endtour_label  = __( 'End Tour', 'uael' );
						$next           = apply_filters( 'uael_hotspot_next_label', $next_label, $settings );
						$previous       = apply_filters( 'uael_hotspot_previous_label', $previous_label, $settings );
						$end            = apply_filters( 'uael_hotspot_endtour_label', $endtour_label, $settings );
					?>
					<?php if ( 'yes' == $settings['hotspot_tooltip_data'] ) { ?>
						<span class="uael-tooltip-container">							
							<span <?php echo $this->get_render_attribute_string( $tooltip_data ); ?>><?php echo $this->parse_text_editor( $item['content'] ); ?>
								<span class="uael-tour"><span class="uael-actual-step"><?php echo $counter; ?> <?php echo __( 'of', 'uael' ); ?> <?php echo sizeof( $settings['hotspots_list'] ); ?></span><ul><li><a href="#0" class="uael-prev-<?php echo $node_id; ?>" data-tooltipid="<?php echo $counter; ?>">&#171; <?php echo $previous; ?></a></li><li><a href="#0" class="uael-next-<?php echo $node_id; ?>" data-tooltipid="<?php echo $counter; ?>"><?php echo $next; ?> &#187;</a></li></ul></span>
								<?php
								if ( 'yes' == $settings['hotspot_tour_autoplay'] && 'yes' == $settings['hotspot_tour_repeat'] ) {
									?>
									<span class="uael-hotspot-end"><a href="#" class="uael-tour-end-<?php echo $node_id; ?>"><?php echo $end; ?></a></span><?php } ?>
							</span>
						</span>
					<?php } ?>
					<?php
					$counter++;
					endforeach;
				?>
				</div>
			<?php endif; ?>

			<?php if ( 'yes' == $settings['hotspot_tour'] && 'yes' == $settings['hotspot_tour_autoplay'] && 'yes' == $settings['hotspot_tooltip_data'] && 'click' == $settings['autoplay_options'] ) { ?>
				<?php
					$this->add_render_attribute( 'button', 'class', 'elementor-button' );
				if ( ! empty( $settings['overlay_button_size'] ) ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['overlay_button_size'] );
				}
				?>
				<div class="uael-hotspot-overlay">
					<div class="uael-overlay-button">
						<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
							<span class="elementor-button-text elementor-inline-editing" data-elementor-setting-key="overlay_button_text" data-elementor-inline-editing-toolbar="none"><?php echo $settings['overlay_button_text']; ?></span>
						</a>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Render Hotspot widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.9.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
			var length = settings.hotspots_list.length;

			function data_attributes() {
				var side			= settings.position;
				var trigger			= '';
				var tour_autoplay 	= '';
				var tour_repeat  	= '';
				var tour_overlay  	= '';
				var arrow			= settings.arrow;
				var animation		= settings.tooltip_anim;
				var zindex			= ( 'yes' == settings.hotspot_tooltip_adv ) ? settings.zindex : 99;
				var interval_val 	= settings.tour_interval.size;
				var action_auto   	= ( 'auto' == settings.autoplay_options ) ? 'auto' : '';

				var delay			= 300;

				var anim_duration			= ( 'yes' == settings.hotspot_tooltip_adv ) ? settings.anim_duration.size : 350;

				var distance			= ( '' != settings.distance.size ) ? settings.distance.size : 6;

				if( '' == interval_val ) {
					tour_interval = 4000;
				} else {
					tour_interval = interval_val * 1000;
				}

				if ( 'yes' == settings.hotspot_tour && 'yes' == settings.hotspot_tooltip_data ) {
					trigger = 'custom';

					if ( 'yes' == settings.hotspot_tour_autoplay ) {
						tour_autoplay = 'yes';
						tour_overlay = ( 'click' == settings.autoplay_options ) ? 'yes' : 'no';

						if ( 'yes' == settings.hotspot_tour_repeat ) {
							tour_repeat = 'yes';
						} else {
							tour_repeat = 'no';
						}
					} else {
						tour_autoplay = 'no';
						tour_overlay = 'no';

						if ( 'yes' == settings.hotspot_tour_repeat ) {
							tour_repeat = 'yes';
						} else {
							tour_repeat = 'no';
						}
					}
				} else {
					trigger = settings.trigger;
				}

				var data_attr  = 'data-side="' + side + '" ';
					data_attr += 'data-hotspottrigger="' + trigger + '" ';
					data_attr += 'data-arrow="' + arrow + '" ';
					data_attr += 'data-distance="' + distance + '" ';
					data_attr += 'data-delay="' + delay + '" ';
					data_attr += 'data-animation="' + animation + '" ';
					data_attr += 'data-animduration="' + anim_duration + '" ';
					data_attr += 'data-zindex="' + zindex + '" ';
					data_attr += 'data-length="' + length + '" ';
					data_attr += 'data-autoplay="' + tour_autoplay + '" ';
					data_attr += 'data-repeat="' + tour_repeat + '" ';
					data_attr += 'data-tourinterval="' + tour_interval + '" ';
					data_attr += 'data-overlay="' + tour_overlay + '" ';
					data_attr += 'data-autoaction="' + action_auto + '" ';

				return data_attr;
			}
		#>
		<# if ( '' !== settings.image.url ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};
			var image_url = elementor.imagesManager.getImageUrl( image );
			var node_id = view.$el.data('id');
			var hotspot_tour = '';
			var tour_enable = '';
			var hide_nonactive = '';

			var tooltip_enable = ( 'yes' == settings.hotspot_tooltip_data ) ? ' uael-hotspot-tooltip-yes' : '';

			if ( 'yes' == settings.hotspot_tour ) {
				hotspot_tour = 'uael-tour-active';
				tour_enable  = ' uael-hotspot-tour';
			} else {
				hotspot_tour = 'uael-tour-inactive';
			}

			if( 'yes' == settings.hotspot_tour && 'yes' == settings.hotspot_nonactive_markers ) {
				hide_nonactive = 'uael-hotspot-marker-nonactive';
			}
			#>
			<# var param = data_attributes(); #>

			<div class="uael-hotspot{{ tour_enable }}{{ tooltip_enable }}">
				<img src="{{ image_url }}"/>
				<#
				if ( settings.hotspots_list ) {
					var counter = 1; #>
					<div class="uael-hotspot-container" {{{ param }}}>
						<# _.each( settings.hotspots_list, function( item ) {
							var hotspot_glow = '';
							if ( 'yes' == settings.hotspot_anim ) {
								hotspot_glow = ' uael-hotspot-anim';
							}

							if ( '' != item.marker_link.url ) {
								view.addRenderAttribute( 'url-' + item._id, 'href', item.marker_link.url );
							}
							#>

							<# if ( '' != item.marker_link.url ) { #>
								<# if ( 'yes' == settings.hotspot_tooltip_data ) { #>
									<# if ( 'yes' != settings.hotspot_tour && 'hover' == settings.trigger ) { #>
										<a {{{ view.getRenderAttributeString( 'url-' + item._id ) }}}>
									<# } #>
								<# } else { #>
									<a {{{ view.getRenderAttributeString( 'url-' + item._id ) }}}>
								<# } #>
							<# } #>

							<span class="uael-tooltip elementor-repeater-item-{{ item._id }}">
								<span class="uael-hotspot-main-{{ node_id }} uael-hotspot-content{{ hotspot_glow }} {{ hide_nonactive }}" id="uael-tooltip-id-{{ node_id }}-{{ counter }}" data-uaeltour="{{ counter }}" data-tooltip-content="#uael-tooltip-content-{{ item._id }}">
									<# if ( 'icon' === item.hotspot ) { #>
										<i class="{{ item.icon }}"></i>
									<# } else if ( 'image' === item.hotspot ) { #>
										<img src="{{ item.repeater_image.url }}" class="uael-hotspot-img" />
									<# } else { #>
											<span class="uael-hotspot-text">{{ item.text }}</span>
									<# } #>
								</span>
							</span>
							<# if ( '' != item.marker_link.url ) { #>
								<# if ( 'yes' == settings.hotspot_tooltip_data ) { #>
									<# if ( 'yes' != settings.hotspot_tour && 'hover' == settings.trigger ) { #>
										</a>
									<# } #>
								<# } else { #>
									</a>
								<# } #>
							<# } #>
							<# if ( 'yes' == settings.hotspot_tooltip_data ) { #>
								<span class="uael-tooltip-container">							
									<span class="uael-tooltip-text {{ hotspot_tour }}" id="uael-tooltip-content-{{ item._id }}">{{{ item.content }}}
										<span class="uael-tour"><span class="uael-actual-step">{{ counter }} of {{ length }}</span><ul><li><a href="#0" class="uael-prev-{{ node_id }}" data-tooltipid="{{ counter }}">&#171; <?php _e( 'Previous', 'uael' ); ?></a></li><li><a href="#0" class="uael-next-{{ node_id }}" data-tooltipid="{{ counter }}"><?php _e( 'Next', 'uael' ); ?> &#187;</a></li></ul></span>
									</span>
								</span>
							<# } #>
							<# counter++;
						}); #>
					</div>
				<# } #>
				<# if( 'yes' == settings.hotspot_tour && 'yes' == settings.hotspot_tour_autoplay && 'yes' == settings.hotspot_tooltip_data && 'click' == settings.autoplay_options ) { #>
					<#
						view.addRenderAttribute( 'button', 'class', 'elementor-button' );
						if ( '' != settings.overlay_button_size ) {
							view.addRenderAttribute( 'button', 'class', 'elementor-size-' + settings.overlay_button_size );
						}
					#>
					<div class="uael-hotspot-overlay">
						<div class="uael-overlay-button">
							<a {{{ view.getRenderAttributeString( 'button' ) }}}>
								<span class="elementor-button-text elementor-inline-editing" data-elementor-setting-key="overlay_button_text" data-elementor-inline-editing-toolbar="none">{{ settings.overlay_button_text }}</span>
							</a>
						</div>
					</div>
				<# } #>
			</div>
		<# } #>
		<# elementorFrontend.hooks.doAction( 'frontend/element_ready/uael-hotspot.default' ); #>
		<?php
	}
}
