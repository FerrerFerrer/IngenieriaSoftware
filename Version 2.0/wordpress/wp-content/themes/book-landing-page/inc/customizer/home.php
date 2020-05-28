<?php
/**
 * Home Page Options
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_home' ) ) :

function book_landing_page_customize_register_home( $wp_customize ) {

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'book_landing_page_home_page_settings',
         array(
            'priority' => 40,
            'capability' => 'edit_theme_options',
            'title' => __( 'Home Page Settings', 'book-landing-page' ),
            'description' => __( 'Customize Home Page Settings', 'book-landing-page' ),
        ) 
    );
    /** Home Page Settings Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_home' );