{{-- View for \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker --}}
<div
    id="{{$id}}"
    class="form-group datepicker" {!!  $dynamic_fields !!}
>
    <div class='input-group date js_simple_date_time_picker'
         data-view-mode="{{$view_mode}}"
         data-header-format="MMMM YYYY"
         data-date-format="{{$js_date_format}}"

         @if($min_year) data-min-year="{{$min_year}}" @endif
         @if($max_year) data-max-year="{{$max_year}}" @endif

         data-toolbar-placement="{{$toolbar_position}}"
         data-show-number-week="@json($show_week_number)"
         data-position-horizontal="{{$horizontal_position}}"
         data-position-vertical="{{$vertical_position}}">
        <input type='text' class="form-control"
               name="{{$name}}"
               value="{{$value}}"
               @if($required) required @endif
        />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>