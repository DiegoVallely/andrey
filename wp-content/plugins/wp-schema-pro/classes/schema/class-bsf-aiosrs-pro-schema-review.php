<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Review' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Review {

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
			$schema['@type']    = 'Review';

			if ( ( isset( $data['item'] ) && ! empty( $data['item'] ) ) ||
				( isset( $data['item-image'] ) && ! empty( $data['item-image'] ) ) ) {

				$schema['itemReviewed']['@type'] = 'Thing';

				if ( isset( $data['item'] ) && ! empty( $data['item'] ) ) {
					$schema['itemReviewed']['name'] = wp_strip_all_tags( $data['item'] );
				}
				if ( isset( $data['item-image'] ) && ! empty( $data['item-image'] ) ) {
					$schema['itemReviewed']['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['item-image'] );
				}
			}

			if ( isset( $data['rating'] ) && ! empty( $data['rating'] ) ) {
				$schema['reviewRating']['@type']       = 'Rating';
				$schema['reviewRating']['ratingValue'] = wp_strip_all_tags( $data['rating'] );
			}

			if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
				$schema['description'] = wp_strip_all_tags( $data['description'] );
			}

			if ( isset( $data['date'] ) && ! empty( $data['date'] ) ) {
				$schema['datePublished'] = wp_strip_all_tags( $data['date'] );
			}
			if ( isset( $data['reviewer-type'] ) && ! empty( $data['reviewer-type'] ) ) {
				$schema['author']['@type'] = wp_strip_all_tags( $data['reviewer-type'] );
			} else {
				$schema['author']['@type'] = 'Person';
			}
			if ( isset( $data['reviewer-name'] ) && ! empty( $data['reviewer-name'] ) ) {
				$schema['author']['name'] = wp_strip_all_tags( $data['reviewer-name'] );
			}

			return apply_filters( 'wp_schema_pro_schema_review', $schema, $data, $post );
		}

	}
}
