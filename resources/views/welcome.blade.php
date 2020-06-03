@extends('layouts.app')

@section('title','物件一覧')

@section('content')

<div class="container">
    <div class="row">
        <div class='col-sm-12'>
            @if (session('flash_message'))
                <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
                    {{ session('flash_message') }}
                </div>
            @endif
            <table class='table table-striped table-bordered table-sm' id='buildings'>
                <thead>
                    <tr>
                        <th class='sort' data-sort='name'>物件名</th>
                        <th class='sort' data-sort='total_unit'>総戸数</th>
                        <th class='sort' data-sort='countPublishedPrice'>新築時価格有り戸数</th>
                        <th class='sort' data-sort='countExpectedPrice'>大山査定数</th>
                        <th class='sort' data-sort='percent'>査定進捗率(総戸数比)</th>
                    </tr>
                </thead>
                <tbody class='list'>
                    @foreach($buildings as $building)
                    <tr>
                        <td class='name'><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></td>
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
@endsection