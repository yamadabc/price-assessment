<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}" defer></script>
    
</head>
<body>
    <header>
        <div class="flex">
            <h1 class='item'><a href="/">大山査定</a></h1>
            <div class="item">
                <!-- モーダル表示の為のボタン -->
                <!-- ドロップダウンメニュー -->
                <div class="dropdown">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">csvアップロード</button>
                    <div class="dropdown-menu">
                        <button class='btn' data-toggle='modal' data-target="#modal-buildings">
                            物件情報・新規
                        </button>
                        <button class='btn' data-toggle='modal' data-target="#modal-rooms">
                            部屋情報・新規
                        </button>
                        <div class="dropdown-divider"></div>
                        <button class='btn' data-toggle='modal' data-target="#modal-buildings-update">
                            物件情報・編集
                        </button>
                        <button class='btn' data-toggle='modal' data-target="#modal-rooms-update">
                            部屋情報・編集
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- モーダルの配置 -->
            <div class="modal fade" id="modal-buildings" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class='modal-title' id='modal-label'>新規物件情報のアップロード</h4>
                            <button type='button' class='close' data-dismiss='modal'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        {!! Form::open(['route'=>'import.building','enctype'=>'multipart/form-data']) !!}
                        <div class="modal-body">
                                {!! Form::file('csv') !!}
                        </div>
                        <div class="modal-footer">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                        @endif
                            {!! Form::submit('アップロード',['class'=>'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- モーダルの配置 -->
        <div class="modal fade" id="modal-rooms" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class='modal-title' id='modal-label'>新規部屋情報のアップロード</h4>
                        <button type='button' class='close' data-dismiss='modal'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['route'=>'import.room','enctype'=>'multipart/form-data']) !!}
                    <div class="modal-body">
                            {!! Form::file('csv') !!}
                    </div>
                    <div class="modal-footer">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {!! Form::submit('アップロード',['class'=>'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- モーダルの配置 -->
    <div class="modal fade" id="modal-buildings-update" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class='modal-title' id='modal-label'>編集済み物件情報のアップロード</h4>
                            <button type='button' class='close' data-dismiss='modal'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        {!! Form::open(['route'=>'import.buildingsUpdate','enctype'=>'multipart/form-data']) !!}
                        <div class="modal-body">
                                {!! Form::file('csv') !!}
                        </div>
                        <div class="modal-footer">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                        @endif
                            {!! Form::submit('アップロード',['class'=>'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- モーダルの配置 -->
        <div class="modal fade" id="modal-rooms-update" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class='modal-title' id='modal-label'>新規部屋情報のアップロード</h4>
                        <button type='button' class='close' data-dismiss='modal'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['route'=>'import.roomsUpdate','enctype'=>'multipart/form-data']) !!}
                    <div class="modal-body">
                            {!! Form::file('csv') !!}
                    </div>
                    <div class="modal-footer">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {!! Form::submit('アップロード',['class'=>'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </header>
    @yield('content')


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>