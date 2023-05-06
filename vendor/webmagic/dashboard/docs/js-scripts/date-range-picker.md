This functionality for choosing date ranges, dates and times for inputs - 
[Documentation](https://www.daterangepicker.com/).

### Activation functionality
* To the parent element, we add class **```'js_datetime_picker-blk'```**.
* Add the class to the first input **```'js_datetime_picker'```**.
* Add the class to the second input **```'js_datetime_picker-end'```** and attribute **disabled**.

##### Add date attributes for customization:

> All date attributes are assigned exclusively to the first input with class **```'js_datetime_picker'```**.

* **data-time** = _"true/false"_ - enable or disable time selection;
* **data-24-hour** = _"true/false"_ - use 24-hour instead of 12-hour times, removing the AM/PM selection;
* **data-seconds** = _"true/false"_ - enable or disable the ability to select seconds for time;
* **data-date** = _"true/false"_ - enable or disable date selection (display calendar or not);
* **data-single** = _"true/false"_ - enable or disable the ability to display only one calendar, if we work with only 
one date, you also need to remove the second input with the class **```'js_datetime_picker-end'```**;
* **data-ranges** = _"true/false"_ - enable or disable the ability to display suggested date ranges on the left;
* **data-format** = _"Y/M/DD H:mm:ss"_ - set the date format (year, month, day hours, minutes, seconds), respectively. 
To select only the date, use Y/M/DD, if you need only the time without the date, set H:mm:ss, the format can be changed 
as you like;
* **data-show-dropdowns** = _"true/false"_ - show year and month select boxes above calendars to jump to a specific 
month and year;
* **data-min-year** = _"number"_ - the minimum year shown in the dropdowns when showDropdowns is set to true, if the 
year is not specified, then the default will be 1921.
* **data-max-year** = _"number"_ - the maximum year shown in the dropdowns when showDropdowns is set to true, if the 
year is not specified, then the default will be 2121, if you specify the current year, then you need to specify plus 
one year, because then the choice of months does not work;
* **data-auto-apply** = _"true/false"_ - hide the apply and cancel buttons, and automatically apply a new date range as 
soon as two dates are clicked.

##### Example:
```html
<div id="inp-1" class="input-group js_datetime_picker-blk">
    <input type="text"
           name="date-start"
           class="form-control js_datetime_picker"
           data-time="true"
           data-24-hour="true"
           data-seconds="true"
           data-date="true"
           data-single="false"
           data-ranges="true"
           data-format="Y/MM/DD HH:mm:ss"
           data-show-dropdowns="true"
           data-min-year="1990"
           data-max-year="2022"
           data-auto-apply="false"
           value=""
           readonly
           required/>
    <div class="input-group-addon">to</div>
    <input type="text" name="date-end"
           class="form-control js_datetime_picker-end"
           disabled
           value=""
           required/>
</div>
```
