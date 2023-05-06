@if(isset($subitem['sub_items']) && count($subitem['sub_items']))
    <li class="dropdown-submenu dropdown-hover">
        <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{__($subitem['text'])}}</a>
        <ul class="dropdown-menu border-0 shadow" style="display: none;">
            @each('dashboard::components.menus.main_menu.top_sidebar_menu.sub_item', $subitem['sub_items'], 'subitem')
        </ul>
    </li>
@else
    <li><a href="{{url($subitem['link'])}}" class="dropdown-item">{{__($subitem['text'])}}</a></li>
@endif