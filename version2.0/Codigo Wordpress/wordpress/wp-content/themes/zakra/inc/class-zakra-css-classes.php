<?php
/**
 * Adds classes to appropriate places.
 *
 * @package zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Zakra_Css_Classes' ) ) :
	/**
	 * Adds css classes
	 */
	class Zakra_Css_Classes {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_filter( 'body_class', array( $this, 'zakra_add_body_classes' ) );
			add_filter( 'post_class', array( $this, 'zakra_add_post_classes' ) );
			add_filter( 'zakra_header_class', array( $this, 'zakra_add_header_classes' ) );
			add_filter( 'zakra_footer_widget_container_class', array(
				$this,
				'zakra_add_footer_widget_container_classes',
			) );
			add_filter( 'zakra_footer_bar_class', array( $this, 'zakra_add_footer_bar_classes' ) );
			add_filter( 'zakra_primary_menu_class', array( $this, 'zakra_add_primary_menu_classes' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'zakra_add_metabox_styles' ), 12 );
		}

		/**
		 * Adds css classes on body
		 *
		 * @param array $classes list of old classes.
		 *
		 * @return array
		 */
		public function zakra_add_body_classes( $classes ) {

			if ( ! is_home() ) {
				$content_margin = get_post_meta( zakra_get_post_id(), 'zakra_remove_content_margin' );

				if ( isset( $content_margin[0] ) && $content_margin[0] ) {
					$classes[] = 'tg-no-content-margin';
				}
			}

			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			/**
			 * Layout.
			 */

			// Layout.
			$classes[] = zakra_get_current_layout();

			// Container style.
			$classes[] = get_theme_mod( 'zakra_general_container_style', 'tg-container--wide' );

			// Add transparent header class.
			if ( zakra_is_header_transparent_enabled() ) {
				$classes[] = 'has-transparent-header';
			}

			// Add if page header is enabled.
			if ( 'page-header' === zakra_is_page_title_enabled() ) {
				$classes[] = 'has-page-header';
			}

			// Add class if breadcrumbs is enabled.
			if ( zakra_is_breadcrumbs_enabled() ) {
				$classes[] = 'has-breadcrumbs';
			}

			return $classes;
		}

		/**
		 * Adds css classes into the post.
		 *
		 * @param array $classes old classes.
		 *
		 * @return array new classes
		 */
		public function zakra_add_post_classes( $classes ) {

			if ( is_archive() || is_home() || is_search() ) {
				$classes[] = 'zakra-article';
			}
			if ( is_single() ) {
				$classes[] = 'zakra-single-article';
			}

			if ( is_singular( 'post' ) ) {
				$classes[] = 'zakra-article-post';
			}

			if ( is_singular( 'page' ) ) {
				$classes[] = 'zakra-article-page';
			}

			return $classes;
		}

		/**
		 * Adds css classes into header
		 *
		 * @param array $classes list of old classes.
		 *
		 * @return array
		 */
		public function zakra_add_header_classes( $classes ) {

			// TODO: check zakra pro header_top_class method.
			if ( ! is_home() ) {
				$header_style = get_post_meta( zakra_get_post_id(), 'zakra_header_style', true );
			}

			if ( ! empty( $header_style ) ) {
				$classes[] = $header_style;
			} else {
				$classes[] = get_theme_mod( 'zakra_header_main_style', 'tg-site-header--left' );
			}

			// Add transparent header class.
			if ( zakra_is_header_transparent_enabled() ) {
				$classes[] = 'tg-site-header--transparent';
			}

			return $classes;
		}

		/**
		 * Adds css classes into primary menu
		 *
		 * @param array $classes list of old classes.
		 *
		 * @return array
		 */
		public function zakra_add_primary_menu_classes( $classes ) {
			$zakra_menu_item_active_style = get_post_meta( zakra_get_post_id(), 'zakra_menu_item_active_style', true );
			$zakra_menu_extra             = get_theme_mod( 'zakra_primary_menu_extra', false );

			if ( ! empty( $zakra_menu_item_active_style ) ) {
				$classes[] = $zakra_menu_item_active_style;
			} else {
				$classes[] = get_theme_mod( 'zakra_primary_menu_text_active_effect', 'tg-primary-menu--style-underline' );
			}

			if ( ! empty( $zakra_menu_extra ) ) {
				$classes[] = 'tg-extra-menus';
			}

			return $classes;
		}

		/**
		 * Adds css classes into the footer widget area
		 *
		 * @param array $classes list of old classes.
		 *
		 * @return array
		 */
		public function zakra_add_footer_widget_container_classes( $classes ) {
			$classes[] = get_theme_mod( 'zakra_footer_widgets_style', 'tg-footer-widget-col--four' );

			// Add hide class if the widget title is disabled.
			if ( get_theme_mod( 'zakra_footer_widgets_hide_title', false ) ) {
				$classes[] = 'tg-footer-widget--title-hidden';
			}

			return $classes;
		}

		/**
		 * Adds css classes into the footer bar area
		 *
		 * @param array $classes list of old classes.
		 *
		 * @return array
		 */
		public function zakra_add_footer_bar_classes( $classes ) {
			$footer_style = get_post_meta( zakra_get_post_id(), 'zakra_footer_style', true );
			if ( ! empty( $footer_style ) ) {
				$classes[] = $footer_style;
			} else {
				$classes[] = get_theme_mod( 'zakra_footer_bar_style', 'tg-site-footer-bar--center' );
			}

			return $classes;
		}

		/**
		 * Adds styles from metabox.
		 *
		 * @return void
		 */
		public function zakra_add_metabox_styles() {
			$customize_zakra_menu_item_color        = get_theme_mod( 'zakra_primary_menu_text_color', '#16181a' );
			$customize_zakra_menu_item_hover_color  = get_theme_mod( 'zakra_primary_menu_text_hover_color', '#269bd1' );
			$customize_zakra_menu_item_active_color = get_theme_mod( 'zakra_primary_menu_text_active_color', '#269bd1' );

			$zakra_menu_item_color        = get_post_meta( zakra_get_post_id(), 'zakra_menu_item_color', true );
			$zakra_menu_item_hover_color  = get_post_meta( zakra_get_post_id(), 'zakra_menu_item_hover_color', true );
			$zakra_menu_item_active_color = get_post_meta( zakra_get_post_id(), 'zakra_menu_item_active_color', true );

			$meta_css = '';
			if ( $customize_zakra_menu_item_color !== $zakra_menu_item_color && ! empty( $zakra_menu_item_color ) ) {
				$meta_css .= '.main-navigation.tg-primary-menu > div > ul > li > a { color: ' . $zakra_menu_item_color . ' }';
			}
			if ( $customize_zakra_menu_item_hover_color !== $zakra_menu_item_hover_color && ! empty( $zakra_menu_item_hover_color ) ) {
				$meta_css .= '.main-navigation.tg-primary-menu > div > ul > li:hover > a { color: ' . $zakra_menu_item_hover_color . ' }';
			}
			if ( $customize_zakra_menu_item_active_color !== $zakra_menu_item_active_color && ! empty( $zakra_menu_item_active_color ) ) {
				$meta_css .= '.main-navigation.tg-primary-menu > div > ul li:active > a, .main-navigation.tg-primary-menu > div > ul > li.current_page_item > a, .main-navigation.tg-primary-menu > div > ul > li.current-menu-item > a { color: ' . $zakra_menu_item_active_color . ' }';
				$meta_css .= '.main-navigation.tg-primary-menu.tg-primary-menu--style-underline > div > ul > li.current_page_item > a::before, .main-navigation.tg-primary-menu.tg-primary-menu--style-underline > div > ul > li.current-menu-item > a::before, .main-navigation.tg-primary-menu.tg-primary-menu--style-left-border > div > ul > li.current_page_item > a::before, .main-navigation.tg-primary-menu.tg-primary-menu--style-left-border > div > ul > li.current-menu-item > a::before, .main-navigation.tg-primary-menu.tg-primary-menu--style-right-border > div > ul > li.current_page_item > a::before, .main-navigation.tg-primary-menu.tg-primary-menu--style-right-border > div > ul > li.current-menu-item > a::before { background-color: ' . $zakra_menu_item_active_color . ' }';
			}

			$meta_css .= apply_filters( 'zakra_meta_box_style', false );

			wp_add_inline_style( 'zakra-style', $meta_css );
		}

	}
endif;
new Zakra_Css_Classes();
