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
        {!! Form::open(['route' => ['buildings_show',$building->id],'method' => 'get']) !!}
            <div class="items">
                {!! Form::text('room_number',old('room_number'),['placeholder'=>'部屋番号を入力']) !!}
                {!! Form::submit('検索',['class' => 'btn btn-success']) !!}
            </div>
        {!! Form::close() !!}
</div>
@include('components.buildingShowTable')

<h3 class='chart_building_name'><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a> {{ $layout_type }}</h3>
<figure class='highcharts-figure'>
    <div id='container' style='height:600px;'></div>
</figure>

<script>
let jsRooms = <?php echo $jsRooms; ?>;


Highcharts.chart('container', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text: '売買坪単価'
    },
    
    xAxis: {
        tickInterval:1,
        title: {
            enabled: true,
            text: '階数'
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true
    },
    yAxis: {
        min:0,
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
                pointFormat: '{point.x} 階, {point.y} 万円/坪'
            }
        }
    },
    series: [{
        name: '新築時坪単価',
        color: 'rgba(223, 83, 83, .5)',
        data:[
            @foreach($jsRooms as $jsRoom)
            @php            
                $publishedUnitPrice = round($jsRoom->published_price / ($jsRoom->occupied_area * 0.3025));
                $result = $jsRoom->floor_number.','.$publishedUnitPrice;
            @endphp
            [{{$result}}],
            @endforeach
        ]
    }, {
        name: '予想価格坪単価',
        color: 'rgba(119, 152, 191, .5)',
        data: [
            @foreach($jsRooms as $jsRoom)
            @php            
                $expectedUnitPrice = round($jsRoom->expected_price / ($jsRoom->occupied_area * 0.3025));
                $ooyamaResult = $jsRoom->floor_number.','.$expectedUnitPrice;
            @endphp
            [{{$ooyamaResult}}],
            @endforeach
         ]
    }]
});
</script>


@endsection