@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

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
    <table class='table table-hover table-striped table-bordered table-sm'>
        <tr>
            <th>部屋番号</th>
            <th>階数</th>
            <th>間取り</th>
            <th>間取りタイプ</th>
            <th>方角</th>
            <th>占有面積</th>
            <th>新築時価格</th>
            <th>新築時坪単価</th>
            <th>予想売買価格</th>
            <th>予想売買価格坪単価</th>
            <th>予想賃料</th>
            <th>予想賃料坪単価</th>
            <th>利回り</th>
            <th>値上がり率</th>
            <th>成約価格</th>
            <th>差分</th>
            <th>謄本</th>
            <th>編集</th>
        </tr>
    @foreach($rooms as $room)
    <tr>
        <td><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
        <td>{{ $room->floor_number }}</td>
        <td>{{ $room->layout }}{{$room->building->building_name}}</td>
        <td>{{ $room->layout_type }}</td>
        <td>{{ $room->direction }}</td>
        <td>{{ $room->occupied_area }}㎡</td>
        <td>{{ $room->published_price }}</td>
        <td>
            @if($room->occupied_area != 0)
                {{ round($room->published_price / ($room->occupied_area * 0.3025)) }}</td>
            @else
                0
            @endif
        <td>{{ $room->expected_price }}</td>
        <td>
            @if($room->occupied_area != 0)
                {{ round($room->expected_price / ($room->occupied_area * 0.3025)) }}</td>
            @else
                0
            @endif
        <td>{{ $room->expected_rent_price }}</td>
        <td>
            @if($room->occupied_area != 0)
                {{ round($room->expected_rent_price / ($room->occupied_area * 0.3025)) }}
            @else
                0
            @endif
        </td>
        <td>
            @if($room->expected_price != 0)
                {{ round($room->expected_rent_price * 12 / ($room->expected_price * 10000) * 100 ,2) }}
            @else
                0
            @endif
        %</td>
        <td>
            @if($room->published_price != 0)
                {{ round($room->expected_price / $room->published_price * 100,2) }}
            @else
                0
            @endif
        %</td>
        <td>
            
            @foreach($room->soldSalesRooms as $soldSalesRoom)
                @if($loop->last)
                    {{ $soldSalesRoom->price }}
                @endif
            @endforeach
                    
        </td>
        <td>
            @if(isset($room->soldSalesRooms->price))
                {{ $room->expected_price - $room->soldSalesRooms->price }}
            @else
                0
            @endif
        </td>
        <td><a href="#">リンク</a></td>
        <td><a href="{{ route('room_edit',$room->id) }}">編集</a></td>
    </tr>
    
    @endforeach
    </table>       
@endsection