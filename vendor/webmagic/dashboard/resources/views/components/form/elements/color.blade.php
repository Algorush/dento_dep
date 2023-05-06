<input
        data-parent-wrap=".js_color-wrap"
        id="{{$id}}"
        class="{{$class}}"
        type="{{$type}}"
        value="{{$value ? $value : old($name)}}"
        name="{{$name}}"
        @if($required) required="required" @endif
        {!! $dynamic_fields !!}
/>
<div class="position-relative js_color-wrap"></div>