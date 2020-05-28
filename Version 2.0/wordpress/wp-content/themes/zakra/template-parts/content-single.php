<?php
/**
 * Template part for displaying posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zakra
 */

$content_orders = get_theme_mod(
	'zakra_single_post_content_structure', array(
		'featured_image',
		'title',
		'meta',
		'content',
	)
);

$meta_orders = get_theme_mod(
	'zakra_single_blog_post_meta_structure', array(
		'comments',
		'categories',
		'author',
		'date',
		'tags',
	)
);

$meta_style = get_theme_mod( 'zakra_blog_archive_meta_style', 'tg-meta-style-one' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $meta_style ); ?>>
	<?php do_action( 'zakra_before_single_post' ); ?>

	<?php
	foreach ( $content_orders as $key => $content_order ) :
		if ( 'featured_image' === $content_order ) :
			zakra_post_thumbnail();

		elseif ( 'title' === $content_order ) :
			?>
			<header class="entry-header">
				<?php
				zakra_entry_title();
				?>

			</header><!-- .entry-header -->

		<?php elseif ( 'meta' === $content_order && 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				foreach ( $meta_orders as $key => $meta_order ) {
					if ( 'comments' === $meta_order ) {
						zakra_post_comments();
					} elseif ( 'categories' === $meta_order ) {
						zakra_posted_in();
					} elseif ( 'author' === $meta_order ) {
						zakra_posted_by();
					} elseif ( 'date' === $meta_order ) {
						zakra_posted_on();
					} elseif ( 'tags' === $meta_order ) {
						zakra_post_tags();
					}
				}
				?>
			</div><!-- .entry-meta -->

		<?php elseif ( 'content' === $content_order ) : ?>
			<div class="entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'zakra' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zakra' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->

		<?php
		endif;
	endforeach;
	?>

	<?php do_action( 'zakra_after_single_post' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->

