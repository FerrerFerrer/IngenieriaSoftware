<?php
/**
 * General options.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== GENERAL ==========================================*/
if ( ! class_exists( 'Zakra_Customize_General_Option' ) ) :

	/**
	 * General option.
	 */
	class Zakra_Customize_General_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			$elements = array(

				/**
				 * General > Container Style.
				 */
				'zakra_general_container_style' => array(
					'setting' => array(
						'default'           => 'tg-container--wide',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'     => 'radio_image',
						'priority' => 10,
						'label'    => esc_html__( 'Container Style', 'zakra' ),
						'section'  => 'zakra_general',
						'choices'  => array(
							'tg-container--wide'     => ZAKRA_PARENT_INC_ICON_URI . '/wide.png',
							'tg-container--boxed'    => ZAKRA_PARENT_INC_ICON_URI . '/boxed.png',
							'tg-container--separate' => ZAKRA_PARENT_INC_ICON_URI . '/separate.png',
						),

					),
				),

				/**
				 * General > Container Width.
				 */
				'zakra_general_container_width' => array(
					'output'  => array(
						array(
							'selector'    => '.tg-container',
							'property'    => 'max-width',
							'media_query' => '@media (min-width: 1200px)',
						),
					),
					'setting' => array(
						'default'           => array(
							'slider' => 1160,
							'suffix' => 'px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control' => array(
						'type'        => 'slider',
						'priority'    => 20,
						'label'       => esc_html__( 'Container Width', 'zakra' ),
						'section'     => 'zakra_general',
						'input_attrs' => array(
							'min'  => 768,
							'max'  => 1920,
							'step' => 1,
						),
					),
				),

				/**
				 * General > Content Width.
				 */
				'zakra_general_content_width'   => array(
					'output'  => array(
						array(
							'selector' => '#primary',
							'property' => 'width',
						),
					),
					'setting' => array(
						'default'           => array(
							'slider' => 70,
							'suffix' => '%',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control' => array(
						'type'        => 'slider',
						'priority'    => 30,
						'label'       => esc_html__( 'Content Width', 'zakra' ),
						'description' => esc_html__( 'Only works for left/ right sidebar layout', 'zakra' ),
						'section'     => 'zakra_general',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
				),

				/**
				 * General > Sidebar Width.
				 */
				'zakra_general_sidebar_width'   => array(
					'output'  => array(
						array(
							'selector' => '#secondary',
							'property' => 'width',
						),
					),
					'setting' => array(
						'default'           => array(
							'slider' => 30,
							'suffix' => '%',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control' => array(
						'type'        => 'slider',
						'priority'    => 40,
						'label'       => esc_html__( 'Sidebar Width', 'zakra' ),
						'description' => esc_html__( 'Only works for left/ right sidebar layout', 'zakra' ),
						'section'     => 'zakra_general',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
				),

			);

			return $elements;

		}

	}

	new Zakra_Customize_General_Option();

endif;
