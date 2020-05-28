<?php
/**
 * Typography.
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== TYPOGRAPHY ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Typography_Option' ) ) :

	/**
	 * Typography option.
	 */
	class Zakra_Customize_Typography_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 * @return array
		 */
		public function elements() {

			return array(

				/* ============================== Base Typography ============================== */
				/**
				 * Typography > Base Typography > Body.
				 */
				'zakra_base_typography_body'        => array(
					'output'  => array(
						array(
							'selector' => 'body',
						),
					),
					'setting' => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '15px',
							'line-height' => '1.8',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 10,
						'label'    => esc_html__( 'Body', 'zakra' ),
						'section'  => 'zakra_base_typography',
					),
				),

				/**
				 * Typography > Base Typography > Heading.
				 */
				'zakra_base_typography_heading'     => array(
					'output'  => array(
						array(
							'selector' => 'h1, h2, h3, h4, h5, h6',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_base_typography_heading_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 20,
						'label'    => esc_html__( 'Heading', 'zakra' ),
						'section'  => 'zakra_base_typography',
					),
				),

				/* ============================== Site Identity ============================== */
				/**
				 * Typography > Site Identity > Site Title.
				 */
				'zakra_typography_site_title'       => array(
					'output'  => array(
						array(
							'selector' => '.site-branding .site-title',
						),
					),
					'setting' => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '1.313rem',
							'line-height' => '1.5',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 10,
						'label'    => esc_html__( 'Site Title', 'zakra' ),
						'section'  => 'zakra_site_identity_typography',
					),
				),

				/**
				 * Typography > Site Identity > Tagline.
				 */
				'zakra_typography_site_description' => array(
					'output'  => array(
						array(
							'selector' => '.site-branding .site-description',
						),
					),
					'setting' => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '1rem',
							'line-height' => '1.8',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 20,
						'label'    => esc_html__( 'Tagline', 'zakra' ),
						'section'  => 'zakra_site_identity_typography',
					),
				),

				/* ============================== Primary Menu ============================== */
				/**
				 * Typography > Primary Menu.
				 */
				'zakra_typography_primary_menu'     => array(
					'output'     => array(
						array(
							'selector' => '.tg-primary-menu > div ul li a',
						),
					),
					'setting'    => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '1rem',
							'line-height' => '1.8',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					), 'control' => array(
						'type'     => 'typography',
						'label'    => esc_html__( 'Primary Menu', 'zakra' ),
						'priority' => 10,
						'section'  => 'zakra_primary_menu_typography',
					),
				),

				/**
				 *  Typography > Primary Menu > Dropdown.
				 */
				'zakra_typography_primary_menu_dropdown'     => array(
					'output'     => array(
						array(
							'selector' => '.tg-primary-menu > div ul li ul li a',
						),
					),
					'setting'    => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '1rem',
							'line-height' => '1.8',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					), 'control' => array(
						'type'     => 'typography',
						'priority' => 20,
						'label'    => esc_html__( 'Dropdown', 'zakra' ),
						'section'  => 'zakra_primary_menu_typography',
					),
				),

				/* ============================== Mobile Menu ============================== */
				/**
				 * Typography > Mobile Menu.
				 */
				'zakra_typography_mobile_menu'     => array(
					'output'     => array(
						array(
							'selector' => '.tg-mobile-navigation a',
						),
					),
					'setting'    => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '1rem',
							'line-height' => '1.8',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					), 'control' => array(
						'type'     => 'typography',
						'priority' => 10,
						'label'    => esc_html__( 'Mobile Menu', 'zakra' ),
						'section'  => 'zakra_mobile_menu_typography',
					),
				),

				/* ============================== Post/Page/Blog ============================== */
				/**
				 * Typography > Post/Page Title.
				 */
				'zakra_typography_post_page_title'     => array(
					'output'     => array(
						array(
							'selector' => '.tg-page-header .tg-page-header__title, .tg-page-content__title',
						),
					),
					'setting'    => array(
						'default'           => apply_filters( 'zakra_typography_post_page_title_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '18px',
							'line-height' => '1.3',
							'color'       => '#16181a',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 10,
						'label'    => esc_html__( 'Post/Page Title', 'zakra' ),
						'section'  => 'zakra_post_page_blog_typography',
					),
				),

				/**
				 * Typography > Blog/Archive Post Title.
				 */
				'zakra_typography_blog_post_title'     => array(
					'output'     => array(
						array(
							'selector' => '.entry-title:not(.tg-page-content__title)',
						),
					),
					'setting'    => array(
						'default'           => array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '2.25rem',
							'line-height' => '1.3',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 10,
						'label'    => esc_html__( 'Blog/Archive Post Title', 'zakra' ),
						'section'  => 'zakra_post_page_blog_typography',
					),
				),

				/* ============================== Headings( h1 - h6 ) ============================== */
				/**
				 * Typography > Headings( h1 - h6 ) > Heading 1.
				 */
				'zakra_typography_h1'               => array(
					'output'  => array(
						array(
							'selector' => 'h1',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_h1_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '2.5rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 60,
						'label'    => esc_html__( 'Heading 1', 'zakra' ),
						'section'  => 'zakra_headings_typography',
					),
				),

				/**
				 * Typography > Headings( h1 - h6 ) > Heading 2.
				 */
				'zakra_typography_h2'               => array(
					'output'  => array(
						array(
							'selector' => 'h2',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_h2_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '2.25rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 70,
						'label'    => esc_html__( 'Heading 2', 'zakra' ),
						'section'  => 'zakra_headings_typography',
					),
				),

				/**
				 * Typography > Headings( h1 - h6 ) > Heading 3.
				 */
				'zakra_typography_h3'               => array(
					'output'  => array(
						array(
							'selector' => 'h3',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_h3_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '2.25rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 80,
						'label'    => esc_html__( 'Heading 3', 'zakra' ),
						'section'  => 'zakra_headings_typography',
					),
				),

				/**
				 *  Typography > Headings( h1 - h6 ) > Heading 4.
				 */
				'zakra_typography_h4'               => array(
					'output'  => array(
						array(
							'selector' => 'h4',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_h4_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '1.75rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 90,
						'label'    => esc_html__( 'Heading 4', 'zakra' ),
						'section'  => 'zakra_headings_typography',
					),
				),

				/**
				 *  Typography > Headings( h1 - h6 ) > Heading 5.
				 */
				'zakra_typography_h5'               => array(
					'output'  => array(
						array(
							'selector' => 'h5',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_h5_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '1.313rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 100,
						'label'    => esc_html__( 'Heading 5', 'zakra' ),
						'section'  => 'zakra_headings_typography',
					),
				),

				/**
				 * Typography > Headings( h1 - h6 ) > Heading 6.
				 */
				'zakra_typography_h6'               => array(
					'output'  => array(
						array(
							'selector' => 'h6',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_h1_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '1.125rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 110,
						'label'    => esc_html__( 'Heading 6', 'zakra' ),
						'section'  => 'zakra_headings_typography',
					),
				),

				/* ============================== Widgets ============================== */
				/**
				 * Typography > Widgets > Title.
				 */
				'zakra_typography_widget_heading'   => array(
					'output'  => array(
						array(
							'selector' => '.widget .widget-title',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_widget_heading_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '500',
							'font-size'   => '1.2rem',
							'line-height' => '1.3',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 10,
						'label'    => esc_html__( 'Title', 'zakra' ),
						'section'  => 'zakra_widgets_typography',
					),
				),

				/**
				 * Typography > Widgets > Content.
				 */
				'zakra_typography_widget_content'   => array(
					'output'  => array(
						array(
							'selector' => '.widget',
						),
					),
					'setting' => array(
						'default'           => apply_filters( 'zakra_typography_widget_content_filter', array(
							'font-family' => '-apple-system, blinkmacsystemfont, segoe ui, roboto, oxygen-sans, ubuntu, cantarell, helvetica neue, helvetica, arial, sans-serif',
							'variant'     => '400',
							'font-size'   => '15px',
							'line-height' => '1.8',
						) ),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_typography' ),
					),
					'control' => array(
						'type'     => 'typography',
						'priority' => 20,
						'label'    => esc_html__( 'Content', 'zakra' ),
						'section'  => 'zakra_widgets_typography',
					),
				),

			);

		}

	}

	new Zakra_Customize_Typography_Option();

endif;
