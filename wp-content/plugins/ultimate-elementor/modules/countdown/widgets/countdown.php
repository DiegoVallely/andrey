<?php
/**
 * UAEL Countdown Timer.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Countdown\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Countdown.
 */
class Countdown extends Common_Widget {

	/**
	 * Retrieve Countdown Widget name.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Countdown' );
	}

	/**
	 * Retrieve Countdown Widget heading.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return string Widget heading.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Countdown' );
	}

	/**
	 * Retrieve Countdown Widget icon.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Countdown' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Countdown' );
	}

	/**
	 * Retrieve the list of styles needed for Hotspot.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return [ 'uael-countdown' ];
	}

	/**
	 * Retrieve the list of scripts the Hotspot widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-cookie-lib', 'uael-countdown' ];
	}


	/**
	 * Register Countdown controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function _register_controls() {

		// Content Tab.
		$this->register_countdown_general_controls();
		$this->register_after_countdown_expire_controls();
		$this->register_countdown_label_controls();
		$this->register_countdown_style_controls();
		$this->register_helpful_information();

		$this->register_style_controls();
		$this->register_digits_style_controls();
		$this->register_label_style_controls();
		$this->register_message_style_controls();
	}


	/**
	 * Register Countdown General Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_countdown_general_controls() {

		$this->start_controls_section(
			'countdown_content',
			[
				'label' => __( 'General', 'uael' ),
			]
		);

		$this->add_control(
			'countdown_type',
			[
				'label'   => __( 'Type', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'fixed'     => __( 'Fixed Timer', 'uael' ),
					'evergreen' => __( 'Evergreen Timer', 'uael' ),
					'recurring' => __( 'Recurring Timer', 'uael' ),
				],
				'default' => 'fixed',
			]
		);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'doc_fixed_timer',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( 'Click <a href="%s" target="_blank" rel="noopener">here</a> to know more about the <span style="text-decoration:underline;font-weight:900;">Fixed Timer</span>.', 'uael' ), 'https://uaelementor.com/docs/types-of-timers-in-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#fixed-timer' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'countdown_type' => [ 'fixed' ],
					],
				]
			);
		}

		$this->add_control(
			'due_date',
			[
				'label'       => __( 'Due Date and Time', 'uael' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) ) ),
				/* translators: %s: Time zone. */
				'description' => sprintf( __( 'Date set according to your timezone: %s.', 'uael' ), Utils::get_timezone_string() ),
				'condition'   => [
					'countdown_type' => [ 'fixed' ],
				],
				'label_block' => false,
			]
		);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'doc_evergreen_timer',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( 'Click <a href="%s" target="_blank" rel="noopener">here</a> to know more about the <span style="text-decoration:underline;font-weight:900;">Evergreen Timer</span>.', 'uael' ), 'https://uaelementor.com/docs/types-of-timers-in-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#evergreen-timer' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'countdown_type' => [ 'evergreen' ],
					],
				]
			);
		}

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'doc_recur_timer',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( 'Click <a href="%s" target="_blank" rel="noopener">here</a> to know more about <span style="text-decoration:underline;font-weight:900;">Recurring Timer</span>.', 'uael' ), 'https://uaelementor.com/docs/faqs-for-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#what-is-the-difference-between-evergreen-and-recurring-timer-and-how-does-the-recurring-timer-works-' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'countdown_type' => 'recurring',
					],
				]
			);
		}

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'timezone_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s Doc Link */
					'raw'             => sprintf( __( 'Which <a href="%s" target="_blank" rel="noopener">timezone</a> does the timer use?', 'uael' ), 'https://uaelementor.com/docs/faqs-for-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#which-timezone-does-the-timer-use-' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'countdown_type' => 'fixed',
					],
				]
			);
		}

		$this->add_control(
			'start_date',
			[
				'label'       => __( 'Start Date and Time', 'uael' ),
				'description' => __( 'Select the date & time when you want to make your countdown timer go live on your site.', 'uael' ),
				'type'        => Controls_Manager::DATE_TIME,
				'label_block' => false,
				'default'     => date( 'Y-m-d H:i' ),
				'condition'   => [
					'countdown_type' => 'recurring',
				],
			]
		);

		$this->add_control(
			'evg_days',
			[
				'label'     => __( 'Days', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => '0',
				'max'       => '6',
				'default'   => '1',
				'condition' => [
					'countdown_type' => [ 'evergreen', 'recurring' ],
				],

			]
		);

		$this->add_control(
			'evg_hours',
			[
				'label'     => __( 'Hours', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => '0',
				'max'       => '23',
				'default'   => '5',
				'condition' => [
					'countdown_type' => [ 'evergreen', 'recurring' ],
				],
			]
		);

		$this->add_control(
			'evg_minutes',
			[
				'label'       => __( 'Minutes', 'uael' ),
				'description' => __( 'Set the above Days, Hours, Minutes fields for the amount of time you want the timer to display.', 'uael' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => '0',
				'max'         => '59',
				'default'     => '30',
				'condition'   => [
					'countdown_type' => [ 'evergreen', 'recurring' ],
				],
			]
		);

		$this->add_control(
			'reset_days',
			[
				'label'       => __( 'Repeat Timer after ( Days )', 'uael' ),
				'description' => __( 'Note: This option will repeat the timer after sepcified number of days.', 'uael' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => '1',
				'default'     => '7',
				'condition'   => [
					'countdown_type' => 'recurring',
				],
			]
		);

		$this->add_control(
			'display_days',
			[
				'label'        => __( 'Display Days', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'uael' ),
				'label_off'    => __( 'Hide', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'display_hours',
			[
				'label'        => __( 'Display Hours', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'uael' ),
				'label_off'    => __( 'Hide', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'display_minutes',
			[
				'label'        => __( 'Display Minutes', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'uael' ),
				'label_off'    => __( 'Hide', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'display_seconds',
			[
				'label'        => __( 'Display Seconds', 'uael' ),
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
	 * Register After Expire Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_after_countdown_expire_controls() {

		$this->start_controls_section(
			'countdown_expire_actions',
			[
				'label' => __( 'Action after expire', 'uael' ),
			]
		);

		$this->add_control(
			'expire_actions',
			[
				'label'       => __( 'Select Action', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'hide'         => __( 'Hide', 'uael' ),
					'redirect'     => __( 'Redirect', 'uael' ),
					'show_message' => __( 'Show Message', 'uael' ),
					'none'         => __( 'None', 'uael' ),
				],
				'label_block' => false,
				'default'     => 'hide',
			]
		);

		$this->add_control(
			'message_after_expire',
			[
				'label'       => __( 'Message', 'uael' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'condition'   => [
					'expire_actions' => 'show_message',
				],
				'default'     => __( 'Sale has ended!!', 'uael' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'expire_redirect_url',
			[
				'label'         => __( 'Redirect URL', 'uael' ),
				'type'          => Controls_Manager::URL,
				'label_block'   => true,
				'show_external' => false,
				'default'       => [
					'url' => '#',
				],
				'condition'     => [
					'expire_actions' => 'redirect',
				],
				'dynamic'       => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'preview_expire_message',
			[
				'label'        => __( 'Preview after expire message', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'expire_actions' => 'show_message',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register labels Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_countdown_label_controls() {

		$this->start_controls_section(
			'countdown_labels',
			[
				'label' => __( 'Labels', 'uael' ),
			]
		);

		$this->add_control(
			'display_timer_labels',
			[
				'label'   => __( 'Display Labels', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'uael' ),
					'custom'  => __( 'Custom', 'uael' ),
					'none'    => __( 'None', 'uael' ),
				],
			]
		);

		$this->add_control(
			'custom_days',
			[
				'label'       => __( 'Label for Days', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Days', 'uael' ),
				'condition'   => [
					'display_timer_labels' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'custom_hours',
			[
				'label'       => __( 'Label for Hours', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Hours', 'uael' ),
				'condition'   => [
					'display_timer_labels' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'custom_minutes',
			[
				'label'       => __( 'Label for Minutes', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Minutes', 'uael' ),
				'condition'   => [
					'display_timer_labels' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'custom_seconds',
			[
				'label'       => __( 'Label for Seconds', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Seconds', 'uael' ),
				'condition'   => [
					'display_timer_labels' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Countdown General Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_countdown_style_controls() {

		$this->start_controls_section(
			'style',
			[
				'label' => __( 'Layout', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'countdown_style',
			[
				'label'        => __( 'Select Style', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'square'  => 'Square',
					'circle'  => 'Circle',
					'rounded' => 'Rounded',
					'none'    => 'None',
				],
				'default'      => 'square',
				'prefix_class' => 'uael-countdown-shape-',
			]
		);

		$this->add_control(
			'rounded_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition'  => [
					'countdown_style' => 'rounded',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '10',
					'bottom' => '10',
					'left'   => '10',
					'right'  => '10',
					'unit'   => 'px',
				],
			]
		);

		$this->add_control(
			'countdown_separator',
			[
				'label'        => __( 'Separator', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'uael' ),
				'label_off'    => __( 'Disable', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'uael-countdown-separator-wrapper-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'countdown_separator_color',
			[
				'label'     => __( 'Separator Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-countdown-wrapper .uael-countdown-separator' => 'color:{{VALUE}};',
				],
				'condition' => [
					'countdown_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation',
			[
				'label'        => __( 'Flash Animation', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'uael' ),
				'label_off'    => __( 'Disable', 'uael' ),
				'return_value' => 'yes',
				'prefix_class' => 'uael-countdown-anim-',
			]
		);

		$this->add_control(
			'start_animation',
			[
				'label'     => __( 'Start Animation Before (Minutes)', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'condition' => [
					'animation' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Countdown General Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_style_controls() {

		$this->start_controls_section(
			'countdown_timer_style',
			[
				'label' => __( 'Countdown items', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'size',
			[
				'label'      => __( 'Container Width', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 240,
					],
				],
				'default'    => [
					'size' => '90',
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-countdown-items-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-countdown-show-message .uael-countdown-items-wrapper' => 'max-width:100%;',
					'{{WRAPPER}} .uael-preview-message .uael-countdown-items-wrapper' => 'max-width:100%;',
					'{{WRAPPER}} .uael-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-item-label'     => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-item'           => 'height:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-shape-none .uael-item' => 'height:calc({{SIZE}}{{UNIT}}*1.3);',
					'{{WRAPPER}}.uael-countdown-shape-none .uael-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-shape-none .uael-item-label' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-border-none .uael-item' => 'height:calc({{SIZE}}{{UNIT}}*1.3);',
					'{{WRAPPER}}.uael-countdown-border-none .uael-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-border-none .uael-item-label' => 'width:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'countdown_style!' => [ 'circle' ],
				],
			]
		);

		$this->add_responsive_control(
			'bg_size',
			[
				'label'      => __( 'Container Width ( PX )', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 180,
					],
				],
				'default'    => [
					'size' => '85',
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-item'           => 'padding: calc({{SIZE}}{{UNIT}}/4); height:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-border-none .uael-item' => 'padding: calc({{SIZE}}{{UNIT}}/4); height:calc({{SIZE}}{{UNIT}}*1.5);',
					'{{WRAPPER}} .uael-countdown-items-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-border-none .uael-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-countdown-border-none .uael-item-label' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-item-label'     => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-countdown-show-message .uael-countdown-items-wrapper' => 'max-width:100%;',
					'{{WRAPPER}} .uael-preview-message .uael-countdown-items-wrapper' => 'max-width:100%;',
				],
				'condition'  => [
					'countdown_style' => 'circle',
				],
			]
		);

		$this->add_responsive_control(
			'distance_betn_countdown_items',
			[
				'label'      => __( 'Spacing between items', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'range'      => [
					'px' => [
						'max' => 230,
						'min' => 0,
					],
					'%'  => [
						'max' => 300,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-item:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .uael-item:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .uael-item:last-of-type' => 'margin-right: 0px;',
					'(mobile){{WRAPPER}}.uael-countdown-responsive-yes .uael-item:not(:first-child)' => 'margin-left: 0;margin-top: calc( {{SIZE}}{{UNIT}} / 2 );',
					'(mobile){{WRAPPER}}.uael-countdown-responsive-yes .uael-item:not(:last-child)' => 'margin-right: 0;margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 );',
				],
			]
		);

		$this->add_responsive_control(
			'distance_betn_items_and_labels',
			[
				'label'      => __( 'Spacing between digits and labels', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'size' => 15,
					'unit' => 'px',
				],
				'range'      => [
					'px' => [
						'max' => 110,
						'min' => 0,
					],
					'%'  => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-countdown-wrapper .uael-countdown-item' => 'margin-bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'display_timer_labels' => [ 'default', 'custom' ],
				],
			]
		);

		$this->add_control(
			'items_background_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#f5f5f5',
				'selectors' => [
					'{{WRAPPER}} .uael-item' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.uael-countdown-shape-none .uael-item' => 'background-color:unset',
				],
				'condition' => [
					'countdown_style!' => 'none',
				],
			]
		);

		$this->add_control(
			'items_border_style',
			[
				'label'        => __( 'Border Style', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'solid',
				'options'      => [
					'none'   => __( 'None', 'uael' ),
					'solid'  => __( 'Solid', 'uael' ),
					'double' => __( 'Double', 'uael' ),
					'dotted' => __( 'Dotted', 'uael' ),
					'dashed' => __( 'Dashed', 'uael' ),
				],
				'selectors'    => [
					'{{WRAPPER}} .uael-item' => 'border-style: {{VALUE}};',
				],
				'prefix_class' => 'uael-countdown-border-',
				'condition'    => [
					'countdown_style!' => 'none',
				],
			]
		);

		$this->add_control(
			'items_border_color',
			[
				'label'     => __( 'Border Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#eaeaea',
				'selectors' => [
					'{{WRAPPER}} .uael-item' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'items_border_style!' => 'none',
					'countdown_style!'    => 'none',
				],
			]
		);

		$this->add_control(
			'items_border_size',
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
				'selectors'  => [
					'{{WRAPPER}} .uael-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
				],
				'condition'  => [
					'items_border_style!' => 'none',
					'countdown_style!'    => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'responsive_support',
			[
				'label'        => __( 'Responsive Support', 'uael' ),
				'description'  => __( 'Enable this option to stack the Countdown items on mobile.', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'uael' ),
				'label_off'    => __( 'Off', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'uael-countdown-responsive-',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Digit Style Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_digits_style_controls() {

		$this->start_controls_section(
			'countdown_digits_style',
			[
				'label' => __( 'Digits', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'digits_typography',
				'selector' => '{{WRAPPER}} .uael-countdown-wrapper .uael-countdown-item,{{WRAPPER}} .uael-countdown-wrapper .uael-countdown-separator',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'items_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '#050054',
				'selectors' => [
					'{{WRAPPER}} .uael-countdown-item,{{WRAPPER}} .uael-countdown-separator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Register Digit Style Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_label_style_controls() {

		$this->start_controls_section(
			'countdown_labels_style',
			[
				'label'     => __( 'Labels', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'display_timer_labels!' => 'none',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'labels_typography',
				'selector' => '{{WRAPPER}} .uael-item-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'labels_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '#3d424d;',
				'selectors' => [
					'{{WRAPPER}} .uael-item-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Register Message Style Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_message_style_controls() {

		$this->start_controls_section(
			'countdown_message_style',
			[
				'label'     => __( 'Expire Message', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'expire_actions' => 'show_message',
				],
			]
		);

		$this->add_responsive_control(
			'message_align',
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
					'{{WRAPPER}} .uael-expire-message-wrapper' => 'text-align:{{VALUE}};',
				],
				'condition' => [
					'expire_actions' => 'show_message',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'message_typography',
				'selector'  => '{{WRAPPER}} .uael-expire-show-message',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'expire_actions' => 'show_message',
				],
			]
		);

		$this->add_control(
			'message_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-expire-show-message' => 'color: {{VALUE}};',
				],
				'condition' => [
					'expire_actions' => 'show_message',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Display countdown labels
	 *
	 * @param array $settings specifies string for the time fraction.
	 * @since 1.14.0
	 * @access protected
	 */
	protected function total_interval( $settings ) {
		$total_time  = 0;
		$cnt_days    = empty( $settings['evg_days'] ) ? 0 : ( $settings['evg_days'] * 24 * 60 * 60 * 1000 );
		$cnt_hours   = empty( $settings['evg_hours'] ) ? 0 : ( $settings['evg_hours'] * 60 * 60 * 1000 );
		$cnt_minutes = empty( $settings['evg_minutes'] ) ? 0 : ( $settings['evg_minutes'] * 60 * 1000 );
		$total_time  = $cnt_days + $cnt_hours + $cnt_minutes;
		return $total_time;
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.14.0
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
						'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/introducing-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_2',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s Know more about the types of timers » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/types-of-timers-in-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_3',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s What is the difference between Fixed, Evergreen timer? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/faqs-for-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#what-is-the-difference-between-fixed-evergreen-timer-" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_4',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s What is the difference between Evergreen and Recurring Timer  » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/faqs-for-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#what-is-the-difference-between-evergreen-and-recurring-timer-and-how-does-the-recurring-timer-works-" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_5',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s How does the Recurring Timer works? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/faqs-for-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#what-is-the-difference-between-evergreen-and-recurring-timer-and-how-does-the-recurring-timer-works-" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_6',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s Doc Link */
						'raw'             => sprintf( __( '%1$s Which timezone does the timer use? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/faqs-for-countdown-timer-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin#which-timezone-does-the-timer-use-" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

			$this->end_controls_section();
		}
	}

	/**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function render() {
		$settings        = $this->get_settings_for_display();
		$id              = $this->get_id();
		$labels          = array( 'days', 'hours', 'minutes', 'seconds' );
		$length          = sizeof( $labels );
		$edit_mode       = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$data_attributes = array( 'data-expire-action', 'data-countdown-type', 'data-timer-labels', 'data-animation' );
		$data_values     = array( $settings['expire_actions'], $settings['countdown_type'], $settings['display_timer_labels'], $settings['start_animation'] );

		$this->add_render_attribute( 'countdown-wrapper', 'class', 'uael-countdown-items-wrapper' );

		$this->add_render_attribute( 'countdown', 'class', [ 'uael-countdown-wrapper', 'countdown-active' ] );

		$this->add_render_attribute( 'digits', 'class', 'uael-countdown-item' );

		for ( $i = 0; $i < 4; $i++ ) {
			$this->add_render_attribute( 'countdown', $data_attributes[ $i ], $data_values[ $i ] );
		}

		if ( $edit_mode && 'yes' === $settings['preview_expire_message'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'uael-preview-message' );
		}

		if ( 'custom' === $settings['display_timer_labels'] ) {
			for ( $i = 0; $i < $length; $i++ ) {
				$this->add_render_attribute( 'countdown', 'data-timer-' . $labels[ $i ], $settings[ 'custom_' . $labels[ $i ] ] );
			}
		}

		if ( 'fixed' === $settings['countdown_type'] ) {
			$this->add_render_attribute( 'countdown', 'data-due-date', $settings['due_date'] );
		} else {
			$this->add_render_attribute( 'countdown', 'data-evg-interval', $this->total_interval( $settings ) );
		}

		if ( 'recurring' === $settings['countdown_type'] ) {
			$this->add_render_attribute( 'countdown', 'data-start-date', $settings['start_date'] );
			$this->add_render_attribute( 'countdown', 'data-reset-days', $settings['reset_days'] );
		}

		if ( 'redirect' === $settings['expire_actions'] ) {
			$this->add_render_attribute( 'countdown', 'data-redirect-url', $settings['expire_redirect_url']['url'] );
			$this->add_render_attribute( 'url', 'href', $settings['expire_redirect_url']['url'] );
		} elseif ( 'show_message' === $settings['expire_actions'] ) {
			$this->add_render_attribute( 'countdown', 'data-countdown-expire-message', $settings['preview_expire_message'] );
		}

		if ( isset( $_COOKIE[ 'uael-timer-distance-' . $id ] ) ) {
			if ( 'hide' === $settings['expire_actions'] && 0 > $_COOKIE[ 'uael-timer-distance-' . $id ] && false === $edit_mode ) {
				$this->add_render_attribute( 'countdown', 'class', 'uael-countdown-hide' );
			}
		}

		if ( 'none' === $settings['display_timer_labels'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'uael-countdown-labels-hide' );
		}

		if ( 'yes' !== $settings['display_days'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'uael-countdown-show-days-no' );
		}

		if ( 'yes' !== $settings['display_hours'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'uael-countdown-show-hours-no' );
		}

		if ( 'yes' !== $settings['display_minutes'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'uael-countdown-show-minutes-no' );
		}

		if ( 'yes' !== $settings['display_seconds'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'uael-countdown-show-seconds-no' );
		}

		?>		
		<div <?php echo $this->get_render_attribute_string( 'countdown' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'countdown-wrapper' ); ?> >
				<?php for ( $i = 0; $i < $length; $i++ ) { ?>
					<div class="uael-countdown-<?php echo $labels[ $i ]; ?> uael-item">
						<span id="<?php echo $labels[ $i ]; ?>-wrapper-<?php echo $id; ?>"<?php echo $this->get_render_attribute_string( 'digits' ); ?> >
							<?php if ( true === $edit_mode ) { ?>
								<?php echo __( '00', 'uael' ); ?>
							<?php } ?> 
						</span>
						<?php if ( 'none' !== $settings['display_timer_labels'] ) { ?>
							<span id="<?php echo $labels[ $i ]; ?>-label-wrapper-<?php echo $id; ?>" class='uael-countdown-<?php echo $labels[ $i ]; ?>-label-<?php echo $id; ?> uael-item-label'>
							</span>
						<?php } ?>
					</div>
					<?php if ( 'yes' === $settings['countdown_separator'] && $i < $length - 1 ) { ?>
						<div class="uael-countdown-separator uael-countdown-<?php echo $labels[ $i ]; ?>-separator"> : </div>
					<?php } ?>
				<?php } ?>
				<?php if ( ( 'show_message' === $settings['expire_actions'] && 0 > $_COOKIE[ 'uael-timer-distance-' . $id ] && false === $edit_mode ) || ( 'show_message' === $settings['expire_actions'] && 'yes' === $settings['preview_expire_message'] && true === $edit_mode ) ) { ?>
					<div class="uael-expire-message-wrapper">
						<div class='uael-expire-show-message'><?php echo $settings['message_after_expire']; ?></div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}

