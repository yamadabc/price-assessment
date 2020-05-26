
    <tr>
        <td><a href="{{ route('room_show',$room->id) }}">{{ $room->room_number }}</a></td>
        <td>{{ $room->floor_number }}</td>
        <td>{{ $room->layout }}</td>
        <td>{{ $room->layout_type }}</td>
        <td>{{ $room->direction }}</td>
        <td>{{ $room->occupied_area }}㎡</td>
        <td>{{ $room->published_price }}</td>
        <td>
            @if($room->occupied_area != 0)
                {{ round($room->published_price / ($room->occupied_area * 0.3025)) }}</td>
            @else
                0
            @endif
        <td>{{ $room->expected_price }}</td>
        <td>
            @if($room->occupied_area != 0)
                {{ round($room->expected_price / ($room->occupied_area * 0.3025)) }}</td>
            @else
                0
            @endif
        <td>{{ $room->expected_rent_price }}</td>
        <td>
            @if($room->occupied_area != 0)
                {{ round($room->expected_rent_price / ($room->occupied_area * 0.3025)) }}
            @else
                0
            @endif
        </td>
        <td>
            @if($room->expected_price != 0)
                {{ round($room->expected_rent_price * 12 / ($room->expected_price * 10000) * 100 ,2) }}
            @else
                0
            @endif
        %</td>
        <td>
            @if($room->published_price != 0)
                {{ round($room->expected_price / $room->published_price * 100,2) }}
            @else
                0
            @endif
        %</td>
        <td>
            @if(isset($room->soldSalesRooms->price))
                {{ $room->soldSalesRooms->price }}
            @else
                0
            @endif
        </td>
        <td>
            @if(isset($room->soldSalesRooms->price))
                {{ $room->expected_price - $room->soldSalesRooms->price }}
            @else
                0
            @endif
        </td>
        <td><a href="#">リンク</a></td>
        <td><a href="{{ route('room_edit',$room->id) }}">編集</a></td>
    </tr>
    