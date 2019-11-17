<?php
 
if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

final class HTMega_Addons_Elementor {
    
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    public function i18n() {
        load_plugin_textdomain( 'htmega-addons' );
    }

    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Plugins Required File
        $this->includes();

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
    }

    public function is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }

    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $elementor = 'elementor/elementor.php';
        if( $this->is_plugins_active( $elementor ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) { return; }

            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );

            $message = '<p>' . __( 'HTMEGA Addons not working because you need to activate the Elementor plugin.', 'htmega-addons' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Elementor Activate Now', 'htmega-addons' ) ) . '</p>';
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) { return; }

            $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

            $message = '<p>' . __( 'HTMEGA Addons not working because you need to install the Elementor plugin', 'htmega-addons' ) . '</p>';

            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Elementor Install Now', 'htmega-addons' ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $message . '</p></div>';
    }

    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            __( '"%1$s" requires "%2$s" version %3$s or greater.', 'htmega-addons' ),
            '<strong>' . __( 'HTMega Addons', 'htmega-addons' ) . '</strong>',
            '<strong>' . __( 'Elementor', 'htmega-addons' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            __( '"%1$s" requires "%2$s" version %3$s or greater.', 'htmega-addons' ),
            '<strong>' . __( 'HTMega Addons', 'htmega-addons' ) . '</strong>',
            '<strong>' . __( 'PHP', 'htmega-addons' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function init_widgets() {
        // Include Widget files
        require_once( HTMEGA_ADDONS_PL_PATH . 'includes/widgets_control.php' );
    }

    public function init_controls() {}

    public function includes() {
        // Include files
        require_once ( HTMEGA_ADDONS_PL_PATH.'includes/helper-function.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH.'admin/admin-init.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH.'includes/init.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH.'includes/class.htmega-icon-manager.php' );
    }

}

HTMega_Addons_Elementor::instance();