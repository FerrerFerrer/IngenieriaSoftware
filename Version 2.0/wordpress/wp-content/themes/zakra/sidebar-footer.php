<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zakra
 */

if ( ! is_active_sidebar( 'footer-sidebar-1' ) && ! is_active_sidebar( 'footer-sidebar-2' ) && ! is_active_sidebar( 'footer-sidebar-3' ) && ! is_active_sidebar( 'footer-sidebar-4' ) ) {
	return;
}

$zakra_footer_widgets_style = apply_filters( 'zakra_footer_widgets_style', get_theme_mod( 'zakra_footer_widgets_style', 'tg-footer-widget-col--four' ) );

$footer_sidebar_classes = apply_filters( 'zakra_footer_sidebar_filter', array(
	'tg-footer-widget-col--one'   => array(
		'footer-sidebar-1',
	),
	'tg-footer-widget-col--two'   => array(
		'footer-sidebar-1',
		'footer-sidebar-2',
	),
	'tg-footer-widget-col--three' => array(
		'footer-sidebar-1',
		'footer-sidebar-2',
		'footer-sidebar-3',
	),
	'tg-footer-widget-col--four'  => array(
		'footer-sidebar-1',
		'footer-sidebar-2',
		'footer-sidebar-3',
		'footer-sidebar-4',
	),
) );
?>

<div class="tg-footer-widget-container <?php zakra_footer_widget_container_class(); ?>">
	<?php
	foreach ( $footer_sidebar_classes as $footer_sidebar_key => $footer_sidebar_class ) {
		foreach ( $footer_sidebar_class as $footer_sidebar_display ) {

			if ( $footer_sidebar_key === $zakra_footer_widgets_style ) {
				?>
				<div class="tg-footer-widget-area <?php echo esc_attr( $footer_sidebar_display ); ?>">
					<?php if ( is_active_sidebar( $footer_sidebar_display ) ) : ?>
						<?php dynamic_sidebar( $footer_sidebar_display ); ?>
					<?php endif; ?>
				</div>
				<?php
			}
		}
	}
	?>
</div> <!-- /.tg-footer-widget-container -->
