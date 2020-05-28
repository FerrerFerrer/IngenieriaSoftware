<?php
/**
 * Custom template function for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Book_Landing_Page
*/

if( ! function_exists( 'book_landing_page_doctype_cb' ) ) :
/**
 * Doctype Declaration
 * 
 * @since 1.0.1
*/
function book_landing_page_doctype_cb(){
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'book_landing_page_doctype', 'book_landing_page_doctype_cb' );

if( ! function_exists( 'book_landing_page_head' ) ) :
/**
 * Before wp_head
 * 
 * @since 1.0.1
*/
function book_landing_page_head(){
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
}
endif;
add_action( 'book_landing_page_before_wp_head', 'book_landing_page_head' );

if( ! function_exists( 'book_landing_page_page_start' ) ) :
/**
 * Page Start
 * 
 * @since 1.0.1
*/
function book_landing_page_page_start(){
    ?>
    <div id="page" class="site">
      <a class="skip-link screen-reader-text" href="#acc-content"><?php esc_html_e( 'Skip to content (Press Enter)', 'book-landing-page' ); ?></a>
    <?php
}
endif;
add_action( 'book_landing_page_before_header', 'book_landing_page_page_start', 20 );

if( ! function_exists( 'book_landing_page_header_cb' ) ) :
/**
 * Header Start
 * 
 * @since 1.0.1
*/
function book_landing_page_header_cb(){
    ?>
    <header id="masthead" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
      <div class="container">
        <div class="site-branding" itemscope itemtype="http://schema.org/Organization">
              <?php 
                  if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                      the_custom_logo();
                  } 
              ?>
               <div class="text-logo">
                    <?php if ( is_front_page() ) : ?>
                        <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                        <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                    <?php endif; 
                      $description = get_bloginfo( 'description', 'display' );
                      if ( $description || is_customize_preview() ) : ?>
                      <p class="site-description" itemprop="description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
              <?php
              endif; ?>
        </div>
        </div><!-- .site-branding -->
      
      <div id="menu-opener">
          <span></span>
          <span></span>
          <span></span>
      </div>
     
      <nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
      </nav><!-- #site-navigation -->
      </div>
    </header><!-- #masthead -->
    <?php 
}
endif;
add_action( 'book_landing_page_header', 'book_landing_page_header_cb', 20 );

