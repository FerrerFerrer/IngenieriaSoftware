<?php
/**
 * Tabmenu Section
 * 
 * @package Book_Landing_Page
 */
$book_landing_page_tabmenu_section_title = get_theme_mod( 'book_landing_page_tabmenu_section_title' );
$book_landing_page_tabmenu_section_content = get_theme_mod( 'book_landing_page_tabmenu_section_content' );
$book_landing_page_tabmenu_block_one = get_theme_mod( 'book_landing_page_tabmenu_block_one' );
$book_landing_page_tabmenu_block_two = get_theme_mod( 'book_landing_page_tabmenu_block_two' );
$book_landing_page_tabmenu_block_three = get_theme_mod( 'book_landing_page_tabmenu_block_three' );
$book_landing_page_tabmenu_block_four = get_theme_mod( 'book_landing_page_tabmenu_block_four' );
$book_landing_page_tabmenu_block_five = get_theme_mod( 'book_landing_page_tabmenu_block_five' );

    ?>
    
    <section class="sample" id="tabmenu_section" >
        <div class="container">
            <header class="header">
            <?php 
                if($book_landing_page_tabmenu_section_title){ echo ' <h2 class="main-title">'. esc_html( $book_landing_page_tabmenu_section_title) .'</h2>';}
                if($book_landing_page_tabmenu_section_content){ echo '<p>'. wpautop( wp_kses_post( $book_landing_page_tabmenu_section_content ) ); }            
            ?>
            </header>     
            <div class="tab-holder">
                <?php  if( $book_landing_page_tabmenu_block_one || $book_landing_page_tabmenu_block_two || $book_landing_page_tabmenu_block_three || $book_landing_page_tabmenu_block_four || $book_landing_page_tabmenu_block_five ){
                    $book_landing_page_tabmenu_blocks = array( $book_landing_page_tabmenu_block_one, $book_landing_page_tabmenu_block_two, $book_landing_page_tabmenu_block_three, $book_landing_page_tabmenu_block_four, $book_landing_page_tabmenu_block_five);
                    $book_landing_page_tabmenu_blocks = array_filter( $book_landing_page_tabmenu_blocks );
                    $tabmenu_qry = new WP_Query( array( 
                        'post_type'             => 'post',
                        'posts_per_page'        => -1,
                        'post__in'              => $book_landing_page_tabmenu_blocks,
                        'orderby'               => 'post__in',
                        'ignore_sticky_posts'   => true
                        ) );
                    echo '<ul class="tabs">';
                        if( $tabmenu_qry->have_posts() ){
                            $count = 1;
                            while( $tabmenu_qry->have_posts() ){
                                $class = ( $count == 1 ) ? 'class="active"' : '';
                                $tabmenu_qry->the_post();
                                    echo '<li '. $class .'><button class="tab-btn" id="'. esc_attr( get_the_ID() ) .'">';
                                        the_title(); 
                                    echo '</button></li>';
                                $count++;
                            }
                            wp_reset_postdata();
                        }
                    echo '</ul>';
            
                    $tabmenu_qry = new WP_Query( array( 
                        'post_type'             => 'post',
                        'posts_per_page'        => 1,
                        'post__in'              => $book_landing_page_tabmenu_blocks,
                        'orderby'               => 'post__in',
                        'ignore_sticky_posts'   => true
                        ) ); 
            
                    $count1 = 0;
                    echo '<div class="tab-content" >';
                        while( $tabmenu_qry->have_posts() ){
                            $tabmenu_qry->the_post();
                ?>       
                            <div class="tabs-content">
                                <?php the_content(); ?>
                            </div>  
                    <?php   $count1++;
                        } 
                        wp_reset_query(); 
                     echo'</div>';

                    ?>
                <div id="loader"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>   
                <?php } ?>
            </div>
        </div>
    </section>
<?php 
