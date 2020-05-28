<?php
/**
 * Subscribe Section
 *
 * @package book_landing_Page
 */

 $book_landing_page_ed_subscribe_section = get_theme_mod('book_landing_page_ed_subscribe_section');

if ( ! book_landing_page_is_newsletter_activated() || ! is_active_sidebar( 'bottom-widget' ) || ! $book_landing_page_ed_subscribe_section ) {
	return;
}
?>
<section class="subscribe" id="subscribe_section">
    <div class="container">
        <?php dynamic_sidebar( 'bottom-widget' );?>
    </div>
</section>