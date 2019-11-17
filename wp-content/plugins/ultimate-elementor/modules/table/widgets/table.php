<?php
/**
 * UAEL Table.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Table\Widgets;


// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Table.
 */
class Table extends Common_Widget {

	/**
	 * Retrieve Table Widget name.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Table' );
	}

	/**
	 * Retrieve Table Widget title.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Table' );
	}

	/**
	 * Retrieve Table Widget icon.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Table' );
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
		return parent::get_widget_keywords( 'Table' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-datatable', 'uael-table' ];
	}

	/**
	 * Register General Content controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_header_content_controls();
		$this->register_body_content_controls();
		$this->register_adv_content_controls();

		$this->register_header_style_controls();
		$this->register_body_style_controls();
		$this->register_icon_image_controls();
		$this->register_search_controls();
		$this->register_helpful_information();
	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_header_content_controls() {

		$condition = array();

		// Table header settings.
		$this->start_controls_section(
			'section_table_header',
			[
				'label' => __( 'Table Header', 'uael' ),
			]
		);

			$this->add_control(
				'source',
				[
					'label'   => __( 'Source', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'manual',
					'options' => [
						'manual' => __( 'Manual', 'uael' ),
						'file'   => __( 'CSV File', 'uael' ),
					],
				]
			);

			$this->add_control(
				'file',
				[
					'label'     => __( 'Upload a CSV File', 'uael' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'source' => 'file',
					],
				]
			);
		if ( parent::is_internal_links() ) {
			$this->add_control(
				'file_help_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( 'Note: Facing issue with %1$sCSV importer?%2$s Please read %3$sthis%2$s article for troubleshooting steps.', 'uael' ), '<a href="https://uaelementor.com/docs/create-table-by-uploading-csv/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>', '<a href="https://uaelementor.com/docs/facing-issues-with-csv-import/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'source' => 'file',
					],
				]
			);
		}

			// Repeater object created.
			$repeater = new Repeater();

			// Content Type Row/Col.
			$repeater->add_control(
				'header_content_type',
				[
					'label'   => __( 'Action', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'cell',
					'options' => [
						'row'  => __( 'Start New Row', 'uael' ),
						'cell' => __( 'Add New Cell', 'uael' ),
					],
				]
			);

			// Table heading border Row/Cell Note.
			$repeater->add_control(
				'add_head_cell_row_description',
				[
					'label'     => '',
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'type'      => Controls_Manager::RAW_HTML,
					'raw'       => sprintf( '<p style="font-size: 12px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', __( 'You have started a new row. Please add new cells in your row by clicking <b>Add Item</b> button below.', 'uael' ) ),
					'condition' => [
						'header_content_type' => 'row',
					],
				]
			);

			// Start control tab.
			$repeater->start_controls_tabs( 'items_repeater' );

				// Start control content tab.
				$repeater->start_controls_tab(
					'tab_head_content',
					[
						'label'     => __( 'CONTENT', 'uael' ),
						'condition' => [
							'header_content_type' => 'cell',
						],
					]
				);

						// table heading text.
						$repeater->add_control(
							'heading_text',
							[
								'label'     => __( 'Text', 'uael' ),
								'type'      => Controls_Manager::TEXT,
								'dynamic'   => [
									'active' => true,
								],
								'condition' => [
									'header_content_type' => 'cell',
								],
							]
						);

				$repeater->end_controls_tab();

				// Start control content tab.
				$repeater->start_controls_tab(
					'tab_head_icon',
					[
						'label'     => __( 'ICON / IMAGE', 'uael' ),
						'condition' => [
							'header_content_type' => 'cell',
						],
					]
				);

					// Content Type Icon/Image.
					$repeater->add_control(
						'header_content_icon_image',
						[
							'label'   => __( 'Select', 'uael' ),
							'type'    => Controls_Manager::SELECT,
							'default' => 'icon',
							'options' => [
								'icon'  => __( 'Icon', 'uael' ),
								'image' => __( 'Image', 'uael' ),
							],
						]
					);

					// Single select icon.
					$repeater->add_control(
						'heading_icon',
						[
							'label'     => __( 'Icon', 'uael' ),
							'type'      => Controls_Manager::ICON,
							'condition' => [
								'header_content_type' => 'cell',
								'header_content_icon_image' => 'icon',
							],
						]
					);

					// Single Add Image.
					$repeater->add_control(
						'head_image',
						[
							'label'     => __( 'Choose Image', 'uael' ),
							'type'      => Controls_Manager::MEDIA,
							'dynamic'   => [
								'active' => true,
							],
							'condition' => [
								'header_content_type' => 'cell',
								'header_content_icon_image' => 'image',
							],
						]
					);

					$repeater->end_controls_tab();

					// Start control content tab.
					$repeater->start_controls_tab(
						'tab_head_advance',
						[
							'label'     => __( 'ADVANCE', 'uael' ),
							'condition' => [
								'header_content_type' => 'cell',
							],
						]
					);

					// Table header column span.
					$repeater->add_control(
						'heading_col_span',
						[
							'label'     => __( 'Column Span', 'uael' ),
							'title'     => __( 'How many columns should this column span across.', 'uael' ),
							'type'      => Controls_Manager::NUMBER,
							'default'   => 1,
							'min'       => 1,
							'max'       => 20,
							'step'      => 1,
							'condition' => [
								'header_content_type' => 'cell',
							],
						]
					);

					// Cell row Span.
					$repeater->add_control(
						'heading_row_span',
						[
							'label'     => __( 'Row Span', 'uael' ),
							'title'     => __( 'How many rows should this column span across.', 'uael' ),
							'type'      => Controls_Manager::NUMBER,
							'default'   => 1,
							'min'       => 1,
							'max'       => 20,
							'step'      => 1,
							'separator' => 'below',
							'condition' => [
								'header_content_type' => 'cell',
							],
						]
					);

					// Cell row Span.
					$repeater->add_control(
						'heading_row_width',
						[
							'label'      => __( 'Column Width', 'uael' ),
							'type'       => Controls_Manager::SLIDER,
							'range'      => [
								'px' => [
									'min' => 0,
									'max' => 500,
								],
								'%'  => [
									'min' => 0,
									'max' => 100,
								],
							],
							'size_units' => [ 'px', '%' ],
							'separator'  => 'below',
							'selectors'  => [
								'{{WRAPPER}} {{CURRENT_ITEM}}.uael-table-col' => 'width: {{SIZE}}{{UNIT}}',
							],
							'condition'  => [
								'header_content_type' => 'cell',
							],
						]
					);

					// Single Header Text Color.
					$repeater->add_control(
						'single_heading_color',
						[
							'label'     => __( 'Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .uael-table-row {{CURRENT_ITEM}} .uael-table__text' => 'color: {{VALUE}};',
							],
							'condition' => [
								'header_content_type' => 'cell',
							],
						]
					);

					// Single Header Background Color.
					$repeater->add_control(
						'single_heading_background_color',
						[
							'label'     => __( 'Background Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} thead .uael-table-row {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								'header_content_type' => 'cell',
							],
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tab();

			// Repeater set default values.
			$this->add_control(
				'table_headings',
				[
					'type'        => Controls_Manager::REPEATER,
					'show_label'  => true,
					'fields'      => array_values( $repeater->get_controls() ),
					'title_field' => '{{ header_content_type }}: {{{ heading_text }}}',
					'default'     => [
						[
							'header_content_type' => 'row',
						],
						[
							'header_content_type' => 'cell',
							'heading_text'        => __( 'Sample ID', 'uael' ),
						],
						[
							'header_content_type' => 'cell',
							'heading_text'        => __( 'Heading 1', 'uael' ),
						],
						[
							'header_content_type' => 'cell',
							'heading_text'        => __( 'Heading 2', 'uael' ),
						],
					],
					'condition'   => [
						'source' => 'manual',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_body_content_controls() {

		// Table content.
		$this->start_controls_section(
			'section_table_content',
			[
				'label'     => __( 'Table Content', 'uael' ),
				'condition' => [
					'source' => 'manual',
				],
			]
		);

		// Repeater obj for content.
		$repeater_content = new Repeater();

		// Content Type Row/Col.
		$repeater_content->add_control(
			'content_type',
			[
				'label'   => __( 'Action', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cell',
				'options' => [
					'row'  => __( 'Start New Row', 'uael' ),
					'cell' => __( 'Add New Cell', 'uael' ),
				],
			]
		);

		// Table heading border Row/Cell Note.
		$repeater_content->add_control(
			'add_body_cell_row_description',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => sprintf( '<p style="font-size: 12px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', __( 'You have started a new row. Please add new cells in your row by clicking <b>Add Item</b> button below.', 'uael' ) ),
				'condition' => [
					'content_type' => 'row',
				],
			]
		);

		// Start control tab.
		$repeater_content->start_controls_tabs( 'items_repeater' );

			// Start control content tab.
			$repeater_content->start_controls_tab(
				'tab_content',
				[
					'label'     => __( 'Content', 'uael' ),
					'condition' => [
						'content_type' => 'cell',
					],
				]
			);

				// Single Cell text.
				$repeater_content->add_control(
					'cell_text',
					[
						'label'     => __( 'Text', 'uael' ),
						'type'      => Controls_Manager::TEXTAREA,
						'dynamic'   => [
							'active' => true,
						],
						'condition' => [
							'content_type' => 'cell',
						],
					]
				);

				// Single Cell LINK.
				$repeater_content->add_control(
					'link',
					[
						'label'       => __( 'Link', 'uael' ),
						'type'        => Controls_Manager::URL,
						'placeholder' => '#',
						'dynamic'     => [
							'active' => true,
						],
						'default'     => [
							'url' => '',
						],
						'condition'   => [
							'content_type' => 'cell',
						],
					]
				);

			// End Content control tab.
			$repeater_content->end_controls_tab();

			// Start Media Tab.
			$repeater_content->start_controls_tab(
				'tab_media',
				[
					'label'     => __( 'ICON / IMAGE', 'uael' ),
					'condition' => [
						'content_type' => 'cell',
					],
				]
			);

				// Content Type Icon/Image.
				$repeater_content->add_control(
					'cell_content_icon_image',
					[
						'label'   => __( 'Select', 'uael' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'icon',
						'options' => [
							'icon'  => __( 'Icon', 'uael' ),
							'image' => __( 'Image', 'uael' ),
						],
					]
				);

				// Single Cell Icon.
				$repeater_content->add_control(
					'cell_icon',
					[
						'label'       => __( 'Icon', 'uael' ),
						'type'        => Controls_Manager::ICON,
						'label_block' => false,
						'default'     => '',
						'condition'   => [
							'content_type'            => 'cell',
							'cell_content_icon_image' => 'icon',
						],
					]
				);

				// Single Add Image.
				$repeater_content->add_control(
					'image',
					[
						'label'     => __( 'Choose Image', 'uael' ),
						'type'      => Controls_Manager::MEDIA,
						'dynamic'   => [
							'active' => true,
						],
						'condition' => [
							'content_type'            => 'cell',
							'cell_content_icon_image' => 'image',
						],
					]
				);

			// End Media control tab.
			$repeater_content->end_controls_tab();

			// Start Media Tab.
			$repeater_content->start_controls_tab(
				'tab_advance_cells',
				[
					'label'     => __( 'Advance', 'uael' ),
					'condition' => [
						'content_type' => 'cell',
					],
				]
			);

			// Cell Column Span.
			$repeater_content->add_control(
				'cell_span',
				[
					'label'     => __( 'Column Span', 'uael' ),
					'title'     => __( 'How many columns should this column span across.', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1,
					'min'       => 1,
					'max'       => 20,
					'step'      => 1,
					'condition' => [
						'content_type' => 'cell',
					],
				]
			);

			// Cell row Span.
			$repeater_content->add_control(
				'cell_row_span',
				[
					'label'     => __( 'Row Span', 'uael' ),
					'title'     => __( 'How many rows should this column span across.', 'uael' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1,
					'min'       => 1,
					'max'       => 20,
					'step'      => 1,
					'separator' => 'below',
					'condition' => [
						'content_type' => 'cell',
					],
				]
			);

			// Cell Column Span.
			$repeater_content->add_control(
				'table_th_td',
				[
					'label'       => __( 'Convert this Cell into Table Heading?', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => [
						'td' => __( 'No', 'uael' ),
						'th' => __( 'Yes', 'uael' ),
					],
					'default'     => 'td',
					'condition'   => [
						'content_type' => 'cell',
					],
					'label_block' => true,
				]
			);

			// End Media control tab.
			$repeater_content->end_controls_tab();

		// End control tab.
		$repeater_content->end_controls_tabs();

		// Repeater set default values.
		$this->add_control(
			'table_content',
			[
				'type'        => Controls_Manager::REPEATER,
				'default'     => [
					[
						'content_type' => 'row',
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Sample #1', 'uael' ),
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Row 1, Content 1', 'uael' ),
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Row 1, Content 2', 'uael' ),
					],
					[
						'content_type' => 'row',
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Sample #2', 'uael' ),
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Row 2, Content 1', 'uael' ),
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Row 2, Content 2', 'uael' ),
					],
					[
						'content_type' => 'row',
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Sample #3', 'uael' ),
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Row 3, Content 1', 'uael' ),
					],
					[
						'content_type' => 'cell',
						'cell_text'    => __( 'Row 3, Content 2', 'uael' ),
					],
				],
				'fields'      => array_values( $repeater_content->get_controls() ),
				'title_field' => '{{ content_type }}: {{{ cell_text }}}',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_adv_content_controls() {

		// Column style starts.
		$this->start_controls_section(
			'section_advance_settings',
			[
				'label' => __( 'Advance Settings', 'uael' ),
			]
		);

			// Sortable Table Switcher.
			$this->add_control(
				'sortable',
				[
					'label'        => __( 'Sortable Table', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'YES', 'uael' ),
					'label_off'    => __( 'NO', 'uael' ),
					'description'  => __( 'Sort table entries on the click of table headings.', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

			// Searchable Table Switcher.
			$this->add_control(
				'searchable',
				[
					'label'        => __( 'Searchable Table', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'description'  => __( 'Search/filter table entries easily.', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

			$this->add_control(
				'show_entries',
				[
					'label'        => __( 'Show Entries Dropdown', 'uael' ),
					'description'  => __( 'Controls the number of entries in a table.', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_header_style_controls() {

		// Header heading style.
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => __( 'Table Header', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Header typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_typography',
				'label'    => __( 'Typography', 'uael' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} th.uael-table-col',
			]
		);

		// Header padding.
		$this->add_responsive_control(
			'cell_padding_head',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '15',
					'bottom'   => '15',
					'left'     => '15',
					'right'    => '15',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} th.uael-table-col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Header text alignment.
		$this->add_responsive_control(
			'cell_align_head',
			[
				'label'     => __( 'Text Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
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
				'selectors' => [
					'{{WRAPPER}} th .uael-table__text' => 'text-align: {{VALUE}};width: 100%;',
				],
			]
		);

		// Header tabs starts here.
		$this->start_controls_tabs( 'tabs_header_colors_row' );

			// Header Default tab starts.
			$this->start_controls_tab( 'tab_header_colors_row', [ 'label' => __( 'Default', 'uael' ) ] );

				// Header row color default.
				$this->add_control(
					'header_cell_color_row',
					[
						'label'     => __( 'Row Text Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						],
						'selectors' => [
							'{{WRAPPER}} thead .uael-table-row th .uael-table__text' => 'color: {{VALUE}};',
							'{{WRAPPER}} th' => 'color: {{VALUE}};',
							'{{WRAPPER}} tbody .uael-table-row th' => 'color: {{VALUE}};',
						],
					]
				);

				// Header row background color default.
				$this->add_control(
					'header_cell_background_row',
					[
						'label'     => __( 'Row Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} thead .uael-table-row th' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} tbody .uael-table-row th' => 'background-color: {{VALUE}};',
						],
					]
				);

				// Advanced Setting for header Switcher.
				$this->add_control(
					'header_border_styling',
					[
						'label'        => __( 'Apply Border To', 'uael' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => __( 'CELL', 'uael' ),
						'label_off'    => __( 'ROW', 'uael' ),
						'return_value' => 'yes',
						'default'      => 'yes',
						'prefix_class' => 'uael-border-',
					]
				);

				// Table heading border Row/Cell Note.
				$this->add_control(
					'head_border_note',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw'  => sprintf( '<p style="font-size: 12px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', __( 'Note: By default, the border will be applied to cells. You can change it to row by using the above setting.', 'uael' ) ),
					]
				);

				// Header row border.
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'           => 'row_border_head',
						'label'          => __( 'Row Border', 'uael' ),
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width'  => [
								'default' => [
									'top'      => '1',
									'right'    => '1',
									'bottom'   => '1',
									'left'     => '1',
									'isLinked' => true,
								],
							],
							'color'  => [
								'default' => '#bbb',
							],
						],
						'selector'       => '{{WRAPPER}} thead tr.uael-table-row, {{WRAPPER}} tbody .uael-table-row th',
						'condition'      => [
							'header_border_styling!' => 'yes',
						],
					]
				);

				// Header Cell border.
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'           => 'cell_border_head',
						'label'          => __( 'Cell Border', 'uael' ),
						'selector'       => '{{WRAPPER}} th.uael-table-col',
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width'  => [
								'default' => [
									'top'      => '1',
									'right'    => '1',
									'bottom'   => '1',
									'left'     => '1',
									'isLinked' => true,
								],
							],
							'color'  => [
								'default' => '#bbb',
							],
						],
						'condition'      => [
							'header_border_styling' => 'yes',
						],
					]
				);

			$this->end_controls_tab();

			// Tab header hover.
			$this->start_controls_tab( 'tab_header_hover_colors_row', [ 'label' => __( 'Hover', 'uael' ) ] );

				// Header text row color hover.
				$this->add_control(
					'header_cell_hover_color_row',
					[
						'label'     => __( 'Row Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} thead .uael-table-row:hover .uael-table__text' => 'color: {{VALUE}};',
							'{{WRAPPER}} tbody .uael-table-row:hover th .uael-table__text' => 'color: {{VALUE}};',
							'{{WRAPPER}} .uael-table-row:hover th' => 'color: {{VALUE}};',
						],
					]
				);

				// Header row background color hover.
				$this->add_control(
					'header_cell_hover_background_row',
					[
						'label'     => __( 'Row Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} thead .uael-table-row:hover > th' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .uael-table tbody .uael-table-row:hover > th' => 'background-color: {{VALUE}};',
						],
					]
				);

				// Header cell hover text color.
				$this->add_control(
					'header_cell_hover_color',
					[
						'label'     => __( 'Cell Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} thead th.uael-table-col:hover .uael-table__text' => 'color: {{VALUE}};',
							'{{WRAPPER}} tbody .uael-table-row th.uael-table-col:hover .uael-table__text' => 'color: {{VALUE}};',
							'{{WRAPPER}} tr.uael-table-row th.uael-table-col:hover' => 'color: {{VALUE}};',
						],
					]
				);

				// Header cell hover background color.
				$this->add_control(
					'header_cell_hover_background',
					[
						'label'     => __( 'Cell Hover Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} thead .uael-table-row th.uael-table-col:hover' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .uael-table tbody .uael-table-row:hover >  th.uael-table-col:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_body_style_controls() {

		// Rows style tab heading.
		$this->start_controls_section(
			'section_table_body_style',
			[
				'label' => __( 'Table Body', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Cell Typograghy.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cell_typography',
				'label'    => __( 'Typography', 'uael' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} td .uael-table__text-inner,{{WRAPPER}} td .uael-align-icon--left,{{WRAPPER}} td .uael-align-icon--right',
			]
		);

		// Cell padding.
		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '15',
					'bottom'   => '15',
					'left'     => '15',
					'right'    => '15',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} td.uael-table-col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Cell text alignment.
		$this->add_responsive_control(
			'cell_align',
			[
				'label'     => __( 'Text Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
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
				'selectors' => [
					'{{WRAPPER}} td .uael-table__text' => 'text-align: {{VALUE}};    width: 100%;',
				],
			]
		);

		// Cell text alignment.
		$this->add_responsive_control(
			'cell_valign',
			[
				'label'     => __( 'Vertical Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'middle',
				'options'   => [
					'top'    => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'uael' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-table-row .uael-table-col' => 'vertical-align: {{VALUE}};',
				],
			]
		);

		// Tab control starts.
		$this->start_controls_tabs( 'tabs_cell_colors' );

			// Tab Default starts.
			$this->start_controls_tab( 'tab_cell_colors', [ 'label' => __( 'Default', 'uael' ) ] );

				// Cell Color Default.
				$this->add_control(
					'cell_color',
					[
						'label'     => __( 'Row Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => [
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						],
						'selectors' => [
							'{{WRAPPER}} tbody td.uael-table-col .uael-table__text' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'striped_effect_feature',
					[
						'label'        => __( 'Striped Effect', 'uael' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => __( 'YES', 'uael' ),
						'label_off'    => __( 'NO', 'uael' ),
						'return_value' => 'yes',
						'default'      => 'yes',
					]
				);

				// Striped effect (Odd Rows).
				$this->add_control(
					'striped_effect_odd',
					[
						'label'     => __( 'Striped Odd Rows Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#eaeaea',
						'selectors' => [
							'{{WRAPPER}} tbody tr:nth-child(odd)' => 'background: {{VALUE}};',
						],
						'condition' => [
							'striped_effect_feature' => 'yes',
						],
					]
				);

				// Striped effect (Even Rows).
				$this->add_control(
					'striped_effect_even',
					[
						'label'     => __( 'Striped Even Rows Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#FFFFFF',
						'selectors' => [
							'{{WRAPPER}} tbody tr:nth-child(even)' => 'background: {{VALUE}};',
						],
						'condition' => [
							'striped_effect_feature' => 'yes',
						],
					]
				);

				// Cell background color default.
				$this->add_control(
					'cell_background',
					[
						'label'     => __( 'Row Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} tbody .uael-table-row' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'striped_effect_feature!' => 'yes',
						],
					]
				);

				// Advanced Setting for header Switcher.
				$this->add_control(
					'body_border_styling',
					[
						'label'        => __( 'Apply Border To', 'uael' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => __( 'CELL', 'uael' ),
						'label_off'    => __( 'ROW', 'uael' ),
						'return_value' => 'yes',
						'default'      => 'yes',
					]
				);

				// Table body border Row/Cell Note.
				$this->add_control(
					'body_border_note',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw'  => sprintf( '<p style="font-size: 12px;font-style: italic;line-height: 1.4;color: #a4afb7;">%s</p>', __( 'Note: By default, the border will be applied to cells. You can change it to row by using the above setting.', 'uael' ) ),
					]
				);

				// Body Row border.
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'           => 'row_border',
						'label'          => __( 'Border', 'uael' ),
						'selector'       => '{{WRAPPER}} tbody .uael-table-row',
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width'  => [
								'default' => [
									'top'      => '1',
									'right'    => '1',
									'bottom'   => '1',
									'left'     => '1',
									'isLinked' => true,
								],
							],
							'color'  => [
								'default' => '#bbb',
							],
						],
						'condition'      => [
							'body_border_styling!' => 'yes',
						],
					]
				);

				// Body Cell border.
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'           => 'cell_border_body',
						'label'          => __( 'Cell Border', 'uael' ),
						'selector'       => '{{WRAPPER}} td.uael-table-col',
						'fields_options' => [
							'border' => [
								'default' => 'solid',
							],
							'width'  => [
								'default' => [
									'top'      => '1',
									'right'    => '1',
									'bottom'   => '1',
									'left'     => '1',
									'isLinked' => true,
								],
							],
							'color'  => [
								'default' => '#bbb',
							],
						],
						'condition'      => [
							'body_border_styling' => 'yes',
						],
					]
				);

			// Default tab ends here.
			$this->end_controls_tab();

			// Hover tab starts here.
			$this->start_controls_tab( 'tab_cell_hover_colors', [ 'label' => __( 'Hover', 'uael' ) ] );

				// Row hover text color.
				$this->add_control(
					'row_hover_color',
					[
						'label'     => __( 'Row Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} tbody .uael-table-row:hover td.uael-table-col .uael-table__text' => 'color: {{VALUE}};',
						],
					]
				);

				// Row hover background color.
				$this->add_control(
					'row_hover_background',
					[
						'label'     => __( 'Row Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} tbody .uael-table-row:hover' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} tbody .uael-table-row:hover > .uael-table-col:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

				// Cell color hover.
				$this->add_control(
					'cell_hover_color',
					[
						'label'     => __( 'Cell Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-table tbody td.uael-table-col:hover .uael-table__text' => 'color: {{VALUE}};',
						],
					]
				);

				// Cell background color hover.
				$this->add_control(
					'cell_hover_background',
					[
						'label'     => __( 'Cell Hover Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .uael-table tbody .uael-table-row:hover > td.uael-table-col:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

		// Tab control ends.
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_icon_image_controls() {

		// Icon/Image Styling.
		$this->start_controls_section(
			'section_icon_image_style',
			[
				'label'     => __( 'Icon / Image', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'source' => 'manual',
				],
			]
		);

		// Icon - styling heading.
		$this->add_control(
			'icon_styling_heading',
			[
				'label' => __( 'Icon', 'uael' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// All icon color.
		$this->add_control(
			'all_icon_color',
			[
				'label'     => __( 'Icon Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uael-align-icon--left i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .uael-align-icon--right i' => 'color: {{VALUE}};',
				],
			]
		);

		// All icon size.
		$this->add_responsive_control(
			'all_icon_size',
			[
				'label'     => __( 'Scale', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					// Item.
					'{{WRAPPER}} .uael-align-icon--left i' => 'font-size: {{SIZE}}px;    vertical-align: middle;',
					'{{WRAPPER}} .uael-align-icon--right i' => 'font-size: {{SIZE}}px;vertical-align: middle;',
				],
			]
		);

		// All Icon Position.
		$this->add_control(
			'all_icon_align',
			[
				'label'   => __( 'Icon Position', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Before', 'uael' ),
					'right' => __( 'After', 'uael' ),
				],
			]
		);

		// All Icon Spacing.
		$this->add_responsive_control(
			'all_icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					// Item.
					'{{WRAPPER}} .uael-align-icon--left'  => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .uael-align-icon--right' => 'margin-left: {{SIZE}}px;',
				],
			]
		);

		// Image - Styling heading.
		$this->add_control(
			'image_styling_heading',
			[
				'label'     => __( 'Image', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// All Image Size.
		$this->add_responsive_control(
			'all_image_size',
			[
				'label'      => __( 'Scale', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 30,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors'  => [
					// Item.
					'{{WRAPPER}} .uael-col-img--left'  => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-col-img--right' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// All Image Position.
		$this->add_control(
			'all_image_align',
			[
				'label'   => __( 'Image Position', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Before', 'uael' ),
					'right' => __( 'After', 'uael' ),
				],
			]
		);

		// All Image Size.
		$this->add_responsive_control(
			'all_image_indent',
			[
				'label'     => __( 'Image Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					// Item.
					'{{WRAPPER}} .uael-col-img--left'  => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .uael-col-img--right' => 'margin-left: {{SIZE}}px;',
				],
			]
		);

		// All image border radius.
		$this->add_responsive_control(
			'all_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-col-img--left'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .uael-col-img--right' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Registers all controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_search_controls() {

		// Icon / Image Styling.
		$this->start_controls_section(
			'section_search_style',
			[
				'label' => __( 'Search / Show Entries', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			// All icon color.
			$this->add_control(
				'label_color',
				[
					'label'     => __( 'Label Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-advance-heading label' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'input_color',
				[
					'label'     => __( 'Input Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-advance-heading select, {{WRAPPER}} .uael-advance-heading input' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'label_bg_color',
				[
					'label'     => __( 'Input Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .uael-advance-heading select, {{WRAPPER}} .uael-advance-heading input' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'input_border',
					'label'          => __( 'Input Border', 'uael' ),
					'fields_options' => [
						'border' => [
							'default' => 'solid',
						],
						'width'  => [
							'default' => [
								'top'      => '1',
								'right'    => '1',
								'bottom'   => '1',
								'left'     => '1',
								'isLinked' => true,
							],
						],
						'color'  => [
							'default' => '#bbb',
						],
					],
					'selector'       => '{{WRAPPER}} .uael-advance-heading select, {{WRAPPER}} .uael-advance-heading input',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'label_typography',
					'label'    => __( 'Typography', 'uael' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .uael-advance-heading label, {{WRAPPER}} .uael-advance-heading select, {{WRAPPER}} .uael-advance-heading input',
				]
			);

			// Cell padding.
			$this->add_responsive_control(
				'input_padding',
				[
					'label'      => __( 'Input Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default'    => [
						'top'      => '10',
						'bottom'   => '10',
						'left'     => '10',
						'right'    => '10',
						'unit'     => 'px',
						'isLinked' => false,
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-advance-heading select, {{WRAPPER}} .uael-advance-heading input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// All icon size.
			$this->add_control(
				'input_size',
				[
					'label'     => __( 'Input Size', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 200,
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 400,
							'step' => 1,
						],
					],
					'selectors' => [
						// Item.
						'{{WRAPPER}} .uael-advance-heading select, {{WRAPPER}} .uael-advance-heading input' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);

			// All icon size.
			$this->add_control(
				'bottom_spacing',
				[
					'label'     => __( 'Bottom Space', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 15,
						'unit' => 'px',
					],
					'selectors' => [
						// Item.
						'{{WRAPPER}} .uael-advance-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.1.0
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
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/table-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_0',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=wwu4ZzXrhGc&index=15&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to add rows & columns? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-rows-and-columns-to-the-table/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_3',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to add table header? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-table-header-with-table-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_4',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s How to add content in table cell? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-table-content-with-table-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_5',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Table styling » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-style-the-table/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_6',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Row / Column span » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-merge-columns-and-rows-in-table/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_9',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Custom Column Width » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-custom-width-to-table-columns/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_10',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Create table by uploading CSV » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/create-table-by-uploading-csv/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_11',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Facing issues with CSV import? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/facing-issues-with-csv-import/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_7',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Sortable / Searchable table » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-sortable-and-searchable-table-how-to-show-entries-dropdown/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_8',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Control on table entries display count » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/how-to-add-sortable-and-searchable-table-how-to-show-entries-dropdown/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Function to identify if it is a first row or not.
	 *
	 * If yes returns false no returns true.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function is_invalid_first_row() {

		$settings = $this->get_settings_for_display();

		if ( 'row' === $settings['table_content'][0]['content_type'] ) {
			return false;
		}

		return true;
	}

	/**
	 * Function to get table HTML from csv file.
	 *
	 * Parse CSV to Table
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function parse_csv() {

		$settings = $this->get_settings_for_display();

		if ( 'file' != $settings['source'] ) {
			return [
				'html' => '',
				'rows' => '',
			];
		}
		$response = wp_remote_get(
			$settings['file']['url'],
			array(
				'sslverify' => false,
			)
		);

		if (
			'' == $settings['file']['url'] ||
			is_wp_error( $response ) ||
			200 != $response['response']['code'] ||
			'.csv' !== substr( $settings['file']['url'], -4 )
		) {
			return [
				'html' => __( '<p>Please provide a valid CSV file.</p>', 'uael' ),
				'rows' => '',
			];
		}

		$rows       = [];
		$rows_count = [];
		$upload_dir = wp_upload_dir();
		$file_url   = str_replace( $upload_dir['baseurl'], '', $settings['file']['url'] );

		$file = $upload_dir['basedir'] . $file_url;

		// Attempt to change permissions if not readable.
		if ( ! is_readable( $file ) ) {
			chmod( $file, 0744 );
		}

		// Check if file is writable, then open it in 'read only' mode.
		if ( is_readable( $file ) ) {

			$_file = fopen( $file, 'r' );

			if ( ! $_file ) {
				return [
					'html' => __( "File could not be opened. Check the file's permissions to make sure it's readable by your server.", 'uael' ),
					'rows' => '',
				];
			}

			// To sum this part up, all it really does is go row by row.
			// Column by column, saving all the data.
			$file_data = array();

			// Get first row in CSV, which is of course the headers.
			$header = fgetcsv( $_file );

			// @codingStandardsIgnoreStart
			while ( $row = fgetcsv( $_file ) ) {

				foreach ( $header as $i => $key ) {
					$file_data[ $key ] = $row[ $i ];
				}

				$data[] = $file_data;
			}
			// @codingStandardsIgnoreEnd

			fclose( $_file );

		} else {
			return [
				'html' => __( "File could not be opened. Check the file's permissions to make sure it's readable by your server.", 'uael' ),
				'rows' => '',
			];
		}

		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$rows[ $key ]       = $value;
				$rows_count[ $key ] = count( $value );
			}
		}
		$header_val = array_keys( $rows[0] );

		$return['rows'] = $rows_count;

		$heading_count = 0;

		ob_start();
		?>
		<table <?php echo $this->get_render_attribute_string( 'uael_table_id' ); ?>>
			<thead>
				<?php
				$first_row_h    = true;
				$counter_h      = 1;
				$cell_counter_h = 0;
				$inline_count   = 0;
				$header_text    = array();
				$data_entry     = 0;

				if ( $header_val ) {
					?>
					<tr <?php echo $this->get_render_attribute_string( 'uael_table_row' ); ?>>
					<?php
					foreach ( $header_val as $hkey => $head ) {

						$repeater_heading_text = $this->get_repeater_setting_key( 'heading_text', 'table_headings', $inline_count );
						$this->add_render_attribute( $repeater_heading_text, 'class', 'uael-table__text-inner' );

						// TH.
						if ( true === $first_row_h ) {
							$this->add_render_attribute( 'current_' . $hkey, 'data-sort', $cell_counter_h );
						}
						$this->add_render_attribute( 'current_' . $hkey, 'class', 'sort-this' );
						$this->add_render_attribute( 'current_' . $hkey, 'class', 'elementor-repeater-item-' . $hkey );
						$this->add_render_attribute( 'current_' . $hkey, 'class', 'uael-table-col' );
						// Sort Icon.
						if ( 'yes' === $settings['sortable'] && true === $first_row_h ) {
							$this->add_render_attribute( 'icon_sort_' . $hkey, 'class', 'uael-sort-icon' );
						}

						?>
							<th <?php echo $this->get_render_attribute_string( 'current_' . $hkey ); ?> scope="col">
								<span class="sort-style">
								<span <?php echo $this->get_render_attribute_string( 'uael_table__text' ); ?>>

									<span <?php echo $this->get_render_attribute_string( $repeater_heading_text ); ?>><?php echo $head; ?></span>
								</span>
								<?php if ( 'yes' === $settings['sortable'] && true === $first_row_h ) { ?>
									<span <?php echo $this->get_render_attribute_string( 'icon_sort_' . $hkey ); ?>></span>
								<?php } ?>
								</span>
							</th>
							<?php
							$header_text[ $cell_counter_h ] = $head;
							$cell_counter_h++;

							$counter_h++;
							$inline_count++;
					}
					?>
					</tr>
					<?php
				}
				?>
			</thead>
			<tbody>
				<!-- ROWS -->
				<?php
				$counter           = 1;
				$cell_counter      = 0;
				$cell_inline_count = 0;

				foreach ( $rows as $row_key => $row ) {
					?>
				<tr data-entry="<?php echo $row_key + 1; ?>" <?php echo $this->get_render_attribute_string( 'uael_table_row' ); ?>>
					<?php
					foreach ( $row as $bkey => $col ) {

						// Cell text inline classes.
						$repeater_cell_text = $this->get_repeater_setting_key( 'cell_text', 'table_content', $cell_inline_count );
						$this->add_render_attribute( $repeater_cell_text, 'class', 'uael-table__text-inner' );

						$this->add_render_attribute( 'uael_table_col' . $bkey, 'class', 'uael-table-col' );
						$this->add_render_attribute( 'uael_table_col' . $bkey, 'class', 'elementor-repeater-item-' . $bkey );

						// Fetch corresponding header cell text.
						if ( isset( $header_text[ $cell_counter ] ) && $header_text[ $cell_counter ] ) {
							$this->add_render_attribute( 'uael_table_col' . $bkey, 'data-title', $header_text[ $cell_counter ] );
						}
						?>
						<td <?php echo $this->get_render_attribute_string( 'uael_table_col' . $bkey ); ?>>
							<span <?php echo $this->get_render_attribute_string( 'uael_table__text' ); ?>>

								<span <?php echo $this->get_render_attribute_string( $repeater_cell_text ); ?>><?php echo $col; ?></span>
							</span>
						</td>
						<?php
						// Increment to next cell.
						$cell_counter++;

						$counter++;
						$cell_inline_count++;
					}
					?>
				</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		$html           = ob_get_clean();
		$return['html'] = $html;
		return $return;
	}

	/**
	 * Render Woo Product Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render() {

		$settings  = $this->get_settings_for_display();
		$node_id   = $this->get_id();
		$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();
		ob_start();
		include 'template.php';
		$html = ob_get_clean();
		echo $html;
	}

}
