<?php
/**
 * Load Google fonts in front.
 * @package zakra
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Zakra_Google_Fonts
 */
class Zakra_Google_Fonts {

	/**
	 * Array of fonts to load.
	 * @var array
	 */
	private $selected_fonts = array();

	/**
	 * The constructor.
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

	/**
	 * Get all fonts selected from customizer.
	 * @return array
	 */
	public function google_fonts() {
		$fonts_all = Zakra_Fonts::get_google_fonts();

		$selected_fonts      = array();
		$selected_fonts_pass = array();

		array_push( $selected_fonts, get_theme_mod( 'zakra_base_typography_body', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '15px',
			'line-height' => '1.8',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_base_typography_heading', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_site_title', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '1.313rem',
			'line-height' => '1.5',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_site_description', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '1rem',
			'line-height' => '1.8',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_primary_menu', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '1rem',
			'line-height' => '1.8',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_primary_menu_dropdown', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '1rem',
			'line-height' => '1.8',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_mobile_menu', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '1rem',
			'line-height' => '1.8',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_post_page_title', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_blog_post_title', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '2.25rem',
			'line-height' => '1.3',
		) ) );

		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_h1', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '2.5rem',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_h2', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '2.25rem',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_h3', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '2.25rem',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_h4', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '1.75rem',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_h5', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '1.313rem',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_h6', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '1.125rem',
			'line-height' => '1.3',
		) ) );

		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_widget_heading', array(
			'font-family' => 'websafe',
			'variant'     => '500',
			'font-size'   => '1.2rem',
			'line-height' => '1.3',
		) ) );
		array_push( $selected_fonts, get_theme_mod( 'zakra_typography_widget_content', array(
			'font-family' => 'websafe',
			'variant'     => '400',
			'font-size'   => '15px',
			'line-height' => '1.8',
		) ) );

        $selected_fonts = apply_filters( 'zakra_selected_google_fonts', $selected_fonts );

		// Check if selected font is matched in the list
		// Check for the Google Fonts arrays.
		foreach ( $selected_fonts as $selected_font ) {
			if ( array_key_exists( $selected_font['font-family'], $fonts_all ) ) {
				$selected_fonts_pass[] = $selected_font;
			}
		}

		return $selected_fonts_pass;
	}

	/**
	 * Enqueue fonts.
	 */
	public function enqueue() {

		$this->selected_fonts = $this->google_fonts();
		$font_str             = '';
		$subsets              = array();

		if ( empty( $this->selected_fonts ) ) {
			return;
		}

		foreach ( $this->selected_fonts as $google_font ) {
			if ( ! empty( $font_str ) ) {
				$font_str .= '|';
			}

			$font_str .= $google_font['font-family'];
			if ( ! empty( $google_font['variant'] ) ) {
				$font_str .= ':' . $google_font['variant'];
			}

			if ( ! empty( $google_font['subsets'] ) ) {
				$subsets[] = is_array( $google_font['subsets'] ) ? implode( ',', $google_font['subsets'] ) : $google_font['subsets'];
			}
		}

		if ( ! empty( $subsets ) ) {
			$subsets_str = '&amp;subset=' . implode( ',', $subsets );
			$font_str    .= $subsets_str;
		}

		wp_register_style( 'zakra-googlefonts', '//fonts.googleapis.com/css?family=' . $font_str );
		wp_enqueue_style( 'zakra-googlefonts' );

	}

}

new Zakra_Google_Fonts();
