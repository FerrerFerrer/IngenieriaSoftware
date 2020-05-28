<?php
/**
 * Zakra Customizer partials.
 *
 * @package zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Zakra_Customizer_Partials' ) ) {

	/**
	 * Customizer Partials.
	 */
	class Zakra_Customizer_Partials {

		/**
		 * Instance.
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Render the site title for the selective refresh partial.
		 *
		 * @return string
		 */
		public static function customize_partial_blogname() {
			return get_bloginfo( 'name' );
		}

		/**
		 * Render the site tagline for the selective refresh partial.
		 *
		 * @return string
		 */
		public static function customize_partial_blogdescription() {
			return get_bloginfo( 'description' );
		}

	}
}

Zakra_Customizer_Partials::get_instance();
