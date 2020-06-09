@extends('layouts.app')

@section('title','売買/'.$room->building->building_name)

@section('content')

    <div class="flex">
        <h2 class='item'><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a>・売買情報</h2>
        <div class="item">
            <a href="{{ route('room_rent',$room->id) }}" class='btn btn-success'>賃貸</a>
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
            <th>新築時価格表に</br>ない部屋</th>
            <th>謄本</th>
            @if($stockSalesRoom || $soldSalesRoom)
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
            @if(isset($stockSalesRoom))
                {{ $stockSalesRoom->price }}
            @endif
        </td>
        <td>
            @if(isset($stockSalesRoom))
                {{ $stockSalesRoom->previous_price }}
            @endif
        </td>
        <td>
            @if(isset($stockSalesRoom))
                {{ $stockSalesRoom->registered_at }}
            @endif
        </td>
        <td>
            @if(isset($stockSalesRoom))
                {{ $stockSalesRoom->changed_at }}
            @endif
        </td>
        <td>
            @if(isset($soldSalesRoom))
                {{ $soldSalesRoom->price }}
            @endif
        </td>
        <td>
            @if(isset($soldSalesRoom))
                {{ $soldSalesRoom->previous_price }}
            @endif
        </td>
        <td>
            @if(isset($soldSalesRoom))
                {{ $soldSalesRoom->registered_at }}
            @endif
        </td>
        <td>
            @if(isset($soldSalesRoom))
                {{ $soldSalesRoom->changed_at }}
            @endif
        </td>
        <td>{{ $room->expected_price }}</td>
        <td class='diffarence'>
            @foreach($room->soldSalesRooms as $soldSalesRoom)
                @if($loop->last)
                    @if($soldSalesRoom->price - $room->expected_price > 0)
                        <div class="blue">{{ $room->expected_price - $soldSalesRoom->price }}({{ round(( $room->expected_price - $soldSalesRoom->price) / $room->expected_price * 100 ,2) }}%)</div>
                    @else 
                        <div class="red">+{{ $room->expected_price - $soldSalesRoom->price }}({{ round(($room->expected_price - $soldSalesRoom->price) / $room->expected_price * 100 ,2) }}%)</div>
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
        @if($stockSalesRoom || $soldSalesRoom)
            <td>
                <a href="{{ route('sales_edit',$room->id) }}">編集</a>
            </td>
        @endif
        @if($stockSalesRoom || $soldSalesRoom)
            <td>
                @if(!empty($stockSalesRoom) && !empty($soldSalesRoom))
                    {!! Form::model($stockSalesRoom,['route' => ['sales_delete',[$stockSalesRoom->id,$soldSalesRoom->id]],'method' => 'post']) !!}
                @elseif(!empty($stockSalesRoom) && empty($soldSalesRoom))
                    {!! Form::model($stockSalesRoom,['route' => ['sales_delete',$stockSalesRoom->id],'method' => 'post']) !!}
                @elseif(empty($stockSalesRoom) && !empty($soldSalesRoom))
                    {!! Form::model($stockSalesRoom,['route' => ['sales_delete',[-1,$soldSalesRoom->id]],'method' => 'post']) !!}
                @endif
                    {!! Form::submit('削除',['class' => 'dell btn btn-danger btn-sm']) !!}
                {!! Form::close() !!}
            </td>
        @endif
    </tr>
    </table>     
    @include('components.createNRegisterData')
@endsection