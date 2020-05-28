<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Book_Landing_Page
 */

if ( ! function_exists( 'book_landing_page_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function book_landing_page_posted_on() {

  $time_string = '<time datetime="%1$s">%2$s</time>';
  if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
  }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_attr( get_the_modified_date( 'c' ) ),
    esc_html( get_the_modified_date() )
  );

  $posted_on = sprintf(
    esc_html_x( 'Posted on %s', 'post date', 'book-landing-page' ),
    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
  );
  echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'book_landing_page_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function book_landing_page_entry_footer() {

  // Hide category and tag text for pages.
  if ( 'post' === get_post_type() ) {

    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'book-landing-page' ) );
    if ( $tags_list ) {
      printf( '<span class="share-link">%1$s</span>', $tags_list ); // WPCS: XSS OK.
    }
    
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( ', ' );
    if ( $categories_list && book_landing_page_categorized_blog() ) {
      printf( '<span class="category">%s</span>' , esc_url( $categories_list ) ); // WPCS: XSS OK.
    }

  }

  if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link">';
    /* translators: %s: post title */
    comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'book-landing-page' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
    echo '</span>';
  }

  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
  }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_attr( get_the_modified_date( 'c' ) ),
    esc_html( get_the_modified_date() )
  );

  $byline = sprintf(
    esc_html_x( 'By %s', 'post author', 'book-landing-page' ),
    '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
  );

  echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

  edit_post_link(
    sprintf(
      /* translators: %s: Name of current post */
      esc_html__( 'Edit %s', 'book-landing-page' ),
      the_title( '<span class="screen-reader-text">"', '"</span>', false )
    ),
    '<span class="edit-link">',
    '</span>'
  );
}
endif;

if( ! function_exists( 'book_landing_page_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function book_landing_page_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'book_landing_page_categories' ) ) ) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array(
      'fields'     => 'ids',
      'hide_empty' => 1,
      // We only need to know if there is more than one category.
      'number'     => 2,
    ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'book_landing_page_categories', $all_the_cool_cats );
  }

  if ( $all_the_cool_cats > 1 ) {
    // This blog has more than 1 category so book_landing_page_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so book_landing_page_categorized_blog should return false.
    return false;
  }
}
endif;

if( ! function_exists( 'book_landing_page_pagination' ) ) :
/**
 * Pagination
*/
function book_landing_page_pagination(){
    the_posts_pagination( array(
        'mid_size' => 2,
        'prev_text' => __( '<span class="fa fa-angle-double-left"></span>', 'book-landing-page' ),
        'next_text' => __( '<span class="fa fa-angle-double-right"></span>', 'book-landing-page' ),
     ) );   
}
endif;

if( ! function_exists( 'book_landing_page_category_ajax' ) ) :
/**
 * Ajax Callback for Featured Category
*/
function book_landing_page_tabmenu_ajax(){ 

    $id = $_POST['id'];
    $tabmenu_qry = new WP_Query( "p=$id" );
    if( $tabmenu_qry->have_posts() ){
        while( $tabmenu_qry->have_posts() ){
                $tabmenu_qry->the_post();            
                $response .= '<div class="tabs-content">';
                $response .= wpautop( wp_kses_post( get_the_content() ) );
                $response .= '</div>';
                }
            wp_reset_postdata();
        echo $response;
          wp_die();
        }
}
endif;

add_action( 'wp_ajax_book_landing_page_cat_ajax', 'book_landing_page_tabmenu_ajax' );
add_action( 'wp_ajax_nopriv_book_landing_page_cat_ajax', 'book_landing_page_tabmenu_ajax' );

if( ! function_exists( 'book_landing_page_sidebar_layout' ) ) :
/**
 * Return sidebar layouts for pages
 */
function book_landing_page_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'book_landing_page_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'book_landing_page_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
    
}
endif;
    
if( ! function_exists( 'book_landing_page_ed_section') ):
    /**
     * Check if home page section are enable or not.
    */
    function book_landing_page_ed_section(){
        global $book_landing_page_sections;
        $en_sec = false;
        foreach( $book_landing_page_sections as $section ){ 
            if( get_theme_mod( 'book_landing_page_ed_' . $section . '_section' ) == 1 ){
                $en_sec = true;
            }
        }
        return $en_sec;
    }

endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

if( ! function_exists( 'book_landing_page_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function book_landing_page_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'book_landing_page_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function book_landing_page_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = book_landing_page_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#dedbdb;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'book_landing_page_fonts_url' ) ) :
/**
 * Register custom fonts.
 */
function book_landing_page_fonts_url() {
    $fonts_url = '';

    /*
    * translators: If there are characters in your language that are not supported
    * by PT Sans, translate this to 'off'. Do not translate into your own language.
    */
    $pt_sans = _x( 'on', 'PT Sans font: on or off', 'book-landing-page' );
    
    $font_families = array();

    if( 'off' !== $pt_sans ){
        $font_families[] = 'PT Sans:400,400italic,700';
    }

    $query_args = array(
        'family'  => urlencode( implode( '|', $font_families ) ),
        'display' => urlencode( 'fallback' ),
    );

    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

    return esc_url( $fonts_url );
}
endif;

if ( ! function_exists( 'book_landing_page_iframe_match' ) ) :    
/**
 * Check whether the input parameter send is iframe or Url
*/
function book_landing_page_iframe_match( $iframe ){
    return preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $iframe ) ? true : false;
}
endif;

/**
 * Query WooCommerce activation
 */
function book_landing_page_is_woocommerce_activated() {
  return class_exists( 'woocommerce' ) ? true : false;
}

if( ! function_exists( 'book_landing_page_is_newsletter_activated' ) ) :
/**
 * Query Newsletter activation
 */
function book_landing_page_is_newsletter_activated(){
    return class_exists( 'newsletter' ) ? true : false;
}
endif;