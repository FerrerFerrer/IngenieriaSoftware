tinyMCEPopup.requireLangPack();

var TimedContentDialog = {
	init : function() {
		jQuery('#do_client_show').click(
			 function()  {
				 if (jQuery(this).is(':checked'))  {
					 jQuery('#client_show_minutes').removeAttr('disabled');
					 jQuery('#client_show_seconds').removeAttr('disabled');
					 jQuery('#client_show_fade').removeAttr('disabled');
				 }  else  {
					 jQuery('#client_show_minutes').prop('disabled', 'disabled');
					 jQuery('#client_show_seconds').prop('disabled', 'disabled');
					 jQuery('#client_show_fade').prop('disabled', 'disabled');
				 }
			 }
		);
		
		jQuery('#do_client_hide').click(
			 function()  {
				 if (jQuery(this).is(':checked'))  {
					 jQuery('#client_hide_minutes').removeAttr('disabled');
					 jQuery('#client_hide_seconds').removeAttr('disabled');
					 jQuery('#client_hide_fade').removeAttr('disabled');
				 }  else  {
					 jQuery('#client_hide_minutes').prop('disabled', 'disabled');
					 jQuery('#client_hide_seconds').prop('disabled', 'disabled');
					 jQuery('#client_hide_fade').prop('disabled', 'disabled');
				 }
			 }
		);

		var today = new Date();

		jQuery('#do_server_show').click(
			 function()  {
				 if (jQuery(this).is(':checked'))  {
					jQuery('#server_show_date').removeAttr('disabled');
					jQuery('#server_show_time').removeAttr('disabled');
					jQuery('#server_show_date').datepicker(
						{
							changeMonth: true,
							changeYear: true,
							dateFormat: datepickParam.dateFormat
						}
					);
					jQuery('#server_show_time').timepicker(
						{
                            defaultTime: 'now'
						}
					);
				 }  else  {
					jQuery('#server_show_date').prop('disabled', 'disabled');
					jQuery('#server_show_time').prop('disabled', 'disabled');
				 }
			 }
		);
		
		jQuery('#do_server_hide').click(
			 function()  {
				 if (jQuery(this).is(':checked'))  {
					jQuery('#server_hide_date').removeAttr('disabled');
					jQuery('#server_hide_time').removeAttr('disabled');
					jQuery('#server_hide_date').datepicker(
						{
							changeMonth: true,
							changeYear: true,
							dateFormat: datepickParam.dateFormat
						}
					);
					jQuery('#server_hide_time').timepicker(
						{
                            defaultTime: 'now'
						}
					);
				 }  else  {
					jQuery('#server_hide_date').prop('disabled', 'disabled');
					jQuery('#server_hide_time').prop('disabled', 'disabled');
				 }
			 }
		);
		
		jQuery.each( rules, function( key, value ) {
			jQuery('select#rules_list').append( '<option value="' + value['ID'] + '">' + value['title'] + '</option>\n' );
		});
		jQuery( "select#rules_list" ).change( function() {
			jQuery( "select#rules_list option:selected" ).each( function() {
				var id = jQuery( this ).val();
				jQuery.each( rules, function( key, value ) {
					if ( id == value['ID'] ) 
						jQuery( "span#rules_desc" ).html(value['desc']);
				});
                if ( id < 0 ) {
                    jQuery('select#rules_list').prop('disabled', 'disabled');
                    jQuery('#TimedContentDialogRules #insert').prop('disabled', 'disabled');
                }

			});
		}).trigger( "change" );
		
	},

	client_action : function() {
		// Get settings from the dialog and build the arguments for the shortcode
		var show_args = "";
		var hide_args = "";
		var display_args = "";

		var sm = Math.abs(parseInt(jQuery('#client_show_minutes').val()));
		var ss = Math.abs(parseInt(jQuery('#client_show_seconds').val()));
		var sf = Math.abs(parseInt(jQuery('#client_show_fade').val()));
		if (isNaN(sm)) sm = 0; if (isNaN(ss)) ss = 0; if (isNaN(sf)) sf = 0;

		var hm = Math.abs(parseInt(jQuery('#client_hide_minutes').val()));
		var hs = Math.abs(parseInt(jQuery('#client_hide_seconds').val()));
		var hf = Math.abs(parseInt(jQuery('#client_hide_fade').val()));
		if (isNaN(hm)) hm = 0; if (isNaN(hs)) hs = 0; if (isNaN(hf)) hf = 0; 

		st = (sm * 60) + ss;  ht = (hm * 60) + hs;
		
		if (jQuery('#client_display_tag_div').prop('checked')) 
			display_args = " display=\"div\"";
		else  
			display_args = " display=\"span\"";
		
		if (jQuery('#do_client_show').prop('checked')) { 
			if (st > 0)
				show_args = " show=\"" + sm + ":" + ss + ":" + sf + "\"";
			else  {
				tinyMCEPopup.alert(errorMessages.clientNoShow);
				return;
			}
		}
		if (jQuery('#do_client_hide').prop('checked')) {
			if (ht > 0)
				hide_args = " hide=\"" + hm + ":" + hs + ":" + hf + "\"";
			else  {
				tinyMCEPopup.alert(errorMessages.clientNoHide);
				return;
			}
		}
		
		if (jQuery('#do_client_show').prop('checked') && jQuery('#do_client_hide').prop('checked') && (st >= ht)) {
			tinyMCEPopup.alert(errorMessages.clientHideBeforeShow);
			return;
		}
		
		if (!(jQuery('#do_client_show').prop('checked') || jQuery('#do_client_hide').prop('checked'))) {
			tinyMCEPopup.alert(errorMessages.clientNoAction);
			return;
		}
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceReplaceContent', false, '[' + tags.client + ' ' + show_args + hide_args + display_args + ']{$selection}[/' + tags.client + ']');
		tinyMCEPopup.close();
	},

	server_action : function() {
		// Get settings from the dialog and build the arguments for the shortcode
		var show_args = "";
		var hide_args = "";
		var debug_args = "";

		var sd = jQuery('#server_show_date').val();
		var hd = jQuery('#server_hide_date').val();
		var st = jQuery('#server_show_time').val();
		var ht = jQuery('#server_hide_time').val();
		var tz = jQuery('#server_tz option:selected').val();
		var s_Date = new Date(sd + " " + st); 
		var h_Date = new Date(hd + " " + ht); 

		if (jQuery('#do_server_show').prop('checked')) { 
			show_args = " show=\"" + sd + " " + st + " " + tz + "\"";
		}
		if (jQuery('#do_server_hide').prop('checked')) {
			hide_args = " hide=\"" + hd + " " + ht + " " + tz + "\"";
		}
		if (jQuery('#server_debug').prop('checked')) {
			debug_args = " debug=\"true\"";
		}
				
		if (jQuery('#do_server_show').prop('checked') && (sd.length == 0)) {
			tinyMCEPopup.alert(errorMessages.serverNoShowDate);
			return;
		}
		
		if (jQuery('#do_server_hide').prop('checked') && (hd.length == 0)) {
			tinyMCEPopup.alert(errorMessages.serverNoHideDate);
			return;
		}
		
		if (jQuery('#do_server_show').prop('checked') && (st.length == 0)) {
			tinyMCEPopup.alert(errorMessages.serverNoShowTime);
			return;
		}
		
		if (jQuery('#do_server_hide').prop('checked') && (ht.length == 0)) {
			tinyMCEPopup.alert(errorMessages.serverNoHideTime);
			return;
		}
		
		if (jQuery('#do_server_show').prop('checked') && jQuery('#do_server_hide').prop('checked') && (s_Date >= h_Date)) {
			tinyMCEPopup.alert(errorMessages.serverHideBeforeShow);
			return;
		}
		
		if (!(jQuery('#do_server_show').prop('checked') || jQuery('#do_server_hide').prop('checked'))) {
			tinyMCEPopup.alert(errorMessages.serverNoAction);
			return;
		}

		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceReplaceContent', false, '[' + tags.server + ' ' + show_args + hide_args + debug_args + ']{$selection}[/' + tags.server + ']');
		tinyMCEPopup.close();
	},
	
	rules_action : function() {
		// Get settings from the dialog and build the arguments for the shortcode
		var rule_args = " id=\"" + jQuery('select#rules_list option:selected').val() + "\"";
		
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceReplaceContent', false, '[' + tags.rule + ' ' + rule_args + ']{$selection}[/' + tags.rule + ']');
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(TimedContentDialog.init, TimedContentDialog);
