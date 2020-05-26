@extends('layouts.app')

@section('title',$building->building_name.'|'.$room->room_number)

@section('content')

<div class="container">
    <div class="row">
        <a href="{{ route('buildings_show',$building->id) }}"><h2>{{ $building->building_name }}</h2></a>
            <div class="bottun">
                <a href="{{ route('room_sales',$room->id) }}" class='btn btn-danger'>売買</a>
                <a href="{{ route('room_rent',$room->id) }}" class='btn btn-success'>賃貸</a>
            </div>
            <table class='table table-hover table-striped table-bordered table-sm'>
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
                    <th>編集</th>
                </tr>
                @include('components.basicRoomTable')
            </table>
            <p>新規登録</p>
            <a href="{{ route('stock_sales_create',$room->id) }}">売買在庫</a>
            <a href="{{ route('stock_rent_create',$room->id) }}">/賃貸在庫</a>
            <a href="{{ route('sold_sales_create',$room->id) }}">/売買成約</a>
            <a href="{{ route('sold_rent_create',$room->id) }}">/賃貸成約</a>
    </div>
</div>
@endsection