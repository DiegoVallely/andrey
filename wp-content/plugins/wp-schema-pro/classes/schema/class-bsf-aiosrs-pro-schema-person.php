<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Person' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Person {

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
			$schema['@type']    = 'Person';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( ( isset( $data['street'] ) && ! empty( $data['street'] ) ) ||
				( isset( $data['locality'] ) && ! empty( $data['locality'] ) ) ||
				( isset( $data['postal'] ) && ! empty( $data['postal'] ) ) ||
				( isset( $data['region'] ) && ! empty( $data['region'] ) ) ) {

				$schema['address']['@type'] = 'PostalAddress';

				if ( isset( $data['locality'] ) && ! empty( $data['locality'] ) ) {
					$schema['address']['addressLocality'] = wp_strip_all_tags( $data['locality'] );
				}

				if ( isset( $data['region'] ) && ! empty( $data['region'] ) ) {
					$schema['address']['addressRegion'] = wp_strip_all_tags( $data['region'] );
				}

				if ( isset( $data['postal'] ) && ! empty( $data['postal'] ) ) {
					$schema['address']['postalCode'] = wp_strip_all_tags( $data['postal'] );
				}

				if ( isset( $data['street'] ) && ! empty( $data['street'] ) ) {
					$schema['address']['streetAddress'] = wp_strip_all_tags( $data['street'] );
				}
			}

			if ( isset( $data['email'] ) && ! empty( $data['email'] ) ) {
				$schema['email'] = wp_strip_all_tags( $data['email'] );
			}

			if ( isset( $data['gender'] ) && ! empty( $data['gender'] ) ) {
				$schema['gender'] = wp_strip_all_tags( $data['gender'] );
			}

			if ( isset( $data['dob'] ) && ! empty( $data['dob'] ) ) {
				$date_informat       = date( 'Y.m.d', strtotime( $data['dob'] ) );
				$schema['birthDate'] = wp_strip_all_tags( $date_informat );
			}

			if ( isset( $data['member'] ) && ! empty( $data['member'] ) ) {
				$schema['memberOf'] = wp_strip_all_tags( $data['member'] );
			}

			if ( isset( $data['nationality'] ) && ! empty( $data['nationality'] ) ) {
				$schema['nationality'] = wp_strip_all_tags( $data['nationality'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['job-title'] ) && ! empty( $data['job-title'] ) ) {
				$schema['jobTitle'] = wp_strip_all_tags( $data['job-title'] );
			}

			if ( isset( $data['telephone'] ) && ! empty( $data['telephone'] ) ) {
				$schema['telephone'] = wp_strip_all_tags( $data['telephone'] );
			}

			if ( isset( $data['homepage-url'] ) && ! empty( $data['homepage-url'] ) ) {
				$schema['url'] = esc_url( $data['homepage-url'] );
			}

			if ( isset( $data['add-url'] ) && ! empty( $data['add-url'] ) ) {
				foreach ( $data['add-url'] as $key => $value ) {
					if ( isset( $value['same-as'] ) && ! empty( $value['same-as'] ) ) {
						$schema['sameAs'][ $key ] = wp_strip_all_tags( $value['same-as'] );
					}
				}
			}
			$contact_type = BSF_AIOSRS_Pro_Admin::get_options( 'wp-schema-pro-corporate-contact' );

				$contactpoint = array( $contact_type['contact-hear'], $contact_type['contact-toll'] );
			if ( '1' == $contact_type['cp-schema-type'] && true == apply_filters( 'wp_schema_pro_contactpoint_person_schema_enabled', true ) ) {
				if ( isset( $contact_type['contact-type'] ) && ! empty( $contact_type['contact-type'] ) ) {
						$schema['ContactPoint']['@type'] = 'ContactPoint';

					if ( isset( $contact_type['contact-type'] ) && ! empty( $contact_type['contact-type'] ) ) {
						$schema ['ContactPoint']['contactType'] = $contact_type['contact-type'];
					}
					if ( isset( $contact_type['telephone'] ) && ! empty( $contact_type['telephone'] ) ) {
						$schema ['ContactPoint']['telephone'] = $contact_type['telephone'];
					}
					if ( isset( $contact_type['url'] ) && ! empty( $contact_type['url'] ) ) {
						$schema ['ContactPoint']['url'] = $contact_type['url'];
					}
					if ( isset( $contact_type['email'] ) && ! empty( $contact_type['email'] ) ) {
						$schema ['ContactPoint']['email'] = $contact_type['email'];
					}
					if ( isset( $contact_type['areaServed'] ) && ! empty( $contact_type['areaServed'] ) ) {
						$schema ['ContactPoint']['areaServed'] = $contact_type['areaServed'];
					}
					if ( isset( $contactpoint ) && ! empty( $contactpoint ) ) {

						$schema ['ContactPoint']['contactOption'] = $contactpoint;

					}

					if ( isset( $contact_type['availableLanguage'] ) && ! empty( $contact_type['availableLanguage'] ) ) {
						$schema ['ContactPoint']['availableLanguage'] = $contact_type['availableLanguage'];
					}
				}
			}

			return apply_filters( 'wp_schema_pro_schema_person', $schema, $data, $post );
		}

	}
}
