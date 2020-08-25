@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
        <h2><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></h2>

    </div>
    <div class='items'>
        <a href="{{ route('buildings_show',$building->id) }}">テーブル表示</a>
        <p class='block'>/ スタッキング表示</p>
    </div>
    {!! Form::open(['route' => ['buildings_show',$building->id],'method' => 'get']) !!}
        <div class="items">
        <a href="{{ route('building_sales',$building->id) }}" class='btn btn-danger'>売買</a>
        <a href="{{ route('building_stocks',$building->id) }}" class='btn btn-success'>賃貸</a>
            {!! Form::text('room_number',old('room_number'),['placeholder'=>'部屋番号を入力']) !!}
            {!! Form::submit('検索',['class' => 'btn btn-info']) !!}
        </div>
    {!! Form::close() !!}
</div>

<table border id='stucking' class='table-striped'>
    @foreach($floorNumbers as $floorNumber)
    <tr>
        @php
            $rooms = App\Room::where('building_id',$building->id)->where('floor_number',$floorNumber->floor_number)->orderBy('room_number','asc')->get();
        @endphp
        @foreach($rooms as $room)
        @if(!empty(trim($room->layout_type)))
            <td>
        @else
            <td class='undefined'>
        @endif
            <a href="{{ route('room_show',$room->id) }}">
                <p class='th'>{{ $room->room_number }}</p>
                <p>
                    {{ $room->layout_type }}
                    @if(empty(trim($room->layout_type)))
                    不明
                    @endif
                </p>
                <p>{{ $room->occupied_area }}㎡ </p>
                <p>
                    @if($room->occupied_area != 0)
                        {{ round($room->published_price / ($room->occupied_area * 0.3025)) }}
                    @else
                        0
                    @endif
                    万円
                </p>
                <p>
                    @if($room->occupied_area != 0)
                        {{ round($room->expected_price / ($room->occupied_area * 0.3025)) }}
                    @else
                        0
                    @endif
                    万円
                </p>
            </a>
        </td>
        @endforeach
    </tr>
    @endforeach
</table>
@endsection
