<?php
/**
 * UAEL Timeline.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Timeline\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use UltimateElementor\Base\Common_Widget;

use UltimateElementor\Classes\UAEL_Posts_Helper;
use UltimateElementor\Modules\Timeline\Widgets\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Timeline.
 */
class Timeline extends Common_Widget {

	/**
	 * Query object
	 *
	 * @since 1.5.2
	 * @var object $query
	 */
	protected $query = null;

	/**
	 * Query object
	 *
	 * @since 1.5.2
	 * @var boolean $_has_template_content
	 */
	protected $_has_template_content = false;

	/**
	 * Render current query.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	public function get_query() {

		return $this->query;
	}

	/**
	 * Retrieve Timeline Widget name.
	 *
	 * @since 1.5.2
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Timeline' );
	}

	/**
	 * Retrieve Timeline Widget title.
	 *
	 * @since 1.5.2
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Timeline' );
	}

	/**
	 * Retrieve Timeline Widget icon.
	 *
	 * @since 1.5.2
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Timeline' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Timeline' );
	}

	/**
	 * Retrieve the list of scripts the Timeline widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.5.2
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-frontend-script', 'uael-infinitescroll' ];
	}

	/**
	 * Register General Content controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function _register_controls() {
		// Content Tab.
		$this->register_general_content_controls();
		$this->register_timeline_content_controls();
		$this->register_content_query_controls();
		$this->register_post_setting_controls();
		$this->register_helpful_information();

		// Style Tab.
		$this->register_cards_layout_controls();
		$this->register_spacing_style_controls();
		$this->register_cards_style_controls();
		$this->register_date_style_controls();
		$this->register_vertical_separator_style_controls();
	}


	/**
	 * Registers all controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_general_content_controls() {
		// Timeline top heading starts from here.
		$this->start_controls_section(
			'section_timeline_top_heading',
			[
				'label' => __( 'General', 'uael' ),
			]
		);

		$this->add_control(
			'timeline_type',
			[
				'label'   => __( 'Content Source', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content' => __( 'Custom', 'uael' ),
					'posts'   => __( 'Posts', 'uael' ),
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'     => __( 'Posts Per Page', 'uael' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '6',
				'condition' => [
					'timeline_type' => 'posts',
				],
			]
		);

		$this->add_control(
			'timeline_infinite',
			[
				'label'        => __( 'Infinite Load', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'timeline_type' => 'posts',
				],
			]
		);

		if ( parent::is_internal_links() ) {

			$this->add_control(
				'help_doc_infinite',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( 'Display all query posts with infinite load pagination. It will display the x number of posts for each load; where x is the value that entered in “Post Per Page” setting.', 'uael' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'timeline_type'     => 'posts',
						'timeline_infinite' => 'yes',
					],
				]
			);
		}

		// Timeline top heading starts from here.
		$this->end_controls_section();
	}

	/**
	 * Register Posts Query Controls.
	 *
	 * @since 1.5.2
	 * @access public
	 */
	public function register_content_query_controls() {

		$this->start_controls_section(
			'section_filter_field',
			[
				'label'     => __( 'Query', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'timeline_type' => 'posts',
				],
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
					'condition'   => [
						'timeline_type' => 'posts',
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
					'condition'   => [
						'query_type'    => 'custom',
						'timeline_type' => 'posts',
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
									'timeline_type'    => 'posts',
								],
								'separator'   => 'before',
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
									'timeline_type'    => 'posts',
								],
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
						'separator'   => 'before',
						'condition'   => [
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
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
						'condition'   => [
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
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
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
						],
						'separator'   => 'before',
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
						'condition'   => [
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
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
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
						],
						'separator'    => 'before',
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
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
						],
					]
				);

				$this->add_control(
					'orderby_heading',
					[
						'label'     => __( 'Post Order', 'uael' ),
						'type'      => Controls_Manager::HEADING,
						'condition' => [
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
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
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
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
							'query_type'    => 'custom',
							'timeline_type' => 'posts',
						],
					]
				);

				$this->add_control(
					'noposts_heading',
					[
						'label'     => __( 'If Posts Not Found', 'uael' ),
						'type'      => Controls_Manager::HEADING,
						'condition' => [
							'timeline_type' => 'posts',
						],
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
						'condition'   => [
							'timeline_type' => 'posts',
						],
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
						'condition'    => [
							'timeline_type' => 'posts',
						],
					]
				);

			$this->end_controls_section();
	}

