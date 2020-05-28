<?php
/**
 * Banner Section
 * 
 * @package book_landing_Page
 */

$book_landing_page_banner_section_post = get_theme_mod('book_landing_page_banner_section_post');
$book_landing_page_banner_section_title = get_theme_mod( 'book_landing_page_banner_section_title' );
$book_landing_page_banner_section_content = get_theme_mod( 'book_landing_page_banner_section_content' );
$book_landing_page_banner_image = get_theme_mod( 'book_landing_page_banner_image' );
$book_landing_page_banner_section_button_text = get_theme_mod( 'book_landing_page_banner_section_button_text' );
$book_landing_page_banner_section_button_link = get_theme_mod( 'book_landing_page_banner_section_button_link' );

if( $book_landing_page_banner_section_post ){
?>

<section class="banner" id="banner_section">
    <div class="container">
     <?php
        $banner_qry = new WP_Query( "p=$book_landing_page_banner_section_post" );
        
         if( $banner_qry->have_posts() ){            
            while( $banner_qry->have_posts() ){
                $banner_qry->the_post();
    ?>
            <div class="row">
            <?php
                 echo '<div class="col"> <div class="img-holder">';
                    the_post_thumbnail( 'book-landing-page-banner-image' ); 
                 echo '</div></div>';
            ?>
                 <div class="col">
                    <div class="text-holder">
                        <?php 
                            the_title( '<h2 class="title">', '</h2>'); 
                            the_excerpt();
                            
                            if ($book_landing_page_banner_section_button_text) { ?>
                                <a href="<?php echo esc_url( $book_landing_page_banner_section_button_link ); ?>" class="btn-buy"><?php echo esc_html( $book_landing_page_banner_section_button_text ); ?></a>
                        <?php 
                            }
    
                            if($book_landing_page_banner_image){ 
                                     echo '<div class="cards"><img src="' . esc_url( $book_landing_page_banner_image ) . '" alt="' . esc_attr( $book_landing_page_banner_section_title ) . '"></div>'; 
                            } 
                        ?>
                    </div>
                 </div>
            </div>
        <?php 
            } 
            wp_reset_postdata(); 
        }
        ?>
    </div>
</section>
<?php }