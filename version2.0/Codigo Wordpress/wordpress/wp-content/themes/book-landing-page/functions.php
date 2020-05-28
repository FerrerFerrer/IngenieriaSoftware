<?php
/**
 * Book Landing Page functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Book_Landing_page
 */

$book_landing_page_theme_data = wp_get_theme();	
if( ! defined( 'BOOK_LANDING_PAGE_THEME_VERSION' ) ) define( 'BOOK_LANDING_PAGE_THEME_VERSION', $book_landing_page_theme_data->get( 'Version' ) );
if( ! defined( 'BOOK_LANDING_PAGE_THEME_NAME' ) ) define( 'BOOK_LANDING_PAGE_THEME_NAME', $book_landing_page_theme_data->get( 'Name' ) );
if( ! defined( 'BOOK_LANDING_PAGE_THEME_TEXTDOMAIN' ) ) define( 'BOOK_LANDING_PAGE_THEME_TEXTDOMAIN', $book_landing_page_theme_data->get( 'TextDomain' ) );

/**
 * Implement the Custom functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Custom template functions for this theme.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load plugin for right and no sidebar
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/getting-started/getting-started.php';

/**
 * Woocommerce Custom Function
 */
if( book_landing_page_is_woocommerce_activated() )
require get_template_directory() . '/inc/woocommerce-functions.php';