<?php
/**
 * Layout WooCommerce layout.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Return if WooCommerce plugin is not activated.
if ( ! zakra_is_woocommerce_active() ) {
	return;
}

/*========================================== LAYOUT > WooCommerce ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Layout_WooCommerce_Option' ) ) :

	/**
	 * Layout WooCommerce option.
	 */
	class Zakra_Customize_Layout_WooCommerce_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			$sidebar_layout_choices = apply_filters( 'zakra_site_layout_choices', array(
				'tg-site-layout--default'    => ZAKRA_PARENT_INC_ICON_URI . '/layout-default.png',
				'tg-site-layout--left'       => ZAKRA_PARENT_INC_ICON_URI . '/left-sidebar.png',
				'tg-site-layout--right'      => ZAKRA_PARENT_INC_ICON_URI . '/right-sidebar.png',
				'tg-site-layout--no-sidebar' => ZAKRA_PARENT_INC_ICON_URI . '/full-width.png',
				'tg-site-layout--stretched'  => ZAKRA_PARENT_INC_ICON_URI . '/stretched.png',
			) );

			return array(

				/**
				 * Layout > WooCommerce > WooCommerce
				 */
				'zakra_structure_wc'         => array(
					'setting' => array(
						'default'           => 'tg-site-layout--right',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'     => 'radio_image',
						'priority' => 10,
						'label'    => esc_html__( 'WooCommerce', 'zakra' ),
						'section'  => 'zakra_layout_woocommerce_structure',
						'choices'  => $sidebar_layout_choices,
					),
				),

				/**
				 * Layout > WooCommerce > Single Product.
				 */
				'zakra_structure_wc_product' => array(
					'setting' => array(
						'default'           => 'tg-site-layout--right',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'     => 'radio_image',
						'priority' => 20,
						'label'    => esc_html__( 'Single Product', 'zakra' ),
						'section'  => 'zakra_layout_woocommerce_structure',
						'choices'  => $sidebar_layout_choices,
					),
				),

			);

		}

	}

	new Zakra_Customize_Layout_WooCommerce_Option();

endif;
