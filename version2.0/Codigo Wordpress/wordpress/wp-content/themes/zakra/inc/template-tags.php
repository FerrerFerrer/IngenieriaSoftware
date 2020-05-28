<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package zakra
 */

if ( ! function_exists( 'zakra_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function zakra_posted_on() {

		$meta_style = get_theme_mod( 'zakra_blog_archive_meta_style', 'tg-meta-style-one' );

		/* translators: %s: post date. */
		$date_text = ( 'tg-meta-style-one' === $meta_style ) ? esc_html_x( 'Posted on %s', 'post date', 'zakra' ) : '%s';

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			$date_text,
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'zakra_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function zakra_posted_by() {

		$meta_style = get_theme_mod( 'zakra_blog_archive_meta_style', 'tg-meta-style-one' );

		/* translators: %s: post author. */
		$author_text = ( 'tg-meta-style-one' === $meta_style ) ? esc_html_x( 'By %s', 'post author', 'zakra' ) : '%s';

		$byline = sprintf(
			$author_text,
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);


		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'zakra_posted_in' ) ) :
	/**
	 * Prints HTML with meta information of post categories.
	 */
	function zakra_posted_in() {

		$meta_style = get_theme_mod( 'zakra_blog_archive_meta_style', 'tg-meta-style-one' );

		/* translators: 1: list of categories. */
		$catgories_text = ( 'tg-meta-style-one' === $meta_style ) ? esc_html__( 'Posted in %1$s', 'zakra' ) : '%1$s';

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'zakra' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . $catgories_text . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}

	}
endif;


if ( ! function_exists( 'zakra_post_comments' ) ) :
	/**
	 * Prints HTML with comments on current post.
	 */
	function zakra_post_comments() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'No Comments<span class="screen-reader-text"> on %s</span>', 'zakra' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

	}
endif;

if ( ! function_exists( 'zakra_post_tags' ) ) :
	/**
	 * Prints HTML with tags of current post.
	 */
	function zakra_post_tags() {

		$meta_style = get_theme_mod( 'zakra_blog_archive_meta_style', 'tg-meta-style-one' );

		/* translators: 1: list of tags. */
		$tags_text = ( 'tg-meta-style-one' === $meta_style ) ? esc_html__( 'Tagged %1$s', 'zakra' ) : '%1$s';

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'zakra' ) );

			if ( $tags_list ) {
				printf( '<span class="tags-links">' . $tags_text . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

	}
endif;

if ( ! function_exists( 'zakra_post_thumbnail' ) ) :

	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function zakra_post_thumbnail( $image_size = 'post-thumbnail' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php
				the_post_thumbnail(
					$image_size,
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

/**
 * Determine whether this is an AMP response.
 *
 * @return bool Is AMP endpoint and is AMP plugin active.
 */
function zakra_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Store the post ids.
 *
 * Since blog page takes the first post as its id,
 * here we are storing the id of the post and for the blog page,
 * storing its value via getting the specific page id through:
 * `get_option( 'page_for_posts' )`
 *
 * @return false|int|mixed|string|void
 */
function zakra_get_post_id() {

	$post_id        = '';
	$page_for_posts = get_option( 'page_for_posts' );

	// For single post and pages.
	if ( is_singular() ) {
		$post_id = get_the_ID();
	}

	// For the static blog page.
	elseif ( ! is_front_page() && is_home() && $page_for_posts ) {
		$post_id = $page_for_posts;
	}

	// Return the post ID.
	return $post_id;

}
