@extends('layouts.app')

@section('title',$room->building->building_name.'|'.$room->room_number.'編集')

@section('content')

    <div class="row">
        <h2><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a> 編集</h2>
            <div class="bottun">
                <a href="{{ route('room_sales',$room->id) }}" class='btn btn-danger'>売買編集</a>
                <a href="{{ route('room_rent',$room->id) }}" class='btn btn-success'>賃貸編集</a>
            </div>
            
            <table class='table table-striped table-bordered table-sm'>
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
                    <th></th>
                </tr>
                {!! Form::model($room,['route' => ['room_update',$room->id],'method' => 'PUT']) !!}

                <tr>
                    <div class="form-group">
                        <td>{!! Form::text('room_number',old('room_number',$room->room_number),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <div class="form-group">
                        <td>{!! Form::text('floor_number',old('floor_number',$room->floor_number),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <div class="form-group">
                        <td>{!! Form::text('layout',old('layout',$room->layout),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <div class="form-group">
                        <td>{!! Form::text('layout_type',old('layout_type',$room->layout_type),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <div class="form-group">
                        <td>{!! Form::text('direction',old('direction',$room->direction),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <div class="form-group">
                        <td>{!! Form::text('occupied_area',old('occupied_area',$room->occupied_area),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <div class="form-group">
                        <td>{!! Form::text('published_price',old('published_price',$room->published_price),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <td>
                        @if($room->occupied_area != 0)
                            {{ round($room->published_price / ($room->occupied_area * 0.3025)) }}</td>
                        @else
                            0
                        @endif

                    <div class="form-group">
                        <td>{!! Form::text('expected_price',old('expected_price',$room->expected_price),['class' => 'form-control']) !!}</a></td>
                    </div>
                    <td>
                        @if($room->occupied_area != 0)
                            {{ round($room->expected_price / ($room->occupied_area * 0.3025)) }}</td>
                        @else
                            0
                        @endif
                    <div class="form-group">
                        <td>{!! Form::text('expected_rent_price',old('expected_rent_price',$room->expected_rent_price),['class' => 'form-control']) !!}</a></td>
                    </div>
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
                    <td>{!! Form::submit('変更',['class'=>'btn btn-secondary']) !!}</td>
                </tr>
            {!! Form::close() !!}
            </table>
            
            <p>新規登録</p>
            <a href="{{ route('stock_sales_create',$room->id) }}">売買在庫</a>
            <a href="{{ route('stock_rent_create',$room->id) }}">/賃貸在庫</a>
            <a href="{{ route('sold_sales_create',$room->id) }}">/売買成約</a>
            <a href="{{ route('sold_rent_create',$room->id) }}">/賃貸成約</a>
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection