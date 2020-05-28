<?php
/**
 * About Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_about' ) ) :

function book_landing_page_customize_register_about( $wp_customize ) {

	global $book_landing_page_options_posts;

    /** About Section */
    $wp_customize->add_section(
        'book_landing_page_about_settings',
        array(
            'title'    => __( 'About Section', 'book-landing-page' ),
            'priority' => 70,
            'panel'    => 'book_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable About Section */
    $wp_customize->add_setting(
        'book_landing_page_ed_about_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_about_section',
        array(
            'label' => __( 'Enable About Section', 'book-landing-page' ),
            'section' => 'book_landing_page_about_settings',
            'type' => 'checkbox',
        )
    );
    
    /** About Section Title */
    $wp_customize->add_setting(
        'book_landing_page_about_section_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_about_section_title',
        array(
            'label' => __( 'About Section Title', 'book-landing-page' ),
            'section' => 'book_landing_page_about_settings',
            'type' => 'text',
        )
    );
    
    /** About Section Content */
    $wp_customize->add_setting(
        'book_landing_page_about_section_content',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_about_section_content',
        array(
            'label' => __( 'About Section Content', 'book-landing-page' ),
            'section' => 'book_landing_page_about_settings',
            'type' => 'text',
        )
    );

    
    /** About Video Link */
    $wp_customize->add_setting(
        'book_landing_page_about_video',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_iframe',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_about_video',
        array(
            'label' => __( 'About Video Embed Link', 'book-landing-page' ),
            'section' => 'book_landing_page_about_settings',
            'type' => 'text',
        )
    );

    /** About Post */
    $wp_customize->add_setting(
        'book_landing_page_about_section_post',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_about_section_post',
        array(
            'label' => __( 'Select Post', 'book-landing-page' ),
            'section' => 'book_landing_page_about_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );
    /** About Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_about' );