<?php
/**
 * Testimonial Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_testimonial' ) ) :

function book_landing_page_customize_register_testimonial( $wp_customize ) {

	global $book_landing_page_options_posts;

   /** Testimonial Settings */
    $wp_customize->add_section(
        'book_landing_page_testimonial_settings',
        array(
            'title' => __( 'Testimonial Section', 'book-landing-page' ),
            'priority' => 40,
            'panel' => 'book_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable Testimonial Section */
    $wp_customize->add_setting(
        'book_landing_page_ed_testimonial_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_testimonial_section',
        array(
            'label' => __( 'Enable Testimonial Section', 'book-landing-page' ),
            'section' => 'book_landing_page_testimonial_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Testimonial Section Title */
    $wp_customize->add_setting(
        'book_landing_page_testimonial_section_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_testimonial_section_title',
        array(
            'label' => __( 'Testimonial Section Title', 'book-landing-page' ),
            'section' => 'book_landing_page_testimonial_settings',
            'type' => 'text',
        )
    );
    
    /** Testimonial Section Content */
    $wp_customize->add_setting(
        'book_landing_page_testimonial_section_content',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_testimonial_section_content',
        array(
            'label' => __( 'Testimonial Section Content', 'book-landing-page' ),
            'section' => 'book_landing_page_testimonial_settings',
            'type' => 'text',
        )
    );

    /** Testimonial Post One */
    $wp_customize->add_setting(
        'book_landing_page_testimonial_block_one',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_testimonial_block_one',
        array(
            'label' => __( 'Select Testimonial Post One', 'book-landing-page' ),
            'section' => 'book_landing_page_testimonial_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    
    /** Testimonial Post Two */
    $wp_customize->add_setting(
        'book_landing_page_testimonial_block_two',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_testimonial_block_two',
        array(
            'label' => __( 'Select Testimonial Post Two', 'book-landing-page' ),
            'section' => 'book_landing_page_testimonial_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );
    /** Testimonial Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_testimonial' );