if( ! function_exists( 'book_landing_page_breadcrumbs_cb' ) ) :
/**
 * Book Landing Page Breadcrumb
 * 
*/
function book_landing_page_breadcrumbs_cb() {    
    global $post;
    $ed_breadcrumb = get_theme_mod( 'book_landing_page_ed_breadcrumb' );
    $post_page   = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front  = get_option( 'show_on_front' ); //What to show on the front page
    $showCurrent = get_theme_mod( 'book_landing_page_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $delimiter   = get_theme_mod( 'book_landing_page_breadcrumb_separator', __( '>', 'book-landing-page' ) ); // delimiter between crumbs
    $home        = get_theme_mod( 'book_landing_page_breadcrumb_home_text', __( 'Home', 'book-landing-page' ) ); // text for the 'Home' link
    $before      = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
      
    $depth = 1;  
    if( $ed_breadcrumb ){  
      echo '<div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url() ) . '" class="home_crumb"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
          if( is_home() && ! is_front_page() ){            
              $depth = 2;
              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( single_post_title( '', false ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;          
          }elseif( is_category() ){            
              $depth = 2;
              $thisCat = get_category( get_query_var( 'cat' ), false );
              if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                  $p = get_post( $post_page );
                  echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $post_page ) ) . '"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                  $depth ++;  
              }

              if ( $thisCat->parent != 0 ) {
                  $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                  $parent_categories = explode( ',', $parent_categories );

                  foreach ( $parent_categories as $parent_term ) {
                      $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                      if( is_object( $parent_obj ) ){
                          $term_url    = get_term_link( $parent_obj->term_id );
                          $term_name   = $parent_obj->name;
                          echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                          $depth ++;
                      }
                  }
              }

              if( $showCurrent ) echo $before . '<span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;

          }elseif( is_tag() ){            
              $queried_object = get_queried_object();
              $depth = 2;

              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( single_tag_title( '', false ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;    
          }elseif( is_author() ){            
              $depth = 2;
              global $author;
              $userdata = get_userdata( $author );
              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $userdata->display_name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;  
          }elseif( is_day() ){            
              $depth = 2;
              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'book-landing-page' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'book-landing-page' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
              $depth ++;
              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'book-landing-page' ) ), get_the_time( __( 'm', 'book-landing-page' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'book-landing-page' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
              $depth ++;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'd', 'book-landing-page' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
               
          }elseif( is_month() ){            
              $depth = 2;
              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'book-landing-page' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'book-landing-page' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
              $depth++;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'F', 'book-landing-page' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
          }elseif( is_year() ){            
              $depth = 2;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'book-landing-page' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 
          }elseif( is_single() && !is_attachment() ) {
              //For Woocommerce single product            
              if( book_landing_page_is_woocommerce_activated() && 'product' === get_post_type() ){ 
                  if ( wc_get_page_id( 'shop' ) ) { 
                      //Displaying Shop link in woocommerce archive page
                      $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                      if ( ! $_name ) {
                          $product_post_type = get_post_type_object( 'product' );
                          $_name = $product_post_type->labels->singular_name;
                      }
                      echo ' <a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name) . '</span></a> ' . '<span class="separator">' . $delimiter . '</span>';
                  }
              
                  if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                      $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                      $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                      $ancestors = array_reverse( $ancestors );

                      foreach ( $ancestors as $ancestor ) {
                          $ancestor = get_term( $ancestor, 'product_cat' );    
                          if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                              $depth++;
                          }
                      }
                      echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $main_term ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $main_term->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                  }
              
                  if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                                 
              }else{ 
                  //For Post                
                  $cat_object       = get_the_category();
                  $potential_parent = 0;
                  $depth            = 2;
                  
                  if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                      $p = get_post( $post_page );
                      echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';  
                      $depth++;
                  }
                  
                  if( is_array( $cat_object ) ){ //Getting category hierarchy if any
          
                      //Now try to find the deepest term of those that we know of
                      $use_term = key( $cat_object );
                      foreach( $cat_object as $key => $object ){
                          //Can't use the next($cat_object) trick since order is unknown
                          if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                              $use_term = $key;
                              $potential_parent = $object->term_id;
                          }
                      }
                      
                      $cat = $cat_object[$use_term];
                
                      $cats = get_category_parents( $cat, false, ',' );
                      $cats = explode( ',', $cats );

                      foreach ( $cats as $cat ) {
                          $cat_obj = get_term_by( 'name', $cat, 'category' );
                          if( is_object( $cat_obj ) ){
                              $term_url    = get_term_link( $cat_obj->term_id );
                              $term_name   = $cat_obj->name;
                              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                              $depth ++;
                          }
                      }
                  }
      
                  if ( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                               
              }        
          }elseif( is_page() ){            
              $depth = 2;
              if( $post->post_parent ){            
                  global $post;
                  $depth = 2;
                  $parent_id  = $post->post_parent;
                  $breadcrumbs = array();
                  
                  while( $parent_id ){
                      $current_page  = get_post( $parent_id );
                      $breadcrumbs[] = $current_page->ID;
                      $parent_id     = $current_page->post_parent;
                  }
                  $breadcrumbs = array_reverse( $breadcrumbs );
                  for ( $i = 0; $i < count( $breadcrumbs); $i++ ){
                      echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>';
                      if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                      $depth++;
                  }

                  if ( $showCurrent ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" /></span>'. $after;      
              }else{
                  if ( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 
              }
          }elseif( is_search() ){            
              $depth = 2;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html__( 'Search Results for "', 'book-landing-page' ) . esc_html( get_search_query() ) . esc_html__( '"', 'book-landing-page' ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
          }elseif( book_landing_page_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ 
              //For Woocommerce archive page        
              $depth = 2;
              if ( wc_get_page_id( 'shop' ) ) { 
                  //Displaying Shop link in woocommerce archive page
                  $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                  if ( ! $_name ) {
                      $product_post_type = get_post_type_object( 'product' );
                      $_name = $product_post_type->labels->singular_name;
                  }
                  echo ' <a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name) . '</span></a> ' . '<span class="separator">' . $delimiter . '</span>';
              }
              $current_term = $GLOBALS['wp_query']->get_queried_object();
              if( is_product_category() ){
                  $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                  $ancestors = array_reverse( $ancestors );
                  foreach ( $ancestors as $ancestor ) {
                      $ancestor = get_term( $ancestor, 'product_cat' );    
                      if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                          echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                          $depth ++;
                      }
                  }
              }           
              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $current_term->name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;           
          }elseif( book_landing_page_is_woocommerce_activated() && is_shop() ){ //Shop Archive page
              $depth = 2;
              if ( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) {
                  return;
              }
              $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
              $shop_url = wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
      
              if ( ! $_name ) {
                  $product_post_type = get_post_type_object( 'product' );
                  $_name = $product_post_type->labels->singular_name;
              }
              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $_name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;                    
          }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {            
              $depth = 2;
              $post_type = get_post_type_object(get_post_type());
              if( get_query_var('paged') ){
                  echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />';
                  echo ' <span class="separator">' . $delimiter . '</span></span> ' . $before . sprintf( __('Page %s', 'book-landing-page'), get_query_var('paged') ) . $after;
              }elseif( is_archive() ){
                  echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
              }else{
                  echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
              }              
          }elseif( is_attachment() ){            
              $depth  = 2;
              $parent = get_post( $post->post_parent );
              $cat    = get_the_category( $parent->ID );
              if( $cat ){
                  $cat = $cat[0];
                  echo get_category_parents( $cat, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                  echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $parent ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $parent->post_title ) . '<span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . ' <span class="separator">' . $delimiter . '</span></span>';
              }
              if( $showCurrent ) echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;   
          }elseif ( is_404() ){
              if( $showCurrent ) echo $before . esc_html__( '404 Error - Page not Found', 'book-landing-page' ) . $after;
          }
          if( get_query_var('paged') ) echo __( ' (Page', 'book-landing-page' ) . ' ' . get_query_var('paged') . __( ')', 'book-landing-page' );        
          echo '</div>';
    } 
}
endif;
add_action( 'book_landing_page_breadcrumbs', 'book_landing_page_breadcrumbs_cb' );

if( ! function_exists( 'book_landing_page_page_header' ) ) :
/**
 * Page Header for inner pages
 * 
 * @since 1.0.1
*/
function book_landing_page_page_header(){   
    echo '<div id="acc-content"><!-- done for accessibility reasons -->';
    if( !( is_front_page() ||  is_page_template( 'template-home.php' ) ) ) {
      $ed_breadcrumb = get_theme_mod( 'book_landing_page_ed_breadcrumb' );
      if( $ed_breadcrumb ){
        echo '<div class="breadcrumbs"><div class="container">'; 
            do_action( 'book_landing_page_breadcrumbs');
        echo '</div></div>';
      }
      echo '<div class="container">';
        if( is_search() ){ 
          echo '<header class="page-header"><h1 class="page-title">';
            printf( esc_html__( 'Search Results for %s', 'book-landing-page' ), '<span>' . get_search_query() . '</span>' ); 
          echo '</h1></header>';

        }elseif ( is_home() ) {
          echo '<div class="page-header"><h1 class="page-title">';
            single_post_title();
          echo '</h1></div>';

        }elseif ( is_archive() ){ 
            if( book_landing_page_is_woocommerce_activated() ){ 
                if( is_shop() ){
                    echo false; 
                }else{
                    echo '<header class="page-header">';
                      the_archive_title( '<h1 class="page-title">', '</h1>' );
                    echo '</header>';  
                }   
            }else{ 
                  echo '<header class="page-header">';
      				      the_archive_title( '<h1 class="page-title">', '</h1>' );
                  echo '</header>';
            }
        }
      echo '</div>';
      }
      $ed_section = book_landing_page_ed_section();
      if( is_home() || ! $ed_section || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){
          echo '<div class="container">';
          if( !is_404() ){ 
          echo '<div id="content" class="site-content">'; 
            echo '<div class="row">';   
              echo '<div id="primary" class="content-area">';
          }else{
              echo '<div class="error-holder">';   
          } 
      }
}
endif;
add_action( 'book_landing_page_before_content', 'book_landing_page_page_header', 20 );

if( ! function_exists( 'book_landing_page_page_content_image' ) ) :
/**
 * Page Featured Image
 * 
 * @since 1.0.1
*/
function book_landing_page_page_content_image(){
    $sidebar_layout = book_landing_page_sidebar_layout();
    if( has_post_thumbnail() )
    ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'book-landing-page-with-sidebar' ) : the_post_thumbnail( 'book-landing-page-without-sidebar' );    
}
endif;
add_action( 'book_landing_page_before_page_entry_content', 'book_landing_page_page_content_image' );

