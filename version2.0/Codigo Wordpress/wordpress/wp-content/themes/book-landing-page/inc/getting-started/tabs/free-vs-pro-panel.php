<?php
/**
 * Free Vs Pro Panel.
 *
 * @package Book_Landing_Page
 */
?>
<!-- Free Vs Pro panel -->
<div id="free-pro-panel" class="panel-left">
	<div class="panel-aside">               		
		<img src="<?php echo esc_url( get_template_directory_uri() . '/inc/getting-started/images/free-vs-pro.jpg' ); //@todo change respective images.?>" alt="<?php esc_attr_e( 'Free vs Pro', 'book-landing-page' ); ?>"/>
		<a class="button button-primary" href="<?php echo esc_url( 'https://rarathemes.com/wordpress-themes/book-landing-page-pro/' ); ?>" title="<?php esc_attr_e( 'View Premium Version', 'book-landing-page' ); ?>" target="_blank">
            <?php esc_html_e( 'View Pro', 'book-landing-page' ); ?>
        </a>
	</div><!-- .panel-aside -->
</div>