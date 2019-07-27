@extends('layout')

@section('content')
<div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">確認画面</div>
                    <div class="panel-body">
                        <form action="{{ route('friends.notAuthen', ['id' => $id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <p class="text-center">注意！! 「承認しない」を選択すると、二度友達になれません。</p>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">承認しない</button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection