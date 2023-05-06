<div class="col-md-3 col-sm-6 col-12 {{$class}}">
    <div class="info-box" style="background-color: {{$background_color}}">
        <span class="info-box-icon" style="background-color: {{$icon_background_color}}">
            @empty(!$icon) <i class="fas {{$icon}}" @empty(!$icon_color)style="color: {{$icon_color}}"@endempty></i> @endempty
        </span>
        <div class="info-box-content" style="color: {{$text_color}}">
            <span class="info-box-text">{!! $title !!}</span>
            <span class="info-box-number">{!! $message !!}</span>
        </div>
    </div>
</div>