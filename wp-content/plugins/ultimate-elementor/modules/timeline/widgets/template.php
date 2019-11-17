<?php
/**
 * UAEL Timeline Module Template.
 *
 * @package UAEL
 */

$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

$this->add_render_attribute( 'timeline_wrapper', 'class', 'uael-timeline-wrapper' );
$this->add_render_attribute( 'timeline_wrapper', 'class', 'uael-timeline-node' );
if ( 'yes' == $settings['timeline_responsive'] ) {
	$this->add_render_attribute( 'timeline_wrapper', 'class', 'uael-timeline-res-right' );
}
if ( 'yes' == $settings['timeline_cards_box_shadow'] ) {
	$this->add_render_attribute( 'timeline_main', 'class', 'uael-timeline-shadow-yes' );
}

$this->add_render_attribute( 'timeline_main', 'class', 'uael-timeline-main' );
$this->add_render_attribute( 'timeline_days', 'class', 'uael-days' );
$this->add_render_attribute( 'line', 'class', 'uael-timeline__line' );
$this->add_render_attribute( 'line-inner', 'class', 'uael-timeline__line__inner' );
$dynamic_settings = $this->get_settings_for_display();
?>
<div <?php echo $this->get_render_attribute_string( 'timeline_wrapper' ); ?>>
	<?php
		$count        = 0;
		$current_side = '';
	?>

	<div <?php echo $this->get_render_attribute_string( 'timeline_main' ); ?>>
		<div <?php echo $this->get_render_attribute_string( 'timeline_days' ); ?>>
			<?php foreach ( $dynamic['timelines'] as $index => $item ) { ?>
				<?php
				$this->add_render_attribute(
					[
						'timeline_single_content' => [ 'class' => 'uael-date' ],
					]
				);

				$heading_setting_key = $this->get_repeater_setting_key( 'timeline_single_heading', 'timelines', $index );
				$this->add_render_attribute( $heading_setting_key, 'class', 'uael-timeline-heading' );
				$this->add_inline_editing_attributes( $heading_setting_key, 'advanced' );


				$content_setting_key = $this->get_repeater_setting_key( 'timeline_heading_content', 'timelines', $index );
				$this->add_render_attribute( $content_setting_key, 'class', 'uael-timeline-desc-content' );
				$this->add_inline_editing_attributes( $content_setting_key, 'advanced' );


				$date_setting_key = $this->get_repeater_setting_key( 'timeline_single_date', 'timelines', $index );
				$this->add_inline_editing_attributes( $date_setting_key, 'none' );


				if ( ! empty( $item['timeline_single_link']['url'] ) ) {
					$this->add_render_attribute( 'url_' . $item['_id'], 'href', $item['timeline_single_link']['url'] );

					if ( $item['timeline_single_link']['is_external'] ) {
						$this->add_render_attribute( 'url_' . $item['_id'], 'target', '_blank' );
					}

					if ( ! empty( $item['timeline_single_link']['nofollow'] ) ) {
						$this->add_render_attribute( 'url_' . $item['_id'], 'rel', 'nofollow' );
					}
					$link = $this->get_render_attribute_string( 'url_' . $item['_id'] );
				}
				$this->add_render_attribute( 'card_' . $item['_id'], 'class', 'timeline-icon-new' );
				$this->add_render_attribute( 'card_' . $item['_id'], 'class', 'out-view-timeline-icon' );
				if ( ( 'fa fa-calendar' === $item['timeline_single_icon'] ) ) {
					$this->add_render_attribute( 'card_' . $item['_id'], 'class', $settings['timeline_all_icon'] );
				} else {
					$this->add_render_attribute( 'card_' . $item['_id'], 'class', $item['timeline_single_icon'] );
				}
				$this->add_render_attribute( 'current_' . $item['_id'], 'class', 'elementor-repeater-item-' . $item['_id'] );
				$this->add_render_attribute( 'current_' . $item['_id'], 'class', 'uael-timeline-field animate-border' );
				$this->add_render_attribute( 'current_' . $item['_id'], 'class', 'out-view' );
				$this->add_render_attribute( 'timeline_alignment' . $item['_id'], 'class', 'uael-day-new' );

				$this->add_render_attribute( 'data_alignment' . $item['_id'], 'class', 'uael-timeline-widget' );
				if ( 0 == $count % 2 ) {
					$current_side = 'Left';
				} else {
					$current_side = 'Right';
				}

				if ( 'Right' === $current_side ) {
					$this->add_render_attribute( 'timeline_alignment' . $item['_id'], 'class', 'uael-day-left' );
					$this->add_render_attribute( 'data_alignment' . $item['_id'], 'class', 'uael-timeline-left' );
				} else {
					$this->add_render_attribute( 'timeline_alignment' . $item['_id'], 'class', 'uael-day-right' );
					$this->add_render_attribute( 'data_alignment' . $item['_id'], 'class', 'uael-timeline-right' );
				}
				$this->add_render_attribute( 'timeline_events' . $item['_id'], 'class', 'uael-events-new' );
				$this->add_render_attribute( 'timeline_events_inner' . $item['_id'], 'class', 'uael-events-inner-new' );

				$this->add_render_attribute( 'timeline_content' . $item['_id'], 'class', 'uael-content' );

				if ( '' !== $item['timeline_single_heading'] || '' !== $item['timeline_single_content'] ) {
					?>
					<div <?php echo $this->get_render_attribute_string( 'current_' . $item['_id'] ); ?>>
						<div <?php echo $this->get_render_attribute_string( 'data_alignment' . $item['_id'] ); ?>>
							<div class="uael-timeline-marker">
								<i <?php echo $this->get_render_attribute_string( 'card_' . $item['_id'] ); ?>></i>
							</div>

							<div <?php echo $this->get_render_attribute_string( 'timeline_alignment' . $item['_id'] ); ?>>
								<div <?php echo $this->get_render_attribute_string( 'timeline_events' . $item['_id'] ); ?>>
									<?php if ( ! empty( $item['timeline_single_link']['url'] ) ) { ?>
										<a <?php echo $link; ?> >
									<?php } ?>
									<div <?php echo $this->get_render_attribute_string( 'timeline_events_inner' . $item['_id'] ); ?>>
										<?php
										if ( '' !== $item['timeline_single_date'] ) {
											?>
											<div class="uael-timeline-date-hide uael-date-inner"><div class="inner-date-new"><p <?php echo $this->get_render_attribute_string( $date_setting_key ); ?>><?php echo $item['timeline_single_date']; ?></p></div>
											</div>
										<?php } ?>
										<div <?php echo $this->get_render_attribute_string( 'timeline_content' . $item['_id'] ); ?>>	
											<?php
											if ( '' !== $item['timeline_single_heading'] ) {
												?>
											<div class="uael-timeline-heading-text">
												<<?php echo $settings['timeline_heading_tag']; ?> <?php echo $this->get_render_attribute_string( $heading_setting_key ); ?>><?php echo $this->parse_text_editor( $item['timeline_single_heading'] ); ?></<?php echo $settings['timeline_heading_tag']; ?>>
											</div>
											<?php } ?>
											<?php
											if ( '' !== $item['timeline_single_content'] ) {
												?>
												<div <?php echo $this->get_render_attribute_string( $content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['timeline_single_content'] ); ?></div>
											<?php } ?>
										</div>
										<div class="uael-timeline-arrow"></div>
									</div>
									<?php if ( ! empty( $item['timeline_single_link']['url'] ) ) { ?>
										</a>
									<?php } ?>
								</div>
							</div>
							<?php if ( 'center' == $settings['timeline_align'] ) { ?>
								<div class="uael-timeline-date-new">
									<div class="uael-date-new"><div class="inner-date-new"><div <?php echo $this->get_render_attribute_string( $date_setting_key ); ?>><?php echo $item['timeline_single_date']; ?></div></div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php
				}
				++$count;
				?>
			<?php } ?>
		</div>		
		<div <?php echo $this->get_render_attribute_string( 'line' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'line-inner' ); ?>></div>
		</div>
	</div>
</div>

