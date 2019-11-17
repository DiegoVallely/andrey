<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Service' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Service {

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
			$schema['@type']    = 'Service';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['type'] ) && ! empty( $data['type'] ) ) {
				$schema['serviceType'] = wp_strip_all_tags( $data['type'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( ( isset( $data['provider'] ) && ! empty( $data['provider'] ) ) ||
				( isset( $data['location-image'] ) && ! empty( $data['location-image'] ) ) ||
				( isset( $data['telephone'] ) && ! empty( $data['telephone'] ) ) ||
				( isset( $data['price-range'] ) && ! empty( $data['price-range'] ) ) ) {

				$schema['provider']['@type'] = 'LocalBusiness';

				if ( isset( $data['provider'] ) && ! empty( $data['provider'] ) ) {
					$schema['provider']['name'] = wp_strip_all_tags( $data['provider'] );
				}
				if ( isset( $data['location-image'] ) && ! empty( $data['location-image'] ) ) {
					$schema['provider']['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['location-image'] );
				}
				if ( isset( $data['telephone'] ) && ! empty( $data['telephone'] ) ) {
					$schema['provider']['telephone'] = wp_strip_all_tags( $data['telephone'] );
				}
				if ( isset( $data['price-range'] ) && ! empty( $data['price-range'] ) ) {
					$schema['provider']['priceRange'] = wp_strip_all_tags( $data['price-range'] );
				}
			}

			if ( ( isset( $data['location-locality'] ) && ! empty( $data['location-locality'] ) ) ||
				( isset( $data['location-region'] ) && ! empty( $data['location-region'] ) ) ||
				( isset( $data['location-street'] ) && ! empty( $data['location-street'] ) ) ) {

				$schema['provider']['@type']            = 'LocalBusiness';
				$schema['provider']['address']['@type'] = 'PostalAddress';

				if ( isset( $data['location-locality'] ) && ! empty( $data['location-locality'] ) ) {
					$schema['provider']['address']['addressLocality'] = wp_strip_all_tags( $data['location-locality'] );
				}
				if ( isset( $data['location-region'] ) && ! empty( $data['location-region'] ) ) {
					$schema['provider']['address']['addressRegion'] = wp_strip_all_tags( $data['location-region'] );
				}
				if ( isset( $data['location-street'] ) && ! empty( $data['location-street'] ) ) {
					$schema['provider']['address']['streetAddress'] = wp_strip_all_tags( $data['location-street'] );
				}
			}

			if ( isset( $data['area'] ) && ! empty( $data['area'] ) ) {
				$schema['areaServed']['@type'] = 'State';
				$schema['areaServed']['name']  = wp_strip_all_tags( $data['area'] );
			}

			if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
				$schema['description'] = wp_strip_all_tags( $data['description'] );
			}

			if ( ( isset( $data['rating'] ) && ! empty( $data['rating'] ) ) ||
				( isset( $data['review-count'] ) && ! empty( $data['review-count'] ) ) ) {

				$schema['aggregateRating']['@type'] = 'AggregateRating';

				if ( isset( $data['rating'] ) && ! empty( $data['rating'] ) ) {
					$schema['aggregateRating']['ratingValue'] = wp_strip_all_tags( $data['rating'] );
				}
				if ( isset( $data['review-count'] ) && ! empty( $data['review-count'] ) ) {
					$schema['aggregateRating']['reviewCount'] = wp_strip_all_tags( $data['review-count'] );
				}
			}

			return apply_filters( 'wp_schema_pro_schema_service', $schema, $data, $post );
		}

	}
}
