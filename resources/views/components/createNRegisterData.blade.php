<p>◆新規登録</p>
<a href="{{ route('stock_sales_create',$room->id) }}">売買在庫</a>
<a href="{{ route('sold_sales_create',$room->id) }}">/売買成約</a>
<a href="{{ route('stock_rent_create',$room->id) }}">/賃貸在庫</a>
<a href="{{ route('sold_rent_create',$room->id) }}">/賃貸成約</a>

<p>◆登記簿謄本登録</p>
{!! Form::open(['route' => ['pdf_upload',$room->id],'enctype' => 'multipart/form-data']) !!}
{!! Form::file('file_name') !!}
{!! Form::submit('登録する',['class'=>'btn btn-outline-success']) !!}
{!! Form::close() !!}

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif