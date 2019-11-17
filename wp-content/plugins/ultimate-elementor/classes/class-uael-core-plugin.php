<?php
/**
 * UAEL Core Plugin.
 *
 * @package UAEL
 */

namespace UltimateElementor;

use UltimateElementor\Classes\UAEL_Helper;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * UAEL_Core_Plugin.
 *
 * @package UAEL
 */
class UAEL_Core_Plugin {

	/**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 * Member Variable
	 *
	 * @var Modules Manager
	 */
	public $modules_manager;

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

		spl_autoload_register( array( $this, 'autoload' ) );

		$this->includes();

		$this->setup_actions_filters();
	}

	/**
	 * AutoLoad
	 *
	 * @since 0.0.1
	 * @param string $class class.
	 */
	public function autoload( $class ) {

		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$class_to_load = $class;

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);
			$filename = UAEL_DIR . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}
	}

	/**
	 * Includes.
	 *
	 * @since 0.0.1
	 */
	private function includes() {

		require UAEL_DIR . 'classes/class-uael-admin.php';
		require UAEL_DIR . 'includes/manager/modules-manager.php';

		if ( UAEL_Helper::is_widget_active( 'Image_Gallery' ) ) {
			require UAEL_DIR . 'classes/class-uael-attachment.php';
		}
	}

	/**
	 * Setup Actions Filters.
	 *
	 * @since 0.0.1
	 */
	private function setup_actions_filters() {

		add_shortcode( 'uael-template', array( $this, 'uael_template_shortcode' ) );

		add_action( 'elementor/init', array( $this, 'elementor_init' ) );

		add_action( 'elementor/elements/categories_registered', array( $this, 'widget_category' ) );

		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );

		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_widget_styles' ) );

	}

	/**
	 * Elementor Template Shortcode.
	 *
	 * @param array $atts Shortcode Attributes.
	 * @since 0.0.1
	 */
	public function uael_template_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'uael-template'
		);

		if ( '' !== $atts['id'] ) {

			return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $atts['id'] );
		}

	}

	/**
	 * Elementor Init.
	 *
	 * @since 0.0.1
	 */
	public function elementor_init() {

		$this->modules_manager = new Module_Manager();

		$this->init_category();

		do_action( 'ultimate_elementor/init' );

		/* Wpml Compatibility */
		require UAEL_DIR . 'compatibility/class-uael-wpml.php';
	}

	/**
	 * Sections init
	 *
	 * @since 0.0.1
	 * @param object $this_cat class.
	 */
	public function widget_category( $this_cat ) {
		$branding = UAEL_Helper::get_white_labels();
		$category = ( isset( $branding['plugin']['short_name'] ) && '' != $branding['plugin']['short_name'] ) ? $branding['plugin']['short_name'] . ' Elements' : UAEL_CATEGORY;

		$this_cat->add_category(
			'ultimate-elements',
			[
				'title' => $category,
				'icon'  => 'eicon-font',
			]
		);

		return $this_cat;
	}


	/**
	 * Sections init
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 */
	private function init_category() {

		if ( version_compare( ELEMENTOR_VERSION, '2.0.0' ) < 0 ) {
			$branding = UAEL_Helper::get_white_labels();
			$category = ( isset( $branding['plugin']['short_name'] ) && '' != $branding['plugin']['short_name'] ) ? $branding['plugin']['short_name'] . ' Elements' : UAEL_CATEGORY;

			\Elementor\Plugin::instance()->elements_manager->add_category(
				'ultimate-elements',
				[
					'title' => $category,
				],
				1
			);
		}
	}

	/**
	 * Register module required js on elementor's action.
	 *
	 * @since 0.0.1
	 */
	function register_widget_scripts() {

		$js_files    = UAEL_Helper::get_widget_script();
		$map_options = UAEL_Helper::get_integrations_options();
		$language    = '';
		$api_url     = 'https://maps.googleapis.com';
		if ( isset( $map_options['language'] ) && '' != $map_options['language'] ) {
			$language = 'language=' . $map_options['language'];

			// This checks for Chinese language.
			// The Maps JavaScript API is served within China from http://maps.google.cn.
			if (
				'zh-CN' == $map_options['language'] ||
				'zh-TW' == $map_options['language']
			) {
				$api_url = 'http://maps.googleapis.cn';
			}
		}

		if ( isset( $map_options['google_api'] ) && '' != $map_options['google_api'] ) {

			$language = '&' . $language;
			$url      = $api_url . '/maps/api/js?key=' . $map_options['google_api'] . $language;
		} else {

			$url = $api_url . '/maps/api/js?' . $language;
		}

		wp_localize_script(
			'jquery',
			'uael_script',
			array(
				'post_loader'         => UAEL_URL . 'assets/img/post-loader.gif',
				'url'                 => admin_url( 'admin-ajax.php' ),
				'search_str'          => __( 'Search:', 'uael' ),
				'table_length_string' => __( 'Show _MENU_ Entries', 'uael' ),
				'uael_particles_url'  => UAEL_URL . 'assets/min-js/uael-particles.min.js',
				'particles_url'       => UAEL_URL . 'assets/lib/particles/particles.min.js',
			)
		);

		wp_register_script( 'uael-google-maps-api', $url, [ 'jquery' ], UAEL_VER, true );

		wp_register_script( 'uael-google-maps-cluster', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', [ 'jquery' ], UAEL_VER, true );

		wp_register_script( 'uael-video-subscribe', 'https://apis.google.com/js/platform.js', [ 'jquery' ], UAEL_VER, true );

		foreach ( $js_files as $handle => $data ) {

			wp_register_script( $handle, UAEL_URL . $data['path'], $data['dep'], UAEL_VER, $data['in_footer'] );
		}

		$uael_localize = apply_filters(
			'uael_js_localize',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);
		wp_localize_script( 'jquery', 'uael', $uael_localize );
	}

	/**

	 * Enqueue module required styles.
	 *
	 * @since 0.0.1
	 */
	function enqueue_widget_styles() {

		$css_files = UAEL_Helper::get_widget_style();

		if ( ! empty( $css_files ) ) {
			foreach ( $css_files as $handle => $data ) {

				wp_register_style( $handle, UAEL_URL . $data['path'], $data['dep'], UAEL_VER );
				wp_enqueue_style( $handle );
			}
		}

		if ( class_exists( 'Caldera_Forms_Render_Assets' ) && class_exists( 'Caldera_Forms' ) ) {
			\Caldera_Forms_Render_Assets::maybe_register();
			\Caldera_Forms_Render_Assets::optional_style_includes();
			\Caldera_Forms_Render_Assets::enqueue_style( 'front' );
			\Caldera_Forms_Render_Assets::enqueue_style( 'fields' );

			foreach ( \Caldera_Forms_Fields::get_all() as $field_type ) {
				if ( ! empty( $field_types['styles'] ) ) {
					foreach ( $field_types['styles'] as $style ) {
						\Caldera_Forms_Render_Assets::enqueue_style( $style );
					}
				}
			}
		}

		if ( class_exists( 'GFCommon' ) ) {

			$gf_forms = \RGFormsModel::get_forms( null, 'title' );

			foreach ( $gf_forms as $form ) {

				if ( '0' != $form->id ) {
					wp_enqueue_script( 'gform_gravityforms' );
					gravity_form_enqueue_scripts( $form->id );
				}
			};
		}
	}
}

/**
 *  Prepare if class 'UAEL_Core_Plugin' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
UAEL_Core_Plugin::get_instance();
