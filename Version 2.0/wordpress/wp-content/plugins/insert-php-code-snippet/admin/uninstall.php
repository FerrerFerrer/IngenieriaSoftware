<?php 
if ( ! defined( 'ABSPATH' ) ) 
	exit;

function xyz_ips_network_uninstall($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				xyz_ips_uninstall();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	xyz_ips_uninstall();
}

function xyz_ips_uninstall(){

global $wpdb;
delete_option("xyz_ips_sort_order");
delete_option("xyz_ips_sort_field_name");
delete_option("xyz_ips_limit");
delete_option("xyz_ips_installed_date");
delete_option('xyz_ips_credit_dismiss');
/* table delete*/
$wpdb->query("DROP TABLE ".$wpdb->prefix."xyz_ips_short_code");


}

register_uninstall_hook( XYZ_INSERT_PHP_PLUGIN_FILE, 'xyz_ips_network_uninstall' );
?>
