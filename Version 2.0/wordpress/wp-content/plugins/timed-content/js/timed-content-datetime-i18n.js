/* 	I18n initialization for the JQuery UI Datepicker plugin. 
	
	We feed strings in from the main 'timed-content.php' file so that translators can provide the localized 
	versions from the corresponding .POT file.  We don't expect them to become developers in order to
	provide translations. :)
*/
jQuery(function($){
    $.datepicker.regional['timed-content-i18n'] = {
        closeText: TimedContentJQDatepickerI18n.closeText,
        prevText: TimedContentJQDatepickerI18n.prevText,
        nextText: TimedContentJQDatepickerI18n.nextText,
        currentText: TimedContentJQDatepickerI18n.currentText,
        monthNames: TimedContentJQDatepickerI18n.monthNames,
        monthNamesShort: TimedContentJQDatepickerI18n.monthNamesShort,
        dayNames: TimedContentJQDatepickerI18n.dayNames,
        dayNamesShort: TimedContentJQDatepickerI18n.dayNamesShort,
        dayNamesMin: TimedContentJQDatepickerI18n.dayNamesMin,
        weekHeader: TimedContentJQDatepickerI18n.weekHeader,
        dateFormat: TimedContentJQDatepickerI18n.dateFormat,
        firstDay: TimedContentJQDatepickerI18n.firstDay,
        isRTL: TimedContentJQDatepickerI18n.isRTL,
        showMonthAfterYear: TimedContentJQDatepickerI18n.showMonthAfterYear,
        yearSuffix: TimedContentJQDatepickerI18n.yearSuffix	};
    $.datepicker.setDefaults($.datepicker.regional['timed-content-i18n']);

    $.timepicker.regional['timed-content-i18n'] = {
        hourText: TimedContentJQTimepickerI18n.hourText,
        minuteText: TimedContentJQTimepickerI18n.minuteText,
        amPmText: TimedContentJQTimepickerI18n.amPmText,
        showPeriod: TimedContentJQTimepickerI18n.showPeriod,
        timeSeparator: TimedContentJQTimepickerI18n.timeSeparator,
        closeButtonText: TimedContentJQTimepickerI18n.closeButtonText,
        nowButtonText: TimedContentJQTimepickerI18n.nowButtonText,
        deselectButtonText: TimedContentJQTimepickerI18n.deselectButtonText };
    $.timepicker.setDefaults($.timepicker.regional['timed-content-i18n']);

});