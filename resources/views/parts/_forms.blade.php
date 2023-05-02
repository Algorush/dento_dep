<div class="loader2" style="background-color:{{$styles['background_color']}}">
    <div id="progress" style="display: block;">
        @if(isset($styles['logo']))
            <img class="logo_load" src="{{$styles['logo']}}" style="width:{{$styles['logo_width'] ?? ''}}px ; height:height:{{$styles['logo_height'] ?? ''}}px ">
        @else
            <img class="logo_load" src="{{asset('img/logo.png')}}">
        @endif
        <center style="display:none;">
            <span style="color:{{$styles['progressbar_color']}}">LOADING</span>
            <div id="progressbar" style="color:{{$styles['progressbar_color']}}; background:{{$styles['progressbar_background_color']}}"><div id="bar" style="background:{{$styles['progressbar_color']}}"></div></div>
            <div class="percent" id="percent" style="color:{{$styles['progressbar_color']}}">0%</div>
        </center>
    </div>
</div>

{{--Modal--}}
@if(isset($styles['ipr']))
    <div id="IPR-img"><img id="IPR" src="{{$styles['ipr']}}"></div>
@endif
<div class="modal-container hide">
    <div class="modal">
        <img class="close" src="{{asset('img/close.svg')}}">
        <div class="inner">
            <div class="scrollbar style-1">
                <div class="force-overflow">
                    <div class="hdr">@if(isset($styles['point_text_header_1']) && !empty($styles['point_text_header_1']))
                                    {{$styles['point_text_header_1']}}
                                @else
                                    How to wear your Aligners
                                @endif</div>
                    <div class="schedule">
                        <p>@if(isset($styles['point_text_header_2']) && !empty($styles['point_text_header_2']))
                                    {{$styles['point_text_header_2']}} 
                                @else
                                    Wear Sсhedule
                                @endif:
                            <span class="wear_days">@if(isset($styles['wear_count']))
                                    {{$styles['wear_count']}} 
                                @endif</span>                            
                            @if(isset($styles['wear_times_of_day']))
                                {{$styles['wear_times_of_day']=='1' ? "Days" : "Nights"}}
                            @endif                            
                        </p>
                        <p>@if(isset($styles['point_text_header_3']) && !empty($styles['point_text_header_3']))
                                    {{$styles['point_text_header_3']}} 
                                @else
                                    Treatment Duration
                                @endif: <span id="duration_weeks"></span> Weeks</p>
                    </div>
                    <div class="hdr">@if(isset($styles['point_text_header_4']) && !empty($styles['point_text_header_4']))
                                    {{$styles['point_text_header_4']}} 
                                    @else
                                        Patient
                                @endif: {{$styles['client_name'] ?? ''}}</div>
                    <div class="quarter">
                        <img @if(isset($styles['point_image_1'])) src="{{$styles['point_image_1']}}" @else src="{{asset('img/calendar.svg')}}" @endif >

                        <div class="cnt">
                            @if(isset($styles['point_text_1']))
                                {{$styles['point_text_1']}}
                            @else
                                Each pair of aligners (upper and lower arch) should be worn according to the wear schedule.
                                Daytime aligners for 22 hours per day for a minimum of 7 or 14 days.
                                Night-time only aligners for 10 hours per night for a minimum of 10 days.
                            @endif
                        </div>
                    </div>
                    <div class="quarter">
                        <img @if(isset($styles['point_image_2'])) src="{{$styles['point_image_2']}}" @else src="{{asset('img/pair-aligners.svg')}}" @endif >

                        <div class="cnt">
                            @if(isset($styles['point_text_2']))
                                {{$styles['point_text_2']}}
                            @else
                                The aligners should be worn as per the wear schedule unless indicated otherwise by your orthodontic professional.
                            @endif
                        </div>
                    </div>
                    <div class="quarter">
                        <img @if(isset($styles['point_image_3'])) src="{{$styles['point_image_3']}}" @else src="{{asset('img/eating.svg')}}" @endif >

                        <div class="cnt">
                            @if(isset($styles['point_text_3']))
                                {{$styles['point_text_3']}}
                            @else
                                Your aligners should only be removed for eating, drinking hot beverages, and brushing your teeth.
                            @endif
                        </div>
                    </div>
                    <div class="quarter">
                        <img @if(isset($styles['point_image_4'])) src="{{$styles['point_image_4']}}" @else src="{{asset('img/phone.svg')}}" @endif >

                        <div class="cnt">
                            @if(isset($styles['point_text_4']))
                                {{$styles['point_text_4']}}
                            @else
                            Your profesional will guide you during your treatment. Feel free to contact them anytime for additional treatment instructions.
                            @endif
                        </div>
                    </div>
                    <div class="quarter">
                        <div class="cnt">*We do not guarantee the length of the treatment. Progression may vary according to the daily usage by the user, follow up notes from the orthodontist, and/or the patient’s anatomy. However, the more you follow your treatment plan, the more probable the time frame will be.</div>
                    </div>
                    <div style="float: right;display:flex;">
                        @if(isset($styles['pdf']))
                            <div class="pdf"
                                @if(isset($styles['pdf']))
                                data-url="{{$styles['pdf']}}"
                                @else
                                data-url="{{asset('pdf/plan-details.pdf')}}"
                                    @endif>
                                <img id="pdf"
                                    src="{{asset('img/pdf.jpg')}}"
                                >
                                Treatment Plan
                            </div>
                        @endif
                        <div><button class="close-btn">x</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>