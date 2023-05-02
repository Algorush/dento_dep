<div class="main-menu">
    @if(isset($styles['logo']))
        <div class="main_logo" style="width:{{$styles['logo_width'] ?? ''}}px ; height:{{$styles['logo_height'] ?? ''}}px" >
            <img src="{{$styles['logo']}}"></div>
    @else
        <div class="main_logo" ><img src="{{asset('img/logo.png')}}"></div>
    @endif
    <div class="add">DETAILS</div>
</div>
