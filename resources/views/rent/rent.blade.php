@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
    <h2><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a>・賃貸</h2>
    </div>
        {!! Form::open(['route' => ['building_stocks',$building->id],'method' => 'get']) !!}
            <div class="items">
            <a href="{{ route('building_sales',$building->id) }}" class='btn btn-danger'>売買</a>
                {!! Form::text('room_number',old('room_number'),['placeholder'=>'部屋番号を入力']) !!}
                {!! Form::submit('検索',['class' => 'btn btn-info']) !!}
            </div>
        {!! Form::close() !!}
</div>
@if (session('flash_message'))
    <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
        {{ session('flash_message') }}
    </div>
@endif
<div class="flex">
    <div class="highcharts">
        <figure class='highcharts-figure'>
            <div id='unit_price'' style='height:600px;'></div>
        </figure>
    </div>
    <div class="highcharts">
        <figure class='highcharts-figure'>
            <div id='rent' style='height:600px;'></div>
        </figure>
    </div>
</div>
<div class="row">
    @include('components.buildingRentTable')
</div>
<script>
// 坪単価散布図
Highcharts.chart('unit_price', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text:'予想賃料坪単価'
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
        min:{{ $expectedUnitRentPrice }} - 1000,
        title: {
            text: '坪単価'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 50,
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
                pointFormat: '{point.x} 号室, {point.y} 円/坪'
            }
        }
    },
    series: [{
        name: '予想賃料坪単価',
        color: 'rgba(223, 83, 83, .5)',
        data:[
            @foreach($rooms as $room)
                @if($room->occupied_area != 0)
                    @php
                        $publishedUnitPrice = round($room->expected_rent_price / ($room->occupied_area * 0.3025));
                        $result = $room->room_number.','.$publishedUnitPrice;
                    @endphp
                    [{{$result}}],
                @endif
            @endforeach
        ]
    }]

});

// 予想賃料散布図
Highcharts.chart('rent', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text:'予想賃料'
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
        min:{{ $expectedRentPrice }} - 10000,
        title: {
            text: '予想賃料'
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
                pointFormat: '{point.x} 号室, {point.y} 円'
            }
        }
    },
    series: [{
        name: '予想賃料',
        color: 'rgba(223, 83, 83, .5)',
        data:[
            @foreach($rooms as $room)
                @if($room->expected_rent_price != 0)
                    @php
                        $result = $room->room_number.','.$room->expected_rent_price;
                    @endphp
                    [{{$result}}],
                @endif
            @endforeach
        ]
    }]
});
</script>
@endsection