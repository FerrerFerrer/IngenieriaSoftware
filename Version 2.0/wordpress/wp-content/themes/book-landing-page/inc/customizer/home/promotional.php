<?php
/**
 * Promotional Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_promotional' ) ) :

function book_landing_page_customize_register_promotional( $wp_customize ) {

	global $book_landing_page_options_posts;

    /** Promotional Section */
    $wp_customize->add_section(
        'book_landing_page_promotional_settings',
        array(
            'title'    => __( 'Promotional Section', 'book-landing-page' ),
            'priority' => 80,
            'panel'    => 'book_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable promotional Section */
    $wp_customize->add_setting(
        'book_landing_page_ed_promotional_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_promotional_section',
        array(
            'label' => __( 'Enable Promotional Section', 'book-landing-page' ),
            'section' => 'book_landing_page_promotional_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Promotional Post */
    $wp_customize->add_setting(
        'book_landing_page_promotional_section_post',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_promotional_section_post',
        array(
            'label' => __( 'Select Post', 'book-landing-page' ),
            'section' => 'book_landing_page_promotional_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Promotional Section Button URL */
    $wp_customize->add_setting(
        'book_landing_page_promotional_section_button',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_promotional_section_button',
        array(
            'label' => __( 'Promotional Section Button Link', 'book-landing-page' ),
            'section' => 'book_landing_page_promotional_settings',
            'type' => 'text',
        )
    );

    /** Promotional Section Button Text */
    $wp_customize->add_setting(
        'book_landing_page_promotional_section_button_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_promotional_section_button_text',
        array(
            'label' => __( 'Promotional Section Button Text', 'book-landing-page' ),
            'section' => 'book_landing_page_promotional_settings',
            'type' => 'text',
        )
    );

    /** Upload a Image One */
    $wp_customize->add_setting(
        'book_landing_page_promotional_image',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'book_landing_page_promotional_image',
           array(
               'label'      => __( 'Upload Accepted Cards Image', 'book-landing-page' ),
               'section'    => 'book_landing_page_promotional_settings',
           )
       )
    );
    /** Promotional Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_promotional' );