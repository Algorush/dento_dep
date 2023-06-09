<div class="alert alert-{{$type}} alert-dismissible js_alert-dismissible" data-hide="@json($auto_hide)" data-hide-time="{{$auto_hide_delay}}">
    @if($button)
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    @endif
    <h4>
        @if($icon)
            <i class="icon fas {{$icon}}"></i>
        @endif
        @if($title)
            {{ $title }}
        @endif
    </h4>
    @if($text)
        {{ $text }}
    @endif
</div>
