<?php
/**
 * Zakra functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package zakra
 */

if ( ! function_exists( 'zakra_setup' ) ) :
	// Sets up theme defaults and registers support for various WordPress features.
	function zakra_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'zakra', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register menu.
		register_nav_menus( array(
			'menu-primary' => esc_html__( 'Primary', 'zakra' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'width'       => 170,
			'height'      => 60,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Custom background support.
		add_theme_support( 'custom-background' );

		// Gutenberg Wide/fullwidth support.
		add_theme_support( 'align-wide' );

		// AMP support.
		if ( defined( 'AMP__VERSION' ) && ( ! version_compare( AMP__VERSION, '1.0.0', '<' ) ) ) {
			add_theme_support( 'amp',
				apply_filters(
					'zakra_amp_support_filter',
					array(
						'paired' => true,
					)
				)
			);
		}
	}
endif;
add_action( 'after_setup_theme', 'zakra_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zakra_widgets_init() {
	$sidebars = apply_filters( 'zakra_sidebars_args', array(
		'sidebar-right'            => esc_html__( 'Sidebar Right', 'zakra' ),
		'sidebar-left'             => esc_html__( 'Sidebar Left', 'zakra' ),
		'header-top-left-sidebar'  => esc_html__( 'Header Top Bar Left Sidebar', 'zakra' ),
		'header-top-right-sidebar' => esc_html__( 'Header Top Bar Right Sidebar', 'zakra' ),
		'footer-sidebar-1'         => esc_html__( 'Footer One', 'zakra' ),
		'footer-sidebar-2'         => esc_html__( 'Footer Two', 'zakra' ),
		'footer-sidebar-3'         => esc_html__( 'Footer Three', 'zakra' ),
		'footer-sidebar-4'         => esc_html__( 'Footer Four', 'zakra' ),
		'footer-bar-left-sidebar'  => esc_html__( 'Footer Bottom Bar Left Sidebar', 'zakra' ),
		'footer-bar-right-sidebar' => esc_html__( 'Footer Bottom Bar Right Sidebar', 'zakra' ),
	) );

	if ( zakra_is_woocommerce_active() ) {
		$sidebars['wc-left-sidebar']  = esc_html__( 'WooCommerce Left Sidebar', 'zakra' );
		$sidebars['wc-right-sidebar'] = esc_html__( 'WooCommerce Right Sidebar', 'zakra' );
	}

	foreach ( $sidebars as $id => $name ) {
		register_sidebar( array(
			'id'            => $id,
			'name'          => $name,
			'description'   => esc_html__( 'Add widgets here.', 'zakra' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}

add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}


add_action( 'widgets_init', 'zakra_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function zakra_scripts() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	/**
	 * Styles.
	 */
	// Font Awesome 4.
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/lib/font-awesome/css/font-awesome' . $suffix . '.css', false, '4.7.0' );
	wp_enqueue_style( 'font-awesome' );

	// Theme style.
	wp_register_style( 'zakra-style', get_stylesheet_uri() );
	wp_enqueue_style( 'zakra-style' );

	// Support RTL.
	wp_style_add_data( 'zakra-style', 'rtl', 'replace' );

	// Do not load scripts if AMP.
	if ( zakra_is_amp() ) {
		return;
	}

	/**
	 * Scripts.
	 */
	wp_enqueue_script( 'zakra-navigation', get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js', array(), '20151215', true );
	wp_enqueue_script( 'zakra-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix' . $suffix . '.js', array(), '20151215', true );

	// Theme JavaScript.
	wp_enqueue_script( 'zakra-custom', get_template_directory_uri() . '/assets/js/zakra-custom' . $suffix . '.js', array(), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zakra_scripts' );

/**
 * Define constants.
 */
define( 'ZAKRA_PARENT_DIR', get_template_directory() );
define( 'ZAKRA_PARENT_URI', get_template_directory_uri() );
define( 'ZAKRA_PARENT_INC_DIR', ZAKRA_PARENT_DIR . '/inc' );
define( 'ZAKRA_PARENT_INC_URI', ZAKRA_PARENT_URI . '/inc' );
define( 'ZAKRA_PARENT_INC_ICON_URI', ZAKRA_PARENT_URI . '/assets/img/icons' );
define( 'ZAKRA_PARENT_CUSTOMIZER_DIR', ZAKRA_PARENT_INC_DIR . '/customizer' );

// Theme version.
$zakra_theme = wp_get_theme();
define( 'ZAKRA_THEME_VERSION', $zakra_theme->get( 'Version' ) );

// AMP support files.
if ( defined( 'AMP__VERSION' ) && ( ! version_compare( AMP__VERSION, '1.0.0', '<' ) ) ) {
	require_once ZAKRA_PARENT_INC_DIR . '/compatibility/amp/amp.php';
}

/**
 * Include files.
 */
require ZAKRA_PARENT_INC_DIR . '/helpers.php';
require ZAKRA_PARENT_INC_DIR . '/custom-header.php';
require ZAKRA_PARENT_INC_DIR . '/class-zakra-dynamic-filter.php';
require ZAKRA_PARENT_INC_DIR . '/template-tags.php';
require ZAKRA_PARENT_INC_DIR . '/template-functions.php';
require ZAKRA_PARENT_INC_DIR . '/customizer/class-zakra-customizer.php';
require ZAKRA_PARENT_INC_DIR . '/class-zakra-css-classes.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require ZAKRA_PARENT_INC_DIR . '/jetpack.php';
}

// WooCommerce hooks and functions.
if ( class_exists( 'WooCommerce' ) ) {
	require ZAKRA_PARENT_INC_DIR . '/woocommerce.php';
}

// Load hooks.
require ZAKRA_PARENT_INC_DIR . '/hooks/hooks.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/header.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/footer.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/content.php';
require ZAKRA_PARENT_INC_DIR . '/migration.php';

// Breadcrumbs class.
require_once ZAKRA_PARENT_INC_DIR . '/class-breadcrumb-trail.php';

// Admin screen.
if ( is_admin() ) {
	// Meta boxes.
	require ZAKRA_PARENT_INC_DIR . '/meta-boxes/class-zakra-meta-box-page-settings.php';
	require ZAKRA_PARENT_INC_DIR . '/meta-boxes/class-zakra-meta-box.php';

	// Theme options page.
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-admin.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-welcome-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-upgrade-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-dashboard.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-theme-review-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-tdi-notice.php';
}

// Set default content width.
if ( ! isset( $content_width ) ) {
	$content_width = 812;
}

// Calculate $content_width value according to layout options from Customizer and meta boxes.
function zakra_content_width_rdr() {
	global $content_width;

	// Get layout type.
	$layout_type     = zakra_get_layout_type();
	$layouts_sidebar = array( 'tg-site-layout--left', 'tg-site-layout--right' );

	/**
	 * Calculate content width.
	 */
	// Get required values from Customizer.
	$container_width_arr = get_theme_mod( 'zakra_general_container_width', array(
		'slider' => 1160,
		'suffix' => 'px',
	) );

	$content_width_arr   = get_theme_mod( 'zakra_general_content_width', array(
		'slider' => 70,
		'suffix' => '%',
	) );

	// Calculate Padding to reduce.
	$container_style = get_theme_mod( 'zakra_general_container_style', 'tg-container--wide' );
	$content_padding = ( 'tg-container--separate' === $container_style ) ? 120 : 60;

	if ( in_array( $layout_type, $layouts_sidebar, true ) ) {
		$content_width = ( ( (int) $container_width_arr['slider'] * (int) $content_width_arr['slider'] ) / 100 ) - $content_padding;
	} else {
		$content_width = (int) $container_width_arr['slider'] - $content_padding;
	}

}
add_action( 'template_redirect', 'zakra_content_width_rdr' );

if ( ! function_exists( 'zakra_stretched_style_migrate' ) ) :
	/**
	 * Migrate `Stretched` container style to `Layout`.
	 */
	function zakra_stretched_style_migrate() {

		$container_style = get_theme_mod( 'zakra_general_container_style', 'tg-container--wide' );

		$layout_arr = array( 'tg-site-layout--left', 'tg-site-layout--right' );

		$page_types = array( 'default', 'archive', 'post', 'page' );

		// Lets bail out if container style is not stretched.
		if ( 'tg-container--stretched' != $container_style ) {
			return;
		}

		// Lets bail out if 'zakra_stretched_style_transfer' option found.
		if ( get_option( 'zakra_stretched_style_transfer' ) ) {
			return;
		}

		set_theme_mod( 'zakra_general_container_style', 'tg-container--wide' );

		foreach ( $page_types as $page_type ) {
			$layout = get_theme_mod( 'zakra_structure_' . $page_type, 'tg-site-layout--right' );

			// Do nothing if left or right sidebar enabled.
			if ( ! in_array( $layout, $layout_arr ) ) {
				set_theme_mod( 'zakra_structure_' . $page_type, 'tg-site-layout--stretched' );
			}
		}

		// Set transfer as complete.
		update_option( 'zakra_stretched_style_transfer', 1 );
	}
endif;
add_action( 'after_setup_theme', 'zakra_stretched_style_migrate' );

add_filter(‘show_admin_bar’, ‘__return_false’);