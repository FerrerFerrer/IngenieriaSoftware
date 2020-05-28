<?php 
/**
 * Footer Option.
 *
 * @package Book Landing Page
 */
if ( ! function_exists( 'book_landing_page_customize_footer_settings' ) ) :
    
function book_landing_page_customize_footer_settings( $wp_customize ) {

 /** Footer Section */
    $wp_customize->add_section(
        'book_landing_page_footer_section',
        array(
            'title' => __( 'Footer Settings', 'book-landing-page' ),
            'priority' => 70,
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'book_landing_page_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'book-landing-page' ),
            'section' => 'book_landing_page_footer_section',
            'type' => 'textarea',
        )
    );
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_footer_settings' );
 