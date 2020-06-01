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
            <!-- モーダル表示の為のボタン -->
            <div class="item">
                <button class='btn btn-light' data-toggle='modal' data-target="#modal-buildings">
                    物件情報をアップロードする
                </button>
                <button class='btn btn-light' data-toggle='modal' data-target="#modal-rooms">
                    部屋情報をアップロードする
                </button>
            </div>
            <!-- モーダルの配置 -->
            <div class="modal" id="modal-buildings" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class='modal-title' id='modal-label'>物件情報のアップロード</h4>
                        </div>
                        {!! Form::open(['route'=>'import.buildings','enctype'=>'multipart/form-data']) !!}
                        <div class="modal-body">
                                {!! Form::file('csv') !!}
                        </div>
                        <div class="modal-footer">
                            <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>X閉じる</button>
                            {!! Form::submit('アップロード',['class'=>'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- モーダルの配置 -->
        <div class="modal" id="modal-rooms" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class='modal-title' id='modal-label'>部屋情報のアップロード</h4>
                    </div>
                    {!! Form::open(['route'=>'import.rooms','enctype'=>'multipart/form-data']) !!}
                    <div class="modal-body">
                            {!! Form::file('csv') !!}
                    </div>
                    <div class="modal-footer">
                        <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>X閉じる</button>
                        {!! Form::submit('アップロード',['class'=>'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
        @if (session('flash_message'))
            <div class="alert alert-success text-center py-3 my-0 mb-3" role="alert">
                {{ session('flash_message') }}
            </div>
        @endif
    </header>
    @yield('content')


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>