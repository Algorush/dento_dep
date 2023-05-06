<div class="col-lg-3 col-6 {{$class}}">
    <div
        class="small-box"
        style="
            @empty(!$background_color) background-color: {{$background_color}};@endempty
            @empty(!$text_color) color: {{$text_color}};@endempty
        ">
        <div class="inner">
            <h3>{!! $title !!}</h3>
            <p>{!! $description !!}</p>
        </div>
        <div class="icon">
            @empty(!$icon) <i class="fas {{$icon}}" style="color: {{$icon_color}}"></i> @endempty
        </div>
        <a href="{{ $link }}" class="small-box-footer">
            {{ $link_title }} @empty(!$link_icon) <i class="fas {{$link_icon}}"></i> @endempty
        </a>
    </div>
</div>