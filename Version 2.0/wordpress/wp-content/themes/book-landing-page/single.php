<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Book_Landing_Page
 */

get_header(); ?>


		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );
            /**
             * After post content
             * 
             * @hooked book_landing_page_post_author  - 10
             */
			do_action( 'book_landing_page_after_post_content');
			
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
get_sidebar();
get_footer();
