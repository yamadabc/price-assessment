@extends('layouts.app')

@section('title','物件一覧')

@section('content')

<div class="container">
    <div class="row">
        <div class='col-sm-12'>
            <h1>大山査定</h1>
            @if (session('flash_message'))
                <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
                    {{ session('flash_message') }}
                </div>
            @endif
            <table class='table table-striped table-bordered table-sm'>
                <tr>
                    <th>物件名</th>
                    <th>総戸数</th>
                    <th>新築時価格有り戸数</th>
                    <th>大山査定数</th>
                    <th>査定進捗率(総戸数比)</th>
                </tr>
                @foreach($buildings as $building)
                <tr>
                    <td><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></td>
                    <td>{{ $building->total_unit }}</td>
                    <td>
                        @if(isset($building->rooms->published_price))
                        {{ $building->rooms_count }}
                        @endif
                    </td>
                    <td>
                        @if(isset($building->rooms->expected_price))
                        {{ count($building->rooms->expected_price) }}</td>
                        @endif
                    <td>
                        @if(isset($building->rooms->expected_price) && isset($building->total_unit))
                        {{ round($building->rooms->expected_price / $building->total_unit * 100,2) }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection