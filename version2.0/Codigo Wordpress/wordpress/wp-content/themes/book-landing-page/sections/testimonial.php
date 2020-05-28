<?php
/**
 * Testimonial Section
 * 
 * @package Book_Landing_Page
 */

$book_landing_page_testimonial_section_title = get_theme_mod( 'book_landing_page_testimonial_section_title' );
$book_landing_page_testimonial_section_content = get_theme_mod( 'book_landing_page_testimonial_section_content' );
$book_landing_page_testimonial_block_post_one = get_theme_mod( 'book_landing_page_testimonial_block_one' );
$book_landing_page_testimonial_block_post_two = get_theme_mod( 'book_landing_page_testimonial_block_two' );
?>
<section class="testimonial" id="testimonial_section">
    <div class="container">
        <header class="header">
        <?php 
            if($book_landing_page_testimonial_section_title){ echo ' <h2 class="main-title">'. esc_html( $book_landing_page_testimonial_section_title) .'</h2>';}
            if($book_landing_page_testimonial_section_content){ echo wpautop( wp_kses_post( $book_landing_page_testimonial_section_content ) ); }            
        ?>
        </header>
        <?php
            if( $book_landing_page_testimonial_block_post_one && $book_landing_page_testimonial_block_post_two ){ 
            $book_landing_page_testimonial_blocks = array( $book_landing_page_testimonial_block_post_one, $book_landing_page_testimonial_block_post_two );
            $book_landing_page_testimonial_blocks = array_filter( $book_landing_page_testimonial_blocks );
            $testimonial_qry = new WP_Query( array( 
                'post_type'             => 'post',
                'posts_per_page'        => -1,
                'post__in'              => $book_landing_page_testimonial_blocks,
                'orderby'               => 'post__in',
                'ignore_sticky_posts'   => true
            ) );
           
            if( $testimonial_qry->have_posts() ){
        ?>
                <div class="row">
                <?php
                    while( $testimonial_qry->have_posts() ){
                        $testimonial_qry->the_post();
                    ?>
                    <div class="col">
                        <blockquote>
                            <?php the_content(); ?>
                        </blockquote>
                        <cite>
                        <?php
                            echo '<span class="img-holder">';
                                echo '<a href="'.  esc_url( get_permalink() )  .'" >';
                                    if( has_post_thumbnail() ){ 
                                        the_post_thumbnail( 'book-landing-page-recent-post' ); 
                                    }else{
                                        book_landing_page_get_fallback_svg( 'book-landing-page-recent-post' );
                                    } 
                                echo '</a>';
                            echo '</span>';
                            echo '<div class="text-holder">';
                                the_title('<strong class="name">','</strong>');
                            echo '</div>';
                            if( has_excerpt() ){
                                the_excerpt();
                            }
                        ?>
                        </cite>
                    </div> 
                <?php
                    }
                    wp_reset_postdata();
                ?>
                </div>
        <?php } } ?>
    </div>
</section>
<?php 