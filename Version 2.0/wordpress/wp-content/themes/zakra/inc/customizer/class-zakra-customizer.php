<?php
/**
 * Zakra Customizer Class
 *
 * @package zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Zakra_Customizer' ) ) :

	/**
	 * Zakra Customizer class
	 */
	class Zakra_Customizer {
		/**
		 * Constructor - Setup customizer
		 */
		public function __construct() {

			add_action( 'customize_register', array( $this, 'zakra_register_panel' ) );
			add_action( 'customize_register', array( $this, 'zakra_customize_register' ) );
			add_action( 'customize_register', array( $this, 'zakra_customize_helpers' ) );
			add_action( 'customize_preview_init', array( $this, 'zakra_customize_preview_js' ) );
			add_action( 'after_setup_theme', array( $this, 'zakra_customize_options' ) );

			require ZAKRA_PARENT_INC_DIR . '/customizer/controls/php/class-zakra-fonts.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/controls/php/webfonts/class-zakra-google-fonts.php';

		}

		/**
		 * Register custom controls
		 *
		 * @param WP_Customize_Manager $wp_customize Manager instance.
		 */
		public function zakra_register_panel( $wp_customize ) {

			// Controls path.
			$control_dir = ZAKRA_PARENT_INC_DIR . '/customizer/controls';
			$setting_dir = ZAKRA_PARENT_INC_DIR . '/customizer/settings';

			// Load customizer options extending classes.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/extend-customizer/class-zakra-customize-panel.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/extend-customizer/class-zakra-customize-section.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/extend-customizer/class-zakra-customize-upsell-section.php';

			// Register extended classes.
			$wp_customize->register_panel_type( 'Zakra_Customize_Panel' );
			$wp_customize->register_section_type( 'Zakra_Customize_Section' );

			// Load base class for controls.
			require_once $control_dir . '/php/class-zakra-customize-base-control.php';
			// Load custom control classes.
            require_once $control_dir . '/php/class-zakra-customize-background-control.php';
            require_once $control_dir . '/php/class-zakra-customize-upsell-control.php';
			require_once $control_dir . '/php/class-zakra-customize-color-control.php';
			require_once $control_dir . '/php/class-zakra-customize-dimensions-control.php';
			require_once $control_dir . '/php/class-zakra-customize-fontawesome-control.php';
			require_once $control_dir . '/php/class-zakra-customize-heading-control.php';
			require_once $control_dir . '/php/class-zakra-customize-editor-control.php';
			require_once $control_dir . '/php/class-zakra-customize-radio-image-control.php';
			require_once $control_dir . '/php/class-zakra-customize-radio-buttonset-control.php';
			require_once $control_dir . '/php/class-zakra-customize-slider-control.php';
			require_once $control_dir . '/php/class-zakra-customize-sortable-control.php';
			require_once $control_dir . '/php/class-zakra-customize-text-control.php';
			require_once $control_dir . '/php/class-zakra-customize-toggle-control.php';
			require_once $control_dir . '/php/class-zakra-customize-typography-control.php';

            // Register JS-rendered control types.
            $wp_customize->register_control_type( 'Zakra_Customize_Upsell_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Background_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Color_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Fontawesome_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Heading_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Editor_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Dimensions_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Radio_Image_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Radio_Buttonset_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Slider_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Sortable_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Text_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Toggle_Control' );
            $wp_customize->register_control_type( 'Zakra_Customize_Typography_Control' );

		}

		/**
		 * Include customizer helpers.
		 */
		public function zakra_customize_helpers() {

			require_once ZAKRA_PARENT_INC_DIR . '/customizer/class-zakra-customizer-sanitize.php';
			require_once ZAKRA_PARENT_INC_DIR . '/customizer/class-zakra-customizer-partials.php';

		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Manager instance.
		 */
		public function zakra_customize_register( $wp_customize ) {

			// Override defaults.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/override-defaults.php';

			// Register panels and sections.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/register-panels-and-sections.php';

		}

		/**
		 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
		 */
		public function zakra_customize_preview_js() {

			wp_enqueue_script( 'zakra-customizer', ZAKRA_PARENT_INC_URI . '/customizer/assets/js/customizer.js', array( 'customize-preview' ), ZAKRA_THEME_VERSION, true );

		}

		/**
		 * Include customizer options.
		 */
		public function zakra_customize_options() {
			/**
			 * Base class.
			 */
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/class-zakra-customize-base-option.php';

			/**
			 * Child option classes.
			 */
			// Header.
            require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/class-zakra-customize-upsell-option.php';
            require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/header/class-zakra-customize-header-top-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/header/class-zakra-customize-header-main-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/header/class-zakra-customize-header-button-option.php';

			// Menu.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/menu/class-zakra-customize-primary-menu-option.php';

			// General.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/general/class-zakra-customize-general-option.php';

			// Blog.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/blog/class-zakra-customize-blog-general-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/blog/class-zakra-customize-blog-archive-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/blog/class-zakra-customize-single-blog-post-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/blog/class-zakra-customize-blog-meta-option.php';

			// Layout.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/layout/class-zakra-customize-layout-general-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/layout/class-zakra-customize-layout-woocommerce-option.php';

			// Styling.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/styling/class-zakra-customize-base-colors-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/styling/class-zakra-customize-button-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/styling/class-zakra-customize-link-option.php';

			// Footer.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/footer/class-zakra-customize-footer-bottom-bar-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/footer/class-zakra-customize-footer-widget-option.php';
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/footer/class-zakra-customize-scroll-to-top-option.php';

			// Typography.
			require ZAKRA_PARENT_CUSTOMIZER_DIR . '/options/typography/class-zakra-customize-typography-option.php';

		}

	}
endif;

new Zakra_Customizer();
