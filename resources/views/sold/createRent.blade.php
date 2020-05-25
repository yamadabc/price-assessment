@extends('layouts.app')

@section('title','賃貸成約新規入力')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <h2><a href="{{ route('buildings_show',$room->building_id) }}">{{ $room->building->building_name }}</a>{{ $room->room_number }}号室</h2>
            <h2>賃貸成約情報新規入力</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::model($room,['route'=>['sold_rent_store',$room->id],'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('price','成約賃料') !!}<span class='badge-pill badge-danger' style='margin:5px;'>必須 </span></div>
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
                    <div class="col-sm-5">{!! Form::label('previous_price','成約前の賃料') !!}</div>
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
                    <div class="col-sm-5">{!! Form::label('monthly_fee','共益費') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('monthly_fee',old('monthly_fee'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('security_deposit','敷金') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('security_deposit',old('security_deposit'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>ヶ月</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('gratuity_fee','礼金') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('gratuity_fee',old('gratuity_fee'),['class'=>'form-control']) !!}
                            <div class='input-group-append'>
                                <span class='input-group-text' id='addon1'>ヶ月</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">{!! Form::label('deposit','保証金') !!}</div>
                    <div class="col-sm-7">
                        <div class="input-group">
                            {!! Form::text('deposit',old('deposit'),['class'=>'form-control']) !!}
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
</div>


@endsection