<?php
$post_content   = get_theme_mod( 'zakra_post_content_archive_blog', 'excerpt' );
$content_orders = get_theme_mod(
	'zakra_structure_archive_blog', array(
		'featured_image',
		'title',
		'meta',
		'content',
	)
);
$meta_orders    = get_theme_mod(
	'zakra_meta_structure_archive_blog', array(
		'author',
		'date',
		'categories',
		'tags',
		'comments',
	)
);

$readmore_alignment = get_theme_mod( 'zakra_read_more_align_archive_blog', 'left' );

foreach ( $content_orders as $key => $content_order ) :
	if ( 'featured_image' === $content_order ) :
		zakra_post_thumbnail();

	elseif ( 'title' === $content_order ) :
		?>
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
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

			do_action( 'zakra_entry_meta_end' );
			?>
		</div><!-- .entry-meta -->

	<?php elseif ( 'content' === $content_order ) : ?>
		<div class="entry-content">
			<?php
			if ( 'excerpt' === $post_content ) {
				the_excerpt();
			} elseif ( 'content' === $post_content ) {
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
			}

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'zakra' ),
					'after'  => '</div>',
				)
			);

			if ( 'excerpt' === $post_content && true === get_theme_mod( 'zakra_enable_read_more_archive_blog', true ) ) {
				do_action( 'zakra_post_readmore', $readmore_alignment );
			}
			?>
		</div><!-- .entry-content -->

	<?php
	endif;
endforeach;
