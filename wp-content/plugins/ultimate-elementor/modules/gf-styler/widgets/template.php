<?php
/**
 * UAEL Button Module Template.
 *
 * @package UAEL
 */

?>
<?php
$classname = '';
if ( 'yes' == $settings['gf_radio_check_custom'] ) {
	$classname = '';
}

?>
<div class="uael-gf-style <?php echo 'uael-gf-check-style'; ?> elementor-clickable">
	<?php
		$title       = '';
		$description = '';
		$form_desc   = 'false';
	if ( 'yes' === $settings['form_title_option'] ) {
		if ( class_exists( 'GFAPI' ) ) {
			$form      = GFAPI::get_form( absint( $settings['form_id'] ) );
			$title     = $form['title'];
			$form_desc = 'true';
		}
	} elseif ( 'no' === $settings['form_title_option'] ) {
		$title       = $this->get_settings_for_display( 'form_title' );
		$description = $this->get_settings_for_display( 'form_desc' );
		$form_desc   = 'false';
	} else {
		$title       = '';
		$description = '';
		$form_desc   = 'false';
	}
	if ( '' !== $title ) {
		?>
	<<?php echo $settings['form_title_tag']; ?> class="uael-gf-form-title"><?php echo esc_attr( $title ); ?></<?php echo $settings['form_title_tag']; ?>>
		<?php
	}
	if ( '' !== $description ) {
		?>
	<p class="uael-gf-form-desc"><?php echo esc_attr( $description ); ?></p>
		<?php
	}
	if ( '0' == $settings['form_id'] ) {
		_e( 'Please select a Gravity Form', 'uael' );
	} elseif ( $settings['form_id'] ) {
		$ajax = ( true == $settings['form_ajax_option'] ) ? 'true' : 'false';

		$shortcode_extra = '';
		$shortcode_extra = apply_filters( 'uael_gf_shortcode_extra_param', '', absint( $settings['form_id'] ) );

		echo do_shortcode( '[gravityform id=' . absint( $settings['form_id'] ) . ' ajax="' . $ajax . '" title="false" description="' . $form_desc . '" tabindex=' . $settings['form_tab_index_option'] . ' ' . $shortcode_extra . ']' );
	}

	?>

</div>
