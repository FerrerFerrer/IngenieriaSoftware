/**
 * plugin.js
 *
 */

(function() {
	tinymce.create('tinymce.plugins.TimedContentPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
            var buttonOpts = {};
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceTimedContent', function() {
				ed.windowManager.open({
					file : ajaxurl + '?action=timedContentPluginGetTinyMCEDialog',
					width : 640 + parseInt(ed.getLang('timed_content.delta_width', 0)),
					height : 420 + parseInt(ed.getLang('timed_content.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
				});
			});

            if (timedContentAdminTinyMCEOptions.image.length > 0) {
                buttonOpts.title = timedContentAdminTinyMCEOptions.desc;
                buttonOpts.cmd = 'mceTimedContent';
                buttonOpts.image = url + timedContentAdminTinyMCEOptions.image;
            } else {
                buttonOpts.title = timedContentAdminTinyMCEOptions.desc;
                buttonOpts.cmd = 'mceTimedContent';
            }
            buttonOpts.stateSelector = "img";

			// Register example button
			ed.addButton('timed_content', buttonOpts);

			// Add a node change handler, selects the button in the UI when a image is selected
//			ed.on( 'NodeChange', function(ed, cm, n) {
//				cm.setActive('timed_content', n.nodeName == 'IMG');
//			});
		},

		/**
		 * Creates control instances based in the incoming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like list-boxes, split buttons, etc. then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use in order to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Timed Content shortcodes plugin',
				author : 'K. Tough',
				authorurl : 'http://wordpress.org/plugins/timed-content/',
				infourl : 'http://wordpress.org/plugins/timed-content/',
				version : timedContentAdminTinyMCEOptions.version
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('timed_content', tinymce.plugins.TimedContentPlugin);
})();