@extends('layouts.app')

@section('title','売買在庫新規入力')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <h3>売買在庫情報新規入力</h3>
            <h3><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a>{{ $room->room_number }}号室</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::model($room,['route'=>['stock_sales_store',$room->id],'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('price','掲載中の価格') !!}<span class='badge-pill badge-danger' style='margin:5px;'>必須 </span></div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('price',old('price'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>万円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('previous_price','変更前の価格') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('previous_price',old('previous_price'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>万円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('management_fee','管理費') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('management_fee',old('management_fee'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('reserve_fund','修繕積立金') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('reserve_fund',old('reserve_fund'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('company_name','会員名') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('company_name',old('company_name'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('contact_phonenumber','代表電話番号') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('contact_phonenumber',old('contact_phonenumber'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                        <div class="col-sm-5">{!! Form::label('pic','問合せ担当者') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('pic',old('pic'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                        <div class="col-sm-5">{!! Form::label('email','emailアドレス') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::text('email',old('email'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('registered_at','登録年月日') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::date('registered_at',old('registered_at'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                        <div class="col-sm-5">{!! Form::label('changed_at','変更年月日') !!}</div>
                    <div class="col-sm-7">
                        {!! Form::date('changed_at',old('changed_at'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            {!! Form::submit('登録する',['class'=>'btn btn-success btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    </div>


@endsection