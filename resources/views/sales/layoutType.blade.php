@extends('layouts.app')

@section('title',$building->building_name)

@section('content')
<!-- high charts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<div class="flex">
    <div class="items">
        <a href="{{ route('buildings_show',$building->id) }}"><h2>{{ $building->building_name }}</h2></a>
    </div>
        {!! Form::open(['route' => ['building_stocks',$building->id],'method' => 'get']) !!}
            <div class="items">
                {!! Form::text('room_number',old('room_number'),['placeholder'=>'部屋番号を入力']) !!}
                {!! Form::submit('検索',['class' => 'btn btn-info']) !!}
            </div>
        {!! Form::close() !!}
</div>

<h3 class='chart_building_name'>間取タイプ {{ $layout_type }}</h3>
<div class="flex">
    <div class="highcharts">
        <figure class='highcharts-figure'>
            <div id='unit_price' style='height:600px;'></div>
        </figure>
    </div>
    <div class="highcharts">
        <figure class='highcharts-figure'>
            <div id='price' style='height:600px;'></div>
        </figure>
    </div>
</div>

@include('components.buildingSalesTable')

<script>
// 坪単価散布図
Highcharts.chart('unit_price', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text:'売買坪単価'
    },
    
    xAxis: {
        title: {
            enabled: true,
            text: '部屋番号'
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true
    },
    yAxis: {
        min:{{ $publishedUnitPrice }} - 50,
        title: {
            text: '坪単価'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 100,
        y: 0,
        floating: true,
        backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
        borderWidth: 1
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} 号室, {point.y} 万円/坪'
            }
        }
    },
    series: [{
        name: '新築時坪単価',
        color: 'rgba(223, 83, 83, .5)',
        data:[
            @foreach($rooms as $room)
                @if($room->occupied_area != 0)
                    @php            
                        $publishedUnitPrice = round($room->published_price / ($room->occupied_area * 0.3025));
                        $result = $room->room_number.','.$publishedUnitPrice;
                    @endphp
                    [{{$result}}],
                    @endif
            @endforeach
        ]
    }, {
        name: '予想価格坪単価',
        color: 'rgba(119, 152, 191, .5)',
        data: [
            @foreach($rooms as $room)
                @if($room->occupied_area != 0)
                    @php            
                        $expectedUnitPrice = round($room->expected_price / ($room->occupied_area * 0.3025));
                        $ooyamaResult = $room->room_number.','.$expectedUnitPrice;
                    @endphp
                    [{{$ooyamaResult}}],
                @endif
            @endforeach
         ]
    }]
});

// 売買価格散布図
Highcharts.chart('price', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text:'売買価格'
    },
    
    xAxis: {
        title: {
            enabled: true,
            text: '部屋番号'
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true
    },
    yAxis: {
        min:{{ $publishedPrice }} - 1000,
        title: {
            text: '売買価格'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 100,
        y: 0,
        floating: true,
        backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
        borderWidth: 1
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} 号室, {point.y} 万円'
            }
        }
    },
    series: [{
        name: '新築時価格',
        color: 'rgba(223, 83, 83, .5)',
        data:[
            @foreach($rooms as $room)
                @if($room->published_price != 0)
                    @php            
                        $result = $room->room_number.','.$room->published_price;
                    @endphp
                    [{{$result}}],
                @endif
            @endforeach
        ]
    }, {
        name: '予想売買価格',
        color: 'rgba(119, 152, 191, .5)',
        data: [
            @foreach($rooms as $room)
                @if($room->expected_price != 0)
                    @php            
                        $ooyamaResult = $room->room_number.','.$room->expected_price;
                    @endphp
                    [{{$ooyamaResult}}],
                @endif
            @endforeach
         ]
    }]
});
</script>

@endsection