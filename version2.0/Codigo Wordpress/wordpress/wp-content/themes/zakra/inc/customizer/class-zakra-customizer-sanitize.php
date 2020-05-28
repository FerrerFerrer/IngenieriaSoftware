<?php
/**
 * Customizer sanitize class.
 *
 * @package zakra
 *
 * @access  public
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Customizer Sanitizes Initial setup
 */
class Zakra_Customizer_Sanitize {

	/**
	 * Instance
	 *
	 * @access private
	 * @var object
	 */
	private static $instance;

	/**
	 * Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Sanitize Background control.
	 *
	 * @param  mixed $val The value to be sanitized.
	 *
	 * @return array
	 */
	public static function sanitize_background( $val ) {

		if ( ! is_array( $val ) ) {
			return array();
		}

		return array(
			'background-color'      => ( isset( $val['background-color'] ) ) ? esc_attr( $val['background-color'] ) : '',
			'background-image'      => ( isset( $val['background-image'] ) ) ? esc_url_raw( $val['background-image'] ) : '',
			'background-repeat'     => ( isset( $val['background-repeat'] ) ) ? esc_attr( $val['background-repeat'] ) : '',
			'background-position'   => ( isset( $val['background-position'] ) ) ? esc_attr( $val['background-position'] ) : '',
			'background-size'       => ( isset( $val['background-size'] ) ) ? esc_attr( $val['background-size'] ) : '',
			'background-attachment' => ( isset( $val['background-attachment'] ) ) ? esc_attr( $val['background-attachment'] ) : '',
		);
	}

	/**
	 * Sanitize Alpha Color control.
	 *
	 * @param string $val The value to be sanitized.
	 *
	 * @return string
	 */
	public static function sanitize_alpha_color( $val ) {

		if ( '' === $val ) {
			return '';
		}

		if ( is_string( $val ) && 'transparent' === trim( $val ) ) {
			return 'transparent';
		}

		// If not, rgba color, perform hex sanitize.
		if ( false === strpos( $val, 'rgba' ) ) {
			return sanitize_hex_color( $val );
		}

		// So, it might be rgba color, sanitize it.
		// Remove spaces so that sscanf works properly.
		$color = str_replace( ' ', '', $val );
		// Assign color values in variables scanning the $color string.
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $r, $g, $b, $a );

		return "rgba($r,$g,$b,$a)";

	}

	/**
	 * Sanitize Dimensions control.
	 *
	 * @param array $val The value to be sanitized.
	 *
	 * @return array
	 */
	public static function sanitize_dimensions( $val ) {

		if ( ! is_array( $val ) ) {
			return array();
		}

		// Sanitize each dimension input.
		foreach ( $val as $key => $item ) {
			$val[ $key ] = sanitize_text_field( $item );
		}

		return $val;

	}

	/**
	 * Sanitize Radio Buttonset control.
	 *
	 * @param string $val     The value to be sanitized.
	 * @param object $setting Control setting.
	 *
	 * @return string
	 */
	public static function sanitize_radio( $val, $setting ) {

		// Radio key must be slug, which can contain lowercase alphanumeric characters, dash, low dash symbols only.
		$val = sanitize_key( $val );

		// Retrieve all choices.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// Ensure the value is among the choices. If fails test, return default.
		return array_key_exists( $val, $choices ) ? $val : $setting->default;

	}

	/**
	 * Sanitize Slider control.
	 *
	 * @param array  $val     The value to be sanitized.
	 * @param object $setting Control setting.
	 *
	 * @return array
	 */
	public static function sanitize_slider( $val, $setting ) {

		$input_attrs = array();

		if ( isset( $setting->manager->get_control( $setting->id )->input_attrs ) ) {
			$input_attrs = $setting->manager->get_control( $setting->id )->input_attrs;
		}

		$val['slider'] = is_numeric( $val['slider'] ) ? $val['slider'] : '';

		$val['slider'] = isset( $input_attrs['min'] ) && ( ! empty( $val ) ) && ( $input_attrs['min'] > $val['slider'] ) ? $input_attrs['min'] : $val['slider'];
		$val['slider'] = isset( $input_attrs['max'] ) && ( ! empty( $val ) ) && ( $input_attrs['max'] < $val['slider'] ) ? $input_attrs['max'] : $val['slider'];

		$val['suffix'] = esc_attr( $val['suffix'] );

		return $val;

	}

	/**
	 * Sanitize Sortable control.
	 *
	 * @param array  $val     The value to be sanitized.
	 * @param object $setting Control setting.
	 *
	 * @return array
	 */
	public static function sanitize_sortable( $val = array(), $setting ) {

		if ( is_string( $val ) || is_numeric( $val ) ) {
			return array(
				esc_attr( $val ),
			);
		}

		$sanitized_value = array();

		// Sanitize each sortable item.
		foreach ( $val as $item ) {
			if ( isset( $setting->manager->get_control( $setting->id )->choices[ $item ] ) ) {
				$sanitized_value[] = esc_attr( $item );
			}
		}

		return $sanitized_value;

	}

	/**
	 * Sanitize checkbox.
	 *
	 * @param bool $val The value to be sanitized.
	 *
	 * @return bool
	 */
	public static function sanitize_checkbox( $val ) {

		if ( '0' === $val || 'false' === $val ) {
			return false;
		}

		return (bool) $val;

	}

	/**
	 * Sanitize Typography control.
	 *
	 * @param array $value The value to be sanitized.
	 *
	 * @return array
	 */
	public static function sanitize_typography( $value ) {

		if ( ! is_array( $value ) ) {
			return array();
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family'] = esc_attr( $val );
					break;
				case 'variant':
					$value['variant']     = ( 400 === $val || '400' === $val ) ? '400' : $val;
					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( '400' === $value['variant'] || 'italic' === $value['variant'] ) ? 400 : absint( $value['font-weight'] );

					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}
					break;
				case 'font-weight':
					if ( isset( $value['variant'] ) ) {
						break;
					}
					$value['variant'] = $val;
					if ( isset( $value['font-style'] ) && 'italic' === $value['font-style'] ) {
						$value['variant'] = ( '400' !== $val || 400 !== $val ) ? $value['variant'] . 'italic' : 'italic';
					}
					break;
				case 'font-size':
				case 'line-height':
					$value[ $key ] = '' === trim( $value[ $key ] ) ? '' : sanitize_text_field( $val );
					break;
				case 'color':
					$value['color'] = ( '' === $value['color'] ) ? '' : sanitize_hex_color( $val );
					break;
			}
		}

		return $value;

	}

}

Zakra_Customizer_Sanitize::get_instance();
