<?php
/**
 * The template for displaying search results pages
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package zakra
 */

get_header();
?>

	<section id="primary" class="content-area">
		<?php echo apply_filters( 'zakra_after_primary_start_filter', false ); // WPCS: XSS OK. ?>

		<?php if ( have_posts() ) : ?>

			<?php if ( 'page-header' !== zakra_is_page_title_enabled() ) : ?>
				<header class="page-header">
					<h1 class="page-title tg-page-content__title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'zakra' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->
			<?php endif; ?>

			<?php
			do_action( 'zakra_before_posts_the_loop' );

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			do_action( 'zakra_after_posts_the_loop' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		<?php echo apply_filters( 'zakra_after_primary_end_filter', false ); // // WPCS: XSS OK. ?>
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
