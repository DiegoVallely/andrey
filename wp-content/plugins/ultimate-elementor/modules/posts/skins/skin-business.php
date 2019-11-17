<?php
/**
 * UAEL Business Skin.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Scheme_Color;

use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Modules\Posts\TemplateBlocks\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Skin_Business
 */
class Skin_Business extends Skin_Base {

	/**
	 * Get Skin Slug.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function get_id() {

		return 'business';
	}

	/**
	 * Get Skin Title.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function get_title() {

		return __( 'Business Card', 'uael' );
	}

	/**
	 * Register controls on given actions.
	 *
	 * @since 1.10.1
	 * @access protected
	 */
	protected function _register_controls_actions() {

		parent::_register_controls_actions();

		add_action( 'elementor/element/uael-posts/business_section_image_field/before_section_end', [ $this, 'register_update_image_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_meta_field/before_section_end', [ $this, 'register_update_meta_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_excerpt_field/before_section_end', [ $this, 'register_update_excerpt_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_cta_field/before_section_end', [ $this, 'register_update_cta_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_design_blog/before_section_end', [ $this, 'register_update_blog_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_design_layout/before_section_end', [ $this, 'register_update_layout_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_general_field/before_section_end', [ $this, 'register_update_general_controls' ] );

		add_action( 'elementor/element/uael-posts/business_section_title_style/before_section_end', [ $this, 'register_update_title_style' ] );

		add_action( 'elementor/element/uael-posts/business_section_featured_field/before_section_end', [ $this, 'register_update_featured_style' ] );

	}

	/**
	 * Register controls callback.
	 *
	 * @param Widget_Base $widget Current Widget object.
	 * @since 1.10.1
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
		$this->register_authorbox_style_controls();
	}

	/**
	 * Update Image control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_image_controls() {

		$this->update_control(
			'image_position',
			[
				'default' => 'top',
				'options' => array(
					'top'  => __( 'Top', 'uael' ),
					'none' => __( 'None', 'uael' ),
				),
			]
		);

		$this->remove_control( 'image_background_color' );
	}

	/**
	 * Update Meta control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_meta_controls() {
		$this->update_control(
			'show_meta',
			[
				'default' => 'no',
			]
		);
	}

	/**
	 * Update Excerpt control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_excerpt_controls() {
		$this->update_control(
			'show_excerpt',
			[
				'default' => 'no',
			]
		);
	}

	/**
	 * Update CTA control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_cta_controls() {
		$this->update_control(
			'show_cta',
			[
				'default' => 'no',
			]
		);
	}

	/**
	 * Update Layout control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_layout_controls() {

		$this->update_control(
			'alignment',
			[
				'selectors'    => [
					'{{WRAPPER}} .uael-post-wrapper, {{WRAPPER}} .uael-post__separator-wrap' => 'text-align: {{VALUE}};',
				],
				'prefix_class' => 'uael-post__content-align-',
				'render_type'  => 'template',
				'toggle'       => false,
				'default'      => 'left',
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
				'label'      => __( 'Thickness', 'uael' ),
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
					'size' => 100,
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
						'max' => 50,
					],
				],
				'default'   => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-post__separator-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}}.uael-post__content-align-left .uael-post__gradient-separator' => 'background: linear-gradient( to right, {{VALUE}} 0%, #ffffff00 100% );',
					'{{WRAPPER}}.uael-post__content-align-center .uael-post__gradient-separator' => 'background: radial-gradient( {{VALUE}} 10%, #ffffff00 80% );',
					'{{WRAPPER}}.uael-post__content-align-right .uael-post__gradient-separator' => 'background: linear-gradient( to left, {{VALUE}} 0%, #ffffff00 100% );',
				],
			]
		);
	}

	/**
	 * Update Blog Design control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_blog_controls() {

		$this->update_control(
			'blog_padding',
			[
				'default' => [
					'top'    => '25',
					'bottom' => '25',
					'right'  => '25',
					'left'   => '25',
					'unit'   => 'px',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'content_border',
				'selector' => '{{WRAPPER}} .uael-post__bg-wrap',
			]
		);

		$this->add_control(
			'content_radius',
			[
				'label'      => __( 'Rounded Corners', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '15',
					'bottom' => '15',
					'left'   => '15',
					'right'  => '15',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-post__bg-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'classic_box_shadow',
				'selector' => '{{WRAPPER}} .uael-post__bg-wrap',
			]
		);

	}

	/**
	 * Update General Design control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_general_controls() {
		$this->add_control(
			'equal_grid_height',
			[
				'label'        => __( 'Equal Height', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'label_off'    => __( 'No', 'uael' ),
				'label_on'     => __( 'Yes', 'uael' ),
				'prefix_class' => 'uael-equal__height-',
				'description'  => __( 'Enable this to display all posts with same height.', 'uael' ),
				'condition'    => [
					$this->get_control_id( 'post_structure' ) => [ 'featured', 'normal' ],
				],
			]
		);
	}

	/**
	 * Update Title style control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_title_style() {
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
	 * Update featured post control.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_update_featured_style() {

		$this->update_control(
			'_f_meta',
			[
				'condition' => [
					$this->get_control_id( 'post_structure' ) => 'featured',
					$this->get_control_id( 'show_meta' ) => 'yes',
				],
			]
		);

		$this->update_control(
			'_f_excerpt_length',
			[
				'default' => apply_filters( 'uael_post_featured_excerpt_length', 0 ),
			]
		);
	}

	/**
	 * Register Style Taxonomy Badge Controls.
	 *
	 * @since 1.10.1
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
						'top'    => '5',
						'bottom' => '5',
						'left'   => '15',
						'right'  => '15',
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
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'term_hover_color',
				[
					'label'     => __( 'Hover Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms a:hover' => 'color: {{VALUE}};',
						'{{WRAPPER}}.uael-post__link-complete-yes .uael-post__complete-box-overlay:hover + .uael-post__inner-wrap .uael-post__terms a' => 'color: {{VALUE}};',
					],
					'condition' => [
						$this->get_control_id( 'show_meta' ) => 'yes',
					],
				]
			);

			$this->add_control(
				'term_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-posts[data-skin="business"] .uael-post__terms' => 'background-color: {{VALUE}};',
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
						'size' => 5,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__terms-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Posts AuthorBox Controls.
	 *
	 * @since 1.10.1
	 * @access public
	 */
	public function register_authorbox_style_controls() {

		$this->start_controls_section(
			'section_authorbox_field',
			[
				'label' => __( 'Author Box', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'author_image_heading',
				[
					'label' => __( 'Image', 'uael' ),
					'type'  => Controls_Manager::HEADING,
				]
			);

			$this->add_responsive_control(
				'author_image_size',
				[
					'label'      => __( 'Image Width', 'uael' ),
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
					'selectors'  => [
						'{{WRAPPER}} .uael-post__authorbox-image img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'image_spacing',
				[
					'label'     => __( 'Image Spacing', 'uael' ),
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
						'{{WRAPPER}}.uael-post__content-align-left .uael-post__authorbox-image' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.uael-post__content-align-center .uael-post__authorbox-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.uael-post__content-align-right .uael-post__authorbox-image' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'author_content_heading',
				[
					'label'     => __( 'Content', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'writtenby_text',
				[
					'label'   => __( 'Author Info Text', 'uael' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __( 'Written by', 'uael' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'authorbox_desc_color',
				[
					'label'     => __( 'Info Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__authorbox-desc' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'authorbox_name_color',
				[
					'label'     => __( 'Author Name Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-post__authorbox-name, {{WRAPPER}} .uael-post__authorbox-name a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => __( 'Info Text Typography', 'uael' ),
					'name'     => 'authorbox_desc_typography',
					'selector' => '{{WRAPPER}} .uael-post__authorbox-desc',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => __( 'Author Name Typography', 'uael' ),
					'name'     => 'authorbox_name_typography',
					'selector' => '{{WRAPPER}} .uael-post__authorbox-name, {{WRAPPER}} .uael-post__authorbox-name a',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				]
			);

			$this->add_control(
				'authorbox_spacing',
				[
					'label'     => __( 'Top Spacing', 'uael' ),
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
						'{{WRAPPER}} .uael-post__authorbox-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Render Main HTML.
	 *
	 * @since 1.10.1
	 * @access protected
	 */
	public function render() {

		$settings = $this->parent->get_settings_for_display();

		$skin = Skin_Init::get_instance( $this->get_id() );

		echo $skin->render( $this->get_id(), $settings, $this->parent->get_id() );
	}
}

