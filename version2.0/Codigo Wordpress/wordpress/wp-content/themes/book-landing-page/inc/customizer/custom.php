<?php
/**
 * Custom Options
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_custom' ) ) :

function book_landing_page_customize_register_custom( $wp_customize ) {
    
    /** Custom CSS*/
    $wp_customize->add_section(
        'book_landing_page_custom_settings',
        array(
            'title' => __( 'Custom CSS Settings', 'book-landing-page' ),
            'priority' => 90,
            'capability' => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_setting(
        'book_landing_page_custom_css',
        array(
            'default' => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_strip_all_tags'
            )
    );
    
    $wp_customize->add_control(
        'book_landing_page_custom_css',
        array(
            'label' => __( 'Custom CSS', 'book-landing-page' ),
            'section' => 'book_landing_page_custom_settings',
            'description' => __( 'Put your custom CSS', 'book-landing-page' ),
            'type' => 'textarea',
        )
    );
    /** Custom CSS Ends */
    
 }
endif;
 add_action( 'customize_register', 'book_landing_page_customize_register_custom' );