<?php
/**
 * Zakra content area functions to be hooked.
 *
 * @package zakra
 */

if ( ! function_exists( 'zakra_posts_navigation' ) ) :
	/**
	 * Archive navigation.
	 */
	function zakra_posts_navigation() {
		the_posts_navigation();
	}
endif;

if ( ! function_exists( 'zakra_post_navigation' ) ) :
	/**
	 * Archive navigation.
	 */
	function zakra_post_navigation() {
		the_post_navigation();
	}
endif;

if ( ! function_exists( 'zakra_entry_content' ) ) :
	/**
	 * Archive navigation.
	 */
	function zakra_entry_content() {
		get_template_part( 'template-parts/blog/blog', 'post-layout' );
	}
endif;

if ( ! function_exists( 'zakra_post_readmore' ) ) :
	/**
	 * Post read more HTML.
	 *
	 * @param string $readmore_alignment CSS class.
	 */
	function zakra_post_readmore( $readmore_alignment ) {
		?>
		<div class="<?php zakra_css_class( 'zakra_read_more_wrapper_class' ); ?> tg-text-align--<?php echo esc_attr(
			$readmore_alignment ); ?>">
			<a href="<?php the_permalink(); ?>" class="tg-read-more">
				<?php echo apply_filters( 'zakra_read_more_text', esc_html__( 'Read More', 'zakra' ) ); // WPCS: XSS OK. ?></a>
		</div>
		<?php
	}
endif;
