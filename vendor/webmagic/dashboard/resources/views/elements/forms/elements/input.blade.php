<input
        id="{{$id}}"
        class="{{$class}} @if(request()->ajax() == false && isset($errors) && $errors->has($name)) error @endif"
        type="{{$type}}"
        placeholder="{{ $placeholder }}"
        value="{{$value !== '' ? $value : old($name)}}"
        name="{{$name}}"

        @if($required) required="required" @endif

        {!!  $dynamic_fields !!}
/>
@if(request()->ajax() == false && isset($errors) && $errors->has($name))
    <p class="help-block __error">
        @foreach($errors->get($name) as $errorMessage)
            {{$errorMessage}}<br>
        @endforeach
    </p>
@endif