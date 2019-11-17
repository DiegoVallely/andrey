<?php

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class HTMega_Admin_Setting{

    public function __construct(){
        add_action('admin_enqueue_scripts', array( $this, 'htmega_enqueue_admin_scripts' ) );
        $this->HTMega_Admin_Settings_page();
    }

    /*
    *  Setting Page
    */
    public function HTMega_Admin_Settings_page() {
        require_once('include/class.settings-api.php');
        require_once('include/template-library.php');
        if( is_plugin_active('htmega-pro/htmega_pro.php') ){
            require_once HTMEGA_ADDONS_PL_PATH_PRO.'includes/admin/admin-setting.php';
        }else{
            require_once( 'include/admin-setting.php' );
        }
    }

    /*
    *   Enqueue admin scripts
    */
    public function htmega_enqueue_admin_scripts(){
        wp_enqueue_style( 'htmega-admin', HTMEGA_ADDONS_PL_URL . 'admin/assets/css/htmega_admin.css', false, HTMEGA_VERSION );
    }

}

new HTMega_Admin_Setting();