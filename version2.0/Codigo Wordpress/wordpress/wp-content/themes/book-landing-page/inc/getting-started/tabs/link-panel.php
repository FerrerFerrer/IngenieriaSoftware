<?php
/**
 * Right Buttons Panel.
 *
 * @package Book_Landing_Page
 */
?>
<div class="panel-right">
	<div class="panel-aside">
		<h4><?php esc_html_e( 'Upgrade To Pro', 'book-landing-page' ); ?></h4>
		<p><?php esc_html_e( 'The Pro version of the theme allows you to change the look and feel of the website with just a few clicks. You can easily change the color, background image and pattern as well as fonts of the website with the Pro version. Also, the Pro theme features more homepage sections than free version to allow you to showcase your organization services in a better way boosting the growth of the organization. Furthermore, the premium theme comes with multiple predefined page templates.', 'book-landing-page' ); ?></p>
		<p><?php esc_html_e( 'Also, the Pro version gets regular updates and has a dedicated support team to solve your queries.', 'book-landing-page' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( 'https://rarathemes.com/wordpress-themes/book-landing-page-pro/' ); ?>" title="<?php esc_attr_e( 'View Premium Version', 'book-landing-page' ); ?>" target="_blank">
            <?php esc_html_e( 'Read more about the features here', 'book-landing-page' ); ?>
        </a>
	</div><!-- .panel-aside Theme Support -->
	<!-- Knowledge base -->
	<div class="panel-aside">
		<h4><?php esc_html_e( 'Visit the Knowledge Base', 'book-landing-page' ); ?></h4>
		<p><?php esc_html_e( 'Need help with WordPress and our theme as quickly as possible? Visit our well-organized documentation.', 'book-landing-page' ); ?></p>
		<p><?php esc_html_e( 'Our documentation comes with a step-by-step guide from installing WordPress to customizing our theme to creating an attractive and engaging website.', 'book-landing-page' ); ?></p>

		<a class="button button-primary" href="<?php echo esc_url( 'https://docs.rarathemes.com/docs/' . BOOK_LANDING_PAGE_THEME_TEXTDOMAIN . '/' ); ?>" title="<?php esc_attr_e( 'Visit the knowledge base', 'book-landing-page' ); ?>" target="_blank"><?php esc_html_e( 'Visit the Knowledge Base', 'book-landing-page' ); ?></a>
	</div><!-- .panel-aside knowledge base -->
</div><!-- .panel-right -->