	/**
	 * Register Posts settings Controls.
	 *
	 * @since 1.5.2
	 * @access public
	 */
	public function register_post_setting_controls() {

		$this->start_controls_section(
			'section_posts_field',
			[
				'label'     => __( 'Posts', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'timeline_type' => 'posts',
				],
			]
		);

			$this->add_control(
				'post_thumbnail',
				[
					'label'        => __( 'Show Image', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'condition'    => [
						'timeline_type' => 'posts',
					],
				]
			);

				$this->add_group_control(
					Group_Control_Image_Size::get_type(),
					[
						'name'      => 'post_image_size',
						'label'     => __( 'Image Size', 'uael' ),
						'default'   => 'full',
						'condition' => [
							'timeline_type'  => 'posts',
							'post_thumbnail' => 'yes',
						],
					]
				);

			$this->add_control(
				'post_title',
				[
					'label'        => __( 'Show Title', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'condition'    => [
						'timeline_type' => 'posts',
					],
				]
			);

			$this->add_control(
				'post_excerpt',
				[
					'label'        => __( 'Show Excerpt', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'condition'    => [
						'timeline_type' => 'posts',
					],
				]
			);
				$this->add_control(
					'excerpt_length',
					[
						'label'     => __( 'Excerpt Length', 'uael' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => '25',
						'condition' => [
							'timeline_type' => 'posts',
							'post_excerpt'  => 'yes',
						],
					]
				);

			$this->add_control(
				'post_timeline_cta_type',
				[
					'label'       => __( 'Link Type', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'module',
					'label_block' => false,
					'options'     => [
						'module' => __( 'Complete Box', 'uael' ),
						'link'   => __( 'Text', 'uael' ),
						'none'   => __( 'None', 'uael' ),
					],
				]
			);

			$this->add_control(
				'post_timeline_link_text',
				[
					'label'     => __( 'Link Text', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => __( 'Read More', 'uael' ),
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'post_timeline_cta_type' => 'link',
					],
				]
			);

			$this->add_control(
				'post_timeline_date_type',
				[
					'label'       => __( 'Date', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'label_block' => false,
					'options'     => [
						''        => __( 'Published Date', 'uael' ),
						'updated' => __( 'Last Modified Date', 'uael' ),
						'custom'  => __( 'Custom', 'uael' ),
					],
				]
			);

			$this->add_control(
				'post_timeline_date_text',
				[
					'label'     => __( 'Custom Meta Key', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => [
						'post_timeline_date_type' => 'custom',
					],
				]
			);
		if ( parent::is_internal_links() ) {

			$this->add_control(
				'help_doc_custom_date',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
					'raw'             => sprintf( __( '<b>For Advanced Users -</b> Display the date/value store in custom meta key of the post. Learn more about this feature %1$s here %2$s.', 'uael' ), '<a href="https://uaelementor.com/docs/display-custom-value-in-posts-date-area/" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'timeline_type'           => 'posts',
						'post_timeline_date_type' => 'custom',
					],
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.5.2
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
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/timeline-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=-FErpbu2F58&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc&index=19" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How query builder works for post timeline? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/query-builder-for-post-timeline/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Enable infinite load pagination for post timeline » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/enable-infinite-load-pagination-for-post-timeline/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Display custom value in post\'s date area » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/display-custom-value-in-posts-date-area/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Styling particular item / icon? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-style-particular-item-icon/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Manage Timeline on responsive view? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/timeline-responsive-view/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_7',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Set on-scroll color for connector line and icon » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/set-on-scroll-color/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Registers all controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_timeline_content_controls() {
		// Timeline repeater section starts.
		$this->start_controls_section(
			'section_timeline',
			[
				'label'     => __( 'Timeline Items', 'uael' ),
				'condition' => [
					'timeline_type' => 'content',
				],
			]
		);

		// Repeater object created.
		$repeater = new Repeater();

		// Repeater section starts.
		$repeater->start_controls_tabs( 'timeline_repeater' );

		// Tab Content starts.
		$repeater->start_controls_tab( 'tab_content', [ 'label' => __( 'Content', 'uael' ) ] );

			// Single date text.
			$repeater->add_control(
				'timeline_single_date',
				[
					'label'     => __( 'Date', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'separator' => 'before',
					'dynamic'   => [
						'active' => true,
					],
				]
			);

			// Single content heading text.
			$repeater->add_control(
				'timeline_single_heading',
				[
					'label'   => __( 'Heading', 'uael' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			// Single content tiny text.
			$repeater->add_control(
				'timeline_single_content',
				[
					'label'   => __( 'Description', 'uael' ),
					'type'    => Controls_Manager::WYSIWYG,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			// Single card link.
			$repeater->add_control(
				'timeline_single_link',
				[
					'label'       => __( 'Link', 'uael' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'uael' ),
					'default'     => [
						'url' => '',
					],
					'dynamic'     => [
						'active' => true,
					],
				]
			);

		// Tab Content ends.
		$repeater->end_controls_tab();

		// Tab Style starts.
		$repeater->start_controls_tab( 'tab_style', [ 'label' => __( 'Style', 'uael' ) ] );

			$repeater->add_control(
				'timeline_content_advanced',
				[
					'label'        => __( 'Override Global Settings', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'YES', 'uael' ),
					'label_off'    => __( 'NO', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

			$repeater->add_control(
				'current_card_heading_color',
				[
					'label'     => __( 'Heading Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main {{CURRENT_ITEM}} .uael-content .uael-timeline-heading, {{WRAPPER}} .uael-timeline-main {{CURRENT_ITEM}} .uael-content .uael-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

			$repeater->add_control(
				'timeline_current_card_color',
				[
					'label'     => __( 'Description Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main {{CURRENT_ITEM}} .uael-timeline-desc-content, {{WRAPPER}} .uael-timeline-main {{CURRENT_ITEM}} .inner-date-new' => 'color: {{VALUE}};',
					],
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

			$repeater->add_control(
				'timeline_current_card_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .uael-events-inner-new' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--center {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.uael-timeline--center {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.uael-timeline--right {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.uael-timeline--right {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'{{WRAPPER}}.uael-timeline--left {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--center {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--left {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.uael-timeline--left {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--center {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--left {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right {{CURRENT_ITEM}} .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
					],
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

			// Single select icon.
			$repeater->add_control(
				'timeline_single_icon',
				[
					'label'     => __( 'Connector Icon', 'uael' ),
					'type'      => Controls_Manager::ICON,
					'default'   => 'fa fa-calendar',
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

			// Single default Divider icon color.
			$repeater->add_control(
				'single_timeline_divider_icon_color_default',
				[
					'label'     => __( 'Icon Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-days {{CURRENT_ITEM}}.animate-border .timeline-icon-new' => 'color: {{VALUE}} !important;',
					],
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

			// single default divider icon background color.
			$repeater->add_control(
				'single_timeline_divider_icon_bg_color_default',
				[
					'label'     => __( 'Icon Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-days {{CURRENT_ITEM}}.animate-border .uael-timeline-marker' => 'background: {{VALUE}};',
					],
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

			$repeater->add_control(
				'single_date_color_default',
				[
					'label'     => __( 'Date Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main {{CURRENT_ITEM}} .inner-date-new' => 'color: {{VALUE}};',
					],
					'condition' => [
						'timeline_content_advanced' => 'yes',
					],
				]
			);

		// Tab style ends.
		$repeater->end_controls_tab();

		// Repeater set default values.
		$this->add_control(
			'timelines',
			[
				'label'       => __( '&nbsp;', 'uael' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => array_values( $repeater->get_controls() ),
				'title_field' => '{{{ timeline_single_date }}}',
				'default'     => [
					[
						'timeline_single_date'    => __( 'January 1, 2014', 'uael' ),
						'timeline_single_heading' => __( 'My Heading 1', 'uael' ),
						'timeline_single_content' => __( 'I am timeline card content. You can change me anytime. Click here to edit this text.', 'uael' ),
					],
					[
						'timeline_single_date'    => __( 'January 1, 2015', 'uael' ),
						'timeline_single_heading' => __( 'My Heading 2', 'uael' ),
						'timeline_single_content' => __( 'I am timeline card content. You can change me anytime. Click here to edit this text.', 'uael' ),
					],
					[
						'timeline_single_date'    => __( 'January 1, 2016', 'uael' ),
						'timeline_single_heading' => __( 'My Heading 3', 'uael' ),
						'timeline_single_content' => __( 'I am timeline card content. You can change me anytime. Click here to edit this text.', 'uael' ),
					],
					[
						'timeline_single_date'    => __( 'January 1, 2017', 'uael' ),
						'timeline_single_heading' => __( 'My Heading 4', 'uael' ),
						'timeline_single_content' => __( 'I am timeline card content. You can change me anytime. Click here to edit this text.', 'uael' ),
					],
					[
						'timeline_single_date'    => __( 'January 1, 2018', 'uael' ),
						'timeline_single_heading' => __( 'My Heading 5', 'uael' ),
						'timeline_single_content' => __( 'I am timeline card content. You can change me anytime. Click here to edit this text.', 'uael' ),
					],
				],
			]
		);
		// Timeline section ends.
		$this->end_controls_section();
	}

	/**
	 * Registers cards layout controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_cards_layout_controls() {
		// Timeline card starts from here.
		$this->start_controls_section(
			'section_timeline_layout',
			[
				'label' => __( 'Layout', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'timeline_align',
				[
					'label'        => __( 'Orientation', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'center',
					'options'      => [
						'left'   => [
							'title' => __( 'Left', 'uael' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'uael' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'uael' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'render_type'  => 'template',
					'toggle'       => false,
					'prefix_class' => 'uael-timeline--',
				]
			);

			$this->add_control(
				'timeline_align_responsive',
				[
					'label'        => __( 'Responsive Support', 'uael' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'tablet',
					'options'      => [
						'none'   => __( 'Inherit', 'uael' ),
						'tablet' => __( 'For Tablet & Mobile', 'uael' ),
						'mobile' => __( 'For Mobile', 'uael' ),
					],
					'render_type'  => 'template',
					'prefix_class' => 'uael-timeline-responsive-',
					'condition'    => [
						'timeline_align' => 'center',
					],
				]
			);

			$this->add_control(
				'timeline_responsive',
				[
					'label'        => __( 'Responsive Orientation', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Right', 'uael' ),
					'label_off'    => __( 'Left', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'timeline_align'             => 'center',
						'timeline_align_responsive!' => 'none',
					],
				]
			);

			// Timeline content Alignment.
			$this->add_responsive_control(
				'card_content_align',
				[
					'label'       => __( 'Content Alignment', 'uael' ),
					'description' => __( 'Note: Keep above setting unselected to align content w.r.t. timeline item\'s orientation.', 'uael' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => [
						'left'   => [
							'title' => __( 'Left', 'uael' ),
							'icon'  => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'uael' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'uael' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .uael-timeline-main .uael-day-right .uael-events-inner-new' => 'text-align: {{VALUE}};',
						'{{WRAPPER}} .uael-timeline-main .uael-day-left .uael-events-inner-new' => 'text-align: {{VALUE}};',
					],
				]
			);

			// Vertical divider arrow, date postion.
			$this->add_control(
				'timeline_arrow_position',
				[
					'label'        => __( 'Arrow Alignment', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'top'    => [
							'title' => __( 'Top', 'uael' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center' => [
							'title' => __( 'Middle', 'uael' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'bottom' => [
							'title' => __( 'Bottom', 'uael' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'render_type'  => 'template',
					'default'      => 'center',
					'prefix_class' => 'uael-timeline-arrow-',
					'separator'    => 'after',
				]
			);

		// Timeline spacing ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers spacing controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_spacing_style_controls() {

		// Timeline spacing starts from here.
		$this->start_controls_section(
			'section_timeline_spacing',
			[
				'label' => __( 'Spacing', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Horizontal spacing between cards.
		$this->add_responsive_control(
			'timeline_horizontal_spacing',
			[
				'label'     => __( 'Horizontal Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					],
				],
				'selectors' => [
					/* CENTER */
					'{{WRAPPER}}.uael-timeline--center .uael-timeline-marker' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px;',

					'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-marker' => 'margin-right: {{SIZE}}px; margin-left: 0;',
					'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-marker' => 'margin-right: {{SIZE}}px; margin-left: 0;',

					'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-timeline-marker' => 'margin-left: {{SIZE}}px; margin-right: 0;',
					'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-timeline-marker' => 'margin-left: {{SIZE}}px; margin-right: 0;',

					/* LEFT */
					'{{WRAPPER}}.uael-timeline--left .uael-timeline-marker' => 'margin-right: {{SIZE}}px;',

					/* RIGHT */
					'{{WRAPPER}}.uael-timeline--right .uael-timeline-marker' => 'margin-left: {{SIZE}}px;',
				],
			]
		);

		// Vertical spacing between cards.
		$this->add_responsive_control(
			'timeline_vertical_spacing',
			[
				'label'     => __( 'Vertical Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .uael-timeline-field:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
					'{{WRAPPER}} .uael-timeline-field:last-child' => 'margin-bottom: 0px;',
					// , {{WRAPPER}}.uael-timeline--center .uael-timeline-marker
				],
			]
		);

		// Heading bottom spacing.
		$this->add_responsive_control(
			'timeline_heading_spacing',
			[
				'label'     => __( 'Heading Bottom Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .uael-timeline-heading' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		// Heading bottom spacing.
		$this->add_responsive_control(
			'timeline_date_spacing',
			[
				'label'     => __( 'Date Bottom Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'condition' => [
					'timeline_align' => [ 'left', 'right' ],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .uael-date-inner .inner-date-new p' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		// Timeline spacing ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers cards style controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_cards_style_controls() {
		// Timeline card starts from here.
		$this->start_controls_section(
			'section_timeline_cards',
			[
				'label' => __( 'Timeline Items', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// New tab starts here.
		$this->start_controls_tabs( 'tabs_cards' );

		// Tab Default starts here.
		$this->start_controls_tab( 'tab_card_default', [ 'label' => __( 'DEFAULT', 'uael' ) ] );

			$this->add_control(
				'timeline_heading_tag',
				[
					'label'   => __( 'Heading Tag', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'h1'  => __( 'H1', 'uael' ),
						'h2'  => __( 'H2', 'uael' ),
						'h3'  => __( 'H3', 'uael' ),
						'h4'  => __( 'H4', 'uael' ),
						'h5'  => __( 'H5', 'uael' ),
						'h6'  => __( 'H6', 'uael' ),
						'div' => __( 'div', 'uael' ),
						'p'   => __( 'p', 'uael' ),
					],
					'default' => 'h3',
				]
			);

			$this->add_control(
				'timeline_card_heading_color',
				[
					'label'     => __( 'Heading Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-content .uael-timeline-heading, {{WRAPPER}} .uael-timeline-main .uael-content .uael-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card default content text color.
			$this->add_control(
				'timeline_default_card_color',
				[
					'label'     => __( 'Description Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-timeline-desc-content, {{WRAPPER}} .uael-timeline-main .inner-date-new,{{WRAPPER}} .uael-timeline-main a .uael-timeline-desc-content' => 'color: {{VALUE}};',
					],
				]
			);

			// Post Timeline card Link text color.
			$this->add_control(
				'timeline_post_link_color',
				[
					'label'     => __( 'Link Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-timeline-link-style .uael-timeline-link' => 'color: {{VALUE}};',
					],
					'condition' => [
						'timeline_type'          => 'posts',
						'post_timeline_cta_type' => 'link',
					],
				]
			);

			// Timeline card default content typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => __( 'Heading Typograhy', 'uael' ),
					'name'     => 'timeline_card_heading_typography',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .uael-timeline-main .uael-content .uael-timeline-heading, {{WRAPPER}} .uael-timeline-main .uael-content .uael-timeline-heading-text .elementor-inline-editing',
				]
			);

			// Timeline card default content typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => __( 'Description Typograhy', 'uael' ),
					'name'     => 'timeline_default_card_typography',
					'selector' => '{{WRAPPER}} .uael-timeline-main .uael-timeline-desc-content, {{WRAPPER}} .uael-timeline-main .inner-date-new',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				]
			);

			// Post Timeline card Link typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( 'Link Text Typograhy', 'uael' ),
					'name'      => 'timeline_post_link_typography',
					'selector'  => '{{WRAPPER}} .uael-timeline-main .uael-timeline-link-style .uael-timeline-link',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'condition' => [
						'timeline_type'          => 'posts',
						'post_timeline_cta_type' => 'link',
					],
				]
			);

			// Timeline card default background color.
			$this->add_control(
				'timeline_default_card_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#eeeeee',
					'selectors' => [
						'{{WRAPPER}} .uael-events-inner-new' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.uael-timeline--center .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.uael-timeline--center .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.uael-timeline--right .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.uael-timeline--right .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'{{WRAPPER}}.uael-timeline--left .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--center .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--left .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.uael-timeline--left .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--center .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--left .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
					],
				]
			);

			$this->add_control(
				'timeline_cards_box_shadow',
				[
					'label'        => __( 'Box Shadow', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'YES', 'uael' ),
					'label_off'    => __( 'NO', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

			$this->add_control(
				'timeline_cards_box_shadow_color',
				[
					'label'     => __( 'Shadow Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0,0,0,0.5)',
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-shadow-yes .uael-day-new' => 'filter: drop-shadow(0px 1px {{timeline_cards_box_shadow_blur.SIZE}}px {{VALUE}});',
						'{{WRAPPER}} .uael-timeline-shadow-yes .uael-day-new' => '-webkit-filter: drop-shadow(0px 1px {{timeline_cards_box_shadow_blur.SIZE}}px {{VALUE}});',
					],
					'condition' => [
						'timeline_cards_box_shadow' => 'yes',
					],
				]
			);

			$this->add_control(
				'timeline_cards_box_shadow_blur',
				[
					'label'     => __( 'Shadow Blur Effect', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 4,
						'unit' => 'px',
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition' => [
						'timeline_cards_box_shadow' => 'yes',
					],
				]
			);

			// Card border radius.
			$this->add_responsive_control(
				'timeline_cards_border_radius',
				[
					'label'      => __( 'Rounded Corners', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => [
						'top'    => '4',
						'bottom' => '4',
						'left'   => '4',
						'right'  => '4',
						'unit'   => 'px',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-day-right .uael-events-inner-new' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .uael-day-left .uael-events-inner-new'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Item padding.
			$this->add_responsive_control(
				'timeline_cards_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .uael-timeline-main .uael-day-right .uael-events-inner-new' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .uael-timeline-main .uael-day-left .uael-events-inner-new' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		// Tab card default ends.
		$this->end_controls_tab();

		// Tab Focused starts here.
		$this->start_controls_tab( 'tab_card_focused', [ 'label' => __( 'FOCUSED', 'uael' ) ] );

			$this->add_control(
				'timeline_focused_heading_color',
				[
					'label'     => __( 'Heading Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .in-view .uael-content .uael-timeline-heading, {{WRAPPER}} .uael-timeline-main .in-view .uael-content .uael-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card focused content text color.
			$this->add_control(
				'timeline_focused_card_color',
				[
					'label'     => __( 'Description Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .in-view .uael-timeline-desc-content, {{WRAPPER}} .uael-timeline-main .in-view .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

			// Post Timeline card Link text color.
			$this->add_control(
				'timeline_post_link_focus_color',
				[
					'label'     => __( 'Link Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .in-view .uael-timeline-link' => 'color: {{VALUE}};',
					],
					'condition' => [
						'timeline_type'          => 'posts',
						'post_timeline_cta_type' => 'link',
					],
				]
			);

			// Timeline card focused background color.
			$this->add_control(
				'timeline_focused_card_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .in-view .uael-events-inner-new' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.uael-timeline--center .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--center .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--left .in-view .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right .in-view .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.uael-timeline--center .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.uael-timeline--center .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--left .in-view .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--right .in-view .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .in-view .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .in-view .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

					],
				]
			);

		// Card Focused tab ends.
		$this->end_controls_tab();

		// Tab Hover starts here.
		$this->start_controls_tab( 'tab_card_hover', [ 'label' => __( 'HOVER', 'uael' ) ] );

			$this->add_control(
				'timeline_hover_heading_color',
				[
					'label'     => __( 'Heading Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .animate-border:hover .uael-content .uael-timeline-heading, {{WRAPPER}} .uael-timeline-main .animate-border:hover .uael-content .uael-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card hover content text color.
			$this->add_control(
				'timeline_hover_card_color',
				[
					'label'     => __( 'Description Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-days .animate-border:hover .uael-timeline-desc-content, {{WRAPPER}} .uael-days .animate-border:hover .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

			// Post Timeline card Link text color.
			$this->add_control(
				'timeline_post_link_hover_color',
				[
					'label'     => __( 'Link Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .animate-border:hover .uael-timeline-link-style .uael-timeline-link' => 'color: {{VALUE}};',
					],
					'condition' => [
						'timeline_type'          => 'posts',
						'post_timeline_cta_type' => 'link',
					],
				]
			);

			// Timeline card hover background color.
			$this->add_control(
				'timeline_hover_card_bg_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .animate-border:hover .uael-events-inner-new' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.uael-timeline--center div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--center div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--left div.uael-timeline-main .animate-border:hover .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right div.uael-timeline-main .animate-border:hover .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.uael-timeline--center div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.uael-timeline--center div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--left div.uael-timeline-main .animate-border:hover .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.uael-timeline--right div.uael-timeline-main .animate-border:hover .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-right .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right div.uael-timeline-main .animate-border:hover .uael-day-left .uael-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
					],
				]
			);

		// Tab Hover ends here.
		$this->end_controls_tab();

		// Tab card section ends here.
		$this->end_controls_tabs();

		// Timeline Cards ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers vertical separator controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_vertical_separator_style_controls() {
		// Timeline vertical divider starts from here.
		$this->start_controls_section(
			'section_timeline_middle_divider',
			[
				'label' => __( 'Connector', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// All global select icon.
		$this->add_control(
			'timeline_all_icon',
			[
				'label'   => __( 'Connector Icon', 'uael' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'fa fa-calendar',
			]
		);

		// Vertical divider width.
		$this->add_control(
			'timeline_separator_width',
			[
				'label'     => __( 'Connector Width', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .uael-timeline__line' => 'width: {{SIZE}}px;',
				],
			]
		);

		// Default Icon Font Size slider.
		$this->add_responsive_control(
			'timeline_all_icon_font_size',
			[
				'label'     => __( 'Icon Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 16,
				],
				'range'     => [
					'px' => [
						'min'  => 10,
						'max'  => 30,
						'step' => 1,
					],
				],
				'condition' => [
					'timeline_all_icon!' => '',
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .uael-timeline-main .timeline-icon-new' => 'font-size: {{SIZE}}px',
				],
			]
		);

		// Default Icon Background Size slider.
		$this->add_responsive_control(
			'timeline_all_icon_size',
			[
				'label'      => __( 'Icon Background Size', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
					'em' => [
						'min' => 1.5,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => '3',
					'unit' => 'em',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-timeline-marker' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-timeline-arrow'  => 'height: {{SIZE}}{{UNIT}};',

					'{{WRAPPER}}.uael-timeline--left .uael-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}}.uael-timeline--right .uael-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 );',

					'.rtl {{WRAPPER}}.uael-timeline--left .uael-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',
					'.rtl {{WRAPPER}}.uael-timeline--right .uael-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',

					'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',
					'(tablet){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',

					'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',
					'(tablet).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline-res-right .uael-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',

					'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',
					'(mobile){{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',

					'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',
					'(mobile).rtl {{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline-res-right .uael-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',
				],
			]
		);

		// New tab starts here.
		$this->start_controls_tabs( 'tabs_divider' );

		// Tab Default starts here.
		$this->start_controls_tab( 'tab_divider_default', [ 'label' => __( 'DEFAULT', 'uael' ) ] );

			// Default vertical divider color.
			$this->add_control(
				'timeline_divider_color',
				[
					'label'     => __( 'Line Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.uael-timeline--center .uael-timeline__line' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--left .uael-timeline__line' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.uael-timeline--right .uael-timeline__line' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-tablet .uael-timeline__line' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.uael-timeline--center.uael-timeline-responsive-mobile .uael-timeline__line' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Default Divider icon color.
			$this->add_control(
				'timeline_divider_icon_color',
				[
					'label'     => __( 'Icon Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .animate-border .timeline-icon-new' => 'color: {{VALUE}};',
					],
				]
			);

			// Default Divider icon background color.
			$this->add_control(
				'timeline_divider_icon_bg_color',
				[
					'label'     => __( 'Icon Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .animate-border .uael-timeline-marker' => 'background: {{VALUE}};',
					],
				]
			);

		// Tab Default ends.
		$this->end_controls_tab();

		// Tab Focused starts.
		$this->start_controls_tab( 'tab_divider_focused', [ 'label' => __( 'FOCUSED', 'uael' ) ] );

			$this->add_control(
				'timeline_divider_scroll_color',
				[
					'label'     => __( 'Line Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-timeline__line__inner' => 'background-color: {{VALUE}};width: 100%;',
					],
				]
			);

			// Focused divider icon color.
			$this->add_control(
				'timeline_divider_icon_scroll_color',
				[
					'label'     => __( 'Icon Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-days .in-view .in-view-timeline-icon .timeline-icon-new' => 'color: {{VALUE}};',
					],
				]
			);

			// Focused divider icon background color.
			$this->add_control(
				'timeline_divider_icon_bg_scroll_color',
				[
					'label'     => __( 'Icon Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-days .in-view .in-view-timeline-icon' => 'background: {{VALUE}};',
					],
				]
			);

		// Tab Focused ends.
		$this->end_controls_tab();

		// Tab Hover starts.
		$this->start_controls_tab( 'tab_divider_hover', [ 'label' => __( 'HOVER', 'uael' ) ] );

			// Hover divider icon color.
			$this->add_control(
				'timeline_divider_icon_hover_color',
				[
					'label'     => __( 'Icon Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-days .animate-border:hover .timeline-icon-new' => 'color: {{VALUE}};',
					],
				]
			);

			// Hover divider icon background color.
			$this->add_control(
				'timeline_divider_icon_bg_hover_color',
				[
					'label'     => __( 'Icon Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-days .animate-border:hover .uael-timeline-marker' => 'background: {{VALUE}};',
					],
				]
			);

		// Tab Hover Ends.
		$this->end_controls_tab();

		// Tabs ends here.
		$this->end_controls_tabs();

		// Section Vertical Divider ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers date style controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_date_style_controls() {
		// Timeline Dates starts from here.
		$this->start_controls_section(
			'section_timeline_dates',
			[
				'label' => __( 'Dates', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'date_tabs' );

		// Tab Date default starts.
		$this->start_controls_tab( 'tab_default_date', [ 'label' => __( 'DEFAULT', 'uael' ) ] );

			// Timeline date typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'date_typography_default',
					'selector' => '{{WRAPPER}} .uael-timeline-main .inner-date-new',
				]
			);

			// Timeline date color.
			$this->add_control(
				'date_color_default',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

		// Tab Date default ends.
		$this->end_controls_tab();

		// Tab Date Focused starts.
		$this->start_controls_tab( 'tab_focused_date', [ 'label' => __( 'FOCUSED', 'uael' ) ] );

			// Timeline date color.
			$this->add_control(
				'date_color_focused',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-days .in-view .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

		// Tab Date focused ends.
		$this->end_controls_tab();

		// Tab Date hover starts.
		$this->start_controls_tab( 'tab_hover_date', [ 'label' => __( 'HOVER', 'uael' ) ] );

			// Timeline date color.
			$this->add_control(
				'date_color_hover',
				[
					'label'     => __( 'Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-timeline-main .uael-days .animate-border:hover .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

		// Tab Date hover ends.
		$this->end_controls_tab();

		// Tab Date ends.
		$this->end_controls_tabs();

		// Timeline dates ends.
		$this->end_controls_section();
	}

	/**
	 * Get alignment of timeline.
	 *
	 * Written in PHP.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function get_horizontal_aligment() {

		if ( '' === $this->get_settings( 'timeline_align' ) ) {
			return 'center';
		}

		return $this->get_settings( 'timeline_align' );
	}

	/**
	 * Get query products based on settings.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param array $settings Settings array for the widget.
	 * @since 1.5.2
	 * @access public
	 */
	public static function get_query_posts( $settings ) {

		$post_type = ( isset( $settings['post_type_filter'] ) && '' != $settings['post_type_filter'] ) ? $settings['post_type_filter'] : 'post';

		$paged                             = self::get_paged();
		$query_args                        = [
			'post_type'      => $post_type,
			'posts_per_page' => ( '' == $settings['posts_per_page'] ) ? -1 : $settings['posts_per_page'],
			'paged'          => $paged,
			'post_status'    => 'publish',
		];
		$query_args['orderby']             = $settings['orderby'];
		$query_args['order']               = $settings['order'];
		$query_args['ignore_sticky_posts'] = ( isset( $settings['ignore_sticky_posts'] ) && 'yes' == $settings['ignore_sticky_posts'] ) ? 1 : 0;

		if ( ! empty( $settings['post_filter'] ) ) {

			$query_args[ $settings['post_filter_rule'] ] = $settings['post_filter'];
		}

		if ( '' !== $settings['author_filter'] ) {

			$query_args[ $settings['author_filter_rule'] ] = $settings['author_filter'];
		}

		// Get all the taxanomies associated with the post type.
		$taxonomy = UAEL_Posts_Helper::get_taxonomy( $post_type );

		if ( ! empty( $taxonomy ) && ! is_wp_error( $taxonomy ) ) {

			// Get all taxonomy values under the taxonomy.
			foreach ( $taxonomy as $index => $tax ) {

				if ( ! empty( $settings[ 'tax_' . $index . '_' . $post_type . '_filter' ] ) ) {

					$operator = $settings[ $index . '_' . $post_type . '_filter_rule' ];

					$query_args['tax_query'][] = [
						'taxonomy' => $index,
						'field'    => 'slug',
						'terms'    => $settings[ 'tax_' . $index . '_filter' ],
						'operator' => $operator,
					];
				}
			}
		}
		if ( 0 < $settings['offset'] ) {

			/**
			 * Offset break the pagination. Using WordPress's work around
			 *
			 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
			 */
			$query_args['offset_to_fix'] = $settings['offset'];
		}

		return apply_filters( '_uael_timeline_query_args', $query_args, $settings );
	}

	/**
	 * Set Query Posts.
	 *
	 * @since 1.5.2
	 * @access public
	 */
	public function query_posts() {

		$settings = $this->get_settings();

		if ( 'main' == $settings['query_type'] ) {

			global $wp_query;

			$main_query = clone $wp_query;

			$this->query = $main_query;

		} else {

			$query_args  = $this->get_query_posts( $settings );
			$this->query = new \WP_Query( $query_args );
		}
	}

	/**
	 * Render Woo Product Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function render() {

		$settings  = $this->get_settings();
		$dynamic   = $this->get_settings_for_display();
		$node_id   = $this->get_id();
		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

		if ( 'content' == $settings['timeline_type'] ) {
			ob_start();
			include 'template.php';
			$html = ob_get_clean();
			echo $html;
		} elseif ( 'posts' == $settings['timeline_type'] ) {
			$this->add_render_attribute( 'timeline_wrapper', 'class', 'uael-timeline-wrapper' );
			$this->add_render_attribute( 'timeline_wrapper', 'class', 'uael-timeline-node' );

			if ( 'yes' == $settings['timeline_responsive'] ) {
				$this->add_render_attribute( 'timeline_wrapper', 'class', 'uael-timeline-res-right' );
			} ?>
			<div <?php echo $this->get_render_attribute_string( 'timeline_wrapper' ); ?>>
				<?php
				$skin = Skin_Init::get_instance( $node_id );

				echo $skin->render( $settings, $node_id, $dynamic );
				?>
			</div>
			<?php
		}
	}

}
