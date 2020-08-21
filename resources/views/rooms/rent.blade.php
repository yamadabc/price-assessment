@extends('layouts.app')

@section('title','売買/'.$room->building->building_name)

@section('content')

    <div class="flex">
        <h2 class='item'><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a>・賃貸</h2>
        <div class="item">
            <a href="{{ route('room_sales',$room->id) }}" class='btn btn-danger'>売買</a>
        </div>
    </div>
    @if (session('flash_message'))
        <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
            {{ session('flash_message') }}
        </div>
    @endif
            <table class='table table-striped table-bordered table-sm'>
                <tr>
                    <th>部屋番号</th>
                    <th>階数</th>
                    <th>間取り</th>
                    <th>間取りタイプ</th>
                    <th>方角</th>
                    <th>専有面積</th>
                    <th>掲載中の賃料(万円)</th>
                    <th>変更前賃料(万円)</th>
                    <th>登録年月日</th>
                    <th>変更年月日</th>
                    <th>成約賃料</th>
                    <th>成約前賃料</th>
                    <th>登録年月日</th>
                    <th>変更年月日</th>
                    <th>予想賃料</th>
                    <th>差分</th>
                    <th>新築時価格表にない部屋</th>
                    <th>謄本</th>
                    @if($stockRentRoom || $soldRentRoom)
                        <th></th>
                        <th></th>
                    @endif
                </tr>
            <tr>
                <td><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
                <td>{{ $room->floor_number }}</td>
                <td>{{ $room->layout }}</td>
                <td>{{ $room->layout_type }}</td>
                <td>{{ $room->direction }}</td>
                <td>{{ $room->occupied_area }}㎡</td>
                <td>
                    @if(isset($stockRentRoom))
                        {{ $stockRentRoom->price }}
                    @endif
                </td>
                <td>
                    @if(isset($stockRentRoom))
                        {{ $stockRentRoom->previous_price }}
                    @endif
                </td>
                <td>
                    @if(isset($stockRentRoom))
                        {{ $stockRentRoom->registered_at }}
                    @endif
                </td>
                <td>
                    @if(isset($stockRentRoom))
                        {{ $stockRentRoom->changed_at }}
                    @endif
                </td>
                <td>
                    @if(isset($soldRentRoom))
                        {{ $soldRentRoom->price }}
                    @endif
                </td>
                <td>
                    @if(isset($soldRentRoom))
                        {{ $soldRentRoom->previous_price }}
                    @endif
                </td>
                <td>
                    @if(isset($soldRentRoom))
                        {{ $soldRentRoom->registered_at }}
                    @endif
                </td>
                <td>
                    @if(isset($soldRentRoom))
                        {{ $soldRentRoom->changed_at }}
                    @endif
                </td>
                <td>{{ $room->expected_rent_price }}</td>
                <td class='diffarence'>
                    @foreach($room->soldRentRooms as $soldRentRoom)
                        @if($loop->last)
                            @if($room->expected_rent_price - $soldRentRoom->price > 0)
                                <div class="red">+{{ $room->expected_rent_price - $soldRentRoom->price }}({{ round(($room->expected_rent_price - $soldRentRoom->price) / $room->expected_rent_price * 100 ,2) }}%)</div>
                            @else
                                <div class="blue">{{ $room->expected_rent_price - $soldRentRoom->price }}({{ round(( $room->expected_rent_price - $soldRentRoom->price) / $room->expected_rent_price * 100 ,2) }}%)</div>
                            @endif
                        @endif
                    @endforeach
                </td>
                <td class='has_no_data'>
                    @if($room->has_no_data == 1)
                        ⚪︎
                    @endif
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
                @if($stockRentRoom || $soldRentRoom)
                    <td>
                        <a href="{{ route('rent_edit',$room->id) }}">編集</a>
                    </td>
                @endif
                @if($stockRentRoom || $soldRentRoom)
                    <td>
                        @if(!empty($stockRentRoom) && !empty($soldRentRoom))
                            {!! Form::model($stockRentRoom,['route' => ['rent_delete',[$stockRentRoom->id,$soldRentRoom->id]],'method' => 'post']) !!}
                        @elseif(!empty($stockRentRoom) && empty($soldRentRoom))
                            {!! Form::model($stockRentRoom,['route' => ['rent_delete',$stockRentRoom->id],'method' => 'post']) !!}
                        @elseif(empty($stockRentRoom) && !empty($soldRentRoom))
                            {!! Form::model($stockRentRoom,['route' => ['rent_delete',[-1,$soldRentRoom->id]],'method' => 'post']) !!}
                        @endif
                            {!! Form::submit('削除',['class' => 'dell_rent btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                @endif
            </tr>
            </table>
            @include('components.createNRegisterData')
@endsection