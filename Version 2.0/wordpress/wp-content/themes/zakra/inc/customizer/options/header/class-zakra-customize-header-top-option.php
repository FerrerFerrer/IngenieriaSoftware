<?php
/**
 * Header top options.
 *
 * @package     zakra
 */

defined( 'ABSPATH' ) || exit;

/*========================================== HEADER > HEADER TOP ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Header_Top_Option' ) ) :

	/**
	 * Header top customizer options.
	 */
	class Zakra_Customize_Header_Top_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				/**
				 * Header > Header Top Bar > Enable Header Top Bar.
				 */
				'zakra_header_top_enabled'               => array(
					'setting' => array(
						'default'           => false,
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_checkbox' ),

					),
					'control' => array(
						'label'    => esc_html__( 'Enable Header Top Bar', 'zakra' ),
						'section'  => 'zakra_header_top',
						'type'     => 'toggle',
						'priority' => 10,
					),
				),

				/* ============================== Left Content ============================== */

				/**
				 * Header > Header Top Bar > Left content.
				 */
				'zakra_header_top_left_content'          => array(
					'setting' => array(
						'default'           => 'text_html',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'            => 'select',
						'priority'        => 20,
						'is_default_type' => true,
						'label'           => esc_html__( 'Left Content', 'zakra' ),
						'section'         => 'zakra_header_top',
						'choices'         => array(
							'none'      => esc_html__( 'None', 'zakra' ),
							'text_html' => esc_html__( 'Text/HTML', 'zakra' ),
							'menu'      => esc_html__( 'Menu', 'zakra' ),
							'widget'    => esc_html__( 'Widget', 'zakra' ),
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
						),

					),
				),

				/**
				 * Header > Header Top Bar > Left content > Text/HTML for Left Content.
				 */
				'zakra_header_top_left_content_html'     => array(
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => 'wp_kses_post',
					),
					'control' => array(
						'type'            => 'editor',
						'priority'        => 30,
						'label'           => esc_html__( 'Text/HTML for Left Content', 'zakra' ),
						'section'         => 'zakra_header_top',
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
							array(
								'setting'  => 'zakra_header_top_left_content',
								'operator' => '==',
								'value'    => 'text_html',
							),
						),
					),
				),

				/**
				 * Header > Header Top Bar > Left Content > Menu for Left Content.
				 */
				'zakra_header_top_left_content_menu'     => array(
					'setting' => array(
						'default'           => 'none',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'            => 'select',
						'priority'        => 40,
						'is_default_type' => true,
						'label'           => esc_html__( 'Select a Menu for Left Content', 'zakra' ),
						'section'         => 'zakra_header_top',
						'choices'         => $this->get_menu_options(),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
							array(
								'setting'  => 'zakra_header_top_left_content',
								'operator' => '==',
								'value'    => 'menu',
							),
						),

					),
				),

				/* ============================== Right Content ============================== */

				/**
				 * Header > Header Top Bar > Right content.
				 */
				'zakra_header_top_right_content'         => array(
					'setting' => array(
						'default'           => 'menu',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'            => 'select',
						'priority'        => 50,
						'is_default_type' => true,
						'label'           => esc_html__( 'Right Content', 'zakra' ),
						'section'         => 'zakra_header_top',
						'choices'         => array(
							'none'      => esc_html__( 'None', 'zakra' ),
							'text_html' => esc_html__( 'Text/HTML', 'zakra' ),
							'menu'      => esc_html__( 'Menu', 'zakra' ),
							'widget'    => esc_html__( 'Widget', 'zakra' ),
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Header > Header Top Bar > Right content > Text/HTML for Right Content.
				 */
				'zakra_header_top_right_content_html'    => array(
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => 'wp_kses_post',
					),
					'control' => array(
						'type'            => 'editor',
						'priority'        => 60,
						'label'           => esc_html__( 'Text/HTML for Right Content', 'zakra' ),
						'section'         => 'zakra_header_top',
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
							array(
								'setting'  => 'zakra_header_top_right_content',
								'operator' => '==',
								'value'    => 'text_html',
							),
						),
					),
				),

				/**
				 * Header > Header Top Bar > Right content > Menu for Right Content.
				 */
				'zakra_header_top_right_content_menu'    => array(
					'setting' => array(
						'default'           => 'none',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'            => 'select',
						'priority'        => 70,
						'is_default_type' => true,
						'label'           => esc_html__( 'Select a Menu for Right Content', 'zakra' ),
						'section'         => 'zakra_header_top',
						'choices'         => $this->get_menu_options(),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
							array(
								'setting'  => 'zakra_header_top_right_content',
								'operator' => '==',
								'value'    => 'menu',
							),
						),

					),
				),

				/**
				 * Header > Header Top Bar > Header Top Text Color
				 */
				'zakra_header_top_text_color'            => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-header .tg-site-header-top',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '#51585f',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 80,
						'label'           => esc_html__( 'Header Top Text Color', 'zakra' ),
						'section'         => 'zakra_header_top',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * OptionHeader > Header Top Bar > Background.
				 */
				'zakra_header_top_bg'                    => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-header .tg-site-header-top',
						),
					),
					'setting' => array(
						'default'           => array(
							'background-color'      => '#e9ecef',
							'background-image'      => '',
							'background-repeat'     => 'repeat',
							'background-position'   => 'center center',
							'background-size'       => 'contain',
							'background-attachment' => 'scroll',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_background' ),
					),
					'control' => array(
						'type'            => 'background',
						'priority'        => 90,
						'label'           => esc_html__( 'Background', 'zakra' ),
						'section'         => 'zakra_header_top',
						'active_callback' => array(
							array(
								'setting'  => 'zakra_header_top_enabled',
								'operator' => '==',
								'value'    => true,
							),
						),
					),
				),

			);

		}

	}

	new Zakra_Customize_Header_Top_Option();

endif;
