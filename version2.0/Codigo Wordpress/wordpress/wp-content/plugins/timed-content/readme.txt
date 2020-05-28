=== Timed Content ===

Contributors: kjvtough, awelzel
Tags: marketing, marketing tool, post, page, date, time, timer, timed, show, hide, content, schedule, display
Requires at least: 3.8
Tested up to: 5.3
Stable tag: 2.65
License: GPL2

Plugin to show or hide portions of a Page or Post based on specific date/time characteristics.

== Description ==

The Timed Content plugin allows users to specify that a portion of a Page or Post should appear/be visible or disappear/be invisible based on given time characteristics. You can also make portions of a Post or Page be visible at certain dates and times; you can even set up a schedule!

The plugin adds the following:

* A "client-side" shortcode that allows the marking of content to appear or disappear after a given time interval; a "fade" effect is included.  This functionality is intended to be used for special effects only, as content marked in this manner is still visible in the HTML source and, therefore, not a secure method of hiding content.
* Two "server-side" shortcodes that allow the marking of content to be visible only during specified date/time intervals.  This functionality **can** be used as a secure method of hiding content, because the marked content will be included in the Page/Post **only** when viewed in the specified date/time intervals.

A TinyMCE dialog is included to help users build the shortcodes. See the Screenshots tab for more info.

== Installation ==

1. Extract the contents of the package to the `/wp-content/plugins/timed-content` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Old rules after updating to version 2.50 =

In versions prior to 2.50 the date/time format was not handled very well which caused quite some confusion. Therefore version 2.50 now uses a fixed format similar to ISO 8601: yyyy-mm-dd HH:MM

Existing shortcodes and rules containing dates in the format mm/dd/yyyy should still work, but when editing rules the date value is converted to the new format.

To be sure, you should check your existing rules and shortcodes if you upgraded from a version below 2.50.

= Using Timed Content in Gutenberg =

If you want to use Timed Content with Gutenberg you have to add a "Classic" block. There is no way to show or hide other content blocks with Timed Content.

== Screenshots ==

1. An example showing use of the `[timed-content-client]` shortcode.  The "alarm clock" button on the editor menubar brings up a dialog box to help build the Timed Content shortcodes.
2. The "Add Timed Content shortcode" dialog showing the Client tab.  Check the attribute you want to add and fill in the textboxes.
3. The "Add Timed Content shortcode" dialog showing the Server tab.  Check the attribute you want to add, then click on the Date and Time textboxes.
4. The date and time pickers help you format a correct date and time.  Here's the jQuery UI Datepicker in action.
5. The "Add Timed Content shortcode" dialog showing the Timed Content Rules tab.

== Changelog ==

= 2.65 =

* Fixed a PHP warning which could occur if no exceptions are defined in a rule.

= 2.64 =

* Fixed empty TinyMCE dialog.

= 2.62-2.63 =

* Fixed PHP 7.3 compatibility issues.

= 2.61 =

* Fixed PHP notice when using rules without exceptions.

= 2.60 =

* Fixed broken handling of rule exceptions.
* Changed label for intervals in rule editor.

= 2.58 =

* Changed the way how debug output is generated to the old variant without HTML sanitizing to make it easier to understand the output (thanks to Enrico Bacis for this).

= 2.57 =

* Extended `debug` parameter: it's now also possible to show debug output only if content is hidden (thanks to Enrico Bacis for this).

= 2.56 =

* Use of 'UTC' instead of '+0000' as default time zone to avoid problems with older PHP versions (eventhough you should better update to a supported PHP version).

= 2.55 =

* Better handling of shortcodes with invalid timezones to avoid unhandled runtime exceptions.
* Improved debug output.

= 2.54 =

* Default date values for new rules will now be in the correct format and not in the local date format of WordPress.

= 2.53 =

* Added support for old shortcodes with localized date formats again. Every date/time which can be used in `strtotime()` should work now as well.
* Improved format of debug output.

= 2.52 =

* Fixed a bug for server side shortcodes without or invalid "hide" attribute which did always hide the content.

= 2.51 =

