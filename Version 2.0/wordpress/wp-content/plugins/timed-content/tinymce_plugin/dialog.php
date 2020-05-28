<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php _ex( 'Add Timed Content shortcodes', 'TinyMCE Dialog - Dialog titlebar', 'timed-content' ); ?> </title>
    <script type="text/javascript" src="<?php echo includes_url(); ?>/js/tinymce/tiny_mce_popup.js"></script>
    <script type="text/javascript" src="<?php echo includes_url(); ?>/js/tinymce/utils/mctabs.js"></script>
    <?php wp_print_styles(); ?>
    <style>
        .panel_wrapper {
            height: 370px;
        }
        div.ui-datepicker-div {
            font-size: 10px;
        }
        div.ui-timepicker-div {
            font-size: 10px;
        }
        div.tabs ul li {
            cursor: pointer;
        }
    </style>
    <?php wp_print_scripts(); ?>
    <script type="text/javascript">
        <?php echo $this->getRulesJS(); ?>
        var tags = { 'client': '<?php echo TIMED_CONTENT_SHORTCODE_CLIENT; ?>',
            'server': '<?php echo TIMED_CONTENT_SHORTCODE_SERVER; ?>',
            'rule': '<?php echo TIMED_CONTENT_SHORTCODE_RULE; ?>' };
        var errorMessages = { 'clientNoShow': '<?php _e( 'When using the Show action, the Show time must be at least 1 second.', 'timed-content' ); ?>',
            'clientNoHide': '<?php _e( 'When using the Hide action, the Hide time must be at least 1 second.', 'timed-content' ); ?>',
            'clientHideBeforeShow': '<?php _e( 'When using both Show and Hide actions, the Hide time must be later than the Show time.', 'timed-content' ); ?>',
            'clientNoAction': '<?php _e( 'Please select an action to perform.', 'timed-content' ); ?>',
            'serverNoShowDate': '<?php _e( 'Please set a date for the Show action.', 'timed-content' ); ?>',
            'serverNoShowTime': '<?php _e( 'Please set a time for the Show action.', 'timed-content' ); ?>',
            'serverNoHideDate': '<?php _e( 'Please set a date for the Hide action.', 'timed-content' ); ?>',
            'serverNoHideTime': '<?php _e( 'Please set a time for the Hide action.', 'timed-content' ); ?>',
            'serverHideBeforeShow': '<?php _e( 'When using both Show and Hide actions, the Hide time must be later than the Show time.', 'timed-content' ); ?>',
            'serverNoAction': '<?php _e( 'Please select an action to perform.', 'timed-content' ); ?>' };
        var datepickParam = { 'dateFormat' : 'yy-mm-dd' };
    </script>
    <script type="text/javascript" src="<?php echo TIMED_CONTENT_PLUGIN_URL; ?>/tinymce_plugin/dialog.js"></script>
</head>
<body style="display: none">
<div class="tabs">
    <ul>
        <li id="client_tab" class="current" onclick="javascript:mcTabs.displayTab('client_tab','client_panel');">
            <span><?php _ex( 'Client', 'TinyMCE Dialog - Client tab label', 'timed-content' ); ?> </span></li>
        <li id="server_tab" onclick="javascript:mcTabs.displayTab('server_tab','server_panel');">
            <span><?php _ex( 'Server', 'TinyMCE Dialog - Server tab label', 'timed-content' ); ?> </span></li>
        <li id="rules_tab" onclick="javascript:mcTabs.displayTab('rules_tab','rules_panel');">
            <span><?php _ex( 'Timed Content Rules', 'TinyMCE Dialog - Rules tab label', 'timed-content' ); ?></span>
        </li>
    </ul>
