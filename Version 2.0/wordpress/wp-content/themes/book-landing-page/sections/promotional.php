<?php
/**
 * Promotional Section
 * 
 * @package Book_Landing_Page
 */

$book_landing_page_promotional_section_post        = get_theme_mod( 'book_landing_page_promotional_section_post' );
$book_landing_page_promotional_section_button      = get_theme_mod( 'book_landing_page_promotional_section_button' );
$book_landing_page_promotional_section_button_text = get_theme_mod('book_landing_page_promotional_section_button_text');
$book_landing_page_promotional_image               = get_theme_mod( 'book_landing_page_promotional_image' );

    if( $book_landing_page_promotional_section_post ){
?>
<section class ="promotional-block" id="promotional_section">
    <div class ="container">  
    <?php
    	$promotional_qry = new WP_Query( "p=$book_landing_page_promotional_section_post" );
            if( $promotional_qry->have_posts() ){
                while( $promotional_qry->have_posts() ){
                    $promotional_qry->the_post();

                    echo '<header class="header">';
                        the_title( '<h2 class="main-title">', '</h2>');
                        the_content();
                    echo '</header>';
       				
       				if( has_post_thumbnail() ) {
       					echo '<div class="img-holder">';
    						the_post_thumbnail( 'book-landing-page-banner-image' ); 
    					echo '</div>';
       				}         
                    if( has_excerpt() ) { ?>
        			<div class="price-holder">
        				<?php the_excerpt(); ?>
        			</div>
        		<?php }

        			if ($book_landing_page_promotional_section_button_text) { ?>
            			<div class="btn-holder">
            				<a href="<?php echo esc_url( $book_landing_page_promotional_section_button ); ?>" class="btn-buy"><?php echo esc_html( $book_landing_page_promotional_section_button_text ); ?></a>
            			</div>
        			<?php
        				if($book_landing_page_promotional_image){
                            echo '<div class="cards"><img src="' . esc_url( $book_landing_page_promotional_image ). '" alt="' . the_title_attribute( 'echo=0' ) . '"></div>'; 
                        } 
                    ?>
    		<?php } }
            wp_reset_postdata();
        } ?>

    </div>
</section>
<?php }