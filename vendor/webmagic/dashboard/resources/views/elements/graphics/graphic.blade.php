<div>
    @if($is_change_view_available)
        <a href="#" class="d-inline-block text-light-blue mb-3 pull-right {{$graphic_change_view_uniq_class}}"
           data-graphic=".{{$graphic_uniq_class}}"
           style="padding: 3px 0;">@lang('dashboard::common.graphic_change_view')</a>
    @endif
    <div>
        <h4 data-original-title title>{{ $title }}</h4>
    </div>
    <div class="chart">
        <canvas class="js_graphic {{$graphic_uniq_class}}" width="500px" height="200"
                style="width: 500px; height: 200px;"
                @if($data_url) data-url="{{$data_url}}" @endif
                data-method="GET"
                data-chart-data='{
                    "labels"  : {{$labels}},
                    "datasets": {{$data_set}}
                }'
                data-options='{
                        "el": ".{{$graphic_uniq_class}}",
                        @if($is_change_view_available)
                        "btnChangeType": ".{{$graphic_change_view_uniq_class}}",
                        @endif
                        {{--"descriptionBlk": ".js_graphic-description-id",--}}
                        @if($graphic_form_class)
                        "form": ".{{$graphic_form_class}}",
                        @endif
                        "type": "{{$type}}",
                        "options":{
                            "legend":{
                                "display": "{{$is_legend_display}}",
                                "position": "{{$legend_position}}",
                                "labels": {
                                    "boxWidth": 12
                                }
                            },
                            "scales":{
                                "xAxes": [{
                                    "gridLines": {
                                        "display": "{{$show_x_axes}}"
                                    }
                                }],
                                "yAxes": [{
                                    "gridLines": {
                                        "display": "{{$show_y_axes}}"
                                    }
                                }]
                            }
                        },
                        "commonDatasets": {
                            "pointRadius": "{{$point_radius}}",
                            "lineTension": "{{$line_tension}}"
                        }
                    }'></canvas>
    </div>
</div>
