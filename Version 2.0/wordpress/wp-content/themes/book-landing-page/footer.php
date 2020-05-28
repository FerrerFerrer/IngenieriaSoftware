<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Book_Landing_Page
 */

    /**
     * After Content
     * 
     * @hooked book_landing_page_content_end - 20
    */
    do_action( 'book_landing_page_after_content' );
    

    /**
     * Book Landing Page Footer
     * 
     * @hooked book_landing_page_footer_start  - 20
     * @hooked book_landing_page_footer_menu   - 30
     * @hooked book_landing_page_footer_credit - 40
     * @hooked book_landing_page_footer_end    - 50
    */
	do_action( 'book_landing_page_footer' ); 
    
    /**
	 * After Footer
     * 
     * @hooked book_landing_page_page_end - 20
	 */
    do_action( 'book_landing_page_page_end' );
    
    
    wp_footer(); ?>

</body>
</html>