@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="column col-md-offset-2 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading text-center">{{ $partner_user_detail->nickname }}</div>
                <div class="panel-body">
                    @foreach($contact as $con)
                    @if($con['sent_user'] === $partner_user_detail->id)
                    <!-- 左側に相手のメッセージを表示 -->
                    <div class="form-group text-left">
                        <div class="avatar img-left">
                            @if(!empty($partner_user_detail->pic))
                                <img src="data:image/png;base64,{{ $partner_user_detail->pic }}" width="150px" class="img-responsive img-rounded">
                            @else
                                <img src="/images/sample-img.png" class="img-responsive img-rounded">
                            @endif
                        </div>
                        <p class="msg-inrTxt-left">
                            <span class="triangle-left"></span>
                            {{ $con['messages'] }}
                        </p>
                        <div style="font-size:.5em;clear:both;">{{ $con['created_at'] }}</div>
                    </div>
                    @else
                    <!-- 右側にログインユーザーのメッセージを表示 -->
                    <div class="form-group text-right">
                        <div class="avatar img-right">
                            @if(!empty($login_user_detail->pic))
                                <img src="data:image/png;base64,{{ $login_user_detail->pic }}" width="150px" class="img-responsive img-rounded">
                            @else
                                <img src="/images/sample-img.png" class="img-responsive img-rounded">
                            @endif
                        </div>
                        <p class="msg-inrTxt-right">
                        <span class="triangle-right"></span>
                            {{ $con['messages']}}
                        </p>
                        <div style="font-size:.5em;clear:both;">{{ $con['created_at'] }}</div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <!-- 送信用ボタン -->
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-body text-right">
                    <form action="{{ route('contacts.contact', ['friend_id' => $friend_id, 'partner_id' => $partner_user_detail->id]) }}" method="POST">
                        @csrf
                        <input type="text" class="form-control" name="messages" />
                        <button type="submit" class="btn btn-primary">送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection