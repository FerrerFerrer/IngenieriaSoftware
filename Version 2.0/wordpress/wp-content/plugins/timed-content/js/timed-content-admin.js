jQuery(document).ready(function () {
    jQuery("select#timed_content_rule_frequency").change(function () {
        jQuery("select#timed_content_rule_frequency option:selected").each(function () {
            if (jQuery(this).val() == '0')
                jQuery("#timed_content_rule_hourly_num_of_hours_div").css("display", "block");
            else
                jQuery("#timed_content_rule_hourly_num_of_hours_div").css("display", "none");
            if (jQuery(this).val() == '1')
                jQuery("#timed_content_rule_daily_num_of_days_div").css("display", "block");
            else
                jQuery("#timed_content_rule_daily_num_of_days_div").css("display", "none");
            if (jQuery(this).val() == '2') {
                jQuery("#timed_content_rule_weekly_num_of_weeks_div").css("display", "block");
                jQuery("#timed_content_rule_weekly_days_of_week_to_repeat_div").css("display", "block");
            } else {
                jQuery("#timed_content_rule_weekly_num_of_weeks_div").css("display", "none");
                jQuery("#timed_content_rule_weekly_days_of_week_to_repeat_div").css("display", "none");
            }
            if (jQuery(this).val() == '3') {
                jQuery("#timed_content_rule_monthly_num_of_months_div").css("display", "block");
                jQuery("#timed_content_rule_monthly_nth_weekday_of_month_div").css("display", "block");
                // Check the 'timed_content_rule_monthly_nth_weekday_of_month' checkbox when first displayed...
                if (jQuery("#timed_content_rule_monthly_nth_weekday_of_month").prop("checked")) {
                    jQuery("#timed_content_rule_monthly_nth_weekday_of_month_nth_div").css("display", "block");
                    jQuery("#timed_content_rule_monthly_nth_weekday_of_month_weekday_div").css("display", "block");
                } else {
                    jQuery("#timed_content_rule_monthly_nth_weekday_of_month_nth_div").css("display", "none");
                    jQuery("#timed_content_rule_monthly_nth_weekday_of_month_weekday_div").css("display", "none");
                }
                // ...then watch it for changes.
                jQuery("#timed_content_rule_monthly_nth_weekday_of_month").change(function () {
                    if (jQuery(this).prop("checked")) {
                        jQuery("#timed_content_rule_monthly_nth_weekday_of_month_nth_div").css("display", "block");
                        jQuery("#timed_content_rule_monthly_nth_weekday_of_month_weekday_div").css("display", "block");
                    } else {
                        jQuery("#timed_content_rule_monthly_nth_weekday_of_month_nth_div").css("display", "none");
                        jQuery("#timed_content_rule_monthly_nth_weekday_of_month_weekday_div").css("display", "none");
                    }
                });
            } else {
                jQuery("#timed_content_rule_monthly_num_of_months_div").css("display", "none");
                jQuery("#timed_content_rule_monthly_nth_weekday_of_month_div").css("display", "none");
                jQuery("#timed_content_rule_monthly_nth_weekday_of_month_nth_div").css("display", "none");
                jQuery("#timed_content_rule_monthly_nth_weekday_of_month_weekday_div").css("display", "none");
            }
            if (jQuery(this).val() == '4')
                jQuery("#timed_content_rule_yearly_num_of_years_div").css("display", "block");
            else
                jQuery("#timed_content_rule_yearly_num_of_years_div").css("display", "none");
        })
    }).trigger("change");
    jQuery("input[name=timed_content_rule_recurrence_duration]").change(function () {
        if (jQuery("input[name=timed_content_rule_recurrence_duration]:checked").val() == "recurrence_duration_end_date") {
            jQuery("#timed_content_rule_recurrence_duration_end_date_div").css("display", "block");
            jQuery("#timed_content_rule_recurrence_duration_num_repeat_div").css("display", "none");
        } else {
            jQuery("#timed_content_rule_recurrence_duration_end_date_div").css("display", "none");
            jQuery("#timed_content_rule_recurrence_duration_num_repeat_div").css("display", "block");
        }
    }).trigger("change");timed_content_rule_exceptions_dates_picker

    jQuery("#timed_content_rule_exceptions_dates").on("dblclick", "option", function(){
        jQuery(this).remove();
        if (jQuery("#timed_content_rule_exceptions_dates option").length == 0 )
            jQuery("#timed_content_rule_exceptions_dates").append( '<option value="0">' + timedContentRuleAdmin.no_exceptions_label + '</option>' );
        jQuery("#timed_content_rule_exceptions_dates_picker").trigger("change");

    });
    jQuery("#publish").on("click", function() {
        jQuery("#timed_content_rule_exceptions_dates option[value='0']" ).remove();
        jQuery("#timed_content_rule_exceptions_dates option").attr("selected", "selected");
    });
});
