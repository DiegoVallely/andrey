<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Recipe' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Recipe {

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
			$schema['@type']    = 'Recipe';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['author'] ) && ! empty( $data['author'] ) ) {
				$schema['author']['@type'] = 'Person';
				$schema['author']['name']  = wp_strip_all_tags( $data['author'] );
			}

			if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
				$schema['description'] = wp_strip_all_tags( $data['description'] );
			}

			if ( isset( $data['preperation-time'] ) && ! empty( $data['preperation-time'] ) ) {
				$schema['prepTime'] = wp_strip_all_tags( $data['preperation-time'] );
			}

			if ( isset( $data['cook-time'] ) && ! empty( $data['cook-time'] ) ) {
				$schema['cookTime'] = wp_strip_all_tags( $data['cook-time'] );
			}

			if ( isset( $data['recipe-keywords'] ) && ! empty( $data['recipe-keywords'] ) ) {
				$schema['keywords'] = wp_strip_all_tags( $data['recipe-keywords'] );
			}

			if ( isset( $data['recipe-category'] ) && ! empty( $data['recipe-category'] ) ) {
				$schema['recipeCategory'] = wp_strip_all_tags( $data['recipe-category'] );
			}

			if ( isset( $data['recipe-cuisine'] ) && ! empty( $data['recipe-cuisine'] ) ) {
				$schema['recipeCuisine'] = wp_strip_all_tags( $data['recipe-cuisine'] );
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

			if ( isset( $data['nutrition'] ) && ! empty( $data['nutrition'] ) ) {
				$schema['nutrition']['@type']    = 'NutritionInformation';
				$schema['nutrition']['calories'] = wp_strip_all_tags( $data['nutrition'] );
			}

			if ( isset( $data['ingredients'] ) && ! empty( $data['ingredients'] ) ) {
				$schema['recipeIngredient'] = wp_strip_all_tags( $data['ingredients'] );
			}

			if ( isset( $data['recipe-instructions'] ) && ! empty( $data['recipe-instructions'] ) ) {
				foreach ( $data['recipe-instructions'] as $key => $value ) {

					if ( isset( $value['steps'] ) && ! empty( $value['steps'] ) ) {

						$schema['recipeInstructions'][ $key ]['@type'] = 'HowToStep';
						$schema['recipeInstructions'][ $key ]['text']  = $value['steps'];
					}
				}
			}

			if ( isset( $data['recipe-video'] ) && ! empty( $data['recipe-video'] ) ) {
				foreach ( $data['recipe-video'] as $key => $value ) {
					if ( isset( $value['video-name'] ) && ! empty( $value['video-name'] ) ) {

							$schema['video'][ $key ]['name'] = $value['video-name'];
					}
					if ( isset( $value['video-desc'] ) && ! empty( $value['video-desc'] ) ) {
							$schema['video'][ $key ]['description'] = $value['video-desc'];
					}
					if ( isset( $value['video-image'] ) && ! empty( $value['video-image'] ) ) {
							$schema['video'][ $key ]['thumbnailUrl'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $value['video-image'], 'URL' );
					}
					if ( isset( $value['recipe-video-content-url'] ) && ! empty( $value['recipe-video-content-url'] ) ) {
							$schema['video'][ $key ]['contentUrl'] = $value['recipe-video-content-url'];
					}
					if ( isset( $value['recipe-video-embed-url'] ) && ! empty( $value['recipe-video-embed-url'] ) ) {
							$schema['video'][ $key ]['embedUrl'] = $value['recipe-video-embed-url'];
					}
					if ( isset( $value['recipe-video-duration'] ) && ! empty( $value['recipe-video-duration'] ) ) {
							$schema['video'][ $key ]['duration'] = $value['recipe-video-duration'];
					}
					if ( isset( $value['recipe-video-upload-date'] ) && ! empty( $value['recipe-video-upload-date'] ) ) {
							$schema['video'][ $key ]['uploadDate'] = $value['recipe-video-upload-date'];
					}
					if ( isset( $value['recipe-video-interaction-count'] ) && ! empty( $value['recipe-video-interaction-count'] ) ) {
							$schema['video'][ $key ]['interactionCount'] = $value['recipe-video-interaction-count'];
					}
					if ( isset( $value['recipe-video-expires-date'] ) && ! empty( $value['recipe-video-expires-date'] ) ) {
							$schema['video'][ $key ]['expires'] = $value['recipe-video-expires-date'];
					}
				}
			}

			return apply_filters( 'wp_schema_pro_schema_recipe', $schema, $data, $post );
		}

	}
}
