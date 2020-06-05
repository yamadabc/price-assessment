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
<div id="rooms">
    <table class='table table-hover table-striped table-bordered table-sm'>
        <thead>
            <tr>
                <th>id</th>
                <th class='sort' data-sort='room_number'>部屋番号</th>
                <th class='sort' data-sort='floor_number'>階数</th>
                <th class='sort' data-sort='layout'>間取り</th>
                <th class='sort' data-sort='layout_type'>間取りタイプ</th>
                <th class='sort' data-sort='direction'>方角</th>
                <th class='sort' data-sort='occupied_area'>占有面積</th>
                <th class='sort' data-sort='published_price'>新築時価格</th>
                <th class='sort' data-sort='published_unit_price'>新築時坪単価</th>
                <th class='sort' data-sort='expected_price'>予想売買価格</th>
                <th class='sort' data-sort='expected_unit_price'>予想売買価格坪単価</th>
                <th class='sort' data-sort='expected_rent_price'>予想賃料</th>
                <th class='sort' data-sort='expected_unit_rent_price'>予想賃料坪単価</th>
                <th class='sort' data-sort='rimawari'>利回り</th>
                <th class='sort' data-sort='increase_rate'>値上がり率</th>
                <th class='sort' data-sort='price'>成約価格</th>
                <th class='sort' data-sort='diffarence'>差分</th>
                <th>謄本</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody class='list'>
            @foreach($rooms as $room)
            <tr>
                <td>{{ $room->id }}</td>
                <td class='room_number'><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
                <td class='floor_number'><a href="{{ route('floor_sort',[$building->id,$room->floor_number]) }}">{{ $room->floor_number }}</a></td>
                <td class='layout'>{{ $room->layout }}</td>
                <td class='layout_type'>
                    @if($room->layout_type)    
                        <a href="{{ route('layout_type_sort',[$building->id,$room->layout_type]) }}">{{ $room->layout_type }}</a></td>
                    @endif
                <td class='direction'>{{ $room->direction }}</td>
                <td class='occupied_area'>{{ $room->occupied_area }}㎡</td>
                <td class='published_price'>{{ $room->published_price }}</td>
                <td class='published_unit_price'>
                    @if($room->occupied_area != 0)
                        {{ round($room->published_price / ($room->occupied_area * 0.3025)) }}</td>
                    @else
                        0
                    @endif
                <td class='expected_price'>{{ $room->expected_price }}</td>
                <td class='expected_unit_price'>
                    @if($room->occupied_area != 0)
                        {{ round($room->expected_price / ($room->occupied_area * 0.3025)) }}</td>
                    @else
                        0
                    @endif
                <td class='expected_rent_price'>{{ $room->expected_rent_price }}</td>
                <td class='expected_unit_rent_price'>
                    @if($room->occupied_area != 0)
                        {{ round($room->expected_rent_price / ($room->occupied_area * 0.3025)) }}
                    @else
                        0
                    @endif
                </td>
                <td class='rimawari'>
                    @if($room->expected_price != 0)
                        {{ round($room->expected_rent_price * 12 / ($room->expected_price * 10000) * 100 ,2) }}
                    @else
                        0
                    @endif
                %</td>
                <td class='increase_rate'>
                    @if($room->published_price != 0)
                        {{ round($room->expected_price / $room->published_price * 100,2) }}
                    @else
                        0
                    @endif
                %</td>
                <td class='price'>
                    @foreach($room->soldSalesRooms as $soldSalesRoom)
                        @if($loop->last)
                            {{ $soldSalesRoom->price }}
                        @endif
                    @endforeach
                </td>
                <td class='diffarence'>
                    @foreach($room->soldSalesRooms as $soldSalesRoom)
                        @if($loop->last)
                            @if($soldSalesRoom->price - $room->expected_price > 0)
                                <div class="red">+{{ $soldSalesRoom->price - $room->expected_price }}({{ round(($soldSalesRoom->price - $room->expected_price) / $room->expected_price * 100 ,2) }}%)</div>
                            @else 
                                <div class="blue">{{ $soldSalesRoom->price - $room->expected_price }}({{ round(($soldSalesRoom->price - $room->expected_price) / $room->expected_price * 100 ,2) }}%)</div>
                            @endif
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($room->copyOfRegisters as $copyOfRegister)
                        @if(isset($copyOfRegister))
                            @if($loop->last)   
                            <a href="{{ route('pdf_show',$room->getCopyOfRegisters($room->id)) }}">リンク</a>
                            @endif
                        @endif    
                    @endforeach
                </td>
                <td><a href="{{ route('room_edit',$room->id) }}">編集</a></td>
            </tr>
            @endforeach
        </tbody>
    </table> 
</div> 

<h3 class='chart_building_name'><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></h3>
<p class='chart_building_name'>
    @foreach($floor_numbers as $floor_number)
        <a href="{{ route('floor_sort',[$building->id,$floor_number]) }}">{{ $floor_number }} / </a>
    @endforeach
    
</p>
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
        text: {{ $room->floor_number }} + '階 売買坪単価'
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
                pointFormat: '{point.x} ㎡, {point.y} 万円/坪'
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
                $result = $jsRoom->occupied_area.','.$publishedUnitPrice;
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
                $ooyamaResult = $jsRoom->occupied_area.','.$expectedUnitPrice;
            @endphp
            [{{$ooyamaResult}}],
            @endforeach
         ]
    }]
});
</script>


@endsection