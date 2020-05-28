<?php
/**
 * Header button options.
 *
 * @package zakra
 */

defined( 'ABSPATH' ) || exit;

/*========================================== HEADER > HEADER BUTTON ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Header_Button_Option' ) ) :

	/**
	 * Header main customizer options.
	 */
	class Zakra_Customize_Header_Button_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				/**
				 * Header > Header Button > Button Text.
				 */
				'zakra_header_button_text' => array(
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'control' => array(
						'type'            => 'text',
						'priority'        => 10,
						'is_default_type' => true,
						'label'           => esc_html__( 'Button Text', 'zakra' ),
						'section'         => 'zakra_header_button',
					),
				),

				/**
				 * Header > Header Button > Button Link.
				 */
				'zakra_header_button_link' => array(
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => 'esc_url_raw',
					),
					'control' => array(
						'type'            => 'text',
						'priority'        => 20,
						'is_default_type' => true,
						'label'           => esc_html__( 'Button Link', 'zakra' ),
						'section'         => 'zakra_header_button',
					),
				),

				'zakra_header_button_target'           => array(
					'setting' => array(
						'default'           => false,
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_checkbox' ),
					),
					'control' => array(
						'type'     => 'toggle',
						'priority' => 30,
						'label'    => esc_html__( 'Open link in a new tab', 'zakra' ),
						'section'  => 'zakra_header_button',
					),
				),

				/**
				 * Header > Header Button > Text Color.
				 */
				'zakra_header_button_text_color'       => array(
					'output'  => array(
						array(
							'selector' => '.main-navigation.tg-primary-menu > div ul li.tg-header-button-wrap a',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '#ffffff',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'     => 'color',
						'priority' => 40,
						'label'    => esc_html__( 'Text Color', 'zakra' ),
						'section'  => 'zakra_header_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Header > Header Button > Text Hover Color.
				 */
				'zakra_header_button_text_hover_color' => array(
					'output'  => array(
						array(
							'selector' => '.main-navigation.tg-primary-menu > div ul li.tg-header-button-wrap a:hover',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '#ffffff',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'     => 'color',
						'priority' => 50,
						'label'    => esc_html__( 'Text Hover Color', 'zakra' ),
						'section'  => 'zakra_header_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Header > Header Button > Background Color.
				 */
				'zakra_header_button_bg_color'         => array(
					'output'  => array(
						array(
							'selector' => '.main-navigation.tg-primary-menu > div ul li.tg-header-button-wrap a',
							'property' => 'background-color',
						),
					),
					'setting' => array(
						'default'           => '#269bd1',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'     => 'color',
						'priority' => 60,
						'label'    => esc_html__( 'Background Color', 'zakra' ),
						'section'  => 'zakra_header_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Header > Header Button > Background Hover color.
				 */
				'zakra_header_button_bg_hover_color'   => array(
					'output'  => array(
						array(
							'selector' => '.main-navigation.tg-primary-menu > div ul li.tg-header-button-wrap a:hover',
							'property' => 'background-color',
						),
					),
					'setting' => array(
						'default'           => '#1e7ba6',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'     => 'color',
						'priority' => 70,
						'label'    => esc_html__( 'Background Hover Color', 'zakra' ),
						'section'  => 'zakra_header_button',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 * Header > Header Button > Roundness.
				 */
				'zakra_header_button_roundness'        => array(
					'output'  => array(
						array(
							'selector' => '.main-navigation.tg-primary-menu > div ul li.tg-header-button-wrap a',
							'property' => 'border-radius',
						),
					),
					'setting' => array(
						'default'           => array(
							'slider' => 0,
							'suffix' => 'px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control' => array(
						'type'        => 'slider',
						'priority'    => 80,
						'label'       => esc_html__( 'Roundness', 'zakra' ),
						'section'     => 'zakra_header_button',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 30,
							'step' => 1,
						),
					),
				),

				/**
				 * Header > Header Button > Padding.
				 */
				'zakra_header_button_padding'          => array(
					'output'  => array(
						array(
							'selector' => '.main-navigation.tg-primary-menu > div ul li.tg-header-button-wrap a',
							'property' => 'padding',
						),
					),
					'setting' => array(
						'default'           => array(
							'top'    => '5px',
							'right'  => '10px',
							'bottom' => '5px',
							'left'   => '10px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_dimensions' ),
					),
					'control' => array(
						'type'        => 'dimensions',
						'priority'    => 90,
						'label'       => esc_html__( 'Padding', 'zakra' ),
						'section'     => 'zakra_header_button',
						'input_attrs' => array(
							'min'  => 0,
							'step' => 1,
						),
					),
				),

			);

		}

	}

	new Zakra_Customize_Header_Button_Option();

endif;
