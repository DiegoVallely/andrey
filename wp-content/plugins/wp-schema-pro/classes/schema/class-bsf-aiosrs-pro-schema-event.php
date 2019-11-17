<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Event' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Event {

		/**
		 * Render Schema.
		 *
		 * @param  array $data Meta Data.
		 * @param  array $post Current Post Array.
		 * @return array
		 */
		public static function render( $data, $post ) {
			$schema = array();

			$schema['@context'] = 'https://schema.org';
			$schema['@type']    = 'Event';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
				$schema['description'] = wp_strip_all_tags( $data['description'] );
			}

			if ( isset( $data['start-date'] ) && ! empty( $data['start-date'] ) ) {
				$schema['startDate'] = wp_strip_all_tags( $data['start-date'] );
			}

			if ( isset( $data['end-date'] ) && ! empty( $data['end-date'] ) ) {
				$schema['endDate'] = wp_strip_all_tags( $data['end-date'] );
			}

			if ( isset( $data['performer'] ) && ! empty( $data['performer'] ) ) {
				$schema['performer']['@type'] = 'Person';
				$schema['performer']['name']  = wp_strip_all_tags( $data['performer'] );
			}

			if ( isset( $data['location'] ) && ! empty( $data['location'] ) ) {
				$schema['location']['@type'] = 'Place';
				$schema['location']['name']  = wp_strip_all_tags( $data['location'] );
			}

			if ( ( isset( $data['location-street'] ) && ! empty( $data['location-street'] ) ) ||
				( isset( $data['location-locality'] ) && ! empty( $data['location-locality'] ) ) ||
				( isset( $data['location-postal'] ) && ! empty( $data['location-postal'] ) ) ||
				( isset( $data['location-region'] ) && ! empty( $data['location-region'] ) ) ||
				( isset( $data['location-country'] ) && ! empty( $data['location-country'] ) ) ) {

				$schema['location']['@type']            = 'Place';
				$schema['location']['address']['@type'] = 'PostalAddress';

				if ( isset( $data['location-street'] ) && ! empty( $data['location-street'] ) ) {
					$schema['location']['address']['streetAddress'] = wp_strip_all_tags( $data['location-street'] );
				}
				if ( isset( $data['location-locality'] ) && ! empty( $data['location-locality'] ) ) {
					$schema['location']['address']['addressLocality'] = wp_strip_all_tags( $data['location-locality'] );
				}
				if ( isset( $data['location-postal'] ) && ! empty( $data['location-postal'] ) ) {
					$schema['location']['address']['postalCode'] = wp_strip_all_tags( $data['location-postal'] );
				}
				if ( isset( $data['location-region'] ) && ! empty( $data['location-region'] ) ) {
					$schema['location']['address']['addressRegion'] = wp_strip_all_tags( $data['location-region'] );
				}
				if ( isset( $data['location-country'] ) && ! empty( $data['location-country'] ) ) {
					$schema['location']['address']['addressCountry'] = wp_strip_all_tags( $data['location-country'] );
				}
			}

			$schema['offers']['@type'] = 'Offer';
			$schema['offers']['price'] = '0';
			if ( isset( $data['price'] ) && ! empty( $data['price'] ) ) {
				$schema['offers']['price'] = wp_strip_all_tags( $data['price'] );
			}

			if ( ( isset( $data['avail'] ) && ! empty( $data['avail'] ) ) ||
				( isset( $data['currency'] ) && ! empty( $data['currency'] ) ) ||
				( isset( $data['ticket-buy-url'] ) && ! empty( $data['ticket-buy-url'] ) ) ) {

				if ( isset( $data['avail'] ) && ! empty( $data['avail'] ) ) {
					$schema['offers']['availability'] = wp_strip_all_tags( $data['avail'] );
				}
				if ( isset( $data['currency'] ) && ! empty( $data['currency'] ) ) {
					$schema['offers']['priceCurrency'] = wp_strip_all_tags( $data['currency'] );
				}
				if ( isset( $data['valid-from'] ) && ! empty( $data['valid-from'] ) ) {
					$schema['offers']['validFrom'] = wp_strip_all_tags( $data['valid-from'] );
				}
				if ( isset( $data['ticket-buy-url'] ) && ! empty( $data['ticket-buy-url'] ) ) {
					$schema['offers']['url'] = esc_url( $data['ticket-buy-url'] );
				}
			}

			return apply_filters( 'wp_schema_pro_schema_event', $schema, $data, $post );
		}

	}
}
