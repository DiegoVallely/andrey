<?php

/*
 * Elementor category
 */
function htmega_elementor_init(){
    \Elementor\Plugin::instance()->elements_manager->add_category(
        'htmega-addons',
        [
            'title'  => 'HTMega Addons',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','htmega_elementor_init');

/*
 * Plugisn Options value
 * return on/off
 */
function htmega_get_option( $option, $section, $default = '' ){

    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

/*
 * Elementor Templates List
 * return array
 */
function htmega_elementor_template() {
    $templates = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
    $types = array();
    if ( empty( $templates ) ) {
        $template_lists = [ '0' => __( 'Do not Saved Templates.', 'htmega-addons' ) ];
    } else {
        $template_lists = [ '0' => __( 'Select Template', 'htmega-addons' ) ];
        foreach ( $templates as $template ) {
            $template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
        }
    }
    return $template_lists;
}

/*
 * Sidebar Widgets List
 * return array
 */
function htmega_sidebar_options() {
    global $wp_registered_sidebars;
    $sidebar_options = array();

    if ( ! $wp_registered_sidebars ) {
        $sidebar_options['0'] = __( 'No sidebars were found', 'htmega-addons' );
    } else {
        $sidebar_options['0'] = __( 'Select Sidebar', 'htmega-addons' );
        foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
            $sidebar_options[ $sidebar_id ] = $sidebar['name'];
        }
    }
    return $sidebar_options;
}

/*
 * Get Taxonomy
 * return array
 */
function htmega_get_taxonomies( $htmega_texonomy = 'category' ){
    $terms = get_terms( array(
        'taxonomy' => $htmega_texonomy,
        'hide_empty' => true,
    ));
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
        return $options;
    }
}

/*
 * Get Post Type
 * return array
 */
function htmega_get_post_types( $args = [] ) {
   
    $post_type_args = [
        'show_in_nav_menus' => true,
    ];
    if ( ! empty( $args['post_type'] ) ) {
        $post_type_args['name'] = $args['post_type'];
    }
    $_post_types = get_post_types( $post_type_args , 'objects' );

    $post_types  = [];
    foreach ( $_post_types as $post_type => $object ) {
        $post_types[ $post_type ] = $object->label;
    }
    return $post_types;
}

/*
 * HTML Tag list
 * return array
 */
function htmega_html_tag_lists() {
    $html_tag_list = [
        'h1'   => __( 'H1', 'htmega-addons' ),
        'h2'   => __( 'H2', 'htmega-addons' ),
        'h3'   => __( 'H3', 'htmega-addons' ),
        'h4'   => __( 'H4', 'htmega-addons' ),
        'h5'   => __( 'H5', 'htmega-addons' ),
        'h6'   => __( 'H6', 'htmega-addons' ),
        'p'    => __( 'p', 'htmega-addons' ),
        'div'  => __( 'div', 'htmega-addons' ),
        'span' => __( 'span', 'htmega-addons' ),
    ];
    return $html_tag_list;
}

/*
 * Contact form list
 * return array
 */
function htmega_contact_form_seven(){
    $countactform = array();
    $htmega_forms_args = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
    $htmega_forms = get_posts( $htmega_forms_args );

    if( $htmega_forms ){
        foreach ( $htmega_forms as $htmega_form ){
            $countactform[$htmega_form->ID] = $htmega_form->post_title;
        }
    }else{
        $countactform[ esc_html__( 'No contact form found', 'htmega-addons' ) ] = 0;
    }
    return $countactform;
}


/*
 * All Post Name
 * return array
 */
function htmega_post_name ( $post_type = 'post' ){
    $options = array();
    $options = ['0' => esc_html__( 'None', 'htmega-addons' )];
    $wh_post = array( 'posts_per_page' => -1, 'post_type'=> $post_type );
    $wh_post_terms = get_posts( $wh_post );
    if ( ! empty( $wh_post_terms ) && ! is_wp_error( $wh_post_terms ) ){
        foreach ( $wh_post_terms as $term ) {
            $options[ $term->ID ] = $term->post_title;
        }
        return $options;
    }
}

/*
 * Caldera Form
 * @return array
 */
function htmega_caldera_forms_options() {
    if ( class_exists( 'Caldera_Forms' ) ) {
        $caldera_forms = Caldera_Forms_Forms::get_forms( true, true );
        $form_options  = ['0' => esc_html__( 'Select Form', 'htmega-addons' )];
        $form          = array();
        if ( ! empty( $caldera_forms ) && ! is_wp_error( $caldera_forms ) ) {
            foreach ( $caldera_forms as $form ) {
                if ( isset($form['ID']) and isset($form['name'])) {
                    $form_options[$form['ID']] = $form['name'];
                }   
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'htmega-addons' ) ];
    }
    return $form_options;
}

/*
 * Check user Login and call this function
 */
global $user;
if ( empty( $user->ID ) ) {
    add_action('elementor/init', 'htmega_ajax_login_init' );
}

/*
 * wp_ajax_nopriv Function
 */
function htmega_ajax_login_init() {
    add_action( 'wp_ajax_nopriv_htmega_ajax_login', 'htmega_ajax_login' );
}

/*
 * ajax login
 */
function htmega_ajax_login(){
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    $user_data = array();
    $user_data['user_login'] = !empty( $_POST['username'] ) ? $_POST['username']: "";
    $user_data['user_password'] = !empty( $_POST['password'] ) ? $_POST['password']: "";
    $user_data['remember'] = true;
    $user_signon = wp_signon( $user_data, false );

    if ( is_wp_error($user_signon) ){
        echo json_encode( [ 'loggeauth'=>false, 'message'=> esc_html__('Invalid username or password!', 'htmega-addons') ] );
    } else {
        echo json_encode( [ 'loggeauth'=>true, 'message'=> esc_html__('Login successfully, Redirecting...', 'htmega-addons') ] );
    }
    die();
}

/*
 * Redirect 404 page select from plugins options
 */
function htmega_redirect_404() {
    $errorpage_id = htmega_get_option( 'errorpage','htmega_general_tabs' );
    if ( is_404() && !empty ( $errorpage_id ) ) {
        wp_redirect( esc_url( get_page_link( $errorpage_id ) ) ); die();
    }
}
add_action('template_redirect','htmega_redirect_404');