if( ! function_exists( 'book_landing_page_post_content_image' ) ) :
/**
 * Post Featured Image
 * 
 * @since 1.0.1
*/
function book_landing_page_post_content_image(){
    if( has_post_thumbnail() ){
    echo ( !is_single() ) ? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">' : '<div class="post-thumbnail">'; 
         ( is_active_sidebar( 'right-sidebar' ) ) ? the_post_thumbnail( 'book-landing-page-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'book-landing-page-without-sidebar', array( 'itemprop' => 'image' ) ) ; 
    echo ( !is_single() ) ? '</a>' : '</div>' ;    
    }
}
endif;
add_action( 'book_landing_page_before_post_entry_content', 'book_landing_page_post_content_image', 20 );
add_action( 'book_landing_page_before_search_entry_summary', 'book_landing_page_post_content_image', 20 );

if( ! function_exists( 'book_landing_page_post_entry_header' ) ) :
/**
 * Post Entry Header
 * 
 * @since 1.0.1
*/
function book_landing_page_post_entry_header(){
    ?>
    <header class="entry-header">
        <?php
            if ( is_single() ) {
                the_title( '<h1 class="entry-title">', '</h1>' );
            } else {
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            }   
        ?>
    </header><!-- .entry-header -->
    <?php
}
endif;
add_action( 'book_landing_page_before_post_entry_content', 'book_landing_page_post_entry_header', 10 );
add_action( 'book_landing_page_before_search_entry_summary', 'book_landing_page_post_entry_header', 10 );

if( ! function_exists( 'book_landing_page_post_author' ) ) :
/**
 * Post Author Bio
 * 
 * @since 1.0.1
*/
function book_landing_page_post_author(){
    if( get_the_author_meta( 'description' ) ){
        global $post;
    ?>
    <section class="author">
        <h2 class="title"><?php esc_html_e( 'About Admin', 'book-landing-page' ); ?></h2>
        <div class="holder">
        <div class="img-holder"><?php echo get_avatar( get_the_author_meta( 'ID' ), 126 ); ?></div>
            <div class="text-holder">
                <strong class="name"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></strong>
                <?php book_landing_page_posted_on(); ?>
                <?php echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ); ?>
            </div>
        </div>
    </section>
    <?php  
    }  
}
endif;
add_action( 'book_landing_page_after_post_content', 'book_landing_page_post_author', 10 );

