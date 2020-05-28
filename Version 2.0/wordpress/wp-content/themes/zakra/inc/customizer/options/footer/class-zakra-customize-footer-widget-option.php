<?php
/**
 * Footer widgets options.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== FOOTER > FOOTER WIDGETS ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Footer_Widget_Option' ) ) :

	/**
	 * Option: Footer widget Option.
	 */
	class Zakra_Customize_Footer_Widget_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				/**
				 * Footer > Footer Widgets > Enable Footer Widgets.
				 */
				'zakra_footer_widgets_enabled'                  => array(
					'setting' => array(
						'default'           => true,
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_checkbox' ),
					),
					'control' => array(
						'type'     => 'toggle',
						'priority' => 10,
						'label'    => esc_html__( 'Enable Footer Widgets', 'zakra' ),
						'section'  => 'zakra_footer_widgets',
					),
				),

				/**
				 * Footer > Footer Widgets > Footer Widgets Style.
				 */
				'zakra_footer_widgets_style'                    => array(
					'setting' => array(
						'default'           => 'tg-footer-widget-col--four',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'            => 'radio_image',
						'priority'        => 20,
						'label'           => esc_html__( 'Footer Widgets Style', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => apply_filters( 'zakra_footer_widgets_style_choices', array(
							'tg-footer-widget-col--one'   => ZAKRA_PARENT_INC_ICON_URI . '/one-column.png',
							'tg-footer-widget-col--two'   => ZAKRA_PARENT_INC_ICON_URI . '/two-columns.png',
							'tg-footer-widget-col--three' => ZAKRA_PARENT_INC_ICON_URI . '/three-columns.png',
							'tg-footer-widget-col--four'  => ZAKRA_PARENT_INC_ICON_URI . '/four-columns.png',
						) ),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Background.
				 */
				'zakra_footer_widgets_bg'                       => array(
					'output'  => array(
						array(
							'selector' => apply_filters( 'zakra_footer_widgets_bg_selector', '.tg-site-footer-widgets' ),
						),
					),
					'setting' => array(
						'default'           => array(
							'background-color'      => '#ffffff',
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
						'priority'        => 30,
						'label'           => esc_html__( 'Background', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Border Top.
				 */
				'zakra_footer_widgets_border_top_width'         => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets',
							'property' => 'border-top-width',
						),
					),
					'setting' => array(
						'default'           => array(
							'slider' => 1,
							'suffix' => 'px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control' => array(
						'type'            => 'slider',
						'priority'        => 40,
						'label'           => esc_html__( 'Border Top', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'input_attrs'     => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Border Top Color.
				 */
				'zakra_footer_widgets_border_top_color'         => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets',
							'property' => 'border-top-color',
						),
					),
					'setting' => array(
						'default'           => '#e9ecef',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 50,
						'label'           => esc_html__( 'Border Top Color', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Hide Widget Title.
				 */
				'zakra_footer_widgets_hide_title'               => array(
					'setting' => array(
						'default'           => false,
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_checkbox' ),
					),
					'control' => array(
						'type'            => 'toggle',
						'priority'        => 60,
						'label'           => esc_html__( 'Hide Widget Title', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Widget Title Color.
				 */
				'zakra_footer_widgets_title_color'              => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets .widget-title',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '#16181a',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 70,
						'label'           => esc_html__( 'Widget Title Color', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
							array(
								'setting'  => 'zakra_footer_widgets_hide_title',
								'operator' => '===',
								'value'    => false,
							),
						),

					),
				),

				/*========================================== FOOTER > FOOTER WIDGETS:STYLING ==========================================*/
				/**
				 * Footer > Footer Widgets > Text Color.
				 */
				'zakra_footer_widgets_text_color'               => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets, .tg-site-footer .tg-site-footer-widgets p',
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
						'label'           => esc_html__( 'Text Color', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Link Color.
				 */
				'zakra_footer_widgets_link_color'               => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets a',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '#16181a',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 90,
						'label'           => esc_html__( 'Link Color', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > Link Hover Color.
				 */
				'zakra_footer_widgets_link_hover_color'         => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets a:hover, .tg-site-footer .tg-site-footer-widgets a:focus',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '#269bd1',
						'capability'        => 'edit_theme_options',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 100,
						'label'           => esc_html__( 'Link Hover Color', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > List Item Border Bottom.
				 */
				'zakra_footer_widgets_item_border_bottom_width' => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets ul li',
							'property' => 'border-bottom-width',
						),
					),
					'setting' => array(
						'default'           => array(
							'slider' => 1,
							'suffix' => 'px',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_slider' ),
					),
					'control' => array(
						'type'            => 'slider',
						'priority'        => 110,
						'label'           => esc_html__( 'List Item Border Bottom', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'input_attrs'     => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

				/**
				 * Footer > Footer Widgets > List Item Border Bottom Color.
				 */
				'zakra_footer_widgets_item_border_bottom_color' => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-footer .tg-site-footer-widgets ul li',
							'property' => 'border-bottom-color',
						),
					),
					'setting' => array(
						'default'           => '#e9ecef',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 120,
						'label'           => esc_html__( 'List Item Border Bottom Color', 'zakra' ),
						'section'         => 'zakra_footer_widgets',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_footer_widgets_enabled',
								'operator' => '===',
								'value'    => true,
							),
						),
					),
				),

			);

		}

	}

	new Zakra_Customize_Footer_Widget_Option();

endif;
