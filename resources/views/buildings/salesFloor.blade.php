@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
        <h2><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a>・売買</h2>
    </div>
        {!! Form::open(['route' => ['building_sales',$building->id],'method' => 'get']) !!}
            <div class="items">
                <a href="{{ route('building_stocks',$building->id) }}" class='btn btn-success'>賃貸</a>
                {!! Form::text('room_number',old('room_number'),['placeholder'=>'部屋番号を入力']) !!}
                {!! Form::submit('検索',['class' => 'btn btn-success']) !!}
            </div>
        {!! Form::close() !!}
</div>
<p class='chart_building_name'>
    @foreach($floor_numbers as $floor_number)
        <a href="{{ route('floor_sort',[$building->id,$floor_number]) }}">{{ $floor_number }} / </a>
    @endforeach
</p>
<div class="flex">
    <div class="items">
    <figure class='highcharts-figure'>
        <div id='container' style='height:600px;'></div>
    </figure>
    </div>
</div>
@include('components.buildingSalesTable')

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
        text: {{ $floor }} + '階 売買坪単価'
    },
    
    xAxis: {
        title: {
            enabled: true,
            text: '占有面積'
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true
    },
    yAxis: {
        min:{{ $expectedUnitPrice }} - 50,
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
                pointFormat: '{point.x} ㎡, {point.y} 万円/坪'
            }
        }
    },
    series: [{
        name: '新築時坪単価',
        color: 'rgba(223, 83, 83, .5)',
        data:[
            @foreach($jsRooms as $jsRoom)
                @if($jsRoom->occupied_area != 0)
                    @php            
                        $publishedUnitPrice = round($jsRoom->published_price / ($jsRoom->occupied_area * 0.3025));
                        $result = $jsRoom->occupied_area.','.$publishedUnitPrice;
                    @endphp
                    [{{$result}}],
                    @endif
            @endforeach
        ]
    }, {
        name: '予想価格坪単価',
        color: 'rgba(119, 152, 191, .5)',
        data: [
            @foreach($jsRooms as $jsRoom)
                @if($jsRoom->occupied_area != 0)
                    @php            
                        $expectedUnitPrice = round($jsRoom->expected_price / ($jsRoom->occupied_area * 0.3025));
                        $ooyamaResult = $jsRoom->occupied_area.','.$expectedUnitPrice;
                    @endphp
                    [{{$ooyamaResult}}],
                @endif
            @endforeach
         ]
    }]
});
</script>


@endsection