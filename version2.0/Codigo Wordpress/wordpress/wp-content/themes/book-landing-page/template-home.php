<?php
/**
 * Template Name: Home Page
 *
 * @package Book_Landing_Page
 */
get_header(); 
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">	
		<?php 
		while ( have_posts() ) : the_post(); ?> 
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php 
					the_post_thumbnail(); 
					the_content(); ?>		
				</div>			    
			</article><!-- #post-## -->
		<?php endwhile; ?>
	</main><!-- #main -->
</div>
<?php
get_footer(); 
