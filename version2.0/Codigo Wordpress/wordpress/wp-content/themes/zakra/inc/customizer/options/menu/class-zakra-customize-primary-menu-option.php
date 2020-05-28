<?php
/**
 * Primary menu.
 *
 * @package zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== MENU > PRIMARY MENU ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Primary_Menu_Option' ) ) :

	/**
	 * Primary Menu option.
	 */
	class Zakra_Customize_Primary_Menu_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				/**
				 * Menu > Primary Menu > Disable Primary Menu.
				 */
				'zakra_primary_menu_disabled'            => array(
					'setting' => array(
						'default'           => false,
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_checkbox' ),
					),
					'control' => array(
						'type'     => 'toggle',
						'priority' => 10,
						'label'    => esc_html__( 'Disable Primary Menu', 'zakra' ),
						'section'  => 'zakra_primary_menu',
					),
				),

				/**
				 * Menu > Primary Menu > Keep Menu Items on one line.
				 */
				'zakra_primary_menu_extra'               => array(
					'setting' => array(
						'default'           => false,
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_checkbox' ),
					),
					'control' => array(
						'type'            => 'toggle',
						'priority'        => 20,
						'label'           => esc_html__( 'Keep Menu Items on One Line', 'zakra' ),
						'section'         => 'zakra_primary_menu',
						'active_callback' => array(
							array(
								'setting'  => 'zakra_primary_menu_disabled',
								'operator' => '===',
								'value'    => false,
							),
						),
					),
				),

				/**
				 * Menu > Primary Menu > Border Bottom.
				 */
				'zakra_primary_menu_border_bottom_width' => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-header .main-navigation',
							'property' => 'border-bottom-width',
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
						'type'            => 'slider',
						'priority'        => 30,
						'label'           => esc_html__( 'Border Bottom', 'zakra' ),
						'section'         => 'zakra_primary_menu',
						'input_attrs'     => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_primary_menu_disabled',
								'operator' => '===',
								'value'    => false,
							),
						),
					),
				),

				/**
				 * Menu > Primary Menu > Border Bottom Color.
				 */
				'zakra_primary_menu_border_bottom_color' => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-header .main-navigation',
							'property' => 'border-bottom-color',
						),
					),
					'setting' => array(
						'default'           => '#e9ecef',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 40,
						'label'           => esc_html__( 'Border Bottom Color', 'zakra' ),
						'section'         => 'zakra_primary_menu',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => array(
							array(
								'setting'  => 'zakra_primary_menu_disabled',
								'operator' => '===',
								'value'    => false,
							),
						),
					),
				),

				/** ##========== Menu item: Default Style ==========## */

				/**
				 * Menu > Primary Menu > Menu Item Color.
				 */
				'zakra_primary_menu_text_color'          => array(
					'output'  => array(
						array(
							'selector' => '.tg-primary-menu > div > ul li:not(.tg-header-button-wrap) a',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 50,
						'label'           => esc_html__( 'Menu Item Color', 'zakra' ),
						'section'         => 'zakra_primary_menu_item',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => apply_filters(
							'zakra_primary_menu_item_style_cb',
							array(
								array(
									'setting'  => 'zakra_primary_menu_disabled',
									'operator' => '===',
									'value'    => false,
								),
							)
						),
					),
				),

				/**
				 * Menu > Primary Menu > Menu Item Hover Color.
				 */
				'zakra_primary_menu_text_hover_color'    => array(
					'output'  => array(
						array(
							'selector' => '.tg-primary-menu > div > ul li:not(.tg-header-button-wrap):hover > a',
							'property' => 'color',
						),
					),
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 60,
						'label'           => esc_html__( 'Menu Item Hover Color', 'zakra' ),
						'section'         => 'zakra_primary_menu_item',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => apply_filters(
							'zakra_primary_menu_item_style_cb',
							array(
								array(
									'setting'  => 'zakra_primary_menu_disabled',
									'operator' => '===',
									'value'    => false,
								),
							)
						),
					),
				),

				/**
				 * Menu > Primary Menu > Menu Item Active Color.
				 */
				'zakra_primary_menu_text_active_color'   => array(
					'output'  => array(
						array(
							'selector' => '.tg-primary-menu > div ul li:active > a, .tg-primary-menu > div ul > li:not(.tg-header-button-wrap).current_page_item > a, .tg-primary-menu > div ul > li:not(.tg-header-button-wrap).current-menu-item > a',
							'property' => 'color',
						),
						array(
							'selector' => '.tg-primary-menu.tg-primary-menu--style-underline > div ul > li:not(.tg-header-button-wrap).current_page_item > a::before, .tg-primary-menu.tg-primary-menu--style-underline > div ul > li:not(.tg-header-button-wrap).current-menu-item > a::before, .tg-primary-menu.tg-primary-menu--style-left-border > div ul > li:not(.tg-header-button-wrap).current_page_item > a::before, .tg-primary-menu.tg-primary-menu--style-left-border > div ul > li:not(.tg-header-button-wrap).current-menu-item > a::before, .tg-primary-menu.tg-primary-menu--style-right-border > div ul > li:not(.tg-header-button-wrap).current_page_item > a::before, .tg-primary-menu.tg-primary-menu--style-right-border > div ul > li:not(.tg-header-button-wrap).current-menu-item > a::before',
							'property' => 'background-color',
						),
					),
					'setting' => array(
						'default'           => '',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'            => 'color',
						'priority'        => 70,
						'label'           => esc_html__( 'Menu Item Active Color', 'zakra' ),
						'section'         => 'zakra_primary_menu_item',
						'choices'         => array(
							'alpha' => true,
						),
						'active_callback' => apply_filters(
							'zakra_primary_menu_item_style_cb',
							array(
								array(
									'setting'  => 'zakra_primary_menu_disabled',
									'operator' => '===',
									'value'    => false,
								),
							)
						),
					),
				),

				/**
				 * Menu > Primary Menu > Active Menu Item Style.
				 */
				'zakra_primary_menu_text_active_effect'  => array(
					'setting' => array(
						'default'           => 'tg-primary-menu--style-underline',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_radio' ),
					),
					'control' => array(
						'type'            => 'select',
						'priority'        => 80,
						'is_default_type' => true,
						'label'           => esc_html__( 'Active Menu Item Style', 'zakra' ),
						'section'         => 'zakra_primary_menu_item',
						'choices'         => array(
							'tg-primary-menu--style-none'         => esc_html__( 'None', 'zakra' ),
							'tg-primary-menu--style-underline'    => esc_html__( 'Underline Border', 'zakra' ),
							'tg-primary-menu--style-left-border'  => esc_html__( 'Left Border', 'zakra' ),
							'tg-primary-menu--style-right-border' => esc_html__( 'Right Border', 'zakra' ),
						),
						'active_callback' => apply_filters(
							'zakra_primary_menu_item_style_cb',
							array(
								array(
									'setting'  => 'zakra_primary_menu_disabled',
									'operator' => '===',
									'value'    => false,
								),
							)
						),
					),
				),
				/*  End: Default Styles */

			);

		}

	}

	new Zakra_Customize_Primary_Menu_Option();

endif;
