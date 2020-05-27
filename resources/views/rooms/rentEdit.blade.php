@extends('layouts.app')

@section('title',$room->building->building_name.'|'.$room->room_number.'編集')

@section('content')

<div class="container">
    <div class="row">
        <h2><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a> 賃貸情報編集</h2>
            <div class="bottun">
                <a href="{{ route('room_sales',$room->id) }}" class='btn btn-danger'>売買編集</a>
            </div>
            
            <table class='table table-striped table-bordered table-sm'>
                <tr>
                    <th>部屋番号</th>
                    <th>階数</th>
                    <th>掲載中の価格(万円)</th>
                    <th>変更前価格(万円)</th>
                    <th>登録年月日</th>
                    <th>変更年月日</th>
                    <th>成約価格</th>
                    <th>成約前価格</th>
                    <th>登録年月日</th>
                    <th>変更年月日</th>
                    <th>謄本</th>
                    <th></th>
                </tr>
                @if(!empty($room) && !empty($stockRentRoom) && empty($soldRentRoom))
                    {!! Form::model($room,['route' => ['rent_update',$room->id,$stockRentRoom->id],'method' => 'PUT']) !!}
                @elseif(!empty($room) && !empty($soldRentRoom) && empty($stockRentRoom))
                    {!! Form::model($room,['route' => ['rent_update',$room->id,$soldRentRoom->id],'method' => 'PUT']) !!}
                @elseif(!empty($room) && !empty($stockRentRoom) && !empty($soldRentRoom))
                    {!! Form::model($room,['route' => ['rent_update',$room->id,$stockRentRoom->id,$soldRentRoom->id],'method' => 'PUT']) !!}
                @endif
                <tr>
                    <td><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
                    <td>{{ $room->floor_number }}</td>
                    
                    <div class="form-group">
                        @if(isset($stockRentRoom))
                            <td>{!! Form::text('price',old('price',$stockRentRoom->price),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('price',old('price'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($stockRentRoom))
                            <td>{!! Form::text('previous_price',old('previous_price',$stockRentRoom->previous_price),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('previous_price',old('previous_price'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($stockRentRoom))
                            <td>{!! Form::text('registered_at',old('registered_at',$stockRentRoom->registered_at),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('registered_at',old('registered_at'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($stockRentRoom))
                            <td>{!! Form::text('changed_at',old('changed_at',$stockRentRoom->changed_at),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('changed_at',old('changed_at'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($soldRentRoom))
                            <td>{!! Form::text('sold_price',old('sold_price',$soldRentRoom->price),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('sold_price',old('sold_price'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($soldRentRoom))
                            <td>{!! Form::text('sold_previous_price',old('sold_previous_price',$soldRentRoom->previous_price),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('sold_previous_price',old('sold_previous_price'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($soldRentRoom))
                            <td>{!! Form::text('sold_registered_at',old('sold_registered_at',$soldRentRoom->registered_at),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('sold_registered_at',old('sold_registered_at'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(isset($soldRentRoom))
                            <td>{!! Form::text('sold_changed_at',old('sold_changed_at',$soldRentRoom->changed_at),['class' => 'form-control']) !!}</a></td>
                        @else
                            <td>{!! Form::text('sold_changed_at',old('sold_changed_at'),['class' => 'form-control']) !!}</a></td>
                        @endif
                    </div>
                    <td><a href="#">リンク</a></td>
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