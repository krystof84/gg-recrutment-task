<?php

/**
 * Enqueues scripts and styles.
 */
function theme_scripts() {

    // Theme css file
    wp_enqueue_style('bb-style', get_template_directory_uri() . '/style.css', array(), '0.1');   

    // Add google font
    wp_enqueue_style('bb-font-fisrt', 'https://fonts.googleapis.com/css?family=Open+Sans', array(), null);

    // Main css file
    wp_enqueue_style('bb-main', get_template_directory_uri() . '/src/css/main.css', array(), '0.1');

    // Live reload - only dev enviroment
    if($_SERVER['SERVER_NAME'] == 'globegroup') {
        wp_enqueue_script('livereload', 'http://globegroup:35729/livereload.js?snipver=1', null, false, true);
    }
}
add_action( 'wp_enqueue_scripts', 'theme_scripts');


/**
 * Setup theme
 */
if( !function_exists('bb_setup') ) {
    function bb_setup() {
        add_theme_support( 'post-thumbnails' );
        
        register_nav_menu('main-menu', __('Main Menu'));

        add_theme_support( 'custom-logo', array(
            'height'      => 28,
            'width'       => 109,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array( 'site-title', 'site-description' ),
        ) );
    }
}
add_action('after_setup_theme', 'bb_setup')

?>