<?php
/**
 * Subscribe Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_subscribe' ) ) :

function book_landing_page_customize_register_subscribe( $wp_customize ) {
    
    if ( book_landing_page_is_newsletter_activated() ) {
    
        /** Subscribe Settings */
        $wp_customize->add_section(
            'book_landing_page_subscribe_settings',
            array(
                'title'    => __( 'Subscribe Settings', 'book-landing-page' ),
                'priority' => 90,
                'panel'    => 'book_landing_page_home_page_settings',
            )
        );
        
        /** Enable/Disable Subscribe */
        $wp_customize->add_setting(
            'book_landing_page_ed_subscribe_section',
            array(
                'default' => '',
                'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
            )
        );
        
        $wp_customize->add_control(
            'book_landing_page_ed_subscribe_section',
            array(
                'label' => __( 'Enable Subscribe', 'book-landing-page' ),
                'description' =>  __( 'Newsletters plugin must be activated for this section to be enable. ', 'book-landing-page' ),
                'section' => 'book_landing_page_subscribe_settings',
                'type' => 'checkbox',
    
            )
        );
    }
    /** Subscribe Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_subscribe' );