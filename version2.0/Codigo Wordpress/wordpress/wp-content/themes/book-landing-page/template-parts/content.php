<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Book_Landing_Page
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/Blog">
	<?php 
    /**
     * Before Page entry content
     * 
     * @hooked book_landing_page_post_content_image - 10
     * @hooked book_landing_page_post_entry_header  - 20 
    */
    do_action( 'book_landing_page_before_post_entry_content' );    
    ?>

  	<?php if( is_single() ) { ?>
    	<footer class="entry-footer">
			<div class="entry-meta">
				<?php book_landing_page_entry_footer(); ?>
			</div><!-- .entry-meta -->
		</footer><!-- .entry-footer -->
	<?php } ?>

	<div class="entry-content">
		<?php
		if( is_single() ){
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Read More', 'book-landing-page' ), array( 'span' => array( 'class' => '' ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		 }else{ 
		 	if( false === get_post_format() ){
                    the_excerpt();
                }else{
                    the_content( sprintf(
        				/* translators: %s: Name of current post. */
        				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'book-landing-page' ), array( 'span' => array( 'class' => array() ) ) ),
        				the_title( '<span class="screen-reader-text">"', '"</span>', false )
        			) );
                }
            }
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'book-landing-page' ),
				'after'  => '</div>',
			) );
		?>

	<?php if( !is_single() ){ ?>
		<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read More', 'book-landing-page' ); ?></a>
    <?php }?>
	</div><!-- .entry-content -->
	<?php if( !is_single() ){ ?>
		<footer class="entry-footer">
			<div class="entry-meta">
				<?php book_landing_page_entry_footer(); ?>
			</div><!-- .entry-meta -->
		</footer><!-- .entry-footer -->
    <?php }?>

</article><!-- #post-## -->
