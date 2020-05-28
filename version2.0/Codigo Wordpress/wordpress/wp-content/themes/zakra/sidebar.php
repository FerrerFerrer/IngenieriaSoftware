<?php
/**
 * The sidebar containing the main widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zakra
 */

// Hide sidebar when sidebar is not present.
if ( in_array( zakra_get_current_layout(), array( 'tg-site-layout--no-sidebar', 'tg-site-layout--default', 'tg-site-layout--stretched' ), true ) ) {
	return;
}

// Get site layout from customizer and page setting.
$current_sidebar = zakra_get_current_layout();

// Get which sidebar content to show in Sidebar.
$sidebar_meta = get_post_meta( zakra_get_post_id(), 'zakra_sidebar', true );

$sidebar = '';

if ( $sidebar_meta ) {
	$sidebar = $sidebar_meta;
} else {
	if ( 'tg-site-layout--left' === $current_sidebar ) {
		$sidebar = 'sidebar-left';
	} else {
	    $sidebar = 'sidebar-right';
    }
}

if ( ! is_active_sidebar( $sidebar ) ) {
	return;
}
?>

<aside id="secondary" class="tg-site-sidebar widget-area <?php zakra_sidebar_class(); ?>">
	<?php
	if ( ! empty( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	}
	?>
</aside><!-- #secondary -->
