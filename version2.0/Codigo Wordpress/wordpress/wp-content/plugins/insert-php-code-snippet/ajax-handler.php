<?php
if ( ! defined( 'ABSPATH' ) )
    exit;

add_action('wp_ajax_ips_backlink', 'xyz_ips_ajax_backlink');
function xyz_ips_ajax_backlink() {

	check_ajax_referer('xyz-ips-blink','security');
    if(current_user_can('administrator')){
        global $wpdb;
        if(isset($_POST)){
            if(intval($_POST['enable'])==1){
                update_option('xyz_credit_link','ips');
                echo 1;
            }
            if(intval($_POST['enable'])==-1){
                update_option('xyz_ips_credit_dismiss','dis');
                echo -1;
            }
        }
    }die;
}

?>