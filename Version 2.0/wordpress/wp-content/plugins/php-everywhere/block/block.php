<?php

// Front
require_once dirname( __FILE__ ) . '/front/block.php';

function php_everywhere_register_block() {
    //if the settings are set to being admin only the Gutenberg block can not e used.
    if(get_option('php_everywhere_option_roles', "not_set") == 'admin')
	{
        return;
	}



    $dir = dirname( __FILE__ );

    if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}

    // Editor
    wp_register_script(
        'php-everywhere-editor-js',
        plugins_url( 'editor/js/block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'),
        filemtime( plugin_dir_path( __FILE__ ) . 'editor/js/block.js' )
    );
    wp_register_style(
        'php-everywhere-editor-css',
        plugins_url( 'editor/css/editor.css', __FILE__ ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'editor/css/editor.css' )

    );

    // Register block
    register_block_type( 'php-everywhere-block/php', array(
        'editor_script' => 'php-everywhere-editor-js',
        'render_callback' => 'php_everywhere_render_block',
        'editor_style'  => 'php-everywhere-editor-css'
    ) );

    if ( function_exists( 'wp_set_script_translations' ) ) {
        /**
         * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
         * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
         * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
         */
        wp_set_script_translations( 'php-everywhere-editor-js', 'php-everywhere' );
      }

}

//disable block or not
if(get_option('php_everywhere_option_options_block', "no") == "no")
{
	add_action( 'init', 'php_everywhere_register_block' );
}

