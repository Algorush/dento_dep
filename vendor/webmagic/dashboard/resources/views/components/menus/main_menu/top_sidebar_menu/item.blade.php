@if(isset($item['sub_items']) && count($item['sub_items']))
    <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{__($item['text'])}}</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
            @each('dashboard::components.menus.main_menu.top_sidebar_menu.sub_item', $item['sub_items'], 'subitem')
        </ul>
@else
    <li class="nav-item">
        <a href="{{url($item['link'])}}" class="nav-link">{{__($item['text'])}}</a>
    </li>
@endif