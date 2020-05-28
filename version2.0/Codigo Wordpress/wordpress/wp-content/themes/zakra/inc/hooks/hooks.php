<?php
/**
 * Zakra hooks.
 *
 * @package zakra
 */

/* ------------------------------ HEADER ------------------------------ */
/**
 * Header doctype.
 *
 * @see zakra_doctype()
 */
add_action( 'zakra_action_doctype', 'zakra_doctype', 10 );

/**
 * HTML head.
 *
 * @see zakra_head()
 */
add_action( 'zakra_action_head', 'zakra_head', 10 );

/**
 * Before page.
 *
 * @see zakra_page_start()
 * @see zakra_skip_content_link()
 */
add_action( 'zakra_action_before', 'zakra_page_start', 10 );
add_action( 'zakra_action_before', 'zakra_skip_content_link', 15 );

/**
 * Before header.
 *
 * @see zakra_transparent_header_start()
 * @see zakra_header_start()
 */
add_action( 'zakra_action_before_header', 'zakra_transparent_header_start', 10 );
add_action( 'zakra_action_before_header', 'zakra_header_start', 15 );

/**
 * Header top.
 *
 * @see zakra_header_top()
 */
add_action( 'zakra_action_header_top', 'zakra_header_top', 10 );

/**
 * Header top left content.
 *
 * @see zakra_header_top_left_content()
 */
add_action( 'zakra_action_header_top_left_content', 'zakra_header_top_left_content', 10 );

/**
 * Header top right content.
 *
 * @see zakra_header_top_right_content()
 */
add_action( 'zakra_action_header_top_right_content', 'zakra_header_top_right_content', 10 );

/**
 * Before header main.
 *
 * @see zakra_before_header_main()
 */
add_action( 'zakra_action_before_header_main', 'zakra_before_header_main', 10 );

/**
 * Header main.
 *
 * @see zakra_header_main_site_branding()
 * @see zakra_header_main_site_navigation()
 * @see zakra_header_main_action()
 */
add_action( 'zakra_action_header_main', 'zakra_header_main_site_branding', 10 );
add_action( 'zakra_action_header_main', 'zakra_header_main_site_navigation', 15 );
add_action( 'zakra_action_header_main', 'zakra_header_main_action', 20 );

/**
 * Header: Site navigation.
 *
 * @see zakra_site_navigation()
 */
add_action( 'zakra_action_site_navigation', 'zakra_site_navigation', 10 );

/**
 * Header: Header action.
 *
 * @see zakra_header_action()
 */
add_action( 'zakra_action_header_main_action', 'zakra_header_action', 10 );

/**
 * After header main.
 *
 * @see zakra_after_header_main()
 */
add_action( 'zakra_action_after_header_main', 'zakra_after_header_main', 10 );

/**
 * After header.
 *
 * @see zakra_header_end()
 * @see zakra_transparent_header_end()
 * @see zakra_header_media_markup()
 */
add_action( 'zakra_action_after_header', 'zakra_header_end', 10 );
add_action( 'zakra_action_after_header', 'zakra_transparent_header_end', 15 );
add_action( 'zakra_action_after_header', 'zakra_header_media_markup', 20 );

/* ------------------------------ CONTENT ------------------------------ */
/**
 * Header Breadcrumbs.
 *
 * @see zakra_breadcrumbs()
 */
add_action( 'zakra_action_breadcrumbs', 'zakra_breadcrumbs', 10 );

/**
 * Before content.
 *
 * @see zakra_main_start()
 * @see zakra_page_header()
 * @see zakra_content_start()
 */
add_action( 'zakra_action_before_content', 'zakra_main_start', 10 );
add_action( 'zakra_action_before_content', 'zakra_page_header', 15 );
add_action( 'zakra_action_before_content', 'zakra_content_start', 20 );

/* ------------------------------ FOOTER ------------------------------ */
/**
 * After content.
 *
 * @see zakra_content_end()
 * @see zakra_main_end()
 */
add_action( 'zakra_action_after_content', 'zakra_content_end', 10 );
add_action( 'zakra_action_after_content', 'zakra_main_end', 15 );

/**
 * Before footer.
 *
 * @see zakra_footer_start()
 */
add_action( 'zakra_action_before_footer', 'zakra_footer_start', 10 );

/**
 * Footer widgets.
 *
 * @see zakra_footer_widgets()
 */
add_action( 'zakra_action_footer_widgets', 'zakra_footer_widgets', 10 );

/**
 * Footer bar.
 *
 * @see zakra_footer_bottom_bar()
 */
add_action( 'zakra_action_footer_bottom_bar', 'zakra_footer_bottom_bar', 10 );

/**
 * Footer bar section one.
 *
 * @see zakra_footer_bottom_bar_one()
 */
add_action( 'zakra_action_footer_bottom_bar_one', 'zakra_footer_bottom_bar_one', 10 );

/**
 * Footer bar section two.
 *
 * @see zakra_footer_bottom_bar_two()
 */
add_action( 'zakra_action_footer_bottom_bar_two', 'zakra_footer_bottom_bar_two', 10 );

/**
 * After footer.
 *
 * @see zakra_footer_end()
 */
add_action( 'zakra_action_after_footer', 'zakra_footer_end', 10 );

/**
 * After page.
 *
 * @see zakra_page_end()
 */
add_action( 'zakra_action_after', 'zakra_page_end', 10 );

/**
 * Mobile navigation.
 *
 * @see zakra_mobile_navigation()
 */
add_action( 'zakra_action_after', 'zakra_mobile_navigation', 15 );

/**
 * Scroll to top.
 *
 * @see zakra_scroll_to_top()
 */
add_action( 'zakra_action_after', 'zakra_scroll_to_top', 20 );

/**
 * Archive posts navigation.
 *
 * @see zakra_posts_navigation()
 */
add_action( 'zakra_after_posts_the_loop', 'zakra_posts_navigation', 10 );

/**
 * Single post navigation.
 *
 * @see zakra_post_navigation()
 */
add_action( 'zakra_after_single_post_content', 'zakra_post_navigation', 10 );

/**
 * Post content.
 *
 * @see zakra_entry_content()
 */
add_action( 'zakra_action_entry_content', 'zakra_entry_content', 10 );

/**
 * Post read more.
 *
 * @see zakra_entry_content()
 */
add_action( 'zakra_post_readmore', 'zakra_post_readmore', 10 );
