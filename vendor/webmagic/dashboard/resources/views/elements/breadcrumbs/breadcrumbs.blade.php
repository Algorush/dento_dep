<ol class="breadcrumb float-sm-right">
    @foreach ($items as $item)
        @if(!$loop->last)
            <li class="breadcrumb-item">
                <a href="{{$item->getLink()}}">
                    @if($item->hasIcon()) <i class="fas {{$item->getIcon()}}"></i>@endif {{$item->getText()}}
                </a>
            </li>
        @else
            <li class="breadcrumb-item active">{{$item->getText()}}</li>
        @endif
    @endforeach
</ol>
