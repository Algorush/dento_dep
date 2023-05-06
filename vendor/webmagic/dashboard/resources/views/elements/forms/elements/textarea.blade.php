<textarea
        id="{{$id}}"
        class="{{$class}}"
        name="{{$name}}"
        cols="{{$cols}}"
        rows="{{$rows}}"
        title="{{$title}}"
        placeholder="{{$placeholder}}"
        @if($required) required="required" @endif
        {!!  $dynamic_fields !!}
        @if(isset($url_on_blur) && $url_on_blur) data-blur-url="{{$url_on_blur}}" @endif
        @if(isset($method_on_blur) && $method_on_blur) data-blur-method="{{$method_on_blur}}" @endif
        @if(isset($show_success_message)) data-success-msg="{{$show_success_message ? 'true' : 'false'}}" @endif
        @if(isset($show_error_message)) data-error-msg="{{$show_error_message ? 'true' : 'false'}}" @endif
        @if(isset($show_spinner_on_blur)) data-show-spinner="{{$show_spinner_on_blur ? 'true' : 'false'}}" @endif
>{!! $content !!}</textarea>
