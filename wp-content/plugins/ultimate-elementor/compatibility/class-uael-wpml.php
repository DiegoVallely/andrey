<?php
/**
 * UAEL WPML compatibility.
 *
 * @package UAEL
 */

namespace UltimateElementor\Compatibility;

/**
 * Class UAEL_Wpml.
 */
class UAEL_Wpml {

	/**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {

		// WPML String Translation plugin exist check.
		if ( is_wpml_string_translation_active() ) {

			$this->includes();

			add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'translatable_widgets' ] );
		}
	}

	/**
	 * Integrations class for complex widgets.
	 *
	 * @since 1.2.0
	 */
	public function includes() {

		include_once( 'modules/buttons.php' );
		include_once( 'modules/table.php' );
		include_once( 'modules/google-map.php' );
		include_once( 'modules/price-list.php' );
		include_once( 'modules/business-hours.php' );
		include_once( 'modules/price-table.php' );
		include_once( 'modules/video-gallery.php' );
		include_once( 'modules/timeline.php' );
		include_once( 'modules/hotspot.php' );
	}

	/**
	 * Widgets to translate.
	 *
	 * @since 1.2.0
	 * @param array $widgets Widget array.
	 * @return array
	 */
	function translatable_widgets( $widgets ) {

		$widgets['uael-advanced-heading'] = [
			'conditions' => [ 'widgetType' => 'uael-advanced-heading' ],
			'fields'     => [
				[
					'field'       => 'heading_title',
					'type'        => __( ' Advanced Heading : Heading', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'heading_description',
					'type'        => __( 'Advanced Heading : Description', 'uael' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'heading_line_text',
					'type'        => __( 'Advanced Heading : Separator Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				'heading_link'       => [
					'field'       => 'url',
					'type'        => __( 'Advanced Heading : Text Link', 'uael' ),
					'editor_type' => 'LINK',
				],
				'heading_image_link' => [
					'field'       => 'url',
					'type'        => __( 'Advanced Heading : Photo URL', 'uael' ),
					'editor_type' => 'LINK',
				],
			],
		];

		$widgets['uael-dual-color-heading'] = [
			'conditions' => [ 'widgetType' => 'uael-dual-color-heading' ],
			'fields'     => [
				[
					'field'       => 'before_heading_text',
					'type'        => __( 'Dual Color Heading : Before Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'second_heading_text',
					'type'        => __( 'Dual Color Heading : Highlighted Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_heading_text',
					'type'        => __( 'Dual Color Heading : After Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				'heading_link' => [
					'field'       => 'url',
					'type'        => __( 'Dual Color Heading : Link', 'uael' ),
					'editor_type' => 'LINK',
				],
			],
		];

		$widgets['uael-fancy-heading'] = [
			'conditions' => [ 'widgetType' => 'uael-fancy-heading' ],
			'fields'     => [
				[
					'field'       => 'fancytext_prefix',
					'type'        => __( 'Fancy Heading : Before Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'fancytext',
					'type'        => __( 'Fancy Heading : Fancy Text', 'uael' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'fancytext_suffix',
					'type'        => __( 'Fancy Heading : After Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-ba-slider'] = [
			'conditions' => [ 'widgetType' => 'uael-ba-slider' ],
			'fields'     => [
				[
					'field'       => 'before_text',
					'type'        => __( 'Before After Slider : Before Label', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_text',
					'type'        => __( 'Before After Slider : After Label', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-content-toggle'] = [
			'conditions' => [ 'widgetType' => 'uael-content-toggle' ],
			'fields'     => [
				[
					'field'       => 'rbs_section_heading_1',
					'type'        => __( 'Content Toggle : Heading 1', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'section_content_1',
					'type'        => __( 'Content Toggle : Description 1', 'uael' ),
					'editor_type' => 'VISUAL',
				],
				[
					'field'       => 'rbs_section_heading_2',
					'type'        => __( 'Content Toggle : Heading 2', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'section_content_2',
					'type'        => __( 'Content Toggle : Description 2', 'uael' ),
					'editor_type' => 'VISUAL',
				],
			],
		];

		$widgets['uael-modal-popup'] = [
			'conditions' => [ 'widgetType' => 'uael-modal-popup' ],
			'fields'     => [
				[
					'field'       => 'title',
					'type'        => __( 'Modal Popup : Modal Title', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ct_content',
					'type'        => __( 'Modal Popup : Modal Description', 'uael' ),
					'editor_type' => 'VISUAL',
				],
				[
					'field'       => 'modal_text',
					'type'        => __( 'Modal Popup : Display on Text - Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'btn_text',
					'type'        => __( 'Modal Popup : Display on Button - Button Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-infobox'] = [
			'conditions' => [ 'widgetType' => 'uael-infobox' ],
			'fields'     => [
				[
					'field'       => 'infobox_title_prefix',
					'type'        => __( 'Info Box : Title Prefix', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'infobox_title',
					'type'        => __( 'Info Box : Title', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'infobox_description',
					'type'        => __( 'Info Box : Description', 'uael' ),
					'editor_type' => 'VISUAL',
				],
				[
					'field'       => 'infobox_link_text',
					'type'        => __( 'Info Box : CTA Link Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'infobox_button_text',
					'type'        => __( 'Info Box : CTA Button Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				'infobox_text_link'  => [
					'field'       => 'url',
					'type'        => __( 'Info Box : CTA Link', 'uael' ),
					'editor_type' => 'LINK',
				],
				'infobox_image_link' => [
					'field'       => 'url',
					'type'        => __( 'Info Box : Photo URL', 'uael' ),
					'editor_type' => 'LINK',
				],
			],
		];

		$widgets['uael-buttons'] = [
			'conditions'        => [ 'widgetType' => 'uael-buttons' ],
			'fields'            => [],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\Buttons',
		];

		$widgets['uael-table'] = [
			'conditions'        => [ 'widgetType' => 'uael-table' ],
			'fields'            => [],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\Table',
		];

		$widgets['uael-google-map'] = [
			'conditions'        => [ 'widgetType' => 'uael-google-map' ],
			'fields'            => [],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\GoogleMap',
		];

		$widgets['uael-price-list'] = [
			'conditions'        => [ 'widgetType' => 'uael-price-list' ],
			'fields'            => [],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\PriceList',
		];

		$widgets['uael-video-gallery'] = [
			'conditions'        => [ 'widgetType' => 'uael-video-gallery' ],
			'fields'            => [
				[
					'field'       => 'filters_heading_text',
					'type'        => __( ' Video Gallery : Title Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'filters_all_text',
					'type'        => __( ' Video Gallery : "All" Tab Label', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\VideoGallery',
		];

		$widgets['uael-video'] = [
			'conditions' => [ 'widgetType' => 'uael-video' ],
			'fields'     => [
				[
					'field'       => 'sticky_info_bar_text',
					'type'        => __( ' Video : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-price-table'] = [
			'conditions'        => [ 'widgetType' => 'uael-price-table' ],
			'fields'            => [
				[
					'field'       => 'heading',
					'type'        => __( 'Price Table : Title', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'sub_heading',
					'type'        => __( 'Price Table : Description', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'price',
					'type'        => __( 'Price Table : Price', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'original_price',
					'type'        => __( 'Price Table : Original Price', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'duration',
					'type'        => __( 'Price Table : Duration', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'sub_heading_style2',
					'type'        => __( 'Price Table : Description', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'cta_text',
					'type'        => __( 'Price Table : CTA Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'link',
					'type'        => __( 'Price Table : CTA Link', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'footer_additional_info',
					'type'        => __( 'Price Table : Disclaimer Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'ribbon_title',
					'type'        => __( 'Price Table : Ribbon Title', 'uael' ),
					'editor_type' => 'LINE',
				],
				'link' => [
					'field'       => 'url',
					'type'        => __( 'Price Table : Link', 'uael' ),
					'editor_type' => 'LINK',
				],
			],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\PriceTable',
		];

		$widgets['uael-timeline'] = [
			'conditions'        => [ 'widgetType' => 'uael-timeline' ],
			'fields'            => [],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\Timeline',
		];

		$widgets['uael-business-hours'] = [
			'conditions'        => [ 'widgetType' => 'uael-business-hours' ],
			'fields'            => [],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\BusinessHours',
		];

		$widgets['uael-image-gallery'] = [
			'conditions' => [ 'widgetType' => 'uael-image-gallery' ],
			'fields'     => [
				[
					'field'       => 'filters_all_text',
					'type'        => __( 'Image Galley : "All" Tab Label', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-woo-add-to-cart'] = [
			'conditions' => [ 'widgetType' => 'uael-woo-add-to-cart' ],
			'fields'     => [
				[
					'field'       => 'btn_text',
					'type'        => __( 'Woo - Add To Cart : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-posts'] = [
			'conditions' => [ 'widgetType' => 'uael-posts' ],
			'fields'     => [
				[
					'field'       => 'no_results_text',
					'type'        => __( ' Display Message : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'classic_cta_text',
					'type'        => __( 'CTA Text - Classic : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'card_cta_text',
					'type'        => __( 'CTA Text - Card : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'event_cta_text',
					'type'        => __( 'CTA Text - Event : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'feed_cta_text',
					'type'        => __( 'CTA Text - Creative Feeds : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'news_cta_text',
					'type'        => __( 'CTA Text - News : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'business_cta_text',
					'type'        => __( 'CTA Text - Business Card : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'classic_load_more_text',
					'type'        => __( '"Load More" Label - Classic : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'card_load_more_text',
					'type'        => __( '"Load More" Label - Card : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'event_load_more_text',
					'type'        => __( '"Load More" Label - Event : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'feed_load_more_text',
					'type'        => __( '"Load More" Label - Creative Feeds : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'business_load_more_text',
					'type'        => __( '"Load More" Label - Business Card : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'business_writtenby_text',
					'type'        => __( 'Author Info Text - Business Card : Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-hotspot'] = [
			'conditions'        => [ 'widgetType' => 'uael-hotspot' ],
			'fields'            => [
				[
					'field'       => 'overlay_button_text',
					'type'        => __( 'Hotspot : Overlay Button Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => '\UltimateElementor\Compatibility\WPML\Hotspot',
		];

		$widgets['uael-offcanvas'] = [
			'conditions' => [ 'widgetType' => 'uael-offcanvas' ],
			'fields'     => [
				[
					'field'       => 'ct_content',
					'type'        => __( 'Off-Canvas : Content', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'btn_text',
					'type'        => __( 'Off-Canvas : Button Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-business-reviews'] = [
			'conditions' => [ 'widgetType' => 'uael-business-reviews' ],
			'fields'     => [
				[
					'field'       => 'default_read_more',
					'type'        => __( 'Business Reviews - Default : Read More Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'card_read_more',
					'type'        => __( 'Business Reviews - Card : Read More Text', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'bubble_read_more',
					'type'        => __( 'Business Reviews - Bubble : Read More Text', 'uael' ),
					'editor_type' => 'LINE',
				],
			],
		];

		$widgets['uael-countdown'] = [
			'conditions' => [ 'widgetType' => 'uael-countdown' ],
			'fields'     => [
				[
					'field'       => 'message_after_expire',
					'type'        => __( 'Countdown : Message', 'uael' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'custom_days',
					'type'        => __( 'Countdown : Label for Days', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'custom_hours',
					'type'        => __( 'Countdown : Label for Hours', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'custom_minutes',
					'type'        => __( 'Countdown : Label for Minutes', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'custom_seconds',
					'type'        => __( 'Countdown : Label for Seconds', 'uael' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'expire_redirect_url',
					'type'        => __( 'Countdown : Redirect URL', 'uael' ),
					'editor_type' => 'LINK',
				],
			],
		];

		return $widgets;
	}
}

/**
 *  Prepare if class 'UAEL_Wpml' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
UAEL_Wpml::get_instance();
