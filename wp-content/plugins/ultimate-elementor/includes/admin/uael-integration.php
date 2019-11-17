<?php
/**
 * General Setting Form
 *
 * @package UAEL
 */

use UltimateElementor\Classes\UAEL_Helper;

$settings = UAEL_Helper::get_integrations_options();

$languages = UAEL_Helper::get_google_map_languages();

$is_saved      = ( isset( $_REQUEST['message'] ) && 'saved' == $_REQUEST['message'] ) ? true : false;
$google_status = '';
$yelp_status   = '';

// Action when settings saved.
if ( $is_saved ) {
	UAEL_Helper::get_api_authentication();
}
if ( isset( $settings['google_places_api'] ) && ! empty( $settings['google_places_api'] ) ) {
	$google_status = get_option( 'uael_google_api_status' );
}
if ( isset( $settings['yelp_api'] ) && ! empty( $settings['yelp_api'] ) ) {
	$yelp_status = get_option( 'uael_yelp_api_status' );
}
?>
<div class="uael-container uael-integration-wrapper">
	<form method="post" class="wrap clear" action="" >
		<div class="wrap uael-addon-wrap clear">
			<h1 class="screen-reader-text"><?php _e( 'Integrations', 'uael' ); ?></h1>
			<div id="poststuff">
				<div id="post-body" class="columns-1">
					<div id="post-body-content">
						<div class="uael-integration-form-wrap">
							<div class="widgets postbox">
								<div class="inside">
									<div class="form-wrap">
										<div class="form-field">
											<label for="uael-integration-google-api-key" class="uael-integration-heading"><?php _e( 'Google Map API Key', 'uael' ); ?></label>
											<p class="install-help uael-p"><strong><?php _e( 'Note:', 'uael' ); ?></strong>
											<?php
												$a_tag_open  = '<a target="_blank" rel="noopener" href="' . esc_url( 'https://uaelementor.com/docs/create-google-map-api-key/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin' ) . '">';
												$a_tag_close = '</a>';

												printf(
													/* translators: %1$s: a tag open. */
													__( 'This setting is required if you wish to use Google Map in your website. Need help to get Google map API key? Read %1$s this article %2$s.', 'uael' ),
													$a_tag_open,
													$a_tag_close
												);
												?>
											</p>
											<input type="text" name="uael_integration[google_api]" id="uael-integration-google-api-key" class="placeholder placeholder-active" value="<?php echo esc_attr( $settings['google_api'] ); ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="widgets postbox">
								<div class="inside">
									<div class="form-wrap">
										<div class="form-field">
											<label for="uael-integration-google-language" class="uael-integration-heading"><?php _e( 'Google Map Localization Language', 'uael' ); ?></label>
											<p class="install-help uael-p"><strong><?php _e( 'Note:', 'uael' ); ?></strong>  <?php _e( 'This setting sets localization language to google map. The language affects the names of controls, copyright notices, driving directions, and control labels.', 'uael' ); ?></p>
											<p class="uael-p">
											<?php
												$a_tag_open  = '<a href="' . esc_url( 'https://uaelementor.com/docs/how-to-display-uaels-google-maps-widget-in-your-local-language/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin' ) . '" target="_blank" rel="noopener">';
												$a_tag_close = '</a>';
												printf(
													/* translators: %1$s: a tag open. */
													__( 'Need help to understand this feature? Read %1$s this article %2$s.', 'uael' ),
													$a_tag_open,
													$a_tag_close
												);
												?>
											</p>
											<select name="uael_integration[language]" id="uael-integration-google-language" class="placeholder placeholder-active">
												<option value=""><?php _e( 'Default', 'uael' ); ?></option>
											<?php foreach ( $languages as $key => $value ) { ?>
												<?php
												$selected = '';
												if ( $key === $settings['language'] ) {
													$selected = 'selected="selected" ';
												}
												?>
												<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo esc_attr( $value ); ?></option>
											<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="widgets postbox">
								<div class="inside">
									<div class="form-wrap">
										<div class="form-field">
											<label for="uael-integration-google-places-key" class="uael-integration-heading"><?php _e( 'Business Reviews - Google Places API Key', 'uael' ); ?></label>
											<p class="install-help uael-p"><strong><?php _e( 'Note:', 'uael' ); ?></strong>
											<?php
												$a_tag_open  = '<a target="_blank" rel="noopener" href="' . esc_url( 'https://uaelementor.com/docs/get-google-places-api-key/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin' ) . '">';
												$a_tag_close = '</a>';

												printf(
													/* translators: %1$s: a tag open. */
													__( 'This setting is required if you wish to use Google Places Reviews in your website. Need help to get Google Places API key? Read %1$s this article %2$s.', 'uael' ),
													$a_tag_open,
													$a_tag_close
												);
												?>
											</p>
											<input type="text" name="uael_integration[google_places_api]" id="uael-integration-google-places-key" class="placeholder placeholder-active" value="<?php echo esc_attr( $settings['google_places_api'] ); ?>">

											<?php if ( 'yes' === $google_status && $is_saved ) { ?>
												<span class="uael-response-success"><?php _e( 'Your API key authenticated successfully!', 'uael' ); ?></span>
											<?php } elseif ( 'no' === $google_status ) { ?>
													<span class="uael-response-warning"><?php _e( 'Entered API key is invalid', 'uael' ); ?></span>
											<?php } elseif ( 'exceeded' === $google_status && $is_saved ) { ?>
													<span class="uael-google-error-response">
														<span class="uael-response-warning"><?php _e( '<b>Google Error Message:</b>', 'uael' ); ?></span>
														<?php
															printf(
																/* translators: %1$s command. */
																__( 'You have exceeded your daily request quota for this API. If you did not set a custom daily request quota, verify your project has an active billing account.</br>Click %1$s here %2$s to enable billing.', 'uael' ),
																'<a href="http://g.co/dev/maps-no-account" target="_blank" rel="noopener">',
																'</a>'
															);
														?>
													</span>
											<?php } ?>

										</div>
									</div>
								</div>
							</div>

							<div class="widgets postbox">
								<div class="inside">
									<div class="form-wrap">
										<div class="form-field">
											<label for="uael-integration-yelp-api-key" class="uael-integration-heading"><?php _e( 'Business Reviews - Yelp API Key', 'uael' ); ?></label>
											<p class="install-help uael-p"><strong><?php _e( 'Note:', 'uael' ); ?></strong>
											<?php
												$a_tag_open  = '<a target="_blank" rel="noopener" href="' . esc_url( 'https://uaelementor.com/docs/get-yelp-api-key/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin' ) . '">';
												$a_tag_close = '</a>';

												printf(
													/* translators: %1$s: a tag open. */
													__( 'This setting is required if you wish to use Yelp Reviews in your website. Need help to get Yelp API key? Read %1$s this article %2$s.', 'uael' ),
													$a_tag_open,
													$a_tag_close
												);
												?>
											</p>
											<input type="text" name="uael_integration[yelp_api]" id="uael-integration-yelp-api-key" class="placeholder placeholder-active" value="<?php echo esc_attr( $settings['yelp_api'] ); ?>">

											<?php if ( 'yes' === $yelp_status && $is_saved ) { ?>
												<div class="uael-response-success"><?php _e( 'Your API key authenticated successfully!', 'uael' ); ?></div>
											<?php } elseif ( 'no' === $yelp_status ) { ?>
													<div class="uael-response-warning"><?php _e( 'Entered API key is invalid', 'uael' ); ?></div>
											<?php } ?>

										</div>
									</div>
								</div>
							</div>
						</div>
						<?php submit_button( __( 'Save Changes', 'uael' ), 'uael-save-integration-options button-primary button button-hero' ); ?>
						<?php wp_nonce_field( 'uael-integration', 'uael-integration-nonce' ); ?>
					</div>
				</div>
				<!-- /post-body -->
				<br class="clear">
			</div>
		</div>
	</form>
</div>
