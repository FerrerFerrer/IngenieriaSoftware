<?php
/*
Plugin Name: Timed Content
Text Domain: timed-content
Domain Path: /lang
Plugin URI: http://wordpress.org/plugins/timed-content/
Description: Plugin to show or hide portions of a Page or Post based on specific date/time characteristics.  These actions can either be processed either server-side or client-side, depending on the desired effect.
Author: K. Tough, Arno Welzel, Enrico Bacis
Version: 2.65
Author URI: http://wordpress.org/plugins/timed-content/
*/
defined('ABSPATH') or die();

include 'lib/customFieldsInterface.php';

define('TIMED_CONTENT_VERSION', '2.65');
define('TIMED_CONTENT_SLUG', 'timed-content');
define('TIMED_CONTENT_PLUGIN_URL', plugins_url() . '/' . TIMED_CONTENT_SLUG);
define('TIMED_CONTENT_SHORTCODE_CLIENT', 'timed-content-client');
define('TIMED_CONTENT_SHORTCODE_SERVER', 'timed-content-server');
define('TIMED_CONTENT_SHORTCODE_RULE', 'timed-content-rule');
define('TIMED_CONTENT_TIME_ZERO', '1970-01-01 00:00:00 +000');  // Start of Unix Epoch (32 bit)
define('TIMED_CONTENT_TIME_END', '2038-01-19 03:14:06 +000');   // End of Unix Epoch (32 bit)
define('TIMED_CONTENT_RULE_TYPE', 'timed_content_rule');
define('TIMED_CONTENT_RULE_POSTMETA_PREFIX', TIMED_CONTENT_RULE_TYPE . '_');
define('TIMED_CONTENT_CSS', TIMED_CONTENT_PLUGIN_URL . '/css/timed-content.css');
define('TIMED_CONTENT_CSS_DASHICONS', TIMED_CONTENT_PLUGIN_URL . '/css/dashicons/style.css');
define('TIMED_CONTENT_JQUERY_UI_CSS', TIMED_CONTENT_PLUGIN_URL . '/css/jqueryui/1.10.3/themes/smoothness/jquery-ui.css');
define('TIMED_CONTENT_JQUERY_UI_TIMEPICKER_JS', TIMED_CONTENT_PLUGIN_URL . '/js/jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.js');
define('TIMED_CONTENT_JQUERY_UI_TIMEPICKER_CSS', TIMED_CONTENT_PLUGIN_URL . '/js/jquery-ui-timepicker-0.3.3/jquery.ui.timepicker.css');
define('TIMED_CONTENT_DATE_FORMAT_OUTPUT', 'Y-m-d H:i O');

/**
 * Class timedContentPlugin
 *
 * @package TimedContent
 */
class timedContentPlugin
{
    var $rule_freq_array;
    var $rule_days_array;
    var $rule_ordinal_array;
    var $rule_ordinal_days_array;
    var $rule_occurrence_custom_fields;
    var $rule_pattern_custom_fields;
    var $rule_recurrence_custom_fields;
    var $rule_exceptions_custom_fields;

    var $meridiem;
    var $show_period;
    var $show_period_labels;
    var $show_leading_zero;

    var $jquery_ui_datetime_datepicker_i18n;
    var $jquery_ui_datetime_timepicker_i18n;

    /**
     * Constructor
     */
    function __construct()
    {
        add_filter('timed_content_filter', 'convert_smilies');
        add_filter('timed_content_filter', 'convert_chars');
        add_filter('timed_content_filter', 'prepend_attachment');
        add_filter('timed_content_filter', 'do_shortcode');
        add_filter('manage_' . TIMED_CONTENT_RULE_TYPE . '_posts_columns', array($this, 'addDescColumnHead'));
        add_filter('pre_get_posts', array($this, 'timedContentPreGetPosts'));
        add_filter('post_updated_messages', array($this, 'timedContentRuleUpdatedMessages'), 1);

        add_action('plugins_loaded', array($this, 'i18nInit'), 1);
        add_action('init', array($this, 'init'), 2);
        add_action('wp_head', array($this, 'addHeaderCode'), 1);
        add_action('manage_' . TIMED_CONTENT_RULE_TYPE . '_posts_custom_column', array($this, 'addDescColumnContent'), 10, 2);
        add_action('admin_enqueue_scripts', array($this, 'addAdminHeaderCode'), 1);
        add_action('admin_init', array($this, 'setTinyMCEPluginVars'), 1);
        add_action('admin_init', array($this, 'initTinyMCEPlugin'), 2);
        add_action('wp_ajax_timedContentPluginGetTinyMCEDialog', array($this, 'timedContentPluginGetTinyMCEDialog'), 1);
        add_action('wp_ajax_timedContentPluginGetRulePeriodsAjax', array($this, 'timedContentPluginGetRulePeriodsAjax'), 1);
        add_action('wp_ajax_timedContentPluginGetScheduleDescriptionAjax', array($this, 'timedContentPluginGetScheduleDescriptionAjax'), 1);
        add_action('dashboard_glance_items', array($this, 'addRulesCount'));
        add_action('admin_head', array($this, 'addPostTypeIcons'), 1);

        add_shortcode(TIMED_CONTENT_SHORTCODE_CLIENT, array($this, 'clientShowHTML'));
        add_shortcode(TIMED_CONTENT_SHORTCODE_SERVER, array($this, 'serverShowHTML'));
        add_shortcode(TIMED_CONTENT_SHORTCODE_RULE, array($this, 'rulesShowHTML'));
    }

    /**
     * Initialise plugin
     */
    function init()
    {
        global $wp_locale;

        $this->rule_freq_array = array(
            0 => __('hourly', 'timed-content'),
            1 => __('daily', 'timed-content'),
            2 => __('weekly', 'timed-content'),
            3 => __('monthly', 'timed-content'),
            4 => __('yearly', 'timed-content')
        );

        $this->rule_days_array = array(
            0 => __('Sunday', 'timed-content'),
            1 => __('Monday', 'timed-content'),
            2 => __('Tuesday', 'timed-content'),
            3 => __('Wednesday', 'timed-content'),
            4 => __('Thursday', 'timed-content'),
            5 => __('Friday', 'timed-content'),
            6 => __('Saturday', 'timed-content')
        );

        $this->rule_ordinal_array = array(
            0 => __('first', 'timed-content'),
            1 => __('second', 'timed-content'),
            2 => __('third', 'timed-content'),
            3 => __('fourth', 'timed-content'),
            4 => __('last', 'timed-content')
        );

        $this->rule_ordinal_days_array = array(
            0 => __('Sunday', 'timed-content'),
            1 => __('Monday', 'timed-content'),
            2 => __('Tuesday', 'timed-content'),
            3 => __('Wednesday', 'timed-content'),
            4 => __('Thursday', 'timed-content'),
            5 => __('Friday', 'timed-content'),
            6 => __('Saturday', 'timed-content'),
            7 => __('day', 'timed-content')
        );

        $this->jquery_ui_datetime_datepicker_i18n = array(
            "closeText" => _x( "Done", "jQuery UI Datepicker Close label", "timed-content" ), // Display text for close link
            "prevText" => _x( "Prev", "jQuery UI Datepicker Previous label", "timed-content" ), // Display text for previous month link
            "nextText" => _x( "Next", "jQuery UI Datepicker Next label", "timed-content" ), // Display text for next month link
            "currentText" => _x( "Today", "jQuery UI Datepicker Today label", "timed-content" ), // Display text for current month link
            "weekHeader" => _x( "Wk", "jQuery UI Datepicker Week label", "timed-content" ), // Column header for week of the year
            // Replace the text indices for the following arrays with 0-based arrays
            "monthNames" => $this->stripArrayIndices( $wp_locale->month ), // Names of months for drop-down and formatting
            "monthNamesShort" => $this->stripArrayIndices( $wp_locale->month_abbrev ), // For formatting
            "dayNames" => $this->stripArrayIndices( $wp_locale->weekday ), // For formatting
            "dayNamesShort" => $this->stripArrayIndices( $wp_locale->weekday_abbrev ), // For formatting
            "dayNamesMin" => $this->stripArrayIndices( $wp_locale->weekday_initial ), // Column headings for days starting at Sunday
            "dateFormat" => 'yy-mm-dd',
            "firstDay" => get_option( 'start_of_week' ),
            "isRTL" => $wp_locale->is_rtl(),
            "showMonthAfterYear" => false, // True if the year select precedes month, false for month then year
            "yearSuffix" => '' // Additional text to append to the year in the month headers
        );

        $tf = get_option( 'time_format' );
        if ( false !== strpos( $tf, "A") ) {
            $this->meridiem = array($wp_locale->meridiem['AM'], $wp_locale->meridiem['PM']);
            $this->show_period = true;
            $this->show_period_labels = true;
            $this->show_leading_zero = false;
        } elseif ( false !== strpos( $tf, "a") ) {
            $this->meridiem = array($wp_locale->meridiem['am'], $wp_locale->meridiem['pm']);
            $this->show_period = true;
            $this->show_period_labels = true;
            $this->show_leading_zero = false;
        } else {
            $this->meridiem = array('', '');
            $this->show_period = false;
            $this->show_period_labels = false;
            $this->show_leading_zero = true;
        }

        $this->jquery_ui_datetime_timepicker_i18n = array(
            "hourText" => _x( "Hour", "jQuery UI Timepicker 'Hour' label", "timed-content" ),
            "minuteText" => _x( "Minute", "jQuery UI Timepicker 'Minute' label", "timed-content" ),
            "timeSeparator" => _x( ":", "jQuery UI Datepicker: Character used to separate hours and minutes in translated language", 'timed-content' ),
            "closeButtonText" => _x( "Done", "jQuery UI Timepicker 'Done' label", "timed-content" ),
            "nowButtonText" => _x( "Now", "jQuery UI Timepicker 'Now' label", "timed-content" ),
            "deselectButtonText" => _x( "Deselect", "jQuery UI Timepicker 'Deselect' label", "timed-content" ),
            "amPmText" => array('', ''),
            "showPeriod" => false,
            "showPeriodLabels" => false,
            "showLeadingZero" => false,
            "timeFormat" => 'G:i'
        );

        $this->timedContentRuleTypeInit();
        $this->setupCustomFields();
    }

    /**
     * Creates the Timed Content Rule post type and registers it with Wordpress
     */
    function timedContentRuleTypeInit()
    {
        $labels = array(
            'name'               => _x( 'Timed Content rules', 'post type general name', 'timed-content' ),
            'singular_name'      => _x( 'Timed Content rule', 'post type singular name', 'timed-content' ),
            'add_new'            => _x( 'Add new', 'Menu item/button label on Timed Content Rules admin page',
                'timed-content' ),
            'add_new_item'       => __( 'Add new Timed Content rule', 'timed-content' ),
            'edit_item'          => __( 'Edit Timed Content rule', 'timed-content' ),
            'new_item'           => __( 'New Timed Content rule', 'timed-content' ),
            'view_item'          => __( 'View Timed Content rule', 'timed-content' ),
            'search_items'       => __( 'Search Timed Content rules', 'timed-content' ),
            'not_found'          => __( 'No Timed Content rules found', 'timed-content' ),
            'not_found_in_trash' => __( 'No Timed Content rules found in trash', 'timed-content' ),
            'parent_item_colon'  => '',
            'menu_name'          => _x( 'Timed Content rules', 'post type general name', 'timed-content' )
        );
        $args   = array(
            'labels'              => $labels,
            'description'         => __( 'Create regular schedules to show or hide selected content in a page or post.',
                'timed-content' ),
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'query_var'           => false,
            'rewrite'             => false,
            'capability_type'     => 'post',
            'has_archive'         => false,
            'hierarchical'        => false,
            'menu_position'       => 5,
            'supports'            => array( 'title' )
        );
        register_post_type( TIMED_CONTENT_RULE_TYPE, $args );
    }


