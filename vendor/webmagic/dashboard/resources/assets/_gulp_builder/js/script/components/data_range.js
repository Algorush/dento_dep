/**
 * Range date picker init
 *
 * @param elStart - start date range picker element
 * @param elEnd - end date range picker element
 */
let moment = require('moment');
import '../../../node_modules/bootstrap-daterangepicker/daterangepicker';
import { controls } from './controls.js';

export class Datatime_picker {

    constructor(wrapRange){
        this.wrapRange = $(wrapRange);
    }

    /**
     * initialize data time picker
     */
    init(){
        let _this = this;
        /**
         * Add language by locale
         */
        moment.locale(app.locale);

        /**
         * Current data for date, time and calendar
         */
        let currTime = $(_this.wrapRange).data('time'); // add time
        let currSeconds = $(_this.wrapRange).data('seconds'); // add seconds
        let currFormat = $(_this.wrapRange).data('format'); // add date format
        let currSingle = $(_this.wrapRange).data('single'); // add one calendar
        let currRanges = $(_this.wrapRange).data('ranges'); // add left ranges
        let curr24Hour = $(_this.wrapRange).data('24-hour'); // add AM/PM time
        let currShowDropdowns = $(_this.wrapRange).data('show-dropdowns'); // add dropdowns with month and year
        let currPositionDrops = $(_this.wrapRange).data('dropdowns-down'); // add position dropdowns
        let currMinYear = $(_this.wrapRange).data('min-year'); // add min year for dropdown
        let currMaxYear = $(_this.wrapRange).data('max-year'); // add max year for dropdown
        let currAutoApply = $(_this.wrapRange).data('auto-apply'); // add auto apply date
        let currStartDate = $(_this.wrapRange).val();
        let currEndDate = $(_this.wrapRange).siblings('.js_datetime_picker-end').val();
        if ($(_this.wrapRange).val() ===  '') {
            $(_this.wrapRange).css('color', '#fff');
            currStartDate = moment().startOf('hour');
        }
        if(currEndDate ===  ''){
            currEndDate = moment().startOf('hour').add(32, 'hour');
        }

        /**
         * Default option
         */
        let options = {
            singleDatePicker: currSingle,
            timePicker: currTime,
            timePicker24Hour: curr24Hour,
            timePickerSeconds: currSeconds,
            autoUpdateInput: false,
            startDate: currStartDate,
            endDate: currEndDate,
            showDropdowns: currShowDropdowns,
            drops: currPositionDrops ? 'down' : 'up',
            minYear: currMinYear,
            maxYear: currMaxYear,
            autoApply: currAutoApply,
            // parentEl: $(_this.wrapRange).closest('.js_datetime_picker-blk'),
            language: moment.locale(app.locale),
            locale: {
                format: currFormat
            }
        };

        /**
         * Active ranges
         */
        if(currRanges != false) {

            options.ranges = {
                [app.translate.calendarOption1]: [moment().subtract(6, 'days'), moment()],
                [app.translate.calendarOption2]: [moment().subtract(13, 'days'), moment()],
                [app.translate.calendarOption3]: [moment().subtract(29, 'days'), moment()],
                [app.translate.calendarOption4]: [moment().subtract(89, 'days'), moment()],
                [app.translate.calendarOption5]: [moment().subtract(1, 'year').add(1,'day'), moment()],
                [app.translate.calendarOption6]: [moment().startOf('month'), moment().endOf('month')],
                //'All Time': [moment().subtract(30, 'years'),  moment()]
            };
        }

        $(_this.wrapRange).daterangepicker(options);

        /**
         * Add data into input's on change
         */
        $(_this.wrapRange).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format(currFormat));
            if ($(this).data('single', false)){
                $(this).css('color', '#555');
                $(this).siblings('.js_datetime_picker-end').val(picker.endDate.format(currFormat));
            }
        });

        /**
         * Hide calendar for time only active
         */
        $(_this.wrapRange).on('show.daterangepicker', function() {
            if($(this).data('date') === false){
                $(this).closest('.js_datetime_picker-blk').find('.calendar-table').hide();
            }
        });

        $(_this.wrapRange).on('cancel.daterangepicker', function() {
            $(this).val('');
            $(this).siblings('.js_datetime_picker-end').val('');
        });

        app.bodyEl.on('click', '.js_datetime_picker-end', function() {
            $(this).siblings('.js_datetime_picker').trigger( "click" );
        })
    }
}
