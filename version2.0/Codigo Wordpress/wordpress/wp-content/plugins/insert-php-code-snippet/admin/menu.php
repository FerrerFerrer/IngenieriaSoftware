<?php
if ( ! defined( 'ABSPATH' ) )
	 exit;

if(isset($_GET['action']) && $_GET['action']=='snippet-status' ){
	ob_start();
}
	
if(isset($_GET['action']) && $_GET['action']=='snippet-add' ){
	ob_start();
}	

if(isset($_GET['action']) && $_GET['action']=='snippet-delete' ){
	ob_start();
}

if(isset($_GET['action']) && $_GET['action']=='snippet-edit' ){
		ob_start();
}

if(isset($_GET['page']) && $_GET['page']=='insert-php-code-snippet-suggest-features' ){
	ob_start();
}
add_action('admin_menu', 'xyz_ips_menu');

function xyz_ips_menu(){
	
	add_menu_page('insert-php-code-snippet', 'XYZ PHP Code', 'manage_options', 'insert-php-code-snippet-manage','xyz_ips_snippets',plugins_url('images/logo.png',XYZ_INSERT_PHP_PLUGIN_FILE));

	add_submenu_page('insert-php-code-snippet-manage', 'PHPCode Snippets', 'PHPCode Snippets', 'manage_options', 'insert-php-code-snippet-manage','xyz_ips_snippets');
	add_submenu_page('insert-php-code-snippet-manage', 'PHPCode Snippets - Manage settings', 'Settings', 'manage_options', 'insert-php-code-snippet-settings' ,'xyz_ips_settings');	
	add_submenu_page('insert-php-code-snippet-manage', 'PHPCode Snippets - About', 'About', 'manage_options', 'insert-php-code-snippet-about' ,'xyz_ips_about');
	add_submenu_page('insert-php-code-snippet-manage', 'PHPCode Snippets - Suggest Feature', 'Suggest a Feature', 'manage_options', 'insert-php-code-snippet-suggest-features' ,'xyz_ips_suggest_feature');
}

function xyz_ips_snippets(){
	$formflag = 0;
	if(isset($_GET['action']) && $_GET['action']=='snippet-delete' )
	{
		include(dirname( __FILE__ ) . '/snippet-delete.php');
		$formflag=1;
	}
	if(isset($_GET['action']) && $_GET['action']=='snippet-edit' )
	{
		require( dirname( __FILE__ ) . '/header.php' );
		include(dirname( __FILE__ ) . '/snippet-edit.php');
		require( dirname( __FILE__ ) . '/footer.php' );
		$formflag=1;
	}
	if(isset($_GET['action']) && $_GET['action']=='snippet-add' )
	{	
		require( dirname( __FILE__ ) . '/header.php' );
		require( dirname( __FILE__ ) . '/snippet-add.php' );
		require( dirname( __FILE__ ) . '/footer.php' );
		$formflag=1;
	}
	if(isset($_GET['action']) && $_GET['action']=='snippet-status' )
	{
		require( dirname( __FILE__ ) . '/snippet-status.php' );
		$formflag=1;
	}
	if($formflag == 0){
		require( dirname( __FILE__ ) . '/header.php' );
		require( dirname( __FILE__ ) . '/snippets.php' );
		require( dirname( __FILE__ ) . '/footer.php' );
	}
}

function xyz_ips_settings()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
	
}

function xyz_ips_about(){
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/about.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}
	
function xyz_ips_suggest_feature(){
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/suggest_feature.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function xyz_ips_add_style_script(){

	wp_enqueue_script('jquery');
	
	wp_register_script( 'xyz_notice_script', plugins_url ('js/notice.js' , XYZ_INSERT_PHP_PLUGIN_FILE ));
	wp_enqueue_script( 'xyz_notice_script' );
	
	// Register stylesheets
	wp_register_style('xyz_ips_style', plugins_url('css/xyz_ips_styles.css', XYZ_INSERT_PHP_PLUGIN_FILE));
	wp_enqueue_style('xyz_ips_style');
}
add_action('admin_enqueue_scripts', 'xyz_ips_add_style_script');

?>