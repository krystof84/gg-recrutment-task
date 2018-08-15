<?php

/**
 * Enqueues scripts and styles.
 */
function theme_scripts() {

    // Theme css file
    wp_enqueue_style('bb-style', get_template_directory_uri() . '/style.css', array(), '0.1');   

    // Add google font
    wp_enqueue_style('bb-font-fisrt', 'https://fonts.googleapis.com/css?family=Open+Sans', array(), null);

    // Add FontAwesome
    wp_enqueue_style('bb-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); 

    // Main css file
    wp_enqueue_style('bb-main', get_template_directory_uri() . '/src/css/main.css', array(), '0.1');

    // Live reload - only dev enviroment
    if($_SERVER['SERVER_NAME'] == 'globegroup') {
        wp_enqueue_script('livereload', 'http://globegroup:35729/livereload.js?snipver=1', null, false, true);
    }
}
add_action( 'wp_enqueue_scripts', 'theme_scripts');


function theme_admin_scripts() {

    wp_enqueue_script('bb-main-script', get_template_directory_uri() . '/src/js/main-admin.js', array('jquery'), '0.3', true);

}
add_action( 'admin_enqueue_scripts', 'theme_admin_scripts' );

/********* TinyMCE Buttons ***********/
if ( ! function_exists( 'mytheme_buttons' ) ) {
    function mytheme_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }
 
        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }
 
        add_filter( 'mce_external_plugins', 'mytheme_add_buttons' );
        add_filter( 'mce_buttons', 'mytheme_register_buttons' );
    }
}
 
if ( ! function_exists( 'mytheme_add_buttons' ) ) {
    function mytheme_add_buttons( $plugin_array ) {
        $plugin_array['mybutton'] = get_template_directory_uri().'/src/js/tinymce_buttons.js';
        return $plugin_array;
    }
}
 
if ( ! function_exists( 'mytheme_register_buttons' ) ) {
    function mytheme_register_buttons( $buttons ) {
        array_push( $buttons, 'mybutton' );
        return $buttons;
    }
}
 
add_action ( 'after_wp_tiny_mce', 'mytheme_tinymce_extra_vars' );
 
if ( !function_exists( 'mytheme_tinymce_extra_vars' ) ) {
	function mytheme_tinymce_extra_vars() { ?>
		<script type="text/javascript">
			var tinyMCE_object = <?php echo json_encode(
				array(
					'button_name' => esc_html__('Add Banner !', 'mythemeslug'),
					'button_title' => esc_html__('Banner configurator', 'mythemeslug'),
					'image_title' => esc_html__('Image', 'mythemeslug'),
					'image_button_title' => esc_html__('Upload image', 'mythemeslug'),
				)
				);
			?>;
		</script><?php
	}
}

// add_action ( 'admin_enqueue_scripts', function () {
//     if (is_admin ())
//         wp_enqueue_media ();
// } );







// Add Shortcode: banner
function custom_shortcode( $atts ) {


	$atts = shortcode_atts(
		array(
			'src' => '',
            'title' => '',
            'link' => '',
            'desc' => '',
		),
        $atts,
        'banner'
    );
    
    $output = '<div class="cta">
                <div class="cta__icon">
                    <img src="'. $atts['src'] .'">
                </div>
                <div class="cta__text">
                    <p class="cta__heading">
                        <a href="' . $atts['link'] . '">
                            ' . $atts['title'] . ' <i class="cta__arrow fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </p>
                    <p class="cta__description">'. $atts['desc'] .'</p>
                </div>
            </div>';

    return $output;

}
add_shortcode( 'banner', 'custom_shortcode' );

/**
 * Setup theme
 */
if( !function_exists('gg_setup') ) {
    function gg_setup() {
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
                    'category', 'post_tag'
                ),
                'register_meta_box_cb' => 'gg_add_metabox_excerpt',
            )
        );

        // Register custom metabox excerpt for post type: testowy
        function gg_add_metabox_excerpt() {
            add_meta_box(
                'gg_single_excerpt',
                'Excerpt',
                'gg_create_field_excerpt',
                'testowy',
                'normal',
                'high'
            );
        }

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

        register_taxonomy('tag','testowy',array(
            'hierarchical' => false,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array( 'slug' => 'tag' ),
        ));

        // Generate HTML for custom metabox
        function gg_create_field_excerpt() {
            global $post;
      
            wp_nonce_field( basename( __FILE__ ), 'single_excerpt' );

         
            $singleExcerpt = get_post_meta( $post->ID, 'singleExcerpt', true );
         
            echo '<textarea name="singleExcerpt" rows="5" class="widefat">' . esc_textarea( $singleExcerpt ) . '</textarea>';
        }
        // Save the metabox data
        function gg_save_excerpt_meta( $post_id, $post ) {
           
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
     
            if ( ! isset( $_POST['singleExcerpt'] ) || ! wp_verify_nonce( $_POST['single_excerpt'], basename(__FILE__) ) ) {
                return $post_id;
            }

            $events_meta['singleExcerpt'] = esc_textarea( $_POST['singleExcerpt'] );
            foreach ( $events_meta as $key => $value ) :
                if ( 'revision' === $post->post_type ) {
                    return;
                }
                if ( get_post_meta( $post_id, $key, false ) ) {
                    update_post_meta( $post_id, $key, $value );
                } else {
                    add_post_meta( $post_id, $key, $value);
                }
                if ( ! $value ) {
                    delete_post_meta( $post_id, $key );
                }
            endforeach;
        }
        add_action( 'save_post', 'gg_save_excerpt_meta', 1, 2 );

        // Image Sizes
        add_image_size('gg-post-thumbnail', 769, 409, true);

        add_action( 'init', 'mytheme_buttons' );
    }
}
add_action('after_setup_theme', 'gg_setup');

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

    register_sidebar( array(
        'name'          => 'Testimonial',
        'id'            => 'bb-single-widget-1',
        'before_widget' => '<div class="testimonial">',
        'after_widget'  => '</div>',
    ) );
}
add_action('widgets_init', 'bb_widgets_init');

?>