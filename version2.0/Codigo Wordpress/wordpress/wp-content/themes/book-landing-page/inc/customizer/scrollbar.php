<?php
/**
 * Scroll Bar Options
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_scrollbar' ) ) :

	function book_landing_page_customize_register_scrollbar( $wp_customize ) {
		/** Scrollbar Settings */
	    $wp_customize->add_section(
	        'book_landing_page_scrollbar_settings',
	        array(
	            'title'      => __( 'Scrollbar Settings', 'book-landing-page' ),
	            'priority'   => 70,
	            'capability' => 'edit_theme_options',
	        )
	    );

	    /** Enable/Disable Scrollbar */
	    $wp_customize->add_setting(
	        'book_landing_page_ed_scrollbar',
	        array(
	            'default' => '',
	            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
	        )
	    );
	    
	    $wp_customize->add_control(
	        'book_landing_page_ed_scrollbar',
	        array(
	            'label'   => __( 'Enable Nice Scroll', 'book-landing-page' ),
	            'section' => 'book_landing_page_scrollbar_settings',
	            'type'    => 'checkbox',
	        )
	    );
	}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_scrollbar' );