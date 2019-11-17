<?php
/**
 * UAEL Default Skin.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\BusinessReviews\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Modules\BusinessReviews\TemplateBlocks\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Skin_Default
 */
class Skin_Default extends Skin_Base {

	/**
	 * Get Skin Slug.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function get_id() {
		return 'default';
	}

	/**
	 * Get Skin Title.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function get_title() {

		return __( 'Default', 'uael' );
	}

	/**
	 * Register Control Actions.
	 *
	 * @since 1.13.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		parent::_register_controls_actions();

		add_action( 'elementor/element/uael-business-reviews/default_section_info_controls/before_section_end', [ $this, 'update_image_controls' ] );

		add_action( 'elementor/element/uael-business-reviews/default_section_styling/before_section_end', [ $this, 'update_box_style_controls' ] );
	}

	/**
	 * Update Date control.
	 *
	 * @since 1.13.0
	 * @access public
	 */
	public function update_image_controls() {
		$this->update_control(
			'image_align',
			[
				'default'   => 'left',
				'condition' => [
					$this->get_control_id( 'reviewer_image' ) => 'yes',
				],
			]
		);

		$this->update_control(
			'review_source_icon',
			[
				'default'   => 'yes',
				'condition' => [
					$this->get_control_id( 'image_align' ) . '!' => 'top',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'default_block_border',
				'label'          => __( 'Border', 'uael' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1',
						],
					],
					'color'  => [
						'default' => '#ededed',
					],
				],
				'selector'       => '{{WRAPPER}} .uael-review',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'default_block_box_shadow',
				'selector' => '{{WRAPPER}} .uael-review',
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

