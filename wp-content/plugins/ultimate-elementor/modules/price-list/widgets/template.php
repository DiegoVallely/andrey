<?php
/**
 * UAEL Price List Module Template.
 *
 * @package UAEL
 */

?>

<div class="uael-price-list uael-price-list-<?php echo $settings['image_position']; ?> uael-pl-price-position-<?php echo $settings['price_position']; ?>">

	<?php

	foreach ( $settings['price_list'] as $index => $item ) {

		$title_key = $this->get_repeater_setting_key( 'title', 'price_list', $index );
		$this->add_inline_editing_attributes( $title_key, 'basic' );

		$description_key = $this->get_repeater_setting_key( 'item_description', 'price_list', $index );

		$this->add_render_attribute( $description_key, 'class', 'uael-price-list-description' );
		$this->add_inline_editing_attributes( $description_key, 'basic' );

		$this->add_render_attribute( 'item_wrap' . $index, 'class', 'uael-price-list-item' );

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'item_wrap' . $index, 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		?>

		<div <?php echo $this->get_render_attribute_string( 'item_wrap' . $index ); ?>>

			<?php if ( ! empty( $item['image']['url'] ) ) { ?>
				<div class="uael-price-list-image">
					<?php echo $this->render_image( $item, $settings ); ?>
				</div>
			<?php } ?>

			<div class="uael-price-list-text">
				<div class="uael-price-list-header">
					<?php

					echo $this->render_item_header( $item );
					?>

					<span <?php echo $this->get_render_attribute_string( $title_key ); ?>><?php echo $item['title']; ?></span>
					<?php

					echo $this->render_item_footer( $item );

					if ( 'above' !== $settings['image_position'] && 'below' !== $settings['price_position'] ) {
						?>
						<span class="uael-price-list-separator"></span>
					<?php } ?>

					<?php
					if ( 'below' != $settings['price_position'] && 'above' != $settings['image_position'] ) {

						$this->get_price( $index, 'inner' );

					}
					?>
				</div>

				<?php if ( '' != $item['item_description'] ) { ?>

				<p <?php echo $this->get_render_attribute_string( $description_key ); ?>><?php echo $item['item_description']; ?></p>

				<?php } ?>

				<?php
						$this->get_price( $index, 'outer' );
				?>
			</div>
		</div>
	<?php } ?>
</div>
