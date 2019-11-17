<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

/**
 * Elementor category
 */
function htmega_elementor_init_pro(){
    \Elementor\Plugin::instance()->elements_manager->add_category(
        'htmega-addons-pro',
        [
            'title'  => esc_html__( 'HTMega Pro', 'htmega-pro' ),
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','htmega_elementor_init_pro');

/**
* Options return
*/
function htmega_get_option_pro( $option, $section, $default = '' ){
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}