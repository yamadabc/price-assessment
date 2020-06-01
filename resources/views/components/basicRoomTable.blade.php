
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
        <td class='price'>
            @foreach($room->soldSalesRooms as $soldSalesRoom)
                @if($loop->last)
                    {{ $soldSalesRoom->price }}
                @endif
            @endforeach
        </td>
        <td class='diffarence'>
            @foreach($room->soldSalesRooms as $soldSalesRoom)
                @if($loop->last)
                    @if($soldSalesRoom->price - $room->expected_price > 0)
                        <div class="red">+{{ $soldSalesRoom->price - $room->expected_price }}</div>
                    @else
                        <div class="blue">{{ $soldSalesRoom->price - $room->expected_price }}</div>
                    @endif
                @endif
            @endforeach
        </td>
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
    