* Fixed a bug where the "hide" attribute of server side shortcodes did not get parsed correctly.

= 2.50 =

* Major code refactoring and cleanup - please check your existing rules and shortcodes if they still work as expected and change them if needed!
* Increased minimum required WordPress version to 3.8
* Date format for new shortcodes and rules is now always "yyyy-mm-dd HH:MM" (similar to ISO 8601)
* Existing dates in rules and shortcodes will be parsed as "mm/dd/yyyy HH:MM" if they contain slashes
* Time values containing "AM" or "PM" will still work but converted to 24h format internally

= 2.15 =

* Fixed 404 error caused by wrong URL for jquery date/time picker localization.
* Current date/time in TinyMCE dialog will be displayed as "yyyy-mm-dd HH:MM" as well.

= 2.10 =

* Fixed a problem with unexpected `p` elements inside server side timed content sections.

= 2.9 =

* Changed default sort order of the rules in the backend to the title.

= 2.8 =

* Added debug parameter `tctest`.

= 2.7 =

* Fixed deprecated class constructors.

= 2.6 =

* New action hooks.
* `[timed-content-rule]` shortcode now accepts a Timed Content Rule name as well as an ID.
* Streamlined i18n for date/time pickers (Use values available in Wordpress settings and `$wp_locale` when available, combined *-i18n.js files into one).
* Some developer docs in the `readme.txt`

= 2.5.1 =

* Fixed `current_time()` bug in __rulesShowHTML() introduced in 2.5.

= 2.5 =

* Removed dependency on jQuery UI Dialog; now uses Thickbox.
* Added and modified `fix_date_i18n()` from https://core.trac.wordpress.org/ticket/25768 to better handle DST and timezones with i18n.
* Added custom filter `timed_content_filter_override` so admins can modify/replace `timed_content_filter` if necessary.
* Using built-in spinner image now instead of `wpspin.gif`

= 2.4 =

* Removed `timed-content-admin-tinymce.js` (No need anymore; required JS variables now hooked directly into editor). Fixes incompatibility with OptimizePress.

= 2.3.1 =