    /**
     * Fix for date_i18n() as suggested in https://core.trac.wordpress.org/ticket/25768
     *
     * Modified from the original patch to use the currently set timezone from PHP,
     * like PHP's date(), and to make the code more readable.
     *
     * @param      $j
     * @param      $req_format
     * @param bool $i
     * @param bool $gmt
     *
     * @return bool|string
     */
    function fix_date_i18n($j, $req_format, $i = false, $gmt = false)
    {
        global $wp_locale;
        global $post;

        $timestamp = $i;

        // get current timestamp if $i is false
        if (false === $timestamp) {
            if ($gmt) {
                $timestamp = time();
            } else {
                $timestamp = current_time( 'timestamp' );
            }

            // use debug parameter if current user is allowed to edit the post
            if (isset( $_GET['tctest'] ) && current_user_can("edit_post", $post->post_id)) {
                $dt = DateTime::createFromFormat('Y-m-d H:i:s', $_GET['tctest']);
                if ($dt != false) {
                    $timestamp = $dt->getTimestamp();
                }
            }
        }

        // get components of the date (timestamp) as array
        $date_components = getdate($timestamp);

        // numeric representation of a month, with leading zeros
        $date_month = $wp_locale->get_month($date_components['mon']);
        $date_month_abbrev = $wp_locale->get_month_abbrev($date_month);
        // numeric representation of the day of the week
        $date_weekday = $wp_locale->get_weekday($date_components['wday']);
        $date_weekday_abbrev = $wp_locale->get_weekday_abbrev($date_weekday);
        // get if hour is Ante meridiem or Post meridiem
        $meridiem = $date_components['hours'] >= 12 ? 'pm' : 'am';
        // lowercase Ante meridiem and Post meridiem hours
        $date_meridiem = $wp_locale->get_meridiem($meridiem);
        // uppercase Ante meridiem and Post meridiem
        $date_meridiem_capital = $wp_locale->get_meridiem(strtoupper($meridiem));

        // escape literals
        $date_weekday_abbrev   = backslashit($date_weekday_abbrev);
        $date_month            = backslashit($date_month);
        $date_weekday          = backslashit($date_weekday);
        $date_month_abbrev     = backslashit($date_month_abbrev);
        $date_meridiem         = backslashit($date_meridiem);
        $date_meridiem_capital = backslashit($date_meridiem_capital);

        // the translated format string
        $translated_date_format_string = '';
        // the 2 arrays map a format literal to its translation (e. g. 'F' to the escaped month translation)
        $translate_formats = array('D', 'F', 'l', 'M', 'a', 'A', 'c', 'r');
        $translations      = array(
            $date_weekday_abbrev, // D
            $date_month, // F
            $date_weekday, // l
            $date_month_abbrev, // M
            $date_meridiem, // a
            $date_meridiem_capital, // A
            'Y-m-d\TH:i:sP', // c
            sprintf( '%s, d %s Y H:i:s O', $date_weekday_abbrev, $date_month_abbrev ), // r
        );

        // find each format literal that needs translation and replace it by its translation
        // respects the escaping
        // iterate $req_format from ending to beginning
        for ( $i = strlen( $req_format ) - 1; $i > - 1; $i -- ) {
            // test if current char is format literal that needs translation
            $translate_formats_index = array_search( $req_format[ $i ], $translate_formats );

            if ( $translate_formats_index !== false ) {
                // counts the slashes (the escape char) in front of the current char
                $slashes_counter = 0;

                // count all slashes left-hand side of the current char
                for ( $j = $i - 1; $j > - 1; $j -- ) {
                    if ( $req_format[ $j ] == '\\' ) {
                        $slashes_counter ++;
                    } else {
                        break;
                    }
                }

                // number of slashes is even
                if ( $slashes_counter % 2 == 0 ) // current char is not escaped, therefore it is a format literal
                {
                    $translated_date_format_string = $translations[ $translate_formats_index ] . $translated_date_format_string;
                } else // current char is escaped, therefore it is not a format literal, just add it unchanged
                {
                    $translated_date_format_string = $req_format[ $i ] . $translated_date_format_string;
                }
            } else // current char is no a format literal, just add it unchanged
            {
                $translated_date_format_string = $req_format[ $i ] . $translated_date_format_string;
            }
        }

        $req_format = $translated_date_format_string;

        if ($gmt) {
            // get GMT date string
            $date_formatted = gmdate( $req_format, $timestamp );
        } else {
            // get Wordpress time zone
            // $timezone_string = get_option('timezone_string');
            // Haha, just kidding. Let's get the currently set timezone, as God and Rasmus intended
            $timezone_string = date_default_timezone_get();

            if ($timezone_string) {
                // create time zone object
                $timezone_object = timezone_open( $timezone_string );
                // create date object from time zone object
                $local_date_object = date_create( null, $timezone_object );
                // set time and date of $local_date_object to $timestamp
                $date_components = isset( $date_components ) ? $date_components : getdate( $timestamp );
                date_date_set( $local_date_object, $date_components['year'], $date_components['mon'],
                    $date_components['mday'] );
                date_time_set( $local_date_object, $date_components['hours'], $date_components['minutes'],
                    $date_components['seconds'] );
                // format date according to the Wordpress time zone
                $date_formatted = date_format( $local_date_object, $req_format );
            } else {
                // fall back if no Wordpress time zone set
                $date_formatted = date( $req_format, $i );
            }
        }

        return $date_formatted;
    }

    /**
     * Filter to change sort order to title
     *
     * @param array $messages Array of currently defined messages for post types
     *
     * @return mixed            Array of messages with appropriate messages for Timed Content Rules added in
     */
    function timedContentPreGetPosts($query)
    {
        if ( $query->is_admin ) {
            if ( $query->get( 'post_type' ) == TIMED_CONTENT_RULE_TYPE ) {
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'ASC' );
            }
        }

