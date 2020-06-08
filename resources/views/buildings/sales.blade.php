@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
        <a href="{{ route('buildings_show',$building->id) }}"><h2>{{ $building->building_name }}</h2></a>
    </div>
        {!! Form::open(['route' => ['building_sales',$building->id],'method' => 'get']) !!}
            <div class="items">
                <a href="{{ route('building_stocks',$building->id) }}" class='btn btn-success'>賃貸</a>
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
<div class="row">
    <table class='table table-striped table-bordered table-sm' id='rooms'>
        <thead>
            <tr>
                <th>id</th>
                <th class='sort' data-sort='room_number'>部屋番号</th>
                <th class='sort' data-sort='floor_number'>階数</th>
                <th class='sort' data-sort='layout'>間取り</th>
                <th class='sort' data-sort='layout_type'>間取りタイプ</th>
                <th class='sort' data-sort='direction'>方角</th>
                <th class='sort' data-sort='occupied_area'>占有面積</th>
                <th class='sort' data-sort='price'>掲載中の価格(万円)</th>
                <th class='sort' data-sort='previous_price'>変更前価格(万円)</th>
                <th class='sort' data-sort='registered_at'>登録年月日</th>
                <th class='sort' data-sort='changed_at'>変更年月日</th>
                <th class='sort' data-sort='sold_price'>成約価格</th>
                <th class='sort' data-sort='sold_previous_price'>成約前価格</th>
                <th class='sort' data-sort='sold_registered_at'>登録年月日</th>
                <th class='sort' data-sort='sold_changed_at'>変更年月日</th>
                <th class='sort' data-sort='expected_price'>予想売買価格</th>
                <th>差分</th>
                <th>謄本</th>
                <th></th>
            </tr>
        </thead>
        <tbody class='list'>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->id }}</td>
                <td class='room_number'><a href="{{ route('room_sales',$room->id) }}">{{ $room->room_number }}</a></td>
                <td class='floor_number'>{{ $room->floor_number }}</td>
                <td class='layout'>{{ $room->layout }}</td>
                <td class='layout_type'>{{ $room->layout_type }}</td>
                <td class='direction'>{{ $room->direction }}</td>
                <td class='occupied_area'>{{ $room->occupied_area }}㎡</td>
                
                <td class='price'>
                    @foreach($room->stockSalesRooms as $stockSalesRoom)
                        @if($loop->last)
                            {{ $stockSalesRoom->price }}
                        @endif
                    @endforeach
                </td>
                <td class='previous_price'>
                    @foreach($room->stockSalesRooms as $stockSalesRoom)
                        @if($loop->last)
                            {{ $stockSalesRoom->previous_price }}
                        @endif
                    @endforeach
                </td>
                <td class='registered_at'>
                    @foreach($room->stockSalesRooms as $stockSalesRoom)
                        @if($loop->last)
                            {{ $stockSalesRoom->registered_at }}
                        @endif
                    @endforeach
                </td>
                <td class='changed_at'>
                    @foreach($room->stockSalesRooms as $stockSalesRoom)
                        @if($loop->last)
                        {{ $stockSalesRoom->changed_at }}
                        @endif
                    @endforeach
                </td>
                
                <td class='sold_price'>
                    @foreach($room->soldSalesRooms as $soldSalesRoom)
                        @if($loop->last)
                            {{ $soldSalesRoom->price }}
                        @endif
                    @endforeach
                </td>
                <td class='sold_previous_price'>
                    @foreach($room->soldSalesRooms as $soldSalesRoom)
                        @if($loop->last)
                            {{ $soldSalesRoom->previous_price }}
                        @endif
                    @endforeach
                </td>
                <td class='sold_registered_at'>
                    @foreach($room->soldSalesRooms as $soldSalesRoom)
                        @if($loop->last)
                            {{ $soldSalesRoom->registered_at }}
                        @endif
                    @endforeach
                </td>
                <td class='sold_changed_at'>
                    @foreach($room->soldSalesRooms as $soldSalesRoom)
                        @if($loop->last)
                            {{ $soldSalesRoom->changed_at }}
                        @endif
                    @endforeach
                </td>
                
                <td class='expected_price'>{{ $room->expected_price }}</td>
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
                <td>
                    <a href="{{ route('sales_edit',$room->id) }}">編集</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection