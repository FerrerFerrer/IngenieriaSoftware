<?php
/**
 * Base styling.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== STYLING > BASE ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Base_Colors_Option' ) ) :

	/**
	 * Base option.
	 */
	class Zakra_Customize_Base_Colors_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			$primary_color = array(
				'output'    => array(
					array(
						'selector' => 'a:hover, a:focus,  .tg-primary-menu > div ul li:hover > a,  .tg-primary-menu > div ul li.current_page_item > a, .tg-primary-menu > div ul li.current-menu-item > a,  .tg-mobile-navigation > div ul li.current_page_item > a, .tg-mobile-navigation > div ul li.current-menu-item > a,  .entry-content a,  .tg-meta-style-two .entry-meta span, .tg-meta-style-two .entry-meta a',
						'property' => 'color',
					),
					array(
						'selector' => '.tg-primary-menu.tg-primary-menu--style-underline > div > ul > li.current_page_item > a::before, .tg-primary-menu.tg-primary-menu--style-underline > div > ul > li.current-menu-item > a::before, .tg-primary-menu.tg-primary-menu--style-left-border > div > ul > li.current_page_item > a::before, .tg-primary-menu.tg-primary-menu--style-left-border > div > ul > li.current-menu-item > a::before, .tg-primary-menu.tg-primary-menu--style-right-border > div > ul > li.current_page_item > a::before, .tg-primary-menu.tg-primary-menu--style-right-border > div > ul > li.current-menu-item > a::before, .tg-scroll-to-top:hover, button, input[type="button"], input[type="reset"], input[type="submit"], .tg-primary-menu > div ul li.tg-header-button-wrap a',
						'property' => 'background-color',
					),
				),
				'wc_output' => array(
					array(
						'selector' => '.woocommerce ul.products li.product .woocommerce-loop-product__title:hover,
							.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,
							.woocommerce div.product p.price, .woocommerce div.product span.price,
							.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
							.woocommerce .widget_price_filter .price_slider_amount .button',
						'property' => 'color',
					),
					array(
						'selector' => '.woocommerce span.onsale, .woocommerce ul.products a.button,
							.woocommerce a.button, .woocommerce a.button.alt, .woocommerce button.button, .woocommerce button.button.alt,
							.woocommerce nav.woocommerce-pagination ul li span.current,
							.woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus,
							.woocommerce div.product form.cart .button,
							.woocommerce div.product .woocommerce-tabs #respond input#submit,
							.woocommerce .widget_product_search .woocommerce-product-search button[type="submit"],
							.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range,
							.woocommerce .widget_price_filter .price_slider_amount .button:hover',
						'property' => 'background-color',
					),
					array(
						'selector' => '.woocommerce nav.woocommerce-pagination ul li,
							.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
							.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
							.woocommerce .widget_price_filter .price_slider_amount .button',
						'property' => 'border-color',
					),
				),
				'setting'   => array(
					'default'           => '#269bd1',
					'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
				),
				'control'   => array(
					'type'     => 'color',
					'priority' => 10,
					'label'    => esc_html__( 'Primary Color', 'zakra' ),
					'section'  => 'zakra_styling_base',
					'choices'  => array(
						'alpha' => true,
					),
				),
			);

			return array(

				/**
				 * Styling > Base Colors > Primary color.
				 */
				'zakra_base_color_primary' => apply_filters( 'zakra_base_color_primary_args', $primary_color ),

				/**
				 *  Styling > Base Colors > Text color.
				 */
				'zakra_base_color_text'    => array(
					'output'    => array(
						array(
							'selector' => 'body',
							'property' => 'color',
						),
					),
					'wc_output' => array(
						array(
							'selector' => '.woocommerce ul.products li.product .price, .woocommerce .star-rating span',
							'property' => 'color',
						),
					),
					'setting'   => array(
						'default'           => '#51585f',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control'   => array(
						'type'     => 'color',
						'priority' => 20,
						'label'    => esc_html__( 'Text Color', 'zakra' ),
						'section'  => 'zakra_styling_base',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

				/**
				 *  Styling > Base Colors > Border Color.
				 */
				'zakra_base_color_border'  => array(
					'output'  => array(
						array(
							'selector' => '.tg-site-header, .tg-primary-menu, .tg-primary-menu > div ul li ul, .tg-primary-menu > div ul li ul li a, .posts-navigation, #comments, .widget ul li, .post-navigation, #secondary, .tg-site-footer .tg-site-footer-widgets, .tg-site-footer .tg-site-footer-bar .tg-container',
							'property' => 'border-color',
						),

						array(
							'selector' => 'hr .tg-container--separate, ',
							'property' => 'background-color',
						),
					),
					'setting' => array(
						'default'           => '#e9ecef',
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_alpha_color' ),
					),
					'control' => array(
						'type'     => 'color',
						'priority' => 30,
						'label'    => esc_html__( 'Border Color', 'zakra' ),
						'section'  => 'zakra_styling_base',
						'choices'  => array(
							'alpha' => true,
						),
					),
				),

			);

		}

	}

	new Zakra_Customize_Base_Colors_Option();

endif;
