<div class="header-flex">
            <h1 class='item'><a href="/">大山査定管理システム</a></h1>
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