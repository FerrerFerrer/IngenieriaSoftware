<?php
/**
 * Video Review Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_review' ) ) :

function book_landing_page_customize_register_review( $wp_customize ) {

	global $book_landing_page_options_posts;

    /** Review Section */
    $wp_customize->add_section(
        'book_landing_page_review_settings',
        array(
            'title' => __( 'Review Section', 'book-landing-page' ),
            'priority' => 50,
            'panel' => 'book_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable Review Section */
    $wp_customize->add_setting(
        'book_landing_page_ed_review_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_review_section',
        array(
            'label' => __( 'Enable Review Section', 'book-landing-page' ),
            'section' => 'book_landing_page_review_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Review Section Title */
    $wp_customize->add_setting(
        'book_landing_page_review_section_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_review_section_title',
        array(
            'label' => __( 'Review Section Title', 'book-landing-page' ),
            'section' => 'book_landing_page_review_settings',
            'type' => 'text',
        )
    );
    
    /** Review Section Content */
    $wp_customize->add_setting(
        'book_landing_page_review_section_content',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_review_section_content',
        array(
            'label' => __( 'Review Section Content', 'book-landing-page' ),
            'section' => 'book_landing_page_review_settings',
            'type' => 'text',
        )
    );

    
    /** Review Video Link */
    $wp_customize->add_setting(
        'book_landing_page_review_video',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_iframe',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_review_video',
        array(
            'label' => __( 'Review Video Embed Link', 'book-landing-page' ),
            'section' => 'book_landing_page_review_settings',
            'type' => 'text',
        )
    );
    
    /** Review Post */
    $wp_customize->add_setting(
        'book_landing_page_review_post',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_review_post',
        array(
            'label' => __( 'Select Post', 'book-landing-page' ),
            'section' => 'book_landing_page_review_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );
    /** Review Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_review' );