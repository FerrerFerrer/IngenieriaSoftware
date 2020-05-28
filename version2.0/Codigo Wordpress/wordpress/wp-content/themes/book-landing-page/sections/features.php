<?php
/**
 * Features Section
 * 
 * @package Book_Landing_Page
 */
$book_landing_page_features_section_title   = get_theme_mod( 'book_landing_page_features_section_title' );
$book_landing_page_features_section_content = get_theme_mod( 'book_landing_page_features_section_content' );
$book_landing_page_features_block_one       = get_theme_mod( 'book_landing_page_features_block_one' );
$book_landing_page_features_block_two       = get_theme_mod( 'book_landing_page_features_block_two' );
$book_landing_page_features_block_three     = get_theme_mod( 'book_landing_page_features_block_three' );
$book_landing_page_features_block_four      = get_theme_mod( 'book_landing_page_features_block_four' );
$book_landing_page_features_block_five      = get_theme_mod( 'book_landing_page_features_block_five' );
$book_landing_page_features_block_six       = get_theme_mod( 'book_landing_page_features_block_six' );     
?>
<section class="about" id="features_section">
    <div class="container">
        <header class="header">
        <?php 
            if($book_landing_page_features_section_title){echo ' <h2 class="main-title">'. esc_html( $book_landing_page_features_section_title ) .'</h2>';}
            if($book_landing_page_features_section_content){echo wpautop( wp_kses_post( $book_landing_page_features_section_content ) );}            
        ?>
        </header>
    
        <?php
             if( $book_landing_page_features_block_one || $book_landing_page_features_block_two || $book_landing_page_features_block_three || $book_landing_page_features_block_four || $book_landing_page_features_block_five || $book_landing_page_features_block_six ){
            $book_landing_page_features_blocks = array( $book_landing_page_features_block_one, $book_landing_page_features_block_two, $book_landing_page_features_block_three, $book_landing_page_features_block_four, $book_landing_page_features_block_five, $book_landing_page_features_block_six );
            $book_landing_page_features_blocks = array_diff( array_unique( $book_landing_page_features_blocks  ), array('') );
            $features_qry = new WP_Query( array( 
                'post_type'             => 'post',
                'posts_per_page'        => -1,
                'post__in'              => $book_landing_page_features_blocks,
                'orderby'               => 'post__in',
                'ignore_sticky_posts'   => true
            ) );
            
            if( $features_qry->have_posts() ){
        ?>
                <div class="row">
                    <?php
                        while( $features_qry->have_posts() ){
                        $features_qry->the_post();
                    ?>
                            <div class="col">
                                <?php
                                    echo '<div class="img-holder">';
                                        if( has_post_thumbnail() ){                      
                                            the_post_thumbnail( 'book-landing-page-featured-post' ); 
                                        }else{
                                            book_landing_page_get_fallback_svg( 'book-landing-page-featured-post' );
                                        }
                                    echo '</div>';
                                ?>
                                <div class="text-holder">
                                    <h2 class="title"><?php the_title(); ?></h2>
                                        <?php the_content(); ?>
                                </div>
                            </div>
                    <?php
                        }
                        wp_reset_postdata();
                    ?>
                </div>
         <?php }  } ?>
    </div>
</section>
<?php
   
