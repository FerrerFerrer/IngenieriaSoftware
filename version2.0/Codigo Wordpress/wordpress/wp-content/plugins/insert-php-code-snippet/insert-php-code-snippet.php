<?php 
/*
Plugin Name: Insert PHP Code Snippet
Plugin URI: http://xyzscripts.com/wordpress-plugins/insert-php-code-snippet/
Description: Insert and run PHP code in your pages and posts easily using shortcodes. This plugin lets you create a shortcode corresponding to any random PHP code  and use the same in your posts, pages or widgets.        
Version: 1.3.1
Author: xyzscripts.com
Author URI: http://xyzscripts.com/
Text Domain: insert-php-code-snippet
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// if ( !function_exists( 'add_action' ) ) {
// 	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
// 	exit;
// }
if ( ! defined( 'ABSPATH' ) )
	 exit;

//error_reporting(E_ALL);

define('XYZ_INSERT_PHP_PLUGIN_FILE',__FILE__);

require( dirname( __FILE__ ) . '/xyz-functions.php' );

require( dirname( __FILE__ ) . '/add_shortcode_tynimce.php' );

require( dirname( __FILE__ ) . '/admin/install.php' );

require( dirname( __FILE__ ) . '/admin/menu.php' );

require( dirname( __FILE__ ) . '/shortcode-handler.php' );

require( dirname( __FILE__ ) . '/ajax-handler.php' );

require( dirname( __FILE__ ) . '/admin/uninstall.php' );

require( dirname( __FILE__ ) . '/widget.php' );

require( dirname( __FILE__ ) . '/direct_call.php' );

require_once( dirname( __FILE__ ) . '/admin/admin-notices.php' );

if(get_option('xyz_credit_link')=="ips"){

	add_action('wp_footer', 'xyz_ips_credit');

}
function xyz_ips_credit() {	
	$content = '<div style="width:100%;text-align:center; font-size:11px; clear:both"><a target="_blank" title="Insert PHP Snippet Wordpress Plugin" href="http://xyzscripts.com/wordpress-plugins/insert-php-code-snippet/">PHP Code Snippets</a> Powered By : <a target="_blank" title="PHP Scripts & Wordpress Plugins" href="http://www.xyzscripts.com" >XYZScripts.com</a></div>';
	echo $content;
}


?>
