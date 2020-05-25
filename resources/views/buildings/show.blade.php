@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="container">
    <div class="row">
            <h2>{{ $building->building_name }}</h2>
            <div class="bottun">
                <a href="#" class='btn btn-danger'>売買</a>
                <a href="#" class='btn btn-success'>賃貸</a>
            </div>
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
            @foreach($building->rooms as $room)
            <tr>
                <td><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
                <td>{{ $room->floor_number }}</td>
                <td>{{ $room->layout }}</td>
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
                    @if(isset($room->soldSalesRooms->price))
                        {{ $room->soldSalesRooms->price }}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if(isset($room->soldSalesRooms->price))
                        {{ $room->expected_price - $room->soldSalesRooms->price }}
                    @else
                        0
                    @endif
                </td>
                <td><a href="#">リンク</a></td>
                <td><a href="#">編集</a></td>
            </tr>
            
            @endforeach
            </table>       
    </div>
</div>
@endsection