<?php
/**
 * UAEL Off - Canvas.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Offcanvas\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Offcanvas.
 */
class Offcanvas extends Common_Widget {

	/**
	 * Retrieve Off - Canvas Widget name.
	 *
	 * @since 1.11.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Offcanvas' );
	}

	/**
	 * Retrieve Offcanvas Widget title.
	 *
	 * @since 1.11.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Offcanvas' );
	}

	/**
	 * Retrieve OffCanvas Widget icon.
	 *
	 * @since 1.11.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Offcanvas' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.11.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Offcanvas' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.11.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-offcanvas' ];
	}

	/**
	 * Register canvas controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->register_general_content_controls();
		$this->register_display_offcanvas_controls();
		$this->register_display_content_controls();
		$this->register_close_controls();
		$this->register_helpful_information();

		$this->register_offcanvas_style_controls();
		$this->register_menu_style_controls();
		$this->register_content_style_controls();
		$this->register_button_style_controls();
		$this->register_icon_style_controls();
		$this->register_close_icon_style_controls();
	}

	/**
	 * Register Off - Canvas Content Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_general_content_controls() {
		$this->start_controls_section(
			'content',
			[
				'label' => __( 'Content', 'uael' ),
			]
		);

		$this->add_control(
			'preview_offcanvas',
			[
				'label'        => __( 'Preview', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'label_off'    => __( 'No', 'uael' ),
				'label_on'     => __( 'Yes', 'uael' ),
			]
		);

		$this->add_control(
			'content_type',
			[
				'label'   => __( 'Content Type', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => $this->get_content_type(),
			]
		);

		$menus = $this->get_menus_list();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					/* translators: %s admin link */
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'uael' ), admin_url( 'nav-menus.php' ) ),
					'condition'    => [
						'content_type' => 'menu',
					],
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'uael' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition'       => [
						'content_type' => 'menu',
					],
				]
			);
		}

		$this->add_control(
			'ct_content',
			[
				'label'      => __( 'Description', 'uael' ),
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => __( 'Enter content here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.​ Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'uael' ),
				'rows'       => 10,
				'show_label' => false,
				'dynamic'    => [
					'active' => true,
				],
				'condition'  => [
					'content_type' => 'content',
				],
			]
		);

		$this->add_control(
			'ct_saved_rows',
			[
				'label'     => __( 'Select Section', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'section' ),
				'default'   => '-1',
				'condition' => [
					'content_type' => 'saved_rows',
				],
			]
		);

		$this->add_control(
			'ct_page_templates',
			[
				'label'     => __( 'Select Page', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'page' ),
				'default'   => '-1',
				'condition' => [
					'content_type' => 'saved_page_templates',
				],
			]
		);

		$this->add_control(
			'ct_saved_modules',
			[
				'label'     => __( 'Select Widget', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_data( 'widget' ),
				'default'   => '-1',
				'condition' => [
					'content_type' => 'saved_modules',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Off - Canvas Title Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_display_content_controls() {
		$this->start_controls_section(
			'offcanvas',
			[
				'label' => __( 'Display Settings', 'uael' ),
			]
		);

		$this->add_control(
			'offcanvas_on',
			[
				'label'   => __( 'Display On', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button'    => __( 'Button', 'uael' ),
					'icon'      => __( 'Icon', 'uael' ),
					'custom'    => __( 'Custom Class', 'uael' ),
					'custom_id' => __( 'Custom ID', 'uael' ),
				],
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Click Me', 'uael' ),
				'placeholder' => __( 'Click Me', 'uael' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'offcanvas_on' => 'button',
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => __( 'Icon', 'uael' ),
				'type'      => Controls_Manager::ICON,
				'default'   => 'fa fa-home',
				'condition' => [
					'offcanvas_on' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'     => __( 'Size (px)', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 60,
				],
				'range'     => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-offcanvas-action .uael-offcanvas-icon-bg i' => 'font-size: {{SIZE}}px; width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
				'condition' => [
					'offcanvas_on' => 'icon',
				],
			]
		);

		$this->add_control(
			'uael_display_position',
			[
				'label'        => __( 'Position', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'inline',
				'options'      => [
					'inline'   => __( 'Inline', 'uael' ),
					'floating' => __( 'Floating', 'uael' ),
				],
				'condition'    => [
					'offcanvas_on' => array( 'button', 'icon' ),
				],
				'prefix_class' => 'uael-offcanvas-trigger-align-',
				'render_type'  => 'template',
			]
		);

		// If uael_display_position is Inline.
		$this->add_responsive_control(
			'uael_display_inline_button_align',
			[
				'label'     => __( 'Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
				'default'   => 'left',
				'condition' => [
					'uael_display_position' => 'inline',
					'offcanvas_on'          => 'button',
				],
				'toggle'    => false,
			]
		);

		// If uael_display_position is Floating.
		$this->add_control(
			'uael_display_floating_align',
			[
				'label'       => __( 'Alignment', 'uael' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'left',
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
				'toggle'      => false,
				'label_block' => false,
				'condition'   => [
					'offcanvas_on'          => array( 'button', 'icon' ),
					'uael_display_position' => 'floating',
				],
			]
		);

		$this->add_responsive_control(
			'uael_display_floating_on_window_position',
			[
				'label'          => __( 'Floating Position', 'uael' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => '%',
				'default'        => [
					'size' => '50',
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => '50',
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => '50',
					'unit' => '%',
				],
				'range'          => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .uael-offcanvas-action-wrap .uael-button-wrapper .uael-offcanvas-action-alignment-left,
					{{WRAPPER}} .uael-offcanvas-action-wrap .uael-offcanvas-icon-wrap .uael-offcanvas-action-alignment-left,
                    {{WRAPPER}} .uael-offcanvas-action-wrap .uael-button-wrapper .uael-offcanvas-action-alignment-right,
                    {{WRAPPER}} .uael-offcanvas-action-wrap .uael-offcanvas-icon-wrap .uael-offcanvas-action-alignment-right' => 'top: {{SIZE}}{{UNIT}}; transform: translateY( -{{SIZE}}{{UNIT}} );',
				],
				'condition'      => [
					'uael_display_position' => 'floating',
					'offcanvas_on'          => array( 'button', 'icon' ),
				],
			]
		);

		$this->add_control(
			'btn_size',
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
					'offcanvas_on' => 'button',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_icon',
			[
				'label'     => __( 'Select Icon', 'uael' ),
				'type'      => Controls_Manager::ICON,
				'default'   => '',
				'condition' => [
					'offcanvas_on' => 'button',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_icon_position',
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
					'offcanvas_on'           => 'button',
					'offcanvas_button_icon!' => '',
				],
			]
		);

		$this->add_control(
			'offcanvas_icon_spacing',
			[
				'label'     => __( 'Icon Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => '5',
					'unit' => 'px',
				],
				'condition' => [
					'offcanvas_on'           => 'button',
					'offcanvas_button_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right, {{WRAPPER}} .uael-infobox-link-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left, {{WRAPPER}} .uael-infobox-link-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_custom',
			[
				'label'       => __( 'Class', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Add your custom class without the dot. e.g: my-class', 'uael' ),
				'condition'   => [
					'offcanvas_on' => 'custom',
				],
			]
		);

		$this->add_control(
			'offcanvas_custom_id',
			[
				'label'       => __( 'Custom ID', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Add your custom id without the # key. e.g: my-id', 'uael' ),
				'condition'   => [
					'offcanvas_on' => 'custom_id',
				],
			]
		);

		$this->add_control(
			'offcanvas_trigger_zindex',
			[
				'label'       => __( 'Z-Index', 'uael' ),
				'description' => __( 'Adjust the z-index of the floating trigger if it is not visibile on the page. Defaults is set to 999', 'uael' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '999',
				'min'         => 0,
				'step'        => 1,
				'condition'   => [
					'offcanvas_on'          => array( 'button', 'icon' ),
					'uael_display_position' => 'floating',
				],
				'selectors'   => [
					'{{WRAPPER}} .uael-offcanvas-trigger' => 'z-index: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'all_align',
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
				'default'   => 'left',
				'condition' => [
					'offcanvas_on'          => 'icon',
					'uael_display_position' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-offcanvas-action-wrap' => 'text-align: {{VALUE}};',
				],
				'toggle'    => false,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Off - Canvas Close button.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_close_controls() {
		$this->start_controls_section(
			'section_close',
			[
				'label' => __( 'Close Button', 'uael' ),
			]
		);

		$this->add_control(
			'close_icon',
			[
				'label'   => __( 'Select Close Icon', 'uael' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'fa fa-close',
			]
		);

		$this->add_control(
			'close_inside_icon_position',
			[
				'label'     => __( 'Icon Alignment', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right-top',
				'options'   => [
					'left-top'  => __( 'Left Top', 'uael' ),
					'right-top' => __( 'Right Top', 'uael' ),
				],
				'condition' => [
					'close_icon!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'close_icon_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 14,
				],
				'range'     => [
					'px' => [
						'max' => 60,
					],
				],
				'selectors' => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas-close .uael-offcanvas-close-icon' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
				],
				'condition' => [
					'close_icon!' => '',
				],
			]
		);

		$this->add_control(
			'esc_keypress',
			[
				'label'        => __( 'Close on ESC Keypress', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'label_off'    => __( 'No', 'uael' ),
				'label_on'     => __( 'Yes', 'uael' ),
			]
		);

		$this->add_control(
			'overlay_click',
			[
				'label'        => __( 'Close on Overlay Click', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
				'label_off'    => __( 'No', 'uael' ),
				'label_on'     => __( 'Yes', 'uael' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register off-canvas button Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_button_style_controls() {
		$this->start_controls_section(
			'section_button_style',
			[
				'label'     => __( 'Button', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'offcanvas_on' => 'button',
				],
			]
		);

		$this->add_control(
			'btn_html_message',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => sprintf( '<p style="font-size: 11px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', __( 'To see these changes please turn off the preview setting from Content Tab.', 'uael' ) ),
				'condition' => [
					'preview_offcanvas' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'btn_typography',
				'label'     => __( 'Typography', 'uael' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button',
				'condition' => [
					'offcanvas_on' => 'button',
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
					'{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'offcanvas_on' => 'button',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => __( 'Normal', 'uael' ),
				'condition' => [
					'offcanvas_on' => 'button',
				],
			]
		);

			$this->add_control(
				'button_text_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button' => 'color: {{VALUE}};',
					],
					'condition' => [
						'offcanvas_on' => 'button',
					],
				]
			);

			$this->add_control(
				'btn_background_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'offcanvas_on' => 'button',
					],
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'btn_border',
					'label'       => __( 'Border', 'uael' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button',
					'condition'   => [
						'offcanvas_on' => 'button',
					],
				]
			);

			$this->add_control(
				'btn_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'offcanvas_on' => 'button',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'button_box_shadow',
					'selector'  => '{{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button',
					'condition' => [
						'offcanvas_on' => 'button',
					],
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => __( 'Hover', 'uael' ),
				'condition' => [
					'offcanvas_on' => 'button',
				],
			]
		);

			$this->add_control(
				'btn_hover_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button:hover, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'offcanvas_on' => 'button',
					],
				]
			);

			$this->add_control(
				'btn_hover_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button:hover, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button:hover' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'offcanvas_on' => 'button',
					],
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
				]
			);

			$this->add_control(
				'button_hover_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'border_border!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-offcanvas-action-wrap a.elementor-button:hover, {{WRAPPER}} .uael-offcanvas-action-wrap .elementor-button:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'offcanvas_on' => 'button',
					],
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register off-canvas Icon Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_icon_style_controls() {
		$this->start_controls_section(
			'section_offcanvas_icon_display_style',
			[
				'label'     => __( 'Icon', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'offcanvas_on' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'offcanvas_icon_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-offcanvas-icon-bg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_style' );

			$this->start_controls_tab(
				'icon_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'offcanvas_on' => 'icon',
					],
				]
			);
				$this->add_control(
					'icon_color_normal',
					[
						'label'     => __( 'Icon Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						],
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-action i' => 'color: {{VALUE}};',
						],
						'condition' => [
							'offcanvas_on' => 'icon',
						],
					]
				);

				$this->add_control(
					'icon_background_color_normal',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-icon-bg' => 'background: {{VALUE}};',
						],
						'condition' => [
							'offcanvas_on' => 'icon',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'icon_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						'offcanvas_on' => 'icon',
					],
				]
			);

				$this->add_control(
					'icon_color_hover',
					[
						'label'     => __( 'Icon Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						],
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-action i:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'offcanvas_on' => 'icon',
						],
					]
				);

				$this->add_control(
					'icon_background_color_hover',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-icon-bg:hover' => 'background: {{VALUE}};',
						],
						'condition' => [
							'offcanvas_on' => 'icon',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register off-canvas CLose Icon Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_close_icon_style_controls() {

		$this->start_controls_section(
			'section_close_icon_style',
			[
				'label'     => __( 'Close Icon', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'close_icon!' => '',
				],
			]
		);

		$this->add_control(
			'close_icon_color_normal',
			[
				'label'     => __( 'Icon Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas-close .uael-offcanvas-close-icon' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'close_icon!' => '',
				],
			]
		);

		$this->add_control(
			'close_icon_color_hover',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,.3)',
				'selectors' => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas-close' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'close_icon!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'close_icon_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas-close-icon-wrapper .uael-offcanvas-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'close_icon!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register offcanvas Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_offcanvas_style_controls() {
		$this->start_controls_section(
			'section_offcanvas_style',
			[
				'label' => __( 'Off - Canvas', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'offcanvas_bg_color',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'offcanvas_spacing',
			[
				'label'      => __( 'Content Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Menu Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_menu_style_controls() {
		$this->start_controls_section(
			'section_menu_style',
			[
				'label'     => __( 'Menu', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_type' => 'menu',
				],
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'menu_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
					'selector'  => '{{WRAPPER}} .uael-offcanvas-menu',
					'condition' => [
						'content_type' => 'menu',
					],
				]
			);

			$this->add_responsive_control(
				'menu_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '5',
						'bottom' => '5',
						'left'   => '20',
						'right'  => '20',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-offcanvas-menu .menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'content_type' => 'menu',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_style_menu_item' );

			$this->start_controls_tab(
				'tab_menu_item_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'content_type' => 'menu',
					],
				]
			);

				$this->add_control(
					'menu_item_color',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						],
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-menu .menu-item a' => 'color: {{VALUE}}',
						],
						'condition' => [
							'content_type' => 'menu',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_menu_item_hover',
				[
					'label' => __( 'Hover', 'uael' ),
				]
			);

				$this->add_control(
					'menu_item_color_hover',
					[
						'label'     => __( 'Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						],
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-menu .menu-item a:hover' => 'color: {{VALUE}}',
						],
						'condition' => [
							'content_type' => 'menu',
						],
					]
				);

				$this->add_control(
					'menu_item_bgcolor_hover',
					[
						'label'     => __( 'Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-offcanvas-menu .menu-item a:hover' => 'background-color: {{VALUE}}',
						],
						'condition' => [
							'content_type' => 'menu',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register offcanvas Content Style Controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_content_style_controls() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => __( 'Content', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_type' => 'content',
				],
			]
		);

			$this->add_control(
				'content_text_color',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'.uaoffcanvas-{{ID}} .uael-offcanvas-content' => 'color: {{VALUE}};',
						'{{WRAPPER}} .uael-offcanvas-content' => 'color: {{VALUE}};',
					],
					'condition' => [
						'content_type' => 'content',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'content_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'selector'  => '.uaoffcanvas-{{ID}} .uael-offcanvas-content .uael-text-editor',
					'separator' => 'before',
					'condition' => [
						'content_type' => 'content',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'content_border',
					'label'       => __( 'Content Border', 'uael' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .uaoffcanvas-{{ID}} .uael-offcanvas .uael-offcanvas-content',
					'condition'   => [
						'content_type' => 'content',
					],
				]
			);

			$this->add_control(
				'content_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uaoffcanvas-{{ID}} .uael-offcanvas .uael-offcanvas-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'content_type' => 'content',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Off-Canvas controls.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function register_display_offcanvas_controls() {
		$this->start_controls_section(
			'section_offcanvas_controls',
			[
				'label' => __( 'Off - Canvas', 'uael' ),
			]
		);

		$this->add_responsive_control(
			'offcanvas_width',
			[
				'label'          => __( 'Width (px)', 'uael' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px' ],
				'default'        => [
					'size' => '300',
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => '250',
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => '200',
					'unit' => 'px',
				],
				'range'          => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .uaoffcanvas-{{ID}} .uael-offcanvas' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .uaoffcanvas-{{ID}}.uael-offcanvas-parent-wrapper .position-at-left' => 'left: -{{SIZE}}px;',
					'{{WRAPPER}} .uaoffcanvas-{{ID}}.uael-offcanvas-parent-wrapper .position-at-right' => 'right: -{{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'offcanvas_position',
			[
				'label'       => __( 'Position', 'uael' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'at-left',
				'options'     => [
					'at-left'  => [
						'title' => __( 'Left', 'uael' ),
						'icon'  => 'fa fa-align-left',
					],
					'at-right' => [
						'title' => __( 'Right', 'uael' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'label_block' => false,
				'toggle'      => false,
			]
		);

		$this->add_control(
			'offcanvas_type',
			[
				'label'       => __( 'Appear Effect', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'normal',
				'label_block' => false,
				'options'     => [
					'normal' => __( 'Slide', 'uael' ),
					'push'   => __( 'Push', 'uael' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'page_overlay',
			[
				'label'       => __( 'Overlay Color', 'uael' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(0,0,0,0.75)',
				'selectors'   => [
					'.uaoffcanvas-{{ID}} .uael-offcanvas-overlay' => 'background: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Off-Canvas helpful information.
	 *
	 * @since 1.11.0
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/off-canvas-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Trigger Off-Canvas from any Elementor Widget » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/off-canvas-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to Design an Off-Canvas menu for Elementor? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/design-off-canvas-menu-for-elementor/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to Trigger Off-Canvas on the Click of a Menu Element? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/off-canvas-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Render content type list.
	 *
	 * @since 1.11.0
	 * @return array Array of content type
	 * @access public
	 */
	public function get_content_type() {
		$content_type = array(
			'content'              => __( 'Content', 'uael' ),
			'menu'                 => __( 'Menu', 'uael' ),
			'saved_rows'           => __( 'Saved Section', 'uael' ),
			'saved_page_templates' => __( 'Saved Page', 'uael' ),
		);

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$content_type['saved_modules'] = __( 'Saved Widget', 'uael' );
		}
		return $content_type;
	}

	/**
	 * Get available menus list
	 *
	 * @since 1.11.0
	 * @return array Array of menu
	 * @access public
	 */
	public function get_menus_list() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Render Menu HTML.
	 *
	 * @since 1.11.0
	 * @param array $settings The settings array.
	 * @param int   $node_id The node id.
	 * @return string menu HTML
	 * @access public
	 */
	public function get_menu_html( $settings, $node_id ) {

		$menus = $this->get_menus_list();

		if ( ! empty( $menus ) ) {

			$args = [
				'echo'        => false,
				'menu'        => $settings['menu'],
				'menu_class'  => 'uael-offcanvas-menu',
				'fallback_cb' => '__return_empty_string',
				'container'   => '',
			];

			$menu_html = wp_nav_menu( $args );

			return $menu_html;
		}
	}

	/**
	 * Render Off - Canvas widget classes names.
	 *
	 * @since 1.11.0
	 * @param array $settings The settings array.
	 * @param int   $node_id The node id.
	 * @return string Concatenated string of classes
	 * @access public
	 */
	public function get_offcanvas_content( $settings, $node_id ) {
		$content_type     = $settings['content_type'];
		$dynamic_settings = $this->get_settings_for_display();

		switch ( $content_type ) {
			case 'content':
				global $wp_embed;
				return '<div class="uael-text-editor elementor-inline-editing" data-elementor-setting-key="ct_content" data-elementor-inline-editing-toolbar="advanced">' . wpautop( $wp_embed->autoembed( $dynamic_settings['ct_content'] ) ) . '</div>';
			break;

			case 'menu':
				$menu_content = $this->get_menu_html( $settings, $node_id );
				return $menu_content;
			break;

			case 'saved_rows':
				return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['ct_saved_rows'] );
			break;

			case 'saved_modules':
				return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['ct_saved_modules'] );

			case 'saved_page_templates':
				return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['ct_page_templates'] );
			break;

			default:
				return;
			break;
		}
	}

	/**
	 * Render Button.
	 *
	 * @since 1.11.0
	 * @param int   $node_id The node id.
	 * @param array $settings The settings array.
	 * @access public
	 */
	public function render_button( $node_id, $settings ) {
		$this->add_render_attribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );
		$this->add_render_attribute( 'button', 'href', 'javascript:void(0);' );
		$this->add_render_attribute( 'button', 'class', 'uael-offcanvas-trigger elementor-button-link elementor-button elementor-clickable' );

		if ( ! empty( $settings['btn_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['btn_size'] );
		}

		$position = '';

		if ( 'button' == $settings['offcanvas_on'] ) {
			if ( 'floating' == $settings['uael_display_position'] ) {
				$position = ' uael-offcanvas-action-alignment-' . $settings['uael_display_floating_align'];

				$this->add_render_attribute( 'button', 'class', '' . $position . '' );
			} else {
				if ( ! empty( $settings['uael_display_inline_button_align'] ) ) {
					$this->add_render_attribute( 'wrapper', 'class', 'elementor-align-' . $settings['uael_display_inline_button_align'] );
					$this->add_render_attribute( 'wrapper', 'class', 'elementor-tablet-align-' . $settings['uael_display_inline_button_align_tablet'] );
					$this->add_render_attribute( 'wrapper', 'class', 'elementor-mobile-align-' . $settings['uael_display_inline_button_align_mobile'] );
				}
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?> data-offcanvas="<?php echo $node_id; ?>">
				<?php $this->render_button_text(); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render close icon.
	 *
	 * @since 1.11.0
	 * @param string $node_id The node id.
	 * @param array  $settings The settings array.
	 * @access protected
	 */
	protected function render_close_icon( $node_id, $settings ) {

		$close_position = '';

		$close_position = 'uael-offcanvas-close-icon-position-' . $settings['close_inside_icon_position'];

		$this->add_render_attribute( 'close-wrapper', 'class', 'uael-offcanvas-close-icon-wrapper elementor-icon-wrapper elementor-clickable' );

		$this->add_render_attribute( 'close-wrapper', 'class', $close_position );

		$this->add_render_attribute(
			'close-icon',
			'class',
			'uael-offcanvas-close elementor-icon-link elementor-clickable '
		);

		?>
	<div <?php echo $this->get_render_attribute_string( 'close-wrapper' ); ?>>
		<span <?php echo $this->get_render_attribute_string( 'close-icon' ); ?>>
			<svg class="uael-offcanvas-close-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
				<path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
			</svg>
		</span>
	</div>
		<?php
	}

	/**
	 * Render button text.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function render_button_text() {

		$settings = $this->get_settings();

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );

		$this->add_render_attribute(
			'btn-text',
			[
				'class'                                 => 'elementor-button-text elementor-inline-editing',
				'data-elementor-setting-key'            => 'btn_text',
				'data-elementor-inline-editing-toolbar' => 'none',
			]
		);

		$this->add_render_attribute(
			'icon-align',
			[
				'class' => 'elementor-button-icon elementor-align-icon-' . $settings['offcanvas_button_icon_position'],
			]
		);

		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( '' !== $settings['offcanvas_button_icon'] ) { ?>
				<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
					<i class="<?php echo esc_attr( $settings['offcanvas_button_icon'] ); ?>" aria-hidden="true"></i>
				</span>
			<?php } ?>
			<span <?php echo $this->get_render_attribute_string( 'btn-text' ); ?>><?php echo $this->get_settings_for_display( 'btn_text' ); ?></span>
		</span>
		<?php
	}

	/**
	 * Render action HTML.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function render_action_html() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

		if ( 'button' == $settings['offcanvas_on'] ) {
			$this->render_button( $id, $settings );
			if ( ( 'floating' == $settings['uael_display_position'] ) && $is_editor ) {
				?>
				<div class="uael-builder-msg" style="text-align: center;">
					<h5><?php _e( 'Off - Canvas - ID ', 'uael' ); ?><?php echo $id; ?></h5>
					<p><?php _e( 'Click here to edit the "Off- Canvas" settings. This text will not be visible on frontend.', 'uael' ); ?></p>
				</div>

				<?php
			}
		} elseif ( (
			'custom' == $settings['offcanvas_on'] ||
			'custom_id' == $settings['offcanvas_on'] ) &&
			$is_editor
		) {
			?>
			<div class="uael-builder-msg" style="text-align: center;">
				<h5><?php _e( 'Off - Canvas - ID ', 'uael' ); ?><?php echo $id; ?></h5>
				<p><?php _e( 'Click here to edit the "Off- Canvas" settings. This text will not be visible on frontend.', 'uael' ); ?></p>
			</div>
			<?php
		} else {
			$inner_html = '';

			$this->add_render_attribute(
				'action-wrap',
				'class',
				[
					'uael-offcanvas-action',
					'elementor-clickable',
					'uael-offcanvas-trigger',
				]
			);

			$this->add_render_attribute( 'action-wrap', 'data-offcanvas', $id );

			switch ( $settings['offcanvas_on'] ) {
				case 'icon':
					$this->add_render_attribute( 'action-wrap', 'class', 'uael-offcanvas-icon-wrap' );
					$position = '';

					if ( 'floating' == $settings['uael_display_position'] ) {
						$position = ' uael-offcanvas-action-alignment-' . $settings['uael_display_floating_align'];
					}
					if ( ( 'floating' == $settings['uael_display_position'] ) && $is_editor ) {
						?>
						<div class="uael-builder-msg" style="text-align: center;">
								<h5><?php _e( 'Off - Canvas - ID ', 'uael' ); ?><?php echo $id; ?></h5>
								<p><?php _e( 'Click here to edit the "Off- Canvas" settings. This text will not be visible on frontend.', 'uael' ); ?></p>
						</div>
						<?php
					}

					$inner_html = '<span class="uael-offcanvas-icon-bg' . $position . '"><i class="uael-offcanvas-icon ' . $settings['icon'] . '"></i></span>';

					break;
			}
			?>

			<div <?php echo $this->get_render_attribute_string( 'action-wrap' ); ?>><?php echo $inner_html; ?></div>

			<?php
		}
	}

	/**
	 * Close Render action HTML.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function close_render_action_html() {
		$settings = $this->get_settings();
		$id       = $this->get_id();

		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

		if ( '' !== $settings['close_icon'] ) {
			$this->render_close_icon( $id, $settings );
		}
	}

	/**
	 * Get Data Attributes.
	 *
	 * @since 1.11.0
	 * @param array $settings The settings array.
	 * @return string Data Attributes
	 * @access public
	 */
	public function get_parent_wrapper_attributes( $settings ) {
		$id = $this->get_id();
		$this->add_render_attribute(
			'parent-wrapper',
			[
				'id'                    => $id . '-overlay',
				'data-trigger-on'       => $settings['offcanvas_on'],

				'data-close-on-overlay' => $settings['overlay_click'],

				'data-close-on-esc'     => $settings['esc_keypress'],

				'data-content'          => $settings['content_type'],

				'data-device'           => ( false !== ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) ) ? 'true' : 'false' ),

				'data-custom'           => $settings['offcanvas_custom'],

				'data-custom-id'        => $settings['offcanvas_custom_id'],

				'data-canvas-width'     => $settings['offcanvas_width']['size'],
			]
		);

		$this->add_render_attribute(
			'parent-wrapper',
			'class',
			[
				'uael-offcanvas-parent-wrapper',
				'uael-module-content',
				'uaoffcanvas-' . $id,
			]
		);

		return $this->get_render_attribute_string( 'parent-wrapper' );
	}

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  @since 1.11.0
	 *  @return string
	 */
	public function get_saved_data( $type = 'page' ) {
		$saved_widgets = $this->get_post_template( $type );
		$options[-1]   = __( 'Select', 'uael' );
		if ( count( $saved_widgets ) ) {
			foreach ( $saved_widgets as $saved_row ) {
				$options[ $saved_row['id'] ] = $saved_row['name'];
			}
		} else {
			$options['no_template'] = __( 'It seems that, you have not saved any template yet.', 'uael' );
		}
		return $options;
	}

	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type Type.
	 *  @since 1.11.0
	 *  @return string
	 */
	public function get_post_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'      => 'elementor_library',
				'orderby'        => 'title',
				'order'          => 'ASC',
				'posts_per_page' => '-1',
				'tax_query'      => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type,
					),
				),
			)
		);

		$templates = array();

		foreach ( $posts as $post ) {
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title,
			);
		}

		return $templates;
	}

	/**
	 * Render offcanvas output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function render() {
		$settings  = $this->get_settings();
		$node_id   = $this->get_id();
		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

		$class = ( $is_editor && 'yes' == $settings['preview_offcanvas'] ) ? 'uael-show-preview' : '';

		$shadowclass = ( '' !== $settings['page_overlay'] ) ? 'uael-offcanvas-shadow-inset' : 'uael-offcanvas-shadow-normal';

		// To Disable scroll when overlay is added to the page add the condition of page_overlay option to $scrollclass.
		$scrollclass = 'uael-offcanvas-scroll-disable';

		$editor_mode_class = ( $is_editor ) ? 'uael-editor-mode' : '';

		$this->add_inline_editing_attributes( 'btn_text', 'none' );
		$this->add_inline_editing_attributes( 'ct_content', 'advanced' );

		$this->add_render_attribute( 'inner-wrapper', 'id', 'offcanvas-' . $node_id );

		$this->add_render_attribute(
			'inner-wrapper',
			'class',
			[
				'uael-offcanvas',
				'uael-custom-offcanvas',
				$class,
				$editor_mode_class,
				'uael-offcanvas-type-' . $settings['offcanvas_type'],
				$scrollclass,
				$shadowclass,
			]
		);

		$this->add_render_attribute( 'inner-wrapper', 'class', 'position-' . $settings['offcanvas_position'] );
		?>

		<div <?php echo $this->get_parent_wrapper_attributes( $settings ); ?> >
			<div <?php echo $this->get_render_attribute_string( 'inner-wrapper' ); ?>>
				<div class="uael-offcanvas-content">
					<div class="uael-offcanvas-action-wrap">
						<?php echo $this->close_render_action_html(); ?>
					</div>
					<div class="uael-offcanvas-text uael-offcanvas-content-data">
						<?php echo do_shortcode( $this->get_offcanvas_content( $settings, $node_id ) ); ?>
					</div>
				</div>
			</div>
			<div class="uael-offcanvas-overlay elementor-clickable"></div>
		</div>
			<div class="uael-offcanvas-action-wrap">
				<?php echo $this->render_action_html(); ?>
			</div>
		<?php
	}

	/**
	 * Rend offcanvas output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.11.0
	 * @access protected
	 */
	protected function _content_template() {}
}
