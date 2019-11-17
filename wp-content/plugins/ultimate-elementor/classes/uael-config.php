<?php
/**
 * UAEL Config.
 *
 * @package UAEL
 */

namespace UltimateElementor\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use UltimateElementor\Classes\UAEL_Helper;

/**
 * Class UAEL_Config.
 */
class UAEL_Config {


	/**
	 * Widget List
	 *
	 * @var widget_list
	 */
	public static $widget_list = null;

	/**
	 * Get Widget List.
	 *
	 * @since 0.0.1
	 *
	 * @return array The Widget List.
	 */
	public static function get_widget_list() {
		if ( null === self::$widget_list ) {
			self::$widget_list = array(
				'Advanced_Heading' => array(
					'slug'      => 'uael-advanced-heading',
					'title'     => __( 'Advanced Heading', 'uael' ),
					'keywords'  => [ 'uael', 'heading', 'advanced' ],
					'icon'      => 'uael-icon-adv-heading',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/advanced-heading/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'BaSlider'         => array(
					'slug'      => 'uael-ba-slider',
					'title'     => __( 'Before After Slider', 'uael' ),
					'keywords'  => [ 'uael', 'slider', 'before', 'after' ],
					'icon'      => 'uael-icon-before-after',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/before-after-slider/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin',
				),
				'Business_Hours'   => array(
					'slug'      => 'uael-business-hours',
					'title'     => __( 'Business Hours', 'uael' ),
					'keywords'  => [ 'uael', 'business', 'hours', 'schedule' ],
					'icon'      => 'uael-icon-business-hours',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/business-hours/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'CfStyler'         => array(
					'slug'      => 'uael-cf7-styler',
					'title'     => __( 'Contact Form 7 Styler', 'uael' ),
					'keywords'  => [ 'uael', 'form', 'cf7', 'contact', 'styler' ],
					'icon'      => 'uael-icon-cf7-form',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/contact-form-7-styler/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'ContentToggle'    => array(
					'slug'      => 'uael-content-toggle',
					'title'     => __( 'Content Toggle', 'uael' ),
					'keywords'  => [ 'uael', 'toggle', 'content', 'show', 'hide' ],
					'icon'      => 'uael-icon-content-toggle',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/content-toggle/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Dual_Heading'     => array(
					'slug'      => 'uael-dual-color-heading',
					'title'     => __( 'Dual Color Heading', 'uael' ),
					'keywords'  => [ 'uael', 'dual', 'heading', 'color' ],
					'icon'      => 'uael-icon-dual-col',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/dual-color-heading/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin',
				),
				'Fancy_Heading'    => array(
					'slug'      => 'uael-fancy-heading',
					'title'     => __( 'Fancy Heading', 'uael' ),
					'keywords'  => [ 'uael', 'fancy', 'heading', 'ticking', 'animate' ],
					'icon'      => 'uael-icon-fancy-text',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/fancy-heading/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'GoogleMap'        => array(
					'slug'         => 'uael-google-map',
					'title'        => __( 'Google Map', 'uael' ),
					'keywords'     => [ 'uael', 'google', 'map', 'location', 'address' ],
					'icon'         => 'uael-icon-google-map',
					'title_url'    => '#',
					'default'      => true,
					'setting_url'  => admin_url( 'options-general.php?page=' . UAEL_SLUG . '&action=integration' ),
					'setting_text' => __( 'Settings', 'uael' ),
					'doc_url'      => 'https://uaelementor.com/docs-category/widgets/google-maps/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'GfStyler'         => array(
					'slug'      => 'uael-gf-styler',
					'title'     => __( 'Gravity Form Styler', 'uael' ),
					'keywords'  => [ 'uael', 'form', 'gravity', 'gf', 'styler' ],
					'icon'      => 'uael-icon-gravity-form',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/gravity-form-styler/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Image_Gallery'    => array(
					'slug'      => 'uael-image-gallery',
					'title'     => __( 'Image Gallery', 'uael' ),
					'keywords'  => [ 'uael', 'image', 'gallery', 'carousel', 'slider', 'layout' ],
					'icon'      => 'uael-icon-img-gallery',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/image-gallery/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Infobox'          => array(
					'slug'      => 'uael-infobox',
					'title'     => __( 'Info Box', 'uael' ),
					'keywords'  => [ 'uael', 'info', 'box', 'bar' ],
					'icon'      => 'uael-icon-info-box',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/info-box/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Modal_Popup'      => array(
					'slug'      => 'uael-modal-popup',
					'title'     => __( 'Modal Popup', 'uael' ),
					'keywords'  => [ 'uael', 'modal', 'popup', 'lighbox' ],
					'icon'      => 'uael-icon-popup',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/modal-popup/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'CafStyler'        => array(
					'slug'      => 'uael-caf-styler',
					'title'     => __( 'Caldera Form Styler', 'uael' ),
					'keywords'  => [ 'uael', 'caldera', 'form', 'styler' ],
					'icon'      => 'uael-icon-caldera-form',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/caldera-form-styler/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Buttons'          => array(
					'slug'      => 'uael-buttons',
					'title'     => __( 'Multi Buttons', 'uael' ),
					'keywords'  => [ 'uael', 'buttons', 'multi', 'call to action', 'cta' ],
					'icon'      => 'uael-icon-button',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/multi-buttons/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Price_Table'      => array(
					'slug'      => 'uael-price-table',
					'title'     => __( 'Price Box', 'uael' ),
					'keywords'  => [ 'uael', 'price', 'table', 'box', 'pricing' ],
					'icon'      => 'uael-icon-price-table',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/price-box/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Price_List'       => array(
					'slug'      => 'uael-price-list',
					'title'     => __( 'Price List', 'uael' ),
					'keywords'  => [ 'uael', 'price', 'list', 'pricing' ],
					'icon'      => 'uael-icon-price-list',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/price-list/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Table'            => array(
					'slug'      => 'uael-table',
					'title'     => __( 'Table', 'uael' ),
					'keywords'  => [ 'uael', 'table', 'sort', 'search' ],
					'icon'      => 'uael-icon-table',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/table/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Woo_Add_To_Cart'  => array(
					'slug'      => 'uael-woo-add-to-cart',
					'title'     => __( 'Woo - Add To Cart', 'uael' ),
					'keywords'  => [ 'uael', 'woo', 'cart', 'add to cart', 'products' ],
					'icon'      => 'uael-icon-woo-cart',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/woo-add-to-cart/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Woo_Categories'   => array(
					'slug'      => 'uael-woo-categories',
					'title'     => __( 'Woo - Categories', 'uael' ),
					'keywords'  => [ 'uael', 'woo', 'categories', 'taxomonies', 'products' ],
					'icon'      => 'uael-icon-woo-cat',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/woo-categories/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Woo_Products'     => array(
					'slug'      => 'uael-woo-products',
					'title'     => __( 'Woo - Products', 'uael' ),
					'keywords'  => [ 'uael', 'woo', 'products' ],
					'icon'      => 'uael-icon-woo-grid',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/woo-products/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Hotspot'          => array(
					'slug'      => 'uael-hotspot',
					'title'     => __( 'Hotspot', 'uael' ),
					'keywords'  => [ 'uael', 'hotspot', 'tour' ],
					'icon'      => 'uael-icon-hotspot',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/hotspot/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Posts'            => array(
					'slug'      => 'uael-posts',
					'title'     => __( 'Posts', 'uael' ),
					'keywords'  => [ 'uael', 'post', 'grid', 'masonry', 'carousel', 'content grid', 'content' ],
					'icon'      => 'uael-icon-post-grid',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/posts/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Timeline'         => array(
					'slug'      => 'uael-timeline',
					'title'     => __( 'Timeline', 'uael' ),
					'keywords'  => [ 'uael', 'timeline', 'history', 'scroll', 'post', 'content timeline' ],
					'icon'      => 'uael-icon-timeline',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/timeline/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Video_Gallery'    => array(
					'slug'      => 'uael-video-gallery',
					'title'     => __( 'Video Gallery', 'uael' ),
					'keywords'  => [ 'uael', 'video', 'youtube', 'gallery', 'vimeo' ],
					'icon'      => 'uael-icon-video-gallery',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/video-gallery/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Video'            => array(
					'slug'      => 'uael-video',
					'title'     => __( 'Video', 'uael' ),
					'keywords'  => [ 'uael', 'video', 'youtube', 'vimeo', 'sticky', 'drag', 'float', 'subscribe' ],
					'icon'      => 'uael-icon-video',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/video/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Countdown'        => array(
					'slug'      => 'uael-countdown',
					'title'     => __( 'Countdown Timer', 'uael' ),
					'keywords'  => [ 'uael', 'count', 'timer', 'countdown' ],
					'icon'      => 'uael-icon-timer',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/countdown-timer/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Business_Reviews' => array(
					'slug'         => 'uael-business-reviews',
					'keywords'     => [ 'uael', 'reviews', 'wp reviews', 'business', 'wp business', 'google', 'rating', 'social', 'yelp' ],
					'title'        => __( 'Business Reviews', 'uael' ),
					'icon'         => 'uael-icon-business-reviews',
					'title_url'    => '#',
					'default'      => true,
					'doc_url'      => 'https://uaelementor.com/docs-category/widgets/business-reviews/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
					'setting_url'  => admin_url( 'options-general.php?page=' . UAEL_SLUG . '&action=integration' ),
					'setting_text' => __( 'Settings', 'uael' ),
				),
				'Offcanvas'        => array(
					'slug'      => 'uael-offcanvas',
					'title'     => __( 'Off - Canvas', 'uael' ),
					'keywords'  => [ 'uael', 'off', 'offcanvas', 'off-canvas', 'canvas', 'template', 'floating' ],
					'icon'      => 'uael-icon-off-canvas',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/off-canvas/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Marketing_Button' => array(
					'slug'      => 'uael-marketing-button',
					'title'     => __( 'Marketing Button', 'uael' ),
					'keywords'  => [ 'uael', 'button', 'marketing', 'call to action', 'cta' ],
					'icon'      => 'uael-icon-marketing-button',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/marketing-button/?utm_source=uael-pro-dashboard&utm_medium=uael-menu-page&utm_campaign=uael-pro-plugin',
				),
				'Particles'        => array(
					'slug'      => 'uael-particles',
					'title'     => __( 'Particle Backgrounds', 'uael' ),
					'keywords'  => [],
					'icon'      => '',
					'title_url' => '#',
					'default'   => true,
					'doc_url'   => 'https://uaelementor.com/docs-category/widgets/particles-background-extension/',
				),
			);
		}

		return self::$widget_list;
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since 0.0.1
	 */
	public static function get_widget_script() {
		$folder = UAEL_Helper::get_js_folder();
		$suffix = UAEL_Helper::get_js_suffix();

		$js_files = array(
			'uael-frontend-script'  => array(
				'path'      => 'assets/' . $folder . '/uael-frontend' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-cookie-lib'       => array(
				'path'      => 'assets/' . $folder . '/js_cookie' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-modal-popup'      => array(
				'path'      => 'assets/' . $folder . '/uael-modal-popup' . $suffix . '.js',
				'dep'       => [ 'jquery', 'uael-cookie-lib' ],
				'in_footer' => true,
			),
			'uael-offcanvas'        => array(
				'path'      => 'assets/' . $folder . '/uael-offcanvas' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-twenty-twenty'    => array(
				'path'      => 'assets/' . $folder . '/jquery_twentytwenty' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-move'             => array(
				'path'      => 'assets/' . $folder . '/jquery_event_move' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-fancytext-typed'  => array(
				'path'      => 'assets/' . $folder . '/typed' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-fancytext-slidev' => array(
				'path'      => 'assets/' . $folder . '/rvticker' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-google-maps'      => array(
				'path'      => 'assets/' . $folder . '/uael-google-map' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-hotspot'          => array(
				'path'      => 'assets/' . $folder . '/tooltipster' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-posts'            => array(
				'path'      => 'assets/' . $folder . '/uael-posts' . $suffix . '.js',
				'dep'       => [ 'jquery', 'imagesloaded' ],
				'in_footer' => true,
			),
			'uael-business-reviews' => array(
				'path'      => 'assets/' . $folder . '/uael-business-reviews' . $suffix . '.js',
				'dep'       => [ 'jquery', 'imagesloaded' ],
				'in_footer' => true,
			),
			'uael-isotope'          => array(
				'path'      => 'assets/js/isotope.pkgd.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-woocommerce'      => array(
				'path'      => 'assets/' . $folder . '/uael-woocommerce' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-datatable'        => array(
				'path'      => 'assets/js/jquery.datatables.min.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-table'            => array(
				'path'      => 'assets/' . $folder . '/uael-table' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-particles'        => array(
				'path'      => 'assets/' . $folder . '/uael-particles' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			/* Libraries */
			'uael-element-resize'   => array(
				'path'      => 'assets/lib/jquery-element-resize/jquery_resize.min.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-isotope'          => array(
				'path'      => 'assets/lib/isotope/isotope.min.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-infinitescroll'   => array(
				'path'      => 'assets/lib/infinitescroll/jquery.infinitescroll.min.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-fancybox'         => array(
				'path'      => 'assets/lib/fancybox/jquery_fancybox.min.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
			'uael-justified'        => array(
				'path'      => 'assets/lib/justifiedgallery/justifiedgallery.min.js',
				'dep'       => [ 'jquery', 'uael-frontend-script' ],
				'in_footer' => true,
			),
			'uael-countdown'        => array(
				'path'      => 'assets/' . $folder . '/uael-countdown' . $suffix . '.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			),
		);

		return $js_files;
	}

	/**
	 * Returns Style array.
	 *
	 * @return array()
	 * @since 0.0.1
	 */
	public static function get_widget_style() {
		$folder = UAEL_Helper::get_css_folder();
		$suffix = UAEL_Helper::get_css_suffix();

		if ( UAEL_Helper::is_script_debug() ) {
			$css_files = array(
				'uael-info-box'         => array(
					'path' => 'assets/css/modules/info-box.css',
					'dep'  => [],
				),
				'uael-heading'          => array(
					'path' => 'assets/css/modules/heading.css',
					'dep'  => [],
				),
				'uael-ba-slider'        => array(
					'path' => 'assets/css/modules/ba-slider.css',
					'dep'  => [],
				),
				'uael-buttons'          => array(
					'path' => 'assets/css/modules/buttons.css',
					'dep'  => [],
				),
				'uael-modal-popup'      => array(
					'path' => 'assets/css/modules/modal-popup.css',
					'dep'  => [],
				),
				'uael-offcanvas'        => array(
					'path' => 'assets/css/modules/offcanvas.css',
					'dep'  => [],
				),
				'uael-content-toggle'   => array(
					'path' => 'assets/css/modules/content-toggle.css',
					'dep'  => [],
				),
				'uael-caf-styler'       => array(
					'path' => 'assets/css/modules/caf-styler.css',
					'dep'  => [],
				),
				'uael-business-hours'   => array(
					'path' => 'assets/css/modules/business-hours.css',
					'dep'  => [],
				),
				'uael-cf7-styler'       => array(
					'path' => 'assets/css/modules/cf-styler.css',
					'dep'  => [],
				),
				'uael-gf-styler'        => array(
					'path' => 'assets/css/modules/gform-styler.css',
					'dep'  => [],
				),
				'uael-hotspot'          => array(
					'path' => 'assets/css/modules/hotspot.css',
					'dep'  => [],
				),
				'uael-post'             => array(
					'path' => 'assets/css/modules/post.css',
					'dep'  => [],
				),
				'uael-post-card'        => array(
					'path' => 'assets/css/modules/post-card.css',
					'dep'  => [],
				),
				'uael-post-event'       => array(
					'path' => 'assets/css/modules/post-event.css',
					'dep'  => [],
				),
				'uael-post-feed'        => array(
					'path' => 'assets/css/modules/post-feed.css',
					'dep'  => [],
				),
				'uael-post-news'        => array(
					'path' => 'assets/css/modules/post-news.css',
					'dep'  => [],
				),
				'uael-post-carousel'    => array(
					'path' => 'assets/css/modules/post-carousel.css',
					'dep'  => [],
				),
				'uael-post-business'    => array(
					'path' => 'assets/css/modules/post-business.css',
					'dep'  => [],
				),
				'uael-video-gallery'    => array(
					'path' => 'assets/css/modules/video-gallery.css',
					'dep'  => [],
				),
				'uael-fancybox'         => array(
					'path' => 'assets/css/modules/jquery.fancybox.min.css',
					'dep'  => [],
				),
				'uael-price-list'       => array(
					'path' => 'assets/css/modules/price-list.css',
					'dep'  => [],
				),
				'uael-price-table'      => array(
					'path' => 'assets/css/modules/price-table.css',
					'dep'  => [],
				),
				'uael-table'            => array(
					'path' => 'assets/css/modules/table.css',
					'dep'  => [],
				),
				'uael-image-gallery'    => array(
					'path' => 'assets/css/modules/image-gallery.css',
					'dep'  => [],
				),
				'uael-common'           => array(
					'path' => 'assets/css/modules/common.css',
					'dep'  => [],
				),
				'uael-timeline'         => array(
					'path' => 'assets/css/modules/timeline.css',
					'dep'  => [],
				),
				'uael-video'            => array(
					'path' => 'assets/css/modules/video.css',
					'dep'  => [],
				),
				'uael-countdown'        => array(
					'path' => 'assets/css/modules/countdown.css',
					'dep'  => [],
				),
				'uael-business-reviews' => array(
					'path' => 'assets/css/modules/business-reviews.css',
					'dep'  => [],
				),
				'uael-particles'        => array(
					'path' => 'assets/css/modules/particles.css',
					'dep'  => [],
				),
				'uael-google-maps'      => array(
					'path' => 'assets/css/modules/google-map.css',
					'dep'  => [],
				),
			);
		} else {
			$css_files = array(
				'uael-frontend' => array(
					'path' => 'assets/min-css/uael-frontend.min.css',
					'dep'  => [],
				),
			);
		}

		if ( is_rtl() ) {
			$css_files = array(
				'uael-frontend' => array(
					// This is autogenerated rtl file.
					'path' => 'assets/min-css/uael-frontend-rtl.min.css',
					'dep'  => [],
				),
			);
		}

		if ( class_exists( 'WooCommerce' ) ) {
			$css_files['uael-woocommerce'] = array(
				'path' => 'assets/' . $folder . '/uael-woocommerce' . $suffix . '.css',
				'dep'  => [],
			);
		}

		return $css_files;
	}
}
