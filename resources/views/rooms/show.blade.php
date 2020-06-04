@extends('layouts.app')

@section('title',$room->building->building_name.'|'.$room->room_number)

@section('content')

<div class="flex">
    <div class="item"><a href="{{ route('buildings_show',$room->building_id) }}"><h2>{{ $room->building->building_name }}</h2></a></div>
    <div class="item"><a href="{{ route('room_sales',$room->id) }}" class='btn btn-danger'>売買</a>
    <a href="{{ route('room_rent',$room->id) }}" class='btn btn-success'>賃貸</a></div>
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
            <th>謄本</th>
            <th></th>
        </tr>
        @include('components.basicRoomTable')
    </table>
    @include('components.createNRegisterData')

@endsection