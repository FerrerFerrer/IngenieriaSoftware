<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Book_Landing_Page
 */

get_header(); ?>
<div class="holder">
    <h1><?php esc_html_e( '404', 'book-landing-page' ); ?></h1>
    <h2><?php esc_html_e( 'Sorry, The Page Not Found', 'book-landing-page' ); ?></h2>
    
    <?php

	$clean_home_url = esc_url( home_url( '/' ) );

	printf( __( 'Can&rsquo;t find what you need? Take a moment and do a search below or start from our <a href="%s">Homepage</a>', 'book-landing-page' ), $clean_home_url ); ?>

</div>
<?php	
    get_search_form();
    get_footer();