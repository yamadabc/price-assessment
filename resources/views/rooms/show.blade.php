@extends('layouts.app')

@section('title',$building->building_name.'|'.$room->room_number)

@section('content')

<div class="container">
    <div class="row">
            <h2><a href="/">大山査定</a></h2>
            <h2>{{ $building->building_name }}</h2>
            <div class="bottun">
                <a href="#" class='btn btn-danger'>売買</a>
                <a href="#" class='btn btn-success'>賃貸</a>
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
                @include('layouts.basicRoomTable')
                
            </table>
    </div>
</div>
@endsection