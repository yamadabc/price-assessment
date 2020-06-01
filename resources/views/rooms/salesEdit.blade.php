@extends('layouts.app')

@section('title',$room->building->building_name.'|'.$room->room_number.'編集')

@section('content')

<h2><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a> 売買情報編集</h2>

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
        <th></th>
    </tr>
    @if(!empty($room) && !empty($stockSalesRoom) && empty($soldSalesRoom))
        {!! Form::model($room,['route' => ['sales_update',$room->id,$stockSalesRoom->id],'method' => 'PUT']) !!}
    @elseif(!empty($room) && !empty($soldSalesRoom) && empty($stockSalesRoom))
        {!! Form::model($room,['route' => ['sales_update',$room->id,$soldSalesRoom->id],'method' => 'PUT']) !!}
    @elseif(!empty($room) && !empty($stockSalesRoom) && !empty($soldSalesRoom))
        {!! Form::model($room,['route' => ['sales_update',$room->id,$stockSalesRoom->id,$soldSalesRoom->id],'method' => 'PUT']) !!}
    @endif
    <tr>
        <td><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
        <td>{{ $room->floor_number }}</td>
        
        <div class="form-group">
            @if(isset($stockSalesRoom))
                <td>{!! Form::text('price',old('price',$stockSalesRoom->price),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('price',old('price'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($stockSalesRoom))
                <td>{!! Form::text('previous_price',old('previous_price',$stockSalesRoom->previous_price),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('previous_price',old('previous_price'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($stockSalesRoom))
                <td>{!! Form::text('registered_at',old('registered_at',$stockSalesRoom->registered_at),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('registered_at',old('registered_at'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($stockSalesRoom))
                <td>{!! Form::text('changed_at',old('changed_at',$stockSalesRoom->changed_at),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('changed_at',old('changed_at'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($soldSalesRoom))
                <td>{!! Form::text('sold_price',old('sold_price',$soldSalesRoom->price),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('sold_price',old('sold_price'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($soldSalesRoom))
                <td>{!! Form::text('sold_previous_price',old('sold_previous_price',$soldSalesRoom->previous_price),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('sold_previous_price',old('sold_previous_price'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($soldSalesRoom))
                <td>{!! Form::text('sold_registered_at',old('sold_registered_at',$soldSalesRoom->registered_at),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('sold_registered_at',old('sold_registered_at'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <div class="form-group">
            @if(isset($soldSalesRoom))
                <td>{!! Form::text('sold_changed_at',old('sold_changed_at',$soldSalesRoom->changed_at),['class' => 'form-control']) !!}</a></td>
            @else
                <td>{!! Form::text('sold_changed_at',old('sold_changed_at'),['class' => 'form-control']) !!}</a></td>
            @endif
        </div>
        <td>{!! Form::submit('変更',['class'=>'btn btn-secondary']) !!}</td>
    </tr>
{!! Form::close() !!}
</table>
@include('components.createNRegisterData')
@endsection