<?php
/**
 * Breadcrumb Options
 *
 * @package Book_Landing_Page
 */

if ( ! function_exists( 'book_landing_page_customize_register_breadcrumb' ) ) :

function book_landing_page_customize_register_breadcrumb( $wp_customize ) {    /** BreadCrumb Settings */
    $wp_customize->add_section(
        'book_landing_page_breadcrumb_settings',
        array(
            'title' => __( 'Breadcrumb Settings', 'book-landing-page' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting(
        'book_landing_page_ed_breadcrumb',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_breadcrumb',
        array(
            'label' => __( 'Enable Breadcrumb', 'book-landing-page' ),
            'section' => 'book_landing_page_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Current */
    $wp_customize->add_setting(
        'book_landing_page_ed_current',
        array(
            'default' => '1',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_current',
        array(
            'label' => __( 'Show current', 'book-landing-page' ),
            'section' => 'book_landing_page_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Home Text */
    $wp_customize->add_setting(
        'book_landing_page_breadcrumb_home_text',
        array(
            'default' => __( 'Home', 'book-landing-page' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_breadcrumb_home_text',
        array(
            'label' => __( 'Breadcrumb Home Text', 'book-landing-page' ),
            'section' => 'book_landing_page_breadcrumb_settings',
            'type' => 'text',
        )
    );
    
    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'book_landing_page_breadcrumb_separator',
        array(
            'default' => '>',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_breadcrumb_separator',
        array(
            'label' => __( 'Breadcrumb Separator', 'book-landing-page' ),
            'section' => 'book_landing_page_breadcrumb_settings',
            'type' => 'text',
        )
    );
    /** BreadCrumb Settings Ends */
 }
endif;
 add_action( 'customize_register', 'book_landing_page_customize_register_breadcrumb' );