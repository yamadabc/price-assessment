@extends('layouts.app')

@section('title','部屋新規入力')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <h3>部屋情報新規入力</h3>
            <h3><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::model($building,['route'=>['room_store',$building->id],'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('room_number','部屋番号') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('room_number',old('room_number'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('floor_number','階数') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('floor_number',old('floor_number'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('layout','間取') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('layout',old('layout'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('layout_type','間取タイプ') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('layout_type',old('layout_type'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('direction','方角') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('direction',old('direction'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('occupied_area','専有面積') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('occupied_area',old('occupied_area'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>㎡</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('published_price','新築時価格') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('published_price',old('published_price'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>万円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('expected_price','予想売買価格') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('expected_price',old('expected_price'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>万円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('expected_rent_price','予想賃料') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('expected_rent_price',old('expected_rent_price'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                        <div class="col-sm-5">{!! Form::label('has_no_data','新築時価格表') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::radio('has_no_data',0,) !!}データあり
                        {!! Form::radio('has_no_data',1,) !!}データなし
                    </div>
                </div>
            </div>
            {!! Form::submit('登録する',['class'=>'btn btn-success btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    </div>
</div>


@endsection