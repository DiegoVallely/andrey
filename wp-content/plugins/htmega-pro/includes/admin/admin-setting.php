<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class HTmega_Admin_Settings_Pro {

    private $settings_api;

    function __construct() {
        $this->settings_api = new HTmega_Settings_API;

        if( class_exists('HTMega_Template_Library') ){
            HTMega_Template_Library::instance()->set_api_endpoint( 'https://demo.hasthemes.com/api/htmega/layouts-pro-98em9JP9/layoutinfopro.json' );
            HTMega_Template_Library::instance()->set_api_templateapi( 'https://demo.hasthemes.com/api/htmega/layouts-pro-98em9JP9/%s.json' );
        }

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 220 );

        add_action( 'wsa_form_top_htmega_element_tabs', array( $this, 'html_element_toogle_button' ) );
        add_action( 'wsa_form_top_htmega_thirdparty_element_tabs', array( $this, 'html_element_toogle_button' ) );
        add_action( 'wsa_form_bottom_htmega_pro_vs_free_tabs', array( $this, 'pro_vs_free_html_tabs' ) );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->htmega_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->htmega_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }
    
    // Plugins menu Register
    function admin_menu() {

        $menu = 'add_menu_' . 'page';
        $menu(
            'htmega_panel',
            esc_html__( 'HTMega Addons', 'htmega-pro' ),
            esc_html__( 'HTMega Addons', 'htmega-pro' ),
            'htmega_addons_option_page',
            NULL,
            HTMEGA_ADDONS_PL_URL.'admin/assets/images/menu-icon.png',
            59
        );
        
        add_submenu_page(
            'htmega_addons_option_page', 
            esc_html__( 'Settings', 'htmega-pro' ),
            esc_html__( 'Settings', 'htmega-pro' ),
            'manage_options', 
            'htmega_addons_options', 
            array ( $this, 'plugin_page' ) 
        );

    }

    // Options page Section register
    function htmega_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'htmega_pro_vs_free_tabs',
                'title' => esc_html__( 'General', 'htmega-pro' )
            ),
            array(
                'id'    => 'htmega_element_tabs',
                'title' => esc_html__( 'Elements', 'htmega-pro' )
            ),
            
            array(
                'id'    => 'htmega_thirdparty_element_tabs',
                'title' => esc_html__( 'Third Party', 'htmega-pro' )
            ),

            array(
                'id'    => 'htmega_general_tabs',
                'title' => esc_html__( 'Other options', 'htmega-pro' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function htmega_admin_fields_settings() {

        $settings_fields = array(

            'htmega_general_tabs'=>array(

                array(
                    'name'  => 'google_map_api_key',
                    'label' => esc_html__( 'Google Map Api Key', 'htmega-pro' ),
                    'desc' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s', esc_html__( 'Go to', 'htmega-pro' ), esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key' ), esc_html__( 'https://developers.google.com', 'htmega-pro' ), esc_html__( 'and generate the API key.', 'htmega-pro' ) ),
                    'placeholder' => esc_html__( 'Google Map Api key', 'htmega-pro' ),
                    'type' => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                array(
                    'name'    => 'errorpage',
                    'label'   => esc_html__( 'Select 404 Page.', 'htmega-pro' ),
                    'desc'    => esc_html__( 'You can select 404 page from here.', 'htmega-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => htmega_post_name('page')
                ),

            ),

            'htmega_element_tabs'=>array(

                array(
                    'name'  => 'accordion',
                    'label'  => esc_html__( 'Accordion', 'htmega-pro' ),
                    'desc'  => esc_html__( 'Accordion', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'animatesectiontitle',
                    'label'  => esc_html__( 'Animate Heading', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'addbanner',
                    'label'  => esc_html__( 'Add Banner', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'blockquote',
                    'label'  => esc_html__( 'Blockquote', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'brandlogo',
                    'label'  => esc_html__( 'Brands', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'businesshours',
                    'label'  => esc_html__( 'Business Hours', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'button',
                    'label'  => esc_html__( 'Button', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'calltoaction',
                    'label'  => esc_html__( 'Call To Action', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'carousel',
                    'label'  => esc_html__( 'Carousel', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'countdown',
                    'label'  => esc_html__( 'Countdown', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'counter',
                    'label'  => esc_html__( 'Counter', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'customevent',
                    'label'  => esc_html__( 'Custom Event', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'dualbutton',
                    'label'  => esc_html__( 'Double Button', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'dropcaps',
                    'label'  => esc_html__( 'Dropcaps', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'flipbox',
                    'label'  => esc_html__( 'Flip Box', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'galleryjustify',
                    'label'  => esc_html__( 'Gallery Justify', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'googlemap',
                    'label'  => esc_html__( 'Google Map', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'imagecomparison',
                    'label'  => esc_html__( 'Image Comparison', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'imagegrid',
                    'label'  => esc_html__( 'Image Grid', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'imagemagnifier',
                    'label'  => esc_html__( 'Image Magnifier', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'imagemarker',
                    'label'  => esc_html__( 'Image Marker', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'imagemasonry',
                    'label'  => esc_html__( 'Image Masonry', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'inlinemenu',
                    'label'  => esc_html__( 'Inline Navigation', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'instagram',
                    'label'  => esc_html__( 'Instagram', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'lightbox',
                    'label'  => esc_html__( 'Light Box', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'modal',
                    'label'  => esc_html__( 'Modal', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'newtsicker',
                    'label'  => esc_html__( 'News Ticker', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'notify',
                    'label'  => esc_html__( 'Notify', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'offcanvas',
                    'label'  => esc_html__( 'Offcanvas', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'panelslider',
                    'label'  => esc_html__( 'Panel Slider', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'popover',
                    'label'  => esc_html__( 'Popover', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'postcarousel',
                    'label'  => esc_html__( 'Post carousel', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'postgrid',
                    'label'  => esc_html__( 'Post Grid', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'postgridtab',
                    'label'  => esc_html__( 'Post Grid Tab', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'postslider',
                    'label'  => esc_html__( 'Post Slider', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'pricinglistview',
                    'label'  => esc_html__( 'Pricing List View', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'pricingtable',
                    'label'  => esc_html__( 'Pricing Table', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'progressbar',
                    'label'  => esc_html__( 'Progress Bar', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'scrollimage',
                    'label'  => esc_html__( 'Scroll Image', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'scrollnavigation',
                    'label'  => esc_html__( 'Scroll Navigation', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'search',
                    'label'  => esc_html__( 'Search', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'sectiontitle',
                    'label'  => esc_html__( 'Section Title', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'service',
                    'label'  => esc_html__( 'Service', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'singlepost',
                    'label'  => esc_html__( 'Single Post', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),
                
                array(
                    'name'  => 'thumbgallery',
                    'label'  => esc_html__( 'Slider Thumbnail Gallery', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'socialshere',
                    'label'  => esc_html__( 'Social Share', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'switcher',
                    'label'  => esc_html__( 'Switcher', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'tabs',
                    'label'  => esc_html__( 'Tabs', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'datatable',
                    'label'  => esc_html__( 'Data Table', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'teammember',
                    'label'  => esc_html__( 'Team Member', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'testimonial',
                    'label'  => esc_html__( 'Testimonial', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'testimonialgrid',
                    'label'  => esc_html__( 'Testimonial Grid', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'toggle',
                    'label'  => esc_html__( 'Toggle', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'tooltip',
                    'label'  => esc_html__( 'Tooltip', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'on',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'twitterfeed',
                    'label'  => esc_html__( 'Twitter Feed', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'userloginform',
                    'label'  => esc_html__( 'User Login Form', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'userregisterform',
                    'label'  => esc_html__( 'User Register Form', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'verticletimeline',
                    'label'  => esc_html__( 'Verticle Timeline', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'videoplayer',
                    'label'  => esc_html__( 'Video Player', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'workingprocess',
                    'label'  => esc_html__( 'Working Process', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

                array(
                    'name'  => 'errorcontent',
                    'label'  => esc_html__( '404 Content', 'htmega-pro' ),
                    'type'  => 'checkbox',
                    'default'=>'off',
                    'class'=>'htmega_table_row',
                ),

            ),
        );
        
        // Third Party Addons
        $third_party_element = array();
        if( is_plugin_active('bbpress/bbpress.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'bbpress',
                'label'    => esc_html__( 'bbPress', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('booked/booked.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'bookedcalender',
                'label'    => esc_html__( 'Booked Calender', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('buddypress/bp-loader.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'buddypress',
                'label'    => esc_html__( 'BuddyPress', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('caldera-forms/caldera-core.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'calderaform',
                'label'    => esc_html__( 'Caldera Form', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'contactform',
                'label'    => esc_html__( 'Contact form 7', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('download-monitor/download-monitor.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'downloadmonitor',
                'label'    => esc_html__( 'Download Monitor', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('easy-digital-downloads/easy-digital-downloads.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'easydigitaldownload',
                'label'    => esc_html__( 'Easy Digital Downloads', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('gravityforms/gravityforms.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'gravityforms',
                'label'    => esc_html__( 'Gravity Forms', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('instagram-feed/instagram-feed.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'instragramfeed',
                'label'    => esc_html__( 'Instragram Feed', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('wp-job-manager/wp-job-manager.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'jobmanager',
                'label'    => esc_html__( 'Job Manager', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('LayerSlider/layerslider.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'layerslider',
                'label'    => esc_html__( 'Job Manager', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'mailchimpwp',
                'label'    => esc_html__( 'Mailchimp for wp', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('ninja-forms/ninja-forms.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'ninjaform',
                'label'    => esc_html__( 'Ninja Form', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('quform/quform.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'quforms',
                'label'    => esc_html__( 'QU Form', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('wpforms-lite/wpforms.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'wpforms',
                'label'    => esc_html__( 'WP Form', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('revslider/revslider.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'revolution',
                'label'    => esc_html__( 'Revolution Slider', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('tablepress/tablepress.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'tablepress',
                'label'    => esc_html__( 'TablePress', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('awesome-weather/awesome-weather.php') ) {
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'  => 'weather',
                'label'  => esc_html__( 'Weather', 'htmega-pro' ),
                'type'  => 'checkbox',
                'default'=>'on',
                'class'=>'htmega_table_row',
            ];
        }

        if( is_plugin_active('woocommerce/woocommerce.php') ) {
           
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'wcaddtocart',
                'label'    => esc_html__( 'WC : Add To cart', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'categories',
                'label'    => esc_html__( 'WC : Categories', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'name'    => 'wcpages',
                'label'    => esc_html__( 'WC : Pages', 'htmega-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'=>'htmega_table_row',
            ];

        }

        return array_merge($settings_fields, $third_party_element);
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'HTMega Addons Settings','htmega-pro' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'htmega-pro') ?></strong></p>
            </div>
            
            <?php
        }
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = [];
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }

    // Element Toogle Button
    function html_element_toogle_button(){
        ob_start();
        ?>
            <span class="htmega-open-element-toggle"><?php esc_html_e( 'Toggle All', 'htmega-pro' );?></span>
        <?php
        echo ob_get_clean();
    }

    // General tab
    function pro_vs_free_html_tabs(){
        ob_start();
        ?>
            <div class="htmega-general-tabs">

                <div class="htmega-document-section">
                    <div class="htmega-column">
                        <a href="https://hasthemes.com/blog-category/ht-mega/" target="_blank">
                            <img src="<?php echo HTMEGA_ADDONS_PL_URL; ?>/admin/assets/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', 'htmega-pro' ); ?>">
                        </a>
                    </div>
                    <div class="htmega-column">
                        <a href="https://demo.hasthemes.com/doc/htmega/index.html" target="_blank">
                            <img src="<?php echo HTMEGA_ADDONS_PL_URL; ?>/admin/assets/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', 'htmega-pro' ); ?>">
                        </a>
                    </div>
                    <div class="htmega-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo HTMEGA_ADDONS_PL_URL; ?>/admin/assets/images/genral-contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', 'htmega-pro' ); ?>">
                        </a>
                    </div>
                </div>

            </div>
        <?php
        echo ob_get_clean();
    }


}

new HTmega_Admin_Settings_Pro();