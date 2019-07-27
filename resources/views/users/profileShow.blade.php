@extends('layout')

@section('content')
<div class="container">
        <div class="row">
            <div class="col col-md-offset-2 col-md-8">
                <nav class="panel panel-default">
                    <div class="panel-heading">投稿者詳細</div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="column col-md-6">
                                    <div class="form-group profile-pic">
                                        <label for="pic">プロフィール画像</label>
                                        @if(!empty($user_detail->pic))
                                            <img src="data:image/png;base64,{{ $user_detail->pic }}" width="150px" class="img-responsive img-rounded">
                                        @else
                                            <img src="/images/sample-img.png" width="200px" class="img-responsive img-rounded">
                                        @endif
                                    </div>
                                    <a href="{{ route('all') }}">トップページに戻る</a>
                            </div>
                            <div class="column col-md-6">
                                <!-- ステータス（仮）-->
                                <div class="form-group">
                                    @if(empty($status))
                                        <label></label>
                                    @elseif($status === 1)
                                        <label class="{{ \App\Friend::STATUS[1]['class'] }} label-padding">
                                            @if(!empty($your))
                                              {{ $your }}
                                            @endif
                                              {{ \App\Friend::STATUS[1]['label'] }}
                                        </label>
                                    @elseif($status === 2)
                                        <label class="{{ \App\Friend::STATUS[2]['class'] }} label-padding">{{ \App\Friend::STATUS[2]['label'] }}</label>
                                    @elseif($status === 3)
                                        <label class="{{ \App\Friend::STATUS[3]['class'] }} label-padding">{{ \App\Friend::STATUS[3]['label'] }}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="student_at_month">何月生（2019年度）</label>
                                    <!-- やりたいこと12 取り出したデータとアクセサで加工したデータが一致するものを表示する。 -->
                                    @foreach(\App\User::STUDENT as $key => $val)
                                      @if($key === $user_detail->student_at_month)
                                        <p>
                                        {{ $val['month'] }}
                                        </p>
                                        @break
                                      @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="nickname">ニックネーム</label>
                                    <p>{{ $user_detail->nickname }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="hoping_way">希望進路</label>
                                    @foreach(\App\User::HOPING as $key => $val)
                                      @if($key === $user_detail->hoping_way)
                                        <p>{{ $val['way'] }}</p>
                                        @break
                                      @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="comments">一言</label>
                                    <p>{{ $user_detail->comments }}</p>
                                </div>
                                <!-- ステータスに応じたアクションを追加予定。ログインユーザーと表示しているユーザーの場合表示させない-->
                                @if(Auth::user()->id != $user_id) <!-- !==だったら、効かないけど、=を1つ減らしたら出来た？ -->
                                <div class="form-group">
                                    @if(empty($status))
                                      <form action="/friends/{{ $user_id }}/request" method="POST">
                                          @csrf
                                          <button type="submit" class="btn btn-primary">友達リクエストを送る</button>
                                      </form>
                                      <!-- 引数がうまく渡せていない。formタグで、そもそもIdを渡せるのか？渡している引数が少ないか多いか? too few arguments to function '関数名' →Request $requestの指定がなかったため-->
                                    @else
                                        <p></p>
                                    @endif
                                </div>
                                @endif
                            </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
@endsection