        return $query;
    }

    /**
     * Filter to customize CRUD messages for Timed Content Rules
     *
     * @param array $messages Array of currently defined messages for post types
     *
     * @return mixed          Array of messages with appropriate messages for Timed Content Rules added in
     */
    function timedContentRuleUpdatedMessages($messages)
    {
        global $post;

        /* translators: date and time format to activate rule. http://ca2.php.net/manual/en/function.date.php*/
        $post_date = date_i18n( __( 'M j, Y @ G:i', 'timed-content' ), strtotime( $post->post_date ) );

        $messages[ TIMED_CONTENT_RULE_TYPE ] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => __( 'Timed Content Rule updated.', 'timed-content' ),
            2  => __( 'Custom field updated.', 'timed-content' ),
            3  => __( 'Custom field deleted.', 'timed-content' ),
            4  => __( 'Timed Content Rule updated.', 'timed-content' ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Timed Content Rule restored to revision from %s',
                'timed-content' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => __( 'Timed Content Rule published.', 'timed-content' ),
            7  => __( 'Timed Content Rule saved.', 'timed-content' ),
            8  => __( 'Timed Content Rule submitted.', 'timed-content' ),
            /* translators: %s: date and time to activate rule. */
            9  => sprintf( __( 'Timed Content Rule scheduled for: %s.', 'timed-content' ),
                "<strong>" . $post_date . "</strong>" ),
            10 => __( 'Timed Content Rule draft updated.', 'timed-content' )
        );

        return $messages;
    }

    function datetimeToEnglish( $date, $time = "" )
    {
        $months       = array(
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        );
        $monthsI18N   = array(
            __( "January", 'timed-content' ),
            __( "February", 'timed-content' ),
            __( "March", 'timed-content' ),
            __( "April", 'timed-content' ),
            __( "May", 'timed-content' ),
            __( "June", 'timed-content' ),
            __( "July", 'timed-content' ),
            __( "August", 'timed-content' ),
            __( "September", 'timed-content' ),
            __( "October", 'timed-content' ),
            __( "November", 'timed-content' ),
            __( "December", 'timed-content' )
        );
        $english_date = str_replace( $monthsI18N, $months, $date );

        return $english_date . " " . $time;
    }

    /**
     * Advances a date by a set number of days
     *
     * @param int $current             UNIX timestamp of the date before incrementing
     * @param int $interval_multiplier Number of days to advance
     *
     * @return int                     Unix timestamp of the new date
     */
    function getNextDay( $current, $interval_multiplier )
    {
        return strtotime( $interval_multiplier . " day", $current );
    }

    /**
     * Advances a date/time by a set number of hours
     *
     * @param int $current UNIX timestamp of the date/time before incrementing
     * @param int $interval_multiplier Number of hours to advance
     *
     * @return int Unix timestamp of the new date/time
     */
    function getNextHour( $current, $interval_multiplier )
    {
        return strtotime( $interval_multiplier . " hour", $current );
    }

    /**
     * Advances a date/time by a set number of weeks
     *
     * Advances a date/time by a set number of weeks.  If given an array of days of the week, this function will
     * advance the date/time to the next day in that array in the jumped-to week. Use this function if you're
     * repeating an action on specific days of the week (i.e., on Weekdays, Tuesdays and Thursdays, etc.).
     *
     * @param int $current             UNIX timestamp of the date before incrementing
     * @param int $interval_multiplier Number of weeks to advance
     * @param array $days              Array of integers symbolizing the days of the week to
     *                                 repeat on (0 - Sunday, 1 - Monday, ..., 6 - Saturday).
     *
     * @return int                     Unix timestamp of the new date
     */
    function getNextWeek( $current, $interval_multiplier, $days = array() )
    {
        // If $days is empty, advance $interval_multiplier weeks from $current and return the timestamp
        if ( empty( $days ) ) {
            return strtotime( $interval_multiplier . " week", $current );
        }

        // Otherwise, set up an array combining the days of the week to repeat on and the current day
        // (keys and values of the array will be the same, and the array is sorted)
        $currentDayOfWeekIndex = date( "w", $current );
        $days                  = array_merge( array( $currentDayOfWeekIndex ), $days );
        $days                  = array_unique( $days );
        $days                  = array_values( $days );
        sort( $days );
        $daysOfWeek = array_combine( $days, $days );

        // If the current day is the last one of the days of the week to repeat on, jump ahead to
        // the next week to be repeating on and get the earliest day in the array
        if ( $currentDayOfWeekIndex == max( $daysOfWeek ) ) {
            $pattern = ( ( 7 - $currentDayOfWeekIndex ) + ( 7 * ( $interval_multiplier - 1 ) ) + ( min( array_keys( $daysOfWeek ) ) ) ) . " day";
        } // Otherwise, cycle through the array until we find the next day to repeat on
        else {
            $nextDayOfWeekIndex = $currentDayOfWeekIndex;
            do {
            } while ( ! isset( $daysOfWeek[ ++ $nextDayOfWeekIndex ] ) );
            $pattern = ( $nextDayOfWeekIndex - $currentDayOfWeekIndex ) . " day";
        }

        return strtotime( $pattern, $current );
    }

    /**
     * Advances a date by a set number of months
     *
     * Advances a date by a set number of months.  When the date of the first active period lies
     * on the 29th, 30th, or 31st of the month, this function will return a date on the the last day
     * of the month for those months not containing those days.
     *
     * @param int $current             UNIX timestamp of the date before incrementing
     * @param int $start               UNIX timestamp of the first active period's date
     * @param int $interval_multiplier Number of months to advance
     *
     * @return int                     Unix timestamp of the new date
     */
    function getNextMonth( $current, $start, $interval_multiplier )
    {
        // For most days in the month, it's pretty easy. Get the day of month of the starting date.
        $startDay = date( "j", $start );

        // If it's before or on the 28th, just jump the number of months and be done with it.
        if ( $startDay <= 28 ) {
            return strtotime( $interval_multiplier . " month", $current );
        }

        // If it's on the 29th, 30th, or 31st, it gets tricky.  Some months don't have those days - so on those
        // months we need to repeat on the last day of the month instead, but we also need to jump back to the
        // correct day the following month. Let's say we want to repeat something on the 31st every month: this
        // is what we expect to see for a pattern:
        //
        //   .
        //   .
        //   .
        // December 31st
        // January 31st
        // February 28th
        // March 31st
        // April 30th
        //   .
        //   .
        //   .
        //
        // Unfortunately, PHP relative date handling isn't that smart (add "+1 month" to January 31st, and you
        // end up in March), so we'll have to figure it out ourselves by figuring out how many days to jump instead.

        // We'll need to calculate this for each interval and return the timestamp after the last jump.
        $temp_current = $current;
        for ( $i = 0; $i < $interval_multiplier; $i ++ ) {
            // The pattern for jumping will be different in each interval.
            /** @noinspection PhpUnusedLocalVariableInspection */
            $temp_pattern = "";

            // Get the month number of the current date.
            //$currentMonth = date( "n", $temp_current );

            // Get the number of days in the month of the current date.
            $lastDayThisMonth = date( "t", strtotime( "this month", $temp_current ) );

            // Get the number of days for the next month relative to the current date .
            // Subtract 3 days from the next month to counter known month skipping bugs in PHP's relative date
            // handling, that being the difference between the shortest possible month (non-leap February - 28 days)
            // and the longest (Jan., Mar., May, Jul., Aug., Oct., Dec. - 31 days).  This may be fixed in PHP 5.3.x
            // but this should be backwards-compatible anyway.
            $lastDayNextMonth = date( "t", strtotime( "-3 day next month", $temp_current ) );

            // If the current month is longer than next month, follow this block
            if ( $lastDayThisMonth > $lastDayNextMonth ) {
                // If we're repeating on the last day of this month, jump the number of days next month
                if ( $startDay == $lastDayThisMonth ) {
                    $temp_pattern = $lastDayNextMonth . " days";
                }
                // If the start day doesn't exist in the next month (i.e., no "31st" in June), jump the
                // number of days next month plus the difference between the start day and the number of days this month
                elseif ( $startDay > $lastDayNextMonth ) {
                    $temp_pattern = ( $lastDayThisMonth + $lastDayNextMonth - $startDay ) . " days";
                } // Otherwise, jump ahead the number of days in this month
                else {
                    $temp_pattern = $lastDayThisMonth . " days";
                }
            } // Or, if the current month is shorter than next month
            elseif ( $lastDayThisMonth < $lastDayNextMonth ) {
                // If the start day doesn't exist in this month (i.e., no "31st" in June), jump the
                // number of days next month plus the difference between the start day and the number of days this month
                if ( $startDay >= $lastDayThisMonth ) {
                    $temp_pattern = $startDay . " days";
                } // Otherwise, jump ahead the number of days in this month
                else {
                    $temp_pattern = $lastDayThisMonth . " days";
                }
            } // If the current month and next month are equally long, jumping by "1 month" is fine
            else {
                $temp_pattern = "1 month";
            }

            $temp_current = strtotime( $temp_pattern, $temp_current );
        }

        return $temp_current;

    }

    /**
     * Advances a date to the 'n'th weekday of the next month (eg., first Wednesday, third Monday, last Friday, etc.).
     *
     * NB: if $ordinal is set to '4' and $day is set to '7', it wil return the last day of the month.
     *
     * @param int $current UNIX timestamp of the date before incrementing
     * @param int $ordinal Integer symbolizing the ordinal (0 - first, 1 - second, 2 - third, 3 - fourth, 4 - last)
     * @param int $day     Integers symbolizing the days of the week to repeat on
     *                     (0 - Sunday, 1 - Monday, ..., 6 - Saturday, 7 - day).
     *
     * @return int         Unix timestamp of the new date
     */
    function getNthWeekdayOfMonth( $current, $ordinal, $day )
    {
        // First, get the month/year we need to work with
        $the_month        = date( "F", $current );
        $the_year         = date( "Y", $current );
        $lastDayThisMonth = date( "t", $current );

        // Get the time for the $current timestamp
        $current_time = date( "g:i A", $current );
        $the_day      = "";

        if ( $day == 7 ) { // If $day is "day of the month", get the day of month based on the ordinal
            switch ( $ordinal ) {
                case 0    :
                    $the_day = "1";
                    break;                    // First day of the month    //
                case 1    :
                    $the_day = "2";
                    break;                    // Second day of the month    //
                case 2    :
                    $the_day = "3";
                    break;                    // Third day of the month    //
                case 3    :
                    $the_day = "4";
                    break;                    // Fourth day of the month    //
                case 4    :
                    $the_day = $lastDayThisMonth;
                    break;    // Last day of the month    //
                default    :
                    $the_day = "1";
                    break;
            }
        } else {            // If $day is one of the days of the week...
            $day_range = array();
            switch ( $ordinal ) {    // ...get a 7-day range based on the ordinal...
                case 0    :
                    $day_range = range( 1, 7 );
                    break;                                        // First 7 days of the month    //
                case 1    :
                    $day_range = range( 8, 14 );
                    break;                                        // Second 7 days of the month    //
                case 2    :
                    $day_range = range( 15, 21 );
                    break;                                    // Third 7 days of the month    //
                case 3    :
                    $day_range = range( 22, 28 );
                    break;                                    // Fourth 7 days of the month    //
                case 4    :
                    $day_range = range( $lastDayThisMonth - 6, $lastDayThisMonth );
                    break;    // Last 7 days of the month        //
                default    :
                    $day_range = range( 1, 7 );
                    break;
            }
            foreach ( $day_range as $a_day ) { // ...and find the matching weekday in that range.
                if ( $day == date( "w", strtotime( $the_month . " " . $a_day . ", " . $the_year ) ) ) {
                    $the_day = $a_day;
                    break;
                }
            }
        }

        // Build the date string for the correct day and return its timestamp
        $pattern = $the_month . " " . $the_day . ", " . $the_year . ", " . $current_time;

        return strtotime( $pattern );

    }

    /**
     * Advances a date by a set number of years
     *
     * @param int $current             UNIX timestamp of the date before incrementing
     * @param int $interval_multiplier Number of years to advance
     *
     * @return int                     Unix timestamp of the new date
     */
    function getNextYear( $current, $interval_multiplier )
    {
        return strtotime( $interval_multiplier . " year", $current );
    }

    /**
     * Validates the various Timed Content Rule parameters and returns a series of error messages.
     *
     * @param $args  Array of Timed Content Rule parameters
     *
     * @return array Array of error messages
     */
    function validate( $args )
    {
        $errors = array();

        $instance_start = DateTime::createFromFormat('Y-m-d', $args['instance_start']['date']);
        if($instance_start != false) {
            $instance_start = $instance_start->getTimestamp();
        }
        $instance_end= DateTime::createFromFormat('Y-m-d', $args['instance_end']['date']);
        if($instance_end != false) {
            $instance_end = $instance_end->getTimestamp();
        }
        $end_date = DateTime::createFromFormat('Y-m-d', $args['end_date']);
        if($end_date != false) {
            $end_date = $end_date->getTimestamp();
        }

        if ($args['instance_start']['date'] == "") {
            $errors[] = __( "Starting date must not be empty.", 'timed-content' );
        }
        if ($args['instance_start']['time'] == "") {
            $errors[] = __("Starting time must not be empty.", 'timed-content');
        }
        if ($args['instance_end']['date'] == "") {
            $errors[] = __("Ending date must not be empty.", 'timed-content');
        }
        if ($args['instance_end']['time'] == "") {
            $errors[] = __("Ending time must not be empty.", 'timed-content');
        }
        if ($args['interval_multiplier'] == "") {
            $errors[] = __("Interval must not be empty.", 'timed-content');
        }
        if (! is_numeric($args['interval_multiplier'])) {
            $errors[] = __("Number of recurrences must be a number.", 'timed-content');
        }
        if (($args['num_repeat'] == "") && ($args['recurr_type'] == "recurrence_duration_num_repeat")) {
            $errors[] = __("Number of repetitions must not be empty.", 'timed-content');
        }
        if ((! is_numeric($args['num_repeat'])) && ($args['recurr_type'] == "recurrence_duration_num_repeat")) {
            $errors[] = __("Number of repetitions must be a number.", 'timed-content');
        }
        if (($args['end_date'] == "") && ($args['recurr_type'] == "recurrence_duration_end_date")) {
            $errors[] = __("End date must not be empty.", 'timed-content');
        }
        if (false === $args['instance_start']) {
            $errors[] = __("Starting date/time must be valid.", 'timed-content');
        }
        if (false === $args['instance_end']) {
            $errors[] = __("Ending date/time must be valid.", 'timed-content');
        }
        if ($instance_start > $instance_end) {
            $errors[] = __("Starting date/time must be before ending date/time.", 'timed-content');
        }
        if (($instance_end > $end_date) && ($args['recurr_type'] == "recurrence_duration_end_date")) {
            $errors[] = __("Recurrence end date must be after ending date/time.", 'timed-content');
        }

        return $errors;
    }

    /**
     * Calculates the active periods for a Timed Content Rule
     *
     * @param $args  Array of Timed Content Rule parameters
     *
     * @return array Array of active periods. Each value in the array describes an active period as an array itself
     *               with "start" and "end" keys and values that are either UNIX timestamps or human-readable dates,
     *               based on whether $args['human_readable'] is set to true or false.
     */
    function getRulePeriods( $args )
    {
        $active_periods = array();
        $period_count   = 0;

        $human_readable      = $args['human_readable'];
        $freq                = $args['freq'];
        $timezone            = $args['timezone'];
        $recurr_type         = $args['recurr_type'];
        $num_repeat          = intval( $args['num_repeat'] );
        $end_date            = $args['end_date'];
        $days_of_week        = $args['days_of_week'];
        $interval_multiplier = $args['interval_multiplier'];
        $instance_start_date = $args['instance_start']['date'];
        $instance_start_time = $args['instance_start']['time'];
        $instance_end_date   = $args['instance_end']['date'];
        $instance_end_time   = $args['instance_end']['time'];
        $monthly_pattern     = $args['monthly_pattern'];
        $monthly_pattern_ord = $args['monthly_pattern_ord'];
        $monthly_pattern_day = $args['monthly_pattern_day'];
        $exceptions_dates    = $args['exceptions_dates'];

        add_filter( 'date_i18n', array( &$this, "fix_date_i18n" ), 10, 4 );
        $temp_tz = date_default_timezone_get();
        date_default_timezone_set( $timezone );
        $right_now_t = current_time( 'timestamp', 1 );

        // use debug parameter if current user is allowed to edit the post
        if ( isset( $_GET['tctest'] ) && current_user_can( "edit_post", $post->post_id ) ) {
            $dt = DateTime::createFromFormat( 'Y-m-d H:i:s', $_GET['tctest'] );
            if ( $dt != false ) {
                $right_now_t = $dt->getTimestamp();
            }
        }

        $instance_start = strtotime( $this->datetimeToEnglish( $instance_start_date,
                $instance_start_time ) . " " . $timezone );    // Beginning of first occurrence
        $instance_end   = strtotime( $this->datetimeToEnglish( $instance_end_date,
                $instance_end_time ) . " " . $timezone );            // End of first occurrence
        $current        = $instance_start;
        $end_current    = $instance_end;

        if ( $recurr_type == "recurrence_duration_num_repeat" ) {
            $last_occurrence_start = strtotime( TIMED_CONTENT_TIME_END );
        } else {
            $last_occurrence_start = strtotime( $this->datetimeToEnglish( $end_date,
                    $instance_start_time ) . " " . $timezone );
        }

        if ( $recurr_type == "recurrence_duration_end_date" ) {
            $loop_test = "return ( \$current <= \$last_occurrence_start );";
        } else {
            $loop_test = "return ( \$period_count < \$num_repeat );";
        }

        while ( eval ( $loop_test ) ) {
            $exception_period = false;
            $current_date = date('Y-m-d', $current);
            if ( is_array( $exceptions_dates ) ) {
                foreach ( $exceptions_dates as $exceptions_date ) {
                    if (is_numeric($exceptions_date)) {
                        $exceptions_date = date('Y-m-d', $exceptions_date);
                    }
                    if ( $current_date === $exceptions_date ) {
                        $exception_period = true;
                        break;
                    }
                }
            }

            if ( ( eval ( $loop_test ) ) && ( ! ( $exception_period ) ) ) {
                $end_current = $current + ( $instance_end - $instance_start );
                if ( $human_readable == true ) {
                    $active_periods[ $period_count ]["start"] = date_i18n( TIMED_CONTENT_DATE_FORMAT_OUTPUT, $current );
                    $active_periods[ $period_count ]["end"]   = date_i18n( TIMED_CONTENT_DATE_FORMAT_OUTPUT, $end_current );
                    if ( $right_now_t < $current ) {
                        $active_periods[ $period_count ]["status"] = "upcoming";
                        $active_periods[ $period_count ]["time"]   = sprintf( _x( '%s from now.',
                            'Human readable time difference', 'timed-content' ),
                            human_time_diff( $current, $right_now_t ) );
                    } elseif ( ( $current <= $right_now_t ) && ( $right_now_t <= $end_current ) ) {
                        $active_periods[ $period_count ]["status"] = "active";
                        $active_periods[ $period_count ]["time"]   = __( "Right now!", 'timed-content' );
                    } else {
                        $active_periods[ $period_count ]["status"] = "expired";
                        $active_periods[ $period_count ]["time"]   = sprintf( _x( '%s ago.',
                            'Human readable time difference', 'timed-content' ),
                            human_time_diff( $end_current, $right_now_t ) );
                    }
                } else {
                    $active_periods[ $period_count ]["start"] = $current;
                    $active_periods[ $period_count ]["end"]   = $end_current;
                }
                if ( ! ( $exception_period ) ) {
                    $period_count ++;
                }
            }

            if ( $freq == 0 ) {
                $current = $this->getNextHour( $current, $interval_multiplier );
            } elseif ( $freq == 1 ) {
                $current = $this->getNextDay( $current, $interval_multiplier );
            } elseif ( $freq == 2 ) {
                $current = $this->getNextWeek( $current, $interval_multiplier, $days_of_week );
            } elseif ( $freq == 3 ) {
                $current      = $this->getNextMonth( $current, $instance_start, $interval_multiplier );
                $temp_current = $current;
                if ( $monthly_pattern == "yes" ) {
                    $current = $this->getNthWeekdayOfMonth( $current, $monthly_pattern_ord,
                        $monthly_pattern_day );
                } else {
                    $current = $temp_current;
                }
            } elseif ( $freq == 4 ) {
                $current = $this->getNextYear( $current, $interval_multiplier );
            }
        }
        date_default_timezone_set( $temp_tz );
        remove_filter( 'date_i18n', array( &$this, "fix_date_i18n" ), 10, 4 );

        return $active_periods;
    }

    /**
     * Wrapper for calling timedContentPlugin::__getRulePeriods() by the ID of a Timed Content Rule
     *
     * @param int  $ID ID of the   Timed Content Rule
     * @param bool $human_readable If true, the active periods are returned as a human-readable date
     *                             as defined by the constant TIMED_CONTENT_DT_FORMAT_OUTPUT otherwise,
     *                             they are returned as UNIX timestamps.
     *
     * @return array               Array of active periods
     */
    function getRulePeriodsById( $ID, $human_readable = false )
    {
        if ( TIMED_CONTENT_RULE_TYPE != get_post_type( $ID ) ) {
            return array();
        }

        $prefix = TIMED_CONTENT_RULE_POSTMETA_PREFIX;
        $args   = array();

        $args['human_readable'] = (bool) $human_readable;
        $args['freq']           = get_post_meta( $ID, $prefix . 'frequency', true );
        $args['timezone']       = get_post_meta( $ID, $prefix . 'timezone', true );
        $args['recurr_type']    = get_post_meta( $ID, $prefix . 'recurrence_duration', true );
        $args['num_repeat']     = get_post_meta( $ID, $prefix . 'recurrence_duration_num_repeat', true );
        $args['end_date']       = get_post_meta( $ID, $prefix . 'recurrence_duration_end_date', true );
        $args['days_of_week']   = get_post_meta( $ID, $prefix . 'weekly_days_of_week_to_repeat', true );
        if ( $args['freq'] == 0 ) {
            $args['interval_multiplier'] = get_post_meta( $ID, $prefix . 'hourly_num_of_hours', true );
        }
        if ( $args['freq'] == 1 ) {
            $args['interval_multiplier'] = get_post_meta( $ID, $prefix . 'daily_num_of_days', true );
        }
        if ( $args['freq'] == 2 ) {
            $args['interval_multiplier'] = get_post_meta( $ID, $prefix . 'weekly_num_of_weeks', true );
        }
        if ( $args['freq'] == 3 ) {
            $args['interval_multiplier'] = get_post_meta( $ID, $prefix . 'monthly_num_of_months', true );
        }
        if ( $args['freq'] == 4 ) {
            $args['interval_multiplier'] = get_post_meta( $ID, $prefix . 'yearly_num_of_years', true );
        }
        $args['instance_start']      = get_post_meta( $ID, $prefix . 'instance_start', true );
        $args['instance_end']        = get_post_meta( $ID, $prefix . 'instance_end', true );
        $args['monthly_pattern']     = get_post_meta( $ID, $prefix . 'monthly_nth_weekday_of_month', true );
        $args['monthly_pattern_ord'] = get_post_meta( $ID, $prefix . 'monthly_nth_weekday_of_month_nth', true );
        $args['monthly_pattern_day'] = get_post_meta( $ID, $prefix . 'monthly_nth_weekday_of_month_weekday', true );

        $exceptions_dates = get_post_meta( $ID, $prefix . 'exceptions_dates' );
        if (false !== $exceptions_dates && isset($exceptions_dates[0]) && is_array($exceptions_dates[0])) {
            $args['exceptions_dates'] = $exceptions_dates[0];
        } else {
            $args['exceptions_dates'] = false;
        }

        $args = $this->convertDateTimeParametersToISO($args);

        return $this->getRulePeriods( $args );
    }

    /**
     * Wrapper for calling timedContentPlugin::__getRulePeriods() based on the contents of the form fields
     * of the Add Timed Content Rule and Edit Timed Content Rule screens. Output is sent to output as JSON
     */
    function timedContentPluginGetRulePeriodsAjax()
    {
        if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
            $prefix = TIMED_CONTENT_RULE_POSTMETA_PREFIX;
            $args   = array();

            $args['human_readable']      = ( ( ( isset( $_POST[ $prefix . 'human_readable' ] ) ) && ( $_POST[ $prefix . 'human_readable' ] == 'true' ) ) ? (bool) $_POST[ $prefix . 'human_readable' ] : false );
            $args['freq']                = $_POST[ $prefix . 'frequency' ];
            $args['timezone']            = $_POST[ $prefix . 'timezone' ];
            $args['recurr_type']         = $_POST[ $prefix . 'recurrence_duration' ];
            $args['num_repeat']          = $_POST[ $prefix . 'recurrence_duration_num_repeat' ];
            $args['end_date']            = $_POST[ $prefix . 'recurrence_duration_end_date' ];
            $args['days_of_week']        = ( isset( $_POST[ $prefix . 'weekly_days_of_week_to_repeat' ] ) ? $_POST[ $prefix . 'weekly_days_of_week_to_repeat' ] : array() );
            $args['interval_multiplier'] = $_POST[ $prefix . 'interval_multiplier' ];
            $args['instance_start']      = $_POST[ $prefix . 'instance_start' ];
            $args['instance_end']        = $_POST[ $prefix . 'instance_end' ];
            $args['monthly_pattern']     = $_POST[ $prefix . 'monthly_nth_weekday_of_month' ];
            $args['monthly_pattern_ord'] = $_POST[ $prefix . 'monthly_nth_weekday_of_month_nth' ];
            $args['monthly_pattern_day'] = $_POST[ $prefix . 'monthly_nth_weekday_of_month_weekday' ];
            $args['exceptions_dates']    = ( isset( $_POST[ $prefix . 'exceptions_dates' ] ) ? $_POST[ $prefix . 'exceptions_dates' ] : array() );

            $response = json_encode( $this->getRulePeriods( $args ) );

            // response output
            header( "Content-Type: application/json" );
            echo $response;
        }
        die();

    }

    /**
     * Returns a human-readable description of a Timed Content Rule
     *
     * @param $args   Array of Timed Content Rule parameters
     *
     * @return string Schedule description or warning, if the rule may not work properly
     */
    function getScheduleDescription( $args )
    {
        $interval_multiplier = 1;
        $desc                = "";

        $errors = $this->validate( $args );
        if ( $errors ) {
            $messages = "<div class=\"tcr-warning\">\n";
            $messages .= "<p class=\"heading\">" . __( "Warning!", 'timed-content' ) . "</p>\n";
            $messages .= "<p>" . __( "Some problems have been detected.  Although you can still publish this rule, it may not work the way you expect.", 'timed-content' ) . "</p>\n";
            $messages .= "<ul>\n";
            foreach ( $errors as $error ) {
                $messages .= "    <li>" . $error . "</li>\n";
            }
            $messages .= "</ul>\n";
            $messages .= "<p>" . __( "Check that all of the conditions for this rule are correct, and use <b>Show projected dates/times</b> to ensure your rule is working properly.", 'timed-content' ) . "</p>\n";
            $messages .= "</div>\n";

            return $messages;
        }

        if ( $args['action'] ) {
            $action = __( "Show the content", 'timed-content' );
        } else {
            $action = __( "Hide the content", 'timed-content' );
        }
        $freq                = $args['freq'];
        $timezone            = $args['timezone'];
        $recurr_type         = $args['recurr_type'];
        $num_repeat          = intval( $args['num_repeat'] );
        $end_date            = $args['end_date'];
        $days_of_week        = $args['days_of_week'];
        $interval_multiplier = $args['interval_multiplier'];
        $instance_start_date = $args['instance_start']['date'];
        $instance_start_time = $args['instance_start']['time'];
        $instance_end_date   = $args['instance_end']['date'];
        $instance_end_time   = $args['instance_end']['time'];
        $monthly_pattern     = $args['monthly_pattern'];
        $monthly_pattern_ord = $args['monthly_pattern_ord'];
        $monthly_pattern_day = $args['monthly_pattern_day'];
        $exceptions_dates    = $args['exceptions_dates'];

        $desc = sprintf( _x( '%1$s on %2$s @ %3$s until %4$s @ %5$s.',
            'Perform action (%1$s) from date/time of first active period (%2$s @ %3$s) until date/time of last active period (%4$s @ %5$s).',
            'timed-content' ), $action, $instance_start_date, $instance_start_time, $instance_end_date,
            $instance_end_time );

        if ( $freq == 0 ) {
            $desc .= "<br />" . sprintf( _n( 'Repeat this action every hour.', 'Repeat this action every %d hours.',
                    $interval_multiplier, 'timed-content' ), $interval_multiplier );
        } elseif ( $freq == 1 ) {
            $desc .= "<br />" . sprintf( _n( 'Repeat this action every day.', 'Repeat this action every %d days.',
                    $interval_multiplier, 'timed-content' ), $interval_multiplier );
        } elseif ( $freq == 2 ) {
            if ( ( $days_of_week ) && ( is_array( $days_of_week ) ) ) {
                $days      = array();
                $days_list = "";
                foreach ( $days_of_week as $v ) {
                    $days[] = $this->rule_days_array[ $v ];
                }
                switch ( count( $days ) ) {
                    case 1:
                        $days_list = sprintf( _x( '%1$s', 'List of one weekday', 'timed-content' ), $days[0] );
                        break;
                    case 2:
                        $days_list = sprintf( _x( '%1$s and %2$s', 'List of two weekdays', 'timed-content' ),
                            $days[0], $days[1] );
                        break;
                    case 3:
                        $days_list = sprintf( _x( '%1$s, %2$s and %3$s', 'List of three weekdays',
                            'timed-content' ), $days[0], $days[1], $days[2] );
                        break;
                    case 4:
                        $days_list = sprintf( _x( '%1$s, %2$s, %3$s and %4$s', 'List of four weekdays',
                            'timed-content' ), $days[0], $days[1], $days[2], $days[3] );
                        break;
                    case 5:
                        $days_list = sprintf( _x( '%1$s, %2$s, %3$s, %4$s and %5$s', 'List of five weekdays',
                            'timed-content' ), $days[0], $days[1], $days[2], $days[3], $days[4] );
                        break;
                    case 6:
                        $days_list = sprintf( _x( '%1$s, %2$s, %3$s, %4$s, %5$s and %6$s', 'List of six weekdays',
                            'timed-content' ), $days[0], $days[1], $days[2], $days[3], $days[4], $days[5] );
                        break;
                    case 7:
                        $days_list = sprintf( _x( '%1$s, %2$s, %3$s, %4$s, %5$s, %6$s and %7$s',
                            'List of all weekdays', 'timed-content' ), $days[0], $days[1], $days[2], $days[3],
                            $days[4], $days[5], $days[6] );
                        break;
                }
                if ( $interval_multiplier == 1 ) {
                    $desc .= "<br />" . sprintf( _x( 'Repeat this action every week on %s.',
                            'List the weekdays to repeat the rule when frequency is every week. %s is the list of weekdays.',
                            'timed-content' ), $days_list );
                } else {
                    $desc .= "<br />" . sprintf( _x( 'Repeat this action every %1$d weeks on %2$s.',
                            'List the weekdays to repeat the rule when frequency is every %1$d weeks. %2$s is the list of weekdays.',
                            'timed-content' ), $interval_multiplier, $days_list );
                }
            } else {
                $desc .= "<br />" . sprintf( _n( 'Repeat this action every week.',
                        'Repeat this action every %d weeks.', $interval_multiplier, 'timed-content' ),
                        $interval_multiplier );
            }

        } elseif ( $freq == 3 ) {
            if ( $monthly_pattern == "yes" ) {
                if ( $interval_multiplier == 1 ) {
                    $desc .= "<br />" . sprintf( _x( 'Repeat this action every month on the %1$s %2$s of the month.',
                            "Example: 'Repeat this action every month on the second Friday of the month.'",
                            'timed-content' ), $this->rule_ordinal_array[ $monthly_pattern_ord ],
                            $this->rule_ordinal_days_array[ $monthly_pattern_day ] );
                } else {
                    $desc .= "<br />" . sprintf( _x( 'Repeat this action every %1$d months on the %2$s %3$s of the month.',
                            "Example: 'Repeat this action every 2 months on the second Friday of the month.'",
                            'timed-content' ), $interval_multiplier,
                            $this->rule_ordinal_array[ $monthly_pattern_ord ],
                            $this->rule_ordinal_days_array[ $monthly_pattern_day ] );
                }
            } else {
                $desc .= "<br />" . sprintf( _n( 'Repeat this action every month.',
                        'Repeat this action every %d months.', $interval_multiplier, 'timed-content' ),
                        $interval_multiplier );
            }
        } elseif ( $freq == 4 ) {
            $desc .= "<br />" . sprintf( _n( 'Repeat this action every year.', 'Repeat this action every %d years.',
                    $interval_multiplier, 'timed-content' ), $interval_multiplier );
        }

        if ( $recurr_type == "recurrence_duration_num_repeat" ) {
            $desc .= "<br />" . sprintf( _n( 'This rule will be active for one recurrence.',
                    'This rule will be active for %d recurrences.', $num_repeat, 'timed-content' ), $num_repeat );
        } elseif ( $recurr_type == "recurrence_duration_end_date" ) {
            $desc .= "<br />" . sprintf( __( 'This rule will be active until %s.', 'timed-content' ), $end_date );
        }

        if ( ( $exceptions_dates ) && ( is_array( $exceptions_dates ) ) ) {
            sort( $exceptions_dates, SORT_NUMERIC );
            $exceptions_dates = array_unique( $exceptions_dates );
            if ( $exceptions_dates[0] == 0 ) {
                array_shift( $exceptions_dates );
            }
            if ( ! empty( $exceptions_dates ) ) {
                $desc .= "<br />" . sprintf( __( 'This rule will be inactive on the following dates: %s.',
                        'timed-content' ), join( ", ", $exceptions_dates ) );
            }
        }

        $desc .= "<br />" . sprintf( __( 'All times are in the %s timezone.', 'timed-content' ), $timezone );

        return $desc;
    }

    /**
     * Wrapper for calling timedContentPlugin::__getScheduleDescription() by the ID of a Timed Content Rule
     *
     * @param int $ID ID of the Timed Content Rule
     *
     * @return string
     */
    function getScheduleDescriptionById( $ID )
    {
        $defaults = array();

        foreach ( $this->rule_occurrence_custom_fields as $field ) {
            $defaults[ $field['name'] ] = $field['default'];
        }
        foreach ( $this->rule_pattern_custom_fields as $field ) {
            $defaults[ $field['name'] ] = $field['default'];
        }
        foreach ( $this->rule_recurrence_custom_fields as $field ) {
            $defaults[ $field['name'] ] = $field['default'];
        }
        foreach ( $this->rule_exceptions_custom_fields as $field ) {
            $defaults[ $field['name'] ] = $field['default'];
        }

        $prefix = TIMED_CONTENT_RULE_POSTMETA_PREFIX;
        $args   = array();

        $args['action']       = ( false === get_post_meta( $ID, $prefix . 'action',
            true ) ? $defaults['action'] : get_post_meta( $ID, $prefix . 'action', true ) );
        $args['freq']         = ( false === get_post_meta( $ID, $prefix . 'frequency',
            true ) ? $defaults['frequency'] : get_post_meta( $ID, $prefix . 'frequency', true ) );
        $args['timezone']     = ( false === get_post_meta( $ID, $prefix . 'timezone',
            true ) ? $defaults['timezone'] : get_post_meta( $ID, $prefix . 'timezone', true ) );
        $args['recurr_type']  = ( false === get_post_meta( $ID, $prefix . 'recurrence_duration',
            true ) ? $defaults['recurrence_duration'] : get_post_meta( $ID, $prefix . 'recurrence_duration',
            true ) );
        $args['num_repeat']   = ( false === get_post_meta( $ID, $prefix . 'recurrence_duration_num_repeat',
            true ) ? $defaults['recurrence_duration_num_repeat'] : get_post_meta( $ID,
            $prefix . 'recurrence_duration_num_repeat', true ) );
        $args['end_date']     = ( false === get_post_meta( $ID, $prefix . 'recurrence_duration_end_date',
            true ) ? $defaults['recurrence_duration_end_date'] : get_post_meta( $ID,
            $prefix . 'recurrence_duration_end_date', true ) );
        $args['days_of_week'] = ( false === get_post_meta( $ID, $prefix . 'weekly_days_of_week_to_repeat',
            true ) ? $defaults['weekly_days_of_week_to_repeat'] : get_post_meta( $ID,
            $prefix . 'weekly_days_of_week_to_repeat', true ) );
        if ( $args['freq'] == 0 ) {
            $args['interval_multiplier'] = ( false === get_post_meta( $ID, $prefix . 'hourly_num_of_hours',
                true ) ? $defaults['hourly_num_of_hours'] : get_post_meta( $ID, $prefix . 'hourly_num_of_hours',
                true ) );
        }
        if ( $args['freq'] == 1 ) {
            $args['interval_multiplier'] = ( false === get_post_meta( $ID, $prefix . 'daily_num_of_days',
                true ) ? $defaults['daily_num_of_days'] : get_post_meta( $ID, $prefix . 'daily_num_of_days',
                true ) );
        }
        if ( $args['freq'] == 2 ) {
            $args['interval_multiplier'] = ( false === get_post_meta( $ID, $prefix . 'weekly_num_of_weeks',
                true ) ? $defaults['weekly_num_of_weeks'] : get_post_meta( $ID, $prefix . 'weekly_num_of_weeks',
                true ) );
        }
        if ( $args['freq'] == 3 ) {
            $args['interval_multiplier'] = ( false === get_post_meta( $ID, $prefix . 'monthly_num_of_months',
                true ) ? $defaults['monthly_num_of_months'] : get_post_meta( $ID, $prefix . 'monthly_num_of_months',
                true ) );
        }
        if ( $args['freq'] == 4 ) {
            $args['interval_multiplier'] = ( false === get_post_meta( $ID, $prefix . 'yearly_num_of_years',
                true ) ? $defaults['yearly_num_of_years'] : get_post_meta( $ID, $prefix . 'yearly_num_of_years',
                true ) );
        }
        $args['instance_start']      = ( false === get_post_meta( $ID, $prefix . 'instance_start',
            true ) ? $defaults['instance_start'] : get_post_meta( $ID, $prefix . 'instance_start', true ) );
        $args['instance_end']        = ( false === get_post_meta( $ID, $prefix . 'instance_end',
            true ) ? $defaults['instance_end'] : get_post_meta( $ID, $prefix . 'instance_end', true ) );
        $args['monthly_pattern']     = ( false === get_post_meta( $ID, $prefix . 'monthly_nth_weekday_of_month',
            true ) ? $defaults['monthly_nth_weekday_of_month'] : get_post_meta( $ID,
            $prefix . 'monthly_nth_weekday_of_month', true ) );
        $args['monthly_pattern_ord'] = ( false === get_post_meta( $ID, $prefix . 'monthly_nth_weekday_of_month_nth',
            true ) ? $defaults['monthly_nth_weekday_of_month_nth'] : get_post_meta( $ID,
            $prefix . 'monthly_nth_weekday_of_month_nth', true ) );
        $args['monthly_pattern_day'] = ( false === get_post_meta( $ID,
            $prefix . 'monthly_nth_weekday_of_month_weekday',
            true ) ? $defaults['monthly_nth_weekday_of_month_weekday'] : get_post_meta( $ID,
            $prefix . 'monthly_nth_weekday_of_month_weekday', true ) );
        $exceptions_dates = get_post_meta( $ID, $prefix . 'exceptions_dates' );
        if (false !== $exceptions_dates && isset($exceptions_dates[0]) && is_array($exceptions_dates[0])) {
            $args['exceptions_dates'] = $exceptions_dates[0];
        } else {
            $args['exceptions_dates'] = $defaults['exceptions_dates'];
        }

        $args = $this->convertDateTimeParametersToISO( $args );

        return $this->getScheduleDescription( $args );
    }

    /**
     * Wrapper for calling timedContentPlugin::__getRulePeriods() based on the contents of the form fields
     * of the Add Timed Content Rule and Edit Timed Content Rule screens.  Output is sent to output as plain text
     */
    function timedContentPluginGetScheduleDescriptionAjax()
    {
        if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
            $prefix = TIMED_CONTENT_RULE_POSTMETA_PREFIX;
            $args   = array();

            $args['action']              = $_POST[ $prefix . 'action' ];
            $args['freq']                = $_POST[ $prefix . 'frequency' ];
            $args['timezone']            = $_POST[ $prefix . 'timezone' ];
            $args['recurr_type']         = $_POST[ $prefix . 'recurrence_duration' ];
            $args['num_repeat']          = $_POST[ $prefix . 'recurrence_duration_num_repeat' ];
            $args['end_date']            = $_POST[ $prefix . 'recurrence_duration_end_date' ];
            $args['days_of_week']        = ( isset( $_POST[ $prefix . 'weekly_days_of_week_to_repeat' ] ) ? $_POST[ $prefix . 'weekly_days_of_week_to_repeat' ] : array() );
            $args['interval_multiplier'] = $_POST[ $prefix . 'interval_multiplier' ];
            $args['instance_start']      = $_POST[ $prefix . 'instance_start' ];
            $args['instance_end']        = $_POST[ $prefix . 'instance_end' ];
            $args['monthly_pattern']     = $_POST[ $prefix . 'monthly_nth_weekday_of_month' ];
            $args['monthly_pattern_ord'] = $_POST[ $prefix . 'monthly_nth_weekday_of_month_nth' ];
            $args['monthly_pattern_day'] = $_POST[ $prefix . 'monthly_nth_weekday_of_month_weekday' ];
            $args['exceptions_dates']    = ( isset( $_POST[ $prefix . 'exceptions_dates' ] ) ? $_POST[ $prefix . 'exceptions_dates' ] : array() );

            $response = $this->getScheduleDescription( $args );

            // response output
            header( "Content-Type: text/plain" );
            echo $response;
        }
        die();
    }

    /**
     * Processes the [timed-content-client] shortcode.
     *
     * @param array $atts   Shortcode attributes
     * @param null $content Content inside the shortcode
     *
     * @return string       Processed output
     */
    function clientShowHTML( $atts, $content = null )
    {
        $show_attr = "";
        $hide_attr = "";
        extract( shortcode_atts( array( 'show' => '0:00:000', 'hide' => '0:00:000', 'display' => 'div' ), $atts ) );

        // Initialize show/hide arguments
        $s_min  = 0;
        $s_sec  = 0;
        $s_fade = 0;
        $h_min  = 0;
        $h_sec  = 0;
        $h_fade = 0;
        @list( $s_min, $s_sec, $s_fade ) = explode( ":", $show );
        @list( $h_min, $h_sec, $h_fade ) = explode( ":", $hide );

        if ( ( (int) $s_min + (int) $s_sec ) > 0 ) {
            $show_attr = "_show_" . $s_min . "_" . $s_sec . "_" . $s_fade;
        }
        if ( ( (int) $h_min + (int) $h_sec ) > 0 ) {
            $hide_attr = "_hide_" . $h_min . "_" . $h_sec . "_" . $h_fade;
        }

        $the_class = TIMED_CONTENT_SHORTCODE_CLIENT . $show_attr . $hide_attr;
        $the_tag   = ( $display == "div" ? "div" : "span" );

        $the_filter = "timed_content_filter";
        $the_filter = apply_filters( "timed_content_filter_override", $the_filter );

        $the_HTML = "<"
                    . $the_tag
                    . " class='"
                    . $the_class
                    . "'"
                    . ( ( $show_attr != "" ) ? " style='display: none;'" : "" ) . ">"
                    . str_replace( ']]>', ']]&gt;', apply_filters( $the_filter, $content ) )
                    . "</" . $the_tag . ">";

        return $the_HTML;
    }

    /**
     * Processes the [timed-content-server] shortcode.
     *
     * @param array $atts   Shortcode attributes
     * @param null $content Content inside the shortcode
     *
     * @return string       Processed output
     */
    function serverShowHTML( $atts, $content = null )
    {
        global $post;
        extract( shortcode_atts( array(
            'show'  => 0,
            'hide'  => 0,
            'debug' => 'false'
        ), $atts ) );

        // Get time and timezone object for "show" time
        $pos = strrpos( $show, ' ' );
        if ( $pos !== false ) {
            $show_time = substr( $show, 0, $pos );
            $show_tzname = substr( $show, $pos + 1 );
        } else {
            $show_time = $show;
            $show_tzname = date_default_timezone_get();
        }
        try {
            $show_tz = new DateTimeZone($show_tzname);
        } catch(Exception $e)  {
            $show_tz = new DateTimeZone('UTC');
        }

        // Create time and timezone object for "hide" time
        $pos = strrpos( $hide, ' ' );
        if ( $pos !== false ) {
            $hide_time = substr( $hide, 0, $pos );
            $hide_tzname = substr( $hide, $pos + 1 );
        } else {
            $hide_time = $hide;
            $hide_tzname = date_default_timezone_get();
        }
        try {
            $hide_tz = new DateTimeZone($hide_tzname);
        } catch(Exception $e)  {
            $hide_tz = new DateTimeZone('UTC');
        }

        // Try to parse date as ISO first
        $show_dt = DateTime::createFromFormat( 'Y-m-d G:i', $show_time, $show_tz);
        // Fallback to American format
        if ($show_dt === false) {
            $show_dt = DateTime::createFromFormat('m/d/Y G:i', $show_time, $show_tz);
        }

        if ( $show_dt !== false ) {
            $show_t = $show_dt->getTimeStamp();
        } else {
            // If nothing else worked so far, try strtotime()
            // as it was before version 2.50
            $show_t = strtotime($show);
            if($show_t === false) $show_t = 0;
            $show_dt = new DateTime();
            $show_dt->setTimeStamp($show_t);
            $show_dt->setTimezone($show_tz);
        }

        // Try to parse date as ISO first
        $hide_dt = DateTime::createFromFormat( 'Y-m-d G:i', $hide_time, $hide_tz);
        if ($hide_dt === false) {
            $hide_dt = DateTime::createFromFormat( 'm/d/Y G:i', $hide_time, $hide_tz);
        }
        if ( $hide_dt !== false ) {
            $hide_t = $hide_dt->getTimeStamp();
        } else {
            // If nothing else worked so far, try strtotime()
            // as it was before version 2.50
            $hide_t = strtotime($hide);
            if($hide_t === false) $hide_t = 0;
            $hide_dt = new DateTime();
            $hide_dt->setTimeStamp($hide_t);
            $hide_dt->setTimezone($hide_tz);
        }

        $right_now_t   = current_time( 'timestamp', 1 );
        $debug_message = "";

        // use debug parameter if current user is allowed to edit the post
        if ( isset( $_GET['tctest'] ) && current_user_can( "edit_post", $post->post_id ) ) {
            $dt = DateTime::createFromFormat( 'Y-m-d H:i:s', $_GET['tctest'] );
            if ( $dt != false ) {
                $right_now_t = $dt->getTimestamp();
            }
        }

        $the_filter = "timed_content_filter";
        $the_filter = apply_filters( "timed_content_filter_override", $the_filter );

        $show_content = false;
        if ( ( $show_t <= $right_now_t ) && ( $right_now_t <= $hide_t || $hide_t == 0 ) ) {
            $show_content = true;
        }

        if ( ( ( $debug == "true" ) || ( ( ! $show_content ) && ( $debug == "when_hidden" ) ) )
                && ( current_user_can( "edit_post", $post->post_id ) ) ) {
            add_filter( 'date_i18n', array( &$this, "fix_date_i18n" ), 10, 4 );
            $temp_tz = date_default_timezone_get();
            date_default_timezone_set( get_option( 'timezone_string' ) );

            $right_now = date_i18n( TIMED_CONTENT_DATE_FORMAT_OUTPUT, $right_now_t );

            if ( $show_t > $right_now_t ) {
                $show_diff_str = sprintf( _x( '%s from now.', 'Human readable time difference', 'timed-content' ),
                    human_time_diff( $show_t, $right_now_t ) );
            } else {
                $show_diff_str = sprintf( _x( '%s ago.', 'Human readable time difference', 'timed-content' ),
                    human_time_diff( $show_t, $right_now_t ) );
            }
            if ( $hide_t > $right_now_t ) {
                $hide_diff_str = sprintf( _x( '%s from now.', 'Human readable time difference', 'timed-content' ),
                    human_time_diff( $hide_t, $right_now_t ) );
            } else {
                $hide_diff_str = sprintf( _x( '%s ago.', 'Human readable time difference', 'timed-content' ),
                    human_time_diff( $hide_t, $right_now_t ) );
            }

            $debug_message = "<div class=\"tcr-warning\">\n";
            $debug_message .= "<p class=\"heading\">" . _x( "Notice", "Noun", 'timed-content' ) . "</p>\n";
            $debug_message .= "<p>" . sprintf( __( 'Debugging has been turned on for a %1$s shortcode on this post/page. Only website users who are currently logged in and can edit this post/page will see this.  To turn off this message, remove the %2$s attribute from the shortcode.',
                    'timed-content' ), "<code>[timed-content-server]</code>", "<code>debug</code>" ) . "</p>\n";

            if ( $show_t === 0 ) {
                $debug_message .= "<p>" . sprintf( __( 'The %s attribute is not set or invalid.', 'timed-content' ),
                        "<code>show</code>" ) . "</p>\n";
            } else {
                $debug_message .= "<p>" . sprintf( __( 'The %s attribute is currently set to', 'timed-content' ),
                        "<code>show</code>" ) . ": " . $show . ",<br />\n "
                                  . __( 'The Timed Content plugin thinks the intended date/time is',
                        'timed-content' ) . ": " . $show_dt->format( TIMED_CONTENT_DATE_FORMAT_OUTPUT)
                                  . " (" . $show_diff_str . ")</p>\n";
            }

            if ( $hide === 0 ) {
                $debug_message .= "<p>" . sprintf( __( 'The %s attribute is not set or invalid.', 'timed-content' ),
                        "<code>hide</code>" ) . "</p>\n";
            } else {
                $debug_message .= "<p>" . sprintf( __( 'The %s attribute is currently set to', 'timed-content' ),
                        "<code>hide</code>" ) . ": " . $hide . ",<br />\n"
                                  . __( 'The Timed Content plugin thinks the intended date/time is',
                        'timed-content' ) . ": " . $hide_dt->format(TIMED_CONTENT_DATE_FORMAT_OUTPUT)
                                  . " (" . $hide_diff_str . ").</p>\n";
            }

            $debug_message .= "<p>" . __( 'Current date:',
                    'timed-content' ) . "&nbsp;" . $right_now . "</p>\n";
            $debug_message .= "<p>" . __( 'Content filter:', 'timed-content' ) . "&nbsp;" . $the_filter . "</p>\n";
            $debug_message .= "<p>" . _x( 'Content:', "Noun", 'timed-content' ) . "</p><p>" . $content . "</p>\n";

            if ( $show_content === true ) {
                $debug_message .= "<p>" . __( 'The plugin will show the content.', 'timed-content' ) . "</p>";
            } else {
                $debug_message .= "<p>" . __( 'The plugin will hide the content.', 'timed-content' ). "</p>";
            }

            $debug_message .= "</div>\n";

            date_default_timezone_set( $temp_tz );
            remove_filter( 'date_i18n', array( &$this, "fix_date_i18n" ), 10, 4 );
        }

        if ( $show_content === true ) {
            do_action( "timed_content_server_show", $post->ID, $show, $hide, $content );

            return $debug_message . str_replace( ']]>', ']]&gt;', apply_filters( $the_filter, $content ) ) . "\n";
        } else {
            do_action( "timed_content_server_hide", $post->ID, $show, $hide, $content );

            return $debug_message . "\n";
        }

    }

    /**
     * Processes the [timed-content-rule] shortcode.
     *
     * @param array $atts   Shortcode attributes
     * @param null $content Content inside the shortcode
     *
     * @return string       Processed output
     */
    function rulesShowHTML( $atts, $content = null )
    {
        global $post;
        extract( shortcode_atts( array( 'id' => 0 ), $atts ) );
        if ( ! is_numeric( $id ) ) {
            $page = get_page_by_title( $id, OBJECT, TIMED_CONTENT_RULE_TYPE );
            if ( $page == null ) {
                return;
            }
            $id = $page->ID;
        }
        if ( TIMED_CONTENT_RULE_TYPE != get_post_type( $id ) ) {
            return;
        }

        $prefix         = TIMED_CONTENT_RULE_POSTMETA_PREFIX;
        $right_now_t    = current_time( 'timestamp', 1 );
        $rule_is_active = false;

        // use debug parameter if current user is allowed to edit the post
        if ( isset( $_GET['tctest'] ) && current_user_can( "edit_post", $post->post_id ) ) {
            $dt = DateTime::createFromFormat( 'Y-m-d H:i:s', $_GET['tctest'] );
            if ( $dt != false ) {
                $right_now_t = $dt->getTimestamp();
            }
        }

        $active_periods = $this->getRulePeriodsById( $id, false );
        $action_is_show = (bool) get_post_meta( $id, $prefix . 'action', true );

        foreach ( $active_periods as $period ) {
            if ( ( $period['start'] <= $right_now_t ) && ( $right_now_t <= $period['end'] ) ) {
                $rule_is_active = true;
                break;
            }
        }

        $the_filter = "timed_content_filter";
        $the_filter = apply_filters( "timed_content_filter_override", $the_filter );

        if ( ( ( $rule_is_active == true ) && ( $action_is_show == true ) ) || ( ( $rule_is_active == false ) && ( $action_is_show == false ) ) ) {
            do_action( "timed_content_rule_show", $post->ID, $id, $content );

            return str_replace( ']]>', ']]&gt;', apply_filters( $the_filter, $content ) );
        } else {
            do_action( "timed_content_rule_hide", $post->ID, $id, $content );

            return "";
        }
    }

    /**
     * Enqueues the JavaScript code necessary for the functionality of the [timed-content-client] shortcode.
     */
    function addHeaderCode()
    {
        if ( ! is_admin() ) {
            wp_enqueue_style( 'timed-content-css', TIMED_CONTENT_CSS, false, TIMED_CONTENT_VERSION );
            wp_enqueue_script( 'timed-content_js', TIMED_CONTENT_PLUGIN_URL . '/js/timed-content.js',
                array( 'jquery' ), TIMED_CONTENT_VERSION );
        }
    }

    /**
     * Enqueues the CSS code necessary for custom icons for the Timed Content Rules management screens
     * and the TinyMCE editor.  Echo'd to output.
     */
    function addPostTypeIcons()
    {
        wp_enqueue_style( 'timed-content-dashicons', TIMED_CONTENT_CSS_DASHICONS, false, TIMED_CONTENT_VERSION );
        ?>
        <style type="text/css" media="screen">
            #adminmenu #menu-posts-<?php echo TIMED_CONTENT_RULE_TYPE; ?>.menu-icon-post div.wp-menu-image:before {
                font-family: 'timed-content-dashicons' !important;
                content: '\e601';
            }

            #dashboard_right_now li.<?php echo TIMED_CONTENT_RULE_TYPE; ?>-count a:before {
                font-family: 'timed-content-dashicons' !important;
                content: '\e601';
            }

            .mce-i-timed_content:before {
                font: 400 24px/1 'timed-content-dashicons' !important;
                padding: 0;
                vertical-align: top;
                margin-left: -2px;
                padding-right: 2px;
                content: '\e601';
            }
        </style>
        <?php
    }

    /**
     * Enqueues the JavaScript code necessary for the functionality of the Timed Content Rules management screens.
     */
    function addAdminHeaderCode()
    {
        if ( ( isset( $_GET['post_type'] ) && $_GET['post_type'] == TIMED_CONTENT_RULE_TYPE )
             || ( isset( $post_type ) && $post_type == TIMED_CONTENT_RULE_TYPE )
             || ( isset( $_GET['post'] ) && get_post_type( $_GET['post'] ) == TIMED_CONTENT_RULE_TYPE ) ) {
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'timed-content-css', TIMED_CONTENT_CSS, false, TIMED_CONTENT_VERSION );
            // Enqueue the JavaScript file that manages the meta box UI
            wp_enqueue_script( 'timed-content-admin_js', TIMED_CONTENT_PLUGIN_URL . '/js/timed-content-admin.js',
                array( 'jquery' ), TIMED_CONTENT_VERSION );
            // Enqueue the JavaScript file that makes AJAX requests
            wp_enqueue_script( 'timed-content-ajax_js', TIMED_CONTENT_PLUGIN_URL . '/js/timed-content-ajax.js',
                array( 'jquery', 'thickbox' ), TIMED_CONTENT_VERSION );

            // Set up local variables used in the Admin JavaScript file
            wp_localize_script( 'timed-content-admin_js', 'timedContentRuleAdmin', array(
                'no_exceptions_label' => __( "- No exceptions set -", 'timed-content' )
            ) );

            // Set up local variables used in the AJAX JavaScript file
            wp_localize_script( 'timed-content-ajax_js', 'timedContentRuleAjax', array(
                'ajaxurl'               => admin_url( 'admin-ajax.php' ),
                'start_label'           => _x( 'Start',
                    'Scheduled Dates/Times dialog - Beginning of active period table header', 'timed-content' ),
                'end_label'             => _x( 'End',
                    'Scheduled Dates/Times dialog - End of active period table header', 'timed-content' ),
                'dialog_label'          => _x( 'Scheduled dates/times',
                    'Scheduled Dates/Times dialog - dialog header', 'timed-content' ),
                'button_loading_label'  => __( 'Calculating dates/times', 'timed-content' ),
                'button_finished_label' => __( 'Show projected dates/times', 'timed-content' ),
                'dialog_width'          => 800,
                'dialog_height'         => 500,
                'error'                 => __( "Error", 'timed-content' ),
                'error_desc'            => __( "Something unexpected has happened along the way. The specific details are below:",
                'timed-content' )
            ) );
        }
    }

    /**
     * Initializes the TinyMCE plugin bundled with this Wordpress plugin
     *
     * @return void
     */
    function initTinyMCEPlugin()
    {
        if ( ( ! current_user_can( 'edit_posts' ) ) && ( ! current_user_can( 'edit_pages' ) ) ) {
            return;
        }

        // Add only in Rich Editor mode
        if ( get_user_option( 'rich_editing' ) == 'true' ) {
            add_filter( "mce_external_plugins", array( &$this, "addTimedContentTinyMCEPlugin" ) );
            add_filter( "mce_buttons", array( &$this, "registerTinyMCEButton" ) );
        }
    }

    /**
     * Sets up variables to use in the TinyMCE plugin's plugin.js.
     *
     * @return void
     */
    function setTinyMCEPluginVars()
    {
        global $wp_version;
        if ( ( ! current_user_can( 'edit_posts' ) ) && ( ! current_user_can( 'edit_pages' ) ) ) {
            return;
        }

        // Add only in Rich Editor mode
        if ( get_user_option( 'rich_editing' ) == 'true' ) {
            if ( version_compare( $wp_version, "3.8", "<" ) ) {
                $image = "/clock.gif";
            } else {
                $image = "";
            }
            wp_localize_script( 'editor',
                'timedContentAdminTinyMCEOptions',
                array(
                    'version' => TIMED_CONTENT_VERSION,
                    'desc'    => __( "Add Timed Content shortcodes", 'timed-content' ),
                    'image'   => $image
                ) );
        }
    }

    /**
     * Sets up the button for the associated TinyMCE plugin for use in the editor menubar.
     *
     * @param array $buttons Array of menu buttons already registered with TinyMCE
     *
     * @return array         The array of TinyMCE menu buttons with ours now loaded in as well
     */
    function registerTinyMCEButton( $buttons )
    {
        array_push( $buttons, "|", "timed_content" );

        return $buttons;
    }

    /**
     * Loads the associated TinyMCE plugin into TinyMCE's plugin array
     *
     * @param array $plugin_array Array of plugins already registered with TinyMCE
     *
     * @return array                The array of TinyMCE plugins with ours now loaded in as well
     */
    function addTimedContentTinyMCEPlugin( $plugin_array )
    {
        $plugin_array['timed_content'] = TIMED_CONTENT_PLUGIN_URL . "/tinymce_plugin/plugin.js";

        return $plugin_array;
    }

    /**
     * Generates JavaScript array of objects describing Timed Content rules.  Used in the dialog box created by
     * timedContentPlugin::timedContentPluginGetTinyMCEDialog().
     *
     * @return string JavaScript array describing the Timed Content rules
     */
    function getRulesJS()
    {
        $the_js    = "var rules = [\n";
        $args      = array(
            'post_type'      => TIMED_CONTENT_RULE_TYPE,
            'posts_per_page' => - 1,
            'post_status'    => 'publish'
        );
        $the_rules = get_posts( $args );
        foreach ( $the_rules as $rule ) {
            $desc = $this->getScheduleDescriptionById( $rule->ID );
            $desc = str_replace('<br />', ' ', $desc);
            // Only add a rule if there's no errors or warnings
            if ( false === strpos( $desc, "tcr-warning" ) ) {
                $the_js .= "    { 'ID': " . $rule->ID . ", 'title': '" . esc_js( ( ( strlen( $rule->post_title ) > 0 ) ? $rule->post_title : _x( "(no title)",
                        "No Timed Content Rule title",
                        "timed-content" ) ) ) . "', 'desc': '" . esc_js( $desc ) . "' },\n";
            }
        }
        if ( empty( $the_rules ) ) {
            $the_js .= "    { 'ID': -999, 'title': ' ---- ', 'desc': '" . __( 'No Timed Content Rules found',
                    'timed-content' ) . "' }\n";
        }

        $the_js .= "];\n";

        return $the_js;
    }

    /**
     * Display a dialog box for this plugin's associated TinyMCE plugin.  Called from TinyMCE via AJAX.
     *
     * @return void
     */
    function timedContentPluginGetTinyMCEDialog()
    {
        wp_enqueue_style( TIMED_CONTENT_SLUG . '-jquery-ui-css', TIMED_CONTENT_JQUERY_UI_CSS );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_register_style( TIMED_CONTENT_SLUG . '-jquery-ui-timepicker-css',
            TIMED_CONTENT_JQUERY_UI_TIMEPICKER_CSS );
        wp_enqueue_style( TIMED_CONTENT_SLUG . '-jquery-ui-timepicker-css' );
        wp_register_script( TIMED_CONTENT_SLUG . '-jquery-ui-timepicker-js', TIMED_CONTENT_JQUERY_UI_TIMEPICKER_JS,
            array( 'jquery', 'jquery-ui-datepicker' ), TIMED_CONTENT_VERSION );
        wp_enqueue_script( TIMED_CONTENT_SLUG . '-jquery-ui-timepicker-js' );
        if ( ! ( wp_script_is( TIMED_CONTENT_SLUG . '-jquery-ui-datetime-i18n-js', 'registered' ) ) ) {
            wp_register_script( TIMED_CONTENT_SLUG . '-jquery-ui-datetime-i18n-js',
                TIMED_CONTENT_PLUGIN_URL . "/js/timed-content-datetime-i18n.js",
                array( 'jquery', 'jquery-ui-datepicker', TIMED_CONTENT_SLUG . '-jquery-ui-timepicker-js' ),
                TIMED_CONTENT_VERSION );
            wp_enqueue_script( TIMED_CONTENT_SLUG . '-jquery-ui-datetime-i18n-js' );
            wp_localize_script( TIMED_CONTENT_SLUG . '-jquery-ui-datetime-i18n-js', 'TimedContentJQDatepickerI18n',
                $this->jquery_ui_datetime_datepicker_i18n );
            wp_localize_script( TIMED_CONTENT_SLUG . '-jquery-ui-datetime-i18n-js', 'TimedContentJQTimepickerI18n',
                $this->jquery_ui_datetime_timepicker_i18n );
        }

        ob_start();
        include( "tinymce_plugin/dialog.php" );
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
        die();
    }

    /**
     * Adds support for i18n (internationalization)
     *
     * @return void
     */
    function i18nInit()
    {
        $plugin_dir = basename( dirname( __FILE__ ) ) . "/lang/";
        load_plugin_textdomain( 'timed-content', false, $plugin_dir );
    }

    /**
     * Add custom columns to the Timed Content Rules overview page
     *
     * @return void
     */
    function addDescColumnHead( $defaults )
    {
        unset( $defaults['date'] );
        $defaults['description'] = __( 'Description', 'timed-content' );
        $defaults['shortcode']   = __( 'Shortcode', 'timed-content' );

        return $defaults;
    }

    /**
     * Display content associated with custom columns on the Timed Content rules overview page
     *
     * @param $column_name  Name of the column to be displayed
     * @param $post_ID      ID of the Timed Content Rule being listed
     */
    function addDescColumnContent( $column_name, $post_ID )
    {
        if ( $column_name == 'shortcode' ) {
            echo '<code>[' . TIMED_CONTENT_SHORTCODE_RULE . ' id="' . $post_ID . '"]...[/' . TIMED_CONTENT_SHORTCODE_RULE . ']</code>';
        }
        if ( $column_name == 'description' ) {
            $desc = $this->getScheduleDescriptionById( $post_ID );
            if ( $desc ) {
                echo '<em>' . $desc . '</em>';
            }
        }
    }

    /**
     * Display a count of Timed Content rules in the Dashboard's Right Now widget
     *
     * @return void
     */
    function addRulesCount() {
        if ( ! post_type_exists( TIMED_CONTENT_RULE_TYPE ) ) {
            return;
        }

        $num_posts = wp_count_posts( TIMED_CONTENT_RULE_TYPE );
        $num       = number_format_i18n( $num_posts->publish );
        $text      = _n( 'Timed Content rule', 'Timed Content rules', intval( $num_posts->publish ),
            'timed-content' );
        if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
            echo "<a href='edit.php?post_type=" . TIMED_CONTENT_RULE_TYPE . "'>"
                 . '<li class="' . TIMED_CONTENT_RULE_TYPE . '-count">'
                 . $num
                 . ' '
                 . $text
                 . '</a></li>';
        }

        if ( $num_posts->pending > 0 ) {
            $num  = number_format_i18n( $num_posts->pending );
            $text = _n( 'Timed Content rule pending', 'Timed Content rules pending', intval( $num_posts->pending ),
                'timed-content' );
            if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
                echo "<a href='edit.php?post_status=pending&post_type=" . TIMED_CONTENT_RULE_TYPE . "'>"
                     . '<li class="' . TIMED_CONTENT_RULE_TYPE . '-count">'
                     . $num
                     . ' '
                     . $text
                     . '</a></li>';
            }
        }
    }

    /**
     * Setup custom fields for Timed Content rules
     *
     * @return void
     */
    function setupCustomFields()
    {
        global $post;

        $now_ts = current_time( 'timestamp' );
        $now_plus1h_dt = new DateTime();
        $now_plus2h_dt = new DateTime();
        $now_plus1y_dt = new DateTime();
        $now_plus1h_dt->setTimeStamp($now_ts);
        $now_plus2h_dt->setTimeStamp($now_ts);
        $now_plus1y_dt->setTimeStamp($now_ts);
        $now_plus1h_dt->add(new DateInterval('PT1H'));
        $now_plus2h_dt->add(new DateInterval('PT2H'));
        $now_plus1y_dt->add(new DateInterval('P1Y'));

        $post_id = ( isset( $_GET['post'] ) && ( TIMED_CONTENT_RULE_TYPE === get_post_type( $_GET['post'] ) ) ? intval( $_GET['post'] ) : intval( 0 ) );
        $exceptions_dates = get_post_meta( $post_id, TIMED_CONTENT_RULE_POSTMETA_PREFIX . "exceptions_dates" );
        if (false !== $exceptions_dates && isset($exceptions_dates[0]) && is_array($exceptions_dates[0])) {
            $timed_content_rules_exceptions_dates = $exceptions_dates[0];
            sort( $timed_content_rules_exceptions_dates, SORT_NUMERIC );
            $timed_content_rules_exceptions_dates = array_unique( $timed_content_rules_exceptions_dates );

            // If the exceptions are stored as timestamps, convert them to ISO first
            $num = 0;
            while ($num<count($timed_content_rules_exceptions_dates)) {
                if (is_numeric($timed_content_rules_exceptions_dates[$num])) {
                    $timed_content_rules_exceptions_dates[$num] = date('Y-m-d', $timed_content_rules_exceptions_dates[$num]);
                }
                $num++;
            }

            $timed_content_rules_exceptions_dates_array = array_combine($timed_content_rules_exceptions_dates, $timed_content_rules_exceptions_dates);
        } else {
            $timed_content_rules_exceptions_dates_array = array( "0" => __( "- No exceptions set -", 'timed-content' ) );
        }

        $this->rule_occurrence_custom_fields = array(
            array(
                "name"        => "action",
                "display"     => "block",
                "title"       => __( "Action", 'timed-content' ),
                "description" => __( "Sets the action to be performed when the rule is active.", 'timed-content' ),
                "type"        => "radio",
                "values"      => array(1 => __( "Show the content", 'timed-content' ),
                                       0 => __( "Hide the content", 'timed-content' ) ),
                "default"     => 1,
                "scope"       => array(TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "instance_start",
                "display"     => "block",
                "title"       => __( "Starting date/time", 'timed-content' ),
                "description" => __( "Sets the date and time for the beginning of the first active period for this rule.", 'timed-content' ),
                "type"        => "datetime",
                "default"     => array("date" => strftime('%Y-%m-%d', $now_plus1h_dt->getTimeStamp()),
                                       "time" => strftime('%H:%M', $now_plus1h_dt->getTimeStamp())),
                "scope"       => array(TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "instance_end",
                "display"     => "block",
                "title"       => __( "Ending date/time", 'timed-content' ),
                "description" => __( "Sets the date and time for the end of the first active period for this rule.", 'timed-content' ),
                "type"        => "datetime",
                "default"     => array("date" => strftime('%Y-%m-%d', $now_plus2h_dt->getTimeStamp()),
                                       "time" => strftime('%H:%M', $now_plus2h_dt->getTimeStamp())),
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "timezone",
                "display"     => "block",
                "title"       => __( "Timezone", 'timed-content' ),
                "description" => __( "Select the timezone you wish to use for this rule.", 'timed-content' ),
                "type"        => "timezone-list",
                "default"     => get_option( 'timezone_string' ),
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            )
        );

        $this->rule_pattern_custom_fields = array(
            array(
                "name"        => "frequency",
                "display"     => "block",
                "title"       => __( "Frequency", 'timed-content' ),
                "description" => __( "Sets the frequency at which the action should be repeated.", 'timed-content' ),
                "type"        => "list",
                "default"     => "1",
                "values"      => $this->rule_freq_array,
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "hourly_num_of_hours",
                "display"     => "none",
                "title"       => __( "Interval of recurrences", 'timed-content' ),
                "description" => __( "Repeat this action every X hours.", 'timed-content' ),
                "type"        => "number",
                "default"     => "1",
                "min"         => "1",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "daily_num_of_days",
                "display"     => "none",
                "title"       => __( "Interval of recurrences", 'timed-content' ),
                "description" => __( "Repeat this action every X days.", 'timed-content' ),
                "type"        => "number",
                "default"     => "1",
                "min"         => "1",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "weekly_num_of_weeks",
                "display"     => "none",
                "title"       => __( "Interval of recurrences", 'timed-content' ),
                "description" => __( "Repeat this action every X weeks.", 'timed-content' ),
                "type"        => "number",
                "default"     => "1",
                "min"         => "1",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "weekly_days_of_week_to_repeat",
                "display"     => "none",
                "title"       => __( "Repeat on the following days", 'timed-content' ),
                "description" => __( "Repeat this action on these days of the week <strong>instead</strong> of the day of week the starting date/time falls on.", 'timed-content' ),
                "type"        => "checkbox-list",
                "default"     => array(),
                "values"      =>  $this->rule_days_array,
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "monthly_num_of_months",
                "display"     => "none",
                "title"       => __( "Interval of recurrences", 'timed-content' ),
                "description" => __( "Repeat this action every X months.", 'timed-content' ),
                "type"        => "number",
                "default"     => "1",
                "min"         => "1",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "monthly_nth_weekday_of_month",
                "display"     => "none",
                "title"       => __( "Repeat on a specific weekday of the month", 'timed-content' ),
                "description" => __( "Repeat this action on a specific weekday of the month (for example, \"every third Tuesday\"). Check this box to select a pattern below.", 'timed-content' ),
                "type"        => "checkbox",
                "default"     => "no",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "monthly_nth_weekday_of_month_nth",
                "display"     => "none",
                "title"       => __( "Weekday ordinal", 'timed-content' ),
                "description" => __( "Select a value for week of the month (for example \"first\", \"second\", etc.).", 'timed-content' ),
                "type"        => "list",
                "default"     => 0,
                "values"      => $this->rule_ordinal_array,
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "monthly_nth_weekday_of_month_weekday",
                "display"     => "none",
                "title"       => __( "Day of the week", 'timed-content' ),
                "description" => __( "Select the day of week.", 'timed-content' ),
                "type"        => "list",
                "default"     => 0,
                "values"      =>  $this->rule_ordinal_days_array,
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "yearly_num_of_years",
                "display"     => "none",
                "title"       => __( "Interval of recurrences", 'timed-content' ),
                "description" => __( "Repeat this action every X years.", 'timed-content' ),
                "type"        => "number",
                "default"     => "1",
                "min"         => "1",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            )
        );

        $this->rule_recurrence_custom_fields = array(
            array(
                "name"        => "recurrence_duration",
                "display"     => "block",
                "title"       => __( "How often to repeat this action", 'timed-content' ),
                "description" => "",
                "type"        => "radio",
                "values"      =>  array("recurrence_duration_end_date" => __( "Keep repeating until a given date", 'timed-content' ),
                                        "recurrence_duration_num_repeat" => __( "Repeat a set number of times", 'timed-content' ) ),
                "default"     => "recurrence_duration_end_date",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "recurrence_duration_end_date",
                "display"     => "none",
                "title"       => __( "End Date", 'timed-content' ),
                "description" => __( "Using the settings above, repeat this action until this date.", 'timed-content' ),
                "type"        => "date",
                "default"     => strftime('%Y-%m-%d', $now_plus1y_dt->getTimeStamp()),
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            ),
            array(
                "name"        => "recurrence_duration_num_repeat",
                "display"     => "none",
                "title"       => __( "Number of repetitions", 'timed-content' ),
                "description" => __( "Using the settings above, repeat this action this many times.", 'timed-content' ),
                "type"        => "number",
                "default"     => "1",
                "min"         => "1",
                "scope"       => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"  => "edit_posts"
            )
        );

        $exceptions_dates_picker_on_select = <<<FUNC
onSelect: function (dateText, inst) {
                jQuery("#timed_content_rule_exceptions_dates option[value='0']" ).remove();
                jQuery("#timed_content_rule_exceptions_dates").append( '<option value="' + dateText + '">' + dateText + '</option>' );
                jQuery(this).val("");
                jQuery(this).trigger("change");
            },
FUNC;

        $this->rule_exceptions_custom_fields = array(
            array(
                "name"             => "exceptions_dates_picker",
                "display"          => "block",
                "title"            => __( "Add exception date:", 'timed-content' ),
                "description"      => __( "Select a date to add to the exception dates list.", 'timed-content' ),
                "type"             => "date",
                "default"          => "",
                "scope"            => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"       => "edit_posts",
                "custom_functions" => $exceptions_dates_picker_on_select
            ),
            array(
                "name"             => "exceptions_dates",
                "display"          => "block",
                "title"            => __( "Exception dates list", 'timed-content' ),
                "description"      => __( "Dates that this Timed Content rule will not be active.  Double-click on a date to remove it from the list.", 'timed-content' ),
                "type"             => "menu",
                "values"           => $timed_content_rules_exceptions_dates_array,
                "size"             => "10",
                "default"          => array(),
                "scope"            => array( TIMED_CONTENT_RULE_TYPE ),
                "capability"       => "edit_posts"
            )
        );

        $scf = new customFieldsInterface( "timed_content_rule_schedule",
            __( 'Rule description/schedule', 'timed-content' ),
            "<div id=\"schedule_desc\" style=\"font-style: italic; overflow-y: auto;\">"
            . ( isset( $_GET['post'] ) && ( TIMED_CONTENT_RULE_TYPE === get_post_type( $_GET['post'] ) ) ? $this->getScheduleDescriptionById( intval( $_GET['post'] ) ) : $this->getScheduleDescriptionById( intval( 0 ) ) )
            . "</div>"
            . "<div id=\"tcr-dialogHolder\" style=\"display:none;\"></div>"
            . "<div style=\"padding-top: 10px;\"><input type=\"button\" class=\"button button-primary\" id=\"timed_content_rule_test\" value=\"" . __( 'Show projected dates/times',
                'timed-content' ) . "\" /></div>",
            TIMED_CONTENT_RULE_POSTMETA_PREFIX,
            array( TIMED_CONTENT_RULE_TYPE ),
            array(),
            $this->jquery_ui_datetime_datepicker_i18n,
            $this->jquery_ui_datetime_timepicker_i18n);
        $ocf = new customFieldsInterface( "timed_content_rule_initial_event",
            __( 'Action/Initial Event', 'timed-content' ),
            __( 'Set the action to be taken and when it should first run.', 'timed-content' ),
            TIMED_CONTENT_RULE_POSTMETA_PREFIX,
            array( TIMED_CONTENT_RULE_TYPE ),
            $this->rule_occurrence_custom_fields,
            $this->jquery_ui_datetime_datepicker_i18n,
            $this->jquery_ui_datetime_timepicker_i18n);
        $pcf = new customFieldsInterface( "timed_content_rule_recurrence",
            __( 'Repeating Pattern', 'timed-content' ),
            __( 'Set how often the action should repeat.', 'timed-content' ),
            TIMED_CONTENT_RULE_POSTMETA_PREFIX,
            array( TIMED_CONTENT_RULE_TYPE ),
            $this->rule_pattern_custom_fields,
            $this->jquery_ui_datetime_datepicker_i18n,
            $this->jquery_ui_datetime_timepicker_i18n );
        $rcf = new customFieldsInterface( "timed_content_rule_stop_condition",
            __( 'Stopping Condition', 'timed-content' ),
            __( 'Set how long or how many times the action should occur.', 'timed-content' ),
            TIMED_CONTENT_RULE_POSTMETA_PREFIX,
            array( TIMED_CONTENT_RULE_TYPE ),
            $this->rule_recurrence_custom_fields,
            $this->jquery_ui_datetime_datepicker_i18n,
            $this->jquery_ui_datetime_timepicker_i18n );
        $ecf = new customFieldsInterface( "timed_content_rule_exceptions",
            __( 'Exceptions', 'timed-content' ),
            __( 'Set up any exceptions to this Timed Content Rule.', 'timed-content' ),
            TIMED_CONTENT_RULE_POSTMETA_PREFIX,
            array( TIMED_CONTENT_RULE_TYPE ),
            $this->rule_exceptions_custom_fields,
            $this->jquery_ui_datetime_datepicker_i18n,
            $this->jquery_ui_datetime_timepicker_i18n );
    }

    /**
     * Strips indices from an array
     *
     * @param $ArrayToStrip
     *
     * @return array Processed array
     */
    function stripArrayIndices($ArrayToStrip)
    {
        foreach ($ArrayToStrip as $objArrayItem) {
            $NewArray[] = $objArrayItem;
        }

        return $NewArray;
    }

    /**
     * Convert dates and times to ISO format if needed
     *
     * @param array $args Existing date and time values
     *
     * @return array      Converted date values in ISO format
     */
    function convertDateTimeParametersToISO($args)
    {
        $date_parsed = date_create_from_format('Y-m-d', $args['instance_start']['date']);
        if ($date_parsed === false) {
            $date_source = strtotime($this->datetimeToEnglish($args['instance_start']['date']));
            $args['instance_start']['date'] = strftime('%Y-%m-%d', $date_source);
        }

        $date_parsed = date_create_from_format('Y-m-d', $args['instance_end']['date']);
        if ($date_parsed === false) {
            $date_source = strtotime($this->datetimeToEnglish($args['instance_end']['date']));
            $args['instance_end']['date'] = strftime('%Y-%m-%d', $date_source);
        }

        $args['instance_start']['time'] = $this->convertTimeToISO($args['instance_start']['time']);

        $args['instance_end']['time'] = $this->convertTimeToISO($args['instance_end']['time']);

        $date_parsed = date_create_from_format('Y-m-d', $args['end_date']);
        if ($date_parsed === false) {
            $date_source = strtotime($this->datetimeToEnglish($args['end_date']));
            $args['end_date'] = strftime('%Y-%m-%d', $date_source);
        }

        if( is_array($args['exceptions_dates'])) {
            foreach ($args['exceptions_dates'] as $key => $value) {
                $date_parsed = date_create_from_format('Y-m-d', $value);
                if ($date_parsed === false) {
                    $date_source = strtotime($this->datetimeToEnglish($args['end_date']));
                    $args['exceptions_dates'][$key] = strftime('%Y-%m-%d', $date_source);
                }
            }
        }

        return $args;
    }

    /**
     * Convert time to ISO format if needed
     *
     * @param string $time Existing time value
     *
     * @return string      Converted time values in ISO format
     */
    function convertTimeToISO($time) {
        if (strpos($time, 'AM') !== false) {
            $time_base = trim(substr($time, 0, strlen($time)-2));
            $time_dt = date_create_from_format('G:i', $time_base);
            if($time_dt !== false) {
                $time = strftime('%H:%M', $time_dt->getTimestamp());
            }
        } else if (strpos($time, 'PM') !== false) {
            $time_base = trim(substr($time, 0, strlen($time)-2));
            $time_dt = date_create_from_format('G:i', $time_base);
            if($time_dt !== false) {
                $time = strftime('%H:%M', $time_dt->getTimestamp() + 43200);
            }
        }

        return $time;
    }
}

// Initialize plugin
$timedContentPluginInstance = new timedContentPlugin();
?>