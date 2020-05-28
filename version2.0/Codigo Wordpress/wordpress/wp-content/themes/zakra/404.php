<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package zakra
 */

get_header();
?>

	<div id="primary" class="content-area">
		<?php echo apply_filters( 'zakra_after_primary_start_filter', false ); // WPCS: XSS OK. ?>

		<section class="error-404 not-found">
			<?php if ( 'page-header' !== zakra_is_page_title_enabled() ) : ?>
				<header class="page-header">
					<?php zakra_entry_title(); ?>
				</header><!-- .page-header -->
			<?php endif; ?>

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'zakra' ); ?></p>

				<?php
				get_search_form();
				?>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

		<?php echo apply_filters( 'zakra_after_primary_end_filter', false ); // WPCS: XSS OK. ?>
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
