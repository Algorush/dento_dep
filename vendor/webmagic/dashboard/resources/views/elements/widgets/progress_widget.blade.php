<div class="col-md-3 col-sm-6 col-12 {{$class}}">
    <div class="info-box" @empty(!$background_color) style="background-color: {{$background_color}}" @endempty>
        <span class="info-box-icon" @empty(!$icon_background_color) style="background-color: {{$icon_background_color}};" @endempty>
            @empty(!$icon) <i class="fas {{$icon}}" @empty(!$text_color) style="color: {{$text_color}}" @endempty></i> @endempty
        </span>
        <div class="info-box-content" @empty(!$text_color) style="color: {{$text_color}}" @endempty>
            <span class="info-box-text">{!! $title !!}</span>
            <span class="info-box-number">{!! $message !!}</span>
            <div class="progress">
                <div class="progress-bar" style="width: {{$progress}}%; @empty(!$progress_color) background-color: {{$progress_color}}; @endempty"></div>
            </div>
            <span class="progress-description">{!! $description !!}</span>
        </div>
    </div>
</div>