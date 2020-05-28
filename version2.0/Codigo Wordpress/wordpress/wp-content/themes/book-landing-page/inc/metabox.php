<?php
/**
 * Book Landing Page Metabox
 * 
 * @package Book_Landing_Page
 */

add_action( 'add_meta_boxes', 'book_landing_page_add_sidebar_layout_box' );

function book_landing_page_add_sidebar_layout_box(){
    add_meta_box( 
        'book_landing_page_sidebar_layout',
        __( 'Sidebar Layout', 'book-landing-page' ),
        'book_landing_page_sidebar_layout_callback', 
        'page',
        'normal',
        'high'
    );
}

$book_landing_page_sidebar_layout = array(
    'right-sidebar' => array(
         'value'=> 'right-sidebar',
         'label'=> __( 'Right Sidebar(default)', 'book-landing-page'),
         'thumbnail'=> get_template_directory_uri() . '/images/right-sidebar.png'         
     ),
    'no-sidebar' => array(
         'value' => 'no-sidebar',
         'label' => __('No Sidebar','book-landing-page'),
         'thumbnail'=> get_template_directory_uri() . '/images/no-sidebar.png'
    )
);

function book_landing_page_sidebar_layout_callback(){
    global $post, $book_landing_page_sidebar_layout;
    wp_nonce_field( basename( __FILE__ ), 'book_landing_page_nonce' );
?>
 
<table class="form-table">
    <tr>
        <td colspan="4"><em class="f13"><?php esc_html_e( 'Choose Sidebar Template', 'book-landing-page' ); ?></em></td>
    </tr>
    <tr>
        <td>
        <?php  
            foreach( $book_landing_page_sidebar_layout as $field ){  
                $layout = get_post_meta( $post->ID, 'book_landing_page_sidebar_layout', true ); ?>

            <div class="radio-image-wrapper" style="float:left; margin-right:30px;">
                <label class="description">
                    <span><img src="<?php echo esc_url( $field['thumbnail'] ); ?>" alt="<?php echo esc_attr( $field['label'] ); ?>" /></span><br/>
                    <input type="radio" name="book_landing_page_sidebar_layout" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( $field['value'], $layout ); if( empty( $layout ) && $field['value']=='right-sidebar'){ checked( $field['value'], 'right-sidebar' ); }?>/>&nbsp;<?php echo esc_html( $field['label'] ); ?>
                </label>
            </div>
            <?php } // end foreach 
            ?>
            <div class="clear"></div>
        </td>
    </tr>
</table> 
<?php 
}

/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function book_landing_page_save_sidebar_layout( $post_id ){
    global $book_landing_page_sidebar_layout;

    // Verify the nonce before proceeding.
    if( !isset( $_POST[ 'book_landing_page_nonce' ] ) || !wp_verify_nonce( $_POST[ 'book_landing_page_nonce' ], basename( __FILE__ ) ) )
        return;
    
    // Stop WP from clearing custom fields on autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;

    if( 'page' == $_POST['post_type'] ){  
        if( ! current_user_can( 'edit_page', $post_id ) ) return $post_id;  
    }elseif( ! current_user_can( 'edit_post', $post_id ) ){  
        return $post_id;  
    }

    $layout = isset( $_POST['book_landing_page_sidebar_layout'] ) ? sanitize_key( $_POST['book_landing_page_sidebar_layout'] ) : 'right-sidebar';

    if( array_key_exists( $layout, $book_landing_page_sidebar_layout ) ){
        update_post_meta( $post_id, 'book_landing_page_sidebar_layout', $layout );
    }else{
        delete_post_meta( $post_id, 'book_landing_page_sidebar_layout' );
    }  
}
add_action('save_post', 'book_landing_page_save_sidebar_layout');