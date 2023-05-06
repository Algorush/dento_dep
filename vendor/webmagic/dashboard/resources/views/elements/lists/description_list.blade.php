<dl class="@if($is_horizontal) dl-horizontal @endif" {!! $dynamic_fields !!}>
    @foreach($data as $title => $description)
        <dt class="@if($set_headers_left_align) text-left @endif">{!! $title !!}</dt>
        <dd>{!! $description !!}</dd>
    @endforeach
</dl>
