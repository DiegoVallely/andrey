<?php
/**
 * UAEL Marketing Button.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\MarketingButton\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Widget_Button;
use Elementor\Group_Control_Background;
// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Marketing Button.
 */
class Marketing_Button extends Common_Widget {

	/**
	 * Retrieve Marketing Button Widget name.
	 *
	 * @since 1.10.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Marketing_Button' );
	}

	/**
	 * Retrieve Marketing Button Widget title.
	 *
	 * @since 1.10.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Marketing_Button' );
	}

	/**
	 * Retrieve Marketing Button Widget icon.
	 *
	 * @since 1.10.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Marketing_Button' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.10.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Marketing_Button' );
	}

	/**
	 * Retrieve Marketing Button sizes.
	 *
	 * @since 1.10.0
	 * @access public
	 *
	 * @return array Marketing Button Sizes.
	 */
	public static function get_button_sizes() {
		return Widget_Button::get_button_sizes();
	}

	/**
	 * Register Marketing Button controls.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function _register_controls() {

		// Content Tab.
		$this->register_buttons_content_controls();

		// Style Tab.
		$this->register_styling_style_controls();
		$this->register_color_content_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Marketing Button General Controls.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function register_buttons_content_controls() {

		$this->start_controls_section(
			'section_buttons',
			[
				'label' => __( 'General', 'uael' ),
			]
		);
			$this->add_control(
				'text',
				[
					'label'   => __( 'Title', 'uael' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '2',
					'default' => __( 'Subscribe Now', 'uael' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'desc_text',
				[
					'label'   => __( 'Description', 'uael' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '3',
					'default' => __( 'Get access to Premium Features for FREE for a year!', 'uael' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'link',
				[
					'label'    => __( 'Link', 'uael' ),
					'type'     => Controls_Manager::URL,
					'default'  => [
						'url'         => '#',
						'is_external' => '',
					],
					'dynamic'  => [
						'active' => true,
					],
					'selector' => '',
				]
			);

			$this->add_control(
				'icon',
				[
					'label'       => __( 'Icon', 'uael' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
					'default'     => 'fa fa-arrow-right',
					'separator'   => 'before',
				]
			);

			$this->add_control(
				'icon_align',
				[
					'label'     => __( 'Icon Position', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'      => __( 'Before Title', 'uael' ),
						'right'     => __( 'After Title', 'uael' ),
						'all_left'  => __( 'Before Title & Description', 'uael' ),
						'all_right' => __( 'After Title & Description', 'uael' ),
					],
					'condition' => [
						'icon!' => '',
					],
				]
			);

			$this->add_control(
				'icon_vertical_align',
				[
					'label'       => __( 'Icon Vertical Alignment', 'uael' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => 'center',
					'options'     => [
						'flex-start' => [
							'title' => __( 'Top', 'uael' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center'     => [
							'title' => __( 'Middle', 'uael' ),
							'icon'  => 'eicon-v-align-middle',
						],
					],
					'condition'   => [
						'icon!'      => '',
						'icon_align' => [ 'all_left', 'all_right' ],
					],
					'selectors'   => [
						'{{WRAPPER}} .uael-marketing-buttons-all_left.elementor-button .elementor-button-icon, {{WRAPPER}} .uael-marketing-buttons-all_right.elementor-button .elementor-button-icon' => 'align-self: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_size',
				[
					'label'     => __( 'Icon Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'condition' => [
						'icon!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_indent',
				[
					'label'     => __( 'Icon Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'condition' => [
						'icon!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-align-icon-right,
						{{WRAPPER}} .uael-marketing-buttons-all_right.elementor-button .elementor-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-align-icon-left,
						{{WRAPPER}} .uael-marketing-buttons-all_left.elementor-button .elementor-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'css_id',
				[
					'label'   => __( 'CSS ID', 'uael' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '',
					'title'   => __( 'Add your custom id WITHOUT the # key.', 'uael' ),
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.10.0
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/marketing-button-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Register Marketing Button Colors Controls.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function register_color_content_controls() {

		$this->start_controls_section(
			'general_colors',
			[
				'label' => __( 'Content', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'text_align',
				[
					'label'        => __( 'Alignment', 'uael' ),
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
					'prefix_class' => 'uael-mbutton-text-',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'all_typography',
					'label'    => __( 'Title Typography', 'uael' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .uael-marketing-button-title',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'desc_typography',
					'label'    => __( 'Description Typography', 'uael' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .uael-marketing-button .uael-marketing-button-desc',
				]
			);

			$this->add_responsive_control(
				'title_margin_bottom',
				[
					'label'      => __( 'Space between Title & Description', 'uael' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-marketing-button .elementor-button-content-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Marketing Button Styling Controls.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function register_styling_style_controls() {

		$this->start_controls_section(
			'section_styling',
			[
				'label' => __( 'Button', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'align',
				[
					'label'        => __( 'Alignment', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
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
							'title' => __( 'Justify', 'uael' ),
							'icon'  => 'fa fa-align-justify',
						],
					],
					'default'      => 'center',
					'toggle'       => false,
					'prefix_class' => 'elementor%s-align-',
				]
			);

			$this->add_control(
				'size',
				[
					'label'   => __( 'Size', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'md',
					'options' => self::get_button_sizes(),
				]
			);

			$this->add_responsive_control(
				'padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( '_button_style' );

				$this->start_controls_tab(
					'_button_normal',
					[
						'label' => __( 'Normal', 'uael' ),
					]
				);

					$this->add_control(
						'all_text_color',
						[
							'label'     => __( 'Text Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} a.elementor-button' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_color',
							'label'          => __( 'Background Color', 'uael' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} a.elementor-button',
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
							'name'     => 'all_border',
							'label'    => __( 'Border', 'uael' ),
							'selector' => '{{WRAPPER}} .elementor-button',
						]
					);

					$this->add_control(
						'all_border_radius',
						[
							'label'      => __( 'Border Radius', 'uael' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'all_button_box_shadow',
							'selector' => '{{WRAPPER}} .elementor-button',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'all_button_hover',
					[
						'label' => __( 'Hover', 'uael' ),
					]
				);

					$this->add_control(
						'all_hover_color',
						[
							'label'     => __( 'Text Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} a.elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_hover_color',
							'label'          => __( 'Background Color', 'uael' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} a.elementor-button:hover',
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
						'all_border_hover_color',
						[
							'label'     => __( 'Border Hover Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} a.elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'all_button_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .elementor-button:hover',
							'separator' => 'after',
						]
					);

					$this->add_control(
						'hover_animation',
						[
							'label'       => __( 'Hover Animation', 'uael' ),
							'type'        => Controls_Manager::HOVER_ANIMATION,
							'label_block' => false,
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render Marketing Button widget text.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function render_button_text() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		if ( '' !== $settings['icon'] ) {
			$this->add_render_attribute( 'content-wrapper', 'class', 'uael-buttons-icon-' . $settings['icon_align'] );
		}

		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon' );

		$this->add_render_attribute( 'btn-text', 'class', 'elementor-button-text' );
		$this->add_render_attribute( 'btn-text', 'class', 'uael-marketing-button-title' );
		$this->add_render_attribute( 'btn-text', 'class', 'elementor-inline-editing' );

		?>
		<?php if ( ! empty( $settings['icon'] ) && ( 'all_left' == $settings['icon_align'] || 'all_right' == $settings['icon_align'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
			</span>
		<?php endif; ?>
		<span class="uael-marketing-buttons-wrap">
			<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
				<?php if ( ! empty( $settings['icon'] ) && ( 'left' == $settings['icon_align'] || 'right' == $settings['icon_align'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					</span>
				<?php endif; ?>
				<span <?php echo $this->get_render_attribute_string( 'btn-text' ); ?> data-elementor-setting-key="text" data-elementor-inline-editing-toolbar="none"><?php echo $settings['text']; ?></span>
			</span>
			<?php if ( '' !== $settings['desc_text'] ) { ?>
				<span class="uael-marketing-button-desc elementor-inline-editing" data-elementor-setting-key="desc_text" data-elementor-inline-editing-toolbar="none"><?php echo $settings['desc_text']; ?></span>
			<?php } ?> 
		</span>
		<?php
	}

	/**
	 * Render Marketing Buttons output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}

		if ( '' != $settings['css_id'] ) {
			$this->add_render_attribute( 'button', 'id', $settings['css_id'] );
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}
		if ( '' !== $settings['icon'] ) {
			$this->add_render_attribute( 'button', 'class', 'uael-marketing-buttons-' . $settings['icon_align'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
		?>
		<div class="uael-marketing-button">
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php $this->render_button_text(); ?>
				</a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Marketing Buttons widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.10.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="uael-marketing-button">
			<#
			view.addRenderAttribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );
			var uael_mbutton_align = '';
			var new_icon_align = '';
			var icon_align = '';

			view.addRenderAttribute( 'button', 'class', 'elementor-button' );

			if ( '' != settings.link.url ) {
				view.addRenderAttribute( 'button', 'href', settings.link.url );
				view.addRenderAttribute( 'button', 'class', 'elementor-button-link' );
			}

			if ( '' != settings.size ) {
				view.addRenderAttribute( 'button', 'class', 'elementor-size-' + settings.size );
			}

			if ( '' !== settings.icon ) {
				uael_mbutton_align = 'uael-marketing-buttons-' + settings.icon_align;
				view.addRenderAttribute( 'button', 'class', uael_mbutton_align );
			}

			if ( settings.hover_animation ) {
				view.addRenderAttribute( 'button', 'class', 'elementor-animation-' + settings.hover_animation );
			} #>

			<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
				<a id="{{ settings.css_id }}" {{{ view.getRenderAttributeString( 'button' ) }}}>
					<#
					if ( '' != settings.icon ) {
						new_icon_align = ' uael-buttons-icon-' + settings.icon_align;
					} #>
					<# if ( '' !== settings.icon && ( 'all_left' == settings.icon_align || 'all_right' == settings.icon_align ) ) {
						icon_align = 'elementor-align-icon-' + settings.icon_align; #>
						<span class="elementor-button-icon {{ icon_align }}">
							<i class="{{ settings.icon }}" aria-hidden="true"></i>
						</span>
					<# } #>
					<span class="uael-marketing-buttons-wrap">
						<span class="elementor-button-content-wrapper{{ new_icon_align }}">
							<# if ( '' !== settings.icon && ( 'left' == settings.icon_align || 'right' == settings.icon_align ) ) {
								icon_align = 'elementor-align-icon-' + settings.icon_align; #>
								<span class="elementor-button-icon {{ icon_align }}">
									<i class="{{ settings.icon }}" aria-hidden="true"></i>
								</span>
							<# } #>
							<span class="elementor-button-text elementor-inline-editing uael-marketing-button-title" data-elementor-setting-key="settings.buttons.text" data-elementor-inline-editing-toolbar="none">{{ settings.text }}</span>
						</span>
						<# if ( '' != settings.desc_text ) { #>
						<span class="uael-marketing-button-desc" data-elementor-setting-key="settings.buttons.desc_text" data-elementor-inline-editing-toolbar="none">{{ settings.desc_text }}</span>
						<# } #>
					</span>
				</a>
			</div>
		<?php
	}

}
