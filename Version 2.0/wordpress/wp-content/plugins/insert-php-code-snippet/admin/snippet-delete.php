<?php
if ( ! defined( 'ABSPATH' ) ) 
    exit;

global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_ips_snippetId = intval($_GET['snippetId']);
$xyz_ips_pageno = intval($_GET['pageno']);

if(! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'ips-pdel_'.$xyz_ips_snippetId )) {
    wp_nonce_ays( 'ips-pdel_'.$xyz_ips_snippetId );
    exit;
} 
else{
    if($xyz_ips_snippetId=="" || !is_numeric($xyz_ips_snippetId)){
        header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage'));
        exit();
    }

    $snippetCount = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'xyz_ips_short_code WHERE id=%d LIMIT 0,1',$xyz_ips_snippetId )) ;

    if($snippetCount==0){
        header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=2'));
        exit();
    }
    else{
        $wpdb->query($wpdb->prepare( 'DELETE FROM  '.$wpdb->prefix.'xyz_ips_short_code  WHERE id=%d',$xyz_ips_snippetId)) ;
        header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=3&pagenum='.$xyz_ips_pageno));
        exit();
    }
}
?>