<?php
/**
 * UAEL BusinessReviews Skin - bubble.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\BusinessReviews\Skins;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use UltimateElementor\Modules\BusinessReviews\TemplateBlocks\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Skin_Bubble
 *
 * @property Products $parent
 */
class Skin_Bubble extends Skin_Base {

	/**
	 * Get ID.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function get_id() {
		return 'bubble';
	}

	/**
	 * Get title.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function get_title() {
		return __( 'Bubble', 'uael' );
	}

	/**
	 * Register Control Actions.
	 *
	 * @since 1.13.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		parent::_register_controls_actions();

		add_action( 'elementor/element/uael-business-reviews/bubble_section_info_controls/before_section_end', [ $this, 'update_image_controls' ] );

		add_action( 'elementor/element/uael-business-reviews/bubble_section_date_controls/before_section_end', [ $this, 'update_date_controls' ] );

		add_action( 'elementor/element/uael-business-reviews/bubble_section_content_controls/before_section_end', [ $this, 'update_content_controls' ] );

		add_action( 'elementor/element/uael-business-reviews/bubble_section_styling/before_section_end', [ $this, 'update_box_style_controls' ] );

		add_action( 'elementor/element/uael-business-reviews/bubble_section_spacing/before_section_end', [ $this, 'update_spacing_controls' ] );

	}

	/**
	 * Update Date control.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function update_image_controls() {
		$this->remove_control( 'image_align' );

		$this->update_control(
			'image_size',
			[
				'condition' => [
					$this->get_control_id( 'reviewer_image' ) => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-review-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-review-content-arrow-wrap' => 'left: calc( {{SIZE}}{{UNIT}} - 14px );',
				],
			]
		);

		$this->update_control(
			'review_source_icon',
			[
				'default' => 'yes',
			]
		);
	}

	/**
	 * Update Date control.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function update_date_controls() {
		$this->update_control(
			'review_date',
			[
				'default' => 'no',
			]
		);
	}

	/**
	 * Update content controls.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function update_content_controls() {

		$this->remove_control( 'reviewer_content_color' );

		$this->add_control(
			'hide_arrow_content',
			[
				'label'        => __( 'Hide Arrow', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					$this->get_control_id( 'review_content' ) => 'yes',
				],
			]
		);
	}

	/**
	 * Update Box control.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function update_box_style_controls() {

		$this->add_control(
			'bubble_content_color',
			[
				'label'     => __( 'Text Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-review-content' => 'color: {{VALUE}}',
				],
				'condition' => [
					$this->get_control_id( 'review_content' ) => 'yes',
				],
			]
		);

		$this->update_control(
			'block_bg_color',
			[
				'default'   => '#fafafa',
				'selectors' => [
					'{{WRAPPER}} .uael-review-content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .uael-review-arrow'   => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->update_control(
			'block_padding',
			[
				'selectors' => [
					'{{WRAPPER}} .uael-review-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bubble_block_border_style',
			[
				'label'       => __( 'Border Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => [
					'none'  => __( 'None', 'uael' ),
					'solid' => __( 'Solid', 'uael' ),
				],
				'selectors'   => [
					'{{WRAPPER}} .uael-review-content' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'bubble_block_border_size',
			[
				'label'     => __( 'Border Width', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					$this->get_control_id( 'bubble_block_border_style' ) . '!'    => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-review-content' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-review-arrow'   => 'top: -{{SIZE}}px; left: 0px; border-width: 16px;',
				],
			]
		);

		$this->add_control(
			'bubble_block_border_color',
			[
				'label'     => __( 'Border Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					$this->get_control_id( 'bubble_block_border_style' ) . '!'    => 'none',
				],
				'default'   => '#ededed',
				'selectors' => [
					'{{WRAPPER}} .uael-review-content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .uael-review-arrow-border' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->update_control(
			'block_radius',
			[
				'default'   => [
					'top'    => '5',
					'bottom' => '5',
					'right'  => '5',
					'left'   => '5',
					'unit'   => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-review-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

	}

	/**
	 * Register Styling Controls.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function update_spacing_controls() {

		$this->remove_control( 'reviewer_name_spacing' );

		$this->update_responsive_control(
			'reviewer_image_spacing',
			[
				'default'   => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-review-image' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_block_spacing',
			[
				'label'     => __( 'Content Block Bottom Spacing', 'uael' ),
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
					'{{WRAPPER}} .uael-review-content-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Render Main HTML.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function render() {

		$settings = $this->parent->get_settings_for_display();

		$skin = Skin_Init::get_instance( $this->get_id() );

		echo $skin->render( $this->get_id(), $settings, $this->parent->get_id() );
	}
}
