@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
        <h2><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a><a href="{{ route('room_create',$building->id) }}" class='btn btn-light'>新規部屋情報入力</a></h2>

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

<table border id='stucking'>
    @foreach($floorNumbers as $floorNumber)
    <tr>
        @php
            $rooms = App\Room::where('floor_number',$floorNumber->floor_number)->get();
        @endphp
        @foreach($rooms as $room)
        @if(!empty(trim($room->layout_type)))
            <td>
        @else
            <td class='undefined'>
        @endif
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
        </td>
        @endforeach
    </tr>
    @endforeach
</table>
@endsection