</div>
<div class="panel_wrapper">
    <div id="client_panel" class="panel current">
        <form name="TimedContentDialogClient" id="TimedContentDialogClient"
              onsubmit="TimedContentDialog.client_action();return false;" action="#">
            <p><?php _ex( 'Select the actions you wish to perform and the times after the Page/Post is loaded when they should occur.', 'TinyMCE Dialog - Client tab instructions', 'timed-content' ); ?> </p>
            <fieldset>
                <legend>
                    <input name="do_client_show" type="checkbox" id="do_client_show" value="show"/>
                    <label
                        for="do_client_show"><?php _ex( 'Show', 'TinyMCE Dialog - Show action label', 'timed-content' ); ?>  </label>
                </legend>
                <p><label
                        for="client_show_minutes"><?php _ex( 'Time (mm:ss):', 'TinyMCE Dialog - Time count label', 'timed-content' ); ?></label>
                    <input id="client_show_minutes" name="client_show_minutes" type="text" class="text" size="2"
                           disabled="disabled"/>
                    :
                    <input id="client_show_seconds" name="client_show_seconds" type="text" class="text" size="2"
                           disabled="disabled"/>
                </p>

                <p><label
                        for="client_show_fade"><?php _ex( 'Fade in (ms):', 'TinyMCE Dialog - Fade-in label', 'timed-content' ); ?></label>
                    <input id="client_show_fade" name="client_show_fade" type="text" class="text" size="4"
                           disabled="disabled"/>
                    <em>(<?php _ex( 'Optional', 'TinyMCE Dialog - Optional checkbox HTML label', 'timed-content' ); ?>)</em>
                </p>
            </fieldset>
            <fieldset>
                <legend>
                    <input name="do_client_hide" type="checkbox" id="do_client_hide" value="hide"/>
                    <label
                        for="do_client_hide"><?php _ex( 'Hide', 'TinyMCE Dialog - Hide action label', 'timed-content' ); ?> </label>
                </legend>
                <p><label
                        for="client_hide_minutes"><?php _ex( 'Time (mm:ss):', 'TinyMCE Dialog - Time count label', 'timed-content' ); ?></label>
                    <input id="client_hide_minutes" name="client_hide_minutes" type="text" class="text" size="2"
                           disabled="disabled"/>
                    :
                    <input id="client_hide_seconds" name="client_hide_seconds" type="text" class="text" size="2"
                           disabled="disabled"/>
                </p>

                <p><label
                        for="client_hide_fade"><?php _ex( 'Fade out (ms):', 'TinyMCE Dialog - Fade-out label', 'timed-content' ); ?></label>
                    <input id="client_hide_fade" name="client_hide_fade" type="text" class="text" size="4"
                           disabled="disabled"/>
                    <em>(<?php _ex( 'Optional', 'TinyMCE Dialog - Optional checkbox HTML label', 'timed-content' ); ?>)</em>
                </p>
            </fieldset>
            <fieldset>
                <legend>
                    <?php _ex( 'Display Mode', 'TinyMCE Dialog - Display Mode label', 'timed-content' ); ?> </legend>
                <p><input id="client_display_tag_div" name="client_display_tag" type="radio" class="text"
                          checked="checked"/>
                    <label
                        for="client_display_tag_div"><?php printf( _x( 'Enclose content using %s tags (block-level)', 'TinyMCE Dialog - Display mode <div> HTML description', 'timed-content' ), "<code>&lt;div&gt;</code>" ); ?> </label><br />
                    <input id="client_display_tag_span" name="client_display_tag" type="radio" class="text"/>
                    <label
                        for="client_display_tag_span"><?php printf( _x( 'Enclose content using %s tags (inline)', 'TinyMCE Dialog - Display mode <span> HTML description', 'timed-content' ), "<code>&lt;span&gt;</code>" ); ?> </label>
                </p>
            </fieldset>
            <div class="mceActionPanel">
                <input type="button" id="insert" name="insert"
                       value="<?php _ex( 'Insert', 'TinyMCE Dialog - Insert button HTML label', 'timed-content' ); ?> "
                       onclick="TimedContentDialog.client_action();"/>
                <input type="button" id="cancel" name="cancel"
                       value="<?php _ex( 'Cancel', 'TinyMCE Dialog - Cancel button HTML label', 'timed-content' ); ?> "
                       onclick="tinyMCEPopup.close();"/>
            </div>
        </form>
    </div>
    <div id="server_panel" class="panel">
        <form name="TimedContentDialogServer" id="TimedContentDialogServer"
              onsubmit="TimedContentDialog.server_action();return false;" action="#">
            <p><?php _ex( 'Select the actions you wish to perform and the dates/times when they should occur.', 'TinyMCE Dialog - Server tab instructions', 'timed-content' ); ?> </p>

            <p>
                <input name="server_debug" type="checkbox" id="server_debug" value="true"/>
                <label
                    for="server_debug"><?php _ex( 'Add debugging messages (Only logged-in users who can edit this Post/Page will see them)', 'TinyMCE Dialog - Server debugging label', 'timed-content' ); ?> </label>
            </p>

            <p><?php _e('Current Date/Time:', 'timed-content' ); ?> <?php echo strftime( '%Y-%m-%d %H:%M', current_time('timestamp', 0)); ?></p>
            <fieldset>
                <legend>
                    <input name="do_server_show" type="checkbox" id="do_server_show" value="show"/>
                    <label
                        for="do_server_show"><?php _ex( 'Show', 'TinyMCE Dialog - Show action label', 'timed-content' ); ?> </label>
                </legend>
                <p><label for="server_show_date"><?php _ex( 'Date:', 'Date field label', 'timed-content' ); ?> </label>
                    <input name="server_show_date" type="text" disabled="disabled" class="text" id="server_show_date"
                           style="width: 175px;"/>
                    <label for="server_show_time"><?php _ex( 'Time:', 'Time field label', 'timed-content' ); ?> </label>
                    <input name="server_show_time" type="text" disabled="disabled" class="text" id="server_show_time"
                           style="width: 125px;"/>
                </p>
            </fieldset>
            <fieldset>
                <legend>
                    <input name="do_server_hide" type="checkbox" id="do_server_hide" value="hide"/>
                    <label
                        for="do_server_hide"><?php _ex( 'Hide', 'TinyMCE Dialog - Hide action label', 'timed-content' ); ?></label>
                </legend>
                <p><label for="server_hide_date"><?php _ex( 'Date:', 'Date field label', 'timed-content' ); ?> </label>
                    <input name="server_hide_date" type="text" disabled="disabled" class="text" id="server_hide_date"
                           style="width: 175px;"/>
                    <label for="server_hide_time"><?php _ex( 'Time:', 'Time field label', 'timed-content' ); ?> </label>
                    <input name="server_hide_time" type="text" disabled="disabled" class="text" id="server_hide_time"
                           style="width: 125px;"/>
                </p>
            </fieldset>
            <fieldset>
                <legend>
                    <?php _ex( 'Timezone', 'TinyMCE Dialog - Timezone fieldset label', 'timed-content' ); ?> 
                </legend>
                <p><?php _ex( 'Select a city whose timezone you wish to use:', 'TinyMCE Dialog - Timezone <select> HTML label', 'timed-content' ); ?>
                    <select name="server_tz" id="server_tz" style="width: auto;">
                        <?php echo customFieldsInterface::generateTimezoneSelectOptions(get_option('timezone_string')); ?>
                    </select>
                </p>

                <p><?php _e('Wordpress Timezone:', 'timed-content' ); ?> <?php echo get_option('timezone_string'); ?></p>
            </fieldset>
            <div class="mceActionPanel">
                <input type="button" id="insert" name="insert"
                       value="<?php _ex( 'Insert', 'TinyMCE Dialog - Insert button HTML label', 'timed-content' ); ?> "
                       onclick="TimedContentDialog.server_action();"/>
                <input type="button" id="cancel" name="cancel"
                       value="<?php _ex( 'Cancel', 'TinyMCE Dialog - Cancel button HTML label', 'timed-content' ); ?> "
                       onclick="tinyMCEPopup.close();"/>
            </div>
        </form>
    </div>
    <div id="rules_panel" class="panel">
        <form name="TimedContentDialogRules" id="TimedContentDialogRules"
              onsubmit="TimedContentDialog.rules_action();return false;" action="#">
            <p><?php _ex( 'Select the Timed Content Rule you wish to use. Only rules without any warnings will appear below.', 'TinyMCE Dialog - Timed Content Rules tab instructions', 'timed-content' ); ?> </p>

            <p><?php _ex( 'Rule:', 'TinyMCE Dialog - Timed Content Rules <select> HTML label', 'timed-content' ); ?>
                <select name="rules_list" id="rules_list" style="width: auto;">
                    <!-- options list generated using $this->getRulesJS() above and TimedContentDialog.init JS function in /tinymce_plugin/js/dialog.js -->
                </select>
            </p>
            <fieldset>
                <legend>
                    <?php _ex( 'Description', 'TinyMCE Dialog - Timed Content Rules description label', 'timed-content' ); ?>  </legend>
                <p>
                    <span id="rules_desc"></span>
                </p>
            </fieldset>
            <div class="mceActionPanel">
                <input type="button" id="insert" name="insert"
                       value="<?php _ex( 'Insert', 'TinyMCE Dialog - Insert button HTML label', 'timed-content' ); ?> "
                       onclick="TimedContentDialog.rules_action();"/>
                <input type="button" id="cancel" name="cancel"
                       value="<?php _ex( 'Cancel', 'TinyMCE Dialog - Cancel button HTML label', 'timed-content' ); ?> "
                       onclick="tinyMCEPopup.close();"/>
            </div>
        </form>
    </div>
</div>
</body>
