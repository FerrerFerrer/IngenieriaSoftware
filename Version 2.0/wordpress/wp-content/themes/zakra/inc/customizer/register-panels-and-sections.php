<?php
/**
 * Register customizer panels and sections.
 *
 * @package zakra
 */

/**
 * Section: Zakra Pro Upsell.
 */
if ( ! zakra_is_zakra_pro_active() ) :

    $wp_customize->add_section(
        new Zakra_Customize_Section(
            $wp_customize,
            'zakra_customize_upsell_section',
            array(
                'title'    => esc_html__( 'View Pro Version', 'zakra' ),
                'priority' => 5,
            )
        )
    );

endif;

/**
 * Panel: Theme options.
 */
$wp_customize->add_panel(
	new Zakra_Customize_Panel(
		$wp_customize,
		'zakra_theme_options',
		array(
			'priority'   => 10,
			'title'      => esc_html__( 'Theme Options', 'zakra' ),
			'capabitity' => 'edit_theme_options',
		)
	)
);

/*
 * Section: Header.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_header_group',
		array(
			'title'    => esc_html__( 'Header', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 10,
		)
	)
);

// Section: Header > Header Top Bar.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_header_top',
		array(
			'title'    => esc_html__( 'Header Top Bar', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_header_group',
			'priority' => 10,
		)
	)
);

// Section: Header > Header Main Area.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_header_main',
		array(
			'title'    => esc_html__( 'Header Main Area', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_header_group',
			'priority' => 20,
		)
	)
);

// Section: Header > Header Button.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_header_button',
		array(
			'title'    => esc_html__( 'Header Button', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_header_group',
			'priority' => 30,
		)
	)
);

/*
 * Section: Menu.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_menu_group',
		array(
			'title'    => esc_html__( 'Menu', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 20,
		)
	)
);

// Section: Menu > Primary Menu.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_primary_menu',
		array(
			'title'    => esc_html__( 'Primary Menu', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_menu_group',
			'priority' => 10,
		)
	)
);

// Section: Menu > Primary menu : Dropdown.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_primary_menu_item',
		array(
			'title'    => esc_html__( 'Primary Menu : Menu Item', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_menu_group',
			'priority' => 20,
		)
	)
);

/*
 * Section: General.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_general',
		array(
			'title'    => esc_html__( 'General', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 30,
		)
	)
);

/*
 * Section: Post/Page/Blog.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_blog',
		array(
			'title'    => esc_html__( 'Post/Page/Blog', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 40,
		)
	)
);

// Section: Blog > Single blog post.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_blog_general',
		array(
			'title'    => esc_html__( 'General', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_blog',
			'priority' => 10,
		)
	)
);

// Section: Blog > Blog/Archive.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_archive_blog',
		array(
			'title'    => esc_html__( 'Blog/Archive', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_blog',
			'priority' => 20,
		)
	)
);

// Section: Blog > Single Post.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_single_blog_post',
		array(
			'title'    => esc_html__( 'Single Post', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_blog',
			'priority' => 30,
		)
	)
);

// Section: Blog > Meta.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_meta',
		array(
			'title'    => esc_html__( 'Meta', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_blog',
			'priority' => 40,
		)
	)
);

/*
 * Section: Page Header.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_page_header_group',
		array(
			'title'    => esc_html__( 'Page Header', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 50,
		)
	)
);

// Section: Page header > Page title.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_page_title',
		array(
			'title'    => esc_html__( 'Page Title', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_page_header_group',
			'priority' => 10,
		)
	)
);

// Section: Page header > Breadcrumbs.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_breadcrumbs',
		array(
			'title'    => esc_html__( 'Breadcrumbs', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_page_header_group',
			'priority' => 20,
		)
	)
);

/*
 * Section: Layout.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_layout_group',
		array(
			'title'    => esc_html__( 'Layout', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 60,
		)
	)
);

// Section: Layout > General.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_layout_structure',
		array(
			'title'    => esc_html__( 'General', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_layout_group',
			'priority' => 10,
		)
	)
);

// Section: Layout > WooCommerce.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_layout_woocommerce_structure',
		array(
			'title'    => esc_html__( 'WooCommerce', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_layout_group',
			'priority' => 20,
		)
	)
);

/*
 * Section: Styling.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_styling_group',
		array(
			'title'    => esc_html__( 'Styling', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 70,
		)
	)
);

// Section: Styling > Base Colors.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_styling_base',
		array(
			'title'    => esc_html__( 'Base Colors', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_styling_group',
			'priority' => 10,
		)
	)
);

// Section: Styling > Background.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_styling_background',
		array(
			'title'    => esc_html__( 'Background', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_styling_group',
			'priority' => 20,
		)
	)
);

// Section: Styling > Link Colors.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_styling_link',
		array(
			'title'    => esc_html__( 'Link Colors', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_styling_group',
			'priority' => 30,
		)
	)
);

// Section: Styling > Button.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_styling_button',
		array(
			'title'    => esc_html__( 'Button', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_styling_group',
			'priority' => 40,
		)
	)
);

/**
 * Section: Typography.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_typography_group',
		array(
			'title'    => esc_html__( 'Typography', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 80,
		)
	)
);

// Section: Typography > Base typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_base_typography',
		array(
			'title'    => esc_html__( 'Base Typography', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 10,
		)
	)
);

// Section: Typography > Site Identity Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_site_identity_typography',
		array(
			'title'    => esc_html__( 'Site Identity', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 20,
		)
	)
);

// Section: Typography > Primary Menu Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_primary_menu_typography',
		array(
			'title'    => esc_html__( 'Primary Menu', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 30,
		)
	)
);

// Section: Typography > Mobile Menu Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_mobile_menu_typography',
		array(
			'title'    => esc_html__( 'Mobile Menu', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 40,
		)
	)
);

// Section: Typography > Post/Page/Blog Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_post_page_blog_typography',
		array(
			'title'    => esc_html__( 'Post/Page/Blog', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 45,
		)
	)
);

// Section: Typography > Page Title Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_page_title_typography',
		array(
			'title'    => esc_html__( 'Post/Page Title', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 50,
		)
	)
);

// Section: Typography > Blog/Archive Post Title Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_blog_post_title_typography',
		array(
			'title'    => esc_html__( 'Blog/Archive Post Title', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 60,
		)
	)
);

// Section: Typography > Headings ( h1 - h6 ) Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_headings_typography',
		array(
			'title'    => esc_html__( 'Headings ( H1 - H6 )', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 70,
		)
	)
);

// Section: Typography > Widgets Typography.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_widgets_typography',
		array(
			'title'    => esc_html__( 'Widgets', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_typography_group',
			'priority' => 80,
		)
	)
);

/*
 * Section: Footer.
 */
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_footer_group',
		array(
			'title'    => esc_html__( 'Footer', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'priority' => 90,
		)
	)
);

// Section: Footer > Footer widgets.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_footer_widgets',
		array(
			'title'    => esc_html__( 'Footer Widgets', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_footer_group',
			'priority' => 10,
		)
	)
);

// Section: Footer > Footer bar.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_footer_bottom_bar',
		array(
			'title'    => esc_html__( 'Footer Bottom Bar', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_footer_group',
			'priority' => 20,
		)
	)
);

// Section: Styling > Scroll to top.
$wp_customize->add_section(
	new Zakra_Customize_Section(
		$wp_customize,
		'zakra_footer_scroll_to_top',
		array(
			'title'    => esc_html__( 'Scroll to Top', 'zakra' ),
			'panel'    => 'zakra_theme_options',
			'section'  => 'zakra_footer_group',
			'priority' => 30,
		)
	)
);
