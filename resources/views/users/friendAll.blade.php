@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="column col-md-offset-2 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">友達一覧</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>何月生</th>
                            <th>ニックネーム</th>
                            <th>希望職種</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($friendOne)) <!-- こっちに問題がある。Undefined friendReceived -->
                        @foreach($friendOne as $key => $val)
                            @if(!empty($val['friendReceived']))
                                <?php $friendReceived = $val['friendReceived']; ?>
                            <tr>
                                <td>
                                    @if(!empty($friendReceived['student_at_month']))
                                        {{ $friendReceived->getStudentMonth($friendReceived['student_at_month']) }}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($friendReceived['nickname']))
                                        <a href="{{ route('friends.request', ['id' => $friendReceived['id'] ]) }}">{{ $friendReceived['nickname'] }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($friendReceived['hoping_way']))
                                        {{ $friendReceived->getHopingWay($friendReceived['hoping_way']) }}
                                    @endif
                                </td>
                                <td><a href="{{ route('contacts.contact', ['id' => $friendReceived['id'] ]) }}" class="btn btn-primary">聞いてみる</a></td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                    @if(!empty($friendTwo))
                        @foreach($friendTwo as $key => $val)
                            @if(!empty($val['friendRequested']))
                                <?php $friendRequested = $val['friendRequested']; ?>
                            <tr>
                                <td>
                                    @if(!empty($friendRequested['student_at_month']))
                                        {{ $friendRequested->getStudentMonth($friendRequested['student_at_month']) }}</td>
                                    @endif
                                <td>
                                    @if(!empty($friendRequested['nickname']))
                                        <a href="{{ route('friends.request', ['id' => $friendRequested['id'] ]) }}">{{ $friendRequested['nickname'] }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($friendRequested['hoping_way']))
                                        {{ $friendRequested->getHopingWay($friendRequested['hoping_way']) }}
                                    @endif
                                </td>
                                <td><a href="{{ route('contacts.contact', ['id' => $friendRequested['id'] ]) }}" class="btn btn-primary">聞いてみる</a></td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection