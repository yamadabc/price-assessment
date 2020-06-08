<div id="rooms">
    <table class='table table-hover table-striped table-bordered table-sm'>
        <thead>
            <tr>
                <th>id</th>
                <th class='sort' data-sort='room_number'>部屋番号</th>
                <th class='sort' data-sort='floor_number'>階数</th>
                <th class='sort' data-sort='layout'>間取り</th>
                <th class='sort' data-sort='layout_type'>間取りタイプ</th>
                <th class='sort' data-sort='direction'>方角</th>
                <th class='sort' data-sort='occupied_area'>占有面積</th>
                <th class='sort' data-sort='published_price'>新築時価格</th>
                <th class='sort' data-sort='published_unit_price'>新築時坪単価</th>
                <th class='sort' data-sort='expected_price'>予想売買価格</th>
                <th class='sort' data-sort='expected_unit_price'>予想売買価格坪単価</th>
                <th class='sort' data-sort='expected_rent_price'>予想賃料</th>
                <th class='sort' data-sort='expected_unit_rent_price'>予想賃料坪単価</th>
                <th class='sort' data-sort='rimawari'>利回り</th>
                <th class='sort' data-sort='increase_rate'>値上がり率</th>
                <th>謄本</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody class='list'>
            @foreach($rooms as $room)
            <tr>
                <td>{{ $room->id }}</td>
                <td class='room_number'><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
                <td class='floor_number'><a href="{{ route('floor_sort',[$building->id,$room->floor_number]) }}">{{ $room->floor_number }}</a></td>
                <td class='layout'>{{ $room->layout }}</td>
                <td class='layout_type'>
                    @if($room->layout_type)    
                        <a href="{{ route('layout_type_sort',[$building->id,$room->layout_type]) }}">{{ $room->layout_type }}</a></td>
                    @endif
                <td class='direction'>{{ $room->direction }}</td>
                <td class='occupied_area'>{{ $room->occupied_area }}㎡</td>
                <td class='published_price'>{{ $room->published_price }}</td>
                <td class='published_unit_price'>
                    @if($room->occupied_area != 0)
                        {{ round($room->published_price / ($room->occupied_area * 0.3025)) }}</td>
                    @else
                        0
                    @endif
                <td class='expected_price'>{{ $room->expected_price }}</td>
                <td class='expected_unit_price'>
                    @if($room->occupied_area != 0)
                        {{ round($room->expected_price / ($room->occupied_area * 0.3025)) }}</td>
                    @else
                        0
                    @endif
                <td class='expected_rent_price'>{{ $room->expected_rent_price }}</td>
                <td class='expected_unit_rent_price'>
                    @if($room->occupied_area != 0)
                        {{ round($room->expected_rent_price / ($room->occupied_area * 0.3025)) }}
                    @else
                        0
                    @endif
                </td>
                <td class='rimawari'>
                    @if($room->expected_price != 0)
                        {{ round($room->expected_rent_price * 12 / ($room->expected_price * 10000) * 100 ,2) }}
                    @else
                        0
                    @endif
                %</td>
                <td class='increase_rate'>
                    @if($room->published_price != 0)
                        {{ round($room->expected_price / $room->published_price * 100,2) }}
                    @else
                        0
                    @endif
                %</td>
                
                <td>
                    @foreach($room->copyOfRegisters as $copyOfRegister)
                        @if(isset($copyOfRegister))
                            @if($loop->last)   
                            <a href="{{ route('pdf_show',$room->getCopyOfRegisters($room->id)) }}">リンク</a>
                            @endif
                        @endif    
                    @endforeach
                </td>
                <td><a href="{{ route('room_edit',$room->id) }}">編集</a></td>
            </tr>
            @endforeach
        </tbody>
    </table> 
</div> 