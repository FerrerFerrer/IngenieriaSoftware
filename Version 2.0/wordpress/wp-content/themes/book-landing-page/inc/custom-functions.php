<?php
/**
 * Book Landing Page functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Book_Landing_page
*/

if ( ! function_exists( 'book_landing_page_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function book_landing_page_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Book Landing Page, use a find and replace
	 * to change 'book-landing-page' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'book-landing-page', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'book-landing-page' ),
		'secondary' => esc_html__( 'Footer Menu', 'book-landing-page' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
        'status',
        'audio', 
        'chat'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'book_landing_page_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Custom Image Size
    add_image_size( 'book-landing-page-with-sidebar', 750, 500, true );
    add_image_size( 'book-landing-page-without-sidebar', 1110, 500, true );
    add_image_size( 'book-landing-page-featured-post', 337, 226, true );
    add_image_size( 'book-landing-page-recent-post', 70, 70, true );
    add_image_size( 'book-landing-page-banner-image', 380, 582, true );
    add_image_size( 'book-landing-page-about-block', 555, 330, true );
    add_image_size( 'book-landing-page-review-block', 630, 366, true );


    /* Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
endif;
add_action( 'after_setup_theme', 'book_landing_page_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function book_landing_page_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'book_landing_page_content_width', 750 );
}
add_action( 'after_setup_theme', 'book_landing_page_content_width', 0 );

/**
 * Adjust content_width value according to template.
 *
 * @return void
*/
function book_landing_page_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){
	   $sidebar_layout = book_landing_page_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1140;
        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {
		$GLOBALS['content_width'] = 1140;
	}

}
add_action( 'template_redirect', 'book_landing_page_template_redirect_content_width' );

/**
 * Enqueue scripts and styles.
 */
function book_landing_page_scripts(){
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	$ed_scrollbar = get_theme_mod( 'book_landing_page_ed_scrollbar', '' );

    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );

    wp_enqueue_style( 'book-landing-page-google-fonts', book_landing_page_fonts_url() );
    wp_enqueue_style( 'book-landing-page-style', get_stylesheet_uri(), array(), BOOK_LANDING_PAGE_THEME_VERSION );

    if( book_landing_page_is_woocommerce_activated() ) {
    	wp_enqueue_style( 'book-landing-page-woocommerce-style', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array('book-landing-page-style'), BOOK_LANDING_PAGE_THEME_VERSION );
    }

    wp_register_script( 'book-landing-page-ajax', get_template_directory_uri() . '/js' . $build . '/ajax' . $suffix . '.js', array('jquery'), BOOK_LANDING_PAGE_THEME_VERSION, true );

    if ( $ed_scrollbar ) {
      wp_enqueue_script( 'nice-scroll', get_template_directory_uri() . '/js' . $build . '/nice-scroll' . $suffix . '.js', array('jquery'), '3.6.6', true );
    }
    
    wp_enqueue_script( 'book-landing-page-custom', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array('jquery'), BOOK_LANDING_PAGE_THEME_VERSION, true );

	wp_enqueue_script( 'book-landing-page-ajax' );
    
    wp_localize_script( 
        'book-landing-page-ajax', 
        'book_landing_page_ajax',
        array(
            'url' => admin_url( 'admin-ajax.php' ),
            'ed_scrollbar' => get_theme_mod( 'book_landing_page_ed_scrollbar', '' ),            
         )
    ); 
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'book_landing_page_scripts' );

if( ! function_exists( 'book_landing_page_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function book_landing_page_admin_scripts(){
    wp_enqueue_style( 'book-landing-page-admin', get_template_directory_uri() . '/inc/css/admin.css', '', BOOK_LANDING_PAGE_THEME_VERSION );
}
endif; 
add_action( 'admin_enqueue_scripts', 'book_landing_page_admin_scripts' );

/**
 * Flush out the transients used in book_landing_page_categorized_blog.
 */
function book_landing_page_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'book_landing_page_categories' );
}
add_action( 'edit_category', 'book_landing_page_category_transient_flusher' );
add_action( 'save_post', 'book_landing_page_category_transient_flusher' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function book_landing_page_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}

    if( !( is_active_sidebar( 'right-sidebar' )) || is_page_template( 'template-home.php' ) || is_404() ) {
        $classes[] = 'full-width'; 
    }
    
    if( is_page() ){
        $book_landing_page_post_class = book_landing_page_sidebar_layout(); 
        if( $book_landing_page_post_class == 'no-sidebar' )
        $classes[] = 'full-width';
    }
	
	 if( book_landing_page_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }   

	return $classes;
}
add_filter( 'body_class', 'book_landing_page_body_classes' );

if ( ! function_exists( 'book_landing_page_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function book_landing_page_excerpt_more( $more ) {
  	return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'book_landing_page_excerpt_more' );

if ( ! function_exists( 'book_landing_page_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function book_landing_page_excerpt_length( $length ) {
    return is_admin() ? $length : 45;
}
endif;
add_filter( 'excerpt_length', 'book_landing_page_excerpt_length', 999 );

if( ! function_exists( 'book_landing_page_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function book_landing_page_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $required = ( $req ? " required" : '' );
    $author   = ( $req ? __( 'Name*', 'book-landing-page' ) : __( 'Name', 'book-landing-page' ) );
    $email    = ( $req ? __( 'Email*', 'book-landing-page' ) : __( 'Email', 'book-landing-page' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'book-landing-page' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $author ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'book-landing-page' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $email ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'book-landing-page' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'book-landing-page' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'book_landing_page_change_comment_form_default_fields' );

if( ! function_exists( 'book_landing_page_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function book_landing_page_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'book-landing-page' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'book-landing-page' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'book_landing_page_change_comment_form_defaults' );

if( ! function_exists( 'book_landing_page_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 *
 * @return string
 */
function book_landing_page_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'book_landing_page_single_post_schema' ) ) :
/**
 * Single Post Schema
 *
 * @return string
 */
function book_landing_page_single_post_schema() {
    if ( is_singular( 'post' ) ) {
        global $post;
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        $site_logo   = wp_get_attachment_image_src( $custom_logo_id , 'travel-agency-schema' );
        $images      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $excerpt     = book_landing_page_escape_text_tags( $post->post_excerpt );
        $content     = $excerpt === "" ? mb_substr( book_landing_page_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
        $schema_type = ! empty( $custom_logo_id ) && has_post_thumbnail( $post->ID ) ? "BlogPosting" : "Blog";

        $args = array(
            "@context"  => "http://schema.org",
            "@type"     => $schema_type,
            "mainEntityOfPage" => array(
                "@type" => "WebPage",
                "@id"   => esc_url( get_permalink( $post->ID ) )
            ),
            "headline"      => esc_html( get_the_title( $post->ID ) ),
            "datePublished" => esc_html( get_the_time( DATE_ISO8601, $post->ID ) ),
            "dateModified"  => esc_html( get_post_modified_time(  DATE_ISO8601, __return_false(), $post->ID ) ),
            "author"        => array(
                "@type"     => "Person",
                "name"      => book_landing_page_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) )
            ),
            "description" => ( class_exists('WPSEO_Meta') ? WPSEO_Meta::get_value( 'metadesc' ) : $content )
        );

        if ( has_post_thumbnail( $post->ID ) ) :
            $args['image'] = array(
                "@type"  => "ImageObject",
                "url"    => $images[0],
                "width"  => $images[1],
                "height" => $images[2]
            );
        endif;

        if ( ! empty( $custom_logo_id ) ) :
            $args['publisher'] = array(
                "@type"       => "Organization",
                "name"        => esc_html( get_bloginfo( 'name' ) ),
                "description" => wp_kses_post( get_bloginfo( 'description' ) ),
                "logo"        => array(
                    "@type"   => "ImageObject",
                    "url"     => $site_logo[0],
                    "width"   => $site_logo[1],
                    "height"  => $site_logo[2]
                )
            );
        endif;

        echo '<script type="application/ld+json">';
        if ( version_compare( PHP_VERSION, '5.4.0' , '>=' ) ) {
            echo wp_json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
        } else {
            echo wp_json_encode( $args );
        }
        echo '</script>';
    }
}
endif;
add_action( 'wp_head', 'book_landing_page_single_post_schema' );

if( ! function_exists( 'book_landing_page_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function book_landing_page_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'book_landing_page_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'book-landing-page' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'book-landing-page' ), esc_html( $name ) ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=book-landing-page-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'book-landing-page' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?book_landing_page_admin_notice=1"><?php esc_html_e( 'Dismiss', 'book-landing-page' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'book_landing_page_admin_notice' );

if( ! function_exists( 'book_landing_page_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function book_landing_page_update_admin_notice(){
    if ( isset( $_GET['book_landing_page_admin_notice'] ) && $_GET['book_landing_page_admin_notice'] = '1' ) {
        update_option( 'book_landing_page_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'book_landing_page_update_admin_notice' );