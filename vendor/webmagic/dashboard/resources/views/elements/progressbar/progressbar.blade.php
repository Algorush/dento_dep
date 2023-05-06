@if($title)
<p><code>{{$title}}</code></p>
@endif
<div class="progress {{$thickness}}">
    <div
        class="progress-bar {{$color}} @if($striped) progress-bar-striped @endif"
        role="progressbar"
        aria-valuemin="0"
        aria-valuemax="100"
        style="width: {{$progress}}%"
    >
    </div>
</div>