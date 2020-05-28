<?php
/**
 * Tab menu Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_tabmenu' ) ) :

function book_landing_page_customize_register_tabmenu( $wp_customize ) {

	global $book_landing_page_options_posts;

    /** Tabber Menu Settings */
    $wp_customize->add_section(
        'book_landing_page_tabmenu_settings',
        array(
            'title'    => __( 'Sample Menu Settings', 'book-landing-page' ),
            'priority' => 60,
            'panel'    => 'book_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable Tabber Menu */
    $wp_customize->add_setting(
        'book_landing_page_ed_tabmenu_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_tabmenu_section',
        array(
            'label' => __( 'Enable Sample Menu', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'checkbox',
        )
    );
    
     /** Tabber Menu Section Title */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_section_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_section_title',
        array(
            'label' => __( 'Sample Menu Section Title', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'text',
        )
    );
    
    /** Tabber Menu Section Content */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_section_content',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_section_content',
        array(
            'label' => __( 'Sample Menu Section Content', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'text',
        )
    );

    /** Tabmenu Post One */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_block_one',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_block_one',
        array(
            'label' => __( 'Select Post One', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    
    /** Tabmenu Post Two */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_block_two',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_block_two',
        array(
            'label' => __( 'Select Post Two', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Tabmenu Post Three */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_block_three',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_block_three',
        array(
            'label' => __( 'Select Post Three', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Tabmenu Post Four */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_block_four',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_block_four',
        array(
            'label' => __( 'Select Post Four', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );

    /** Tabmenu Post Five */
    $wp_customize->add_setting(
        'book_landing_page_tabmenu_block_five',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_tabmenu_block_five',
        array(
            'label' => __( 'Select Post Five', 'book-landing-page' ),
            'section' => 'book_landing_page_tabmenu_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );
    /** Tabber Menu Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_tabmenu' );