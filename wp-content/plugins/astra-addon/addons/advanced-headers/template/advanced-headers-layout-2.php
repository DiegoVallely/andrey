<?php
/**
 * The title bar style 2 for our theme.
 *
 * This template generates markup required for the title bar style 2
 *
 * @todo Update this template for Default Advanced Headers Style
 *
 * @package Astra Addon
 */

$show_breadcrumb       = Astra_Ext_Advanced_Headers_Loader::astra_advanced_headers_layout_option( 'breadcrumb' );
$is_breadcrumb_enabled = '';
$title                 = apply_filters( 'astra_advanced_header_title', astra_get_the_title() );
$description           = apply_filters( 'astra_advanced_header_description', get_the_archive_description() );
if ( $show_breadcrumb ) {
	$is_breadcrumb_enabled = $show_breadcrumb;
}

?>
<div class="ast-inside-advanced-header-content">
	<div class="ast-advanced-headers-layout ast-advanced-headers-layout-2" >
		<div class="ast-container ast-title-bar-align-center">
			<div class="ast-advanced-headers-wrap">
				<?php do_action( 'astra_advanced_header_layout_2_wrap_top' ); ?>
				<?php if ( $title ) { ?>
				<h1 class="ast-advanced-headers-title">
					<?php do_action( 'astra_advanced_header_layout_2_before_title' ); ?>
					<?php echo apply_filters( 'astra_advanced_header_layout_2_title', wp_kses_post( $title ) ); ?>
					<?php do_action( 'astra_advanced_header_layout_2_after_title' ); ?>
				</h1>
				<?php } ?>

				<?php do_action( 'astra_advanced_header_layout_2_after_title_tag' ); ?>

				<?php if ( $description ) { ?>
				<div class="taxonomy-description">
					<?php do_action( 'astra_advanced_header_layout_2_before_description' ); ?>
					<?php echo apply_filters( 'astra_advanced_header_layout_2_description', wp_kses_post( $description ) ); ?>
					<?php do_action( 'astra_advanced_header_layout_2_after_description' ); ?>
				</div>
				<?php } ?>

				<?php do_action( 'astra_advanced_header_layout_2_wrap_bottom' ); ?>
			</div>

	<?php if ( $is_breadcrumb_enabled ) { ?>
				<div class="ast-advanced-headers-breadcrumb">
					<?php Astra_Ext_Advanced_Headers_Markup::advanced_headers_breadcrumbs_markup(); ?>
				</div><!-- .ast-advanced-headers-breadcrumb -->
	<?php } ?>
		</div>
	</div>
</div>
