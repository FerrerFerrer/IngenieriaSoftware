<?php
/**
 * Single blog post layout.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== LAYOUT > SINGLE BLOG POST ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Single_Blog_Post_Option' ) ) :

	/**
	 * Single Blog Post option.
	 */
	class Zakra_Customize_Single_Blog_Post_Option extends Zakra_Customize_Base_Option {

		/**
		 * Arguments for options.
		 *
		 * @return array
		 */
		public function elements() {

			return array(

				/**
				 * Post/Page/Blog > Single Post > Single Post Content Order.
				 */
				'zakra_single_post_content_structure'   => array(
					'setting' => array(
						'default'           => array(
							'featured_image',
							'title',
							'meta',
							'content',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_sortable' ),
					),
					'control' => array(
						'type'        => 'sortable',
						'priority'    => 10,
						'label'       => esc_html__( 'Single Post Content Order', 'zakra' ),
						'description' => esc_html__( 'Drag & Drop items to re-arrange the order', 'zakra' ),
						'section'     => 'zakra_single_blog_post',
						'choices'     => array(
							'featured_image' => esc_attr__( 'Featured Image', 'zakra' ),
							'title'          => esc_attr__( 'Title', 'zakra' ),
							'meta'           => esc_attr__( 'Meta Tags', 'zakra' ),
							'content'        => esc_attr__( 'Content', 'zakra' ),
						),
					),
				),

				/**
				 * Post/Page/Blog > Single Post > Meta Tags Order.
				 */
				'zakra_single_blog_post_meta_structure' => array(
					'setting' => array(
						'default'           => array(
							'author',
							'date',
							'categories',
							'tags',
							'comments',
						),
						'sanitize_callback' => array( 'Zakra_Customizer_Sanitize', 'sanitize_sortable' ),
					),
					'control' => array(
						'type'        => 'sortable',
						'priority'    => 20,
						'label'       => esc_html__( 'Meta Tags Order', 'zakra' ),
						'description' => esc_html__( 'Drag & Drop items to re-arrange the order', 'zakra' ),
						'section'     => 'zakra_single_blog_post',
						'choices'     => array(
							'comments'   => esc_attr__( 'Comments', 'zakra' ),
							'categories' => esc_attr__( 'Categories', 'zakra' ),
							'author'     => esc_attr__( 'Author', 'zakra' ),
							'date'       => esc_attr__( 'Date', 'zakra' ),
							'tags'       => esc_attr__( 'Tags', 'zakra' ),
						),
					),
				),

			);

		}

	}

	new Zakra_Customize_Single_Blog_Post_Option();

endif;
