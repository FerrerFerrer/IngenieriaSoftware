<?php 
if ( ! defined( 'ABSPATH' ) )
	 exit;
	 
header( 'Content-Type: text/javascript' );	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
/*if(!isset($shortcodesXYZEP))
	$shortcodesXYZEP = new XYZ_Insert_Php_TinyMCESelector();*/
	
global $wpdb;
$buttonName = 'xyz_ips_snippet_selecter';

$xyz_snippets_arr=$wpdb->get_results($wpdb->prepare( "SELECT id,title FROM ".$wpdb->prefix."xyz_ips_short_code WHERE status=%d  ORDER BY id DESC",1),ARRAY_A );
// 		print_r($xyz_snippets_arr);
if(count($xyz_snippets_arr)==0)
die;

if(floatval(get_bloginfo('version'))>=3.9)
{
?>
	(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.xyz_ips_snippet', {
          init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               ed.addButton( '<?php echo $buttonName;?>', {
            	    title: 'Insert PHP Code Snippet',
		            type: 'menubutton',
		            icon: 'icon xyz-ips-own-icon',
		            menu: [
			            	
			           		<?php foreach ($xyz_snippets_arr as $key=>$val) { ?>      
			           			{
			            		text: '<?php echo addslashes($val['title']); ?>',
			            		value: '[xyz-ips snippet="<?php echo addslashes($val['title']); ?>"]',
			            		onclick: function() {
			            			ed.selection.setContent(this.value());
			            		}
			           		},
							<?php } ?>  
						
	           ]
                    
               });
               
               
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'xyz_ips_buttons', tinymce.plugins.xyz_ips_snippet );
})();
<?php	
}
/*else if(floatval(get_bloginfo('version'))>=3.9)
{
?>
(function() {

 tinymce.PluginManager.add('<?php echo $buttonName; ?>', function( editor, url ) {
        editor.addButton( '<?php echo $buttonName; ?>', {
            title: 'Insert PHP Code Snippet',
            type: 'menubutton',
            icon: 'icon xyz-ips-own-icon',
            menu: [
<?php foreach ($xyz_snippets_arr as $key=>$val) { ?>            
            	{
            		text: '<?php echo addslashes($val['title']); ?>',
            		value: '[xyz-ips snippet="<?php echo addslashes($val['title']); ?>"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
<?php } ?>           		
           ]
        });
    });

})();
<?php }*/ else { 

	$xyz_snippets = array(
                'title'   =>'Insert PHP Code Snippet',
				'url'	=> plugins_url('images/logo.png', XYZ_INSERT_PHP_PLUGIN_FILE),
                'xyz_ips_snippets' => $xyz_snippets_arr
            );
	?>

var tinymce_<?php echo $buttonName; ?> =<?php echo json_encode($xyz_snippets) ?>;


(function() {
	//******* Load plugin specific language pack

	tinymce.create('tinymce.plugins.<?php echo $buttonName; ?>', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {

         tinymce_<?php echo $buttonName; ?>.insert = function(){
                if(this.v && this.v != ''){
                tinymce.execCommand('mceInsertContent', false, '[xyz-ips snippet="'+tinymce_<?php echo $buttonName; ?>.xyz_ips_snippets[this.v]['title']+'"]');
				}
            };
			
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			if(n=='<?php echo $buttonName; ?>'){
                var c = cm.createSplitButton('<?php echo $buttonName; ?>', {
                     title : tinymce_<?php echo $buttonName; ?>.title,
					 image :  tinymce_<?php echo $buttonName; ?>.url,
                     onclick : tinymce_<?php echo $buttonName; ?>.insert
                });

                // Add some values to the list box
              

				c.onRenderMenu.add(function(c, m){
		                 for (var id in tinymce_<?php echo $buttonName; ?>.xyz_ips_snippets){
                            m.add({
                                v : id,
                                title : tinymce_<?php echo $buttonName; ?>.xyz_ips_snippets[id]['title'],
                                onclick : tinymce_<?php echo $buttonName; ?>.insert
                            });
                        }
                    });


                // Return the new listbox instance
                return c;
             }
             
             return null;
		},

		
	});

	// Register plugin
	tinymce.PluginManager.add('<?php echo $buttonName; ?>', tinymce.plugins.<?php echo $buttonName; ?>);
})();

<?php } ?>
