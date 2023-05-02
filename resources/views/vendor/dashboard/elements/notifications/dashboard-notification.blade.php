<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close  js_alert-submit-ajax" data-dismiss="alert" aria-hidden="true"
                data-action="{{route('dashboard::deals.notifications')}}" data-method="Post"
        >×</button>

    <h4>
        <i class="icon icon fas fa-exclamation-circle"></i>Warning!
    </h4>
    @if($text)
        {!! $text !!}
    @endif
</div>
