<a href="{{$link}}" class="brand-link {{ $class }}">
    @if($prefer_image_logo && $icon != '')
        <div class="brand-link-img" style="background-image: url('{{asset($icon)}}')"></div>
    @else
    <div class="brand-link-img">
         <p class="brand-txt-l brand-text font-weight-light mb-0 pt-2">{{$regular_text}}</p>
         <p class="brand-txt-s text-center mb-0">{{$collapsed_text}}</p>
    </div>
    @endif
</a>
