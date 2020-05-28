<?php
/**
 * Review Section
 * 
 * @package Book_Landing_Page
 */

$book_landing_page_review_section_title = get_theme_mod( 'book_landing_page_review_section_title');
$book_landing_page_review_section_content = get_theme_mod( 'book_landing_page_review_section_content');
$book_landing_page_review_video = get_theme_mod( 'book_landing_page_review_video');
$book_landing_page_review_post = get_theme_mod( 'book_landing_page_review_post' );


?>
<section class="video-review" id="review_section">
    <div class="container" >
    <?php if( $book_landing_page_review_section_title || $book_landing_page_review_section_content ){ ?>
        <header class="header">
        <?php 
            if($book_landing_page_review_section_title){echo ' <h2 class="main-title">'. esc_html( $book_landing_page_review_section_title ).'</h2>';}

            if($book_landing_page_review_section_content){echo wpautop( wp_kses_post( $book_landing_page_review_section_content ) );}            
        ?>
        </header>
        <?php } ?>
        <?php 
            if( $book_landing_page_review_post ){
            $review_qry = new WP_Query( "p=$book_landing_page_review_post" );
            
            if( $review_qry->have_posts() ){
                while( $review_qry->have_posts() ){
                    $review_qry->the_post(); ?>
                    <div class="holder">
                        <?php 
                            if( $book_landing_page_review_video ){ 
                                echo '<div class="video-holder">';
                                if( book_landing_page_iframe_match( $book_landing_page_review_video ) ){    
                                    echo book_landing_page_sanitize_iframe( $book_landing_page_review_video );         
                                }else{
                                    echo wp_oembed_get( $book_landing_page_review_video );
                                }
                                echo '</div>';
                            }else{
                                echo '<div class="video-holder">';
                                    the_post_thumbnail( 'book-landing-page-review-block' ); 
                                echo '</div>';
                            }
                            ?>
                            <div class="text-holder">
                                <?php
                                    the_title( ' <h3 class="title">','</h2>');
                                    the_content();
                                ?>
                            </div>
                    </div>
           <?php } }
           wp_reset_postdata();
        }?>
    </div>
</section>
