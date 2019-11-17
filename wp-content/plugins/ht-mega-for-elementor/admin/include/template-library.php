<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class HTMega_Template_Library{

    const TRANSIENT_KEY = 'htmega_template_info';

    public static $endpoint = 'https://demo.hasthemes.com/api/htmega/layouts-free/layoutinfofree.json';
    public static $templateapi = 'https://demo.hasthemes.com/api/htmega/layouts-free/%s.json';

    public static $api_args = [];

    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct(){
        if ( is_admin() ) {
            add_action( 'admin_menu', [ $this, 'admin_menu' ], 225 );
            add_action( 'wp_ajax_htmega_ajax_request', [ $this, 'templates_ajax_request' ] );
            add_action( 'wp_ajax_nopriv_htmega_ajax_request', [ $this, 'templates_ajax_request' ] );
        }
        add_action( 'admin_enqueue_scripts', [ $this, 'scripts' ] );

        self::$api_args = [
            'plugin_version' => HTMEGA_VERSION,
            'url'            => home_url(),
        ];

    }

    // Setter Endpoint
    function set_api_endpoint( $endpoint ){
        self::$endpoint = $endpoint;
    }
    
    // Setter Template API
    function set_api_templateapi( $templateapi ){
        self::$templateapi = $templateapi;
    }

    // Plugins Library Register
    function admin_menu() {
        add_submenu_page(
            'htmega_addons_option_page', 
            __( 'Templates Library', 'htmega-addons' ),
            __( 'Templates Library', 'htmega-addons' ), 
            'manage_options', 
            'htmega_addons_templates_library', 
            array ( $this, 'library_render_html' ) 
        );
    }

    function library_render_html(){
        require_once HTMEGA_ADDONS_PL_PATH . 'admin/include/templates_list.php';
    }

    public static function request_remote_templates_info( $force_update ) {
        global $wp_version;
        $body_args = apply_filters( 'htmegatemplates/api/get_templates/body_args', self::$api_args );
        $request = wp_remote_get(
            self::$endpoint,
            [
                'timeout'    => $force_update ? 25 : 10,
                'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
                'body'       => $body_args,
            ]
        );
        $response = json_decode( wp_remote_retrieve_body( $request ), true );
        return $response;
    }

    /**
     * Retrieve template library and save as a transient.
     */
    public static function set_templates_info( $force_update = true ) {
        $transient = get_transient( self::TRANSIENT_KEY );

        if ( ! $transient || $force_update ) {
            $info = self::request_remote_templates_info( $force_update );
            set_transient( self::TRANSIENT_KEY, $info, DAY_IN_SECONDS );
        }
    }

    /**
     * Get template info.
     */
    public function get_templates_info( $force_update = true ) {
        if ( ! get_transient( self::TRANSIENT_KEY ) || $force_update ) {
            self::set_templates_info( true );
        }
        return get_transient( self::TRANSIENT_KEY );
    }

    /**
     * Admin Scripts.
     */
    public function scripts( $hook ) {

        // wp core styles
        wp_enqueue_style( 'wp-jquery-ui-dialog' );
        // wp core scripts
        wp_enqueue_script( 'jquery-ui-dialog' );
        
        wp_enqueue_script(
            'htmega-admin',
            HTMEGA_ADDONS_PL_URL . 'admin/assets/js/admin.js',
            [
                'jquery',
            ],
            true
        );
        
        if( 'htmega-addons_page_htmega_addons_templates_library' == $hook ){

            // CSS
            wp_enqueue_style( 'htmega-stapel', HTMEGA_ADDONS_PL_URL . 'admin/assets/lib/css/stapel.css', false, HTMEGA_VERSION );

            wp_enqueue_script(
                'htmega-modernizr',
                HTMEGA_ADDONS_PL_URL . 'admin/assets/lib/js/modernizr.custom.63321.js',
                [
                    'jquery',
                ],
                false
            );

            wp_enqueue_script(
                'htmega-stapel',
                HTMEGA_ADDONS_PL_URL . 'admin/assets/lib/js/jquery.stapel.js',
                [
                    'jquery',
                ],
                true
            );

            // JS
            wp_enqueue_script(
                'htmega-templates',
                HTMEGA_ADDONS_PL_URL . 'admin/assets/js/admin-ajax.js',
                [
                    'jquery',
                ],
                true
            );

        }
        $current_user = wp_get_current_user();

        wp_localize_script(
            'htmega-templates',
            'HTTM',
            [
                'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                'adminURL'         => admin_url(),
                'elementorURL'     => admin_url( 'edit.php?post_type=elementor_library' ),
                'version'          => HTMEGA_VERSION,
                'pluginURL'        => plugin_dir_url( __FILE__ ),
                'packagedesc'      => __( 'Templates in this package', 'htmega-addons' ),
                'user'             => [
                    'email' => $current_user->user_email,
                ]
            ]
        );

    }

    /**
     * Ajax request.
     */
    function templates_ajax_request(){

        if ( isset( $_REQUEST ) ) {

            $template_id = $_REQUEST['httemplateid'];
            $page_title = $_REQUEST['pagetitle'];

            $templateurl = sprintf( self::$templateapi, $template_id );

            $response_data = $this->templates_get_content_remote_request( $templateurl );

            $defaulttitle = !empty( $response_data['title'] ) ? $response_data['title'] : __( 'New Template', 'htmega-addons' );

            $args = [
                'post_type'    => !empty( $page_title ) ? 'page' : 'elementor_library',
                'post_status'  => !empty( $page_title ) ? 'draft' : 'publish',
                'post_title'   => !empty( $page_title ) ? $page_title : $defaulttitle,
                'post_content' => '',
            ];
            $new_post_id = wp_insert_post( $args );

            update_post_meta( $new_post_id, '_elementor_data', $response_data['content'] );
            update_post_meta( $new_post_id, '_elementor_page_settings', $response_data['page_settings'] );
            update_post_meta( $new_post_id, '_elementor_template_type', $response_data['type'] );
            update_post_meta( $new_post_id, '_elementor_edit_mode', 'builder' );

            if ( $new_post_id && ! is_wp_error( $new_post_id ) ) {
                update_post_meta( $new_post_id, '_wp_page_template', ! empty( $response_data['page_template'] ) ? $response_data['page_template'] : 'elementor_header_footer' );
            }

            echo json_encode(
                array( 
                    'id' => $new_post_id,
                    'edittxt' => !empty( $page_title ) ? esc_html__( 'Edit Page', 'htmega-addons' ) : esc_html__( 'Edit Template', 'htmega-addons' )
                )
            );
        }

        wp_die();
    }

    function templates_get_content_remote_request( $templateurl ){
        $url = $templateurl;
        $response = wp_remote_get( $url, array(
            'timeout'   => 60,
            'sslverify' => false
        ) );
        $result = json_decode( wp_remote_retrieve_body( $response ), true );
        return $result;
    }


}

HTMega_Template_Library::instance();