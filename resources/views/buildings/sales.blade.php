@extends('layouts.app')

@section('title',$building->building_name)

@section('content')

<div class="flex">
    <div class="items">
        <h2><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a>・売買<a href="{{ route('room_create',$building->id) }}" class='btn btn-light'>新規部屋情報入力</a></h2>
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
    @include('components.buildingSalesTable')
</div>

@endsection