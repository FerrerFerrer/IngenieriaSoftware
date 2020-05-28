<?php
function zakra_migrations() {
	// Update id: `zakra_typography_page_title` to `zakra_typography_post_page_title`
	$old_page_title_typography = get_theme_mod( 'zakra_typography_page_title' );

	if ( $old_page_title_typography ) {
		set_theme_mod( 'zakra_typography_post_page_title', $old_page_title_typography );
		remove_theme_mod( 'zakra_typography_page_title' );
	}

	// Migrate Page Header Text Color to Typography.
	$old_page_title_color       = get_theme_mod( 'zakra_page_header_text_color' );
	$old_page_title_font_size   = get_theme_mod( 'zakra_page_title_font_size' );
	$post_page_title_typography = get_theme_mod( 'zakra_typography_post_page_title', apply_filters( 'zakra_typography_post_page_title_filter', array(
		'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
		'variant'     => '500',
		'line-height' => '1.3',
		'color'       => '#16181a',
	) ) );

	if ( $old_page_title_color ) {
		$post_page_title_typography[ 'color' ] = $old_page_title_color;
		set_theme_mod( 'zakra_typography_post_page_title', $post_page_title_typography );
		remove_theme_mod( 'zakra_page_header_text_color' );
	}

	if ( $old_page_title_font_size ) {
		$post_page_title_typography[ 'font-size' ] = $old_page_title_font_size['slider'] . $old_page_title_font_size['suffix'];
		set_theme_mod( 'zakra_typography_post_page_title', $post_page_title_typography );
		remove_theme_mod( 'zakra_page_title_font_size' );
	}

}
add_action( 'after_setup_theme', 'zakra_migrations' );
