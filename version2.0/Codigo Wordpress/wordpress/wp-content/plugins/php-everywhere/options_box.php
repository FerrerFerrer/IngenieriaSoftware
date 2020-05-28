<?php


function php_everywhere_options_box()
{
    if (get_option('php_everywhere_option_roles') == 'admin') {
        //get user
        $user = wp_get_current_user();
        //check user role
        if ($user->roles[0] == 'administrator') {
            add_meta_box(
                'php_everywhere_options_id', // this is HTML id of the box on edit screen
                'PHP Everywhere', // title of the box
                'php_everywhere_options_box_content', // function to be called to display the checkboxes, see the function below
                '', // on which edit screen the box should appear
                'side', // part of page where the box should appear
                'default' // priority of the box
            );
        }
    } else {
        add_meta_box(
            'php_everywhere_options_id', // this is HTML id of the box on edit screen
            'PHP Everywhere', // title of the box
            'php_everywhere_options_box_content', // function to be called to display the checkboxes, see the function below
            '', // on which edit screen the box should appear
            'side', // part of page where the box should appear
            'default' // priority of the box
        );
    }

}


function php_everywhere_options_box_content( $post_id ) {
	load_plugin_textdomain('php-everywhere', false, plugin_dir_path( __FILE__ )  . 'languages/' );
    // nonce field for security check, you can have the same
    // nonce field for all your meta boxes of same plugin
    wp_nonce_field( plugin_basename( __FILE__ ), 'php_everywhere' );
	$text = get_post_meta( get_the_ID(),'php_everywhere_code',true);
	$text = htmlspecialchars($text);
	if($text == '')
	{
		$text = __('Just put [php_everywhere] where you want the code to be executed.', 'php-everywhere');
	}
    echo '<div style="width:100%;"><textarea name="php_everywhere_code" rows="7" style="width:100%">'.$text.'</textarea></div>';
    
}

//disable options box
if(get_option('php_everywhere_option_options_box', "no") == "no")
{
	// save data from checkboxes
	add_action( 'save_post', 'php_everywhere_data' );
	// register the meta box
	add_action('add_meta_boxes', 'php_everywhere_options_box');
}
function php_everywhere_data() {
	

    // check if this isn't an auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
		
	if (!isset($_POST['php_everywhere']) ) {
		$_POST['php_everywhere'] = false;
	}
	

    // further checks if you like, 
    // for example particular user, role or maybe post type in case of custom post types
	$post_id = get_the_ID();
	
	//check if the user is administrator and the meta box is displayed
	//if a user doesn't have priviledges we wan't to remove the php
	if(get_option('php_everywhere_option_roles', "not_set") == 'admin')
	{
		
		//get user
		$user = wp_get_current_user();
		//check user role
		if($user->roles[0] !== 'administrator') {
			// now store data in custom fields based on checkboxes selected
			update_post_meta( $post_id, 'php_everywhere_code', "" );
		}
		else
		{
			// security check
			if ( !wp_verify_nonce( $_POST['php_everywhere'], plugin_basename( __FILE__ ) ) )
				return;
			// now store data in custom fields based on checkboxes selected
			update_post_meta( $post_id, 'php_everywhere_code', htmlspecialchars_decode($_POST['php_everywhere_code']) );
		}
	}
	else
	{
		// security check
		if ( !wp_verify_nonce( $_POST['php_everywhere'], plugin_basename( __FILE__ ) ) )
        	return;
		// now store data in custom fields based on checkboxes selected
		update_post_meta( $post_id, 'php_everywhere_code', htmlspecialchars_decode($_POST['php_everywhere_code']) );
	}
	
    
}

//more security features to disable php code being added in post metas
add_action( 'added_post_meta', 'php_everywhere_after_post_meta', 10, 4);
add_action( 'updated_postmeta', 'php_everywhere_after_post_meta', 10, 4);
function php_everywhere_after_post_meta( $meta_id, $post_id, $meta_key, $meta_value )
{
	if ( 'php_everywhere_code' == $meta_key ) {
		//check if the user is administrator and the meta box is displayed
		//if a user doesn't have priviledges we wan't to remove the php
		if(get_option('php_everywhere_option_roles', "not_set") == 'admin')
		{
			
			//get user
			$user = wp_get_current_user();
			//check user role
			if($user->roles[0] !== 'administrator') {
				// now store data in custom fields based on checkboxes selected
				update_post_meta( $post_id, 'php_everywhere_code', "" );
			}
		}
	}
}
?>