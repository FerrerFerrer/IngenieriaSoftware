<?php
/**
 * Button styling.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== STYLING >  BUTTON ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Button_Option' ) ) :

	/**
	 * Button option.
	 */
	class Zakra_Customize_Button_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				/**
				 * Styling > Button > Text Color.
				 */
				'zakra_button_text_color'       => array(
					'output'    => array(
						array(
							'selector' => 'button, input[type="button"], input[type="reset"], input[type="submit"]',
							'property' => 'color',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce ul.products a.button, .woocommerce div.product form.cart .button',
							'property' => 'color',
						),
					),
					'setting'   => array(
						'default'           => '#ffffff',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control'   => array(
						'type'     => 'color',
						'priority' => 10,
						'label'    => esc_html__( 'Text Color', 'zakra' ),
						'section'  => 'zakra_styling_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Styling > Button > Text Hover Color.
				 */
				'zakra_button_text_hover_color' => array(
					'output'    => array(
						array(
							'selector' => 'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover',
							'property' => 'color',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce a.button:hover, .woocommerce a.button.alt:hover, .woocommerce button.button:hover, .woocommerce button.button.alt:hover, .woocommerce ul.products a.button:hover, .woocommerce div.product form.cart .button:hover',
							'property' => 'color',
						),
					),
					'setting'   => array(
						'default'           => '#ffffff',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control'   => array(
						'type'     => 'color',
						'priority' => 20,
						'label'    => esc_html__( 'Text Hover Color', 'zakra' ),
						'section'  => 'zakra_styling_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Styling > Button > Background Color.
				 */
				'zakra_button_bg_color'         => array(
					'output'    => array(
						array(
							'selector' => 'button, input[type="button"], input[type="reset"], input[type="submit"]',
							'property' => 'background-color',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce ul.products a.button, .woocommerce div.product form.cart .button',
							'property' => 'background-color',
						),
					),
					'setting'   => array(
						'default'           => '#269bd1',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control'   => array(
						'type'     => 'color',
						'priority' => 30,
						'label'    => esc_html__( 'Background Color', 'zakra' ),
						'section'  => 'zakra_styling_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Styling > Button > Background Hover Color.
				 */
				'zakra_button_bg_hover_color'   => array(
					'output'    => array(
						array(
							'selector' => 'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover',
							'property' => 'background-color',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce a.button:hover, .woocommerce a.button.alt:hover, .woocommerce button.button:hover, .woocommerce button.button.alt:hover, .woocommerce ul.products a.button:hover, .woocommerce div.product form.cart .button:hover',
							'property' => 'background-color',
						),
					),
					'setting'   => array(
						'default'           => '#1e7ba6',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control'   => array(
						'type'     => 'color',
						'priority' => 40,
						'label'    => esc_html__( 'Background Hover Color', 'zakra' ),
						'section'  => 'zakra_styling_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Styling > Button > Roundness.
				 */
				'zakra_button_roundness'        => array(
					'output'    => array(
						array(
							'selector' => 'button, input[type="button"], input[type="reset"], input[type="submit"]',
							'property' => 'border-radius',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce ul.products a.button, .woocommerce div.product form.cart .button',
							'property' => 'border-radius',
						),
					),
					'setting'   => array(
						'default'           => array(
							'slider' => 0,
							'suffix' => 'px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control'   => array(
						'type'        => 'slider',
						'priority'    => 50,
						'label'       => esc_html__( 'Roundness', 'zakra' ),
						'section'     => 'zakra_styling_button',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
					),
				),

				/**
				 * Styling > Button > Padding.
				 */
				'zakra_button_padding'          => array(
					'output'    => array(
						array(
							'selector' => 'button, input[type="button"], input[type="reset"], input[type="submit"]',
							'property' => 'padding',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt, .woocommerce ul.products a.button, .woocommerce div.product form.cart .button, .woocommerce ul.products li.product .button',
							'property' => 'padding',
						),
					),
					'setting'   => array(
						'default'           => array(
							'top'    => '10px',
							'right'  => '15px',
							'bottom' => '10px',
							'left'   => '15px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_dimensions' ),
					),
					'control'   => array(
						'type'        => 'dimensions',
						'priority'    => 60,
						'label'       => esc_html__( 'Padding', 'zakra' ),
						'section'     => 'zakra_styling_button',
						'input_attrs' => array(
							'min'  => 0,
							'step' => 1,
						),
					),
				),

			);

		}

	}

	new Zakra_Customize_Button_Option();

endif;
