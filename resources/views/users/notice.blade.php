@extends('layout')

@section('content')
<div class="container">
        <div class="row">
            <div class="col col-md-4">
                <nav class="panel panel-default">
                    <div class="panel-heading">通知一覧</div>
                    <div class="list-group">
                        <a href="/confirm" class="list-group-item {{ $current_page === 1 ? 'active': '' }}">リクエスト中</a>
                        <a href="{{ route('friends.authen') }}" class="list-group-item {{ $current_page === 2 ? 'active': '' }}">あなたの承認待ち</a>
                        <a href="{{ route('friends.message') }}" class="list-group-item {{ $current_page === 3 ? 'active': '' }}">メッセージ</a>
                    </div>
                </nav>
            </div>
            <div class="column col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @switch($current_page)
                            @case(1)
                                リクエスト一覧
                                @break
                            @case(2)
                                あなたの承認待ち
                                @break
                            @case(3)
                                メッセージ一覧
                            @break
                        @endswitch
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>何月生</th>
                                <th>ニックネーム</th>
                                <th>希望職種</th>
                                <th>
                                @switch($current_page)
                                    @case(1)
                                        一言
                                        @break
                                    @case(2)
                                        承認 or 非承認
                                        @break
                                    @case(3)
                                        メッセージ
                                        @break
                                    @endswitch
                                </th>
                            </tr>
                        </thead>
                            <!-- 理解するために分割する -->
                            <!-- リクエスト中 -->
                            @if($current_page === 1)
                                @foreach($friends as $key => $val)
                                    @if(!empty($val['received']))
                                        <?php  $received = $val['received']  ?> <!-- bladeでは、変数定義が出来ないため。Nullの場合どうするか？ -->
                                    @endif
                                    <tbody>
                                    <tr>
                                        <td>@if(!empty($received['student_at_month']))
                                                {{ $received->getStudentMonth($received['student_at_month']) }}
                                            @endif
                                        </td><!-- $val['status']は存在しない。$val['received']のみ -->
                                        <td>
                                            @if(!empty($received['nickname']))
                                                <a href="{{ route('friends.request', ['id' => $received['id'] ]) }}">{{ $received['nickname'] }}</a></td>
                                            @else
                                                <a href="{{ route('friends.request', ['id' => $received['id'] ]) }}">ニックネーム無し</a>
                                            @endif
                                        <td>
                                            @if(!empty($received['hoping_way']))
                                                {{ $received->getHopingWay($received['hoping_way']) }}
                                            @endif
                                        </td>
                                        <td>{{ $received['comments'] }}</td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            @endif
                            <!-- あなたの承認待ち -->
                            @if($current_page === 2)
                                @foreach($friends as $key => $val)
                                    @if(!empty($val['requested']))
                                        <?php  $requested = $val['requested']  ?> <!-- bladeでは、変数定義が出来ないため。Nullの場合どうするか？ -->
                                    @endif
                                    <tbody>
                                    <tr>
                                        <td>
                                            @if(!empty($requested['student_at_month']))
                                                {{ $requested->getStudentMonth($requested['student_at_month']) }}
                                            @endif
                                        </td><!-- $val['status']は存在しない。$val['received']のみ -->
                                        <td>
                                            @if(!empty($requested['nickname']))
                                                <a href="{{ route('friends.request', ['id' => $requested['id'] ]) }}">{{ $requested['nickname'] }}</a></td>
                                            @else
                                                <a href="{{ route('friends.request', ['id' => $requested['id'] ]) }}">ニックネーム無し</a>
                                            @endif
                                        <td>@if(!empty($requested['hoping_way']))
                                                {{ $requested->getHopingWay($requested['hoping_way']) }}
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('friends.authen', ['id' => $requested['id'] ]) }}" method="POST"><!-- 渡されている値が数値じゃなくて、文字列？ POSTで渡される値は文字列になる。-->
                                                @csrf
                                                <button type="submit" class="btn btn-primary">承認する</button>
                                            </form>
                                            <a href="{{ route('friends.notAuthen', ['id' => $requested['id'] ]) }} " class="btn">承認しない</a>
                                            <!-- <form action="{{ route('friends.notAuthen', ['id' => $requested['id'] ]) }}" method="GET"> FORM GETだと、値が空になる。
                                                @csrf
                                                <button type="submit" class="btn">承認しない</button>
                                            </form> -->
                                        </td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            @endif
                            <!-- メッセージ -->
                            @if($current_page === 3)
                            @foreach($friends as $key => $val)
                                    @if(!empty($val['message']))
                                    <?php  $message = $val['message']  ?> <!-- bladeでは、変数定義が出来ないため。Nullの場合どうするか？ -->
                                        @if(!empty($val['partner_detail']))
                                        <?php  $sent_user = $val['partner_detail'] ?>
                                    <tbody>
                                    <tr>
                                        <td>
                                            @if(!empty($sent_user['student_at_month']))
                                                {{ $sent_user->getStudentMonth($sent_user['student_at_month']) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($sent_user['nickname']))
                                                <a href="{{ route('friends.request', ['id' => $sent_user['id'] ]) }}">{{ $sent_user['nickname'] }}</a>
                                            @else
                                                <a href="{{ route('friends.request', ['id' => $sent_user['id'] ]) }}">ニックネーム無し</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($sent_user['hoping_way']))
                                                {{ $sent_user->getHopingWay($sent_user['hoping_way']) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($message['messages']))
                                                <a href="{{ route('contacts.contact', ['id' => $message['sent_user']]) }}"><?php echo mb_strimwidth($message['messages'], 0, 15);  ?>‥</a>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                    @endif
                                    @endif
                                @endforeach
                            @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection