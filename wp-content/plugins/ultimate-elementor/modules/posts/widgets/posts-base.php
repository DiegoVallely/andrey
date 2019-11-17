<?php
/**
 * UAEL Posts Abstract Base Class.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Posts\Widgets;

use Elementor\Controls_Manager;
use UltimateElementor\Base\Common_Widget;

use UltimateElementor\Classes\UAEL_Posts_Helper;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Posts_Base
 */
abstract class Posts_Base extends Common_Widget {

	/**
	 * Query object
	 *
	 * @since 1.7.0
	 * @var object $query
	 */
	protected $query = null;

	/**
	 * Query object
	 *
	 * @since 1.7.0
	 * @var boolean $_has_template_content
	 */
	protected $_has_template_content = false;

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.7.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		return [
			'imagesloaded',
			'jquery-slick',
			'uael-isotope',
			'uael-posts',
			'uael-element-resize',
		];
	}

	/**
	 * Render current query.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	public function get_query() {

		return $this->query;
	}

	/**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	public function render() {}

	/**
	 * Set current query.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	abstract public function query_posts();

	/**
	 * Register controls.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Skin', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->end_controls_section();

		$this->register_content_query_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Posts Query Controls.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function register_content_query_controls() {

		$this->start_controls_section(
			'section_filter_field',
			[
				'label' => __( 'Query', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'query_type',
				[
					'label'       => __( 'Query Type', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'custom',
					'label_block' => true,
					'options'     => [
						'main'   => __( 'Main Query', 'uael' ),
						'custom' => __( 'Custom Query', 'uael' ),
					],
				]
			);

			$post_types = UAEL_Posts_Helper::get_post_types();

			$this->add_control(
				'post_type_filter',
				[
					'label'       => __( 'Post Type', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'post',
					'label_block' => true,
					'options'     => $post_types,
					'separator'   => 'after',
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

		foreach ( $post_types as $key => $type ) {

			// Get all the taxanomies associated with the post type.
			$taxonomy = UAEL_Posts_Helper::get_taxonomy( $key );

			if ( ! empty( $taxonomy ) ) {

				// Get all taxonomy values under the taxonomy.
				foreach ( $taxonomy as $index => $tax ) {

					$terms = get_terms( $index );

					$related_tax = [];

					if ( ! empty( $terms ) ) {

						foreach ( $terms as $t_index => $t_obj ) {

							$related_tax[ $t_obj->slug ] = $t_obj->name;
						}
						$this->add_control(
							$index . '_' . $key . '_filter_rule',
							[
								/* translators: %s Label */
								'label'       => sprintf( __( '%s Filter Rule', 'uael' ), $tax->label ),
								'type'        => Controls_Manager::SELECT,
								'default'     => 'IN',
								'label_block' => true,
								'options'     => [
									/* translators: %s label */
									'IN'     => sprintf( __( 'Match %s', 'uael' ), $tax->label ),
									/* translators: %s label */
									'NOT IN' => sprintf( __( 'Exclude %s', 'uael' ), $tax->label ),
								],
								'condition'   => [
									'post_type_filter' => $key,
									'query_type'       => 'custom',
								],
							]
						);

						// Add control for all taxonomies.
						$this->add_control(
							'tax_' . $index . '_' . $key . '_filter',
							[
								/* translators: %s label */
								'label'       => sprintf( __( '%s Filter', 'uael' ), $tax->label ),
								'type'        => Controls_Manager::SELECT2,
								'multiple'    => true,
								'default'     => '',
								'label_block' => true,
								'options'     => $related_tax,
								'condition'   => [
									'post_type_filter' => $key,
									'query_type'       => 'custom',
								],
								'separator'   => 'after',
							]
						);

					}
				}
			}
		}
			$this->add_control(
				'author_filter_rule',
				[
					'label'       => __( 'Author Filter Rule', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'author__in',
					'label_block' => true,
					'options'     => [
						'author__in'     => __( 'Match Author', 'uael' ),
						'author__not_in' => __( 'Exclude Author', 'uael' ),
					],
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'author_filter',
				[
					'label'       => __( 'Author Filter', 'uael' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'default'     => '',
					'label_block' => true,
					'options'     => UAEL_Posts_Helper::get_users(),
					'separator'   => 'after',
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'post_filter_rule',
				[
					'label'       => __( 'Post Filter Rule', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'post__in',
					'label_block' => true,
					'options'     => [
						'post__in'     => __( 'Match Posts', 'uael' ),
						'post__not_in' => __( 'Exclude Posts', 'uael' ),
					],
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'post_filter',
				[
					'label'       => __( 'Post Filter', 'uael' ),
					'type'        => 'uael-query-posts',
					'post_type'   => 'all',
					'multiple'    => true,
					'label_block' => true,
					'separator'   => 'after',
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'ignore_sticky_posts',
				[
					'label'        => __( 'Ignore Sticky Posts', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'offset',
				[
					'label'       => __( 'Offset', 'uael' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 0,
					'description' => __( 'Use this setting to exclude number of initial posts from being display.', 'uael' ),
					'condition'   => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'query_exclude_current',
				[
					'label'        => __( 'Exclude Current Post', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => '',
					'description'  => __( 'Enable this option to remove current post from the query.', 'uael' ),
					'condition'    => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'orderby_heading',
				[
					'label'     => __( 'Post Order', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'query_type' => 'custom',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'orderby',
				[
					'label'     => __( 'Order by', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'date',
					'options'   => [
						'date'       => __( 'Date', 'uael' ),
						'title'      => __( 'Title', 'uael' ),
						'rand'       => __( 'Random', 'uael' ),
						'menu_order' => __( 'Menu Order', 'uael' ),
					],
					'condition' => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'order',
				[
					'label'     => __( 'Order', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'desc',
					'options'   => [
						'desc' => __( 'Descending', 'uael' ),
						'asc'  => __( 'Ascending', 'uael' ),
					],
					'condition' => [
						'query_type' => 'custom',
					],
				]
			);

			$this->add_control(
				'noposts_heading',
				[
					'label'     => __( 'If Posts Not Found', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'no_results_text',
				[
					'label'       => __( 'Display Message', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'default'     => __( 'Sorry, we couldn\'t find any posts. Please try a different search.', 'uael' ),
				]
			);

			$this->add_control(
				'show_search_box',
				[
					'label'        => __( 'Display Search Box', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'description'  => __( 'Enable this setting to display search box if posts not found in your query.', 'uael' ),
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.7.0
	 * @access protected
	 */
	protected function register_helpful_information() {

		if ( parent::is_internal_links() ) {
			$this->start_controls_section(
				'section_helpful_info',
				[
					'label' => __( 'Helpful Information', 'uael' ),
				]
			);

			$this->add_control(
				'help_doc_0',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/posts-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=8fu8W4quFg0&index=20&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How query builder works for post? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-query-builder-works-for-posts-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Enable infinite load pagination » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-enable-infinite-load-pagination-for-posts/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Filters/Actions » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/filters-actions-for-posts-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Using filterable tabs » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/filterable-tabs-for-posts-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Layouts in Post » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/layouts-for-posts-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}
}
