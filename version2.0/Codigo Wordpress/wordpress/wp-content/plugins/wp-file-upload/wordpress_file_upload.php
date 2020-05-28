<?php
/*Plugin Name: Wordpress File Upload
/*
Plugin URI: https://www.iptanus.com/support/wordpress-file-upload
Description: Simple interface to upload files from a page.
Version: 4.14.2
Author: Nickolas Bossinas
Author URI: https://www.iptanus.com/nickolas
Text Domain: wp-file-upload
Domain Path: /languages

Wordpress File Upload (Wordpress Plugin)
Copyright (C) 2010-2020 Nickolas Bossinas
Contact me at https://www.iptanus.com/contact

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Extract the Request URI.
 *
 * In some web servers the request URL is not mentioned correctly and it must be
 * calculated in combination with other $_SERVER variables.
 *
 * @return string the correct request URI
 */
function wfu_get_request_uri() {
	$pathinfo         = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : ''; 
	list( $pathinfo ) = explode( '?', $pathinfo );
	$pathinfo         = str_replace( '%', '%25', $pathinfo );

	list( $req_uri ) = explode( '?', $_SERVER['REQUEST_URI'] );
	$home_path       = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
	$home_path_regex = sprintf( '|^%s|i', preg_quote( $home_path, '|' ) );

	$req_uri  = str_replace( $pathinfo, '', $req_uri );
	$req_uri  = trim( $req_uri, '/' );
	$req_uri  = preg_replace( $home_path_regex, '', $req_uri );
	$req_uri  = trim( $req_uri, '/' );
	
	return $req_uri;
}

/**
 * Checks before plugin loading.
 *
 * This function performs checks in order to decide if the plugin will be loaded
 * or not. It enables to load the plugin only for specific pages defined by the
 * admin.
 *
 * @return bool true if the plugin must be loaded, false if not.
 */
function wordpress_file_upload_preload_check() {
	//do not load plugin if this is the login page
	$uri = wfu_get_request_uri();
	if ( strpos($uri, 'wp-login.php') !== false ) return false;

	$load_plugin = true;
	if ( !is_admin() ) {
		$envars = get_option("wfu_environment_variables", array());
		$ids = ( isset($envars["WFU_RESTRICT_FRONTEND_LOADING"]) ? $envars["WFU_RESTRICT_FRONTEND_LOADING"] : "false" );
		//if restricted loading is enabled, then the plugin will load only if
		//the current page ID is included in $ids list
		if (  $ids !== "false" && trim($ids) != "" ) {
			$load_plugin = false;
			$types = array();
			$ids = explode(",", $ids);
			//check that list of ids is valid and also store their post types in
			//an array, so that later on we get the current page from path only
			//for these post types
			foreach ( $ids as $ind => $id ) {
				$id = (int)trim($id);
				$typ = get_post_type($id);
				if ( $typ !== false ) {
					$ids[$ind] = $id;
					//store the post type of the id
					if ( !in_array($typ, $types) ) array_push($types, $typ);
				}
				else unset($ids[$ind]);
			}
			if ( count($ids) > 0 ) {
				$page = get_page_by_path($uri, OBJECT, $types);
				if ( $page ) {
					foreach ( $ids as $id )
						if ( $id == $page->ID ) {
							$load_plugin = true;
							break;
						}
				}
			}
		}
	}
	return $load_plugin;
}

//before loading the plugin we need to check if restricted loading is enabled
if ( !wordpress_file_upload_preload_check() ) return;
//proceed loading the plugin
DEFINE("WPFILEUPLOAD_PLUGINFILE", __FILE__);
require_once( plugin_dir_path( WPFILEUPLOAD_PLUGINFILE ) . 'wfu_loader.php' );