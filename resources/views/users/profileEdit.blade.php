@extends('layout')

@section('content')
<div class="container">
        <div class="row">
            <div class="col col-md-offset-2 col-md-8">
                <nav class="panel panel-default">
                    <div class="panel-heading">プロフィール編集</div>
                    <div class="panel-body">
                        <div class="panel-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <div class="column col-md-6">
                                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="pic">プロフィール画像</label>
                                        <input type="file" class="" name="pic" id="pic" value="{{ old('pic') ?? $user->pic }}" />
                                        <div class="img-padding">
                                        @if(!empty($user->pic))
                                            <img src="data:image/png;base64,{{ $user->pic }}" alt="" width="150px">
                                        @endif
                                        </div>
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">画像をアップロードする</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="column col-md-6">
                                <form action="{{ route('users.update', ['user_id' => Auth::user()->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="student_at_month">何月生（2019年度）</label>
                                    <select name="student_at_month" id="" class="form-control">
                                        <option value="">選択してください</option>
                                         <!-- 編集の画面を参考にする -->
                                         @foreach(\App\User::STUDENT as $key => $val)                                                    <option value="{{ $key }}"                                                {{ $key == old('student_at_month', $user->student_at_month)? 'selected' : '' }}
                                            >
                                            {{ $val['month'] }}
                                            </option>
                                         @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nickname">ニックネーム</label>
                                    <input type="text" class="form-control" name="nickname" id="nickname" value="{{ old('nickname') ?? $user->nickname }}" />
                                </div>
                                <div class="form-group">
                                    <label for="hoping_way">希望進路</label>
                                    <select name="hoping_way" id="" class="form-control">
                                        <option value="">選択してください</option>
                                             <!-- 編集の画面を参考にする -->
                                             @foreach(\App\User::HOPING as $key => $val)
                                                <option value="{{ $key }}"
                                                {{ $key == old('hoping_way', $user->hoping_way)? 'selected' : '' }}
                                                >
                                                {{ $val['way'] }}
                                                </option>
                                             @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comments">一言</label>
                                    <input type="text" class="form-control" name="comments" id="comments" value="{{ old('comments') ?? $user->comments }}" />
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">プロフィールを更新する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
@endsection