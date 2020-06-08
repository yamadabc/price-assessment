@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
        <a href="{{ route('buildings_show',$building->id) }}"><h2>{{ $building->building_name }}</h2></a>
    </div>
        {!! Form::open(['route' => ['building_sales',$building->id],'method' => 'get']) !!}
            <div class="items">
                {!! Form::text('room_number',old('room_number'),['placeholder'=>'部屋番号を入力']) !!}
                {!! Form::submit('検索',['class' => 'btn btn-success']) !!}
            </div>
        {!! Form::close() !!}
</div>
@if (session('flash_message'))
    <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
        {{ session('flash_message') }}
    </div>
@endif
<div class="row">
    <table class='table table-striped table-bordered table-sm'>
        <tr>
            <th>部屋番号</th>
            <th>階数</th>
            <th>間取り</th>
            <th>間取りタイプ</th>
            <th>方角</th>
            <th>占有面積</th>
            <th>掲載中の価格(万円)</th>
            <th>変更前価格(万円)</th>
            <th>登録年月日</th>
            <th>変更年月日</th>
            <th>成約価格</th>
            <th>成約前価格</th>
            <th>登録年月日</th>
            <th>変更年月日</th>
            <th>予想売買価格</th>
            <th>差分</th>
            <th>謄本</th>
            <th></th>
        </tr>
        @foreach($rooms as $room)
        <tr>
            <td><a href="{{ route('room_sales',$room->id) }}">{{ $room->room_number }}</a></td>
            <td>{{ $room->floor_number }}</td>
            <td>{{ $room->layout }}</td>
            <td>{{ $room->layout_type }}</td>
            <td>{{ $room->direction }}</td>
            <td>{{ $room->occupied_area }}㎡</td>
            
            <td>
                @foreach($room->stockSalesRooms as $stockSalesRoom)
                    @if($loop->last)
                        {{ $stockSalesRoom->price }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($room->stockSalesRooms as $stockSalesRoom)
                    @if($loop->last)
                        {{ $stockSalesRoom->previous_price }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($room->stockSalesRooms as $stockSalesRoom)
                    @if($loop->last)
                        {{ $stockSalesRoom->registered_at }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($room->stockSalesRooms as $stockSalesRoom)
                    @if($loop->last)
                    {{ $stockSalesRoom->changed_at }}
                    @endif
                @endforeach
            </td>
            
            <td>
                @foreach($room->soldSalesRooms as $soldSalesRoom)
                    @if($loop->last)
                        {{ $soldSalesRoom->price }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($room->soldSalesRooms as $soldSalesRoom)
                    @if($loop->last)
                        {{ $soldSalesRoom->previous_price }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($room->soldSalesRooms as $soldSalesRoom)
                    @if($loop->last)
                        {{ $soldSalesRoom->registered_at }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($room->soldSalesRooms as $soldSalesRoom)
                    @if($loop->last)
                        {{ $soldSalesRoom->changed_at }}
                    @endif
                @endforeach
            </td>
            
            <td>{{ $room->expected_price }}</td>
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
            
            <td><a href="#">リンク</a></td>
            <td>
                <a href="{{ route('sales_edit',$room->id) }}">編集</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection