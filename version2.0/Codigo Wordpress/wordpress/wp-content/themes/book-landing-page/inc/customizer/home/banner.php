<?php
/**
 * Banner Section Theme Option.
 *
 * @package Book_Landing_Page
 */
if ( ! function_exists( 'book_landing_page_customize_register_banner' ) ) :

function book_landing_page_customize_register_banner( $wp_customize ) {

	global $book_landing_page_options_posts;
    
	/** Banner Section */
    $wp_customize->add_section(
        'book_landing_page_banner_settings',
        array(
            'title'    => __( 'Banner Section', 'book-landing-page' ),
            'priority' => 20,
            'panel'    => 'book_landing_page_home_page_settings',
        )
    );
        
    /** Enable/Disable Banner Section */
    $wp_customize->add_setting(
        'book_landing_page_ed_banner_section',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_ed_banner_section',
        array(
            'label' => __( 'Enable Banner Section', 'book-landing-page' ),
            'section' => 'book_landing_page_banner_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Banner Post */
    $wp_customize->add_setting(
        'book_landing_page_banner_section_post',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_banner_section_post',
        array(
            'label' => __( 'Select Post', 'book-landing-page' ),
            'section' => 'book_landing_page_banner_settings',
            'type' => 'select',
            'choices' => $book_landing_page_options_posts,
        )
    );
   
    /** Promotional Section Button Text */
    $wp_customize->add_setting(
        'book_landing_page_banner_section_button_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_banner_section_button_text',
        array(
            'label' => __( 'Banner Section Button Text', 'book-landing-page' ),
            'section' => 'book_landing_page_banner_settings',
            'type' => 'text',
        )
    );

    /** banner Section Button Link */
    $wp_customize->add_setting(
        'book_landing_page_banner_section_button_link',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'book_landing_page_banner_section_button_link',
        array(
            'label' => __( 'Banner Section Button Link', 'book-landing-page' ),
            'section' => 'book_landing_page_banner_settings',
            'type' => 'text',
        )
    );

    /** Upload a Accepted Cards Image */
    $wp_customize->add_setting(
        'book_landing_page_banner_image',
        array(
            'default' => '',
            'sanitize_callback' => 'book_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'book_landing_page_banner_image',
           array(
               'label'      => __( 'Upload Accepted Cards Image', 'book-landing-page' ),
               'section'    => 'book_landing_page_banner_settings',
           )
       )
    );
       
    /** Banner Section Ends */
}
endif;
add_action( 'customize_register', 'book_landing_page_customize_register_banner' );