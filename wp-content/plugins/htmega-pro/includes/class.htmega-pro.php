<?php 

if ( ! function_exists('is_plugin_active')) { include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

final class HTMega_Addons_Elementor_Pro {

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'admin_init', [ $this, 'check_plugin_active' ] );
    }

    public function i18n() {
        load_plugin_textdomain( 'htmega-pro' );
    }

    // Check plugins status
    public function check_plugin_active(){
        if( !is_plugin_active( 'ht-mega-for-elementor/htmega_addons_elementor.php' ) ){
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }
    }

    public function is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }

    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $htmega = 'ht-mega-for-elementor/htmega_addons_elementor.php';
        if( $this->is_plugins_active( $htmega ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) { return; }

            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $htmega . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $htmega );

            $message = '<p>' . esc_html__( 'HTMega pro not working because you need to activate the HTMega Absolute Addons plugin.', 'htmega-pro' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Now', 'htmega-pro' ) ) . '</p>';
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) { return; }

            $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=ht-mega-for-elementor' ), 'install-plugin_ht-mega-for-elementor' );

            $message = '<p>' . esc_html__( 'HTMega pro not working because you need to install the HTMega Absolute Addons plugin', 'htmega-pro' ) . '</p>';

            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Now', 'htmega-pro' ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $message . '</p></div>';
    }

}

HTMega_Addons_Elementor_Pro::instance();