@extends('layouts.app')

@section('title','査定進捗管理')

@section('content')
<div id='buildings'>
    <div class="container">
        <div class="row">
            <div class='col-sm-12'>
                @if (session('flash_message'))
                <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
                    {{ session('flash_message') }}
                </div>
                @endif
                <input class='search form-control' placeholder='物件名で検索' style='width:20%;'>
            <table class='table table-striped table-bordered table-sm'>
                <thead>
                    <tr>
                        <th>物件id</th>
                        <th class='sort' data-sort='name'>物件名</th>
                        <th class='sort' data-sort='publishedMedian'>中央値<br>(新築)</th>
                        <th class='sort' data-sort='expectedMedian'>中央値<br>(予想)</th>
                        <th class='sort' data-sort='occupiedAreaMedian'>中央値<br>(専有面積)</th>
                        <th class='sort' data-sort='expectedRentMedian'>中央値<br>(賃料坪単価)</th>
                        <th class='sort' data-sort='rimawari'>中央値<br>(利回り)</th>
                        <th class='sort' data-sort='total_unit'>総戸数</th>
                        <th class='sort' data-sort='countPublishedPrice'>新築時価格<br>有り戸数</th>
                        <th class='sort' data-sort='countExpectedPrice'>査定数</th>
                        <th class='sort' data-sort='percent'>査定進捗率<br>(総戸数比)</th>
                    </tr>
                </thead>
                <tbody class='list'>
                    @foreach($buildings as $building)
                        @php
                            //それぞれの中央値を求める
                            $publishedMedian = [];
                            $expectedMedian = [];
                            $expectedRentMedian = [];
                            $rimawari = [];
                            $occupiedAreaMedian = [];

                            foreach($building->rooms as $room){
                                if(($room->occupied_area != 0)){
                                    $publishedMedian[] = round($room->published_price / ($room->occupied_area * 0.3025));//新築
                                    $expectedMedian[] = round($room->expected_price / ($room->occupied_area * 0.3025));//予想
                                    $expectedRentMedian[] = round($room->expected_rent_price / ($room->occupied_area * 0.3025));//賃料坪単価
                                }else{
                                    $publishedMedian[] = 0;
                                    $expectedMedian[] = 0;
                                    $expectedRentMedian[] = 0;
                                }
                                if($room->expected_price != 0){
                                    $rimawari[] = round($room->expected_rent_price * 12 / ($room->expected_price * 10000) * 100 ,2);
                                }else{
                                    $rimawari[] = 0;
                                }

                                $occupiedAreaMedian[] = $room->occupied_area;//専有面積
                            }
                        @endphp
                    <tr>
                        <td>{{ $building->id }}</td>
                        <td class='name'><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></td>
                        <td class='publishedMedian'>{{ $baseClass->median($publishedMedian) }}</td>
                        <td class='expectedMedian'>{{ $baseClass->median($expectedMedian) }}</td>
                        <td class='occupiedAreaMedian'>{{ $baseClass->median($occupiedAreaMedian) }}</td>
                        <td class='expectedRentMedian'>{{ $baseClass->median($expectedRentMedian) }}</td>
                        <td class='rimawari'>{{ $baseClass->median($rimawari) }}%</td>
                        <td class='total_unit'>{{ $building->total_unit }}</td>
                        <td class='countPublishedPrice'>
                            {{ $building->countPublishedPrice() }}
                        </td>
                        <td class='countExpectedPrice'>
                            {{ $building->countExpectedPrice() }}
                        </td>
                        <td class='percent'>
                            @if(!empty($building->countExpectedPrice()) && isset($building->total_unit))
                                {{ round($building->countExpectedPrice() / $building->total_unit * 100,2) }}%
                            @else
                                0.00%
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection