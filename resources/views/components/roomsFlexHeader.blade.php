<div class="items">
    <h2 class='block'><a href="{{ route('buildings_show',$building->id) }}">{{ $building->building_name }}</a></h2>
    <p class='block'>( {{ $building->total_unit }}室中 {{ count($building->rooms) }}室査定完了( {{ round(count($building->rooms) / $building->total_unit * 100 ,2 ) }}% ))</p>
</div>

<div class='items'>
    @if(Request::is('buildings/stucking/'.$building->id))
        <a href="{{ route('buildings_show',$building->id) }}">テーブル表示</a>
        <p class='block'>/ スタッキング表示</p>
    @else
        <p class='block'>テーブル表示 /</p>
        <a href="{{ route('buildings_stucking',$building->id) }}">スタッキング表示</a>
    @endif
</div>
