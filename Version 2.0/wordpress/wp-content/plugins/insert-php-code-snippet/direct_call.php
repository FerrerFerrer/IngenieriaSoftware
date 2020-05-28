<?php
if ( ! defined( 'ABSPATH' ) )
	 exit;
	 
function xyz_ips_plugin_query_vars($vars) {
	$vars[] = 'wp_ips';
	return $vars;
}
add_filter('query_vars', 'xyz_ips_plugin_query_vars');


function xyz_ips_plugin_parse_request($wp) {
	/*confirmation*/
	if (array_key_exists('wp_ips', $wp->query_vars) && $wp->query_vars['wp_ips'] == 'editor_plugin_js') {
		require( dirname( __FILE__ ) . '/editor_plugin.js.php' );
		die;
	}
	
}
add_action('parse_request', 'xyz_ips_plugin_parse_request');
