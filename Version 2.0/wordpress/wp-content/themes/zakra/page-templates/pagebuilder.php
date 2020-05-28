<?php
/**
 *
 * Template Name: Page Builder
 *
 * The template for displaying content from page builder.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zakra
 */

get_header();
?>

	<div id="primary" class="content-area pagebuilder-content">

		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile; // End of the loop.
		?>

	</div><!-- #primary -->

<?php
get_footer();