if( ! function_exists( 'book_landing_page_get_comment_section' ) ) :
/**
 * Comment template
 * 
 * @since 1.0.1
*/
function book_landing_page_get_comment_section(){
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
}
endif;
add_action( 'book_landing_page_comment', 'book_landing_page_get_comment_section' );

if( ! function_exists( 'book_landing_page_content_end' ) ) :
/**
 * Content End
 * 
 * @since 1.0.1
*/
function book_landing_page_content_end(){
    $ed_section = book_landing_page_ed_section();
    if( is_home() || ! $ed_section || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){
      if( !is_404() ){
          echo '</div>'; 
          echo '</div>';
          echo '</div>'; 
      }    
      echo '</div>';// .row /#content /.container
    }
}
endif;
add_action( 'book_landing_page_after_content', 'book_landing_page_content_end', 20 );

if( ! function_exists( 'book_landing_page_footer_start' ) ) :
/**
 * Footer Start
 * 
 * @since 1.0.1
*/
function book_landing_page_footer_start(){
    echo '<footer id="colophon" class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">';
    echo '<div class="container">';
}
endif;
add_action( 'book_landing_page_footer', 'book_landing_page_footer_start', 20 );

if( ! function_exists( 'book_landing_page_footer_menu' ) ) :
/**
 * Footer Bottom
 * 
 * @since 1.0.1 
*/
function book_landing_page_footer_menu(){
    if ( has_nav_menu( 'secondary' ) ) {
        echo '<nav class="widget-nav-links" id="footer-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">';
            wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'fallback_cb'  => false, ) ); 
        echo '</nav>'; // #site-navigation
    }
}
endif;
add_action( 'book_landing_page_footer', 'book_landing_page_footer_menu', 30 );

if( ! function_exists( 'book_landing_page_footer_credit' ) ) :
/**
 * Footer Credits 
 */
function book_landing_page_footer_credit(){
  $copyright_text = get_theme_mod( 'book_landing_page_footer_copyright_text' );
  echo '<div class="site-info">';
    if( $copyright_text ){
      echo wp_kses_post( $copyright_text ); 
    }else{
      esc_html_e( 'Copyright &copy;&nbsp;', 'book-landing-page' ); 
      echo date_i18n( esc_html__( 'Y', 'book-landing-page' ) );
      echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) );
      echo '</a>. ';
    }
    
    esc_html_e( 'Book Landing Page | Developed By ', 'book-landing-page' );
    echo '<a href="' . esc_url( 'https://rarathemes.com/' ) . '" rel="nofollow" target="_blank">' . esc_html__( 'Rara Theme', 'book-landing-page' ) . '</a>. ';
    
    printf( esc_html__( 'Powered by %s ', 'book-landing-page' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'book-landing-page' ) ) .'" target="_blank">WordPress</a>.' );
    if ( function_exists( 'the_privacy_policy_link' ) ) {
        the_privacy_policy_link();
    }
  echo '</div>';

}
endif;
add_action( 'book_landing_page_footer', 'book_landing_page_footer_credit', 40 );

if( ! function_exists( 'book_landing_page_footer_end' ) ) :
/**
 * Footer End
 * 
 * @since 1.0.1 
*/
function book_landing_page_footer_end(){
    echo '</div>';
    echo '</footer>'; // #colophon 
    echo '<div class="overlay"></div>';
}
endif;
add_action( 'book_landing_page_footer', 'book_landing_page_footer_end', 50 );

if( ! function_exists( 'book_landing_page_page_end' ) ) :
/**
 * Page End
 * 
 * @since 1.0.1
*/
function book_landing_page_page_end(){
    ?>
    </div><!-- #acc-content -->
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'book_landing_page_after_footer', 'book_landing_page_page_end', 20 );