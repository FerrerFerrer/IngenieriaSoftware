<?php
/**
 * Features Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_features' ) ) :

function book_landing_page_customize_register_features( $wp_customize ) {

	global $book_landing_page_options_posts;

    /** Features Block Section */
    $wp_customize->add_section(
        'book_landing_page_features_settings',
        array(
            'title' => __( 'Features Section', 'book-landing-page' ),
            'priority' => 30,
            'panel' => 'book_landing_page_home_page_settings',
        )
    );

    /** Enable/Disable Features Section */
    $wp_customize->add_setting(
        'book_landing_page_ed_features_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_features_section',
        array(
            'label' => __( 'Enable Features Section', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'checkbox',
        )
    );

    /** Features Section Title */
    $wp_customize->add_setting(
        'book_landing_page_features_section_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_section_title',
        array(
            'label' => __( 'Features Section Title', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'text',
        )
    );


    /** Features Section Content */
    $wp_customize->add_setting(
        'book_landing_page_features_section_content',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_section_content',
        array(
            'label' => __( 'Features Section Content', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'text',
        )
    );

    /** Features Post One */
    $wp_customize->add_setting(
        'book_landing_page_features_block_one',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_block_one',
        array(
            'label' => __( 'Select Feature Post One', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Features Post Two */
    $wp_customize->add_setting(
        'book_landing_page_features_block_two',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_block_two',
        array(
            'label' => __( 'Select Feature Post Two', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Features Post Three */
    $wp_customize->add_setting(
        'book_landing_page_features_block_three',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_block_three',
        array(
            'label' => __( 'Select Feature Post Three', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Features Post Four */
    $wp_customize->add_setting(
        'book_landing_page_features_block_four',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_block_four',
        array(
            'label' => __( 'Select Feature Post Four', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Features Post Five */
    $wp_customize->add_setting(
        'book_landing_page_features_block_five',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_block_five',
        array(
            'label' => __( 'Select Feature Post Five', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Features Post Six */
    $wp_customize->add_setting(
        'book_landing_page_features_block_six',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_features_block_six',
        array(
            'label' => __( 'Select Features Post Six', 'book-landing-page' ),
            'section' => 'book_landing_page_features_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );
    
    /** Features Block Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_features' );