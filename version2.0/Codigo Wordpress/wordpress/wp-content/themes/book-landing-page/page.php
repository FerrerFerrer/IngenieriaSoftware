<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Book_Landing_Page
 */

$sidebar_layout = book_landing_page_sidebar_layout();

get_header(); ?>
		<header class="entry-header">
    		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				/**
                 * Book Landing Page Comment
                 * 
                 * @hooked book_landing_page_get_comment_section 
                */
                do_action( 'book_landing_page_comment' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if( $sidebar_layout == 'right-sidebar' )
get_sidebar();
get_footer();
