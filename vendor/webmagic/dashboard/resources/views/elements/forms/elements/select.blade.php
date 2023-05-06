<select
        id="{{$id}}"
        name="{{$name}}"
        class="{{$class}} @if(request()->ajax() == false && $errors->has($name)) error @endif"
        @if($multiple) multiple @endif
        @if($required) required @endif        
        {!! $dynamic_fields !!}
        data-placeholder="{{$placeholder}}"
>
        @foreach($options as $key => $val)
            <option value="{{$key}}" @if(in_array($key, $selected_keys)) selected @endif >{{$val}}</option>
        @endforeach
</select>
@if(request()->ajax() == false && $errors->has($name))
    <p class="help-block __error">
        @foreach($errors->get($name) as $errorMessage)
            {{$errorMessage}}<br>
        @endforeach
    </p>
@endif