* Fixed minor bugs related to Exception Dates.
* Optimized rule periods arrays (array only needs 'status' and 'time' when it's meant to be human-readable).
* Added custom filter `timed_content_filter` to emulate `apply_filter( 'the_content', ... )` functionality for content.

= 2.3 =

* Fixed bug when setting up weekly recurrence for Timed Content Rules.
* NEW! Exception Dates (dates on which your Timed Content Rule shouldn't run).

= 2.2 =

* Much improved i18n
* New Spanish translation - Many thanks to Andrew Kurtis and Jelena Kovacevic from WebHostingHub (Nueva traducción de español - Muchas gracias a Andrew Kurtis y Jelena Kovacevic desde WebHostingHub).

= 2.1.5 =

* Unified dashicons among all of my plugins.
* Minor improvements in TinyMCE dialog UI and Date/Time UI controls.

= 2.1.4 =

* Fixed TinyMCE editor button for TinyMCE 4.x.

= 2.1.3 =

* Removed support for PHP4 in `customFieldsInterface.php`.
* Fixed Wordpress version check for deciding which image to use for TinyMCE button.
* Fixed "Strict Standards" warning in PHP 5.4 in `__getNextWeek()`.

= 2.1.2 =

* Dashicons support for WP 3.8 + added. Support for old-style icons in Admin/TinyMCE is deprecated.
* Added versioning to all `wp_enqueue_style()` calls.

= 2.1.1 =

* CSS for JQuery UI now loaded locally as required by Wordpress plugin repository rules.
* Improved UX on TinyMCE dialog and Timed Content Rules detail page.

= 2.1 =

* Fixed inconsistency in how the days of week to repeat on were being set up between the front and back ends.
* Fixed variable scope bug that occurred on activation.
* Improved i18n.

= 2.0 =

* Added Timed Content Rules.
* Replaced AnyTime plugin with jQuery UI Timepicker (http://fgelinas.com/code/timepicker) and Wordpress's internal jQuery UI Datepicker.
* HTML code created by `[timed-content-client]` can now either be enclosed in either `<div>` or `<span>` tags.
* Debugging statements for `[timed-content-server]` now displayed on Post/Page (only if logged in and have the rights to edit that Post/Page - no more digging into the HTML source).
* Improved code documentation.

= 1.2 =

* Upgraded AnyTime jQuery plugin.
* `timed-content.js` is now always loaded (Size > 1KB, so not a lot of extra overhead); fixes bug when multiple/nested shortcodes are used.

= 1.1 =

* Fixed some internal filename discrepancies.

= 1.0 =

* Initial release.

== Examples ==

`[timed-content-client show="1:00"]Show me after one minute.  Since we don't want a fade-in, we can leave it out of the "show" attribute completely.[/timed-content-client]`

`[timed-content-client show="1:00:1000"]Show me after one minute with a 1000 millisecond (1 second) fade-in.[/timed-content-client]`

`[timed-content-client hide="1:00:1000"]Hide me after one minute with a 1000 millisecond (1 second) fade-out.[/timed-content-client]`

`[timed-content-client show="1:00:500" hide="5:00:2000"]Show me after one minute with a 500 millisecond (a half-second) fade-in, then hide me after five minutes with a 2000 millisecond (2 seconds) fade-out.[/timed-content-client]`

`[timed-content-server show="2013-09-13 20:30:00 -0600"]Show me starting at 8:30 PM Central Standard Time on September 13th, 2013. I will not be displayed before then.[/timed-content-server]`

`[timed-content-server hide="2013-09-13 20:30:00 America/Chicago"]Hide me starting at 8:30 PM Central Daylight Time (i.e., the same timezone as Chicago) on September 13th, 2013.  I will not be displayed after then[/timed-content-server]`

`[timed-content-server show="2013-09-13 20:30:00 -0600" hide="2013-09-13 21:30:00 -0600"]Show me starting at 8:30 PM Central Standard Time on September 13th, 2013, then hide me an hour later. I will not be displayed before or after then.[/timed-content-server]`

`[timed-content-rule id="164"]Display me based on the settings for the Timed Content Rule whoseID is 164.[/timed-content-rule]`

== Usage ==

NOTE: All shortcodes can be built using the TinyMCE dialog.  When in doubt, use the dialog to create correctly formed shortcodes.

**The timed-content-client shortcode**

`[timed-content-client show="mm:ss:fff" hide="mm:ss:fff"]Example Text[/timed-content-client]`

* `show` - Specifies the time interval after loading the web page when the marked content should be displayed. The attribute consists of three parts,
separated by colons: `mm` - minutes, `ss` - seconds, and `fff` - if greater than `0`, a fade-in effect lasting `fff` milliseconds is applied.
* `hide` - Specifies the time interval after loading the web page when the marked content should be hidden. The attribute consists of three parts,
separated by colons: `mm` - minutes, `ss` - seconds, and `fff` - if greater than `0`, a fade-out effect lasting `fff` milliseconds is applied.

Both attributes are optional, but at least one attribute must be included. Leading zeros (0) are optional. The shortcode's behaviour depends on which attributes are used:

* `show` only - Marked content is initially not visible, then appears `mm` minutes and `ss` seconds after loading with a `fff` millisecond fade-in.
* `hide` only - Marked content is initially visible, then disappears `mm` minutes and `ss` seconds after loading with a `fff` millisecond fade-out.
* `show` and `hide` - Marked content is initially not visible, then appears according to the values set in `show`, then disappears according to the values set in `hide`.

Your users must have JavaScript enabled for this shortcode to work.

**The timed-content-server shortcode**

`[timed-content-server show="datetime" hide="datetime" debug="true|false|when_hidden"]Example Text[/timed-content-server]`

* `show` - Specifies the date/time when the marked content should start being included on the web page.
* `hide` - Specifies the date/time after which the marked content should stop being included on the web page.
* `debug` - If `true`, adds some debugging statements to the web page as HTML comments. If `when_hidden`, the debugging statements are added only when the content is hidden. Defaults to `false`.

The date and time are expected to be yyyy-mm-dd HH:MM (similar to ISO 8601), for example `2019-04-07 15:30` for April 7, 2019, 15:30. For backward compatiblity old "human readable" date formats should also work, but these should not be used any longer!

Both `show` and `hide` attributes are optional, but at least one attribute must be included. The shortcode's behaviour depends on which attributes are used:

* `show` only - Marked content is outputted only after the date/time set here.
* `hide` only - Marked content is outputted only before the date/time set here.
* `show` and `hide` - Marked content is outputted only during the time period defined by the `show` and `hide` attributes.

**The timed-content-rule shortcode**

`[timed-content-rule id="{rule_id}|{rule_name}"]Example Text[/timed-content-rule]`

You can find the correct shortcode from the Timed Content Rules overview page, or use the TinyMCE dialog.

**Testing server side rules**

For testing the behaviour of server side rules at specific times, you may use the GET parameter `tctest` in an URL, followed by date and time in the format `YYYY-MM-DD+hh:mm:ss`. This works only you are logged in with a user which has the right to edit the displayed page or post. For example: `http://mysite.example?tctest=2018-02-10+19:16:00` will show the content as if it was February 2, 2018 at 19:16.

== Developer Documentation ==

**Action hooks**

`add_action( "timed_content_server_show", "{function_name}", {priority_level}, 4 );`

Fired when the `[timed-content-server]` shortcode is encountered *AND* the content is to be displayed based on the shortcode's show/hide attributes.  Functions using this hook should accept the following arguments in order:

* `$post_id` - the ID of the currently displayed Post/Page
* `$show` - the value of the `show` attribute. If not set, defaults to "1970-Jan-01 00:00:00 +000"
* `$hide` - the value of the `hide` attribute. If not set, defaults to "2038-Jan-19 03:14:07 +000"
* `$content` - The content enclosed by the shortcode

`add_action( "timed_content_server_hide", "{function_name}", {priority_level}, 4 );`

Fired when the `[timed-content-server]` shortcode is encountered *AND* the content is to be hidden based on the shortcode's show/hide attributes.  Functions using this hook should accept the following arguments in order:

* `$post_id` - the ID of the currently displayed Post/Page
* `$show` - the value of the `show` attribute. If not set, defaults to "1970-Jan-01 00:00:00 +000"
* `$hide` - the value of the `hide` attribute. If not set, defaults to "2038-Jan-19 03:14:07 +000"
* `$content` - The content enclosed by the shortcode

`add_action( "timed_content_rule_show", "{function_name}", {priority_level}, 3 );`

Fired when the `[timed-content-rule]` shortcode is encountered *AND* the content is to be displayed based on the Timed Content Rule's properties.  Functions using this hook should accept the following arguments in order:

* `$post_id` - the ID of the currently displayed Post/Page
* `$rule_id` - the ID of the Timed Content Rule being called. Use `get_post_meta( $rule_id )` to get the Rule's properties.
* `$content` - The content enclosed by the shortcode

`add_action( "timed_content_rule_hide", "{function_name}", {priority_level}, 3 );`

Fired when the `[timed-content-rule]` shortcode is encountered *AND* the content is to be hidden based on the Timed Content Rule's properties.  Functions using this hook should accept the following arguments in order:

* `$post_id` - the ID of the currently displayed Post/Page
* `$rule_id` - the ID of the Timed Content Rule being called. Use `get_post_meta( $rule_id )` to get the Rule's properties.
* `$content` - The content enclosed by the shortcode

**Filter hooks**

`timed_content_filter`

Filter for any content enclosed by a Timed Content shortcode.  Implements the same filters as `the_content`:

* `wptexturize`
* `convert_smilies`
* `convert_chars`
* `wpautop`
* `prepend_attachment`
* `do_shortcode`

`timed_content_filter_override`

Replaces the `timed_content_filter` with another pre-existing filter to use for any content enclosed by a Timed Content shortcode.  Any function hooked into this filter must return the name of a filter (as a string).
