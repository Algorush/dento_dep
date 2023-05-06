/**
 * SimpleDateTimePicker init (eonasdan-bootstrap-datetimepicker plugin)
 *
 * @param el - start Datetimepicker element
 */
import '../../../node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker';
let moment = require('moment');

export class SimpleDateTimePicker {
    constructor(elPicker){
        this.elPicker = $(elPicker)
    }
    /**
     * Initialize SimpleDateTimePicker
     */
    init() {
        /**
         * Add language by locale
         */
        moment.locale(app.locale)
        this.setOptions()
    }

    /**
     * Set default options for initialization element
     */
    setOptions() {
        let viewMode = $(this.elPicker).attr('data-view-mode');
        let viewHeaderFormat = $(this.elPicker).attr('data-header-format');
        let dateFormat = $(this.elPicker).attr('data-date-format');
        let minYear = $(this.elPicker).attr('data-min-year');
        let maxYear = $(this.elPicker).attr('data-max-year');
        let positionToolbarPlacement = $(this.elPicker).attr('data-toolbar-placement');
        let showWeeks = $(this.elPicker).attr('data-show-number-week');
        let positionHorizontal = $(this.elPicker).attr('data-position-horizontal');
        let positionVertical = $(this.elPicker).attr('data-position-vertical');
        let defaultOptions = {
            locale: app.locale,
            dayViewHeaderFormat: viewHeaderFormat ? viewHeaderFormat : 'MMMM YYYY',
            viewMode: viewMode ? viewMode : 'days',
            format: dateFormat ? dateFormat : 'YYYY/MM/DD',
            minDate: minYear ? moment(new Date(minYear), 'YYYY') : false,
            maxDate: maxYear ? moment(new Date(maxYear), 'YYYY') : false,
            sideBySide: true,
            toolbarPlacement: positionToolbarPlacement? positionToolbarPlacement : 'top',
            calendarWeeks: showWeeks === 'true' || showWeeks === true ? true : false,
            showTodayButton: true,
            allowInputToggle: true,
            showClear: true,
            showClose: true,
            focusOnShow: false,
            widgetPositioning: {
                horizontal: positionHorizontal ? positionHorizontal : 'auto',
                vertical: positionVertical ? positionVertical : 'auto'
            },
            tooltips: {
                today: app.translate.calendarToday,
                clear: app.translate.calendarClear,
                close: app.translate.calendarClose,
                selectMonth: app.translate.calendarSelectMonth,
                prevMonth: app.translate.calendarPrevMonth,
                nextMonth: app.translate.calendarNextMonth,
                selectYear: app.translate.calendarSelectYear,
                prevYear: app.translate.calendarPrevYear,
                nextYear: app.translate.calendarNextYear,
                selectDecade: app.translate.calendarSelectDecade,
                prevDecade: app.translate.calendarPrevDecade,
                nextDecade: app.translate.calendarNextDecade,
                prevCentury: app.translate.calendarPrevCentury,
                nextCentury: app.translate.calendarNextCentury
            }
        }
        $(this.elPicker).datetimepicker(defaultOptions)
    }
}
