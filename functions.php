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

        // Register custom post type: testowy
        register_post_type( 'testowy',
            array(
                'labels' => array(
                    'name' => __( 'testowy' ),
                    'singular_name' => __( 'testowy' )
                ),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 5,
                'supports' => array(
                    'title', 'editor', 'thumbnail'
                ),
                'taxonomies' => array(
                    'category'
                ),
            )
        );

        // Register custom taxonomy for custom post: testowy
        register_taxonomy(
            'kategoria', 
            'testowy',
            array(  
                'hierarchical' => true,  
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'kategoria', 
                    'with_front' => false  
                )
            )  
        );
    }
}
add_action('after_setup_theme', 'bb_setup');

/**
 * Register Widgets
 */
function bb_widgets_init() {
    register_sidebar( array(
        'name'          => 'Footer 1',
        'id'            => 'bb-footer-widget-1',
        'before_widget' => '<div class="footer__widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<p class="footer__widget-title">',
        'after_title'   => '</p>',
    ) );

    register_sidebar( array(
        'name'          => 'Footer 2',
        'id'            => 'bb-footer-widget-2',
        'before_widget' => '<div class="footer__widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<p class="footer__widget-title">',
        'after_title'   => '</p>',
    ) );

    register_sidebar( array(
        'name'          => 'Footer 3',
        'id'            => 'bb-footer-widget-3',
        'before_widget' => '<div class="footer__widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<p class="footer__widget-title">',
        'after_title'   => '</p>',
    ) );
}
add_action('widgets_init', 'bb_widgets_init');

?>