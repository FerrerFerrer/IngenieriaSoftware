<?php
/**
 * Book Landing Theme Customizer.
 *
 * @package Book_Landing_Page
 */

if ( ! function_exists( 'book_landing_page_modify_sections' ) ) :

function book_landing_page_modify_sections( $wp_customize ){
	if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
		$wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'book-landing-page' );
	}
}
endif;
add_action( 'customize_register', 'book_landing_page_modify_sections' );

$book_landing_page_sections = array( 'banner', 'features', 'testimonial', 'review', 'tabmenu', 'about', 'promotional', 'subscribe' );

$book_landing_page_settings = array( 'info','default', 'home', 'breadcrumb', 'scrollbar', 'footer' );

/* Option list of all post */	
$book_landing_page_options_posts = array();
$book_landing_page_options_posts_obj = get_posts('posts_per_page=-1');
$book_landing_page_options_posts[''] = __( 'Choose Post', 'book-landing-page' );
foreach ( $book_landing_page_options_posts_obj as $book_landing_page_posts ) {
	$book_landing_page_options_posts[$book_landing_page_posts->ID] = $book_landing_page_posts->post_title;
}

foreach( $book_landing_page_settings as $setting ){
    require get_template_directory() . '/inc/customizer/' . $setting . '.php';
}

foreach( $book_landing_page_sections as $section ){
    require get_template_directory() . '/inc/customizer/home/' . $section . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function book_landing_page_customize_preview_js() {
	wp_enqueue_script( 'book-landing-page-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'book_landing_page_customize_preview_js' );

/** 
 * Registering and enqueuing scripts/stylesheets for Customizer controls.
 */ 
function book_landing_page_customizer_js() {
	wp_enqueue_style( 'book-landing-page-customizer-css', get_template_directory_uri() . '/inc/css/customize.css', array(),BOOK_LANDING_PAGE_THEME_VERSION );
	wp_enqueue_script( 'book-landing-page-customizer-js', get_template_directory_uri() . '/inc/js/customizer.js', array("jquery"), BOOK_LANDING_PAGE_THEME_VERSION, true  );	
	$book_landing_page_array = array(
    	'newsletter'      => book_landing_page_is_newsletter_activated()
	);
	wp_localize_script( 'book-landing-page-customizer-js', 'book_landing_page_data', $book_landing_page_array );
}

add_action( 'customize_controls_enqueue_scripts', 'book_landing_page_customizer_js' );

