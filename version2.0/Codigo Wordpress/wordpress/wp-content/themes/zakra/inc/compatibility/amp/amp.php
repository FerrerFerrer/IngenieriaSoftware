<?php
/**
 * AMP Compatibility.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Zakra_Amp' ) ) :

	/**
	 * Class Amp
	 */
	class Zakra_Amp {

		/**
		 * Initiate Hooks and filters.
		 */
		public function __construct() {
			add_filter( 'zakra_nav_data_attrs', array( $this, 'add_nav_attrs' ) );
			add_filter( 'zakra_nav_toggle_data_attrs', array( $this, 'add_nav_toggle_attrs' ) );
			add_filter( 'walker_nav_menu_start_el', array( $this, 'add_nav_sub_menu_buttons' ), 10, 2 );
		}

		/**
		 * Return mobile navigation data attrs.
		 *
		 * @param string $input The data attrs in the nav already existed.
		 *
		 * @return string
		 */
		public function add_nav_attrs( $input ) {
			if ( ! zakra_is_amp() ) {
				return $input;
			}
			$input .= ' [class]="( nvAmpMenuExpanded ? \'tg-mobile-navigation tg-mobile-navigation--opened\' : \'tg-mobile-navigation\' )" ';
			$input .= ' aria-expanded="false" [aria-expanded]="nvAmpMenuExpanded ? \'true\' : \'false\'" ';

			return $input;
		}

		/**
		 * Add the nav toggle data attributes.
		 *
		 * @param string $input the data attrs already existing in nav toggle.
		 *
		 * @return string
		 */
		public function add_nav_toggle_attrs( $input ) {
			if ( ! zakra_is_amp() ) {
				return $input;
			}

			$input .= ' on="tap:AMP.setState( { nvAmpMenuExpanded: ! nvAmpMenuExpanded } )" ';
			$input .= ' role="button" ';
			$input .= ' tabindex="0" ';

			$input .= ' aria-expanded="false" ';
			$input .= ' [aria-expanded]="nvAmpMenuExpanded ? \'true\' : \'false\'" ';

			return $input;
		}

		/**
		 * Show dropdown menu for AMP.
		 *
		 * @param string $item_output Nav menu item HTML.
		 * @param object $item        Nav menu item.
		 *
		 * @return string Modified nav menu item HTML.
		 */
		public function add_nav_sub_menu_buttons( $item_output, $item ) {

			if ( ! zakra_is_amp() ) {
				return $item_output;
			}

			if ( ! in_array( 'menu-item-has-children', $item->classes, true ) ) {
				return $item_output;
			}

			$expanded = in_array( 'current-menu-ancestor', $item->classes, true );

			// Generate a unique state ID.
			static $nav_menu_item_number = 0;
			$nav_menu_item_number ++;
			$expanded_state_id = 'navMenuItemExpanded' . $nav_menu_item_number;

			$item_output .= sprintf(
				'<amp-state id="%s"><script type="application/json">%s</script></amp-state>',
				esc_attr( $expanded_state_id ),
				wp_json_encode( $expanded )
			);

			$dropdown_button = '<span';
			$dropdown_class  = 'dropdown-toggle tg-submenu-toggle';
			$toggled_class   = 'toggled-on';
			$dropdown_button .= sprintf(
				' class="%s" [class]="%s"',
				esc_attr( $dropdown_class . ( $expanded ? " $toggled_class" : '' ) ),
				esc_attr( sprintf( "%s + ( $expanded_state_id ? %s : '' )", wp_json_encode( $dropdown_class ), wp_json_encode( " $toggled_class" ) ) )
			);

			$dropdown_button .= sprintf(
				' aria-expanded="%s" [aria-expanded]="%s"',
				esc_attr( wp_json_encode( $expanded ) ),
				esc_attr( "$expanded_state_id ? 'true' : 'false'" )
			);

			$dropdown_button .= sprintf(
				' on="%s"',
				esc_attr( "tap:AMP.setState( { $expanded_state_id: ! $expanded_state_id } )" )
			);

			$dropdown_button .= ' role="button" tabindex=0>';

			$dropdown_button .= '</span>';

			$item_output .= $dropdown_button;

			return $item_output;
		}

	}

	new Zakra_Amp();

endif;
