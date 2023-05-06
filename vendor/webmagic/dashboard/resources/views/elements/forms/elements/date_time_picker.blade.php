{{-- View for \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker --}}
<div
    id="{{$id}}"
    class="input-group js_datetime_picker-blk" {!!  $dynamic_fields !!}>
    <input type="text"
           name="{{$name}}"
           class="form-control js_datetime_picker"
           data-time={{ $time ? "true" : "false" }}
           data-24-hour={{$time24format ? "true" : "false"}}
           data-seconds={{$seconds ? "true" : "false"}}
           data-date={{ $date ? "true" : "false" }}
           data-single={{ $range ? "false" : "true" }}
           data-ranges={{ $default_ranges ? "true" : "false"}}
           data-format="{{$js_date_format}}"
           data-show-dropdowns={{ $show_months_years_dropdown ? "true" : "false" }}
           data-dropdowns-down={{ $show_dropdowns_down ? "true" : "false" }}
           data-min-year={{ $min_year_for_dropdown }}
           data-max-year={{ $max_year_for_dropdown }}
           data-auto-apply={{ $auto_apply_date ? "true" : "false" }}
           value="{{$value}}"
           readonly
            @if($required) required @endif
    />
    @if($range)
    <div class="input-group-addon px-2">to</div>
    <input type="text" name="{{$name_end}}"
           class="form-control js_datetime_picker-end"
           readonly
           value="{{$value_end}}"
           @if($required_end) required @endif
    />
    @endif
</div>
